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

?>