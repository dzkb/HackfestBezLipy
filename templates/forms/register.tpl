<h3>Zarejestruj się w serwisie</h3>
{if $confirmreg==1}
	<p class="b" style="color:red;">Teraz możesz <a href="?action=user">się zalogować</a> do Wygranej Matury! :)</p>
{else}
	{if $user_exists==1}<p class="b" style="color:red;">Niestety, istnieje już użytkownik o takim loginie lub rejestrowałeś się już pod ten adres e-mail.</p>{/if}
	{if $wrong_emails==1}<p class="b" style="color:red;">Podane adresy email nie zgadzają się.</p>{/if}
	{if $wrong_passwords==1}<p class="b" style="color:red;">Podane hasła nie zgadzają się.</p>{/if}
	{if $fields==1}<p class="b" style="color:red;">Wypełnij wszystkie pola</p>{/if}
	<form method="post">
		Login: <input type="text" name="login" value="{$smarty.post.login}"/><br />
		Hasło: <input type="password" name="haslo" /><br />
		Powtórz hasło: <input type="password" name="hasloconfirmation" /><br />
		Email: <input type="text" name="email" value="{$smarty.post.email}" /><br />
		Powtórz email: <input type="text" name="emailconfirmation" value="{$smarty.post.emailconfirmation}" /><br />
		Miejscowość: <input type="text" name="miejscowosc" value="{$smarty.post.miejscowosc}" /><br />
		Zainteresowania: <input type="text" name="zainteresowania" value="{$smarty.post.zainteresowania}" /><br />
		<input type="submit" value="Zarejestruj się" />
	</form>
{/if}