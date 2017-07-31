<div {CSS}>
<div class="vf_list">
<h1 class="vf_tit">{TITLE}</h1>
<!-- BLOCK frm -->
<div>
<form name="search_frm" method="{frm.METHOD}" action="{frm.S_SEARCH}">
<input class="search" type="text" name="{frm.VAR_KEYWORD}" value="{KEYWORD}">
<input class="search_btn" type="submit" name="s1" value="{L_SEARCH}">
</form>
</div>
<!-- END frm -->
<ul>
<!-- BLOCK row -->
<li>
<!-- IF list.row.PIC_THUMB --><a href="{row.U_VIEW}" class="img">{row.PIC_THUMB}</a><!-- ENDIF -->
<a href="{row.U_VIEW}" class="tit">{row.TITLE}</a>
<!-- IF row.DATE --><p class="vf_date">{row.DATE}</p><!-- ENDIF -->
<div class="desc">{row.PREVIEW}</div>
</li>
<!-- END row -->
</ul>
{PAGING}
</div>

</div>