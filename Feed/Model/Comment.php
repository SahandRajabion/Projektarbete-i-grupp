<?php

require_once("Model/LoginModel.php");

class Comment
{
	private $data = array();
	private $userId;
	private $loginModel;
	
	public function __construct($data, $userId)
	{
		$this->data = $data;
		$this->userId = $userId;
		$this->loginModel = new LoginModel();
	}

	public function GetUserId() 
	{
		return $this->userId;
	}
	
	public function GetCommentHTML()
	{
		$this->data['date'] = strtotime($this->data['date']);

		$html = "";

		$html .= '<div class="comment" id ="comment' .  $this->data["CommentId"] . '">';

		if ($this->loginModel->getId() == $this->userId) {
			$html .=
			'<a href="#" class="delete_button" id="' . $this->data["CommentId"] . '">
	  		<img src="images/icon_del.gif" border="0" />
	  		</a>';
  		}

		$html .= '<div class="date">' . date('j F Y H:i:s', $this->data['date']) . '</div>
				<p>' . $this->data['body'] . '</p>
			</div>';

		return $html;
	}
	
	public static function validate(&$values)
	{
		$errors = array();
		$data	= array();

		$data['id'] = $_POST['id'];
		
		if(!($data['body'] = filter_input(INPUT_POST, 'body', FILTER_CALLBACK, array('options'=>'Comment::ValidateText'))))
		{
			$errors['body'] = 'Vänligen skriv en kommentar';
		}

		if(!empty($errors))
		{	
			// Om några fel hittas så lägg in de i referens variabeln
			$values = $errors;
			return false;
		}
		
		// Om inga fel hittas så lägg värderna i referens variabeln
		foreach($data as $key => $value){
			$values[$key] = $value;
		}
		
		return true;
	}

	// Metoden används som FILTER_CALLBACK
	private static function ValidateText($string)
	{
		// Ser till att man har skrivit något
		if(mb_strlen($string, 'utf8') < 1)
			return false;
	
		// Tar bort alla specialtecken och gör om mellanslag till br taggar
		$string = nl2br(htmlspecialchars($string));
		
		// Tar bort de mellanslag som finns kvar
		$string = str_replace(array(chr(10), chr(13)), '', $string);
		
		return $string;
	}
}
