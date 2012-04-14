<?
class Ksiazki extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}
	
	public function listaPrzedmiotow() {
		$smarty = new Smarty();
		
		$query = "SELECT * FROM przedmioty ORDER BY nazwa ASC";
		$query_r = mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_array($query_r, MYSQL_NUM)){
			// linki do przedmiot󷍊			$smarty->assign("items",$result);
			$przedmioty[$result[0]]=$result[1];
			//echo "<a href='index.php?action=ksiazki&przedmiot=".$result[0]."'>".$result[1]."</a></br>";
		}
		$smarty->assign("przedmioty",$przedmioty);
		$smarty->display(CFG_DIR_TPL."listings/ksiazki_wybierz_przedmiot.tpl");
	}
	
	public function pobierzKsiazki($przedmiot, $typ) {
		$query = "";
		$query = "SELECT nazwa FROM przedmioty WHERE id=".$przedmiot." LIMIT 1";
		$query_r = mysql_query($query) or die(mysql_error());
		$res=mysql_fetch_assoc($query_r);
		$nazwa_przedmiotu=$res['nazwa'];
		
		if ($typ == 0) {
			$query = "SELECT * FROM ksiazki WHERE przedmiot_id=".$przedmiot."";
		}else{
			$query = "SELECT * FROM ksiazki WHERE przedmiot_id=".$przedmiot." AND typ_id=".$typ."";
		}
		$query_r = mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_assoc($query_r)){
			$ksiazki[$result['id']]=$result;
		}
		
		// pobierz rodzaje ksiazek
		$query = "SELECT * FROM typy_ksiazek";
		$q_run = mysql_query($query) or die(mysql_error());
		while($result = mysql_fetch_assoc($q_run)) {
			$rodzaje[$result['id']]=$result;
		}
		
		// wyݷietl
		$smarty = new Smarty();
		$smarty->assign("ksiazki",$ksiazki);
		$smarty->assign("przedmiot",$nazwa_przedmiotu);
		$smarty->assign("rodzaje",$rodzaje);
		$smarty->display(CFG_DIR_TPL.'listings/lista_ksiazek.tpl');
	}
	
	public function pobierzOpisKsiazki($id) {
		$query="SELECT * FROM ksiazki WHERE id=".$id;
		$q_run=mysql_query($query) or die(mysql_error());
		$q_res=mysql_fetch_assoc($q_run);
		
		$smarty = new Smarty();
		$smarty->assign('ksiazka',$q_res);
		$smarty->display(CFG_DIR_TPL.'ksiazka.tpl');
	}
	
	public function controller() {
		if($_GET['ksiazka']) {
			$this->pobierzOpisKsiazki(stripslashes($_GET['ksiazka']));
		}
		elseif($_GET['przedmiot']) {
			if($_GET['typ']) {
				$this->pobierzKsiazki(stripslashes($_GET['przedmiot']), stripslashes($_GET['typ']));
			}else{
				$this->pobierzKsiazki(stripslashes($_GET['przedmiot']), 0);
			}
		}
		else {
			$this->listaPrzedmiotow();
		}
	}
}
?>