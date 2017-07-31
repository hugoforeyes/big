<?php
/**
* @version		$Id: group.php 2 2012-02-14 13:28 phu $
* @package		vFramework.cp.staff
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class Staff_Grp extends vCPModule{protected $model='id:int,title:string,prop:prop,readonly:int';protected $task=array('listing'=>array('auth'=>'access','cmd'=>'create,delete','filter'=>'search','model'=>'title,prop,readonly',),'edit'=>array('auth'=>'access','model'=>'title,prop','null'=>'title',),'delete'=>array('auth'=>'delete',),);protected function edit($f=true){global $alt,$map;$alt['module']['prop']=vRegistry::parse("access=bool\nedit=bool\ndelete=bool\ncreate=bool\npublish=bool\nmove=bool\nown=bool\nmanage=bool");parent::edit($f);}protected function listing_sql(){global $alt;$s=parent::listing_sql();$s[0]['o']=' ORDER BY id ASC';return $s;}protected function listing_data($d){global $tpl,$stf;for($i=0,$n=count($d);$i<$n;$i++){$v=&$d[$i];if($v['readonly'])$v['id']=0;}$d=parent::listing_data($d);for($i=0,$n=count($d);$i<$n;$i++){$v=&$d[$i];if($v['readonly'])$v['CMD']='';$v['prop']=vRegistry::parse($v['prop']);$t=array();foreach($v['prop'] as $k=>$a)if($a)$t[]=$tpl->_('PROP_'.$k);$v['prop']=implode(', ',$t);}array_pop($this->task['listing']['model']);return $d;}}