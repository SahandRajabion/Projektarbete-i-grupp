<?php

require_once("Model/Dao/CourseRepository.php");

class AdminModel
{
	private $validationErrors = 0;
	private $adminRepository;

	public function __construct() 
	{
		$this->courseRepository = new CourseRepository();
	}

    public function CreateNewCourse($checkBoxValues, $courseName, $courseCode) 
    {
    	if ($this->validationErrors == 0) 
    	{
	    	if (strlen($courseName) < 1) 
	    	{
	    		$this->validationErrors++;
	    		$msgId = 35;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;
	    	}
    	}

    	if ($this->validationErrors == 0) 
    	{
	    	if (htmlspecialchars($courseName) != $courseName) 
	    	{ 	
	    		$this->validationErrors++;
	    		$msgId = 34;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;
	    	}
    	}

    	if ($this->validationErrors == 0) 
    	{
	    	if ($this->courseRepository->CourseNameExists($courseName)) 
	    	{ 	
	    		$this->validationErrors++;
	    		$msgId = 38;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;
	    	}
    	}

	   	if ($this->validationErrors == 0) 
	    {
	    	if ($this->courseRepository->CourseCodeExists($courseCode)) 
	    	{ 	
	    		$this->validationErrors++;
	    		$msgId = 38;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;
	    	}
	    }

    	if ($this->validationErrors == 0) 
    	{
		    if (strlen($courseCode) < 1) 
		    {
	    		$this->validationErrors++;
	    		$msgId = 36;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;
	    	}
    	}

    	if ($this->validationErrors == 0) 
    	{
    		if (strlen($courseCode) > 6) 
	    	{
	    		$this->validationErrors++;
	    		$msgId = 39;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;	
	    	}
    	}


    	if ($this->validationErrors == 0) 
    	{
	    	if (htmlspecialchars($courseCode) != $courseCode && preg_match('/^[\w]+$/', $courseCode) == false) 
	    	{
	    		$this->validationErrors++;
	    		$msgId = 37;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;
	    	}
    	}

    	if ($this->validationErrors == 0) 
    	{
	    	if (empty($checkBoxValues)) 
	    	{
	    		$this->validationErrors++;
	    		$msgId = 20;
	            $this->loginMessage = new LoginMessage($msgId);        
	            $message = $this->loginMessage->getMessage();

	            echo $message;
	    	}
    	}

    	if ($this->validationErrors == 0) 
    	{
    		$courseId = $this->courseRepository->AddCourse($courseName, $courseCode);

    		foreach ($checkBoxValues as $programId) 
    		{
    			$this->courseRepository->AddCourseToProgram($programId, $courseId);
    		}

    		$msgId = 40;
            $this->loginMessage = new LoginMessage($msgId);        
            $message = $this->loginMessage->getMessage();

            echo $message;	
    	}
	}
}



    