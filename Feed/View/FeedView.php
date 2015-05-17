<?php
require_once('Model/Dao/CourseRepository.php');
require_once('Model/Dao/PostRepository.php');
require_once('Model/LoginModel.php');
require_once('Model/PostItems.php');
require_once('Model/Dao/CommentRepository.php');
require_once('Model/Dao/MessagesRepository.php');
require_once('View/UploadView.php');
require_once('Model/ImagesModel.php');
require_once('View/BaseView.php');


class FeedView extends BaseView{


private $courseRepository;
protected $loginModel;
private $postRepository;
private $commentRepository;
protected $imagesModel;
private $messagesRepository;
private $title = "message";
private $hiddenFeedId = "hiddenFeedId";
private $imgName = "imgName";
private $postContent = "Post";
private $postTitle = "Title";
private $date = "Date";
private $link;


  public function __construct(LoginModel $model){

    $this->courseRepository = new CourseRepository();
    $this->postRepository = new PostRepository();
    $this->loginModel = $model;
    $this->userRepository = new UserRepository();
    $this->commentRepository = new CommentRepository();
    $this->uploadView = new UploadView();   
    $this->imagesModel = new ImagesModel();
    $this->messagesRepository = new MessagesRepository();

  }

    public function showCourseFeed($courseId){
        
  

         $html = $this->GetFeedHTML($courseId);



        return $html;

      }


      public function GetFeedHTML($courseId)
      {
        $linkRSS = $this->courseRepository->getRSS($courseId);  

        $feedItems = $this->postRepository->getPosts($courseId, $linkRSS);

        $schema = $this->courseRepository->getCourseSchema($courseId);

        $items = array();

        $html = $this->cssView("News feed"); 


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
                      foreach ($schema as $key) {
                        # code...
                         if ($key != null) {
                           # code...
                            $html .= '<li><a name="Inbox" href="'.$key.'"><b>Schedule</b></a></li>';
                         }
                      }
                    

                  $html .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
                  '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
                  </ul>
                </div>';


        $html .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                ' . $this->message . '';

        
        $html .="<div class='jumbotron'>        
        
        <h2 class='page-header' style='text-align:center; font-family:fantasy;'>" . $this->courseRepository->getCourseName($courseId) . "</h2></div>
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
       $html .="<div class='jumbotron' style='margin-left:-39px;'>";


      if ($this->loginModel->getId() == $key->getUserId() || $this->loginModel->isAdmin() && $key->getCreator() === null) 
        {
            $html .= "<form class='post-remove' method='post' action=''> 
            <input type='image' src='images/del.png' id='deletepost' border='0' alt='submit' />
            <input type='hidden' name='imgName' id='imgName' value='" . $key->getImgName() . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $key->getid() ."'>
            </form>";

            $html .= "<form class='post-edit' method='post' action=''> 
            <input type='hidden' name='Post' id='Post' value='" . BaseView::escape($key->getPost()) . "'>
            <input type='hidden' name='Title' id='Title' value='" . BaseView::escape($key->getPTitle()) . "'>
            <input type='hidden' name='hiddenFeedId' id='hiddenFeedId' value='". $key->getid() ."'>
            <input type='image' style='margin-top: -39px; margin-left: 34px;' src='images/edit.png' id='editpost' border='0' alt='submit' />";
        }
                        $creators = $key->getCreator();
                        if ($key->getCreator() != null || $key->getCreator() != "" || !empty($creators)) {

                           $html .="<div class='well'>Created by:  ".$key->getCreator()." </br>";
                        }   

                        $posts = $key->getPost();
                   
                        $usrIds = $key->getUserId();
                        if ($key->getUserId() != null && $key->getPost() != null || $key->getUserId() != "" && $key->getPost() != ""|| !empty($usrIds) && !empty($posts) ||
                          $key->getUserId() != null && $key->getImgName() != null || $key->getUserId() != "" && $key->getImgName() != ""|| !empty($usrIds) && !empty($getImgName) ||
                          $key->getUserId() != null && $key->getCode() != null || $key->getUserId() != "" && $key->getCode() != ""|| !empty($usrIds) && !empty($getCode) ) {
 

                          $html .= "<div class='well'>Created by: <a href='?profile&id=" . $key->getUserId() . "'>" . $this->userRepository->getUsernameFromId($key->getUserId()) . "</a></br>";

                        }

                        $rsstitles = $key->getRssTitle(); 
                        $html .="Date :</br> ".$key->getDate()."</br></div>";

                        if ($key->getRssTitle() != null || $key->getRssTitle() != "" || !empty($rsstitles)) {
                           $html .= "<a href=" . $key->getLink() . "><h3>".$key->getRssTitle()."</h3></a>";
                        }

                        $rssPosts = $key->getRSSPost();
                        if ($key->getRSSPost() != null || $key->getRSSPost() != "" || !empty($rssPosts)) {
                            $html .=   "<div class='text-values'><p>" . $key->getRSSPost() . "</p></div>";
                        }


                        $title = $key->getPTitle();
                         if ($title  != null || $title  != "" || !empty($title)){

                            $html .=   "<div class='text-values'><p>" . $title . "</p></div>";
                        }


                        $normalPosts = $key->getPost();
                         if ($key->getPost() != null || $key->getPost() != "" || !empty($normalPosts)){

                            $html .=   "<div class='text-values'><p>" . $key->getPost() . "</p></div>";
                        }


                      
                       
                       
                
                $imgName = $key->getImgName();          
                if (empty($imgName) == false) 
                {
                    $html .= "<img class='img-rounded' src='View/Images/" . $key->getImgName() . "' width='500' height='315'>";
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

                        $html .= '<div class="comment" id ="comment' .  $data["CommentId"] . '"> <li class="list-group-item">';

                        if ($this->loginModel->getId() == $comment->GetUserId() || $this->loginModel->isAdmin()) {
                            
                            $html .=
                            '
                             
                            <a href="#" class="delete_button" id="' . $data["CommentId"] . '">
                            <span class=""><i class="glyphicon glyphicon-trash"></i></span>
                            </a>';
                        
                        }

                        $html .= '<div class="date">' . date('j F Y H:i:s', $data['date']) . '</div>
                        <a href="?profile&id=' . $comment->GetUserId() . '">' . $this->userRepository->getUsernameFromId($comment->GetUserId()) . '</a> wrote: <p>' . $data['body'] . '</p>
                        </div>';
                    }            
                }

                 $html .= "<div id='addCommentContainer" . $key->getid() . "' class='addCommentContainer'>
                    <form class='comment-form' method='post' action=''>
                            <input type='hidden' id='courseid' name='courseid' value='" . $courseId . "'>
                            <input type='hidden' id='" . $this->id . "' name='" . $this->id . "' value='" . $key->getid() . "'>
                            <label for='body'>Write a comment</label>".
                            "<textarea name='body' id='body' maxlength='250' cols='20' class='form-control input-lg'></textarea>
                            <input type='submit' id='submit' value='Kommentera' class='btn btn-default'/>".
                        "
                    </form>
                </div>
                </div>
                </div>";                
        }

      

        //Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet

         $html .= "<script type='text/javascript'>var course_id = " . $courseId . ";</script>
                </ul>
                </div>";


           $html .= '
           <script type="text/javascript" src="js/jquery.js"></script>
           <script type="text/javascript" src="js/LoadMoreItems.js"></script>
           </div><p id="loader"><img src="images/ajax-loader.gif"></p>
           <script type="text/javascript" src="js/GetLatestItems.js"></script>

            </body>
          </html>'; 



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