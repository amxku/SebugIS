<?php
/******************************************
Info:SEBUG Security Database
Function:全局函数
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
//转换字符
function char_cv($string) {
	$string = htmlspecialchars(addslashes($string));
	return $string;
}

//截取字数
function trimmed_title($text, $limit=12, $start=0) {
	if ($limit) {
		$val = csubstr($text, $start, $limit);
		return $val[1] ? $val[0].'...' : $val[0];
	} else {
		return $text;
	}
}

function csubstr($text, $start=0, $limit=12) {
	if (function_exists('mb_substr')) {
		$more = (mb_strlen($text,'UTF-8') > $limit) ? true : false;
		$text = mb_substr($text, $start, $limit, 'UTF-8');
		return array($text, $more);
	} elseif (function_exists('iconv_substr')) {
		$more = (iconv_strlen($text) > $limit) ? true : false;
		$text = iconv_substr($text, $start, $limit, 'UTF-8');
		return array($text, $more);
	} else {
		preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);   
		if(func_num_args() >= 3) {   
			if (count($ar[0])>$limit) {
				$more = true;
				$text = join('',array_slice($ar[0], $start, $limit)); 
			} else {
				$more = false;
				$text = join('',array_slice($ar[0], $start, $limit)); 
			}
		} else {
			$more = false;
			$text =  join('',array_slice($ar[0], $start)); 
		}
		return array($text, $more);
	} 
}

//读取文件内容
function loadfile($filename, $filesize = 0, $method='rb', $local = 1) {
	$filedata = false;
	if (strpos($filename, '..') !== false) {
		 exit('Load file failed');
	}
	if(function_exists('file_get_contents')) {
		$filedata = @file_get_contents($filename);
	} elseif($local && $fp = @fopen($filename, $method)) {
		flock($fp,LOCK_SH);
		$size = $filesize ? $filesize : filesize($filename);
		$filedata = @fread($fp, $size);
		fclose($fp);
	} elseif(!$local) {
		$filedata = @implode('', file($filename));
	}
	return $filedata;
}

//写入文件内容
function writefile($filename, $data, $method = 'wb', $chmod = 1) {
	$return = false;
	if (strpos($filename, '..') !== false) {
		 exit('Write file failed');
	}
	if($fp = @fopen($filename, $method )) {
		@flock($fp, LOCK_EX);
		$return = fwrite($fp, $data);
		fclose($fp);
		$chmod && @chmod($filename,0777);
	}
	return $return;
}

//页面输出
function PageEnd() {
	$output = ob_get_contents();
	ob_end_clean();
	function_exists('ob_gzhandler') ? @ob_start('ob_gzhandler') : ob_start();
	echo $output;
	exit;
}

// 去除转义字符
function stripslashes_array(&$array) {
	if (is_array($array)) {
		foreach ($array as $k => $v) {
			$array[$k] = stripslashes_array($v);
		}
	} else if (is_string($array)) {
		$array = stripslashes($array);
	}
	return $array;
}

// 防止acunetix 扫描
$http = $_SERVER["ALL_HTTP"];
if(isset($_COOKIE["StopScan"]) && $_COOKIE["StopScan"]){
	die("www.sebug.net");
}
if(strpos(strtolower($http),"acunetix" )){
	setcookie("StopScan",1);
	die("www.sebug.net");
}
?>