<?php
	include '../model/Model.php';
	include 'uploadFile.php';

	// Gets contents ranking
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

	// Creates and fills model
	$newModel = new Model();
	$newSection = new Section();
	$newSection = createSection();
	$newSection = createToplink($newSection);
	$newSection = createMiniature($newSection);
	$newSection = createLinks($newSection, $linksRanks);
	$newSection = createTextareas($newSection, $textAreaRanks);
	$newSection = createGalleries($newSection, $galleriesRanks);

	array_push($newModel->sections, $newSection);

	// Removes old version of section
	$oldModel = new Model();
	$oldModel->loadFromDB();
	$oldModel->deleteSectionById($_POST['id'], false);

	// Exports model to DB
	executeQuery($newModel->toSQL());

	// Cleans uploads
	cleanUpUploads($_POST['id']);

	// Generates website
	$model = new Model();
	$model->loadFromDB();
	$model->toWebsite();


	// -------------------------------------

	function cleanUpUploads($sectionId) {
		$toRemove = "SELECT path FROM adm_upload WHERE isTextEmbeded='0' and id NOT IN ("
    		. "SELECT uploadId FROM adm_miniature "
    		. "UNION SELECT uploadId FROM adm_galleryimage, adm_gallery WHERE adm_galleryimage.galleryId = adm_gallery.id " 
    		. "UNION SELECT uploadId FROM adm_link)";
		$filesList = executeQuery($toRemove);
		while($f = $filesList->fetch()) {
			unlink("../../" . $f['path']);
		}
		$q = "DELETE FROM adm_upload WHERE isTextEmbeded='0' and id NOT IN (SELECT uploadId FROM adm_miniature "
			. "UNION SELECT uploadId FROM adm_galleryimage, adm_gallery WHERE adm_galleryimage.galleryId = adm_gallery.id "
			. "UNION SELECT uploadId FROM adm_link); ";
		executeQuery($q);

		// Embeded images
		$embededImages = getTextAreaEmbededFiles();
		$toRemove = "SELECT path FROM adm_upload WHERE path LIKE 'images/textImages/%' ";
		foreach ($embededImages as $e) {
			$toRemove .= "and path <> '" . $e . "' ";
		}
		$filesList = executeQuery($toRemove);
		while($f = $filesList->fetch()) {
			unlink("../../" . $f['path']);
		}
		$q = "DELETE FROM adm_upload WHERE path LIKE 'images/textImages/%' ";
		foreach ($embededImages as $e) {
			$q .= "and path <> '" . $e . "' ";
		}
		executeQuery($q);
	}

	function getTextAreaEmbededFiles() {
		$textAreaContents = executeQuery("SELECT contentCol1, contentCol2 FROM adm_textarea");
		$images = array();
		while($e = $textAreaContents->fetch()) {
			for ($i = 1; $i <= 2; $i++) {
				$startPos = 0;
				$e['contentCol'.$i] = stripslashes($e['contentCol'.$i]);
				do {
					if (strlen($e['contentCol'.$i]) <= $startPos+1)
						break;
					$startPos = strpos($e['contentCol'.$i], "src=\"../../images/textImages/", $startPos+1);
					if($startPos > -1) {
						$endPos = strpos($e['contentCol'.$i], "\"", $startPos + strlen("src=\"../../images/textImages/"));
						array_push($images, substr($e['contentCol'.$i], $startPos + strlen("src=\"../../"), $endPos - $startPos - strlen("src=\"../../")));
					}
				} while ($startPos > -1);
			}
		}
		return $images;
	}

	function createSection() {
		$newSection = new Section();
		$newSection->createFromForm($_POST['title'], $_POST['fontColor'], $_POST['backgroundColor'], $_POST['selectPattern'], $_POST['rank'], $_POST['id']);
		return $newSection;
	}

	function createToplink($section) {
		if (isset($_POST['isTopLink']) && strcmp($_POST['isTopLink'], "on") == 0) {
			$newTopLink = new TopLink();
			$newTopLink->createFromForm($_POST['id'], $_POST['topLinkText']);
			$newTopLink->rank = $_POST['toplink_rank'];
			$section->toplink = $newTopLink;
		}
		return $section;
	}

	function createMiniature($section) {
		if (isset($_POST['isMiniature']) && strcmp($_POST['isMiniature'], "on") == 0) {
			if (!isUploadError($_FILES['miniatureImage']['error'])) {
				$newMiniature = new Miniature();
				$newMiniature->createFromForm($_POST['id'], -1);
				$newMiniature->rank = $_POST['miniature_rank'];
				$section->miniature = $newMiniature;

				$path = uploadFile ('images/miniatures', $_FILES['miniatureImage']);
				$section->miniature->upload = new Upload();
				$section->miniature->upload->createFromForm($path[1], $path[0]);
			}
			if($section->miniature == null && strcmp($_POST['miniatureUploadId'], '-1') != 0) {
				$newMiniature = new Miniature();
				$newMiniature->createFromForm($_POST['id'], $_POST['miniatureUploadId']);
				$newMiniature->rank = $_POST['miniature_rank'];
				$section->miniature = $newMiniature;
			}
		}
		return $section;
	}

	function createLinks($section, $linksRanks) {
		$link_isUpload = array();
		$uploads = array();
		foreach($_POST as $key => $value) {
			if (strrpos($key, 'link_isUpload_') === 0) {
				array_push($link_isUpload, $value);
			}
		}
		if (isset($_FILES['link_uploadedFile'])) {
			$uploadFilesPaths = uploadFiles ('file-upload', $_FILES['link_uploadedFile']);
			foreach ($uploadFilesPaths as $path) {
				if (strlen($path[1]) > 0) {
					$newUpload = new Upload();
					$newUpload->createFromForm($path[1], $path[0]);
					array_push($uploads, $newUpload);
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
				array_push($section->links, $newLink);
			} else {
				$url = $_POST['link_url'][$newCount];
				if (booltoInt($link_isUpload[$newCount]) && strlen($uploadFilesPaths[$pathCount][1]) > 0) 
					$url = $uploadFilesPaths[$pathCount ++][1];
				$newLink->createFromForm(
					booltoInt($link_isUpload[$newCount]),
					$_POST['link_label'][$newCount], 
					$url,
					((booltoInt($link_isUpload[$newCount]) && $pathCount > 0) ? $uploads[$pathCount-1]->id : -1),
					$_POST['id'],
					$linksRanks[$totalCount]);
				if ($pathCount > 0)
					$newLink->upload = $uploads[$pathCount-1];
				array_push($section->links, $newLink);
				$totalCount ++;
				$newCount ++;
			}
			next($_POST['isCurLink']);
		}
		return $section;
	}

	function createTextareas($section, $textAreaRanks) {
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
				array_push($section->textareas, $newTextArea);
			}
		}
		return $section;
	}

	function createGalleries($section, $galleriesRanks) {
		$photosPerGallery = array();
		$isNewImage = array();
		$count = 0;
		foreach($_POST as $key => $value) {
			if (strrpos($key, 'gallery_') === 0) {
				$newGallery = new Gallery();
				$newGallery->createFromForm($_POST['id'], $galleriesRanks[$count]);
				array_push($photosPerGallery, 0);
				array_push($section->galleries, $newGallery);
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
					$newGalleryimage->createFromForm($section->galleries[$i]->id, $_POST['uploadId'][$curCount ++], $j);
					array_push($section->galleries[$i]->galleryimages, $newGalleryimage);	
				} else {
					if (sizeof($uploadFilesPaths) > 0 && strlen($uploadFilesPaths[$newCount][1]) > 0) {
						$newGalleryimage->createFromForm($section->galleries[$i]->id, -1, $j);
						$newUpload = new Upload();
						$newUpload->createFromForm($uploadFilesPaths[$newCount][1], $uploadFilesPaths[$newCount][0]);
						$newGalleryimage->upload = $newUpload;
						array_push($section->galleries[$i]->galleryimages, $newGalleryimage);
					}
					$newCount ++;
				}
				$totalCount ++;
			}
		}
		return $section;
	}

?>
