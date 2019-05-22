let globalId = 0;
$(document).ready(function(){
	$("#filter-add").click(function(){
		addItem();
	});
});

$(document).on("click",".button-removeItem",function(){
	var self = $(this);
	self.parent().parent().remove();
});

function addItem(obj){
	if(obj == undefined){
		obj = {name:'',value:''};
	}
	
	let code = "";
	
	code += "<tr>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][name]\" value=\""+obj.name+"\" class=\"form-control\"></td>";
		code += "<td><input type=\"text\" name=\"config[d"+globalId+"][value]\" value=\""+obj.value+"\" class=\"form-control\"></td>";
		code += "<td>";
			code += "<button class='btn btn-danger button-removeItem' type='button'>Excluir</button>";
		code += "</td>";
	code += "</tr>";
	globalId++;
	
	$("#tb1 tbody").append(code);
}

function filterCallback(a,responseBody,c,d){
	if(d.status = 200){
		$("#tb1 tbody").html("");
		for(var i in responseBody){
			item = responseBody[i];
			addItem(item);
		}
	}
}