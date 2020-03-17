<?
class DB_connection{

	public $db_link;

	public function __construct($obj){
		$this -> db_link = $obj;
		$this -> db_link -> select_db(DB_NAME);
		if($this -> db_link -> errno){
			try {
		        $this -> db_link -> query("CREATE DATABASE ".DB_NAME);
		    } finally {
		        $this -> db_link -> select_db(DB_NAME);
		    }
		}
	}
	
}

global $DB;
$DB = new DB_connection(new mysqli(DB_HOST, DB_USER, DB_PASS));
$DB = $DB -> db_link;