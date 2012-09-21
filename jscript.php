<?php
/******************************************
Info:SEBUG Security Database
Function:JS输出
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
//加载公共函数
require_once ('./include/common.inc.php');
require_once(SEBUG_ROOT.'include/func/global.func.php');
require_once(SEBUG_ROOT.'include/func/permalink.func.php');
require_once(SEBUG_ROOT.'include/func/cache.func.php');

//显示模式
$viewmode = (int)$_GET['V'];
//标题长度
$length = (int)$_GET['L'];
//调用数量
$limit = (int)$_GET['T'];

//设置默认值
!$length  && $length = '60';
!$limit  && $limit = '8';
!$viewmode  && $viewmode = '1';

if($viewmode == '1'){
?>
	document.writeln("<html>");
	document.writeln("<head>");
	document.writeln("<meta http-equiv='content-type' content='text/html; charset=utf-8'>");
	document.writeln("</head>");
	document.writeln("<body>");
<?
	$js_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_js_1_'.$limit.'_'.$length.'.jpg';
	if(!is_file($js_cachefile)){
		js_recache(1,$limit,$length);
	}
	include($js_cachefile);
	if($ontime - $js_bu_time > 14400){
		js_recache($viewmode,$limit,$length);
	}
	foreach ($js_db as $key => $js_rs) {
		echo "document.writeln(\"<a href='".$js_rs['to_url']."' title='".$js_rs['title']."' target='_blank'>".$js_rs['title']."</a><br>\");";
	}
?>
	document.writeln("</body>");
	document.writeln("</html>");
<?
}elseif($viewmode == '2'){
?>
	document.writeln("<html>");
	document.writeln("<head>");
	document.writeln("<meta http-equiv='content-type' content='text/html; charset=utf-8'>");
	document.writeln("</head>");
	document.writeln("<body>");
	document.writeln("<div id='sebug_list'><TABLE cellSpacing='0' cellPadding='0' border='0'><TR><TD><TABLE cellSpacing='0' cellPadding='0' border='0'>");
<?
	$js_cachefile = SEBUG_ROOT.'forumdata/sebug_cache/cache_js_2_'.$limit.'_'.$length.'.jpg';
	if(!is_file($js_cachefile)){
		js_recache(2,$limit,$length);
	}
	include($js_cachefile);
	if($ontime - $js_bu_time > 14400){
		js_recache($viewmode,$limit,$length);
	}
	foreach ($js_db as $key => $js_rs) {
		echo "document.writeln(\"<TR><TD height='19'><a href='".$js_rs['to_url']."' title='".$js_rs['title']."' target='_blank'>".$js_rs['title']."</a></TD></TR>\");";
	}
?>
	document.writeln("</TABLE></TD></TR></TABLE></DIV>");

	/*定义常量(可根据实际情况做调整)*/
	marqueetable = document.getElementById('sebug_list');
	scrollheight=19;//滚动高度
	scrollline=4;//滚动内容的行数 
	scrolltimeout=60;//滚动刷新的时间(毫秒)
	//滚动停留时检测的次数,
	//scrollstoptimes*scrolltimeout为实际的停留时间 
	scrollstoptimes=40;

	/*初始化滚动设置(无需修改)*/
	marqueetable.scrollTop=0; 	
	stopscroll1=false; 	
	startmarqueetop=0;
	offsettop=scrollheight;
	marqueestoptime=0;
	marqueetable.innerHTML+=marqueetable.innerHTML; 
	with(marqueetable){
	style.width=500;
	style.height=scrollheight;
	style.overflowX="hidden";
	style.overflowY="hidden";
	noWrap=true;
	onmouseover=new Function("stopscroll1=true");
	onmouseout=new Function("stopscroll1=false");
	}
	function setmarqueetime()
	{
		marqueetable.scrollTop=0;
		setInterval("marqueeup()",scrolltimeout);//设置滚动的时间
	}
	function marqueeup(){ 	
		if(stopscroll1==true) return; 	 
		offsettop+=1; 	
		if(offsettop==scrollheight+1) 	 
		{ 
			marqueestoptime+=1; 		
			offsettop-=1; 		
			if(marqueestoptime==scrollstoptimes)//停留的时间
			{
				offsettop=0; 
				marqueestoptime=0;
			}
		} else {
			startmarqueetop=marqueetable.scrollTop; 		
			marqueetable.scrollTop+=1; 	
			if(startmarqueetop==marqueetable.scrollTop)
			{ 
				marqueetable.scrollTop=scrollheight*(scrollline-1); 
				marqueetable.scrollTop+=1; 
			}
		}
	}
	setmarqueetime(); 	
	document.writeln("</body>");
	document.writeln("</html>");
<?
}else {
	Header('Location:'.$show_no);
}	
?>