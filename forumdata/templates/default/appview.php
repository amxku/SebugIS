<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>
{template header}
<div id="content">
	<br />
	<h2>{$show_type_title}</h2>
	<br />
	<!--{if $uid}-->
		<div class="post-vuln">{$language['sebug_article_Submit']}:<a href="{$user_url}{$u_name}/" target='_blank'>{$u_rs['username']}</a> ({$u_email})</div>
	<!--{/if}-->
	<div class="type-info"><pre>{$show_type['type_info']}</pre></div>
	<br />
	<!--{if $show_type['website']}-->
		<div class="post-vuln">{$language['appview_website']} : <a href="{$show_type['website']}" target='_blank'>{$show_type['website']}</a></div>
	<!--{/if}-->
	<!--{if $show_type['check_view']}-->
		<div class="post-vuln">{$language['appview_Chart']}</div>
		<div class="type-info">
			<script type="text/javascript" src="{$url}include/jscript/swfobject.js"></script>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" 
			width="865" height="200" id="ie_chart" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="{$url}images/open-flash-chart.swf?width=865&height=200&data={$url}t/test.php" />
			<param name="quality" value="high" />
			<embed src="{$url}images/open-flash-chart.swf?data={$url}t/test.php" width="865" height="200" name="chart" align="middle" allowScriptAccess="sameDomain" 
			type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" id="chart"/>
			</object>
		</div>
		<br />
	<!--{/if}-->
	<div class="li_list">
	<!--{loop $show_appdb $show_applist}-->
		<li><span class="li_time">{$show_applist['attime']}</span><a href="{$show_applist['to_url']}" title="{$show_applist['title']}">{$show_applist['title']}</a></li>
	<!--{/loop}-->
	</div>
</div>