var provincefun =' ';
// var ii=layer.msg("加载中……");

var numberMultiple=1;


if(role_id==1){
	 numberMultiple = 25;
}


var ii= layer.open({
	type: 1,
	skin: 'layui-layer-demo', //样式类名
	closeBtn: 0, //不显示关闭按钮
	anim: 2,
	shadeClose: false, //开启遮罩关闭
	content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
});



var todaysData=Datas('','index.php?r=site/today-datas');


renderingData(provincefun, ii)

var dataoiyhsajkd='' ;
// 今日数据
	// $.get('index.php?r=site/today-datas&province=', function(data) {


	// 	var obj = eval('(' + data + ')');
	// 	console.log(obj)

	// });

function  Datas(provincefun,url){
 var csj_data;
      $.ajax
       ({
           cache: false,
           async: false,
           type: 'get',
           data: { province: provincefun },
           url: url,
           success: function (data) {
		var obj = eval('(' + data + ')');
               csj_data = obj;
           }
       });
       console.log(csj_data)
		return csj_data;
 }



	setInterval(function() {
	$('#current_time').text(getNowFormatDate())
	}, 1000);



	var _this = this;
     this.province = $("#province");//省份select对象
    _this.province.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen


	$(window).resize(function() {
		var ii = layer.msg("加载中……");
		var normal_mode_false = $('#FullScreen', window.parent.document).attr('datae')
		if (normal_mode_false == 'false') {
			$('#normal-mode').css('display', 'block')
		} else {
			$('#normal-mode').css('display', 'none')
		}
		var str = $(".region").eq(0).text()
		if (str == '全国'||str == '全国') {
			str = ''
		}

		renderingData(str, ii)	
	});


$("#province").change(function(){
	var province_val = $(this).val();
	var province = province_val
	if(province_val=='china'){
       province='全国'
	}
	$(".region").eq(0).text(province)
	var ii= layer.open({
	type: 1,
	skin: 'layui-layer-demo', //样式类名
	closeBtn: 0, //不显示关闭按钮
	anim: 2,
	shadeClose: false, //开启遮罩关闭
	content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
    });
	renderingData(province_val, ii)
})







