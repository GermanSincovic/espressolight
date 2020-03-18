<?

global $mysqli;

define("DOMAIN", "http://".$_SERVER['HTTP_HOST']."/");
// vardump($_SERVER);

define("DB_HOST", "192.168.0.102");

define("DB_NAME", "espressolight");

define("DB_USER", "root");

define("DB_PASS", "");

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
class JS_MODEL_LOADER{
	private $root_dir;
	public function __construct(){
		$this -> root_dir = realpath( __DIR__ . '/..');
		$this -> search($this -> root_dir . '/js'); 
	}
	public function search($dir){
		$list = scandir($dir);
		array_splice($list , 0, 2);
		foreach( $list as $value){
			if( !is_dir($dir."/".$value) AND $value != 'main.js' ){
				echo "<script src='".str_replace($this -> root_dir, '..', $dir."/".$value)."'></script>";
			}
		}
		foreach( $list as $value){
			if( is_dir($dir."/".$value) ){
				$this -> search($dir."/".$value);
			}
		}
	}
}

function vardump($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

function debug($e){
	vardump($e);
	die();
}



?>