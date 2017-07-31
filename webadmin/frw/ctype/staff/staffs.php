<?php
/**
* @version		$Id: staffs.php 3 2013-05-21 15:06 Phu $
* @package		vFramework.cp.staff
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');$cfg['cp']['language']=array(''=>'- '.$tpl->l['DEFAULT'].' -','vn'=>'Tiếng Việt','en'=>'English');
class Staff extends vCPModule{protected $model='id:int,username:string,password:password,lang,email,level:int,ip:string,log_time:int,log_expire:int,fullname:string,email:string,prop:prop,created:int,modified:int,enabled:int';protected $task=array('listing'=>array('cmd'=>'create,delete,active,inactive','filter'=>'search','model'=>'username,email,level,ip,log_time',),'edit'=>array('auth'=>'edit','model'=>'username,password,level','model2'=>'email,lang','null'=>'username',),'delete'=>array('auth'=>'delete',),'auth'=>array('auth'=>'admin',),'visual'=>array(),'login'=>array(),'logout'=>array(),'captcha'=>array(),'active'=>array('auth'=>'publish',),'inactive'=>array('auth'=>'publish',),'password'=>array(),'lang'=>array(),);protected $_pos=array();protected $_auth=array();protected function login(){global $stf,$cfg,$tpl,$alt,$db;$u=vRequest::string('u');$p=vRequest::string('p');$i=$stf->session('get','flc',0);if($u&&$p){if(!$cfg['debug']&&$u==$p)vPage::redirect(URL_CP);if(($i<=1||($i>1&&vCaptcha::check(vRequest::string('captcha_sid'),vRequest::string('captcha'))))&&$stf->login($u,$p)){$stf->session('clear','flc');$db->query('SELECT id FROM #__staff WHERE username="'.$u.'"');$stf->profile['id']=$db->fetch_field('id');if($cfg['log'])$stf->logs($alt['page'],'login',array('ip'=>vRequest::ip(),));vPage::redirect(URL_CP.'?'.(($alt['return'])?$alt['return']:'l='.$cfg['lang']));return true;}if($cfg['log'])$stf->logs($alt['page'],'login',array('username'=>$u,'password'=>$p,'ip'=>vRequest::ip(),));$i++;$stf->session('set','flc',$i);}$h=parse_url(strip_tags(vRequest::uri()));$h=isset($h['query'])?'<input type="hidden" name="'.VAR_RETURN.'" value="'.$h['query'].'" />':'';$tpl->vars(array('_CLS'=>' class="login"','S_HIDDEN'=>$h,'CAPTCHA'=>($i>1)?vForm::draw(array('captcha'=>'captcha')):''));$tpl->theme('body','login');}protected function logout(){global $stf,$cfg,$alt;if($cfg['log'])$stf->logs($alt['page'],'logout');$stf->logout();vPage::redirect(URL_CP);}protected function captcha(){$s=vRequest::string('sid');if($s)vCaptcha::draw($s);else echo vCaptcha::sid();die;}protected function visual(){if(isset($_COOKIE['webadmin'])&&$_COOKIE['webadmin'])setcookie('webadmin',0,time()- 60,'/');else setcookie('webadmin',1,0,'/');vPage::redirect(URL_BASE);}protected function inactive(){$this->active();}protected function active(){global $db,$alt,$stf;$ids=implode(',',vRequest::_var('ids'));if($ids){$sql='UPDATE #__'.$this->table.'
				SET enabled='.(($alt['task']=='active')?'1':'0').' WHERE id IN ('.$ids.') AND id<>'.$stf->profile['id'];if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);}$this->ret=1;}protected function password(){global $db,$tpl,$stf;vRequest::vars($y,array('oldpassword','repassword',),'string');$x['password']=vRequest::string('password');cpPage::nav('CHANGE_PASS');cpPage::cmd('update');cpPage::cmd('cancel',$this->url);if(vRequest::issubmit('update')){if($y['oldpassword'] AND $x['password'] AND $y['repassword']){if($x['password']==$y['repassword']){$db->query('SELECT password FROM #__staff WHERE id='.$stf->profile['id']);$y['dbpassword']=$db->fetch_field('password');if(md5($y['oldpassword'])==$y['dbpassword']){$x['modified']=time();$x['password']=md5($x['password']);$sql=$db->sql('UPDATE','#__staff',$x,'id='.$stf->profile['id']);if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);cpPage::report('RP_CHANGE_PASS');}else{cpPage::error('ERR_PASS');}}else{cpPage::error('ERR_NEW_PASS');}}else{cpPage::error('ERR_NOTNULL');}}$h='<form id="main_form" name="main_form" method="POST" action="'.$this->url.'&'.VAR_TASK.'=password">
	<input type="hidden" name="update" value="1" />
	<input type="submit" name="s'.time().'" value="" class="hidden" />
	<table class="form_wra"><tbody><tr><td class="td_wra"><table class="form">
	<tr><th>'.$tpl->l['USERNAME'].'</th><td style="font-weight:bold;">'.$stf->profile['username'].'</td></tr>
	<tr>
	<th><span class="ico inn" title="'.$tpl->l['NOTNULL'].'"></span>'.$tpl->l['PASSWORD'].'</th>
	<td><input name="oldpassword" type="password" id="oldpassword" /></td>
	</tr>
	<tr>
	<th><span class="ico inn" title="'.$tpl->l['NOTNULL'].'"></span>'.$tpl->l['NEW_PASSWORD'].'</th>
	<td><input name="password" type="password" id="password" /></td>
	</tr>
	<tr>
	<th><span class="ico inn" title="'.$tpl->l['NOTNULL'].'"></span>'.$tpl->l['NEW_PASSWORD2'].'</th>
	<td><input name="repassword" type="password" id="repassword" /></td>
	</tr>
	</table></td></tr></tbody></table></form>';$tpl->theme('body','',$h);}protected function lang(){global $db,$tpl,$stf,$cfg,$alt;$l=vRequest::cmd('language',$stf->profile['lang']);cpPage::nav('CHANGE_LANG');cpPage::cmd('update');cpPage::cmd('cancel',$this->url);if(vRequest::issubmit('update')){$stf->profile['lang']=$l;$sql='UPDATE #__staff SET lang="'.$l.'" WHERE id='.$stf->profile['id'];if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);vPage::redirect(VAR_INDEX.'?'.VAR_LANG.'='.$alt['lang'].'&amp;'.VAR_PAGE.'='.$alt['page'].'&t=lang');}$h='<form id="main_form" name="main_form" method="POST" action="'.$this->url.'&'.VAR_TASK.'=lang">
	<input type="hidden" name="update" value="1" />
	<input type="submit" name="s'.time().'" value="" class="hidden" />
	<table class="form_wra"><tbody><tr><td class="td_wra"><table class="form">
	<tr><th>'.$tpl->l['USERNAME'].'</th><td style="font-weight:bold;">'.$stf->profile['username'].'</td></tr>
	<tr>
	<th>'.$tpl->l['LANGUAGE'].'</th>
	<td>'.vForm::select($cfg['cp']['language'],'language','','','',$l).'</td>
	</tr>
	</table></td></tr></tbody></table></form>';$tpl->theme('body','',$h);}protected function auth(){global $db,$alt,$tpl,$stf,$map,$cfg;$o=vRequest::issubmit('overwrite');$sql='SELECT username, prop FROM #__staff WHERE id='.$alt['id'];if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows()){$d=$db->fetch_row();$p=vRegistry::parse($d['prop'],1);if(!$o&&isset($p['adv']))$alt['action']='adv';}else vPage::redirect(URL_CP);if(vRequest::issubmit('update')){$p=array();if($alt['action']){$p=vRequest::arr('adv');foreach($p as $k=>$v){if(!$v)unset($p[$k]);}$p='[adv]'.PHP_EOL.vRegistry::ini($p);}else{$p['page']=vRequest::_var('parent');if($p['page']){$p['page']=implode(',',$p['page']);}$p['auth']=vRequest::int('auth');$p=vRegistry::ini($p);}$sql='UPDATE #__staff SET prop="'.$p.'" WHERE id='.$alt['id'];if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);$this->ret=1;}else{cpPage::nav('AUTH');cpPage::cmd('update');cpPage::cmd('cancel',$this->url);$sql='SELECT id, title FROM #__staff_grp ORDER BY id ASC';if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);$a=array(0=>array('id'=>0,'title'=>''))+ $db->fetch();$cp=array();foreach($map->d as $v){$cp[$v['alias']]=vPage::blank($v['tree']['l']).$v['title'];}$cp['cp.sitemap']='+ '.$tpl->l['SITEMAP'];$cp['cp.blocks']='+ '.$tpl->l['BLOCKS'];$sql='SELECT name FROM #__ctype WHERE func=1 AND ctype>=2 AND enabled=1 ORDER BY ctype ASC, name ASC';if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows()){$m=$db->fetch();foreach($m as $k=>$v){$cp['cp.'.$v['name']]=''.(isset($tpl->l[strtoupper($v['name'])])?$tpl->l[strtoupper($v['name'])]:$v['name']);}}$h='<form id="main_form" name="main_form" method="POST" action="'.$this->url.'&'.VAR_TASK.'=auth&'.VAR_ACTION.'='.$alt['action'].(($o)?'&overwrite':'').'&'.VAR_ID.'='.$alt['id'].'">
	<input type="hidden" name="update" value="1" />
	<input type="submit" name="s'.time().'" value="" class="hidden" />
	<table class="form_wra"><tbody><tr><td class="td_wra"><table class="form"><tbody>
	<tr><th>'.$tpl->l['USERNAME'].'</th><td style="font-weight:bold;">'.$d['username'].'</td></tr>
	<tr>
	<th>'.$tpl->l['PAGE'].' / '.$tpl->l['CATEGORY'].'</th>
	<td>';if($alt['action']){$h.='<table class="form" style="width:0px;"><tbody>';foreach($cp as $k=>$v){$h.='<tr><td>'.$v.'</td><td>'.vForm::select($a,'adv['.$k.']','','id','title',isset($p['adv'][$k])?$p['adv'][$k]:0).'</td></tr>';}$h.='</tbody></table>';}else{$h.=vForm::select($cp,'parent[]','class="multiselect" size="10" multiple="multiple"','','',isset($p['page'])?explode(',',$p['page']):'','parent');}$h.='</td></tr>'.(($alt['action'])?'':'<tr>
	<th>'.$tpl->l['AUTH'].'</th>
	<td>'.vForm::select($a,'auth','','id','title',isset($p['auth'])?$p['auth']:0).'</td>
	</tr>').'<tr>
	<th></th>
	<td><a href="'.$this->url.'&'.VAR_TASK.'=auth&'.VAR_ACTION.'='.(($alt['action'])?'':'adv').'&overwrite&'.VAR_ID.'='.$alt['id'].'"><span class="ico iauth"></span><span>'.$tpl->l[($alt['action'])?'BASIC':'ADVANCE'].'</span></a></td>
	</tr>
	</tbody></table></td></tr></tbody></table></form>
	<script type="text/javascript">
	$(function(){$("select.multiselect").multiSelect({selectAll: true, selectAllText: \''.$tpl->l['ALL'].'\', noneSelected: \''.$tpl->l['ALL'].'\', oneOrMoreSelected: \'% '.$tpl->l['PAGE'].'\'});})
	</script>';$tpl->theme('body','',$h);}}protected function listing_sql(){global $alt;$s=parent::listing_sql();$s[0]['s'].=',a.log_expire';if(isset($alt['filter']['active'])&&$alt['filter']['active']){$t=' AND enabled='.(($alt['filter']['active']==1)?'1':'0');$s[0]['w'].=$t;$s[1]['w'].=$t;}return $s;}protected function listing_data($d){global $tpl,$stf,$cfg;if(!$stf->admin)$this->task['listing']['cmd']=array();$d=parent::listing_data($d);$this->model['ip']='int';$this->model['online']='int';$this->task['listing']['model'][]='online';for($i=0,$n=count($d);$i<$n;$i++){$v=&$d[$i];if($v['id']==$stf->profile['id'])$v['CMD']='';else $v['CMD'].=($v['level'])?'':(($stf->admin)?'<a href='.$this->url.'&t=auth&id='.$v['id'].' title="'.$tpl->l['AUTH'].'"><span class="ico iauth"></span></a>':'');$v['level']=($stf->admin)?(($v['level'])?$tpl->l['GRAND_ACCESS']:$tpl->l['RESTRIC_ACCESS'].'<a href='.$this->url.'&t=auth&id='.$v['id'].' title="'.$tpl->l['AUTH'].'"><span class="ico iauth"></span></a>'):'';$v['online']=($v['log_expire']>=time())?vTime::live(time()- $v['log_time'],true):'';$v['log_time']=($v['log_time'])?vTime::format($cfg['date']['input'],$v['log_time']):'';}return $d;}protected function listing_filter(){global $tpl,$cfg,$stf;parent::listing_filter();if($stf->admin){cpPage::cmd('group',$this->url.'&'.VAR_SECTION.'=group');if($cfg['log'])cpPage::cmd('group:logs',$this->url.'&'.VAR_SECTION.'=logs');}cpPage::filter('active',array(1=>$tpl->l['ACTIVE'],2=>$tpl->l['INACTIVE']),false);}protected function edit_data($d){global $cfg,$tpl;if(!$d)$d=array('level'=>0,'lang'=>'','enabled'=>0);$d['password']='';$d['lang']=vForm::select($cfg['cp']['language'],'lang','','','',$d['lang']);$d['level']=vForm::radio(array(0=>$tpl->l['RESTRIC_ACCESS'],1=>$tpl->l['GRAND_ACCESS']),'level',true,'','',$d['level']);return $d;}protected function edit_request(){$x=parent::edit_request();if($x['username']){global $alt,$db,$tpl;$s='SELECT id FROM #__staff WHERE username="'.$x['username'].'"'.((!$alt['_']['saveas']&&$alt['id'])?' AND id <>'.$alt['id']:'');$db->query($s);if($db->affected_rows()){$x['username']='';$this->msg[]=$tpl->l['ERR_DUP_STAFF'];}}$a=array('admin','vipcom','qwerty','abcd','abc123','00000','000000','11111','111111','123123','12345','123456','1234567','12345678','123456789','1234567890');if($x['password']){if($x['password']==$x['username']||strlen($x['password'])<5||in_array($x['password'],$a)){$this->msg[0]++;$this->msg[]=$tpl->l['ERR_SAFE_PASS'];}else $x['password']=md5($x['password']);}else unset($x['password']);return $x;}protected function edit_form($d){global $tpl;parent::edit_form($d);vPage::head('$(function() {
$("#enabled").parent().children("label").html("'.$tpl->_('Active').'");
$("#password").after(\' <span class="note">'.$tpl->l['TIP_PASSWORD'].'</span>\');
});','script');}}