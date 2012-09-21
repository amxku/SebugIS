<?php
require ('./include/common.inc.php');
require (SEBUG_ROOT.'include/func/admin.func.php');

//check_root_amxku
/*===================== 程序配置 =====================*/
$admin = array();
$admin['name'] = 'admin';
$admin['pass'] = '21232f297a57a5a743894a0e4a801fc3';
/*===================== 配置结束 =====================*/


/*===================== 身份验证 =====================*/
if ($action == 'logout') {
	scookie('hostpass', '');
	@header('Location: '.$url);
	exit;
}
if ($action == 'login') {
	$name = addslashes(trim($_POST['name']));
	$pass = md5(addslashes(trim($_POST['password'])));
$clientcode = md5(intval(trim($_POST['clientcode'])));
	if ($admin['name'] == $name && $admin['pass'] == $pass) {
		scookie('hostpass', $pass);
		loginresult(Yes);
		@header('Location: '.$php_self);
		exit;
	}
	loginresult(No);
}
$login = 0;
if ($_COOKIE['hostpass']) {
	if ($_COOKIE['hostpass'] != $admin['pass']) {
		loginpage();
	}
	$login = 1;
} else {
	loginpage();
}
/*===================== 身份验证结束 =====================*/

$adminitem = array(
	'main' => 'T_SSD.NET',
	'BUG' => 'V_SSD',
	'EXP' => 'E_SSD',
	'tools' => 'SSD data',
	'log' => 'Log',
	'user' => 'User',
	'type' => '目录',
);

if (!$job) {
	$job = 'main';
} else {
	if (strlen($job) > 20) {
		$job = 'main';
	}
	$job = str_replace(array('.','/','\\',"'",':','%'),'',$job);
	$job = basename($job);
	$job = in_array($job, array('main','BUG','EXP','tools','log','user','type')) ? $job : 'main';
}
$subnav = '';
if (is_file('./image/'.$job.'.php')) {
	include ('./image/'.$job.'.php');
} else {
	include ('./image/main.php');
}
?>