<?
class User{
	
	public $role;

	public function __construct(){
		$this -> role = "anonimous";
	}

	public function login(){
		$tmpArr['login'] = $_POST['login'];
		$tmpArr['password'] = md5($_POST['password']);
		$tmpObj = new API("GET", "users", false, $tmpArr);
		$result = $tmpObj -> response;
		$_SESSION['a'] = $result;
		header("Location: ".DOMAIN);
	}

	public function logout(){
		session_start();
		session_destroy();
		global $DB;
		unset($DB);
		header('Location: /');
	}
}
?>