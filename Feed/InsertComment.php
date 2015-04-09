<?php

require_once("Model/Dao/CommentRepository.php");
require_once("Model/Comment.php");
require_once('View/HTMLView.php');

$htmlView = new HTMLView();
$commentRepository = new CommentRepository();

$values = array();
$validationResult = Comment::validate($values);

if($validationResult)
{
	$values['CommentId'] = $commentRepository->InsertComment($values['body'], $values['id']);
	
	$values['date'] = date('r', time());

	$comment = new Comment($values);

	$htmlView->EchoHTML(json_encode(array('status'=>1, 'html'=>$comment->GetCommentHTML())));
}

else
{
	$htmlView->EchoHTML('{"status":0,"errors":' . json_encode($values) . '}');
}
