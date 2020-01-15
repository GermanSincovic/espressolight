<?
class Router{

	public $url;
	public $interface;
	public $component;
	public $subcomponent;

	public function __construct(){
		$this -> url = $_SERVER['REQUEST_URI'];
		$this -> path = preg_replace('/(.+)\/$/','$1',explode("?", $_SERVER['REQUEST_URI'])[0]);
		$this -> get = explode("?", $_SERVER['REQUEST_URI'])[1];
		$tmpstr = preg_split('@/@', $this -> url, NULL, PREG_SPLIT_NO_EMPTY);
		$this -> interface    = $tmpstr[0];
		$this -> component    = $tmpstr[1];
		$this -> subcomponent = $tmpstr[2];
	} 


}

global $Router;
$Router = new Router();
?>