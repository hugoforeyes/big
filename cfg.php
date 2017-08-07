<?php
/**
* @version		$Id: cfg.php 3 2013-08-27 08:40 phu $
* @package		vFramework.cfg
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE') or die('v');

// Load config

$cfg = array(
	'vkey' => 'REPLACE_YOUR_LICENSE_KEY',
	'vchar' => '',
	'ver' => '1.9.10',

	'db' => array(
		'type' => 'mysql',
		'host' => 'localhost',
		'name' => 'big',
		'user' => 'root',
		'pass' => '123456',
		'prefix' => 'vf_'
	),

	// Open Graph protocol
	'og' => 1,

	'base' => '/big/',
	'site' => 'Big',

	//'404' => '',
	'session_lifetime' => 60*60,
	'session_handler' => 'big',
	'offline' => '',
	'debug' => 1,
	'timezone' => 'Asia/Ho_Chi_Minh',
	'gzip' => 0,
	'log' => '0',
	'mobi' => 0,
	'sef' => 1,
	'canon' => 1, // 0, 1=redirect, 2=element, 3=all

	'lang' => 'en',
	'language' => array(
		'en' => array('en-GB', 'English', 0),
	),

	'cache' => 0,
	'cache_time' => '',

	'decimal' => 0,
	'decimal_symbol' => ',',
	'grouping_symbol' => '.',

	'email' => 'REPLACE',
	'mailer' => '',
	'smtp' => array(
		'host' => '',
		'user' => '',
		'pass' => '',
		'port' => ''
	),

	'ftp' => array(
		'enable' => 0,
		'host' => '127.0.0.1',
		'port' => '21',
		'mode' => 0,
		'user' => '',
		'pass' => '',
		'root' => ''
	),

	'date' => array(
		'short' => "%d-%m-%Y",
		'long' => "%d-%m-%Y",
		'time' => "%d-%m-%Y %H:%M",
		'full' => "%d-%m-%Y %I:%M %p",
		'hour' => "%H:%M",
		'input' => "%Y-%m-%d %H:%M:%S"
	),

	'file' => array(
		'sfn' => 0,
		'ext' => 'csv,doc,odg,odp,ods,odt,pdf,ppt,txt,xcf,xls,xlsx,docx,xml,zip,rar,tar,gz',
		'media' => 'swf,flv,mp3,wav',
		'image' => 'bmp,gif,jpg,jpeg,png,swf',
		'size' => '104857600', //10mb
		'chunk' => '1048576', //1mb
		'dir' => '{YY}' //{ID}{ALIAS}{M}{MM}{Y}{YY}
	),

	'theme' => 'vip',
	'theme_page' => 'page',
	'theme_style' => 'css/style',

	'cp' => array(
		'theme' => 'vip',
		'theme_page' => 'page',
		'theme_style' => 'style',
		'lang' => 'en'
	),

	'paging' => 15,
	'flood' => 60,	//seconds
);