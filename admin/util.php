<?php
function connectBDD() {
	try
	{
		$bdd = new PDO('mysql:host=localhost; dbname=scenesenmailer; charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	return $bdd;
}
?>