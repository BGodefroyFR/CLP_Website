<?php
	include '../model/Model.php';

	/*$myJSON = json_encode($_POST);
	$file = '/home/bruno/compagnielepassage.fr/admin/controller/save.json';
	$content = $myJSON;
	file_put_contents($file, $content);*/

	$content = file_get_contents('/home/bruno/compagnielepassage.fr/admin/controller/save.json');
	$_POST = json_decode($content, true);

	$newModel = new Model();
	
	// Creates and fills section
	$newSection = new Section();
	$newSection->createFromForm($_POST['title'], $_POST['fontColor'], $_POST['backgroundColor'], $_POST['selectPattern']);
	array_push($newModel->sections, $newSection);

	// Manages toplinks and miniatures
	if (isset($_POST['isTopLink']) && strcmp($_POST['isTopLink'], "on") == 0) {
		$newTopLink = new TopLink();
		$newTopLink->createFromForm($sectionId, $label)
	}

	// Creates and fills links, galeries and textareas
	foreach($_POST as $key => $value)
	{
	    
	}



?>