function renderingData(provincefun, ii) {


	$("#province").empty().append('<option value=" ">全国</option>');

	var FullScreen = $('#FullScreen', parent.document).attr('datae');
	if (FullScreen == 'false') {
		$('html').css('fontSize', ' 62.5%')
		// html { font-size: 62.5%; }
	} else if (FullScreen == 'true') {
		$('html').css('fontSize', '15px')
	}
// 今日数据
      
		if (todaysData) {
			$('#wdcNUM').text(todaysData.user_num*numberMultiple);
			$('#operateNum').text(todaysData.agenty_num)
			$('#waterworksNum').text(todaysData.factory_num)
			$('#serviceNum').text(todaysData.agentf_num)
			$('#equipmentNum').text(todaysData.devfactory_num)
		}

	// 实时数据

	// var realTimeData = Datas('','index.php?r=site/today-datas');
		$.get('index.php?r=site/real-time-datas&province=' + provincefun, function(data) {

			if(data.code){
				//console.log(data);
				return;
			}
			var obj = eval('(' + data + ')');
			// console.log(obj);
			if (obj) {
				$('#todayRmb').text(Math.ceil(obj.today_sales*10*numberMultiple));
				$('#todayVbepRmb').text(Math.ceil(obj.today_sales*numberMultiple))
				$('#todaWwaterRmb').text(Math.ceil(obj.today_wateruse*numberMultiple))
				$('#januaryVbepRmb').text(Math.ceil(obj.total_sales *numberMultiple))
				$('#waterJanuaryRmb').text(Math.ceil( obj.total_wateruse*numberMultiple))
			}
		});
	// 服务中心销量排名（本月前五）
		$.get('index.php?r=site/agentf-sales&province=' + provincefun, function(data) {
			if(data.code){
			//	console.log(data);
			    return;
			}
			var obj = eval('(' + data + ')');
			// console.log(obj)
			if (obj.datas.length) {
          
				$('#rankingsService').empty()

				for (var i = 0; i < obj.datas.length; i++) {
					var item = obj.datas[i];
					  //   console.log(item.Name )
					var item_num = item.num ? item.num : 0
					var html = '<div class="ranking-Percentage" style="position:relative">' +
						'<div class="progress">' +
						'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' + item_num / obj.total_sales + '" aria-valuemin="0" aria-valuemax="100" ' +
						'style="width: ' + item_num / obj.total_sales*100  + '%">' +
						' <span class="sr-only">' + item.num / obj.total_sales + '% Complete (success)</span>' +
						' </div>' + '</div>' + '<p class="rankingNum">' + Math.floor(item_num*numberMultiple)  + '袋</p><p style="margin-top: -1.2rem;">  ' + item.Name + '</p></div>' +
						'';
					$('#rankingsService').append(html)
				}
				if (obj.datas.length == 1) {
					$('#rankingsService .ranking-Percentage').css('marginTop', '4em');
				} else if (obj.datas.length == 2) {
					$('#rankingsService .ranking-Percentage').css('marginTop', '3em');
				} else if (obj.datas.length == 3) {
					$('#rankingsService .ranking-Percentage').css('marginTop', '2em');
				} else if (obj.datas.length == 4) {
					$('#rankingsService .ranking-Percentage').css('marginTop', '1em');
				}
			} else {
				$('#rankingsService').empty().append('<p style="position: relative;"><span class="hot"></span>服务中心销量排名（本月前五）</p><br/  >')
				for (var i = 0; i < 5; i++) {
					var html = '<div class="ranking-Percentage" style="position:relative">' +
						'<div class="progress">' +
						'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" ' +
						'style="width: 0%">' +
						' <span class="sr-only">0% Complete (success)</span>' +
						' </div>' + '</div>' + '<p class="rankingNum">0袋</p></div>' +
						'<p style="margin-top: -25px;"> 服务中心</p>';
					$('#rankingsService').append(html)
				}
			}
		});
		// 运营中心销量排名（本月前五）
		$.get('index.php?r=site/agenty-sales&province=' + provincefun, function(data) {
			if(data.code){
			//	console.log(data);
				return;
			}
			var obj = eval('(' + data + ')');

			if (obj.datas.length) {
				$('#rankingsOperate').empty()
				for (var i = 0; i < obj.datas.length; i++) {
					var item = obj.datas[i];
					var item_num = item.num ? item.num : 0
					var html = '<div	class="operate-item">' +
						'<p class="item-title" style="padding-bottom: 10px; color:#A541C2;font-weight:400;font-size:12px;  font-size: 1.2rem; ">' +  Math.floor(item_num*numberMultiple) + '袋</p>' +
						'<div class="Middle-line">' +
						'<div class="operate-img" style="height:' + item_num/ obj.total_sales*100 + '%;    background: url(/static/images3/Arrow.png) no-repeat;background-size: 65% 100%;background-position: 40%;">' +
						'<img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">' +
						// '<img src="/static/images3/Arrow.png" class="Arrow" alt="">' +
						'</div>' +
						'</div>' +
						'<p class="item-name">' + item.Name + '</p>' +
						'</div>';
					$('#rankingsOperate').append(html)
				}

				if (obj.datas.length == 1) {

					$('#rankingsOperate .operate-item').css('marginLeft', '6em');

				} else if (obj.datas.length == 2) {
					$('#rankingsOperate .operate-item').css('marginLeft', '3em');
				} else if (obj.datas.length == 3) {
					$('#rankingsOperate .operate-item').css('marginLeft', '2em');

				} else if (obj.datas.length == 4) {
					$('#rankingsOperate .operate-item').css('marginLeft', '1em');
				}
			} else {
				$('#rankingsOperate').empty()
				for (var i = 0; i < 5; i++) {
					var html = '<div class="operate-item">' +
						'<p class="item-title" style="    padding-bottom: 10px;">0袋</p>' +
						'<div class="Middle-line">' +
						'<div class="operate-img" style="height:0px">' +
						'<img id="scream" src="/static/images3/Smallbell.png" class="Smallbell"  alt="The Scream" width="5">' +
						'<img src="/static/images3/Arrow.png" class="Arrow" alt="">' +
						'</div>' +
						'</div>' +
						'<p class="item-name">运营</p>' +
						'</div>';
					$('#rankingsOperate').append(html)
				}
			}
		});

		// 地图地址
		$.get('index.php?r=site/get-province', function(data) {
			if(data.code){
				// console.log(data);
				return;
			}
			var obj = eval('(' + data + ')');
			// console.log(obj)
			if (obj) {

				 $.each(obj, function (index, item) {
		            if (item) {
		                $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
		            }
		        });
				 _this.province.val(provincefun)
				 _this.province.trigger("chosen:updated");
			}
		})	
			// 地图渲染

		$.get('index.php?r=site/dev-distribution&province=' + provincefun, function(data) {
             if(data.code){
				return;
			}

			var obj = eval('(' + data + ')');
			console.log(obj)		
			$("#equipmentOne").text(obj.not_active );
			$("#equipmentTwo").text(obj.dev_active*numberMultiple );
			$("#equipmentThree").text(obj.dev_warning *numberMultiple);
			var ProvinceNum = [];
			for (var i = 0; i < obj.datas.length; i++) {
				ProvinceNum.push(obj.datas[i].Province);
			};
			var Province = unique(ProvinceNum)
			var ProvinceTxt = [];
			var ProvinceP = []
			for (var i = 0; i < Province.length; i++) {
				ProvinceTxt.push(0);
				for (var y = 0; y < obj.datas.length; y++) {
					if (Province[i] === obj.datas[y].Province) {
						ProvinceTxt[i]++
					}
				}
				var num = Percentage3(ProvinceTxt[i], obj.datas.length)
				ProvinceP.push(num)
			};
			var placeList = [
				// {geoCoord:[121.15, 31.89]}
			]
			var earlyWarning = [];
			if(obj.warning_devnos){
					for (var i = 0; i < obj.warning_devnos.length; i++) {
						earlyWarning.push({
							geoCoord: [obj.warning_devnos[i].BaiDuLng, obj.warning_devnos[i].BaiDuLat]
						})
					};
			}
		
			for (var i = 0; i < obj.dev_location.length; i++) {
				placeList.push({
					geoCoord: [obj.dev_location[i].BaiDuLng, obj.dev_location[i].BaiDuLat]
				})
			}
			var reg;
			var province = '';
			if (provincefun != '') {
				var str = provincefun
				if (str.indexOf("省") != -1) {
					reg = new RegExp("省", "g");
					province = str.replace(reg, "");
				} else if (str.indexOf("市") != -1) {
					reg = new RegExp("市", "g");
					province = str.replace(reg, "");
				} else {
					province = str;
				}
				// provincefun=province
			}
			if (province == '请选择' || province == '' || province == '全国') {
				province = 'china';
			};
console.log(provincefun)
if(!provincefun){
	provincefun='china';
}



			map(placeList, Province, ProvinceTxt, ProvinceP, provincefun, earlyWarning);
		});




		// 饼图
		$.get('index.php?r=site/user-type-sales&province=' + provincefun, function(data) {
			if(data.code){
			//	console.log(data);
				return;
			}
			var obj = eval('(' + data + ')');
			// console.log(obj)
			var PieName = ['家庭', '单位', '集团', '其他']
			var PieNamenum = [0, 0, 0, 0]
			for (var i = 0; i < obj.usertype.length; i++) {
				var item = obj.usertype[i];
				if (item.CustomerType == 1) {
					PieNamenum[0] = item.num
				} else if (item.CustomerType == 2) {
					PieNamenum[1] = item.num
				} else if (item.CustomerType == 3) {
					PieNamenum[2] = item.num
				} else if (item.CustomerType == 99) {
					PieNamenum[3] = item.num
				}
			}


			var histogram_daray = [0, 0, 0, 0]
			for (var i = 0; i < obj.datas.length; i++) {
				var item = obj.datas[i];
				if (item.CustomerType == 1) {
					histogram_daray[0] = item.num*numberMultiple 
				} else if (item.CustomerType == 2) {
					histogram_daray[1] = item.num
				} else if (item.CustomerType == 3) {
					histogram_daray[2] = item.num*numberMultiple 
				} else {
					histogram_daray[3] = item.num*numberMultiple 
				}
			};


			barPieChart(PieName, PieNamenum);
			histogram(PieName, histogram_daray);
		});
		// 折线
		$.get('index.php?r=site/line-datas&province=' + provincefun, function(data) {
			if(data.code){
				// console.log(data);
			return;
			}
			var obj = eval('(' + data + ')');
			var userdarax = [];
			var userdaray = [];
			var waterdaray = [];
			var _Saledaray = [];
			NumberDays(15, userdarax)
			// // 用户增长
			for (var i = 0; i < userdarax.length; i++) {
				userdaray.push(0)
				var nowDate = Date.parse(userdarax[i]);
				for (var j = 0; j < obj.user_increase.length; j++) {
					TwoDate = Date.parse(obj.user_increase[j].Date);
					if (nowDate == TwoDate) {
						userdaray[i]++
					}
				}
			}
			for (var i = 0; i < userdarax.length; i++) {
				waterdaray.push(0)
				var nowDate = Date.parse(userdarax[i]);
				for (var j = 0; j < obj.user_sales.length; j++) {
					TwoDate = Date.parse(obj.user_sales[j].Date);
					if (nowDate == TwoDate) {
						waterdaray[i]++;
					}
				}
			}
			for (var i = 0; i < userdarax.length; i++) {
				_Saledaray.push(0)
				var nowDate = Date.parse(userdarax[i]);

				for (var j = 0; j < obj.use_status.length; j++) {
					TwoDate = Date.parse(obj.use_status[j].ActDate);
					if (nowDate == TwoDate) {
						_Saledaray[i] = _Saledaray[i] * 1 + obj.use_status[j].WaterUse * 1;
					}
				}
			}
	for (var i = 0; i < userdarax.length; i++) {
		     userdaray[i]=userdaray[i]*numberMultiple;
		     _Saledaray[i]=_Saledaray[i]*numberMultiple;
		     waterdaray[i]=waterdaray[i]*numberMultiple;
	}


			lineDiagram(userdarax, userdaray, _Saledaray, waterdaray)
			layer.close(ii);
		})

		function unique($data) {
			var res = [];
			var json = {};
			for (var p = 0; p < $data.length; p++) {
				if (!json[$data[p]]) {
					res.push($data[p]);
					json[$data[p]] = 1;
				} else {}
			}
			return res;
		};
function NumberDays(xin, _date) {
	for (var i = 0; i >= -xin + 1; i--) {
		_date.push(GetDateStr(i, 1))
	}
	_date.reverse();
	return _date;
};


function GetDateStr(AddDayCount, AddMonthCount) {
	var dd = new Date();
	dd.setDate(dd.getDate() + AddDayCount); //获取AddDayCount天后的日期
	var y = dd.getFullYear();
	var m = dd.getMonth() + AddMonthCount; //获取当前月份的日期
	var d = dd.getDate();
	if (String(d).length < 2) {
		d = "0" + d;
	}
	if (String(m).length < 2) {
		m = "0" + m;
	}
	return y + "-" + m + "-" + d;
};

		function Percentage3(number1, number2) {
			if (number2 <= 0) {
				number2 = 1
			}
			if (number1 <= 0) {
				number1 = 0
			}
			return (Math.round((number1 / number2) * 10000) / 100); // 小数点后两位百分比
		};

}

