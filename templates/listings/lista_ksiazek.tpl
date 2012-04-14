<h3>Książki z przedmiotu {$przedmiot}</h3>
<div style="float:left;background:#ccc;width:200px;height:600px;margin:10px;padding:5px;">
<b>Wybierz typ książki:</b>
<ul>
	<li>{if !$smarty.get.typ}<b>{else}<a href="?action=ksiazki&przedmiot={$smarty.get.przedmiot}">{/if}wszystkie{if !$smarty.get.typ}</b>{else}</a>{/if}</li>
{foreach from=$rodzaje key=k item=i}
	<li>{if $smarty.get.typ==$i.id}<b>{else}<a href="?action=ksiazki&przedmiot={$smarty.get.przedmiot}&typ={$i.id}">{/if}{$i.rodzaj}{if $smarty.get.typ==$i.id}</b>{else}</a>{/if}</li>
{/foreach}
</ul>
</div>
<a href="?action=ksiazki&przedmiot={$smarty.get.przedmiot}&dodaj=1">Zaproponuj książkę</a>
{foreach from=$ksiazki key=k item=i}
	<h3><a href="?action=ksiazki&ksiazka={$i.id}&przedmiot={$smarty.get.przedmiot}">{$i.nazwa}</a></h3>
	<p><b>Autor:</b> {$i.autor}</p>
	<p><b>Opis:</b> {$i.opis}</p>
	<hr />
{/foreach}
<h4><a href="?action=ksiazki">Powróć do wyszukiwania książek według przedmiotu</a></h4>