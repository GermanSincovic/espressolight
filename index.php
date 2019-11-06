<?

session_start();

require_once("model/config.php");

load_models();

$DB = new DB_connection();
var_dump($DB);
$DB -> close();


?>