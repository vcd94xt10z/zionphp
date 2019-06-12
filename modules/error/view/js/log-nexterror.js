$(document).ready(function(){
	window.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
		mode: 'text/x-php',
		lineNumbers: true,
		styleActiveLine: true,
	    matchBrackets: true,
	    autoCloseTags: true,
	    lineWrapping: true,
	    readOnly: true
	});
	
	var line  = parseInt($("#focusline").val()) - 1;
	var line2 = line + 5;
	
	editor.focus();	
	editor.setCursor({line: line2, ch: 0});
	editor.markText({line: line, ch: 0}, {line: line, ch: 999}, {className:"errorHighlight"});
	
	$(".button-close").click(function(){
		window.close();
	});
});