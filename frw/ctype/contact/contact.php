<?php
/**
 * @version		$Id: contact.php 3 2015-06-02 09:43 phu $
 * @package		vFramework.contact
 * @copyright	(C) 2015 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE')or die('v');$alt['module']=&$map->r[$alt['page']];$o=& $alt['module']['prop'];require_once PATH_CTYPE.DS.'contact'.DS.'controller.php';contact_controller();$tpl->theme('body','contact');$tpl->_var('CSS',$tpl->css($o['css'],'.vf_contact'));