<?

session_start();

require_once("model/config.php");

new MODEL_LOADER();

$Parser = new Parser();
$Router = new Router();
debug($DB_connection);
$Auth = new Auth();

if($Router -> interface == 'api'){

	new API();

} else {

	if ( $Auth -> isAnonimous() ) {

		require_once('view/v_login.php');
		
	} else {

		if ( $Router -> interface != $Auth -> getRole() ) {

			header('Location: '.DOMAIN.$Auth -> getRole());

		} else {

			require_once('view/v_main.php');
			
		}

	}

}


?>