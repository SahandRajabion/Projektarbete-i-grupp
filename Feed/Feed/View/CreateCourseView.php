<?php

require_once("View/BaseView.php");
require_once('Model/Token.php');

class CreateCourseView extends BaseView
{

	public function DidUserPressToCreateCourse() {
		if (isset($_GET[$this->createNewCourseLocation])) {
			return true;
		}

		return false;
	}

	public function DidUserPressSubmitNewCourse() 
	{
		if (isset($_POST[$this->submitNewCourseLocation])) 
		{
			return true;			
		}

		return false;
	}	

	public function GetCheckedBoxes() 
	{
		if (isset($_POST[$this->programCheckBoxLocation])) 
		{
			$checkedBoxes = array();

			foreach ($_POST[$this->programCheckBoxLocation] as $checked) 
			{
				$checkedBoxes[] = $checked;
			}

			return $checkedBoxes;
		}
	}

	public function GetCourseName() 
	{
		if (isset($_POST[$this->courseNameLocation])) 
		{
			return $_POST[$this->courseNameLocation];
		}
	}

	public function GetCourseCode() 
	{
		if (isset($_POST[$this->courseCodeLocation])) 
		{
			return $_POST[$this->courseCodeLocation];
		}
	}

	public function GetRSSUrl() 
	{
		if (isset($_POST[$this->rssUrlLocation])) 
		{
			return $_POST[$this->rssUrlLocation];
		}
	}	
	

	public function ShowCreateCourseForm() 
	{
	    $html = "<!DOCTYPE html>
	    <html>
	    <head>
	    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
		<link rel='stylesheet' type='text/css' href='css/styleVal.css' />		
		<script src='js/script.js'></script>
	    <title>LSN</title>                
	    <meta charset='utf-8'>
	    <meta name='viewport' content='width=device-width, initial-scale=1'>
	    </head>
	    <body>
	     <div class='container'>";		

		$html .= "
		</br>
		<a href='?'>Tillbaka</a>
                    <form action='' class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
						<h1>Skapa ny kurs</h1>

						 <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->courseNameLocation'>Kursnamn: </label>
					         <div class='col-sm-10'>
					           <input class='form-control' name='$this->courseNameLocation' type='text' size='40' maxlength='40'>
					         </div>
					      </div>

					     <div class='form-group'>
					         <label class='col-sm-2 control-label' for='$this->courseCodeLocation'>Kurskod: </label>
					         <div class='col-sm-10'>
					           <input class='form-control' name='$this->courseCodeLocation' type='text' size='6' maxlength='6'>
					         </div>
					      </div>

					       <div class='form-group'>
					         <label class='col-sm-1 control-label' for='$this->rssUrlLocation'>RSS-feed URL: </label>
					         <div class='col-sm-10'>
					           <input class='form-control' name='$this->rssUrlLocation' type='text' size='6' maxlength='1000'>
					         </div>
					      </div></br></br>

					    <div class='form-group'>
					        <label class='col-sm-2 control-label1' for='$this->schoolLocation'>Kurs ska hamna under: </label>
					        <div class='col-sm-10'>
					        	<p><input type='checkbox' name='$this->programCheckBoxLocation[]' value='1'> Webbprogrammerare </p>
								<p><input type='checkbox' name='$this->programCheckBoxLocation[]' value='2'> Utvecklare av digitala tjänster </p> 
								<p><input type='checkbox' name='$this->programCheckBoxLocation[]' value='3'> Interaktionsdesigner </p>
					        </div>
					      </div> 

					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
				           	 <input type='hidden' name='CSRFToken' value='" . Token::generate() . "' />
					         <input class='btn btn-default' name='$this->submitNewCourseLocation' type='submit' value='Skapa kurs' />
					       </div>
					     </div>
					   </fieldset>
			       </form>";

		            $html .= "</div>
                </body>
                </html>";     	       
		
		return $html;
	}
}
