<?

define("DOMAIN", "http://espressolight.loc/");

function getDbConnect($_serv = null){

	$dbHost = "localhost";
	$dbName = "espresso";
	$dbUser = "admin";
	$dbPass = "admin";

    $con = mysql_connect($dbHost, $dbUser, $dbPass);
    if( false  ===  $con){
        print_r('Connection failed');
        return false;
    }
    
    mysql_query("SET NAMES 'utf8';", $con);
    mysql_query("SET CHARACTER SET 'utf8';", $con);
    mysql_query("set character_set_client='utf8'", $con);
    mysql_query("set character_set_results='utf8'", $con);
    mysql_query("set collation_connection='utf8_general_ci'", $con);

    if(mysql_select_db($dbName, $con)){
        return $con;
    }else{
        var_dump(mysql_query("CREATE DATABASE espresso"));
        var_dump(mysql_select_db($dbName, $con));
        var_dump(mysql_query("CREATE TABLE `clients` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(250) NOT NULL,
                    `created` TIMESTAMP NOT NULL,
                    `active` TINYINT(1) NOT NULL,
                    `phone` VARCHAR(50) NOT NULL,
                    `email` VARCHAR(50) NOT NULL,
                    `owner` VARCHAR(250) NOT NULL,
                    PRIMARY KEY (`id`) )
                    COLLATE='utf8_general_ci';"));
    }

}


?>