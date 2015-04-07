<?php

require_once('Model/Dao/PostRepository.php');
require_once('Model/Dao/CommentRepository.php');
require_once('View/HTMLView.php');

$postRepository = new PostRepository();
$commentRepository = new CommentRepository();
$htmlView = new HTMLView();

// Hämtar ut sista id som har postats från Ajax anropet
$last_id = $_POST['last_id'];

$feedItems = $postRepository->GetMorePostItems($last_id);

$last_id = 0;
$html = "";

// Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
foreach ($feedItems as $feedItem)
{
    $last_id = $feedItem['PostId'];
    
    $html .= "<li> <h2>" . $feedItem['Post'] . "</h2> <p>" . $feedItem['Date'] . "</p> </li>";

    $comments = $commentRepository->GetCommentsForPost($feedItem['PostId']);

    if (empty($comments) == false) 
    {
        foreach ($comments as $comment) 
        {
            $html .= $comment->GetCommentHTML();
        }            
    }    

    $html .= "<div id='addCommentContainer" . $feedItem['PostId'] . "' class='addCommentContainer'>
        <form class='comment-form' method='post' action=''>
            <div>
                <input type='hidden' id='PostId' name='PostId' value='" . $feedItem['PostId'] . "'>
                <label for='body'>Skriv en kommentar</label>
                <textarea name='body' id='body' maxlength='250' cols='20' rows='5'></textarea>
                <input type='submit' id='submit' value='Kommentera'/>
            </div>
        </form>
    </div>"; 
}

// Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet
if ($last_id != 0) 
{
    //Måste ha med att länka med js filerna för den annars kmr den ej känna till js klasserna för någon anledning
	$html .= "<script type='text/javascript'>var last_id = " . $last_id . ";</script>";
}

$htmlView->EchoHTML($html);



