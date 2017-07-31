<!-- BLOCK blk -->
<div {blk.CSS}>

<!-- BLOCK row -->
<li>
<!-- IF blk.row.PIC_THUMB --><a href="{blk.row.U_VIEW}" class="img">{blk.row.PIC_THUMB}</a><!-- ENDIF -->
<a href="{blk.row.U_VIEW}" class="tit">{blk.row.TITLE}</a>
<!-- IF blk.row.DATE --><p class="vf_date">{blk.row.DATE}</p><!-- ENDIF -->
<div class="desc">{blk.row.PREVIEW}</div>
</li>
<!-- END row -->

</div>
<!-- END blk -->
