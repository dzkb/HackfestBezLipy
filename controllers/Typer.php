<?
class Typer extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}
	
	public function wybierzPrzedmiot() {
		// pobierz listę przedmiotów
		$przedmioty = array();
		$query = "SELECT * FROM przedmioty";
		$query_r = mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_assoc($query_r)){
			// info o przedmiotach
			
		}
	}
	
	public function pobierzTematyki($przedmiot) {
		// pobierz tematyki do typera
		$query = "SELECT * FROM zagadnienia WHERE id_przedmiotu=".$przedmiot;
		$query_r=mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_assoc($query_r)){
			// info o zagadnieniach i linki do glosowania GET ?vote=$result['id']
		}
	}
	
	public function zaglosujNaZagadnienie($id_zagadnienia){
		$pass = false;
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = "SELECT * FROM glosowania WHERE ip=".ip2long($ip);
		$query_r=mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($query_r) == 0) {
			$pass = true;
		}else{
			$result = mysql_fetch_array($query_r);
			if ((time() - $result['czas_glosowania']) > 172800){
				$pass = true;
			}
		}
		if (mysql_num_rows($query_r) == 0) 
		session_start();
		if ($_SESSION['logged'] == true) {
			$query = "SELECT * FROM zagadnienia WHERE id=".$id_zagadnienia;
			$query_r=mysql_query($query) or die(mysql_error());
			$zagadnienie = mysql_fetch_array($query_r);
			// teraz mamy do dyspozycji pola id, nazwa, id przedmiotu i glosy
			$query = "UPDATE zagadnienia SET glosy=".$zagadnienie['glosy']+1 ." WHERE id=".$id_zagadnienia;
			$query_r=mysql_query($query) or die(mysql_error());
			$query = "INSERT INTO glosowania (ip) VALUES (".ip2long($ip).")";
		}else{
			// niezalogowany - przekieruj na user
		}
	}
	
	public function controller() {
		if($_GET['przedmiot']) {
			$this->pobierzTematyki(stripslashes($_GET['przedmiot']));
		}elseif ($_GET['vote']){
			$this->zaglosujNaZagadnienie(stripslashes($_GET['vote']));
		}else{
			$this->wybierzPrzedmiot();
		}
	}
}
?>