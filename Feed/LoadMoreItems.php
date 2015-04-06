<?php

require_once('Model/Dao/FeedRepository.php');
require_once('View/HTMLView.php');

$feedRepository = new FeedRepository();
$htmlView = new HTMLView();

// Hämtar ut sista id som har postats från Ajax anropet
$last_id = $_POST['last_id'];

$feedItems = $feedRepository->GetMoreFeedItems($last_id);

$last_id = 0;
$html = "";

// Skriver ut varje feed item och sparar undan de sista id som blir från sista feed item
foreach ($feedItems as $feedItem)
{
    $last_id = $feedItem['id'];
    
    $html .= "<li> <h2>" . $feedItem['title'] . "</h2> <p>" . $feedItem['description'] . "</p> </li>";

    $html .= "<div id='addCommentContainer'>
        <form id='addCommentForm' method='post' action=''>
            <div>
                <label for='body'>Add a comment</label>
                <textarea name='body' id='body' maxlength='250' cols='20' rows='5'></textarea>
                <input type='submit' id='submit' value='Comment'/>
            </div>
        </form>
    </div>";    
}

// Lagrar undan sista id i variabel i javascript kod så man kan hämta den sen för ajax anropet
if ($last_id != 0) 
{
	$html .= "<script type='text/javascript'>var last_id = " . $last_id . ";</script>";
}

$htmlView->EchoHTML($html);



