<?
class DB_connection{

	public $db_link;

	public function __construct(){
		$this -> db_link = new mysqli(DB_HOST, DB_USER, DB_PASS);
		$this -> db_link -> select_db(DB_NAME);
		if($this -> db_link -> errno){
			try {
		        $this -> db_link -> query("CREATE DATABASE ".DB_NAME);
		    } finally {
		        $this -> db_link -> select_db(DB_NAME);
		    }
		}
		return $this -> db_link;
	}

}

global $DB_connection;
$DB_connection = new DB_connection();