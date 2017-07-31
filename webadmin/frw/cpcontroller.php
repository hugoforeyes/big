<?php
/**
 * @version		$Id: cpcÏntroller.php 3 2013-12-30 14:04 phu $
 * @package		vFramework.cp.mvc
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
class vCPController
{
    protected $ret = 0;
    protected $cfg;
    protected $model;
    protected $view;
    public function __construct()
    {
        global $alt, $map, $tpl, $cfg, $db;
        $m = get_class($this);
        $t = strtolower($m);
        $k = $t . '_cfg';
        global $$k;
        if (!$$k)
            include PATH_WORKING . DS . $k . '.php';
        $this->cfg =& $$k;
        $tpl->lang($t);
        cpPage::help($t);
        vRegistry::cfg($this->cfg, $t);
        foreach (array(
            'model',
            'view'
        ) as $v) {
            if (!isset($this->{$v})) {
                $k = PATH_WORKING . DS . $t . '_' . $v . '.php';
                if (is_file($k)) {
                    include $k;
                    $k = $m;
                } else
                    $k = 'vCP';
                $k .= ucfirst($v);
                $this->{$v} = new $k($t);
            }
        }
        if ($alt['return'] && $alt['page'] != 'cp.staff') {
            $t = (isset($map->r[$alt['return']])) ? $map->r[$alt['return']]['title'] : $tpl->_($alt['return']);
            cpPage::nav($t, VAR_INDEX . '?' . VAR_LANG . '=' . $alt['lang'] . '&amp;' . VAR_PAGE . '=' . $alt['return']);
        }
        if (isset($map->r[$alt['page']])) {
            $alt['module'] =& $map->r[$alt['page']];
            $this->cfg['prop'] =& $map->r[$alt['page']]['prop'];
            $t = $alt['module']['title'];
            vPage::head($t, 'title');
        } else {
            $alt['module'] = null;
            $t             = substr($alt['page'], 3);
            vPage::head($tpl->_($t), 'title');
        }
        $this->cfg['url'] = VAR_INDEX . '?' . VAR_LANG . '=' . $alt['lang'] . '&amp;' . VAR_PAGE . '=' . $alt['page'] . (($alt['return']) ? '&amp;' . VAR_RETURN . '=' . $alt['return'] : '');
        cpPage::nav($t, $this->cfg['url']);
        if ($alt['section']) {
            $this->cfg['url'] .= '&amp;' . VAR_SECTION . '=' . $alt['section'];
            if (!is_numeric($alt['section']))
                cpPage::nav($alt['section'], $this->cfg['url']);
        }
        $this->cfg['url'] .= '&amp;' . VAR_PUBLISH . '=' . $alt['publish'] . '&amp;' . VAR_KEYWORD . '=' . urlencode($alt['keyword']) . '&amp;' . VAR_PAGING . '=' . $alt['paging'];
        foreach ($alt['filter'] as $k => $v)
            $this->cfg['url'] .= '&amp;filter[' . $k . ']=' . $v;
        $m =& $this->cfg['structure'];
        if ($cfg['langs'] == 1)
            unset($m['lang']);
        if ($o =& $this->cfg['prop']) {
            if (isset($o['cfg']) && $o['cfg']) {
                unset($o['cfg']);
                $o = vPage::gcfg($this->cfg['table'], $o);
            }
            if (isset($o['ext']) && $o['ext'])
                $o['ext'] = vRegistry::parse($o['ext']);
            if (!isset($o['ext']) || !$o['ext'])
                unset($m['prop']);
            if (!isset($o['seo']) || !$o['seo'])
                unset($m['meta']);
            if (isset($m['ordering']) && isset($o['od']) && $o['od'] != 'ordering')
                unset($m['ordering']);
            if (isset($o['lan'])) {
                if ($o['lan'])
                    unset($m['lang']);
                else
                    $this->cfg['trans'] = '';
            } else if (isset($m['lang']) && $this->cfg['trans'])
                $this->cfg['trans'] = '';
        }
    }
    public function __destruct()
    {
    }
    protected function call($o, $m, $a = null, $b = null)
    {
        $t = vPage::alt('task');
        if (method_exists($o, $t . '_' . $m))
            $m = $t . '_' . $m;
        if ($a && $b)
            return $o->{$m}($a, $b);
        else if ($a)
            return $o->{$m}($a);
        else
            return $o->{$m}();
    }
    public function exec($t = '')
    {
        global $stf, $cfg;
        do {
            if ($this->ret)
                $t = isset($this->cfg['task'][$t]['ret']) ? $this->cfg['task'][$t]['ret'] : '';
            else if (!$t)
                $t = vPage::alt('task');
            if ($t == 'create')
                $t = 'edit';
            reset($this->cfg['task']);
            $t = ($t && isset($this->cfg['task'][$t])) ? $t : key($this->cfg['task']);
            if ($t) {
                if (($this->cfg['task'][$t]['auth'] && !$stf->{$this->cfg['task'][$t]['auth']}) || (isset($stf->{$t}) && !$stf->{$t})) {
                    cpPage::null();
                }
                vPage::alt('task', $t);
                $this->ret = 0;
                $a         = $t . '_task';
                if (method_exists($this, $a))
                    $this->{$a}();
                else
                    $this->task();
            }
        } while ($this->ret);
        $s = $this->cfg['msg'];
        $t = array_shift($s);
        if ($s) {
            $s = implode('<br />', $s);
            if ($t == 1)
                cpPage::warning($s);
            else if ($t == 2)
                cpPage::error($s);
            else
                cpPage::report($s);
        }
    }
    protected function task()
    {
        global $map, $alt, $cfg, $stf, $tpl, $ctype, $db;
        $m =& $this->cfg['structure'];
        $t = vPage::alt('task');
        switch (($this->cfg['task'][$t]['type']) ? $this->cfg['task'][$t]['type'] : 0) {
            case 1:
                $d = vPage::alt('id');
                if ($d) {
                    $d = $this->model->record($d);
                    $d = $this->call($this, 'data', $d);
                    $this->call($this->view, 'render', $d);
                }
                break;
            case 4:
                $n = vPage::cfg('paging');
                if (!$n)
                    $n = 10;
                $d = $this->model->records(vPage::alt('paging'), $n);
                $d = $this->call($this, 'data', $d);
                $n = $this->model->count();
                $this->call($this->view, 'render', $d, $n);
                break;
            case 11:
                $id = vRequest::arr('ids', 'int');
                if ($id) {
                    if ($d = $this->model->delete($id)) {
                        $file = vFile::instance();
                        foreach ($d as $v) {
                            foreach ($v as $f) {
                                if ($f) {
                                    $f = explode("\n", $f);
                                    foreach ($f as $i)
                                        if ($i && substr($i, 0, 7) !== 'http://')
                                            @$file->delete($i);
                                }
                            }
                        }
                    }
                    if (isset($this->cfg['type'][23])) {
                        vPage::alt('task', $this->cfg['type'][23]);
                        $this->call($this, 'task');
                    } else
                        $map->count();
                }
                $this->ret = 1;
                break;
            case 12:
                $a = 0;
                $d = null;
                if (isset($m['alias']))
                    cpPage::help('alias');
                if (vRequest::int('update')) {
                    $d = $this->request();
                    $a = $this->submit($d);
                }
                if ($a) {
                    $this->cfg['msg'][] = $tpl->l['RP_UPDATE'];
                    $t                  = vPage::alt('task');
                    if (isset($this->cfg['type'][23])) {
                        vPage::alt('task', $this->cfg['type'][23]);
                        $this->call($this, 'task');
                    }
                    $this->ret = 1;
                    if (isset($alt['_']['pageto']) && $alt['_']['pageto']) {
                        vPage::alt('task', $t);
                        vPage::alt('id', 0);
                        vRequest::set('update', 0);
                        $this->call($this, 'task');
                        $this->ret = 0;
                    }
                } else {
                    if ($alt['id'] && !$d)
                        $d = $this->model->erecord($alt['id']);
                    $d = $this->call($this, 'data', $d);
                    $this->call($this->view, 'render', $d);
                }
                break;
            case 21:
                $i = vRequest::_var('ids');
                if (is_array($i))
                    $i = implode(',', $i);
                $a = $this->cfg['task'][$t]['field'];
                if ($a)
                    $a = $a[0];
                if ($i && $a) {
                    if ($cfg['log'])
                        $stf->logs($alt['page'], 'publish', array(
                            'ids' => $i
                        ));
                    if ($m[$a] == 'int') {
                        $s = 'UPDATE #__' . $this->cfg['table'] . ' SET ' . $a . '=abs(' . $a . '-1) WHERE id IN (' . $i . ')';
                        if (!$db->query($s))
                            trigger_error($db->error(), E_USER_ERROR);
                    } else if ($m[$a] == 'timestamp') {
                        $s = 'SELECT id, ' . $a . ' FROM #__' . $this->cfg['table'] . ' WHERE id IN (' . $i . ')';
                        if (!$db->query($s))
                            trigger_error($db->error(), E_USER_ERROR);
                        $d = $db->fetch();
                        $b = time();
                        foreach ($d as $v) {
                            $s = 'UPDATE #__' . $this->cfg['table'] . ' SET ' . $a . '=' . (($v[$a]) ? 0 : $b) . ' WHERE id=' . $v['id'];
                            if (!$db->query($s))
                                trigger_error($db->error(), E_USER_ERROR);
                            $b++;
                        }
                    }
                } else {
                    $alt['switch'][$a] = 1;
                }
                $this->ret = 1;
                break;
            case 22:
                if ($alt['id']) {
                    $s = 'SELECT ' . (isset($m['pid']) ? 'pid,' : '') . 'ordering FROM #__' . $this->cfg['table'] . ' WHERE id=' . $alt['id'];
                    if (!$db->query($s, 1))
                        trigger_error($db->error(), E_USER_ERROR);
                    if ($d = $db->fetch_row()) {
                        $a = ($alt['action'] == 'up') ? 1 : 0;
                        if (isset($this->cfg['prop']['od']) && $this->cfg['prop']['od'] == 'ordering' && $this->cfg['prop']['od2'] == 'DESC')
                            $a = abs($a - 1);
                        $s = 'SELECT id, ordering FROM #__' . $this->cfg['table'] . '
							WHERE id<>' . $alt['id'] . (isset($m['pid']) ? ' AND pid=' . $d['pid'] : '') . '
								AND ordering' . (($a) ? '<' : '>') . $d['ordering'] . '
							ORDER BY ordering ' . (($a) ? 'DESC' : 'ASC');
                        if (!$db->query($s, 1))
                            trigger_error($db->error(), E_USER_ERROR);
                        if ($db->affected_rows()) {
                            $d2 = $db->fetch_row();
                            $s  = 'UPDATE #__' . $this->cfg['table'] . '
								SET ordering=' . $d2['ordering'] . '
								WHERE id=' . $alt['id'];
                            if (!$db->query($s))
                                trigger_error($db->error(), E_USER_ERROR);
                            $s = 'UPDATE #__' . $this->cfg['table'] . '
								SET ordering=' . $d['ordering'] . '
								WHERE id=' . $d2['id'];
                            if (!$db->query($s))
                                trigger_error($db->error(), E_USER_ERROR);
                        }
                    }
                } else {
                    foreach (vRequest::_var('order') as $k => $v) {
                        $s = 'UPDATE #__' . $this->cfg['table'] . ' SET ordering=' . intval($v) . ' WHERE id=' . intval($k);
                        if (!$db->query($s))
                            trigger_error($db->error(), E_USER_ERROR);
                    }
                }
                if (isset($this->cfg['type'][23])) {
                    vPage::alt('task', $this->cfg['type'][23]);
                    $this->call($this, 'task');
                }
                $this->ret = 1;
                break;
            case 23:
                $d = $this->model->erecords(0, -1, 0);
                if ($n = count($d)) {
                    $e = array();
                    for ($i = 0; $i < $n; $i++)
                        $e[$d[$i]['id']] =& $d[$i];
                    if (isset($m['count'])) {
                        for ($i = 0, $n = count($d); $i < $n; $i++) {
                            $d[$i]['count'] = 0;
                            if ($d[$i]['ctype'] && $ctype->r[0][$d[$i]['ctype']]['func']) {
                                $s = 'SELECT count(*) AS counter FROM #__' . $ctype->r[0][$d[$i]['ctype']]['name'] . ' WHERE cid=' . $d[$i]['id'];
                                if ($db->query($s))
                                    $d[$i]['count'] = $db->fetch_field('counter');
                            }
                        }
                    }
                    if (isset($m['tree'])) {
                        $this->_resync_tree($d, $e, 0, 1, 0);
                        $x = 0;
                        $n = count($d);
                        for ($i = 0; $i < $n; $i++)
                            $x = ($d[$i]['tree']['l'] > $x) ? $d[$i]['tree']['l'] : $x;
                        for ($j = $x; $j > 0; $j--) {
                            for ($i = 0; $i < $n; $i++) {
                                if ($d[$i]['tree']['l'] == $j) {
                                    $e[$d[$i]['pid']]['tree']['f'] .= (($e[$d[$i]['pid']]['tree']['f']) ? ',' : '') . $d[$i]['id'];
                                    $e[$d[$i]['pid']]['tree']['f'] .= (($e[$d[$i]['pid']]['tree']['f'] && $d[$i]['tree']['f']) ? ',' : '') . $d[$i]['tree']['f'];
                                }
                            }
                        }
                    } else if (isset($m['ordering'])) {
                        for ($i = 0; $i < $n; $i++)
                            $d[$i]['ordering'] = $i + 1;
                    }
                    foreach ($d as $e) {
                        $cfg['log'] = 0;
                        if (isset($e['tree']))
                            $e['tree'] = vRegistry::ini($e['tree']);
                        $this->model->update($e['id'], $e);
                    }
                    if ($this->cfg['table'] == 'sitemap') {
                        global $map;
                        $map->load();
                    }
                }
                $this->ret = 1;
                break;
            case 24:
                if ($a = $this->cfg['task'][$t]['field']) {
                    $d = array();
                    foreach ($a as $k) {
                        if (isset($m[$k])) {
                            $d[$k] = 0;
                        }
                    }
                    $cfg['log'] = 0;
                    $this->model->update(false, $d);
                }
                break;
            case 31:
                $x = array();
                vRequest::vars($x, array(
                    'part:int',
                    'filename:string',
                    'ext:cmd',
                    'save:cmd'
                ));
                if (!$x['filename'])
                    $x['filename'] = ((substr($alt['page'], 0, 3) == 'cp.') ? substr($alt['page'], 3) : $alt['page']) . date('_Y-m-d');
                $x['total']  = $this->model->count();
                $x['paging'] = isset($this->cfg['task'][$t]['paging']) ? $this->cfg['task'][$t]['paging'] : 100;
                $x['page']   = ceil($x['total'] / $x['paging']);
                $x['deny']   = isset($this->cfg['task'][$t]['deny']) ? $this->cfg['task'][$t]['deny'] : '';
                if (vRequest::int('update')) {
                    $l = ($cfg['langs'] && $this->cfg['langs']) ? (($this->cfg['trans']) ? 2 : 1) : 0;
                    $f =& $this->cfg['task'][$t]['field'];
                    $f = $this->model->_f($f);
                    if (!$f)
                        $f = array_keys($m);
                    if (isset($m['cid']) && isset($map->r[$alt['page']]))
                        $f = array_diff($f, array(
                            'cid'
                        ));
                    if ($this->cfg['langs'] && isset($m['lang']) && !in_array('lang', $f))
                        array_splice($f, 1, 0, 'lang');
                    $g = isset($this->cfg['task'][$t]['render']) ? $this->cfg['task'][$t]['render'] : '';
                    if ($g)
                        $g = array_intersect($g, $f);
                    $this->cfg['task'][$t]['render'] = $g;
                    $s                               = array_flip(($this->cfg['task'][$t]['field']) ? array_intersect($this->cfg['task'][$t]['field'], (array) $this->cfg['trans']) : $this->cfg['trans']);
                    $c                               = '';
                    if (isset($this->cfg['prop']['ext']) && $this->cfg['prop']['ext']) {
                        foreach ($this->cfg['prop']['ext'] as $k => $v) {
                            $c[($k{0} == '~' || $k{0} == '*' || $k{0} == '#') ? substr($k, 1) : $k] = $v;
                        }
                    }
                    if ($alt['action'] == 'export' && $x['deny'] != 'e') {
                        if ($cfg['log'])
                            $stf->logs($alt['page'], $alt['action']);
                        vPage::alt('filter', array(
                            'ord' => 'id_ASC'
                        ));
                        $d  = $this->model->erecords($x['part'], ($x['part']) ? $x['paging'] : -1, ($l > 1) ? true : false);
                        $ex = vSpreadsheet::instance($x['ext']);
                        $d  = $ex->export_data($d, $l, $m, $f, $g, $s, $c);
                        $d  = $this->call($this, 'data', $d);
                        $ex->export($d, $x['filename'] . '.' . $x['ext']);
                    } else if ($alt['action'] == 'import' && $x['deny'] != 'i') {
                        $u = vRequest::file('file_upload');
                        if (!$u['error']) {
                            if ($cfg['log'])
                                $stf->logs($alt['page'], $alt['action'], array(
                                    'file' => $u['name']
                                ));
                            $e = strtolower(substr(strrchr($u['name'], '.'), 1));
                            if (in_array($e, array(
                                'xls',
                                'xlsx'
                            ))) {
                                $ex = vSpreadsheet::instance($e);
                                $d  = $ex->import($u['tmp_name']);
                                $d  = $ex->import_data($d, $l, $m, $f, $g, $s, $c);
                                $d  = $this->call($this, 'data', $d);
                                $r  = isset($d['_']) ? $d['_'] : '';
                                unset($d['_']);
                                foreach ($d as $k => $v) {
                                    $i = ($x['save'] == 'update' && isset($v['id'])) ? $v['id'] : 0;
                                    if (isset($m['alias'])) {
                                        if (!isset($v['alias']) || !$v['alias'])
                                            $v['alias'] = isset($v['title']) ? $v['title'] : '';
                                        $v['alias'] = vFilter::alias($v['alias']);
                                        $a          = $v['alias'];
                                        $j          = 0;
                                        while ($this->model->alias($v['alias'], $i)) {
                                            $j++;
                                            $v['alias'] = $a . '-' . $j;
                                        }
                                    }
                                    $cfg['log'] = 0;
                                    $this->model->update($i, $v, isset($r[$k]) ? $r[$k] : '');
                                }
                                if (isset($this->cfg['type'][23])) {
                                    vPage::alt('task', $this->cfg['type'][23]);
                                    $this->call($this, 'task');
                                    vPage::alt('task', $t);
                                    $this->ret = 0;
                                }
                                $this->cfg['msg'][] = $tpl->_('RP_IMPORT');
                            } else {
                                $this->cfg['msg'][0] = 1;
                                $this->cfg['msg'][]  = $tpl->_('UPLOAD_ERR_8');
                            }
                        } else {
                            $this->cfg['msg'][0] = 1;
                            $this->cfg['msg'][]  = $tpl->_('UPLOAD_ERR_' . $u['error']);
                        }
                    }
                }
                $this->call($this->view, 'render', $x);
                break;
        }
    }
    protected function data($d = null)
    {
        global $tpl, $stf, $cfg, $alt;
        $m =& $this->cfg['structure'];
        $t = vPage::alt('task');
        switch (($this->cfg['task'][$t]['type']) ? $this->cfg['task'][$t]['type'] : 0) {
            case 1:
                $this->_f($d);
                unset($d['cid']);
                unset($d['lang']);
                unset($d['hot']);
                unset($d['unread']);
                break;
            case 12:
                if (isset($m['lang']) && $cfg['langs'] > 1 && $this->cfg['langs'] && !$this->cfg['trans'])
                    $d['lang'] = cpPage::form('lang', '', isset($d['lang']) ? $d['lang'] : $alt['lang'], '', ($this->cfg['table'] == 'blocks') ? true : false);
                break;
            case 4:
                for ($i = 0, $n = count($d); $i < $n; $i++) {
                    $v =& $d[$i];
                    $this->_f($v);
                    $v['CSS'] = 'enabled';
                    if (isset($v['enabled']))
                        $v['CSS'] = ($v['enabled']) ? 'enabled' : 'disabled';
                    else if (isset($v['published']))
                        $v['CSS'] = ($v['published']) ? 'enabled' : 'disabled';
                    $v['ICON'] = ((isset($m['pic_thumb']) && isset($v['pic_thumb']) && $v['pic_thumb']) ? '<span class="ico ipic"></span>' : '') . ((isset($m['hot']) && isset($v['hot']) && $v['hot']) ? '<span class="ico ihot"></span>' : '') . (($this->cfg['langs'] && isset($m['lang']) && $cfg['langs'] > 1 && $alt['lang'] == '') ? (($this->cfg['table'] == 'blocks' && !$v['lang']) ? '' : '<span class="lang i' . ((isset($v['lang']) && $v['lang']) ? $v['lang'] : $cfg['lang']) . '"></span>') : '');
                    if (isset($m['ordering']) && isset($v['ordering']))
                        $v['ordering'] = '<input type="text" name="order[' . $v['id'] . ']" value="' . $v['ordering'] . '" style="width:35px;" />' . (($stf->move) ? '<a href="' . $this->cfg['url'] . '&amp;' . VAR_TASK . '=order&amp;' . VAR_ACTION . '=up&amp;' . VAR_ID . '=' . $v['id'] . '" title="' . $tpl->l['UP'] . '"><span class="ico iup"></span></a>' : '') . (($stf->move) ? '<a href="' . $this->cfg['url'] . '&amp;' . VAR_TASK . '=order&amp;' . VAR_ACTION . '=down&amp;' . VAR_ID . '=' . $v['id'] . '" title="' . $tpl->l['DOWN'] . '"><span class="ico idown"></span></a>' : '');
                    $v['U_VIEW'] = isset($this->cfg['task']['view']) ? $this->cfg['url'] . '&' . VAR_TASK . '=view&' . VAR_ID . '=' . $v['id'] : '';
                    $v['CMD']    = (!$stf->edit || (!$stf->publish && ((isset($v['enabled']) && $v['enabled']) || (isset($v['published']) && $v['published'])))) ? '' : '<a href="' . $this->cfg['url'] . '&amp;t=edit&amp;id=' . (isset($v['id']) ? $v['id'] : '') . '" title="' . $tpl->l['EDIT'] . '"><span class="ico iedit"></span></a>';
                }
                break;
        }
        return $d;
    }
    protected function request()
    {
        global $alt, $cfg, $file, $ctype, $map, $blk;
        $m =& $this->cfg['structure'];
        $t = $this->cfg['task'][$alt['task']]['field'];
        $a = array();
        $p = 0;
        foreach ($t as $k) {
            if ($k && isset($m[$k]) && !in_array($k, array(
                'published',
                'enabled',
                'prop'
            )))
                $a[$k] = ($m[$k]) ? $m[$k] : 'string';
            if ($k == 'prop' && isset($m[$k]))
                $p = 1;
        }
        $x = array();
        vRequest::vars($x, $a);
        if ($p) {
            if (isset($this->cfg['prop']['ext'])) {
                $p = $this->cfg['prop']['ext'];
            } else if (isset($x['ctype']) && $x['ctype']) {
                if ($alt['page'] == 'cp.sitemap' && isset($ctype->r[0][$x['ctype']]) && $ctype->r[0][$x['ctype']]) {
                    $p = $ctype->r[0][$x['ctype']]['prop'];
                } else if ($alt['page'] == 'cp.blocks' && isset($ctype->r[1][$x['ctype']]) && $ctype->r[1][$x['ctype']]) {
                    $p = $ctype->r[1][$x['ctype']]['prop'];
                }
            }
            $a = array();
            foreach ($p as $k => $v) {
                if ($k{0} == '~')
                    $k = substr($k, 1);
                if (is_array($v))
                    $v = 'text';
                $a[$k] = $v;
            }
            vRequest::vars($x['prop'], $a, '', '', 'prop');
        } else if (isset($alt['module']['prop']['ext']) && $alt['module']['prop']['ext']) {
            vRequest::vars($x['prop'], vRegistry::parse($alt['module']['prop']['ext']), '', '', 'prop');
        }
        $alt['_']['pageto'] = vRequest::bool('pageto');
        $alt['_']['saveas'] = vRequest::bool('saveas');
        if ($alt['id']) {
            $x['id'] = $alt['id'];
            if ($alt['_']['saveas']) {
                $x['id'] = 0;
                if (isset($m['cid']))
                    $x['cid'] = $alt['module']['id'];
                if (isset($m['created']))
                    $x['created'] = $this->_datetime($m['created']);
            }
        } else {
            $x['id'] = 0;
            if (isset($m['cid']))
                $x['cid'] = $alt['module']['id'];
            if (isset($m['ordering']))
                $x['ordering'] = ($this->cfg['table'] == 'blocks') ? 0 : 65535;
            if (isset($m['created']))
                $x['created'] = $this->_datetime($m['created']);
        }
        if (isset($m['modified']))
            $x['modified'] = $this->_datetime($m['modified']);
        if (isset($m['enabled'])) {
            $x['enabled']        = vRequest::bool('enabled');
            $alt['_']['enabled'] = $x['enabled'];
        } else if (isset($m['published'])) {
            $x['published'] = 0;
            if (vRequest::bool('enabled')) {
                $x['published'] = vRequest::string('published');
                $x['published'] = ($x['published']) ? vTime::timestamp($x['published']) : time();
                $x['published'] = $this->_datetime($m['published'], $x['published']);
            }
            $alt['_']['enabled'] = $x['published'];
        }
        if ($cfg['langs'] > 1 && $this->cfg['langs']) {
            if ($this->cfg['trans']) {
                $a = array();
                foreach ($cfg['language'] as $i => $j) {
                    if ($i <> $cfg['lang'])
                        $a[] = $i . ':array';
                }
                vRequest::vars($x['_'], $a);
            } else if (isset($m['lang']))
                $x['lang'] = vRequest::cmd('lang');
        }
        foreach ($m as $k => $v) {
            if (in_array($v, array(
                'image',
                'media',
                'file'
            )))
                $this->_up1($x, $k, $v);
            else if (in_array($v, array(
                    'images',
                    'medias',
                    'files'
                )) && isset($x[$k]))
                $this->_upn($x, $k);
            else if (in_array($v, array(
                    'array',
                    'prop',
                    'meta',
                    'tree'
                )) && isset($x[$k])) {
                if ($v == 'prop' && $p) {
                    foreach ($p as $a => $b) {
                        if ($b == 'pages' && $x[$k][$a] && sizeof($x[$k][$a]) == $map->c)
                            $x[$k][$a] = '';
                        else if (in_array($b, array(
                                'image',
                                'media',
                                'file'
                            )))
                            $this->_up1($x[$k], $a, $b);
                        else if (in_array($b, array(
                                'images',
                                'medias',
                                'files'
                            )) && isset($x[$k][$a]))
                            $this->_upn($x[$k], $a, $k);
                    }
                }
                $x[$k] = vRegistry::ini($x[$k]);
            } else if (in_array($v, array(
                    'pages',
                    'categories',
                    'records',
                    'size'
                )) && isset($x[$k])) {
                if (sizeof($x[$k]) == $map->c)
                    $x[$k] = '';
                else
                    $x[$k] = implode(',', $x[$k]);
            }
        }
        if ($cfg['langs'] > 1 && $this->cfg['langs'] && $this->cfg['trans']) {
            foreach ($this->cfg['trans'] as $k) {
                if (isset($m[$k]) && in_array($m[$k], array(
                    'array',
                    'prop',
                    'meta',
                    'tree'
                ))) {
                    foreach ($cfg['language'] as $i => $j) {
                        if ($i <> $cfg['lang'] && isset($x['_'][$i][$k]))
                            $x['_'][$i][$k] = vRegistry::ini($x['_'][$i][$k]);
                    }
                }
            }
        }
        if (isset($m['pic_thumb']) && isset($m['pic_full']) && (!isset($x['pic_thumb']) || !$x['pic_thumb']) && isset($x['pic_full']) && $x['pic_full']) {
            if ($m['pic_full'] == 'images') {
                $v              = explode("\n", $x['pic_full']);
                $x['pic_thumb'] = $v[0];
            } else if ($m['pic_full'] == 'image')
                $x['pic_thumb'] = $x['pic_full'];
            if ($x['pic_thumb']) {
                $x['pic_thumb'] = $file->copy($x['pic_thumb'], $x['pic_thumb']);
                if (isset($this->cfg['prop']['pic_thumb_sz']) && $m['pic_thumb'] == 'image') {
                    $a = $this->cfg['prop']['pic_thumb_sz'];
                    if ($a[0] || $a[1])
                        $file->resize($x['pic_thumb'], $a[0], $a[1]);
                }
            }
        }
        return $x;
    }
    protected function submit($x)
    {
        global $db, $cfg, $tpl, $alt;
        $m =& $this->cfg['structure'];
        if (!isset($x['id']))
            $x['id'] = 0;
        $t = isset($this->cfg['task'][$alt['task']]['notnull']) ? $this->cfg['task'][$alt['task']]['notnull'] : null;
        if ($t) {
            $n = 0;
            if (is_string($t))
                $t = preg_split('/[\n,;]/', $t);
            foreach ($t as $k) {
                if (!isset($x[$k]) || !$x[$k]) {
                    $this->cfg['msg'][0] = 2;
                    $n++;
                } else if ($cfg['langs'] && $this->cfg['langs'] && $this->cfg['trans']) {
                    foreach ($cfg['language'] as $l => $v) {
                        if ($cfg['lang'] != $l && isset($x['_'][$l][$k]) && !$x['_'][$l][$k])
                            $x['_'][$l][$k] = $x[$k];
                    }
                }
            }
            if ($n)
                $this->cfg['msg'][] = $tpl->l['ERR_NOTNULL'];
        }
        if (isset($m['alias'])) {
            if ($x['alias'] == '' && isset($x['title']))
                $x['alias'] = $x['title'];
            $x['alias'] = vFilter::alias($x['alias']);
            $t          = $x['alias'];
            $i          = 0;
            while ($this->model->alias($x['alias'], $x['id'])) {
                $i++;
                $x['alias'] = $t . '-' . $i;
            }
            if ($cfg['langs'] && $this->cfg['langs'] && $this->cfg['trans'] && in_array('alias', $this->cfg['trans'])) {
                foreach ($cfg['language'] as $l => $v) {
                    if ($l <> $cfg['lang']) {
                        if (isset($x['_'][$l]['alias']) && $x['_'][$l]['alias'] == '' && isset($x['_'][$l]['title']))
                            $x['_'][$l]['alias'] = $x['_'][$l]['title'];
                        $x['_'][$l]['alias'] = vFilter::alias($x['_'][$l]['alias']);
                        $t                   = $x['_'][$l]['alias'];
                        $i                   = 0;
                        while ($this->model->alias($x['_'][$l]['alias'], $x['id'], $l)) {
                            $i++;
                            $x['_'][$l]['alias'] = $t . '-' . $i;
                        }
                    }
                }
            }
        }
        if ($this->cfg['msg'][0])
            return 0;
        $r = array();
        if (isset($x['_'])) {
            $r = $x['_'];
            unset($x['_']);
        }
        if (isset($this->cfg['revs']) && $this->cfg['revs']) {
            global $stf;
            $stf->revs($this->cfg['table'], $alt['id'], $x);
        }
        $this->model->update($x['id'], $x, $r);
        return 1;
    }
    protected function _resync_tree(&$d, &$e, $id, $s, $l, $p = '')
    {
        $t = '';
        for ($i = 0, $n = count($d); $i < $n; $i++) {
            if ($id == $d[$i]['pid']) {
                if (isset($d[$i]['ordering']))
                    $d[$i]['ordering'] = $s;
                $d[$i]['tree'] = array(
                    'l' => $l,
                    'f' => '',
                    'c' => ''
                );
                $t             = $p;
                if ($d[$i]['pid']) {
                    $e[$d[$i]['pid']]['tree']['c'] .= (($e[$d[$i]['pid']]['tree']['c']) ? ',' : '') . $d[$i]['id'];
                    $p .= (($p) ? ',' : '') . $d[$i]['pid'];
                }
                $d[$i]['tree']['p'] = $p;
                $s                  = $this->_resync_tree($d, $e, $d[$i]['id'], $s + 1, $l + 1, $p);
                $p                  = $t;
            }
        }
        return $s;
    }
    protected function prop_task()
    {
        global $tpl, $cfg, $alt, $ctype;
        $c = vRequest::cmd('ctype');
        if ($c && $c <> 'null') {
            if ($alt['page'] == 'cp.sitemap' && isset($ctype->r[0][$c])) {
                $f = $ctype->r[0][$c]['prop'];
            } else if ($alt['page'] == 'cp.blocks' && isset($ctype->r[1][$c])) {
                $f = $ctype->r[1][$c]['prop'];
            }
            if ($f) {
                $tpl->lang($c);
                if ($cfg['langs'] == 1) {
                    unset($f['lan']);
                }
                echo vForm::draw($f, '', '', null, $c, 'prop');
            }
        }
        die;
    }
    protected function _datetime($s, $t = 0)
    {
        if (!$t)
            $t = time();
        $d = 0;
        switch ($s) {
            case 'int':
            case 'timestamp':
                $d = $t;
                break;
            case 'date':
                $d = date('Y-m-d', $t);
                break;
            case 'datetime':
                $d = date('Y-m-d H:i:s', $t);
                break;
        }
        return $d;
    }
    protected function _up1(&$x, $k, $v)
    {
        global $alt, $cfg, $file;
        if ($alt['_']['saveas'])
            unset($x[$k]);
        require_once(PATH_CORE . DS . 'file.php');
        $k2 = $k . '_uploader';
        if (isset($x[$k2]) && $x[$k2] && $x[$k2]['tmp_name']) {
            if ($a = vFilter::file($x[$k2]['name'], $v)) {
                if (strpos($cfg['file']['dir'], '}'))
                    $cfg['file']['dir'] = strtr($cfg['file']['dir'], array(
                        '{ID}' => (($alt['module']['id']) ? $alt['module']['id'] : 'a'),
                        '{ALIAS}' => (($alt['module']['alias'] == '/') ? 'a' : $alt['module']['alias']),
                        '{M}' => date('m'),
                        '{Y}' => date('y'),
                        '{YY}' => date('Y')
                    ));
                if ($a = $file->upload($x[$k2]['tmp_name'], $cfg['file']['dir'] . '/' . $a)) {
                    if (isset($x[$k]) && $x[$k])
                        $file->delete($x[$k]);
                    $x[$k] = $a;
                    if (isset($alt['module']['prop'][$k . '_sz'])) {
                        $a = $alt['module']['prop'][$k . '_sz'];
                        if ($a[0] || $a[1])
                            $file->resize($x[$k], $a[0], $a[1]);
                    }
                }
            }
        } else if (vRequest::bool($k . '_remover') && isset($x[$k]) && $x[$k]) {
            $file->delete($x[$k]);
            $x[$k] = '';
        }
        unset($x[$k2]);
    }
    protected function _upn(&$x, $k, $f = '')
    {
        global $alt, $file;
        if ($alt['_']['saveas'])
            $x[$k] = array();
        require_once(PATH_CORE . DS . 'file.php');
        $a = (array) vRequest::_var($k . '_remover', '', '', $f);
        if (isset($x[$k . '_tit']) && !is_array($x[$k . '_tit']))
            $x[$k . '_tit'] = explode("\n", $x[$k . '_tit']);
        foreach ($a as $i => $j) {
            if ($j && isset($x[$k][$i]) && $x[$k][$i]) {
                $file->delete($x[$k][$i]);
                unset($x[$k][$i]);
                if (isset($x[$k . '_tit']))
                    unset($x[$k . '_tit'][$i]);
            }
        }
        $x[$k] = trim(implode("\n", array_merge($x[$k], vRequest::arr($k . '_uploader', 'string', '', $f))));
        if (isset($x[$k . '_tit']))
            $x[$k . '_tit'] = trim(implode("\n", array_merge($x[$k . '_tit'], vRequest::arr($k . '_uploader_tit', 'string', '', $f))));
    }
    protected function _f(&$d)
    {
        global $tpl, $cfg, $db;
        if ($d) {
            $m = $this->cfg['structure'];
            if (isset($d['prop']) && $d['prop'] && isset($this->cfg['prop']['ext']) && $this->cfg['prop']['ext']) {
                $d['prop'] = vRegistry::parse($d['prop']);
                $d += $d['prop'];
                $m += $this->cfg['prop']['ext'];
            }
            foreach ($d as $k => $v) {
                if (isset($m[$k])) {
                    switch ($m[$k]) {
                        case 'html':
                            $d[$k] = $tpl->purl($v);
                            break;
                        case 'image':
                        case 'media':
                        case 'file':
                            $d['o_' . $k] = (substr($v, 0, 7) == 'http://' ? '' : URL_UPLOAD) . $v;
                            if ($v)
                                $d[$k] = vForm::media($v, array(), false);
                            break;
                        case 'timestamp':
                            $d['o_' . $k] = $v;
                            if ($v)
                                $d[$k] = vTime::format($cfg['date']['input'], $v);
                            break;
                        case 'category':
                        case 'categoryr':
                            $d['o_' . $k] = $v;
                            if (!isset($c)) {
                                $c   = array();
                                $sql = 'SELECT prop FROM #__ctype WHERE ctype=2 AND name="category"';
                                if (!$db->query($sql))
                                    trigger_error($db->error(), E_USER_ERROR);
                                $cat = vRegistry::parse($db->fetch_field('prop'));
                            }
                            if (isset($cat[$k])) {
                                if (!isset($c[$k]))
                                    $c[$k] = new vCategory($k, 1, $cat[$k][1], $cat[$k][2], $cat[$k][3], $cat[$k][4]);
                                $d[$k] = $c[$k]->nav($v);
                            }
                            break;
                    }
                }
            }
            if (isset($this->cfg['prop']['dat']) && $this->cfg['prop']['dat'] && isset($this->cfg['structure'][$this->cfg['prop']['dat']]) && isset($d[$this->cfg['prop']['dat']]))
                $d['DATE'] = $d[$this->cfg['prop']['dat']];
        }
    }
}