var charts = document.getElementsByClassName('charts');
var data = new Array();
var myCharts = new Array();
for (var i = charts.length - 1; i >= 0; i--) {
	myCharts[i] = echarts.init(charts[i]);
	var minValue = charts[i].getAttribute("data-min");
	var maxValue = charts[i].getAttribute("data-max");
	var lowest = minValue - (maxValue - minValue)*0.5;
	var highest = parseInt(maxValue) + parseInt((maxValue - minValue)*0.5);
	data[i] = {
		time:[],
		data:[],
		lowest:lowest,
		highest:highest
	};
	var option = {
		title: {
			text: charts[i].getAttribute("data-title")
		},
		tooltip: {},
		toolbox: {
			show: true,
			feature: {
				dataView: {readOnly: false},
				restore: {},
				saveAsImage: {}
			}
		},
		tooltip : {
			trigger: 'axis',
			axisPointer: {
				animation: true
			}
		},
		dataZoom: {
			show: true,
			start: 0,
			end: 100
		},
		xAxis: {
			data: data[i].time
		},
		yAxis: {
			type : 'value',
			splitLine: {
				show: false
			},
			min:lowest,
			max:highest
		},
		visualMap: {
			top:0,
			right:'20%',
			type: 'piecewise',
			pieces: [{
				gt: parseInt(lowest),
				lte: parseInt(minValue),
				label:"低于 <" + minValue,
				color: '#ff9933'
			}, {
				gt: parseInt(minValue),
				lte: parseInt(maxValue),
				label:"正常",
				color: '#096'
			}, {
				gt: parseInt(maxValue),
				lte:parseInt(highest),
				label:"超过 >" + maxValue,
				color: '#cc0033'
			}],
			outOfRange: {
				color: '#999'
			}
		},
		series: {
			name: '数值',
			type: 'line',
			symbolSize:10,
			symbol:'circle',
			data: data[i].data,
			markLine: {
				silent: true,
				data: [{
					yAxis: minValue
				}, {
					yAxis: maxValue
				}]
			}
		}
	};
	myCharts[i].setOption(option);
	setInterval(function (i) {
		return function(){
			//getData(i);
			if(data[i].data.length >= 30){
				data[i].data.shift();
				data[i].time.shift();
			}
			data[i].time.push(getTimeNow());
			data[i].data.push(parseInt(data[i].lowest) + parseInt(Math.random()*(data[i].highest - data[i].lowest)));
			myCharts[i].setOption({
				xAxis: {
					data: data[i].time
				},
				series: [{
					name:'数值',
					data: data[i].data
				}]
			});
		}
	}(i), 3000);

}

function GetXmlHttpObject(){ 
	var objXMLHttp = null;
	if (window.XMLHttpRequest)
	{
		objXMLHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
}

function getTimeNow(){
	var myDate = new Date();
	var hour = myDate.getHours();
	var minutes = myDate.getMinutes();
	var seconds = myDate.getSeconds();
	if(hour < 10){
		hour = "0" + hour;
	}
	if(minutes < 10){
		minutes = "0" + minutes;
	}
	if(seconds < 10){
		seconds = "0" + seconds;
	}
	return hour + ":" + minutes + ":" + seconds;
}

function getData(i) {
	var xmlHttp = GetXmlHttpObject();
	if(xmlHttp == null)
	{
		toastr.error("Browser does not support HTTP Request");
		return;
	}
	var url = "./functions.php?type=get_controller_data&controllerId=" + charts[i].getAttribute("data-controllerid");
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				var mydata = JSON.parse(xmlHttp.responseText);
				if(mydata.state == "get_controller_data_success"){
					if(data[i].data.length >= 30){
						data[i].data.shift();
						data[i].time.shift();
					}
					data[i].time.push(getTimeNow());
					data[i].data.push(mydata.data);
					myCharts[i].setOption({
						xAxis: {
							data: data[i].time
						},
						series: [{
							name:'数值',
							data: data[i].data
						}]
					});
				}else if(mydata.state == "get_controller_data_failed"){
					toastr.error("获取数据失败");
				}
			}else{
				toastr.error("发生错误：" + request.status);
			}
		}
	}
	xmlHttp.open("GET",url);
	xmlHttp.send(null);
}

