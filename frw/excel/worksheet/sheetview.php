<?php
/**
 * @category   PHPExcel
 * @package    PHPExcel_Worksheet
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.7, 2012-05-19
 */

class PHPExcel_Worksheet_SheetView{private $_zoomScale=100;private $_zoomScaleNormal=100;public function __construct(){}public function getZoomScale(){return $this->_zoomScale;}public function setZoomScale($pValue=100){if(($pValue>=1)||is_null($pValue)){$this->_zoomScale=$pValue;}else{throw new Exception("Scale must be greater than or equal to 1.");}return $this;}public function getZoomScaleNormal(){return $this->_zoomScaleNormal;}public function setZoomScaleNormal($pValue=100){if(($pValue>=1)||is_null($pValue)){$this->_zoomScaleNormal=$pValue;}else{throw new Exception("Scale must be greater than or equal to 1.");}return $this;}public function __clone(){$vars=get_object_vars($this);foreach($vars as $key=>$value){if(is_object($value)){$this->$key=clone $value;}else{$this->$key=$value;}}}}