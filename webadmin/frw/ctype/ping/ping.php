<?php
/**
* @version		$Id: ping.php 2 2011-12-28 11:02 phu $
* @package		vFramework.cp.ping
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');$tpl->lang('ping');$c=VAR_INDEX.'?'.VAR_LANG.'='.$alt['lang'].'&'.VAR_PAGE.'='.$alt['page'];$u=vFilter::url(vRequest::site());$s=parse_ini_file(PATH_WORKING.DS.'ping.ini',true);if($u&&$alt['section']){if(isset($map->r['sitemap.xml']))$u.='sitemap.xml';if(isset($s[$alt['section']])&&isset($s[$alt['section']]['url'])&&$s[$alt['section']]['url']){$s=$s[$alt['section']]['url'];$m=$tpl->l['ERR_FAILS'];if(strpos($s,'{XML}')===false){$p=parse_url($s);if(isset($p['host'])){$host=$p['host'];$port=isset($p['port'])?$p['port']:80;$uri=isset($p['path'])?$p['path']:'/';if($f=fsockopen($host,$port,$e1,$e2)){$d='<?xml version="1.0"?>
<methodCall>
<methodName>weblogUpdates.ping</methodName>
<params>
	<param><value>'.$cfg['site'].'</value></param>
	<param><value>'.$u.'</value></param>
</params>
</methodCall>';$d="POST $uri HTTP/1.0\r\nUser-Agent: vFramework! Ping/1.0\r\nHost: $host\r\nContent-Type: text/xml\r\nContent-length: ".strlen($d)."\r\n\r\n".$d;fwrite($f,$d);$r='';while(!feof($f))$r.=fgets($f,128);fclose($f);$m=trim($r);}}}else{$s=str_replace('{XML}',$u,$s);if(($f=fopen($s,"r"))==true){$m=stream_get_contents($f);fclose($f);}}echo $m;}die;}cpPage::nav('ping',$c);if($u){cpPage::cmd('resync','javascript:ping();');}else{cpPage::error('Can not ping from localhost !!!');}$h='<table class="list"><thead><tr><td class="cw1"><input type="checkbox" name="checkall" class="checkbox checkall" /></td><td>'.$tpl->_('Ping_srv').'</td><td>'.$tpl->_('Result').'</td></tr></thead><tbody>';foreach($s as $k=>$v){$h.='<tr class="tbrow"><td class="center">'.((isset($v['url'])&&$v['url'])?'<input type="checkbox" name="ids['.$k.']" value="'.$k.'" class="checkbox ping" />':'').'</td>
<td><a '.((isset($v['www'])&&$v['www'])?'href="'.$v['www'].'" ':'').'target="_blank">'.((isset($v['desc'])&&$v['desc'])?$v['desc']:$k).'</a></td>
<td id="'.$k.'">'.((!isset($v['url'])||!$v['url'])?'<a href="'.$v['www'].'" target="_blank">'.$v['www'].'</a>':'').'</td></tr>';}$h.='</tbody></table>
<script type="text/javascript">
function ping() {
	$(".ping").each(function(index){
		if ($(this).is(":checked")) {
			var ping = $(this).val();
			$("#" + ping).html(\'<img src="'.URL_CP_THEME.'img/loading.gif" />\');
			$.ajax("'.$c.'&s=" + ping).done(function(d){
				$("#" + ping).html(d);
			}).fail(function() {
				alert("Error!");
			});
		}
	});
}
</script>';$tpl->theme('body','',$h);