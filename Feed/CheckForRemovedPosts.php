<?php

require_once("Model/Dao/PostRepository.php");

if (isset($_POST['arrayOfPostIds']) && empty($_POST['arrayOfPostIds']) == false && count($_POST['arrayOfPostIds']) > 1) {
	$sitePostIds = $_POST['arrayOfPostIds']; 

	$postRepository = new PostRepository();

	$databaseIds = $postRepository->getAllPostIds();

	$result = array_diff($sitePostIds, $databaseIds);

	if (count($result) > 0)
	{
		$string_version = implode(',', $result);
		echo $string_version;
	}
}
