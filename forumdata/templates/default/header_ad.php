<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$options['title']}</title>
<meta name="description" content="$options[meta_description]"/>
<meta name="keywords" content="$options[meta_keywords]"/>
<meta name="title" content="{$options['title']}" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="UTF-8" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="msthemecompatible" content="yes" />
<meta name="copyright" content="Sebug.net"/>
<meta name="author" content="s1_at_sebug.net"/>
<meta name="verify-v1" content="m8GjyLA+CoowKKYb8WA/06IN6RAf3KA6nMUBLMRMMmY=" />
<link rel="stylesheet" href="{$url}forumdata/templates/default/style.css" type="text/css" media="all"/>
<!--[if IE]><link rel="stylesheet" href="{$url}forumdata/templates/default/style_ie.css" type="text/css" media="screen" /><![endif]-->
<link rel="alternate" title="{$language['sebug_title_home']}" href="{$rss_url}" type="application/rss+xml"/>
<script type="text/javascript">
var sebugurl = '$url';
</script>
</head>
<body>
	<div style="text-align:center;background:#FF6D06;color:#FFF;padding:5px;font-weight:bold;">SEBUG Security vulnerability Database将于2009年07月04日 23:00 进行数据库维护，届时将不能正常访问，因此给您带来不便，敬请谅解。</div>
<div id="main">
<span class="topb"><!--{if $ssd_uid}--><a href="{$user_url}{$ssd_user}">{$ssd_user}</a> | <a href="{$profile_url}">{$language['h_Sitting']}</a> | <a href="{$addvul_url}">add Vulndb</a> | <a href="{$addexp_url}">add Exploits</a> | <a href="{$url}login.php?s1=logout">{$language['h_logout']}</a><!--{else}--><a href="{$login_url}">{$language['h_login']}</a><!--{/if}--></span>
	<div id="header">
		<h1 id="title"><span title="{$language['sebug_title_home']}">SEBUG.NET</span></h1>
	</div>
	<div id="menubar">
		<ul class="menus">
			<li><a href='{$url}' title='{$language['sebug_title_home']}'>Home</a></li>
			<li <!--{if $pagefile == 'bug_list'}-->class="current_page_item"<!--{/if}-->><a href='{$vuldb_url}' title='{$language['sebug_title_Vulndb']}'>Vulndb</a></li>
			<li <!--{if $pagefile == 'appdir'}-->class="current_page_item"<!--{/if}-->><a href='{$appdir_url}' title='{$language['sebug_title_appdir']}'>Appdir</a></li>
			<li><a href='{$url}local/' title='Papers'>Papers</a></li>
			<li <!--{if $pagefile == 'cooperate'}-->class="current_page_item"<!--{/if}-->><a href='{$cooperate_url}' title='{$language['sebug_title_Partner']}'>Partners</a></li>
			<li <!--{if $pagefile == 'About'}-->class="current_page_item"<!--{/if}-->><a href='{$About_url}' title='{$language['sebug_title_about']}'>About</a></li>
		</ul>
	</div>