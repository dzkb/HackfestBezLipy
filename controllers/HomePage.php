<?
class HomePage extends GlobalsHandler {
	public function __construct()
	{
		$this->controller();
	}
	
	public function widokHomePage() {
		$smarty = new Smarty();
		$smarty->display(CFG_DIR_TPL.'homepage.tpl');
		
	}
	
	public function controller() {
		$this->widokHomePage();
	}
}
?>