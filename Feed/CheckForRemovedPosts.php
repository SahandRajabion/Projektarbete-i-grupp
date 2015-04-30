<?php

require_once("Model/Dao/PostRepository.php");

if (isset($_POST['arrayOfPostIds']) && empty($_POST['arrayOfPostIds']) == false && count($_POST['arrayOfPostIds']) > 1
	&& isset($_POST['course_id']) && empty($_POST['course_id']) == false && count($_POST['course_id']) > 1) {

	$sitePostIds = $_POST['arrayOfPostIds']; 
	$course_id = $_POST['course_id'];

	$postRepository = new PostRepository();

	$databaseIds = $postRepository->getAllPostIds($course_id);

	$result = array_diff($sitePostIds, $databaseIds);

	if (count($result) > 0)
	{
		$string_version = implode(',', $result);
		echo $string_version;
	}
}
