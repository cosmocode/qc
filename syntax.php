<?php

/**
 * DokuWiki Plugin qc (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <gohr@cosmocode.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

require_once(DOKU_PLUGIN . 'syntax.php');

class syntax_plugin_qc extends DokuWiki_Syntax_Plugin
{

    public function getType()
    {
        return 'substition';
    }

    public function getPType()
    {
        return 'normal';
    }

    public function getSort()
    {
        return 150;
    }


    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern('~~NOQC~~', $mode, 'plugin_qc');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        $data = array();

        return $data;
    }

    public function render($mode, Doku_Renderer $R, $data)
    {
        if ($mode != 'metadata') return false;

        $R->meta['relation']['qcplugin_disabled'] = true;
        return true;
    }
}

// vim:ts=4:sw=4:et:enc=utf-8:
