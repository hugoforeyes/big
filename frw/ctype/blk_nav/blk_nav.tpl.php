<!-- BLOCK blk -->
<div {blk.CSS}>

<!-- IF .blk.rdfa -->
<ul xmlns:v="http://rdf.data-vocabulary.org/#">
<!-- BLOCK rdfa -->
<li typeof="v:Breadcrumb"<!-- IF blk.rdfa.POS == 0 --> class="first"<!-- ENDIF --><!-- IF blk.rdfa.POS == 2 --> class="last"<!-- ENDIF -->>
  <!-- IF blk.rdfa.POS > 2 -->{blk.CON}<!-- ENDIF -->
	<a href="{blk.rdfa.URL}" title="{blk.rdfa.TIT}" rel="v:url" property="v:title">{blk.rdfa.TIT}</a>
  <!-- IF blk.rdfa.POS < 2 -->{blk.CON}<!-- ENDIF -->
</li>
<!-- END rdfa -->
</ul>
<!-- ENDIF -->

<!-- IF .blk.microdata -->
<ul>
<!-- BLOCK microdata -->
<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"<!-- IF blk.microdata.POS == 0 --> class="first"<!-- ENDIF --><!-- IF blk.microdata.POS == 2 --> class="last"<!-- ENDIF -->>
  <!-- IF blk.microdata.POS > 2 -->{blk.CON}<!-- ENDIF -->
	<a href="{blk.microdata.URL}" title="{blk.microdata.TIT}" itemprop="url"><span itemprop="title">{blk.microdata.TIT}</span></a>
  <!-- IF blk.microdata.POS < 2 -->{blk.CON}<!-- ENDIF -->
</li>
<!-- END microdata -->
</ul>
<!-- ENDIF -->

<!-- BLOCK row -->
<!-- IF blk.row.POS > 2 -->{blk.CON}<!-- ENDIF -->
<a href="{blk.row.URL}" title="{blk.row.TIT}" rel="v:url" property="v:title"<!-- IF blk.row.POS == 0 --> class="first"<!-- ENDIF --><!-- IF blk.row.POS == 2 --> class="last"<!-- ENDIF -->>{blk.row.TIT}</a>
<!-- IF blk.row.POS < 2 -->{blk.CON}<!-- ENDIF -->
<!-- END row -->

</div>
<!-- END blk -->
