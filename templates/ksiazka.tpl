<h2>{$ksiazka.nazwa}</h2>
<img src="/public/images/ksiazki/{$ksiazka.img}" style="float:left;margin:10px;" />
<p><b>Autor:</b> {$ksiazka.autor}</p>
<p><b>Opis:</b> {$ksiazka.opis}</p>
<h4><a href="?action=ksiazki&przedmiot={$smarty.get.przedmiot}">Powrót do listy książek z przedmiotu</a></h4>
<h3>Komentarze i opinie (<a href="?action=ksiazki&przedmiot={$smarty.get.przedmiot}&ksiazka={$ksiazka.id}&komentarz=1">Dodaj swój komentarz</a>)</h3>
{foreach from=$komentarze key=k item=i}
<p style="font-weight:bold;">{$i.nick}</p>
<p>{$i.tresc} (<i>{$i.datetime}</i>)</p>
{/foreach}
