<?	// Predefiniowanie: Start sesji, include/require, sprawdzenie cookies, setlocale, start klas
	include_once('Config.php');
	$_Config=new Config();
	$_Config->bootstrap();
	$_Globals=new GlobalsHandler();

// Funkcje lokalne mogą się przydać
function sortujAscDesc($sortby)
{
	global $ascdesc, $ascdesc_;
	if(($_GET['sort'] && $_GET['s_type']) && $_GET['sort']==$sortby)
	{
		if($_GET['s_type']=='asc')
		{
			$ascdesc='desc';
			$ascdesc_="malejąco";
		}
		else
		{
			$ascdesc='asc';
			$ascdesc_="rosnąco";
		}
	}
	else
	{
		$ascdesc='asc';
		$ascdesc_="rosnąco";
	}
}

function zmienGet($doZmiany,$dodaj)
{ // Dopisywanie i usuwanie z get
	global $line;
	$x=0;
		if($_GET)
		{
			foreach($_GET as $key=>$row)
			{
				if($doZmiany!==$key && "default"!==$key && "id"!==$key && "status"!==$key)
				{
						if($x==0)
						{
							$line='?'.$key.'='.$row;
							$x++;
						}
						else
						{
							$line=$line.'&'.$key.'='.$row;
						}
				}
				else
				{
					if($key=="default")
					{
						$line='?'.$dodaj;
						$x++;
					}
					elseif($doZmiany==$key && $doZmiany!==$dodaj)
					{
						if($x==0)
						{
							$line='?'.$dodaj;
							$x++;
						}
						else
						{
							$line=$line.'&'.$dodaj;
						}
					}
				}	
			}
			if(!$_GET['dodaj'] && $key!=="default")
			{
				if($x==0)
				{
					$line='?'.$dodaj;
					$x++;
				}
				else
				{
					$line=$line.'&'.$dodaj;
				}
			}
		}
		else
		{
			$line='?'.$dodaj;
		}
}
function przepiszGetDoHidden()
{
	if($_GET)
	{
		foreach($_GET as $key=>$value)
		{
			if($key!=='date_picked' && $key!=='id' && $key!=='wysylka_kalendarz' && $key!=='wysylka_kalendarz_end')
				$_GETstring.='<input type="hidden" name="'.$key.'" value="'.$value.'" />';
		}
		return $_GETstring;
	}
	else return false;
	
}
// Funkcje koniec
/* assigning some vars */
$_VH = new ViewHelpers();

/*
	Route assigning controller
	WHERE THE FUN TAKES PLACE :)))
	główny kontroler
*/

$_VH->naviController('start');

/*
if($_GET['action'])
{
	if($_GET['action']=='kierunki')
	{
		$_Kierunki = new Kierunki();
	}elseif ($_GET['action']=='ksiazki'){
	
	}elseif ($_GET['action']=='progi'){
	
	}elseif ($_GET['action']=='typer'){
	
	}else{
	
		$_HomePage = new HomePage();
	}
}
else
{
	$_HomePage = new HomePage();
}
*/

if($_GET['action']) {
	switch ($_GET['action']) {
		case "kierunki": $_Kierunki = new Kierunki();
						 break;
		case "ksiazki":  $_Ksiazki = new Ksiazki();
						 break;
		case "progi": 	 $_Progi = new Progi();
						 break;
		case "typer": 	 $_Typer = new Typer();
						 break;
		case "user": 	 $_User = new User();
						 break;
		default: 		 $_HomePage = new HomePage();
	}
}else{
	$_HomePage = new HomePage();
}

$_VH->naviController('end');

echo '</div></div><div id="clb"></div>';
?>