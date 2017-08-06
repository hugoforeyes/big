<div class="page-wp row">

<!-- BLOCK view -->
	<!-- IF view.O_PIC_THUMB -->
	<div class="page-img col-md-8 col-sm-12">
		<img src="{view.O_PIC_THUMB}" alt="" />
	</div>
	<!-- ENDIF -->
	<div class="page-text col-md-4 col-sm-12">
		{view.CONTENT}
	</div>
<!-- END view -->

</div>
<script type="text/javascript">
$(document).ready(function() {
  $('#content_inner_scrollbar').slimScroll({
      position: 'right',
      height: '355px',
      railVisible: true,
      alwaysVisible: true,
      distance: '0px'
  });
});
</script>
