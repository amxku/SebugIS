<?php
/******************************************
Info:SEBUG Security Database
Function:后台主页
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
if(!defined('SEBUG_ROOT') || !isset($php_self) || !preg_match("/[\/\\\\]admin\.php$/", $php_self)) {
	exit('Access Denied');
}
if($login){
	$globals  = getphpcfg('register_globals');
	$safemode = getphpcfg('safe_mode');

	//查询数据信息
	$bugs = $DB->result($DB->query("SELECT COUNT(id) FROM {$db_prefix}sebug_data where checked=1 AND Categories=1"), 0);
	$exp = $DB->result($DB->query("SELECT COUNT(id) FROM {$db_prefix}sebug_data where checked=1 AND Categories=0"), 0);
	$b_e = $bugs+$exp;
	$bugs_ncheck = $DB->result($DB->query("SELECT COUNT(id) FROM {$db_prefix}sebug_data where checked=0 AND Categories=1"), 0);
	$exp_ncheck = $DB->result($DB->query("SELECT COUNT(id) FROM {$db_prefix}sebug_data where checked=0 AND Categories=0"), 0);

	$server['datetime'] = date("Y-m-d H:i:s",$ontime);
	$server['software'] = $_SERVER['SERVER_SOFTWARE'];
	if (function_exists('memory_get_usage')) {
		$server['memory_info'] = get_real_size(memory_get_usage());
	}
	
	//查询在线用户信息
	$onlines = $comma = '';
	$query = $DB->query("SELECT s.uid,CONCAT_WS('.',s.ip1,s.ip2,s.ip3,s.ip4) as ipaddress,s.lastactivity,u.username FROM {$db_prefix}sessions s LEFT JOIN {$db_prefix}users u ON (s.uid=u.userid) WHERE s.uid > 0 ORDER BY s.lastactivity");
	while($online = $DB->fetch_array($query)) {
		$online['lastactivity'] = date('Y-m-d H:i:s', $online['lastactivity']);
		$onlines .= $comma.'<a href="'.$php_self.'?job=user&action=edit&zone='.$online['uid'].'" title="IP地址:'.$online['ipaddress'].'&#13;最后活动时间:'.$online['lastactivity'].'">'.$online['username'].'</a>';
		$comma = ', ';
	}
	unset($online);
	$DB->free_result($query);

	//查询用户数量
	$users_n_check = $DB->result($DB->query("SELECT COUNT(userid) FROM {$db_prefix}users"), 0);
	$users_n_nocheck = $DB->result($DB->query("SELECT COUNT(userid) FROM {$db_prefix}users where checked IN ('1')"), 0);
	
	//查询在线用户数量
	$online_users = $DB->result($DB->query("SELECT COUNT(uid) FROM {$db_prefix}sessions"), 0);

	//查询分类数量
	$type_n = $DB->result($DB->query("SELECT COUNT(typeid) FROM {$db_prefix}type"), 0);
	$type_n_no = $DB->result($DB->query("SELECT COUNT(typeid) FROM {$db_prefix}type where checked IN ('0')"), 0);
	
	cpheader();
	include template('main');
	cpfooter();
}
?>