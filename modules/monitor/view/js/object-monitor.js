let queueSyncRunning     = false;
let queueCheckRunning    = false;
let crontabRunning       = false;
let crontabIntervalSec   = 10;
let queueSyncIntervalSec = 10;
let queueTTS             = new Array();
let consoleDebug         = false;

$(document).ready(function(){
	$("#button-test").click(function(){
		speechSynthesis.speak(new SpeechSynthesisUtterance('Este é um teste!'));
	});
	
	setInterval(function(){
		crontab();	
	},crontabIntervalSec * 1000);
	
	setInterval(function(){
		queueSync();
	},queueSyncIntervalSec * 1000);
	
	// ao carregar a página, já chama o crontab 1 
	// vez e carrega as notificações
	crontab(function(){
		queueSync();	
	});
});

$(document).on("click",".button-changeSound",function(){
	var objectid = $(this).attr("data-objectid");
	var value    = $(this).attr("data-value");
	
	$.ajax({
		url: '/zion/mod/monitor/Object/changeSound/'+objectid+"/"+value,
		method: "GET",
		cache: false,
		timeout: 3000 // 3s
	}).done(function(){
		reloadData();
	}).fail(function(){
	});
});

/**
 * Recarrega os dados de monitoramento
 * @returns
 */
function reloadDataGUI(list){
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
			code += "<td align='center'>"+item.type+"</td>";
			code += "<td align='center'>"+item.interval+"s</td>";
			code += "<td align='center'>"+item.counter_success+"</td>";
			code += "<td align='center'>"+item.counter_error+"</td>";
			code += "<td align='center'>"+item.counter_timeout+"</td>";
			code += "<td>"+item.url+"</td>";
			code += "<td>";
				code += "<button class='btn "+sound1Class+" btn-sm button-changeSound' data-objectid='"+item.objectid+"' data-value='1'>On</button>";
				code += "<button class='btn "+sound0Class+" btn-sm button-changeSound' data-objectid='"+item.objectid+"' data-value='0' style='margin-left: 5px'>Off</button>";
			code += "</td>";
		code += "</tr>";
	}
	
	$("#tb1 tbody").html(code);
}

/**
 * Executa o crontab para verificar se status dos serviços
 * @returns
 */
function crontab(callback){
	log("crontab() start");
	if(crontabRunning){
		log("crontab() já esta em execução");
		return;
	}
	crontabRunning = true;
	
	$.ajax({
		url: '/zion/mod/monitor/Object/crontab/',
		method: "GET",
		cache: false,
		timeout: 3000 // 3s
	}).done(function(result){
		log("crontab() end");
		crontabRunning = false;
		
		try {
			callback();
		}catch(e){}
	}).fail(function(){
		log("crontab() end");
		crontabRunning = false;
		
		try {
			callback();
		}catch(e){}
	});
}

/**
 * Consulta as novas notificações
 * @returns
 */
function queueSync(){
	log("queueSync() start");
	if(queueSyncRunning){
		log("queueSync() já esta em execução");
		return;
	}
	queueSyncRunning = true;
	
	$.ajax({
		url: '/zion/mod/monitor/Object/getNotifications/',
		method: "GET",
		cache: false,
		timeout: 10000 // 10s
	}).done(function(result){
		reloadDataGUI(result.objectList);
		
		for(var i in result.ttsList){
			queueTTS.push(result.ttsList[i]);
		}
		
		queueSyncRunning = false;
		log("queueSync() end");
		
		queueCheck();
	}).fail(function(){
		queueSyncRunning = false;
		log("queueSync() end");
	});
}

function queueCheck(){
	log("queueCheck() start");
	if(queueCheckRunning){
		log("queueCheck() já esta em execução");
		return;
	}
	queueCheckRunning = true;
	
	if(queueTTS.length <= 0){
		queueCheckRunning = false;
		log("queueCheck() end");
		return;
	}
	
	var notify = queueTTS.shift();
	if(notify.sound_enabled == 1){
		log("Saying \""+notify.tts_text+"\"");
		
		speak(notify.tts_text,function(){
			queueCheckRunning = false;
			log("queueCheck() end");
			queueCheck();
			return;
		});
		
		/*
		playSound(notify.notify_sound,function(){
			queueCheckRunning = false;
			log("queueCheck() end");
			queueCheck();
			return;
		});
		*/
	}else{
		queueCheckRunning = false;
		log("queueCheck() end");
		queueCheck();
		return;
	}
}

/**
 * Reproduz um aviso sonoro
 * @param url
 * @param callback
 * @returns
 */
function playSound(url,callback){
	log("Reproduzindo "+url);
	try {
		var audio = new Audio(url);
		audio.addEventListener('ended', function(){
			callback();
		});
		var promise = audio.play();
		
		if (promise !== undefined) {
			promise.then(_ => {
		        // Autoplay started!
		    }).catch(error => {
		        // Autoplay was prevented.
		    	log("Erro em reproduzir audio");
				callback();
				return;
		    });
		}else{
			log("Erro em reproduzir audio");
			callback();
			return;
		}
	}catch(e){
		log("Erro em reproduzir audio");
		callback();
		return;
	}
}

function speak(text,callback){
	var url = '/zion/mod/monitor/Object/getAudio/?text='+text;
	var audio = new Audio(url);
	audio.onended = function(){
		try { callback(); }catch(e){}
	}
	audio.play();
	return;
}

function log(text){
	if(!consoleDebug){
		return;
	}
	console.log(text);
}