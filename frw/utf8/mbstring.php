<?php
/**
* @version		$Id: mbstring.php 2 2011-09-04 10:49 phu $
* @package		vFramework
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		GPL
*/
defined('V_LIFE')or die('v');function utf8_strpos($str,$needle,$offset=null){if(is_null($offset)){return mb_strpos($str,$needle);}else{return mb_strpos($str,$needle,$offset);}}function utf8_strrpos($str,$search,$offset=false){if($offset===false){if(empty($str)){return false;}return mb_strrpos($str,$search);}else{if(!is_int($offset)){trigger_error('utf8_strrpos expects parameter 3 to be long',E_USER_ERROR);return false;}$str=mb_substr($str,$offset);if(false!==($pos=mb_strrpos($str,$search))){return $pos + $offset;}return false;}}function utf8_substr($str,$offset,$length=null){if(is_null($length)){return mb_substr($str,$offset);}else{return mb_substr($str,$offset,$length);}}function utf8_strlen($str){return mb_strlen($str,'utf-8');}function utf8_strtoupper($str){return mb_strtoupper($str);}function utf8_strtolower($str){return mb_strtolower($str);}