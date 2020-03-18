<?
class Router{

    public $endpointPattern = '';

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

    public function getAPIEndpointPattern($url){
        $e = $url;

        if($e == "/api/v1/auth/login" || $e == "/api/v1/auth/logout"){ return $e; }

        $e = explode("?", $e)[0];
        $e = explode("/", $e);
        if(preg_match("/\D/", $e[3]) > 0){
            return false;
        }
        $ending = preg_match("/^\d+$/", $e[3]) > 0 ? "/{id}" : "" ;
        return "/".$e[1]."/".$e[2].$ending;
    }

}