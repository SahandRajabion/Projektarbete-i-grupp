<?php

	class Validation {

	private $didSubmit;
	private $fileName;
	private $imagestypes;
	private $imgRoot;	

	//static messages for validation.



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




		public function __construct(){

		}

		public function getImgName($upload) {
			$this->fileName = $upload;
		}


		public function errorToMessage() {
			//error message 3 is the file is uploaded but not complete.
		 if($_FILES[$this->fileName]['error'] == 3) {
			if (file_exists($this->imgRoot . $_FILES[$this->fileName]['name'])) {
				//Remove the wrong file that is not completed.
				unlink($this->imgRoot . $_FILES[$this->fileName]['name']);
			}	
			return self::$ErrorUPLOAD_ERR_NO_TMP_DIR;
		 }
			// error message 2 & 3 for the file is big or the file length is bigger than is php ini supported.
	     else if($_FILES[$this->fileName]['error'] == 2 || $_FILES[$this->fileName]['error'] == 1) {
				return self::$ErrorUPLOAD_ERR_FORM_SIZE;
			}
			// error file 4 is that the user trying to upload widthout file.
	      else if($_FILES[$this->fileName]['error'] == 4) {
		     	return self::$ErrorUPLOAD_ERR_NO_FILE;
		   }
	
     	}

   		public function getFileName($upload) {
			$this->fileName = $upload;
		}

		
}