<?php

require_once('Model/Dao/PostRepository.php');
require_once('Model/Dao/CommentRepository.php');

class FeedView
{
    private $postRepository;
    private $commentRepository;
    private $title = "message";
    private $hiddenFeedId = "hiddenFeedId";
    private $imgName = "imgName";
    private $postContent = "Post";
    private $postTitle = "Title";
    private $date = "Date";
    private $id = "id";
    private $code = "code";

    public function __construct() 
    {
        $this->postRepository = new PostRepository();
        $this->commentRepository = new CommentRepository();
    }

    public function GetFeedHTML()
    {
        $feedItems = $this->postRepository->getPosts();
        $last_id = 0;

        $html = "<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv='Content-Type'content='text/html; charset=utf-8' />
        <title>Newsfeed</title>
        </head>

        <body>
                <div class='header'>
                </div>
                <div class='content'>
                <ul id='items'>";    

     // Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
     foreach ($feedItems as $feedItem) 
        {
                $last_id = $feedItem[$this->date];

                $html .= "<div class='post' id='post" . $feedItem[$this->id] . "'>";

                $html .= "<form class='post-remove' method='post' action=''> 
                <input type='image' src='images/icon_del.gif' id='deletepost' border='0' alt='submit' />
                <input type='hidden' name='" . $this->imgName . "' id='" . $this->imgName . "' value='" . $feedItem[$this->imgName] . "'>
                <input type='hidden' name='" . $this->hiddenFeedId . "' id='" . $this->hiddenFeedId . "' value='". $feedItem[$this->id] ."'>
                </form>";


                $html .= "<form class='post-edit' method='post' action=''> 
                <input type='hidden' name='" . $this->postContent . "' id='" . $this->postContent . "' value='" . $feedItem[$this->postContent] . "'>
                <input type='hidden' name='" . $this->postTitle . "' id='" . $this->postTitle . "' value='" . $feedItem[$this->postTitle] . "'>
                <input type='hidden' name='" . $this->hiddenFeedId . "' id='" . $this->hiddenFeedId . "' value='". $feedItem[$this->id] ."'>
                <input type='image' src='images/icon_edit.png' id='editpost' border='0' alt='submit' />";
                

                $html .= "<div class='date'>" . $feedItem[$this->date] . "</div>
                <div class='text-values'>
                <p>" . $feedItem[$this->postContent] . "</p>
                <p>". $feedItem[$this->postTitle] . "</p>
                </div>";

                if (empty($feedItem[$this->imgName]) == false) 
                {
                    $html .= "<img src='View/Images/" . $feedItem[$this->imgName] . "' width='500' height='315'>";
                }

                if (empty($feedItem[$this->code]) == false) 
                {
                    $html .= "<iframe width='500' height='315' src='https://www.youtube.com/embed/". $feedItem[$this->code] ."' frameborder='0' allowfullscreen></iframe>";                  
                }

                $html .= "
                </form>
                ";

                $comments = $this->commentRepository->GetCommentsForPost($feedItem[$this->id]);

                if (empty($comments) == false) 
                {
                    foreach ($comments as $comment) 
                    {
                        $html .= $comment->GetCommentHTML();
                    }            
                }

                $html .= "<div id='addCommentContainer" . $feedItem[$this->id] . "' class='addCommentContainer'>
                    <form class='comment-form' method='post' action=''>
                        <div>
                             <input type='hidden' id='" . $this->id . "' name='" . $this->id . "' value='" . $feedItem[$this->id] . "'>
                            <label for='body'>Skriv en kommentar</label>
                            <textarea name='body' id='body' maxlength='250' cols='20' rows='5'></textarea>
                            <input type='submit' id='submit' value='Kommentera'/>
                        </div>
                    </form>
                </div>
                </div>";                
        }

        // Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet
        $html .= "<script type='text/javascript'>var last_id = " . $last_id . ";</script> 
                </ul>
                <p id='loader'><img src='images/ajax-loader.gif'></p>
                </div>
                <div class='footer'>
                </div>
            </div>
        </body>
        </html>";

        return $html;
    }

    public function getHiddenId() {
        if (isset($_POST[$this->hiddenImgID])) {
            return $_POST[$this->hiddenImgID];
        }
        
    }

    public function GetImageTitle() {
        if (isset($_POST[$this->title])) {
            return nl2br($_POST[$this->title]);
        }
    }
}