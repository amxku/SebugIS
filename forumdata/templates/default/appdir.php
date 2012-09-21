<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}
	
	<div id="content">
		<br />
	<!--{if $zmdata}-->
		<!--{loop $zmdata $k $v}-->
		<div class="applists"><span class="return_en">{$k}</span><span class="return_top"><a href="#">TOP↑</a></span>
			<ul>
			<!--{loop $v $val}-->
				<li><a href="{$appdir_vi_url}{eval echo str_replace(" ", "+",$val)}/" title="{$val}">{$val}</a></li>
			<!--{/loop}-->
			</ul>
		</div>
	<!--{/loop}-->
	</div>
	<!--{/if}-->