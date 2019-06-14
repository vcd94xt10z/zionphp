$(document).ready(function(){
});

function testCallback(type,responseBody,statusText,responseObj){
	if(responseObj.status == 200){
		$("#result").html("<div class=\"alert alert-success\" role=\"alert\">E-mail enviado</div>");
	}else{
		$("#result").html("<div class=\"alert alert-danger\" role=\"alert\">"+responseObj.responseText+"</div>");
	}
}