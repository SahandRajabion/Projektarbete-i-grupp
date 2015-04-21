<?php

require_once("./View/LoginView.php");
require_once("./Model/LoginModel.php");
require_once("View/BaseView.php");
require_once('View/FeedView.php');

class LoggedInView extends BaseView 
{
    private $feedView;
    private $model;
    private $username;

    public function __construct() {
        $this->model = new LoginModel();
        $this->feedView = new FeedView();
    }
   
    public function showLoggedInPage() {
        $this->username = $this->model->getUsername();

        $html = "<!DOCTYPE html>
        <html>
        <head>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js' type='text/javascript'></script>
        <script src='js/CommentSlideButton.js' type='text/javascript'></script>
        <meta http-equiv='Content-Type'content='text/html; charset=utf-8' />
        <link rel='stylesheet' type='text/css' href='css/commentSlideStyle.css' /> 
        <title>LSN</title>
        </head>

        <body>
        <div class='container'>";

        $html .= "
            <br><br>
            <h4>$this->username is logged in</h4>    
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
                 <li><a name='changePassword' href='?" . $this->changePasswordLocation . "'>Change password</a></li>
                 <li><a name='logOut' href='?". $this->logOutLocation . "'>Log ut</a></li>
              </ul>
           </div>
        </nav>
        $this->message
        ";

        $html .= $this->feedView->GetFeedHTML();

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