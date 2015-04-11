<?php

	require_once('View/UploadView.php');	
	require_once('View/FeedView.php');
	require_once('Model/ImagesModel.php');
	require_once('Model/Images.php');
	require_once('Model/Posts.php');
	require_once('Model/PostModel.php');
	require_once('Model/YoutubeModel.php');
	require_once('Model/Youtube.php');

	$regExYoutube = "/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/";


			$imgRoot = getcwd()."/View/Images/";
			$uploadPage = new UploadView();
			$feed = new FeedView();
			$imagesModel = new ImagesModel();
			$postModel = new PostModel();
			$youtubeModel = new YoutubeModel();
			$counter = 1;


		 function GetUrlCode() 
		 {
			return $uploadPage->getUrlCode();
		 }

		 	if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
			{
				$UploadDirectory = $imgRoot; 
	
				//Is file size is less than allowed size.
				if ($_FILES["FileInput"]["size"] > 5242880) {
				echo("Filen storlek är för stor!");
				}
	
				//allowed file type Server side check
				switch(strtolower($_FILES['FileInput']['type']))
				{
					//allowed file types
     		       case 'image/png': 
					case 'image/gif': 
					case 'image/jpeg': 
						break;
					default:
						echo('Fel file type!'); //output error
				}
	
				$File_Name          = strtolower($_FILES['FileInput']['name']);
				$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
				$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
				$NewFileName 		= $Random_Number.$File_Ext; //new file name
	
				if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
				   {
				   	$images = new Images($NewFileName,$uploadPage->getTitle());
					$imagesModel->addImages($images);
					echo $feed->GetFeedHTML();
					echo('Bilden har laddat upp!');
					}else{
					echo('Som fel har inträffat, gick inte att ladda upp bilden!');
					}
	
				}
				else
				{
				  if ($uploadPage->getTitle() != "") {

					if (!preg_match($regExYoutube, $uploadPage->getTitle())) {
						$post = new Posts($uploadPage->getTitle());
						$postModel->addPost($post);
						echo("Inlägget har lagts till!");
						echo $feed->GetFeedHTML();		
					}
					else
					{
						$fullURL =$uploadPage->getTitle();
						if (preg_match($regExYoutube, $fullURL)) {
						$newURL = substr($fullURL, 32);
						$video = new Youtube($newURL);
						$youtubeModel->addVideo($video);
						echo $feed->GetFeedHTML();
						echo("Youtube klippet har lagts till!");
    					} 
					}

				  }
				  else
				  {
				  	echo("Som fel har inträffat!");
				  }
				}