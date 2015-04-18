<?php

session_start();

require_once("Model/LoginModel.php");
require_once("Model/Dao/CommentRepository.php");


$loginModel = new LoginModel();
$commentRepository = new CommentRepository();

$userId = $loginModel->getId();

$comments = $commentRepository->GetUsersComments($userId);

foreach ($comments as $comment) 
{
	if ($comment['CommentId'] == $_POST['comment_id']) {
		if (isset($_POST["comment_id"]) && strlen($_POST['comment_id']) > 0 && is_numeric($_POST['comment_id']))
		{
			$comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT); 
			
			$commentRepository->DeleteComment($comment_id);

			// Success status
			echo 1;
		}
	}
}
