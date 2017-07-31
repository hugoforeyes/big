<?php
/**
* @version		$Id: site.php 2 2012-03-02 16:46 phu $
* @package		vFramework.cp.site
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');if($alt['section']=='plugin'){cpPage::nav('System');$h='<table class="list"><tbody>';$sql='SELECT name, prop FROM #__ctype WHERE func=1 AND ctype=2 AND enabled=1 ORDER BY name ASC';if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($j=$db->affected_rows()){$p=$db->fetch();$u=VAR_INDEX.'?'.VAR_PAGE.'=cp.';for($i=0;$i<$j;$i++){$h.='<tr class="tbrow"><td><a href="'.$u.$p[$i]['name'].'">'.$tpl->_($p[$i]['name']).'</a></td></tr>';if($p[$i]['prop']){$p[$i]['prop']=vRegistry::parse($p[$i]['prop']);foreach($p[$i]['prop'] as $k=>$v)$h.='<tr class="tbrow"><td class="step1 title"><a class="step1" href="'.$u.(is_array($v)?$v[0]:$v).'">'.$tpl->_($k).'</a></td></tr>';}}}$h.='</tbody></table>';$tpl->theme('body','',$h);}else{if(V_LIFE==1)vPage::redirect('../');if(vRequest::issubmit(VAR_ID)){$_SESSION['_vSite']=$alt['id'];vPage::redirect(VAR_INDEX.'?'.VAR_LANG.'='.vPage::alt('lang').'&amp;'.VAR_PAGE.'=cp.sitemap');}if(isset($cfg['sites'])){cpPage::nav('Site');$tpl=vTemplate::instance();$h='<table class="list">
<thead><tr><td class="th_title">'.$tpl->_('Title').'</td><td class="th_url">'.$tpl->_('Domain').'</td></tr></thead>
<tbody>';foreach($cfg['sites'] as $k=>$v){$h.='<tr class="tbrow"><td><a '.((V_SITE==$v[0])?'':'href="'.VAR_INDEX.'?'.VAR_LANG.'='.vPage::alt('lang').'&amp;'.VAR_PAGE.'=cp.site&amp;'.VAR_ID.'='.$v[0]).'">'.((V_SITE==$v[0])?'<span class="ico ihot"></span>':'').$v[1].'</a></td><td>'.$k.'</td></tr>';}$h.='</tbody></table>';$tpl->theme('body','',$h);}else include PATH_WORKING.DS.'sites.php';}