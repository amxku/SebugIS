<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}
<!--{if $ssd_uid}-->
<script type="text/javascript" src="{$url}include/jscript/common.js"></script>
<script type="text/javascript" src="{$url}include/jscript/login.js"></script>
<form action="{$url}login.php?s1=modpro" method="post" onsubmit="return checkproform();">
<input type="hidden" name="s1" value="modpro" />
<div id="content">
	<br /><br />
	<p>		
		<label for="Old_password">{$language['add_t_PassWord']}<br />
			<input name="oldpassword" id="oldpassword" type="password" style="width:240px;" tabindex="1" value=""/>
		</label>
		<br /><br />
		<table width="80%" border="0">
			<tr>
				<td>
					News password: (*):<br />
					<input name="newpassword" id="newpassword" type="password" style="width:240px;" tabindex="2" value=""/><br />{$language['login_passwd_length']}
				</td>
				<td>
					{$language['lo_Re_password']}(*):<br />
					<input name="confirmpassword" id="confirmpassword" type="password" style="width:240px;" tabindex="3" value=""/><br />{$language['lo_Re_password']}
					</td>
			</tr>
		</table>
		<br />
		<label for="email">email address:(*):<br />
			<input name="email" id="email" type="text" style="width:240px;" tabindex="4" value="{$user['email']}"/>
		</label>
		<br /><br />
		
		<label for="Homepage">Homepage:<br />
			<input name="homepage" id="homepage" type="text" style="width:240px;" tabindex="5" value="{$user['homepage']}"/>
		</label>
		<br /><br />	
		
		<label for="clientcode">{$language['add_t_clientcode']}<br /><span id="seccodeimage"></span><br />
			<input onfocus="updateseccode();this.onfocus = null;" name="clientcode" id="clientcode" value="" tabindex="6" class="formfield" style="width:240px;" maxlength="6" autocomplete="off"/>
		</label>
	</p>
	<br />
	<p>
		<button type="submit" tabindex="7">{$language['lo_Submit']}</button><br><br>
	</p>
</div>
</form>
<!--{/if}-->