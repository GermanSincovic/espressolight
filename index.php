<?

session_start();

require_once("model/config.php");

new MODEL_LOADER();

$Router = new Router();

if( $Router -> isAPI() ) {
    $Router -> callEndpoint();
} else {
    if( API_Auth::isLoggedIn() ){
        $Router -> showPage('main');
    } else {
        if($Router -> urlPattern == '/login'){
            $Router -> showPage('login');
        } elseif ($Router -> urlPattern == '/logout'){
            API_Auth::logout();
            header("Location: ".DOMAIN.'/login');
        } else {
            $Router -> redirect('login');
        }
    }
}