<?php
require_once('View/BaseView.php');
require_once("./Model/LoginModel.php");


class ProgramView extends baseView {
    private $model;


		public function __construct() {
				//<a href='?$this->loginLocation'>Tillbaka</a>
			        $this->model = new LoginModel();

	
		}

		public function showCoursePage() {

		$html = "<!DOCTYPE html>
				<html>
				<head>
                <title>CoursePage</title>				
				<meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
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
                 <li><a name='profile' href='?". $this->userProfileLocation . "&id=".$this->model->getId()."'>Min profil</a></li>
                 <li><a name='logOut' href='?". $this->logOutLocation . "'>Logga ut</a></li>
              </ul>
           </div>
        </nav>
        $this->message
        ";
        $html .= "</div>
        </body>
        </html>";
				 	
		$html .= "
		</br>
		<h1>Course Page</h1>
		<br/>

		<div id='UD'>
        <a href='UDCourseView.php'><img src='img/Penguins.jpg'/></a>
        </div>

        <div id='WP'>
        <a href='WPCourseView.php'><img src='img/wp.jpg'/></a>
        </div>

        <div id='ID'>
        <a href='IDCourseView.php'><img src='img/Penguins.jpg'/></a>
        </div>

        <div id='Public'>
        <a href='IDCourseView.php'><img src='img/Penguins.jpg'/></a>
        </div>

        ";


		$html .= "</div>
				</body>
				</html>";

		return $html;
	}


	public function didUserPressReturnToLoginPage() {
		if (isset($_POST[$this->loginLocation])) {
			return true;
		}
		return false;
	}


	public function pressSubmitToSend() {
		if (isset($_POST[$this->forgetPasswordLocation])) {
			# code...
			return true;
		}
		return false;
	}



	public function getEmail() {
		if (isset($_POST[$this->emailLocation])) {
		
				return htmlentities($_POST[$this->emailLocation]);
			
			
		}
	}
}