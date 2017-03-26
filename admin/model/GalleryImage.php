<?php

class GalleryImage extends Elem {

	var $galleryId = NULL;
	var $imageId = NULL;

	function __construct() {
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->galleryId = $tuple['galleryId'];
		$this->imageId = $tuple['imageId'];
	}

	function createFromForm($galleryId, $imageId) {
	  $this->galleryId = $galleryId;
	  $this->imageId = $imageId;
	}

	function toFrontEnd() {
	}
}
?>