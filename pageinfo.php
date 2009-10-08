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

echo '<div>';
echo '<dl>';
echo '<dt>'.$qc->getLang('g_created').'</dt>';
echo '<dd>'.dformat($data['created']).'</dd>';

echo '<dt>'.$qc->getLang('g_modified').'</dt>';
echo '<dd>'.dformat($data['modified']).'</dd>';

echo '<dt>'.$qc->getLang('g_changes').'</dt>';
echo '<dd>'.$data['changes'].'</dd>';

// print top 5 authors
arsort($data['authors']);
$top5 = array_slice($data['authors'],0,5);
$cnt = count($top5);
$i=1;
echo '<dt>'.$qc->getLang('g_authors').'</dt>';
echo '<dd>';
foreach($top5 as $a => $e){
    if($a == '*'){
        echo 'Anonymous';
    }else{
        echo editorinfo($a);
    }
    echo ' ('.$e.')';
    if($i++ < $cnt) echo ', ';
}
echo '</dd>';

echo '<dt>'.$qc->getLang('g_chars').'</dt>';
echo '<dd>'.$data['chars'].'</dd>';

echo '<dt>'.$qc->getLang('g_words').'</dt>';
echo '<dd>'.$data['words'].'</dd>';

echo '</dl>';
echo '</div>';


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

