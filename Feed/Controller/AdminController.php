<?php

require_once("Model/AdminModel.php");
require_once("Model/LoginModel.php");
require_once("View/CreateCourseView.php");
require_once("Model/Token.php");

class AdminController 
{
    private $adminModel;
    private $loginModel;
    private $createCourseView;
    private $htmlView;

    public function __construct() 
    {
        $this->adminModel = new AdminModel();
        $this->loginModel = new LoginModel();
        $this->createCourseView = new CreateCourseView();
        $this->htmlView = new HTMLView();
    }

    public function CreateNewCourse() 
    {
        $token = $this->createCourseView->getToken();
        
        if (Token::check($token))
        {
            if ($this->loginModel->isAdmin()) 
            {
                $checkedBoxValues = $this->createCourseView->GetCheckedBoxes();
                $courseName = $this->createCourseView->GetCourseName();
                $courseCode = $this->createCourseView->GetCourseCode();
                $rssFeedUrl = $this->createCourseView->GetRSSUrl();

                $message = $this->adminModel->createNewCourse($checkedBoxValues, $courseName, $courseCode, $rssFeedUrl);

                $this->createCourseView->setMessage($message);
                $this->htmlView->echoHTML($this->createCourseView->ShowCreateCourseForm());
            }
        }
    }
    
}


    
        
    