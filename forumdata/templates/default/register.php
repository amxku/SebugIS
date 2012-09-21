<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}

<script type="text/javascript" src="{$url}include/jscript/common.js"></script>
<script type="text/javascript" src="{$url}include/jscript/login.js"></script>
<form action="{$url}login.php?s1=doregister" method="post" onsubmit="return checkregform();">
<input type="hidden" name="s1" value="doregister" />
<div id="content">
	<br /><br />
	<p><Strong>{$language['lo_create_acc']}</Strong><br /><br />
	<p>
		<label for="username">{$language['add_t_UserName']}<br />
			<input name="username" id="username" type="text" style="width:240px;" tabindex="1" value="" autocomplete="off"/><br />{$language['login_username_length']}
		</label>
		<br /><br />
		
		<table width="80%" border="0">
			<tr>
				<td>
					{$language['lo_Re_password']}(*):<br />
					<input name="password" id="password" type="password" style="width:240px;" tabindex="2" value=""/><br />{$language['login_passwd_length']}
				</td>
				<td>
					{$language['lo_Re_password']}(*):<br />
					<input name="confirmpassword" id="confirmpassword" type="password" style="width:240px;" tabindex="3" value=""/><br />{$language['lo_Re_password']}
				</td>
			</tr>
		</table>
		<br />
		<label for="password">email address:(*):<br />
			<input name="email" id="email" type="text" style="width:240px;" tabindex="4" value="" autocomplete="off"/><br />e.g. myname@sebug.net
		</label>
		<br /><br />
		
		<label for="password">Homepage:<br />
			<input name="homepage" id="homepage" type="text" style="width:240px;" tabindex="5" value="" autocomplete="off"/><br />e.g. http://sebug.net
		</label>
		<br /><br />	
		
		<label for="clientcode">{$language['add_t_clientcode']}<br /><span id="seccodeimage"></span><br />
			<input onfocus="updateseccode();this.onfocus = null;" name="clientcode" id="clientcode" value="" tabindex="6" class="formfield" style="width:240px;" maxlength="6" autocomplete="off"/>
		</label>
	</p>
	<br />
	<p>
		<button type="submit" tabindex="7">{$language['lo_Register']}</button>
	</p>
</div>
</form>