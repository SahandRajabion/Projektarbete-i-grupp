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

?>

<script src="js/oldJquery.js"></script>

<script type="text/javascript" src="js/LoadMoreSentMsg.js"></script>
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
