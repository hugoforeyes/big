<?php
/**
 * @version		$Id: blk_captcha.php 3 2013-04-04 15:36 phu $
 * @package		vFramework.core.captcha
 * @copyright	(c) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
function blk_captcha(){$s=vRequest::string('sid');if($s)vCaptcha::draw($s);else echo vCaptcha::sid();}