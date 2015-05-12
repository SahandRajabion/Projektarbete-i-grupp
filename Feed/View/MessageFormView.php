<?php
 
	require_once('View/HTMLView.php');
	require_once('View/BaseView.php');
	require_once('Model/LoginModel.php');

	/**
	* inbox
	*/
	class MessageFormView extends BaseView
	{
		  private $mainView;
		  private $loginModel;
		  private $pic;
		  private $messagesRepository;
		
		public function __construct()
		{
			# code...
			$this->mainView = new HTMLView();
		    $this->loginModel = new LoginModel();
		    $this->messagesRepository  = new MessagesRepository();
		   
		}


		public function createMessageView() {
			$FromUser = $this->loginModel->getUsername();
			$toUser = $this->getId();


			$html = $this->cssView();

			$html .= " 
			</br>
			<div class='jumbotron'>
	                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
	                       <fieldset>
							 <div class='form-group'>
						         <div class='col-sm-10'>
						           <input class='form-control' name='$this->usernameLocation' value='".$FromUser."' type='hidden'>
						         </div>
						      </div>


						       <div class='form-group'>
						         <div class='col-sm-10'>
						           <input class='form-control' name='$this->toUserIdLocation' value='".$toUser."' type='hidden'>
						         </div>
						      </div>

						     <div class='form-group'>
						         <label class='col-sm-2 control-label' for='$this->subjectLocation'>Subject: </label>
						         <div class='col-sm-10'>
						           <input class='form-control' name='$this->subjectLocation' type='text' value='".$this->getUserSubject()."' maxlength='32'>
						         </div>
						      </div>

						      <div class='form-group'>
						         <label class='col-sm-2 control-label' for='$this->sendMessageLocation'>Message: </label>
						         <div class='col-sm-10'>
						           <textarea rows='20' cols='50' class='form-control' name='$this->sendMessageLocation' type='text' value='".$this->getUserMsg()."' maxlength='500'></textarea>
						         </div>
						      </div>
						         <input class='btn btn-default' name='$this->submitSendMsgLocation' type='submit' value='Send' />
						       </div>
						     </div>
						   </fieldset>
				       </form></div>";

			          
			     $html .= '
			     <script src="js/jquery.min.js"></script>
			        <script src="js/bootstrap.min.js"></script>
			        <script src="js/ie10-viewport-bug-workaround.js"></script>
			      </body>
			    </html>';	     	       
			
			return $html;
		}

	
		public function rednerMessageFormView() {

			return $this->createMessageView();
		}


		public function didUserPressToSendMsg() {
		
			if (isset($_POST[$this->submitSendMsgLocation])) {
				return true;
			}

			return false;
		}


		public function getUserName() {
			if (isset($_POST[$this->usernameLocation])) {
				return $_POST[$this->usernameLocation];
			}
		}


		public function getToUserId() {
			if (isset($_POST[$this->toUserIdLocation])) {
				return $_POST[$this->toUserIdLocation];
			}
		}


		public function getUserSubject() {
			if (isset($_POST[$this->subjectLocation])) {
				return $_POST[$this->subjectLocation];
			}
		}


		public function getUserMsg() {
			if (isset($_POST[$this->sendMessageLocation])) {
				return $_POST[$this->sendMessageLocation];
			}
		}

		public function setMessage($message) {
      	  $this->message = $message;
    	}


    			public function cssView() {

			    // BEHÖVS
    	  $Images = glob("imgs/*.*");

          $username = $this->loginModel->getUsername();

          $adminMenu = "";
          $userPic = "";
          $userPicProfile = "";


        
          if ($this->loginModel->isAdmin()) 
          {
          	  $adminMenu .= "<li><a name='AdminPanel' href='?". $this->AdminPanelLocation . "'>Admin Panel</a></li>";
          }

    /// PROFIL BILD FÖR NAV 
    $users = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
    
    foreach ($Images as $value) 
    {  
        $img = $this->imagesModel->getImages($this->loginModel->getId());
        if ($img->getImgName() == basename($value)) 
        {        
          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName">' . $username . '</label></div>';
          $this->pic = $value;
        }
    }

    if (basename($this->pic) === "" && $users->getSex() == "Man") 
    {
        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName">' . $username . '</label></div>';
    }
    else if (basename($this->pic) === "" && $users->getSex() == "Kvinna")
    {
        $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName">' . $username . '</label></div>';
    }

     $html = 
    '<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <link rel="icon" href="../../favicon.ico">
        <title>LSN</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet">
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="script.js"></script>

        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      </head>

      <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="?">LSN</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

              <form class="navbar-form navbar-right" role="search" method="post" enctype="multipart/form-data">
              <div class="form-group">
              <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
             
              <div class="input_container">
                <input type="text" id="course_id" onkeyup="autocomplet()" name="' . $this->searchLocation . '" size="20" maxlength="20" class="form-control1" placeholder="Search">
                <ul id="course_list_id"></ul>
                </div>
              </div>
              </div>
              <button type="submit" name="' . $this->submitSearchLocation . '" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
            </form>
              

              <ul class="nav navbar-nav navbar-right">
              <li>' . $userPic . '</li>
                ' . $adminMenu . '
                <li><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">My profile</a></li>
                <li><a name="logOut" href="?' . $this->logOutLocation . '">Log out</a></li>
              </ul>
              
            </div>
          </div>
        </nav>

        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
              <ul class="nav nav-sidebar">
                <li><a href="?">Available Programmes</a></li>';
           
                $open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

            
                  if ($open != null) {
                        # code...
                       if ($open == 1) {
                         # code...
                         $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox (One new message)</a></li>';
                       }
                       else {
                           $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox ('.$open.' new messages)</a></li>';
                       }
                  }
                  else {
                      $html .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li>';
                  }
                 
              $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
              '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
              </ul>
            </div>';


            $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            ' . $this->message . '';


        
	

    return $html;
		}
	}