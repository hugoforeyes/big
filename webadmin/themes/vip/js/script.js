/* Main Script */
jQuery.fn.nodeIndex=function(){return $(this).prevAll().length};function setLinks(){if(!document.getElementsByTagName)return!1;var a=document.getElementsByTagName("a");if(0==a.length)return!1;for(var b=0;b<a.length;b++)"external"==a[b].getAttribute("rel")&&(a[b].onclick=function(){return!window.open(this.href)})}function returnTop(a){"Opera"!=navigator.appName?$("html,body").animate({scrollTop:0},a):$("html").animate({scrollTop:0},a)}
function hook_editform_submit(a){a?$("#main_form").submit(function(b){b.preventDefault();eval(a);return!1}):$("#main_form").unbind("submit").submit()}function view(a){w=600;h=400;l=(screen.width-w)/2;t=(screen.height-h)/2-30;0>t&&(t=0);window.open(a,"","menubar=no, toolbar=no, scrollbars=yes, resizable=yes, width="+w+", height="+h+", top="+t+", left="+l)}
function cmd(a){if("index.php"==a.substring(0,9)||"?"==a.substring(0,1))document.main_form.action=a;else{if("delete"==a&&"0"==confirm("Delete ?"))return;"update"!=a&&(document.main_form.action=document.main_form.action+"&t="+a)}$("#main_form").submit()}var tagBox,commentsBox,editPermalink,makeSlugeditClickable,WPSetThumbnailHTML,WPSetThumbnailID,WPRemoveThumbnail,wptitlehint;
$(function(){tagBox={clean:function(a){return a.replace(/\s*,\s*/g,",").replace(/,+/g,",").replace(/[,\s]+$/,"").replace(/^[,\s]+/,"")},parseTags:function(a){var b=a.id.split("-check-num-")[1],a=$(a).closest(".tagsdiv"),d=a.find(".the-tags"),c=d.val().split(","),e=[];delete c[b];$.each(c,function(a,b){(b=$.trim(b))&&e.push(b)});d.val(this.clean(e.join(",")));this.quickClicks(a);return!1},quickClicks:function(a){var b=$(".the-tags",a),d=$(".tagchecklist",a),c=$(a).attr("id"),e;b.length&&(e=b.prop("disabled"),
a=b.val().split(","),d.empty(),$.each(a,function(a,b){var g,i;if(b=$.trim(b))g=$("<span />").text(b),e||(i=$('<a id="'+c+"-check-num-"+a+'" class="ntdelbutton">X</a>'),i.click(function(){tagBox.parseTags(this)}),g.prepend("&nbsp;").prepend(i)),d.append(g)}))},flushTags:function(a,b,d){var b=b||!1,c,e=$(".the-tags",a),f=$("input.newtag",a);c=b?$(b).text():f.val();tagsval=e.val();c=this.clean(tagsval?tagsval+","+c:c);c=array_unique_noempty(c.split(",")).join(",");e.val(c);this.quickClicks(a);b||f.val("");
"undefined"==typeof d&&f.focus();return!1},get:function(a){var b=a.substr(a.indexOf("-")+1);$.post(ajaxurl,{action:"get-tagcloud",tax:b},function(d,c){if(0==d||"success"!=c)d=wpAjax.broken;d=$('<p id="tagcloud-'+b+'" class="the-tagcloud">'+d+"</p>");$("a",d).click(function(){tagBox.flushTags($(this).closest(".inside").children(".tagsdiv"),this);return!1});$("#"+a).after(d)})},init:function(){var a=this,b=$("div.ajaxtag");$(".tagsdiv").each(function(){tagBox.quickClicks(this)});$("input.tagadd",b).click(function(){a.flushTags($(this).closest(".tagsdiv"))});
$("div.taghint",b).click(function(){$(this).css("visibility","hidden").parent().siblings(".newtag").focus()});$("input.newtag",b).blur(function(){""==this.value&&$(this).parent().siblings(".taghint").css("visibility","")}).focus(function(){$(this).parent().siblings(".taghint").css("visibility","hidden")}).keyup(function(a){if(13==a.which)return tagBox.flushTags($(this).closest(".tagsdiv")),!1}).keypress(function(a){if(13==a.which)return a.preventDefault(),!1}).each(function(){$(this).closest("div.tagsdiv").attr("id")});
$("#post").submit(function(){$("div.tagsdiv").each(function(){tagBox.flushTags(this,!1,1)})});$("a.tagcloud-link").click(function(){tagBox.get($(this).attr("id"));$(this).unbind().click(function(){$(this).siblings(".the-tagcloud").toggle();return!1});return!1})}}});function array_unique_noempty(a){var b=[];jQuery.each(a,function(a,c){(c=jQuery.trim(c))&&-1==jQuery.inArray(c,b)&&b.push(c)});return b}
$(function(){setLinks();returnTop(0);0<$("#debug").length&&$("#brd").after('<a href="#debug" id="todebug">Debug</a>');$(".focus").focus();$("table.list .checkbox").attr("checked",!1);$(".tbrow td").live("click",function(a){"TD"==a.target.nodeName&&(a=$(this).parent().children("td:first-child"),$("input",a).is(":checked")?($("input",a).removeAttr("checked"),$(this).parent().removeClass("selected")):($("input",a).attr("checked","checked"),$(this).parent().addClass("selected")))});$(".tbrow .checkbox").live("click",
function(){$(this).is(":checked")?$(this).parents("tr").addClass("selected"):$(this).parents("tr").removeClass("selected")});$("table.list .checkall,#th_scroll .checkall").live("click",function(){$(this).is(":checked")?($("table.list .tbrow .checkbox").attr("checked",!0),$("table.list .tbrow").addClass("selected"),"TD"==$(this).parent().get(0).nodeName?$("#th_scroll .checkall").attr("checked",!0):$("table.list .checkall").attr("checked",!0)):($("table.list .tbrow .checkbox").attr("checked",!1),$("table.list .tbrow").removeClass("selected"),
"TD"==$(this).parent().get(0).nodeName?$("#th_scroll .checkall").attr("checked",!1):$("table.list .checkall").attr("checked",!1))});scrollY=$.browser.safari?$("body").scrollTop():$("body,html,document").scrollTop();0<$("input.calendar").length&&$("input.calendar").datetimepicker({dateFormat:"yy-mm-dd",showSecond:!0,timeFormat:"hh:mm:ss"});0<$("input.datetime").length&&$("input.datetime").datetimepicker({dateFormat:"yy-mm-dd",showSecond:0,minDate:0,timeFormat:"hh:mm"});0<$("input.date").length&&$("input.date").datepicker({dateFormat:"yy-mm-dd"});$.browser.msie&&8>$.browser.version&&$(".form_wra").css({width:$("#inner_wra").width()});$(".ordering").live("keyup",function(a){13==a.keyCode&&cmd("order")});tagBox.init()});
function send_tags(){tagBox.init()};

