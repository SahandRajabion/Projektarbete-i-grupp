<?php

require_once('Model/Dao/CourseRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('View/BaseView.php');
require_once('Model/LoginModel.php');



class CourseView extends BaseView
{
    private $courseRepository;
    private $model;
    private $key;
    private $postRepository;

    public function __construct() 
    {
        $this->courseRepository = new CourseRepository();
        $this->postRepository = new PostRepository();
        $this->model = new LoginModel();


    }

    public function getProgramName($id) 
    {
      if ($id === 1) 
      {
        return "Webbprogrammerare";
      }
      else if ($id === 2)
      {
        return "Utvecklare av digitala tjänster";
      }
      else if ($id === 3)
      {
        return "Interaktionsdesigner";
      }
    }
     

     public function GetCourseHTML($id)
     {    
          $programName = $this->getProgramName($id);
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
          <h1>Kurser inom " . $programName . "</h1>
          $this->message
          ";

        $nrcourses = $this->courseRepository->GetAllCourseNr($id);

        if (isset($nrcourses) && empty($nrcourses) == false) 
        {
          foreach ($nrcourses as $key) {
              # code...
              $courses[] = $this->courseRepository->getCourses($key);
              $this->key = $key;
          }

        if ($courses != null) {

                foreach ($courses as $course) 
                 {

                  foreach ($course as $key) {
                      # code...

                      $courseId =$this->courseRepository->getCourseID($key);
                      $html .="<div class='items'> <li> <a href='?".$this->course."&".$this->id."=".$courseId. "'>" . $key . "</li></div></br>";
                  }
                }
        }
      }
                $html .= "</div>    
                  </body>
                  </html>";

          return $html;
    }

    // public function getSkiten() {

    //     return $_SESSION[$this->session];

    // }


    public function hasSubmitAcourse() {
         if (isset($_GET[$this->course])) {
            return true;
        }

        return false;
    }

}