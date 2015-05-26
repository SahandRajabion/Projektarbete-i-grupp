<?php

class LoginMessage {
    private $messageId;

    private $messages = array('Username is required', 'Password is required', "Username or password is incorrect",
                              "Invalid information in cookies", 'Username has invalid characters',
                              'Username is taken', 'Passwords is not matching', 'Password need atleast 6 characters',
                              'Username need atleast 3 characters',
                              "You are logged in and will be remembered next time", "You are logged in", "You are logged out",
                              'Registration was successful', "You are logged in with cookies", "ReCaptcha text is incorrect", "You are blocked", "Current password is incorrect",
                              "Password has changed, you have to login again", "New password needs atleast 6 characters", "New password cannot be changed to be same",
                              "Course has to be under a program", "User details has changed", "Email is not a valid email", "Password has invalid characters","Password has been reset", "Email is not matching", "Email already exists, you can choose to reset password" , "Check so every input is filled in correct format", "Check so email is filled and is in valid email", "Check that firstname and surname is filled and is in correct format", "Are you a man or woman?", "Check that your birthdate is in correct format (1999-01-01)", "Are you studying or lecturing on Campus or Distance?", "What program are you studying on Linnaéus University?"
                              , "Coursename contains invalid characters", "Coursename cannot be empty", "Coursecode cannot be empty", "Coursecode contains invalid characters", "Coursename already exists", "Coursecode can only contain 6 characters", "Course has been created", "Coursecode already exist", "A mail with instructions has been sent", "Password contains invalid characters", "Password has been reset", "Message has been sent", "All inputs must be filled", "Name cannot be empty", "Email and message cannot be empty", "Email cannot be empty", "Name must be atleast 3 characters", "Message cannot be empty", "Message must be atleast 3 characters", "Name is not in valid format", "Email is not in valid format",
                               "ReCaptcha is not enabled" , "The url is in invalid format, Example: <u>http</u>://</b>coursepress.lnu.se/kurs/projektarbeteigrupp/feed", "Email already exists, you can choose to <a href=?forgetPassword>reset your password</a>" , "The url is in invalid format, Example: <u>http</u>://</b>se.timeedit.net/web/lnu/db1/ri1Y1X4QQ9wZ76Qv49050755yYYQ5Z5784Y55X5.html");   

    public function __construct($messageId) {
        $this->messageId = $messageId;

    }

    /**
     * @return string html with feedback
     */
    public function getMessage() {
        $message = $this->messages[$this->messageId];

        if($this->messageId < 9 || $this->messageId == 14 || $this->messageId == 15 || $this->messageId == 16 
          || $this->messageId == 18 || $this->messageId == 19 || $this->messageId == 20 || $this->messageId == 23 || $this->messageId == 24 || $this->messageId == 25 || $this->messageId == 26 || $this->messageId == 28 || $this->messageId == 29 || $this->messageId == 30 || $this->messageId == 31 || $this->messageId == 32 || $this->messageId == 33 || $this->messageId == 34 || $this->messageId == 35
          || $this->messageId == 36 || $this->messageId == 37 || $this->messageId == 38  || $this->messageId == 22 || $this->messageId == 39 || $this->messageId == 41 || $this->messageId == 43 || $this->messageId == 46 || $this->messageId == 47 || $this->messageId == 48 || $this->messageId == 49 || $this->messageId == 50 || $this->messageId == 51 || $this->messageId == 52 || $this->messageId == 53 
          || $this->messageId == 54 || $this->messageId == 55 || $this->messageId == 56 || $this->messageId == 57 || $this->messageId == 58) {
            $alert = "
          <div class='alert alert-danger alert-error'>
           <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
          ";
        }    
        else{
            $alert = "<div class='alert alert-success'>
             <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>";
        }
        if(!empty($message)) {
          $ret = "
          $alert
          <a href='#' class='close' data-dismiss='alert'>&times;</a>        
          <span id='sizeOfPTag'>$message</span>
          </div>";
        }
        else {
            $ret = "<span id='sizeOfPTag'>$message</span>";
        }
        return $ret;
    }
}