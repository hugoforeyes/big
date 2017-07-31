<!-- BLOCK blk -->
<div {blk.CSS}>
<!-- IF blk.TITLE -->
<{blk.TAG} class="vf_tit">{blk.TITLE}</{blk.TAG}>
<!-- ENDIF -->

<ul>
<!-- BLOCK hot -->
<li class="hot">
<!-- IF blk.hot.PIC_THUMB --><a href="{blk.hot.U_VIEW}" class="img">{blk.hot.PIC_THUMB}</a><!-- ENDIF -->
<a href="{blk.hot.U_VIEW}" class="tit">{blk.hot.TITLE}</a>
<!-- IF blk.hot.DATE --><p class="vf_date">{blk.hot.DATE}</p><!-- ENDIF -->
<div class="desc">{blk.hot.PREVIEW}</div>
</li>
<!-- END hot -->
<!-- BLOCK row -->
<li>
<!-- IF blk.row.PIC_THUMB --><a href="{blk.row.U_VIEW}" class="img">{blk.row.PIC_THUMB}</a><!-- ENDIF -->
<a href="{blk.row.U_VIEW}" class="tit">{blk.row.TITLE}</a>
<!-- IF blk.row.DATE --><p class="vf_date">{blk.row.DATE}</p><!-- ENDIF -->
<div class="desc">{blk.row.PREVIEW}</div>
</li>
<!-- END row -->
</ul>
</div>
<!-- END blk -->

<!-- BLOCK ajax -->
<div id="{ajax.ID}">{L_LOADING}</div>
<script type="text/javascript">
$.post("{ajax.URL}",function(d){$('#{ajax.ID}').html(d);});
</script>
<!-- END ajax -->