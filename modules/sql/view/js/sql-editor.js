$(document).ready(function(){
	$("#sql-query").keydown(function(e){
		// ctrl + enter
		if (!(e.keyCode == 13 && e.ctrlKey)) {
			return;
	    }
		
		var query = $(this).val();
		
		$("#sql-message").html("").css("display","none");
		$("#sql-result").html("").css("display","none");
		
		// show loading here
		
		$.ajax({
			url: '/zion/mod/sql/SQL/run/?query='+query,
			method: "GET",
			cache: false
		}).done(function(resultList){
			var code = "";
			for(var i in resultList){
				var obj = resultList[i];
				
				code += "<tr>";
				for(var j in obj){
					code += "<td>"+obj[j]+"</td>";	
				}
				code += "</tr>";
			}
			
			// hide loading here
			$("#sql-result").html(code).css("display","block");
		}).fail(function(a,b,c,d){
			$("#sql-message").html(a.responseText).css("display","block");
			
			// hide loading here
		});
	});
});