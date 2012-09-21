<?php
/******************************************
Info:SEBUG Security Database
Function:EXP管理
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
		checktype();
		//////////分类信息
		include($show_no_cachefile);
		foreach ($checktype_db as $key => $type_list) {
			//
		}
	
	if ($action == 'add') {
		$title = htmlspecialchars(trim($_POST['title']));	//标题
		$os = intval($_POST['os']);	//取系统
		$puti = char_cv(trim($_POST['putime']));	//发布时间
		$exp = htmlspecialchars($_POST['exp']);	//exp
		$systype = intval($_POST['systype']);	//systype
		$checked = intval($_POST['checked']);	//审核
		$type = intval($_POST['type']);	//类型

		if (!$title) {
			redirect('没有标题',$php_self.'?job=EXP&amp;action=addEXP');
		}
		if (!$puti) {
			redirect('没有发布时间',$php_self.'?job=EXP&amp;action=addEXP');
		}else{
			$put = explode("-", $puti);
			if(checkdate($put[1],$put[2],$put[0])){
				$putime = mktime(0, 0, 0, $put[1], $put[2], $put[0]);
			}else{
				redirect('发布时间格式不对',$php_self.'?job=EXP&amp;action=addEXP');
			}
		}
		if (!$exp) {
			redirect('没有exp',$php_self.'?job=EXP&amp;action=addEXP');
		}
		if (!$os) {
			redirect('没有选择系统',$php_self.'?job=EXP&amp;action=addEXP');
		}
		if (!$type) {
			redirect('没有选择类型',$php_self.'?job=EXP&amp;action=addEXP');
		}
		$r = $DB->fetch_one_array("SELECT id FROM {$db_prefix}sebug_data WHERE Categories=0 AND title='".$title."'");
		if($r['id']) {
			redirect('该信息已经登记过',$php_self.'?job=EXP&amp;action=addEXP');
		}
		$DB->query("INSERT INTO {$db_prefix}sebug_data (Categories,os,be_type,typeid,attime,putime,title,bugexp,checked) VALUES (0,'".$os."','".$type."','".$systype."','".$ontime."','".$putime."','".$title."','".$exp."','".$checked."')");
			$DB->unbuffered_query("UPDATE {$db_prefix}type SET v_num=v_num+1 WHERE typeid IN ('".$systype."')");
		redirect('添加成功',$php_self.'?job=EXP&amp;action=addEXP');
	}

	if ($action == 'edit_save') {
		$id=(int)$_POST['zone'];
		$title = htmlspecialchars(trim($_POST['title']));	//标题
		$puti = char_cv(trim($_POST['putime']));	//发布时间
		$exp = htmlspecialchars($_POST['exp']);	//exp
		$systype = intval($_POST['systype']);	//systype
		$checked = intval($_POST['checked']);	//审核
		$type = intval($_POST['type']);	//类型
		$r_os = intval($_POST['os']);

		$put = explode("-", $puti);
		if(checkdate($put[1],$put[2],$put[0])){
			$putime = mktime(0, 0, 0, $put[1], $put[2], $put[0]);
		}else{
			redirect('发布时间格式不对',$php_self.'?job=EXP&amp;action=addEXP');
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
			
			$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET title='".$title."',os='".$r_os."',be_type='".$type."',typeid='".$systype."',putime='".$putime."',bugexp='".$exp."' where id IN ('".$id."')");

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
					$DB->unbuffered_query("DELETE FROM {$db_prefix}sebug_data where id IN ($id)");
				}elseif ($do == 'type') {
					$systypeid= intval($_POST['systype']);		
					$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET typeid='".$systypeid."' WHERE id IN ($id)");
				}elseif ($do == 'check') {				
					$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET checked='1' WHERE id IN ($id)");
				}else {
					$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET checked='0' WHERE id IN ($id)");
				}
				redirect('操作完成',$php_self.'?job=EXP');
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
		$subnav = '信息列表';
		$wd = char_cv(trim($_POST['keywords']));
		$addquery ='';
		if ($do == 'search') {
			$addquery = " where title LIKE '%$wd%'";
		}
		$query = $DB->query("SELECT COUNT(*) as total FROM {$db_prefix}sebug_data$addquery");
		$rs = $DB->fetch_array($query);
		$exp_list_num = $rs['total'];
		if($exp_list_num){
			$page=(int)$_GET['page']; //取类页面值
			$pagenum = 10;
			if($page) {
				$start_limit = ($page - 1) * $pagenum;
			}else{
				$start_limit = 0;
				$page = 1;
			}
			$multipage = multi($exp_list_num,$pagenum,$page,$php_self.'?job=EXP');
			$sqlstr = $DB->query("SELECT id,attime,title,os,checked,be_type,Categories FROM {$db_prefix}sebug_data$addquery ORDER BY checked,id desc LIMIT $start_limit, ".$pagenum);
			$exp_listdb = array();
			while ($exp_list = $DB->fetch_array($sqlstr)){
				//去标题长度
				$exp_list['title'] = trimmed_title(trim($exp_list['title']),100);
				$exp_list['attime'] = date("Y-m-d,H:m:s",$exp_list['attime']);
				$exp_list['os'] = idtoos($exp_list['os']);
				$exp_list['type'] = idexp($exp_list['be_type']);
				$exp_listdb[] = $exp_list;
			}
		unset($exp_list);
		$DB->free_result($sqlstr);
		} else {
			redirect('没找到');
		}
	}

	if (in_array($action, array('addEXP', 'edit'))) {
		if ($action == 'addEXP') {
			$subnav = '添加Exploits信息';
		} else {
			$subnav = '编辑Exploits信息';
			$id = intval($_GET['zone']);
			$edit_exp = $DB->fetch_one_array("SELECT * FROM {$db_prefix}sebug_data WHERE Categories=0 AND id='".$id."'");
				$checked = $edit_exp['checked'];
				$edit_exp['putime'] = date("Y-m-d",$edit_exp['putime']);
		}
	}
	cpheader();
	include template('EXP');
	cpfooter();
}
?>