function getNowFormatDate() {
	var date = new Date();
	var seperator1 = "-";
	var seperator2 = ":";
	var month = date.getMonth() + 1;
	var strDate = date.getDate();
	if (month >= 1 && month <= 9) {
		month = "0" + month;
	}
	if (strDate >= 0 && strDate <= 9) {
		strDate = "0" + strDate;
	}



	var dataget1 = date.getHours();
	var dataget2 = date.getMinutes();
	var dataget3 = date.getSeconds();

	if (dataget1 >= 1 && dataget1 <= 9) {
		dataget1 = "0" + dataget1;
	}
	if (dataget2 >= 0 && dataget2 <= 9) {
		dataget2 = "0" + dataget2;
	}
	if (dataget3 >= 0 && dataget3 <= 9) {
		dataget3 = "0" + dataget3;
	}

	var getDay = date.getDay();
	var show_day = new Array('星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');


	var getDay_day = getDay - 1;
	if (getDay_day < 0) {
		getDay_day = 6;
	};


	var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate +
		" " + show_day[getDay_day] + "  " + dataget1 + "  " + seperator2 + dataget2 + "   " +
		seperator2 + "   " + dataget3;
	return currentdate;
}


function map(placeList, Province, ProvinceTxt, ProvinceP, provincefun, earlyWarning) {
// console.log(earlyWarning)
if(provincefun==' '){
	provincefun='china';
}
else
    if(provincefun.indexOf('省')){
		var src_province_val=provincefun.split("省");
		provincefun= src_province_val[0];
	}
		if(provincefun.indexOf('自治区')){
		var src_province_val=provincefun.split("自治区");
		provincefun= src_province_val[0];
	}
     if(provincefun.indexOf('回')){
		var src_province_val=provincefun.split("回");
		provincefun= src_province_val[0];
	}
if(provincefun.indexOf('维')){
		var src_province_val=provincefun.split("维吾尔");
		provincefun= src_province_val[0];
	}
	if(provincefun.indexOf('特')){
		var src_province_val=provincefun.split("特别");
		provincefun= src_province_val[0];

	}
	if(provincefun.indexOf('壮')){
		var src_province_val=provincefun.split("壮");
		provincefun= src_province_val[0];
	}	

// console.log(provincefun)
	require.config({
		paths: {
			echarts: '/static/js/echarts/dist'
		}
	});
	require(
		[
			'echarts',
			'echarts/chart/map',
			'echarts/config'
		],
		function(ec) {
			var myChart = ec.init(document.getElementById('main'));

			var option = {
				backgroundColor: 'transparent',

				color: [

					'#FEC751'
				],

				color: [
					'#9018A9',
					'#FEC751',
					'#0D64A5'
				],


				legend: {
					orient: 'vertical',
					x: 'left',
					data: [],
					textStyle: {
						color: '#fff'
					}
				},

				toolbox: {
					show: true,
					orient: 'vertical',
					x: 'right',
					y: 'center',
					feature: {
						mark: {
							show: false
						},
						dataView: {
							show: false,
							readOnly: false
						},
						restore: {
							show: false
						},
						saveAsImage: {
							show: false
						}
					}
				},
				series: [{
						name: '正常设备',
						type: 'map',
						mapType: provincefun,
						hoverable: false,
						roam: false,

						itemStyle: {
							normal: {
								borderColor: ' rgba(37,40,45,0.68)',

								areaStyle: {
									color: '#2F343A'
								}
							}
						},
						data: [],
						markPoint: {
							symbol: 'diamond',
							symbolSize: 6,
							large: true,
							effect: {
								show: true
							},
							data: (function() {
								var data = [];
								var len = placeList.length;
								var geoCoord
								while (len--) {
									geoCoord = placeList[len % placeList.length].geoCoord;
									data.push({
										// name : placeList[len % placeList.length].name + len,
										value: 10,
										geoCoord: [
											geoCoord[0],
											geoCoord[1]
										]
									})
								}
								// console.log(data)  
								return data;
							})()
						}
					}, {
						name: '预警设备',
						type: 'map',
						mapType: provincefun,
						hoverable: false,
						roam: false,
						itemStyle: {
							normal: {
								borderColor: ' rgba(37,40,45,0.68)',

								areaStyle: {
									color: '#2F343A'
								}
							}
						},
						data: [],
						markPoint: {
							symbol: 'diamond',
							symbolSize: 3,
							large: true,
							effect: {
								show: true
							},
							data: (function() {
								var data = [];
								var len = earlyWarning.length;
								var geoCoord
								while (len--) {
									geoCoord = earlyWarning[len % earlyWarning.length].geoCoord;
									data.push({
										// name : placeList[len % placeList.length].name + len,
										value: 10,
										geoCoord: [
											geoCoord[0],
											geoCoord[1]
										]
									})
								}
								// console.log(data)  
								return data;
							})()
						}
					}


				]
			};
			myChart.setOption(option, true);
		}

	)


};




