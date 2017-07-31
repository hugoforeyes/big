<div class="content_type3">

<!-- BLOCK view -->
<!-- IF view.O_PIC_THUMB --><div class="content_type3_image"><img src="{view.O_PIC_THUMB}" height="362" alt="" /></div><!-- ENDIF -->
<img class="content_type3_cover" src="{URL_UPLOAD}binner.png" height="362" alt="" />
<div id="content_inner_scrollbar" class="content_type3_content"><div class="content_type3_content_padded">
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
