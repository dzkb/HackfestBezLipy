<?
/*
	APCM (AJAX to PHP Class->Method) handler
	It works itself, without OOP
*/

	if($_GET['c'] && $_GET['m'])
	{
		error_reporting(E_ALL); // Due to safety reasons
		// Loading configuration (external)
			include_once(str_replace($_SERVER['PHP_SELF'], "/admin/", (substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "\\")))))."Config.php");
			$Config=new Config();
			$Config->bootstrap();
		// Preparing variables
			$classname=$_GET['c'];
			$methodname=$_GET['m'];
			if(isset($_GET['p2']) or isset($_GET['p3']))
				$param[]=$_GET['p'];
			else
				$param=$_GET['p'];
			if(isset($_GET['p2'])){ $param[]=$_GET['p2']; }
			if(isset($_GET['p3'])){ $param[]=$_GET['p3']; }
		// Loading classfile
			include_once($classname.".php");
		// Calling function
			if(is_array($param))
				call_user_func_array(array($classname,$methodname), $param);
			else
				call_user_func(array($classname,$methodname),$param);
	}
?>