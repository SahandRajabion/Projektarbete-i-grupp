<?php
require_once('View/BaseView.php');
require_once('recaptchalib.php');
require_once('Model/Token.php');
class RegisterView extends BaseView {
  private $emailRegEx;    
  /**
    * Function to render message
    */
    public function setMessage($message) {
        $this->message .= $message;
    }
    /**
    * Function to see where user wants to go and do
    */  
  public function didUserPressReturnToLoginPage() {
    if (isset($_GET[$this->loginLocation])) {
      return true;
    }
    return false;
  }
  public function didUserPressSubmit() {
    if (isset($_POST[$this->registerLocation])) {
      return true;
    }
    return false;
  }
    /**
    * Functions to get register information
    */  
  public function getUserName() {
    if (isset($_POST[$this->usernameLocation])) {
      return $_POST[$this->usernameLocation];
    }
  }
  public function getConfirmPassword() {
    if (isset($_POST[$this->confirmPasswordLocation])) {
      return $_POST[$this->confirmPasswordLocation];
    }
  }
  /**
    * Show register page
    *
    * @return string Returns String HTML
    */  
  public function showRegisterPage() {
        $loginUsername = "";
        $username = "";
        if (isset($_POST[$this->submitLocation])) 
        {
            $loginUsername = $this->escape($this->getUserName());
        }
        if(isset($_POST[$this->registerLocation])){
            $usernameInput = $this->getUserName();
            $username .= $this->escape($usernameInput);
        }
        $this->emailRegEx = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
        $email = $this->getEmail();
        $confirmEmail = $this->getConfirmEmail();
        if(!preg_match($this->emailRegEx, $email))
        {
           $email = "";
        }
        if(!preg_match($this->emailRegEx, $confirmEmail))
        {
           $confirmEmail = "";
        }
        if ($email !== $confirmEmail) 
        {
          $confirmEmail = "";
          $email = "";
        }
    $html = 
        '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">
        <title>Sign Up | LSN</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet">
        
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        <link rel="stylesheet" href="css/recaptcha.css">
        <script type="text/javascript">
         var RecaptchaOptions = {
            theme : "custom",
            custom_theme_widget: "responsive_recaptcha"
         };
       </script>
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
               <div id="logolsn">
                  <a class="navbar-brand" href="?"><img id="logo" src="images/lsnlogo.png"></a>
              </div>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <form action="?' . $this->registerLocation . '" method="post" class="navbar-form navbar-right" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group">
                       <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                       <input type="text" value="' . $loginUsername . '" name="' . $this->usernameLocation . '" size="20" maxlength="20" placeholder="Username" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                      <input type="password" name="' . $this->passwordLocation . '" size="20" maxlength="20" placeholder="Password" class="form-control">
                    </div>
                </div>
                <div class="checkbox">
                <label class="text-muted">
                <input type="checkbox" name="' . $this->checkBoxLocation . '"> Remember me
                </label>
                </div>
                <button type="submit" name="' . $this->submitLocation . '" class="btn btn-primary">Sign in</button>
              </form>
            </div>
            <!--/.navbar-collapse -->
          </div>
        </nav>
        <div class="jumbotron">
          <div class="container">
          ' . $this->message . '
            <div class="row">
                      <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                      <form role="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <h2>Sign Up</h2>
                        <div class="form-group">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" size="20" maxlength="20" value="' . $username . '" name="' . $this->usernameLocation . '" class="form-control input-lg" placeholder="Username">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password"  size="20" maxlength="20" name="' . $this->passwordLocation . '" class="form-control input-lg" placeholder="Password">                    
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input type="password" size="20" maxlength="20" name="' . $this->confirmPasswordLocation . '" class="form-control input-lg" placeholder="Confirm Password">                            
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input type="text" size="20" maxlength="20" name="' . $this->fNameLocation . '" value="' . $this->escape($this->getFname()) . '" class="form-control input-lg" placeholder="First Name">                              </div> 
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" size="20" maxlength="20" name="' . $this->lNameLocation . '" value="' . $this->escape($this->getLname()) . '" class="form-control input-lg" placeholder="Last Name">
                              </div> 
                            </div>
                          </div>
                        </div>
                       <div class="form-group">
                       <em>(optional)</em>
                         <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-gift"></i></span>
                            <input type="date" size="20" maxlength="10" name="' . $this->birthdayLocation . '" class="form-control input-lg" placeholder="yyyy-mm-dd">
                          </div> 
                        </div>
                        <div class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                  <input type="email" size="20" maxlength="40" name="' . $this->emailRegLocation . '" value="' . $this->escape($email) . '" class="form-control input-lg" placeholder="Email">
                              </div>                  
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                               <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                  <input type="email" size="20" maxlength="40" name="' . $this->emailConfirmLocation . '" value="' . $this->escape($confirmEmail) . '" class="form-control input-lg" placeholder="Confirm Email">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                                <select class="form-control input-lg" name="' . $this->sexLocation . '">
                                  <option value="" disabled selected>Choose Gender</option>
                                  <option value="Man">Male</option>
                                  <option value="Kvinna">Woman</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <select class="form-control input-lg" name="' . $this->instituteLocation . '">
                                  <option value="" disabled selected>Choose Program</option>
                                  <option value="2">Utvecklare av digitala tjänster</option>
                                  <option value="1">Webbprogrammerare</option>
                                  <option value="3">Interaktionsdesigner</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <select class="form-control input-lg" name="' . $this->schoolLocation . '">
                                  <option value="" disabled selected>Choose Study Form</option>
                                  <option value="Campus">Campus</option>
                                  <option value="Distans">Distans</option>
                                </select>
                        </div>
                          <div class="form-group">
                           <div id="responsive_recaptcha" style="display:none">
                            <div id="recaptcha_image"></div>
                            <div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
                            <label class="solution">
                              <span class="recaptcha_only_if_image">Type the text:</span>
                              <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                            </label>
                            <div class="options">
                              <a href="javascript:Recaptcha.reload()" id="icon-reload">Get another CAPTCHA</a>
                              <a class="recaptcha_only_if_audio" href="javascript:Recaptcha.switch_type(' . "'image'" . ')" id="icon-image">Get an image CAPTCHA</a>
                              <a href="javascript:Recaptcha.showhelp()" id="icon-help">Help</a>
                            </div>
                          </div>
                      <script type="text/javascript"
                          src="http://www.google.com/recaptcha/api/challenge?k=' . Settings::$SITE_KEY. '">
                      </script>
 
                      <noscript>
                        <iframe src="http://www.google.com/recaptcha/api/noscript?k=' . Settings::$SITE_KEY. '"
                              height="300" width="500" frameborder="0"></iframe><br>
                        <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                        </textarea>
                        <input type="hidden" name="recaptcha_response_field"
                              value="manual_challenge">
                      </noscript>
                         </div>
                        
                        <div class="row">
                          <div class="col-xs-12 col-md-6">
                            <input type="hidden" name="CSRFToken" value="' . Token::generate() . '" />
                            <input type="submit" value="Register" name="' . $this->registerLocation . '" class="btn btn-primary btn-block btn-lg">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
          </div>
        </div>
        <div class="container">
          <footer>
            <p>&copy; Linnaeus Social Network 2015</p>
          </footer>
        </div> 
        <!-- /container -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/ie10-viewport-bug-workaround.js"></script>
        </body>
        </html>';    
         
    return $html;
  }
}