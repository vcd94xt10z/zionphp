/*
 * Autor Vinicius Cesar Dias
 */

// variáveis globais

// eventos anexados no documento
$(document).on("dblclick","#filter-result table tbody tr",function(){
	var a = $(this).find(".edit");
	if(!a.length){
		a = $(this).find(".view");
	}

	if(a.length){
		var url = a.attr("href");
		var win = window.open(url,"_blank");
		win.focus();
	}
});

$(document).on("click",".button-del-row",function(){
	$(this).parent().parent().remove();
});

$(document).on("click",".viewFullText",function(){
	var text = $(this).attr("data-text");
	
	var code = "";
	code += "<div id=\"viewFullText\">";
		code += "<button type='button' class='closeViewFullText'>X</button>";
		code += "<div>";
			code += text.replace("\r\n","<br>").replace("\n","<br>");
		code += "</div>";
	code += "</div>";
	
	$("#viewFullText").remove();
	$("body").append(code);
	$("#viewFullText").css("display","block");
	
	$(".closeViewFullText").click(function(){
		$(this).parent().remove();
	});
});

$(document).on("click",".ajaxlink",function(){
	var self     = $(this);
	var url      = self.attr("data-url");
	var method   = self.attr("data-method");
	var callback = self.attr("data-callback");
	
	if(method == ""){
		method = "GET";
	}
	
	$.ajax({
		url: url,
		method: method,
		cache: false
	}).done(function(a,b,c,d){
		self.notify(c.responseText,"success");
		
		try {
			eval(callback+"();");
		}catch(e){}
	}).fail(function(a,b,c,d){
		self.notify(a.responseText,"error");
		
		try {
			eval(callback+"();");
		}catch(e){}
	});
});

// carregamento da página
$(document).ready(function(){
	$("#zion-menu-button").click(function(){
		var menu = $("#zion-menu");
		if(menu.css("margin-left") == "0px"){
			menu.css("margin-left","-1000px");	
		}else{
			menu.css("margin-left","0px");
		}
	});
	
	$("#module-selector").change(function(){
		var module = $(this).val();
		if(module != ""){
			window.location = "/zion/mod/"+module+"/";
		}
	});
	
	// adicionando automaticamente um icone
	//$(".filter-page .card .card-header").append("<span class=\"glyphicon glyphicon-menu-up\" aria-hidden=\"true\"></span>");
	$(".filter-page .card .card-header").append("<i class=\"fas fa-arrow-down\"></i>");
	
	$("#button-filter-basic").click(function(){
		showFilterGUI();
		$(".form-inline").addClass("hide-advanced-fields");
		$("#button-filter-basic").css("display","none");
		$("#button-filter-advanced").css("display","inline-block");
		$(".filter-page .card-body .row-filter-advanced").css("display","none");
	});
	
	$("#button-filter-advanced").click(function(){
		showFilterGUI();
		$(".form-inline").removeClass("hide-advanced-fields");
		$("#button-filter-basic").css("display","inline-block");
		$("#button-filter-advanced").css("display","none");
		$(".filter-page .card-body .row-filter-advanced").css("display","flex");
	});
	
	$("img").each(function(){
		var ref = $(this);
		
		if(ref.attr("src") == undefined){
			ref.attr("src",ref.attr("data-src"));
			ref.attr("data-src","");
		}
	});
	
	$("body").keydown(function(e){
	    var keyCode = e.keyCode || e.which;
	    var tagName = (e.target.tagName);

	    // ESC
	    if(keyCode == 27){
	    	e.preventDefault();
	    	window.close();
	    	return false;
	    }

	    // F3
	    if(keyCode == 114){
	    	e.preventDefault();
	    	window.history.back();
	    	return false;
	    }

  	    // F8
	    if(keyCode == 119){
	    	e.preventDefault();
	    	$("#filter-button").click();
	    	return false;
	    }

	    // CTRL + s
	    if ((event.ctrlKey || event.metaKey) && keyCode == 83) {
	    	e.preventDefault();
	    	fireZevent("ctrl+s");
	    	$("#register-button").click();
	    	return false;
	    }

	    // abrir filtro
	    if(keyCode == 40){
	    	e.preventDefault();
	    	showFilterGUI();
	    	return false;
	    }
	    
	    // fechar filtro
	    if(keyCode == 38){
	    	e.preventDefault();
	    	hideFilterGUI();
	    	return false;
	    }

	    return true;
	});
	
	// colocando um delay
	setTimeout(function(){
		$("form[data-readonly=\"1\"],.form-view").each(function(){
			disableAllFormFields($(this));
		});
	},100);

	$(".card-header").click(function(){
		toggleFilterGUI();
	});

	$("#register-button").click(function(){
		onRegister();
	});
});

