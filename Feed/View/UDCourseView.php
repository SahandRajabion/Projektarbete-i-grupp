<?php

require_once('Model/Dao/CourseRepository.php');
require_once('View/BaseView.php');


class UDCourseView extends BaseView
{
    private $courseRepository;
 

    public function __construct() 
    {
        $this->courseRepository = new CourseRepository();
    }
           
    

    public function GetUDCourseHTML()
    {
        $id = intval($_GET['id']);
        $courses = $this->courseRepository->GetAllCourses($id);
        
     
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


     foreach ($courses as $course) 
        {

                $html .=" <li> <a href='?" . $course['CourseName'] . "'></li>";

               
        }

    
        $html .= "</div>
                </body>
                </html>";

        return $html;
    }




  

}