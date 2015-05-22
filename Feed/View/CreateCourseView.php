<?php

require_once("View/BaseView.php");
require_once("Model/ImagesModel.php");
require_once('Model/Token.php');

class CreateCourseView extends BaseView
{
	protected $loginModel;
	protected $imagesModel;
	private $messageRepository;

	public function __construct(LoginModel $model,MessagesRepository $messageRepository) 
	{
		$this->imagesModel = new ImagesModel();
		$this->loginModel = $model;
		$this->messageRepository = $messageRepository;
	}


    /**
    * Function to render message
    */
    public function setMessage($message) {
        $this->message .= $message;
    }

	public function DidUserPressToCreateCourse() {
		if (isset($_GET[$this->createNewCourseLocation])) {
			return true;
		}

		return false;
	}

	public function DidUserPressSubmitNewCourse() 
	{
		if (isset($_POST[$this->submitNewCourseLocation])) 
		{
			return true;			
		}

		return false;
	}	

	public function GetCheckedBoxes() 
	{
		if (isset($_POST[$this->programCheckBoxLocation])) 
		{
  			$checkedBoxes = array();

  			foreach ($_POST[$this->programCheckBoxLocation] as $checked) 
  			{
            if ($checked === "1" ||  $checked === "2" || $checked === "3") 
            {
    				  $checkedBoxes[] = $checked;
            }
  			}
        
  			return $checkedBoxes;
		}
	}

	public function GetCourseName() 
	{
		if (isset($_POST[$this->courseNameLocation])) 
		{
			return $_POST[$this->courseNameLocation];
		}
	}

	public function GetCourseCode() 
	{
		if (isset($_POST[$this->courseCodeLocation])) 
		{
			return $_POST[$this->courseCodeLocation];
		}
	}

	public function GetRSSUrl() 
	{
		if (isset($_POST[$this->rssUrlLocation])) 
		{
			return $_POST[$this->rssUrlLocation];
		}
	}	


  public function GetSchema() 
  {
    if (isset($_POST[$this->schemaLocation])) 
    {
      return $_POST[$this->schemaLocation];
    }
  } 
	

	public function ShowCreateCourseForm() 
	{
    // BEHÖVS
    $Images = glob("imgs/*.*");

          $username = $this->loginModel->getUsername();


            $html = $this->cssView("Create Course");

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


      $html .= '<form role="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
          <h2 class="sub-header">Create Course</h2> 

              <div class="form-group">
                  <input type="text" placeholder="Course Name" name="' . $this->courseNameLocation . '" size="40" maxlength="40" class="form-control input-lg" >                    
                </div>

              <div class="form-group">
                    <input type="text" placeholder="Course Code" size="6" maxlength="6" name="' . $this->courseCodeLocation . '" class="form-control input-lg" >                            
              </div>

              <div class="form-group">
              <em>(optional)</em>
                    <input type="text" placeholder="RSS Feed Url" size="40" maxlength="255" name="' . $this->rssUrlLocation . '" class="form-control input-lg" >                            
              </div>

              <div class="form-group">
              <em>(optional)</em>
                    <input type="text" placeholder="Schema Url" size="40" maxlength="255" name="' . $this->schemaLocation . '" class="form-control input-lg" >                            
              </div>

              <div class="form-group">
              <label>Course should be under</label>
              <div class="checkbox">
              <label>
                <input type="checkbox" name="' . $this->programCheckBoxLocation . '[]" value="1">
                  Webbprogrammerare
              </label>
              </div>

              <div class="checkbox">
              <label>
                <input type="checkbox" name="' . $this->programCheckBoxLocation . '[]" value="2">
                  Utvecklare av digitala tjänster
              </label>
              </div>

              <div class="checkbox">
              <label>
                <input type="checkbox" name="' . $this->programCheckBoxLocation . '[]" value="3">
                  Interaktionsdesigner
              </label>
              </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <input type="hidden" name="CSRFToken" value="' . Token::generate() . '" />
                  <input type="submit" name="' . $this->submitNewCourseLocation . '" value="Create Course" class="btn btn-primary btn-block btn-lg">
                </div>
              </div>
            </form>
            </div>
            ';



    return $html;	
	}
}
