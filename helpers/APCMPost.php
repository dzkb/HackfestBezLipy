<?
/*
	APCM-POST
	APCM Variation: works on only *three* params:
		$_POST['_apcm_c'] => class name
		$_POST['_apcm_m'] => method name
		$_POST['_apcm_p'] => argument
		
	This function is very unsecure ATM.
*/

	//	error_reporting(E_ALL); // Due to safety reasons
		
		if($_POST['apcm_c'] && $_POST['apcm_m'] && $_POST['apcm_p'])
		{
		// Loading configuration (external)
			include_once(str_replace($_SERVER['PHP_SELF'], "/admin/", (substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "\\")))))."Config.php");
			$Config=new Config();
			$Config->bootstrap();
		// Preparing variables
			$classname=$_POST['_apcm_c'];
			$methodname=$_POST['_apcm_m'];
			$param=$_POST['_apcm_p'];
		// Loading classfile
			include_once($classname.".php");
		// Calling function
			call_user_func(array($classname,$methodname),$param);
		}
		else
		{
			$res= "APCM-POST class failure. POST not received.";
			echo $res;
		}
?>