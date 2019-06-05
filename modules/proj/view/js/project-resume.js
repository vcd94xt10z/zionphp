$(document).ready(function(){
	$(".button-play").click(function(){
		var keys = $(this).attr("data-keys");
		onPlay(keys);
	});
	$(".button-pause").click(function(){
		var keys = $(this).attr("data-keys");
		onPause(keys);
	});
	$(".button-refresh").click(function(){
		onRefresh();
	});
});

function onRefresh(){
	window.location.reload();
}

function onPlay(keys){
	$.ajax({
		url: '/zion/mod/proj/Feature/play/'+keys,
		method: "GET",
		cache: false,
		timeout: 3000
	}).done(function(){
		onRefresh();
	}).fail(function(){
	});
}

function onPause(keys){
	$.ajax({
		url: '/zion/mod/proj/Feature/pause/'+keys,
		method: "GET",
		cache: false,
		timeout: 3000
	}).done(function(){
		onRefresh();
	}).fail(function(){
	});
}