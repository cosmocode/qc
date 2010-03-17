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
     * Constructor - get some config details and check if a check runs in the last 24h
     */
    function action_plugin_qc() {
        global $conf;

        // check if a runfile exists - if not -> there is no last run
        if (!is_file($conf['cachedir'].'/qclastgather')) return;

        // check last run
        $get = fileatime($conf['cachedir'].'/qclastgather');
        $get = intval($get);
        if ($get+(60*60*24) > time()) $this->run = true;
    }

    /**
     * Register its handlers with the dokuwiki's event controller
     *
     * we need hook the indexer to trigger the cleanup
     */
    function register(&$controller) {
        $controller->register_hook('INDEXER_TASKS_RUN', 'BEFORE', $this, 'qccron', array());
    }

    /**
     * start the scan
     *
     * Scan for fixmes
     */
    function qccron(&$event, $param) {
        if ($this->run) return;
        $this->run = true;
        echo 'qc data gatherer: started'.NL;

        global $conf;
        $qc      = $this->loadHelper('qc',true);
        $persist = array();

        // do the search
        search($resultset, $conf['datadir'], 'search_allpages', array('skipacl' => true));

        foreach ($resultset as $result) {
            $fixme = $qc->getQCData($result['id']);

            // when there are no quality problems we won't need the information
            if ($this->isOk($fixme['err'])) continue;

            $persist[$result['id']] = $fixme;
        }

        $persist = serialize($persist);

        io_saveFile($conf['tmpdir'].'/qcgather', $persist);

        touch($conf['cachedir'].'/qclastgather');
    }

    /**
     * checks an array to quality
     *
     * @return true when everything is alright
     */
    function isOk($arr) {
        foreach ($arr as $key => $val) {
            if ($val != 0) return false;
        }
        return true;
    }

    function hashToConf($data, $file) {
        $str = "";
        foreach ($data as $k => $v) {
            $str .= sprintf("%-30s %s\n",$k,$v);
        }
        io_saveFile($file, $str);
    }

}

?>
