<!-- BLOCK blk -->
<div {blk.CSS}>
<!-- IF blk.TITLE -->
<div class="vf_tit">{blk.TITLE}</div>
<!-- ENDIF -->
<form name="searchblk" method="{blk.METHOD}" action="{blk.S_SUBMIT}">
<input class="text" type="text" id="{blk.VAR_KEYWORD}" name="{blk.VAR_KEYWORD}" placeholder="{L_KEYWORD}" value="{blk.KEYWORD}" />
<input class="submit" type="submit" value="{L_SEARCH}" />
</form></div>
<!-- END blk -->
