<?
class Router{

    private $url;
    private $varsGet;
    private $varsPath;

    public function __construct(){
        $this -> url = $_SERVER['REQUEST_URI'];
        $this -> parseUrl();
    }

    private function parseUrl(){
        $tmp = explode("?", $this -> url);
        $this -> varsPath = preg_split('@/@', $tmp[0], NULL, PREG_SPLIT_NO_EMPTY);
        parse_str($tmp[1], $this -> varsGet);
    }

}