<?
session_start();
require_once("model/config.php");
load_models();

if($Router -> interface == 'api'){

	$API = new API();

} else {

	// USER
	$User = new User();

	if( $_POST['login'] ){ $User -> login(); }

	if ( $_SESSION["auth"]["role"] == 'anonimous' ) {

		require_once('view/v_login.php');
		
	} else {

		if ( $Router -> interface == $_SESSION["auth"]["role"] ) {
			require_once('view/v_main.php');
		} else {
			header('Location: '.DOMAIN.$_SESSION["auth"]["role"]);
		}

	}

	if( $_POST['logout'] ){ $User -> logout(); }

}


	// Eof USER

	// var_dump($_SESSION);

?>