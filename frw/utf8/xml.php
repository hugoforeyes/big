<?php
/**
* @version		$Id: xml.php 2 2011-09-04 10:49 phu $
* @package		vFramework
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		GPL
*/
defined('V_LIFE')or die('v');function utf8_encode($str){$out='';for($i=0,$len=strlen($str);$i<$len;$i++){$letter=$str[$i];$num=ord($letter);if($num<0x80){$out.=$letter;}else if($num<0xC0){$out.="\xC2".$letter;}else{$out.="\xC3".chr($num - 64);}}return $out;}function utf8_decode($str){$pos=0;$len=strlen($str);$ret='';while($pos<$len){$ord=ord($str[$pos])& 0xF0;if($ord===0xC0||$ord===0xD0){$charval=((ord($str[$pos])& 0x1F)<<6)|(ord($str[$pos + 1])& 0x3F);$pos+=2;$ret.=(($charval<256)?chr($charval):'?');}else if($ord===0xE0){$ret.='?';$pos+=3;}else if($ord===0xF0){$ret.='?';$pos+=4;}else{$ret.=$str[$pos];++$pos;}}return $ret;}