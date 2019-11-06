<?

session_start();

require_once("model/config.php");

load_models();

$DB = new DB_connection(new mysqli(DB_HOST, DB_USER, DB_PASS));
$DB = $DB -> db_link;
vardump($DB);


?>