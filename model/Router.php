<?

class Router{

    public $urlPattern;
    public $url;
    public $path;
    public $varsGet;
    public $varsPath;

    public function __construct(){
        $this -> parseUrl();
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

    public function callEndpoint(){
        switch ($this -> urlPattern){
            case "/api/v1/auth/login" : $m = new API_Auth(); $m -> login(); break;
            case "/api/v1/auth/logout" : API_Auth::logout(); break;
//            case "/api/users" : ; break;
//            case "/api/users/{id}" : ; break;
            default : ;
        }
    }

    public function showPage($page){
        require_once('view/v_'.$page.'.php');
    }

    public function redirect($path){
        header("Location: ".DOMAIN.$path);
    }

}