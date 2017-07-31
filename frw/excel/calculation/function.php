<?php
/**
 * @category   PHPExcel
 * @package    PHPExcel_Calculation
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.7, 2012-05-19
 */

class PHPExcel_Calculation_Function{const CATEGORY_CUBE='Cube';const CATEGORY_DATABASE='Database';const CATEGORY_DATE_AND_TIME='Date and Time';const CATEGORY_ENGINEERING='Engineering';const CATEGORY_FINANCIAL='Financial';const CATEGORY_INFORMATION='Information';const CATEGORY_LOGICAL='Logical';const CATEGORY_LOOKUP_AND_REFERENCE='Lookup and Reference';const CATEGORY_MATH_AND_TRIG='Math and Trig';const CATEGORY_STATISTICAL='Statistical';const CATEGORY_TEXT_AND_DATA='Text and Data';private $_category;private $_excelName;private $_phpExcelName;public function __construct($pCategory=NULL,$pExcelName=NULL,$pPHPExcelName=NULL){if(($pCategory!==NULL)&&($pExcelName!==NULL)&&($pPHPExcelName!==NULL)){$this->_category=$pCategory;$this->_excelName=$pExcelName;$this->_phpExcelName=$pPHPExcelName;}else{throw new Exception("Invalid parameters passed.");}}public function getCategory(){return $this->_category;}public function setCategory($value=null){if(!is_null($value)){$this->_category=$value;}else{throw new Exception("Invalid parameter passed.");}}public function getExcelName(){return $this->_excelName;}public function setExcelName($value){$this->_excelName=$value;}public function getPHPExcelName(){return $this->_phpExcelName;}public function setPHPExcelName($value){$this->_phpExcelName=$value;}}