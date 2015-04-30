<?php

require_once("./View/LoginView.php");
require_once("./Model/LoginModel.php");
require_once("./Model/ImagesModel.php");
require_once("View/BaseView.php");
require_once('View/FeedView.php');

class LoggedInView extends BaseView 
{
    private $feedView;
    private $model;
    private $username;
    private $imagesModel;
    private $pic;

    public function __construct() {
        $this->model = new LoginModel();
        $this->imagesModel = new ImagesModel();
        $this->feedView = new FeedView();
    }

    public function GetUserProfileDetails($id) 
    {
        return $this->model->GetUserProfileDetails($id);
    }
   
    public function showPublicCourseFeed() {
        $this->username = $this->model->getUsername();
        $adminMenu = "";

        if ($this->model->isAdmin()) 
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
        $user = $this->GetUserProfileDetails($this->model->getId());
        $Images = glob("imgs/*.*");
            foreach ($Images as $value) {  

              $img = $this->imagesModel->getImgs($this->username);
              if ($img->getImg() == basename($value)) {
                
                $html .= '<div id="imgArea"><img src="'.$value.'"><h4>'.$this->username.' är inloggad</h4></div>';
                $this->pic = $value;
              }
            }

        if(basename($this->pic) === "" && $user->getSex() == "Man") 
          {
             $html .= '<div id="imgArea"><img src="img/default.jpg"><h4>'.$this->username.' är inloggad</h4></div>';
          }
         else if(basename($this->pic) === "" && $user->getSex() == "Kvinna")
         {
            $html .= '<div id="imgArea"><img src="img/kvinna.png"><h4>'.$this->username.' är inloggad</h4></div>';
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
                 <li><a name='profile' href='?". $this->userProfileLocation . "&id=".$this->model->getId()."'>Min profil</a></li>
                 <li><a name='logOut' href='?". $this->logOutLocation . "'>Logga ut</a></li>
              </ul>
           </div>
        </nav>
        $this->message";

        // Hård kodat för få ut allmänt
        $html .= $this->feedView->GetFeedHTML(1);
        $html .= "</div>
        </body>
        </html>";

        return $html;
    }
 
    /**
     * @return bool true if user has pressed log out else false
     */
    public function didUserPressLogOut() {
        if (isset($_GET[$this->logOutLocation])) {
            return true;
        }
        return false;

    }

    public function didUserPressAdminPanel() {
        if (isset($_GET[$this->adminPanelLocation])) {
            return true;
        }
        return false;
    }

    /**
     * @param $message string containing feedback
     */
    public function setMessage($message) {
        $this->message = $message;
    }
}