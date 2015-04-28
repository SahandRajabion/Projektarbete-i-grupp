<?php

session_start();

require_once('Model/Dao/UserRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('Model/Dao/CommentRepository.php');
require_once('Model/LoginModel.php');
require_once('View/HTMLView.php');
require_once('View/FeedView.php');
require_once('View/BaseView.php');

$userRepository = new UserRepository();
$postRepository = new PostRepository();
$commentRepository = new CommentRepository();
$htmlView = new HTMLView();
$loginModel = new LoginModel();

if (isset($_POST["first_id"]) && strlen($_POST['first_id']) > 0 && is_numeric($_POST['first_id']))
{
    $first_id = $_POST['first_id'];

    $feedItems = $postRepository->GetLatestPostItems($first_id);

    $html = "";

    // Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
    foreach ($feedItems as $feedItem) 
    {
        $first_id = $feedItem['id'];

        $html .= "<div class='post' id='post" . $feedItem['id'] . "'>";

        if ($loginModel->getId() == $feedItem['UserId']) 
        {
            $html .= "<form class='post-remove' method='post' action=''> 
            <input type='image' src='images/icon_del.gif' id='deletepost' border='0' alt='submit' />
            <input type='hidden' name='imgName' id='imgName' value='" . $feedItem['imgName'] . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $feedItem['id'] ."'>
            </form>";

            $html .= "<form class='post-edit' method='post' action=''> 
            <input type='hidden' name='Post' id='Post' value='" . BaseView::escape($feedItem['Post']) . "'>
            <input type='hidden' name='Title' id='Title' value='" . BaseView::escape($feedItem['Title']) . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $feedItem['id'] ."'>
            <input type='image' src='images/icon_edit.png' id='editpost' border='0' alt='submit' />";
        }

        $html .= "<div class='date'>" . $feedItem['Date'] . "</div>
        <a href='?profile=" . $feedItem['UserId'] . "'>" . $userRepository->getUsernameFromId($feedItem['UserId']) . "</a> delade:
        <div class='text-values'>
        <p>" . $feedItem['Post'] . "</p>
        <p>". $feedItem['Title'] . "</p>
        </div>";

        if (empty($feedItem['imgName']) == false) 
        {
            $html .= "<img src='View/Images/" . $feedItem['imgName'] . "' width='500' height='315'>";
        }

        if (empty($feedItem['code']) == false) 
        {
            $html .= "<iframe width='500' height='315' src='https://www.youtube.com/embed/". $feedItem['code'] ."' frameborder='0' allowfullscreen></iframe>";                  
        }

        $html .= "
        </form>
        ";

        $comments = $commentRepository->GetCommentsForPost($feedItem['id']);

        if (empty($comments) == false) 
        {
            foreach ($comments as $comment) 
            {
                $data = $comment->GetData();

                $data['date'] = strtotime($data['date']);

                $html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '">';

                if ($loginModel->getId() == $comment->GetUserId()) {
                    $html .=
                    '<a href="#" class="delete_button" id="' . $data["CommentId"] . '">
                    <img src="images/icon_del.gif" border="0" />
                    </a>';
                }

                $html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
                <a href="?profile=' . $comment->GetUserId() . '">' . $comment->GetUsernameOfCreator() . '</a> skrev: <p>' . $data['body'] . '</p>
                </div>';
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
        </div>
        </div>";                     
    }

    // Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet
    if ($first_id != NULL) 
    {
        //Måste ha med att länka med js filerna för den annars kmr den ej känna till js klasserna för någon anledning
        $html .= "<script type='text/javascript'>var first_id = " . $first_id . ";</script>";
    }

    $htmlView->EchoHTML($html);
}


