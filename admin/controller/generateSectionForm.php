<?php
	include '../model/Model.php';

	generateSectionForm();

	function generateSectionForm() {
		$newModel = new Model();
		$newModel->loadFromDB();
		$content = $newModel->toSectionForm(36);

		$file = '../view/modifySection.html';
		file_put_contents($file, $content);
	}
?>