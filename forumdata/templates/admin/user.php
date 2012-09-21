<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!--{if $login}-->

<h4><a href="{$php_self}?job=main">SEBUG.NET</a>&raquo;用户信息管理</h4>

<form action="" name="form1" id="form1" method="post">
<p><a href="{$php_self}?job=user">用户列表</a> | <a href="{$php_self}?job=user&action=usermail">邮件列表</a> | <a href="{$php_self}?job=user&action=user_updata">更新用户上报数量</a> | <a href="{$php_self}?job=log&action=userloginlog">用户登录日志</a></p>
<!--{if $action == 'list'}-->
	<h4>{$subnav}</h4>
	<table border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr class="head">
			<td nowrap><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)" /></td>
			<td width="200">用户名</td>
			<td width="160"><a href="{$php_self}?job=user&top=3">注册时间</a></td>
			<td width="100"><a href="{$php_self}?job=user&top=1">登陆次数</a></td>
			<td width="100"><a href="{$php_self}?job=user&top=2">提交数量</a></td>
			<td width="130">上次登陆IP</td>
			<td width="160"><a href="{$php_self}?job=user&top=4">上次登陆时间</a></td>
			<td width="140">操作</td>
		</tr>
		<!--{loop $user_listdb $user_list}-->
			<!--{eval $thisbg = isset($thisbg) && $thisbg == 'tablecell' ? 'tablecell2' : 'tablecell';}-->
			<tr class="$thisbg">
				<td><input type="checkbox" name="zone[]" value="$user_list[userid]" /></td>
				<td><a href="{$user_url}{$user_list['username']}" target="_blank">{$user_list['username']}</td>
				<td>{$user_list['regdate']}</a></td>
				<td><!--{if $user_list['logincount']}-->{$user_list['logincount']}<!--{else}-->0<!--{/if}--></td>
				<td><!--{if $user_list['sebugt']}-->{$user_list['sebugt']}<!--{else}-->0<!--{/if}--></td>
				<td><!--{if $user_list['lastip']}-->{$user_list['lastip']}<!--{else}-->0.0.0.0<!--{/if}--></td>
				<td>{$user_list['lastactivity']}</td>
				<td>
					<a href="{$php_self}?job=user&action=edit&zone={$user_list['userid']}">编辑</a> - <a href="{$php_self}?job=user&action=delete&zone={$user_list['userid']}">删除</a> - <!--{if $user_list['checked'] == 0}--><a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=user&action=domore&do=nocheck&zone={$user_list['userid']}"><span class="yes">禁用</span></a><!--{else}--><a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=user&action=domore&do=check&zone={$user_list['userid']}"><span class="no">启用</span></a><!--{/if}-->
				</td>
			</tr>
		<!--{/loop}-->
			<!--{if $user_list_num >= $pagenum}-->
				<tr class="tdfoot">
          <td colspan="8" nowrap="nowrap"><div class="records">记录 : {$user_list_num}</div><div class="multipage">{$multipage}</div></td>
        </tr>
		<!--{/if}-->
	</table>
	<p class="operation">
		<input name="action"  value="domore" type="hidden" />
		<input name="do" id="do" value="" type="hidden" />
		<a href="###" onclick="$('do').value='check';$('form1').submit();">启用</a> - 
		<a href="###" onclick="$('do').value='nocheck';$('form1').submit()">禁用</a> - 
		<a href="###" onclick="$('do').value='de';$('form1').submit()">删除</a>
	</p>
<!--{elseif $action == 'edit'}-->

	<h4>{$subnav}</h4>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr class="input-line">
			<td class="input-title">用户名</td>
			<td width="70%"><a href="{$user_url}{$edit_user['username']}" target="_blank">{$edit_user['username']}</a></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">E-mail</td>
			<td width="70%"><a href="mailto:{$edit_user['email']}" target="_blank">{$edit_user['email']}</a></td>
		</tr>
		<!--{if $edit_user['homepage']}-->
			<tr class="input-line">
				<td class="input-title">Homepage</td>
				<td width="70%"><a href="{$edit_user['homepage']}" target="_blank">{$edit_user['homepage']}</a></td>
			</tr>
		<!--{/if}-->
		<tr class="input-line">
			<td class="input-title">注册IP:</td>
			<td>{$edit_user['regip']}</td>
		</tr>
		<tr class="input-line">
			<td class="input-title">注册时间:</td>
			<td>{$edit_user['regdate']}</td>
		</tr>
		<tr class="input-line">
			<td class="input-title">上次登陆IP:</td>
			<td>{$edit_user['lastip']}</td>
		</tr>
		<tr class="input-line">
			<td class="input-title">上次登陆时间:</td>
			<td>{$edit_user['lastactivity']}</td>
		</tr>
		<tr class="input-line">
			<td class="input-title">提交数量:</td>
			<td>{$edit_user['sebugt']}</td>
		</tr>
		<tr class="input-line">
			<td class="input-title">密码:</td>
			<td><input name="passwd" style="width:600px;" maxlength="100" type="text" value="" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">是否审核:</td>
            <td><input name="checked" type="hidden" id="checked" value="0" /><input name="checked" type="checkbox" id="checked" value="0" <!--{if $checked == 0}-->checked='checked'<!--{/if}--> />是否审核此提交信息</td>
		</tr>
		<tr class="input-submit">
			<td>
				<input name="action"  value="edit_save" type="hidden" />
				<input name="zone"  value="{$edit_user['userid']}" type="hidden" />
				<button type="submit">确定提交</button>
			</td>
		</tr>
	</table>

<!--{elseif $action == 'usermail'}-->
	<h4>{$subnav}</h4>
	<p><a href="{$php_self}?job=user&action=usermail&top=1">有登录记录</a>  |  <a href="{$php_self}?job=user&action=usermail&top=2">有提交记录</a></p>
	<p>共计【{$mailuser_n}】个</p>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr class="input-line">
			<td>
				<textarea style="width:850px;" rows="15" id="exp"><!--{loop $user_maildb $user_mail}-->{$user_mail['email']}<!--{/loop}--></textarea>
			</td>
		</tr>
	</table>
<!--{/if}-->
</form>
	<!--{if $action == 'list'}-->
	<div>
		<form method="post" action="">
			<input type="text" autocomplete="off" name="keywords" style="width:500px;" maxlength="30" value="$keywords" />
			<input name="action"  value="list" type="hidden" />
			<input name="do"  value="search" type="hidden" />
			<button type="submit">搜索</button>
		</form>
	</div>
	<!--{/if}-->
<!--{/if}-->