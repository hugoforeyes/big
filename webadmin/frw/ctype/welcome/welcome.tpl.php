<!-- BLOCK msg -->
<div class="form_wra welcome"><div class="tr_wra">
<div class="td_wra">
	<h2 class="title_welcome">{L_STAFF}</h2>
	<table class="form">
	<tr>
		<th>{L_HELLO}</th>
		<td>{msg.STAFF}</td>
	</tr>
	<tr>
		<th>IP</th>
		<td>{msg.IP}</td>
	</tr>
	<tr>
		<th>{L_ONLINE}</th>
		<td>{msg.ONLINE}</td>
	</tr>
	</table>

</div>
<div class="td_wra">
	<!-- IF msg.NOTICE -->
	<h2 class="title_welcome">{L_NOTICE}</h2>
	<table class="form">
	{msg.NOTICE}
	</table>
	<!-- ENDIF -->

	<h2 class="title_welcome">{L_SYSTEM}</h2>
	<table class="form">
	<tr>
		<th>{L_SOFTWARE}</th>
		<td>vFramework {msg.VERSION}</td>
	</tr>
	<tr>
		<th>{L_LICENSE}</th>
		<td><div id="license"><img src="{URL_CP_THEME}img/loading.gif" alt="" /></div><script type="text/javascript">$(function(){
$.post('{msg.U_LICENSE}',function(e){$("#license").html(e);});
});</script></td>
	</tr>
	</table>
  
</div>
</div></div>
<!-- END msg -->