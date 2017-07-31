<?php
/**
 * @category   PHPExcel
 * @package    PHPExcel_Reader
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.7, 2012-05-19
 */
if(!defined('PHPEXCEL_ROOT')){define('PHPEXCEL_ROOT',dirname(__FILE__).'/../../');require(PHPEXCEL_ROOT.'PHPExcel/Autoloader.php');}
class PHPExcel_Reader_DefaultReadFilter{public function readCell($column,$row,$worksheetName=''){return true;}}