// 折线图
function lineDiagram(userdarax, userdaray, Saledaray, waterdaray) {
	// 基于准备好的dom，初始化echarts图表
	var myChart = echarts.init(document.getElementById('echarts3'), 'customed');
	var option = {
		tooltip: {
			trigger: 'axis',
			backgroundColor: 'rgba(203,73,46,0.9)',
			textStyle: {
				color: '#fff',
			},
			formatter: function(params) {

				var html =params[0].name + '<br/>' +params[1].seriesName + ':' + Math.round((params[1].data) * 10000) / 10000 + '(L)<br/>'+
				params[2].seriesName + ':' + Math.round((params[2].data) * 10000) / 10000 + '(袋)<br/>' +
				 params[0].seriesName + ':' + params[0].data + '家<br/>' 
				
				
					
				return html;
			}
		},
		grid:{
                    x:50,
                    borderWidth:1
                },

		toolbox: {
			show: false,
			feature: {
				mark: {
					show: true
				},
				dataView: {
					show: true,
					readOnly: false
				},
				magicType: {
					show: true,
					type: ['line', 'bar']
				},
				restore: {
					show: true
				},
				saveAsImage: {
					show: true
				}
			}
		},
		calculable: true,
		xAxis: [{
			type: 'category',
			boundaryGap: false,
			data: userdarax,
			axisLabel: {
				show: true,
				textStyle: {
					color: 'rgb(233,233,233)',
				}
			}
		}],
		yAxis: [{
			type: 'value',
			axisLabel: {
				show: true,
				textStyle: {
					color: 'rgb(233,233,233)',
				},
				formatter: '{value}'
			}
		}],
		series: [{
			name: '用户',
			type: 'line',
			center: ['20%', '20%'],
			data: userdaray,
			itemStyle: {
				normal: {
					color: "#3EE3E5",
					lineStyle: {
						color: "#3EE3E5"
					}
				}
			}

		}, {
			name: '用水量',
			type: 'line',
			data: Saledaray,
			itemStyle: {
				normal: {
					color: "#FEC751",
					lineStyle: {
						color: "#FEC751"
					}
				}
			}
		}, {
			name: '销量',
			type: 'line',
			data: waterdaray,
			itemStyle: {
				normal: {
					color: "#AE43CD",
					lineStyle: {
						color: "#AE43CD"
					}
				}
			}
			// markLine : {
			//     data : [
			//         {type : 'average', name : '平均值'}
			//     ]
			// }
		}]
	};

	// 为echarts对象加载数据 
	myChart.setOption(option);



}



