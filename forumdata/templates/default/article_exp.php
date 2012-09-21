<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<div id="content">
	<h2 class="post-title">{$show_exp_title}</h2>
	{$language['sebug_kmyad']}
	
	<div class="post-vuln">SSV ID:<a href="{$show_exp['to_url']}" target='_blank' title="{$show_exp_title}">{$show_exp['id']}</a></div>
	<!--{if $checktype_type_name}--><div class="post-vuln">SEBUG-Appdir:<a href="{$appdir_vi_url}{$checktype_type_url}/" title="{$checktype_type_name}">{$checktype_type_name}</a></div><!--{/if}-->
	<div class="post-vuln">{$language['sebug_article_Published']}:{$show_exp['putime']}</div>
	<!--{if $uid}-->
	<div class="post-vuln">{$language['sebug_article_Submit']}:<a href="{$user_url}{$u_name}/" target='_blank'>{$u_rs['username']}</a> ({$u_email})</div>
	<!--{/if}-->
	<div class="post-vuln">{$language['sebug_article_Exploit']}:</div>
		<div class="exp-content"><span class="bugexp_url">[www.sebug.net]<br />{$language['sebug_article_exp_info']}</span><pre>{$show_exp['bugexp']}</pre></div>
	<div class="post-sebug">// sebug.net [{$show_p_attime}]</div>
</div>