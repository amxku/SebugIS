<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}
<br />
<div id="content">
	<!--{if $show_searchdb}-->
	<div class="li_list">
		<!--{loop $show_searchdb $show_search}-->
				<li><span class="li_time">{$show_search['attime']}</span><a href="{$show_search['to_url']}" title="{$show_search['title']}" target="_blank">{$show_search['title']}</a></li>
		<!--{/loop}-->
	</div>
	<div class="fixed"></div>
	<!--{if $search_num >= $pagenum}-->
	<div class="pages">[Records: {$search_num}] -  {$multipage}</div>
	<!--{/if}-->
<!--{/if}-->
</div>