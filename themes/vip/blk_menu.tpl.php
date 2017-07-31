<!-- BLOCK blk -->
<div id="mainnavi">
<!-- BLOCK row -->
<!-- IF row.TREE == "o1" -->
<div class="mainnavi_home_placeholder">
<!-- ELSEIF row.TREE == "c1" -->
</div>
<!-- ELSEIF row.TREE == "o2" -->
    <a href="{row.URL}"<!-- IF row.ACTIVE --> class="active"<!-- ENDIF -->>{row.TITLE}</a>
<!-- ELSE -->
<!-- ENDIF -->
<!-- END row -->
</div>
<!-- END blk -->