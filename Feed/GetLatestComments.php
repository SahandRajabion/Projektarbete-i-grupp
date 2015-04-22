<?php

session_start();

require_once("Model/Dao/CommentRepository.php");
require_once("Model/LoginModel.php");
require_once("Model/Comment.php");

$commentRepository = new CommentRepository();
$loginModel = new LoginModel();

if (isset($_POST["first_comment_id"]) && strlen($_POST['first_comment_id']) > 0 && is_numeric($_POST['first_comment_id']))
{
    $first_comment_id = $_POST['first_comment_id'];

	$comment = $commentRepository->GetLatestCommentItem($first_comment_id);

	if ($comment != null) {

		$data = $comment->GetData();

		$first_comment_id = $data["CommentId"];

		$html = "";

		$data['date'] = strtotime($data['date']);

		$html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '">';

		if ($loginModel->getId() == $comment->GetUserId()) 
		{
		    $html .=
		    '<a href="#" class="delete_button" id="' . $data["CommentId"] . '">
		    <img src="images/icon_del.gif" border="0" />
		    </a>';
		}

		$html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
		<a href="?profile=' . $comment->GetUserId() . '">' . $comment->GetUsernameOfCreator() . '</a> skrev: <p>' . $data['body'] . '</p>
		</div>';	

	    // Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet
	    if ($first_comment_id != NULL) 
	    {
	        //Måste ha med att länka med js filerna för den annars kmr den ej känna till js klasserna för någon anledning
	        $html .= "<script type='text/javascript'>var first_comment_id = " . $first_comment_id . ";</script>";
	    }

		echo (json_encode(array('postId'=>$data['id'], 'html'=>$html, 'insertBeforeId'=>$_POST['first_comment_id'])));
	}
}