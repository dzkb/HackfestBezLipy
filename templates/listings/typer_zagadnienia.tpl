<h3>Wybierz teraz zagadnienie z tego przedmiotu, które Twoim zdaniem pojawi się na maturze</h3>
{foreach from=$zagadnienia item=i key=k}
	<a href="?action=typer&przedmiot={$smarty.get.przedmiot}&vote={$i.id}">{$i.zagadnienie}</a> ({$i.glosy})<br />
{/foreach}