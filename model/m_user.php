<?
class User{
	
	public $role;

	public function __construct(){
		$this -> role = "anonimous";
	}

	public function login(){
		echo "login";
	}

	public function logout(){
		echo "logout";
	}
}
?>