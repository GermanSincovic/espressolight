<?
class DB_connection extends mysqli {

	public function __construct(){
	    parent::__construct(DB_HOST, DB_USER, DB_PASS);
		$this -> select_db(DB_NAME);
		if($this -> errno) {
            // Set default DB Schema if not exists
            try {
                $this -> multi_query(file_get_contents('defaults/default_db.sql'));
            } finally {
                $this -> select_db(DB_NAME);
            }

        }
	}
}

//global $DB_connection;
//$DB_connection = new DB_connection();