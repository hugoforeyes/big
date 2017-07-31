<?php
/**
* @version		$Id: article.php 2 2011-11-07 08:26 phu $
* @package		vFramework.article
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');$article_cfg=array('structure'=>'id:int,cid:page,lang,title,alias,preview:text,content:html,pic_thumb:image,hits:int,hot:int,ordering:int,prop:prop,meta:meta,created:timestamp,modified:timestamp,published:timestamp','langs'=>1,'tpl'=>'article','task'=>array('cat'=>array('type'=>3,'field'=>'cid,title,pic_thumb,preview,prop,hits,created,modified,published',),'list'=>array('type'=>2,'field'=>'title,pic_thumb,preview,prop,hits,created,modified,published',),'view'=>array('type'=>1,'field'=>'title,pic_thumb,preview,content,prop,meta,hits,ordering,created,modified,published','next'=>'title,pic_thumb,preview,prop',),));
class Article extends vController{public function __construct(){global $alt;if($alt['section']||$alt['keyword']||$alt['task'])vPage::http404();parent::__construct();if($o=&$this->cfg['prop']){if(!isset($o['pic_thumb'])||!$o['pic_thumb'])unset($this->cfg['structure']['pic_thumb']);if(!isset($o['pre'])||!$o['pre'])unset($this->cfg['structure']['preview']);}}}$ctrl=new Article();$ctrl->exec();unset($ctrl);