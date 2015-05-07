<?php

require_once('Model/Dao/CourseRepository.php');
require_once('Model/Dao/UserRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('Model/Dao/CommentRepository.php');
require_once('Model/LoginModel.php');
require_once('View/UploadView.php');
require_once('Model/ImagesModel.php');
require_once('View/BaseView.php');
require_once('View/RSSFeedView.php');


class FeedView extends BaseView
{
    private $courseRepository;
    private $userRepository;
    private $postRepository;
    private $uploadView;
    private $commentRepository;
    private $loginModel;
    private $imagesModel;
    private $title = "message";
    private $hiddenFeedId = "hiddenFeedId";
    private $imgName = "imgName";
    private $postContent = "Post";
    private $postTitle = "Title";
    private $date = "Date";
    private $rssFeedView;   

   


    public function __construct() 
    {
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
        $this->courseRepository = new CourseRepository();
        $this->loginModel = new LoginModel();
        $this->uploadView = new UploadView();   
        $this->imagesModel = new ImagesModel();
        $this->rssFeedView = new RSSFeedView();

    }

   public function showCourseFeed($courseId) {
        $username = $this->loginModel->getUsername();
        $adminMenu = "";
        $pic = "";

        if ($this->loginModel->isAdmin()) 
        {
            $adminMenu .= "<li><a name='newCourse' href='?". $this->createNewCourseLocation . "'>Skapa ny kurs</a></li>";
        }

        $html = "<!DOCTYPE html>
        <html>
        <head>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js' type='text/javascript'></script>
        <script src='js/CommentSlideButton.js' type='text/javascript'></script>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' href='css/commentSlideStyle.css' /> 
        <title>LSN</title>
        </head>

        <body>
        <div class='container'>
        <br>";
        $user = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
        $Images = glob("imgs/*.*");
            foreach ($Images as $value) {  

              $img = $this->imagesModel->getImgs($username);
              if ($img->getImg() == basename($value)) {
                
                $html .= '<div id="imgArea"><img src="'.$value.'"><h4>'.$username.' är inloggad</h4></div>';
                $pic = $value;
              }
            }

        if(basename($pic) === "" && $user->getSex() == "Man") 
          {
             $html .= '<div id="imgArea"><img src="img/default.jpg"><h4>'.$username.' är inloggad</h4></div>';
          }
         else if(basename($pic) === "" && $user->getSex() == "Kvinna")
         {
            $html .= '<div id="imgArea"><img src="img/kvinna.png"><h4>'.$username.' är inloggad</h4></div>';
         }
        $html .= "
            <br><br>
            <nav class='navbar navbar-default' role='navigation'>
            <div class='navbar-header'>
              <button type='button' class='navbar-toggle' data-toggle='collapse' 
                 data-target='#example-navbar-collapse'>
                 <span class='sr-only'>Toggle navigation</span>
                 <span class='icon-bar'></span>
                 <span class='icon-bar'></span>
                 <span class='icon-bar'></span>
              </button>
           </div>
           <div class='collapse navbar-collapse' id='example-navbar-collapse'>
              <ul class='nav navbar-nav'>
                 $adminMenu
                 <li><a name='profile' href='?". $this->userProfileLocation . "&id=".$this->loginModel->getId()."'>Min profil</a></li>
                 <li><a name='logOut' href='?". $this->logOutLocation . "'>Logga ut</a></li>
              </ul>
           </div>
        </nav>
        $this->message";

        $html .= $this->GetFeedHTML($courseId);

        $html .= "</div>
        </body>
        </html>";

        return $html;
    }    

    public function GetFeedHTML($courseId)
    {
        $feedItems = $this->postRepository->getPosts($courseId);

        $html = "
        <h1 style='text-align:center'>" . $this->courseRepository->getCourseName($courseId) . "</h1>
        <div class='content'>";

        $html .= $this->uploadView->RenderUploadForm($courseId);
        $rssURL = $this->courseRepository->checkIfRSSUrlExists($courseId);

        if($rssURL != null)
        {
            $html.="<a name='renderRSS' href='?". $this->rssFeedLocation .'&'.$this->id.'='.$courseId."'>Klicka för att se de senaste kursinformationen från CoursePress</a></br></br></br></br></br>";
        }


        $html .= "<ul id='items'>";    

     // Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
     foreach ($feedItems as $feedItem) 
        {
                $html .= "<div class='post' id='post" . $feedItem[$this->id] . "'>";

                if ($this->loginModel->getId() == $feedItem['UserId']) 
                {
                    $html .= "<form class='post-remove' method='post' action=''> 
                    <input type='image' src='images/icon_del.gif' id='deletepost' border='0' alt='submit' />
                    <input type='hidden' name='" . $this->imgName . "' id='" . $this->imgName . "' value='" . $feedItem[$this->imgName] . "'>
                    <input type='hidden' name='" . $this->hiddenFeedId . "' id='" . $this->hiddenFeedId . "' value='". $feedItem[$this->id] ."'>
                    </form>";

                    $html .= "<form class='post-edit' method='post' action=''> 
                    <input type='hidden' name='" . $this->postContent . "' id='" . $this->postContent . "' value='" . BaseView::escape($feedItem[$this->postContent]) . "'>
                    <input type='hidden' name='" . $this->postTitle . "' id='" . $this->postTitle . "' value='" . BaseView::escape($feedItem[$this->postTitle]) . "'>
                    <input type='hidden' name='" . $this->hiddenFeedId . "' id='" . $this->hiddenFeedId . "' value='". $feedItem[$this->id] ."'>
                    <input type='image' src='images/icon_edit.png' id='editpost' border='0' alt='submit' />";
                }
                $html .= "<div class='date'>" . $feedItem[$this->date] . "</div>
                <a href='?profile&id=" . $feedItem['UserId'] . "'>" . $this->userRepository->getUsernameFromId($feedItem['UserId']) . "</a> delade:
                <div class='text-values'>
                <p>" . $feedItem[$this->postContent] . "</p>
                <p>". $feedItem[$this->postTitle] . "</p>
                </div>";

                if (empty($feedItem[$this->imgName]) == false) 
                {
                    $html .= "<img src='View/Images/" . $feedItem[$this->imgName] . "' width='500' height='315'>";
                }

                if (empty($feedItem[$this->youtubeCode]) == false) 
                {
                    $html .= "<iframe width='500' height='315' src='https://www.youtube.com/embed/". $feedItem[$this->youtubeCode] ."' frameborder='0' allowfullscreen></iframe>";                  
                }

                $html .= "
                </form>
                ";

                $comments = $this->commentRepository->GetCommentsForPost($feedItem[$this->id]);

                if (empty($comments) == false) 
                {
                    foreach ($comments as $comment) 
                    {
                        $data = $comment->GetData();

                        $data['date'] = strtotime($data['date']);

                        $html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '">';

                        if ($this->loginModel->getId() == $comment->GetUserId()) {
                            $html .=
                            '<a href="#" class="delete_button" id="' . $data["CommentId"] . '">
                            <img src="images/icon_del.gif" border="0" />
                            </a>';
                        }

                        $html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
                        <a href="?profile&id=' . $comment->GetUserId() . '">' . $comment->GetUsernameOfCreator() . '</a> skrev: <p>' . $data['body'] . '</p>
                        </div>';
                    }            
                }

                $html .= "<div id='addCommentContainer" . $feedItem[$this->id] . "' class='addCommentContainer'>
                    <form class='comment-form' method='post' action=''>
                        <div>
                            <input type='hidden' id='courseid' name='courseid' value='" . $courseId . "'>
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
        $html .= "<script type='text/javascript'>var course_id = " . $courseId . ";</script>
                </ul>
                <p id='loader'><img src='images/ajax-loader.gif'></p>
                </div>";

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

    public function hasSubmitRssFeedLocation() {
        
        if (isset($_GET[$this->rssFeedLocation])) {
            return true;
    }

        return false;
    }

    public function renderFeed($courseId)
    {
      return $this->showCourseFeed($courseId);
    }


  

}