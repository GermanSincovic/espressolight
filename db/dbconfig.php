<?

define("DOMAIN", "http://espressolight.loc/");

function getDbConnect($_serv = null){

	$dbHost = "localhost";
	$dbName = "espresso";
	$dbUser = "admin";
	$dbPass = "admin";

    $mysqli = new mysqli($dbHost, $dbUser, $dbPass);

    try {

        $mysqli->query("CREATE DATABASE espresso");

    } finally {

        $mysqli->select_db("espresso");
        
    }



    // $mysqli->query("CREATE TABLE `clients` (
    //                  `id` INT NOT NULL AUTO_INCREMENT,
    //                  `name` VARCHAR(250) NOT NULL,
    //                  `created` TIMESTAMP NOT NULL,
    //                  `active` TINYINT(1) NOT NULL,
    //                  `phone` VARCHAR(50) NOT NULL,
    //                  `email` VARCHAR(50) NOT NULL,
    //                  `owner` VARCHAR(250) NOT NULL,
    //                  PRIMARY KEY (`id`) )
    //                  COLLATE='utf8_general_ci';");
    // vardump($mysqli);

}



        // mysqli_query("CREATE DATABASE espresso");
        // mysqli_select_db($dbName, $con);
        // mysqli_query("CREATE TABLE `espresso.clients` (
        //             `id` INT NOT NULL AUTO_INCREMENT,
        //             `name` VARCHAR(250) NOT NULL,
        //             `created` TIMESTAMP NOT NULL,
        //             `active` TINYINT(1) NOT NULL,
        //             `phone` VARCHAR(50) NOT NULL,
        //             `email` VARCHAR(50) NOT NULL,
        //             `owner` VARCHAR(250) NOT NULL,
        //             PRIMARY KEY (`id`) )
        //             COLLATE='utf8_general_ci';");

?>