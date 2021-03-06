<?php
/**
 * @version		$Id: gallery.php 3 2012-12-07 08:26 phu $
 * @package		vFramework.cp.gallery
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
$gallery_cfg = array(
    'structure' => 'id:int,cid:page,title:string,alias:alias,pic_thumb:image,pic_full:image,pic_full_tit:text,preview:text,content:html,prop:prop,hot:int,hits:int,ordering:int,created:int,modified:int,published:int,pic1:image,pic2:image,pic3:image,pic4:image',
    'trans' => 'title,preview,content,prop,meta',
    'langs' => 1,
    'tpl' => 'gallery',
    'task' => array(
        'cat' => array(
            'type' => 3,
            'field' => 'cid,title,pic_thumb,pic_full,preview,prop,hot,hits,created,modified,published,pic1,pic2,pic3,pic4'
        ),
        'list' => array(
            'type' => 2,
            'field' => 'title,pic_thumb,pic_full,preview,prop,hot,hits,created,modified,published,pic1,pic2,pic3,pic4'
        ),
        'view' => array(
            'type' => 1,
            'field' => 'title,pic_thumb,pic_full,pic_full_tit,preview,content,prop,meta,hot,hits,ordering,created,modified,published,pic1,pic2,pic3,pic4',
            'next' => 'title,pic_thumb,prop,hot,hits,created,modified,published'
        )
    )
);
class Gallery extends vController
{
    public function __construct()
    {
        global $alt;
        $this->view = new GalleryView();
        if ($alt['section'] || $alt['keyword'] || $alt['task'])
            vPage::http404();
        parent::__construct();
        if ($o =& $this->cfg['prop']) {
            if (!isset($o['ctn']) || !$o['ctn']) {
                unset($this->cfg['structure']['content']);
                unset($this->trans[1]);
            }
            if (isset($o['mti']) && $o['mti'])
                $this->cfg['structure']['pic_full'] .= 's';
            if (!isset($o['tit']) || !$o['tit'])
                unset($this->cfg['structure']['pic_full_tit']);
            if (!isset($o['pre']) || !$o['pre'])
                unset($this->cfg['structure']['preview']);
            if ((!isset($o['ctn']) || !$o['ctn']) && (!isset($o['mti']) || !$o['mti'])) {
                unset($this->cfg['structure']['content']);
            }
        }
    }
    public function view_data($d)
    {
        $d = parent::data($d);
        $o =& $this->cfg['prop'];
        if (isset($o['mti']) && $o['mti']) {
            foreach (explode("\n", $d[0]['pic_full']) as $v)
                $d[0]['o_pic_full'][] = trim($v);
            if (count($d[0]['o_pic_full']) > 1) {
                unset($d[0]['pic_full']);
                if (isset($d[0]['pic_full_tit'])) {
                    foreach (explode("\n", $d[0]['pic_full_tit']) as $v)
                        $d[0]['o_pic_full_tit'][] = trim($v);
                    unset($d[0]['pic_full_tit']);
                }
            } else {
                $d[0]['o_pic_full'] = $d[0]['o_pic_full'][0];
                $d[0]['pic_full']   = ($d[0]['o_pic_full']) ? vForm::media($d[0]['o_pic_full']) : '';
            }
        }
        return $d;
    }
}
class GalleryView extends vView
{
    public function view_render($d, $c = 0)
    {
        parent::render($d, $c);
        $o =& $this->cfg['prop'];
        if (isset($o['mti']) && $o['mti'] && is_array($d[0]['o_pic_full'])) {
            global $tpl;
            foreach ($d[0]['o_pic_full'] as $k => $v) {
                $t = isset($d[0]['o_pic_full_tit'][$k]) ? $d[0]['o_pic_full_tit'][$k] : '';
                $tpl->block('view.row', array(
                    'PIC' => vForm::media($v, array(
                        'tip' => $t
                    ), false),
                    'O_PIC' => $v,
                    'TIT' => $t
                ));
            }
        }
    }
}
$ctrl = new Gallery();
$ctrl->exec();
unset($ctrl);
?>