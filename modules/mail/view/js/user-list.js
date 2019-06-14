$(document).ready(function(){
	var code = "";
	code += "<a class='btn btn-primary' href='#' style='margin-left: 10px;' id='button-test'>";
		code += "Testar Envio";
	code += "</a>";
	$("#button-new").after(code);
	
	$("#button-test").click(function(){
		var url = '/zion/mod/mail/User/sendTestForm/';
		var win = window.open(url,"_blank");
		win.focus();
	});
});