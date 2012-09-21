<?php
// 本文件说明：缓存相关函数
if(!defined('SEBUG_ROOT')) {
	exit('Access Denied');
}
// 生成最新收录缓存文件
function show_no_recache(){
	global $title_long,$DB,$db_prefix;
	$sqlstr = $DB->query("SELECT id,Categories,title,attime FROM {$db_prefix}sebug_data where checked=1 ORDER BY id DESC LIMIT 0,18");
	$show_no_db = array();
	while ($show_no = $DB->fetch_array($sqlstr)){
		//去标题长度
		$show_no['title'] = trimmed_title(trim($show_no['title']),$title_long);
		$show_no['attime'] = date("Y-m-d",$show_no['attime']);
		if($show_no['Categories']){
			$show_no['to_url'] = checkpermalink_bug($show_no['id']);
		}else{
			$show_no['to_url'] = checkpermalink_exp($show_no['id']);
		}
		$show_no_db[] = $show_no;
	}
	$contents = "\$show_no_db = array(\r\n";
	foreach($show_no_db as $show_no) {
		$contents.="\t'".addslashes($show_no['id'])."'  => array(\r\t\t'attime' => '".addslashes($show_no['attime'])."',\r\t\t'title' =>'".addslashes($show_no['title'])."',\r\t\t'to_url' => '".addslashes($show_no['to_url'])."',\r\t),\r\n";
	}//end
	$contents .= ');';
	writetocache('show_no',$contents);
	unset($show_no);
	$DB->free_result($sqlstr);
}

// 生成rss缓存文件
function rss_recache(){
	global $DB,$db_prefix,$ontime;
	$sqlstr = $DB->query("SELECT id,Categories,title,attime FROM {$db_prefix}sebug_data where checked=1 ORDER BY id DESC LIMIT 0,40");
	$rss_db = array();
	while ($rss_rs = $DB->fetch_array($sqlstr)){
		$rss_rs['title'] = htmlspecialchars(trim($rss_rs['title']),ENT_QUOTES);
		$rss_rs['attime'] = date("Y-m-d",$rss_rs['attime']);
		if($rss_rs['Categories']){
			$rss_rs['to_url'] = checkpermalink_bug($rss_rs['id']);
		}else{
			$rss_rs['to_url'] = checkpermalink_exp($rss_rs['id']);
		}
		$rss_db[] = $rss_rs;
	}
	$contents = "\$rss_bu_time = '".addslashes($ontime)."';\r\n\$rss_db = array(\r\n";
	foreach($rss_db as $rss_rs) {
		$contents.="\t'".addslashes($rss_rs['id'])."'  => array(\r\t\t'attime' => '".addslashes($rss_rs['attime'])."',\r\t\t'title' =>'".addslashes($rss_rs['title'])."',\r\t\t'to_url' => '".addslashes($rss_rs['to_url'])."',\r\t),\r\n";
	}
	$contents .= ');';
	writetocache('rss',$contents);
	unset($rss_rs);
	$DB->free_result($sqlstr);
}

// 生成js缓存文件
function js_recache($viewmode,$limit,$length){
	global $DB,$db_prefix,$ontime;	
	$sqlstr = $DB->query("SELECT id,Categories,title,attime FROM {$db_prefix}sebug_data where checked=1 ORDER BY id DESC LIMIT 0,".$limit);
	$rsdb = array();
	while ($rs = $DB->fetch_array($sqlstr)){
		$rs['title'] = trimmed_title($rs['title'],$length);
		$rs['attime'] = date("Y-m-d",$rs['attime']);
		if($rs['Categories']){
			$rs['to_url'] = checkpermalink_bug($rs['id']);
		}else{
			$rs['to_url'] = checkpermalink_exp($rs['id']);
		}
		$rsdb[] = $rs;
	}
	$contents = "\$js_bu_time = '".addslashes($ontime)."';\r\n\$js_db = array(\r\n";
	foreach($rsdb as $rs) {
		$contents.="\t'".addslashes($rs['id'])."'  => array(\r\t\t'title' =>'".addslashes($rs['title'])."',\r\t\t'to_url' => '".addslashes($rs['to_url'])."',\r\t),\r\n";
	}//end
	$contents .= ');';
	pr($viewmode);
	$js_file = 'js_'.$viewmode.'_'.$limit.'_'.$length;
	writetocache($js_file,$contents);
	unset($rs);
	$DB->free_result($sqlstr);
}

