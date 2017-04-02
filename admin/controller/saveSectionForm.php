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

	cleanUpUploads(36);

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

	// Cleans DB
	cleanUpDB($_POST['id']);

	// Exports model to DB
	executeQuery($newModel->toBDD());

	// Cleans uploads
	cleanUpUploads($_POST['id']);


	// -------------------------------------

	function cleanUpDB($sectionId) {
		$q = "DELETE FROM adm_galleryimage WHERE galleryId IN " 
			. "(SELECT id FROM adm_gallery WHERE sectionId = '" . $sectionId . "'); ";

		$q .= "DELETE FROM adm_link WHERE sectionId = '" . $sectionId . "'; ";
		$q .= "DELETE FROM adm_textarea WHERE sectionId = '" . $sectionId . "'; ";
		$q .= "DELETE FROM adm_gallery WHERE sectionId = '" . $sectionId . "'; ";

		$q .= "DELETE FROM adm_section WHERE id='" . $sectionId . "'; "
		 . "DELETE FROM adm_toplink WHERE sectionId='" . $sectionId . "'; "
		 . "DELETE FROM adm_miniature WHERE sectionId='" . $sectionId . "'; ";

		executeQuery($q);
	}

	function cleanUpUploads($sectionId) {
		// Cleans up files
		$toRemove = "SELECT path FROM adm_upload WHERE isTextEmbeded='0' and id NOT IN ("
    		. "SELECT uploadId FROM adm_miniature WHERE sectionId = '" . $sectionId . "' "
    		. "UNION SELECT uploadId FROM adm_galleryimage, adm_gallery WHERE adm_galleryimage.galleryId = adm_gallery.id and sectionId = '" . $sectionId . "' " 
    		. "UNION SELECT uploadId FROM adm_link WHERE sectionId = '" . $sectionId . "')";

		$filesList = executeQuery($toRemove);
		while($f = $filesList->fetch()) {
			unlink("../../" . $f['path']);
		}

		// Cleans up DB
		$q = "DELETE FROM adm_upload WHERE isTextEmbeded='0' and id NOT IN (SELECT uploadId FROM adm_miniature WHERE sectionId = '" . $sectionId . "' "
			. "UNION SELECT uploadId FROM adm_galleryimage, adm_gallery WHERE adm_galleryimage.galleryId = adm_gallery.id and sectionId = '" . $sectionId . "' "
			. "UNION SELECT uploadId FROM adm_link WHERE sectionId = '" . $sectionId . "'); ";
		executeQuery($q);
	}

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
			if(sizeof($model->miniatures) == 0 && strcmp($_POST['miniatureUploadId'], '-1') != 0) {
				$newMiniature = new Miniature();
				$newMiniature->createFromForm($_POST['id'], $_POST['miniatureUploadId']);
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
		if (isset($_FILES['link_uploadedFile'])) {
			$uploadFilesPaths = uploadFiles ('file-upload', $_FILES['link_uploadedFile']);
			foreach ($uploadFilesPaths as $path) {
				if (strlen($path[1]) > 0) {
					$newUpload = new Upload();
					$newUpload->createFromForm($path[1], $path[0]);
					array_push($model->uploads, $newUpload);
				}
			}
		}
		
		$totalCount = 0;
		$curCount = 0;
		$newCount = 0;
		$pathCount = 0;

		while (isset($_POST['isCurLink']) && current($_POST['isCurLink'])) {
			$newLink = new Link();
			if(strcmp(current($_POST['isCurLink']), 'true') == 0) {
				$newLink->createFromForm(
					(int)$_POST['isOnServer'][$curCount],
					$_POST['curLink_label'][$curCount], 
					$_POST['curLink_target'][$curCount],
					$_POST['curUploadId'][$curCount],
					$_POST['id'],
					$linksRanks[$totalCount ++]);
				$curCount ++;
			} else {
				$url = $_POST['link_url'][$newCount];
				if (booltoInt($link_isUpload[$newCount])) 
					$url = $uploadFilesPaths[$pathCount ++][1];
				if (strlen($url) > 0) {
					$newLink->createFromForm(
						booltoInt($link_isUpload[$newCount]),
						$_POST['link_label'][$newCount], 
						$url,
						(booltoInt($link_isUpload[$newCount]) ? $model->uploads[$pathCount-1 + $uploadOffset]->id : -1),
						$_POST['id'],
						$linksRanks[$totalCount ++]);
				}
				$newCount ++;
			}

			array_push($model->links, $newLink);
			next($_POST['isCurLink']);
		}
		return $model;
	}

	function createTextareas($model, $textAreaRanks) {
		$count = 0;
		foreach($_POST as $key => $value) {
			if (strrpos($key, 'isTwoCol') === 0 && strcmp($key, 'isTwoCol') != 0) {
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
		$isNewImage = array();
		$count = 0;
		foreach($_POST as $key => $value) {
			if (strrpos($key, 'gallery_') === 0) {
				$newGallery = new Gallery();
				$newGallery->createFromForm($_POST['id'], $galleriesRanks[$count]);
				array_push($photosPerGallery, 0);
				array_push($model->galleries, $newGallery);
				$count ++;
			} else if (strrpos($key, 'curGalleryIm_rankMarker') === 0) {
				$photosPerGallery[$count-1] ++;
				array_push($isNewImage, true);
			}
			else if (strrpos($key, 'galleryIm_rankMarker') === 0) {
				$photosPerGallery[$count-1] ++;
				array_push($isNewImage, false);
			}
		}
		if(isset($_FILES['galery_photoUpload'])) {
			$uploadFilesPaths = uploadFiles ('images/galeries', $_FILES['galery_photoUpload']);
		}
		$totalCount = 0;
		$newCount = 0;
		$curCount = 0;
		for ($i = 0; $i < sizeof($photosPerGallery); $i++) {
			for ($j = 0; $j < $photosPerGallery[$i]; $j++) {
				$newGalleryimage = new Galleryimage();
				if ($isNewImage[$totalCount]) {
					$newGalleryimage->createFromForm($model->galleries[$i]->id, $_POST['uploadId'][$curCount ++], $j);	
				} else {
					if (strlen($uploadFilesPaths[$newCount][1]) > 0) {
						$newUpload = new Upload();
						$newUpload->createFromForm($uploadFilesPaths[$newCount][1], $uploadFilesPaths[$newCount][0]);
						array_push($model->uploads, $newUpload);

						$newGalleryimage->createFromForm($model->galleries[$i]->id, $newUpload->id, $j);
					}
					$newCount ++;
				}
				array_push($model->galleryimages, $newGalleryimage);
				$totalCount ++;
			}
		}
		return $model;
	}

?>
