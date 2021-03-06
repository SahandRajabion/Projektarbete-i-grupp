<?php 

session_start();

require_once("Settings.php");
require_once('View/UploadView.php');
require_once('View/FeedView.php');
require_once('Model/Image.php');
require_once('Model/LoginModel.php');
require_once('Model/PostItems.php');
require_once('Model/PostModel.php');
require_once('Model/Youtube.php');
require_once('Model/Dao/CommentRepository.php');
require_once('Controller/LoginController.php'); 

$regExYoutube = "/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/";
$imgRoot = getcwd()."/View/UploadImages/";
$uploadPage = new UploadView();
$model = new LoginModel();
$feed = new FeedView($model);
$postModel = new PostModel();
$loginController = new LoginController();
$counter = 1;
 
function GetUrlCode() 
{
	return $uploadPage->getUrlCode();
}

try 
{
	if ($model->isAdmin() || ($model->isAdmin() === false && $_POST['courseid'] === "1")) 
	{
		if (isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
		{
			$UploadDirectory = $imgRoot; 

			if ($_FILES["FileInput"]["size"] > 5242880) 
			{
				die();
			}

			switch(strtolower($_FILES['FileInput']['type']))
			{
				//allowed file types
			    case 'image/png': 
				case 'image/gif': 
				case 'image/jpeg': 
					break;

				default:
					die();
			}

			$File_Name          = strtolower($_FILES['FileInput']['name']);
			$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
			$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
			$NewFileName 		= $Random_Number.$File_Ext; //new file name

			if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
			{
			   	$image = new Image($NewFileName,$uploadPage->getTitle(), $loginController->getId());
				$id = $postModel->addImage($image, $_POST['courseid']);
			}

			else
			{
				die();
			}
		}

		else
		{
			if ($uploadPage->getTitle() != "") 
			{
				if (!preg_match($regExYoutube, $uploadPage->getTitle())) 
				{

					$post = new PostItems(null,$loginController->getId(), null, $uploadPage->getTitle(),null, null, null, null, null, null, null);
					$id = $postModel->addPost($_POST['courseid'], $post);
				}

				else
				{
					$fullURL = $uploadPage->getTitle();

					if (preg_match($regExYoutube, $fullURL)) 
					{
						$newURL = substr($fullURL, 32);
						$video = new Youtube($newURL, $loginController->getId());
						$id = $postModel->addVideo($video, $_POST['courseid']);
					} 
				}
			}
			else
			{
			  	die();
			}
		}		
	}
}

catch (Exception $e) 
{
	error_log($e->getMessage() . "\n", 3, Settings::$ERROR_LOG);

	if (Settings::$DO_DEBUG) 
	{
    	throw $e;
    }
}