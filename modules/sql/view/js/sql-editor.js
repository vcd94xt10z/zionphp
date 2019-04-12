$(document).ready(function(){
	window.editor = CodeMirror.fromTextArea(document.getElementById('sql-query'), {
		mode: 'text/x-sql',
	    indentWithTabs: true,
	    smartIndent: true,
	    lineNumbers: true,
	    matchBrackets : true,
	    autofocus: true,
	    extraKeys: {
          'Ctrl-Enter': (cm) => {
        	  runQuery();
          }
	    }
	});
	
	$("#sql-search").keyup(function(e){
		// chamar somente quando for caracteres válidos
		loadObjects();
	});
	
	$(".zcontextmenu a").click(function(){
		var self = $(this);
		var cmd  = self.text();
		var type = self.parent().parent().attr("data-type");
		var name = self.parent().parent().attr("data-name");
		
		sendToEditor(type,cmd,name);
	});
	
	loadObjects();
});

$(document).on("contextmenu",".zcm", function(e) {
	var type = $(this).attr("data-type");
	var name = $(this).text();
	var top  = e.pageY;
	var left = e.pageX;
	
	$(".zcontextmenu").css("display","none");
	$(".zcontextmenu[data-type="+type+"]").css({
		position: "absolute",
		display: "block",
		top: top,
		left: left
	}).attr("data-name",name);
	return false;
}).on("click", function() {
	$(".zcontextmenu").css("display","none");
});

function renderListHTML(list,type){
	var code = "";
	
	code += "<ul>";
	for(var i in list){
		code += "<li class='zcm' data-type='"+type+"'>"+list[i].name+"</li>";
	}
	code += "</ul>";
	
	return code;
}

function sendToEditor(type,cmd,name){
	$.ajax({
		url: '/zion/mod/sql/SQL/statement/?type='+type+"&cmd="+cmd+"&name="+name,
		method: "GET",
		cache: false
	}).done(function(result){
		if(result != ""){
			window.editor.setValue(result);
			if(cmd == "SELECT"){
				runQuery();
			}
		}
	});
}

function loadObjects(){
	var query = $("#sql-search").val();
	
	$.ajax({
		url: '/zion/mod/sql/SQL/objectList/?name='+query,
		method: "GET",
		cache: false
	}).done(function(result){
		var code = "";
		
		code += "<ul>";
			code += "<li class='cat type-table'><span>Tables ("+result.table.length+")</span>";
			code += renderListHTML(result.table,"table");
			code += "</li>";
			
			code += "<li class='cat type-view'><span>Views ("+result.view.length+")</span>";
			code += renderListHTML(result.view,"view");
			code += "</li>";
			
			code += "<li class='cat type-function'><span>Functions ("+result.function.length+")</span>";
			code += renderListHTML(result.function,"function");
			code += "</li>";
			
			code += "<li class='cat type-procedure'><span>Procedures ("+result.procedure.length+")</span>";
			code += renderListHTML(result.procedure,"procedure");
			code += "</li>";
			
			code += "<li class='cat type-trigger'><span>Triggers ("+result.trigger.length+")</span>";
			code += renderListHTML(result.trigger,"trigger");
			code += "</li>";
			
			code += "<li class='cat type-event'><span>Events ("+result.event.length+")</span>";
			code += renderListHTML(result.event,"event");
			code += "</li>";
		code += "</ul>";
		
		$("#sql-objects").html(code);
	}).fail(function(a){
		alert(a.responseText);
	});
}

function runQuery(){
	var query = window.editor.getValue();
	
	query = query.replace("\r\n"," ");
	query = query.replace("\n"," ");
	query = query.replace("<br>"," ");
	
	$("#sql-message").html("").css("display","none");
	$("#sql-result").html("").css("display","none");
	
	// show loading here
	
	$.ajax({
		url: '/zion/mod/sql/SQL/run/?query='+query,
		method: "GET",
		cache: false
	}).done(function(resultList){
		var code = "";
		
		// cabeçalho (lê apenas a primeira linha)
		code += "<thead>";
		for(var i in resultList){
			var obj = resultList[i];
			
			code += "<tr>";
			for(var j in obj){
				code += "<td>"+j+"</td>";	
			}
			code += "</tr>";
			break;
		}
		code += "</thead>";
		
		// dados
		code += "<tbody>";
		for(var i in resultList){
			var obj = resultList[i];
			
			code += "<tr>";
			for(var j in obj){
				code += "<td>"+obj[j]+"</td>";	
			}
			code += "</tr>";
		}
		code += "</tbody>";
		
		// hide loading here
		$("#sql-result").html(code).css("display","block");
	}).fail(function(a,b,c,d){
		$("#sql-message").html(a.responseText).css("display","block");
		
		// hide loading here
	});
}