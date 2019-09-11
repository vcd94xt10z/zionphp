function cb_recarregarFiltro(){
	$("#filter-button").click();
}

$(document).ready(function(){
	let url  = "/zion/mod/core/System/job";
	let url2 = "/zion/mod/error/Log/cleanAll";
	let code = "";
	
	code += "<button id=\"btn-job\" type=\"button\" class=\"btn btn-outline-info ajaxlink\" data-url=\""+url+"\" data-callback='cb_recarregarFiltro'>";
	code += "Job";
	code += "</button>";
	
	code += "<a id=\"btn-monitor\" href=\"/zion/mod/error/Log/monitor\" class=\"btn btn-outline-info\">";
	code += "Monitor";
	code += "</a>";
	
	code += "<button id=\"btn-cleanAll\" type=\"button\" class=\"btn btn-outline-info ajaxlink\" data-url=\""+url2+"\" data-callback='cb_recarregarFiltro'>";
	code += "Limpar Erros";
	code += "</button>";
	
	$("#button-new").after(code);
	$("#btn-job").css("marginLeft","5px");
	$("#btn-monitor").css("marginLeft","5px");
	$("#btn-cleanAll").css("marginLeft","5px");
});