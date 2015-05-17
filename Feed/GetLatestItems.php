<?php

session_start();

require_once('Model/Dao/UserRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('Model/Dao/CommentRepository.php');
require_once('Model/LoginModel.php');
require_once('View/HTMLView.php');
require_once('View/FeedView.php');

$userRepository = new UserRepository();
$postRepository = new PostRepository();
$commentRepository = new CommentRepository();
$htmlView = new HTMLView();
$loginModel = new LoginModel();

if (isset($_POST["first_id"]) && strlen($_POST['first_id']) > 0 && is_numeric($_POST['first_id']) && isset($_POST["course_id"]) && strlen($_POST['course_id']) > 0 && is_numeric($_POST['course_id']))
{
    $first_id = $_POST['first_id'];
    $course_id = $_POST['course_id'];


    $feedItems = $postRepository->GetLatestPostItems($first_id, $course_id);
   

    $html = "";

    // Skriver ut varje feed item och sparar undan de sista id som blir frÃ¥n sista feed item
    foreach ($feedItems as $feedItem) 
    {
        if ($feedItem != null){
        $html .= "<div class='post' id='post" . $feedItem['id'] . "'>";
        $html .="<div class='jumbotron' style='margin-left:-39px;'>";


        if ($loginModel->getId() == $feedItem['UserId']) 
        {
            $html .= "<form class='post-remove' method='post' action=''> 
            <input type='image' src='images/del.png' id='deletepost' border='0' alt='submit' />
            <input type='hidden' name='imgName' id='imgName' value='" . $feedItem['imgName'] . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $feedItem['id'] ."'>
            </form>";

            $html .= "<form class='post-edit' method='post' action=''> 
            <input type='hidden' name='Post' id='Post' value='" . BaseView::escape($feedItem['Post']) . "'>
            <input type='hidden' name='Title' id='Title' value='" . BaseView::escape($feedItem['Title']) . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $feedItem['id'] ."'>
            <input type='image' style='margin-top: -39px; margin-left: 34px;' src='images/edit.png' id='editpost' border='0' alt='submit' />";
        }

        $html .= "
        <div class='well'>Created by: <a href='?profile=" . $feedItem['UserId'] . "'>" . $userRepository->getUsernameFromId($feedItem['UserId']) . "</a></br>
        Date : <div class='date'>" . $feedItem['Date'] . "</div></div>
        <div class='text-values'>
        <p>" . $feedItem['Post'] . "</p>
        <p>". $feedItem['Title'] . "</p>
        </div>";

        if (empty($feedItem['imgName']) == false) 
        {
            $html .= "<img class='img-responsive' class='img-responsive' src='View/Images/" . $feedItem['imgName'] . "'>";
        }

        if (empty($feedItem['code']) == false) 
        {
            $html .= "<div class='embed-responsive embed-responsive-16by9'><iframe  class='embed-responsive-item' src='https://www.youtube.com/embed/". $feedItem['code'] ."' allowfullscreen></iframe></div>";                  

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

                $html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '"> <li class="list-group-item">';

                if ($loginModel->getId() == $comment->GetUserId()) {
                     $html .=
                            '
                             
                            <a href="#" class="delete_button" id="' . $data["CommentId"] . '">
                            <span class=""><i class="glyphicon glyphicon-trash"></i></span>
                            </a>';
                }

                $html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
                <a href="?profile=' . $comment->GetUserId() . '">' . $userRepository->getUsernameFromId($comment->GetUserId()) . '</a> wrote: <h5>' . $data['body'] . '</h5>
                </div>';
            }            
        }

        $html .= "<div id='addCommentContainer" . $feedItem['id'] . "' class='addCommentContainer'>
            <form class='comment-form' method='post' action=''>
                <div>
                    <input type='hidden' id='courseid' name='courseid' value='" . $course_id . "'>
                    <input type='hidden' id='id' name='id' value='" . $feedItem['id'] . "'>
                    <label for='body'>Write a comment</label>
                    <textarea name='body' id='body' maxlength='250' cols='20' class='form-control input-lg'></textarea>
                    <input type='submit' id='submit' value='Kommentera' class='btn btn-default'/>
                </div>
            </form>
        </div>
        </div></div>";                     
    }
    }

    $htmlView->EchoHTML($html);
}


