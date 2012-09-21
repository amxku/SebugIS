<?PHP
/******************************************
Info:SEBUG Security Database
Function:生成验证码
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
require_once '../include/common.inc.php';

$refererhost = parse_url($_SERVER['HTTP_REFERER']);
$refererhost['host'] .= !empty($refererhost['port']) ? (':'.$refererhost['port']) : '';
if($refererhost['host'] != $_SERVER['HTTP_HOST']) {
	exit('Access Denied');
}

// 验证码生成
session_start();
session_register('seccode');
$_SESSION['seccode'] = '';

$width            = "60";//图片宽
$height           = "22";//图片高
$len              = "6";//生成几位验证码
$bgcolor          = "#F3F3F3";//背景色
$noise            = true;//生成杂点
$noisenum         = 0;//杂点数量
$border           = true;//边框
$bordercolor      = "#F3F3F3";
$image            = imageCreate($width, $height);
$back             = getcolor($bgcolor);

imageFilledRectangle($image, 0, 0, $width, $height, $back);
$size = $width / $len;
if ($size > $height) {
	$size=$height;
}
$left = ($width - $len * ($size + $size / 10)) / $size;

$textall = array_merge_recursive(range('0','9'));
for ($i=0; $i<$len; $i++) {
    $tmptext=rand(0, 9);
	$randtext = $textall[$tmptext];
    $seccode .= $randtext;
}

$textColor = imageColorAllocate($image, 0, 0, 0);
imagestring($image, $size, 3, 3, $seccode, $textColor); 

if($noise) {
	setnoise();
}

$_SESSION['seccode'] = $seccode;

$bordercolor = getcolor($bordercolor); 
if($border) {
	imageRectangle($image, 0, 0, $width-1, $height-1, $bordercolor);
}

header("Content-type: image/png");
imagePng($image);
imagedestroy($image);

function getcolor($color) {
	global $image;
	$color = eregi_replace ("^#","",$color);
	$r = $color[0].$color[1];
	$r = hexdec ($r);
	$b = $color[2].$color[3];
	$b = hexdec ($b);
	$g = $color[4].$color[5];
	$g = hexdec ($g);
	$color = imagecolorallocate ($image, $r, $b, $g); 
	return $color;
}

function setnoise() {
	global $image, $width, $height, $back, $noisenum;
	for ($i=0; $i<$noisenum; $i++){
		$randColor = imageColorAllocate($image, rand(0, 255), rand(0, 255), rand(0, 255));  
		imageSetPixel($image, rand(0, $width), rand(0, $height), $randColor);
	} 
}
?>