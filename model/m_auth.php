<?
class Auth{
	
	public function __construct(){
		if(!$_SESSION["auth"]){
			$_SESSION["auth"]["role"] = "anonimous";
		}
	}

	public function isMaster(){
		return $_SESSION["auth"]["role"] == "master";
	}

	public function isAdmin(){
		return $_SESSION["auth"]["role"] == "admin";
	}

	public function isEmployee(){
		return $_SESSION["auth"]["role"] == "employee";
	}

	public function isAnonimous(){
		return $_SESSION["auth"]["role"] == "anonimous";
	}
	
}
?>