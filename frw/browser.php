<?php
/**
 * @version		$Id: browser.php 2 2012-03-07 10:21 Phu $
 * @package		vFramework.core.browser
 * @copyright	(C) 2011 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE')or die('v');
class vBrowser{static function mobile(){$r="/(nokia|iphone|ipad|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";$r.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";$r.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";$r.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";$r.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";$r.=")/i";return isset($_SERVER['HTTP_X_WAP_PROFILE'])or isset($_SERVER['HTTP_PROFILE'])or preg_match($r,strtolower($_SERVER['HTTP_USER_AGENT']));}static function javascript(){$r="/(nokia|iphone|ipad|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";$r.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";$r.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";$r.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";$r.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";$r.=")/i";return preg_match($r,strtolower($_SERVER['HTTP_USER_AGENT']));}}