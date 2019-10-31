<?
require_once('dbconfig.php');
				
				
function vardump($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

function db_custom_query($q){
	getDbConnect();
	$result = mysql_query($q) or die('db_custom_query'.mysql_error());
	return $result;	
}
?>