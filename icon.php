<?php
if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/../../../');
define('DOKU_DISABLE_GZIP_OUTPUT', 1);
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');
require_once(DOKU_INC.'inc/template.php');
session_write_close();

$ID   = cleanID($_REQUEST['id']);
$qc = plugin_load('helper','qc');
$data = $qc->getQCData($ID);

$score = 0;
foreach($data['err'] as $err => $val) $score += $val;

$maxerr = 10; //what score to use as total failure
$pct = ($score*100)/$maxerr;

// use gradient class to calculate color between red and green
require_once(dirname(__FILE__).'/ColorGradient.class.php');
$hgrad = new ColorGradient(array(0 => 'FF0000', 100 => '00FF00'), 0.0, 1.0, 'hsv');
$img   = imagecreatetruecolor(60,25);
$bgcol = $hgrad->getColorGD($pct/100,$img);
imagefill($img,0,0,$bgcol);
$txcol = imagecolorallocate($img,0,0,0);
imagestring($img,5,5,5,-1*$score,$txcol);

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
