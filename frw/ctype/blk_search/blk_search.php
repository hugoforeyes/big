<?php
/**
 * @version		$Id: blk_search.php 3 2013-05-24 10:02 phu $
 * @package		vFramework.block.search
 * @copyright	(C) 2011 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE')or die('v');function blk_search($p=''){global $tpl,$alt,$cfg,$map;$tpl->reset_theme('block');$tpl->theme('block',(isset($p['prop']['tpl'])&&$p['prop']['tpl'])?$p['prop']['tpl']:'blk_search');$tpl->reset_block('blk');$tpl->block('blk',array('CSS'=>$tpl->css($p['prop']['css'],'.vf_block'),'TITLE'=>($p['title']{0}=='~')?'':$p['title'],'S_SUBMIT'=>URL_BASE.VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&':'').VAR_PAGE.'='.$map->i[$p['prop']['rel']]['alias'],'METHOD'=>$p['prop']['typ'],'VAR_KEYWORD'=>VAR_KEYWORD,'KEYWORD'=>$alt['keyword'],));}