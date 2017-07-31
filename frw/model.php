<?php
/**
 * @version		$Id: model.php 3 2013-04-10 13:39 phu $
 * @package		vFramework.cp.mvc
 * @copyright	(C) 2012 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
class vModel
{
    public $cfg;
    protected $db;
    public function __construct($t = '')
    {
        if (!$t)
            $t = strtolower(substr(get_class($this), 0, -5));
        $k = $t . '_cfg';
        global $$k;
        if (!$$k) {
            include PATH_WORKING . DS . $k . '.php';
            vRegistry::cfg($$k, $t);
        }
        $this->cfg =& $$k;
    }
    public function record($a = 0, $n = false)
    {
        $db = vDatabase::instance();
        $d  = array();
        $s  = $this->record_sql($a);
        if (!$db->query($s))
            trigger_error($db->error(), E_USER_ERROR);
        if (!$n)
            $d = $db->fetch_row();
        else {
            $d[0] = $db->fetch_row();
            $p =& $this->cfg['prop'];
            $p['nxt'] = isset($p['nxt']) ? $p['nxt'] : 0;
            $p['prv'] = isset($p['prv']) ? $p['prv'] : 0;
            if ($p['nxt'] || $p['prv']) {
                $t                              = vPage::alt('task');
                $this->cfg['task'][$t]['field'] = preg_split('/[\n,;]/', $this->cfg['task'][$t]['next']);
                $s                              = $this->records_sql();
                if ($p['nxt']) {
                    $b = $s['w'];
                    $s['w'] .= ($p['nxt'] == -1 && isset($d[0]['id'])) ? ' AND a.id<>' . $d[0]['id'] : (' AND ' . $p['od'] . (($p['od2'] == 'DESC') ? '<' : '>') . '"' . $d[0][$p['od']] . '"');
                    if (!$db->query($s, $p['nxt']))
                        trigger_error($db->error(), E_USER_ERROR);
                    if ($db->affected_rows())
                        $d[1] = $db->fetch();
                    $s['w'] = $b;
                }
                if ($p['prv']) {
                    $s['w'] .= ($p['prv'] == -1 && isset($d[0]['id'])) ? ' AND a.id<>' . $d[0]['id'] : (' AND ' . $p['od'] . (($p['od2'] == 'DESC') ? '>' : '<') . '"' . $d[0][$p['od']] . '"');
                    $s['o'] = ' ORDER BY a.published ASC';
                    if (!$db->query($s, $p['prv']))
                        trigger_error($db->error(), E_USER_ERROR);
                    if ($db->affected_rows())
                        $d[2] = array_reverse($db->fetch());
                }
            }
        }
        return $d;
    }
    protected function record_sql($a)
    {
        global $cfg, $alt, $db;
        $m =& $this->cfg['structure'];
        $t  = vPage::alt('task');
        $l  = ($cfg['langs'] > 1 && isset($this->cfg['langs']) && $this->cfg['langs']) ? ((isset($this->cfg['trans']) && $this->cfg['trans']) ? 2 : 1) : 0;
        $lc = ($alt['lang'] && $alt['lang'] <> $cfg['lang']) ? 1 : 0;
        $x  = $this->_f($this->cfg['task'][$t]['field']);
        if (isset($m['id']) && $x[0] != 'id')
            array_unshift($x, 'id');
        $s = 'SELECT a.' . str_replace(',', ',a.', implode(',', ($x) ? $x : array_keys($m)));
        $w = (isset($m['cid'])) ? ' WHERE a.cid=' . $alt['module']['id'] : ' WHERE 1';
        if ($a)
            $w .= ' AND ' . (($cfg['sef']) ? 'a.alias="' . $a . '"' : 'a.id=' . $a);
        else {
            $db->query('SELECT id FROM #__' . $this->cfg['table'] . ' WHERE alias="' . $alt['module']['alias'] . '"' . (isset($m['published']) ? ' AND published>0 AND published<' . time() : '') . (($l == 1 && $alt['lang']) ? ' AND (' . (($alt['lang'] == $cfg['lang']) ? 'lang="" OR ' : '') . 'lang="' . $alt['lang'] . '")' : ''));
            if ($db->affected_rows())
                $w .= ' AND a.alias="' . $alt['module']['alias'] . '"';
        }
        if (isset($m['published']))
            $w .= ' AND a.published>0 AND a.published<' . time();
        else if (isset($m['enabled']))
            $w .= ' AND a.enabled>0';
        if ($l == 1 && $alt['lang'])
            $w .= ' AND (' . (($alt['lang'] == $cfg['lang']) ? 'a.lang="" OR ' : '') . 'a.lang="' . $alt['lang'] . '")';
        $f = 'FROM #__' . $this->cfg['table'] . ' a';
        if ($l == 2 && $lc) {
            $f .= ' LEFT JOIN #__' . $this->cfg['table'] . '_trans t ON a.id=t.id';
            $w .= ' AND t.lang="' . $alt['lang'] . '"';
            foreach ($this->cfg['trans'] as $a)
                $s = str_replace('a.' . $a, 't.' . $a, $s);
        }
        return array(
            's' => $s,
            'f' => $f,
            'w' => $w
        );
    }
    public function records($a, $b = 0)
    {
        $db = vDatabase::instance();
        $d  = '';
        if ($a < 1)
            $a = 1;
        if ($b == -1)
            $b = 0;
        else if ($b < 1)
            $b = vPage::cfg('paging');
        $s = $this->records_sql($a);
        if (is_array($a)) {
            $a = 1;
            $b = 0;
        }
        if (!$db->query($s, $b, ($a - 1) * $b))
            trigger_error($db->error(), E_USER_ERROR);
        if ($db->affected_rows() == 0 && $a > 1) {
            vPage::alt('paging', 1);
            if (!$db->query($s, $b))
                trigger_error($db->error(), E_USER_ERROR);
        }
        return $db->fetch();
    }
    protected function records_sql($a = 0)
    {
        global $alt, $cfg, $map;
        $m =& $this->cfg['structure'];
        $t  = vPage::alt('task');
        $l  = ($cfg['langs'] > 1 && isset($this->cfg['langs']) && $this->cfg['langs']) ? ((isset($this->cfg['trans']) && $this->cfg['trans']) ? 2 : 1) : 0;
        $lc = ($alt['lang'] && $alt['lang'] <> $cfg['lang']) ? 1 : 0;
        $x  = $this->_f($this->cfg['task'][$t]['field']);
        if (!$x)
            $x = array_keys($m);
        if (isset($m['id'])) {
            if ($x[0] == 'id')
                unset($x[0]);
            array_unshift($x, ($cfg['sef'] && isset($m['alias'])) ? 'alias as id' : 'id');
        }
        if (isset($this->cfg['prop']['dat']) && $this->cfg['prop']['dat'] && isset($m[$this->cfg['prop']['dat']]) && !in_array($this->cfg['prop']['dat'], $x))
            array_push($x, $this->cfg['prop']['dat']);
        $s = 'SELECT a.' . implode(',a.', $x);
        $w = ($alt['page'] && isset($m['cid'])) ? ' WHERE a.cid=' . $map->r[$alt['page']]['id'] : ' WHERE 1';
        if (isset($m['published']))
            $w .= ' AND a.published>0 AND a.published<' . time();
        else if (isset($m['enabled']))
            $w .= ' AND a.enabled>0';
        if ($l == 1 && $alt['lang'])
            $w .= ' AND (' . (($alt['lang'] == $cfg['lang']) ? 'a.lang="" OR ' : '') . 'a.lang="' . $alt['lang'] . '")';
        if (is_array($a) && $a)
            $w .= ' AND a.id IN (' . implode(',', $a) . ')';
        $f = ' FROM #__' . $this->cfg['table'] . ' a';
        if ($l == 2 && $lc) {
            $f .= ' LEFT JOIN #__' . $this->cfg['table'] . '_trans t ON a.id=t.id';
            $w .= ' AND t.lang="' . $alt['lang'] . '"';
            foreach ($this->cfg['trans'] as $a)
                $s = str_replace('a.' . $a, 't.' . $a, $s);
        }
        $o = ' ORDER BY a.' . $this->cfg['prop']['od'] . ' ' . $this->cfg['prop']['od2'];
        return array(
            's' => $s,
            'f' => $f,
            'w' => $w,
            'o' => $o
        );
    }
    public function recordc($a = 0)
    {
        global $alt, $map;
        $db          = vDatabase::instance();
        $d           = array();
        $t           = $alt['page'];
        $alt['page'] = '';
        $s           = $this->records_sql($a);
        $alt['page'] = $t;
        foreach (explode(',', $alt['module']['tree']['c']) as $i) {
            if ($i) {
                $x = array(
                    'id' => $i,
                    'title' => $map->i[$i]['title'],
                    'alias' => $map->i[$i]['alias']
                );
                if ($a) {
                    $t = $s;
                    $t['w'] .= ' AND a.cid IN (' . $i . (($map->i[$i]['tree']['f']) ? ',' . $map->i[$i]['tree']['f'] : '') . ')';
                    if (!$db->query($t, $a))
                        trigger_error($db->error(), E_USER_ERROR);
                    $x['r'] = $db->fetch();
                } else
                    $x['r'] = null;
                $d[] = $x;
            }
        }
        return $d;
    }
    public function hits($id)
    {
        if ($id) {
            $db = vDatabase::instance();
            $s  = 'UPDATE #__' . $this->cfg['table'] . ' SET hits=hits+1 WHERE id=' . $id;
            if (!$db->query($s))
                trigger_error($db->error(), E_USER_ERROR);
        }
    }
    public function count()
    {
        $db     = vDatabase::instance();
        $s      = $this->records_sql();
        $s['s'] = 'SELECT count(*) as total';
        if (!$db->query($s))
            trigger_error($db->error(), E_USER_ERROR);
        return $db->fetch_field('total');
    }
    public function _f($f)
    {
        $a = array();
        if ($f) {
            $m =& $this->cfg['structure'];
            foreach ($f as $k) {
                if (isset($m[$k]))
                    $a[] = $k;
            }
        }
        return ($a) ? $a : '';
    }
}