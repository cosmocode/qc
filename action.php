<?php
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
if(!defined('DOKU_DATA')) define('DOKU_DATA',DOKU_INC.'data/');

require_once(DOKU_PLUGIN.'action.php');
require_once(DOKU_INC.'inc/search.php');
require_once(DOKU_INC.'inc/io.php');

/**
 * QC Cronjob Action Plugin: Clean up the history once per day
 *
 * @author Dominik Eckelmann <dokuwiki@cosmocode.de>
 */
class action_plugin_qc extends DokuWiki_Action_Plugin {

    /**
     * if true a cleanup process is already running
     * or done in the last 24h
     */
    var $run = false;

    /**
     * File with the queue informations
     */
    var $file;

    /**
     * Constructor - set up some pathes
     */
    function action_plugin_qc() {
        global $conf;
        $this->file = $conf['tmpdir'] . '/qcgather';
    }

    /**
     * Register its handlers with the dokuwiki's event controller
     *
     * we need hook the indexer to trigger the cleanup
     */
    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('INDEXER_TASKS_RUN', 'BEFORE', $this, 'qccron', array());
    }

    /**
     * start the scan
     *
     * Scan for fixmes
     */
    function qccron(&$event, $param) {
        if ($this->run) return;

        global $ID;
        if(!$ID) return;

        $this->run = true;
        echo 'qc data gatherer: started on '.$ID.NL;
        $qc = $this->loadHelper('qc',true);

        $persist = array();
        if (is_file($this->file)) {
            $persist = file_get_contents($this->file);
            $persist = unserialize($persist);
        } else {
            $persist = array();
            echo '2';
        }

        $fixme = $qc->getQCData($ID);

        // when there are no quality problems we won't need the information
        if ($this->isOk($fixme['err'])) {
            unset($persist[$ID]);
        } else {
            $persist[$ID] = $fixme;
        }

        $persist = serialize($persist);
        file_put_contents($this->file, $persist);
    }

    /**
     * checks an array to quality
     *
     * @return true when everything is alright
     */
    function isOk($arr) {
        return count(array_filter((array) $arr)) == 0;
    }
}
