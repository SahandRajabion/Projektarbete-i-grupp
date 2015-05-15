<?php
  require_once('Validation/Validation.php');
  require_once('View/BaseView.php');
  require_once('recaptchalib.php');
  class contactView extends BaseView{
    private $name = "name";
    private $email = "email";
    private $msg = "message";
    private $send = "send";
    private $GetName;
    private $GetMeg;
    private $GetEmail;
    private $mainView;  
    private $validation;
    public function __construct() {
      $this->validation = new Validation();
    }
  public function getUserName() {
    if (isset($_POST[$this->usernameLocation])) {
      return $_POST[$this->usernameLocation];
    }
  }
    
    //render contact form.
    public function ContactForm() {
        $loginUsername = "";
        if (isset($_POST[$this->submitLocation])) 
        {
            $loginUsername = $this->escape($this->getUserName());
        }
      if($this->validation->ContactFormValidation($this->getName(),$this->getEmail(),$this->getMsg()) !== true ){
        $this->GetName = $this->getName();
        $this->GetMeg = $this->getMsg();
        $this->GetEmail = $this->getEmail();
      }
      
        $html = 
        '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">
        <title>Contact Us | LSN</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet">
        <link rel="stylesheet" href="css/recaptcha.css">
        <script type="text/javascript">
         var RecaptchaOptions = {
            theme : "custom",
            custom_theme_widget: "responsive_recaptcha"
         };
       </script>
        
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
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
              <form action="?' . $this->ContactLocation . '" method="post" class="navbar-form navbar-right" enctype="multipart/form-data">
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
                        <h2>Contact Us</h2> 
                      <div class="form-group">
                          <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input type="text" name="' . $this->name . '" value="' . $this->escape($this->GetName) . '" class="form-control input-lg" placeholder="Name" maxlength="20" size="20">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                  <input type="email" name="' . $this->email . '" value="' . $this->escape($this->GetEmail). '" class="form-control input-lg" placeholder="Email" maxlength="40" size="40">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                              <textarea id="contactTextArea" maxlength="500" name="' . $this->msg . '" placeholder="Message" class="form-control input-lg" rows="3">' . $this->escape($this->GetMeg) . '</textarea>
                          </div>
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
                            <input type="submit" value="Send Message" name="' . $this->send . '" class="btn btn-primary btn-block btn-lg">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
          </div>
        </div>
        <div class="container">
          <footer>
            <p>&copy; Linnaéus Social Network 2015</p>
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
    /**
    * Function to render message
    */
    public function setMessage($message) {
        $this->message .= $message;
    }  
    public function getName() {
      if (isset($_POST[$this->name])) {
        return $_POST[$this->name];
      }
    }
    public function getEmail() {
      if (isset($_POST[$this->email])) {
        return $_POST[$this->email];
      }
    }
    public function getMsg() {
      if (isset($_POST[$this->msg])) {
        $message = nl2br($_POST[$this->msg]);
        return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $message);
      }
    }
    public function hasSubmitToSend() {
      if (isset($_POST[$this->send])) {
        return true;
      }
      return false;
    }
    public function didUserPressToContact() {
    if (isset($_GET[$this->ContactLocation])) {
      return true;
    }
    return false;
  }
  }