function histogram(PieName, histogram_daray) {


	var myChart2 = echarts.init(document.getElementById('echarts2'), 'customed');

	var option2 = {

		tooltip: {
			trigger: 'axis',
			backgroundColor: 'rgba(203,73,46,0.9)',
			textStyle: {
				color: '#fff',
			},
			formatter: function(params) {

				return params[0].name + '用户：' + params[0].data + '袋'
			}
		},
		grid:{
                    x:50,
                    borderWidth:1
                },
		xAxis: [{
			type: 'category',
			axisLabel: {
				show: true,
				textStyle: {
					color: 'rgb(233,233,233)',
				}
			},
			data: PieName
		}],
		yAxis: [{
			type: 'value',
			axisLabel: {
				show: true,
				textStyle: {
					color: 'rgb(233,233,233)',
				}
			}
		}],
		series: [{
			"name": "销量",
			'barWidth': 10,
			"type": "bar",
			itemStyle: {
				//通常情况下：
				normal: {　　　　　　　　　　　　 //每个柱子的颜色即为colorList数组里的每一项，如果柱子数目多于colorList的长度，则柱子颜色循环使用该数组
					color: function(params) {
						var colorList = ['#51F2F3', '#FEC751', '#C248DC', '#EE5030'];
						return colorList[params.dataIndex];
					}
				},
				//鼠标悬停时：
				emphasis: {
					shadowBlur: 10,
					shadowOffsetX: 0,
					shadowColor: '#CB492E'
				}
			},
			"data": histogram_daray
		}]
	};

	// 为echarts对象加载数据 
	myChart2.setOption(option2, true);
}



