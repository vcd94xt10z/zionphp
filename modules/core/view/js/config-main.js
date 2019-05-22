let globalId = 0;
$(document).ready(function(){
	$("#filter-addItem").click(function(){
		addItem();
	});
	
	$("#filter-save").click(function(){
		var inputs = $("#form1 td input").toArray();
		for(var i in inputs){
			var elem = $(inputs[i]);
			if(elem.val() == ""){
				elem.css("border","1px solid #f00");
				elem.focus();
				return;
			}else{
				elem.css("border","1px solid #ccc");
			}
		}
		$("#form1").submit();
	});
});

$(document).on("click",".button-removeItem",function(){
	var self = $(this);
	var tr = self.parent().parent();
	var mandt = tr.find(".config-mandt").val();
	var env = tr.find(".config-env").val();
	var key = tr.find(".config-key").val();
	var name = tr.find(".config-name").val();
	tr.remove();
	
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
		obj = {
			mandt: 0,
			env: '',
			key: '',
			name: '',
			value: '',
		};
	}
	
	if(obj.env == ""){
		obj.env = zion.ENV;
	}
	
	let code = "";
	
	code += "<tr>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][mandt]\" value=\""+obj.mandt+"\" class=\"form-control config-mandt\" required></td>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][env]\" value=\""+obj.env+"\" class=\"form-control config-env\" required></td>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][key]\" value=\""+obj.key+"\" class=\"form-control config-key\" required></td>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][name]\" value=\""+obj.name+"\" class=\"form-control config-name\" required></td>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][value]\" value=\""+obj.value+"\" class=\"form-control config-value\"></td>";
		code += "<td>";
			code += "<button class='btn btn-info button-upItem fas fa-chevron-up' type='button'></button>";
			code += "<button class='btn btn-info button-downItem fas fa-chevron-down' type='button'></button>";
			code += "<button class='btn btn-danger button-removeItem fas fa-trash-alt' type='button'></button>";
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