<?php
require_once('View/BaseView.php');
require_once('Model/Dao/MessagesRepository.php');
require_once("./Model/LoginModel.php");
require_once("./Model/ImagesModel.php");

class ProgramView extends baseView {
    protected $loginModel;
    private $messageRepository;
    protected $imagesModel;

    public function __construct() 
    {
      $this->loginModel = new LoginModel();
      $this->imagesModel = new ImagesModel();
      $this->messageRepository = new MessagesRepository();
    }

    public function showCoursePage() {
               
               $html = $this->cssView("Program");

          $open = $this->messageRepository->getIfOpenOrNot($this->loginModel->getId());

                
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
              
              $html .= '
              <h1 class="page-header">Available Progammes</h1>

              <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->UDCourseLocation . '">
                  <img src="img/ud2.png" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->WPCourseLocation . '">
                  <img src="img/wp2.png" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->IDCourseLocation . '">
                  <img src="img/id2.png" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="?' . $this->PUCourseLocation . '">
                  <img src="img/public2.png" class="img-thumbnail">
                  </a>
                </div>
              </div>';

    


    return $html;
  }







   public function didUserPressUD() {
        if (isset($_GET[$this->UDCourseLocation])) {
            return true;
        }
        return false;

    }

     public function didUserPressID() {
        if (isset($_GET[$this->IDCourseLocation])) {
            return true;
        }
        return false;

    }

     public function didUserPressWP() {
        if (isset($_GET[$this->WPCourseLocation])) {
            return true;
        }
        return false;

    }

     public function didUserPressPU() {
        if (isset($_GET[$this->PUCourseLocation])) {
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




    public function hasSubmitToSearch() {

      if (isset($_POST[$this->submitSearchLocation])) { 
        return true;
      }
    }


    public function getSearchValue() {
      if (isset($_POST[$this->searchLocation])) {
        return trim($_POST[$this->searchLocation]);
      }
    }





}