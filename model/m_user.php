<?
class User{
	
	public function __construct(){
		if(!$_SESSION["auth"]){
			$_SESSION["auth"]["role"] = "anonimous";
		}
	}

	public function login(){
		$tmpArr['login'] = $_POST['login'];
		$tmpArr['password'] = md5($_POST['password']);
		$tmpObj = new API("GET", "users", false, $tmpArr);
		$result = $tmpObj -> response;
		unset($result['password']);
		unset($result['photo']);
		if (count($result) == 1) {
			$_SESSION["auth"] = $result[1];
		}
		header('Location: '.DOMAIN);
	}

	public function logout(){
		session_start();
		session_destroy();
		global $DB;
		unset($DB);
		header('Location: '.DOMAIN);
	}
}
?>