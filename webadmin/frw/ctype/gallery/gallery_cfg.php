<?php
/**
 * @version        $Id: gallery_cfg.php 3 2012-08-21 13:39 phu $
 * @package        vFramework.cp.gallery
 * @copyright    (C) 2012 Vipcom. All rights reserved.
 * @license        Commercial
 */
defined('V_LIFE') or die('v');
$gallery_cfg = array(
    'structure' => 'id:int,cid:page,title:string,alias:alias,pic_thumb:image,pic_full:image,pic_full_tit:text,preview:text,content:html,prop:prop,hot:int,hits:int,created:timestamp,modified:timestamp,published:timestamp,pic1:image,pic2:image,pic3:image,pic4:image',
    'trans' => 'title,preview,content,prop,meta',
    'langs' => 1,
    'task' => array(
        'index' => array(
            'type' => 4,
            'auth' => 'access',
            'cmd' => 'create,delete,publish,hot,move,imexport',
            'filter' => 'search,publish,order',
            'field' => 'id,title,pic_thumb,hot,hits,published',
            'render' => 'title,hits,published'
        ),
        'view' => array(
            'type' => 1,
            'auth' => 'access'
        ),
        'delete' => array(
            'type' => 11,
            'auth' => 'delete',
            'ret' => ''
        ),
        'edit' => array(
            'type' => 12,
            'auth' => 'access',
            'field' => 'title,alias,pic_thumb,pic_full,pic_full_tit,preview,content,prop,meta,published,pic1,pic2,pic3,pic4',
            'render' => 'title,alias,pic_thumb,pic_full,preview,content,prop,meta,published,pic1,pic2,pic3,pic4',
            'notnull' => 'title'
        ),
        'publish' => array(
            'type' => 21,
            'field' => 'published',
            'auth' => 'publish',
            'ret' => ''
        ),
        'hot' => array(
            'type' => 21,
            'field' => 'hot',
            'auth' => 'publish',
            'ret' => ''
        ),
        'imexport' => array(
            'type' => 31,
            'field' => 'id,title,alias,pic_thumb,pic_full,preview,content,hot,hit,published,prop,meta',
            'render' => 'prop,meta',
            'auth' => 'admin',
            'paging' => 1000
        )
    )
);
?>