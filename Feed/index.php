<?php

include('View/HTMLView.php');
include('View/FeedView.php');

$htmlView = new HTMLView();
$feedView = new FeedView();

$html = $feedView->GetFeedHTML();

$htmlView->EchoHTML($html);