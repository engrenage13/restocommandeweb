<?php
function connectToDB() {
	global $connexion;
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$connexion = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_DATABASE'], $_ENV['DB_PORT']);

	if (!$connexion) {
		die("La connexion a échouée : ".mysqli_connect_error());
	}

	mysqli_set_charset($connexion, 'utf8');
}

connectToDB(); 
?>