function barPieChart(PieName, PieNamenum) {

	var myChart = echarts.init(document.getElementById('echarts'));


	var option = {
		tooltip: {
			trigger: 'item',
			formatter: "{a} <br/>{b} : ({d}%)",
			backgroundColor: 'rgba(203,73,46,0.9)',
			textStyle: {
				color: '#fff',

			}
		},
		// legend: {
		//   orient : 'vertical',
		//   x : 'right',
		//   y : 'bottom',
		//   data:['家庭','集团','公司','其他'],
		//   textStyle: {
		//   color: '#fff'
		//       },
		//   },
		toolbox: {
			show: false,
			feature: {
				mark: {
					show: false
				},
				dataView: {
					show: false,
					readOnly: true,

				},
				magicType: {
					show: false,
					type: ['pie', 'funnel'],
					option: {
						funnel: {
							x: '20%',
							width: '100%',
							funnelAlign: 'center',
							max: 1548
						}
					}
				},
				restore: {
					show: false,
					title: "刷新",
				},
				saveAsImage: {
					show: false
				}
			}
		},
		calculable: false,
		series: [{
				name: '用户类型',
				type: 'pie',
				radius: ['50%', '60%'],
				center: ['50%', '55%'],
				itemStyle: {
					normal: {
						label: {
							show: true,
							formatter: '{d}%'

						},
						labelLine: {
							show: true
						}
					},
					emphasis: {
						label: {
							show: false,
							position: 'center',
							textStyle: {
								fontSize: '30',
								fontWeight: 'bold'
							}
						}
					}
				},
				data: [{
						value: PieNamenum[0],
						name: PieName[0]
					}, {
						value: PieNamenum[1],
						name: PieName[1]
					}, {
						value: PieNamenum[2],
						name: PieName[2]
					}, {
						value: PieNamenum[3],
						name: PieName[3]
					}

				]
			}



		],
		color: ['#51F2F3', '#FEC751', '#C248DC', '#EE5030']

	};


	myChart.setOption(option, true);



}

