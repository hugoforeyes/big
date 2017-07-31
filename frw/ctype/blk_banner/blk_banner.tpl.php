<!-- BLOCK blk -->
<!-- IF blk.ID -->
<div {blk.CSS}>
<!-- IF blk.TITLE -->
<{blk.TAG} class="vf_tit">{blk.TITLE}</{blk.TAG}>
<!-- ENDIF -->
<ul id="{blk.ID}">
<!-- ENDIF -->

	<!-- BLOCK row -->
	<li><a title="{blk.row.TIP}" {blk.row.HREF}>{blk.row.BANNER}</a><!-- IF blk.row.TITLE --><h6>{blk.row.TITLE}</h6><!-- ENDIF --><!-- IF blk.row.CONTENT --><div>{blk.row.CONTENT}</div><!-- ENDIF --></li>
	<!-- END row -->

<!-- IF blk.ID -->
</ul>
</div>
<!-- ENDIF -->
<!-- END blk -->

<!-- BLOCK ajax -->
<script type="text/javascript">
setInterval(function(){
	$.post("{ajax.URL}",function(d){$('#{ajax.ID}').html(d);});
}, {ajax.TIME});
</script>
<!-- END ajax -->