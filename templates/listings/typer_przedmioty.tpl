<h3>Typer 2012</h3>
<p>Pasowałoby w kilku zdaniach wyjaśnić na czym polega <b>Typer 2012</b>, ale pisząc to o 04:47 jestem w stanie skrobnąć tylko tyle.</p>
<p>Wybierz zagadnienia <b>z danego przedmiotu:</b></p>
{foreach from=$przedmioty key=k item=i}
	<a href="?action=typer&przedmiot={$i.id}">{$i.nazwa}</a>,
{/foreach}