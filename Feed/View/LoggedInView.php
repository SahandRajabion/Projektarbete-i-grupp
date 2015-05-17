<?php

require_once("./View/LoginView.php");
require_once("./Model/LoginModel.php");
require_once("./Model/ImagesModel.php");
require_once("View/BaseView.php");
require_once('View/FeedView.php');
require_once('Model/Dao/MessagesRepository.php');

class LoggedInView extends BaseView 
{
    private $feedView;
    protected $loginModel;
    protected $imagesModel;
    protected  $pic;
    private $messagesRepository;

    public function __construct() {
        $this->loginModel = new LoginModel();
        $this->imagesModel = new ImagesModel();
        $this->feedView = new FeedView($this->loginModel);
        $this->messagesRepository = new MessagesRepository();
    }

    public function GetUserProfileDetails($id) 
    {
        return $this->loginModel->GetUserProfileDetails($id);
    }
   
    public function showPublicCourseFeed() {


        $html = $this->feedView->GetFeedHTML(1);
   

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