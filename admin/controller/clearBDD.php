<?php
	include '../util.php';

	$q = "TRUNCATE adm_gallery;"
		. "TRUNCATE adm_galleryimage;"
		. "TRUNCATE adm_html;"
		. "TRUNCATE adm_link;"
		. "TRUNCATE adm_miniature;"
		. "TRUNCATE adm_section;"
		. "TRUNCATE adm_textarea;"
		. "TRUNCATE adm_toplink;"
		. "TRUNCATE adm_upload;";

	executeQuery($q);
?>