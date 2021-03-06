<?php
/**
 * @category   PHPExcel
 * @package    PHPExcel_CachedObjectStorage
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.7, 2012-05-19
 */

class PHPExcel_CachedObjectStorage_Memory extends PHPExcel_CachedObjectStorage_CacheBase{public function addCacheData($pCoord,PHPExcel_Cell $cell){$this->_cellCache[$pCoord]=$cell;return $cell;}public function getCacheData($pCoord){if(!isset($this->_cellCache[$pCoord])){return null;}return $this->_cellCache[$pCoord];}public function copyCellCollection(PHPExcel_Worksheet $parent){parent::copyCellCollection($parent);$newCollection=array();foreach($this->_cellCache as $k=>&$cell){$newCollection[$k]=clone $cell;$newCollection[$k]->attach($parent);}$this->_cellCache=$newCollection;}public function unsetWorksheetCells(){foreach($this->_cellCache as $k=>&$cell){$cell->detach();$this->_cellCache[$k]=null;}unset($cell);$this->_cellCache=array();$this->_parent=null;}}