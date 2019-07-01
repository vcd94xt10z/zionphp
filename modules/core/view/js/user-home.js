'use strict';

function getConfig(title,label,dataLabels,dataValues){
	var config = {
		type: 'line',
		data: {
			labels: dataLabels,
			datasets: [{
				label: label,
				backgroundColor: '#87CEFA',
				borderColor: '#4682B4',
				data: dataValues,
				fill: false,
			}]
		},
		options: {
			responsive: true,
			title: {
				display: true,
				text: title
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: 'Dias'
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: 'Valores'
					}
				}]
			}
		}
	};
	return config;
}

var chartNextId = 1;
window.onload = function() {
	for(let i in dataChart){
		let obj = dataChart[i];
		
		let code = "";
		code += "<div class='col-6'>";
			code += "<canvas id='"+chartNextId+"'></canvas>";
		code += "</div>";
		$("#zcharts").append(code);
		
		let ctx = document.getElementById(chartNextId).getContext('2d');
		let config = getConfig(
			obj.title,
			obj.label,
			obj.labels,
			obj.values
		);
		window.myLine = new Chart(ctx, config);
		
		chartNextId++;
	}
};