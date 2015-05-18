<?php

require_once("Model/AdminModel.php");
require_once("Model/Token.php");
require_once("View/CourseView.php");

class AdminController 
{
    private $adminModel;
    private $loginModel;
    private $createCourseView;
    private $htmlView;
    private $courseView;

    public function __construct(LoginModel $model,CreateCourseView $createCourseView,HTMLView $htmlView) 
    {
        $this->adminModel = new AdminModel();
        $this->loginModel = $model;
        $this->createCourseView = $createCourseView;
        $this->htmlView = $htmlView;
        $this->courseView = new CourseView();
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
                $schema = $this->createCourseView->GetSchema();

                $message = $this->adminModel->createNewCourse($checkedBoxValues, $courseName, $courseCode, $rssFeedUrl,$schema);

                $this->createCourseView->setMessage($message);
                $this->htmlView->echoHTML($this->createCourseView->ShowCreateCourseForm());
            }
        }
    }


    
}


    
        
    