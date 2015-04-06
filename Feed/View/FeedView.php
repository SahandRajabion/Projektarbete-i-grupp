<?php

require_once('Model/Dao/FeedRepository.php');
require_once('Model/Dao/CommentRepository.php');
require_once('View/HTMLView.php');
require_once('View/CookieStorage.php');
require_once('View/UploadView.php');
require_once('Model/ImagesModel.php');

class FeedView
{
    private $feedRepository;
    private $commentRepository;
    private $mainView;
    private $session = "session";
    private $hiddenImgID = "hiddenImgID";
    private $hiddenImg = "hiddenImg";
    private static $page = "page";
    public static $upload ="upload";
    private $uploadPage;
    private $msg = "message";
    private $imagesModel;
    private $cookieStorage;
    private $del = "delete";
    private $yesDel = "yesDel";
    private $NoDel = "NoDel";

    private static $itemId = "ItemId";

    public function __construct() 
    {
        $this->feedRepository = new FeedRepository();
        $this->commentRepository = new CommentRepository();
        $this->mainView = new HTMLView();
        $this->uploadPage = new UploadView();
        $this->imagesModel = new ImagesModel();
        $this->cookieStorage = new CookieStorage();
    }

    public function GetFeedHTML()
    {
        $feedItems = $this->feedRepository->GetFeedItems();

        $html = "<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv='Content-Type'content='text/html; charset=utf-8' />
        <title>Newsfeed</title>
        <link rel='stylesheet' href='css/style.css' />
        <script type='text/javascript' src='js/jquery.min.js'></script>
        <script type='text/javascript' src='js/script.js'></script>
        <script src='script.js'></script>
        <script type='text/javascript' src='js/LoadMoreItems.js'></script>
        <script type='text/javascript' src='js/InsertComment.js'></script>

        </head>

        <body>
                <div class='header'>
                </div>
                <div class='content'>
                <ul id='items'>";
       $html .= $this->mainView->echoHTML($this->DisplayAllImagesForUsers()) ."<br>";

        $last_id = 0;

        // Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
        foreach ($feedItems as $feedItem) 
        {
            $last_id = $feedItem['id'];

            $html .= 
            "<li>
                <input type='hidden' name='" . self::$itemId . "' value='" . $feedItem['id'] . "'>
                <h2>" . $feedItem['title'] . "</h2>
                <p> " . $feedItem['description'] . "</p>
            </li>";

            $comments = $this->commentRepository->GetCommentsForPost($feedItem['id']);

            if (empty($comments) == false) 
            {
                foreach ($comments as $comment) 
                {
                    $html .= $comment->GetCommentHTML();
                }            
            }

            $html .= "<div id='addCommentContainer'>
                <form id='addCommentForm' method='post' action=''>
                    <div>
                        <label for='body'>Add a comment</label>
                        <textarea name='body' id='body' maxlength='250' cols='20' rows='5'></textarea>
                        <input type='submit' id='submit' value='Comment'/>
                    </div>
                </form>
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



        //Render all images for users.
    public function DisplayAllImagesForUsers($msg = '') {


        $responseMessages = '';
        if ($msg != '') {
            $responseMessages .= '<strong>' . $msg . '</strong>';
        }

        $MsgSuccesUpload = $this->cookieStorage->GetMessageCookie();
        echo '<strong>' .$MsgSuccesUpload . '</strong>';
        $this->cookieStorage->DeleteMessageCookie();    
        $Images = glob("View/Images/*.*");
        $pic = "<br><br><br><br>";

        foreach ($Images as $value) {
            $img = $this->imagesModel->getImages(basename($value));
            $SoSoon = "";
            if($img->GetMSG() == "") {
                $SoSoon .="";
            }

            $pic .= '<form id="remove" enctype="multipart/form-data" method="post" action="">'.
            '<strong> '.$img->GetMSG().$SoSoon.'</strong>'.
            '</div>'.
            '<br>'.
            '<br>'.
            '<img  src="'.$value.'" id="ImgSize" class="preview">'.
            '<br>'.
            '<br>'.
            '<input type="hidden" name="'.$this->hiddenImgID.'" value="'.basename($value).'">'.
            '<input type="submit" name="'.$this->del.'" value="Ta bort" class="btn btn-danger">&nbsp;'.
            '</form>'.
            '<br>'.
            '<br>';

        }   
        $msgs = $responseMessages;              
        echo $responseMessages;
        return $pic;    
    }


    // confirm that user want to remove an image or cancel.
    public function areYouSure() {
            $remove = '<form id="delete" enctype="multipart/form-data" method="post" action="">'.
            '<fieldset class="delete">'.
            '<div class="alert alert-danger role="alert"><strong>Vill du verkligen ta bort '.$_SESSION[$this->session].'?</strong></div>'.
            '<br>'.
            '<br>'.
            '<input type="hidden" name="'.$this->hiddenImg.'" value="'.$_SESSION[$this->session].'">'.
            '<input type="submit" name="'.$this->yesDel.'" value="Ja!Ta bort" class="btn btn-danger">&nbsp;&nbsp;'.
            '<input type="submit" name="'.$this->NoDel.'" value ="Avbryt" class="btn btn-success">'.
            '</fieldset>'.
            '</form>';
        
        return $remove;
    }
   

    public function getHiddenId() {
        if (isset($_POST[$this->hiddenImgID])) {
            $_SESSION[$this->session] = $_POST[$this->hiddenImgID];
            return $_POST[$this->hiddenImgID];
        }
        
    }

    public function getSessionHidden() {
        if (isset($_POST[$this->hiddenImg])) {
            return $_POST[$this->hiddenImg];
        }
    }


    public function GetImageComment() {
        if (isset($_POST[$this->msg])) {
            return nl2br($_POST[$this->msg]);
        }
    }


    public function hasSubmitToDel() {
        if (isset($_POST[$this->del])) {
            return true;
        }
    }

    public function renderAreYouSure() {
        echo $this->mainView->echoHTML($this->areYouSure()) ."<br>";
    }


    public function getYesDel() {
        if (isset($_POST[$this->yesDel])) {
            return true;
        }
    }

    public function getNoDel() {
        if (isset($_POST[$this->NoDel])) {
            return true;
        }
    }

}