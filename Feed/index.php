<?php

include('View/HTMLView.php');
include('View/FeedView.php');
require_once('Controller/MasterController.php');

$htmlView = new HTMLView();
$feedView = new FeedView();
$masterController = new MasterController();

// Run Application
$masterController->doControll();
$html = $feedView->GetFeedHTML();

$htmlView->EchoHTML($html);