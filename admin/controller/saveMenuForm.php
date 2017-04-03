<?php
	include '../model/Model.php';
	include 'uploadFile.php';

	$model = new Model();
	$model->loadFromDB();

	updateTopLinksRanks($model);
	updateMiniaturesRanks($model);
	updateSections($model);

	// -------------------------------------

	function updateTopLinksRanks($model) {
		$curRank = 0;
		$q = "";
		foreach ($_POST['toplink'] as $t) {
			$curToplink = $model->getById($model->toplinks, $t);
			$curToplink->rank = $curRank ++;
			$q .= $curToplink->rankUpdate();
		}
		executeQuery($q);
	}

	function updateMiniaturesRanks($model) {
		$curRank = 0;
		$q = "";
		foreach ($_POST['miniature'] as $t) {
			$curMiniature = $model->getById($model->miniatures, $t);
			$curMiniature->rank = $curRank ++;
			$q .= $curMiniature->rankUpdate();
		}
		executeQuery($q);
	}

	function updateSections($model) {
		$listDeleted = array(sizeof($model->sections));
		foreach($listDeleted as $e)
			$e = true;

		$curRank = 0;
		$q = "";
		foreach ($_POST['section'] as $t) {
			$count = 0;
			foreach($model->sections as $e) {
				if ($e->id == $t) {
					$listDeleted[$count] = false;
					$curSection = $e;
					break;
				}
				$count ++;
			}
			if ($curSection == null) { // new section
				$newSection = new Section();
				$newSection->createFromMenu($curRank ++, $t);
				$q .= $newSection->toBDD();
			} else {
				$curSection->rank = $curRank ++;
				$q .= $curSection->rankUpdate();
			}
		}
		executeQuery($q);

		// Remove deleted sections
		$count = 0;
		foreach($listDeleted as $e) {
			if ($e) {
				$model->deleteSection($count);
			}
			$count ++;
		}
	}
?>