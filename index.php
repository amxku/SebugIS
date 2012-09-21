<?php
/******************************************
Info:SEBUG Security Database
Function:前台主页
Author:amxku
date:2008/10/18
site:http://www.sebug.net
=================CHANGELOG=================
*******************************************/
require ('./include/common.inc.php');
require(SEBUG_ROOT.'include/func/front.func.php');
include language('templates');

$pagefile = '';
!$s1 && $s1 = 'index';
!$options['title']  && $options['title'] = 'SEBUG.NET';
!$options['meta_keywords']  && $options['meta_keywords'] = $language['sebug_meta_keywords'];
!$options['meta_description'] && $options['meta_description'] = $language['sebug_meta_description'];

$pagenum = '20';

//****index****
if ($s1 == 'index') {
	$pagefile = 'main';

//****list****
}elseif ($s1 == 'bug_list') {
	$os=(int)$_GET['o'];
	$type=(int)$_GET['t'];
	!$os  && $os = '0';
	!$type  && $type = '0';
	$showtype = '';
	if($os){
		$showtype = " AND os IN ('".$os."')";
	}if($type){
		$showtype = " AND be_type IN ('".$type."')";
	}if(0!=$type AND 0!=$os){
		$showtype = " AND be_type IN ('".$type."') AND os IN ('".$os."')";
	}
	$query = $DB->query("SELECT COUNT(*) as total FROM {$db_prefix}sebug_data where checked=1$showtype");
	$rs = $DB->fetch_array($query);
	$bug_list_num = $rs['total'];
	if($bug_list_num){
		$t_os = idtoos($os);
		$t_type = idexp($type);
		$page=(int)$_GET['page']; //取类页面值
		if($page) {
			$start_limit = ($page - 1) * $pagenum;
			$options['title'] = trim($t_os.' '.$t_type.' '.$language['sebug_title_Vulndb'].' [ '.checkpage($bug_list_num,$pagenum,$page).' ]').' - SEBUG.NET';
		}else{
			$start_limit = 0;
			$page = 1;
			$options['title'] = trim($t_os.' '.$t_type.' '.$language['sebug_title_Vulndb']).' - SEBUG.NET';
		}
		$multipage = multi($bug_list_num,$pagenum,$page,$vuldb_url.'page/'.$os.'/'.$type.'/');
		$sqlstr = $DB->query("SELECT id,attime,title,Categories FROM {$db_prefix}sebug_data where checked=1$showtype ORDER BY id desc LIMIT $start_limit, ".$pagenum);
		$bug_listdb = array();
		while ($bug_list = $DB->fetch_array($sqlstr)){
			//去标题长度
			$bug_list['title'] = trimmed_title(trim($bug_list['title']),$title_long);
			$bug_list['attime'] = date("Y-m-d",$bug_list['attime']);
			if($bug_list['Categories']){
					$bug_list['to_url'] = checkpermalink_bug($bug_list['id']);
				}else{
					$bug_list['to_url'] = checkpermalink_exp($bug_list['id']);
				}
			$bug_listdb[] = $bug_list;
		}

		unset($bug_list);
		$DB->free_result($query);
		$DB->free_result($sqlstr);
	}else{
		Header('Location:'.$show_no);
	}
	$pagefile = 'bug_list';
	$options['meta_keywords'] = $language['sebug_meta_keywords_bugslist'];
	$options['meta_description'] = $language['sebug_meta_description_bugslist'];

//****show_bug****
}elseif ($s1 == 'show_bug') {
	$id = (int)$_GET['v'];
	$chd = htmlspecialchars(trim($_GET['ch']));
	if($id){
		if($chd == 'amxku'){
			$show_b_query = $DB->query("SELECT id,os,title,attime,putime,Impact,buginfo,reference,bugexp,ress,be_type,uid,typeid FROM {$db_prefix}sebug_data where Categories=1 AND id IN ('".$id."')");
		}else{
			$show_b_query = $DB->query("SELECT id,os,title,attime,putime,Impact,buginfo,reference,bugexp,ress,be_type,uid,typeid FROM {$db_prefix}sebug_data where Categories=1 AND checked IN ('1') AND id IN ('".$id."')");
		}
		$show_bug = $DB->fetch_array($show_b_query);
		if($show_bug['id']){
			$show_os = idtoos($show_bug['os']);
			$show_type = idexp($show_bug['be_type']);
			$show_title = trim($show_bug['title']);
			$show_p_attime = date("Y-m-d",$show_bug['attime']);
			$show_bug['putime'] = date("Y-m-d",$show_bug['putime']);
			$show_bug['to_url'] = checkpermalink_bug($show_bug['id']);
			$uid = (int)$show_bug['uid'];
				if($uid){
					$u_query = $DB->query("SELECT username,email FROM {$db_prefix}users where userid IN ('".$uid."')");
					$u_rs = $DB->fetch_array($u_query);
					if($u_rs['username']){
						$u_name = urlencode($u_rs['username']);
						$u_email = check_mail($u_rs['email']);
					}
				}
			//////////分类信息
			$type_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_checktype.jpg';
			if(!is_file($type_cachefile)){
				checktype();
			}
			$checktype = $checktype_db = array();
			include($type_cachefile);
			foreach ($checktype_db as $key => $checktype) {
				if($checktype['typeid'] == $show_bug['typeid']){
					$checktype_type_name = char_cv($checktype['type_name']);
					$checktype_type_url = str_replace(" ", "+" , $checktype_type_name);
				}
			}
			unset($checktype);		
			//////////分类信息
		}else{
			Header('Location:'.$show_no);
		}
		$pagefile = 'article_bug';
		$options['title'] = $show_bug['id'].': '.trim($show_title);
		$options['meta_keywords'] = $show_os.','.$show_type.','.$language['sebug_meta_keywords_bugslist'];
		$options['meta_description'] = $show_title.','.$show_os.','.$show_type;
		$DB->free_result($show_b_query);
	}else{
		Header('Location:'.$show_no);
	}

//****show_exp****
}elseif ($s1 == 'show_exp') {
	$id = (int)$_GET['e'];
	$chd = htmlspecialchars(trim($_GET['ch']));
	if($id){
		if($chd == 'amxku'){
			$show_e_query = $DB->query("SELECT id,be_type,title,putime,attime,bugexp,uid,typeid FROM {$db_prefix}sebug_data where Categories=0 AND id IN ('".$id."')");
		}else{
			$show_e_query = $DB->query("SELECT id,be_type,title,putime,attime,bugexp,uid,typeid FROM {$db_prefix}sebug_data where Categories=0 AND id IN ('".$id."') and checked IN ('1')");
		}
		$show_exp = $DB->fetch_array($show_e_query);
		if($show_exp['id']){
			$show_exp_title = trim($show_exp['title']);
			$show_exp_os = idexp($show_exp['be_type']);
			$show_p_attime = date("Y-m-d",$show_exp['attime']);
			$show_exp['putime'] = date("Y-m-d",$show_exp['putime']);
			$show_exp['to_url'] = checkpermalink_exp($show_exp['id']);
			$uid = (int)$show_exp['uid'];
			if($uid){
				$u_query = $DB->query("SELECT username,email FROM {$db_prefix}users where userid IN ('".$uid."')");
				$u_rs = $DB->fetch_array($u_query);
				if($u_rs['username']){
					$u_name = urlencode($u_rs['username']);
					$u_email = check_mail($u_rs['email']);
				}
			}
			//////////分类信息
			$type_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_checktype.jpg';
			if(!is_file($type_cachefile)){
				checktype();
			}
			$checktype = $checktype_db = array();
			include($type_cachefile);
			foreach ($checktype_db as $key => $checktype) {
				if($checktype['typeid'] == $show_exp['typeid']){
					$checktype_type_name = char_cv($checktype['type_name']);
					$checktype_type_url = str_replace(" ", "+" , $checktype_type_name);
				}
			}
			unset($checktype);
			//////////分类信息
		}else{
			Header('Location:'.$show_no);
		}
		$pagefile = 'article_exp';
		$options['title'] = $show_exp['id'].': '.trim($show_exp_title);
		$options['meta_keywords'] = $show_exp_os.','.$language['sebug_meta_keywords_explist'];
		$options['meta_description'] = $show_exp_title.','.$show_exp_os;
		$DB->free_result($show_e_query);
	}else{
		Header('Location:'.$show_no);
	}

//****show_no****
}elseif ($s1 == 'show_no') {
	header('HTTP/1.1 404 Not Found');
	$show_no_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_show_no.jpg';
	if(!is_file($show_no_cachefile)){
		show_no_recache();
	}
	//////////最新漏洞
	include($show_no_cachefile);
	foreach ($show_no_db as $key => $show_no) {
		//
	}
	$pagefile = 'show_no';
	$options['title'] = $language['sebug_no_title'];

//****search****
}elseif ($s1 == 's') {
	//判断关键字
	$wd = char_cv(trim($_GET['w']));
	if ($wd){
		$pagenum1 = '22';
		$sea_query = $DB->query("SELECT COUNT(*) as total FROM {$db_prefix}sebug_data where checked=1 AND (title LIKE '%".$wd."%' OR id LIKE '%".$wd."%')");
		$ser_rs = $DB->fetch_array($sea_query);
		$search_num = $ser_rs['total'];
		// 如果没有记录
		if ($search_num <= 0){
			Header('Location:http://s1.sebug.net/?cx=018356698781290416774%3Ajk5udkluq_4&cof=FORID%3A9&ie=UTF-8&q='.$wd);
		}else{
			$page=(int)$_GET['page']; //取类页面值
			if($page){
				$start_limit = ($page - 1) * $pagenum1;
				$options['title'] = trim($wd.' [ '.checkpage($search_num,$pagenum1,$page).' ]  - Sebug Search');
			}else{
				$start_limit = 0;
				$page = 1;
				$options['title'] = trim($wd.' - Sebug Search');
			}
			$multipage = multi($search_num,$pagenum1,$page,"$search_url&amp;w=$wd");
			$sea_sqlstr = $DB->query("SELECT id,Categories,title,attime FROM {$db_prefix}sebug_data where checked=1 AND (title LIKE '%".$wd."%' OR id LIKE '%".$wd."%') ORDER BY id DESC LIMIT $start_limit,".$pagenum1);
			$show_searchdb = array();
			while ($show_search = $DB->fetch_array($sea_sqlstr)){
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
			$DB->free_result($sea_sqlstr);
			$DB->free_result($sea_query);
			$pagefile = 'search';
		}
	}else{
		Header('Location:'.$show_no);
	}

//****cooperate****
}elseif ($s1 == 'cooperate') {

	$pagefile = 'cooperate';
	$options['title'] = $language['sebug_title_Partner'].' - SEBUG.NET';

//****help****
}elseif ($s1 == 'About') {

	$pagefile = 'About';
	$options['title'] = $language['sebug_title_about'].' - SEBUG.NET';


//****js_show****
}elseif ($s1 == 'js_show') {
	$pagefile = 'js_show';
	$options['title'] = $language['sebug_title_js'].' - SEBUG.NET';

//****app dir list****
}elseif ($s1 == 'appdir') {
	$options['title'] = $language['sebug_title_appdir'].' - SEBUG.NET';
	$options['meta_keywords'] = 'appdir,厂商目录,'.$language['sebug_meta_keywords_bugslist'];
	$options['meta_description'] = 'appdir,厂商目录,'.$language['sebug_meta_description_bugslist'];
	
	//读取缓存
	$index_appdir_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_index_appdir.jpg';
	if(!is_file($index_appdir_cachefile)){
		index_appdir();
	}
	include($index_appdir_cachefile);
 	include(SEBUG_ROOT.'include/func/piny_appdir.func.php'); //载入拼音转换类
/**
 * 厂商目录，按首字母归类，模仿http://www.google.cn/music/artistlibrary?region=cn&type=female
 * amxku@sebug.net
 * 2009-05-08
**/
 	if($index_appdir_db){
		$zmdata = array();
		if(is_array($index_appdir_db)) {
			foreach ($index_appdir_db as $name) {
				$zm = strtoupper(keyp_y($name));
				$zmdata[$zm][] = $name;
			}
		}
		foreach($zmdata as $k => $v) {
			//pr($k);
			foreach($v as $key => $val) {
				//pr($val);
			}
		}
	} else {
		Header('Location:'.$show_no);
	}
	$pagefile = 'appdir';
	
//****app dir show****
}elseif ($s1 == 'appview') {
	$getd = char_cv($_GET['d']);
	$id = str_replace("+", " " , $getd);
	if($id){
		$show_e_query = $DB->query("SELECT * FROM {$db_prefix}type where checked=1 AND type_name IN ('".$id."')");
		$show_type = $DB->fetch_array($show_e_query);
		if($show_type['typeid']){
				$show_type_title = trim($show_type['type_name']);
				$uid = (int)$show_type['uid'];
					if($uid){
						$u_query = $DB->query("SELECT username,email FROM {$db_prefix}users where userid IN ('".$uid."')");
						$u_rs = $DB->fetch_array($u_query);
						if($u_rs['username']){
							$u_name = urlencode($u_rs['username']);
							$u_email = check_mail($u_rs['email']);
						}
					}
			$app_sqlstr = $DB->query("SELECT id,Categories,title,attime FROM {$db_prefix}sebug_data where checked=1 AND typeid IN ('".$show_type['typeid']."') ORDER BY id DESC");
			$show_appdb = array();
			while ($show_applist = $DB->fetch_array($app_sqlstr)){
				$show_applist['title'] = trimmed_title(trim($show_applist['title']),$title_long);
				$show_applist['attime'] = date("Y-m-d",$show_applist['attime']);
				if($show_applist['Categories']){
					$show_applist['to_url'] = checkpermalink_bug($show_applist['id']);
				}else{
					$show_applist['to_url'] = checkpermalink_exp($show_applist['id']);
				}
				$show_appdb[] = $show_applist;
			}
			unset($show_applist);
			$DB->free_result($app_sqlstr);
			unset($type_list);
			$DB->free_result($show_e_query);
		} else {
			Header('Location:'.$show_no);
		}
	} else {
		Header('Location:'.$show_no);
	}
	$pagefile = 'appview';
	$options['title'] = $show_type_title.' - SEBUG.NET';
	$options['meta_keywords'] = $show_type_title.','.$language['appview_Chart'].','.$language['sebug_meta_keywords_bugslist'];
	$options['meta_description'] = trimmed_title(str_replace("\r\n", "",trim($show_type['type_info'])),50);
}else {
	Header('Location:'.$show_no);
}
include template($pagefile);
footer();
?>