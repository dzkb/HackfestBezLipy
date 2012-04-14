<h3>Zaloguj się do serwisu</h3>
{if $login_fail==1}<p class="b" style="color:red;">Błędny użytkownik i/lub hasło</p>{/if}
<form method="post">
	Login: <input type="text" name="login" /><br />
	Hasło: <input type="password" name="haslo" /><br />
	<input type="submit" value="Zaloguj" />
</form>
<p>Nie masz jeszcze konta? <a href="?action=user&register=1">Zrób sobie jedno!</a></p>