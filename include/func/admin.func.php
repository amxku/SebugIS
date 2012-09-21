<?php
/******************************************
Info:SEBUG Security Database
Function:后台函数
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
require (SEBUG_ROOT.'include/func/global.func.php');
require (SEBUG_ROOT.'include/func/permalink.func.php');
require (SEBUG_ROOT.'include/func/cache.func.php');
//判断漏洞针对平台
function idtoos($id){
	$temp = '';
	switch($id){
		case 9:
		$temp='other';
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
		$temp='MacOX';
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
		$temp='多平台';
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
	$temp = '';
	switch($id){
		case 1:
		$temp = '越权访问';
		break;
		case 2:
		$temp = '拒绝服务';
		break;
		case 3:
		$temp = '嵌入恶意代码';
		break;
		case 4:
		$temp = 'SQL注入';
		break;
		case 5:
		$temp = '其他类型';
		break;
		case 6:
		$temp = '远程溢出';
		break;
		case 7:
		$temp = '文件包含';
		break;
		case 8:
		$temp = '本地溢出';
		break;
		case 9:
		$temp = '跨站';
		break;
		case 10:
		$temp = 'Web Apps';
		break;
		case 11:
		$temp = '遍历目录';
		break;
		case 12:
		$temp = 'DOS/POC';
		break;
		case 13:
		$temp = 'ShellCode';
		break;
		case 14:
		$temp = '上传';
		break;
		case 15:
		$temp = '泄漏信息';
		break;
		case 16:
		$temp = '远程执行';
		break;
		case 17:
		$temp = 'Cookie验证漏洞';
		break;
		}
	return $temp;
}

// 连接多个ID
function implode_ids($array){
	$ids = $comma = '';
	if (is_array($array) && count($array)){
		foreach($array as $id) {
			$ids .= "$comma'".intval($id)."'";
			$comma = ', ';
		}
	}
	return $ids;
}

function template($file) {
	$tplfile = SEBUG_ROOT.'forumdata/templates/admin/'.$file.'.php';
	$objfile = SEBUG_ROOT.'forumdata/templates_c/admin_'.$file.'.tpl.php';
	if (@filemtime($tplfile) > @filemtime($objfile)) {
		require_once SEBUG_ROOT.'include/class/template.class.php';
		parse_template($tplfile, $objfile);
	}
	return $objfile;
}

$php_self = char_cv($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);

function getphpcfg($varname) {
	switch($result = @get_cfg_var($varname)) {
		case 0:
			return '关闭';
			break;
		case 1:
			return '打开';
			break;
		default:
			return $result;
			break;
	}
}

function getfun($funName) {
	return (function_exists($funName)) ? '支持' : '不支持';
}

function scookie($key, $value, $life = 0, $prefix = 1) {
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	$key = ($prefix ? $cookiepre : '').$key;
	$life = $life ? $timestamp + $life : 0;
	$useport = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	setcookie($key, $value, $life, $cookiepath, $cookiedomain, $useport);
}

// 删除cookies
function dcookies($key = '') {
	global $sax_uid, $sax_user, $sax_pw;
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
		$sax_uid = 0;
		$sax_user = $sax_pw = '';
	}
}


// 获取数据库大小单位
function get_real_size($size) {
	$kb = 1024;         // Kilobyte
	$mb = 1024 * $kb;   // Megabyte
	$gb = 1024 * $mb;   // Gigabyte
	$tb = 1024 * $gb;   // Terabyte

	if ($size < $kb) {
		return $size.' Byte';
	} elseif ($size < $mb) {
		return round($size/$kb,2).' KB';
	} elseif ($size < $gb) {
		return round($size/$mb,2).' MB';
	} elseif ($size < $tb) {
		return round($size/$gb,2).' GB';
	} else {
		return round($size/$tb,2).' TB';
	}
}

// 控制面板各页面页眉
function cpheader() {
	global $adminitem,$job,$login;
	$title = isset($adminitem) ? $adminitem[$job] : 'SEBUG.NET';
	include template('header');
}

// 控制面板各页面页脚
function cpfooter() {
	global $starttime,$DB;
	$mtime		= explode(' ', microtime());
	$totaltime	= number_format(($mtime[1] + $mtime[0] - $starttime), 6);
	$debuginfo	= 'Processed in '.$totaltime.' second(s), '.$DB->querycount.' queries';
	include template('footer');
	PageEnd();
}

// 后台登陆入口页面
function loginpage(){
	cpheader();
	include template('login');
	cpfooter();
	PageEnd();
}

// 操作提示页面
function redirect($msg, $tourl = 'javascript:history.go(-1);', $min='2') {
	include template('redirect');
	PageEnd();
}

//生成模板
function buildtemplate($name) {
	$t_dir = SEBUG_ROOT.'forumdata/templates/'.$name.'/';
	if(is_dir($t_dir)) {
		$dirs = dir($t_dir);
		$t_files = array();
		$i=0;
		while ($file = $dirs->read()) {
			$filepath = $t_dir.$file;
			$pathinfo = pathinfo($file);
			if(is_file($filepath) && $pathinfo['extension'] == 'php') {
				$i++;
				$t_files[$i]['tplfile'] = $filepath;
				$t_files[$i]['objfile'] = SEBUG_ROOT.'forumdata/templates_c/'.$name.'_'.str_replace('.php','',$file).'.tpl.php';
			}
		}
		$dirs->close();

		require_once SEBUG_ROOT.'include/class/template.class.php';

		foreach($t_files as $data) {
			parse_template($data['tplfile'], $data['objfile']);
		}
	} else {
		exit('模板不存在');
	}
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

// 自动识别URL
function parseurl($content) {
	//$content = str_replace(" ", "%20" , $content);
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

function getrowbg() {
	global $bgcounter;
	if ($bgcounter++%2==0) {
		return "bg1";
	} else {
		return "bg2";
	}
}

// 转换时间单位:秒 to XXX
function format_timespan($seconds = '') {
	if ($seconds == '') $seconds = 1;
	$str = '';
	$years = floor($seconds / 31536000);
	if ($years > 0) {
		$str .= $years.' 年, ';
	}
	$seconds -= $years * 31536000;
	$months = floor($seconds / 2628000);
	if ($years > 0 || $months > 0) {
		if ($months > 0) {
			$str .= $months.' 月, ';
		}
		$seconds -= $months * 2628000;
	}
	$weeks = floor($seconds / 604800);
	if ($years > 0 || $months > 0 || $weeks > 0) {
		if ($weeks > 0)	{
			$str .= $weeks.' 周, ';
		}
		$seconds -= $weeks * 604800;
	}
	$days = floor($seconds / 86400);
	if ($months > 0 || $weeks > 0 || $days > 0) {
		if ($days > 0) {
			$str .= $days.' 天, ';
		}
		$seconds -= $days * 86400;
	}
	$hours = floor($seconds / 3600);
	if ($days > 0 || $hours > 0) {
		if ($hours > 0) {
			$str .= $hours.' 小时, ';
		}
		$seconds -= $hours * 3600;
	}
	$minutes = floor($seconds / 60);
	if ($days > 0 || $hours > 0 || $minutes > 0) {
		if ($minutes > 0) {
			$str .= $minutes.' 分钟, ';
		}
		$seconds -= $minutes * 60;
	}
	if ($str == '') {
		$str .= $seconds.' 秒, ';
	}
	$str = substr(trim($str), 0, -1);
	return $str;
}

// 分页函数
function multi($num, $perpage, $curpage, $mpurl) {
	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
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

		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1">第一页</a> ' : '').($curpage > 1 ? '<a href="'.$mpurl.'page='.($curpage - 1).'">上一页</a> ' : '');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? $i.' ' : '<a href="'.$mpurl.'page='.$i.'">['.$i.']</a> ';
		}
		$multipage .= ($curpage < $pages ? '<a href="'.$mpurl.'page='.($curpage + 1).'">下一页</a>' : '').($to < $pages ? ' <a href="'.$mpurl.'page='.$pages.'">最后一页</a>' : '');
		$multipage = $multipage ? ''.$multipage : '';
	}
	return $multipage;
}

function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}


function sqldumptable($table, $startfrom = 0, $currsize = 0) {
	global $DB, $sizelimit, $startrow, $sqlcompat, $dumpcharset;

	$offset = 300;
	$tabledump = '';

	if(!$startfrom) {
		$tabledump = "DROP TABLE IF EXISTS $table;\n";
		$createtable = $DB->query("SHOW CREATE TABLE $table");
		$create = $DB->fetch_row($createtable);
		$tabledump .= $create[1];

		if($sqlcompat == 'MYSQL41' && $DB->version() < '4.1') {
			$tabledump = preg_replace("/TYPE\=(.+)/", "ENGINE=\\1 DEFAULT CHARSET=".$dumpcharset, $tabledump);
		}
		if($DB->version() > '4.1' && $dumpcharset) {
			$tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=.+/", "DEFAULT CHARSET=".$dumpcharset, $tabledump);
		}

		$query = $DB->query("SHOW TABLE STATUS LIKE '$table'");
		$tablestatus = $DB->fetch_array($query);
		$tabledump .= ($tablestatus['Auto_increment'] ? " AUTO_INCREMENT=$tablestatus[Auto_increment]" : '').";\n\n";
		if($sqlcompat == 'MYSQL40' && $DB->version() >= '4.1') {
			if($tablestatus['Auto_increment'] <> '') {
				$temppos = strpos($tabledump, ',');
				$tabledump = substr($tabledump, 0, $temppos).' auto_increment'.substr($tabledump, $temppos);
			}
		}
	}

	$tabledumped = 0;
	$numrows = $offset;

	while($currsize + strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
		$tabledumped = 1;
		$rows = $DB->query("SELECT * FROM $table LIMIT $startfrom, $offset");
		$numfields = $DB->num_fields($rows);
		$numrows = $DB->num_rows($rows);
		while($row = $DB->fetch_row($rows)) {
			$comma = '';
			$tabledump .= "INSERT INTO $table VALUES (";
			for($i = 0; $i < $numfields; $i++) {
				$tabledump .= $comma.'\''.mysql_escape_string($row[$i]).'\'';
				$comma = ',';
			}
			$tabledump .= ");\n";
		}
		$startfrom += $offset;
	}

	$startrow = $startfrom;
	$tabledump .= "\n";
	return $tabledump;
}

// 登录记录
function loginresult($check_ok) {
	global $ontime,$onlineip,$name;
	writefile(SEBUG_ROOT.'forumdata/loginlog.php', "<?PHP exit('Access Denied'); ?>\t$name\t$ontime\t$onlineip\t$check_ok\n", 'a');
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

?>