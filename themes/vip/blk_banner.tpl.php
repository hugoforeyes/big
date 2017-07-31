<!-- BLOCK blk -->
<!-- IF blk.ID -->
<div id="slideshow">
<!-- ENDIF -->

	<!-- BLOCK row -->
    <img src="{blk.row.IMAGE}" height="362" alt="{blk.row.TIP}" class="active" />
	<!-- END row -->

<!-- IF blk.ID -->
</div>
<img src="{URL_UPLOAD}bhome.png" id="homecover" />
<!-- ENDIF -->
<!-- END blk -->

<!-- BLOCK ajax -->
<script type="text/javascript">
setInterval(function(){
  $.post("{ajax.URL}",function(d){$('#{ajax.ID}').html(d);});
}, {ajax.TIME});
</script>
<!-- END ajax -->