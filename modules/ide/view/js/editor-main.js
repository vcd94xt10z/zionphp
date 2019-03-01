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
});

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