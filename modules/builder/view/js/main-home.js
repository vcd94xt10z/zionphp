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
	    	swal("Sucesso", responseBody, "success");
	    }).fail(function(responseObj,statusText,responseBody) {
	    	swal("Erro", responseObj.responseText, "error");
	    });
	});
	
	$("#moduleid").focus();
});