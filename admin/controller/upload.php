<?php
	if (file_exists("../../images/upload/" . $_FILES["upload"]["name"]))
	{
	 echo $_FILES["upload"]["name"] . " existe deja. ";
	}
	else
	{
	 move_uploaded_file($_FILES["upload"]["tmp_name"],
	 "../../images/upload/" . $_FILES["upload"]["name"]);
	 echo "Image enregistree";

	 	$funcNum = $_GET['CKEditorFuncNum'] ;
		$url = "../../images/upload/" . $_FILES["upload"]["name"];
		$message = 'Ok!';
 
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
	}
?>