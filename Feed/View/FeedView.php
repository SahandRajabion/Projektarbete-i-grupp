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
private $pic;
private $link;


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
        
    $this->username = $this->loginModel->getUsername();
    $adminMenu = "";
    $userPic = "";

    if ($this->loginModel->isAdmin()) 
    {
        $adminMenu .= "<li><a name='newCourse' href='?". $this->createNewCourseLocation . "'>Create course</a></li>";
    }
 

    $user = $this->loginModel->GetUserProfileDetails($this->loginModel->getId());
    $Images = glob("imgs/*.*");
    
    foreach ($Images as $value) 
    {  
        $img = $this->imagesModel->getImgs($this->username);
        $removeImg = $this->imagesModel->getImgToRemove(basename($value));
        if ($img->getImg() == basename($value)) 
        {        
          $userPic .= '<div><img id="profileImage" src="'.$value.'" > <label id="profileName">' . $this->username . '</label></div>';
          $this->pic = $value;
        }
    }

    if (basename($this->pic) === "" && $user->getSex() == "Man") 
    {
        $userPic .= '<div><img id="profileImage" src="img/default.jpg"> <label id="profileName">' . $this->username . '</label></div>';
    }
    else if (basename($this->pic) === "" && $user->getSex() == "Kvinna")
    {
        $userPic .= '<div><img id="profileImage" src="img/kvinna.png"> <label id="profileName"><a name="profile" href="?' . $this->userProfileLocation . "&id=".$this->loginModel->getId(). '">' . $username . '</a></label></div>';
    }

        $html = "<!DOCTYPE html>
        <html>
        <head>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js' type='text/javascript'></script>
        <script src='js/CommentSlideButton.js' type='text/javascript'></script>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link href='css/bootstrap.min.css' rel='stylesheet'>
        <link href='css/customCss.css' rel='stylesheet'>
        <script type='text/javascript' src='jquery.min.js'></script>
        <script type='text/javascript' src='script.js'></script>
        
        <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
        <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
        <title>LSN</title>
        </head>

        <body>
        <div class='container'>
        <br>";

        

       $html .= "
              <br><br>
             <nav class='navbar navbar-inverse navbar-fixed-top'>
          <div class='container'>
            <div class='navbar-header'>
              <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false'aria-controls='navbar'>
                <span class='sr-only'>Toggle navigation</span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
              </button>
              <a class='navbar-brand' href='?'>LSN</a>
            </div>
            <div id='navbar' class='navbar-collapse collapse'>

              <form class='navbar-form navbar-right' role='search' method='post' enctype='multipart/form-data'>
              <div class='form-group'>
              <div class='input-group'>
              <span class='input-group-addon'><i class='glyphicon glyphicon-search'></i></span>
             
              <div class='input_container'>
                <input type='text' id='course_id' onkeyup='autocomplet()' name='" . $this->searchLocation . "' size='20' maxlength='20' class='form-control1' placeholder='Search'>
                <ul id='course_list_id'></ul>
                </div>
              </div>
              </div>
              <button type='submit' name='" . $this->submitSearchLocation . "' class='btn btn-primary'><i class='glyphicon glyphicon-search'></i></button>
            </form>
              

              <ul class='nav navbar-nav navbar-right'>
              <li>'" . $userPic . "'</li>
                '" . $adminMenu . "'
                <li><a name='profile' href='?" . $this->userProfileLocation . '&id='.$this->loginModel->getId(). "'>My profile</a></li>
                <li><a name='logOut' href='?" . $this->logOutLocation . "'>Log out</a></li>
              </ul>
              
            </div>
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
        $linkRSS = $this->courseRepository->getRSS($courseId);  

        $feedItems = $this->postRepository->getPosts($courseId, $linkRSS);
        $items = array();

        $html = "
        <h1 style='text-align:center'>" . $this->courseRepository->getCourseName($courseId) . "</h1>
        <div class='content'>";

        $html .= $this->uploadView->RenderUploadForm($courseId);

        $html .= "<ul id='items'>";

      if($feedItems != null){

        foreach ($feedItems as $value) {
         
         $postItems = new PostItems($value['id'], $value['UserId'], $value['imgName'], $value['Post'], $value['Title'], $value['code'], date('Y-m-d H:i:s', strtotime($value['Date'])), null, null, null, null);
  
         $items[] = $postItems;
        }
      }
        
        $rssURL = $this->courseRepository->checkIfRSSUrlExists($courseId);

        if($rssURL != null)
        {
        $url = $this->courseRepository->getRSSLink($courseId);
        $xml = simplexml_load_file($url);
        foreach($xml->channel->item as $entry){
                  
        $title = $entry->title;
        $this->link = $entry->link;
        $description = $entry->description;

        $pubDate = date('Y-m-d H:i:s', strtotime($entry->pubDate));

        $namespaces = $entry->getNameSpaces(true);
        $dc = $entry->children($namespaces['dc']); 
        $creator = $dc->creator;
        
        $data = $this->courseRepository->getAllRssLinks($this->link);

        $allLinks = null;
        foreach ($data as $key) {
          
          $allLinks .= $key['RssLink']; 
           
        }
      
          if($allLinks === null){

          $userid = $this->loginModel->getId();
          $this->courseRepository->addRSSData(0, $courseId, $this->link);

          }

          $rssArray = $this->courseRepository->getAllRssLinks($this->link);
         
            foreach ($rssArray as $rss) {
              
             $RSSItems = new PostItems($rss['id'], $rss['UserId'], null, null , null, null, $pubDate, $this->link, $creator, $description, $title);

             $items[] = $RSSItems;
    
      }

     }


 }

     usort($items, array($this,'sortFeedItemsByDate'));

     foreach ($items as $key) {
       $html .= "<div class='post' id='post" . $key->getid(). "'>"; 
       
        if ($this->loginModel->getId() == $key->getUserId() || $this->loginModel->isAdmin() && $key->getCreator() === null) 
        {
            $html .= "<form class='post-remove' method='post' action=''> 
            <input type='image' src='images/icon_del.gif' id='deletepost' border='0' alt='submit' />
            <input type='hidden' name='imgName' id='imgName' value='" . $key->getImgName() . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $key->getid() ."'>
            </form>";

            $html .= "<form class='post-edit' method='post' action=''> 
            <input type='hidden' name='Post' id='Post' value='" . BaseView::escape($key->getPost()) . "'>
            <input type='hidden' name='Title' id='Title' value='" . BaseView::escape($key->getPTitle()) . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $key->getid() ."'>
            <input type='image' src='images/icon_edit.png' id='editpost' border='0' alt='submit' />";
        }


     
                        $creators = $key->getCreator();
                        if ($key->getCreator() != null || $key->getCreator() != "" || !empty($creators)) {

                           $html .="Inlägg skapad av:  ".$key->getCreator()." </br>";
                        }   

                        $posts = $key->getPost();
                        if ($key->getPost() != null || $key->getPost() != "" || !empty($posts)){
                        
                        $usrIds = $key->getUserId();
                        if ($key->getUserId() != null || $key->getUserId() != "" || !empty($usrIds)) {


                          $html .= "<a href='?profile&id=" . $key->getUserId() . "'>" . $this->userRepository->getUsernameFromId($key->getUserId()) . "</a></br>";

                        }}

                        $rsstitles = $key->getRssTitle(); 
                        $html .="Datum skapad:</br> ".$key->getDate()."</br> ";

                        if ($key->getRssTitle() != null || $key->getRssTitle() != "" || !empty($rsstitles)) {
                           $html .= "<a href=" . $key->getLink() . "><h3>".$key->getRssTitle()."</h3></a>";
                        }

                        $rssPosts = $key->getRSSPost();
                        if ($key->getRSSPost() != null || $key->getRSSPost() != "" || !empty($rssPosts)) {
                            $html .=   "<div class='text-values'><p>" . $key->getRSSPost() . "</p></div>";
                        }


                        $normalPosts = $key->getPost();
                         if ($key->getPost() != null || $key->getPost() != "" || !empty($normalPosts)){

                            $html .=   "<div class='text-values'><p>" . $key->getPost() . "</p></div>";
                        }

                      
                       
                       
                
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

                        if ($this->loginModel->getId() == $comment->GetUserId() || $this->loginModel->isAdmin()) {
                            
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