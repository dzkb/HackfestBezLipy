<?
class Typer extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}
	
	public function wybierzPrzedmiot() {
		// pobierz listę przedmiotów
		$query = "Select * ";
		$query_r = mysql_query($query) or die(mysql_error());
		
	}
	
	public function pobierzTematyki($przedmiot) {
		// pobierz tematyki do typera
		$query = "Select * ";
		$query_r=mysql_query($query) or die(mysql_error());
	}
	
	public function controller() {
		if(!$_GET['przedmiot']) {
			$this->wybierzPrzedmiot();
		}
		else
		{
			$this->pobierzTematyki(stripslashes($_GET['przedmiot']));
		}
	}
}
?>