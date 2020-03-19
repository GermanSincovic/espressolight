<?
class Router{

    public $APIEndpointPattern = false;

    private $url;
    private $varsGet;
    private $path;
    private $varsPath;

    public function __construct(){
        $this -> url = $_SERVER['REQUEST_URI'];
        $tmp = explode("?", $this -> url);
        $this -> path = $tmp[0];
        $this -> varsPath = preg_split('@/@', $this -> path, NULL, PREG_SPLIT_NO_EMPTY);
        parse_str($tmp[1], $this -> varsGet);
        if($this -> isAPI()){
            $this -> APIEndpointPattern = $this -> getAPIEndpointPattern();
        }
    }

    public function isAPI(){
        return ($this -> varsPath[0] == 'api' ? true : false);
    }

    public function getAPIEndpointPattern(){
        return preg_replace('/(\/)(\d+)(?=(\/|$))/', '{id}', $this -> path);
    }

}