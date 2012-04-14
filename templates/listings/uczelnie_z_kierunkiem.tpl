<h3>Uczelnie, gdzie możesz studiować {$kierunek.nazwa}</h3>
{foreach from=$uczelnie key=k item=i}
	<h3><a href="?action=kierunki&kierunek={$smarty.get.kierunek}&uczelnia={$i.id}">{$i.nazwa}</a></h3>
	<p>{$i.opis}</p>
	<p><a href="#" style="font-weight:bold;">Zobacz progi punktowe na {$kierunek.nazwa} na uczelni {$i.nazwa}</a></p>
	<p><a href="#">Opinie o uczelni (12)</a></p>
{/foreach}
<hr />
<a href="?action=kierunki">Wybierz inny kierunek</a>