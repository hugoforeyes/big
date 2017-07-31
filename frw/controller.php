<?php
/**
 * @version		$Id: controller.php 3 2012-09-10 13:39 phu $
 * @package		vFramework.cp.mvc
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
class vController
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
                    $k = 'v';
                $k .= ucfirst($v);
                $this->{$v} = new $k($t);
            }
        }
        if (isset($map->r[$alt['page']])) {
            $alt['module'] =& $map->r[$alt['page']];
            $this->cfg['prop'] =& $map->r[$alt['page']]['prop'];
        } else {
            die;
        }
        if (isset($this->cfg['prop']['css']))
            $tpl->_var('CSS', $tpl->css($this->cfg['prop']['css'], '.vf_' . $this->cfg['table']));
        $this->cfg['url'] = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&amp;' : '') . (($alt['page']) ? VAR_PAGE . '=' . $alt['page'] : '') . (($alt['section']) ? '&amp;' . VAR_SECTION . '=' . $alt['section'] : '') . (($alt['paging'] > 1) ? '&amp;' . VAR_PAGING . '=' . $alt['paging'] : '');
        $m =& $this->cfg['structure'];
        if ($cfg['langs'] == 1)
            unset($m['lang']);
        if ($o =& $this->cfg['prop']) {
            if (isset($o['cfg']) && $o['cfg']) {
                unset($o['cfg']);
                $o = vPage::gcfg($this->cfg['table'], $o);
            }
            if (isset($o['ext']) && !$o['ext'])
                unset($m['prop']);
            if (isset($o['seo']) && !$o['seo'])
                unset($m['meta']);
            if (isset($o['lan'])) {
                if ($o['lan'])
                    unset($m['lang']);
                else
                    $this->cfg['trans'] = '';
            } else if (isset($m['lang']) && $this->cfg['trans'])
                $this->cfg['trans'] = '';
            if (isset($p['prop']['tpl']) && $p['prop']['tpl'])
                $m['tpl'] = $p['prop']['tpl'];
            if (isset($o['tpl']) && $o['tpl'])
                $this->cfg['tpl'] = $o['tpl'];
            if (isset($this->cfg['trans']) && $this->cfg['trans'])
                $cfg['trans'] = 1;
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
    public function exec_new($t = '')
    {
        global $alt, $mem;
        do {
            if ($this->ret)
                $t = isset($this->cfg['task'][$t]['ret']) ? $this->cfg['task'][$t]['ret'] : '';
            if (!$t)
                $t = $alt['task'];
            if (!$t && isset($this->cfg['prop']['typ'])) {
                if ($this->cfg['prop']['typ'] == 1 || $alt['id'])
                    $t = 'view';
                else if ($this->cfg['prop']['typ'] == 3)
                    $t = 'cat';
                else
                    $t = 'list';
            }
            if ($t == 'create')
                $t = 'edit';
            reset($this->cfg['task']);
            $t = ($t && isset($this->cfg['task'][$t])) ? $t : key($this->cfg['task']);
            vPage::debug($this->cfg['prop']['typ']);
            if ($t) {
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
    public function exec($t = '')
    {
        global $alt;
        if (isset($this->cfg['prop']['typ'])) {
            if ($this->cfg['prop']['typ'] == 1 || $alt['id'])
                $t = 'view';
            else if ($this->cfg['prop']['typ'] == 3)
                $t = 'cat';
            else
                $t = 'list';
        } else {
            reset($this->cfg['task']);
            $t = key($this->cfg['task']);
        }
        if ($t) {
            vPage::alt('task', $t);
            $this->ret = 0;
            $t .= '_task';
            if (method_exists($this, $t))
                $this->{$t}();
            else
                $this->task();
        }
    }
    protected function task()
    {
        global $map, $alt, $cfg, $tpl, $ctype, $db;
        $m =& $this->cfg['structure'];
        $t = vPage::alt('task');
        switch (($this->cfg['task'][$t]['type']) ? $this->cfg['task'][$t]['type'] : 0) {
            case 1:
                $d = $this->model->record(vPage::alt('id'), true);
                $d = $this->call($this, 'data', $d);
                $this->model->hits($d[0]['id']);
                $this->call($this->view, 'render', $d);
                break;
            case 2:
                $d = $this->model->records(vPage::alt('paging'), ($this->cfg['prop']['pag']) ? $this->cfg['prop']['pag'] : vPage::cfg('paging'));
                $d = $this->call($this, 'data', $d);
                $n = $this->model->count();
                $this->call($this->view, 'render', $d, $n);
                break;
            case 3:
                $d = $this->model->recordc($this->cfg['prop']['cat']);
                $d = $this->call($this, 'data', $d);
                $this->call($this->view, 'render', $d);
                break;
        }
    }
    protected function data($d = null)
    {
        global $tpl, $stf, $cfg, $alt, $map;
        $m =& $this->cfg['structure'];
        $t = vPage::alt('task');
        switch (($this->cfg['task'][$t]['type']) ? $this->cfg['task'][$t]['type'] : 0) {
            case 1:
                $this->_f($d[0]);
                if (isset($d[1])) {
                    for ($i = 0, $n = count($d[1]); $i < $n; $i++) {
                        $v =& $d[1][$i];
                        $this->_f($v);
                        $v['U_VIEW'] = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&amp;' : '') . VAR_PAGE . '=' . $alt['page'] . (($alt['section']) ? '&amp;' . VAR_SECTION . '=' . $alt['section'] : '') . '&' . VAR_ID . '=' . $v['id'];
                    }
                }
                if (isset($d[2])) {
                    for ($i = 0, $n = count($d[2]); $i < $n; $i++) {
                        $v =& $d[2][$i];
                        $this->_f($v);
                        $v['U_VIEW'] = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&amp;' : '') . VAR_PAGE . '=' . $alt['page'] . (($alt['section']) ? '&amp;' . VAR_SECTION . '=' . $alt['section'] : '') . '&' . VAR_ID . '=' . $v['id'];
                    }
                }
                break;
            case 2:
                if ($d) {
                    for ($i = 0, $n = count($d); $i < $n; $i++) {
                        $v =& $d[$i];
                        $this->_f($v);
                        $v['U_VIEW'] = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&amp;' : '') . VAR_PAGE . '=' . (isset($v['cid']) ? $map->i[$v['cid']]['alias'] : $alt['page']) . (($alt['section']) ? '&amp;' . VAR_SECTION . '=' . $alt['section'] : '') . '&' . VAR_ID . '=' . $v['id'];
                    }
                }
                break;
            case 3:
                if ($d) {
                    for ($i = 0, $x = count($d); $i < $x; $i++) {
                        $c =& $d[$i];
                        $c['U_VIEW'] = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&amp;' : '') . VAR_PAGE . '=' . $c['alias'];
                        if (isset($c['r']) && $c['r']) {
                            for ($j = 0, $n = count($c['r']); $j < $n; $j++) {
                                $v =& $c['r'][$j];
                                $this->_f($v);
                                $v['U_VIEW'] = VAR_INDEX . '?' . (($cfg['langs'] > 1 && $alt['lang'] != $cfg['lang']) ? VAR_LANG . '=' . $alt['lang'] . '&amp;' : '') . VAR_PAGE . '=' . $c['alias'] . '&' . VAR_ID . '=' . $v['id'];
                            }
                        }
                    }
                }
                break;
        }
        return $d;
    }
    protected function _f(&$d)
    {
        global $tpl, $cfg, $db;
        if ($d) {
            $m =& $this->cfg['structure'];
            if (isset($d['prop']) && $d['prop'] && isset($this->cfg['prop']['ext']) && $this->cfg['prop']['ext']) {
                $d['prop'] = vRegistry::parse($d['prop']);
                $d += $d['prop'];
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
                                    $c[$k] = new vCategory($k, 1, $cat[$k][1], $cat[$k][2]);
                                $v = $c[$k]->nav($v);
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