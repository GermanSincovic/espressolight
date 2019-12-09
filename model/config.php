<?

global $mysqli;

define("DOMAIN", "http://espressolight.loc/");

define("DB_HOST", "localhost");

define("DB_NAME", "espresso");

define("DB_USER", "admin");

define("DB_PASS", "admin");

// loading all classes (all files by mask m_*.php)
function load_models(){
	$files = scandir(__DIR__);
	foreach ($files as $value) {
		if(preg_match("/^m_(.+).php/i",$value)){
			require_once($value);
		}
	}
}

function vardump($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

?>