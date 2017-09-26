<?php
/**
 * @version		$Id: gallery_view.php 3 2012-08-22 11:26 phu $
 * @package		vFramework.cp.gallery
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
class GalleryView extends vCPView
{
    protected function view_tpl($d)
    {
        $tpl            = vTemplate::instance();
        //$d['pic_thumb'] = '<img src = ' . URL_UPLOAD . '/' . $d['pic_thumb'] . ' />';
        $pic_full       = NULL;
        foreach (explode("\n", $d['o_pic_full']) as $v) {
            if ($v != NULL)
                $pic_full .= '<p><img src="' . $v . '" style="max-height: 250px;"  /></p>';
        }
        $h = '<div class= "vf_ctn">
	<h1 class="vf_tit">' . $d['title'] . '</h1><br/>' . $pic_full . $tpl->purl($d['content']) . '</div>';
        unset($d['title']);
        unset($d['content']);
        unset($d['pic_full']);
        unset($d['pic_thumb']);
        $h2 = substr(parent::tpl($d), 1);
        return $h . $h2;
    }
}
?>