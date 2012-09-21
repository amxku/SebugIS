<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<div id="content">
 <div style="line-height:24px;padding-top:10px;text-align:left;">
		<strong>{$language['sebug_about_1']}</strong><br />
		<div style="padding:7px;">
			{$language['sebug_about_1_info']}
		</div>
		<strong>{$language['sebug_about_2']}</strong><br />
		{$language['sebug_about_2_a']}<br />
		<div style="padding:7px;">
			{$language['sebug_about_2_a_info']}
		</div> 
		{$language['sebug_about_2_b']}<br />
		<div style="padding:7px;">
			{$language['sebug_about_2_b_info_1']} [<a target="_blank" href="{$addvul_url}">{$language['sebug_about_2_b_info_3']}</a>] {$language['sebug_about_2_b_info_2']}
		</div>
		{$language['sebug_about_2_c']}<br />
		<div style="padding:7px;">
			[<a href="{$rss_url}" target="_blank">RSS Mirror_1</a>], [<a href="http://feed.feedsky.com/sebug" target="_blank">RSS Mirror_2</a>] {$language['sebug_about_2_c_info']}
		</div>
		{$language['sebug_about_2_d']}<br />
		<div style="padding:7px;">
			[<a href="{$js_url}" target="_blank">Javascript</a>] {$language['sebug_about_2_d_info']}
		</div>
		{$language['sebug_about_2_f']}<br />
		<div style="padding:7px;">
			[<a href="{$sitemap_url}" target="_blank">SiteMap</a>] {$language['sebug_about_2_f_info']}
		</div>
		
		<strong>{$language['sebug_about_3']}</strong><br />
		<div style="padding:7px;">
			{$language['sebug_about_3_info']}
		</div>
		<strong>{$language['sebug_about_4']}</strong><br />
		<div style="padding:7px;">
			<a href='http://www.sablog.net/blog/' target="_blank">4ngle</a>、<a href='http://huaidan.org/' target="_blank">鬼仔</a>、<a href='http://www.f2s.com.cn/' target="_blank">枫三少</a>、<a href='http://hi.baidu.com/%CD%F5%BD%E0%5F' target="_blank">王洁</a>、<a href='http://www.Neeao.com/' target="_blank">Neeao</a>、<a href='http://www.cdnunion.com/' target="_blank">CDNunion</a>、<a href='http://hqlong.com/' target="_blank">hqlong</a>
		</div>
		<strong>{$language['sebug_about_5']}</strong><br />
		<div style="padding:7px;">
			{$language['sebug_article_exp_info']}
		</div>
		<strong>{$language['sebug_Partners_2']}</strong><br />
		<div style="padding:7px;">
			{$language['sebug_Partners_mail']}：<a href="javascript:location.href='mailto:'+String.fromCharCode(115,49,64,115,101,98,117,103,46,110,101,116)+'?sebug.net'">E-mail Sebug</a>
			<br />
			{$language['sebug_Partners_site']}：<a target="_blank" href="{$url}" title="SEBUG Security Database">{$url}</a>
		</div> 
  </div>
</div>