<?if(!defined('SEBUG_ROOT')) {exit('Access Denied');}?>

{template header}
<!--{if $ssd_uid}-->
<script type="text/javascript" src="{$url}include/jscript/common.js"></script>
<script type="text/javascript" src="{$url}include/jscript/addinfo.js"></script>
<br />
<form method="POST" action="{$url}login.php?s1=doaddexp" onsubmit="return checkexpform();">
<input type="hidden" name="s1" value="doaddexp" />
<table border="0" align="center" cellpadding="5" cellspacing="5" >
			<tr>
				<td align="right">{$language['add_t_Title']}</td>
				<td align="left"><input name="exp_title" type="text" id="exp_title" tabindex="1" style="width:500px;"/>   <span class="tags">*</span></td>
			</tr>
			<tr>
				<td align="right">{$language['add_t_Published']}</td>
				<td align="left"><input name="exp_putime" type="text" id="exp_putime" value="yyyy-mm-dd" tabindex="2" style="width:500px;"/>   <span class="tags">*</span>[e.g 2008-10-10]</td>
			</tr>
			<tr>
			<td align="right">{$language['sebug_title_appdir']}:</td>
			<td><select name="systype" id="systype">
                          <option value=''>---{$language['sebug_title_appdir']}---</option>
                          <!--{loop $checktype_db $type_list}--><option value='{$type_list['typeid']}'>{$type_list['type_name']}</option><!--{/loop}-->
                        </select></td>
			</tr>
			<tr>
				<td align="right">{$language['add_t_System']}</td>
				<td align="left"><select name="bug_os" id="bug_os" tabindex="2">
					<option value="">{$language['sebug_list_os']}</option>
					<option value="6">>>Web App</option>
					<option value="3">>>UNIX</option>
					<option value="7">>>HP-UX </option>
					<option value="9">>>OTHER</option>
					<option value="2">>>Linux</option>
					<option value="4">>>SunOS</option>
					<option value="5">>>MacOS</option>
					<option value="1">>>Windows</option>
					<option value="8">>>AIX</option>
					<option value="10">>>{$language['sebug_list_os_1']}</option>
					<option value="11">>>Android</option>
					</select>   <span class="tags">*</span>[e.g windows]</td>
			</tr>
			<tr>
				<td align="right">{$language['add_t_Type']}</td>
				<td align="left"><select name="bug_be_type" id="bug_be_type" tabindex="3">
					<option value=''>{$language['sebug_list_type']}</option>
					<option value='1'>{$language['sebug_list_type_1']}</option>
					<option value='2'>{$language['sebug_list_type_2']}</option>
					<option value='3'>{$language['sebug_list_type_3']}</option>
					<option value='4'>{$language['sebug_list_type_4']}</option>
					<option value='5'>other</option>
					<option value='6'>{$language['sebug_list_type_6']}</option>
					<option value='7'>{$language['sebug_list_type_7']}</option>	
					<option value='8'>{$language['sebug_list_type_8']}</option>
					<option value='8'>{$language['sebug_list_type_9']}</option>
					<option value='8'>{$language['sebug_list_type_10']}</option>
					<option value='8'>{$language['sebug_list_type_11']}</option>
					<option value='8'>{$language['sebug_list_type_12']}</option>
					<option value='8'>{$language['sebug_list_type_13']}</option>
					<option value='8'>{$language['sebug_list_type_14']}</option>
					<option value='8'>{$language['sebug_list_type_15']}</option>
					<option value='8'>{$language['sebug_list_type_16']}</option>
					<option value='8'>{$language['sebug_list_type_17']}</option>
					</select>   <span class="tags">*</span>[e.g {$language['sebug_list_type_3']}]</td>
			</tr>
			<tr>
				<td align="right" valign="top">{$language['add_t_Exploite']}</td>
				<td align="left"><textarea name="exp_exp" rows="12" id="exp_exp" tabindex="4" style="width:700px;"></textarea>   <span class="tags">*</span></td>
			</tr>
					<tr>
				<td align="right" valign="top">{$language['add_t_clientcode']}</td>
				<td align="left" valign="top"><input onfocus="updateseccode();this.onfocus = null;" name="clientcode" id="clientcode" value="" size="5" maxlength="6" tabindex="5" style="width:240px;" autocomplete="off">   <span class="tags">*</span><br /><span id="seccodeimage"></span></td>
			</tr>
			<input name="check_code" type="hidden" id="check_code" value="{$check_time}"/>
</table>
<br />
<p>
	&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" tabindex="6">{$language['lo_Submit']}</button><br><br>
</p>
</form>
<!--{/if}-->