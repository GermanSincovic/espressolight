<?
	session_start();
	session_destroy();
	unset($msqli);
	header('Location: /');
?>