<?php
	session_start(); 
	session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body style="margin-left: 15px; margin-top: 10px;">
  	 	<p style = "margin-bottom: 6px;">Mot de passe ?</p>
  	 	<form style="margin-top: -30px;" method="post" action="validationMdp.php">
			<input type="password" name="mdp" autofocus required>
		    <input type="submit" value="Valider" style="margin-top: 30px;"/>
        </form>
        <?php
        	if(isset($_GET['err']))
        	{
        		echo "<p style = 'margin-bottom: 6px; color: #E87B03;'>Mot de passe non valide</p>";
        	} 
        ?>
    </body>
</html>