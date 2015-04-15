<?php

session_start();

require_once("Model/Dao/CommentRepository.php");
require_once("Model/LoginModel.php");
require_once("Model/Comment.php");
require_once('View/HTMLView.php');

$htmlView = new HTMLView();
$commentRepository = new CommentRepository();
$loginModel = new LoginModel();

$values = array();
$validationResult = Comment::validate($values);

if($validationResult)
{
	$values['CommentId'] = $commentRepository->InsertComment($values['body'], $values['id'], $loginModel->getId());
	
	$values['date'] = date('r', time());

	$comment = new Comment($values, $loginModel->getId());

	$htmlView->EchoHTML(json_encode(array('status'=>1, 'html'=>$comment->GetCommentHTML())));
}

else
{
	$htmlView->EchoHTML('{"status":0,"errors":' . json_encode($values) . '}');
}
