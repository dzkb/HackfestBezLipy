<?
class Progi extends Kierunki {
	public function __construct()
	{
		$this->controller();
	}
	
	public function pobierzProgi($rok,$kierunek,$uczelnia) {
		$query = "Select * ";
		$query_r = mysql_query($query) or die(mysql_error());
	}
	
	public function sprawdzGetProgi() {
		$smarty = new Smarty();
		
		if($_GET['rok'] && $_GET['kierunek'] && $_GET['uczelnia'])
		{
			$this->pobierzProgi(stripslashes($_GET['rok']),stripslashes($_GET['kierunek']),stripslashes($_GET['uczelnia']));
		}
		else
		{
			$smarty->display(CFG_DIR_TPL.'errors/error_progi.tpl');
		}
	}
	
	public function controller() {
		$this->sprawdzGetProgi();
	}
}

?>