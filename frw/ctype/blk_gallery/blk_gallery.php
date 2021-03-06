<?php
/**
 * @version		$Id: blk_gallery.php 3 2012-10-22 10:24 Phu $
 * @package		vFramework.block.gallery
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
function blk_gallery($p = '')
{
    global $tpl, $db, $map, $alt, $cfg;
    $o =& $p['prop'];
    $tpl->reset_theme('block');
    $tpl->reset_block('blk');
    $tpl->theme('block', (isset($o['tpl']) && $o['tpl']) ? $o['tpl'] : 'blk_gallery');
    $id = array();
    if (isset($o['src']) && $o['src']) {
        if (is_string($o['src']))
            $o['src'] = array(
                $o['src']
            );
        foreach ($o['src'] as $v) {
            if (isset($map->i[$v]) && $map->i[$v]['ctype'] == 'gallery')
                $id[] = $v;
        }
    } else {
        for ($i = 0; $i < $map->c; $i++) {
            if ($map->d[$i]['ctype'] == 'gallery')
                $id[] = $map->d[$i]['id'];
        }
    }
    if ($id) {
        $tpl->block('blk', array(
            'CSS' => $tpl->css($o['css'], '.vf_block'),
            'TITLE' => ($p['title']{0} == '~') ? '' : $p['title'],
            'TAG' => (!isset($o['tag']) || !$o['tag']) ? $o['tag'] : 'h3',
            'URL' => (isset($map->i[$id[0]])) ? URL_BASE . VAR_INDEX . '?' . VAR_PAGE . '=' . $map->i[$id[0]]['alias'] : ''
        ));
        $id = implode(',', $id);
        $s  = 'SELECT ' . (($cfg['sef']) ? 'alias as id' : 'id') . ', cid, title, pic_thumb, pic_full, preview FROM #__gallery WHERE cid IN (' . $id . ') AND published>0 AND published<' . time();
        if ($o['typ'] == 'hot')
            $s .= ' AND hot=1 ORDER BY rand()';
        else if ($o['typ'] == 'new')
            $s .= ' ORDER BY published DESC';
        else if ($o['typ'] == 'top')
            $s .= ' ORDER BY hits DESC';
        else
            $s .= ' ORDER BY rand()';
        if (!$db->query($s, $o['num']))
            trigger_error($db->error(), E_USER_ERROR);
        if ($db->affected_rows()) {
            $d = $db->fetch();
            if (isset($o['hot']) && $o['hot']) {
                for ($j = 0; $j < $o['hot']; $j++) {
                    if ($v = array_shift($d)) {
                        $v['title']     = (isset($o['pre']) && $o['pre']) ? '<p>' . $v['title'] . '</p>' : '';
                        $v['preview']   = (isset($o['pre']) && $o['pre']) ? '<p>' . $v['preview'] . '</p>' : '';
                        $v['pic_thumb'] = '<img src="' . URL_UPLOAD . $v['pic_thumb'] . '" alt="' . $v['title'] . '" />';
                        $v['pic_full']  = '<img src="' . URL_UPLOAD . $v['pic_full'] . '" alt="' . $v['title'] . '" />';
                        $v['U_VIEW']    = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&' : '') . VAR_PAGE . '=' . $map->i[$v['cid']]['alias'] . '&' . VAR_ID . '=' . $v['id'];
                        $tpl->block('blk.hot', $v, true);
                    }
                }
            }
            $i = 1;
            foreach ($d as $k => $v) {
                $v['title']     = (isset($o['pre']) && $o['pre']) ? '<p>' . $v['title'] . '</p>' : '';
                $v['preview']   = (isset($o['pre']) && $o['pre']) ? '<p>' . $v['preview'] . '</p>' : '';
                $v['pic_thumb'] = '<img src="' . URL_UPLOAD . $v['pic_thumb'] . '" alt="' . $v['title'] . '" />';
                $v['pic_full']  = '<img src="' . URL_UPLOAD . $v['pic_full'] . '" alt="' . $v['title'] . '" />';
                $v['U_VIEW']    = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&' : '') . VAR_PAGE . '=' . $map->i[$v['cid']]['alias'] . '&' . VAR_ID . '=' . $v['id'];
                $v['N']         = $i;
                $i++;
                $tpl->block('blk.row', $v, true);
            }
        }
    }
}