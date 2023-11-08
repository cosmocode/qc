<?php

use dokuwiki\Extension\SyntaxPlugin;

/**
 * DokuWiki Plugin qc (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <gohr@cosmocode.de>
 */
class syntax_plugin_qc extends SyntaxPlugin
{
    /** @inheritdoc */
    public function getType()
    {
        return 'substition';
    }

    /** @inheritdoc */
    public function getPType()
    {
        return 'normal';
    }

    /** @inheritdoc */
    public function getSort()
    {
        return 150;
    }

    /** @inheritdoc */
    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern('~~NOQC~~', $mode, 'plugin_qc');
    }

    /** @inheritdoc */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        return [];
    }

    /** @inheritdoc */
    public function render($mode, Doku_Renderer $R, $data)
    {
        if ($mode != 'metadata') return false;

        $R->meta['relation']['qcplugin_disabled'] = true;
        return true;
    }
}
