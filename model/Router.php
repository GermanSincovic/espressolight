<?

class Router{

    public $urlPattern;
    public $url;
    public $path;
    public $varsGet;
    public $varsPath;

    public function __construct(){
        $parsedUrl = Parser::parseUrl();
        $this -> url = $parsedUrl['url'];
        $this -> path = $parsedUrl['path'];
        $this -> varsGet = $parsedUrl['varsGet'];
        $this -> varsPath = $parsedUrl['varsPath'];
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
            case "/api/v1/auth/login" : (new API_Auth) -> login(); break;
            case "/api/v1/auth/logout" : (new API_Auth) -> logout(); break;
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