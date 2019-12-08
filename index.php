<?

session_start();

require_once("model/config.php");

load_models();

if($Router -> interface == 'api'){
	$API = new API();
	// vardump($API);
}


?>