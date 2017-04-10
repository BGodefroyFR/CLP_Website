<?php
	if(strcmp(hash('ripemd160', $_POST['mdp']), "1df8aecacf101d9da33edca430b32217042213b6") == 0)
	{
		session_start(); 
		$_SESSION['connexion'] = $_POST['mdp'];
		die("<script>location.href = 'homepage.php'</script>");
	}
	else
	{
		die("<script>location.href = 'index.php?err=1'</script>");
	}
?>