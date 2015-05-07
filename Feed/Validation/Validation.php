<?php

/**
* 
*/
class Validation 
{

  	//Messages for upload function.
	private static $ErrorUPLOAD_ERR_FORM_SIZE = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				     <button type="button" class="close" data-dismiss="alert">
  											     <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										         <strong>Filen är för stort!!</strong></div>';
	private static $ErrorUPLOAD_ERR_NO_FILE = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				  <button type="button" class="close" data-dismiss="alert">
  											  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										      <strong>Välj en bild först sen tryck ladda upp!!!</strong></div>';
	private static $ErrorUPLOAD_ERR_NO_TMP_DIR = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				      <button type="button" class="close" data-dismiss="alert">
  											      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										          <strong>Som fel har inträffat</strong></div>';


//Regex validation.
	private $emailExp;
	private $Exp;

	function __construct()
	{
		# code...
		//Regx took from http://www.phpportalen.net/.
		$this->emailExp = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
		$this->Exp = "/^([a-zA-ZÅÄÖåäö]{2,10})([- ]{1})?([a-zA-ZÅÄÖåäö]{2,10})?$/";
	}



	//Validation for contact form.
		public function ContactFormValidation($Name,$Email,$Message) {
			if ($Name == null && $Email == null && $Message == null) {
				return 46;
			}
		   else if ($Name == null) {
				return 47;
			}
			else if (mb_strlen($Name) < 3) {
				return 50;
			}
			else if(!preg_match($this->Exp, $Name)) {
				return 53;
			}
			
			else if($Email == null && $Message == null) {
				return 48;
			}
			else if ($Email == null) {
				return 49;
			}

			else if(!preg_match($this->emailExp, $Email)) {
				return 54;
			}
			
			else if ($Message == null) {
				return 51;
			}
			else if (mb_strlen($Message) < 3) {
				return 52;
			}				
				return true;
		}


	public function getImgName($upload) {
		$this->fileName = $upload;
	}

	public function hasSubmitToUpload($hasSubmit) {
			$this->didSubmit = $hasSubmit; 
	}
	public function getFileName($upload) {
			$this->fileName = $upload;
	}
	public function getImgRoot($imgPath) {
			$this->imgRoot = $imgPath;
	}

	public function errorToMessage() {
			//error message 3 is the file is uploaded but not complete.
		 if($this->fileName['error'] == 3) {
			if (file_exists($this->imgRoot . $this->fileName['name'])) {
				//Remove the wrong file that is not completed.
				unlink($this->imgRoot . $this->fileName['name']);
			}	
			return self::$ErrorUPLOAD_ERR_NO_TMP_DIR;
		 }
			// error message 2 & 3 for the file is big or the file length is bigger than is php ini supported.
	     else if($this->fileName['error'] == 2 || $this->fileName['error'] == 1) {
				return self::$ErrorUPLOAD_ERR_FORM_SIZE;
			}
			// error file 4 is that the user trying to upload widthout file.
	      else if($this->fileName['error'] == 4) {
		     	return self::$ErrorUPLOAD_ERR_NO_FILE;
		   }
	
     	}
}