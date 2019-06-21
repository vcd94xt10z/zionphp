$(document).ready(function(){
	yetiLogin("img1","user-login","user-password","button-tooglePassword");
	
	$("#button-tooglePassword").click(function(){
		var pass = $("#user-password");
		
		if(pass.attr("type") == "password"){
			pass.attr("type","text");
			
			
			$(this).removeClass("fa-eye");
			$(this).addClass("fa-eye-slash");
		}else{
			pass.attr("type","password");
			
			$(this).removeClass("fa-eye-slash");
			$(this).addClass("fa-eye");
		}
	});
});

function loginCallback(type,responseBody,statusText,responseObj){
	if(type == 'fail'){
		if(responseObj.status == 403){
			$.notify(responseObj.responseText);
			return;
		}
	}else{
		window.location = "/zion/mod/core/User/home";
	}
}