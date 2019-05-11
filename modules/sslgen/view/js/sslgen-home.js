$(document).ready(function(){
});

function callbackForm(type,responseBody,reason,obj){
	$("#code").html("<pre>"+responseBody+"</pre>");
}