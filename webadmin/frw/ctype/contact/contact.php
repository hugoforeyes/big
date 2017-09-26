<?php
/**
 * @version		$Id: contact.php 3 2012-09-05 13:39 phu $
 * @package		vFramework.cp.contact
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
$tpl->lang('contact');
$contact_cfg = array(
    'structure' => 'id:int,cid:page,title,prop:prop,created:timestamp,unread:int',
    'task' => array(
        'index' => array(
            'type' => 4,
            'auth' => 'access',
            'cmd' => 'delete,imexport',
            'filter' => 'search',
            'field' => 'id,title,prop,created,unread',
            'render' => 'title,created'
        ),
        'view' => array(
            'type' => 1,
            'auth' => 'access',
            'field' => 'title,prop,created'
        ),
        'delete' => array(
            'type' => 11,
            'auth' => 'delete',
            'ret' => ''
        ),
        'imexport' => array(
            'type' => 31,
            'deny' => 'i',
            'field' => 'title,prop,created',
            'render' => 'prop',
            'auth' => 'access',
            'paging' => 9999
        )
    )
);
class Contact extends vCPController
{
    public function index_data($d = null)
    {
        $d = parent::data($d);
        if ($e = $this->cfg['prop']['ext']) {
            for ($i = 0, $n = count($d); $i < $n; $i++) {
                $d[$i]['prop'] = vRegistry::parse($d[$i]['prop']);
                $d[$i]         = array_merge($d[$i], $d[$i]['prop']);
                foreach ($e as $k => $v) {
                    if ($v == 'html' || $v == 'text')
                        $d[$i][$k] = isset($d[$i][$k]) ? utf8_substr(strip_tags($d[$i][$k]), 0, 100) . '...' : '';
                }
                $d[$i]['CMD'] = '';
                $d[$i]['CSS'] = ($d[$i]['unread']) ? 'enabled' : 'disabled';
            }
            $f = array(
                'title'
            );
            $i = 0;
            foreach ($e as $k => $v) {
                if ($i < 5) {
                    if ($k{0} == '~' || $k{0} == '*' || $k{0} == '#')
                        $k = substr($k, 1);
                    $this->cfg['structure'][$k] = 'string';
                    $f[]                        = $k;
                    $i++;
                }
            }
            $f[]                                  = 'created';
            $this->cfg['task']['index']['render'] = $f;
        }
        return $d;
    }
    public function view_task()
    {
        $d = array(
            'unread' => 0
        );
        $this->model->update(vPage::alt('id'), $d);
        parent::task();
    }
    public function imexport_data($d = null)
    {
        $d = parent::data($d);
        for ($i = 0, $n = count($d); $i < $n; $i++) {
            $d[$i]['created'] = date("r", $d[$i]['created']);
        }
        return $d;
    }
}
$ctrl = new Contact();
$ctrl->exec();
unset($ctrl);