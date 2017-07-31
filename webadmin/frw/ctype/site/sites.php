<?php
/**
* @version		$Id: sites.php 2 2012-05-20 17:07 phu $
* @package		vFramework.cp.site
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');$sites_cfg=array('table'=>'site','structure'=>'id:int,title:string,domain:string,def:int','task'=>array('index'=>array('type'=>4,'auth'=>'access','filter'=>'search','cmd'=>'default','field'=>'id,title,domain,def','render'=>'title,domain',),'default'=>array('auth'=>'admin',),));
class Sites extends vCPController{public function __construct(){$this->model=new SitesModel();parent::__construct();}public function index_data($d=null){$d=parent::data($d);for($i=0,$n=count($d);$i<$n;$i++){$v=&$d[$i];$v['CMD']='';$v['CSS']=(V_SITE==$v['id'])?'disabled':'enabled';$v['ICON']=($v['def']==1)?'<span class="ico ihot"></span>':'';$v['U_VIEW']=(V_SITE==$v['id'])?'':$this->cfg['url'].'&amp;'.VAR_ID.'='.$v['id'];}return $d;}public function default_task(){global $db;$i=vRequest::_var('ids');if(is_array($i))$i=array_shift($i);$i=intval($i);$s='UPDATE #__'.$this->cfg['table'].' SET def=1 WHERE id='.$i;if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);$s='UPDATE #__'.$this->cfg['table'].' SET def=0 WHERE id<>'.$i;if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);$this->ret=1;}}
class SitesModel extends vCPModel{protected function records_sql($a=0){global $alt;$s=parent::records_sql($a);$s['o']=' ORDER BY a.id ASC';$s['w'].=' OR a.domain LIKE "%'.$alt['keyword'].'%"';return $s;}}$ctrl=new Sites();$ctrl->exec();unset($ctrl);