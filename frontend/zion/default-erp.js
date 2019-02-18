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

// carregamento da página
$(document).ready(function(){
	$("#module-selector").change(function(){
		var module = $(this).val();
		if(module != ""){
			window.location = "/zion/mod/"+module+"/";
		}
	});
	
	// adicionando automaticamente um icone
	//$(".filter-page .card .card-header").append("<span class=\"glyphicon glyphicon-menu-up\" aria-hidden=\"true\"></span>");
	$(".filter-page .card .card-header").append("<i class=\"fas fa-arrow-down\"></i>");
	
	$("#button-toggleFilterMode").click(function(){
		showFilterGUI();
		
		var mode = $(this).attr("data-mode");
		if(mode == "simple"){
			$(".form-inline").removeClass("hide-advanced-fields");
			$(this).attr("data-mode","advanced");
		}else{
			$(".form-inline").addClass("hide-advanced-fields");
			$(this).attr("data-mode","simple");
		}
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
		// setando chaves
		for(var key in responseBody){
			var id = "#obj\\["+key.replace( /(:|\.|\[|\]|,|=|@)/g, "\\$1" )+"\\]";
			$(id).val(responseBody[key]);
		}
		
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