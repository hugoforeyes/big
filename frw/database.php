<?php
/**
 *
 * @version $Id: database.php 3 2013-08-09 10:49 phu $
 * @package vFramework
 * @copyright (C) 2015 Vipcom. All rights reserved.
 * @license GPL
 */
defined('V_LIFE') or die('v');
class vDatabase
{
    private static $_d;
    var $c;
    var $r = false;
    var $t = false;
    var $o = array();
    var $p = false;
    public static function instance()
    {
        if (is_null(self::$_d))
            self::$_d = new self();
        return self::$_d;
    }
    function connect($p = false, $n = false)
    {
        global $cfg;
        if (!$cfg['db']['host'] || !$cfg['db']['user'] || !$cfg['db']['name'])
            return;
        $this->c = @mysqli_connect($cfg['db']['host'], $cfg['db']['user'], $cfg['db']['pass'], $n);
        if ($this->c) {
            if (@mysqli_select_db($this->c, $cfg['db']['name'])) {
                $mysql_version = mysqli_get_server_info($this->c);
                if (version_compare($mysql_version, '4.1.3', '>=')) {
                    @mysqli_query($this->c, "SET NAMES 'utf8'");
                    if (strpos($mysql_version, '5') === 0)
                        @mysqli_query($this->c, "SET sql_mode = 'MYSQL40'");
                }
                return $this->c;
            }
        }
        return $this->error('');
    }
    function transaction($s = 'begin')
    {
        switch ($s) {
            case 'start':
            case 'begin':
                if (!$this->t) {
                    $result = @mysqli_query($this->c, 'BEGIN');
                    if (!$result)
                        $this->error();
                    $this->t = true;
                }
                break;
            case 'commit':
                if (!$this->t) {
                    $result = @mysqli_query($this->c, 'COMMIT');
                    if (!$result)
                        $this->error();
                    $this->t = false;
                }
                break;
            case 'rollback':
                @mysqli_query($this->c, 'ROLLBACK');
                $this->t = false;
                break;
        }
    }
    function close()
    {
        if (!$this->c)
            return false;
        if ($this->t)
            $this->transaction('commit');
        foreach ($this->o as $r)
            $this->free($r);
        return @mysqli_close($this->c);
    }
    function free($r = false)
    {
        if ($r === false) {
            while ($this->o) {
                $r = array_pop($this->o);
                @mysqli_free_result($r);
            }
            return true;
        } else
            return @mysqli_free_result($r);
        return false;
    }
    function query($q = '', $t = 0, $o = 0)
    {
        global $cfg;
        if ($q != '') {
            if (!$this->c)
                $this->connect();
            $this->r = false;
            if (is_array($q))
                $q = implode(' ', $q);
            $q = str_replace('#__', $cfg['db']['prefix'], $q);
            if ($t > 0)
                $q .= " LIMIT " . (($o > 0) ? $o . ', ' . $t : $t);
            $this->r = @mysqli_query($this->c, $q);
            if ($this->r === false)
                $this->error($q);
            if (strpos($q, 'SELECT') === 0 && $this->r)
                $this->o[] = $this->r;
            return $this->r;
        }
        return false;
    }
    function affected_rows()
    {
        return ($this->c) ? mysqli_affected_rows($this->c) : false;
    }
    function fetch($r = false)
    {
        if ($r === false)
            $r = $this->r;
        if ($r !== false) {
            $result = array();
            while ($row = @mysqli_fetch_assoc($r))
                $result[] = $row;
            return $result;
        }
        return false;
    }
    function fetch_row($r = false)
    {
        if ($r === false)
            $r = $this->r;
        return ($r !== false) ? @mysqli_fetch_assoc($r) : false;
    }
    function fetch_field($field, $rownum = false, $r = false)
    {
        global $cache;
        if ($r === false)
            $r = $this->r;
        if ($r !== false) {
            if ($rownum !== false)
                $this->seek($rownum, $r);
            $row = $this->fetch_row($r);
            return (isset($row[$field])) ? $row[$field] : false;
        }
        return false;
    }
    function seek($n, $r = false)
    {
        if ($r === false)
            $r = $this->r;
        return ($r !== false) ? @mysqli_data_seek($r, $n) : false;
    }
    function nextid()
    {
        return ($this->c) ? @mysqli_insert_id($this->c) : false;
    }
    function sql($query, $table, $array = '', $where = '')
    {
        $sql = '';
        switch ($query) {
            case 'INSERT':
                $field = array();
                $data  = array();
                foreach ($array as $key => $val) {
                    $field[] = $key;
                    $data[]  = $this->_v($val);
                }
                $sql = 'INSERT INTO ' . $table . '(' . implode(', ', $field) . ') VALUES(' . implode(', ', $data) . ')';
                break;
            case 'UPDATE':
                $data = array();
                foreach ($array as $key => $var) {
                    $data[] = "$key = " . $this->_v($var);
                }
                $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $data) . ' WHERE ' . $where;
                break;
        }
        return $sql;
    }
    function error()
    {
        if (!$this->c)
            $err = @mysqli_errno() . ' ' . @mysqli_error();
        else
            $err = @mysqli_errno($this->c) . ' ' . @mysqli_error($this->c);
        if ($this->t)
            $this->transaction('rollback');
        return $err;
    }
    function like($e)
    {
        $e = str_replace(array(
            '_',
            '%'
        ), array(
            "\_",
            "\%"
        ), $e);
        $e = str_replace(array(
            chr(0) . "\_",
            chr(0) . "\%"
        ), array(
            '_',
            '%'
        ), $e);
        return 'LIKE \'' . $this->escape($e) . '\'';
    }
    function escape($s)
    {
        if (!$this->c)
            $this->connect();
        return mysqli_real_escape_string($this->c, $s);
    }
    function _v($a)
    {
        if (is_null($a))
            return 'NULL';
        else if (is_string($a))
            return '\'' . $this->escape($a) . '\'';
        else
            return (is_bool($a)) ? intval($a) : $a;
    }
}