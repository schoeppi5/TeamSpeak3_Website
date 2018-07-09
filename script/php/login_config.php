<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(session_id() == '') {
		session_start();
	}

	$pdo = new PDO('mysql:host=localhost;', 'root', '');

	$pdo->exec("USE IF EXISTS teamspeak");
?>
