<?php
/**
* @version		$Id: json.php 3 2014-06-11 8:26 phu $
* @package		vFramework.core.json
* @copyright	(C) 2014 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class vJSON{static function parse($s){$a=$s;return $a;}static function render($s,$c=false){if($c===false){header('Cache-Control: no-store, no-cache, must-revalidate');header('Cache-Control: post-check=0, pre-check=0',false);header('Pragma: no-cache');}echo json_encode($s);}}