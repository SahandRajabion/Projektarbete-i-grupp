<?php

session_start();

require_once('Model/Dao/PostRepository.php');
require_once('Model/LoginModel.php');

$postRepository = new PostRepository();
$loginModel = new LoginModel();

$userId = $loginModel->getId();
$posts = $postRepository->GetUsersPosts($userId);

if ($posts === null) 
{
	if ($loginModel->isAdmin()) 
	{
		if (isset($_POST["feed_id"]) && strlen($_POST['feed_id']) > 0 && is_numeric($_POST['feed_id']))
		{
			echo 1;
		}
	}
}	

else if ($loginModel->isAdmin()) 
{
	if (isset($_POST["feed_id"]) && strlen($_POST['feed_id']) > 0 && is_numeric($_POST['feed_id']))
	{
		echo 1;
	}
}

else 
{
	foreach ($posts as $post) 
	{
		if ($post['id'] == $_POST["feed_id"] ) 
		{
			echo 1;
		}
	}
}


