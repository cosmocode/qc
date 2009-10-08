<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

// we inherit from the XHTML renderer instead directly of the base renderer
require_once DOKU_INC.'inc/parser/renderer.php';

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

        'created'       => 0,
        'modified'      => 0,
        'changes'       => 0,
        'authors'       => array(),

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
        ),
    );

    var $quotelevel = 0;

    function document_start() {
        global $ID;
        $meta = p_get_metadata($ID);

        // get some dates from meta data
        $this->doc['created']  = $meta['date']['created'];
        $this->doc['modified'] = $meta['date']['modified'];

        // get author info
        $revs = getRevisions($ID,0,0);
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
        $this->doc['words'] = count(preg_split('/[^\w\-_]/u',$text));
    }


    /**
     * Here the score is calculated
     */
    function document_end() {

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
        if(count($this->doc['authors']) == 1){
            $this->doc['err']['singleauthor'] = 1;
        }

        // add up all scores
        foreach($this->doc['err'] as $err => $val) $this->doc['score'] += $val;


        //we're done here
        $this->doc = serialize($this->doc);
    }

    /**
     * return some info
     */
    function getInfo(){
        return confToHash(dirname(__FILE__).'/info.txt');
    }

    /**
     * the format we produce
     */
    function getFormat(){
        return 'qc';
    }


    function header($text, $level, $pos){
        $this->doc['header_count'][$level]++;
        $this->doc['header_struct'][] = $level;
    }

    function smiley($smiley) {
        if($smiley == 'FIXME') $this->doc['fixme']++;
    }

    function linebreak() {
        $this->doc['linebreak']++;
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


}

//Setup VIM: ex: et ts=4 enc=utf-8 :
