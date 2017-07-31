<?php
/**
* @version		$Id: group.php 3 2012-09-04 13:39 phu $
* @package		vFramework.cp.banner
* @copyright	(C) 2012 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');$group_cfg=array('table'=>'banner','structure'=>'id:int,title,count:int','langs'=>0,'task'=>array('index'=>array('type'=>4,'auth'=>'access','cmd'=>'create,delete','filter'=>'search','field'=>'id,title,count','render'=>'title,count',),'edit'=>array('type'=>12,'auth'=>'access','field'=>'title','notnull'=>'title',),'resync'=>array('type'=>23,'auth'=>'access',),'delete'=>array('auth'=>'delete',)));
class Group extends vCPController{public function index_data($d=null){$d=parent::data($d);for($i=0,$n=count($d);$i<$n;$i++){$d[$i]['U_VIEW']=$this->cfg['url'].'&'.VAR_SECTION.'='.$d[$i]['id'];}return $d;}public function resync_task(){$this->model->resync();$this->ret=1;}public function delete_task(){$ids=vRequest::_var('ids');if($ids){foreach($ids as $id){$db=vDatabase::instance();$s='SELECT count(id) as counter FROM #__banners WHERE pid='.$id;if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);if($db->fetch_field('counter')==0){$s='DELETE FROM #__banner WHERE id='.$id;if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);}else{$tpl=vTemplate::instance();cpPage::error($tpl->l['ERR_DEL_EMPTY']);}}}$this->ret=1;}}$ctrl=new Group();$ctrl->exec();unset($ctrl);