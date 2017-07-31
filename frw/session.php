<?php
/**
* @version		$Id: session.php 3 2014-01-29 15:53 phu $
* @package		vFramework
* @copyright	Copyright (C) 2010 Vipcom. All rights reserved.
* @license		Commercial, see license.php
*/
defined('V_LIFE')or die('v');
class vSession{private static $_s;var $state=null;var $_namespace='';public static function instance(){if(is_null(self::$_s))self::$_s=new self();return self::$_s;}function __construct(){$this->session('start');}function __destruct(){$this->session('close');}function sid($sid=null){$e='sid'.((defined('V_CP'))?'.cp':'');if($sid)return $this->session('set',$e,$sid);return $this->session('get',$e);}function session($task,$name='',$value=null,$namespace=null){global $cfg;$namespace=($namespace)?'__'.$namespace:$this->_namespace;switch($task){case 'unset':case 'clear':$value=null;case 'set':$old=isset($_SESSION[$namespace][$name])?$_SESSION[$namespace][$name]:null;if(null===$value){unset($_SESSION[$namespace][$name]);}else{$_SESSION[$namespace][$name]=$value;}return $old;break;case 'get':if(isset($_SESSION[$namespace][$name])){return $_SESSION[$namespace][$name];}return $value;break;case 'start':if(version_compare(PHP_VERSION,'5')==-1)register_shutdown_function((array(&$this,'__destruct')));$this->_namespace=($cfg['session_handler'])?$cfg['session_handler']:'__'.substr($cfg['vkey'],0,10);if(session_id()){session_unset();session_destroy();}session_start();header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');break;case 'close':session_write_close();break;default:return isset($_SESSION[$namespace][$name]);break;}}}