<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class helper_plugin_qc extends DokuWiki_Plugin {

    function getInfo() {
        return confToHash(dirname(__FILE__).'/info.txt');
    }

    function tpl(){
        global $ACT,$INFO,$ID;
        if($ACT != 'show' || !$INFO['exists']) return;

        echo '<img src="'.DOKU_BASE.'lib/plugins/qc/icon.php?id='.$ID.'" width="60" height="25" alt="" id="plugin__qc__icon" />';
        echo '<div id="plugin__qc__out" style="display:none"></div>';
    }



    function getQCData($theid){
        global $ID;
        $oldid = $ID;
        $ID = $theid;
        require_once(DOKU_INC.'inc/parserutils.php');
        $data = unserialize(p_cached_output(wikiFN($ID), 'qc'));
        $ID = $oldid;
        return $data;
    }

}
// vim:ts=4:sw=4:et:enc=utf-8: 
