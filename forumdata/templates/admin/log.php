<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!--{if $login}-->
	<h4><a href="{$php_self}?job=main">SEBUG.NET</a>&raquo;登录日志</h4>
	<form action="" name="form1" id="form1" method="post">
	<p><a href="{$php_self}?job=log&action=loginlog">管理员登录日志</a> | <a href="{$php_self}?job=log&action=userloginlog">用户登录日志</a></p>
	<h4>{$subnav}</h4>	
		<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
			<tr class="head">
				<td width="160">用户名</td>
				<td>登陆时间</td>
				<td>IP地址</td>
				<td>登陆结果</td>
			</tr>
		<!--{if $logdb}-->
			<!--{loop $logdb $log}-->
				<!--{eval $thisbg = isset($thisbg) && $thisbg == 'tablecell' ? 'tablecell2' : 'tablecell';}-->
			<tr class="$thisbg">
				<td>$log[1]</td>
				<td>$log[2]</td>
				<td>$log[3]</td>
				<td>$log[4]</td>
			</tr>
			<!--{/loop}-->
		<!--{else}-->
			<tr class="tablecell">
				<td colspan="5">没有记录</td>
			</tr>
		<!--{/if}-->
				<!--{if $tatol >= $pagenum}-->
					<tr class="tdfoot">
	          <td colspan="8" nowrap="nowrap"><div class="records">记录 : {$tatol}</div><div class="multipage">{$multipage}</div></td>
	        </tr>
				<!--{/if}-->
		</table>
	</form>
<!--{/if}-->