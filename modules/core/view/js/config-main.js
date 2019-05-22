let globalId = 0;
$(document).ready(function(){
	$("#filter-addItem").click(function(){
		addItem();
	});
	
	$("#filter-save").click(function(){
		var mandt = $("#filter\\[mandt\\]").val();
		var env   = $("#filter\\[env\\]").val();
		var key   = $("#filter\\[key\\]").val();
		
		$("#mandt").val(mandt);
		$("#env").val(env);
		$("#key").val(key);
		
		if(key == ""){
			alert("Chave vazia!");
			return;
		}
		
		$("#form1").submit();
	});
});

$(document).on("click",".button-removeItem",function(){
	var self = $(this);
	var tr = self.parent().parent();
	var name = tr.find(".config-name").val();
	tr.remove();
	
	var mandt = $("#filter\\[mandt\\]").val();
	var env   = $("#filter\\[env\\]").val();
	var key   = $("#filter\\[key\\]").val();
	
	var args = new Array();
	args.push("mandt="+mandt);
	args.push("env="+env);
	args.push("key="+key);
	args.push("name="+name);
	
	$.ajax({
		url: "/zion/mod/core/Config/deleteItem?"+args.join("&"),
		method: "GET",
		cache: false
	}).done(function(){
		$.notify("Dados atualizados","success");
	}).fail(function(){
		$.notify("Erro em atualizar","error");
	});
});

$(document).on("click",".button-upItem",function(){
	var self = $(this);
	var tr1 = self.parent().parent();
	var tr2 = self.parent().parent().prev();
	
	if(tr2.length == 0){
		return;
	}
	
	var clone = tr1.clone();
	tr2.before(clone);
	tr1.remove();
});

$(document).on("click",".button-downItem",function(){
	var self = $(this);
	var tr1 = self.parent().parent();
	var tr2 = self.parent().parent().next();
	
	if(tr2.length == 0){
		return;
	}
	
	var clone = tr1.clone();
	tr2.after(clone);
	tr1.remove();
});

function addItem(obj){
	if(obj == undefined){
		obj = {name:'',value:''};
	}
	
	let code = "";
	
	code += "<tr>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][name]\" value=\""+obj.name+"\" class=\"form-control config-name\"></td>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][value]\" value=\""+obj.value+"\" class=\"form-control config-value\"></td>";
		code += "<td>";
			code += "<button class='btn btn-danger button-removeItem' type='button'>Excluir</button>";
			code += "<button class='btn btn-info button-upItem' type='button'>Subir</button>";
			code += "<button class='btn btn-info button-downItem' type='button'>Descer</button>";
		code += "</td>";
	code += "</tr>";
	globalId++;
	
	$("#tb1 tbody").append(code);
}

function updateItensCallback(a,responseBody,c,d){
	if(d.status == 200){
		$.notify("Dados atualizados","success");
	}else{
		$.notify("Erro em atualizar","error");
	}
}

function filterCallback(a,responseBody,c,d){
	if(d.status == 200){
		$("#tb1 tbody").html("");
		for(var i in responseBody){
			item = responseBody[i];
			addItem(item);
		}
	}
}