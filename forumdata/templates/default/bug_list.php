<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

	<div class="fixed"></div>
	<form action="./" name="selectdform">
	<div class="list_other">
		<select name="o"  onChange="window.location='{$vuldb_url}page/'+selectdform.o.options[selectdform.o.selectedIndex].value+'/'+selectdform.t.options[selectdform.t.selectedIndex].value+'/'">
			<option value='0' selected>{$language['sebug_list_os']}</option>
			<option value="1" <!--{if $os == 1}-->selected<!--{/if}-->>Windows</option>
			<option value="2" <!--{if $os == 2}-->selected<!--{/if}-->>Linux</option>
			<option value="3" <!--{if $os == 3}-->selected<!--{/if}-->>UNIX</option>
			<option value="4" <!--{if $os == 4}-->selected<!--{/if}-->>SunOS</option>
			<option value="5" <!--{if $os == 5}-->selected<!--{/if}-->>MacOS</option>
			<option value="6" <!--{if $os == 6}-->selected<!--{/if}-->>Web App</option>
			<option value="7" <!--{if $os == 7}-->selected<!--{/if}-->>HP-UX </option>
			<option value="8" <!--{if $os == 8}-->selected<!--{/if}-->>AIX</option>
			<option value="9" <!--{if $os == 9}-->selected<!--{/if}-->>Other</option>
			<option value="10" <!--{if $os == 10}-->selected<!--{/if}-->>{$language['sebug_list_os_1']}</option>
			<option value="11" <!--{if $os == 11}-->selected<!--{/if}-->>Android</option>
			<option value="12" <!--{if $os == 12}-->selected<!--{/if}-->>Symbian</option>
		</select>
		<select name="t" onChange="window.location='{$vuldb_url}page/'+selectdform.o.options[selectdform.o.selectedIndex].value+'/'+selectdform.t.options[selectdform.t.selectedIndex].value+'/'">
			<option value='0' selected>{$language['sebug_list_type']}</option>
			<option value='1' <!--{if $type == 1}-->selected<!--{/if}-->>{$language['sebug_list_type_1']}</option>
			<option value='2' <!--{if $type == 2}-->selected<!--{/if}-->>{$language['sebug_list_type_2']}</option>
			<option value='3' <!--{if $type == 3}-->selected<!--{/if}-->>{$language['sebug_list_type_3']}</option>
			<option value='4' <!--{if $type == 4}-->selected<!--{/if}-->>{$language['sebug_list_type_4']}</option>
			<option value='5' <!--{if $type == 5}-->selected<!--{/if}-->>{$language['sebug_list_type_5']}</option>
			<option value='6' <!--{if $type == 6}-->selected<!--{/if}-->>{$language['sebug_list_type_6']}</option>
			<option value='7' <!--{if $type == 7}-->selected<!--{/if}-->>{$language['sebug_list_type_7']}</option>
			<option value='8' <!--{if $type == 8}-->selected<!--{/if}-->>{$language['sebug_list_type_8']}</option>
			<option value='9' <!--{if $type == 9}-->selected<!--{/if}-->>{$language['sebug_list_type_9']}</option>
			<option value='10' <!--{if $type == 10}-->selected<!--{/if}-->>{$language['sebug_list_type_10']}</option>
			<option value='11' <!--{if $type == 11}-->selected<!--{/if}-->>{$language['sebug_list_type_11']}</option>
			<option value='12' <!--{if $type == 12}-->selected<!--{/if}-->>{$language['sebug_list_type_12']}</option>
			<option value='13' <!--{if $type == 13}-->selected<!--{/if}-->>{$language['sebug_list_type_13']}</option>
			<option value='14' <!--{if $type == 14}-->selected<!--{/if}-->>{$language['sebug_list_type_14']}</option>
			<option value='15' <!--{if $type == 15}-->selected<!--{/if}-->>{$language['sebug_list_type_15']}</option>
			<option value='16' <!--{if $type == 16}-->selected<!--{/if}-->>{$language['sebug_list_type_16']}</option>
			<option value='17' <!--{if $type == 17}-->selected<!--{/if}-->>{$language['sebug_list_type_17']}</option>	
		</select>
	</div>
	</form>
	<div class="fixed"></div>
	<div id="content">
		<!--{if $bug_list_num}-->
		<div class="li_list">
			<!--{loop $bug_listdb $bug_list}-->
			<li><span class="li_time">{$bug_list['attime']}</span><a href="{$bug_list['to_url']}" title="{$bug_list['title']}">{$bug_list['title']}</a></li>
			<!--{/loop}-->
		</div>
	</div>
	
	<div class="fixed"></div>
	<!--{if $bug_list_num >= $pagenum}-->
		<div class="pages">[Records: {$bug_list_num}] -  {$multipage}</div>
	<!--{/if}-->
	<!--{/if}-->