/* Filter */
jQuery.fn.slideLeftHide=function(a,b){this.animate({width:"hide",paddingLeft:"hide",paddingRight:"hide",marginLeft:"hide",marginRight:"hide"},a,b)};jQuery.fn.slideLeftShow=function(a,b){this.animate({width:"show",paddingLeft:"show",paddingRight:"show",marginLeft:"show",marginRight:"show"},a,b)};
$(function(){$("#filter select").each(function(){0!=$(this).val()&&$(this).addClass("field_selected").css({display:"block"})});$("input[name=k]").val()&&$("#filters_form span").addClass("field_selected");var a=0;$(".filters").mouseenter(function(){0==a&&($("#filter").css({width:"100%"}),$("#filters_form > *").slideLeftShow(500,function(){a=1}))});$("html").click(function(b){1==a&&-1==$(b.target).parents().index($("#filter"))&&($("#filter").css({width:"auto"}),$("#filters_form > *").not(".field_selected").slideLeftHide(500,
function(){a=0}))})});

/* Freeze table head */
function UpdateTableHeaders(){$("div.list").each(function(){var c=$(".tableFloatingHeaderOriginal",this),a=$(".tableFloatingHeader",this),b=$(this).offset(),d=$(window).scrollTop();d>b.top-31&&(d<b.top+$(this).height())-31?(a.css("visibility","visible"),$("td",a).each(function(a){a=$("td",c).eq(a).css("width");$(this).css("width",a)}),a.css("width",$(this).css("width"))):(a.css("visibility","hidden"),a.css("top","31px"))})}
$(function(){if(!$.browser.msie){$("table.list").each(function(){$(this).wrap('<div class="list" style="position:relative"></div>');var a=$("tr:first",this);a.before(a.clone());var b=$("tr:first",this);b.addClass("tableFloatingHeader");b.css("position","fixed");b.css("top","31px");b.css("visibility","hidden");a.addClass("tableFloatingHeaderOriginal")});UpdateTableHeaders();$(window).scroll(UpdateTableHeaders);$(window).resize(UpdateTableHeaders);var c=0;scrollY=0;0<$("#cmd").length&&(cmd_init(),c=
36,$(window).scroll(function(){scrollY=$.browser.safari?$("body").scrollTop():$("body,html,document").scrollTop();vf_cmdscroll(c)}),$(window).resize(function(){returnTop(0);cmd_init()}))}});function cmd_init(){s_cmd_top=$("#cmd").offset().top;cmdpos_flag=0;vf_cmdscroll()}
function vf_cmdscroll(c){0<$("table.list").length?scrollY>s_cmd_top-31?1!=cmdpos_flag&&($("#cmd").css({position:"fixed",top:"31px","margin-left":c+"px"}).addClass("cmd_scroll"),cmdpos_flag=1):0!=cmdpos_flag&&($("#cmd").css({position:"relative",top:0,"margin-left":0}).removeClass("cmd_scroll"),cmdpos_flag=0):scrollY>s_cmd_top-31?1!=cmdpos_flag&&($("#cmd").css({position:"fixed",top:"31px"}).addClass("cmd_scroll"),cmdpos_flag=1):0!=cmdpos_flag&&($("#cmd").css({position:"relative",top:0}).removeClass("cmd_scroll"),
cmdpos_flag=0)};

