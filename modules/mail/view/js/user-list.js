$(document).ready(function(){
	var code = "";
	code += "<a class='btn btn-primary' href='#' style='margin-left: 10px;' id='button-test'>";
		code += "Testar Envio";
	code += "</a>";
	$("#button-new").after(code);
	
	$("#button-test").click(function(){
		var server = window.prompt("Informe o servidor");
		var user   = window.prompt("Informe o remetente");
		var to     = window.prompt("Informe o destinatário");
		
		var args = new Array();
		args.push("server="+server);
		args.push("user="+user);
		args.push("to="+to);
		
		var url = '/zion/mod/mail/User/sendTest/?'+args.join("&");
		var win = window.open(url,"_blank");
		win.focus();
	});
});