<?
namespace controller;

use model\API\API;
use model\API\API_Response;

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

    public function callEndpoint(){

        switch ( [ $this -> urlPattern, $_SERVER['REQUEST_METHOD'] ] ){

            case ["api/v1/auth/login", "POST"] : (new API_Auth) -> login(); break;
            case ["api/v1/auth/logout", "POST"]: (new API_Auth) -> logout(); break;
            case ["api/v1/auth/current", "GET"]: (new API_Auth) -> getLoggedInUserData(); break;

            case ["api/v1/users", "GET"]: (new UserController) -> getUserList(); break;
            case ["api/v1/users/{id}", "GET"] : (new UserController) -> getUser((new Router) -> varsPath[3]); break;
            case ["api/v1/users", "PUT"] : (new UserController) -> createUser((new API)->body); break;
            case ["api/v1/users/{id}", "POST"] : (new UserController) -> updateUser((new Router) -> varsPath[3], (new API)->body); break;
            case ["api/v1/users/{id}", "DELETE"] : (new UserController) -> deleteUser((new Router) -> varsPath[3]); break;

            case ["api/v1/accounts", "GET" ]: (new API_Accounts) -> getAccountList(); break;
            case ["api/v1/accounts/{id}", "GET" ]: (new API_Accounts) -> getAccount(); break;
            case ["api/v1/accounts", "PUT" ]: (new API_Accounts) -> createAccount(); break;
            case ["api/v1/accounts/{id}", "POST" ]: (new API_Accounts) -> updateAccount(); break;
            case ["api/v1/accounts/{id}", "DELETE" ]: (new API_Accounts) -> deleteAccount(); break;

            default : new API_Response(400, [ 'message' => 'Check URL or Method'] );  break;
        }
    }

    public function redirect($path){
        header("Location: ".DOMAIN.$path);
    }

}