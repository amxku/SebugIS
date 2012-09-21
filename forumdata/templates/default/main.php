<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<div id="content">
	<p>
		<div class="indexseach">
		<form name="search" id="search" method="GET" action='{$search_url}'>
			<input name="s1" type="hidden" id="s1" value="s"/>
			<input name="w" type="text" id="w" class="it_search" style="width:400px;"/>&nbsp;&nbsp;&nbsp;<button type="submit">Search</button>
			<br />
			<br />
			<br />
			<u>{$language['sebug_home_searchinfo']}</u>
		</form>
		</div>
	</p>
</div>