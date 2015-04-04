<?php

include('Model/Dao/FeedRepository.php');
require_once('UploadView.php');
require_once('Model/ImagesModel.php');
require_once('HTMLView.php');

class FeedView
{
    private $feedRepository;
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

    public function __construct() 
    {
        $this->feedRepository = new FeedRepository();
        $this->mainView = new HTMLView();
        $this->uploadPage = new UploadView();
        $this->imagesModel = new ImagesModel();
        $this->cookieStorage = new CookieStorage();
    }

    public function GetFeedHTML()
    {
        $feedItems = $this->feedRepository->GetFeedItems();

        $html = 
        "<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv='Content-Type'content='text/html; charset=utf-8' />
        <title>Newsfeed</title>
        <link rel='stylesheet' href='css/style.css' />
        <script type='text/javascript' src='js/jquery.min.js'></script>
        <script type='text/javascript' src='js/script.js'></script>
        <script type='text/javascript' src='js/autoload.js'></script>
        </head>

        <body>
            <div class='container'>
                <div class='header'>
                </div>
                <h1 class='main_title'>Newsfeed</h1>
                <div class='content'>
                <ul id='items'>";

        $last_id = 0;

        // Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
        foreach ($feedItems as $feedItem) 
        {
            $last_id = $feedItem['id'];

            $html .= 
            "<li>
                <h2>" . $feedItem['title'] . "</h2>
                <p> " . $feedItem['description'] . "</p>
            </li>";
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

            $pic .= 
            '<strong> '.$img->GetMSG().$SoSoon.'</strong>'.
            '<br>'.
            '<br>'.
            '<img src="'.$value.'" id="ImgSize" class="img-responsive">'.
            '<br>'.
            '<br>'.
            '<br>'.
            '<br>'.
            '<br>'.
            '<br>';

        }
        $msgs = $responseMessages;              
        echo $responseMessages;
        return $pic;    
    }

        public function renderAllPicsForUsers() {
        echo $this->mainView->echoHTML($this->DisplayAllImagesForUsers()) ."<br>";
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

}