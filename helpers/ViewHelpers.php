<?
class ViewHelpers extends Config {
/*
	Argument [$ctrl] given in some methods below is send from main
	(index) controller. It gives viewNavigation information which variables
	should it assign to Smarty templates. (because of the navigation
	bar).
*/

	/*--- Assigns variables and runs index template ---*/
	public function naviController($ctrl) {
		global $smarty;
		$this->prepareVars($ctrl);
		if($ctrl=="start")
			$smarty->display('index_top.tpl');
		elseif($ctrl=="end")
			$smarty->display('index_bot.tpl');
		
	}
	/*--- Assigns variables ---*/
	protected function prepareVars($ctrl) {
		$this->viewHeader();
		$this->viewNavigation($ctrl);
	}
	/*--- Sets variables for *header* ---*/
	public function viewHeader()
	{
		global $smarty;
		$smarty->assign('pagetitle', CFG_PAGETITLE);
		$smarty->assign('charset', CFG_CHARSET);
		$smarty->assign('end_session_href', '?action=helpers&component=Auth&method=logout');
		$smarty->assign('index_href', CFG_FILENAME);
	}
	
	/*--- Assigns variables for *navigation* ---*/
	public function viewNavigation($ctrl)
	{
		global $smarty;
		$_Globals = new GlobalsHandler();
		
		$smarty->assign('ctrl',$ctrl);
		/* Menu links below */
		// o a tak mozna zrobic nawigacje jak ponizej (wlasciwie to same linki - odniesienia do kontrolerow)
		/*
		$smarty->assign('navi_szukaj_href',$_Globals->addGlobal('action=find'));
		$smarty->assign('navi_dodaj_href',$_Globals->addGlobal('action=add'));
		$smarty->assign('navi_ksiegarnie_href',$_Globals->addGlobal('action=stores'));
		$smarty->assign('navi_magazyn_href',$_Globals->addGlobal('action=resources'));
		$smarty->assign('navi_hr_href',$_Globals->addglobal('action=hr'));*/
	}
}
?>