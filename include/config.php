<?
/******************************************
Info:SEBUG Security Database
Function:数据库配置
Author:amxku@sebug.net
date:2006/10/17
site:http://sebug.net

##################CHANGELOG################
by amxku, V1.0
2006/10/09

by amxku, V1.1
2007/04/20

by amxku, V2.0
2008/10/17

by amxku, V2.1 Bate090501
2009/05
厂商目录，分布，走势

*******************************************/
//数据库主机
$servername = "localhost";

//数据库用户名
$dbusername = "sebug";

//数据库密码
$dbpassword = "sebug.net";

//数据库名
$dbname = "sebug.net";

//数据库名
$db_prefix = "net_";

//数据库连接方式
$usepconnect = '0';

//系统默认字符集
$charset = 'utf-8';

//站点地址
$url = "http://{host}/";

// 设置默认时区
date_default_timezone_set("Asia/Shanghai");

// 登录开关
// 1=开，0=关
$checkloging = '1';
?>