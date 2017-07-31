<div {CSS}>

<!-- BLOCK cat -->
<div class="vf_cat">
<h2 class="vf_tit"><a href="{cat.U_VIEW}">{cat.TITLE}</a></h2>
<ul>
<!-- BLOCK row -->
<li>
<a href="{cat.row.U_VIEW}">
	<span class="img">{cat.row.PIC_THUMB}</span>
	<span class="tit">{cat.row.TITLE}</span>
</a>
</li>
<!-- END row -->
</ul>
</div>
<!-- END cat -->


<!-- BLOCK list -->
<div class="vf_list">
<h2 class="vf_tit"><a href="{list.U_VIEW}">{list.TITLE}</a></h2>
<ul>
<!-- BLOCK row -->
<li>
<a href="{list.row.U_VIEW}">
	<span class="img">{list.row.PIC_THUMB}</span>
	<span class="tit">{list.row.TITLE}</span>
</a>
</li>
<!-- END row -->
</ul>
<div id="paging-wrapper">{list.PAGING}</div>
</div>
<!-- END list -->

<!-- BLOCK view -->
<div class="vf_view">
<!-- IF view.DATE --><p class="vf_date">{view.DATE}</p><!-- ENDIF -->
<!-- IF view.PIC_FULL --><div class="media">{view.PIC_FULL}</div><!-- ENDIF -->
<ul>
<!-- BLOCK row -->
<li>
	<span class="img">{view.row.PIC}</span>
	<span class="tit">{view.row.TIT}</span>
</li>
<!-- END row -->
</ul>
<!-- IF view.TITLE --><h1 class="vf_tit">{view.TITLE}</h1><!-- ENDIF -->
<div class="desc">{view.PREVIEW}</div>
</div>

<!-- IF .view.next -->
<div class="vf_next">
<p class="vf_tit">{L_VMORE}</p>
<ul>
<!-- BLOCK next -->
<li><a href="{view.next.U_VIEW}"><span class="img">{view.next.PIC_THUMB}</span><span class="tit">{view.next.TITLE}</span><!-- IF view.DATE --><span class="vf_date">({view.next.DATE})</span><!-- ENDIF --></a></li>
<!-- END next -->
</ul>
</div>
<!-- ENDIF -->
<!-- END view -->
</div>