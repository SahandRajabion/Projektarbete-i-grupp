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
	$values['CommentId'] = $commentRepository->InsertComment($values['body'], $values['id'], $loginModel->getId());
	
	$values['date'] = date('r', time());

	$comment = new Comment($values, $loginModel->getId());


	$data = $comment->GetData();

	$html = "";

	$data['date'] = strtotime($data['date']);

	$html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '">';

	if ($loginModel->getId() == $comment->GetUserId()) {
	    $html .=
	    '<a href="#" class="delete_button" id="' . $data["CommentId"] . '">
	    <img src="images/icon_del.gif" border="0" />
	    </a>';
	}

	$html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
	<a href="?">' . $comment->GetUsernameOfCreator() . '</a> skrev: <p>' . $data['body'] . '</p>
	</div>';	

	echo (json_encode(array('status'=>1, 'html'=>$html)));
}

else
{
	echo ('{"status":0,"errors":' . json_encode($values) . '}');
}
