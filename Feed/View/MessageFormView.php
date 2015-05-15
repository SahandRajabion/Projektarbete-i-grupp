<?php
 
	require_once('View/BaseView.php');

	/**
	* inbox
	*/
	class MessageFormView extends BaseView
	{
    protected $imagesModel;
		  private $mainView;
		  protected $loginModel;
		  private $messagesRepository;
		
		public function __construct(HTMLView $mainView,LoginModel $model,MessagesRepository $messagesRepository)
		{
			# code...
			$this->mainView = $mainView;
		    $this->loginModel = $model;
		    $this->messagesRepository  = $messagesRepository;
		   $this->imagesModel = new ImagesModel();
		}


		public function createMessageView() {
			$FromUser = $this->loginModel->getUsername();
			$toUser = $this->getId();


			 $html = $this->cssView("Message");

          $open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

                
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


    		
	}