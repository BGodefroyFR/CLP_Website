<?php
include 'util.php';
include 'Link.php';

class Model {

	var $links = array();
	var $galleries = array();
	var $textareas = array();
	var $sections = array();
	var $miniatures = array();
	var $toplinks = array();
	var $uploads = array();
	var $galleryimages = array();

	function loadFromDB() {
		$bdd = connectBDD();

		// links
		$r = $bdd->query("SELECT * FROM adm_link");
		while($d = $r->fetch())
            array_push($this->links, new Link($d));



        $r->closeCursor();
	}
}
?>