$(function(){var a=0;scrollY=0;0<$("table.list").length&&(a=36,$("table.list").parent().before('<div id="th_scroll"></div>'),0<$("table.list").length&&(th_scroll_init(),$(window).scroll(function(){scrollY=$.browser.safari?$("body").scrollTop():$("body,html,document").scrollTop();vf_th_scroll()})));0<$("#cmd").length&&(cmd_init(),$(window).scroll(function(){scrollY=$.browser.safari?$("body").scrollTop():$("body,html,document").scrollTop();vf_cmdscroll(a)}),$(window).resize(function(){returnTop(0);
cmd_init()}))});function vf_th_scroll(){scrollY>s_headtable-31?1!=s_headtable_flag&&($("#th_scroll").css({display:"block"}),s_headtable_flag=1):0!=s_headtable_flag&&($("#th_scroll").css({display:"none"}),s_headtable_flag=0)}$.fn.table_width_init=function(){for(var a=$("thead td",this).length,b=1;b<a;b++)$("thead tr td:eq("+b+")",this).css({width:$("thead tr td:eq("+b+")",this).width()})};
function th_scroll_init(){$("table.list").table_width_init();var a=$("table.list").width()+2;$("#th_scroll").css({width:a});a=$("table.list thead tr").html().replace(/<td/gi,"<div").replace(/td>/gi,"div>");$("#th_scroll").html(a);s_headtable=$("table.list").offset().top;s_headtable_flag=0;vf_th_scroll()}function cmd_init(){s_cmd_top=$("#cmd").offset().top;cmdpos_flag=0;vf_cmdscroll()}
function vf_cmdscroll(a){0<$("table.list").length?scrollY>s_cmd_top-31?1!=cmdpos_flag&&($("#cmd").css({position:"fixed",top:"31px","margin-left":a+"px"}).addClass("cmd_scroll"),cmdpos_flag=1):0!=cmdpos_flag&&($("#cmd").css({position:"relative",top:0,"margin-left":0}).removeClass("cmd_scroll"),cmdpos_flag=0):scrollY>s_cmd_top-31?1!=cmdpos_flag&&($("#cmd").css({position:"fixed",top:"31px"}).addClass("cmd_scroll"),cmdpos_flag=1):0!=cmdpos_flag&&($("#cmd").css({position:"relative",top:0}).removeClass("cmd_scroll"),
cmdpos_flag=0)};