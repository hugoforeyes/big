<div class="content_type1">

<!-- BLOCK view -->
<!-- IF view.O_PIC_THUMB --><div class="content_type1_image"><img src="{view.O_PIC_THUMB}" width="420" height="362" alt="" /></div><!-- ENDIF -->
<div id="content_inner_scrollbar" class="content_type1_content"><div class="content_type1_content_padded">
<br>
{view.CONTENT}
</div></div>
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



