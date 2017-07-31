<?php
/**
 * @version		$Id: blk_contact.php 3 2015-06-02 10:24 Phu $
 * @package		vFramework.contact
 * @copyright	(C) 2015 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE')or die('v');function blk_contact($p=''){global $tpl,$cfg,$alt,$map;$o=& $p['prop'];$tpl->reset_theme('block');$tpl->theme('block',(isset($o['tpl'])&&$o['tpl'])?$o['tpl']:'blk_contact');require_once PATH_CTYPE.DS.'contact'.DS.'controller.php';contact_controller($o['rel'],'blk');$tpl->vars(array('CSS'=>$tpl->css($o['css'],'.vf_block vf_blk_contact'),'S_NOJS'=>URL_BASE.VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&':'').VAR_PAGE.'='.$map->i[$o['rel']]['alias'],));if((isset($cfg['~ajax'])&&$cfg['~ajax'])){$tpl->display('block',0,1,1,1);die;}$tpl->block('ajax',array('ID'=>'vf_ajax_'.$p['id'],'URL'=>URL_BASE.VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&':'').VAR_PAGE.'=null&'.VAR_SECTION.'=contact&'.VAR_BLOCK.'='.$p['id'],));}