<?
class Kierunki extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}

	public function pobierzKierunki() {
		$query="SELECT * FROM kierunki ORDER BY nazwa ASC";
		$query_r=mysql_query($query) or die(mysql_error());
		
		while ($result = mysql_fetch_assoc($query_r)){
			// info o kierunkach
			$kierunki[$result['id']]=$result;
		}
		
		$smarty = new Smarty();
		$smarty->assign("kierunki",$kierunki);
		$smarty->display(CFG_DIR_TPL."listings/kierunki.tpl");
	}
	
	public function wyswietlKierunek($id) {
		/*
			Pobierz informacje o kierunku
		*/
		$query="SELECT nazwa FROM kierunki WHERE id=".$id;
		$query_r=mysql_query($query) or die(mysql_error());
		$kierunek=mysql_fetch_assoc($query_r);
		
		/*
			Pobierz info które uczelnie mają kierunek
		*/
		$smarty=new Smarty();
		
		$uczelnie = $this->znajdzUczelnieZKierunkiem($id);
		foreach ($uczelnie as $uczelnia) {
			#echo var_dump($uczelnia);
			//$uczelnia['id']
			//$uczelnia['nazwa']
			//$uczelnia['opis']
		}
		$smarty->assign("uczelnie",$uczelnie);
		$smarty->assign("kierunek",$kierunek);
		$smarty->display("listings/uczelnie_z_kierunkiem.tpl");
	}
	
	public function znajdzUczelnieZKierunkiem($id) {
		$uczelnie = array();
		//$query_r = mysql_query($query) or die(mysql_error());
		$query="SELECT * FROM uczelnie_kierunki WHERE id_kierunku=".$id;
		$query_r=mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_array($query_r, MYSQL_NUM)){
			$query = "SELECT id,nazwa,opis FROM uczelnie WHERE id=".$result[2];
			$query_r=mysql_query($query) or die(mysql_error());
			$uczelnia = mysql_fetch_array($query_r);
			//echo "<p>".$uczelnia['id']." - ".$uczelnia['nazwa']." - ".$uczelnia['opis']." - ".$uczelnia['url'];
			$uczelnie[] = $uczelnia;
		}
		return $uczelnie;
	}
	
	public function pokazSzczegoloweDane($id){
		$kierunki = array();
		$query = "SELECT * FROM uczelnie WHERE id=".$id;
		$query_r=mysql_query($query) or die(mysql_error());
		$uczelnia = mysql_fetch_array($query_r);
		$query = "SELECT * FROM uczelnie_kierunki WHERE id_uczelni=".$id;
		$query_r=mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_array($query_r, MYSQL_NUM)){
			$query = "SELECT * FROM kierunki WHERE id=".$result[1];
			$query_r=mysql_query($query) or die(mysql_error());
			$kierunek = mysql_fetch_array($query_r);
			$kierunki[] = $kierunek;
		}
		// Dostępne dane:
			//$uczelnia['id']
			//$uczelnia['nazwa']
			//$uczelnia['opis']
			//$uczelnia['url']
			//$uczelnia['dlugiopis']
			//$kierunki['nazwa']
	}
	
	public function pobierzUczelnie(){
		$query="SELECT id,nazwa,opis FROM uczelnie";
		$query_r=mysql_query($query) or die(mysql_error());
		while ($result = mysql_fetch_array($query_r, MYSQL_NUM)){
			// tutaj zrobić listę wszystkich uczelni
		}
	}
	
	public function controller() {
		$smarty = new Smarty();
		
		if($_GET['kierunek']) {
			$this->wyswietlKierunek(stripslashes($_GET['kierunek']));
		}elseif ($_GET['uczelnia']) {
			$this->pokazSzczegoloweDane(stripslashes($_GET['uczelnia']));
		}elseif ($_GET['uczelnie']){
			$this->pobierzUczelnie();
		}else{
			$this->pobierzKierunki();
		}
	}
}
?>