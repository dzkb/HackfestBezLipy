<h3>Dodaj książkę</h3>
{if $captchaerror==1}<p class="b">Przepisz poprawnie kapcię</p>{/if}
<form method="post">
	Nazwa: <input type="text" name="nazwa" /><br />
	Autor: <input type="text" name="autor" /><br />
	Opis: <textarea name="opis"></textarea><br />
	{$recaptcha}
	<input type="submit" value="Zapisz" />
</form>