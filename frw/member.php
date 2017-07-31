<?php
/**
* @version		$Id: member.php 1 2011-05-23 13:51 phu $
* @package		vFramework.core.member
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class vMember extends vSession{private static $_m;var $profile=array();public static function instance(){if(is_null(self::$_m))self::$_m=new self();return self::$_m;}function __construct(){global $cfg,$db;$this->session('start');$sid=$this->sid();if(!$sid&&isset($_COOKIE[$cfg['session_handler']]['sid'])){$cfg['session_lifetime']=30*24*60*60;$sid=md5(trim(strip_tags($_COOKIE[$cfg['session_handler']]['sid'])).vRequest::ip().$_SERVER['HTTP_USER_AGENT']);}if($sid){$sql='SELECT * FROM #__member
			WHERE enabled=1 AND log_sid="'.$sid.'" AND log_expire>='.time();if(!$result=$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows($result)){$this->profile=$db->fetch_row($result);$sql='UPDATE #__member
				SET log_expire='.(time()+ $cfg['session_lifetime']).'
				WHERE log_sid="'.$sid.'"';if(!$result=$db->query($sql))trigger_error($db->error(),E_USER_ERROR);$this->state='active';}}}function login($email,$pass,$r=0){global $cfg,$db;if($email AND $pass){$sql='SELECT id, password
			FROM #__member
			WHERE email="'.$email.'" AND enabled=1';if(!$result=$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows($result)){$d=$db->fetch_row($result);if($d['password']==md5($pass)){if($r)$cfg['session_lifetime']=30*24*60*60;$x['log_time']=time();$x['log_expire']=$x['log_time'] + $cfg['session_lifetime'];$x['log_ip']=vRequest::ip();$sid=sha1($d['id'].substr($d['password'],10).$x['log_time'].uniqid());$x['log_sid']=md5($sid.$x['log_ip'].$_SERVER['HTTP_USER_AGENT']);$sql=$db->sql('UPDATE','#__member',$x,'id='.$d['id']);if(!$result=$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($r)setcookie($cfg['session_handler'].'[sid]',$sid,$x['log_expire'],'/',$_SERVER['HTTP_HOST'],false,true);$this->sid($x['log_sid']);$this->state='active';return true;}}}return false;}function logout(){global $db,$cfg;$this->state=null;$sid=$this->sid();if($sid){setcookie($cfg['session_handler'].'[sid]','',time()- 3600,'/',$_SERVER['HTTP_HOST'],false,true);$sql='UPDATE #__member
			SET log_expire=0, log_sid=""
			WHERE log_sid="'.$sid.'"';if(!$result=$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows($result)){return true;}}return false;}}