function cb_recarregarFiltro(){
	$("#filter-button").click();
}

$(document).ready(function(){
	let url  = "/zion/mod/core/System/job";
	let code = "";
	
	code += "<button id=\"btn-job\" type=\"button\" class=\"btn btn-outline-info ajaxlink\" data-url=\""+url+"\" data-callback='cb_recarregarFiltro'>";
	code += "Job";
	code += "</button>";
	
	code += "<a id=\"btn-monitor\" href=\"/zion/mod/error/Log/monitor\" class=\"btn btn-outline-info\">";
	code += "Monitor";
	code += "</a>";
	
	$("#button-new").after(code);
	$("#btn-job").css("marginLeft","5px");
	$("#btn-monitor").css("marginLeft","5px");
});