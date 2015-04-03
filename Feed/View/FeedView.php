<?php

include('Model/Dao/FeedRepository.php');

class FeedView
{
    private $feedRepository;

    public function __construct() 
    {
        $this->feedRepository = new FeedRepository();
    }

    public function GetFeedHTML()
    {
        $feedItems = $this->feedRepository->GetFeedItems();

        $html = 
        "<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv='Content-Type'content='text/html; charset=utf-8' />
        <title>Newsfeed</title>
        <link rel='stylesheet' href='css/style.css' />
        <script type='text/javascript' src='js/jquery.min.js'></script>
        <script type='text/javascript' src='js/script.js'></script>
        <script type='text/javascript' src='js/autoload.js'></script>
        </head>

        <body>
            <div class='container'>
                <div class='header'>
                </div>
                <h1 class='main_title'>Newsfeed</h1>
                <div class='content'>
                <ul id='items'>";

        $last_id = 0;

        // Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
        foreach ($feedItems as $feedItem) 
        {
            $last_id = $feedItem['id'];

            $html .= 
            "<li>
                <h2>" . $feedItem['title'] . "</h2>
                <p> " . $feedItem['description'] . "</p>
            </li>";
        }

        // Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet
        $html .= "<script type='text/javascript'>var last_id = " . $last_id . ";</script> 
                </ul>
                <p id='loader'><img src='images/ajax-loader.gif'></p>
                </div>  
                <div class='footer'>
                </div>
            </div>
        </body>
        </html>";

        return $html;
    }
}