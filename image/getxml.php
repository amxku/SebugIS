<?php
/******************************************
Info:SEBUG Security Database
Function:ajax 提交数据
Author:amxku
date:2009/05/05
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
require ('../include/common.inc.php');
require (SEBUG_ROOT.'include/func/admin.func.php');

if ($action == 'type') {
	$item = intval($_GET['item']);
	$html = '<div>';
	if ($item) {
		$show_no_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_checktype.jpg';
		if(!is_file($show_no_cachefile)){
			checktype();
		}
		include($show_no_cachefile);
		$html .= '<form name="check_type">';
		$html .= 'id：<input name="ne_id" type="test" style="width:40px;"/>';
		$html .= '<br />';
		$html .= '<select name="typeid" id="typeid">';
		$html .= '<option value="0">系统目录</option>';
			foreach ($checktype_db as $key => $type_list) {
			$html .= '<option value='.$type_list['typeid'].'>'.$type_list['type_name'].'</option>';
			}
    $html .= '</select> - <a href="javascript:;" onclick="showaddtype(\'777\');return false;">添加新目录</a>';
    $html .= '<br />';
    $html .= '<input name="bugid" value="'.$item.'" type="hidden" />';
    $html .= '<input type="button" value="提交" onClick="save_typecheck()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="关闭" onClick="$(\'ajax-div-tagshow\').style.display=\'none\';">';
    $html .= '</form>';
    //提交后，不能自动关闭，奶奶的
	} else {
		$html .= '没有分类';
	}
	$html .= '</div>';
	xmlmsg($html);
}

if ($action == 'checktype') {
		$bugid = intval($_POST['bugid']);
		$typeid = intval($_POST['typeid']);
		$ne_id = intval($_POST['ne_id']);
		if($ne_id){
			$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET typeid='".$typeid."' WHERE id='".$ne_id."'");
			echo $ne_id;
		}else{
			$DB->unbuffered_query("UPDATE {$db_prefix}sebug_data SET typeid='".$typeid."' WHERE id='".$bugid."'");
			echo $bugid;
		}
}

//添加目录
if ($action == 'addtype') {
	$item = intval($_GET['item']);
	$html = '<div>';
	if ($item) {
		$html .= '<form name="check_type">';
		$html .= '分类名称:<input name="type_name" style="width:400px;" maxlength="100" type="text" value="" />';
		$html .= '官方网站:<input name="website" style="width:400px;" maxlength="100" type="text" value="http://" />';
		$html .= '分类说明:<textarea name="type_info" style="width:400px;" rows="8" id="type_info"></textarea>';
		$html .= '<select name="t_checked" id="t_checked"><option value="0">不审核</option><option value="1">审核</option></select>';
		$html .= '<br />';
		$html .= '<select name="check_view" id="check_view"><option value="0">不显示走势图</option><option value="1">显示走势图</option></select>';
		$html .= '<br />';
    $html .= '<input name="item" value="'.$item.'" type="hidden" />';
    $html .= '<input type="button" value="提交" onClick="save_type()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="关闭" onClick="$(\'ajax-div-tagshow\').style.display=\'none\';">';
    $html .= '</form>';
	}
	$html .= '</div>';
	xmlmsg($html);
}

//添加保存目录
if ($action == 'doaddtype') {
		$type_name = htmlspecialchars(trim($_POST['type_name']));
		$website = htmlspecialchars(trim($_POST['website']));
		$type_info = htmlspecialchars(trim($_POST['type_info']));
		$checked = intval($_POST['t_checked']);
		$check_view = intval($_POST['check_view']);
		$item = intval($_POST['item']);
		
		if (!$type_name) {
			echo '分类名称';
		}elseif (!$type_info) {
			echo '没有分类说明';
		}
		$r = $DB->fetch_one_array("SELECT typeid FROM {$db_prefix}type WHERE type_name='".$type_name."'");
		if($r['typeid']) {
			echo '该分类已经登记过';
		}
		$DB->query("INSERT INTO {$db_prefix}type (b_time,type_name,type_info,website,checked,check_view) VALUES ('".$ontime."','".$type_name."','".$type_info."','".$website."','".$checked."','".$check_view."')");
		checktype();
		if($item == '576'){
			header('Location: '.$url.'admin.php?job=EXP&action=addEXP');
		}elseif($item == '675'){
			header('Location: '.$url.'admin.php?job=BUG&action=addbug');
		}else{
			header('Location: '.$url.'admin.php?job=EXP');
		}
}

function xmlmsg($html) {
	@header("Content-Type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<root><![CDATA[".$html."]]></root>\n";
}
?>