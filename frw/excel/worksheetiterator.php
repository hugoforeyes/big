<?php
/**
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.7, 2012-05-19
 */

class PHPExcel_WorksheetIterator implements Iterator{private $_subject;private $_position=0;public function __construct(PHPExcel $subject=null){$this->_subject=$subject;}public function __destruct(){unset($this->_subject);}public function rewind(){$this->_position=0;}public function current(){return $this->_subject->getSheet($this->_position);}public function key(){return $this->_position;}public function next(){++$this->_position;}public function valid(){return $this->_position<$this->_subject->getSheetCount();}}