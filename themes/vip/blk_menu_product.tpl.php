<!-- BLOCK blk -->
<div class="m_products">
<!-- BLOCK row -->
<!-- IF row.TREE == "o1" -->
<!-- ELSEIF row.TREE == "c1" -->
<!-- ELSEIF row.TREE == "o2" -->
 &nbsp; | &nbsp; <a href="{row.URL}" class="m_product_item<!-- IF row.ACTIVE --> active<!-- ENDIF -->">{row.TITLE}</a>
<!-- ELSE -->
<!-- ENDIF -->
<!-- END row -->
</div>
<!-- END blk -->