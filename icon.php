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

$maxerr = 10; //what score to use as total failure
$pct = ($data['score']*100)/$maxerr;

if($_REQUEST['type'] == 'small'){
    $OPTS = array(
        'font'   => dirname(__FILE__).'/vera.ttf',
        'size'   => 8,
        'xpad'   => 3,
        'ypad'   => 0,
        'crad'   => 1,
        'width'  => 50,
        'height' => 14,
    );
    icon_small($pct,$data['score'],$data['fixme']);
}else{
    $OPTS = array(
        'font'   => dirname(__FILE__).'/DejaVuSans-Bold.ttf',
        'size'   => 10,
        'xpad'   => 6,
        'ypad'   => 2,
        'crad'   => 2,
        'width'  => 600,
        'height' => 25,
    );
    icon_large($pct,$data['score'],$data['fixme']);
}


function icon_small($pct,$score,$fixmes){
    global $qc;
    global $OPTS;
    global $maxerr;

    // create a transparent image
    $img   = imagecreatetruecolor($OPTS['width'],$OPTS['height']);
    imageSaveAlpha($img, true);
    imageAlphaBlending($img, true);
    $transparentColor = imagecolorallocatealpha($img, 127, 127, 127, 127);
    imagefill($img, 0, 0, $transparentColor);


    if($score > $maxerr) {
        $c_score = imagecolorallocate($img,255,0,0);   #red
    }elseif($score){
        $c_score = imagecolorallocate($img,255,255,0); #yellow
    }else{
        $c_score = imagecolorallocate($img,0,255,0);   #green
    }
    $c_black  = imagecolorallocate($img,0,0,0);
    $c_yellow = imagecolorallocate($img,255,255,0);

    list($x,$y) = textbox($img,0,1,-1*$score,$c_black,$c_score);
    list($x,$y) = textbox($img,$x+5,1,$fixmes,$c_black,$c_yellow);

    header('Content-Type: image/png');
    imagepng($img);
    imagedestroy($img);
}


function icon_large($pct,$score,$fixmes){
    global $qc;
    global $OPTS;
    global $maxerr;

    // create a transparent image
    $img   = imagecreatetruecolor($OPTS['width'],$OPTS['height']);
    imageSaveAlpha($img, true);
    imageAlphaBlending($img, true);
    $transparentColor = imagecolorallocatealpha($img, 127, 127, 127, 127);
    imagefill($img, 0, 0, $transparentColor);

    list($r,$g,$b) = html2rgb($qc->getConf('color'));
    $c_text  = imagecolorallocate($img,$r,$g,$b);
    $c_black = imagecolorallocate($img,0,0,0);
    $c_red   = imagecolorallocate($img,255,0,0);
    $c_green = imagecolorallocate($img,0,255,0);

    list($x,$y) = textbox($img,0,2,$qc->getLang('i_qcscore'),$c_text);
    $x += 10;

    // status icon
    if($score > $maxerr) {
        $ico = DOKU_INC.'lib/plugins/qc/pix/'.$qc->getConf('theme').'/status_red.png';
    }elseif($score){
        $ico = DOKU_INC.'lib/plugins/qc/pix/'.$qc->getConf('theme').'/status_yellow.png';
    }else{
        $ico = DOKU_INC.'lib/plugins/qc/pix/'.$qc->getConf('theme').'/status_green.png';
    }
    $ico = imagecreatefrompng($ico);
    $w   = imagesx($ico);
    $h   = imagesy($ico);
    imageSaveAlpha($ico, true);
    imagecopy($img,$ico,$x,4,0,0,$w,$h);
    imagedestroy($ico);
    $x += $w;

    // print score if non-zero
    if($score) list($x,$y) = textbox($img,$x,2,'('.$score.')',$c_text);

    if($fixmes){
        $x += 20;
        $ico = DOKU_INC.'lib/plugins/qc/pix/'.$qc->getConf('theme').'/fixme.png';
        $ico = imagecreatefrompng($ico);
        $w   = imagesx($ico);
        $h   = imagesy($ico);
        imageSaveAlpha($ico, true);
        imagecopy($img,$ico,$x,4,0,0,$w,$h);
        imagedestroy($ico);
        $x += $w;

        list($x,$y) = textbox($img,$x,2,'('.$fixmes.')',$c_text);
    }

    header('Content-Type: image/png');
    imagepng($img);
    imagedestroy($img);
}

/**
 * Convert a hex color to it's RGB values
 *
 * @link http://www.anyexample.com/programming/php/php_convert_rgb_from_to_html_hex_color.xml
 */
function html2rgb($color) {
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}

/**
 * Write some text to the image
 *
 * When a background color is given, a rounded box filled with that color
 * is drawn as text background
 */
function textbox(&$img,$x,$y,$text,$col,$bgcol=null){
    global $OPTS;

    $bb = imagettfbbox($OPTS['size'],0,$OPTS['font'],$text);
    $w = $bb[4] - $bb[6];
    $bb = imagettfbbox($OPTS['size'],0,$OPTS['font'],'Ty'); //height for full height letters
    $h = $bb[1] - $bb[7];

    if(!is_null($bgcol)){
        roundrect($img,$x,$y,$x+$w+($OPTS['xpad']*2),$y+$h+($OPTS['ypad']*2),$OPTS['crad'],$bgcol);
        imagefill($img,$x+$OPTS['xpad']+$OPTS['crad'],$y+$OPTS['ypad']+$OPTS['crad'],$bgcol);
    }

    $bb = imagettftext($img,$OPTS['size'],0,$x+$OPTS['xpad'],$y+$h+$OPTS['ypad'],$col,$OPTS['font'],$text);

    return array($x+$w+($OPTS['xpad']*2),$y+$h+($OPTS['ypad']*2));
}

/**
 * Draw a rounded rectangle
 *
 * @link http://www.java2s.com/Code/Php/Graphics-Image/RoundrectangleDemo.htm
 */
function roundrect(&$image, $x1, $y1, $x2, $y2, $curvedepth, $color) {
    imageline($image, ($x1 + $curvedepth), $y1, ($x2 - $curvedepth), $y1, $color);
    imageline($image, ($x1 + $curvedepth), $y2, ($x2 - $curvedepth), $y2, $color);
    imageline($image, $x1, ($y1 + $curvedepth), $x1, ($y2 - $curvedepth), $color);
    imageline($image, $x2, ($y1 + $curvedepth), $x2, ($y2 - $curvedepth), $color);
    imagearc($image, ($x1 + $curvedepth), ($y1 + $curvedepth), (2 * $curvedepth), (2 * $curvedepth), 180, 270, $color);
    imagearc($image, ($x2 - $curvedepth), ($y1 + $curvedepth), (2 * $curvedepth), (2 * $curvedepth), 270, 360, $color);
    imagearc($image, ($x2 - $curvedepth), ($y2 - $curvedepth), (2 * $curvedepth), (2 * $curvedepth), 0, 90, $color);
    imagearc($image, ($x1 + $curvedepth), ($y2 - $curvedepth), (2 * $curvedepth), (2 * $curvedepth), 90, 180, $color);
}
