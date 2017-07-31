<?php
/**
* @version		$Id: staff.php 2 2012-02-14 13:28 phu $
* @package		vFramework.cp.staff
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');cpPage::help('staff');cpPage::help('authorise');cpPage::help('logs');if($alt['section']=='logs'){$cfg['log']=0;include PATH_WORKING.DS.'logs.php';$ctrl=new Staff_Logs();$ctrl->exec($alt['task']);}else if($alt['section']=='group'){include PATH_WORKING.DS.'group.php';$ctrl=new Staff_Grp();$ctrl->exec($alt['task']);}else{include PATH_WORKING.DS.'staffs.php';$ctrl=new Staff();$ctrl->exec($alt['task']);}unset($ctrl);