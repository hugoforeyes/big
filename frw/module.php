<?php
/**
* @version		$Id: module.php 2 2012-01-31 14:21 phu $
* @package		vFramework.module
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class vModule{protected $table='';protected $model='id:int,cid:page,lang,title,alias,preview:text,content:html,pic_thumb:image,hits:int,hot:int,prop:prop,meta:meta,created:int,modified:int,published:int';protected $trans='';protected $langs=0;protected $tpl='';protected $cfg;protected $url;protected $msg=array(0);protected $ret=0;protected $task=array('cat'=>array('model'=>'title,pic_thumb,preview',),'listing'=>array('model'=>'title,pic_thumb,preview',),'view'=>array('model'=>'title,content','next'=>'title,pic_thumb',),);public function __construct(){global $alt,$map,$tpl,$cfg;if($this->table=='')$this->table=strtolower(get_class($this));if($this->tpl=='')$this->tpl=$this->table;$m=&$this->model;if(is_string($m)){$t=preg_split('/[\n,;]/',$m);$m=array();foreach($t as $v){$v=preg_split('/[:=]/',$v.':');$m[$v[0]]=$v[1];}unset($t);}if($this->trans&&is_string($this->trans))$this->trans=preg_split('/[\n,;]/',$this->trans);foreach($this->task as $k=>$v){$m=&$this->task[$k];if(isset($m['model'])){if(is_string($m['model']))$m['model']=preg_split('/[\n,;]/',$m['model']);}else $m['model']='';}if(isset($map->r[$alt['page']])){$alt['module']=&$map->r[$alt['page']];$this->cfg=&$map->r[$alt['page']]['prop'];$this->cfg();$t=$alt['module']['title'];}else{die;}$tpl->_var('CSS',$tpl->css($this->cfg['css'],'.vf_'.$this->table));$this->url=VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&amp;':'').(($alt['page'])?VAR_PAGE.'='.$alt['page']:'').(($alt['section'])?'&amp;'.VAR_SECTION.'='.$alt['section']:'').(($alt['paging']>1)?'&amp;'.VAR_PAGING.'='.$alt['paging']:'');}function __destruct(){}protected function cfg(){global $cfg;if(!isset($this->cfg['pag'])||!$this->cfg['pag'])$this->cfg['pag']=$cfg['paging'];if(!isset($this->cfg['od'])||!$this->cfg['od'])$this->cfg['od']=isset($this->model['published'])?'published':'id';if(!isset($this->cfg['od2'])||!$this->cfg['od2'])$this->cfg['od2']='DESC';}public function exec($t=''){global $alt;if(isset($this->cfg['typ'])){if($this->cfg['typ']==1||$alt['id'])$t='view';else if($this->cfg['typ']==3)$t='cat';else $t='listing';}else $t=key($this->task);$this->{$t}();}protected function tpl(){global $tpl,$alt,$cfg;if(isset($this->tpl)&&$this->tpl){if($this->tpl===true)return true;$tpl->theme('body',$this->tpl);$this->tpl=true;return true;}else{$t=&$this->task[$alt['task']];if(isset($t['tpl'])&&$t['tpl']){$tpl->theme('body',$t['tpl']);return true;}}return false;}protected function view(){global $db;$s=$this->view_sql();if(!$db->query(is_array($s)?implode(' ',$s):$s))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows()&&$d[0]=$db->fetch_row()){if(isset($this->model['hits']))$db->query('UPDATE #__'.$this->table.' SET hits=hits+1 WHERE id='.$d[0]['id']);if(isset($this->task['view']['next'])&&$this->task['view']['next']){$this->task['view']['next']=preg_split('/[\n,;]/',$this->task['view']['next']);$this->task['listing']['model']=& $this->task['view']['next'];$s=$this->listing_sql();if(isset($this->cfg['nxt'])&&$this->cfg['nxt']){$b=$s[0]['w'];$s[0]['w'].=($this->cfg['nxt']==-1&&isset($d[0]['id']))?' AND a.id<>'.$d[0]['id']:(' AND '.$this->cfg['od'].(($this->cfg['od2']=='DESC')?'<':'>').'"'.$d[0][$this->cfg['od']].'"');if(!$db->query(is_array($s[0])?implode(' ',$s[0]):$s[0],$this->cfg['nxt']))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows())$d[1]=$db->fetch();$s[0]['w']=$b;}if(isset($this->cfg['prv'])&&$this->cfg['prv']){$s[0]['w'].=($this->cfg['prv']==-1&&isset($d[0]['id']))?' AND a.id<>'.$d[0]['id']:(' AND '.$this->cfg['od'].(($this->cfg['od2']=='DESC')?'>':'<').'"'.$d[0][$this->cfg['od']].'"');if(!$db->query(is_array($s[0])?implode(' ',$s[0]):$s[0],$this->cfg['prv']))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows())$d[2]=$db->fetch();}}$d=$this->view_data($d);$this->view_display($d);}}protected function view_sql(){global $alt,$cfg,$db;$m=&$this->model;$t=$this->task['view']['model'];$l=($cfg['langs']>1&&$this->langs)?(($this->trans)?2:1):0;$lc=($alt['lang']&&$alt['lang']<>$cfg['lang'])?1:0;foreach($t as $i=>$k){if($k&&!isset($m[$k]))unset($t[$i]);}$this->task['view']['model']=$t;$s='SELECT *';$w=(isset($m['cid']))?' WHERE a.cid="'.$alt['module']['id'].'"':' WHERE 1';if($alt['id']){$w.=' AND '.(($cfg['sef'])?'a.alias="'.$alt['id'].'"':'a.id='.$alt['id']);}else{$db->query('SELECT id FROM #__'.$this->table.' WHERE alias="'.$alt['module']['alias'].'"'.(isset($m['published'])?' AND published>0 AND published<'.time():'').(($l==1&&$alt['lang'])?' AND ('.(($alt['lang']==$cfg['lang'])?'lang="" OR ':'').'lang="'.$alt['lang'].'")':''));if($db->affected_rows())$w.=' AND a.alias="'.$alt['module']['alias'].'"';}if(isset($m['published']))$w.=' AND a.published>0 AND a.published<'.time();else if(isset($m['enabled']))$w.=' AND a.enabled>0';if($l==1&&$alt['lang'])$w.=' AND ('.(($alt['lang']==$cfg['lang'])?'a.lang="" OR ':'').'a.lang="'.$alt['lang'].'")';$f=' FROM #__'.$this->table.' a';if($l==2&&$lc){$f.=' LEFT JOIN #__'.$this->table.'_trans t ON a.id=t.id';$w.=' AND t.lang="'.$alt['lang'].'"';foreach($this->trans as $a)$s=str_replace('a.'.$a,'t.'.$a,$s);}return array('s'=>$s,'f'=>$f,'w'=>$w);}protected function view_data($d){global $tpl,$cfg,$alt;foreach($this->task['view']['model'] as $k){if(isset($d[0][$k])&&$d[0][$k]&&$this->model[$k]=='image'){$d[0]['o_'.$k]=$d[0][$k];$d[0][$k]='<img src="'.URL_UPLOAD.$d[0][$k].'" alt="" />';}}if($d[0]['title']{0}=='~')$d[0]['title']='';if(isset($d[1])&&$d[1]){for($i=0,$n=count($d[1]);$i<$n;$i++){$v=&$d[1][$i];if(isset($this->task['view']['next'])){foreach($this->task['view']['next'] as $k){if(isset($v[$k])&&$v[$k]&&$this->model[$k]=='image')$v[$k]='<img src="'.URL_UPLOAD.$v[$k].'" alt="" />';}}if(isset($v['published']))$v['published']=vTime::format($cfg['date']['input'],$v['published']);if(isset($v['created']))$v['created']=vTime::format($cfg['date']['input'],$v['created']);if(isset($v['modified']))$v['modified']=vTime::format($cfg['date']['input'],$v['modified']);$v['U_VIEW']=VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&amp;':'').(($alt['page'])?VAR_PAGE.'='.$alt['page']:'').(($alt['section'])?'&amp;'.VAR_SECTION.'='.$alt['section']:'').'&'.VAR_ID.'='.$v['id'];}}if(isset($d[2])&&$d[2]){for($i=0,$n=count($d[2]);$i<$n;$i++){$v=&$d[2][$i];if(isset($this->task['view']['next'])){foreach($this->task['view']['next'] as $k){if(isset($v[$k])&&$v[$k]&&$this->model[$k]=='image')$v[$k]='<img src="'.URL_UPLOAD.$v[$k].'" alt="" />';}}if(isset($v['published']))$v['published']=vTime::format($cfg['date']['input'],$v['published']);if(isset($v['created']))$v['created']=vTime::format($cfg['date']['input'],$v['created']);if(isset($v['modified']))$v['modified']=vTime::format($cfg['date']['input'],$v['modified']);$v['U_VIEW']=VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&amp;':'').(($alt['page'])?VAR_PAGE.'='.$alt['page']:'').(($alt['section'])?'&amp;'.VAR_SECTION.'='.$alt['section']:'').'&'.VAR_ID.'='.$v['id'];}}return $d;}protected function view_display($d){global $tpl,$cfg;$this->tpl();$tpl->block('view',$d[0],true);if(isset($cfg['og'])&&$cfg['og']){if(isset($d[0]['title']))vPage::head('<meta property="og:title" content="'.$d[0]['title'].'" />');if(isset($d[0]['preview']))vPage::head('<meta property="og:description" content="'.$d[0]['preview'].'" />');if(isset($d[0]['o_pic_thumb']))vPage::head('<meta property="og:image" content="'.vRequest::site(0).$d[0]['o_pic_thumb'].'" />');}$cfg['~seo']=1;if(isset($d[0]['meta'])){if(!is_array($d[0]['meta']))$d[0]['meta']=vRegistry::parse($d[0]['meta']);if(isset($d[0]['meta']['d'])&&$d[0]['meta']['d'])vPage::head($d[0]['meta']['d'],'description');if(isset($d[0]['meta']['k'])&&$d[0]['meta']['k'])vPage::head($d[0]['meta']['k'],'keywords');if(isset($d[0]['meta']['t'])&&$d[0]['meta']['t'])vPage::head($d[0]['meta']['t'],'title');else if(isset($d[0]['title']))vPage::head($d[0]['title'],'title');}else if(isset($this->cfg['typ'])&&$this->cfg['typ']==1)$cfg['~seo']=0;else vPage::head($d[0]['title'],'title');if(isset($d[1])&&$d[1])foreach($d[1] as $k=>$v)$tpl->block('view.next',$v,true);if(isset($d[2])&&$d[2])foreach($d[2] as $k=>$v)$tpl->block('view.prev',$v,true);}protected function listing(){global $db,$alt;$s=$this->listing_sql();if(!$db->query(is_array($s[0])?implode(' ',$s[0]):$s[0],$this->cfg['pag'],($alt['paging']-1)*$this->cfg['pag']))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows()==0&&$alt['paging']>1){$alt['paging']=1;if(!$db->query($s[0],$this->cfg['pag']))trigger_error($db->error(),E_USER_ERROR);}$d=$db->fetch();if(!$db->query(is_array($s[1])?implode(' ',$s[1]):$s[1]))trigger_error($db->error(),E_USER_ERROR);$c=$db->fetch_field('total');$d=$this->listing_data($d);$this->listing_display($d,$c);}protected function listing_sql(){global $alt,$cfg,$map;$m=&$this->model;$t=$this->task['listing']['model'];$l=($cfg['langs']>1&&$this->langs)?(($this->trans)?2:1):0;$lc=($alt['lang']&&$alt['lang']<>$cfg['lang'])?1:0;foreach($t as $i=>$k){if($k&&!isset($m[$k]))unset($t[$i]);}$this->task[$alt['task']]['model']=$t;if(isset($m['id'])){unset($t['id']);array_unshift($t,($cfg['sef']&&isset($m['alias']))?'alias as id':'id');}if(isset($this->cfg['dat'])&&$this->cfg['dat']&&isset($m[$this->cfg['dat']])&&!in_array($this->cfg['dat'],$t))array_push($t,$this->cfg['dat']);$s='SELECT a.'.implode(',a.',$t);$w=(isset($m['cid']))?' WHERE a.cid="'.$map->r[$alt['page']]['id'].'"':' WHERE 1';if(isset($m['published']))$w.=' AND a.published>0 AND a.published<'.time();else if(isset($m['enabled']))$w.=' AND a.enabled>0';if($l==1&&$alt['lang'])$w.=' AND ('.(($alt['lang']==$cfg['lang'])?'a.lang="" OR ':'').'a.lang="'.$alt['lang'].'")';$f=' FROM #__'.$this->table.' a';if($l==2&&$lc){$f.=' LEFT JOIN #__'.$this->table.'_trans t ON a.id=t.id';$w.=' AND t.lang="'.$alt['lang'].'"';foreach($this->trans as $a)$s=str_replace('a.'.$a,'t.'.$a,$s);}$o=' ORDER BY a.'.$this->cfg['od'].' '.$this->cfg['od2'];return array(array('s'=>$s,'f'=>$f,'w'=>$w,'o'=>$o),array('s'=>'SELECT count(*) as total','f'=>$f,'w'=>$w));}protected function listing_data($d){global $cfg,$tpl,$alt;for($i=0,$n=count($d);$i<$n;$i++){$v=&$d[$i];foreach($this->task['listing']['model'] as $k){if(isset($v[$k])&&$v[$k]&&in_array($this->model[$k],array('image','images','file','files','media','medias')))$v[$k]='<img src="'.URL_UPLOAD.$v[$k].'" alt="" />';}if(isset($v['published']))$v['published']=vTime::format($cfg['date']['input'],$v['published']);if(isset($v['created']))$v['created']=vTime::format($cfg['date']['input'],$v['created']);if(isset($v['modified']))$v['modified']=vTime::format($cfg['date']['input'],$v['modified']);$v['U_VIEW']=VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&amp;':'').(($alt['page'])?VAR_PAGE.'='.$alt['page']:'').(($alt['section'])?'&amp;'.VAR_SECTION.'='.$alt['section']:'').'&'.VAR_ID.'='.$v['id'];}return $d;}protected function listing_display($d,$c){global $tpl,$alt,$cfg;$this->tpl();$tpl->block('list',array('PAGING'=>vPage::paging($this->url,$c,$this->cfg['pag'],$alt['paging'])));if(isset($this->cfg['hot'])&&$this->cfg['hot']){for($j=0;$j<$this->cfg['hot'];$j++){if($v=array_shift($d))$tpl->block('list.hot',$v,true);}}foreach($d as $k=>$v){$tpl->block('list.row',$v,true);}}protected function cat(){global $db,$alt,$map;if(isset($alt['module']['tree']['c'])&&$alt['module']['tree']['c']){$s=$this->cat_sql();$t=array_pop($s);$s['w2']='';$s['o']=$t;$d=array();foreach(explode(',',$alt['module']['tree']['c'])as $i){if($i){$s['w2']='AND cid IN ('.$i.(($map->i[$i]['tree']['f'])?','.$map->i[$i]['tree']['f']:'').')';if(!$db->query(is_array($s)?implode(' ',$s):$s,(isset($this->cfg['cat'])&&$this->cfg['cat'])?$this->cfg['cat']:2))trigger_error($db->error(),E_USER_ERROR);if($t=$db->fetch())$d[$i]=$t;}}$d=$this->cat_data($d);$this->cat_display($d);}else listing();}protected function cat_sql(){global $alt,$cfg,$map;$m=&$this->model;$t=$this->task['cat']['model'];$l=($cfg['langs']>1&&$this->langs)?(($this->trans)?2:1):0;$lc=($alt['lang']&&$alt['lang']<>$cfg['lang'])?1:0;foreach($t as $i=>$k){if($k&&!isset($m[$k]))unset($t[$i]);}$this->task[$alt['task']]['model']=$t;if(isset($m['id'])){unset($t['id']);array_unshift($t,($cfg['sef']&&isset($m['alias']))?'alias as id':'id');}if(isset($m['cid'])){unset($t['cid']);array_unshift($t,'cid');}if(isset($this->cfg['dat'])&&$this->cfg['dat']&&isset($m[$this->cfg['dat']])&&!in_array($this->cfg['dat'],$t))array_push($t,$this->cfg['dat']);$s='SELECT a.'.implode(',a.',$t);$w=' WHERE 1';if(isset($m['published']))$w.=' AND a.published>0 AND a.published<'.time();else if(isset($m['enabled']))$w.=' AND a.enabled>0';if($l==1&&$alt['lang'])$w.=' AND ('.(($alt['lang']==$cfg['lang'])?'a.lang="" OR ':'').'a.lang="'.$alt['lang'].'")';$f=' FROM #__'.$this->table.' a';if($l==2&&$lc){$f.=' LEFT JOIN #__'.$this->table.'_trans t ON a.id=t.id';$w.=' AND t.lang="'.$alt['lang'].'"';foreach($this->trans as $a)$s=str_replace('a.'.$a,'t.'.$a,$s);}$o=' ORDER BY a.'.$this->cfg['od'].' '.$this->cfg['od2'];return array('s'=>$s,'f'=>$f,'w'=>$w,'o'=>$o);}protected function cat_data($d){global $cfg,$tpl,$alt,$map;$u=VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&amp;':'').VAR_PAGE.'=';foreach(array_keys($d)as $i){for($j=0,$m=count($d[$i]);$j<$m;$j++){$v=&$d[$i][$j];foreach($this->task['cat']['model'] as $k){if(isset($v[$k])&&$v[$k]&&in_array($this->model[$k],array('image','images','file','files','media','medias')))$v[$k]='<img src="'.URL_UPLOAD.$v[$k].'" alt="" />';}if(isset($v['published']))$v['published']=vTime::format($cfg['date']['input'],$v['published']);if(isset($v['created']))$v['created']=vTime::format($cfg['date']['input'],$v['created']);if(isset($v['modified']))$v['modified']=vTime::format($cfg['date']['input'],$v['modified']);$v['U_VIEW']=$u.$map->i[$v['cid']]['alias'].'&'.VAR_ID.'='.$v['id'];}}return $d;}protected function cat_display($d){global $tpl,$map,$cfg,$alt;$this->tpl();foreach($d as $i=>$r){$tpl->block('cat',array('TITLE'=>$map->i[$i]['title'],'U_VIEW'=>VAR_INDEX.'?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&':'').VAR_PAGE.'='.$map->i[$i]['alias'],));if(isset($this->cfg['hot'])&&$this->cfg['hot']){for($j=0;$j<$this->cfg['hot'];$j++){if($v=array_shift($r))$tpl->block('cat.hot',$v,true);}}foreach($r as $k=>$v){$tpl->block('cat.row',$v,true);}}}}