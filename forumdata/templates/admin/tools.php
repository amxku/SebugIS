<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<!--{if $login}-->

<h4><a href="{$php_self}?job=main">SEBUG.NET</a>&raquo;MYSQL数据库信息&raquo;</h4>

<form action="" name="form1" id="form1" method="post">
<p><a href="{$php_self}?job=tools">MYSQL数据库信息</a> | <a href="{$php_self}?job=tools&action=backup">备份数据库</a> | <a href="{$php_self}?job=tools&action=tools">数据库维护</a></p>

<!--{if $action == 'mysqlinfo'}-->
	<ul class="info">
		<li>版本: $mysql_version</li>
		<li>运行时间: $mysql_runtime</li>
	</ul>
	<h4>SEBUG数据表 &raquo;</h4>
	<table border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr class="head">
			<td width="20%">名称</td>
			<td width="20%">创建时间</td>
			<td width="20%">最后更新时间</td>
			<td width="10%">记录数</td>
			<td width="10%">数据</td>
			<td width="10%">索引</td>
			<td width="10%">碎片</td>
		</tr>
		<!--{loop $sebug_table $sebug}-->
			<!--{eval $thisbg = isset($thisbg) && $thisbg == 'tablecell' ? 'tablecell2' : 'tablecell';}-->
		<tr class="$thisbg">
			<td>$sebug[Name]</td>
			<td nowrap>$sebug[Create_time]</td>
			<td nowrap>$sebug[Update_time]</td>
			<td nowrap>$sebug[Rows]</td>
			<td nowrap>$sebug[Data_length]</td>
			<td nowrap>$sebug[Index_length]</td>
			<td nowrap>$sebug[Data_free]</td>
		</tr>
		<!--{/loop}-->
		<tr class="tdfoot">
			<td colspan="3"><b>共计:{$sebug_table_num}个数据表</b></td>
			<td><b>$sebug_table_rows</b></td>
			<td><b>$sebug_data_size</b></td>
			<td><b>$sebug_index_size</b></td>
			<td><b>$sebug_free_size</b></td>
		</tr>
	</table>
	<br />
	<h4>其他数据表&raquo;</h4>
	<table border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr class="head">
			<td width="20%">名称</td>
			<td width="20%">创建时间</td>
			<td width="20%">最后更新时间</td>
			<td width="10%">记录数</td>
			<td width="10%">数据</td>
			<td width="10%">索引</td>
			<td width="10%">碎片</td>
		</tr>
	<!--{loop $other_table $other}-->
		<!--{eval $thisbg = isset($thisbg) && $thisbg == 'tablecell' ? 'tablecell2' : 'tablecell';}-->
		<tr class="$thisbg">
			<td>$other[Name]</td>
			<td nowrap>$other[Create_time]</td>
			<td nowrap>$other[Update_time]</td>
			<td nowrap>$other[Rows]</td>
			<td nowrap>$other[Data_length]</td>
			<td nowrap>$other[Index_length]</td>
			<td nowrap>$other[Data_free]</td>
		</tr>
	<!--{/loop}-->
		<tr class="tdfoot">
			<td colspan="3"><b>共计:{$other_table_num}个数据表</b></td>
			<td><b>$other_table_rows</b></td>
			<td><b>$other_data_size</b></td>
			<td><b>$other_index_size</b></td>
			<td><b>$other_free_size</b></td>
		</tr>
	</table>
	<p></p>
<!--{/if}-->

<!--{if $action == 'backup'}-->
	<div>
		<h4>建表语句格式</h4>
		<p>
			<input type="radio" name="sqlcompat" value=""/> 默认<br />
			<input type="radio" name="sqlcompat" value="MYSQL40" /> MySQL 4.0.x<br />
			<input type="radio" name="sqlcompat" value="MYSQL41" checked /> MySQL 4.1.x/5.x
		</p>
	</div>
	<div>
		<h4>字符集限定</h4>
		<p>
			<input type="radio" name="addsetnames" value="1"/> 是
			<input type="radio" name="addsetnames" value="0" checked/> 否
		</p>
	</div>
	<div>
		<h4>分卷备份 - 每个文件</h4>
		<p>
			<input type="text" name="sizelimit" size="20" maxlength="20" value="2048" /> KB
		</p>
	</div>
	<div>
		<h4>备份文件名</h4>
		<p>
			<input type="text" name="filename" size="40" maxlength="40" value="{$backuppath}" />.sql
		</p>
	</div>
	<div>
		<input type="hidden" name="action" value="dobackup" />
		<button type="submit">点击开始备份</button>
	</div>
<!--{/if}-->

<!--{if $action == 'tools'}-->
	<div class="input">
		<h4>选择操作</h4>
		<p>
			<input type="checkbox" name="do[]" value="check" checked /> 检查表<br />
			<input type="checkbox" name="do[]" value="repair" checked /> 修复表<br />
			<input type="checkbox" name="do[]" value="analyze" checked /> 分析表<br />
			<input type="checkbox" name="do[]" value="optimize" checked /> 优化表
		</p>
	</div>
	<div>
		<input type="hidden" name="action" value="dotools" />
		<button type="submit">点击开始数据库维护</button>
	</div>
<!--{/if}-->

<!--{if $action == 'dotools'}-->
	<!--{loop $dodb $do}-->
		<div style="width:24%;margin-right:10px;float:left;">
			<h4>$do[name]表&raquo;</h4>
			<ul class="info">
				<!--{loop $tabledb $table}-->
					<!--{if $table['do'] == $do['do']}-->
						<li>$table[table]: $table[result]</li>
					<!--{/if}-->
				<!--{/loop}-->
			</ul>
		</div>
	<!--{/loop}-->
<!--{/if}-->

</form>
<!--{/if}-->