// 生成地图缓存文件
function sitemap(){
	global $DB,$db_prefix,$ontime;
	$sqlstr = $DB->query("SELECT id,Categories,title,attime FROM {$db_prefix}sebug_data where checked=1 ORDER BY id DESC");
	$rsdb = array();
	while ($rs = $DB->fetch_array($sqlstr)){
		$rs['attime'] = date("Y-m-d",$rs['attime']);
		if($rs['Categories']){
			$rs['to_url'] = checkpermalink_bug($rs['id']);
		}else{
			$rs['to_url'] = checkpermalink_exp($rs['id']);
		}
		$rsdb[] = $rs;
	}
	$contents = "\$sitemap_bu_time = '".addslashes($ontime)."';\r\n\$sitemap_db = array(\r\n";
	foreach($rsdb as $rs) {
		$contents.="\t'".addslashes($rs['id'])."'  => array(\r\t\t'attime' => '".addslashes($rs['attime'])."',\r\t\t'to_url' => '".addslashes($rs['to_url'])."',\r\t),\r\n";
	}//end
	$contents .= ');';
	writetocache('sitemap',$contents); 
	unset($rs);
	$DB->free_result($sqlstr);
}

// 生成分类缓存文件
function checktype(){
	global $DB,$db_prefix,$ontime;
	$query = $DB->query("SELECT COUNT(*) as total FROM {$db_prefix}type where checked=1");
	$rs = $DB->fetch_array($query);
	$type_total = $rs['total'];
	
	$type_sqlstr = $DB->query("SELECT type_name,typeid,v_num,b_time FROM {$db_prefix}type where checked=1 ORDER BY type_name ASC");
	$type_listdb = array();
	while ($type_list = $DB->fetch_array($type_sqlstr)){
		$type_list['b_time'] = date("Y-m-d",$type_list['b_time']);
		$type_listdb[] = $type_list;
	}
	$contents = "\$checktype_bu_time = '".addslashes($ontime)."';\r\n\$type_total = '".addslashes($type_total)."';\r\n\$checktype_db = array(\r\n";
	foreach($type_listdb as $type_list) {
		$contents.="\t'".addslashes($type_list['typeid'])."'  => array(\r\t\t'typeid' =>'".addslashes($type_list['typeid'])."',\r\t\t'type_name' => '".addslashes($type_list['type_name'])."',\r\t\t'b_time' => '".addslashes($type_list['b_time'])."',\r\t\t'v_num' => '".addslashes($type_list['v_num'])."',\r\t),\r\n";
	}//end
	$contents .= ');';
	writetocache('checktype',$contents); 
	unset($type_list);             
	$DB->free_result($type_sqlstr);
}

// 生成appdir缓存文件
function index_appdir(){
	global $DB,$db_prefix,$ontime;
	$type_sqlstr = $DB->query("SELECT type_name FROM {$db_prefix}type where checked=1 ORDER BY type_name ASC");
	$type_listdb = array();
	while ($type_list = $DB->fetch_array($type_sqlstr)){
		$type_listdb[] = $type_list;
	}
	$contents = "\$index_appdir_db = array(";
	foreach($type_listdb as $type_list) {
		$contents.="'".addslashes($type_list['type_name'])."',";
	}
	$contents .= ');';
	writetocache('index_appdir',$contents); 
	unset($type_list);             
	$DB->free_result($type_sqlstr);
}

// 写入缓存文件
function writetocache($cachename,$cachedata = '') {
	global $limit,$length,$js_file,$ontime;
	if(in_array($cachename, array('show_no','show_no_jb','sitemap','rss','js_1_'.$limit.'_'.$length,'js_2_'.$limit.'_'.$length,'checktype','index_appdir'))) {
		$cachedir = SEBUG_ROOT.'forumdata/sebug_cache/';
		$cachefile = $cachedir.'cache_'.$cachename.'.jpg';
			if(!is_dir($cachedir)) {
				@mkdir($cachedir, 0777);
			}
			$cachedata = "<?php\r//SEBUG.NET cache file\r//Created on ".date('Y-m-d H:i:s',$ontime)."\r\n\r\n".$cachedata."\r\n\r?>";
			if (!writefile($cachefile,$cachedata)) {
				exit('Can not write to '.$cachename.' cache files, please check directory ./cache/ .');
			}
	}
}

?>