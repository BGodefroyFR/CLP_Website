<?php
include 'Elem.php';
include 'Section.php';
include 'Upload.php';
include '../util.php';

class Model {

	var $sections = array();

	function __construct() {
	}

	function loadFromDB() {
		$r = executeQuery("SELECT * FROM adm_section ORDER BY rank ASC");
		while($d = $r->fetch()) {
			$e = new Section($d);
			$e->loadFromDB($d);
            array_push($this->sections, $e);
		}
        $r->closeCursor();
	}

	function toSectionForm($sectionId) {
		$s = $this->getSection($sectionId);
		if ($s == null) {
			$s = new Section();
			array_push($this->sections, $s);
		}
		return $s->toSectionForm();
	}

	function toMenuForm() {
		$content = file_get_contents('../view/asset/menuSkeleton.html');

		$topLinkContent = "";
		$miniatureContent = "";
		$sectionContent = "";

		$isDone;
		do {
			$isDone = true;
			foreach ($this->sections as $s) {
				if ($s->toplink != null && $s->toplink->rank == -1)
					$topLinkContent .= $s->toplink->toMenuForm();
				if ($s->miniature != null && $s->miniature->rank == -1)
					$miniatureContent .= $s->miniature->toMenuForm($s->title);
			}
		} while(!$isDone);

		$isDone;
		$rankCounter = 0;
		do {
			$isDone = true;
			foreach ($this->sections as $s) {
				if ($s->toplink != null && $s->toplink->rank == $rankCounter)
					$topLinkContent .= $s->toplink->toMenuForm($s->title);
				if ($s->miniature != null && $s->miniature->rank == $rankCounter)
					$miniatureContent .= $s->miniature->toMenuForm($s->title);
				if ($s->rank == $rankCounter) {
					$sectionContent .= $s->toMenuForm();
					$isDone = false;
				}
			}
			$rankCounter ++;
		} while(!$isDone);

		$content = str_replace('<TOPLINKS>', $topLinkContent, $content);
		$content = str_replace('<MINIATURES>', $miniatureContent, $content);
		$content = str_replace('<SECTIONS>', $sectionContent, $content);

		return $content;
	}

	function toSQL() {
		$q = "";
		foreach($this->sections as $e) {
			$q .= $e->toSQL();
		}
		return $q;
	}

	function toWebsite() {
		$content = file_get_contents('../../assets/html_chuncks/skeleton.php');

		$miniatures = array();
		$toplinks = array();
		foreach ($this->sections as $s) {
			if ($s->miniature != null)
				array_push($miniatures, $s->miniature);
			if ($s->toplink != null)
				array_push($toplinks, $s->toplink);
		}
		$sortedMiniatures = $this->getSortedArray($miniatures);
		$sortedToplinks = $this->getSortedArray($toplinks);

		$sectionsContent = "";
		foreach($this->sections as $s) {
			$sectionsContent .= $s->toWebsite();
		}
		$content = str_replace('<CONTENT>', $sectionsContent, $content);

		$toplinksContent = "";
		foreach($toplinks as $s) {
			$toplinksContent .= $s->toWebsite();
		}
		$content = str_replace('<TOPLINKS>', $toplinksContent, $content);

		$miniaturesContent = "";
		foreach($miniatures as $s) {
			$miniaturesContent .= $s->toWebsite();
		}
		$content = str_replace('<MINIATURES>', $miniaturesContent, $content);

		$file = '../../index_g.php';
		file_put_contents($file, $content);
	}

	function getSortedArray($array) {
		$sortedArray = array();
		while(true) {
			$tmp = $this->getLowerRankElem($array);
			if ($tmp > -1) {
				array_push($sortedArray, $array[$tmp]);
				unset($array[$tmp]);
			}
			else {
				break;
			}
		}
		return $sortedArray;
	}

	function getLowerRankElem($array) {
		$minRank = 1e9;
		$index = -1;
		$count = 0;
		foreach($array as $e) {
			if ($e != null && $e->rank < $minRank) {
				$minRank = $e->rank;
				$index = $count ++;
			}
		}
		return $index;
	}

	function deleteSectionByIndex($sectionIndex, $removeUploads) {
		$this->sections[$sectionIndex]->delete($removeUploads);
	}

	function deleteSectionById($id, $removeUploads) {
		$section = $this->getSection($id);
		if ($section != null)
			$section->delete($removeUploads);
	}

	function getSection($id) {
		foreach($this->sections as $s) {
			if ($s->id == $id)
				return $s;
		}
	}
}
?>