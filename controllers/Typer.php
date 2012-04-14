<?
class Typer extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}
	
	public function wybierzPrzedmiot() {
		$smarty=new Smarty();
		// pobierz listę przedmiotów
		$przedmioty = array();
		$query = "SELECT * FROM przedmioty ORDER BY nazwa ASC";
		$query_r = mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_assoc($query_r)){
			$przedmioty[$result['id']]=$result;
		}
		
		$smarty->assign("przedmioty",$przedmioty);
		$smarty->display(CFG_DIR_TPL.'/listings/typer_przedmioty.tpl');
	}
	
	public function pobierzTematyki($przedmiot) {
		$smarty=new Smarty();
		// pobierz tematyki do typera
		$query = "SELECT * FROM zagadnienia WHERE id_przedmiotu=".$przedmiot." ORDER BY glosy DESC";
		$query_r=mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($query_r) != 1) { $this->wybierzPrzedmiot(); }
		while ($result = mysql_fetch_assoc($query_r)){
			$zagadnienia[$result['id']]=$result;
		}
		
		$smarty->assign("zagadnienia",$zagadnienia);
		$smarty->display(CFG_DIR_TPL."listings/typer_zagadnienia.tpl");
		
	}
	
	public function zaglosujNaZagadnienie($id_zagadnienia){
		$pass = false;
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = "SELECT * FROM glosowania WHERE ip=".ip2long($ip);
		$query_r=mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($query_r) == 0) {
			$pass = true;
		}
		else{
			$result = mysql_fetch_array($query_r);
			if ((time() - $result['czas_glosowania']) > 172800){
				$query = "DELETE FROM glosowania WHERE ip=".ip2long($ip);
				$query_r=mysql_query($query) or die(mysql_error());
				$pass = true;
				}
		}
		if($pass) {
			$query = "UPDATE zagadnienia SET glosy=glosy+1 WHERE id=".$id_zagadnienia;
			$query_r=mysql_query($query) or die(mysql_error());
			$query = "INSERT INTO glosowania (ip) VALUES (".ip2long($ip).")";
			$query_r=mysql_query($query) or die(mysql_error());
		}
		$this->pobierzTematyki(stripslashes($_GET['przedmiot']));
	}
	
	public function controller() {
		if ($_GET['vote']){
			$this->zaglosujNaZagadnienie(stripslashes($_GET['vote']));
		}
		elseif($_GET['przedmiot']) {
			$this->pobierzTematyki(stripslashes($_GET['przedmiot']));
		}else{
			$this->wybierzPrzedmiot();
		}
	}
}
?>