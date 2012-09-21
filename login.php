<?php
/******************************************
Info:SEBUG Security Database
Function:用户管理
Author:amxku
date:2009/01/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
require_once ('./include/common.inc.php');
require_once(SEBUG_ROOT.'include/func/front.func.php');
include language('templates');

//检查主机头
if($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) !== preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST']))) {
	exit;
}
//登陆存活期2小时
$login_life = 7200;

!$options['meta_keywords']  && $options['meta_keywords'] = $language['sebug_meta_keywords'];
!$options['meta_description'] && $options['meta_description'] = $language['sebug_meta_description'];

if(!$checkloging){
	redirect($language['check_loging'], $url);
	exit();
}
if (!$s1) {
	$s1 = 'login';
} else {
	if (strlen($s1) > 20) {
		$s1 = 'login';
	}
	$s1 = str_replace(array('.','/','\\',"'",':','%'),'',$s1);
	$s1 = basename($s1);
	$s1 = in_array($s1, array('login','register','profile','user','doregister','modpro','dologin','logout','addvul','addexp','doaddvul','doaddexp')) ? $s1 : 'login';
}

if($s1 == 'login') {
	$options['title'] = 'SEBUG Accounts';
	$pagefile = 'login';
}elseif($s1 == 'register') {
	$options['title'] = $language['login_title_reg'];
	$pagefile = 'register';
}elseif($s1 == 'profile') {
	if($ssd_uid){	
		$options['title'] = $language['login_title_Modify'];
		$pagefile = 'profile';
		
		$user = $DB->fetch_one_array("SELECT email,homepage FROM {$db_prefix}users WHERE userid='".$ssd_uid."'");
	}else{
		Header('Location:'.$login_url);
		exit;
	}
}elseif($s1 == 'user') {
//用户信息
		$my_user = char_cv(trim($_GET['author']));
		$user = $DB->fetch_one_array("SELECT userid FROM {$db_prefix}users WHERE username='".$my_user."'");
		if($user['userid']){
			$author_id = $user['userid'];
		}else{
			Header('Location:'.$url);
			exit;
		}
		$user = $DB->fetch_one_array("SELECT username,email,homepage,password FROM {$db_prefix}users WHERE userid='".$author_id."'");
		$u_email = check_mail($user['email']);
		
		$t_query = $DB->query("SELECT COUNT(*) as total FROM {$db_prefix}sebug_data where checked IN ('1') AND uid IN ('".$author_id."')");
		$t_b_rs = $DB->fetch_array($t_query);
		$search_num = $t_b_rs['total'];
			$pagenum = 18;
			$page=(int)$_GET['page']; //取类页面值
			if($page){
				$start_limit = ($page - 1) * $pagenum;
			}else{
				$start_limit = 0;
				$page = 1;
			}
			$multipage = multi($search_num,$pagenum,$page,$user_url.''.$my_user.'/');
			$ut_query = $DB->query("SELECT id,title,Categories,attime FROM {$db_prefix}sebug_data where checked IN ('1') AND uid IN ('".$author_id."') ORDER BY id DESC LIMIT $start_limit,".$pagenum);
			$show_searchdb = array();
			while ($show_search = $DB->fetch_array($ut_query)){
				//去标题长度
				$show_search['title'] = trimmed_title(trim($show_search['title']),$title_long);
				$show_search['attime'] = date("Y-m-d",$show_search['attime']);
				if($show_search['Categories']){
					$show_search['to_url'] = checkpermalink_bug($show_search['id']);
				}else{
					$show_search['to_url'] = checkpermalink_exp($show_search['id']);
				}
				$show_searchdb[] = $show_search;
			}
			unset($show_search);
			$DB->free_result($ut_query);
			$DB->free_result($t_query);
				
		$options['title'] = $user['username'].' - SEBUG Accounts';
		$pagefile = 'user';
		$options['meta_keywords'] = $user['username'].','.$u_email;
		$options['meta_description'] = $language['sebug_meta_description'];
		
}elseif($s1 == 'doregister'){
//注册
	$clientcode = char_cv($_POST['clientcode']);
	session_start();
	if (!$clientcode || strtolower($clientcode) != strtolower($_SESSION['seccode'])) {
		unset($_SESSION['seccode']);
		redirect($language['login_title_Modify']);
	}
	// 取值并过滤部分
	$username        = char_cv(trim($_POST['username']));
	$password        = $_POST['password'];
	$confirmpassword = $_POST['confirmpassword'];
	$homepage        = char_cv(trim($_POST['homepage']));
	$email           = char_cv(trim($_POST['email']));
	if(!$username || strlen($username) > 30) {
		redirect($language['login_username_length']);
		exit;
	}
	$name_key = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#','$','(',')','%','@','+','?',';','^');
	foreach($name_key as $value){
		if (strpos($username,$value) !== false){
			redirect($language['login_user_name'], $reg_url);
		}
	}
	if (!$password || strlen($password) < 8) {
		redirect($language['login_passwd_length']);
	}
	if ($password != $confirmpassword) {
		redirect($language['loginconfirmpassword']);
	}
	if (strpos($newpassword,"\n") !== false || strpos($password,"\r") !== false || strpos($password,"\t") !== false) {
		redirect($language['login_passwd_characters']);
	}
	$username = char_cv($username);
	$r = $DB->fetch_one_array("SELECT userid FROM {$db_prefix}users WHERE username='$username' LIMIT 1");
	if($r['userid']) {
		redirect($language['login_name_registered'], $reg_url);
		unset($r);
	}
	if ($email && isemail($email)) {
		$r = $DB->fetch_one_array("SELECT userid FROM {$db_prefix}users WHERE email='".$email."' LIMIT 1");
		if($r['userid']) {
			redirect($language['login_mail_registered']);
		}
		unset($r);
	}
	$result = checkurl($homepage);
	if($result) {
		redirect($result);
	}
	$password = md5($password);
	$DB->query("INSERT INTO {$db_prefix}users (username,password,regip,regdate,email,homepage,logincount) VALUES ('".$username."', '".$password."', '".$onlineip."', '".$ontime."', '".$email."','".$homepage."','0')");
	$userid = $DB->insert_id();
	redirect($language['login_Reg_ok'], $url.'login.php?s1=login');	
	
}elseif($s1 == 'modpro'){	
//修改资料
	if($ssd_uid){	
		$clientcode = char_cv($_POST['clientcode']);
		session_start();
		if (!$clientcode || strtolower($clientcode) != strtolower($_SESSION['seccode'])) {
			unset($_SESSION['seccode']);
			redirect($language['login_clientcode']);
		}
		$password_sql = '';
		$confirmpassword = trim($_POST['confirmpassword']);
		$email = char_cv(trim($_POST['email']));
		$homepage = char_cv(trim($_POST['homepage']));
		$oldpassword = md5(trim($_POST['oldpassword']));
		$newpassword = trim($_POST['newpassword']);
		if ($newpassword) {
			$user = $DB->fetch_one_array("SELECT password FROM {$db_prefix}users WHERE userid='".$ssd_uid."'");
			if (!$user) {
				redirect($language['login_m_passwd']);
			}
			if ($oldpassword != $user['password']) {
				redirect($language['login_Error_passwd']);
			}
			if(strlen($newpassword) < 8) {
				redirect($language['login_passwd_length']);
			}
			if ($newpassword != $confirmpassword) {
				redirect($language['login_confirmpassword']);
			}
			if (strpos($newpassword,"\n") !== false || strpos($newpassword,"\r") !== false || strpos($newpassword,"\t") !== false) {
				redirect($language['login_passwd_characters']);
			}
			$password_sql = ",password='".md5($newpassword)."'";
		}
		if ($email && isemail($email)) {
			$r = $DB->fetch_one_array("SELECT userid FROM {$db_prefix}users WHERE email='$email' AND userid!='".$ssd_uid."' LIMIT 1");
			if($r['userid']) {
				redirect($language['login_mail_registered']);
			}
			unset($r);
		}
		if($homepage){
			$result = checkurl($homepage);
			if($result) {
				redirect($result);
			}
		}
		$DB->unbuffered_query("UPDATE {$db_prefix}users SET email='$email',homepage='$homepage' $password_sql WHERE userid='$ssd_uid'");
		if ($newpassword) {
			dcookies();
			redirect($language['login_modified_success_pass'], $login_url);
		} else {
			redirect($language['login_modified_success'], $user_url.''.$ssd_user);
		}
	}else{
		Header('Location:'.$login_url);
		exit;
	}
}elseif($s1 == 'dologin') {
// 登陆验证
	$clientcode = char_cv($_POST['clientcode']);
	session_start();
	if (!$clientcode || strtolower($clientcode) != strtolower($_SESSION['seccode'])) {
		unset($_SESSION['seccode']);
		redirect($language['login_clientcode']);
	}
	$username = char_cv(trim($_POST['username']));
	$password = md5(trim($_POST['password']));
	$userinfo = $DB->fetch_one_array("SELECT userid,password,logincount,checked FROM {$db_prefix}users WHERE username='$username' LIMIT 1");
	if($userinfo['checked'] == 0){
		if ($userinfo['userid'] && $userinfo['password'] == $password) {
			//更新登陆次数、登陆时间和登陆IP
			$DB->unbuffered_query("UPDATE {$db_prefix}users SET logincount=logincount+1, lastactivity='$ontime', lastip='$onlineip' WHERE userid='$userinfo[userid]'");
			$logincount = $userinfo['logincount']+1;
			$userhash = getuserhash($userinfo['userid'],$username,$password,$logincount);
			//保存COOKIE
			scookie('ssd_auth', authcode("$userinfo[userid]\t$password\t$logincount\t$userhash"), $login_life);
			//更新数据库中的登陆会话
			$DB->query("DELETE FROM {$db_prefix}sessions WHERE uid='".$userinfo[userid]."' OR lastactivity<($ontime-$login_life) OR hash='".$userhash."'");
			$ips = explode('.', $onlineip);
			$DB->query("INSERT INTO {$db_prefix}sessions (hash, ip1, ip2, ip3, ip4, uid, lastactivity, seccode) VALUES ('$userhash', '$ips[0]', '$ips[1]', '$ips[2]', '$ips[3]', '$userinfo[userid]', '$ontime', '$clientcode')");
			loginresult($username, 'Yes');
			@header('Location: '.$url);
			exit;
		}else{
			loginresult($username, 'No');
			dcookies();
			Header('Location:'.$login_url);
			exit;
		}
	}else{
		redirect($language['login_account_disabled'],$login_url);
	}
}elseif($s1 == 'logout') {
//注销
	if($ssd_uid){
		dcookies();
		$ssd_uid = 0;
		$ssd_user = $ssd_pw = '';
		@header('Location: '.$url);
		exit;
	}else{
		Header('Location:'.$login_url);
		exit;
	}
}elseif($s1 == 'addvul') {
	if($ssd_uid){
		//读取分类列表
		$show_no_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_checktype.jpg';
		if(!is_file($show_no_cachefile)){
			checktype();
		}
		//////////分类信息
		include($show_no_cachefile);
		foreach ($checktype_db as $key => $type_list) {
			//
		}
		
		$options['title'] = $language['login_title_addv'];
		$pagefile = 'addvul';
		$check_time = md5(date("Y-m-d",$ontime));
	}else{
		Header('Location:'.$login_url);
		exit;
	}
}elseif($s1 == 'addexp') {
	if($ssd_uid){
		//读取分类列表
		$show_no_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_checktype.jpg';
		if(!is_file($show_no_cachefile)){
			checktype();
		}
		//////////分类信息
		include($show_no_cachefile);
		foreach ($checktype_db as $key => $type_list) {
			//
		}
		$options['title'] = $language['login_title_adde'];
		$pagefile = 'addexp';
		$check_time = md5(date("Y-m-d",$ontime));
	}else{
		Header('Location:'.$login_url);
		exit;
	}
}elseif($s1 == 'doaddvul') {	
//用户添加信息 vul
	if($ssd_uid){	
			$check_code = char_cv($_POST['check_code']);
			$ch_time = md5(date("Y-m-d",$ontime));
	
			$clientcode = char_cv($_POST['clientcode']);
			session_start();
			if (!$clientcode || strtolower($clientcode) != strtolower($_SESSION['seccode'])) {
				unset($_SESSION['seccode']);
				redirect($language['login_clientcode']);
			}elseif($check_code != $ch_time){
				//对比前后时间戳
				redirect($language['login_add_overtime']);
			}else{
				//保存操作
				$title = char_cv(trim($_POST['bug_title']));	//取标题
				$os = intval($_POST['bug_os']);	//取系统
				$be_type = intval($_POST['bug_be_type']);	//类型
				$puti = char_cv(trim($_POST['bug_putime']));	//发布时间
				$Impact = nl2br(char_cv($_POST['bug_Impact']));	//影响版本
				$grades = intval($_POST['bug_grades']);	//危害级别
				$buginfo = htmlspecialchars($_POST['bug_buginfo']);	//详细说明
				$ress = nl2br(htmlspecialchars($_POST['bug_ress']));	//解决方案
				$reference = nl2br(parseurl(htmlspecialchars($_POST['bug_reference'])));	//参考
				$bugexp = char_cv($_POST['bug_bugexp']);	//exp
				$systype = intval($_POST['systype']);	//systype
				if($title == ''){
					redirect($language['add_title']);
				}
				if ($os == ''){
					redirect($language['add_system']);
				}
				if ($be_type == ''){
					redirect($language['add_type']);
				}
				if ($puti == 'yyyy-mm-dd') {
					redirect($language['add_Published']);
				}else{
					$put = explode("-", $puti);
					if(checkdate($put[1],$put[2],$put[0])){
						$putime = mktime(0, 0, 0, $put[1], $put[2], $put[0]);
					}else{
						redirect($language['add_time']);
					}
				}
				if ($Impact == ''){
					redirect($language['add_Vulnerable']);
				}
				if ($grades == ''){
					redirect($language['add_grades']);
				}
				if ($buginfo == ''){
					redirect($language['add_Discussion']);
				}
				if ($ress == ''){
					redirect($language['add_Solution']);
				}
				if ($reference == ''){
					redirect($language['add_References']);
				}
				//验证是否已存在
				$query = $DB->query("SELECT id FROM {$db_prefix}sebug_data where title='".$title."'");
				$rs = $DB->fetch_array($query);
				if($rs['id']){
					redirect($language['add_Database_already']);		
				}		
					//写入数据库
	  		$DB->query("INSERT INTO {$db_prefix}sebug_data (Categories,uid,os,be_type,typeid,attime,putime,title,Impact,grades,buginfo,ress,reference, bugexp,checked) VALUES (1,'".$ssd_uid."','".$os."','".$be_type."','".$systype."','".$ontime."','".$putime."','".$title."','".$Impact."','".$grades."','".$buginfo."','".$ress."','".$reference."','".$bugexp."',0)");
	  		
	  		$DB->unbuffered_query("UPDATE {$db_prefix}users SET sebugt=sebugt+1 WHERE userid='".$ssd_uid."'");
	  		redirect($language['add_success']);
			}
	}else{
		Header('Location:'.$login_url);
		exit;
	}
}elseif($s1 == 'doaddexp') {	
//用户添加信息 exp
	if($ssd_uid){	
			$check_code = char_cv($_POST['check_code']);
			$ch_time = md5(date("Y-m-d",$ontime));
	
			$clientcode = char_cv($_POST['clientcode']);
			session_start();
			if (!$clientcode || strtolower($clientcode) != strtolower($_SESSION['seccode'])) {
				unset($_SESSION['seccode']);
				redirect($language['login_clientcode']);
			}elseif($check_code != $ch_time){
				//对比前后时间戳
				redirect($language['login_add_overtime']);
			}else{
				//保存操作
				$os = intval($_POST['bug_os']);
				$title = htmlspecialchars(trim($_POST['exp_title']));	//标题
				$puti = char_cv(trim($_POST['exp_putime']));	//发布时间
				$exp = htmlspecialchars($_POST['exp_exp']);	 //exp
				$type = intval($_POST['bug_be_type']);	//类型
				$systype = intval($_POST['systype']);	//systype
				if($title == ''){
					redirect($language['add_title']);
				}
				if ($os == ''){
					redirect($language['add_system']);
				}
				if ($puti == 'yyyy-mm-dd') {
					redirect($language['add_Published']);
				}else{
					$put = explode("-", $puti);
					if(checkdate($put[1],$put[2],$put[0])){
						$putime = mktime(0, 0, 0, $put[1], $put[2], $put[0]);
					}else{
						redirect($language['add_time']);
					}
				}
				if ($type == ''){
					redirect($language['add_type']);
				}
				if ($exp == ''){
					redirect($language['add_Exploit']);
				}
				//验证是否已存在
				$query = $DB->query("SELECT id FROM {$db_prefix}sebug_data where title='".$title."'");
					$rs = $DB->fetch_array($query);
				if($rs['id'])	{
					redirect($language['add_Database_already']);
				}
					//写入数据库
					$DB->query("INSERT INTO {$db_prefix}sebug_data (Categories,uid,os,be_type,typeid,attime,putime,title,bugexp,checked) VALUES (0,'".$ssd_uid."','".$os."','".$type."','".$systype."','".$ontime."','".$putime."','".$title."','".$exp."',0)");
					
					$DB->query("UPDATE {$db_prefix}users SET sebugt=sebugt+1 WHERE userid='".$ssd_uid."'");
					redirect($language['add_success']);
			}
	}else{
		Header('Location:'.$login_url);
		exit;
	}
}else{
	Header('Location:'.$login_url);
	exit;
}
include template($pagefile);
footer();
?>