<?php
/******************************************
info:SEBUG Security Database
Function:公共函数
Author:amxku
date:2008/10/16
site:http://www.sebug.net
========CHANGELOG========
******************************************/
@header("content-Type: text/html; charset=UTF-8");

error_reporting(7);
@set_magic_quotes_runtime(0);
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];

define('SEBUG_ROOT', substr(dirname(__FILE__), 0, -7));

// 加载数据库
require(SEBUG_ROOT.'include/config.php');

// 允许程序在 register_globals = off 的环境下工作
if ( function_exists('ini_get') ) {
	$onoff = ini_get('register_globals');
} else {
	$onoff = get_cfg_var('register_globals');
}
if ($onoff != 1) {
	@extract($_POST, EXTR_SKIP);
	@extract($_GET, EXTR_SKIP);
	@extract($_COOKIE, EXTR_SKIP);
}

// 检查gzip加速支持情况
if (extension_loaded('zlib')) {
	@ob_start('ob_gzhandler');
} else {
	ob_start();
}

// 加载数据库类
require(SEBUG_ROOT.'include/class/mysql.class.php');

// 初始化数据库类
$DB = new DB_MySQL;
$DB->connect($servername, $dbusername, $dbpassword, $dbname, $usepconnect);
unset($servername, $dbusername, $dbpassword, $dbname, $usepconnect);

// 防止 PHP 5.1.x 使用时间函数报错
if(PHP_VERSION > '5.1') {
	@date_default_timezone_set('PRC');
}
// 系统时间
$ontime = $_SERVER['REQUEST_TIME'];
$timestamp = $_SERVER['REQUEST_TIME'];

// 系统URL
if (!$url) {
	//HTTP_HOST已经包含端口信息,不必加SERVER_PORT了.
	$url = 'http://'.$_SERVER['HTTP_HOST'].substr($php_self,0,strrpos($php_self,'/')).'/';
} else {
	$url = str_replace(array('{host}','index.php'), array($_SERVER['HTTP_HOST'],''), $url);
	if (substr($url, -1) != '/') {
		$url = $url.'/';
	}
}

// 调试函数
function pr($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
?>