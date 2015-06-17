<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once DOKU_INC.'inc/parser/renderer.php';
require_once DOKU_INC.'inc/fulltext.php';

/**
 * The Renderer
 */
class renderer_plugin_qc extends Doku_Renderer {
    /**
     * We store all our data in an array
     */
    var $doc = array(
        // raw statistics
        'header_count'  => array(0,0,0,0,0,0),
        'header_struct' => array(),
        'linebreak'     => 0,
        'quote_nest'    => 0,
        'quote_count'   => 0,
        'fixme'         => 0,
        'hr'            => 0,
        'formatted'     => 0,

        'created'       => 0,
        'modified'      => 0,
        'changes'       => 0,
        'authors'       => array(),

        'internal_links'=> 0,
        'broken_links'  => 0,
        'external_links'=> 0,
        'link_lengths'  => array(),

        'chars'         => 0,
        'words'         => 0,

        'score'         => 0,

        // calculated error scores
        'err' => array(
            'fixme'      => 0,
            'noh1'       => 0,
            'manyh1'     => 0,
            'headernest' => 0,
            'manyhr'     => 0,
            'manybr'     => 0,
            'longformat' => 0,
            'multiformat'=> 0,
        ),
    );

    var $quotelevel = 0;
    var $formatting = 0;
    var $tableopen  = false;

    function document_start() {
        global $ID;
        $meta = p_get_metadata($ID);

        // get some dates from meta data
        $this->doc['created']  = $meta['date']['created'];
        $this->doc['modified'] = $meta['date']['modified'];

        // get author info
        $changelog = new PageChangelog($ID);
        $revs = $changelog->getRevisions(0,10000); //FIXME find a good solution for 'get ALL revisions'
        array_push($revs,$meta['last_change']['date']);
        $this->doc['changes'] = count($revs);
        foreach($revs as $rev){
            $info = getRevisionInfo($ID, $rev);
            if($info['user']){
                $this->doc['authors'][$info['user']] += 1;
            }else{
                $this->doc['authors']['*'] += 1;
            }
        }

        // work on raw text
        $text = rawWiki($ID);
        $this->doc['chars'] = utf8_strlen($text);
        $this->doc['words'] = count(array_filter(preg_split('/[^\w\-_]/u',$text)));
    }


    /**
     * Here the score is calculated
     */
    function document_end() {
        global $ID;

        // 2 points for missing backlinks
        if(!count(ft_backlinks($ID))){
            $this->doc['err']['nobacklink'] += 2;
        }

        // 1 point for each FIXME
        $this->doc['err']['fixme'] += $this->doc['fixme'];

        // 5 points for missing H1
        if($this->doc['header_count'][1] == 0){
            $this->doc['err']['noh1'] += 5;
        }
        // 1 point for each H1 too much
        if($this->doc['header_count'][1] > 1){
            $this->doc['err']['manyh1'] += $this->doc['header'][1];
        }

        // 1 point for each incorrectly nested headline
        $cnt = count($this->doc['header_struct']);
        for($i = 1; $i < $cnt; $i++){
            if($this->doc['header_struct'][$i] - $this->doc['header_struct'][$i-1] > 1){
                $this->doc['err']['headernest'] += 1;
            }
        }

        // 1/2 points for deeply nested quotations
        if($this->doc['quote_nest'] > 2){
            $this->doc['err']['deepquote'] += $this->doc['quote_nest']/2;
        }

        // FIXME points for many quotes?

        // 1/2 points for too many hr
        if($this->doc['hr'] > 2){
            $this->doc['err']['manyhr'] = ($this->doc['hr'] - 2)/2;
        }

        // 1 point for too many line breaks
        if($this->doc['linebreak'] > 2){
            $this->doc['err']['manybr'] = $this->doc['linebreak'] - 2;
        }

        // 1 point for single author only
        if(!$this->getConf('single_author_only') && count($this->doc['authors']) == 1){
            $this->doc['err']['singleauthor'] = 1;
        }

        // 1 point for too small document
        if($this->doc['chars'] < 150){
            $this->doc['err']['toosmall'] = 1;
        }

        // 1 point for too large document
        if($this->doc['chars'] > 100000){
            $this->doc['err']['toolarge'] = 1;
        }

        // header to text ratio
        $hc = $this->doc['header_count'][1] +
              $this->doc['header_count'][2] +
              $this->doc['header_count'][3] +
              $this->doc['header_count'][4] +
              $this->doc['header_count'][5];
        $hc--; //we expect at least 1
        if($hc > 0){
            $hr = $this->doc['chars']/$hc;

            // 1 point for too many headers
            if($hr < 200){
                $this->doc['err']['manyheaders'] = 1;
            }

            // 1 point for too few headers
            if($hr > 2000){
                $this->doc['err']['fewheaders'] = 1;
            }
        }

        // 1 point when no link at all
        if(!$this->doc['internal_links']){
            $this->doc['err']['nolink'] = 1;
        }

        // 0.5 for broken links when too many
        if($this->doc['broken_links'] > 2){
            $this->doc['err']['brokenlink'] = $this->doc['broken_links']*0.5;
        }

        // 2 points for lot's of formatting
        if($this->doc['formatted'] && $this->doc['chars']/$this->doc['formatted'] < 3){
            $this->doc['err']['manyformat'] = 2;
        }

        // add up all scores
        foreach($this->doc['err'] as $err => $val) $this->doc['score'] += $val;


        //we're done here
        $this->doc = serialize($this->doc);
    }

