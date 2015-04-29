<?php
require_once('View/BaseView.php');
require_once("./Model/LoginModel.php");

class ProgramView extends baseView {
    private $model;

    public function __construct() {

    $this->model = new LoginModel();

    }

    public function showCoursePage() {
    $this->username = $this->model->getUsername();
        $adminMenu = "";

        if ($this->model->isAdmin()) 
        {
            $adminMenu .= "<li><a name='newCourse' href='?". $this->createNewCourseLocation . "'>Skapa ny kurs</a></li>";
        }

     $html = "<!DOCTYPE html>
      <html>
      <head>
      <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
    <link rel='stylesheet' type='text/css' href='css/styleVal.css' /> 
    <link rel='stylesheet' type='text/css' href='css/programStyle.css' />   
    <script src='js/script.js'></script>
      <title>LSN</title>                
      <meta charset='utf-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      </head>
      <body>
       <div class='container'>";    

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
        $this->message
        ";
        
          
    $html .= "
    </br>
    <div id='title'>
    <h1>Vad läser du för program ?</h1>
    </div>
    <br/>

    <div id='UD'>
    <div class= 'mg-image'>
        <a href='?". $this->UDCourseLocation . "'><img src='img/UD.gif'/></a>
        </div>
        </div>


        <div id='WP'>
        <div class= 'mg-image'>
        <a href='?". $this->WPCourseLocation . "'><img src='img/WP.gif'/></a>
        </div>
        </div>


        <div id='ID'>
        <div class= 'mg-image'>
        <a href='?". $this->IDCourseLocation . "'><img src='img/ID.png'/></a>
        </div>
        </div>


        <div id='public'>
        <div class= 'mg-image'>
        <a href='?". $this->PUCourseLocation . "'><img src='img/public.png'/></a>
        </div>
        </div>
        ";


    $html .= "</div>
        </body>
        </html>";

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
}