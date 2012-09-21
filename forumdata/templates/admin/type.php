<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!--{if $login}-->
<h4><a href="{$php_self}?job=main">SEBUG.NET</a>&raquo;目录管理</h4>

<form action="" name="form1" id="form1" method="post">
<p> <a href="{$php_self}?job=type">目录列表</a> | <a href="{$php_self}?job=type&action=addtype">添加目录</a> | <a href="{$php_self}?job=type&action=type_updata">更新数量</a> | <a href="{$php_self}?job=EXP&action=addEXP">添加EXP</a> | <a href="{$php_self}?job=BUG&action=addbug">添加BUG</a></p>
<!--{if $action == 'addtype'}-->
	<h4>{$subnav}</h4>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr class="input-line">
			<td class="input-title">目录名称:</td>
			<td><input name="type_name" style="width:600px;" maxlength="100" type="text" value="" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">官方网站:</td>
			<td><input name="website" style="width:600px;" maxlength="100" type="text" value="http://" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">目录说明:</td>
			<td><textarea name="type_info" style="width:600px;" rows="12" id="type_info"></textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">是否审核:</td>
            <td><input name="checked" type="hidden" id="checked" value="0" checked='checked'/><input name="checked" type="checkbox" id="checked" value="1"/>是否审核此分类</td>
		</tr>
				<tr class="input-line">
			<td class="input-title">是否生成走势图:</td>
            <td><input name="check_view" type="hidden" id="check_view" value="0" checked='checked'/><input name="check_view" type="checkbox" id="check_view" value="1"/>是否生成走势图</td>
		</tr>
		<tr class="input-submit">
			<td colspan="2">
				<input name="action" value="add" type="hidden" />
				<button type="submit">确定提交</button>
			</td>
		</tr>
	</table>

<!--{elseif $action == 'list'}-->
	<h4>{$subnav}</h4>	
	<table border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr class="head">
			<td nowrap><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)" /></td>
			<td width="90">时间</td>
			<td width="200">名称</td>
			<td>说明</td>
			<td width="40"><a href="{$php_self}?job=type&top=1">数量</a></td>
			<td width="150">操作</td>
		</tr>
		<!--{loop $type_listdb $type_list}-->
			<!--{eval $thisbg = isset($thisbg) && $thisbg == 'tablecell' ? 'tablecell2' : 'tablecell';}-->
			<tr class="$thisbg">
				<td><input type="checkbox" name="zone[]" value="$type_list[typeid]" /></td>
				<td>{$type_list['b_time']}</td>
				<td><a href="{$url}index.php?s1=appview&d={$type_list['type_name_url']}" target="_blank">{$type_list['type_name']}</a></td>
				<td>{$type_list['type_info']}</td>
				<td><!--{if $type_list['v_num']}-->{$type_list['v_num']}<!--{else}-->0<!--{/if}--></td>
				<td><a href="{$php_self}?job=type&action=edit&zone={$type_list['typeid']}">编辑</a> - <a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=type&action=domore&do=delete&zone={$type_list['typeid']}">删除</a> - <!--{if $type_list['checked'] == 1}--><a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=type&action=domore&do=nocheck&zone={$type_list['typeid']}"><span class="yes">隐藏</span></a><!--{else}--><a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=type&action=domore&do=check&zone={$type_list['typeid']}"><span class="no">显示</span></a><!--{/if}--> - <!--{if $type_list['check_view'] == 1}--><a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=type&action=domore&do=noview&zone={$type_list['typeid']}"><span class="yes">走势</span></a><!--{else}--><a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=type&action=domore&do=view&zone={$type_list['typeid']}"><span class="no">走势</span></a><!--{/if}-->
				</td>
			</tr>
		<!--{/loop}-->
			<!--{if $type_list_num >= $pagenum}-->
				<tr class="tdfoot">
          <td colspan="8" nowrap="nowrap"><div class="records">记录 : {$type_list_num}</div><div class="multipage">{$multipage}</div></td>
        </tr>
		<!--{/if}-->
	</table>
	<p class="operation">
		<input name="action"  value="domore" type="hidden" />
		<input name="do" id="do" value="" type="hidden" />
		<a href="###" onclick="$('do').value='check';$('form1').submit();">显示</a> - 
		<a href="###" onclick="$('do').value='nocheck';$('form1').submit()">隐藏</a> - 
		<a href="###" onclick="$('do').value='view';$('form1').submit()">显示走势图</a> - 
		<a href="###" onclick="$('do').value='noview';$('form1').submit()">隐藏走势图</a> - 
		<a href="###" onclick="$('do').value='delete';$('form1').submit()">删除</a>
	</p>
<!--{elseif $action == 'edit'}-->

	<h4>{$subnav}</h4>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr class="input-line">
			<td class="input-title">目录名称</td>
			<td><input name="type_name" style="width:600px;" maxlength="100" type="text" value="{$edit_type['type_name']}" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">官方网站:</td>
			<td><input name="website" style="width:600px;" maxlength="100" type="text" value="{$edit_type['website']}" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">目录说明:</td>
			<td><textarea name="type_info" style="width:600px;" rows="12" id="type_info">{$edit_type['type_info']}</textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">是否审核:</td>
            <td><input name="checked" type="hidden" id="checked" value="0" /><input name="checked" type="checkbox" id="checked" value="1" <!--{if $checked == 1}-->checked='checked'<!--{/if}--> />是否审核此分类</td>
		</tr>
		<tr class="input-line">
			<td class="input-title">是否生成走势图:</td>
            <td><input name="check_view" type="hidden" id="check_view" value="0" /><input name="check_view" type="checkbox" id="check_view" value="1" <!--{if $check_view == 1}-->checked='checked'<!--{/if}--> />是否生成走势图</td>
		</tr>
		<tr class="input-submit">
			<td>
				<input name="action"  value="edit_save" type="hidden" />
				<input name="zone"  value="{$edit_type['typeid']}" type="hidden" />
				<button type="submit">确定提交</button>
			</td>
		</tr>
	</table>
<!--{/if}-->
</form>
	<!--{if $action == 'list'}-->
	<div class="tablecell">
		<form method="post" action="">
			<input type="text" autocomplete="off" name="keywords" style="width:500px;" maxlength="30" value="$keywords" />
			<input name="action"  value="list" type="hidden" />
			<input name="do"  value="search" type="hidden" />
			<button type="submit">搜索</button>
		</form>
	</div>
	<!--{/if}-->
<!--{/if}-->