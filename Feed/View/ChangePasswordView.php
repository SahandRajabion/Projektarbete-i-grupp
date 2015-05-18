<?php

require_once("helper/CookieStorage.php");
require_once("View/BaseView.php");
require_once('Model/LoginModel.php');
require_once('Model/Token.php');
require_once('Model/Dao/MessagesRepository.php');

class ChangePasswordView extends BaseView
{
	protected $loginModel;
	protected $imagesModel;
	private $messageRepository;

	public function __construct()  
	{
		$this->cookie = new CookieStorage();
		$this->loginModel = new LoginModel();
		$this->imagesModel = new ImagesModel();
		$this->messageRepository = new MessagesRepository();
	}

	public function didUserPressToChangePassword() {
		if (isset($_GET[$this->changePasswordLocation])) {
			return true;
		}

		return false;
	}

	public function saveCookieMessage($value) {
        $this->cookie->save($this->messageLocation, $value, time()+3600);
    }

	public function renderCookieMessage($string) {
		$value = $this->cookie->load($string);
		$this->unsetMessage($string);
		return $value;
	}

	public function unsetMessage($name) {
			$this->cookie->save($name, null, time()-1);
	}

	public function getNewPassword() {
		if (isset($_POST[$this->newPasswordLocation])) {
			return strip_tags($_POST[$this->newPasswordLocation]);
		}
	}

	public function getNewConfirmPassword() {
		if (isset($_POST[$this->newConfirmPasswordLocation])) {
			return strip_tags($_POST[$this->newConfirmPasswordLocation]);
		}
	}	

	public function didUserPressSubmit() 
	{
		if (isset($_POST[$this->submitNewPasswordLocation])) 
		{
			return true;			
		}

		return false;
	}	

	public function showChangePasswordForm() 
	{
	    $this->message = $this->renderCookieMessage($this->messageLocation);


          $html = $this->cssView("Change Password");

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
                  '<li class="active"><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
                  </ul>
                </div>';


                $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                ' . $this->message . '';

       $html .= '<form role="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <h2 class="sub-header">Change Password</h2> 

                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" placeholder="Current Password" name="' . $this->passwordLocation . '" size="20" maxlength="20" class="form-control input-lg" placeholder="New Password">                    
                              </div>
                            </div>

   							<div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input type="password" size="20" placeholder="New Password" maxlength="20" name="' . $this->newPasswordLocation . '" class="form-control input-lg" placeholder="Confirm Password">                            
                              </div>
                            </div>                            

                            <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input type="password" placeholder="Confirm Password" size="20" maxlength="20" name="' . $this->newConfirmPasswordLocation . '" class="form-control input-lg" placeholder="Confirm Password">                            
                              </div>
                            </div>

                        <div class="row">
                          <div class="col-xs-12 col-md-6">
                           	<input type="hidden" name="CSRFToken" value="' . Token::generate() . '" />
                            <input type="submit" name="' . $this->submitNewPasswordLocation . '" value="Change Password" class="btn btn-primary btn-block btn-lg">
                          </div>
                        </div>
                      </form>
                      </div>
            ';





    

    return $html;
	}

}