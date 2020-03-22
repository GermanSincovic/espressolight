<?

class Router{

    public $urlPattern;
    public $url;
    public $path;
    public $varsGet;
    public $varsPath;

    public function __construct(){
        $this -> parseUrl();

        if($this -> isAPI()){
            $this -> callEndpoint();
        }
    }

    public function parseUrl(){
        $this -> url = $_SERVER['REQUEST_URI'];
        $tmp = explode("?", $this -> url);
        $this -> path = $tmp[0];
        $this -> varsPath = preg_split('@/@', $this -> path, NULL, PREG_SPLIT_NO_EMPTY);
        parse_str($tmp[1], $this -> varsGet);
        $this -> urlPattern = $this -> getAPIEndpointPattern();
    }
    public function isAPI(){
        return ($this -> varsPath[0] == 'api' ? true : false);
    }

    public function getAPIEndpointPattern(){
        return preg_replace('/(\/)(\d+)(?=(\/|$))/', '$1{id}', $this -> path);
    }

    private function callEndpoint(){
        switch ($this -> urlPattern){
            case "/api/auth/login" : new API_Auth('login'); break;
            case "/api/auth/logout" : new API_Auth('logout'); break;
//            case "/api/users" : ; break;
//            case "/api/users/{id}" : ; break;
            default : ;
        }
    }

}