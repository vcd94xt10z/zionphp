function cb_recarregarFiltro(){
	$("#filter-button").click();
}

$(document).ready(function(){
	var code = "";
	code += "<button id=\"btn-job\" type=\"button\" class=\"btn btn-outline-info ajaxlink\" data-url=\"/zion/mod/core/System/job\" data-callback='cb_recarregarFiltro'>";
	code += "Job";
	code += "</button>";
	$("#button-new").after(code);
	$("#btn-job").css("marginLeft","5px");
});