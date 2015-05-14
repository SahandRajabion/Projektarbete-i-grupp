<?php
	
	//the require once here just to show the coupling between classes.
	require_once('Validation/Validation.php');
	require_once('View/ProfileView.php');
	require_once('Model/ImagesModel.php');
	require_once('Model/ProfilePic.php');
	require_once('helper/CookieStorage.php');

	class UploadController {
		private $validation;
	    private $imgRoot;
	    private $uploadPage;
	    private $fileName;
	    private $imagesModel;
	    private $cookieStorage;
	    private $model;

		private static $ErrorUPLOAD_ERR_TYPE = "<div class='alert alert-danger alert-error'>
           <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
           <a href='#' class='close' data-dismiss='alert'>&times;</a>        
          <span id='sizeOfPTag'>Image must be of format gif, jpg, or png</span>
          </div>";

		public function __construct(ProfileView $uploadPage,LoginModel $model) {
			$this->validation = new validation();
			$this->imgRoot = getcwd()."/imgs/";
			$this->uploadPage = $uploadPage;
			$this->fileName = $this->getFileName();
			$this->imagesModel = new ImagesModel();
			$this->cookieStorage = new CookieStorage();
			$this->model = $model;
		}
		//Get input and other stuff from upload view class.
		private function DidHasSubmit() {
			return $this->uploadPage->hasSubmitToUpload();
		}
		private function DidHasSubmitToDefault() {
			return $this->uploadPage->hasSubmitToDefault();
		}
		private function getFileName() {
			 return $this->uploadPage->GetImgName();
		}
		//Send image path to validation class.
		private function getImgPath() {
			$this->validation->getImgRoot($this->imgRoot);
		}
	
		//Render upload funcation.
		public function imgUpload() {
			
			$counter = 1;
			$this->validation->getFileName($this->fileName);
			if ($this->DidHasSubmitToDefault()) {
				# code...
				$images = new ProfilePic("img/default.jpg",$this->model->getId());
				$this->imagesModel->updateImage($images);
				header("Location: ?profile&id=".$this->model->getId());
			}
			if ($this->DidHasSubmit() == true) {
							// check if has file and make sure that the file have a right type.
				if (is_uploaded_file($this->fileName['tmp_name']) || $this->fileName['tmp_name'] != "") {

					if (exif_imagetype($this->fileName['tmp_name']) == IMAGETYPE_GIF ||
						 exif_imagetype($this->fileName['tmp_name']) == IMAGETYPE_JPEG ||
						 	 exif_imagetype($this->fileName['tmp_name']) == IMAGETYPE_PNG) {

						if (file_exists($this->imgRoot.$this->fileName['name'])) {
							//Get image name and image extension to add a counter to the exists image.
							$FileNameInfo = new SplFileInfo($this->fileName['name']);
							$extension = $FileNameInfo->getExtension();
							$pointEx = substr(strrchr($this->fileName['name'],"."), -4);
							$FileNameWithOutEx = $FileNameInfo->getBasename($pointEx);
							// While file is existes , add a counter to the name of the file .
							while (file_exists($this->imgRoot.$this->fileName['name'])) {
								$this->fileName['name'] = $FileNameWithOutEx."(".$counter++.")." . $extension;
							}
				
						}
						
					
						if ($this->fileName['size'] < 5000000) {
							//Resize images before uploaded to folder.
							// Create a new image from file or URL.
							$imgCreateFromJ = @imagecreatefromjpeg($this->fileName['tmp_name']);
							$imgCreateFromP = @imagecreatefrompng($this->fileName['tmp_name']);
							$imgCreateFromG = @imagecreatefromgif($this->fileName['tmp_name']);
							// Get image width and height.
							$imgWidth =	getimagesize($this->fileName['tmp_name'])[0];
							$imgHeigth = getimagesize($this->fileName['tmp_name'])[1];
							$newImgWidth = 400;
							$newImgHeight = ($imgHeigth/$imgWidth) * $newImgWidth;
							//Create a new true color image
							$ImgCreateColor = @imagecreatetruecolor($newImgWidth, $newImgHeight);
							//Copy and resize part of an image with new image size.
							@imagecopyresampled($ImgCreateColor, $imgCreateFromJ, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
						    @imagecopyresampled($ImgCreateColor, $imgCreateFromP, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
						   	@imagecopyresampled($ImgCreateColor, $imgCreateFromG, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
							// creates a JPEG from uploaded image.
							$imgToUploadJ = @imagejpeg($ImgCreateColor,$this->imgRoot.$this->fileName['name'],100);
							$imgToUploadP = @imagepng($ImgCreateColor,$this->imgRoot.$this->fileName['name'],100);
							$imgToUploadG = @imagegif($ImgCreateColor,$this->imgRoot.$this->fileName['name'],100);
							
							 if ($imgToUploadJ || $imgToUploadP || $imgToUploadG ) {
								$images = new ProfilePic($this->fileName['name'],$this->model->getId());
							 	$this->imagesModel->updateImage($images);
								header("Location: ?profile&id=".$this->model->getId());
	
							 	//change filem mode, 0755 read and execute.
							 	chmod($this->imgRoot.$this->fileName['name'], 0755);
							  	@imagedestroy($imgCreateFromJ);
							  	@imagedestroy($imgCreateFromP);
							  	@imagedestroy($imgCreateFromG);
						      	@imagedestroy($ImgCreateColor);
							 	}	
						}
					}
					else {
						$this->uploadPage->setMessage(self::$ErrorUPLOAD_ERR_TYPE);
													return $this->uploadPage->userProfile();

						 }
				}
				else {
						$this->uploadPage->setMessage($this->validation->errorToMessage());
						return $this->uploadPage->userProfile();
					 }
			}
			else
			{
				return $this->uploadPage->RenderUserProfile();
			}
		}	
	}