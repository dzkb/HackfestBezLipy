<h3>Kierunki studiów</h3>
<div class="div_kierunek_holder">
{foreach from=$kierunki key=k item=i}
	<a href="?action=kierunki&kierunek={$i.id}" class="div_kierunek" style="background:#{if $k%2 == 0}F6F7DC{else}f9fae8{/if};">
		<h3>{$i.nazwa}</h3>
		<p>{$i.opis}</p>
		<p><b>Popularność:</b> 100%</p>
	</a>
	{if $k%5 == 0}<div style="clear:both;"></div>{/if}
{/foreach}
</div>