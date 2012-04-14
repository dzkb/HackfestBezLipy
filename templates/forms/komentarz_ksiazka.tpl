<h3>Dodaj komentarz do książki</h3>
{if $error==1}<p class="b">Błąd - wypełnij wszystkie pola</p>{/if}
{if $captchaerror==1}<p class="b">Przepisz poprawnie CAPTCHA'ę</p>{/if}
<form method="post">  
	Nick: <input type="text" name="nick" /><br />
	Tresc: <textarea name="tresc"></textarea>
	{$recaptcha}
	<input type="submit" value="Zapisz" />
</form>