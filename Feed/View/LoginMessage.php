<?php

class LoginMessage {
    private $messageId;
    private $messages = array('Username is required', 'Password is required', "Username or password is incorrect",
                              "Invalid information in cookies", 'Username has invalid characters',
                              'Username is taken', 'Passwords is not matching', 'Password need atleast 6 characters',
                              'Username need atleast 3 characters',
                              "Login was successful and we will remember you next time", "Login was successful", "You are logged out",
                              'Register was successful', "You logged in with cookies", "ReCaptcha text is incorrect", "You are now IP blocked", "Current password is incorrect",
                              "Password was changed, you have to login again", "New password needs atleast 6 characters", "New password cannot be changed to be same",
                              "Threads topic is too long", "Threads topic cannot be empty", "Thread has been created", "Password has invalid characters","Lösenordet har återskapat ");    

    public function __construct($messageId) {
        $this->messageId = $messageId;
    }

    /**
     * @return string html with feedback
     */
    public function getMessage() {
        $message = $this->messages[$this->messageId];

        if($this->messageId < 9 || $this->messageId == 14 || $this->messageId == 15 || $this->messageId == 16 
          || $this->messageId == 18 || $this->messageId == 19 || $this->messageId == 20 || $this->messageId == 21 || $this->messageId == 23 || $this->messageId == 24 || $this->messageId == 25 || $this->messageId == 28 || $this->messageId == 29 || $this->messageId == 30) {
            $alert = "<div class='alert alert-danger alert-error'>";
        }   
        else{
            $alert = "<div class='alert alert-success'>";
        }
        if(!empty($message)) {
          $ret = "
          $alert
          <a href='#' class='close' data-dismiss='alert'>&times;</a>        
					<p>$message</p>
					</div>";
        }
        else {
            $ret = "<p>$message</p>";
        }
        return $ret;
    }
}