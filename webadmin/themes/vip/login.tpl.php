<form name="form" method="POST" action="{S_ACTION}" target="_parent">
{S_HIDDEN}
<table>
<tr>
	<td><label>{L_USERNAME}</label></td>
	<td><input type="text" name="u" class="focus string" /></td>
</tr>
<tr>
	<td><label>{L_PASSWORD}</label></td>
	<td><input type="password" name="p" class="string" /></td>
</tr>
{CAPTCHA}
<tr>
	<td></td>
	<td><input type="submit" name="s1" value=" {L_LOGIN} " class="submit vf_btn" /></td>
</tr>
</table>
</form>