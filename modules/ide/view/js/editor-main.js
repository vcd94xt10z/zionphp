$(document).ready(function(){
	window.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
		mode: 'text/x-php',
	    lineNumbers: true
	});
	
	$("#button-load").click(function(){
		loadFile();
	});
	
	$("#button-save").click(function(){
		saveFile();
	});
	
	loadTree();	
});

$(document).on("dblclick",".tree-file > div",function(){
	var file = $(this).parent().attr("data-file");
	$("#file").val(file);
	loadFile();
});

$(document).on("dblclick",".tree-folder > div",function(){
	var self = $(this);
	
	// removendo conteúdo e fechando tree
	if(self.parent().find("ul").length){
		self.parent().find("ul").remove();
		return;
	}
	
	var file = self.parent().attr("data-file");
	loadTree(file);
});

function loadTree(folder){
	if(folder == undefined){
		folder = '';
	}
	
	$.ajax({
		url: '/zion/mod/ide/Editor/loadTree/?folder='+folder,
		method: "GET",
		cache: false
	}).done(function(response){
		var code = "";
		
		code += "<ul>";
		for(var i in response){
			var info = response[i];
			var icon = "tree-file";
			if(!info.isFile){
				icon = "tree-folder";
			}
			
			code += "<li class='"+icon+"' data-file='"+info.file+"' data-isFile=\""+info.isFile+"\" alt='"+info.file+"' title='"+info.file+"'>";
				code += "<div>"+info.name+"</div>";
			code += "</li>";
		}
		code += "</ul>";
		
		if(folder != ''){
			$(".tree-folder[data-file='"+folder+"']").append(code);
		}else{
			$("#ide-tree").html(code);
		}
	}).fail(function(a){
		alert(a.responseText);
	});
}

function saveFile(){
	var file = $("#file").val();
	var code = window.editor.getValue();
	
	$.ajax({
		url: '/zion/mod/ide/Editor/save/?file='+file,
		method: "POST",
		data: code,
		cache: false
	}).done(function(response){
		$("#button-save").notify("Arquivo salvo","success");
	}).fail(function(a){
		$("#button-save").notify(a.responseText,"error");
	});
}

function loadFile(){
	var file = $("#file").val();
	
	$.ajax({
		url: '/zion/mod/ide/Editor/load/?file='+file,
		method: "GET",
		cache: false
	}).done(function(response){
		window.editor.setValue(response);
	}).fail(function(a){
		$("#file").notify(a.responseText,"error");
	});
}