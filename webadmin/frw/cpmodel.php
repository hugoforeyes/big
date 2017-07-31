<?php
/**
 * @version		$Id: cpmodel.php 2 2012-07-24 13:39 phu $
 * @package		vFramework.cp.mvc
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE')or die('v');
class vCPModel{public $cfg;protected $db;public function __construct($t=''){if(!$t)$t=strtolower(substr(get_class($this),0,-5));$k=$t.'_cfg';global $$k;if(!$$k){include PATH_WORKING.DS.$k.'.php';vRegistry::cfg($$k,$t);}$this->cfg=& $$k;}public function erecord($a,$r=1){$db=vDatabase::instance();$d='';if($a){$l=vPage::cfg('langs');$s=$this->erecord_sql($a,$r);if(!$db->query($s[0]))trigger_error($db->error(),E_USER_ERROR);$d=$db->fetch_row();if($r&&$l>1&&$this->cfg['langs']&&$this->cfg['trans']){if(!$db->query($s[1]))trigger_error($db->error(),E_USER_ERROR);$a=$db->fetch();foreach($a as $v){$k=$v['lang'];unset($v['lang']);$d['_'][$k]=$v;}unset($a);}}return $d;}protected function erecord_sql($a,$r=1){global $alt,$cfg,$map;$s=null;if($a){$m=&$this->cfg['structure'];$t=vPage::alt('task');$x=$this->_f($this->cfg['task'][$t]['field']);$s[0]['s']='SELECT '.implode(',',($x)?$x:array_keys($m));$s[0]['f']='FROM #__'.$this->cfg['table'];$s[0]['w']='WHERE '.(isset($m['id'])?'id='.$a:'');if($r&&vPage::cfg('langs')>1&&$this->cfg['langs']&&$this->cfg['trans']){$s[1]['s']='SELECT '.(($x)?'id,lang,'.implode(',',array_intersect($x,$this->cfg['trans'])):'*');$s[1]['f']='FROM #__'.$this->cfg['table'].'_trans';$s[1]['w']=$s[0]['w'];}}return $s;}public function erecords($a=0,$b=0,$r=1){$db=vDatabase::instance();$d='';if($a<1)$a=1;$s=$this->erecords_sql($a,$b,$r);if($b==-1)$b=0;else if($b<1)$b=vPage::cfg('paging');$l=vPage::cfg('langs');if(is_array($a)){$a=1;$b=0;}if(!$db->query($s[0],$b,($a-1)*$b))trigger_error($db->error(),E_USER_ERROR);$d=$db->fetch();if($d&&$r&&$l>1&&$this->cfg['langs']&&$this->cfg['trans']){if($b>0){$a=array();foreach($d as $k=>$v)$a[]=$v['id'];if($a)$s[1]['w'].=' AND id IN ('.implode(',',$a).')';}if(!$db->query($s[1]))trigger_error($db->error(),E_USER_ERROR);$a=$db->fetch();if(isset($d[0]['id'])){$x=array();$e=array();foreach($d as $k=>$v){$x[$v['id']]=$k;$e[]=null;}$lan=vPage::cfg('language');unset($lan[vPage::cfg('lang')]);foreach($lan as $k=>$v)$d['_'][$k]=$e;foreach($a as $v){$b=$v['lang'];if(isset($lan[$b])){unset($v['lang']);$d['_'][$b][$x[$v['id']]]=$v;}}}else{$d['_']=$a;}unset($a);}return $d;}protected function erecords_sql($a=0,$b=0,$r=1){global $alt,$cfg,$map;$s=null;$m=&$this->cfg['structure'];$t=vPage::alt('task');$o='';if(isset($m['ordering'])){$o='ORDER BY ordering ASC';}else if(isset($alt['filter']['ord'])&&$alt['filter']['ord']){$f=explode('_',$alt['filter']['ord']);if(isset($m[$f[0]]))$o='ORDER BY '.$f[0].' '.$f[1];}else{$o='ORDER BY id DESC';}$w='WHERE 1'.((is_array($a)&&$a)?' AND id IN ('.implode(',',$a).')':'');if($cfg['langs']>1&&$this->cfg['langs']&&!$this->cfg['trans']&&isset($m['lang'])&&$alt['lang'])$w.=($b==-1&&$this->cfg['table']=='blocks')?'':' AND ('.(($alt['lang']==$cfg['lang'])?'lang="" OR ':'').'lang="'.$alt['lang'].'")';$x=$this->_f($this->cfg['task'][$t]['field']);$s[0]['s']='SELECT '.implode(',',($x)?$x:array_keys($m));$s[0]['f']='FROM #__'.$this->cfg['table'];$s[0]['w']=$w.((isset($m['cid'])&&isset($map->r[$alt['page']]))?' AND cid='.$map->r[$alt['page']]['id']:'');$s[0]['o']=$o;if($r&&vPage::cfg('langs')>1&&$this->cfg['langs']&&$this->cfg['trans']){$s[1]['s']='SELECT '.(($x)?'id,lang,'.implode(',',array_intersect($x,$this->cfg['trans'])):'*');$s[1]['f']='FROM #__'.$this->cfg['table'].'_trans';$s[1]['w']=$w;}return $s;}public function record($a){$db=vDatabase::instance();$d='';if(is_int($a)&&$a){$l=vPage::cfg('langs');$s=$this->record_sql($a);if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);$d=$db->fetch_row();}return $d;}protected function record_sql($a){global $cfg,$alt;if($a){$m=& $this->cfg['structure'];$t=vPage::alt('task');$l=($cfg['langs']>1&&isset($this->cfg['langs'])&&$this->cfg['langs'])?((isset($this->cfg['trans'])&&$this->cfg['trans'])?2:1):0;$lc=($alt['lang']&&$alt['lang']<>$cfg['lang'])?1:0;$x=$this->_f($this->cfg['task'][$t]['field']);$s='SELECT a.'.str_replace(',',',a.',implode(',',($x)?$x:array_keys($m)));$w='WHERE a.id='.$a;$f='FROM #__'.$this->cfg['table'].' a';if($l==2&&$lc){$f.=' LEFT JOIN #__'.$this->cfg['table'].'_trans t ON a.id=t.id';$w.=' AND t.lang="'.$alt['lang'].'"';foreach($this->cfg['trans'] as $a)$s=str_replace('a.'.$a,'t.'.$a,$s);}return array('s'=>$s,'f'=>$f,'w'=>$w);}}public function records($a,$b=0){$db=vDatabase::instance();$d='';if($a<1)$a=1;if($b==-1)$b=0;else if($b<1)$b=vPage::cfg('paging');$s=$this->records_sql($a);if(is_array($a)){$a=1;$b=0;}if(!$db->query($s,$b,($a-1)*$b))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows()==0&&$a>1){vPage::alt('paging',1);if(!$db->query($s,$b))trigger_error($db->error(),E_USER_ERROR);}return $db->fetch();}protected function records_sql($a=0){global $alt,$cfg,$map;$m=& $this->cfg['structure'];$t=vPage::alt('task');$l=($cfg['langs']>1&&isset($this->cfg['langs'])&&$this->cfg['langs'])?((isset($this->cfg['trans'])&&$this->cfg['trans'])?2:1):0;$lc=($alt['lang']&&$alt['lang']<>$cfg['lang'])?1:0;$x=$this->_f($this->cfg['task'][$t]['field']);$s='SELECT '.substr(str_replace(',',',a.',','.implode(',',($x)?$x:array_keys($m))),1);$w=(isset($m['cid'])&&isset($map->r[$alt['page']]))?' WHERE a.cid="'.$map->r[$alt['page']]['id'].'"':' WHERE 1';$x='';if(isset($m['published']))$x='published';else if(isset($m['enabled']))$x='enabled';$w.=($alt['publish']&&$x)?(($alt['publish']==1)?' AND a.'.$x.'>0':' AND a.'.$x.'=0'):'';if(is_array($a)&&$a){$w.=' AND a.id IN ('.implode(',',$a).')';}else{if(isset($m['title']))$w.=($alt['keyword'])?' AND '.(($l==2&&$lc)?'t':'a').'.title LIKE "%'.$alt['keyword'].'%"':'';if(isset($m['hot']))$w.=($alt['hot'])?' AND a.hot=1':'';if($l==1&&$alt['lang'])$w.=' AND (a.lang="" OR a.lang="'.$alt['lang'].'")';if($this->cfg['task'][$t]['filter']){foreach($this->cfg['task'][$t]['filter'] as $x){if(!in_array($x,array('search','publish'))&&isset($m[$x]))$w.=(isset($alt['filter'][$x])&&$alt['filter'][$x])?' AND a.'.$x.'="'.$alt['filter'][$x].'"':'';}}}$f=' FROM #__'.$this->cfg['table'].' a';if($l==2&&$lc){$f.=' LEFT JOIN #__'.$this->cfg['table'].'_trans t ON a.id=t.id';$w.=' AND t.lang="'.$alt['lang'].'"';foreach($this->cfg['trans'] as $a)$s=str_replace('a.'.$a,'t.'.$a,$s);}$o='';if(isset($m['ordering'])&&!isset($this->cfg['prop']['od']))$o=' ORDER BY a.ordering ASC';else if(isset($alt['filter']['ord'])&&$alt['filter']['ord']){$a=explode('_',$alt['filter']['ord']);if(isset($m[$a[0]]))$o=' ORDER BY a.'.$a[0].' '.$a[1];}else if(isset($this->cfg['prop']['od']))$o=' ORDER BY a.'.$this->cfg['prop']['od'].' '.$this->cfg['prop']['od2'];else if(isset($m['id']))$o=' ORDER BY a.id DESC';return array('s'=>$s,'f'=>$f,'w'=>$w,'o'=>$o);}public function update($id=0,$d,$r=''){global $cfg,$alt,$stf;$db=vDatabase::instance();if($id){unset($d['id']);$s='SELECT id FROM #__'.$this->cfg['table'].' WHERE id='.$id;if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);if($db->fetch_field('id')){$s=$db->sql('UPDATE','#__'.$this->cfg['table'],$d,($id===false)?'1':'id='.$id);if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);}else{$id=0;$cfg['log']=0;}$l='edit';}else{$d['id']=0;$s=$db->sql('INSERT','#__'.$this->cfg['table'],$d);if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);$id=$db->nextid();$l='create';}if($cfg['log'])$stf->logs($alt['page'],$l,array('id'=>$id,));$l=vPage::cfg('langs');if($id&&$r&&$l>1&&$this->cfg['langs']&&$this->cfg['trans']){foreach(vPage::cfg('language')as $i=>$j){if($i<>$l&&isset($r[$i])){if($id){$s='SELECT id FROM #__'.$this->cfg['table'].'_trans WHERE lang="'.$i.'" AND id='.$id;if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows()){unset($r[$i]['lang']);unset($r[$i]['id']);$s=$db->sql('UPDATE','#__'.$this->cfg['table'].'_trans',$r[$i],'lang="'.$i.'" AND id='.$id);}else{$r[$i]['lang']=$i;$r[$i]['id']=$id;$s=$db->sql('INSERT','#__'.$this->cfg['table'].'_trans',$r[$i]);}if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);}else{$r[$i]['lang']=$i;$r[$i]['id']=$id;$s=$db->sql('INSERT','#__'.$this->cfg['table'].'_trans',$r[$i]);if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);}}}}}public function delete($id){global $db,$cfg,$alt,$stf;$d='';$a=$id;if(is_array($id))$id=implode(',',$id);if($id){$m=&$this->cfg['structure'];if($cfg['log']){$i=array();$t=array();$s='SELECT id'.(isset($m['title'])?',title':'').' FROM #__'.$this->cfg['table'].' WHERE id IN ('.$id.')';if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);foreach($db->fetch()as $v){$i[]=$v['id'];if(isset($m['title']))$t[]=$v['title'];}$stf->logs($alt['page'],'delete',array('ids'=>implode(',',$i),'title'=>implode(' | ',$t),));}$t='';foreach($m as $k=>$v){if(in_array($v,array('image','media','file','images','medias','files')))$t[]=$k;}if($t){$this->cfg['task'][vPage::alt('task')]['field']=$t;$d=$this->erecords($a,0,0);}$s='DELETE FROM #__'.$this->cfg['table'].' WHERE id IN ('.$id.')';if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);if(vPage::cfg('langs')>1&&$this->cfg['langs']&&$this->cfg['trans']){$s='DELETE FROM #__'.$this->cfg['table'].'_trans WHERE id IN ('.$id.')';if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);}}return $d;}public function alias($a='',$id=0,$l=''){global $cfg,$alt;if($a){$s='SELECT a.id FROM #__'.$this->cfg['table'].(($l)?' b LEFT JOIN #__'.$this->cfg['table'].'_trans a ON a.id=b.id':' a').' WHERE a.alias="'.$a.'"'.(($id)?' AND a.id<>'.$id:'').(($l)?' AND ('.(($alt['lang']==$cfg['lang'])?'a.lang="" OR ':'').'a.lang="'.$l.'")':'').((V_LIFE==2&&isset($this->cfg['structure']['sid']))?' AND '.(($l)?'b':'a').'.sid='.V_SITE:'');$db=vDatabase::instance();if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);if(!$db->affected_rows())return 0;}return 1;}public function count(){$db=vDatabase::instance();$s=$this->records_sql();$s['s']='SELECT count(*) as total';if(!$db->query($s))trigger_error($db->error(),E_USER_ERROR);return $db->fetch_field('total');}public function _f($f){$a=array();if($f){$m=& $this->cfg['structure'];foreach($f as $k){if(isset($m[$k]))$a[]=$k;}}return($a)?$a:'';}}