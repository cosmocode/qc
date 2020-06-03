<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */
class helper_plugin_qc extends DokuWiki_Plugin
{

    /**
     * Output the standard quality header. Needs to be called formt he template
     */
    public function tpl()
    {
        if (!$this->shouldShow()) return;

        echo '<div id="plugin__qc__wrapper">';
        echo '<div class="summary">';
        echo $this->getLang('i_qcscore');
        echo '</div>';
        echo '<aside class="qc-output"></aside>';
        echo '</div>';
    }

    /**
     * Should the QC plugin be shown?
     *
     * It checks if the page exists, if QC was disabled for this page, general
     * settings and ACLs
     *
     * This may be called from page context as well as from AJAX. In AJAX context
     * the page id needs to be passed as parameter
     *
     * @param string $id the page ID, defaults to global $ID
     * @return bool
     */
    public function shouldShow($id = '')
    {
        global $ACT, $INFO, $ID;
        if ($id === '') $id = $ID;
        if (isset($ACT) && $ACT != 'show') return false;
        if (isset($INFO)) {
            $exists = $INFO['exists'];
        } else {
            $exists = page_exists($id);
        }
        if (!$exists) return false;

        if (auth_quickaclcheck($id) < AUTH_READ) return false;

        if (p_get_metadata($id, 'relation qcplugin_disabled')) return false;
        if ($this->getConf('adminonly')) {
            if (!isset($_SERVER['REMOTE_USER']) || !auth_isadmin()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return the raw quality data
     *
     * Always call this asynchronly!
     *
     * @param $theid
     * @return array
     */
    public function getQCData($theid)
    {
        global $ID;
        $oldid = $ID;
        $ID = $theid;
        $data = unserialize(p_cached_output(wikiFN($ID), 'qc', $ID));
        $ID = $oldid;
        return $data;
    }
}
