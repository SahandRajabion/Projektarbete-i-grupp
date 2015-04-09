<?php

require_once('Model/Dao/PostRepository.php');
require_once('Model/Dao/CommentRepository.php');
require_once('Model/ImagesModel.php');
require_once('View/HTMLView.php');

$postRepository = new PostRepository();
$commentRepository = new CommentRepository();
$htmlView = new HTMLView();
$imagesModel = new ImagesModel();

// Hämtar ut sista id som har postats från Ajax anropet
$last_id = $_POST['last_id'];

$feedItems = $postRepository->GetMorePostItems($last_id);

$last_id = 0;
$html = "";

// Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
foreach ($feedItems as $feedItem)
{
     $last_id = $feedItem['id'];
        $html .= "<form method='post' action=''>
        <li>
        <h2>" . $feedItem['Post'] . "</h2>
        <p>" . $feedItem['Date'] . "</p>";

        if (empty($feedItem['imgName']) == false) 
        {
            $html .= "<img src='View/Images/" . $feedItem['imgName'] . "' id='ImgSize' class='preview'>";
        }

        if (empty($feedItem['code']) == false) 
        {
            $html .= "<iframe width='560' height='315' src='https://www.youtube.com/embed/". $videoItem['code'] ."' frameborder='0' allowfullscreen></iframe>";                  
        }

        $html .= "
        </li>
        <input type='hidden' name='hiddenPostId' value='". $feedItem['id'] ."'>
        <input type='submit' name='deletePost' value='Ta bort' class=btn btn-danger'>
        </form>";

        $comments = $commentRepository->GetCommentsForPost($feedItem['id']);

        if (empty($comments) == false) 
        {
            foreach ($comments as $comment) 
            {
                $html .= $comment->GetCommentHTML();
            }            
        }    

        $html .= "<div id='addCommentContainer" . $feedItem['id'] . "' class='addCommentContainer'>
            <form class='comment-form' method='post' action=''>
                <div>
                    <input type='hidden' id='id' name='id' value='" . $feedItem['id'] . "'>
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



