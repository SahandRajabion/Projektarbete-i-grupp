<?php

session_start();

require_once('Model/Dao/CommentRepository.php');
require_once('Model/LoginModel.php');

$loginModel = new LoginModel();
$commentRepository = new CommentRepository();

$userId = $loginModel->getId();

$comments = $commentRepository->GetUsersComments($userId);


if ($comments === null) 
{
	if ($loginModel->isAdmin()) 
	{
		if (isset($_POST["comment_id"]) && strlen($_POST['comment_id']) > 0 && is_numeric($_POST['comment_id']))
		{
			$comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT); 
			
			$commentRepository->DeleteComment($comment_id);

			// Success status
			echo 1;
		}
	}
}
else {
	foreach ($comments as $comment) 
	{
		if ($comment['CommentId'] == $_POST['comment_id'] || $loginModel->isAdmin()) 
		{
			if (isset($_POST["comment_id"]) && strlen($_POST['comment_id']) > 0 && is_numeric($_POST['comment_id']))
			{
				$comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT); 
				
				$commentRepository->DeleteComment($comment_id);

				// Success status
				echo 1;
			}

		}
	}
}