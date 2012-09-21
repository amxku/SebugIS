<?php
/******************************************
Info:SEBUG Security Database
Function:用户管理
Author:amxku
date:2009/02/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
if(!defined('SEBUG_ROOT') || !isset($php_self) || !preg_match("/[\/\\\\]admin\.php$/", $php_self)) {
	exit('Access Denied');
}
if($login){
	if ($action == 'edit_save') {
		$uuid=(int)$_POST['zone'];
		$passwd = md5(trim($_POST['passwd']));//passwd
		if($passwd){
			$pass_qu =",password ='".$passwd."'";
		}else{
			$pass_qu =' ';
		}
		$checked = intval($_POST['checked']);	//审核
		if($uuid){
			// 更新数据
			$DB->unbuffered_query("UPDATE {$db_prefix}users SET checked='$checked'$pass_qu where userid IN ('".$uuid."')");
			redirect('编辑完毕',$php_self.'?job=user');
		} else {
			redirect('未选择信息');
		}
	}

	if ($action == 'domore') {
		$do = char_cv($_GET['do']);
			!$do && $do = char_cv($_POST['do']);
		if (in_array($do,array('check','nocheck','delete'))) {
			$id = intval($_GET['zone']);
				!$id && $id = implode_ids($_POST['zone']);
			if ($id) {
				if ($do == 'delete') {
					$DB->unbuffered_query("DELETE FROM {$db_prefix}users WHERE userid IN ($id')");
				} elseif ($do == 'check') {				
					$DB->unbuffered_query("UPDATE {$db_prefix}users SET checked='0' WHERE userid IN ($id)");
				} else {
					$DB->unbuffered_query("UPDATE {$db_prefix}users SET checked='1' WHERE userid IN ($id)");
				}
				redirect('操作完成',$php_self.'?job=user');
			} else {
				redirect('未选择信息');
			}
		} else {
			redirect('未选择任何操作');
		}
	}

	if (!$action) {
		$action = 'list';
	}
	if ($action == 'list') {
		$subnav = '用户列表';
		$wd = char_cv($_POST['keywords']);
		$addquery ='';
		if ($do == 'search') {
			$addquery = " WHERE username LIKE '%$wd%' OR email LIKE '%$wd%'";
		}
		
		$gettop = intval($_GET['top']);
		if ($gettop == '1') {
			$ord_by_query = ' ORDER BY logincount DESC LIMIT ';
		}elseif ($gettop == '2') {
			$ord_by_query = ' ORDER BY sebugt DESC LIMIT ';
		}elseif ($gettop == '3') {
			$ord_by_query = ' ORDER BY userid DESC LIMIT ';
			}elseif ($gettop == '4') {
			$ord_by_query = ' ORDER BY lastactivity DESC LIMIT ';
		}else{
			$ord_by_query = ' ORDER BY checked DESC LIMIT ';
		}
		
		$query = $DB->query("SELECT COUNT(*) as total FROM {$db_prefix}users$addquery");
		$rs = $DB->fetch_array($query);
		$user_list_num = $rs['total'];
		if($user_list_num){
			$page=(int)$_GET['page']; //取类页面值
			$pagenum = 10;
			if($page) {
				$start_limit = ($page - 1) * $pagenum;
			}else{
				$start_limit = 0;
				$page = 1;
			}
			$multipage = multi($user_list_num,$pagenum,$page,$php_self.'?job=user&top='.$gettop);
			$sqlstr = $DB->query("SELECT userid,regdate,lastip,lastactivity,username,checked,logincount,sebugt FROM {$db_prefix}users$addquery$ord_by_query $start_limit, ".$pagenum);
			$user_listdb = array();
			while ($user_list = $DB->fetch_array($sqlstr)){
				//去标题长度
				$user_list['title'] = trim($user_list['title']);
				$user_list['regdate'] = date("Y-m-d,H:m:s",$user_list['regdate']);
				$user_list['lastactivity'] = date("Y-m-d,H:m:s",$user_list['lastactivity']);
				$user_listdb[] = $user_list;
			}
		unset($user_list);
		$DB->free_result($sqlstr);
		} else {
			redirect('未选择信息');
		}
	}
	
		if ($action == 'edit') {
			$subnav = '编辑用户信息';
			$id = intval($_GET['zone']);

			$edit_user = $DB->fetch_one_array("SELECT userid,username,regdate,regip,checked,lastip,lastactivity,sebugt,email,homepage FROM {$db_prefix}users WHERE userid='".$id."'");
			$checked = $edit_user['checked'];
			$edit_user['regdate'] = date("Y-m-d,H:m:s",$edit_user['regdate']);
			$edit_user['lastactivity'] = date("Y-m-d,H:m:s",$edit_user['lastactivity']);
		}
		
		if ($action == 'user_updata') {
			// 更新用户上报数量
			/////////////////////		
			$step		  = (!$step) ? 1 : $step;
			$percount = ($percount <= 0) ? 100 : $percount;
			$start    = ($step - 1) * $percount;
			$next     = $start + $percount;
			$step++;
			$jumpurl  = $php_self.'?job=user&action=user_updata&step='.$step.'&percount='.$percount;
			$goon     = 0;
			$query 		= $DB->query("SELECT userid FROM {$db_prefix}users WHERE checked='0' AND logincount>0 ORDER BY logincount LIMIT $start, $percount");
			while ($user_list = $DB->fetch_array($query)) {
				$goon = 1;
				// 更新所有用户的上报数
				$tatol = $DB->result($DB->query("SELECT COUNT(*) FROM {$db_prefix}sebug_data where checked='1' AND uid='".$user_list['userid']."'"), 0);
				$DB->unbuffered_query("UPDATE {$db_prefix}users SET sebugt='$tatol' WHERE userid='".$user_list['userid']."'");
			}
			if($goon){
				redirect('正在更新 '.$start.' 到 '.$next.' 项', $jumpurl, '2');
			} else{
				redirect('成功更新所有用户的上报数据', $php_self.'?job=user&top=2');
			}
			/////////////////////
		}
		
		if ($action == 'usermail') {
			
			$subnav = '邮件列表';
			
			$gettop = intval($_GET['top']);
			if ($gettop == '1') {
				$ord_by_query = 'where logincount > 0';
			}elseif ($gettop == '2') {
				$ord_by_query = 'where sebugt > 0';
			}else{
				$ord_by_query = '';
			}
			
			$mailuser = $DB->query("SELECT email FROM {$db_prefix}users $ord_by_query");
			$mailuser_n = $DB->result($DB->query("SELECT COUNT(*) FROM {$db_prefix}users $ord_by_query"), 0);
			$user_maildb = array();
			while ($user_mail = $DB->fetch_array($mailuser)){
				//去标题长度
				$user_mail['email'] = $user_mail['email'].';';
				$user_maildb[] = $user_mail;
			}
		unset($user_mail);
		$DB->free_result($mailuser);
		}
	cpheader();
	include template('user');
	cpfooter();
}
?>