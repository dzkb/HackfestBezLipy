<?
class User extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}
	
	public function logIn($login, $haslo){
		$smarty=new Smarty();
	
		if ($_SESSION['logged'] != true) {
			$haslo = sha1($haslo);
			$query = "SELECT * FROM uzytkownicy WHERE login='".mysql_real_escape_string($login)."' AND haslo='".mysql_real_escape_string($haslo)."'";
			$query_r=mysql_query($query) or die(mysql_error());
			if (mysql_num_rows($query_r) == 0 ) {
				$smarty->assign('login_fail',1);
				$smarty->display(CFG_DIR_TPL."forms/login.tpl");
			}else{
				$user = mysql_fetch_array($query_r);
				$_SESSION['logged'] = true; // zalogowano
				$_SESSION['uid'] = $user['id']; // zalogowano
			}	
		}else{
			// juz zalogowany
		}
	}
	
	public function logOut(){
		if ($_SESSION['logged'] != true) {
		 // wywal b³¹d/przekieruj	
		}else{
		 unset($_SESSION['logged']);
		 unset($_SESSION['uid']);
		 // wylogowano
		}
	}
	
	public function showProfile(){
		if ($_SESSION['logged'] == true) {
			$query = "SELECT * FROM uzytkownicy WHERE id=".$_SESSION['id'];
			$query_r=mysql_query($query) or die(mysql_error());
			$user = mysql_fetch_array($query_r);
			// wyœwietl profil
		}else{
			if($_POST)
				$this->logIn($_POST['login'],$_POST['haslo']);
			else {
				$smarty=new Smarty();
				$smarty->display(CFG_DIR_TPL."forms/login.tpl");
			}
		}
	}
	
	public function register(){
		if ($_SESSION['logged'] != true) {
			if ($_POST['sent'] == 1) {
				/* sprawdzam argumenty
					wymagane:
					$_POST['login']
					$_POST['haslo']
					$_POST['hasloconfirmation']
					$_POST['email']
					$_POST['emailconfirmation']
					opcjonalne:
					$_POST['miejscowosc']
					$_POST['zainteresowania']
				*/
				
				$query = "SELECT * FROM uzytkownicy WHERE login=".mysql_real_escape_string($_POST['login'])." OR email=".mysql_real_escape_string($_POST['email']);
				$query_r=mysql_query($query) or die(mysql_error());
				if (mysql_num_rows($result) == 1) {
					// user istnieje
				}else{
					if ($_POST['haslo'] == $_POST['hasloconfirmation']) {
						if ($_POST['haslo'] == $_POST['hasloconfirmation']) {
							// dodawanie usera do bazy
							$time = time();
							$query = "INSERT INTO uzytkownicy (login, haslo, email, miejscowosc, zainteresowania) VALUES (".mysql_real_escape_string($_POST['login']).", ".mysql_real_escape_string($_POST['haslo']).", ".mysql_real_escape_string($_POST['email']).", ".mysql_real_escape_string($_POST['miejscowosc']).", ".mysql_real_escape_string($_POST['zainteresowania']).")"; 
						}else{
							// emaile nie zgadzaja sie
						}
					}else{
						// hasla nie zgadzaja sie
					}
				}
			}else{
			}
		}else{
			// wywal b³¹d/przekieruj	
		}
	}
	
	public function controller() {
		if ($_GET['logout'] == 1){
			$this->logOut();
		}elseif ($_GET['register'] == 1){
			$this->register();
		}else{
			$this->showProfile();
	}
}
}
?>