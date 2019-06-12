$(document).ready(function(){
	$("#button-createCRUD").click(function(){
		var moduleid = $("#moduleid").val();
		var entityid = $("#entityid").val();
		var table    = $("#table").val();
		var destiny  = $("#destiny").val();
		
	    $.ajax({
	      type: 'GET',
	      dataType: "text",
	      accepts: {
	          text: "plain/text"
	      },
	      cache: false,
	      url: '/zion/mod/builder/Main/createCRUD/'+moduleid+"/"+entityid+"/"+table+"/"+destiny+"/"
	    }).done(function(responseBody,statusText,responseObj) {
	    	$("#button-createCRUD").notify(responseBody,{ 
	    		position:"right",
	    		className: 'success'
	    	});
	    }).fail(function(responseObj,statusText,responseBody) {
	    	swal("Erro",responseObj.responseText,"error");
	    });
	});
	
	$("#destiny,#moduleid,#entityid").keyup(function(){
		buildTableName();
	}).change(function(){
		buildTableName();
	}).change();
	
	$("#destiny").focus();
});

function buildTableName(){
	var destiny  = $("#destiny").val();
	var moduleid = $("#moduleid").val();
	var entityid = $("#entityid").val();
	var table    = $("#table").val();
	
	var parts = new Array();
	
	if(destiny == "zion"){
		parts.push(destiny);
	}
	if(moduleid != ""){
		parts.push(moduleid);
	}
	if(entityid != ""){
		parts.push(entityid);
	}
	
	$("#table").val(parts.join("_").toLowerCase());
}