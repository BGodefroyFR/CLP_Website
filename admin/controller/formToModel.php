<?php
	include '../model/Model.php';
	include 'uploadFile.php';

	/*$myJSON = json_encode($_POST);
	$file = '/home/bruno/compagnielepassage.fr/admin/controller/save.json';
	$content = $myJSON;
	file_put_contents($file, $content);*/

	$content = file_get_contents('/home/bruno/compagnielepassage.fr/admin/controller/save.json');
	$_POST = json_decode($content, true);

	$newModel = new Model();
	
	// Creates section
	$newSection = new Section();
	$newSection->createFromForm($_POST['title'], $_POST['fontColor'], $_POST['backgroundColor'], $_POST['selectPattern']);
	array_push($newModel->sections, $newSection);

	// Manages toplinks and miniatures
	if (isset($_POST['isTopLink']) && strcmp($_POST['isTopLink'], "on") == 0) {
		$newTopLink = new TopLink();
		$newTopLink->createFromForm($_POST['id'], $_POST['topLinkText']);
		array_push($newModel->toplinks, $newTopLink);
	}
	if (isset($_POST['isMiniature']) && strcmp($_POST['isMiniature'], "on") == 0) {
		$path = uploadFile ('../../images/miniatures', $_FILE['miniatureImage']);
		$newUpload = new Upload();
		$newUpload->createFromForm($path);
		array_push($newModel->uploads, $newUpload);

		$newMiniature = new Miniature();
		$newMiniature->createFromForm($_POST['id'], $path);
		array_push($newModel->miniatures, $newMiniature);
	}

	// Links
	$link_isUpload = array();
	foreach($_POST as $key => $value) {
		if (strrpos($key, 'link_isUpload_') === 0) {
			array_push($link_isUpload, $value);
		}
	}
	if (isset($_POST['link_label'])) {
		$uploadFilesPaths = uploadFiles ('../../file-upload', $_FILE['link_uploadedFile']);
		foreach ($uploadFilesPaths as $path) {
			$newUpload = new Upload();
			$newUpload->createFromForm($path);
			array_push($newModel->uploads, $newUpload);
		}
		
		$count = 0;
		$pathCount = 0;
		while (next($_POST['link_label'])) {
			$newLink = new Link();
			$url = $_POST['link_url'][$count];
			if ($link_isUpload[$count])
				$url = $uploadFilesPaths[$pathCount ++];

			$newLink->createFromForm(
				$link_isUpload[$count],
				current($_POST['link_label']), 
				$url, -1, $_POST['id']);
			$count ++;
			array_push($newModel->links, $newLink);
		}
	}

	// Textareas
	foreach($_POST as $key => $value) {
		$count = 0;
		if (strrpos($key, 'isTwoCol') === 0) {
			$newTextArea = new TextArea();
			$newTextArea->createFromForm($_POST['id'], $value, $_POST['editor'.($count*2)], $_POST['editor'.($count*2+1)]);
			$count ++;
			array_push($newModel->textareas, $newTextArea);
		}
	}

	// Galleries
	$photosPerGallery = array();
	foreach($_POST as $key => $value) {
		if (strrpos($key, 'gallery') === 0) {
			$newGallery = new Gallery();
			$newGallery->createFromForm($_POST['id']);
			array_push($photosPerGallery, $value);
			array_push($newModel->galleries, $newGallery);
		}
	}
	if(sizeof($photosPerGallery) > 0) {
		$uploadFilesPaths = uploadFiles ('../../images/galeries', $_FILE['galery_photoUpload']);
	}
	$count = 0;
	for ($i = 0; $i < sizeof($photosPerGallery); $i++) {
		for ($j = 0; $j < $photosPerGallery[$i]; $j++) {
			$newGalleryimage = new Galleryimage();
			$newGalleryimage->createFromForm($newModel->galleries[$i]->id, $uploadFilesPaths[$count ++]);
			array_push($newModel->galleryimages, $newGalleryimage);
		}
	}

?>
