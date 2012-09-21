<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="copyright" content="sebug.net" />
<meta name="author" content="s1@sebug.net" />
<title>{$title}</title>
<link rel="stylesheet" href="{$url}forumdata/templates/admin/cp.css" type="text/css" />
<script type="text/javascript">
function $(id) {
	return document.getElementById(id);
}
function checkall(form) {
	for (var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
	}
}
</script>
</head>
<body>
<div id="statusmsg"></div>
<div id="header">
	<span style="float:left">
		<h3>SEBUG Security Database</h3>
	</span>
	<!--{if $login}-->
	<span style="float:right">
		<a href="{$php_self}?job=main">后台首页</a> | 
		<a href="{$php_self}?job=EXP">信息管理</a> | 
				<a href="{$php_self}?job=type">目录</a> | 
		<a href="{$php_self}?job=user">用户</a> | 
		<a href="{$php_self}?job=tools">数据库</a> | 
		<a href="./" target="_blank">前台首页</a> | 
		<a href="{$php_self}?action=logout">注销</a>
	</span>
	<!--{/if}-->
</div>
<div id="mainbody">
	<div id="msg"></div>