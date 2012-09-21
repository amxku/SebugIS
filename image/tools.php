<?php
/******************************************
Info:SEBUG Security Database
Function:数据库信息
Author:amxku
date:2008/10/10
site:http://www.sebug.net
========CHANGELOG========
*******************************************/
if(!defined('SEBUG_ROOT') || !isset($php_self) || !preg_match("/[\/\\\\]admin\.php$/", $php_self)) {
	exit('Access Denied');
}
if($login){
	!$action && $action = 'mysqlinfo';
	$backupdir = 'forumdata/backup';
	$backuppath = date('Y-m-d',$ontime).'_'.random(16);

	$tables = array(
		$db_prefix.'sebug_data',
		$db_prefix.'type',
		$db_prefix.'sessions',
		$db_prefix.'users',
	);

	// 数据库信息
	if ($action == 'mysqlinfo') {
		$mysql_version = mysql_get_server_info();
		$mysql_runtime = '';
		$query = $DB->query("SHOW STATUS");
		while ($r = $DB->fetch_array($query)) {
			if (eregi("^uptime", $r['Variable_name'])){
				$mysql_runtime = $r['Value'];
			}
		}
		$mysql_runtime = format_timespan($mysql_runtime);

		$query = $DB->query("SHOW TABLE STATUS");
		$sebug_table_num = $sebug_table_rows = $sebug_data_size = $sebug_index_size = $sebug_free_size = 0;
		$other_table_num = $other_table_rows = $other_data_size = $other_index_size = $other_free_size = 0;
		$sebug_table = $other_table = array();
		while($table = $DB->fetch_array($query)) {
			if(in_array($table['Name'],$tables)) {
				$sebug_data_size = $sebug_data_size + $table['Data_length'];
				$sebug_index_size = $sebug_index_size + $table['Index_length'];
				$sebug_table_rows = $sebug_table_rows + $table['Rows'];
				$sebug_free_size = $sebug_free_size + $table['Data_free'];
				$table['Create_time'] = $table['Create_time'] ? $table['Create_time'] : 'Unknow';
				$table['Update_time'] = $table['Update_time'] ? $table['Update_time'] : 'Unknow';
				$table['Data_length'] = get_real_size($table['Data_length']);
				$table['Index_length'] = get_real_size($table['Index_length']);
				$table['Data_free'] = get_real_size($table['Data_free']);
				$sebug_table_num++;
				$sebug_table[] = $table;
			} else {
				$other_data_size = $other_data_size + $table['Data_length'];
				$other_index_size = $other_index_size + $table['Index_length'];
				$other_table_rows = $other_table_rows + $table['Rows'];
				$other_free_size = $other_free_size + $table['Data_free'];
				$table['Create_time'] = $table['Create_time'] ? $table['Create_time'] : 'Unknow';
				$table['Update_time'] = $table['Update_time'] ? $table['Update_time'] : 'Unknow';
				$table['Data_length'] = get_real_size($table['Data_length']);
				$table['Index_length'] = get_real_size($table['Index_length']);
				$table['Data_free'] = get_real_size($table['Data_free']);
				$other_table_num++;
				$other_table[] = $table;
			}
		}
		$sebug_data_size = get_real_size($sebug_data_size);
		$sebug_index_size = get_real_size($sebug_index_size);
		$sebug_free_size = get_real_size($sebug_free_size);
		$other_data_size = get_real_size($other_data_size);
		$other_index_size = get_real_size($other_index_size);
		$other_free_size = get_real_size($other_free_size);
		unset($table);

	}

	// 备份操作
	if ($action == 'dobackup') {
		$volume = intval($volume) + 1;
		$sqlfilename = SEBUG_ROOT.$backupdir.'/'.$filename.'_'.$volume.'.sql';

		if(!$sqlfilename || preg_match("/(\.)(exe|jsp|asp|asa|htr|stm|shtml|php3|aspx|cgi|fcgi|pl|php|bat)(\.|$)/i", $sqlfilename)) {
			redirect('您没有输入备份文件名或文件名中使用了敏感的扩展名.');
		}

		$idstring = '# Identify: '.base64_encode("$ontmie,$url,$volume")."\n";
		
		//清除表内临时的数据
		$DB->unbuffered_query("TRUNCATE TABLE {$db_prefix}sessions");

		$sqlcompat = in_array($sqlcompat, array('MYSQL40', 'MYSQL41')) ? $sqlcompat : '';
		$dumpcharset = str_replace('-', '', $charset);
		$setnames = intval($addsetnames) || ($DB->version() > '4.1' && (!$sqlcompat || $sqlcompat == 'MYSQL41')) ? "SET character_set_connection=".$dumpcharset.", character_set_results=".$dumpcharset.", character_set_client=binary;\n\n" : '';

		if($DB->version() > '4.1') {
			$DB->query("SET character_set_connection=$dumpcharset, character_set_results=$dumpcharset, character_set_client=binary;");
			if($sqlcompat == 'MYSQL40') {
				$DB->query("SET SQL_MODE='MYSQL40'");
			}
		}
			
		$sqldump = '';
		$tableid = $tableid ? $tableid - 1 : 0;
		$startfrom = intval($startfrom);
		for($i = $tableid; $i < count($tables) && strlen($sqldump) < $sizelimit * 1000; $i++) {
			$sqldump .= sqldumptable($tables[$i], $startfrom, strlen($sqldump));
			$startfrom = 0;
		}
		$tableid = $i;
		if(trim($sqldump)) {
			$sqldump = "$idstring".
				"# <?exit();?>\n".
				"# SEBUG.NET bakfile Multi-Volume Data Dump Vol.$volume\n".
				"# Time: ".date('Y-m-d H:i',$ontime)."\n".
				"# http://www.sebug.net\n".
				"# --------------------------------------------------------\n\n\n".$setnames.$sqldump;

			if(!writefile($sqlfilename, $sqldump)) {
				redirect('数据文件无法备份到服务器, 请检查目录属性.', $php_self.'?job=tools&action=backup');
			} else {
				
					require(SEBUG_ROOT.'include/class/zip.class.php');
						if(@function_exists('gzcompress')){
							$faisunZIP = new PHPzip;
							$sqlgzfilename = SEBUG_ROOT.$backupdir.'/'.$filename;
							$gzfilename = $sqlgzfilename.'.zip';
							$faisunZIP -> addfile(implode('',file("$sqlfilename")),"$sqlfilename","$gzfilename");
						}
						@unlink($sqlfilename);
			
				redirect('分卷备份:数据文件 '.$volume.' 成功创建,程序将自动继续.', $php_self."?job=tools&action=dobackup&filename=".rawurlencode($filename)."&sizelimit=".rawurlencode($sizelimit)."&volume=".rawurlencode($volume)."&tableid=".rawurlencode($tableid)."&startfrom=".rawurlencode($startrow)."&sqlcompat=".rawurlencode($sqlcompat));
			}
		} else {
			redirect('数据成功备份至服务器指定文件中', $php_self.'?job=tools&action=backup');
		}

	}

	// 数据库维护操作
	if($action == 'dotools') {
		$doname = array(
			'check' => '检查',
			'repair' => '修复',
			'analyze' => '分析',
			'optimize' => '优化'
		);
		$dodb = $tabledb = array();
		foreach ($do as $value) {
			$dodb[] = array('do'=>$value,'name'=>$doname[$value]);
			foreach ($tables AS $table) {
				if ($DB->query($value.' TABLE '.$table)) {
					$result = '<span class="yes">成功</span>';
				} else {
					$result = '<span class="no">失败</span>';
				}
				$tabledb[] = array('do'=>$value,'table'=>$table,'result'=>$result);
			}
		}
	}// 数据库维护操作结束

	if ($action == 'buildtemplate') {
		buildtemplate("default");
		redirect('更新模板缓存完毕');
	}

	if ($action == 'recache') {
		show_no_recache();
		index_appdir();
		rss_recache();
		checktype();
		redirect('更新数据缓存完毕');
	}

	cpheader();
	include template('tools');
	cpfooter();
}
?>