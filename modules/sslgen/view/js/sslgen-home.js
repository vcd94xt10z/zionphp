$(document).ready(function(){
});

function callbackForm(type,responseBody,reason,obj){
	$("#code-ext").html("<pre>"+responseBody.ext+"</pre>");
	$("#code-scriptCA").html("<pre>"+responseBody.scriptCA+"</pre>");
	$("#code-scriptSite").html("<pre>"+responseBody.scriptSite+"</pre>");
	$("#code-vhost").html("<pre>"+responseBody.vhost+"</pre>");
	$(".zcode_area > div").css("display","block");
}