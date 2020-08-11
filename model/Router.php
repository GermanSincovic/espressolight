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
        $this -> urlPattern = $parsedUrl['urlPattern'];
    }

    public function isAPI(){
        return ($this -> varsPath[0] == 'api' ? true : false);
    }

    public function callEndpoint(){

        switch ( [ $this -> urlPattern, $_SERVER['REQUEST_METHOD'] ] ){

            case ["api/v1/auth/login", "POST"] : (new API_Auth) -> login(); break;
            case ["api/v1/auth/logout", "POST"]: (new API_Auth) -> logout(); break;
            case ["api/v1/auth/current", "GET"]: (new API_Auth) -> getLoggedInUserData(); break;

            case ["api/v1/users", "GET"]: (new API_Users) -> getUserList(); break;
            case ["api/v1/users/{id}", "GET"] : (new API_Users) -> getUser(); break;
            case ["api/v1/users", "PUT"] : (new API_Users) -> createUser(); break;
            case ["api/v1/users/{id}", "POST"] : (new API_Users) -> updateUser(); break;
            case ["api/v1/users/{id}", "DELETE"] : (new API_Users) -> deleteUser(); break;

            case ["api/v1/accounts", "GET" ]: (new API_Accounts) -> getAccountList(); break;
            case ["api/v1/accounts/{id}", "GET" ]: (new API_Accounts) -> getAccount(); break;
            case ["api/v1/accounts", "PUT" ]: (new API_Accounts) -> createAccount(); break;
            case ["api/v1/accounts/{id}", "POST" ]: (new API_Accounts) -> updateAccount(); break;
            case ["api/v1/accounts/{id}", "DELETE" ]: (new API_Accounts) -> deleteAccount(); break;

            default : new API_Response(400, [ 'message' => 'Check URL or Method'] );  break;
        }
    }

    public function showPage($page){
        require_once("view/v_".$page.".php");
    }

    public function redirect($path){
        header("Location: ".DOMAIN.$path);
    }

}