<?
	// KLASA DO ZMIENNYCH GLOBALNYCH
	// Jan jwitos Witowski
class GlobalsHandler extends Config {
	public $add=array();
	public $remove=array();
	public $_TEMPGET=array();
	public $call=array();
	
	public function __construct()
	{
		$this->globalsToTempGlobals();
	}
	
	/*--- Nie mozemy operowac na zwyklych globalnych
	dlatego przepisujemy globale na temp_globals ---*/
	public function globalsToTempGlobals()
	{
		if($this->_TEMPGET)
			unset($this->_TEMPGET);
		foreach($_GET as $key=>$value)
			$this->_TEMPGET[$key]=$value;
		return $this->_TEMPGET;
	}
	
	/*--- Glowna metoda ---*/
	public function urlAddRemove($add=false,$remove=false,$dumpTemps=false)
	{
		if($remove)
			if(is_array($remove))
				foreach($remove as $removal) { unset($this->_TEMPGET[$removal]); }
			else
				unset($this->_TEMPGET[$remove]);
		if($add)
		{
			if(is_array($add))
				foreach ($add as $key=>$adding)
					$this->addGlobal($adding);
			else
				$this->addGlobal($add);
		}
		
		if($dumpTemps==false)
			return $this->urlReturn();
		else
			return $this->urlReturn(true);
	}
	
	/*--- Dodawanie zmiennej globalnej ---*/
	public function addGlobal($call,$dumpTemps=false)
	{
		if(is_array($call))
		{
			foreach($call as $key=>$_call)
			{
				$_call=explode("=",$_call);
				$this->_call=$_call;
				if($this->_TEMPGET[$_call[0]]) // Jesli juz jest taka globalna to usuwamy stara na wszelki wypadek
					unset($this->_TEMPGET[$_call[0]]);
				$this->_TEMPGET[$_call[0]]=$_call[1];
			}
		}
		else
		{
			$call=explode("=",$call);
			$this->call=$call;
			
			if($this->_TEMPGET[$call[0]])
				unset($this->_TEMPGET[$call[0]]);
			$this->_TEMPGET[$call[0]]=$call[1];
		}
		
		if($dumpTemps==false)
			return $this->urlReturn();
		else
			return $this->urlReturn(true);
	}
	
	/*--- Usuwanie zmiennej globalnej ---*/
	public function removeGlobal($call)
	{
		unset($this->_TEMPGET[$call]);	
		return $this->urlReturn();
	}
	
	/*--- Usuwanie roznych niepotrzebnych gowien ---*/
	public function removeTemporaries()
	{
		$base=array('add_type');
		// to wyzej to tablica wewnetrznych GETow ktore wypieprzam bo sa niepotrzebne
		// przy przepsiywaniu linkow
		// dopisac nastepne gdy potrzeba
		
		foreach($base as $item)
		{
			if($this->call[0]=='action' && $item=='action')
				false;
			else
				unset($this->_TEMPGET[$item]);
		}
	}
	
	/*--- Reczne zwracanie zmiennych globalnych ---*/
	public function urlReturn($dumpTemps=false)
	{
		if($dumpTemps==false)
			$this->removeTemporaries();
		else false;
		
		if($this->_TEMPGET)
			$saver='?'.http_build_query($this->_TEMPGET);
		else
			$saver=false;
		
		$this->globalsToTempGlobals(); // flushujemy $_TEMPGET
		return $saver;
	}
	
	// nie bedziemy tego pewnie uzywac w projekcie
	public function SAD()
	{
		if($_GET['s_type']=='asc')
			return 'desc';
		else
			return 'asc';
	}
}
?>