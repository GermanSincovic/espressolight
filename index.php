<?

session_start();

require_once("model/config.php");

new MODEL_LOADER();

$Parser = new PARSER();
$Router = new Router();
$Auth = new Auth();

if($Router -> interface == 'api'){

	new API();

} else {

	if ( $Auth -> isAnonimous() ) {

		require_once('view/v_login.php');
		
	} else {
		// debug($_SESSION);
		if ( $Router -> interface == $Auth -> getRole() ) {
			require_once('view/v_main.php');
		} else {
			header('Location: '.DOMAIN.$Auth -> getRole());
		}

	}

}


?>