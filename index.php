<?

session_start();

require_once("model/config.php");

new MODEL_LOADER();

$Router = new Router();
$Auth = new Auth();

if($Router -> interface == 'api'){

	$API = new API();

} else {

	if ( $Auth -> isAnonimous() ) {

		require_once('view/v_login.php');
		
	} else {

		if ( $Router -> interface == $_SESSION["auth"]["role"] ) {
			require_once('view/v_main.php');
		} else {
			header('Location: '.DOMAIN.$_SESSION["auth"]["role"]);
		}

	}

}


?>