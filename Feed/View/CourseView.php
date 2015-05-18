<?php

require_once('Model/Dao/MessagesRepository.php');
require_once('Model/Dao/CourseRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('View/BaseView.php');
require_once('Model/LoginModel.php');
require_once('Model/ImagesModel.php');


class CourseView extends BaseView
{
    private $courseRepository;
    protected $loginModel;
    private $key;
    private $postRepository; 
    private $messageRepository;
    protected $imagesModel;

    public function __construct() 
    {
        $this->courseRepository = new CourseRepository();
        $this->postRepository = new PostRepository();
        $this->loginModel = new LoginModel();
        $this->imagesModel = new ImagesModel();
        $this->messageRepository = new MessagesRepository();
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
     
             $html = $this->cssView("Courses for " . $this->getProgramName($id) . " | LSN");

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

            $html .= '<h2 class="sub-header">Courses for ' . $programName . '</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Course Code</th>
                  <th>Course Name</th>
                </tr>
              </thead>
              <tbody>';

                $nrcourses = $this->courseRepository->GetAllCourseNr($id);

                if (isset($nrcourses) && empty($nrcourses) == false) 
                {
                    foreach ($nrcourses as $key) 
                    {
                        $courses[] = $this->courseRepository->getCourses($key);
                    }

                    if ($courses != null && empty($courses) == false) 
                    {
                        foreach ($courses as $course) 
                        {

                            foreach ($course as $key) 
                            {
                                $courseId = $this->courseRepository->getCourseID($key);
                                $courseCode = $this->courseRepository->getCourseCode($courseId);

                                $html .= 
                                        '<tr>
                                          <td>' . $courseCode . '</td>
                                          <td>' . $key . '</td>
                                          <td>
                                          <a href="?' . $this->course . '&' . $this->id . '=' . $courseId. '"> <span class="glyphicon glyphicon-home" aria-hidden=true></span> Visit Course Feed</a>
                                          </td>';
                                    if ($this->loginModel->isAdmin()) {
                                     $html .= '<td>
                                          '.$this->EditCourse($courseId,$courseCode,$key).'
                                          </td>
                                        </tr>';
                                      }
                            }
                        }
                    }
                }
                
                  $html .= '</tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    ';

    

    return $html;
    }


    public function EditCourse($courseId,$code,$name) {

           $html = '<div class="panel panel-info">
            <div class="panel-body">
              <div class="row">                
                <div class=" col-md-9 col-lg-9 "> 
                <form role="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>
                       <div class="input-group">
                       <p>Course name</p>
                        <input id="fName" class="form-control input-lg" name="' . $this->courseNamesLocation . '" value="' . $name . '" type="text" size="20" maxlength="20" placeholder="Course name" />
                        </div>
                        </td>
                      </tr>
                      <tr>
                      <td>
                      <div class="input-group">
                      <p>Course code</p>
                        <input id="lName" class="form-control input-lg" name="' . $this->courseCodesLocation . '" value="' . $code . '" type="text" size="20" maxlength="20" placeholder="Course code" />
                        
                         </div>
                         </td>
                      </tr>
                      <tr>
                      <td>
                      <input type="hidden" name="'.$this->CourseId.'" value="'.$courseId.'">
                    <input class="btn btn-primary" name="' . $this->editCourseLocation . '" type="submit" value="Update" />
                    </td>
                    </tbody>
                  </table>
                  </form>
                </div>
              </div>
            </div>';

            return $html;
    }

    public function hasSubmitAcourse() {
         if (isset($_GET[$this->course])) {
            return true;
        }

        return false;
    }

  public function hasSubmitToEditCourse() {
   
         if (isset($_POST[$this->editCourseLocation])) {

            return true;
        }
    }





     public function getCourseID() {
       if (isset($_POST[$this->CourseId])) {
            return $_POST[$this->CourseId];
        }
   }


    public function getCourseNameAfterEdit() {

       if (isset($_POST[$this->courseNamesLocation])) {
            return $_POST[$this->courseNamesLocation];
        }
   } 

  public function getCourseCodeAfterEdit() {
      if (isset($_POST[$this->courseCodesLocation])) {
            return $_POST[$this->courseCodesLocation];
        }
   } 
}