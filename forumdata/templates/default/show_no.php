<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<div id="content">
	<div class="posttitle"></div>
	<div class="posttitle"><strong>{$language['sebug_no_3']}</strong></div>
	<div class="li_list">
		<form name="search" id="search" method="GET" action='{$search_url}'>
			<input name="s1" type="hidden" id="s1" value="s"/>
			<input name="w" type="text" id="w" class="it_search" style="width:400px;"/>&nbsp;&nbsp;&nbsp;<button type="submit">Search</button>
	</div>
	<div class="posttitle"><a href="http://s1.sebug.net">s1</a>&nbsp;&nbsp;&nbsp;<a href="http://s1.sebug.net/?cx=018356698781290416774%3Ajk5udkluq_4&cof=FORID%3A9&ie=UTF-8&q=php&sa=#1045">php</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/">local</a>&nbsp;&nbsp;&nbsp;<a href="{$url}appdir/">appdir</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/linux_exp/">linux</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2000-exploits/">2000</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2001-exploits/">2001</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2002-exploits/">2002</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2003-exploits/">2003</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2004-exploits/">2004</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2005-exploits/">2005</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2006-exploits/">2006</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2007-exploits/">2007</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2008-exploits/">2008</a>&nbsp;&nbsp;&nbsp;<a href="{$url}local/2009-exploits/">2009</a></div>
	
	<div class="posttitle"></div>
	<div class="posttitle"><strong>{$language['sebug_no_1']}</strong></div>
		<div class="li_list">
		<!--{if $show_no_db}-->
			<!--{loop $show_no_db $show_no}-->
					<li><span class="li_time">{$show_no['attime']}</span><a href="{$show_no['to_url']}" title="{$show_no['title']}" target="_blank" >{$show_no['title']}</a></li>
			<!--{/loop}-->
		</div>
		<!--{/if}-->
	<div class="posttitle"></div>
</div>