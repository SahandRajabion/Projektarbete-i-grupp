<?php

/**
* 
*/
class Validation 
{

//Message for Contact function.
  	private static $ErrorMsgAndEmail = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		    <button type="button" class="close" data-dismiss="alert">
  									    <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  								        <strong>Epost & meddelande fälten måste innehålla något.</strong></div>';										          
	private static $ErrorNameMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		    <button type="button" class="close" data-dismiss="alert">
  									    <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  								        <strong>Kontrollera namnet, fel format.</strong></div>';
	private static $ErrorEmailMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 	         <button type="button" class="close" data-dismiss="alert">
  							   	         <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  								         <strong>Kontrollera epost, fel format.</strong></div>';
	private static $ErrorEmptyMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 			<button type="button" class="close" data-dismiss="alert">
  									    <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  							            <strong>Meddelande fältet får ej vara tomt.</strong></div>';
	private static $ErrorEmptyName = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		 <button type="button" class="close" data-dismiss="alert">
  									 <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  									<strong>Ett namn måste anges.</strong></div>';
	private static $ErrorEmptyEmail = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		   <button type="button" class="close" data-dismiss="alert">
  								       <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  								       <strong>En epost-adress måste anges.</strong></div>';
	private static $ERRORInput = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 	  <button type="button" class="close" data-dismiss="alert">
  								  <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  							      <strong>Ett namn måste anges.<br> En epost-adress måste anges. <br> Meddelande fältet får ej vara tomt.</strong></div>';
	private static $ErrorMiniName = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		 <button type="button" class="close" data-dismiss="alert">
  								     <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  							         <strong>Namnet måste bestå av minst 3 tecken.</strong></div>';
	private static $ErrorMiniMsg = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 	    <button type="button" class="close" data-dismiss="alert">
  								    <span aria-hidden="true">&times;</span><span class="sr-only">Stäng</span></button>
  								    <strong>Meddelandet måste innehålla minst 3 tecken.</strong></div>';


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
				return self::$ERRORInput;
			}
		   else if ($Name == null) {
				return self::$ErrorEmptyName;
			}
			else if (mb_strlen($Name) < 3) {
				return self::$ErrorMiniName;
			}
			else if($Email == null && $Message == null) {
				return self::$ErrorMsgAndEmail;
			}
			else if ($Email == null) {
				return self::$ErrorEmptyEmail;
			}
			else if ($Message == null) {
				return self::$ErrorEmptyMessage;
			}
			else if (mb_strlen($Message) < 3) {
				return self::$ErrorMiniMsg;
			}
			else if(!preg_match($this->Exp, $Name)) {
				return self::$ErrorNameMessage;
			}
			else if(!preg_match($this->emailExp, $Email)) {
				return self::$ErrorEmailMessage;
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