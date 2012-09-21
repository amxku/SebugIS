<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<script type="text/javascript" src="{$url}include/jscript/common.js"></script>
<script type="text/javascript" src="{$url}include/jscript/login.js"></script>
<form action="{$url}login.php?s1=dologin" method="post" onsubmit="return checkloginform();">
<input type="hidden" name="s1" value="dologin" />
<div id="content">
	<br /><br />
	<p><Strong>{$language['lo_Sign_in_1']}</Strong><br /><br />
		{$language['lo_Sign_in_2']}<a href="{$reg_url}">{$language['lo_Sign_in_3']}</a></p>
	<br />
	<p>
		<label for="username">{$language['add_t_UserName']}<br />
			<input name="username" id="username" type="text" style="width:240px;" tabindex="1" value="" autocomplete="off"/>
		</label>
		<br /><br />
		
		<label for="password">{$language['add_t_PassWord']}<br />
			<input name="password" id="password" type="password" style="width:240px;" tabindex="2" value=""/><br />{$language['lo_forgotten_password']}
		</label>
		<br /><br />
		
		<label for="clientcode">{$language['add_t_clientcode']}<br /><span id="seccodeimage"></span><br />
			<input onfocus="updateseccode();this.onfocus = null;" name="clientcode" id="clientcode" value="" tabindex="3" class="formfield" style="width:240px;" maxlength="6" autocomplete="off"/>
		</label>
	</p>
	<br />
	<p>
		<button type="submit" tabindex="4">{$language['lo_login']}</button>
	</p>
</div>
</form>