 $(function() {

 			console.log(datas.where)
 		// 时间选择
 		var dateRange = new pickerDateRange('date_demo', {
 			//aRecent7Days : 'aRecent7DaysDemo3', //最近7天
 			isTodayValid: true,
 			// startDate :'2017-8-22',
 			// endDate :'2017-8-22',
 			//needCompare : true,
 			//isSingleDay : true,
 			//shortOpr : true,
 			//autoSubmit : true,
 			defaultText: ' 至 ',
 			inputTrigger: 'input_trigger_demo',
 			theme: 'ta',
 			success: function(obj) {
 				$("#dCon_demo3").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);

 				$("#selecttime1").val($("#date_demo").val());
 			}
 		});
 		$("#Refresh").click(function() {
 			window.location.reload();

 		})
 		// console.log(where_datas);

 		initProvince(where_datas.areas)
 		provincelist(where_datas.areas)

 		water_brand_list(where_datas.devbrand, where_datas.devname, $("#devbrand"), $("#devname"))

 		roleList(where_datas.devfactory, $('#devfactory'));
 		roleList(where_datas.investor, $('#investor'));
 		roleList(where_datas.agenty, $('#Agenty'));
 		Agentflist()
 		// console.log(where_datas)
 		initAddress()



 		$(document).on('click', '.dropdown-menu li', function() {
 				var _class = $(this).attr('class')
 				// if(_class=='downLi'){
 				var _thisval = $(this).attr('value');
 				var _thisvalText = $(this).text();
 				var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
 				if (_thisval != _toggleval) {
 					$(this).siblings().css({
 						'backgroundColor': 'transparent',
 						'color': '#000'
 					});
 					$(this).css({
 						'backgroundColor': '#E46045',
 						'color': 'rgb(233,233,233)'
 					});
 					$(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvalText + '&nbsp;&nbsp;&nbsp;  <span class="caret"></span>');
 					$(this).parent().siblings(".toggle-input").val(_thisval)
 				}
 				// }
 				// Univalent()
 			})
 			.on('click', '#removerSub', function() {

 				$(".toggle-input").val('')
 				var dropdownLength = $('.dropdown').length;
 				$("#date_demo").text('');
 				$("#selecttime1").val('');
 				$("#searchp").val('');

 				for (var i = 0; i < dropdownLength; i++) {
 					var dropLi = $('.dropdown li:first-of-type').eq(i).text();
 					var dropLival = $('.dropdown li:first-of-type').eq(i).val();
 					$('.dropdown button').eq(i).text(dropLi);
 					$('.dropdown .toggle-input').eq(i).val(dropLival);
 				}


 				return false;
 			})
 			.on('click', '.promote', function() {

 				var par = $(this).parent().siblings(".oiuy").text();
 				var parDevdevname = $(this).parent().siblings(".devname").attr('dataId');
 				var parDevbrand = $(this).parent().siblings(".devbrand ").attr('dataId');
 				var spCodesTemp = $(this).parent().siblings(".DevNo ").text();
 				var searchParameters = {
 					selecttime: datas.where.selecttime||'',
 					province: datas.where.province||'',
 					city: datas.where.city||'',
 					area: datas.where.area||'',
 					state: datas.where.state||'',
 					devbrand_id: parDevbrand||'',
 					devname_id: parDevdevname||'',
 					agenty_id: datas.where.agenty_id||'',
 					agentf_id: datas.where.agentf_id||'',
 					devfactory_id: datas.where.devfactory_id||'',
 					investor_id: datas.where.investor_id||'',
 					customertype: datas.where.customertype||'',
 					search: datas.where.search||''
 				};
 				$.get('index.php?r=version-manage/get-version&devbrand_id=' + parDevbrand + '&devname_id=' + parDevdevname, function(data) {
 					var data = eval('(' + data + ')');
 					var version = '';
 					if (data.state == 0) {
 						version = data.version;
 					}
 					var html = '<div class="container"   style="height:100%;width: 100%;">'
 					html += '<form action="/index.php?r=version-manage/upload-upgrade" method="post" enctype="multipart/form-data"  style="height:100%">'
 					html += '<div class="opdate-details"><div class="opdate-list"> '
 					html += '<p style="font-weight: bold;color: #D74E33;font-size: 15px;">'
 					html += '文件版本:<span>' + version + '</span>'
 					html += '</p>'
 					html += '<p>选择上传文件: '
 					html += '<input type="text" id="file_name" readonly="readonly" value=""  placeholder="选择版本文件"  /> '
 					html += '<a href="javascript:void(0);" class="input">选择文件  <input type="file" id="file"  name="file[]" value=""  multiple ></a>'
 					html += '</p>'
 					html += '<p>选择开始时间：'
 					html += '<input type="text"  value=""  unselectable="on" readonly  placeholder="选择时间" name="StartTime"id="J-xl"> '
 					html += '</p>'
 					html += '<p style="display:none">'
 					html += '<input type="hidden" id="devbrand_dataN" name="devbrand_id" value="' + parDevbrand + '" />'
 					html += '<input type="hidden"  name="devno" value="' + spCodesTemp + '" />'
 					html += '<input type="hidden" id="devname_dataN"  name="devname_id" value="' + parDevdevname + '" />'
 					html += '<input type="hidden"  name="selecttime" value="' + searchParameters.selecttime + '" />'
 					html += '<input type="hidden"  name="province" value="' + searchParameters.province + '" />'
 					html += '<input type="hidden"  name="city" value="' + searchParameters.city + '" />'
 					html += '<input type="hidden"  name="area" value="' + searchParameters.area + '" />'
 					html += '<input type="hidden"  name="state" value="' + searchParameters.state + '" />'
 					html += '<input type="hidden"  name="agenty_id" value="' + searchParameters.agenty_id + '" />'
 					html += '<input type="hidden"  name="agentf_id" value="' + searchParameters.agentf_id + '" />'
 					html += '<input type="hidden"  name="devfactory_id" value="' + searchParameters.devfactory_id + '" />'
 					html += '<input type="hidden"  name="investor_id" value="' + searchParameters.investor_id + '" />'
 					html += '<input type="hidden"  name="customertype" value="' + searchParameters.customertype + '" />'
 					html += '</p>'
 					html += '<p><span>注</span>：点击提交后,设备将在选择是时间内自动升级，若当前最高版本是最新版本，则无需上传文件</p>  '
 					html += ' <button type="button"  class="Close" >取消</button>'
 					html += ' <button type="submit" class="submit" style="background-color: #E46045" >提交</button>'
 					html += '</div><div></form><div>';
 					layerdatefun(html)
 				})
 			})
 	})
 	.on('click', "#AllEquipment", function() {
 		var searchParameters = {
 			selecttime: datas.where.selecttime||'',
 			province: datas.where.province||'',
 			city: datas.where.city||'',
 			area: datas.where.area||'',
 			state: datas.where.state||'',
 			devbrand_id: datas.where.devbrand_id||'',
 			devname_id: datas.where.devname_id||'',
 			agenty_id: datas.where.agenty_id||'',
 			agentf_id: datas.where.agentf_id||'',
 			devfactory_id: datas.where.devfactory_id||'',
 			investor_id: datas.where.investor_id||'',
 			customertype: datas.where.customertype||''
 		}
 		if (!searchParameters.devbrand_id || searchParameters.devbrand_id == '0' || searchParameters.devbrand_id == null || searchParameters.devbrand_id == ' ' || searchParameters.devname_id == '0' || searchParameters.devname_id == null || !searchParameters.devname_id || searchParameters.devname_id == ' ') {
 			layer.msg('请经过筛选设备品牌或设备型号在进行操作');



 			return false;
 		}


 		$.get('index.php?r=version-manage/get-version&devbrand_id=' + searchParameters.devbrand_id + '&devname_id=' + searchParameters.devname_id, function(data) {
 			var data = eval('(' + data + ')');

 			// console.log(data)
 			var version = '';
 			if (data.state == -1) {
 				layer.msg(data.mas);
 				// return   //     alert("上传的格式不正确，请重新选择")
 			} else if (data.state == 0) {
 				version = data.version;
 			}
 			var html = '<div class="container"  style="height:100%;width: 100%;">'
 			html += '<form action="/index.php?r=version-manage/upload-upgrade" method="post" enctype="multipart/form-data"  style="height:100%">'
 			html += '<div class="opdate-details">'
 			html += '<div class="opdate-list"> '
 			html += '<p style="font-weight: bold;color: #D74E33;font-size: 15px;">文件版本:<span>' + version + '</span>'
 			html += '</p>'
 			html += '<p>选择上传文件: '
 			html += '<input type="text" id="file_name" readonly="readonly" value=""  placeholder="选择版本文件" /> '
 			html += '<a href="javascript:void(0);" class="input">选择文件  <input type="file" id="file"  name="file[]" value=""  multiple ></a>'
 			html += '</p><p>选择开始时间：<input type="text"  value=""  unselectable="on" readonly  placeholder="选择时间" name="StartTime"id="J-xl"> </p>'
 			html += '<p style="display:none">'
 			html += '<input type="hidden"  name="selecttime" value="' + searchParameters.selecttime + '" />'
 			html += '<input type="hidden"  name="province" value="' + searchParameters.province + '" />'
 			html += '<input type="hidden"  name="city" value="' + searchParameters.city + '" />'
 			html += '<input type="hidden"  name="area" value="' + searchParameters.area + '" />'
 			html += '<input type="hidden"  name="state" value="' + searchParameters.state + '" />'
 			html += '<input type="hidden"  name="devbrand_id" value="' + searchParameters.devbrand_id + '" />'
 			html += '<input type="hidden"  name="devname_id" value="' + searchParameters.devname_id + '" />'
 			html += '<input type="hidden"  name="agenty_id" value="' + searchParameters.agenty_id + '" />'
 			html += '<input type="hidden"  name="agentf_id" value="' + searchParameters.agentf_id + '" />'
 			html += '<input type="hidden"  name="devfactory_id" value="' + searchParameters.devfactory_id + '" />'
 			html += '<input type="hidden"  name="investor_id" value="' + searchParameters.investor_id + '" />'
 			html += '<input type="hidden"  name="customertype" value="' + searchParameters.customertype + '" />'
 			html += '</p>'
 			html += '<p><span>注</span>：点击提交后,设备将在选择是时间内自动升级，若当前最高版本是最新版本，则无需上传文件</p>  '
 			html += ' <button type="button"  class="Close" >取消</button>'
 			html += ' <button type="submit" class="submit" style="background-color: #E46045" >提交</button>'
 			html += '</div><div></form><div>';
 			layerdatefun(html)
 		});
 	})
 	.on('click', "#batchPromote", function() {
 		var spCodesTemp = [];
 		$('#dev_list_body input:checkbox[name=state]:checked').each(function(i) {
 			spCodesTemp.push($(this).parent().siblings(".DevNo").text());
 		});
 		//var parDevdevname = $("#devbrand option:selected").val();
 		//var parDevbrand  =$("#devname option:selected").val();

 		var searchParameters = {
 			selecttime: datas.where.selecttime||'',

 			province: datas.where.province||'',
 			city: datas.where.city||'',
 			area: datas.where.area||'',

 			state: datas.where.state||'',
 			devbrand_id: datas.where.devbrand_id||'',
 			devname_id: datas.where.devname_id||'',

 			agenty_id: datas.where.agenty_id||'',
 			agentf_id: datas.where.agentf_id||'',

 			devfactory_id: datas.where.devfactory_id||'',
 			investor_id: datas.where.investor_id||'',
 			customertype: datas.where.customertype||'',
 			search: datas.where.search||''
 		}
 		// console.log(searchParameters)

 		if (!searchParameters.devbrand_id || searchParameters.devbrand_id == '0' || searchParameters.devbrand_id == null || searchParameters.devbrand_id == ' ' || searchParameters.devname_id == '0' || searchParameters.devname_id == null || !searchParameters.devname_id || searchParameters.devname_id == ' ') {

 			layer.msg('请选择设备品牌和设备型号筛选后再进行此操作');
 			return;
 		}

 		if (!spCodesTemp.length) {

 			layer.msg('请选择升级设备');
 			return;
 		}
 		// console.log(spCodesTemp)

 		if (spCodesTemp.length < 0) {
 			layer.msg('请选择升级的设备');

 			return;
 		}

 		$.get('index.php?r=version-manage/get-version&devbrand_id=' + searchParameters.devbrand_id + '&devname_id=' + searchParameters.devname_id, function(data) {
 			var data = eval('(' + data + ')');

 			// console.log(data)
 			var version = '';
 			if (data.state == 0) {
 				version = data.version;
 			}
 			var html = '<div class="container"   style="height:100%;width: 100%;">'
 			html += '<form action="/index.php?r=version-manage/upload-upgrade" method="post" enctype="multipart/form-data"  style="height:100%">'
 			html += '<div class="opdate-details"><div class="opdate-list"> '
 			html += '<p style="font-weight: bold;color: #D74E33;font-size: 15px;">文件版本:<span>' + version + '</span></p>'
 			html += '<p>选择上传文件: '
 			html += '<input type="text" id="file_name" readonly="readonly" value="" placeholder="选择版本文件" /> '
 			html += '<a href="javascript:void(0);" class="input">选择文件  <input type="file" id="file"  name="file[]" value=""  multiple ></a>'
 			html += '</p>'
 			html += '<p>选择开始时间：<input type="text"  value="" placeholder="选择时间" unselectable="on" readonly  name="StartTime"id="J-xl"></p>'
 			html += '<p style="display:none"><input type="hidden" id="devbrand_dataN" name="devbrand_id" value="' + searchParameters.devbrand_id + '" /></p>'
 			html += '<p style="display:none"><input type="hidden" id="devname_dataN"  name="devname_id" value="' + searchParameters.devname_id + '" /></p>'
 			html += '<p style="display:none"><input type="hidden"  name="devno" value="' + spCodesTemp + '" /></p>'
 			html += '<p style="display:none">'
 			html += '<input type="hidden"  name="selecttime" value="' + searchParameters.selecttime + '" />'
 			html += '<input type="hidden"  name="province" value="' + searchParameters.province + '" />'
 			html += '<input type="hidden"  name="city" value="' + searchParameters.city + '" />'
 			html += '<input type="hidden"  name="area" value="' + searchParameters.area + '" />'
 			html += '<input type="hidden"  name="state" value="' + searchParameters.state + '" />'
 			html += '<input type="hidden"  name="agenty_id" value="' + searchParameters.agenty_id + '" />'
 			html += '<input type="hidden"  name="agentf_id" value="' + searchParameters.agentf_id + '" />'
 			html += '<input type="hidden"  name="devfactory_id" value="' + searchParameters.devfactory_id + '" />'
 			html += '<input type="hidden"  name="investor_id" value="' + searchParameters.investor_id + '" />'
 			html += '<input type="hidden"  name="customertype" value="' + searchParameters.customertype + '" />'
 			html += '</p>'
 			html += '<p><span>注</span>：点击提交后,设备将在选择是时间内自动升级，若当前最高版本是最新版本，则无需上传文件</p>'
 			html += ' <button type="button"  class="Close" >取消</button>'
 			html += ' <button type="submit" class="submit" style="background-color: #E46045" >提交</button>'
 			html += '</div><div></form><div>';
 			layerdatefun(html)
 		})
 	})


 $("#batchPromote").hover(function() {
 	$(this).css({
 		'backgroundColor': '#C9302C',
 		'color': '#fff'
 	})
 	$("#batchPromote img").attr('src', '/static/images3/batchPromoteImg2.png');
 }, function() {
 	$(this).css({
 		'backgroundColor': '#424952',
 		'color': '#fff'
 	})
 	$("#batchPromote img").attr('src', '/static/images3/batchPromoteImg.png');
 })


 $("#AllEquipment").hover(function() {
 	$(this).css({
 		'backgroundColor': '#C9302C',
 		'color': '#fff'
 	})
 	$("#AllEquipment img").attr('src', '/static/images3/AllEquipmentImg2.png');
 }, function() {
 	$(this).css({
 		'backgroundColor': '#424952',
 		'color': '#fff'
 	})
 	$("#AllEquipment img").attr('src', '/static/images3/AllEquipmentImg.png');
 })
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
 // 省渲染
 function initProvince(areas, _id) {
 	// $('#province option').not(":first").remove(); 
 	var provinceVal = $("#province").parents('.dropdown').children(".dropdown-menu")
 	provinceVal.children().not(":first").remove()
 	for (var index = 0; index < areas.length; index++) {
 		var item = areas[index];
 		// console.log(item)
 		if (item.PId == 0) {
 			provinceVal.append("<li  class='downLi'  value='" + item.Name + "'>" + item.Name + "</li>");
 		}
 	}
 }
 //弹窗
 function layerdatefun(html) {
 	var ppp = layer.open({
 		type: 1,
 		title: false,
 		area: ['730px', '500px'],
 		closeBtn: 0,
 		shadeClose: true,
 		skin: 'yourclass',
 		content: html
 	});


 	$("#J-xl").val(GetDateStr(0, 1))

 	$("#J-xl").click(function() {
 		laydate({
 			elem: '#J-xl'
 		});
 	})

 	$('.Close').click(function() {
 		layer.close(ppp);

 	})


 	$('.submit').click(function() {
 		if ($("#J-xl").val() == '') {

 			layer.msg('请上传时间');
 			return false;
 		}
 	})


 	var input = document.getElementById("file");
 	var result, div;
 	if (typeof FileReader === 'undefined') {
 		result.innerHTML = "抱歉，你的浏览器不支持 FileReader";
 		input.setAttribute('disabled', 'disabled');
 	} else {
 		input.addEventListener('change', readFile, false);
 	}
 	function readFile() {
 		var filesLength = this.files.length
 		if (filesLength > 3) {
 			// alert("上传数量超限")
 			layer.msg('上传数量超限');
 			return false;
 		}
 		for (var i = 0; i < filesLength; i++) {
 			if (!input['value'].match(/.bin|.ini/i)) {　　 //判断上传文件格式
 				layer.msg('上传的格式不正确，请重新选择');
 				return //     alert("上传的格式不正确，请重新选择")
 			}
 			var reader = new FileReader();
 			reader.readAsDataURL(this.files[i]);
 		}
 		$("#file_name").val('已选择' + this.files.length + '个文件'); //将 #file 的值赋给 #file_name
 	}
 }


 function provincelist(areas) {
 	// 选择省后渲染市
 	$("#province").parents('.dropdown').children(".dropdown-menu").children().click(function() {
 		var _thisval = $(this).attr('value');

 		$("#city").html('请选择&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
 		$("#area").html('请选择&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
 		var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
 		if (_thisval != _toggleval) {
 			// alert(_thisval)

 			initCityOnProvinceChange(_thisval, where_datas.areas)
 		}
 		// 选择市后渲染区
 		$("#city").parents('.dropdown').children(".dropdown-menu").children().click(function() {
 			var _thisval = $(this).attr('value');
 			$("#area").html('请选择&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
 			var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
 			if (_thisval != _toggleval) {

 				initThree(_thisval, where_datas.areas)
 			}
 		})
 	})



 }



 // 选择省后渲染区的方法
 function initCityOnProvinceChange(_thisval, areas) {
 	var pid = getAddressIdByName(_thisval);
 	var pcityVal = $("#city").parents('.dropdown').children(".dropdown-menu")
 	pcityVal.children().not(":first").remove();
 	$("#area").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove();

 	if (pid == 0) {
 		return;
 	}
 	for (var index = 0; index < areas.length; index++) {
 		var item = areas[index];
 		if (item.PId != 0 && item.PId == pid) {
 			pcityVal.append("<li   class='downLi' value='" + item.Name + "'>" + item.Name + "</li>");
 		}
 	}
 }
 // 渲染区
 function initThree(_thisval, areas) {
 	var pid = getAddressIdByName(_thisval);

 	var areaVal = $("#area").parents('.dropdown').children(".dropdown-menu")
 	areaVal.children().not(":first").remove();
 	if (pid == 0) {
 		return;
 	}
 	for (var index = 0; index < areas.length; index++) {
 		var item = areas[index];
 		if (item.PId != 0 && item.PId == pid) {
 			areaVal.append("<li   class='downLi' value='" + item.Name + "'>" + item.Name + "</li>");
 		}
 	}
 }

 // 获取id比较
 function getAddressIdByName(_name) {
 	_name = $.trim(_name);
 	if (_name == "") {
 		return 0;
 	}
 	for (var index = 0; index < where_datas.areas.length; index++) {
 		var item = where_datas.areas[index];
 		var name = $.trim(item.Name);
 		if (name != "" && name == _name) {

 			return item.Id;
 		}
 	}
 	return;
 }


 function water_brand_list(devbrand, devname, $id, $goodsid) {
 	if (devbrand) {
 		var water_brandVal = $id.parents('.dropdown').children(".dropdown-menu")
 		water_brandVal.children().not(":first").remove()
 		$("#water_goods").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
 		for (var i = 0; i < devbrand.length; i++) {
 			var item = devbrand[i];
 			// console.log(item)
 			water_brandVal.append("<li  class='downLi' value=" + item.BrandNo + ">" + item.BrandName + "</li>");
 		}
 	}


 	// 次序渲染
 	$id.parents('.dropdown').children(".dropdown-menu").children().click(function() {
 		var _thisval = $(this).attr('value');
    
 		$goodsid.html('请选择设备型号&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
 		var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
 		if (_thisval != _toggleval) {
 			// alert(_thisval)
 			initWater_goodsChange(_thisval)
 		}
 	})
 }


 // 选择品牌后渲染商品的方法
 function initWater_goodsChange(_thisval) {

 	var devname = where_datas.devname;

 	if (devname) {

 		var water_brandVal = $("#devname").parents('.dropdown').children(".dropdown-menu");
 		water_brandVal.children().not(":first").remove()
 		for (var i = 0; i < devname.length; i++) {
 			var item = devname[i];

 			if (item.brand_id == _thisval) {
 				// console.log(item)

 				water_brandVal.append("<li  class='downLi' value='" + item.id + "'>" + item.name + "</li>");
 			}
 		}
 	}
 }



 // 角色渲染
 function roleList(dataList, $id) {

 	var water_brandVal = $id.parents('.dropdown').children(".dropdown-menu");
 	water_brandVal.children().not(":first").remove()
 	if (dataList) {

 		for (var i = 0; i < dataList.length; i++) {
 			var item = dataList[i];
 			water_brandVal.append("<li  class='downLi' value='" + item.Id + "'>" + item.Name + "</li>");
 		}
 	}
 }

 function Agentflist() {
 	$("#Agenty").parents('.dropdown').children(".dropdown-menu").children().click(function() {
 		var _thisval = $(this).attr('value');
 		$("#Agentf").html('请选择服务中心&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
 		Agentflistp(_thisval)

 	})
 }


 function Agentflistp(_thisval) {
 	var water_brandVal = $("#Agentf").parents('.dropdown').children(".dropdown-menu")
 	water_brandVal.children().not(":first").remove();
 	for (var i = 0; i < where_datas.agentf.length; i++) {
 		var item = where_datas.agentf[i];
 		item.ParentId
 		if (_thisval == item.ParentId) {
 			water_brandVal.append("<li  class='downLi' value='" + item.Id + "'>" + item.Name + "</li>");
 		}

 	}
 }

 function initAddress() {
 	if (datas.where) {
 		// 记录选项
 		var select_where = datas.where

 		// console.log(select_where)
 		for (var i in select_where) {
 			var item = select_where[i];

 			if (item) {

 				var form_input = $("form input").length;
 				// console.log(item)
 				// console.log(i)
 				for (var y = 0; y < form_input; y++) {
 					var formName = $("form input").eq(y).attr('name')

 					if (formName == i) {


 						$("form input").eq(y).val(item);
 						$("form input").eq(y).parent().find(".dropdown-toggle").attr('value', item);
 						var oppo = getAddressIdName(item, i)
 						$("form input").eq(y).parent().find(".dropdown-toggle").html(oppo + '&nbsp;&nbsp;&nbsp;<span class="caret"></span>');
 					}
 				}
 			}
 		}

 		$("#date_demo").text(select_where.selecttime);
 		$("#selecttime1").val(select_where.selecttime);


 	}
 }



 function getAddressIdName(_name, i) {
 	// console.log(_name)
 	// console.log(i)

 	_name = $.trim(_name);
 	if (_name == "" || _name == 0) {
 		return '请选择';
 	}

 	if (i == 'province') {

 		initCityOnProvinceChange(_name, where_datas.areas)
 		return _name;
 	} else if (i == 'city') {

 		initThree(_name, where_datas.areas)
 		return _name;
 	} else if (i == 'state') {
 		var _nameval = '全部升级状态'
 		switch (_name * 1) {
 			case 1:
 				_nameval = '等待升级';
 				break;
 			case 2:
 				_nameval = '升级中';
 				break;
 			case 3:
 				_nameval = '升级完成';
 				break;

 		}
 		return _nameval;
 	} else if (i == 'devbrand_id') {
 		// console.log(where_datas)
 		for (var index = 0; index < where_datas.devbrand.length; index++) {
 			var item = where_datas.devbrand[index];
 			// console.log(item)
 			var BrandNo = $.trim(item.BrandNo);
 			if (BrandNo != "" && BrandNo == _name) {
 				initWater_goodsChange(_name)
 				return item.BrandName;
 			}
 		}
 		return _name;
 	} else if (i == 'devname_id') {
 		for (var index = 0; index < where_datas.devname.length; index++) {
 			var item = where_datas.devname[index];

 			var id = $.trim(item.id);
 			if (id != "" && id == _name) {
 				//      initWater_goodsChange(_name) 
 				return item.name;
 			}
 		}
 	} else if (i == 'customertype') {
 		var customertype = '全部用户类型'
 		switch (_name * 1) {
 			case 1:
 				customertype = '家庭';
 				break;
 			case 2:
 				customertype = '公司';
 				break;
 			case 3:
 				customertype = '集团';
 				break;
 			case 99:
 				customertype = '其他';
 				break;

 		}
 		return customertype;
 	} else if (i == 'devfactory_id') {
 		var _title = roleList_id(where_datas.devfactory, _name)
 		return _title;
 	} else if (i == 'investor_id') {
 		var _title = roleList_id(where_datas.investor, _name)
 		return _title;
 	} else if (i == 'agenty_id') {
 		var _title = roleList_id(where_datas.agenty, _name)
 		Agentflistp(_name)

 		return _title;
 	} else if (i == 'agentf_id') {

 		var _title = roleList_id(where_datas.agentf, _name)

 		return _title;
 	}
 	return _name;
 }
 var roleList_id = function(dataList, _name) {
 	// console.log(_name)
 	var poikl = ''
 	for (var i = 0; i < dataList.length; i++) {
 		var item = dataList[i];
 		var id = $.trim(item.Id);
 		if (id != "" && id == _name) {
 			// console.log(item.Name)
 			//      initWater_goodsChange(_name) 
 			poikl = item.Name
 			// return ;
 		}
 		// water_brandVal.append("<li  class='downLi' value='" + item.Id  + "'>" + item.Name  + "</li>").css('minWidth','150px');
 	}
 	return poikl;

 }



 dev_listdata(datas.dev_list)


 function dev_listdata(datas) {
 	if (datas.length) {

 		$("#dev_list_body").empty();
 		for (var i = 0; i < datas.length; i++) {
 			var item = datas[i];

 			for (var z in item) {
 				if (item[z] == null) {
 					item[z] = '-'
 				}
 			}
 			var CustomerType;
 			if (item.CustomerType == 1) {
 				CustomerType = '家庭'
 			} else if (item.CustomerType == 2) {
 				CustomerType = '公司'
 			} else if (item.CustomerType == 3) {
 				CustomerType = '集团'
 			} else {
 				CustomerType = '其他'
 			};
 			var IsUpgrade;
 			if (IsUpgrade) {
 				IsUpgrade = '允许'
 			} else {
 				IsUpgrade = '不允许'
 			}
 			var State;
 			if (State) {
 				State = '完成'
 			} else {
 				State = '未完成'
 			};


 			var html = '<tr>'
 			html += '<td > <input type="checkbox"  name="state" value="1"  id="state_' + i + '" class="state" / ><label for="state_' + i + '"></label></td>'

 			html += '<td><span>&nbsp;' + (i + 1) + '</span></td>'
 			html += '<td class="DevNo"><div>' + item.DevNo + '</div></td>'
 			html += '<td>' + item.HwNo + '</td>'
 			html += '<td>' + item.username + '</td>'
 			html += '<td>' + item.Tel + '</td>'
 			html += '<td class="oiuy">' + CustomerType + '</td>'
 			html += '<td>' + item.agentname + '</td>'
 			html += '<td>' + item.agentpname + '</td>'
 			html += '<td class="devname" dataId="' + item.goods_id + '">' + item.devname + '</td>'
 			html += '<td class="devbrand"  dataId="' + item.brand_id + '">' + item.devbrand + '</td>'
 			html += '<td class="devfactory">' + item.devfactory + '</td>'
 			html += '<td>' + item.investor + '</td>'
 			html += '<td>' + item.Province + '-' + item.City + '-' + item.Area + '</td>'
 			html += '<td>' + item.Address + '</td>'
 			html += '<td>' + item.UpgradeTime + '</td>'
 			html += '<td>' + item.Version + '</td>'
 			html += '<td >' + StateInit(item.IsUpgrade, item.State) + '</td>'
 			html += '<td><div class="promote" style="padding:5px;"><img src="/static/images3/Edition.png" alt=""></div></td>'
 			html += '</tr>';

 			$("#dev_list_body").append(html)
 		}
 	}
 }

 function StateInit(IsUpgrade, State) {


 	var res;
 	if (IsUpgrade == 0 && State == 0) {

 		res = '<span style="color:#E34F32">等待升级</span>'
 	}
 	if (IsUpgrade == 1 && State == 0) {
 		res = '<span style="color:#3DCCCD">升级中</span>'
 	}
 	if (IsUpgrade == 1 && State == 1) {
 		res = '<span style="color:#AB47BD">升级完成</span>'
 	} else {

 	}
 	return res;
 }

 var isCheckAll = false;

 function swapCheck() {
 	if (isCheckAll) {
 		$("input[type='checkbox']").each(function() {
 			this.checked = false;
 		});
 		isCheckAll = false;
 	} else {
 		$("input[type='checkbox']").each(function() {
 			this.checked = true;
 		});
 		isCheckAll = true;
 	}
 }


 //分页
 $("#page").paging({
 	pageNo: 1,
 	totalPage: Math.ceil(datasNum / 10),
 	totalLimit: 10,
 	totalSize: datasNum,
 	callback: function(num, nbsp) {
         // alert(nbsp)
   
 
 		var searchParameters = {
 			selecttime: datas.where.selecttime,
 			province: datas.where.province,
 			city: datas.where.city,
 			area: datas.where.area,

 			state: datas.where.state,
 			devbrand_id: datas.where.devbrand_id,
 			devname_id: datas.where.devname_id,

 			devfactory_id: datas.where.devfactory_id,
 			investor_id: datas.where.investor_id,
 			customertype: datas.where.customertype,
 			search: datas.where.search,
 			agentf_id:datas.where.agentf_id,
 			agenty_id:datas.where.agenty_id,

 			offset: num * nbsp - nbsp,
 			limit: nbsp
 		}



if(datasNum*1>0){

	Get_datas(searchParameters)
}
 		console.log(searchParameters)
 	}
 })



 function Get_datas(searchParameters) {

 	var ii = layer.open({
 		type: 1,
 		skin: 'layui-layer-demo', //样式类名
 		closeBtn: 0, //不显示关闭按钮
 		anim: 2,
 		shadeClose: false, //开启遮罩关闭
 		content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
 	});
 	$.post('./index.php?r=version-manage/dev-list', searchParameters, function(data) {
 		var data = eval('(' + data + ')');
 		 layer.close(ii);
 		 dev_listdata(data)
 	})
 };