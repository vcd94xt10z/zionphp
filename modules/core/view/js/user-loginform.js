$(document).ready(function(){
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
	
	console.log(type);
	console.log(responseBody);
	console.log(statusText);
	console.log(responseObj);
}