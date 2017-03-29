<?php

class GalleryImage extends Elem {

	var $galleryId = NULL;
	var $path = NULL;

	function __construct() {
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->galleryId = $tuple['galleryId'];
		$this->path = $tuple['path'];
	}

	function createFromForm($galleryId, $path, $rank) {
	  $this->galleryId = $galleryId;
	  $this->path = $path;
	  $this->rank = $rank;
	}

	function toFrontEnd() {
	}
}
?>