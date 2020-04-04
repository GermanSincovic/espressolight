<?

define("DOMAIN", "http://".$_SERVER['HTTP_HOST']."/");

define("DB_HOST", "localhost");

define("DB_NAME", "espressolight");

define("DB_USER", "admin");

define("DB_PASS", "admin");

define("SALT", "cf0665bea84");

class MODEL_LOADER{
	public function __construct(){
		$this -> search(__DIR__);
	}
	public function search($dir){
		$list = scandir($dir);
		array_splice($list , 0, 2);
		foreach( $list as $value){
			if( !is_dir($dir."\\".$value) AND $value != 'config.php' ){
				require_once($dir."\\".$value);
			}
		}
		foreach( $list as $value){
			if( is_dir($dir."\\".$value) AND $value != 'config.php' ){
				$this -> search($dir."\\".$value);
			}
		}
	}
}