<?php
/******************************************
Info:SEBUG Security Database
Function:永久链接
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
// 设置永久连接
//1 = 永久连接
$permalink = '1';

if ($permalink == '1') {
	$vuldb_url = $url.'vuldb/';
	$expdb_url = $url.'expdb/';
	$show_no = $url.'nofound/';
	$search_url = $url.'?s1=s';
	$submit = $url.'submit.php';
	$cooperate_url = $url.'about/cooperate.html';
	$About_url = $url.'about/About.html';
	$js_url = $url.'about/js.html';
	$rss_url = $url.'rss.xml';
	$sitemap_url = $url.'sitemap.xml';
	$login_url = $url.'login/';
	$reg_url = $url.'register/';
	$user_url = $url.'author/';
	$profile_url = $url.'profile/';
	$addvul_url = $url.'addvul/';
	$addexp_url = $url.'addexp/';
	$appdir_url = $url.'appdir/';
	$appdir_vi_url = $url.'appdir/';
} else {
	$vuldb_url = $url.'index.php?s1=bug_list';
	$expdb_url = $url.'index.php?s1=exp_list';
	$show_no = $url.'index.php?s1=show_no';
	$search_url = $url.'index.php?s1=s';
	$submit = $url.'submit.php';
	$cooperate_url = $url.'index.php?s1=cooperate';
	$About_url = $url.'index.php?s1=About';
	$js_url = $url.'index.php?s1=js_show';
	$rss_url = $url.'rss.php';
	$sitemap_url = $url.'sitemap.php';
	$login_url = $url.'login.php?s1=login';
	$reg_url = $url.'login.php?s1=register';
	$user_url = $url.'login.php?s1=user&author=';
	$profile_url = $url.'login.php?s1=profile';
	$addvul_url = $url.'login.php?s1=addvul';
	$addexp_url = $url.'login.php?s1=addexp';
	$appdir_url = $url.'index.php?s1=appdir';
	$appdir_vi_url = $url.'index.php?s1=appview&d=';
}

function checkpermalink_bug($show_id){
	global $permalink,$url;
	if ($permalink == '1'){
		$to_url = $url.'vulndb/'.$show_id.'/';
	}else{
		$to_url = $url.'index.php?s1=show_bug&amp;v='.$show_id;
	}
	return $to_url;
}

function checkpermalink_exp($show_id){
	global $permalink,$url;
	if ($permalink == '1'){
		$to_url = $url.'exploit/'.$show_id.'/';
	}else{
		$to_url = $url.'index.php?s1=show_exp&amp;e='.$show_id;
	}
	return $to_url;
}
?>