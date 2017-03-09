<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class helper_plugin_qc extends DokuWiki_Plugin {

    /**
     * Output the standard quality header. Needs to be called formt he template
     */
    function tpl() {
        global $ACT, $INFO, $ID;
        if($ACT != 'show' || !$INFO['exists']) return;
        if(p_get_metadata($ID, 'relation qcplugin_disabled')) return;
        if($this->getConf('adminonly')) {
            if(!isset($_SERVER['REMOTE_USER']) || !auth_isadmin())
                return;
        }

        echo '<div id="plugin__qc__wrapper">';
        echo '<div class="summary">';
        echo $this->getLang('i_qcscore');
        echo '</div>';
        echo '<div class="output"></div>';
        echo '</div>';
    }

    /**
     * Return the raw quality data
     *
     * Always call this asynchronly!
     *
     * @param $theid
     * @return array
     */
    function getQCData($theid) {
        global $ID;
        $oldid = $ID;
        $ID = $theid;
        $data = unserialize(p_cached_output(wikiFN($ID), 'qc', $ID));
        $ID = $oldid;
        return $data;
    }
}
