<!-- BLOCK blk -->
<!-- BLOCK row -->
<!-- IF row.TREE == "o1" -->
<tr>
<!-- ELSEIF row.TREE == "c1" -->
</tr>
<!-- ELSEIF row.TREE == "o2" -->
<div class="col-md-6 col-sm-6 category">
	<div class="pd-box">
		<a href="{row.URL}" title="{row.TITLE}">
			<div class="pd-box-wp">
				<div class="pd-box-img">
					<img src="{row.PIC_THUMB}" border="0" alt="{row.TITLE}" />
				</div>
				<div class="pd-box-text">
					{row.TITLE}
				</div>
			</div>
		</a>
	</div>
</div>
<!-- ELSE -->
<!-- ENDIF -->
<!-- END row -->
<!-- END blk -->