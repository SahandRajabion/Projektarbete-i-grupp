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
        $this->username = $this->loginModel->getUsername();
       
        // Hård kodat för få ut allmänt
         $html = $this->cssView("LoggedInView");

          $open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

                
                      if ($open != null) {
                            # code...
                           if ($open == 1) {
                                                  # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
                      }
                      else {
                          $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
                      }
                     
                  $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
                  '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
                  </ul>
                </div>';


                $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                ' . $this->message . '';


        $html .= $this->feedView->GetFeedHTML(1);
   

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