<?php
require_once('View/HTMLView.php');
require_once('Controller/MasterController.php');
require_once("Settings.php");
require_once("View/BaseView.php");

session_start();

try 
{
	$htmlView = new HTMLView();
	$masterController = new MasterController();

	// Run Application
	$html = $masterController->doControll();
	$htmlView->EchoHTML($html);
}

catch (Exception $e) 
{
	error_log($e->getMessage() . "\n", 3, Settings::$ERROR_LOG);

	if (Settings::$DO_DEBUG) 
	{
		throw $e;
	}
}

// Kan fucka up de för dom andra som använder denna JavaScript
//<script type='text/javascript' src='js/jquery.min.js'></script>
//<link rel='stylesheet' href='css/bootstrap.min.css'>


// FÅR INDIVIDUELL CSS I VARJE HTML UTSKRIVNING ANNARS KAOS
?>

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