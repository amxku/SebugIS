<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<div id="content">
	<h2 class="post-title">{$show_title}</h2>
	{$language['sebug_kmyad']}
	
	<div class="post-vuln">SSV ID:<a href="{$show_bug['to_url']}" target='_blank' title="{$show_title}">{$show_bug['id']}</a></div>
	<!--{if $checktype_type_name}--><div class="post-vuln">SEBUG-Appdir:<a href="{$appdir_vi_url}{$checktype_type_url}/" title="{$checktype_type_name}">{$checktype_type_name}</a></div><!--{/if}-->
	<div class="post-vuln">{$language['sebug_article_Published']}:{$show_bug['putime']}</div>
	<!--{if $uid}-->
	<div class="post-vuln">{$language['sebug_article_Submit']}:<a href="{$user_url}{$u_name}/" target='_blank'>{$u_rs['username']}</a> ({$u_email})</div>
	<!--{/if}-->
	<div><span class="post-vuln">{$language['sebug_article_Vulnerable']}:</span><blockquote>{$show_bug['Impact']}</blockquote></div>
	<div class="post-hr">{$language['sebug_article_Discription']}:</div>
		<div class="post-content"><pre>{$show_bug['buginfo']}</pre></div>
	<div><span class="post-vuln"><*{$language['sebug_article_References']}</span>
		<blockquote>{$show_bug['reference']}</blockquote><span class="post-vuln">*></span></div>
	
	<!--{if $show_bug['bugexp']}-->
	<div class="post-hr">{$language['sebug_article_Exploit']}:</div>
		<div class="exp-content"><span class="bugexp_url">[www.sebug.net]<br />{$language['sebug_article_exp_info']}</span><pre>{$show_bug['bugexp']}</pre></div>
	<!--{/if}-->
	
	<div class="post-hr">{$language['sebug_article_solution']}:</div>
		<div class="post-content">{$show_bug['ress']}</div>
	<div class="post-sebug">// sebug.net [{$show_p_attime}]</div>
</div>