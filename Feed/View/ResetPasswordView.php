<?php
 /**
 * 
 */
 require_once("helper/CookieStorage.php");
 require_once("View/BaseView.php");
 class ResetPasswordView extends BaseView
 {
  /**
    * Function to render message
    */
    public function setMessage($message) {
        $this->message .= $message;
    }
    
  function __construct()
  {
    $this->cookie = new CookieStorage();
  }
  public function showResetPasswordPage() {
        $loginUsername = "";
        if (isset($_POST[$this->submitLocation])) 
        {
            $loginUsername = $this->escape($_POST[$this->usernameLocation]);
        }     
        $html = 
        '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../favicon.ico">
        <title>Reset Password | LSN</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet">
        
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
              <a class="navbar-brand" href="?">LSN</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <form action="?' . $this->code . '=' . $this->getCode() . '&kjAmsdNg" method="post" class="navbar-form navbar-right" enctype="multipart/form-data">
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
                        <h2>Reset Password</h2> 
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password"  name="' . $this->newPasswordLocation . '" size="20" maxlength="20" class="form-control input-lg" placeholder="New Password">                    
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input type="password" size="20" maxlength="20" name="' . $this->newConfirmPasswordLocation . '" class="form-control input-lg" placeholder="Confirm Password">                            
                              </div>
                            </div>
                        <div class="row">
                          <div class="col-xs-12 col-md-6">
                            <input type="submit" name="' . $this->submitNewPasswordLocation . '" value="Change Password" class="btn btn-primary btn-block btn-lg">
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
  public function issetCode() {
    if (isset($_GET[$this->code])) {
      # code...
      return true;
    }
  }
   public function getCode() {
    if (isset($_GET[$this->code])) {
      # code...
      return $_GET[$this->code];
    }
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
      return $_POST[$this->newPasswordLocation];
    }
  }
  public function getNewConfirmPassword() {
    if (isset($_POST[$this->newConfirmPasswordLocation])) {
      return $_POST[$this->newConfirmPasswordLocation];
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
  
 }