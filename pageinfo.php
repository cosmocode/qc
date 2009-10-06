<?php
if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/../../../');
define('DOKU_DISABLE_GZIP_OUTPUT', 1);
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');
require_once(DOKU_INC.'inc/template.php');
session_write_close();

// permission check
$ID   = cleanID($_REQUEST['id']);
if(auth_quickaclcheck($ID) < AUTH_READ) die('Not authorized');

// get data
$qc = plugin_load('helper','qc');
$data = $qc->getQCData($ID);

// calculate overall score
$score = 0;
foreach($data['err'] as $err => $val) $score += $val;

// start output
header('Content-Type: text/html; charset=utf-8');

echo '<h1>'.$qc->getLang('intro_h').'</h1>';

echo '<p>FIXME general data goes here</p>';


// output all the problems
if($score){
    echo '<h2>'.$qc->getLang('errorsfound_h').'</h2>';
    echo '<p>'.$qc->getLang('errorsfound').'</p>';
    echo '<div>';
    foreach($data['err'] as $err => $val){
        if($val){
            echo '<h3>'.sprintf($qc->getLang($err.'_h'),$val).'</h3>';
            echo '<p>'.sprintf($qc->getLang($err),$val).'</p>';
        }
    }
    echo '</div>';
}

//dbg($data);

