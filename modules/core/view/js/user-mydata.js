$(document).ready(function(){
});

function defaultCallback(type,responseBody,statusText,responseObj){
	if(responseObj.status == 204){
		swal("Sucesso","Senha atualizada","success");
	}else{
		swal("Erro",responseObj.responseText,"error");
	}
}