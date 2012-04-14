<?
	/*
		Generuje haslo roota
		nie pamietam o co juz w tym chodiz
	*/
	$salt=time();
	
	define("LOGIN","wpisujesz login");
	define("PASSWORD","wpisujesz has³o");

	echo 'Salt: '.$salt.'<br />';
	echo 'Hash method: md5<br />';
	$passsalt=md5(PASSWORD.$salt);
	echo 'Login: '. LOGIN .'<br />';
	echo 'Clean pass: '. PASSWORD .'<br/>';
	echo 'Salty pass: '.$passsalt.'<br />';	
	echo 'Choose major priviledge: ROOT, EMPL<br /><br />';
	
	echo 'Generating time: '.(time()-$salt);
?>