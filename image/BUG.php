<?php
/******************************************
Info:SEBUG Security Database
Function:BUG信息
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
if(!defined('SEBUG_ROOT') || !isset($php_self) || !preg_match("/[\/\\\\]admin\.php$/", $php_self)) {
	exit('Access Denied');
}
if($login){
	$on_time = date("Y-m-d",$ontime);
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
		
	if ($action == 'add') {
		$title = htmlspecialchars(trim($_POST['title']));	//取标题
		$os = intval($_POST['os']);	//取系统
		$be_type = intval($_POST['be_type']);	//类型
		$puti = char_cv(trim($_POST['putime']));	//发布时间
		$Impact = nl2br(htmlspecialchars($_POST['Impact']));	//影响版本
		$grades = intval($_POST['grades']);	//危害级别
		$buginfo = htmlspecialchars($_POST['buginfo']);	//详细说明
		$ress = nl2br(htmlspecialchars($_POST['ress']));	//解决方案
		$reference = nl2br(parseurl(htmlspecialchars(trim($_POST['reference']))));	//参考
		$bugexp = htmlspecialchars($_POST['bugexp']);	//exp
		$checked = intval($_POST['checked']);	//审核
		$systype = intval($_POST['systype']);	//systype

		if (!$title) {
			redirect('没有标题',$php_self.'?job=BUG&amp;action=addbug');
		}
		if (!$puti) {
			redirect('没有发布时间',$php_self.'?job=BUG&amp;action=addbug');
		}else{
			$put = explode("-", $puti);
			if(checkdate($put[1],$put[2],$put[0])){
				$putime = mktime(0, 0, 0, $put[1], $put[2], $put[0]);
			}else{
				redirect('发布时间格式不对',$php_self.'?job=BUG&amp;action=addbug');
			}
		}
		if (!$os) {
			redirect('没有选择系统',$php_self.'?job=BUG&amp;action=addbug');
		}
		if (!$Impact) {
			redirect('没有影响版本',$php_self.'?job=BUG&amp;action=addbug');
		}
		if (!$be_type) {
			redirect('没有选择类型',$php_self.'?job=BUG&amp;action=addbug');
		}
		$r = $DB->fetch_one_array("SELECT id FROM {$db_prefix}sebug_data WHERE Categories=1 AND title='".$title."'");
		if($r['id']) {
			redirect('该信息已经登记过',$php_self.'?job=BUG&amp;action=addbug');
		}
		$DB->unbuffered_query("UPDATE {$db_prefix}type SET v_num=v_num+1 WHERE typeid IN ('".$systype."')");
		$DB->query("INSERT INTO {$db_prefix}sebug_data (Categories,os,be_type,typeid,attime,putime,title,Impact,grades,buginfo,ress,reference, bugexp,checked) VALUES (1,'".$os."','".$be_type."','".$systype."','".$ontime."','".$putime."','".$title."','".$Impact."','".$grades."','".$buginfo."','".$ress."','".$reference."','".$bugexp."','".$checked."')");
		redirect('添加成功',$php_self.'?job=BUG&amp;action=addbug');
	}

	if ($action == 'edit_save') {
		$id=(int)$_POST['zone'];
		$title = htmlspecialchars(trim($_POST['title']));
		$r_os = intval($_POST['os']);
		$r_be_type = intval($_POST['be_type']);
		$puti = char_cv($_POST['putime']);
		$Impact = $_POST['Impact'];
		$grades = intval($_POST['grades']);
		$buginfo = htmlspecialchars($_POST['buginfo']);
		$ress = $_POST['ress'];	//解决方案
		$reference = trim($_POST['reference']);	//参考
		$checked = intval($_POST['checked']);
		$bugexp = htmlspecialchars($_POST['bugexp']);	//exp
		$systype = intval($_POST['systype']);	//systype
		
		$put = explode("-", $puti);
		if(checkdate($put[1],$put[2],$put[0])){
			$putime = mktime(0, 0, 0, $put[1], $put[2], $put[0]);
		}else{
			redirect('发布时间格式不对',$php_self.'?job=BUG&amp;action=addbug');
		}
		if($id){
			$uid = intval($edit_bug['uid']);
			if($uid){
				$u_query = $DB->query("SELECT username,email FROM {$db_prefix}users where userid IN ('".$uid."')");
					$u_rs = $DB->fetch_array($u_query);
					if($u_rs['username']){
						$u_name = urlencode($u_rs['username']);
						$u_email = check_mail($u_rs['email']);
					}
			}
			// 更新数据
			$DB->unbuffered_query("UPDATE {$db_prefix}type SET v_num=v_num+1 WHERE typeid IN ('".$systype."')");
			$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET title='".$title."',os='".$r_os."',typeid='".$systype."',be_type='".$r_be_type."',putime='".$putime."',Impact='".$Impact."',grades='".$grades."',buginfo='".$buginfo."',ress='".$ress."',reference='".$reference."',checked='".$checked."',bugexp='".$bugexp."' where id IN ('".$id."')");
			redirect('编辑完毕',$php_self.'?job=EXP');
		} else {
			redirect('未选择信息');
		}
	}

	if ($action == 'domore') {		
		$do = char_cv($_GET['do']);
		!$do && $do = char_cv($_POST['do']);
		if (in_array($do,array('check','nocheck','delete','type'))) {
			$id = intval($_GET['zone']);
				!$id && $id = implode_ids($_POST['zone']);
			if ($id) {
				if ($do == 'delete') {
					$DB->unbuffered_query("DELETE FROM {$db_prefix}sebug_data WHERE id IN ($id)");
				} elseif ($do == 'check') {				
					$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET checked='1' WHERE id IN ($id)");
				}elseif ($do == 'type') {
					$systypeid= intval($_POST['systype']);		
					$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET typeid='".$systypeid."' WHERE id IN ($id)");
				} else {
					$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET checked='0' WHERE id IN ($id)");
				}
				redirect('操作完成',$php_self.'?job=BUG');
			} else {
				redirect('未选择信息');
			}
		} else {
			redirect('未选择任何操作');
		}
	}

	if (!$action) {
		$action = 'addbug';
	}

	if (in_array($action, array('addbug', 'edit'))) {		
		if ($action == 'addbug') {
			$subnav = '添加Vulndb信息';
		} else {
			$subnav = '编辑Vulndb信息';
			$id = intval($_GET['zone']);

			$edit_bug = $DB->fetch_one_array("SELECT * FROM {$db_prefix}sebug_data WHERE Categories=1 AND id='".$id."'");
				$os = $edit_bug['os'];
				$be_type = $edit_bug['be_type'];
				$grades = $edit_bug['grades'];
				$checked = $edit_bug['checked'];
				$edit_bug['putime'] = date("Y-m-d",$edit_bug['putime']);
		}
	}
	cpheader();
	include template('BUG');
	cpfooter();
}
?>
