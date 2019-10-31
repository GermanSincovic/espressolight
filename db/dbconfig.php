<?

define("DOMAIN", "http://espressolight.loc/");

function getDbConnect($_serv = null){

	$dbHost = "localhost";
	$dbName = "esspresso";
	$dbUser = "admin";
	$dbPass = "admin";

    $conn = new mysqli($dbHost, $dbUser, $dbPass);
    if ($conn->connect_error) {
       die("Ошибка подключения: " . $conn->connect_error);
    }

    if ($conn->query("CREATE DATABASE espresso") === TRUE) {
       $conn = new mysqli($dbHost, $dbUser, $dbPass);
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }
    }
}




?>