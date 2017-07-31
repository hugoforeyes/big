<?php
/**
 * @version		$Id: core.php 3 2013-08-09 09:35 Phu $
 * @package		vFramework.core
 * @copyright	(C) 2011 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE')or die('v');function __autoload($e){if($e{0}=='v')$e=substr($e,1);$e=strtolower($e).'.php';if(is_file(PATH_CORE.DS.$e))include PATH_CORE.DS.$e;else if(is_file(PATH_CP_CORE.DS.$e))include PATH_CP_CORE.DS.$e;}
class vPage{private static $_d='';static function blank($l){$h='';while($l>0){$h.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';$l--;}return $h;}static function cfg($k='',$v=null){global $cfg;$t=&$cfg;if($k){foreach(explode('.',$k)as $i){if(isset($t[$i]))$t=&$t[$i];else return null;}}if(is_null($v))return $t;else $t=$v;}static function gcfg($c='',$d=array()){global $db;if($c){$db->query('SELECT prop FROM #__cfg WHERE ctype="'.$c.'"');$d=array_merge($d,vRegistry::parse($db->fetch_field('prop')));}return $d;}static function alt($k='',$v=null){global $alt;$t=&$alt;if($k){foreach(explode('.',$k)as $i){if(isset($t[$i]))$t=&$t[$i];else return null;}}if(is_null($v))return $t;else $t=$v;}static function redirect($u='',$m=false){global $db,$file,$cfg;if(isset($db)){$db->close();}if(isset($file)){$file->close();}header($m?'HTTP/1.1 301 Moved Permanently':'HTTP/1.1 303 See other');header('Location: '.str_replace('&amp;','&',$u));die;}static function http404(){global $cfg;if(isset($cfg[404])&&$cfg['404']){vPage::redirect($cfg['404']);}else{header('HTTP/1.1 404 Not Found');header('Status: 404 Not Found');echo '<h3>HTTP 404 - The webpage cannot be found</h3>';}die;}static function finish($s=''){global $db,$file,$cfg;if(isset($cfg['~end']))die;$cfg['~end']=1;if(isset($db))$db->close();if(isset($file))$file->close();($cfg['gzip'])?@ob_flush():@flush();if($e=error_get_last())vPage::error($e['type'],$e['message'],$e['file'],$e['line']);self::$_d.=$s;if(self::$_d)self::$_d='<div id="debug"><h2>vFramework Debug</h2><pre>'.self::$_d.'</pre></div>';die(self::$_d);}static function message($s,$f='report'){global $tpl;$tpl->_var('MESSAGE','<div class="'.$f.'">'.((isset($tpl->l[$s]))?$tpl->l[$s]:$s).'</div>');}static function debug(){foreach(func_get_args()as $e){if(is_array($e))$e=var_export($e,true);self::$_d.='<p>'.$e.'</p>';}}static function error($e,$s,$f,$l){global $db,$cfg;if($cfg['debug']===0)return;$f=str_replace(PATH_ROOT,'',$f);$s=str_replace(PATH_ROOT,'',$s);if($cfg['debug']==1&&(substr($s,0,11)=='PHP Startup'||strpos($s,'deprecated')))$s='';if($s)self::$_d.='<p>'.$s.' in file <b>'.$f.'</b> on line <b>'.$l.'</b></p>';}static function paging($url,$total_items,$items_per_page,$start_page){return vPaging::_($url,$total_items,$items_per_page,$start_page);}static function head($s,$t=''){global $tpl,$cfg;switch($t){case 'css':$s='<link rel="stylesheet" href="'.$s.'" type="text/css" />';break;case 'style':$s='<style type="text/css">'.$s.'</style>';break;case 'js':$s='<script type="text/javascript" src="'.$s.'"></script>';break;case 'script':$s='<script type="text/javascript">'.$s.'</script>';break;case 'title':$a=$tpl->get('INC');if(strpos($a,'<title>')===false){$s='<title>'.$s.'</title>';}else{$a=str_replace("<title>","<title>".$s,$a);$tpl->_var('INC',$a);return;}break;case 'description':$s='<meta name="description" content="'.$s.'" />';break;case 'keywords':$s='<meta name="keywords" content="'.$s.'" />';break;}$s=(($cfg['debug'])?"\n":'').$s;$tpl->_var('INC',$s,true);}}
class vRegistry{static function cfg(&$c,$t){if(!isset($c['table'])||$c['table']=='')$c['table']=$t;if(isset($c['structure'])){$m=& $c['structure'];if($m&&is_string($m)){$t=preg_split('/[\n,;]/',$m);$m=array();foreach($t as $v){$v=preg_split('/[:=]/',$v.':');$m[$v[0]]=$v[1];}unset($t);}else{return;}}else $c['structure']=null;if(!isset($c['langs']))$c['langs']=0;if(!isset($c['trans']))$c['trans']='';else if($c['trans']&&is_string($c['trans']))$c['trans']=preg_split('/[\n,;]/',$c['trans']);if(!isset($c['tpl']))$c['tpl']='';$c['type']=array();foreach($c['task'] as $k=>$v){$m=& $c['task'][$k];if(!isset($m['type']))$m['type']=0;if($m['type'])$c['type'][$m['type']]=$k;if(!isset($m['auth']))$m['auth']='';if(!isset($m['tpl']))$m['tpl']='';if(isset($m['cmd'])&&$m['cmd']){if(is_string($m['cmd']))$m['cmd']=preg_split('/[\n,;]/',$m['cmd']);}else $m['cmd']='';if(isset($m['filter'])&&$m['filter']){if(is_string($m['filter']))$m['filter']=preg_split('/[\n,;]/',$m['filter']);}else $m['filter']='';if(isset($m['field'])&&$m['field']){if(is_string($m['field']))$m['field']=preg_split('/[\n,;]/',$m['field']);}else $m['field']='';if(isset($m['field2'])&&$m['field2']){if(is_string($m['field2']))$m['field2']=preg_split('/[\n,;]/',$m['field2']);}if(isset($m['render'])&&$m['render']){if(is_string($m['render']))$m['render']=preg_split('/[\n,;]/',$m['render']);}if(isset($m['render2'])&&$m['render2']){if(is_string($m['render2']))$m['render2']=preg_split('/[\n,;]/',$m['render2']);}}if(!isset($c['url']))$c['url']='';if(!isset($c['prop']))$c['prop']='';if(!isset($c['msg']))$c['msg']=array(0);}static function ref($a,$f='alias',$f2='',$p='prop'){$r=array();for($i=0,$j=sizeof($a);$i<$j;$i++){if(isset($a[$i][$p])&&$a[$i][$p])$a[$i][$p]=vRegistry::parse($a[$i][$p]);$r[$a[$i][$f]]=$a[$i];if($f2)$r[$a[$i][$f2]]=&$r[$a[$i][$f]];}return $r;}static function parse($d,$s=false){if(is_string($d)){$ls=explode("\n",$d);}else{if(is_array($d)){$ls=$d;}else{$ls=array();}}$a=array();$u=0;$sec='';foreach($ls as $l){$l=trim($l);if($l==''||$l{0}==';'){continue;}$n=strlen($l);if($l&&$l{0}=='['&&$l{$n-1}==']'){$sec=substr($l,1,-1);if($s){$a[$sec]=array();}}else{if($pos=strpos($l,'=')){$k=trim(substr($l,0,$pos));$v=trim(substr($l,$pos +1));if(strpos($v,'|')!==false&&preg_match('#(?<!\\\)\|#',$v)){$z=explode('\n',$v);$b=array();foreach($z as $x=>$y){$p=preg_split('/(?<!\\\)\|/',$y);$array=(strcmp($p[0],$y)===0)?false:true;$p=str_replace('\|','|',$p);foreach($p as $h=>$v2){if($v2=='false'){$v2=false;}else if($v2=='true'){$v2=true;}else if($v2&&$v2{0}=='"'){$n=strlen($v2);if($v2{$n-1}=='"'){$v2=stripcslashes(substr($v2,1,$n - 2));}}if(!isset($b[$x]))$b[$x]=array();$b[$x][]=str_replace('\n',"\n",$v2);}if(!$array){$b[$x]=$b[$x][0];}}if($s&&$sec){$a[$sec][$k]=$b[$x];}else{$a[$k]=$b[$x];}}else{$v=str_replace('\|','|',$v);if($v=='false'){$v=false;}else if($v=='true'){$v=true;}else if($v&&$v{0}=='"'){$n=strlen($v);if($v{$n-1}=='"'){$v=stripcslashes(substr($v,1,$n - 2));}}$v=str_replace('\n',"\n",$v);if($s&&$sec){$a[$sec][$k]=$v;}else{$a[$k]=$v;}}}else{if($s){$a['_invalid']['i'.$u++]=$l;}}}}return $a;}static function ini($d){$r='';$p='';if($d){foreach($d as $k=>$v){if(is_array($v)){if(is_int(key($v))){foreach($v as $x=>$y){$v[$x]=str_replace('|','\|',$y);$v[$x]=str_replace(array("\r\n","\n"),'\\n',$y);}$p.=$k.'='.implode('|',$v)."\n";}else{$r.="[$k]\n";foreach($v as $k=>$s){if(!is_array($s)){$s=str_replace('|','\|',$s);$s=str_replace(array("\r\n","\n"),'\\n',$s);$r.="$k=$s\n";}else if(is_int(key($s))){foreach($s as $x=>$y){$s[$x]=str_replace('|','\|',$y);$s[$x]=str_replace(array("\r\n","\n"),'\\n',$y);}$r.=$k.'='.implode('|',$s)."\n";}}$r.="\n";}}else{$v=str_replace('|','\|',$v);$v=str_replace(array("\r\n","\n"),'\\n',$v);$p.="$k=$v\n";}}}return trim("$p\n$r");}static function php(){}static function xml(){}}
class vRequest{static function set($name,$val=null,$hash='GET'){$bk=array_key_exists($name,$_REQUEST)?$_REQUEST[$name]:null;switch($hash){case 'POST':$_POST[$name]=$val;$_REQUEST[$name]=$val;break;case 'COOKIE':$_COOKIE[$name]=$val;$_REQUEST[$name]=$val;break;case 'FILES':$_FILES[$name]=$val;break;case 'ENV':$_ENV[$name]=$val;break;case 'SERVER':$_SERVER[$name]=$val;break;default:$_GET[$name]=$val;$_REQUEST[$name]=$val;break;}return $bk;}static function site($f=1){global $cfg;if($cfg['base']==''||$cfg['base']=='/')$s='http'.((isset($_SERVER['HTTPS'])&&!empty($_SERVER['HTTPS'])&&(strtolower($_SERVER['HTTPS'])!='off'))?'s':'').'://'.$_SERVER['HTTP_HOST'];else list($s)=explode($cfg['base'],self::uri());return $s.($f?$cfg['base']:'');}static function ip(){return(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))?$_SERVER['HTTP_X_FORWARDED_FOR']:((!empty($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:getenv('REMOTE_ADDR'));}static function uri(){if(isset($_SERVER['HTTPS'])&&!empty($_SERVER['HTTPS'])&&(strtolower($_SERVER['HTTPS'])!='off')){$https='s://';}else{$https='://';}if(!empty($_SERVER['PHP_SELF'])&&!empty($_SERVER['REQUEST_URI'])){$theURI='http'.$https.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];}else{$theURI='http'.$https.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];if(isset($_SERVER['QUERY_STRING'])&&!empty($_SERVER['QUERY_STRING'])){$theURI.='?'.$_SERVER['QUERY_STRING'];}}return vFilter::text(urldecode($theURI));}static function method($m=''){global $_v_method;if($m){$_v_method=strtoupper($m);return;}return strtoupper($_SERVER['REQUEST_METHOD']);}static function issubmit($name){return isset($_REQUEST[$name]);}static function _var($n,$d=null,$m='',$f=''){global $_v_method;$m=($m)?$m:$_v_method;if($m=='FILES'){$v=&$_FILES;$r=$f?((isset($v[$f.'_'.$n])&&$v[$f.'_'.$n]!==null)?$v[$f.'_'.$n]:$d):((isset($v[$n])&&$v[$n]!==null)?$v[$n]:$d);}else{switch($m){case 'GET':$v=&$_GET;break;case 'POST':$v=&$_POST;break;case 'COOKIE':$v=&$_COOKIE;break;case 'ENV':$v=&$_ENV;break;case 'SERVER':$v=&$_SERVER;break;default:$v=&$_REQUEST;$m='REQUEST';}$r=$f?((isset($v[$f][$n])&&$v[$f][$n]!==null)?$v[$f][$n]:$d):((isset($v[$n])&&$v[$n]!==null)?$v[$n]:$d);if(get_magic_quotes_gpc()&&$r!=$d)$r=self::_strip_slashes($r);}return $r;}static function vars(&$n,$arr,$type='',$m='',$f=''){if(!is_array($arr))$arr=preg_split('/[\n,;]/',$arr);$d=null;foreach($arr as $k=>$t){if(is_int($k))list($k,$t,$d)=explode(':',$t.'::');$t=($t)?$t:$type;switch($t){case 'captcha':$n[$k]=vCaptcha::check(self::string($k.'_sid',$d,$m),(string) vFilter::text(self::string($k,$d,$m)));break;case 'record':case 'page':case 'category':case 'int':$n[$k]=self::int($k,intval($d),$m,$f);break;case 'float':$n[$k]=self::float($k,floatval(($d)),$m,$f);break;case 'bool':$n[$k]=self::bool($k,0,$m,$f);break;case 'word':$n[$k]=(string) vFilter::word(self::word($k,$d,$m,$f));break;case 'cmd':$n[$k]=(string) vFilter::cmd(self::cmd($k,$d,$m,$f));break;case 'alias':$n[$k]=(string) vFilter::alias(self::string($k,$d,$m,$f));break;case 'email':$n[$k]=(string) vFilter::email(self::string($k,$d,$m,$f));break;case 'char':case 'nchar':case 'tinytext':case 'text':case 'string':$n[$k]=(string) vFilter::text(self::string($k,$d,$m,$f));break;case 'image':case 'media':case 'file':$n[$k]=(string) vFilter::text(self::string($k,$d,$m,$f));$n[$k.'_uploader']=self::file($k.'_uploader',$f);break;case 'images':case 'medias':case 'files':if(!defined('V_CP'))$n[$k.'_uploader']=self::file($k.'_uploader',$f);case 'records':case 'categories':case 'pages':case 'prop':case 'size':case 'meta':case 'tree':case 'array':case 'arr':case 'arr_bool':case 'arr_int':case 'arr_float':if($t=='size')$t='arr_int';$a=strstr($t,'_');$n[$k]=(array) self::arr($k,($a)?substr($a,1):'',$m,$f);break;default:$n[$k]=(string) vFilter::html(self::_var($k,$d,$m,$f));break;}}}static function int($n,$d=0,$m='',$f=''){return intval(self::_var($n,$d,$m,$f));}static function float($n,$d=0.0,$m='',$f=''){return floatval(self::_var($n,$d,$m,$f));}static function bool($n,$d=false,$m='',$f=''){return(self::_var($n,$d,$m,$f))?true:false;}static function word($n,$d='',$m='',$f=''){return (string) vFilter::word(self::_var($n,$d,$m,$f));}static function cmd($n,$d='',$m='',$f=''){return (string) vFilter::cmd(self::_var($n,$d,$m,$f));}static function string($n,$d='',$m='',$f=''){return (string) vFilter::text(self::_var($n,$d,$m,$f));}static function html($n,$d='',$m='',$f='',$r=false){return (string) vFilter::html(self::_var($n,$d,$m,$f),$r);}static function file($n,$f=''){return self::_var($n,null,'FILES',$f);}static function arr($n,$t='',$m='',$f=''){$x=(array) self::_var($n,null,$m,$f);return vFilter::arr($x,$t);}static function _strip_slashes($val){$val=is_array($val)?array_map(array('vRequest','_strip_slashes'),$val):stripslashes($val);return $val;}}
class vTime{static function timer(){global $_v_timer;list($usec,$sec)=explode(' ',microtime());if($_v_timer){return (float)$usec + (float)$sec - $_v_timer;}else{$_v_timer=(float)$usec + (float)$sec;return false;}}static function live($s,$print=false){global $tpl;$arr=array('day'=>0,'hour'=>0,'minute'=>0,'second'=>0,);if($s>=86400){$arr['day']=floor($s / 86400);$s=$s % 86400;}if($s>=3600){$arr['hour']=floor($s / 3600);$s=$s % 3600;}if($s>=60){$arr['minute']=floor($s / 60);$s=$s % 60;}$arr['second']=$s;if($print){$str='';$str.=($arr['day'])?($arr['day'].' '.(($arr['day']>1)?$tpl->l['DAYS']:$tpl->l['DAY'])):'';$str.=($arr['hour'])?(' '.$arr['hour'].' '.(($arr['hour']>1)?$tpl->l['HOURS']:$tpl->l['HOUR'])):'';$str.=($arr['minute'])?(' '.$arr['minute'].' '.(($arr['minute']>1)?$tpl->l['MINUTES']:$tpl->l['MINUTE'])):'';$str.=($arr['second'])?(' '.$arr['second'].' '.(($arr['second']>1)?$tpl->l['SECONDS']:$tpl->l['SECOND'])):'';return $str;}return $arr;}static function format($f='',$t=null){global $tpl;$t=($t===null)?time():$t;if($t){if(strpos($f,'%a')!==false)$f=str_replace('%a',$tpl->l['SWEEK'.date('w',$t)],$f);if(strpos($f,'%A')!==false)$f=str_replace('%A',$tpl->l['WEEK'.date('w',$t)],$f);if(strpos($f,'%b')!==false)$f=str_replace('%b',$tpl->l['SMONTH'.date('n',$t)],$f);if(strpos($f,'%B')!==false)$f=str_replace('%B',$tpl->l['MONTH'.date('n',$t)],$f);return strftime($f,$t);}}static function timestamp($s,$f=''){if($f==''){$t=strtotime($s);}else{$t=0;}return $t;}}
class vFilter{static function arr($e,$t=''){foreach($e as $i=>$v){if(is_array($v))$e[$i]=vFilter::arr($v,is_array($t)?$t[$i]:$t);else{switch((is_array($t)&&$t)?$t[$i]:$t){case 'int':$e[$i]=intval($v);break;case 'float':$e[$i]=floatval($v);break;case 'bool':$e[$i]=($v)?1:0;break;default:$e[$i]=vFilter::html($v);}}}return $e;}static function email($e){if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/",$e))return $e;return false;}static function domain($e){if(preg_match("@^[a-z0-9]+[a-z0-9-]+(\.[a-z0-9-]+)?(\.[a-z]{2,6})$@i",$e))return $e;return false;}static function url($s){if($s){$t=substr($s,0,7);if($t!='http://'&&$t!='https:/')$s='http://'.$s;if(preg_match("@^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})(:[0-9]+)?(/.*)?$@i",$s))return $s;}return '';}static function file($f,$type=''){global $cfg;$f=preg_replace(array('/[^\w\.\-]+/','/_+/'),'_',strtolower($f));$s=','.(($type=='image')?$cfg['file']['image']:(($type=='media')?$cfg['file']['media'].','.$cfg['file']['image']:$cfg['file']['ext'].','.$cfg['file']['media'].','.$cfg['file']['image']));if(strpos($s,substr(strrchr($f,'.'),1))===false)$f='';return $f;}static function folder($f){$f=preg_replace(array('/[^\w\.\-\/]+/','/_+/'),'',strtolower($f));$f=preg_replace('#[/\\\\]+#','/',$f);$f=str_replace(array('../','./'),'',$f);if($f&&$f{0}==DS)$f=substr($f,1);if($f&&substr($f,-1)==DS)$f=substr($f,0,-1);return $f;}static function ip($e){if($e==filter_var($e,FILTER_VALIDATE_IP))return true;return false;}static function alias($s){if(!function_exists('utf8_strtoascii'))require_once(PATH_CORE.DS.'string.php');return($s=='/')?$s:preg_replace(array('/\s+/','/[^a-z0-9\.\-]/'),array('-',''),trim(str_replace(array('_','-'),' ',utf8_strtoascii($s))));}static function text($s){if(is_array($s))$s=implode("\n",$s);$s=str_replace(array('"','<','>'),array('&quot;','&lt;','&gt;'),$s);$s=preg_replace('/eval\((.*)\)/','',$s);$s=preg_replace('/[\\\"\\\'][\\s]*javascript:(.*)[\\\"\\\']/','""',$s);return trim($s);}static function html($s,$r=false){global $cfg;if(self::utf8($s)===false)return '';$s=str_replace(chr(0),'',$s);$s=preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%','',$s);$s=str_replace('&','&amp;',$s);$s=preg_replace(array('/&amp;#([0-9]+;)/','/&amp;#[Xx]0*((?:[0-9A-Fa-f]{2})+;)/','/&amp;([A-Za-z][A-Za-z0-9]*;)/'),array('&#\1','&#x\1','&\1'),$s);if($r)$s=preg_replace('/<(.*?)>/ie',"'<'.preg_replace(array('/javascript:[^\"\']*/i', '/(".(isset($cfg['disabled_attributes'])?$cfg['disabled_attributes']:'style|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onunload').")=[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')).'>'",strip_tags($s,isset($cfg['allowable_tags'])?$cfg['allowable_tags']:'<p><a><img><strong><b><em><i><u><blockquote>'));return trim($s);}static function cmd($s){return preg_replace('/[^A-Z0-9_\.-]/i','',$s);}static function word($s){return preg_replace('/[^A-Z_]/i','',$s);}static function quot($s){return str_replace(array('\\\"','\"','"'),'&quot;',$s);}static function digit($s){return preg_replace('/[^0-9]/i','',$s);}static function tel($s){return preg_replace('/[^0-9.+()]/i','',$s);}static function utf8($s){if(strlen($s)==0)return true;return(preg_match('/^./us',$s)==1);}}
class vSitemap{private static $_m;var $d=array();var $r=array();var $i=array();var $l=array();var $lr=array();var $c=0;public static function instance($p=false){if(is_null(self::$_m))self::$_m=new self($p);return self::$_m;}function __construct($p=false,$l=''){$this->load($p,$l);}function lang($l=''){global $alt,$cfg,$db;if(!$l&&$cfg['lang']!=$alt['lang'])$l=$cfg['lang'];if($l&&!isset($this->l[$l])){$sql='SELECT id,alias FROM '.(($l==$cfg['lang'])?'#__sitemap WHERE enabled=1':'#__sitemap_trans WHERE lang="'.$l.'"');if(!$db->query($sql)){trigger_error($db->error(),E_USER_ERROR);}$d=$db->fetch();foreach($d as $v){$this->l[$l][$v['id']]=$v['alias'];$this->lr[$l][$v['alias']]=$v['id'];}}}function load($p=false,$l=''){global $cfg,$db;if($cfg['langs']>1&&$l&&$l<>$cfg['lang'])$sql='SELECT a.*, t.title, t.alias, t.meta
			FROM #__sitemap a LEFT JOIN #__sitemap_trans t
			ON a.id = t.id
			WHERE t.lang="'.$l.'"'.(($p)?' AND a.enabled=1':'').' ORDER BY a.ordering ASC';else $sql='SELECT * FROM #__sitemap WHERE 1'.(($p)?' AND enabled=1':'').((V_LIFE==2)?' AND sid='.V_SITE:'').' ORDER BY ordering ASC';if(!$db->query($sql)){trigger_error($db->error(),E_USER_ERROR);}$this->c=$db->affected_rows();$this->d=$db->fetch();$this->r=array();$this->i=array();$this->h=null;$this->m=null;$this->t=null;for($i=0;$i<$this->c;$i++){$this->d[$i]['prop']=vRegistry::parse($this->d[$i]['prop']);$this->d[$i]['tree']=vRegistry::parse($this->d[$i]['tree']);if(!isset($this->d[$i]['tree']['l']))$this->d[$i]['tree']['l']=0;if($this->d[$i]['alias']=='/')$this->h=&$this->d[$i];else if($this->d[$i]['ctype']=='member')$this->m=&$this->d[$i];else if($this->d[$i]['ctype']=='tags')$this->t=&$this->d[$i];$this->r[$this->d[$i]['alias']]=& $this->d[$i];$this->i[$this->d[$i]['id']]=& $this->d[$i];}}function select($e='',$all=false){global $tpl;if($e){if(is_array($e)){$t=',';foreach($e as $v)$t.=$v.','.$this->i[$v]['tree']['f'].',';$e=$t;unset($t);}else $e=','.$e.','.$this->i[$e]['tree']['f'].',';}$l=array();if($all===true)$l[0]=$tpl->l['ALL'];else if($all!==false)$l[0]='';for($i=0;$i<$this->c;$i++){if(strpos($e,','.$this->d[$i]['id'].',')===false)$l[$this->d[$i]['id']]=vPage::blank($this->d[$i]['tree']['l']).$this->d[$i]['title'];}return $l;}function count($c=0,$m=''){global $alt,$db;if($c===true)vPage::redirect(VAR_INDEX.'?'.VAR_PAGE.'=cp.sitemap&'.VAR_TASK.'resync');if($m==''&&substr($alt['page'],0,3)!='cp.')$m=$alt['page'];if($m){$c=intval($c);if($c){$sql='UPDATE #__sitemap SET count=count+'.$c.' WHERE alias="'.$m.'"';if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);}else{$sql='SELECT count(*) as counter FROM #__'.$this->r[$m]['ctype'].' WHERE cid='.$this->r[$m]['id'];if($db->query($sql)){$sql='UPDATE #__sitemap SET count='.$db->fetch_field('counter').' WHERE alias="'.$m.'"';if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);}}}}function menu($t,$p,$s){global $cfg,$alt,$tpl,$db;$tpl->reset_theme('block');if(!$tpl->theme('block',(isset($p['tpl'])&&$p['tpl'])?$p['tpl']:'blk_menu'))$tpl->theme('block','','<!-- BLOCK blk -->
<div {blk.CSS}>
<!-- IF blk.TITLE -->
<h3 class="vf_tit">{blk.TITLE}</h3>
<!-- ENDIF -->
<!-- BLOCK row -->
<!-- IF row.TREE == "o1" -->
<ul>
<!-- ELSEIF row.TREE == "c1" -->
</ul>
<!-- ELSEIF row.TREE == "o2" -->
<li><a href="{row.URL}"<!-- IF row.ACTIVE --> class="active"<!-- ENDIF -->>{row.TITLE}</a>
<!-- ELSE -->
</li>
<!-- ENDIF -->
<!-- END row -->
</div>
<!-- END blk -->');if(isset($p['img'])===false)$p['img']=false;$tpl->reset_block('blk');$m=array();if($p['src']==''){for($i=0;$i<$this->c;$i++){if($this->d[$i]['pid']==0)$m[]=$this->d[$i]['id'];}}else if(is_array($p['src']))$m=$p['src'];else $m[]=$p['src'];if($p['sub']){$c=sizeof($m);$d=array();for($i=0;$i<$c;$i++){if(isset($p['sel'])&&$p['sel'])$d[]=$m[$i];if($p['sub']==1&&isset($this->i[$m[$i]])&&$this->i[$m[$i]]['tree']['c']){$d=array_merge($d,explode(',',$this->i[$m[$i]]['tree']['c']));}else if(isset($this->i[$m[$i]])&&$this->i[$m[$i]]['tree']['f']){foreach(explode(',',$this->i[$m[$i]]['tree']['f'])as $b){if(isset($this->i[$b])&&$this->i[$b]['tree']['l']<=$this->i[$m[$i]]['tree']['l'] + $p['sub'])$d[]=$b;}}}$m=$d;}$tpl->block('blk',array('CSS'=>$tpl->css($p['css'],'.vf_menu'),'TITLE'=>($t{0}=='~')?'':$t));$tpl->block('blk.row',array('CSS'=>$tpl->css($p['css'],'.vf_menu'),'TREE'=>'o1','LEVEL'=>0,));$b=array();$c=sizeof($m);$i=0;$l=isset($this->i[$m[0]])?$this->i[$m[0]]['tree']['l']:1;while($i<$c){if(isset($this->i[$m[$i]])){if($this->i[$m[$i]]['tree']['l']>$l&&$p['sub']>0){$tpl->block('blk.row',array('TREE'=>'o1','LEVEL'=>(int)$this->i[$m[$i]]['tree']['l'],));$b[]=array(1,(int)$this->i[$m[$i]]['tree']['l']);}else if($this->i[$m[$i]]['tree']['l']<$l&&$p['sub']>0){for($j=0,$k=($l-$this->i[$m[$i]]['tree']['l'])*2;$j<=$k;$j++){if($b){list($b1,$b2)=array_pop($b);$tpl->block('blk.row',array('TREE'=>$b1?'c1':'c2','LEVEL'=>$b2,));}}}else if($b){list($b1,$b2)=array_pop($b);$tpl->block('blk.row',array('TREE'=>$b1?'c1':'c2','LEVEL'=>$b2,));}$l=$this->i[$m[$i]]['tree']['l'];$ti=$this->i[$m[$i]]['title'];if($p['img']&&$this->i[$m[$i]]['pic_thumb'])$ti='<img src="'.URL_UPLOAD.$this->i[$m[$i]]['pic_thumb'].'" /><b>'.$ti.'</b>';$u=($this->i[$m[$i]]['ctype']=='alias')?$this->i[$m[$i]]['prop']['url']:$this->i[$m[$i]]['alias'];if($u&&substr($u,0,7)!='http://'){$a=($cfg['langs']>1&&$cfg['lang']!=$alt['lang'])?VAR_LANG.'='.$alt['lang'].'&amp;':'';if($u{0}=='?')$u=URL_BASE.VAR_INDEX.'?'.$a.substr($u,1);else if($u{0}=='/')$u=URL_BASE.(($u=='/')?(($cfg['langs']>1&&$cfg['lang']!=$alt['lang'])?VAR_INDEX.'?'.VAR_LANG.'='.$alt['lang']:''):substr($u,1));else $u=URL_BASE.VAR_INDEX.'?'.$a.VAR_PAGE.'='.((is_numeric($u)&&isset($this->i[$u]))?$this->i[$u]['alias']:$u);}if(!is_array($this->i[$m[$i]]['meta']))$this->i[$m[$i]]['meta']=vRegistry::parse($this->i[$m[$i]]['meta']);$tpl->block('blk.row',array('TREE'=>'o2','TITLE'=>$ti,'URL'=>$u,'PIC_THUMB'=>($this->i[$m[$i]]['pic_thumb'])?URL_UPLOAD.$this->i[$m[$i]]['pic_thumb']:'','ACTIVE'=>($this->i[$m[$i]]['alias']==$s||strpos(','.$this->r[$s]['tree']['p'].',',','.$this->i[$m[$i]]['id'].',')!==false)?' class="active"':'','SUB'=>(isset($m[$i+1])&&isset($this->i[$m[$i+1]])&&$this->i[$m[$i+1]]['tree']['l']>$this->i[$m[$i]]['tree']['l'])?1:0,'LEVEL'=>(int)$this->i[$m[$i]]['tree']['l'],'META_TITLE'=>isset($this->i[$m[$i]]['meta']['t'])?$this->i[$m[$i]]['meta']['t']:'','META_DESC'=>isset($this->i[$m[$i]]['meta']['d'])?$this->i[$m[$i]]['meta']['d']:'','ALIAS'=>$this->i[$m[$i]]['alias']=='/'?'homepage':$this->i[$m[$i]]['alias'],'ID'=>$this->i[$m[$i]]['id'],));$b[]=array(0,(int)$this->i[$m[$i]]['tree']['l']);}$i++;}while($b){list($b1,$b2)=array_pop($b);$tpl->block('blk.row',array('TREE'=>$b1?'c1':'c2','LEVEL'=>$b2,));}$tpl->block('blk.row',array('TREE'=>'c1','LEVEL'=>0));return $tpl->display('block',1);}}
class vCType{var $d=array();var $r=array();var $c=0;function __construct($b=false){$this->load($b);}function load($b=false){global $cfg,$db;if($b!==false){if($b<0)$b=0;if($b>3)$b=3;}$sql='SELECT name, func, ctype, prop FROM #__ctype WHERE '.($b===false?'':'ctype='.$b.' AND ').'enabled=1 ORDER BY name ASC';if(!$db->query($sql)){trigger_error($db->error(),E_USER_ERROR);}$this->c=$db->affected_rows();$this->d=$db->fetch();$this->r=array();for($i=0;$i<$this->c;$i++){$this->d[$i]['prop']=vRegistry::parse($this->d[$i]['prop']);$this->r[$this->d[$i]['ctype']][$this->d[$i]['name']]=& $this->d[$i];}}}
class vBlocks{var $d=array();var $c=0;function __construct($p){$this->load($p);}function load($p){global $db,$cfg,$alt;$sql='SELECT id, title, ctype, auth, pos, prop FROM #__blocks WHERE enabled=1'.((V_LIFE==2)?' AND sid='.V_SITE:'').(($cfg['langs']>1)?' AND (lang="" OR lang="'.$alt['lang'].'")':'').' AND (page="" OR page LIKE "%,'.$p.',%") ORDER BY ordering ASC';if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);$this->c=$db->affected_rows();$this->d=$db->fetch();for($i=0;$i<$this->c;$i++){$this->d[$i]['prop']=vRegistry::parse($this->d[$i]['prop']);}}}