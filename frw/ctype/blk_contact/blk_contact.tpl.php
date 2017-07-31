<!-- BLOCK ajax -->
<div {CSS}>
<form id="{ajax.ID}" name="contactblkfrm" method="POST" action="{S_NOJS}" ENCTYPE="multipart/form-data">
<!-- END ajax -->
{MESSAGE}
<!-- BLOCK blk -->
<input type="hidden" name="submit" value="1" />
<table class="form">
{blk.ROWS}
<tr>
	<th>&nbsp;</th>
<td>
	<input type="submit" name="submit" value="{L_SUBMIT}" class="btn" />
	<input type="reset" name="reset" value="{L_RESET}"  class="btn" />
</td>
</tr>
</table>
<!-- END blk -->
<!-- BLOCK ajax -->
</form>
</div>
<script type="text/javascript">
$('#{ajax.ID}').submit(function(e){
  e.preventDefault();
	$.post('{ajax.URL}',$('#{ajax.ID}').serialize(),function(d){$('#{ajax.ID}').html(d);});
});
</script>
<!-- END ajax -->