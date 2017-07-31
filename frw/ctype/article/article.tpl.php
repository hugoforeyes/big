<div {CSS}>

<!-- BLOCK cat -->
<div class="vf_cat">
<h2 class="vf_tit"><a href="{cat.U_VIEW}">{cat.TITLE}</a></h2>
<ul class="hot">
<!-- BLOCK hot -->
<li class="hot">
<!-- IF cat.hot.PIC_THUMB --><a href="{cat.hot.U_VIEW}" class="img">{cat.hot.PIC_THUMB}</a><!-- ENDIF -->
<a href="{cat.hot.U_VIEW}" class="tit">{cat.hot.TITLE}</a>
<!-- IF cat.hot.DATE --><p class="vf_date">{cat.hot.DATE}</p><!-- ENDIF -->
<div class="desc">{cat.hot.PREVIEW}</div>
</li>
<!-- END hot -->
</ul>
<ul>
<!-- BLOCK row -->
<li><a href="{cat.row.U_VIEW}" class="tit">{cat.row.TITLE}</a><!-- IF cat.row.DATE --><p class="vf_date">{cat.row.DATE}</p><!-- ENDIF --></li>
<!-- END row -->
</ul>
<p class="vf_more"><a href="{cat.U_VIEW}">{L_MORE}</a></p>
</div>
<!-- END cat -->

<!-- BLOCK list -->
<div class="vf_list">
<h2 class="vf_tit"><a href="{list.U_VIEW}">{list.TITLE}</a></h2>
<ul class="hot">
<!-- BLOCK hot -->
<li class="hot">
<!-- IF list.hot.PIC_THUMB --><a href="{list.hot.U_VIEW}" class="img">{list.hot.PIC_THUMB}</a><!-- ENDIF -->
<a href="{list.hot.U_VIEW}" class="tit">{list.hot.TITLE}</a>
<!-- IF list.hot.DATE --><p class="vf_date">{list.hot.DATE}</p><!-- ENDIF -->
<div class="desc">{list.hot.PREVIEW}</div>
</li>
<!-- END hot -->
</ul>
<ul>
<!-- BLOCK row -->
<li>
<!-- IF list.row.PIC_THUMB --><a href="{list.row.U_VIEW}" class="img">{list.row.PIC_THUMB}</a><!-- ENDIF -->
<a href="{list.row.U_VIEW}" class="tit">{list.row.TITLE}</a>
<!-- IF list.row.DATE --><p class="vf_date">{list.row.DATE}</p><!-- ENDIF -->
<div class="desc">{list.row.PREVIEW}</div>
</li>
<!-- END row -->
</ul>
{list.PAGING}
</div>
<!-- END list -->

<!-- BLOCK view -->
<div class="vf_view">
<!-- IF view.TITLE --><h1 class="vf_tit">{view.TITLE}</h1>
<!-- IF view.DATE --><p class="vf_date">{view.DATE}</p><!-- ENDIF --><!-- ENDIF -->
<div class="vf_ctn">{view.CONTENT}</div>
<!-- IF view.AUTHOR --><p class="vf_auth">{view.AUTHOR}</p><!-- ENDIF -->
</div>

<!-- IF .view.prev -->
<div class="vf_next">
<p class="vf_tit">Bài mới</p>
<ul>
<!-- BLOCK prev -->
<li><a href="{view.prev.U_VIEW}">{view.prev.TITLE}</a><!-- IF view.DATE --><p class="vf_date">({view.prev.DATE})</p><!-- ENDIF --></li>
<!-- END prev -->
</ul>
</div>
<!-- ENDIF -->

<!-- IF .view.next -->
<div class="vf_next">
<p class="vf_tit">{L_VMORE}</p>
<ul>
<!-- BLOCK next -->
<li><a href="{view.next.U_VIEW}">{view.next.TITLE}</a><!-- IF view.DATE --><p class="vf_date">({view.next.DATE})</p><!-- ENDIF --></li>
<!-- END next -->
</ul>
</div>
<!-- ENDIF -->
<!-- END view -->

</div>