<?php

require_once('View/HTMLView.php');
require_once('Controller/MasterController.php');

session_start();

$htmlView = new HTMLView();
$masterController = new MasterController();

// Run Application
$html = $masterController->doControll();
$htmlView->EchoHTML($html);

?>

<link rel='stylesheet' href='css/styles.css' />
<link rel='stylesheet' href='css/bootstrap.min.css'>
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type='text/javascript' src='js/LoadMoreItems.js'></script>
<script type='text/javascript' src='js/GetLatestItems.js'></script>
<script type='text/javascript' src='js/InsertComment.js'></script>
<script type='text/javascript' src='js/DeleteComment.js'></script>
<script type='text/javascript' src='js/DeletePost.js'></script>
<script type='text/javascript' src='js/EditPost.js'></script>
<script type='text/javascript' src='js/UploadPost.js'></script>
<script type='text/javascript' src='js/jquery.form.min.js'></script>
<script type='text/javascript' src='js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/bootstrap.js'></script>