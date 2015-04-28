<?php
require_once('View/BaseView.php');
require_once("./Model/LoginModel.php");


class ProgramView extends baseView {
    private $model;
    private $phone;


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
		<h1>Course Page</h1>
		<br/>

		<div id='UD'>
        <a href='?". $this->UDCourseLocation . "'><img src='img/ud.jpg'/></a>

        </div>

        <div id='WP'>
        <a href='WPCourseView.php'><img src='img/wp.png'/></a>
        </div>

        <div id='ID'>
        <a href='IDCourseView.php'><img src=''/></a>
        </div>

        <div id='Public'>
        <a href='PublicCourseView.php'><img src='img/Penguins.jpg'/></a>
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
}