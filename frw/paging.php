<?php
/**
 * @version		$Id: paging.php 3 2012-09-05 9:43 Phu $
 * @package		vFramework.core.paging
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
class vPaging
{
    static function _($u, $t, $p, $s)
    {
        return self::p3($u, $t, $p, $s);
    }
    static function p3($u, $t, $p, $s)
    {
        global $tpl, $cfg;
        if (!$p)
            $p = $cfg['paging'];
        $total_pages = ceil($t / $p);
        if ($total_pages > 1) {
            $tpl->reset_theme('block');
            if (!$tpl->theme('block', (isset($p['tpl']) && $p['tpl']) ? $p['tpl'] : 'blk_paging'))
                $tpl->theme('block', '', '<!-- BLOCK blk -->
<div class="vf_pag"><p>
<span>{L_PAGE}</span>
<!-- BLOCK prev -->
<a href="{prev.URL}" title="{L_PREV}" class="prev">{L_PREV}</a>
<!-- END prev -->
<!-- BLOCK row -->
<!-- IF row.DOT -->
<a class="dot">...</a>
<!-- ELSE -->
<a<!-- IF row.URL --> href="{row.URL}"<!-- ENDIF --><!-- IF row.ACTIVE --> class="active"<!-- ENDIF -->>{row.TITLE}</a>
<!-- ENDIF -->
<!-- END row -->
<!-- BLOCK next -->
<a href="{next.URL}" title="{L_NEXT}" class="next">{L_NEXT}</a>
<!-- END next -->
</p></div>
<!-- END blk -->');
            $tpl->reset_block('blk');
            $tpl->block('blk', array());
            if ($total_pages > 10) {
                $init_page_max = ($total_pages > 3) ? 3 : $total_pages;
                for ($i = 1; $i < $init_page_max + 1; $i++) {
                    $tpl->block('blk.row', array(
                        'TITLE' => $i,
                        'ACTIVE' => ($i == $s) ? 1 : 0,
                        'URL' => ($i == $s) ? '' : $u . '&amp;' . VAR_PAGING . '=' . $i
                    ));
                }
                if ($total_pages > 3) {
                    if ($s > 1 && $s < $total_pages) {
                        if ($s > 5)
                            $tpl->block('blk.row', array(
                                'DOT' => 1
                            ));
                        $init_page_min = ($s > 4) ? $s : 5;
                        $init_page_max = ($s < $total_pages - 4) ? $s : $total_pages - 4;
                        for ($i = $init_page_min - 1; $i < $init_page_max + 2; $i++) {
                            $tpl->block('blk.row', array(
                                'TITLE' => $i,
                                'ACTIVE' => ($i == $s) ? 1 : 0,
                                'URL' => ($i == $s) ? '' : $u . '&amp;' . VAR_PAGING . '=' . $i
                            ));
                        }
                        if ($s < $total_pages - 4)
                            $tpl->block('blk.row', array(
                                'DOT' => 1
                            ));
                    } else {
                        $tpl->block('blk.row', array(
                            'DOT' => 1
                        ));
                    }
                }
                for ($i = $total_pages - 2; $i < $total_pages + 1; $i++) {
                    $tpl->block('blk.row', array(
                        'TITLE' => $i,
                        'ACTIVE' => ($i == $s) ? 1 : 0,
                        'URL' => ($i == $s) ? '' : $u . '&amp;' . VAR_PAGING . '=' . $i
                    ));
                }
            } else {
                for ($i = 1; $i < $total_pages + 1; $i++) {
                    $tpl->block('blk.row', array(
                        'TITLE' => $i,
                        'ACTIVE' => ($i == $s) ? 1 : 0,
                        'URL' => ($i == $s) ? '' : $u . '&amp;' . VAR_PAGING . '=' . $i
                    ));
                }
            }
            if ($s > 1) {
                $tpl->block('blk.prev', array(
                    'URL' => $u . '&amp;' . VAR_PAGING . '=' . ($s - 1)
                ));
            }
            if ($s < $total_pages) {
                $tpl->block('blk.next', array(
                    'URL' => $u . '&amp;' . VAR_PAGING . '=' . ($s + 1)
                ));
            }
            $h = $tpl->display('block', 1);
            $tpl->reset_block('blk');
            return $h;
        }
    }
}