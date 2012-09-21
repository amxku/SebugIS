-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 07 月 09 日 16:52
-- 服务器版本: 5.0.67
-- PHP 版本: 5.2.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sebug.net`
--

-- --------------------------------------------------------

--
-- 表的结构 `net_sebug_data`
--

CREATE TABLE IF NOT EXISTS `net_sebug_data` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `Categories` int(1) NOT NULL,
  `uid` int(11) default NULL,
  `os` int(4) default '0',
  `be_type` int(1) NOT NULL default '0',
  `typeid` int(11) NOT NULL,
  `attime` varchar(11) NOT NULL,
  `putime` varchar(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `Impact` text NOT NULL,
  `grades` int(1) NOT NULL default '0',
  `buginfo` mediumtext NOT NULL,
  `ress` mediumtext NOT NULL,
  `reference` text NOT NULL,
  `bugexp` mediumtext NOT NULL,
  `checked` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `Categories` (`Categories`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11778 ;

-- --------------------------------------------------------

--
-- 表的结构 `net_sessions`
--

CREATE TABLE IF NOT EXISTS `net_sessions` (
  `hash` varchar(20) NOT NULL default '',
  `ip1` tinyint(3) NOT NULL,
  `ip2` tinyint(3) NOT NULL,
  `ip3` tinyint(3) NOT NULL,
  `ip4` tinyint(3) NOT NULL,
  `uid` mediumint(8) NOT NULL default '0',
  `ipaddress` varchar(16) NOT NULL default '',
  `agent` varchar(200) NOT NULL default '',
  `lastactivity` int(10) NOT NULL default '0',
  `seccode` mediumint(9) NOT NULL,
  PRIMARY KEY  (`hash`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `net_type`
--

CREATE TABLE IF NOT EXISTS `net_type` (
  `typeid` bigint(10) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `b_time` int(11) default NULL,
  `type_name` varchar(250) default NULL,
  `type_info` mediumtext,
  `website` varchar(100) NOT NULL,
  `v_num` int(10) default '0',
  `checked` int(1) NOT NULL default '0',
  `check_view` int(1) NOT NULL default '0',
  PRIMARY KEY  (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=414 ;

-- --------------------------------------------------------

--
-- 表的结构 `net_users`
--

CREATE TABLE IF NOT EXISTS `net_users` (
  `userid` mediumint(8) unsigned NOT NULL auto_increment,
  `username` char(15) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `regip` char(15) NOT NULL default '',
  `regdate` int(10) unsigned NOT NULL default '0',
  `lastip` char(15) NOT NULL default '',
  `lastactivity` int(10) unsigned NOT NULL default '0',
  `email` char(50) NOT NULL default '',
  `homepage` varchar(40) NOT NULL,
  `sebugt` int(11) NOT NULL,
  `checked` int(11) NOT NULL default '0',
  `logincount` text NOT NULL,
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=757 ;
