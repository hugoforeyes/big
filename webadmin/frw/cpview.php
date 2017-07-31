<?php
/**
* @version		$Id: cpview.php 3 2013-05-20 16:18 phu $
* @package		vFramework.cp.mvc
* @copyright	(C) 2012 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class vCPView{protected $cfg;public function __construct($t=''){if(!$t)$t=strtolower(substr(get_class($this),0,-4));$k=$t.'_cfg';global $$k;if(!$$k){include PATH_WORKING.DS.$k.'.php';vRegistry::cfg($$k,$t);}$this->cfg=& $$k;}public function call($o,$m,$d){$t=vPage::alt('task');if(method_exists($o,$t.'_'.$m))$m=$t.'_'.$m;return $o->{$m}($d);}public function render($d=null,$c=0){global $tpl,$cfg,$alt,$stf;$t=vPage::alt('task');if($c)cpPage::count($c);if($f=&$this->cfg['task'][$t]['cmd']){foreach($f as $k=>$v){if($v=='move'&&!isset($this->cfg['type'][25]))cpPage::cmd($v,'javascript:cmd(\''.VAR_INDEX.'?'.VAR_PAGE.'=cp.sitemap&'.VAR_TASK.'=move&from='.$alt['module']['id'].'\');');else cpPage::cmd($v);}}if($f=&$this->cfg['task'][$t]['filter']){foreach($f as $k=>$v)cpPage::filter($v);}if($this->cfg['tpl']){if($this->cfg['tpl']!==true)$this->cfg['tpl']=$tpl->theme('body',$this->cfg['tpl']);}else{$a=&$this->cfg['task'][$t];if(isset($a['tpl'])&&$a['tpl'])$this->cfg['tpl']=$tpl->theme('body',$a['tpl']);}if($this->cfg['tpl']!==true){$tpl->theme('body','',$this->call($this,'tpl',$d));}$tpl->vars(array('S_LIST'=>$this->cfg['url'].(($alt['task'])?'&amp;'.VAR_TASK.'='.$alt['task']:''),'S_FILTER'=>$this->cfg['url'].(($alt['task'])?'&amp;'.VAR_TASK.'='.$alt['task']:''),'U_SUBMIT'=>$this->cfg['url'].(($alt['task'])?'&amp;'.VAR_TASK.'='.$alt['task']:''),));switch(($this->cfg['task'][$t]['type'])?$this->cfg['task'][$t]['type']:0){case 1:vPage::head(URL_THEME.'css/content.css','css');cpPage::cmd('back','javascript:history.go(-1);');cpPage::nav('View');$tpl->block($t,$d,true);break;case 4:if($cfg['langs']>1&&isset($this->cfg['langs'])&&$this->cfg['langs'])cpPage::filter((isset($this->cfg['trans'])&&$this->cfg['trans'])?'language':'language_all');$tpl->block($t,array());if($d){foreach($d as $v)$tpl->block($t.'.row',$v,true);}$tpl->vars(array('PAGINATION'=>vPage::paging($this->cfg['url'],$c,$cfg['paging'],$alt['paging']),));break;case 12:if(!$this->cfg['task'][$t]['cmd']){cpPage::cmd('update');cpPage::cmd('cancel',$this->cfg['url']);}cpPage::nav(($alt['id'])?'Edit':'Create');cpPage::editor();$tpl->block($t,$d,true);break;case 31:if($cfg['langs']>1&&$this->cfg['langs']&&!$this->cfg['trans'])cpPage::filter('language_all');cpPage::cmd('update');cpPage::nav('Imexport');break;default:$tpl->block($t,$d,true);break;}}public function tpl($d){global $tpl,$cfg,$alt,$stf;$h=' ';$m=& $this->cfg['structure'];$t=vPage::alt('task');$f=isset($this->cfg['task'][$t]['render'])?$this->cfg['task'][$t]['render']:$this->cfg['task'][$t]['field'];switch(($this->cfg['task'][$t]['type'])?$this->cfg['task'][$t]['type']:0){case 1:$h='@<div class="form_wra"><div class="tr_wra"><div class="td_wra"><table class="view"><tbody>';if(isset($this->cfg['task'][$t]['render'])){foreach($this->cfg['task'][$t]['render'] as $k){if(substr($k,0,2)!='o_'&&!is_array($d[$k]))$h.='<tr><th>'.$tpl->_($k).'</th><td>'.$d[$k].'</td></tr>';}}else{foreach($d as $k=>$v){if(substr($k,0,2)!='o_'&&!is_array($v))$h.='<tr><th>'.$tpl->_($k).'</th><td>'.$v.'</td></tr>';}}$h.='</tbody></table></div>';if(isset($this->cfg['task'][$t]['render2'])){$h.='<div class="td_wra"><table class="view"><tbody>';foreach($this->cfg['task'][$t]['render2'] as $k){if(substr($k,0,2)!='o_'&&!is_array($d[$k]))$h.='<tr><th>'.$tpl->_($k).'</th><td>'.$d[$k].'</td></tr>';}$h.='</tbody></table></div>';}$h.='</div></div>';break;case 4:$f=array_diff($f,array('pic_thumb','hot','lang'));$h='<!-- BLOCK '.$t.' --><form id="main_form" name="main_form" method="POST" action="{U_SUBMIT}"><table class="list"><thead><tr><td class="cw1"><input type="checkbox" name="checkall" class="checkbox checkall" /></td>';$a=isset($m['title'])?'title':$f[0];$r='';foreach($f as $i){if(isset($m[$i])){$h.='	<td class="th_'.$i.(($m[$i]=='int')?' cw2':'').'">'.$tpl->_($i).(($i=='ordering'&&$stf->move)?' <a href="javascript:cmd(\'order\')"><span class="ico isave"></span></a>':'').'</td>';if($i==$a)$r.=' <td class="{'.$t.'.row.CSS} title"><a <!-- IF row.U_VIEW -->href="{'.$t.'.row.U_VIEW}" <!-- ENDIF -->class="{'.$t.'.row.CSS}">{'.$t.'.row.ICON}{'.$t.'.row.'.strtoupper($i).'}</a><div class="actions">{'.$t.'.row.CMD}</div></td>';else $r.=' <td class="{'.$t.'.row.CSS}'.(($m[$i]=='int')?' center':'').'">{'.$t.'.row.'.strtoupper($i).'}</td>';}}$h.='</tr></thead><tbody>
<!-- BLOCK row -->
<tr class="tbrow"><td class="{'.$t.'.row.CSS} center"><input type="checkbox" name="ids[{'.$t.'.row.ID}]" value="{'.$t.'.row.ID}" class="checkbox" /></td>'.$r.'</tr>
<!-- END row -->
</tbody></table></form><!-- END '.$t.' -->';break;case 12:$n=&$this->cfg['task'][$t]['notnull'];$h='@<form id="main_form" name="main_form" method="POST" action="'.$this->cfg['url'].'&amp;'.VAR_TASK.'=edit&amp;'.VAR_ID.'='.$alt['id'].'" ENCTYPE="multipart/form-data">
<input type="hidden" name="update" value="1" />
<input type="submit" name="s'.time().'" value="" class="hidden" />
<div class="form_wra"><div class="tr_wra"><div class="td_wra"><table class="form">';$p=array();foreach($f as $k){if($k&&isset($m[$k])&&!in_array($k,array('published','enabled')))$p[$k]=$m[$k];}$h.=vForm::draw($p,$d,($cfg['langs']>1&&$this->cfg['langs']&&$this->cfg['trans'])?$this->cfg['trans']:'',$n,isset($d['ctype'])?$d['ctype']:'');$h.='<tr><th></th><td>';if(isset($m['enabled']))$h.='<p><input type="checkbox" name="enabled" id="enabled" value="1"'.((!isset($d['enabled'])||$d['enabled']||(isset($alt['_']['enabled'])&&$alt['_']['enabled']))?' checked="checked"':'').' /><label for="enabled">'.$tpl->l['PUBLISH'].'</label></p>';else if(isset($m['published'])){if(!isset($d['published']))$d['published']=time();$h.='<p><input type="checkbox" name="enabled" id="enabled" value="1"'.(($d['published']||(isset($alt['_']['enabled'])&&$alt['_']['enabled']))?' checked="checked"':'').' /><label for="enabled">'.$tpl->l['PUBLISH'].'</label> <input type="text" name="published" id="published" class="calendar" maxlength="25" value="'.vTime::format($cfg['date']['input'],$d['published']).'"> <span class="note">'.$tpl->_('Published format').'</span></p>';}if($alt['id'])$h.='<p><input type="checkbox" name="saveas" id="saveas" value="1" /><label for="saveas">'.$tpl->l['SAVEAS'].'</label></p>';$h.='<p><input type="checkbox" name="pageto" id="pageto" value="1"'.((isset($alt['_']['pageto'])&&$alt['_']['pageto'])?' checked="checked"':'').' /><label for="pageto">'.$tpl->l['PAGETO'].'</label></p></td></tr>';if(isset($this->cfg['task'][$t]['render2'])){$f=$this->cfg['task'][$t]['render2'];if(is_string($f))$f=preg_split('/[\n,;]/',$f);$p=array();foreach($f as $k){if($k&&isset($m[$k])&&!in_array($k,array('published','enabled')))$p[$k]=$m[$k];}if($p){$h.='</table></div><div class="td_wra"><table class="form" id="prop">';$h.=vForm::draw($p,$d,($cfg['langs']>1&&$this->cfg['langs']&&$this->cfg['trans'])?$this->cfg['trans']:'',$n,isset($d['ctype'])?$d['ctype']:'');}}$h.='</table></div></div></div></form>';break;case 31:$h='@<form id="main_form" name="main_form" method="POST" action="'.$this->cfg['url'].'&amp;'.VAR_TASK.'=imexport&amp;'.VAR_ACTION.'='.$alt['action'].'" ENCTYPE="multipart/form-data">
<input type="hidden" name="update" value="1" />
<input type="submit" name="s'.time().'" value="" class="hidden" />
<div class="form_wra"><div class="tr_wra"><div class="td_wra"><table class="form">
<tr><th></th><td>
<input type="radio" id="import" name="'.VAR_ACTION.'"'.(($d['deny']=='i')?' disabled="disabled"':(($alt['action']!='export'||$d['deny']=='e')?' checked="checked"':'')).' value="import"> <label for="import">'.$tpl->_('Import').'</label>
<input style="margin-left:15px;" type="radio" id="export" name="'.VAR_ACTION.'"'.(($d['deny']=='e')?' disabled="disabled"':(($alt['action']!='import'||$d['deny']=='i')?' checked="checked"':'')).' value="export"> <label for="export">'.$tpl->_('Export').'</label>';$h.='</td></tr>
<tr class="export"><th>'.$tpl->_('Data').'</th><td><select name="part">
<option value="0">'.$tpl->_('All').' ('.$d['total'].')</option>';if($d['page']>1){for($i=1;$i<=$d['page'];$i++){$a=($i-1)*$d['paging']+1;$b=$i*$d['paging'];$b=($b>$d['total'])?$d['total']:$b;$h.='<option value="'.$i.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tpl->_('Part').' '.$i.' ('.$a.' - '.$b.')</option>';}}$h.='</select></td></tr>
<tr class="export"><th>'.$tpl->_('File').'</th><td>
<input name="filename" type="text" value="'.$d['filename'].'"/>
<select name="ext">
	'.(class_exists('ZipArchive')?'<option value="xlsx">Excel 2007 (.xlsx)</option>':'').'
	<option value="xls">Excel 2003 (.xls)</option>
</select>
</td></tr>
<tr class="import"><th>'.$tpl->_('File').'</th><td><input type="file" name="file_upload"></td></tr>
<tr class="import"><th>Option: </th><td>
<input id="update" name="save" type="radio" checked="checked" value="update"/>
<label for="update">'.$tpl->_('Update').'</label>
<input style="margin-left:15px;" id="insert" name="save" type="radio" '.(($d['save']=='insert')?'checked="checked" ':'').'value="insert"/>
<label for="insert">'.$tpl->_('Create').'</label>
</td></tr>
</table></div></div></div></form>
<script>$("document").ready(function() {
function export_frm() {
	$(".export").show();
	$(".import").hide();
}
function import_frm() {
	$(".import").show();
	$(".export").hide();
}
if ($("input:radio[name='.VAR_ACTION.']:checked").val() == "export") export_frm(); else import_frm();
$("#export").click(function(){export_frm();});
$("#import").click(function(){import_frm();});
});</script>';break;}return $h;}}