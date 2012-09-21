<?php if(!defined('SEBUG_ROOT')) exit('Access Denied');?>
<h3></h3>
<form action="" method="post">
<input type="hidden" name="action" value="login" />
<div>
	<p>
		<label for="name">
			username：<input name="name" id="name" type="password" style="width:200px;" tabindex="1" value=""/>
		</label>
		<br /><br />
		<label for="password">
			password：<input name="password" id="password" type="password" style="width:200px;" tabindex="2" value=""/>
		</label>
	</p>

	<p>
		<button type="submit" tabindex="4">==Submit==</button>
	</p>
</div>
</form>