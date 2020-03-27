<?
class DB_connection{

	public $db_link;

	public function __construct(){
		$this -> db_link = new mysqli(DB_HOST, DB_USER, DB_PASS);
		$this -> db_link -> select_db(DB_NAME);
		if($this -> db_link -> errno){

            // Set default DB if not exists
            try {
                $this -> db_link -> multi_query(file_get_contents('defaults/default_db.sql'));
            } finally {
                $this -> db_link -> select_db(DB_NAME);
		    }

		}

	}

}

global $DB_connection;
$DB_connection = new DB_connection();
$DB_connection =  $DB_connection -> db_link;