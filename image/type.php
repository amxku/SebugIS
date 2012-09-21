<?php
/******************************************
Info:SEBUG Security Database
Function:分类管理
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
	if ($action == 'add') {
		$type_name = htmlspecialchars(trim($_POST['type_name']));
		$type_info = htmlspecialchars(trim($_POST['type_info']));
		$website = htmlspecialchars(trim($_POST['website']));
		$checked = intval($_POST['checked']);
		$check_view = intval($_POST['check_view']);

		if (!$type_name) {
			redirect('分类名称',$php_self.'?job=type&amp;action=addtype');
		}
		if (!$type_info) {
			redirect('没有分类说明',$php_self.'?job=type&amp;action=addtype');
		}

		$r = $DB->fetch_one_array("SELECT typeid FROM {$db_prefix}type WHERE type_name='".$type_name."'");
		if($r['typeid']) {
			redirect('该分类已经登记过',$php_self.'?job=type&amp;action=addtype');
		}
	  
		$DB->query("INSERT INTO {$db_prefix}type (b_time,type_name,type_info,website,checked,check_view) VALUES ('".$ontime."','".$type_name."','".$type_info."','".$website."','".$checked."','".$check_view."')");
		checktype();
		index_appdir();
		redirect('添加成功',$php_self.'?job=type&amp;action=addtype');
	}

	if ($action == 'edit_save') {
		$id=(int)$_POST['zone'];
		$type_name = htmlspecialchars(trim($_POST['type_name']));
		$type_info = htmlspecialchars($_POST['type_info']);
		$website = htmlspecialchars(trim($_POST['website']));
		$checked = intval($_POST['checked']);
		$check_view = intval($_POST['check_view']);

		if($id){
			// 更新数据
			$DB->unbuffered_query("UPDATE {$db_prefix}type SET type_name='".$type_name."',type_info='".$type_info."',website='".$website."',checked='".$checked."',check_view='".$check_view."' where typeid IN ('".$id."')");
			checktype();
			index_appdir();
			redirect('编辑完毕',$php_self.'?job=type');
		} else {
			redirect('未选择信息');
		}
	}

	if ($action == 'domore') {
		$do = char_cv($_GET['do']);
			!$do && $do = char_cv($_POST['do']);
		if (in_array($do,array('check','nocheck','delete','noview','view'))) {
			$id = intval($_GET['zone']);
				!$id && $id = implode_ids($_POST['zone']);
			if ($id) {
				if ($do == 'delete') {
					$DB->unbuffered_query("DELETE FROM {$db_prefix}type where typeid IN ($id)");
					checktype();
					index_appdir();
				} elseif ($do == 'check') {				
					$DB->unbuffered_query("UPDATE {$db_prefix}type SET checked='1' WHERE typeid IN ($id)");
					checktype();
					index_appdir();
				}elseif ($do == 'view') {				
					$DB->unbuffered_query("UPDATE {$db_prefix}type SET check_view='1' WHERE typeid IN ($id)");
					checktype();
					index_appdir();
				}elseif ($do == 'noview') {				
					$DB->unbuffered_query("UPDATE {$db_prefix}type SET check_view='0' WHERE typeid IN ($id)");
				} else {
					$DB->unbuffered_query("UPDATE {$db_prefix}type SET checked='0' WHERE typeid IN ($id)");
				}
				redirect('操作完成',$php_self.'?job=type');
			} else {
				redirect('未选择信息');
			}
		} else {
			redirect('未选择任何操作');
		}
	}

	if ($action == 'type_updata') {
			// 更新数量
			/////////////////////		
			$step		  = (!$step) ? 1 : $step;
			$percount = ($percount <= 0) ? 100 : $percount;
			$start    = ($step - 1) * $percount;
			$next     = $start + $percount;
			$step++;
			$jumpurl  = $php_self.'?job=type&action=type_updata&step='.$step.'&percount='.$percount;
			$goon     = 0;
			$query 		= $DB->query("SELECT typeid FROM {$db_prefix}type WHERE checked='1' ORDER BY typeid LIMIT $start, $percount");
			while ($ty_list = $DB->fetch_array($query)) {
				$goon = 1;
				// 更新所有用户的上报数
				$tatol = $DB->result($DB->query("SELECT COUNT(*) FROM {$db_prefix}sebug_data where checked='1' AND typeid='".$ty_list['typeid']."'"), 0);
				$DB->unbuffered_query("UPDATE {$db_prefix}type SET v_num='$tatol' WHERE typeid='".$ty_list['typeid']."'");
			}
			if($goon){
				redirect('正在更新 '.$start.' 到 '.$next.' 项', $jumpurl, '2');
			} else{
				checktype();
				index_appdir();
				redirect('成功更新分类数据', $php_self.'?job=type');
			}
			/////////////////////
		}
	if (!$action) {
		$action = 'list';
	}

	if ($action == 'list') {
		$subnav = '分类列表';

		$wd = char_cv($_POST['keywords']);
		$addquery ='';
		if ($do == 'search') {
			$addquery = " where type_name LIKE '%$wd%'";
		}
		$gettop = intval($_GET['top']);
		if ($gettop == '1') {
			$ord_by_query = ' ORDER BY v_num DESC LIMIT ';
		}else{
			$ord_by_query = ' ORDER BY checked,typeid DESC LIMIT ';
		}
		$query = $DB->query("SELECT COUNT(*) as total FROM {$db_prefix}type$addquery");
		$rs = $DB->fetch_array($query);
		$type_list_num = $rs['total'];
		if($type_list_num){
			$page=(int)$_GET['page']; //取类页面值
			$pagenum = 10;
			if($page) {
				$start_limit = ($page - 1) * $pagenum;
			}else{
				$start_limit = 0;
				$page = 1;
			}
			$multipage = multi($type_list_num,$pagenum,$page,$php_self.'?job=type&top='.$gettop);
			$sqlstr = $DB->query("SELECT * FROM {$db_prefix}type$addquery$ord_by_query $start_limit, ".$pagenum);
			$type_listdb = array();
			while ($type_list = $DB->fetch_array($sqlstr)){
				//去标题长度
				$type_list['type_info'] = trimmed_title(trim($type_list['type_info']),40);
				$type_list['b_time'] = date("Y-m-d",$type_list['b_time']);
				$checktype_type_name = char_cv($type_list['type_name']);
				$type_list['type_name_url'] = str_replace(" ", "+" , $checktype_type_name);
				$type_listdb[] = $type_list;
			}
		unset($type_list);
		$DB->free_result($sqlstr);
		} else {
			redirect('未选择信息');
		}
	}

	if (in_array($action, array('addtype', 'edit'))) {
		if ($action == 'addtype') {
			$subnav = '添加分类';
		} else {
			$subnav = '编辑分类';
			$id = intval($_GET['zone']);

			$edit_type = $DB->fetch_one_array("SELECT * FROM {$db_prefix}type WHERE typeid='".$id."'");
				$checked = $edit_type['checked'];
				$check_view = $edit_type['check_view'];
		}
	}
	cpheader();
	include template('type');
	cpfooter();
}
?>