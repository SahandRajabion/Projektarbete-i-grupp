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
		echo 1;
	}
}


