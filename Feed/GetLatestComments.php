<?php

session_start();

require_once("Model/Dao/UserRepository.php");
require_once("Model/Dao/CommentRepository.php");
require_once("Model/LoginModel.php");
require_once("Model/Comment.php");

$userRepository = new UserRepository();
$commentRepository = new CommentRepository();
$loginModel = new LoginModel();

if (isset($_POST["first_comment_id"]) && strlen($_POST['first_comment_id']) > 0 && is_numeric($_POST['first_comment_id']) && isset($_POST["course_id"]) && strlen($_POST['course_id']) > 0 && is_numeric($_POST['course_id']))
{
    $first_comment_id = $_POST['first_comment_id'];
    $course_id = $_POST['course_id'];

	$comment = $commentRepository->GetLatestCommentItem($first_comment_id, $course_id);

	if ($comment != null) {

		$data = $comment->GetData();

		$html = "";

		$data['date'] = strtotime($data['date']);

		$html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '">  <li class="list-group-item">';

		if ($loginModel->getId() == $comment->GetUserId()) 
		{
		     $html .='
                           
                            <a href="#" class="delete_button" id="' . $data["CommentId"] . '">
                            <span class=""><i class="glyphicon glyphicon-trash"></i></span>
                            </a>';
		}

		$html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
		<a href="?profile=' . $comment->GetUserId() . '">' . $userRepository->getUsernameFromId($comment->GetUserId()) . '</a> wrote: <h5>' . $data['body'] . '</h5>
		</div>';	

		echo (json_encode(array('postId'=>$data['id'], 'html'=>$html)));
	}
}