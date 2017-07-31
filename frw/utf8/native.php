<?php
/**
* @version		$Id: native.php 2 2011-09-04 10:49 phu $
* @package		vFramework
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		GPL
*/
defined('V_LIFE')or die('v');function utf8_strpos($str,$needle,$offset=null){if(is_null($offset)){$ar=explode($needle,$str);if(sizeof($ar)>1){return utf8_strlen($ar[0]);}return false;}else{if(!is_int($offset)){trigger_error('utf8_strpos:  Offset must  be an integer',E_USER_ERROR);return false;}$str=utf8_substr($str,$offset);if(false!==($pos=utf8_strpos($str,$needle))){return $pos + $offset;}return false;}}function utf8_strrpos($str,$needle,$offset=null){if(is_null($offset)){$ar=explode($needle,$str);if(sizeof($ar)>1){array_pop($ar);$str=join($needle,$ar);return utf8_strlen($str);}return false;}else{if(!is_int($offset)){trigger_error('utf8_strrpos	expects	parameter 3	to be long',E_USER_ERROR);return false;}$str=utf8_substr($str,$offset);if(false!==($pos=utf8_strrpos($str,$needle))){return $pos + $offset;}return false;}}function utf8_substr($str,$offset,$length=NULL){$str=(string) $str;$offset=(int) $offset;if(!is_null($length)){$length=(int) $length;}if($length===0||($offset<0&&$length<0&&$length<$offset)){return '';}if($offset<0){$strlen=utf8_strlen($str);$offset=$strlen + $offset;if($offset<0){$offset=0;}}$op='';$lp='';if($offset>0){$ox=(int)($offset / 65535);$oy=$offset % 65535;if($ox){$op='(?:.{65535}){'.$ox.'}';}$op='^(?:'.$op.'.{'.$oy.'})';}else{$op='^';}if(is_null($length)){$lp='(.*)$';}else{if(!isset($strlen)){$strlen=utf8_strlen($str);}if($offset>$strlen){return '';}if($length>0){$length=min($strlen - $offset,$length);$lx=(int)($length / 65535);$ly=$length % 65535;if($lx){$lp='(?:.{65535}){'.$lx.'}';}$lp='('.$lp.'.{'.$ly.'})';}else if($length<0){if($length<($offset - $strlen)){return '';}$lx=(int)((-$length)/ 65535);$ly=(-$length)% 65535;if($lx){$lp='(?:.{65535}){'.$lx.'}';}$lp='(.*)(?:'.$lp.'.{'.$ly.'})$';}}if(!preg_match('#'.$op.$lp.'#us',$str,$match)){return '';}return $match[1];}function utf8_strlen($str){return strlen(utf8_decode($str));}function utf8_strtoupper($str){global $UTF8_LOWER_TO_UPPER;return strtr(strtoupper($str),$UTF8_LOWER_TO_UPPER);}function utf8_strtolower($str){global $UTF8_UPPER_TO_LOWER;return strtr(strtolower($str),$UTF8_UPPER_TO_LOWER);}$GLOBALS['UTF8_LOWER_TO_UPPER']=array('ấ'=>'Ấ','ầ'=>'Ầ','ẩ'=>'Ẩ','ẫ'=>'Ẫ','ậ'=>'Ậ','ắ'=>'Ắ','ằ'=>'Ằ','ẳ'=>'Ẳ','ẵ'=>'Ẵ','ặ'=>'Ặ','ạ'=>'Ạ','ả'=>'Ả','ế'=>'Ế','ề'=>'Ề','ể'=>'Ể','ễ'=>'Ễ','ệ'=>'Ệ','ẻ'=>'Ẻ','ẽ'=>'Ẽ','ẹ'=>'Ẹ','ứ'=>'Ứ','ừ'=>'Ừ','ử'=>'Ử','ữ'=>'Ữ','ự'=>'Ự','ố'=>'Ố','ồ'=>'Ồ','ổ'=>'Ổ','ỗ'=>'Ỗ','ộ'=>'Ộ','ớ'=>'Ớ','ờ'=>'Ờ','ở'=>'Ở','ỡ'=>'Ỡ','ợ'=>'Ợ','ọ'=>'Ọ','ỏ'=>'Ỏ','ị'=>'Ị','ỉ'=>'Ỉ','ụ'=>'Ụ','ủ'=>'Ủ','ỳ'=>'Ỳ','ỷ'=>'Ỷ','ỹ'=>'Ỹ','ỵ'=>'Ỵ','â'=>'Â','ă'=>'Ă','á'=>'Á','à'=>'À','ã'=>'Ã','ê'=>'Ê','é'=>'É','è'=>'È','ý'=>'Ý','ư'=>'Ư','ú'=>'Ú','ù'=>'Ù','ũ'=>'Ũ','í'=>'Í','ì'=>'Ì','ĩ'=>'Ĩ','ô'=>'Ô','ơ'=>'Ơ','ó'=>'Ó','ò'=>'Ò','õ'=>'Õ','đ'=>'Đ',);$GLOBALS['UTF8_UPPER_TO_LOWER']=array('Ấ'=>'ấ','Ầ'=>'ầ','Ẩ'=>'ẩ','Ẫ'=>'ẫ','Ậ'=>'ậ','Ắ'=>'ắ','Ằ'=>'ằ','Ẳ'=>'ẳ','Ẵ'=>'ẵ','Ặ'=>'ặ','Ạ'=>'ạ','Ả'=>'ả','Ế'=>'ế','Ề'=>'ề','Ể'=>'ể','Ễ'=>'ễ','Ệ'=>'ệ','Ẻ'=>'ẻ','Ẽ'=>'ẽ','Ẹ'=>'ẹ','Ứ'=>'ứ','Ừ'=>'ừ','Ử'=>'ử','Ữ'=>'ữ','Ự'=>'ự','Ố'=>'ố','Ồ'=>'ồ','Ổ'=>'ổ','Ỗ'=>'ỗ','Ộ'=>'ộ','Ớ'=>'ớ','Ờ'=>'ờ','Ở'=>'ở','Ỡ'=>'ỡ','Ợ'=>'ợ','Ọ'=>'ọ','Ỏ'=>'ỏ','Ị'=>'ị','Ỉ'=>'ỉ','Ụ'=>'ụ','Ủ'=>'ủ','Ỳ'=>'ỳ','Ỷ'=>'ỷ','Ỹ'=>'ỹ','Ỵ'=>'ỵ','Â'=>'â','Ă'=>'ă','Á'=>'á','À'=>'à','Ã'=>'ã','Ê'=>'ê','É'=>'é','È'=>'è','Ý'=>'ý','Ư'=>'ư','Ú'=>'ú','Ù'=>'ù','Ũ'=>'ũ','Í'=>'í','Ì'=>'ì','Ĩ'=>'ĩ','Ô'=>'ô','Ơ'=>'ơ','Ó'=>'ó','Ò'=>'ò','Õ'=>'õ','Đ'=>'đ',);