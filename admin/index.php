<?

session_start();

if($_POST['password']){

	$_SESSION['password'] = md5($_POST['password']);

}

if($_SESSION['password'] == md5('admin')){

	require_once('db/dbmodels.php');

	getDbConnect();

	include_once('admin/v_control_panel.php');

} else {

	include_once('admin/v_login.php');

}

?>