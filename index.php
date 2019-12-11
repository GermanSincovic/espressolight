<?

session_start();

require_once("model/config.php");

load_models();

if($Router -> interface == 'api'){

	if( !$_POST['login'] && !$_POST['logout'] ){ $API = new API(); }

} else {

	// USER MODEL
	// UNDER CONSTRUCTION
	if( !$User ){ $User = new User(); }
	if( $_POST['login']  ){ $User ->  login(); }
	if( $_POST['logout'] ){ $User -> logout(); }

	switch ($_SESSION["auth"] -> role) {
		case 'anonimous': include('view/v_login.php'); break;
		case 'master': var_dump("master"); break;
		case 'admin': var_dump("admin"); break;
	}
	// var_dump($_SESSION);
}


?>