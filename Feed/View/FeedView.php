<?php
require_once('Model/Dao/CourseRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('Model/LoginModel.php');
require_once('Model/PostItems.php');
require_once('Model/Dao/CommentRepository.php');
require_once('View/UploadView.php');
require_once('Model/ImagesModel.php');
require_once('View/BaseView.php');


class FeedView extends BaseView{


private $courseRepository;
private $loginModel;
private $postRepository;
private $commentRepository;
private $imagesModel;

private $title = "message";
private $hiddenFeedId = "hiddenFeedId";
private $imgName = "imgName";
private $postContent = "Post";
private $postTitle = "Title";
private $date = "Date";


  public function __construct(LoginModel $model){

    $this->courseRepository = new CourseRepository();
    $this->postRepository = new PostRepository();
    $this->loginModel = $model;
    $this->userRepository = new UserRepository();
    $this->commentRepository = new CommentRepository();
    $this->uploadView = new UploadView();   
    $this->imagesModel = new ImagesModel();

  }

    public function showCourseFeed($courseId){
        
        $username = $this->loginModel->getUsername();
        $html= "";
        
        $adminMenu = "";
        $pic = "";

        if ($this->loginModel->isAdmin()) 
        {
            $adminMenu .= "<li><a name='newCourse' href='?". $this->createNewCourseLocation . "'>Skapa ny kurs</a></li>";
        }

        $html = "<!DOCTYPE html>
        <html>
        <head>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js' type='text/javascript'></script>
        <script src='js/CommentSlideButton.js' type='text/javascript'></script>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' href='css/commentSlideStyle.css' /> 
        <link rel='stylesheet' href='css/style.css' />
        <link rel='stylesheet' href='css/bootstrap.min.css'>
        <title>LSN</title>
        </head>

        <body>
        <div class='container'>
        <br>";

        $user = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
        $Images = glob("imgs/*.*");

            foreach ($Images as $value) {  

              $img = $this->imagesModel->getImgs($username);
              if ($img->getImg() == basename($value)) {

                $html .= '<div id="imgArea"><img src="'.$value.'"><h4>'.$username.' är inloggad</h4></div>';
                $pic = $value;
              }
            }

        if(basename($pic) === "" && $user->getSex() == "Man") 
          {
             $html .= '<div id="imgArea"><img src="img/default.jpg"><h4>'.$username.' är inloggad</h4></div>';
          }
         else if(basename($pic) === "" && $user->getSex() == "Kvinna")
         {
            $html .= '<div id="imgArea"><img src="img/kvinna.png"><h4>'.$username.' är inloggad</h4></div>';
         }     

       $html .= "
              <br><br>
              <nav class='navbar navbar-default' role='navigation'>
              <div class='navbar-header'>
                <button type='button' class='navbar-toggle' data-toggle='collapse' 
                   data-target='#example-navbar-collapse'>
                   <span class='sr-only'>Toggle navigation</span>
                   <span class='icon-bar'></span>
                   <span class='icon-bar'></span>
                   <span class='icon-bar'></span>
                </button>
             </div>
             <div class='collapse navbar-collapse' id='example-navbar-collapse'>
                <ul class='nav navbar-nav'>
                $adminMenu
                   <li><a name='profile' href='?". $this->userProfileLocation . "&id=".$this->loginModel->getId()."'>Min profil</a></li>
                   <li><a name='logOut' href='?". $this->logOutLocation . "'>Logga ut</a></li>
                </ul>
             </div>
          </nav>
          $this->message";

         $html .= $this->GetFeedHTML($courseId);

        $html .= "</div>
        </body>
        </html>";

        return $html;

      }


      public function GetFeedHTML($courseId)
      {
        
        $feedItems = $this->postRepository->getPosts($courseId);
        $items = array();

        $html = "
        <h1 style='text-align:center'>" . $this->courseRepository->getCourseName($courseId) . "</h1>
        <div class='content'>";

        $html .= $this->uploadView->RenderUploadForm($courseId);

        $html .= "<ul id='items'>";

      
        foreach ($feedItems as $value) {
         
         $postItems = new PostItems($value['id'],$value['UserId'], $value['imgName'], $value['Post'], $value['Title'], $value['code'], date('Y-m-d H:i:s', strtotime($value['Date'])), null, null);
         $items[] = $postItems;
        }

        $rssURL = $this->courseRepository->checkIfRSSUrlExists($courseId);

        if($rssURL != null)
        {
        $url = $this->courseRepository->getRSSLink($courseId);
        $xml = simplexml_load_file($url);
        foreach($xml->channel->item as $entry){
                  
        $title = $entry->title;
        $link = $entry->link;
        $description = $entry->description;

        $pubDate = date('Y-m-d H:i:s', strtotime($entry->pubDate));

        $namespaces = $entry->getNameSpaces(true);
        $dc = $entry->children($namespaces['dc']); 
        $creator = $dc->creator;
        
          $rssLinkExists = $this->courseRepository->checkIfRSSLinkExists($link);
          
          if($rssLinkExists == false){

          $this->courseRepository->addRSSTitle($link);

          }

          $rssIDs = $this->courseRepository->getRSSData($link);


         //TODO: Fixa id till comment för RSS
            foreach ($rssIDs as $id) {
             $RSSItems = new PostItems($id, null, null, $description , $title, null, $pubDate, $link, $creator);

             $items[] = $RSSItems;
    
      }

     }
 }

     usort($items, array($this,'sortFeedItemsByDate'));

     foreach ($items as $key) {
       $html .= "<div class='post' id='post" . $key->getid(). "'>"; 
       
       if ($this->loginModel->getId() == $key->getUserId()) 
        {
          $html .= "<form class='post-remove' method='post' action=''> 
                    <input type='image' src='images/icon_del.gif' id='deletepost' border='0' alt='submit' />
                    <input type='hidden' name='" . $this->imgName . "' id='" . $this->imgName . "' value='" . $key->getImgName() . "'>
                    <input type='hidden' name='" . $this->hiddenFeedId . "' id='" . $this->hiddenFeedId . "' value='". $key->getid() ."'>
                    </form>";

                    $html .= "<form class='post-edit' method='post' action=''> 
                    <input type='hidden' name='" . $this->postContent . "' id='" . $this->postContent . "' value='" . BaseView::escape($key->getPost()) . "'>
                    <input type='hidden' name='" . $this->postTitle . "' id='" . $this->postTitle . "' value='" . BaseView::escape($key->getPTitle()) . "'>
                    <input type='hidden' name='" . $this->hiddenFeedId . "' id='" . $this->hiddenFeedId . "' value='". $key->getid() ."'>
                    <input type='image' src='images/icon_edit.png' id='editpost' border='0' alt='submit' />";
                }
               

                        if ($key->getid() != null) {

                           $html .="Inlägg skapad av:  ".$key->getCreator()." ";
                        }   

                        $html .= "<a href='?profile&id=" . $key->getUserId() . "'>" . $this->userRepository->getUsernameFromId($key->getUserId()) . "</a></br>";
                        $html .="Datum skapad:</br> ".$key->getDate()."</br> ";
                        if ($key->getLink() != null) {
                           $html .= "<a href=" . $key->getLink() . "><h3>".$key->getPTitle()."</h3></a>";
                        }
                        $html .=   "<div class='text-values'><p>" . $key->getPost() . "</p></div>";
                       
                       
                
                $imgName = $key->getImgName();          
                if (empty($imgName) == false) 
                {
                    $html .= "<img src='View/Images/" . $key->getImgName() . "' width='500' height='315'>";
                }

                $code = $key->getCode();
                if (empty($code) == false) 
                {
                    $html .= "<iframe width='500' height='315' src='https://www.youtube.com/embed/". $key->getCode() ."' frameborder='0' allowfullscreen></iframe>";                  
                }

                $html .= "
                </form>
                ";

                $comments = $this->commentRepository->GetCommentsForPost($key->getid());

                 if (empty($comments) == false) 
                {
                    foreach ($comments as $comment) 
                    {
                        $data = $comment->GetData();

                        $data['date'] = strtotime($data['date']);

                        $html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '">';

                        if ($this->loginModel->getId() == $comment->GetUserId()) {
                            
                            $html .=
                            '<a href="#" class="delete_button" id="' . $data["CommentId"] . '">
                            <img src="images/icon_del.gif" border="0" />
                            </a>';
                        }

                        $html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
                        <a href="?profile&id=' . $comment->GetUserId() . '">' . $this->userRepository->getUsernameFromId($comment->GetUserId()) . '</a> skrev: <p>' . $data['body'] . '</p>
                        </div>';
                    }            
                }

                 $html .= "<div id='addCommentContainer" . $key->getid() . "' class='addCommentContainer'>
                    <form class='comment-form' method='post' action=''>
                        <div>
                            <input type='hidden' id='courseid' name='courseid' value='" . $courseId . "'>
                            <input type='hidden' id='" . $this->id . "' name='" . $this->id . "' value='" . $key->getid() . "'>
                            <label for='body'>Skriv en kommentar</label>".
                            "<textarea name='body' id='body' maxlength='250' cols='20' rows='5'></textarea>
                            <input type='submit' id='submit' value='Kommentera'/>".
                        "</div>
                    </form>
                </div>
                </div>";                
        }
      

        //Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet
        $html .= "<script type='text/javascript'>var course_id = " . $courseId . ";</script>
                </ul>
                <p id='loader'><img src='images/ajax-loader.gif'></p>
                </div>";



        return $html;
    }



     public function getHiddenId() {
        if (isset($_POST[$this->hiddenImgID])) {
            return $_POST[$this->hiddenImgID];
        }
        
    }

    public function GetImageTitle() {
        if (isset($_POST[$this->title])) {
            return nl2br($_POST[$this->title]);
        }
    }

    public function renderFeed($courseId)
    {
      return $this->showCourseFeed($courseId);
    }


    public static function sortFeedItemsByDate($a, $b) 
    {
      return strcmp($b->date, $a->date);
    }
  

}