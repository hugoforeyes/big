<?php
/**
* @version		$Id: article.php 3 2012-09-06 08:26 phu $
* @package		vFramework.cp.article
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');$article_cfg=array('structure'=>'id:int,cid:page,lang,title,alias,preview:text,content:html,pic_thumb:image,hits:int,hot:int,ordering:int,prop:prop,meta:meta,created:timestamp,modified:timestamp,published:timestamp','langs'=>1,'task'=>array('index'=>array('type'=>4,'auth'=>'access','cmd'=>'create,delete,publish,hot,move,imexport','filter'=>'search,publish,order','field'=>'id,lang,title,pic_thumb,hot,hits,published,ordering','render'=>'title,hits,published,ordering',),'edit'=>array('type'=>12,'auth'=>'edit','field'=>'lang,title,alias,pic_thumb,preview,content,prop,meta,published','notnull'=>'title',),'view'=>array('type'=>1,'auth'=>'access',),'delete'=>array('type'=>11,'auth'=>'delete','ret'=>'',),'publish'=>array('type'=>21,'field'=>'published','auth'=>'publish','ret'=>'',),'hot'=>array('type'=>21,'field'=>'hot','auth'=>'publish','ret'=>'',),'order'=>array('type'=>22,'auth'=>'move',),'resync'=>array('type'=>23,'field'=>'id,ordering',),'imexport'=>array('type'=>31,'field'=>'id,title,pic_thumb,preview,content,published,prop,meta','render'=>'prop,meta','auth'=>'admin','paging'=>200,),),);
class Article extends vCPController{public function __construct(){$this->view=new ArticleView();parent::__construct();if(!isset($this->cfg['structure']['ordering'])){unset($this->cfg['task']['resync']);unset($this->cfg['type'][23]);}if($o=&$this->cfg['prop']){if(!isset($o['pic_thumb'])||!$o['pic_thumb'])unset($this->cfg['structure']['pic_thumb']);if(!isset($o['pre'])||!$o['pre'])unset($this->cfg['structure']['preview']);}}}
class ArticleView extends vCPView{protected function view_tpl($d){$tpl=vTemplate::instance();$h='<div class="vf_ctn"><h1 class="vf_tit">'.$d['title'].'</h1>'.$tpl->purl($d['content']).'</div>';unset($d['title']);unset($d['content']);unset($d['prop']);$h2=substr(parent::tpl($d),1);return $h.$h2;}}$ctrl=new Article();$ctrl->exec();unset($ctrl);