<?php
	
	require_once('Validation/Validation.php');
	require_once('View/UploadView.php');
	require_once('Model/ImagesModel.php');
	require_once('Model/Images.php');
	require_once('View/CookieStorage.php');

	class UploadController {

		private $validation;
	    private $imgRoot;
	    private $uploadPage;
	    private $fileName;
	    private $imagesModel;
	    private $feedView;
	    private $cookieStorage;

		private static $UPLOADEDSUCCESSED = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										     <strong>Bilden har laddats upp!</strong></div>';

		private static $ErrorUPLOAD_ERR_TYPE = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				    <button type="button" class="close" data-dismiss="alert">
  											    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										        <strong>Bilden måste vara av typen gif,jepg,jpg eller png!</strong></div>';



		public function __construct() {

			$this->validation = new Validation();
			$this->imgRoot = getcwd()."/View/Images/";
			$this->uploadPage = new UploadView();
			$this->fileName = $this->getFileName();
			$this->imagesModel = new ImagesModel();
			$this->feedView = new FeedView();
			$this->cookieStorage = new CookieStorage();

		}

		//Get input and other stuff from upload view class.
		private function DidHasSubmit() {
			return $this->uploadPage->hasSubmitToUpload();
		}

		private function getFileName() {
			 return $this->uploadPage->GetImgName();
		}

		private function GetComment() {
			return $this->uploadPage->getComments();
		}



		//Send image path to validation class.
		private function getImgPath() {
			$this->validation->getImgRoot($this->imgRoot);
		}

		// Get input and other stuff from feedView view class.

		private function getHiddenID() {
			return $this->feedView->getHiddenId();
		}

		private function getHiddenImg() {
			return $this->feedView->getSessionHidden();
		}

		private function GetImageComments() {
			return $this->feedView->GetImageComment();
		}

	
		private function GetSaveds() {
			return $this->feedView->GetSaved();
		}

		private function getHiddenImgEdit() {
			return $this->feedView->getSessionHiddenEdit();
		}
		

		//Render upload funcation.
		public function imgUpload() {
			$this->uploadPage->RenderUploadForm();

			$counter = 1;
			$this->validation->getFileName($this->fileName);
	
			if ($this->DidHasSubmit() == true) {	

				// check if has file and make sure that the file have a right type.
				if (is_uploaded_file($_FILES[$this->fileName]['tmp_name'])) {
					if (exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_GIF ||
						 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_JPEG ||
						 	 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_PNG) {

						if (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {

							//Get image name and image extension to add a counter to the exists image.
							$FileNameInfo = new SplFileInfo($_FILES[$this->fileName]['name']);
							$extension = $FileNameInfo->getExtension();
							$pointEx = substr(strrchr($_FILES[$this->fileName]['name'],"."), -4);
							$FileNameWithOutEx = $FileNameInfo->getBasename($pointEx);

							// While file is existes , add a counter to the name of the file .
							while (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {
								$_FILES[$this->fileName]['name'] = $FileNameWithOutEx."(".$counter++.")." . $extension;
							}
				
						}
						
						
						if ($_FILES[$this->fileName]['size'] < 5000000) {

							//Resize images before uploaded to folder.

							// Create a new image from file or URL.
							$imgCreateFromJ = imagecreatefromjpeg($_FILES[$this->fileName]['tmp_name']);
							$imgCreateFromP = imagecreatefrompng($_FILES[$this->fileName]['tmp_name']);
							$imgCreateFromG = imagecreatefromgif($_FILES[$this->fileName]['tmp_name']);
							// Get image width and height.
							$imgWidth =	getimagesize($_FILES[$this->fileName]['tmp_name'])[0];
							$imgHeigth = getimagesize($_FILES[$this->fileName]['tmp_name'])[1];

							$newImgWidth = 400;
							$newImgHeight = ($imgHeigth/$imgWidth) * $newImgWidth;
							//Create a new true color image
							$ImgCreateColor = imagecreatetruecolor($newImgWidth, $newImgHeight);
							//Copy and resize part of an image with new image size.
							imagecopyresampled($ImgCreateColor, $imgCreateFromJ, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
						    imagecopyresampled($ImgCreateColor, $imgCreateFromP, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
						   	imagecopyresampled($ImgCreateColor, $imgCreateFromG, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);


							// creates a JPEG from uploaded image.
							$imgToUploadJ = imagejpeg($ImgCreateColor,$this->imgRoot.$_FILES[$this->fileName]['name'],100);
							$imgToUploadP = imagepng($ImgCreateColor,$this->imgRoot.$_FILES[$this->fileName]['name'],100);
							$imgToUploadG = imagegif($ImgCreateColor,$this->imgRoot.$_FILES[$this->fileName]['name'],100);
							 if ($imgToUploadJ || $imgToUploadP || $imgToUploadG ) {
								$images = new Images($_FILES[$this->fileName]['name'],$this->GetComment());
							 	$this->imagesModel->addImages($images);

							 	//change file mode, 0755 read and execute.
							 	chmod($this->imgRoot.$_FILES[$this->fileName]['name'], 0755);
							  	imagedestroy($imgCreateFromJ);
							  	imagedestroy($imgCreateFromP);
							  	imagedestroy($imgCreateFromG);
						      	imagedestroy($ImgCreateColor);
						      	$this->cookieStorage->SaveMessageCookie(self::$UPLOADEDSUCCESSED);
						      	header('Location: ?page=FeedView');
							 	}	
						}
					}


					else {
							return $this->uploadPage->imageUpload(self::$ErrorUPLOAD_ERR_TYPE);
						 }
				}
				else {
						return $this->uploadPage->imageUpload($this->validation->errorToMessage());
					 }
			}
		}	

	}