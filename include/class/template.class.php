<?php
/******************************************
info:SEBUG Security Database
Function:模板类
Author:amxku
date:2008/10/06
site:http://www.sebug.net
========CHANGELOG========
sablog的东西，谢谢angel
******************************************/
if(!defined('SEBUG_ROOT')) {
	exit('Access Denied');
}

function parse_template($tplfile, $objfile) {
	global $options;
	$nest = 5;
	if(!$template = loadfile($tplfile)) {
		//exit('Current template file not found or have no access!');
		exit('www.sebug.net');
	}
	/*
	elseif (!include lang('templates')) {
		exit("Current template pack do not have a necessary language file 'templates.php' or have syntax error!");
	}
	*/
	$var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
	$const_regexp = "([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)";

	$template = preg_replace("/([\n\r]+)\t+/s", "\\1", $template);
	$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);
	$template = preg_replace("/\{lang\s+(.+?)\}/ies", "languagevar('\\1')", $template);


	$template = preg_replace("/\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template);
	$template = preg_replace("/$var_regexp/es", "addquote('<?=\\1?>')", $template);
	$template = preg_replace("/\<\?\=\<\?\=$var_regexp\?\>\?\>/es", "addquote('<?=\\1?>')", $template);

	$template = "<? if(!defined('SEBUG_ROOT')) exit('Access Denied'); ?>\n$template";
	$template = preg_replace("/[\n\r\t]*\{template\s+([a-z0-9_]+)\}[\n\r\t]*/is", "\n<? include template('\\1'); ?>\n", $template);
	$template = preg_replace("/[\n\r\t]*\{template\s+(.+?)\}[\n\r\t]*/is", "\n<? include template(\\1); ?>\n", $template);
	$template = preg_replace("/[\n\r\t]*\{eval\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('\n<? \\1; ?>\n','')", $template);
	$template = preg_replace("/[\n\r\t]*\{elseif\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('\n<? } elseif(\\1) { ?>\n','')", $template);
	$template = preg_replace("/[\n\r\t]*\{else\}[\n\r\t]*/is", "\n<? } else { ?>\n", $template);

	for($i = 0; $i < $nest; $i++) {
		$template = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r]*(.+?)[\n\r]*\{\/loop\}[\n\r\t]*/ies", "stripvtags('\n<? if(is_array(\\1)) { foreach(\\1 as \\2) { ?>','\n\\3\n<? } } ?>\n')", $template);
		$template = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/loop\}[\n\r\t]*/ies", "stripvtags('\n<? if(is_array(\\1)) { foreach(\\1 as \\2 => \\3) { ?>','\n\\4\n<? } } ?>\n')", $template);
		$template = preg_replace("/[\n\r\t]*\{if\s+(.+?)\}[\n\r]*(.+?)[\n\r]*\{\/if\}[\n\r\t]*/ies", "stripvtags('\n<? if(\\1) { ?>','\n\\2\n<? } ?>\n')", $template);
	}

	$template = preg_replace("/\{$const_regexp\}/s", "<?=\\1?>", $template);
	$template = preg_replace("/ \?\>[\n\r]*\<\? /s", " ", $template);
	$template = preg_replace("/\"(http)?[\w\.\/:]+\?[^\"]+?&[^\"]+?\"/e", "transamp('\\0')", $template);


	if (!writefile($objfile, $template)) {
		exit('Directory \'./forumdata/templates_c/\' not found or have no access!');
	}
}

function transamp($str) {
	$str = str_replace('&', '&amp;', $str);
	$str = str_replace('&amp;amp;', '&amp;', $str);
	$str = str_replace('\"', '"', $str);
	return $str;
}

function addquote($var) {
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

function languagevar($var) {
	return $GLOBALS['language'][$var] ? $GLOBALS['language'][$var] : "!$var!";
}

function stripvtags($expr, $statement) {
	$expr = str_replace("\\\"", "\"", preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
	$statement = str_replace("\\\"", "\"", $statement);
	return $expr.$statement;
}
?>