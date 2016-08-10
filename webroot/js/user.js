function toggleAutoActivate(){
	console.log($( "#auto-activate" ).is(':checked'));
	if($( "#auto-activate" ).is(':checked')){
		$('#password-container').show('slow');
		$('html, body').animate({
	        scrollTop: $("#password-container").offset().top
	    }, 1000);
	}
	else
	{
		$('#password-container').hide('slow');
	}
}

function addBasicInfo(){
	if($( "#auto-activate" ).is(':checked')){
		var message = "";
		var password =  $("#password").val();
		var confirm_password =  $("#confirm-password").val();
		if(password=="")
			message += "Password is required \n";
		if(confirm_password=="")
			message += "Confirm Password is required \n";
		console.log(password);
		console.log(confirm_password);
		if(password!=confirm_password)
			message += "Confirm password mismatch \n";
		
		if(message != ""){
			alert(message);
			return false;
		}
	}
	return true;
}