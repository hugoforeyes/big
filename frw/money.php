<?php
/**
* @version		$Id: money.php 2 2012-04-09 13:46 phu $
* @package		vFramework.money
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class vMoney{static function out($n){global $cfg;return number_format($n,$cfg['decimal'],$cfg['decimal_symbol'],$cfg['grouping_symbol']);}static function in(){}}