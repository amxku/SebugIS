<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<div id="content">
	<br />
	<p>
		<label for="username">
			<Strong>Author: </Strong>{$user['username']}, {$u_email}<br />
			<!--{if $user[homepage]}--><Strong>Homepage: </Strong><a href="{$user[homepage]}" target="_blank">{$user[homepage]}</a><!--{/if}-->
		</label>
	</p>
	<br />
	<p>
		<!--{if $show_searchdb}-->
		<Strong>------------</Strong>
			<div class="li_list">
				<!--{loop $show_searchdb $show_search}-->
						<li><span class="li_time">{$show_search['attime']}</span><a href="{$show_search['to_url']}" title="{$show_search['title']}">{$show_search['title']}</a></li>
				<!--{/loop}-->
			</div>
				<!--{if $search_num >= $pagenum}-->
					<div class="pages">[Records: {$search_num}] -  {$multipage}</div>
				<!--{/if}-->
		<!--{/if}-->
	</p>
</div>