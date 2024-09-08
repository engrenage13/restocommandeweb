<?php
function connectToDB()
	{
	global $connexion;
	$connexion = mysqli_connect('localhost', 'root', '', 'restocommande');
	mysqli_set_charset($connexion, 'utf8');
}

connectToDB(); 
?>