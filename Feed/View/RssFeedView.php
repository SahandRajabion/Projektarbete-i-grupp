<?php
require_once('Model/Dao/CourseRepository.php');
require_once('Model/LoginModel.php');


class RSSFeedView extends BaseView{


private $courseRepository;
private $model;


  public function __construct(){

    $this->courseRepository = new CourseRepository();
    $this->model = new LoginModel();

  }

    public function RenderRSSFeed($courseId){

        $rssFeed= "";
        $url = $this->courseRepository->getRSSLink($courseId);
        $xml = simplexml_load_file($url);

         $rssFeed = $this->cssView("Inbox");

          $open = $this->messagesRepository->getIfOpenOrNot($this->loginModel->getId());

                
                      if ($open != null) {
                            # code...
                           if ($open == 1) {
                                                  # code...
                         $rssFeed .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox <span class="badge">1</span></a></li>';
                       }
                       else {
                           $rssFeed .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox  <span class="badge">' . $open . '</span></a></li>';
                       }
                      }
                      else {
                          $rssFeed .= '<li><a name="Inbox" href="?' . $this->inboxLocation ."&".$this->id."=".$this->loginModel->getId().'">Inbox</a></li><span class="sr-only">(current)</span></a></li>';
                      }
                     
                  $rssFeed .= '<li><a name="Inbox" href="?' . $this->sendLocation ."&".$this->id."=".$this->loginModel->getId().'">Sent Messages</a></li>'.
                  '<li><a href="?' . $this->changePasswordLocation . '">Change Password</span></a></li>
                  </ul>
                </div>';


                $rssFeed .= '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                ' . $this->message . '';
          
        $rssFeed .= "<h1>" . $this->courseRepository->getCourseName($courseId) . "</h1>";
        $rssFeed .= "<a href='?". $this->backToFeedLocation .'&'.$this->id.'='.$courseId."'>Klicka för att komma tillbaka till nyhetsflödet</a></br></br></br>";
        
        foreach($xml->channel->item as $entry){
        $title = $entry->title;
        $link = $entry->link;
        $description = $entry->description;
        $pubDate = $entry->pubDate;

        $namespaces = $entry->getNameSpaces(true);
        $dc = $entry->children($namespaces['dc']); 
        $creator = $dc->creator;

        
        $rssFeed .= " <ul><a href='$link'><h3>$title</h3></a>Inlägg skapad av: $creator.</br><span class='rssdate'>Datum skapad: ".date("Y-m-d", strtotime($pubDate)).".</span>";
        $rssFeed .= "<br><span class='rssdesc'>Beskrivning: $description</span><hr />";
        $rssFeed .= "</ul>";
        
     }

     return $rssFeed;
  }


    public function didPressBackButton(){
      if (isset($_GET[$this->backToFeedLocation])) {
            return true;
        }

        return false;
    }


    public function RSSFeedId($courseId)
    {
      return $this->RenderRSSFeed($courseId);
   }
}