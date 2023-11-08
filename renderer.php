<?php
// phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

use dokuwiki\ChangeLog\PageChangeLog;
use dokuwiki\File\PageResolver;
use dokuwiki\Utf8\PhpString;

/**
 * The Renderer
 */
class renderer_plugin_qc extends Doku_Renderer
{
    /**
     * We store all our data in an array
     */
    public $docArray = [
        // raw statistics
        'header_count' => [0, 0, 0, 0, 0, 0],
        'header_struct' => [],
        'linebreak' => 0,
        'quote_nest' => 0,
        'quote_count' => 0,
        'fixme' => 0,
        'hr' => 0,
        'formatted' => 0,
        'created' => 0,
        'modified' => 0,
        'changes' => 0,
        'authors' => [],
        'internal_links' => 0,
        'broken_links' => 0,
        'external_links' => 0,
        'link_lengths' => [],
        'chars' => 0,
        'words' => 0,
        'score' => 0,
        // calculated error scores
        'err' => [
            'fixme' => 0,
            'noh1' => 0,
            'manyh1' => 0,
            'headernest' => 0,
            'manyhr' => 0,
            'manybr' => 0,
            'longformat' => 0,
            'multiformat' => 0
        ],
    ];

    protected $quotelevel = 0;
    protected $formatting = 0;
    protected $tableopen = false;

    /** @inheritdoc */
    public function document_start()
    {
        global $ID;
        $meta = p_get_metadata($ID);

        // get some dates from meta data
        $this->docArray['created'] = $meta['date']['created'];
        $this->docArray['modified'] = $meta['date']['modified'];
        $this->docArray['authors']['*'] = 0;

        // get author info
        $changelog = new PageChangeLog($ID);
        $revs = $changelog->getRevisions(0, 10000); //FIXME find a good solution for 'get ALL revisions'
        $revs[] = $meta['last_change']['date'];
        $this->docArray['changes'] = count($revs);
        foreach ($revs as $rev) {
            $info = $changelog->getRevisionInfo($rev);
            if ($info && !empty($info['user'])) {
                $authorUserCnt = empty($this->docArray['authors'][$info['user']])
                    ? 0
                    : $this->docArray['authors'][$info['user']];
                $this->docArray['authors'][$info['user']] = $authorUserCnt + 1;
            } else {
                ++$this->docArray['authors']['*'];
            }
        }

        // work on raw text
        $text = rawWiki($ID);
        $this->docArray['chars'] = PhpString::strlen($text);
        $this->docArray['words'] = count(array_filter(preg_split('/[^\w\-_]/u', $text)));
    }


    /**
     * Here the score is calculated
     * @inheritdoc
     */
    public function document_end()
    {
        global $ID;

        // 2 points for missing backlinks
        if (ft_backlinks($ID) === []) {
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
                ++$this->docArray['err']['headernest'];
            }
        }

        // 1/2 points for deeply nested quotations
        if ($this->docArray['quote_nest'] > 2) {
            $this->docArray['err']['deepquote'] = $this->docArray['quote_nest'] / 2;
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
        foreach ($this->docArray['err'] as $val) $this->docArray['score'] += $val;


        //we're done here
        $this->doc = serialize($this->docArray);
    }

    /** @inheritdoc */
    public function getFormat()
    {
        return 'qc';
    }

    /** @inheritdoc */
    public function internallink($id, $name = null, $search = null, $returnonly = false, $linktype = 'content')
    {
        global $ID;

        $resolver = new PageResolver($ID);
        $id = $resolver->resolveId($id);
        $exists = page_exists($id);

        // calculate link width
        $a = explode(':', getNS($ID));
        $b = explode(':', getNS($id));
        while (isset($a[0]) && $a[0] === $b[0]) {
            array_shift($a);
            array_shift($b);
        }
        $length = count($a) + count($b);
        $this->docArray['link_lengths'][] = $length;

        $this->docArray['internal_links']++;
        if (!$exists) $this->docArray['broken_links']++;
    }

    /** @inheritdoc */
    public function externallink($url, $name = null)
    {
        $this->docArray['external_links']++;
    }

    /** @inheritdoc */
    public function header($text, $level, $pos)
    {
        $this->docArray['header_count'][$level]++;
        $this->docArray['header_struct'][] = $level;
    }

    /** @inheritdoc */
    public function smiley($smiley)
    {
        if ($smiley == 'FIXME') $this->docArray['fixme']++;
    }

    /** @inheritdoc */
    public function linebreak()
    {
        if (!$this->tableopen) {
            $this->docArray['linebreak']++;
        }
    }

    /** @inheritdoc */
    public function table_open($maxcols = null, $numrows = null, $pos = null)
    {
        $this->tableopen = true;
    }

    /** @inheritdoc */
    public function table_close($pos = null)
    {
        $this->tableopen = false;
    }

    /** @inheritdoc */
    public function hr()
    {
        $this->docArray['hr']++;
    }

    /** @inheritdoc */
    public function quote_open()
    {
        $this->docArray['quote_count']++;
        $this->quotelevel++;
        $this->docArray['quote_nest'] = max($this->quotelevel, $this->docArray['quote_nest']);
    }

    /** @inheritdoc */
    public function quote_close()
    {
        $this->quotelevel--;
    }

    /** @inheritdoc */
    public function strong_open()
    {
        $this->formatting++;
    }

    /** @inheritdoc */
    public function strong_close()
    {
        $this->formatting--;
    }

    /** @inheritdoc */
    public function emphasis_open()
    {
        $this->formatting++;
    }

    /** @inheritdoc */
    public function emphasis_close()
    {
        $this->formatting--;
    }

    /** @inheritdoc */
    public function underline_open()
    {
        $this->formatting++;
    }

    /** @inheritdoc */
    public function underline_close()
    {
        $this->formatting--;
    }

    /** @inheritdoc */
    public function cdata($text)
    {
        if (!$this->formatting) return;

        $len = PhpString::strlen($text);

        // 1 point for formattings longer than 500 chars
        if ($len > 500) $this->docArray['err']['longformat']++;

        // 1 point for each multiformatting
        if ($this->formatting > 1) $this->docArray['err']['multiformat'] += 1 * ($this->formatting - 1);

        $this->docArray['formatted'] += $len;
    }
}
