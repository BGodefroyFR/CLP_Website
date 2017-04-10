<?php
	// Upload script for Ckeditor
	include '../util.php';
	include '../model/Elem.php';
	include '../model/Upload.php';

	if (file_exists("../../images/textImages/" . $_FILES["upload"]["name"]))
	{
		echo $_FILES["upload"]["name"] . " existe deja. ";
	}
	else
	{
		$id = rand(1,1e9) . '.' . pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
		if (move_uploaded_file($_FILES["upload"]["tmp_name"],"../../images/textImages/" . $id)) {

			$newUpload = new Upload();
			$newUpload->createFromForm("images/textImages/" . $id, $_FILES["upload"]["name"]);
			$newUpload->isTextEmbeded = 1;
			executeQuery($newUpload->toSQL());

			echo "Image uploadée";

		 	$funcNum = $_GET['CKEditorFuncNum'] ;
			$url = "../../images/textImages/" . $id;
			$message = 'Image uploadée avec succès';
	 
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
		} else {
			echo "Erreur";
		}
	}
?>