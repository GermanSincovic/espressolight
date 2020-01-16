<?
class Router{

	public function __construct(){
		$this -> path = $_SERVER['REDIRECT_URL'];
		$this -> get = $_GET;
		$tmpstr = preg_split('@/@', $this -> path, NULL, PREG_SPLIT_NO_EMPTY);
		$this -> interface    = $tmpstr[0];
		$this -> component    = $tmpstr[1];
		$this -> subcomponent = $tmpstr[2];
	}
}
?>