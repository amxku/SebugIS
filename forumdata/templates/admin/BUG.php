<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!--{if $login}-->
<h4><a href="{$php_self}?job=main">SEBUG.NET</a>&raquo;信息管理</h4>
	<script type="text/javascript">
	var typeck_aj_url = '{$url}image/getxml.php';
	</script>
	<script type="text/javascript" src="{$url}include/jscript/edit_type.js"></script>
	<script type="text/javascript" src="{$url}include/jscript/ajax.js"></script>
<form action="" name="form1" id="form1" method="post">
<p><a href="{$php_self}?job=EXP">信息列表</a> | <a href="{$php_self}?job=EXP&action=addEXP">添加EXP</a> | <a href="{$php_self}?job=BUG&action=addbug">添加BUG</a></p>
<!--{if $action == 'addbug'}-->
	<h4>{$subnav}</h4>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr class="input-line">
			<td class="input-title">名  称</td>
			<td><input name="title" style="width:600px;" maxlength="100" type="text" value="" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">发布时间:</td>
			<td><input name="putime" style="width:600px;" maxlength="100" type="text" value="{$on_time}" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">系统目录:</td>
			<td><select name="systype" id="systype">
                          <option value=''>---系统目录---</option>
                          <!--{loop $checktype_db $type_list}--><option value='{$type_list['typeid']}'>{$type_list['type_name']}</option><!--{/loop}-->
                        </select> - <a href="javascript:;" onclick="showaddtype('675');return false;">添加新目录</a></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">针对平台:</td>
			<td><select name="os" id="os">
                          <option value="" selected>---所属系统---</option>
                          <option value="6"> Web程序</option>
                          <option value="3"> UNIX</option>
                          <option value="7"> HP-UX </option>
                          <option value="9"> 其它系统</option>
                          <option value="2"> Linux</option>
                          <option value="4"> SunOS</option>
						  						<option value="5"> MacOS</option>
                          <option value="1"> Windows</option>
						  						<option value="8"> AIX</option>
						  						<option value="10"> 跨平台</option>
						  						<option value="11"> Android</option>
						  						<option value="12"> Symbian</option>
                        </select></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">所属类型:</td>
			<td><select name="be_type" id="be_type">
                          <option value='' selected>---所属类型---</option>
                           <option value='1'>越权访问</option>
                          <option value='2'>拒绝服务</option>
                          <option value='3'>嵌入恶意代码</option>
                          <option value='4'>SQL注入</option>
                          <option value='5'>其他类型</option>
                          <option value='6'>远程溢出</option>
						  						<option value='7'>文件包含</option>
						  						<option value='8'>本地溢出</option>
						  						<option value='9'>跨站</option>
						  						<option value='11'>遍历目录</option>
						  						<option value='12'>DOS/POC</option>
						  						<option value='13'>ShellCode</option>
						  						<option value='14'>上传</option>
						  						<option value='15'>泄漏信息</option>
						  						<option value='16'>远程执行</option>
						  						<option value='17'>Cookie验证漏洞</option>
                        </select></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">影响版本:<br />(Vulnerable)</td>
			<td><textarea name="Impact" style="width:700px;" rows="3" id="Impact" value=""></textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">危害级别:</td>
			<td><select name="grades" id="grades">
                          <option value="0">---低---</option>
                          <option value="1" selected>---中---</option>
                          <option value="2">---高---</option>
                        </select></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">详细说明:<br />(Discussion)</td>
			<td><textarea name="buginfo" style="width:700px;" rows="7" id="buginfo" value=""></textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">解决方案:<br />(Solution)</td>
			<td><textarea name="ress" style="width:700px;" rows="4" id="ress" value=""></textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">参考:<br />(References)</td>
			<td><textarea name="reference" style="width:700px;" rows="3" id="reference" value=""></textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">测试方法:<br />(Exploit)</td>
			<td><textarea name="bugexp" style="width:700px;" rows="8" id="bugexp" value=""></textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">是否审核:</td>
            <td><input name="checked" type="hidden" id="checked" value="0" checked='checked'/><input name="checked" type="checkbox" id="checked" value="1"/>是否审核此提交信息</td>
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
	<table border="0" cellpadding="5" cellspacing="0" width="100%">
		<tr class="head">
			<td nowrap><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)" /></td>
			<td width="130">时间</td>
			<td>标题</td>
			<td width="100">针对平台</td>
			<td width="100">所属类型</td>
			<td width="120">操作</td>
		</tr>
		<!--{loop $bug_listdb $bug_list}-->
			<!--{eval $thisbg = isset($thisbg) && $thisbg == 'tablecell' ? 'tablecell2' : 'tablecell';}-->
			<tr class="$thisbg">
				<td><input type="checkbox" name="zone[]" value="$bug_list[id]" />|{$bug_list[id]}</td>
				<td>{$bug_list['attime']}</td>
				<td><a href="{$url}index.php?s1=show_bug&ch=amxku&v={$bug_list['id']}" target="_blank">{$bug_list['title']}</a></td>
				<td>{$bug_list['os']}</td>
				<td>{$bug_list['be_type']}</td>
				<td>
					<a href="javascript:;" onclick="tagshow('{$bug_list['id']}');return false;">目录</a> - <a href="{$php_self}?job=BUG&action=edit&zone=$bug_list[id]">编辑</a>-<a onclick="return confirm('您确定要[删除]该信息吗?');" href="{$php_self}?job=BUG&action=domore&do=delete&zone=$bug_list[id]">删除</a>-<!--{if $bug_list['checked'] == 1}--><a onclick="return confirm('您确定要隐藏该信息吗?');" href="{$php_self}?job=BUG&action=domore&do=nocheck&zone=$bug_list[id]"><span class="yes">隐藏</span></a><!--{else}--><a onclick="return confirm('您确定要继续吗?');" href="{$php_self}?job=BUG&action=domore&do=check&zone=$bug_list[id]"><span class="no">显示</span></a><!--{/if}-->
				</td>
			</tr>
		<!--{/loop}-->
		<!--{if $bug_list_num >= $pagenum}-->
				<tr class="tdfoot">
          <td colspan="8" nowrap="nowrap"><div class="records">记录 : {$bug_list_num}</div><div class="multipage">{$multipage}</div></td>
        </tr>
		<!--{/if}-->
	</table>
	<p class="operation">
		<input name="action"  value="domore" type="hidden" />
		<a href="###" onclick="$('do').value='check';$('form1').submit()">显示</a> - 
		<a href="###" onclick="$('do').value='nocheck';$('form1').submit()">隐藏</a> - 
		<a href="###" onclick="$('do').value='de';$('form1').submit()">删除</a> - 
	
		<select name="systype" id="systype">
	      <option value="0">---系统目录---</option>
	      <!--{loop $checktype_db $type_list}--><option value='{$type_list['typeid']}'>{$type_list['type_name']}</option><!--{/loop}-->
    </select>
		<input name="do" id="do" value="type" type="hidden" />
		<button type="submit">提 交</button>
	</p>
