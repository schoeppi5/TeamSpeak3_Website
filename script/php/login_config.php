<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(session_id() == '') {
		session_start();
	}
	if(isset($_COOKIE['userID']) && !empty($_COOKIE['userID']))
	{
		$_SESSION['userID'] = $_COOKIE['userID'];
	}
	$pdo = new PDO('mysql:host=localhost;dbname=user', 'root', '');
?>