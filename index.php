<?

session_start();

require_once("model/config.php");

load_models();

if($Router -> interface == 'api'){

	$API = new API();

} else {

	include('view/v_control_panel.php');

}


?>