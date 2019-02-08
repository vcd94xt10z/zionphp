$(document).ready(function(){
	$(".button-check").click(function(){
		var button = $(this);
		var step = button.attr("data-step");
		
		// ocultando mensagem
		$("#error-message").html("").css("display","none");
		
		$.ajax({
			url: "/zion/mod/welcome/Welcome/step/?step="+step,
			method: "GET",
			cache: false
		}).done(function(){
			$("#img-step"+step).attr("src","/zion/lib/zion/img/status-ok.png");
		}).fail(function(a,b,c,d){
			$("#img-step"+step).attr("src","/zion/lib/zion/img/status-error.png");
			
			// exibindo mensagem
			$("#error-message").html(a.responseText).css("display","block");
		});
	});
	
	$("#error-message").dblclick(function(){
		$(this).css("display","none");
	});
});