$(window).scroll(function(){
	/*
    if ($(window).scrollTop() >= 94) {
        $('header').addClass('fixed-header');
    }else {
        $('header').removeClass('fixed-header');
    }
    */
}).scroll();

// funções
function onErrorFotoProduto(obj){
	obj.onerror = "";
	obj.src = "/img/image-404.png";
    return true;
}

function toggleFilterGUI(){
	var display = $(".filter-page .card-body").css("display");
	if(display == "none"){
		showFilterGUI();
	}else{
		hideFilterGUI();
	}
}

function showFilterGUI(){
	var heading = $(".filter-page .card-header");
	var body    = $(".filter-page .card-body");

	//body.css("display","block");
	body.slideDown();

	// removendo icone anterior
	//heading.find(".glyphicon").remove();
	heading.find(".fas").remove();

	// colocando novo icone
	//heading.append("<span class=\"glyphicon glyphicon-menu-up\" aria-hidden=\"true\"></span>");
	heading.append("<i class=\"fas fa-arrow-up\"></i>");
}

function hideFilterGUI(){
	var heading = $(".filter-page .card-header");
	var body    = $(".filter-page .card-body");

	//body.css("display","none");
	body.slideUp();

	// removendo icone anterior
	//heading.find(".glyphicon").remove();
	heading.find(".fas").remove();

	// colocando novo icone
	//heading.append("<span class=\"glyphicon glyphicon-menu-down\" aria-hidden=\"true\"></span>");
	heading.append("<i class=\"fas fa-arrow-down\"></i>");
}

function disableAllFormFields(jqueryObj){
	jqueryObj.find('input,textarea,select').attr('readonly', 'readonly');
	jqueryObj.find('input[type=radio],input[type=checkbox]').attr('disabled', 'disabled');
}

function defaultFilterCallback(type,responseBody,statusText,responseObj){
	if(type == "done"){
		hideFilterGUI();
    	$("#filter-result").html(responseBody);
	}else{
		var code = "<div class=\"alert alert-danger\">";
		if(responseObj.responseText.length > 500){
			code += "Erro em realiza consulta, tente novamente. Caso o problema persista, contate o suporte.";
		}else{
			code += responseObj.responseText;
		}
		code += "</div>";

		$("#filter-result").html(code);
	}
}

function defaultRegisterCallback(type,responseBody,statusText,responseObj){
	if(type == "done"){
		var keys = new Array();
		
		var etag = responseObj.getResponseHeader("x-etag");
		if(etag == ""){
			etag = responseObj.getResponseHeader("ETag");
		}
		
		try {
			etag = JSON.parse(etag);
			keys = etag.keys;
		}catch(e){
			keys = new Array();
		}
		
		// setando chaves no formulário
		for(var key in keys){
			var id = "#obj\\["+key.replace( /(:|\.|\[|\]|,|=|@)/g, "\\$1" )+"\\]";
			$(id).val(keys[key]);
		}
		
		// mudando método do formulário
		$(".ajaxform").attr("method","PUT");
		
		swal("Sucesso", "Dados salvos", "success");
	}else{
		swal("Erro", responseObj.responseText, "error");
	}
}

function onFilter(){
	$("#filter-form").submit();
}

function onRegister(){
	$("#register-form").submit();
}