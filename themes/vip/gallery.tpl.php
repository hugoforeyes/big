<div class="content_products ">

<!-- BLOCK list -->
<div class="pd-header clearfix">
  <div class="pull-left title">{list.TITLE}</div>
  <div class="pull-right">{list.PAGING}</div>
</div>
<div class="pd-list row" id="product-list">
<!-- BLOCK row -->
<div class="col-md-part-5 pd-item-wp">
  <div class="pd-item" onclick="showDetail('{list.row.ID}');">
    <a data-id="{list.row.ID}"
      data-title="{list.row.TITLE}" data-desc="{list.row.PREVIEW}" 
      data-img="{list.row.O_PIC_FULL}][{list.row.O_PIC1}][{list.row.O_PIC2}][{list.row.O_PIC3}][{list.row.O_PIC4}"
      href="javascript:;">
      <img src="{list.row.O_PIC_FULL}" border="0" alt="" />
    </a>
  </div>
  <div class="pd-name">{list.row.TITLE}</div>
</div>
<!-- END row -->
</div>
<div id="product-detail" class="row pd-detail-wp" style="display: none;">
  <div class="pd-detail-bar col-md-12" onclick="showList()"><< BACK</div>
  <div class="col-md-8 pd-detail-img-wp">
    <img id="pd-detail-img"/>
  </div>
  <div class="col-md-4">
    <div id="pd-detail-desc"></div>
    <div id="pd-detail-thumb"></div>
  </div>
</div>
              

<!-- END list -->

</div>