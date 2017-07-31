<?php
/**
 * @version		$Id: blk_nav.php 3 2014-12-29 15:44 phu $
 * @package		vFramework.block.nav
 * @copyright	(C) 2014 Vipcom. All rights reserved.
 * @license		Commercial
 *
 * Breadcrumbs format https://support.google.com/webmasters/answer/185417?hl=en
 */
defined('V_LIFE')or die('v');function blk_nav($p=''){global $tpl,$map,$alt,$cfg;$o=& $p['prop'];if($alt['page']&&$alt['page']!='/'){$tpl->theme('block','blk_nav');$tpl->block('blk',array('CSS'=>$tpl->css($o['css'],'.vf_block breadcrumbs'),'CON'=>$o['con'],));$b=array(0=>'rdfa',1=>'microdata',2=>'row');$b=(isset($o['nav'])&&isset($b[$o['nav']]))?$b[$o['nav']]:$b[0];if(isset($p['prop']['nah'])&&$p['prop']['nah']){$tpl->block('blk.'.$b,array('TIT'=>$map->h['title'],'URL'=>URL_BASE,'POS'=>0,));}$m=&$map->r[$alt['page']];$u=VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&':'').VAR_PAGE.'=';if($m['tree']['p']&&isset($p['prop']['pat'])&&$p['prop']['pat']){$k=explode(',',$m['tree']['p']);foreach($k as $i){if($map->i[$i]['alias']!='/'){$tpl->block('blk.'.$b,array('TIT'=>$map->i[$i]['title'],'URL'=>$u.$map->i[$i]['alias'],'POS'=>1,));}}}$tpl->block('blk.'.$b,array('TIT'=>$m['title'],'URL'=>$u.$m['alias'],'POS'=>2,));if(isset($cfg['~nav'])&&$cfg['~nav']){if(!is_array($cfg['~nav'])){$cfg['~nav']=array(0=>array($cfg['~nav'],''));}foreach($cfg['~nav'] as $k=>$v){$tpl->block('blk.'.$b,array('TIT'=>$v[0],'URL'=>$v[1],'POS'=>3,));}}}}