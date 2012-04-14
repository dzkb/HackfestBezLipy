<h3>Książki - wybierz przedmiot</h3>
<div class="div_kierunek_holder">
{foreach from=$przedmioty key=k item=i name=przed}
	<a href="?action=ksiazki&przedmiot={$k}" class="div_kierunek" style="background:#{if $smarty.foreach.przed.iteration%2 == 0}F6F7DC{else}f9fae8{/if};font-size:1.2em;">{$i}</a>
	{if $smarty.foreach.przed.iteration%3 == 0}<div style="clear:both;"></div>{/if}
{/foreach}
</div>