$(document).ready(function(){
	$(".button-check").click(function(){
		var step = $(this).attr("data-step");
		
		$.ajax({
			url: "/zion/mod/welcome/Welcome/step/?step="+step,
			method: "GET",
			cache: false
		}).done(function(){
			$("#img-step"+step).attr("src","/zion/lib/zion/img/status-ok.png");
		}).fail(function(a,b,c,d){
			console.log(a);
			console.log(b);
			console.log(c);
			console.log(d);
			
			$("#img-step"+step)
				.attr("src","/zion/lib/zion/img/status-error.png")
				.notify(a.responseText);
		});
	});
});