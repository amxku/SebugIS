<?php
/******************************************
Info:SEBUG Security Database
Function:LOG管理
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
if(!defined('SEBUG_ROOT') || !isset($php_self) || !preg_match("/[\/\\\\]admin\.php$/", $php_self)) {
	exit('Access Denied');
}

if($login){
	!$action && $action = 'loginlog';

	//管理员登录日志
	if ($action == 'loginlog') {
		$subnav = '管理员登录日志';
		$pagenext = $php_self.'?job=log&action=loginlog';
		@$logfile = file(SEBUG_ROOT.'forumdata/loginlog.php');
		$logs = $logdb = array();
		if(is_array($logfile)) {
			foreach($logfile as $log) {
				$logs[] = $log;
			}
		}
	}
	
	//用户登录日志
	if ($action == 'userloginlog') {
		$subnav = '用户登录日志';
		$pagenext = $php_self.'?job=log&action=userloginlog';
		@$logfile = file(SEBUG_ROOT.'forumdata/user_loginlog.php');
		$logs = $logdb = array();
		if(is_array($logfile)) {
			foreach($logfile as $log) {
				$logs[] = $log;
			}
		}
	}

	$logs = @array_reverse($logs);
	$pagenum = 10;
	if($page) {
		$start_limit = ($page - 1) * $pagenum;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$tatol = count($logs);
	if ($tatol) {
		$multipage = multi($tatol, $pagenum, $page, $pagenext);
		for($i = 0; $i < $start_limit; $i++) {
			unset($logs[$i]);
		}
		for($i = $start_limit + $pagenum; $i < $tatol; $i++) {
			unset($logs[$i]);
		}
		foreach($logs as $logrow) {
					$logrow = explode("\t", $logrow);
					$logrow[1] = $logrow[1] ? htmlspecialchars($logrow[1]) : '<span class="no">Null</span>';
					$logrow[2] = date('Y-m-d H:i:s', $logrow[2]);
					$logrow[4] = $logrow[4] ? htmlspecialchars($logrow[4]) : '<span class="no">Null</span>';
					$logrow[4] = trim($logrow[4]) == 'Yes' ? '<span class="yes">Succeed</span>' : '<span class="no">Failed</span>';
					$logdb[] = $logrow;
			}
		unset($logrow);
	}

	
	cpheader();
	include template('log');
	cpfooter();
}
?>