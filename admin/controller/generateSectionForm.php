<?php
	include '../model/Model.php';

	generateSectionForm($_GET['id']);

	function generateSectionForm($sectionId) {
		$newModel = new Model();
		$newModel->loadFromDB();
		$content = $newModel->toSectionForm($sectionId);

		$file = '../view/modifySection.html';
		file_put_contents($file, $content);
	}
?>