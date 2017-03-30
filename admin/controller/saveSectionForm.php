<?php
	include '../model/Model.php';
	include 'uploadFile.php';

	/*$myJSON = json_encode($_POST);
	$file = '/home/bruno/compagnielepassage.fr/admin/controller/save.json';
	$content = $myJSON;
	file_put_contents($file, $content);*/

	//$content = file_get_contents('/home/bruno/compagnielepassage.fr/admin/controller/save.json');
	//$_POST = json_decode($content, true);

	// Get contents ranking
	$linksRanks = array();
	$textAreaRanks = array();
	$galleriesRanks = array();

	$curRank = 0;
	foreach($_POST as $key => $value) {
		if (strrpos($key, 'link_isUpload') === 0) {
			array_push($linksRanks, $curRank ++);
		} else if (strrpos($key, 'textarea_rankMarker') === 0) {
			array_push($textAreaRanks, $curRank ++);
		} else if (strrpos($key, 'gallery_rankMarker') === 0) {
			array_push($galleriesRanks, $curRank ++);
		}
	}

	// Creates and fill model
	$newModel = new Model();
	$newModel = createSection($newModel);
	$newModel = createToplink($newModel);
	$newModel = createMiniature($newModel);
	$newModel = createLinks($newModel, $linksRanks);
	$newModel = createTextareas($newModel, $textAreaRanks);
	$newModel = createGalleries($newModel, $galleriesRanks);

	// Exports model to BDD
	executeQuery($newModel->toBDD());


	// -------------------------------------

	function createSection($model) {
		$newSection = new Section();
		$newSection->createFromForm($_POST['title'], $_POST['fontColor'], $_POST['backgroundColor'], $_POST['selectPattern'], $_POST['rank'], $_POST['id']);
		array_push($model->sections, $newSection);
		return $model;
	}

	function createToplink($model) {
		if (isset($_POST['isTopLink']) && strcmp($_POST['isTopLink'], "on") == 0) {
			$newTopLink = new TopLink();
			$newTopLink->createFromForm($_POST['id'], $_POST['topLinkText']);
			array_push($model->toplinks, $newTopLink);
		}
		return $model;
	}

	function createMiniature($model) {
		if (isset($_POST['isMiniature']) && strcmp($_POST['isMiniature'], "on") == 0) {
			if (!isUploadError($_FILES['miniatureImage']['error'])) {
				$path = uploadFile ('images/miniatures', $_FILES['miniatureImage']);
				$newUpload = new Upload();
				$newUpload->createFromForm($path[1], $path[0]);
				array_push($model->uploads, $newUpload);

				$newMiniature = new Miniature();
				$newMiniature->createFromForm($_POST['id'], $newUpload->id);
				array_push($model->miniatures, $newMiniature);
			}
		}
		return $model;
	}

	function createLinks($model, $linksRanks) {
		$link_isUpload = array();
		foreach($_POST as $key => $value) {
			if (strrpos($key, 'link_isUpload_') === 0) {
				array_push($link_isUpload, $value);
			}
		}
		$uploadOffset = sizeof($model->uploads);
		if (isset($_POST['link_label'])) {
			$uploadFilesPaths = uploadFiles ('file-upload', $_FILES['link_uploadedFile']);
			foreach ($uploadFilesPaths as $path) {
				if (strlen($path[1]) > 0) {
					$newUpload = new Upload();
					$newUpload->createFromForm($path[1], $path[0]);
					array_push($model->uploads, $newUpload);
				}
			}
			
			$count = 0;
			$pathCount = 0;
			
			while (current($_POST['link_label'])) {
				$newLink = new Link();
				$url = $_POST['link_url'][$count];
				if (booltoInt($link_isUpload[$count])) 
					$url = $uploadFilesPaths[$pathCount ++][1];
				if (strlen($url) > 0) {
					$newLink->createFromForm(
						booltoInt($link_isUpload[$count]),
						current($_POST['link_label']), 
						$url,
						(booltoInt($link_isUpload[$count]) ? $model->uploads[$pathCount-1 + $uploadOffset]->id : -1),
						$_POST['id'],
						$linksRanks[$count]);
					array_push($model->links, $newLink);
				}
				$count ++;
				next($_POST['link_label']);
			}
		}
		return $model;
	}

	function createTextareas($model, $textAreaRanks) {
		$count = 0;
		foreach($_POST as $key => $value) {
			if (strrpos($key, 'isTwoCol') === 0) {
				$newTextArea = new TextArea();
				$newTextArea->createFromForm($_POST['id'],
					booltoInt($value),
					$_POST['editor'.($count*2)],
					$_POST['editor'.($count*2+1)],
					$textAreaRanks[$count]);
				$count ++;
				array_push($model->textareas, $newTextArea);
			}
		}
		return $model;
	}

	function createGalleries($model, $galleriesRanks) {
		$photosPerGallery = array();
		$count = 0;
		foreach($_POST as $key => $value) {
			if (strrpos($key, 'gallery_') === 0) {
				$newGallery = new Gallery();
				$newGallery->createFromForm($_POST['id'], $galleriesRanks[$count]);
				array_push($photosPerGallery, 0);
				array_push($model->galleries, $newGallery);
				$count ++;
			} else if (strrpos($key, 'galleryIm_rankMarker') === 0) {
				$photosPerGallery[$count-1] ++;
			}
		}
		if(sizeof($photosPerGallery) > 0) {
			$uploadFilesPaths = uploadFiles ('images/galeries', $_FILES['galery_photoUpload']);
		}
		$count = 0;
		for ($i = 0; $i < sizeof($photosPerGallery); $i++) {
			for ($j = 0; $j < $photosPerGallery[$i]; $j++) {
				if (strlen($uploadFilesPaths[$count][1]) > 0) {
					$newUpload = new Upload();
					$newUpload->createFromForm($uploadFilesPaths[$count][1], $uploadFilesPaths[$count][0]);
					array_push($model->uploads, $newUpload);

					$newGalleryimage = new Galleryimage();
					$newGalleryimage->createFromForm($model->galleries[$i]->id, $newUpload->id, $j);
					array_push($model->galleryimages, $newGalleryimage);
				}
				$count ++;
			}
		}
		return $model;
	}

?>
