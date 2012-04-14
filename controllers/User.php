<?
class User extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}
	
	public function logIn($login, $haslo){
		$smarty=new Smarty();
	
		if (!$_SESSION['logged']) {
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
				
				$this->showProfile();
			}	
		}
		else
		{
			echo var_dump($_SESSION);
			// juz zalogowany
		}
	}
	
	public function logOut(){
		session_start();
		if ($_SESSION['logged'] != true) {
		 // wywal błąd/przekieruj	
		}else{
		 unset($_SESSION['logged']);
		 unset($_SESSION['uid']);
		 // wylogowano
		}
	}
	
	public function showProfile(){
	
		if ($_SESSION['logged'] == true) {
			$query = "SELECT * FROM uzytkownicy WHERE id=".$_SESSION['uid'];
			$query_r=mysql_query($query) or die(mysql_error());
			$user = mysql_fetch_array($query_r);
			// wyświetl profil
			
		}else{
			if($_POST)
				$this->logIn($_POST['login'],$_POST['haslo']);
			else {
				echo var_dump($_SESSION);
				$smarty=new Smarty();
				$smarty->display(CFG_DIR_TPL."forms/login.tpl");
			}
		}
	}
	
	public function register(){
		$smarty=new Smarty();
		if ($_SESSION['logged'] != true)
		{
			if ($_POST) {
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
				if($_POST['login']&&$_POST['haslo']&&$_POST['hasloconfirmation']&&$_POST['email']&&$_POST['emailconfirmation'])
				{
					$query = "SELECT * FROM uzytkownicy WHERE login='".stripslashes($_POST['login'])."' OR email='".stripslashes($_POST['email'])."'";
					$query_r=mysql_query($query) or die(mysql_error());
					if (mysql_num_rows($query_r) == 1)
					{
						$smarty->assign("user_exists",1);
						$smarty->display(CFG_DIR_TPL."forms/register.tpl");
					}
					else
					{
						if ($_POST['haslo'] == $_POST['hasloconfirmation'])
						{
							if ($_POST['email'] == $_POST['emailconfirmation']) {
								// dodawanie usera do bazy
								$time = time();
								$haslo = sha1($_POST['haslo']);
								$query = "INSERT INTO uzytkownicy (login, haslo, email, miejscowosc, zainteresowania) VALUES ('".stripslashes($_POST['login'])."', '".stripslashes($haslo)."', '".stripslashes($_POST['email'])."','".stripslashes($_POST['miejscowosc'])."','".stripslashes($_POST['zainteresowania'])."')"; 
								$q_run = mysql_query($query) or die(mysql_error());
								
								$smarty->assign("confirmreg",1);								
								$smarty->display(CFG_DIR_TPL."forms/register.tpl");
							}
							else
							{
								$smarty->assign("wrong_emails",1);
								$smarty->display(CFG_DIR_TPL."forms/register.tpl");
							}
						}
						else
						{
							$smarty->assign("wrong_passwords",1);
							$smarty->display(CFG_DIR_TPL."forms/register.tpl");
						}
					}
				}
				else
				{
					$smarty->assign("fields",1);
					$smarty->display(CFG_DIR_TPL."forms/register.tpl");
				}
			}
			else{
				// formularz rejestracji
				$smarty->display(CFG_DIR_TPL."forms/register.tpl");
			}
		}
		else
		{
			header("Location:index.php");
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