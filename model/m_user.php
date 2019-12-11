<?
class User{
	
	public $id;
	public $login;
	public $role;
	public $name;
	public $surname;

	public function __construct(){
		$this -> role = "anonimous";
		$_SESSION["auth"] = $this;
	}

	public function login(){
		$tmpArr['login'] = $_POST['login'];
		$tmpArr['password'] = md5($_POST['password']);
		$tmpObj = new API("GET", "users", false, $tmpArr);
		$result = $tmpObj -> response;
		if (count($result) == 1) {
			$this -> id = $result[1]['id'];
			$this -> login = $result[1]['login'];
			$this -> role = $result[1]['role'];
			$this -> name = $result[1]['name'];
			$this -> surname = $result[1]['surname'];
		}
		$_SESSION["auth"] = $this;
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