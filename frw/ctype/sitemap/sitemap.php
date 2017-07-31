<?php
/**
 * @version		$Id: sitemap.php 2 2012-01-04 10:32 phu $
 * @package		vFramework.sitemap
 * @copyright	(C) 2011 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE')or die('v');$cfg['~ajax']=true;$alt['module']=&$map->r[$alt['page']];$o=&$map->r[$alt['page']]['prop'];$url=vRequest::site();@header('Content-Type: text/xml');$t=vRegistry::parse($alt['module']['meta']);echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
	<loc>'.$url.'</loc>
	<lastmod>'.date('r',time()-600).'</lastmod>
	<changefreq>daily</changefreq>
	<priority>1.00</priority>
</url>';$ids=array();if(isset($o['src'])&&$o['src']){if(is_string($o['src']))$o['src']=array($o['src']);foreach($o['src'] as $v){if(isset($map->i[$v])&&$map->i[$v]['ctype']=='article')$ids[]=$v;}}else{for($i=0;$i<$map->c;$i++){if($map->d[$i]['ctype']=='article')$ids[]=$map->d[$i]['id'];}}foreach($ids as $id){if($map->i[$id]['alias']&&$map->i[$id]['alias']!='/'&&$map->i[$id]['ctype']!='alias'){echo '
<url>
	<loc>'.$url;$u='?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&':'').VAR_PAGE.'='.$map->i[$id]['alias'];if($cfg['sef'])$u=vSEF::_($u);else $u=VAR_INDEX.$u;echo $u.'</loc>
	<lastmod>'.date('r',time()-900-(900*$map->i[$id]['tree']['l'])).'</lastmod>
	<changefreq>daily</changefreq>
	<priority>'.(0.8 -($map->i[$id]['tree']['l']*0.05)).'</priority>
</url>';}}for($i=0,$n=count($ids);$i<$n;$i++){$v=$map->i[$ids[$i]]['prop'];if(is_string($v))$v=vRegistry::parse($v);if(isset($v['typ'])&&$v['typ']==1)unset($ids[$i]);}$ids=implode(',',$ids);$f=' WHERE'.(($ids)?' cid IN ('.$ids.') AND':'').' published>0 AND published<'.time();$f.=($cfg['langs']>1)?(' AND ('.(($alt['lang']==$cfg['lang'])?'lang="" OR ':'').'lang="'.$alt['lang'].'")'):'';$sql='SELECT '.(($cfg['sef'])?'alias as id':'id').', cid, title, alias, preview, published FROM #__article'.$f.' ORDER BY published DESC';if(!$db->query($sql))trigger_error($db->error(),E_USER_ERROR);if($db->affected_rows()){$d=$db->fetch();foreach($d as $k=>$v){echo '
<url>
	<loc>'.$url;$u='?'.(($cfg['langs']>1&&$alt['lang']!=$cfg['lang'])?VAR_LANG.'='.$alt['lang'].'&':'').VAR_PAGE.'='.$map->i[$v['cid']]['alias'].'&amp;'.VAR_ID.'='.$v['id'];if($cfg['sef'])$u=vSEF::_($u);else $u=VAR_INDEX.$u;echo $u.'</loc>
	<lastmod>'.date('r',$v['published']).'</lastmod>
	<changefreq>daily</changefreq>
	<priority>'.(0.5 -($map->i[$v['cid']]['tree']['l']*0.05)).'</priority>
</url>';}}echo '</urlset>';?>