$(document).ready(function(){
});

function callbackForm(type,responseBody,reason,obj){
	$("#code-ext").html("<pre>"+responseBody.ext+"</pre>");
	$("#code-script").html("<pre>"+responseBody.script+"</pre>");
	$("#code-vhost").html("<pre>"+responseBody.vhost+"</pre>");
}