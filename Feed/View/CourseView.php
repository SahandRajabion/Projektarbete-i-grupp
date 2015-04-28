<?php

require_once('Model/Dao/CourseRepository.php');
require_once('View/BaseView.php');
require_once('Model/LoginModel.php');



class CourseView extends BaseView
{
    private $courseRepository;
    private $model;
    private $test;
 

    public function __construct() 
    {
        $this->courseRepository = new CourseRepository();
        $this->model = new LoginModel();

    }
     

     public function GetCourseHTML($id)
    {	

    	$nrcourses = $this->courseRepository->GetAllCourseNr($id);

    	foreach ($nrcourses as $key) {
    		# code...
    		$courses[] = $this->courseRepository->getCourses($key);
    	}

    	
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

      if ($courses != null) {
      	# code...

      		  foreach ($courses as $course) 
     		   {
     		   	foreach ($course as $key) {
     		   		# code...
     		   		$html .="<div class='items'> <li> <a href='?Course=" . $key . "'>" . $key . "</li></div></br>";
     		   	}

                
      		  }

      }
   
    
        $html .= "</div>
                </body>
                </html>";

        return $html;
    }
}