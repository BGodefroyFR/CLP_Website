<?php
	include '../model/Model.php';

	$newModel = new Model();
	$newModel->loadFromDB();
	$content = $newModel->toFrontEnd(36);

	$file = '../view/modifySection.html';
	file_put_contents($file, $content);
?>