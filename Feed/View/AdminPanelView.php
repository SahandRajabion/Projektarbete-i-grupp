<?php
	
	require_once('Model/LoginModel.php');
	require_once('Model/Dao/MessagesRepository.php');
	require_once('Model/Dao/UserRepository.php');
	require_once('Model/ImagesModel.php');
	/**
	* Admin panel
	*/
	class AdminPanelView extends BaseView
	{
		
		private $loginModel;
		private $pic;
		private $user;
		private $messagesRepository;
		private $userRepository;
		private $imagesModel;


		function __construct()
		{
			# code...
			$this->loginModel = new LoginModel();
			$this->messagesRepository = new MessagesRepository();
			$this->userRepository = new UserRepository();
			$this->imagesModel = new ImagesModel(); 
		}


		  public function AdminPanel() {
			
				$html = $this->cssView("Admin Panel");

				$html .= '<div class="row"><div class="panel panel-info"> <div class="panel-heading"><h4>Admin Panel</h4></div></div></div>';

			  if ($this->loginModel->isAdmin()) 
		          {
		          	  $html .= "<ul class='list-group'><a class='list-group-item' name='AdminPanel' href='?". $this->UserListLocation . "'>User Options</a></ul>";
		              $html .= "<ul class='list-group'><a class='list-group-item' name='newCourse' href='?". $this->createNewCourseLocation . "'>Create Course</a></ul>";
		          }
		      return $html;
  		  }



  		   public function UserList() {
		    
		     $users = $this->userRepository->getAllUser();

		   	 $html = $this->cssView("User List");	

		
    	        		

	   	     if ($users != null) {
                	$html .= ' <div class="row"><div class="panel panel-info"> <div class="panel-heading"><h4>List of available users</h4></div></div></div>';
	                foreach ($users as $usernames) {
	                	foreach ($usernames as $user) {
	                	
	                		$this->user = $user;
	                	}	 

	                	$userId = $this->userRepository->getUserIdByName($this->user);

	                	$dbRole = $this->userRepository->getRole($userId);

    	        	
			    		if($dbRole == 3) {
			    			# code...
			    			$role = "Upgrade";
			    		}
			    		else
			    		{
			    			$role = "Downgrade";
			    		}


	   					

	   						if ($userId != 0) {
	   								$html .= '<div class="panel panel-info">
	   							<div class="panel-body">';
	   								# code...
	   								  $html .= '<ul class="list-group"><a class="list-group-item" href="?profile&id='. $userId .'">'.$this->user.'</a></ul>';
	   								  	$html .= '<form role="form" action="" method="post"><tr>						
							    <td>
	               				<input type="hidden" name="' . $this->uppgradeLocation . '" id="' . $this->uppgradeLocation . '" value="'. $userId .'"></td>
	               				<td><button type="submit" name="' . $this->uppgradeUserLocation . '" class="btn btn-primary">'.$role." " .$this->user.'</button></td></br></br></form>
	               				<form role="form" action="" method="post">
	               				<td>
	               				<input type="hidden" name="' . $this->removeUserLocation . '" id="' . $this->removeUserLocation . '" value="'. $userId .'"></td>
	               				<td><button type="submit" name="' . $this->submitRemoveUserLocation . '" class="btn btn-danger">Delete ' .$this->user.'</button></td></tr></br></br></form></div></div>';
	   						}
	   						  
	   				
	           		}
                }
		      
		      return $html;
  		  }


  		    public function DidUserPressAdminPanel() {
		        if (isset($_GET[$this->AdminPanelLocation])) {
		            return true;
		        }
		        return false;
		    }

		     public function DidUserPressToUppgradeUser() {
		        if (isset($_POST[$this->uppgradeUserLocation])) {
		            return true;
		        }
		        return false;
		    }

		     public function DidUserPressToRemoveUser() {
		        if (isset($_POST[$this->submitRemoveUserLocation])) {
		            return true;
		        }
		        return false;
		    }


		    public function getUserToRemove() {
		        if (isset($_POST[$this->removeUserLocation])) {
		            return $_POST[$this->removeUserLocation];
		        }
		      
		    }


		    public function getUserToUppgrade() {
		        if (isset($_POST[$this->uppgradeLocation])) {
		            return $_POST[$this->uppgradeLocation];
		        }
		      
		    }

		     public function setMessage($message) {
      		  $this->message = $message;
    		}



		    public function DidUserPressUserList() {
		        if (isset($_GET[$this->UserListLocation])) {
		            return true;
		        }
		        return false;
		    }



		     public function renderAdminPanel() { 		
			    $Panel = $this->AdminPanel();
			    return $Panel;
			  }


			 public function renderUserList() {
			    $userList = $this->UserList();
			    return $userList;
			  }

			 public function cssView($title = null) {

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
				          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
				          $this->pic = $value;
				        }
				    }

				    if (basename($this->pic) === "" && $users->getSex() == "Man") 
				    {
				        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
				    }
				    else if (basename($this->pic) === "" && $users->getSex() == "Kvinna")
				    {
				        $userPic .= '<div><img id="profileImage" src="img/kvinna.png" <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
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
				        <title> ' . $title . ' | LSN</title>
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
				                <li><a name="logOut" href="?' . $this->logOutLocation . '">Log Out</a></li>
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