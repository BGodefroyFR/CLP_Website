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

	function checkConnection() {
		session_start();
		if(strcmp(hash('ripemd160', $_SESSION['connexion']), "1df8aecacf101d9da33edca430b32217042213b6") != 0)
		{
			die("<script>location.href = 'index.php'</script>");
		}
	}


?>