<?php
/*
	防刷新处理
	Version: 1.01
	Author: amxku (luo2k5@Gmail.com)
	Copyright: Sebug.net
	Last Modified: 2007/05/02 20:00
*/
session_start();
$self = htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);

$allow_sep = "2"; //刷新时间,秒
if (isset($_SESSION["post_sep"])) {
    if ($ontime - $_SESSION["post_sep"] < $allow_sep)  {
        exit('<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta http-equiv="Refresh" content="2;url=".$self."">
				<title>SEBUG.NET</title>
			</head>
			<body style="table-layout:fixed; word-break:break-all;">
				<center>
					<div style="margin-top:100px;background-color:#f2f2f2;text-align:center;width:600px;padding:20px;margin-right: auto;margin-left:auto;font-family:Verdana,Tahoma;font-size:13px;border:1px solid #cccccc">
						<img src="http://www.sebug.net/images/loader.gif" alt="Loading..." />
						<p>Loading,Please Wait…</p><p><strong>SEBUG Security vulnerability Database</strong></p>
					</div>
				</center>
			</body>
			</html>');
    }else{
		 $_SESSION["post_sep"] = time();
	}
}else{
	$_SESSION["post_sep"] = time();
}
?>