    /**
     * the format we produce
     */
    function getFormat(){
        return 'qc';
    }

    function internallink($id, $name = NULL, $search=NULL,$returnonly=false,$linktype='content') {
        global $ID;
        resolve_pageid(getNS($ID),$id,$exists);

        // calculate link width
        $a = explode(':',getNS($ID));
        $b = explode(':',getNS($id));
        while(isset($a[0]) && $a[0] == $b[0]){
            array_shift($a);
            array_shift($b);
        }
        $length = count($a)+count($b);
        $this->doc['link_lengths'][] = $length;

        $this->doc['internal_links']++;
        if(!$exists) $this->doc['broken_links']++;
    }

    function externallink($url, $name = NULL) {
        $this->doc['external_links']++;
    }

    function header($text, $level, $pos){
        $this->doc['header_count'][$level]++;
        $this->doc['header_struct'][] = $level;
    }

    function smiley($smiley) {
        if($smiley == 'FIXME') $this->doc['fixme']++;
    }

    function linebreak() {
        if(!$this->tableopen){
            $this->doc['linebreak']++;
        }
    }

    function table_open($maxcols = null, $numrows = null, $pos = null){
        $this->tableopen = true;
    }

    function table_close($pos = null){
        $this->tableopen = false;
    }

    function hr() {
        $this->doc['hr']++;
    }

    function quote_open() {
        $this->doc['quote_count']++;
        $this->quotelevel++;
        $this->doc['quote_nest'] = max($this->quotelevel,$this->doc['quote_nest']);
    }

    function quote_close() {
        $this->quotelevel--;
    }

    function strong_open() {
        $this->formatting++;
    }

    function strong_close() {
        $this->formatting--;
    }

    function emphasis_open() {
        $this->formatting++;
    }

    function emphasis_close() {
        $this->formatting--;
    }

    function underline_open() {
        $this->formatting++;
    }

    function underline_close() {
        $this->formatting--;
    }

    function cdata($text) {
        if(!$this->formatting) return;

        $len = utf8_strlen($text);

        // 1 point for formattings longer than 500 chars
        if($len>500) $this->doc['err']['longformat']++;

        // 1 point for each multiformatting
        if($this->formatting > 1) $this->doc['err']['multiformat'] += 1*($this->formatting - 1);

        $this->doc['formatted'] += $len;
    }
}

//Setup VIM: ex: et ts=4 enc=utf-8 :
