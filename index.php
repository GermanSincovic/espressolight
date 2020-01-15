<?

session_start();

require_once("model/config.php");

new MODEL_LOADER();

$Auth = new Auth();

$query = new QUERY();
$query -> setAction('select');
$query -> setSelector(['a','b','c']);
$query -> setTable('table');
vardump($query->assembly());

die();

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