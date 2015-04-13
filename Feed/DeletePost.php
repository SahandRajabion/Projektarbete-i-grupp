<?php

require_once('Model/Dao/PostRepository.php');

$postRepository = new PostRepository();

if (isset($_POST['image_name']) && empty($_POST['image_name']) == false) 
{
	unlink("View/Images/" . $_POST['image_name']);
}

if (isset($_POST["feed_id"]) && strlen($_POST['feed_id']) > 0 && is_numeric($_POST['feed_id']))
{
	$feed_id = filter_var($_POST['feed_id'], FILTER_SANITIZE_NUMBER_INT); 
	
	$postRepository->DeletePost($feed_id);
}

