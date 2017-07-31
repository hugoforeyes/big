<?php
/**
* @version		$Id: editor.php 2 2012-03-02 09:54 phu $
* @package		vFramework.cp.editor
* @copyright	(C) 2011 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');global $cfg;cpPage::help('editor');vPage::head(URL_JS.'tinymce/jquery.tinymce.js','js');vPage::head('<script type="text/javascript">
$(function() {
$("textarea.editor").tinymce({
	script_url: "'.URL_JS.'tinymce/tiny_mce.js",

	theme: "advanced",
	skin: "default",
	language: "'.(($stf->profile['lang']=='vn')?'vi':'en').'",
	plugins : "vfileman,advbar,advhr,advimage,advlink,advlist,contextmenu,directionality,fullscreen,inlinepopups,layer,lists,media,pagebreak,paste,searchreplace,style,tabfocus,table,wordcount,xhtmlxtras",
	theme_advanced_buttons1 : "bold,italic,underline,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,link,unlink,|,pastetext,pasteword,|,code,fullscreen,advbar",
	theme_advanced_buttons2 : "strikethrough,sub,sup,blockquote,outdent,indent,|,formatselect,styleselect,|,image,media,vfileman,charmap,anchor,advhr,pagebreak",
	theme_advanced_buttons3 : "tablecontrols,|,insertlayer,absolute,|,search,undo,redo,|,styleprops,attribs,removeformat",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing: true,
	theme_advanced_resize_horizontal: false,
	accessibility_focus: true,
	dialog_type:"modal",

	remove_linebreaks: true,
	inline_styles : true,
	valid_children : "+body[style]",
    // valid_elements : "+*[*]",
	extended_valid_elements : "video[id,class,style,width|height|controls|autoplay|loop|muted],audio[id,class,style,width|height|controls|autoplay|loop|muted],source[src|type],svg,canvas[id|class|style|width|height],header[id|class|style|width|height],footer[id|class|style|width|height],article[id|class|style|width|height],aside[id|class|style|width|height],section[id|class|style|width|height],figure[id|class|style|width|height],figcaption[id|class|style],hr[class|width|size|noshade|style],a[id|class|name|href|target|title|onclick|onmouseover|onmouseout|rel|style],link[rel|type|href]",
	force_br_newlines : false, force_p_newlines : true, forced_root_block : "p",
	entity_encoding : "raw",

	relative_urls : true,
	remove_script_host : false,
	document_base_url : "'.URL_UPLOAD.'",

	file_browser_callback : "filebrowser",
	vfileman_callback : "vfileman",
	body_class : "vf_ctn",
	content_css: "'.URL_THEME.'css/content.css'.(($cfg['debug'])?'?'.time():'').'"
});
$("textarea.editor_tiny").tinymce({
	script_url : "'.URL_JS.'tinymce/tiny_mce.js",

	theme : "advanced",
	skin : "default",
	language: "'.(($stf->profile['lang']=='vn')?'vi':'en').'",
	plugins : "vfileman,advbar,advhr,advimage,advlink,advlist,contextmenu,directionality,fullscreen,inlinepopups,layer,lists,media,pagebreak,paste,searchreplace,style,tabfocus,table,wordcount,xhtmlxtras",
	theme_advanced_buttons1 : "bold,italic,underline,link,justifyleft,justifycenter,justifyright,|,pastetext,pasteword,|,code,fullscreen",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing: true,
	accessibility_focus: true,
	dialog_type:"modal",

	remove_linebreaks: true,
	inline_styles : true,
	valid_children : "+body[style]",
    // valid_elements : "+*[*]",
	extended_valid_elements : "video[id,class,style,width|height|controls|autoplay|loop|muted],audio[id,class,style,width|height|controls|autoplay|loop|muted],source[src|type],svg,canvas[id|class|style|width|height],header[id|class|style|width|height],footer[id|class|style|width|height],article[id|class|style|width|height],aside[id|class|style|width|height],section[id|class|style|width|height],figure[id|class|style|width|height],figcaption[id|class|style],hr[class|width|size|noshade|style],a[id|class|name|href|target|title|onclick|onmouseover|onmouseout|rel|style],link[rel|type|href]",
	force_br_newlines : false, force_p_newlines : true, forced_root_block : "p",
	entity_encoding : "raw",

	relative_urls : true,
	remove_script_host : false,
	document_base_url : "'.URL_UPLOAD.'",

	file_browser_callback : "filebrowser",
	vfileman_callback : "vfileman",
	body_class : "vf_ctn",
	content_css: "'.URL_THEME.'css/content.css'.(($cfg['debug'])?'?'.time():'').'"
});
});
function filebrowser(field_name,url,type,win){tinyMCE.activeEditor.windowManager.open({title:"'.$tpl->l['FILEMAN'].'",url:"'.URL_CP.VAR_INDEX.'?'.VAR_PAGE.'=cp.fileman&quickview&opener=plugin&filter="+type,width:700,height:500,inline:1,maximizable:1,resizable:1,popup_css:0,close_previous:0},{window:win,input:field_name});}
function vfileman(){tinyMCE.activeEditor.windowManager.open({title:"'.$tpl->l['FILEMAN'].'",url:"'.URL_CP.VAR_INDEX.'?'.VAR_PAGE.'=cp.fileman&quickview&opener=editor",width:700,height:500,inline:1,maximizable:1,resizable:1,popup_css:0,close_previous:0});}
</script>');?>