<?php

/**
 * The Renderer
 */
class renderer_plugin_qc extends Doku_Renderer
{
    /**
     * We store all our data in an array
     */
    public $docArray = array(
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

        'internal_links' => 0,
        'broken_links'  => 0,
        'external_links' => 0,
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
            'multiformat' => 0,
        ),
    );

    protected $quotelevel = 0;
    protected $formatting = 0;
    protected $tableopen  = false;

    public function document_start() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        global $ID;
        $meta = p_get_metadata($ID);

        // get some dates from meta data
        $this->docArray['created']  = $meta['date']['created'];
        $this->docArray['modified'] = $meta['date']['modified'];

        // get author info
        $changelog = new PageChangelog($ID);
        $revs = $changelog->getRevisions(0, 10000); //FIXME find a good solution for 'get ALL revisions'
        array_push($revs, $meta['last_change']['date']);
        $this->docArray['changes'] = count($revs);
        foreach ($revs as $rev) {
            $info = $changelog->getRevisionInfo($rev);
            if ($info['user']) {
                $this->docArray['authors'][$info['user']] += 1;
            } else {
                $this->docArray['authors']['*'] += 1;
            }
        }

        // work on raw text
        $text = rawWiki($ID);
        $this->docArray['chars'] = utf8_strlen($text);
        $this->docArray['words'] = count(array_filter(preg_split('/[^\w\-_]/u', $text)));
    }


    /**
     * Here the score is calculated
     */
    public function document_end() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        global $ID;

        // 2 points for missing backlinks
        if (!count(ft_backlinks($ID))) {
            $this->docArray['err']['nobacklink'] += 2;
        }

        // 1 point for each FIXME
        $this->docArray['err']['fixme'] += $this->docArray['fixme'];

        // 5 points for missing H1
        if ($this->docArray['header_count'][1] == 0) {
            $this->docArray['err']['noh1'] += 5;
        }
        // 1 point for each H1 too much
        if ($this->docArray['header_count'][1] > 1) {
            $this->docArray['err']['manyh1'] += $this->docArray['header'][1];
        }

        // 1 point for each incorrectly nested headline
        $cnt = count($this->docArray['header_struct']);
        for ($i = 1; $i < $cnt; $i++) {
            if ($this->docArray['header_struct'][$i] - $this->docArray['header_struct'][$i - 1] > 1) {
                $this->docArray['err']['headernest'] += 1;
            }
        }

        // 1/2 points for deeply nested quotations
        if ($this->docArray['quote_nest'] > 2) {
            $this->docArray['err']['deepquote'] += $this->docArray['quote_nest'] / 2;
        }

        // FIXME points for many quotes?

        // 1/2 points for too many hr
        if ($this->docArray['hr'] > 2) {
            $this->docArray['err']['manyhr'] = ($this->docArray['hr'] - 2) / 2;
        }

        // 1 point for too many line breaks
        if ($this->docArray['linebreak'] > 2) {
            $this->docArray['err']['manybr'] = $this->docArray['linebreak'] - 2;
        }

        // 1 point for single author only
        if (!$this->getConf('single_author_only') && count($this->docArray['authors']) == 1) {
            $this->docArray['err']['singleauthor'] = 1;
        }

        // 1 point for too small document
        if ($this->docArray['chars'] < 150) {
            $this->docArray['err']['toosmall'] = 1;
        }

        // 1 point for too large document
        if ($this->docArray['chars'] > 100000) {
            $this->docArray['err']['toolarge'] = 1;
        }

        // header to text ratio
        $hc = $this->docArray['header_count'][1] +
              $this->docArray['header_count'][2] +
              $this->docArray['header_count'][3] +
              $this->docArray['header_count'][4] +
              $this->docArray['header_count'][5];
        $hc--; //we expect at least 1
        if ($hc > 0) {
            $hr = $this->docArray['chars'] / $hc;

            // 1 point for too many headers
            if ($hr < 200) {
                $this->docArray['err']['manyheaders'] = 1;
            }

            // 1 point for too few headers
            if ($hr > 2000) {
                $this->docArray['err']['fewheaders'] = 1;
            }
        }

        // 1 point when no link at all
        if (!$this->docArray['internal_links']) {
            $this->docArray['err']['nolink'] = 1;
        }

        // 0.5 for broken links when too many
        if ($this->docArray['broken_links'] > 2) {
            $this->docArray['err']['brokenlink'] = $this->docArray['broken_links'] * 0.5;
        }

        // 2 points for lot's of formatting
        if ($this->docArray['formatted'] && $this->docArray['chars'] / $this->docArray['formatted'] < 3) {
            $this->docArray['err']['manyformat'] = 2;
        }

        // add up all scores
        foreach ($this->docArray['err'] as $err => $val) $this->docArray['score'] += $val;


        //we're done here
        $this->doc = serialize($this->docArray);
    }

    /**
     * the format we produce
     */
    public function getFormat()
    {
        return 'qc';
    }

    public function internallink($id, $name = null, $search = null, $returnonly = false, $linktype = 'content')
    {
        global $ID;
        resolve_pageid(getNS($ID), $id, $exists);

        // calculate link width
        $a = explode(':', getNS($ID));
        $b = explode(':', getNS($id));
        while (isset($a[0]) && $a[0] == $b[0]) {
            array_shift($a);
            array_shift($b);
        }
        $length = count($a) + count($b);
        $this->docArray['link_lengths'][] = $length;

        $this->docArray['internal_links']++;
        if (!$exists) $this->docArray['broken_links']++;
    }

    public function externallink($url, $name = null)
    {
        $this->docArray['external_links']++;
    }

    public function header($text, $level, $pos)
    {
        $this->docArray['header_count'][$level]++;
        $this->docArray['header_struct'][] = $level;
    }

    public function smiley($smiley)
    {
        if ($smiley == 'FIXME') $this->docArray['fixme']++;
    }

    public function linebreak()
    {
        if (!$this->tableopen) {
            $this->docArray['linebreak']++;
        }
    }

    public function table_open($maxcols = null, $numrows = null, $pos = null) // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->tableopen = true;
    }

    public function table_close($pos = null) // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->tableopen = false;
    }

    public function hr()
    {
        $this->docArray['hr']++;
    }

    public function quote_open() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->docArray['quote_count']++;
        $this->quotelevel++;
        $this->docArray['quote_nest'] = max($this->quotelevel, $this->docArray['quote_nest']);
    }

    public function quote_close() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->quotelevel--;
    }

    public function strong_open() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->formatting++;
    }

    public function strong_close() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->formatting--;
    }

    public function emphasis_open() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->formatting++;
    }

    public function emphasis_close() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->formatting--;
    }

    public function underline_open() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->formatting++;
    }

    public function underline_close() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        $this->formatting--;
    }

    public function cdata($text)
    {
        if (!$this->formatting) return;

        $len = utf8_strlen($text);

        // 1 point for formattings longer than 500 chars
        if ($len > 500) $this->docArray['err']['longformat']++;

        // 1 point for each multiformatting
        if ($this->formatting > 1) $this->docArray['err']['multiformat'] += 1 * ($this->formatting - 1);

        $this->docArray['formatted'] += $len;
    }
}

//Setup VIM: ex: et ts=4 enc=utf-8 :
