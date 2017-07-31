<?php
/**
 * @category   PHPExcel
 * @package    PHPExcel_Writer_Excel2007
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.7, 2012-05-19
 */
abstract 
class PHPExcel_Writer_Excel2007_WriterPart{private $_parentWriter;public function setParentWriter(PHPExcel_Writer_IWriter $pWriter=null){$this->_parentWriter=$pWriter;}public function getParentWriter(){if(!is_null($this->_parentWriter)){return $this->_parentWriter;}else{throw new Exception("No parent PHPExcel_Writer_IWriter assigned.");}}public function __construct($pWriter=null){if(!is_null($pWriter)){$this->_parentWriter=$pWriter;}}}