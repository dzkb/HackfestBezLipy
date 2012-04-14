<h3>Dodaj książkę</h3>
{if $captchaerror==1}<p class="b">Przepisz poprawnie kapcię</p>{/if}
<form method="post">
	Rodzaj książki: <select name="rodzaj">
	<option value="1">zbiór zadań</option>
	<option value="2">podręcznik</option>
	<option value="3">vademecum</option>
	<option value="4">inne</option>
	</select><br />
	Nazwa: <input type="text" name="nazwa" /><br />
	Autor: <input type="text" name="autor" /><br />
	Opis: <textarea name="opis"></textarea><br />
	{$recaptcha}
	<input type="submit" value="Zapisz" />
</form>