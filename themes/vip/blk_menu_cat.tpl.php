<!-- BLOCK blk -->
<!-- BLOCK row -->
<!-- IF row.TREE == "o1" -->
<tr>
<!-- ELSEIF row.TREE == "c1" -->
</tr>
<!-- ELSEIF row.TREE == "o2" -->
<div class="col-md-3 col-sm-6 category">
	<a href="{row.URL}" title="{row.TITLE}">
		<img src="{row.PIC_THUMB}" width="233" height="168" border="0" alt="{row.TITLE}" />
	</a>
</div>
<!-- ELSE -->
<!-- ENDIF -->
<!-- END row -->
<!-- END blk -->