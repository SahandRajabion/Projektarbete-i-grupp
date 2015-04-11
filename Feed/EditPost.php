<?php

require_once('Model/Dao/PostRepository.php');

function ValidateText($string)
{		
	// Tar bort alla specialtecken och gör om mellanslag till br taggar
	$string = nl2br(htmlspecialchars($string));
	
	// Tar bort de mellanslag som finns kvar
	$string = str_replace(array(chr(10), chr(13)), '', $string);

	return $string;
}

$postRepository = new PostRepository();

$post = "";
$title = "";

if (isset($_POST['NewPostContent']) && empty($_POST['NewPostContent']) == false) 
{
	$post = ValidateText($_POST['NewPostContent']);
}

if (isset($_POST['NewPostTitle']) && empty($_POST['NewPostTitle']) == false) 
{
	$title = ValidateText($_POST['NewPostTitle']);
}

$postRepository->EditPost($_POST['FeedId'], $post, $title);

if ($post != "") 
{
	echo $post;
}

else if ($title != "") 
{
	echo $title;
}

