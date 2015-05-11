<?php

session_start();

require_once("Model/Dao/CommentRepository.php");
require_once("Model/LoginModel.php");
require_once("Model/Comment.php");

$commentRepository = new CommentRepository();
$loginModel = new LoginModel();

$values = array();
$validationResult = Comment::validate($values);

if($validationResult)
{
	$commentRepository->InsertComment($values['body'], $values['id'], $loginModel->getId(), $values['courseid']);
	
	$html = "";

	echo (json_encode(array('status'=>1, 'html'=>$html)));
}

else
{
	echo ('{"status":0,"errors":' . json_encode($values) . '}');
}
