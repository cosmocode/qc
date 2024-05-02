<?php

use dokuwiki\Extension\AdminPlugin;
use dokuwiki\plugin\qc\Output;

/**
 * This plugin is used to display a summery of all FIXME pages
 *
 * @see http://dokuwiki.org/plugin:qc
 * @author Dominik Eckelmann <dokuwiki@cosmocode.de>
 */
class admin_plugin_qc extends AdminPlugin
{
    protected $data;
    protected $order;

    /** @inheritdoc */
    public function forAdminOnly()
    {
        return false;
    }

    /** @inheritDoc */
    public function getMenuIcon()
    {
        return __DIR__ . '/svg/good.svg';
    }

    /** @inheritdoc */
    public function handle()
    {
        global $conf;

        // load the quality data
        if (is_file($conf['tmpdir'] . '/qcgather')) {
            $this->data = file_get_contents($conf['tmpdir'] . '/qcgather');
            $this->data = unserialize($this->data);
        } else {
            $this->data = [];
        }

        // order the data
        if (!isset($_REQUEST['pluginqc']['order'])) {
            $_REQUEST['pluginqc']['order'] = 'quality';
        }

        switch ($_REQUEST['pluginqc']['order']) {
            case 'fixme':
                uasort($this->data, [$this, 'sortFixme']);
                $this->order = 'fixme';
                break;
            default:
                uasort($this->data, [$this, 'sortQuality']);
                $this->order = 'quality';
        }
    }

    /** @inheritdoc */
    public function html()
    {
        global $ID;
        $max = $this->getConf('maxshowen');
        if (!$max || $max <= 0) $max = 25;

        echo '<div id="plugin__qc_admin">';
        echo '<h1>' . $this->getLang('admin_headline') . '</h1>';

        echo '<p>' . sprintf($this->getLang('admin_desc'), $max) . '</p>';

        echo '<table class="inline">';
        echo '  <tr>';
        echo '    <th>' . $this->getLang('admin_page') . '</th>';
        echo '    <th class="quality">' . $this->getOrderArrow('quality') .
            '<a href="' . wl($ID, ['do' => 'admin', 'page' => 'qc', 'pluginqc[order]' => 'quality']) . '">' .
            $this->getLang('admin_quality') . '</a></th>';
        echo '    <th class="fixme">' . $this->getOrderArrow('fixme') .
            '<a href="' . wl($ID, ['do' => 'admin', 'page' => 'qc', 'pluginqc[order]' => 'fixme']) . '">' .
            $this->getLang('admin_fixme') . '</a></th>';
        echo '  </tr>';
        
        $skip = $this->getConf('skip_sidebar');
        
        if ($this->data) {
            foreach ($this->data as $id => $data) {
                if ($max == 0) break;
                if ($skip && str_ends_with($id, 'sidebar')) {
                    continue;  // skips 'sidebar' special pages
                }
                echo '  <tr>';
                echo '    <td>';
                tpl_pagelink(':' . $id, $id);
                echo '</td>';
                echo '    <td class="centeralign">' . Output::scoreIcon($data['score']) . '</td>';
                echo '    <td class="centeralign">' . $data['err']['fixme'] . '</td>';
                echo '  </tr>';
                $max--;
            }
        }

        echo '</table>';
        echo '</div>';
    }

    /**
     * return an arrow if currently sorted by this type
     *
     * @ return string
     */
    protected function getOrderArrow($type)
    {
        if ($type == $this->order) return '&darr; ';
        return '';
    }

    /**
     * order by quality
     */
    protected function sortQuality($a, $b)
    {
        return $b['score'] <=> $a['score'];
    }

    /**
     * order by fixmes
     */
    protected function sortFixme($a, $b)
    {
        return $b['err']['fixme'] <=> $a['err']['fixme'];
    }
}
