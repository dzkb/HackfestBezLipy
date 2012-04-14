<h3>Książki - wybierz przedmiot</h3>
{$przedmioty|@var_dump}
{foreach from=$przedmioty key=k item=i}
	<p><a href="?action=ksiazki&przedmiot={$k}">{$i}</a></p>
{/foreach}