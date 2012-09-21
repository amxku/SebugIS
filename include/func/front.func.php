<?php
/******************************************
Info:SEBUG Security Database
Function:前台函数
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
require (SEBUG_ROOT.'include/func/global.func.php');
require (SEBUG_ROOT.'include/func/permalink.func.php');
require (SEBUG_ROOT.'include/func/cache.func.php');
require (SEBUG_ROOT.'include/func/fense.func.php');

// 判断 magic_quotes_gpc 状态
if (@get_magic_quotes_gpc()) {
    $_GET = stripslashes_array($_GET);
    $_POST = stripslashes_array($_POST);
    $_COOKIE = stripslashes_array($_COOKIE);
}

//取字符长度
$title_long = '120';

//判断漏洞针对平台
function idtoos($id){
	global $language;
	$temp = '';
	switch($id){
		case 9:
		$temp='Other';
		break;
		case 1:
		$temp='Windows';
		break;
		case 2:
		$temp='Linux';
		break;
		case 3:
		$temp='UNIX';
		break;
		case 4:
		$temp='SunOS';
		break;
		case 5:
		$temp='MacOS';
		break;
		case 6:
		$temp='Web App';
		break;
		case 7:
		$temp='HP-UX';
		break;
		case 8:
		$temp='AIX';
		break;
		case 10:
		$temp = $language['sebug_list_os_1'];
		break;
		case 11:
		$temp='Android';
		break;
		case 12:
		$temp='Symbian';
		break;
		}
	return $temp;
}

//判断类型
function idexp($id){
	global $language;
	$temp = '';
	switch($id){
		case 1:
		$temp = $language['sebug_list_type_1'];
		break;
		case 2:
		$temp = $language['sebug_list_type_2'];
		break;
		case 3:
		$temp = $language['sebug_list_type_3'];
		break;
		case 4:
		$temp = $language['sebug_list_type_4'];
		break;
		case 5:
		$temp = $language['sebug_list_type_5'];
		break;
		case 6:
		$temp = $language['sebug_list_type_6'];
		break;
		case 7:
		$temp = $language['sebug_list_type_7'];
		break;
		case 8:
		$temp = $language['sebug_list_type_8'];
		break;
		case 9:
		$temp = $language['sebug_list_type_9'];
		break;
		case 10:
		$temp = $language['sebug_list_type_10'];
		break;
		case 11:
		$temp = $language['sebug_list_type_11'];
		break;
		case 12:
		$temp = $language['sebug_list_type_12'];
		break;
		case 13:
		$temp = $language['sebug_list_type_13'];
		break;
		case 14:
		$temp = $language['sebug_list_type_14'];
		break;
		case 15:
		$temp = $language['sebug_list_type_15'];
		break;
		case 16:
		$temp = $language['sebug_list_type_16'];
		break;
		case 17:
		$temp = $language['sebug_list_type_17'];
		break;
		}
	return $temp;
}

//判断漏洞危害级别
function idtohackmode($id){
	$temp = '';
	switch($id){
		case 0:
		$temp='★☆☆☆☆☆';
		break;
		case 1:
		$temp='★★★☆☆☆';
		break;
		case 2:
		$temp='★★★★★★';
		break;
		}
	return $temp;
}

//取Emial地址
function check_mail($content) {
	$eeemail = '';
		$content=explode("@",$content);
		$at_qian=trim($content[0]);
		$at_hou=trim($content[1]);
		$eeemail = $at_qian.'_at_'.$at_hou;
	return $eeemail;
}

//载入模板
function template($file) {
	$tplfile = SEBUG_ROOT.'forumdata/templates/default/'.$file.'.php';
	$objfile = SEBUG_ROOT.'forumdata/templates_c/default_'.$file.'.tpl.php';
	if (@filemtime($tplfile) > @filemtime($objfile)) {
		require_once SEBUG_ROOT.'include/class/template.class.php';
		parse_template($tplfile, $objfile);
	}
	return $objfile;
}

// 获取页面调试信息
function footer() {
	include language('templates');
	//global $DB, $starttime, $options;
	//$mtime = explode(' ', microtime());
	//$totaltime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
	//$sebug_debug = 'Processed in '.$totaltime.' second(s), '.$DB->querycount.' queries';
	include template('footer');
	PageEnd();
}

// 获取分页信息
function checkpage($num,$pagenum,$page) {
	$ch_p = '';
	$t_cc = $num/$pagenum;
	$t_p = $t_cc+1;
	$ch_p =$page.'/'.(int)$t_p;
	return $ch_p;
}

// 检查浏览器语言
function language($file) {
	$HTTP_ACCEPT_LANGUAGE = char_cv(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,5));
	if($HTTP_ACCEPT_LANGUAGE == 'zh-cn') { 
		$uselang = 'zh-cn';
	}elseif($HTTP_ACCEPT_LANGUAGE == 'zh-tw' OR $HTTP_ACCEPT_LANGUAGE == 'zh-hk') {
		$uselang = 'zh-tw';
	}else{
		$uselang = 'en';
	}
	!$uselang && $uselang = 'zh-cn';
	$languagepack = SEBUG_ROOT.'forumdata/lang/'.$uselang.'_'.$file.'.jpg';
	if(is_file($languagepack)) {
		return $languagepack;
	} else {
		return false;
	}
}

// 分页函数
function multi($num, $perpage, $curpage, $mpurl) {
	global $permalink,$s1;
	$multipage = '';
	if (substr($mpurl, 0, 7) != 'http://') {
		$mpurl = $url.$mpurl;
	}
	if($num > $perpage) {
		$page = 10;
		$offset = 5;
		$pages = @ceil($num / $perpage);
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $page - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $curpage - $pages + $to;
				$to = $pages;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$from = $pages - $page + 1;
				}
			}
		}
		
		if ($permalink AND $s1 != 's') {
			$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'">&laquo;First</a> ' : '').($curpage > 1 ? '<a href="'.$mpurl.($curpage - 1).'/">&#8249;Prev</a> ' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '['.$i.'] ' : '<a href="'.$mpurl.$i.'/">'.$i.'</a> ';
			}
			$multipage .= ($curpage < $pages ? '<a href="'.$mpurl.($curpage + 1).'/">Next&#8250;</a>' : '').($to < $pages ? ' <a href="'.$mpurl.$pages.'/">Last&raquo;</a>' : '');
			$multipage = $multipage ? ''.$multipage : '';
		}else{
			$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
			$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1">&laquo;First</a> ' : '').($curpage > 1 ? '<a href="'.$mpurl.'page='.($curpage - 1).'">&#8249;Prev</a> ' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '['.$i.'] ' : '<a href="'.$mpurl.'page='.$i.'">'.$i.'</a> ';
			}
			$multipage .= ($curpage < $pages ? '<a href="'.$mpurl.'page='.($curpage + 1).'">Next&#8250;</a>' : '').($to < $pages ? ' <a href="'.$mpurl.'page='.$pages.'">Last&raquo;</a>' : '');
			$multipage = $multipage ? ''.$multipage : '';
		}
	}
	return $multipage;
}

//取中文首字母
function pykey($py_key){
	$pinyin = 65536 + pys($py_key);
	if ( 45217 <= $pinyin && $pinyin <= 45252 ){
		$zimu = "A";
		return $zimu;
	}
	if ( 45253 <= $pinyin && $pinyin <= 45760 ){
		$zimu = "B";
		return $zimu;
	}
	if ( 45761 <= $pinyin && $pinyin <= 46317 ){
		$zimu = "C";
		return $zimu;
	}
	if ( 46318 <= $pinyin && $pinyin <= 46825 ){
		$zimu = "D";
		return $zimu;
	}
	if ( 46826 <= $pinyin && $pinyin <= 47009 ){
		$zimu = "E";
		return $zimu;
	}
	if ( 47010 <= $pinyin && $pinyin <= 47296 ){
		$zimu = "F";
		return $zimu;
	}
	if ( 47297 <= $pinyin && $pinyin <= 47613 ){
		$zimu = "G";
		return $zimu;
	}
	if ( 47614 <= $pinyin && $pinyin <= 48118 ){
		$zimu = "H";
		return $zimu;
	}
	if ( 48119 <= $pinyin && $pinyin <= 49061 ){
		$zimu = "J";
		return $zimu;
	}
	if ( 49062 <= $pinyin && $pinyin <= 49323 ){
		$zimu = "K";
		return $zimu;
	}
	if ( 49324 <= $pinyin && $pinyin <= 49895 ){
		$zimu = "L";
		return $zimu;
	}
	if ( 49896 <= $pinyin && $pinyin <= 50370 ){
		$zimu = "M";
		return $zimu;
	}
	if ( 50371 <= $pinyin && $pinyin <= 50613 ){
		$zimu = "N";
		return $zimu;
	}
	if ( 50614 <= $pinyin && $pinyin <= 50621 ){
		$zimu = "O";
		return $zimu;
	}
	if ( 50622 <= $pinyin && $pinyin <= 50905 ){
		$zimu = "P";
		return $zimu;
	}
	if ( 50906 <= $pinyin && $pinyin <= 51386 ){
		$zimu = "Q";
		return $zimu;
	}
	if ( 51387 <= $pinyin && $pinyin <= 51445 ){
		$zimu = "R";
		return $zimu;
	}
	if ( 51446 <= $pinyin && $pinyin <= 52217 ){
		$zimu = "S";
		return $zimu;
	}
	if ( 52218 <= $pinyin && $pinyin <= 52697 ){
		$zimu = "T";
		return $zimu;
	}
	if ( 52698 <= $pinyin && $pinyin <= 52979 ){
		$zimu = "W";
		return $zimu;
	}
	if ( 52980 <= $pinyin && $pinyin <= 53640 ){
		$zimu = "X";
		return $zimu;
	}
	if ( 53689 <= $pinyin && $pinyin <= 54480 ){
		$zimu = "Y";
		return $zimu;
	}
	if ( 54481 <= $pinyin && $pinyin <= 62289 ){
		$zimu = "Z";
		return $zimu;
	}
	$zimu = $py_key;
	return $zimu;
}
function pys($pysa){
	$pyi = "";
	$i= 0;
	for ( ; $i < strlen( $pysa ); $i++){
		$_obfuscate_8w= ord( substr( $pysa,$i,1) );
		if ( 160 < $_obfuscate_8w){
			$_obfuscate_Bw = ord( substr( $pysa, $i++, 1 ) );
			$_obfuscate_8w = $_obfuscate_8w * 256 + $_obfuscate_Bw - 65536;
		}
		$pyi.= $_obfuscate_8w;
	}
	return $pyi;
}
////////////////////////////////////////////////////////////////////////////
/////////////////////////////用户管理///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
//获取请求来路
function getreferer() {
	global $options;
	if(!$referer && !$_SERVER['HTTP_REFERER']) {
		$referer = $url;
	} elseif (!$referer && $_SERVER['HTTP_REFERER']) {
		$referer = $_SERVER['HTTP_REFERER'];
	} else {
		$referer = htmlspecialchars($referer);
	}
	if(strpos($referer, 'post.php')) {
		$referer = $url;
	}
	return $referer;
}

// 获得散列
function getuserhash($uid, $username, $password, $logincount) {
	global $ontime, $ssd_auth_key;
	return substr(md5(substr($ontime, 0, -7).$username.$uid.$password.$logincount.$ssd_auth_key), 8, 8);
}

$ssd_auth_key = md5($onlineip.$_SERVER['HTTP_USER_AGENT']);
list($ssd_uid, $ssd_pw, $ssd_logincount, $ssd_hash) = $_COOKIE['ssd_auth'] ? explode("\t", authcode($_COOKIE['ssd_auth'], 'DECODE')) : array('', '', '');

$ssd_uid = intval($ssd_uid);
$ssd_pw = addslashes($ssd_pw);
$ssd_logincount = intval($ssd_logincount);
$ssd_hash = addslashes($ssd_hash);

if (!$ssd_uid || !$ssd_pw || !$ssd_hash) {
	$ssd_uid = 0;
} else {
	//CONCAT_WS('.',s.ip1,s.ip2,s.ip3,s.ip4)='$onlineip' AND 
	$user = $DB->fetch_one_array("SELECT s.uid, s.lastactivity, u.username, u.password, u.logincount
		FROM {$db_prefix}users u
		LEFT JOIN {$db_prefix}sessions s ON (s.uid = u.userid)
		WHERE s.hash='$ssd_hash' AND u.userid='$ssd_uid'
		AND u.password='$ssd_pw' AND u.logincount='$ssd_logincount'");
	if ($user) {
		$ssd_user = $user['username'];
		if ($user['lastactivity'] + 300 < $ontime) {
			$DB->query("UPDATE {$db_prefix}sessions SET lastactivity='$ontime' WHERE uid='$ssd_uid' AND hash='$ssd_hash'");
		}
	} else {
		$ssd_uid = 0;
		$ssd_pw = '';
		$DB->query("DELETE FROM {$db_prefix}sessions WHERE uid='$ssd_uid' OR hash='$ssd_hash' OR lastactivity<($ontime-2592000)");
	}
}

// 登录记录
function loginresult($username = '', $result) {
	global $ontime,$onlineip;
	writefile(SEBUG_ROOT.'forumdata/user_loginlog.php', "<?PHP exit('Access Denied'); ?>\t$username\t$ontime\t$onlineip\t$result\n", 'a');
}

function scookie($key, $value, $life = 0, $prefix = 1) {
	global $cookiepre, $cookiedomain, $cookiepath, $ontime, $_SERVER;
	$key = ($prefix ? $cookiepre : '').$key;
	$life = $life ? $ontime + $life : 0;
	$useport = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	setcookie($key, $value, $life, $cookiepath, $cookiedomain, $useport, TRUE);
}

// 删除cookies
function dcookies($key = '') {
	global $ssd_uid, $ssd_user, $ssd_pw;
	if ($key) {
		if(is_array($key)) {
			foreach ($key as $name) {
				scookie($name, '', -86400 * 365);
			}
		} else {
			scookie($key, '', -86400 * 365);
		}
	} else {
		if(is_array($_COOKIE)) {
			foreach ($_COOKIE as $key => $val) {
				scookie($key, '', -86400 * 365);
			}
		}
		$ssd_uid = 0;
		$ssd_user = $ssd_pw = '';
	}
}

// 获得IP地址
if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
	$onlineip = getenv('HTTP_CLIENT_IP');
} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	$onlineip = getenv('HTTP_X_FORWARDED_FOR');
} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	$onlineip = getenv('REMOTE_ADDR');
} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	$onlineip = $_SERVER['REMOTE_ADDR'];
}
$onlineip = addslashes($onlineip);
@preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
unset($onlineipmatches);

// 检查链接URL是否符合逻辑
function checkurl($url) {
	if($url) {
		if (!preg_match("#^(http|news|https|ftp|ed2k|rtsp|mms)://#", $url)) {
			$result .= 'URL error, please return to re-enter.<br />';
			return $result;
		}
		$key = array("\\",' ',"'",'"','*',',','<','>',"\r","\t","\n",'(',')','+',';');
		foreach($key as $value){
			if (strpos($url,$value) !== false){ 
				$result .= 'URL error, please return to re-enter.<br />';
				return $result;
				break;
			}
		}
	}
}

//判断是否为邮件地址
function isemail($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

// 操作提示页面
function redirect($msg, $tourl = 'javascript:history.go(-1);', $min='2') {
	include template('redirect');
	PageEnd();
}

// base64编码函数
function authcode($string, $operation = 'ENCODE') {
	$string = $operation == 'DECODE' ? base64_decode($string) : base64_encode($string);
	return $string;
}

// 自动识别URL
function parseurl($content) {
	$content = str_replace(" ", "%20" , $content);
	return preg_replace(array(
					"/(?<=[^\]A-Za-z0-9-=\"'\\/])(https?|ftp|gopher|news|telnet|mms){1}:\/\/([A-Za-z0-9\/\-_+=.~!%@?#%&;:$\\()|]+)/is",
					"/([\n\s])www\.([a-z0-9\-]+)\.([A-Za-z0-9\/\-_+=.~!%@?#%&;:$\[\]\\()|]+)((?:[^\x7f-\xff,\s]*)?)/is",
					"/(?<=[^\]A-Za-z0-9\/\-_.~?=:.])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4}))/si"
				), array(
					"<a href=\"\\1://\\2\" target=\"_blank\" rel=external nofollow>\\1://\\2</a>",
					"\\1<a href=\"www.\\2.\\3\\4\" target=\"_blank\" rel=external nofollow>www.\\2.\\3\\4</a>",
					"<a href=\"mailto:\\0\" target=\"_blank\" rel=external nofollow>\\0</a>"
				), ' '.$content);
}
////////////////////////////////////////////////////////////////////////////
/////////////////////////////用户管理///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
//判断奇数，是返回TRUE，否返回FALSE
function is_odd($num){
	return ($num&1);
}
?>