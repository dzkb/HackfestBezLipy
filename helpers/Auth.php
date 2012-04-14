<?
class Auth {
/*
	Authorisation helper
	Prevents from session hijacking & fixation
*/
	public function authorise() {
		session_start();
		if($_SESSION['login'])
		{
			if($_SESSION['login']==hash("sha512",$_SERVER['REMOTE_ADDR']))
			{
				if(!isset($_SESSION[CFG_SESSION_CHECKSALT])) {
					session_regenerate_id();
					$_SESSION[CFG_SESSION_CHECKSALT] = true;
					$_SESSION[CFG_SESSION_IPSALT] = $_SERVER['REMOTE_ADDR'];
					if($_SESSION[CFG_SESSION_IPSALT] !== $_SERVER['REMOTE_ADDR'])
						die("Session hijacking attempt caught.");
				}
			}
			else
			{
				$this->logout(); // safety exit
				die("No authorisation!<br />Safety logout failed.");
			}
		}
		else die(header("Location:/admin/"));
	}
	
	public function logout() {
			ob_start();
			session_destroy();
			unset($_SESSION['login']);
			unset($_SESSION[CFG_SESSION_CHECKSALT]);
			unset($_SESSION[CFG_SESSION_IPSALT]);
			header("Location:/admin/");
			die("Logging out failure: headers not send.");
			ob_end_flush();
	}
}
?>