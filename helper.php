<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();
require_once(DOKU_INC.'inc/plugin.php');

class helper_plugin_qc extends DokuWiki_Plugin {

    /**
     * Checks if the qc plugin is active for the specific page
     * @return bool
     */
    function qcIsActive($id, $act = null) {
        if (!function_exists('gd_info')) {
            msg('You have to install php-gd lib to use the QC plugin.');
            return false;
        }

        global $INFO;
        if($act !== 'show' || (isset($INFO) && !$INFO['exists'])) {
            return false;
        }

        if(p_get_metadata($id, 'relation qcplugin_disabled')) {
            return false;
        }

        if ($id === 'wiki:welcome' || $id === 'wiki:syntax' || $id === "wiki:dokuwiki") {
            return false;
        }

        if ($this->getConf('adminonly')) {
            if (!isset($_SERVER['REMOTE_USER']) || !auth_isadmin()) {
                return false;
            }
        }

        return true;
    }

    function tpl(){
        global $ID, $ACT;
        if (!$this->qcIsActive($ID, $ACT)) {
            return false;
        }

        echo '<div id="plugin__qc__wrapper">' .
                 '<img src="'.DOKU_BASE.'lib/plugins/qc/icon.php?id='.$ID.'" width="600" height="25" alt="" id="plugin__qc__icon" />' .
                 '<div id="plugin__qc__out" style="display:none"></div>' .
             '</div>';
    }

    function getQCData($id) {
        require_once DOKU_INC.'inc/parserutils.php';
        $data = unserialize(p_cached_output(wikiFN($id), 'qc', $id));
        return $data;
    }

}
