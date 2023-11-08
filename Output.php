<?php

namespace dokuwiki\plugin\qc;

/**
 * Class Output
 *
 * Create the HTML formatted output of the scoring analysis
 *
 * @package dokuwiki\plugin\qc
 */
class Output
{
    public const MAXERR = 10; //what score to use as total failure

    /** @var array the scoring data */
    protected $data;

    /** @var  \helper_plugin_qc */
    protected $helper;

    /**
     * Output constructor.
     * @param string $page the page to analyze
     */
    public function __construct($page)
    {
        $this->helper = plugin_load('helper', 'qc');
        $this->data = $this->helper->getQCData($page);
    }

    /**
     * Get the score as icon
     *
     * @param $score
     * @return string
     */
    public static function scoreIcon($score)
    {
        $html = '';

        // rate the score
        if ($score > self::MAXERR) {
            $rating = 'bad';
        } elseif ($score) {
            $rating = 'meh';
        } else {
            $rating = 'good';
        }

        // output icon and score
        $html .= '<span class="qc_icon qc_' . $rating . '">';
        $html .= inlineSVG(__DIR__ . '/svg/' . $rating . '.svg');
        if ($score) $html .= '<span>' . $score . '</span>';
        $html .= '</span>';

        return $html;
    }

    /**
     * Print the short summary
     *
     * @return string
     */
    public function short()
    {
        return self::scoreIcon($this->data['score']);
    }

    /**
     * Print full analysis
     *
     * @return string
     */
    public function long()
    {
        $html = '';

        $html .= '<h1>' . $this->helper->getLang('intro_h') . '</h1>';

        $html .= '<div>';
        $html .= '<dl>';
        $html .= '<dt>' . $this->helper->getLang('g_created') . '</dt>';
        $html .= '<dd>' . dformat($this->data['created']) . '</dd>';

        $html .= '<dt>' . $this->helper->getLang('g_modified') . '</dt>';
        $html .= '<dd>' . dformat($this->data['modified']) . '</dd>';

        // print top 5 authors
        if (!is_array($this->data['authors'])) $this->data['authors'] = [];
        arsort($this->data['authors']);
        $top5 = array_slice($this->data['authors'], 0, 5);
        $cnt = count($top5);
        $i = 1;
        $html .= '<dt>' . $this->helper->getLang('g_authors') . '</dt>';
        $html .= '<dd>';
        foreach ($top5 as $a => $e) {
            if ($a == '*') {
                $html .= $this->helper->getLang('anonymous');
            } else {
                $html .= editorinfo($a);
            }
            $html .= ' (' . $e . ')';
            if ($i++ < $cnt) $html .= ', ';
        }
        $html .= '</dd>';

        $html .= '<dt>' . $this->helper->getLang('g_changes') . '</dt>';
        $html .= '<dd>' . $this->data['changes'] . '</dd>';

        $html .= '<dt>' . $this->helper->getLang('g_chars') . '</dt>';
        $html .= '<dd>' . $this->data['chars'] . '</dd>';

        $html .= '<dt>' . $this->helper->getLang('g_words') . '</dt>';
        $html .= '<dd>' . $this->data['words'] . '</dd>';

        $html .= '</dl>';
        $html .= '</div>';

        // output all the problems
        if ($this->data['score']) {
            $html .= '<h2>' . $this->helper->getLang('errorsfound_h') . '</h2>';
            $html .= '<p>' . $this->helper->getLang('errorsfound') . '</p>';
            $html .= '<div>';
            arsort($this->data['err']); #sort by score
            foreach ($this->data['err'] as $err => $val) {
                if ($val) {
                    $html .= '<h3>';
                    $html .= sprintf($this->helper->getLang($err . '_h'), $val);
                    $html .= '<span class="qc_icon qc_bad">';
                    $html .= inlineSVG(__DIR__ . '/svg/bad.svg');
                    $html .= '<span>' . $val . '</span>';
                    $html .= '</span>';
                    $html .= '</h3>';
                    $html .= '<p>' . sprintf($this->helper->getLang($err), $val) . '</p>';
                }
            }
            $html .= '</div>';
        }

        return $html;
    }
}
