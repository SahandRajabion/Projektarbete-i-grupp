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

        $adminMenu = "";
        $pic = "";

        if ($this->model->isAdmin()) 
        {
            $adminMenu .= "<li><a name='newCourse' href='?". $this->createNewCourseLocation . "'>Skapa ny kurs</a></li>";
        }

        $rssFeed .= "
          <!DOCTYPE html>
          <html>
          <head>
          <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
          <link rel='stylesheet' type='text/css' href='css/styleVal.css' />  
          <link rel='stylesheet' type='text/css' href='css/programStyles.css' />       
          <script src='js/script.js'></script>
          <title>LSN</title>                
          <meta charset='utf-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1'>
          </head>
          <body>
          <div class='container'>"; 

        $rssFeed .= "<br>";
        $username = $this->model->getUsername();
        $pic = "";

        $user = $this->model->GetUserProfileDetails($this->model->getId());
        $Images = glob("imgs/*.*");

            foreach ($Images as $value) {  

              $img = $this->imagesModel->getImgs($username);
              if ($img->getImg() == basename($value)) {

                $rssFeed .= '<div id="imgArea"><img src="'.$value.'"><h4>'.$username.' är inloggad</h4></div>';
                $pic = $value;
              }
            }

        if(basename($pic) === "" && $user->getSex() == "Man") 
          {
             $rssFeed .= '<div id="imgArea"><img src="img/default.jpg"><h4>'.$username.' är inloggad</h4></div>';
          }
         else if(basename($pic) === "" && $user->getSex() == "Kvinna")
         {
            $rssFeed .= '<div id="imgArea"><img src="img/kvinna.png"><h4>'.$username.' är inloggad</h4></div>';
         }     

       $rssFeed .= "
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
                   <li><a name='profile' href='?". $this->userProfileLocation . "&id=".$this->model->getId()."'>Min profil</a></li>
                   <li><a name='logOut' href='?". $this->logOutLocation . "'>Logga ut</a></li>
                </ul>
             </div>
          </nav>
          ";

          
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