<!--{elseif $action == 'edit'}-->
	<h4>{$subnav}</h4>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr class="input-line">
			<td class="input-title">BUG名称</td>
			<td><input name="title" style="width:600px;" maxlength="100" type="text" value="{$edit_bug['title']}" /></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">发布时间:</td>
			<td><input name="putime" style="width:600px;" maxlength="100" type="text" value="{$edit_bug['putime']}" /></td>
		</tr>
		<!--{if $uid}-->
		<tr class="input-line">
			<td class="input-title">信息提交:</td>
			<td><a href="{$user_url}{$user['username']}" target='_blank'>{$user['username']}</a>({$u_email})</td>
		</tr>
		<!--{/if}-->
		<tr class="input-line">
			<td class="input-title">系统分类:</td>
			<td><select name="systype" id="systype">
                          <option value=''>---系统分类---</option>
                          <!--{loop $checktype_db $type_list}--><option value='{$type_list['typeid']}' <!--{if $edit_bug['typeid'] == $type_list['typeid']}-->selected<!--{/if}-->>{$type_list['type_name']}</option><!--{/loop}-->
                        </select></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">针对平台:</td>
			<td><select name="os" id="os">
                          <option value="">---所属系统---</option>
                          <option value="6" <!--{if $os == 6}-->selected<!--{/if}-->> Web程序</option>
                          <option value="3" <!--{if $os == 3}-->selected<!--{/if}-->> UNIX</option>
                          <option value="7" <!--{if $os == 7}-->selected<!--{/if}-->> HP-UX </option>
                          <option value="9" <!--{if $os == 9}-->selected<!--{/if}-->> 其它系统</option>
                          <option value="2" <!--{if $os == 2}-->selected<!--{/if}-->> Linux</option>
                          <option value="4" <!--{if $os == 4}-->selected<!--{/if}-->> SunOS</option>
						  						<option value="5" <!--{if $os == 5}-->selected<!--{/if}-->> MacOS</option>
                          <option value="1" <!--{if $os == 1}-->selected<!--{/if}-->> Windows</option>
						  						<option value="8" <!--{if $os == 8}-->selected<!--{/if}-->> AIX</option>
						  						<option value="10" <!--{if $os == 10}-->selected<!--{/if}-->> 跨平台</option>
						  						<option value="11" <!--{if $os == 11}-->selected<!--{/if}-->> Android</option>
						  						<option value="12" <!--{if $os == 12}-->selected<!--{/if}-->> Symbian</option>
                        </select></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">所属类型:</td>
			<td><select name="be_type" id="be_type">
                          <option value=''>---所属类型---</option>
						  						<option value='1' <!--{if $be_type == 1}-->selected<!--{/if}-->>越权访问</option>
                          <option value='2' <!--{if $be_type == 2}-->selected<!--{/if}-->>拒绝服务</option>
                          <option value='3' <!--{if $be_type == 3}-->selected<!--{/if}-->>嵌入恶意代码</option>
                          <option value='4' <!--{if $be_type == 4}-->selected<!--{/if}-->>SQL注入</option>
                          <option value='5' <!--{if $be_type == 5}-->selected<!--{/if}-->>其他类型</option>
                          <option value='6' <!--{if $be_type == 6}-->selected<!--{/if}-->>远程溢出</option>
						  						<option value='7' <!--{if $be_type == 7}-->selected<!--{/if}-->>文件包含</option>
						  						<option value='8' <!--{if $be_type == 8}-->selected<!--{/if}-->>本地溢出</option>
						  						<option value='9' <!--{if $be_type == 9}-->selected<!--{/if}-->>跨站</option>
						  						<option value='9' <!--{if $be_type == 10}-->selected<!--{/if}-->>web app</option>
						  						<option value='11' <!--{if $be_type == 11}-->selected<!--{/if}-->>遍历目录</option>
						  						<option value='12' <!--{if $be_type == 12}-->selected<!--{/if}-->>DOS/POC</option>
						  						<option value='13' <!--{if $be_type == 13}-->selected<!--{/if}-->>ShellCode</option>
						  						<option value='14' <!--{if $be_type == 14}-->selected<!--{/if}-->>上传</option>
						  						<option value='15' <!--{if $be_type == 15}-->selected<!--{/if}-->>泄漏信息</option>
						  						<option value='16' <!--{if $be_type == 16}-->selected<!--{/if}-->>远程执行</option>
                        </select></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">影响版本:<br />(Vulnerable)</td>
			<td><textarea name="Impact" style="width:700px;" rows="3" id="Impact">{$edit_bug['Impact']}</textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">危害级别:</td>
			<td><select name="grades" id="grades">
                          <option value="0" <!--{if $grades == 0}-->selected<!--{/if}-->>---低---</option>
                          <option value="1" <!--{if $grades == 1}-->selected<!--{/if}-->>---中---</option>
                          <option value="2" <!--{if $grades == 2}-->selected<!--{/if}-->>---高---</option>
                        </select></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">详细说明:<br />(Discussion)</td>
			<td><textarea name="buginfo" style="width:700px;" rows="8" id="buginfo">{$edit_bug['buginfo']}</textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">解决方案:<br />(Solution)</td>
			<td><textarea name="ress" style="width:700px;" rows="4" id="ress">{$edit_bug['ress']}</textarea></td>
		</tr>
		<tr class="input-line">
			<td class="input-title">参考:<br />(References)</td>
			<td><textarea name="reference" style="width:700px;" rows="2" id="reference">{$edit_bug['reference']}</textarea></td>
		</tr>
		<!--{if $edit_bug['bugexp']}-->
		<tr class="input-line">
			<td class="input-title">测试方法:<br />(Exploit)</td>
			<td><textarea name="bugexp" style="width:700px;" rows="8" id="bugexp">{$edit_bug['bugexp']}</textarea></td>
		</tr>
		<!--{/if}-->
		<tr class="input-line">
			<td class="input-title">是否审核:</td>
            <td><input name="checked" type="hidden" id="checked" value="0" /><input name="checked" type="checkbox" id="checked" value="1" <!--{if $checked == 1}-->checked='checked'<!--{/if}--> />是否审核此提交信息</td>
		</tr>
		<tr class="input-submit">
			<td>
				<input name="action"  value="edit_save" type="hidden" />
				<input name="zone"  value="{$edit_bug['id']}" type="hidden" />
				<button type="submit">确定提交</button>
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