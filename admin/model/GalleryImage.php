<?php

class GalleryImage extends Elem {

	var $galleryId;
	var $upload;

	function __construct() {
		parent::__construct();
		$this->galleryId = -1;
		$this->upload = null;
	}

	function loadFromDB($tuple) {
		parent::loadFromDB($tuple);
		$this->galleryId = $tuple['galleryId'];
		$this->upload = new Upload();
      	$this->upload->loadFromDB($tuple['uploadId']);
	}

	function createFromForm($galleryId, $uploadId, $rank) {
	  $this->galleryId = $galleryId;
	  $this->upload = new Upload();
      $this->upload->loadFromDB($uploadId);
	  $this->rank = $rank;
	}

	function toSectionForm() {
		$content = file_get_contents('../view/asset/curGalery_image.html');
		$content = str_replace('<RANKMARKER>', 'curGalleryIm_rankMarker' . rand(1, 1e9), $content);
		$content = str_replace('<IMAGENAME>', $this->upload->initialName, $content);
		$content = str_replace('<UPLOADID>', $this->upload->id, $content);
		return $content;
	}

	function toSQL() {
		$q = "";
      	if ($this->upload != null)
			$q .= $this->upload->toSQL();
      	$q .= "INSERT INTO adm_galleryimage(id, galleryId, uploadId, rank)" 
			. "VALUES('" . $this->id . "', '" . $this->galleryId . "', '" . $this->upload->id . "', '" . $this->rank . "'); ";
		return $q;
	}

	function delete($removeUploads) {
		if ($removeUploads) {
	         $this->upload->delete();
	      }
		$q = "DELETE FROM adm_galleryimage WHERE id = '" . $this->id . "'; ";
		executeQuery($q);
	}
}
?>