<div class="content_products ">

<!-- BLOCK list -->
<div class="pd-header clearfix">
  <div class="pull-left title">{list.TITLE}</div>
  <div class="pull-right">{list.PAGING}</div>
</div>
<div class="pd-list row" id="product-list">
<!-- BLOCK row -->
<div class="col-md-part-5 col-sm-3 col-xs-6 pd-item-wp">
  <div class="pd-item" onclick="showDetail('{list.row.ID}');">
    <a data-id="{list.row.ID}"
      data-title="{list.row.TITLE}"
      data-img="{list.row.O_PIC_FULL}][{list.row.O_PIC1}][{list.row.O_PIC2}][{list.row.O_PIC3}][{list.row.O_PIC4}"
      href="javascript:;">
      <img src="{list.row.O_PIC_FULL}" border="0" alt="" />
      <div class="datadesc" style="display: none;">{list.row.PREVIEW}</div>
    </a>
  </div>
  <div class="pd-name">{list.row.TITLE}</div>
</div>
<!-- END row -->
</div>
<div id="product-detail" class="row pd-detail-wp" style="display: none;">
  <div class="pd-detail-bar col-md-12" onclick="showList()"><< BACK</div>
  <div class="col-md-8 col-sm-12 pd-detail-img-wp">
    <img id="pd-detail-img"/>
  </div>
  <div class="col-md-4 col-sm-10 col-sm-offset-1 col-md-offset-0 pd-info">
    <div id="pd-detail-thumb-xs" class="pd-detail-thumb visible-sm visible-xs"></div>
    <div id="pd-detail-desc"></div>
    <div id="pd-detail-thumb-md" class="pd-detail-thumb visible-md visible-lg"></div>
  </div>
</div>
              

<!-- END list -->

</div>