/* RSS */
$(function(){$(".rss_feed_box").each(function(){var a=$(this),b=$(".xml_source",this).attr("href");$.ajax({type:"GET",url:b,dataType:"xml",success:function(b){$(".rss_feed ul",a).empty();var c="";$(b).find("item").each(function(){var a=$(this).find("title").text(),b=$(this).find("link").text();c+='<li><a href="'+b+'" target="_blank">'+a+"</a></li>"});$(".rss_feed",a).html(c)}});$(a).ajaxError(function(){$(".rss_feed",a).append("RSS Error")})})});

/* Tooltip */
this.tooltip=function(){var c=0,d=0,e=0,f=0,g=function(a,b){a-=window.scrollX;b-=window.scrollY;f=a+10+c<$(window).width()||2*a<$(window).width()?a+10:a-10-c;e=b+10+d<$(window).height()||2*b<$(window).height()?b+10:b-10-d;$("#tooltip").css("top",e+"px");$("#tooltip").css("left",f+"px")};$(".tooltip").hover(function(a){id=this.rel;document.getElementById(id)&&(tooltip=document.getElementById(id),content=tooltip.innerHTML,$("body").append("<div id='tooltip'>"+content+"</div>"),c=tooltip.offsetWidth,
d=tooltip.offsetHeight,$("#tooltip").css({width:c}),$("#tooltip").css({height:d}),g(a.pageX,a.pageY),$("#tooltip").fadeIn("fast"))},function(){$("#tooltip").remove()});$(".tooltip").mousemove(function(a){g(a.pageX,a.pageY)})};$(function(){tooltip()});