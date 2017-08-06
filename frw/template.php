<?php
/**
 * @version		$Id: template.php 3 2014-12-24 9:43 Phu $
 * @package		vFramework.core.template
 * @copyright	(C) 2014 Vipcom. All rights reserved.
 * @license		Commercial
 */
defined('V_LIFE') or die('v');
class vTemplate
{
    private static $_t;
    var $d = array('.' => array(0 => array()));
    var $r;
    var $l = array();
    var $root = '';
    var $theme = '';
    var $_file = array();
    var $compiled_code = array();
    var $block_names = array();
    var $block_else_level = array();
    public static function instance()
    {
        if (is_null(self::$_t))
            self::$_t = new self();
        return self::$_t;
    }
    function __construct()
    {
        global $cfg;
        if (defined('V_CP'))
            $this->root(PATH_CP_THEMES, $cfg['cp']['theme']);
        else
            $this->root(PATH_THEMES, $cfg['theme']);
        $this->r =& $this->d['.'][0];
    }
    function root($dir, $name = '')
    {
        if ($name) {
            $dir  = $dir . DS . $name;
            $name = $name . '_';
        }
        $this->root  = $dir;
        $this->theme = $name;
        return true;
    }
    function reset()
    {
        $this->d             = array(
            '.' => array(
                0 => array()
            )
        );
        $this->compiled_code = array();
        $this->_file         = array();
    }
    function reset_block($blockname)
    {
        if (strpos($blockname, '.') !== false) {
            $blocks     = explode('.', $blockname);
            $blockcount = sizeof($blocks) - 1;
            $str =& $this->d;
            for ($i = 0; $i < $blockcount; $i++) {
                $str =& $str[$blocks[$i]];
                $str =& $str[sizeof($str) - 1];
            }
            unset($str[$blocks[$blockcount]]);
        } else {
            unset($this->d[$blockname]);
        }
        return true;
    }
    function lang($f)
    {
        $f = (defined('V_CP') ? PATH_CP_LANG : PATH_LANG) . DS . $f . '.ini';
        if (is_file($f)) {
            $s       = (function_exists('parse_ini_file')) ? parse_ini_file($f) : vRegistry::parse(file_get_contents($f));
            $this->l = array_merge($this->l, $s);
            return true;
        }
        return false;
    }
    function _($s)
    {
        $u = str_replace(' ', '_', strtoupper($s));
        return isset($this->l[$u]) ? $this->l[$u] : ucfirst($s);
    }
    function css($s, $d = '')
    {
        if ($s == '')
            $s = $d;
        $e = '.';
        if ($s{0} == '#' || $s{0} == '.') {
            $e = $s{0};
            $s = substr($s, 1);
        }
        if ($e == '#') {
            $i = strpos($s, ' ');
            if ($i)
                return 'id="' . substr($s, 0, $i) . '" class="' . substr($s, $i + 1) . '"';
            else
                return 'id="' . $s . '"';
        } else
            return 'class="' . $s . '"';
    }
    function reset_theme($handle)
    {
        unset($this->compiled_code[$handle]);
        unset($this->_file[$handle]);
    }
    function get($k)
    {
        return isset($this->r[$k]) ? $this->r[$k] : '';
    }
    function _var($k, $v, $a = 0)
    {
        if ($a) {
            if (isset($this->r[$k]))
                $this->r[$k] .= $v;
            else
                $this->r[$k] = $v;
        } else {
            $this->r[$k] = $v;
        }
        return true;
    }
    function vars($d)
    {
        foreach ($d as $k => $v)
            $this->r[$k] = $v;
        return true;
    }
    function block($blockname, $vararray, $caplock = 0)
    {
        if (strpos($blockname, '.') !== false) {
            $blocks     = explode('.', $blockname);
            $blockcount = sizeof($blocks) - 1;
            $str =& $this->d;
            for ($i = 0; $i < $blockcount; $i++) {
                $str =& $str[$blocks[$i]];
                $str =& $str[sizeof($str) - 1];
            }
            $s_row_count             = isset($str[$blocks[$blockcount]]) ? sizeof($str[$blocks[$blockcount]]) : 0;
            $vararray['S_ROW_COUNT'] = $s_row_count;
            if (!$s_row_count) {
                $vararray['S_FIRST_ROW'] = true;
            }
            $vararray['S_LAST_ROW'] = true;
            if ($s_row_count > 0) {
                unset($str[$blocks[$blockcount]][($s_row_count - 1)]['S_LAST_ROW']);
            }
            if ($caplock) {
                foreach ($vararray as $key => $val) {
                    $arr[strtoupper($key)] = $val;
                }
                $vararray = $arr;
            }
            $str[$blocks[$blockcount]][] = $vararray;
        } else {
            $s_row_count             = (isset($this->d[$blockname])) ? sizeof($this->d[$blockname]) : 0;
            $vararray['S_ROW_COUNT'] = $s_row_count;
            if (!$s_row_count) {
                $vararray['S_FIRST_ROW'] = true;
            }
            $vararray['S_LAST_ROW'] = true;
            if ($s_row_count > 0) {
                unset($this->d[$blockname][($s_row_count - 1)]['S_LAST_ROW']);
            }
            if ($caplock) {
                foreach ($vararray as $key => $val) {
                    $arr[strtoupper($key)] = $val;
                }
                $vararray = $arr;
            }
            $this->d[$blockname][] = $vararray;
        }
        return true;
    }
    function theme($h, $f, $d = '')
    {
        global $cfg;
        if (!isset($this->compiled_code[$h])) {
            if ($d) {
                $this->compiled_code[$h] = $d;
            } else if ($f) {
                $f .= '.tpl.php';
                $this->_file[$h] = $f;
                if (is_file($this->root . DS . $f))
                    $f = $this->root . DS . $f;
                else if (isset($cfg['path_working']) && $cfg['path_working'] && is_file($cfg['path_working'] . DS . $f))
                    $f = $cfg['path_working'] . DS . $f;
                else
                    return false;
                $this->compiled_code[$h] = @file_get_contents($f);
            }
            if ($this->compiled_code[$h]{0} == '@')
                $this->compiled_code[$h] = substr($this->compiled_code[$h], 1);
            else
                $this->compiled_code[$h] = $this->_compile(trim($this->compiled_code[$h]));
        }
        return true;
    }
    function display($h, $r = false, $p = false, $s = false, $z = false)
    {
        global $cfg;
        if ($r || $p || $s || $z) {
            ob_start();
        }
        $b = $cfg['debug'];
        if ($cfg['debug'] == 1)
            $cfg['debug'] = 0;
        eval(' ?>' . $this->compiled_code[$h] . '<?php ');
        $cfg['debug'] = $b;
        if ($r || $p || $s || $z) {
            $d = ob_get_clean();
            if ($p)
                $d = $this->purl($d);
            if ($s)
                $d = vSEF::render($d);
            if (!defined('V_CP') && isset($cfg['lang_tag']) && $cfg['lang_tag']) {
                if (!is_array($cfg['lang_tag']))
                    $cfg['lang_tag'] = explode(',', $cfg['lang_tag']);
                $d = explode('<body', $d, 2);
                if (count($d) == 2) {
                    $d[0] = str_replace($cfg['lang_tag'], array(
                        ' - ',
                        ''
                    ), $d[0]);
                    $d[1] = preg_replace('/' . $cfg['lang_tag'][0] . '(.*)' . $cfg['lang_tag'][1] . '/', '<span>$1</span>', $d[1]);
                }
                $d = implode('<body', $d);
            }
            if ($r)
                return $d;
            else
                echo $d;
        }
        return true;
    }
    function _compile($code)
    {
        preg_match_all('#<!-- ([^<].*?) (.*?)? ?-->#', $code, $blocks, PREG_SET_ORDER);
        $text_blocks = preg_split('#<!-- [^<].*? (?:.*?)? ?-->#', $code);
        for ($i = 0, $j = sizeof($text_blocks); $i < $j; $i++) {
            $this->_compile_vars($text_blocks[$i]);
        }
        $compile_blocks = array();
        for ($curr_tb = 0, $tb_size = sizeof($blocks); $curr_tb < $tb_size; $curr_tb++) {
            $block_val =& $blocks[$curr_tb];
            switch ($block_val[1]) {
                case 'BLOCK':
                    $this->block_else_level[] = false;
                    $compile_blocks[]         = '<?php ' . $this->_compile_block($block_val[2]) . ' ?>';
                    break;
                case 'ELSEBLOCK':
                    $this->block_else_level[sizeof($this->block_else_level) - 1] = true;
                    $compile_blocks[]                                            = '<?php }} else { ?>';
                    break;
                case 'END':
                case 'ENDBLOCK':
                    array_pop($this->block_names);
                    $compile_blocks[] = '<?php ' . ((array_pop($this->block_else_level)) ? '}' : '}}') . ' ?>';
                    break;
                case 'IF':
                    $compile_blocks[] = '<?php ' . $this->_compile_if($block_val[2], false) . ' ?>';
                    break;
                case 'ELSE':
                    $compile_blocks[] = '<?php } else { ?>';
                    break;
                case 'ELSEIF':
                    $compile_blocks[] = '<?php ' . $this->_compile_if($block_val[2], true) . ' ?>';
                    break;
                case 'ENDIF':
                    $compile_blocks[] = '<?php } ?>';
                    break;
                default:
                    $this->_compile_vars($block_val[0]);
                    $trim_check       = trim($block_val[0]);
                    $compile_blocks[] = (!empty($trim_check)) ? $block_val[0] : '';
                    break;
            }
        }
        $tpl_php = '';
        for ($i = 0, $size = sizeof($text_blocks); $i < $size; $i++) {
            $trim_check_text = trim($text_blocks[$i]);
            $tpl_php .= (($trim_check_text != '') ? $text_blocks[$i] : '') . ((isset($compile_blocks[$i])) ? $compile_blocks[$i] : '');
        }
        $tpl_php = str_replace(' ?><?php ', ' ', $tpl_php);
        $tpl_php = preg_replace('#\?\>([\r\n])#', '?>\1\1', $tpl_php);
        return $tpl_php;
    }
    function _compile_vars(&$text_blocks)
    {
        $varrefs = array();
        preg_match_all('#\{((?:[a-z0-9\-_]+\.)+)(\$)?([A-Z0-9\-_]+)\}#', $text_blocks, $varrefs, PREG_SET_ORDER);
        foreach ($varrefs as $var_val) {
            $namespace   = $var_val[1];
            $varname     = $var_val[3];
            $new         = $this->_generate_block_varref($namespace, $varname, $var_val[2]);
            $text_blocks = str_replace($var_val[0], $new, $text_blocks);
        }
        if (strpos($text_blocks, '{L_') !== false) {
            $text_blocks = preg_replace('#\{L_([a-z0-9\-_]*)\}#is', "<?php echo (isset(\$this->r['L_\\1'])) ? \$this->r['L_\\1'] : \$this->l['\\1']; ?>", $text_blocks);
        }
        $text_blocks = preg_replace('#\{([A-Z0-9\-_]+)\}#', "<?php  echo (isset(\$this->r['\\1'])) ? \$this->r['\\1'] : ''; ?>", $text_blocks);
        return;
    }
    function _compile_block($tag_args)
    {
        $no_nesting = false;
        if (strpos($tag_args, '!') === 0) {
            $no_nesting = substr_count($tag_args, '!');
            $tag_args   = substr($tag_args, $no_nesting);
        }
        if (preg_match('#^([^()]*)\(([\-\d]+)(?:,([\-\d]+))?\)$#', $tag_args, $match)) {
            $tag_args = $match[1];
            if ($match[2] < 0) {
                $loop_start = '($_' . $tag_args . '_count ' . $match[2] . ' < 0 ? 0 : $_' . $tag_args . '_count ' . $match[2] . ')';
            } else {
                $loop_start = '($_' . $tag_args . '_count < ' . $match[2] . ' ? $_' . $tag_args . '_count : ' . $match[2] . ')';
            }
            if (strlen($match[3]) < 1 || $match[3] == -1) {
                $loop_end = '$_' . $tag_args . '_count';
            } else if ($match[3] >= 0) {
                $loop_end = '(' . ($match[3] + 1) . ' > $_' . $tag_args . '_count ? $_' . $tag_args . '_count : ' . ($match[3] + 1) . ')';
            } else {
                $loop_end = '$_' . $tag_args . '_count' . ($match[3] + 1);
            }
        } else {
            $loop_start = 0;
            $loop_end   = '$_' . $tag_args . '_count';
        }
        $tag_template_php = '';
        array_push($this->block_names, $tag_args);
        if ($no_nesting !== false) {
            $block = array_slice($this->block_names, -$no_nesting);
        } else {
            $block = $this->block_names;
        }
        if (sizeof($block) < 2) {
            $tag_template_php = '$_' . $tag_args . "_count = (isset(\$this->d['$tag_args'])) ? sizeof(\$this->d['$tag_args']) : 0;";
            $varref           = "\$this->d['$tag_args']";
        } else {
            $namespace        = implode('.', $block);
            $varref           = $this->_generate_block_data_ref($namespace, false);
            $tag_template_php = '$_' . $tag_args . '_count = (isset(' . $varref . ')) ? sizeof(' . $varref . ') : 0;';
        }
        $tag_template_php .= 'if ($_' . $tag_args . '_count) {';
        $tag_template_php .= 'for ($_' . $tag_args . '_i = ' . $loop_start . '; $_' . $tag_args . '_i < ' . $loop_end . '; ++$_' . $tag_args . '_i){';
        $tag_template_php .= '$_' . $tag_args . '_val = &' . $varref . '[$_' . $tag_args . '_i];';
        return $tag_template_php;
    }
    function _compile_if($tag_args, $elseif)
    {
        preg_match_all('/(?:
			"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"         |
			\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'     |
			[(),]                                  |
			[^\s(),]+)/x', $tag_args, $match);
        $tokens       = $match[0];
        $is_arg_stack = array();
        for ($i = 0, $size = sizeof($tokens); $i < $size; $i++) {
            $token =& $tokens[$i];
            switch ($token) {
                case '!==':
                case '===':
                case '<<':
                case '>>':
                case '|':
                case '^':
                case '&':
                case '~':
                case ')':
                case ',':
                case '+':
                case '-':
                case '*':
                case '/':
                case '@':
                    break;
                case '==':
                    $token = '==';
                    break;
                case '!=':
                case '<>':
                    $token = '!=';
                    break;
                case '<':
                    $token = '<';
                    break;
                case '<=':
                    $token = '<=';
                    break;
                case '>':
                    $token = '>';
                    break;
                case '>=':
                case 'ge':
                case 'gte':
                    $token = '>=';
                    break;
                case '&&':
                case 'and':
                    $token = '&&';
                    break;
                case '||':
                case 'or':
                    $token = '||';
                    break;
                case '!':
                case 'not':
                    $token = '!';
                    break;
                case '%':
                case 'mod':
                    $token = '%';
                    break;
                case '(':
                    array_push($is_arg_stack, $i);
                    break;
                case 'is':
                    $is_arg_start = ($tokens[$i - 1] == ')') ? array_pop($is_arg_stack) : $i - 1;
                    $is_arg       = implode('	', array_slice($tokens, $is_arg_start, $i - $is_arg_start));
                    $new_tokens   = $this->_parse_is_expr($is_arg, array_slice($tokens, $i + 1));
                    array_splice($tokens, $is_arg_start, sizeof($tokens), $new_tokens);
                    $i = $is_arg_start;
                default:
                    if (preg_match('#^((?:[a-z0-9\-_]+\.)+)?(\$)?(?=[A-Z])([A-Z0-9\-_]+)#s', $token, $varrefs)) {
                        $token = (!empty($varrefs[1])) ? $this->_generate_block_data_ref(substr($varrefs[1], 0, -1), true, $varrefs[2]) . '[\'' . $varrefs[3] . '\']' : (($varrefs[2]) ? '$this->d[\'DEFINE\'][\'.\'][\'' . $varrefs[3] . '\']' : '$this->r[\'' . $varrefs[3] . '\']');
                    } else if (preg_match('#^\.((?:[a-z0-9\-_]+\.?)+)$#s', $token, $varrefs)) {
                        $blocks = explode('.', $varrefs[1]);
                        if (sizeof($blocks) > 1) {
                            $block     = array_pop($blocks);
                            $namespace = implode('.', $blocks);
                            $varref    = $this->_generate_block_data_ref($namespace, true);
                            $varref .= "['" . $block . "']";
                        } else {
                            $varref = '$this->d';
                            $varref .= "['" . $blocks[0] . "']";
                        }
                        $token = "sizeof($varref)";
                    } else if (!empty($token)) {
                        $token = '(' . $token . ')';
                    }
                    break;
            }
        }
        if (!sizeof($tokens) || str_replace(array(
            ' ',
            '=',
            '!',
            '<',
            '>',
            '&',
            '|',
            '%',
            '(',
            ')'
        ), '', implode('', $tokens)) == '') {
            $tokens = array(
                'false'
            );
        }
        return (($elseif) ? '} else if (' : 'if (') . (implode(' ', $tokens) . ') { ');
    }
    function _parse_is_expr($is_arg, $tokens)
    {
        $expr_end    = 0;
        $negate_expr = false;
        if (($first_token = array_shift($tokens)) == 'not') {
            $negate_expr = true;
            $expr_type   = array_shift($tokens);
        } else {
            $expr_type = $first_token;
        }
        switch ($expr_type) {
            case 'even':
                if (@$tokens[$expr_end] == 'by') {
                    $expr_end++;
                    $expr_arg = $tokens[$expr_end++];
                    $expr     = "!(($is_arg / $expr_arg) % $expr_arg)";
                } else {
                    $expr = "!($is_arg & 1)";
                }
                break;
            case 'odd':
                if (@$tokens[$expr_end] == 'by') {
                    $expr_end++;
                    $expr_arg = $tokens[$expr_end++];
                    $expr     = "(($is_arg / $expr_arg) % $expr_arg)";
                } else {
                    $expr = "($is_arg & 1)";
                }
                break;
            case 'div':
                if (@$tokens[$expr_end] == 'by') {
                    $expr_end++;
                    $expr_arg = $tokens[$expr_end++];
                    $expr     = "!($is_arg % $expr_arg)";
                }
                break;
        }
        if ($negate_expr) {
            $expr = "!($expr)";
        }
        array_splice($tokens, 0, $expr_end, $expr);
        return $tokens;
    }
    function _generate_block_varref($namespace, $varname, $defop = false)
    {
        $namespace = substr($namespace, 0, -1);
        $varref    = $this->_generate_block_data_ref($namespace, true, $defop);
        $varref .= "['$varname']";
        $varref = "<?php echo (isset($varref)) ? $varref : ''; ?>";
        return $varref;
    }
    function _generate_block_data_ref($blockname, $include_last_iterator, $defop = false)
    {
        $blocks     = explode('.', $blockname);
        $blockcount = sizeof($blocks) - 1;
        if ($defop) {
            $varref = '$this->d[\'DEFINE\']';
            for ($i = 0; $i < $blockcount; $i++) {
                $varref .= "['" . $blocks[$i] . "'][\$_" . $blocks[$i] . '_i]';
            }
            $varref .= "['" . $blocks[$blockcount] . "']";
            if ($include_last_iterator) {
                $varref .= '[$_' . $blocks[$blockcount] . '_i]';
            }
            return $varref;
        } else if ($include_last_iterator) {
            return '$_' . $blocks[$blockcount] . '_val';
        } else {
            return '$_' . $blocks[$blockcount - 1] . '_val[\'' . $blocks[$blockcount] . '\']';
        }
    }
    function purl($d)
    {
        $d = preg_replace_callback("/(src|href| action|poster|data)=\"(.*)\"/iU", array(
            $this,
            '_u'
        ), $d);
        $d = preg_replace_callback("/<object(.*)<\/object>/iU", array(
            $this,
            '_o'
        ), $d);
        $d = preg_replace_callback("/<embed(.*)<\/embed>/iU", array(
            $this,
            '_e'
        ), $d);
        return $d;
    }
    function _u($m)
    {
        $m[1] = str_replace('\"', '"', $m[1]);
        return $m[1] . '="' . (($m[2] == '' || preg_match('@^(/|#|\./|ftp:|http:|https:|skype:|ymsgr:|mailto:|javascript:|tel:)@', $m[2])) ? '' : (($m[1] == 'href' && strpos($m[2], 'index.php') === 0) ? URL_BASE : URL_UPLOAD)) . $m[2] . '"';
    }
    function _o($m)
    {
        $m[1] = preg_replace("/(<param name=\"src\" value|<param name=\"movie\" value)=\"(.*)\"/iUe", '$this->_u(\'$1\', \'$2\')', str_replace('\"', '"', $m[1]));
        return '<object' . $m[1] . '</object>';
    }
    function _e($m)
    {
        $m[1] = preg_replace("/(<param name=\"src\" value|<param name=\"movie\" value)=\"(.*)\"/iUe", '$this->_u(\'$1\', \'$2\')', str_replace('\"', '"', $m[1]));
        return '<embed' . $m[1] . '</embed>';
    }
}