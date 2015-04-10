<?php

require_once('Model/Dao/PostRepository.php');
require_once('Model/Dao/CommentRepository.php');
require_once('View/UploadView.php');

class FeedView
{
    private $postRepository;
    private $commentRepository;
    private $uploadView;

    private $title = "message";
    private $hiddenFeedId = "hiddenFeedId";
    
    public function __construct() 
    {
        $this->uploadView = new UploadView();
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
        <link rel='stylesheet' href='css/style.css' />
        </head>

        <body>
                <div class='header'>
                </div>
                <div class='content'>";




        $html .= $this->uploadView->RenderUploadForm() . "<ul id='items'>";
    

     // Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
     foreach ($feedItems as $feedItem) 
        {
                $last_id = $feedItem['Date'];
                $html .= "<div class='post' id='post" . $feedItem['id'] . "'> 
                <form class='post-remove' method='post' action=''> 
                <input type='image' src='images/icon_del.gif' id='deleteimage' border='0' alt='submit' />
                <div class='date'>" . $feedItem['Date'] . "</div>
                <p>" . $feedItem['Post'] . "</p>
                <p>". $feedItem['Title'] . "</p>";

                if (empty($feedItem['imgName']) == false) 
                {
                    $html .= "<img src='View/Images/" . $feedItem['imgName'] . "' width='500' height='315'>";
                }

                if (empty($feedItem['code']) == false) 
                {
                    $html .= "<iframe width='500' height='315' src='https://www.youtube.com/embed/". $feedItem['code'] ."' frameborder='0' allowfullscreen></iframe>";                  
                }

                $html .= "
                <input type='hidden' name='imagename' id='imagename' value='" . $feedItem['imgName'] . "'>
                <input type='hidden' name='".$this->hiddenFeedId."' id='".$this->hiddenFeedId."' value='". $feedItem['id'] ."'>
                </form>
                ";

                $comments = $this->commentRepository->GetCommentsForPost($feedItem['id']);

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
        <script type='text/javascript' src='js/jquery.min.js'></script>
        <script type='text/javascript' src='js/LoadMoreItems.js'></script>
        <script type='text/javascript' src='js/InsertComment.js'></script>
        <script type='text/javascript' src='js/DeleteComment.js'></script>
        <script type='text/javascript' src='js/DeletePost.js'></script>
        <script type='text/javascript' src='script/AjaxUpload.js'></script>
        <script type='text/javascript' src='script/jquery.form.min.js'></script>
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