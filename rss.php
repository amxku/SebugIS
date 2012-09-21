<?php
/******************************************
Info:SEBUG Security Database
Function:RSS输出
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
// 加载前台常用函数
require_once('./include/common.inc.php');
require_once(SEBUG_ROOT.'include/func/global.func.php');
require_once(SEBUG_ROOT.'include/func/permalink.func.php');
require_once(SEBUG_ROOT.'include/func/cache.func.php');

$rss_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_rss.jpg';
if(!is_file($rss_cachefile)){
	rss_recache();
}
include($rss_cachefile);
if($ontime - $rss_bu_time > 14400){
	rss_recache();
}
header("Content-Type: application/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<rss version=\"2.0\">\n";
echo "\t<channel>\n";
echo "\t\t<title>SEBUG.NET - 安全漏洞信息库</title>\n";
echo "\t\t<link>http://www.sebug.net</link>\n";
echo "\t\t<description>SEBUG Security Database - 致力于信息安全漏洞的研究及收集整理</description>\n";
echo "\t\t<copyright>Copyright (C) 2006 www.sebug.net All Rights Reserved.</copyright>\n";
echo "\t\t<language>zh</language>\n";

foreach ($rss_db as $key => $rss_rs) {
	echo "\t\t<item>\n";
	echo "\t\t\t<guid>".$rss_rs['to_url']."</guid>\n";
	echo "\t\t\t<title>".$rss_rs['title']."</title>\n";
	echo "\t\t\t<author>Sebug.net</author>\n";
	echo "\t\t\t<description><![CDATA[<p>sebug.net</p>".$rss_rs['title']."]]></description>\n";
	echo "\t\t\t<link>".$rss_rs['to_url']."</link>\n";
	echo "\t\t\t<pubDate>".$rss_rs['attime']."</pubDate>\n";
	echo "\t\t</item>\n";
}
echo "\t</channel>\n";
echo "</rss>\n";
?>