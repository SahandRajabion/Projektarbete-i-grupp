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
		
		public function __construct()
		{
			# code...
			$this->mainView = new HTMLView();
		    $this->loginModel = new LoginModel();
		   
		}


		public function createMessageView() {
			$FromUser = $this->loginModel->getUsername();
			$toUser = $this->getId();


				 $html = "<!DOCTYPE html>
		    <html>
		    <head>
		    <meta charset='utf-8'>
		    <meta name='viewport' content='width=device-width, initial-scale=1'>
		    <link rel='stylesheet' href='css/styles.css'>
		    <link rel='stylesheet' href='css/bootstrap.min.css'>
		    </head>
		    <body>
		     <div class='container'>";		

			$html .= " 
			</br>
			<a href='?'>Tillbaka</a>
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
				       </form>";

			            $html .= "</div>
	                </body>
	                </html>";     	       
			
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



	}