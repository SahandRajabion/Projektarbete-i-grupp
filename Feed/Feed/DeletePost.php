<?php

session_start();

require_once('Model/Dao/PostRepository.php');
require_once('Model/LoginModel.php');

$postRepository = new PostRepository();
$loginModel = new LoginModel();

$userId = $loginModel->getId();
$posts = $postRepository->GetUsersPosts($userId);

foreach ($posts as $post) 
{
	if ($post['id'] == $_POST["feed_id"]) 
	{
		if (isset($_POST['image_name']) && empty($_POST['image_name']) == false) 
		{
			unlink("View/Images/" . $_POST['image_name']);
		}

		if (isset($_POST["feed_id"]) && strlen($_POST['feed_id']) > 0 && is_numeric($_POST['feed_id']))
		{
			$feed_id = filter_var($_POST['feed_id'], FILTER_SANITIZE_NUMBER_INT); 
			
			$postRepository->DeletePost($feed_id);

			// Lyckat så responsa med 1
			echo 1;
		}
	}
}

