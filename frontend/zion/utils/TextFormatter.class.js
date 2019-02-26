/**
 * @author Vinicius Cesar Dias
 */
TextFormatter = function(){};

// apelidos
tf = TextFormatter;

/**
 * Corta um texto caso o comprimento for maior que o estabelecido. Caso
 * o texto for cortado, os ultimos tres caracteres serao reticencias.
 */
TextFormatter.cutText = function(text, maxLength){
	if(typeof(text)=='string'){
		if(text.length > maxLength){
			return text.substring(0,Math.max(maxLength-3))+"...";
		}else{
			return text;
		}
	}
	return "";
};

TextFormatter.parseTimezone = function(timezone){
	try {
		if(typeof(timezone) == "undefined" || timezone == null || timezone.length != 6){
			return null;
		}
		var signal = timezone.substr(0,1);
		var hour = parseInt(timezone.substr(1,2));
		var minute = parseInt(timezone.substr(4,2));
		var output = {
			'signal': signal,
			'hour': hour,
			'minute': minute
		}
		return output;
	}catch(e){
		return null;
	}
};

TextFormatter.formatDate = function(date,format,timezone){
	// formato: +00:00
	if(typeof(timezone) == "undefined" || timezone == null || timezone.length != 6){
		timezone = "-03:00"; // brazil
	}
	
	// convertendo para o timezone atual
	var tz = TextFormatter.parseTimezone(timezone);
	if(tz != null){
		if(tz.signal == "+"){
			date.setUTCHours(date.getUTCHours() + tz.hour);
			date.setUTCMinutes(date.getUTCMinutes() + tz.minute);
		}else{
			date.setUTCHours(date.getUTCHours() - tz.hour);
			date.setUTCMinutes(date.getUTCMinutes() - tz.minute);
		}
	}
		
	// separando valores
	var day = date.getUTCDate(); 
	var month = date.getUTCMonth()+1 
	var year = date.getUTCFullYear(); 
	var hour = date.getUTCHours();
	var minute = date.getUTCMinutes();
	var second = date.getUTCSeconds();
	
	// padding
	if(day < 10){
		day = "0"+day;
	}
	if(month < 10){
		month = "0"+month;
	}
	if(hour < 10){
		hour = "0"+hour;
	}
	if(minute < 10){
		minute = "0"+minute;
	}
	if(second < 10){
		second = "0"+second;
	}
	
	format = format.replace(/d/gi,day);
	format = format.replace(/m/gi,month);
	format = format.replace(/Y/gi,year);
	format = format.replace(/H/gi,hour);
	format = format.replace(/i/gi,minute);
	format = format.replace(/s/gi,second);
	
	return format;
};

TextFormatter.formatCEP = function(value)
{
	var value = value.toString();
	return value.substr(0,5)+"-"+value.substr(5,3);
}

TextFormatter.formatCurrency = function(price,c,d,t){
	if(c == undefined){
		c = 2;
	}
	if(d == undefined){
		d = ",";
	}
	if(t == undefined){
		t = ".";
	}
	var n = price, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

TextFormatter.parseCurrency = function(value){
	if(typeof(value) == 'number'){
		return value + 0.00;
	}
	
	if(value == undefined || typeof(value) != 'string' || value == ""){		
		return 0.00;
	}
	
	value = value.replace(/[^0-9\,\.]/g,"");
	
	if(value.indexOf(",") != -1){
		value = value.replace(/[\.]/,"");
		value = value.replace(/[\,]/,".");
	}
	
	try {
		return parseFloat(value);
	}catch(e){
		return 0;
	}
};