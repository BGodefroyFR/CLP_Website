<?php
include '../util.php';
include 'Elem.php';
include 'Link.php';
include 'Gallery.php';
include 'Textarea.php';
include 'Section.php';
include 'Miniature.php';
include 'Toplink.php';
include 'Upload.php';
include 'GalleryImage.php';

class Model {

	var $links = array();
	var $galleries = array();
	var $textareas = array();
	var $sections = array();
	var $miniatures = array();
	var $toplinks = array();
	var $uploads = array();
	var $galleryimages = array();

	function __construct() {
	}

	function loadFromDB() {
		$bdd = connectBDD();

		// links
		$r = $bdd->query("SELECT * FROM adm_link");
		while($d = $r->fetch())
            array_push($this->links, new Link($d));
        // galleries
		$r = $bdd->query("SELECT * FROM adm_gallery");
		while($d = $r->fetch())
            array_push($this->galleries, new Gallery($d));
        // textareas
		$r = $bdd->query("SELECT * FROM adm_textarea");
		while($d = $r->fetch())
            array_push($this->textareas, new Textarea($d));
        // sections
		$r = $bdd->query("SELECT * FROM adm_section");
		while($d = $r->fetch())
            array_push($this->sections, new Section($d));
        // miniatures
		$r = $bdd->query("SELECT * FROM adm_miniature");
		while($d = $r->fetch())
            array_push($this->miniatures, new Miniature($d));
        // toplinks
		$r = $bdd->query("SELECT * FROM adm_toplink");
		while($d = $r->fetch())
            array_push($this->toplinks, new Toplink($d));
        // uploads
		$r = $bdd->query("SELECT * FROM adm_upload");
		while($d = $r->fetch())
            array_push($this->uploads, new Upload($d));
        // galleryimages
		$r = $bdd->query("SELECT * FROM adm_galleryimage");
		while($d = $r->fetch())
            array_push($this->galleryimages, new Galleryimage($d));

        $r->closeCursor();
	}
}
?>