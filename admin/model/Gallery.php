<?php

class Gallery extends Elem {

	var $sectionId;
	
	function __construct() {
		parent::__construct();
		$this->sectionId = -1;
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->sectionId = $tuple['sectionId'];
	}

	function createFromForm($sectionId, $rank) {
      $this->sectionId = $sectionId;
      $this->rank = $rank;
   }

	function toFrontEnd($allGalerieImages, $uploads) {
		$content = file_get_contents('../view/asset/galery.html');
		$content = str_replace("name=\"rankMarker\"", "name=\"gallery_rankMarker" . rand(1, 1e9) . "\"", $content);
		foreach ($this->getGalerieImages($allGalerieImages) as $g) {
			$content = $this->insertGalerieImageToFrontContent($content, $g->toFrontEnd($uploads));
		}
		return $content;
	}

	function toBDD() {
		$q = "INSERT INTO adm_gallery(id, sectionId, rank)" 
			. "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->rank . "'); ";
		return $q;
	}

	function insertGalerieImageToFrontContent($content, $galerieImage) {
		$pos = strrpos($content, '</div>');
		$newContent = substr($content, 0, $pos)
			. $galerieImage
			. substr($content, $pos);
		return $newContent;
	}

	function getGalerieImages($allGalerieImages) {
		$galerieImages = array();
		foreach ($allGalerieImages as $i) {
			if ($i->galleryId == $this->id) {
				array_push($galerieImages, $i);
			}
		}
		return $galerieImages;
	}
}
?>