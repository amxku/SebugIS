<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!--{if $login}-->
<h4>快捷功能向导 &raquo;</h4>
<ul class="info">
	<li><a href="{$php_self}?job=EXP&action=addEXP">添加Exploits</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="{$php_self}?job=BUG&amp;action=addbug">添加Vulndb</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="{$php_self}?job=type&amp;action=addtype">添加目录</a></li>
	
	<li><a href="{$php_self}?job=tools&amp;action=recache">更新缓存</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="{$php_self}?job=type&amp;action=type_updata">更新目录数据</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="{$php_self}?job=tools&amp;action=buildtemplate">更新模板</a></li>

	<li><a href="{$php_self}?job=log&action=loginlog">管理员登录日志</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="{$php_self}?job=log&action=userloginlog">前台用户登录日志</a></li>
</ul>
<h4>运行状态 &raquo;</h4>
<ul class="info">
	<li>系统时间: {$server[datetime]}，{$server[software]}，全局变量{$globals}，安全模式{$safemode}，<!--{if $server['memory_info']}-->内存占用: {$server[memory_info]}<!--{/if}--></li>
	<li>在线用户: <strong>{$online_users}</strong> 个 ， {$onlines}</li>
</ul>
<h4>系统信息 &raquo;</h4>
<ul class="info">
	<li>用户总数: <strong>{$users_n_check}</strong> 个，其中未审核 <strong><a href="{$php_self}?job=user">{$users_n_nocheck}</a></strong> 个</li>
	<li>信息总数: <strong>{$b_e}</strong> 条记录</li>
	<li>分类数量: <strong>{$type_n}</strong> 条记录，其中未审核 <strong><a href="{$php_self}?job=type">{$type_n_no}</a></strong> 条记录</li>
	<li>Vulndb信息数量: <strong>{$bugs}</strong> 条记录，其中未审核 <strong><a href="{$php_self}?job=EXP">{$bugs_ncheck}</a></strong> 条记录</li>
	<li>Exploits信息数量: <strong>{$exp}</strong> 条记录，其中未审核 <strong><a href="{$php_self}?job=EXP">{$exp_ncheck}</a></strong> 条记录</li>	
</ul>
<!--{/if}-->