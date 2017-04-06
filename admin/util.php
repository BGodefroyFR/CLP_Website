<?php
	function executeQuery($q) {
		$bdd = connectBDD();
		return $bdd->query($q);
	}

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

	function getIdFromPath($path) {
		$pos = strrpos($path, '/');
		if ($pos == -1)
			return $path;
		return substr($path, $pos+1);
	}

	// Boolean to Int
	function booltoInt($b) {
		return (strcmp($b, 'true') == 0 ? 1 : 0);
	}


?>