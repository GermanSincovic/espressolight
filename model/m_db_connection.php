<?

class DB_connection{

	public $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);

	public function __construct(){

		$this -> mysqli -> select_db(DB_NAME);

		if($this -> mysqli -> errno){
			try {
		        $this -> mysqli -> query("CREATE DATABASE ".DB_NAME);
		    } finally {
		        $this -> mysqli -> select_db(DB_NAME);
		    }
		}

		return $mysqli;

	}

	public function close(){
		$this -> mysqli -> close();
	}

}

?>