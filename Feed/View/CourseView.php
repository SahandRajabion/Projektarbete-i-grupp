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
     
             $html = $this->cssView("Courses for " . $this->getProgramName($id));

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


    public function hasSubmitAcourse() {
         if (isset($_GET[$this->course])) {
            return true;
        }

        return false;
    }

 
}