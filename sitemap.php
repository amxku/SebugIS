<?php
/******************************************
Info:SEBUG Security Database
Function:sitemap输出
Author:amxku
date:2006/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
// 加载前台常用函数
require_once('./include/common.inc.php');
require_once(SEBUG_ROOT.'include/func/global.func.php');
require_once(SEBUG_ROOT.'include/func/permalink.func.php');
require_once(SEBUG_ROOT.'include/func/cache.func.php');

$sitemap_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_sitemap.jpg';
if(!is_file($sitemap_cachefile)){
	sitemap();
}
include($sitemap_cachefile);
if($ontime - $sitemap_bu_time > 9000){
	sitemap();
}

//////////分类信息
$type_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_checktype.jpg';
if(!is_file($type_cachefile)){
	checktype();
}
$checktype = $checktype_db = array();
include($type_cachefile);

header("Content-Type: application/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";

foreach ($sitemap_db as $key => $sitemap_rs) {
	echo "\t<url>\n";
	echo "\t\t<loc>".$sitemap_rs['to_url']."</loc>\n";
	echo "\t\t<lastmod>".$sitemap_rs['attime']."</lastmod>\n";
	echo "\t\t<changefreq>monthly</changefreq>\n";
	echo "\t\t<priority>0.2</priority>\n";
	echo "\t</url>\n";
}
foreach ($checktype_db as $key => $checktype) {
	$checktype_type_name = char_cv($checktype['type_name']);
	$checktype_type_url = str_replace(" ", "+" , $checktype_type_name);
	echo "\t<url>\n";
	echo "\t\t<loc>".$appdir_vi_url."".$checktype_type_url."/</loc>\n";
	echo "\t\t<lastmod>".$checktype['b_time']."</lastmod>\n";
	echo "\t\t<changefreq>monthly</changefreq>\n";
	echo "\t\t<priority>0.2</priority>\n";
	echo "\t</url>\n";
}
echo "</urlset>\n";
?>