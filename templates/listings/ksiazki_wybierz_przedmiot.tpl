<h3>Książki - wybierz przedmiot</h3>
{foreach from=$przedmioty key=k item=i}
	<p><a href="?action=ksiazki&przedmiot={$k}">{$i}</a></p>
{/foreach}