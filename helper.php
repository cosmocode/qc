<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();
require_once(DOKU_INC.'inc/plugin.php');

class helper_plugin_qc extends DokuWiki_Plugin {

    protected $MAX_ERROR = 10; // if more errors, display a red smiley

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

        $qcData = $this->getQCData($ID);
        $qc_html = "<a href='' id='plugin__qc__closed' title='" . $ID . "'>";

        $qc_html .= $this->getLang('i_qcscore');
        $smiley = "";
        $showNumErrors = false;
        switch (true) {
            case ($qcData['score'] >= $this->MAX_ERROR):
                $smiley = "red";
                $showNumErrors = true;
                break;
            case ($qcData['score'] > 0):
                $smiley = "yellow";
                $showNumErrors = true;
                break;
            default:
                $smiley = "green";
        }
        $qc_html .= "<img id='qc_smiley' src='" . DOKU_BASE . "lib/plugins/qc/pix/" . $this->getConf('theme') . "/status_" . $smiley . ".png' alt=''>";
        if ($showNumErrors) {
            $qc_html .= "<span id='qc_num_errors'>(" . $qcData['score'] . ")</span>";
        }

        if($qcData['fixme'] > 0){
            $qc_html .= "<img id='qc_fixme' src='" . DOKU_BASE . "lib/plugins/qc/pix/" . $this->getConf('theme') . "/fixme.png' alt=''>";
        }

        $qc_html .= "</a>";

        echo '<div id="plugin__qc__wrapper">' . $qc_html . '</div>';
    }

    function getQCData($id) {
        require_once DOKU_INC.'inc/parserutils.php';
        $data = unserialize(p_cached_output(wikiFN($id), 'qc', $id));
        return $data;
    }

}
