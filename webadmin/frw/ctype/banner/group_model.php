<?php
/**
* @version		$Id: group_model.php 3 2012-09-04 13:39 phu $
* @package		vFramework.cp.banner
* @copyright	(C) 2012 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class GroupModel extends vCPModel{static public function resync(){$db=vDatabase::instance();$s='UPDATE #__banner SET count=0';if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);$s='SELECT COUNT(*) as count, pid FROM  #__banners group by pid';if($db->query($s))$arrcout=$db->fetch();foreach($arrcout as $k=>$v){$s='UPDATE #__banner SET count='.$v['count'].' where id='.$v['pid'];if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);}}}