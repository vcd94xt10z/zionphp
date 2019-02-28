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
	
	loadObjects();
});

function loadObjects(){
	var query = $("#sql-search").val();
	
	$.ajax({
		url: '/zion/mod/sql/SQL/objectList/?name='+query,
		method: "GET",
		cache: false
	}).done(function(resultList){
		var code = "";
		
		
		for(var i in resultList){
			code += "<div class=\"dropdown\">";
			var obj = resultList[i];
			for(var j in obj){
				var objectid = "object-"+obj[j];
				code += "<button class=\"btn btn-outline-info dropdown-toggle\" type=\"button\" id=\""+objectid+"\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
					code += obj[j];
				code += "</button>";
				code += "<div class=\"dropdown-menu\" aria-labelledby=\""+objectid+"\">";
					code += "<a class=\"dropdown-item\" href=\"#\">SELECT</a>";
					code += "<a class=\"dropdown-item\" href=\"#\">INSERT</a>";
				code += "</div>";
			}
			code += "</div>";
		}
		
		
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