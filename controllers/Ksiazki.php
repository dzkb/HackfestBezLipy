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
		
		// szukam komentarzy
		
		$query="SELECT * FROM ksiazki_komentarze WHERE ksiazka_id=".$id." LIMIT 5";
		$q_run2=mysql_query($query) or die(mysql_error());
		while($q_res2=mysql_fetch_assoc($q_run2)) {
			$komentarze[$q_res2['id']]=$q_res2;
		}
		
		$smarty = new Smarty();
		$smarty->assign('komentarze',$komentarze);
		$smarty->assign('ksiazka',$q_res);
		$smarty->display(CFG_DIR_TPL.'ksiazka.tpl');
	}
	
	public function dodajKomentarz($id) {
		$smarty=new Smarty();
	require_once('recaptchalib.php');
  $privatekey = "6LcqNtASAAAAAA0Qox2vl18atreXKV-LZ7dQ7BJF";
  $publickey="6LcqNtASAAAAANTlv5YnBJiFxA11OPPKQcGUODaa";
  $smarty->assign("recaptcha",recaptcha_get_html($publickey));
		if($_POST) {
			if($_POST['nick']&&$_POST['tresc'])
			{
				  $resp = recaptcha_check_answer ($privatekey,
												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);


				  if (!$resp->is_valid) {
					$smarty->assign('captchaerror',1);
					$smarty->display(CFG_DIR_TPL.'forms/komentarz_ksiazka.tpl');
				  } else {
   
  
				$query = "INSERT INTO ksiazki_komentarze(ksiazka_id,nick,tresc,datetime,rating) VALUES(".$id.",'".$_POST["nick"]."','".$_POST["tresc"]."',NOW(),0)";
				$q_run = mysql_query($query) or die(mysql_error());
				$this->pobierzOpisKsiazki($id);
				}
			}
			else {
				$smarty->assign('error',1);
				$smarty->display(CFG_DIR_TPL.'forms/komentarz_ksiazka.tpl');
			}
		}
		else {
			//rekapcia
					  
			$smarty->display(CFG_DIR_TPL.'forms/komentarz_ksiazka.tpl');
		}
	}
	
	public function dodajKsiazke() {
		$smarty=new Smarty();
require_once('recaptchalib.php');
$privatekey = "6LcqNtASAAAAAA0Qox2vl18atreXKV-LZ7dQ7BJF";
$publickey="6LcqNtASAAAAANTlv5YnBJiFxA11OPPKQcGUODaa";
$smarty->assign("recaptcha",recaptcha_get_html($publickey));
		if($_POST){
		 $resp = recaptcha_check_answer ($privatekey,
												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);
			if($_POST['nazwa']&&$_POST['autor']&&$_POST['opis']) {
				if (!$resp->is_valid) {
					$smarty->assign('captchaerror',1);
				}
				else {
					$query="INSERT INTO ksiazki(przedmiot_id,typ_id,nazwa,autor,opis) VALUES(".$_GET["przedmiot"].",".$_POST["rodzaj"].",'".$_POST["nazwa"]."','".$_POST["autor"]."','".$_POST["opis"]."')";
					$q_run=mysql_query($query) or die(mysql_error().$query);
					$this->pobierzKsiazki($_GET['przedmiot'],$_GET['typ']);
				}
			}
			else {
				$smarty->assign('error',1);
				$smarty->display(CFG_DIR_TPL.'forms/dodaj_ksiazke.tpl');
			}
		}
		else
		{
			$smarty->display(CFG_DIR_TPL.'forms/dodaj_ksiazke.tpl');
		}
	}
	
	public function controller() {
		if($_GET['ksiazka']) {
			if($_GET['komentarz']==1)
				$this->dodajKomentarz(stripslashes($_GET['ksiazka']));
			else
				$this->pobierzOpisKsiazki(stripslashes($_GET['ksiazka']));
		}
		elseif($_GET['przedmiot']) {
			if($_GET['dodaj']==1){
				$this->dodajKsiazke();
			}
			else {
				if($_GET['typ']) {
					$this->pobierzKsiazki(stripslashes($_GET['przedmiot']), stripslashes($_GET['typ']));
				}else{
					$this->pobierzKsiazki(stripslashes($_GET['przedmiot']), 0);
				}
			}
		}
		else {
			$this->listaPrzedmiotow();
		}
	}
}
?>