<?

session_start();

require_once("model/config.php");

load_models();

if($Router -> interface == 'api'){

	$API = new API();

} else {

	// USER MODEL
	// UNDER CONSTRUCTION
	if( !$User ){ $User = new User(); }
	if( $_POST['login']  ){ $User ->  login(); }
	if( $_POST['logout'] ){ $User -> logout(); }
	if( $User -> role == 'anonimous'){
		include('view/v_login.php');
	}
	// 
}


?>