<?php

include('View/HTMLView.php');
include('View/FeedView.php');
require_once('Controller/MasterController.php');

session_start();


$htmlView = new HTMLView();
$feedView = new FeedView();
$masterController = new MasterController();

// Run Application
$html = $masterController->doControll();

$htmlView->EchoHTML($html);

?>
        <link rel='stylesheet' href='css/style.css' />
        <script type='text/javascript' src='js/jquery.min.js'></script>
        <script type='text/javascript' src='js/LoadMoreItems.js'></script>
        <script type='text/javascript' src='js/InsertComment.js'></script>
        <script type='text/javascript' src='js/DeleteComment.js'></script>
        <script type='text/javascript' src='js/DeletePost.js'></script>
        <script type='text/javascript' src='js/EditPost.js'></script>
        <script type='text/javascript' src='script/AjaxUpload.js'></script>
        <script type='text/javascript' src='script/jquery.form.min.js'></script>