<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>系统消息</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta HTTP-EQUIV="REFRESH" content="{$min};URL={$tourl}" />
<style type="text/css">
body, div {font-size: 14px;font-family: Arial, sans-serif;color: #333;line-height: 16px;}
a {color: #333399;text-decoration: none;}
a:hover {color: #A0A4C1;text-decoration: none;}
.alert {color: #990000;font-size: 14px;margin: 0;padding: 0;}
.box {border: #B1B6D2 1px solid;width: 500px;margin: 100px auto;text-align: center;padding: 1px;}
.box-body {padding:30px;}
.alertmsg {margin-top:30px;background-color: transparent;}
</style>
</head>
<body style="text-align:center">
<div class="box">
	<div class="box-body">
		<h2 class="alert">{$msg}</h2>
		<div class="alertmsg"><a href="{$tourl}">如果你不想等待或浏览器没有自动跳转请点击这里跳转</a></div>
	</div>
</div>
</body>
</html>