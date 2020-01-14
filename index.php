<?

session_start();

require_once("model/config.php");

load_models();
	
$Auth = new Auth();

if($Router -> interface == 'api'){

	$API = new API();

} else {

		// vardump($_SESSION);
	if ( $Auth -> isAnonimous() == 'anonimous' ) {

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