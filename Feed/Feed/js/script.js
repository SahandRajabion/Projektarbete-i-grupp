/*
	Återanvänding av kod, hittat via: http://runnable.com/UfJrnXtk2tZXAAA1/how-to-check-password-strength-using-jquery
*/
$(document).ready(function()
{
	//Kör funktionen varje gång användaren knappar in något med hjälp av ".keyup".
	$('#password').keyup(function()
	{
		$('#result').html(checkStrength($('#password').val()))
	})	
	
	
	//Validerar lösenordets säkerhets styka.
	function checkStrength(password)
	{
		
		var strength = 0
		
		//Validerar input längden.
		if (password.length < 6) { 
			$('#result').removeClass()
			$('#result').addClass('short')
			return 'För Kort' 
		}
		
		
		
		//Är längden på lösenordet längre än 8 tecken, öka "styrkenivå".
		if (password.length > 7) strength += 1
		
		//Innehåller lösenordet stora och små bokstäer, öva "styrkenivå"
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
		
		//Innehåller lösenordet siffror, öka "styrkenivå".
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
		
		//Innehåller lösenordet special tecken, öka "styrkenivå".
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
		
		//Innehåller lösenordet två special tecken, öka "styrkenivå".
		if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		
		
		
		//Beroende på slutgiltig resultat av ovanstående validering (värde på "strenght"), retunerar ett medelande.
		if (strength < 2 )
		{
			$('#result').removeClass()
			$('#result').addClass('weak')
			return 'Svag'			
		}
		else if (strength == 2 )
		{
			$('#result').removeClass()
			$('#result').addClass('good')
			return 'Bra'		
		}
		else
		{
			$('#result').removeClass()
			$('#result').addClass('strong')
			return 'Stark'
		}
	}
});