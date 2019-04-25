let queueRunning       = false;
let crontabRunning     = false;
let crontabIntervalSec = 10;

$(document).ready(function(){
	// executa o crontab
	setInterval(function(){
		crontab();	
	},crontabIntervalSec * 1000);
	
	// recarrega os dados
	reloadData();
	
	// executa a fila de notificações
	runQueue();
	
	$(".button-reload").click(function(){
		reloadData();
	});
});

$(document).on("click",".button-changeSound",function(){
	var objectid = $(this).attr("data-objectid");
	var value    = $(this).attr("data-value");
	
	$.ajax({
		url: '/zion/mod/monitor/Object/changeSound/'+objectid+"/"+value,
		method: "GET",
		cache: false
	}).done(function(){
		reloadData();
	}).fail(function(){
	});
});

/**
 * Recarrega os dados de monitoramento
 * @returns
 */
function reloadData(){
	console.log("reloadData() start");
	$.ajax({
		url: '/zion/mod/monitor/Object/getData/',
		method: "GET",
		cache: false
	}).done(function(list){
		console.log("reloadData() end");
		
		var code = "";
		for(var i in list){
			var item        = list[i];
			var sound0Class = "";
			var sound1Class = "";
			
			if(item.sound_enabled == 1){
				sound0Class = "btn-outline-secondary";
				sound1Class = "btn-outline-primary";
			}else{
				sound1Class = "btn-outline-secondary";
				sound0Class = "btn-outline-primary";
			}
			
			code += "<tr>";
				code += "<td align='center'>";
					if(item.status == 'on'){
						code += "<img src='/zion/lib/zion/img/status-ok.png'>";
					}else{
						code += "<img src='/zion/lib/zion/img/status-error.png'>";
					}
				code += "</td>";
				code += "<td>"+item.objectid+"</td>";
				code += "<td>"+item.type+"</td>";
				code += "<td>"+item.interval+"s</td>";
				code += "<td>"+item.url+"</td>";
				code += "<td>";
					code += "<button class='btn "+sound1Class+" btn-sm button-changeSound' data-objectid='"+item.objectid+"' data-value='1'>On</button>";
					code += "<button class='btn "+sound0Class+" btn-sm button-changeSound' data-objectid='"+item.objectid+"' data-value='0' style='margin-left: 5px'>Off</button>";
				code += "</td>";
			code += "</tr>";
		}
		
		$("#tb1 tbody").html(code);
	}).fail(function(){
		console.log("reloadData() end");
	});
}

/**
 * Executa o crontab para verificar se status dos serviços
 * @returns
 */
function crontab(){
	console.log("crontab() start");
	if(crontabRunning){
		console.log("crontab() já esta em execução");
		return;
	}
	crontabRunning = true;
	
	$.ajax({
		url: '/zion/mod/monitor/Object/crontab/',
		method: "GET",
		cache: false
	}).done(function(result){
		console.log("crontab() end");
		crontabRunning = false;
	}).fail(function(){
		console.log("crontab() end");
		crontabRunning = false;
	});
}

/**
 * Verifica a fila e faz as notificações sonoras necessárias
 * @returns
 */
function runQueue(){
	console.log("runQueue() start");
	
	if(queueRunning){
		console.log("runQueue() já esta em execução");
		return;
	}
	queueRunning = true;
	
	$.ajax({
		url: '/zion/mod/monitor/Object/getNextQueueSound/',
		method: "GET",
		cache: false
	}).done(function(data){
		if(data.object.sound_enabled == 1){
			playSound(data.object.notify_sound,function(){
				console.log("runQueue() end");
				queueRunning = false;
				runQueue();
			});
		}else{
			console.log("runQueue() end");
			queueRunning = false;
			runQueue();
		}
	}).fail(function(){
		console.log("runQueue() end");
		
		setTimeout(function(){
			queueRunning = false;
			runQueue();
		},1000 * 10); // 10s
	});
}

/**
 * Reproduz um aviso sonoro
 * @param url
 * @param callback
 * @returns
 */
function playSound(url,callback){
	console.log("Reproduzindo "+url);
	try {
		var audio = new Audio(url);
		audio.addEventListener('ended', function(){
			callback();
		});
		var promisse = audio.play();
		
		if (promise !== undefined) {
		    promise.then(_ => {
		        // Autoplay started!
		    }).catch(error => {
		        // Autoplay was prevented.
		    	console.log("Erro em reproduzir audio");
				callback();
				return;
		    });
		}else{
			console.log("Erro em reproduzir audio");
			callback();
			return;
		}
	}catch(e){
		console.log("Erro em reproduzir audio");
		callback();
		return;
	}
}