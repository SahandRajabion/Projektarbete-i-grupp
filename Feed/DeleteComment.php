<?php

require_once("Model/Dao/CommentRepository.php");

$commentRepository = new CommentRepository();

if (isset($_POST["comment_id"]) && strlen($_POST['comment_id']) > 0 && is_numeric($_POST['comment_id']))
{
	$comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT); 
	
	$commentRepository->DeleteComment($comment_id);
}