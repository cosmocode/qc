<?php

/**
 * QC Cronjob Action Plugin: Clean up the history once per day
 *
 * @author Dominik Eckelmann <dokuwiki@cosmocode.de>
 */
class action_plugin_qc_cron extends DokuWiki_Action_Plugin
{

    /**
     * if true a cleanup process is already running
     * or done in the last 24h
     */
    protected $run = false;

    /**
     * File with the queue informations
     */
    protected $file;

    /**
     * Constructor - set up some pathes
     */
    public function __construct()
    {
        global $conf;
        $this->file = $conf['tmpdir'] . '/qcgather';
    }

    /**
     * Register its handlers with the dokuwiki's event controller
     *
     * we need hook the indexer to trigger the cleanup
     */
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('INDEXER_TASKS_RUN', 'BEFORE', $this, 'qccron', array());
    }

    /**
     * start the scan
     *
     * Scan for fixmes
     */
    public function qccron(Doku_Event $event, $param)
    {
        if ($this->run) return;

        global $ID;
        if (!$ID) return;

        $this->run = true;
        echo 'qc data gatherer: started on ' . $ID . NL;
        /** @var helper_plugin_qc $qc */
        $qc = $this->loadHelper('qc');

        $persist = [];
        if (is_file($this->file)) {
            $persist = file_get_contents($this->file);
            $persist = unserialize($persist);
        } else {
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
    protected function isOk($arr)
    {
        return count(array_filter((array)$arr)) == 0;
    }
}
