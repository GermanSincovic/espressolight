<?
class Auth{
	
	public function __construct(){
		if(!$_SESSION["auth"]){
			$_SESSION["auth"]["role"] = "anonimous";
		}
	}

	public function getRole(){
		return $_SESSION["auth"]["role"];
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

	public function getCompanyLimitation(){
		return $_SESSION["auth"]["company"];
	}

	public function getName(){
		return (!$this -> isAnonimous()) ? $_SESSION['auth']['name'].' '.$_SESSION['auth']['surname'] : '' ;
	}

	public function getId(){
		return (!$this -> isAnonimous()) ? $_SESSION['auth']['id'] : null ;
	}
	
}
?>