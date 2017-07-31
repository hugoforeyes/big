<?php
/**
* @version		$Id: index.php 3 2013-04-23 08:26 phu $
* @package		vFramework 1.9
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @link				http://www.vipcom.vn
* @license		Commercial
*/
define('V_LIFE',1);define('V_CP',1);define('URL_HELP','https://vipcom.vn/vframework/');define('URL_HELP_EN','https://vipcom.vn/vframework/');define('DS',DIRECTORY_SEPARATOR);define('PATH_CP',dirname(__FILE__));define('PATH_ROOT',substr(PATH_CP,0,strrpos(PATH_CP,DS)));define('PATH_CORE',PATH_ROOT.DS.'frw');define('PATH_CP_CORE',PATH_CP.DS.'frw');define('DEF_POS','HDR,LEF,RIG,CTN,FTR,P01,P02,P03,P04,P05,P06,P07,P08,P09,INC');require PATH_CP_CORE.DS.'cp.php';