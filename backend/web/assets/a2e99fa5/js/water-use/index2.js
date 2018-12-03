  // 接收值


  $(function() {



  	// 时间选择
  	var dateRange = new pickerDateRange('date_demo', {
  		//aRecent7Days : 'aRecent7DaysDemo3', //最近7天
  		isTodayValid: true,
  		startDate: '',
  		endDate: '',
  		//needCompare : true,
  		//isSingleDay : true,
  		//shortOpr : true,
  		//autoSubmit : true,
  		defaultText: ' 至 ',
  		inputTrigger: 'input_trigger_demo',
  		theme: 'ta',
  		success: function(obj) {
  			$("#dCon_demo").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
  			$("#time1sub").val(obj.startDate)
  			$("#time2sub").val(obj.endDate)

  			$('.selection-time .activer').removeClass('activer');
  			// $("#date_demo").text(where_datas.time1);
  		}


  	});

  	if (where_datas.time1) {

  		if (where_datas.time1.length > 9) {


  			$(".selection-time .activer").removeClass('activer');
  			var _timeval = where_datas.time1 + '到' + where_datas.time2;

  			$("#date_demo").text(_timeval)

  		} else {
  			$("#date_demo").text('选择时间段')
  			$(".selection-time .activer").removeClass('activer');
  			$(".selection-time li").eq(where_datas.time1 - 1).addClass('activer');
  		}
  	}



  	$(document).on('click', '.dataUlLI li', function() {
  			$('.activer').removeClass('activer');
  			$(this).addClass('activer');
  			$('.dataUlLI li p').css('borderRight', "1px #000 solid");
  			$(".dataUlLI li:last-of-type p").css('borderRight', "0px #000 solid");
  			$(this).prev().find('p').css('border', "none");
  			$(this).find('p').css('border', "none");

  			$("#time1sub").val($(this).val())
  			$("#time2sub").val('')
  			$("#date_demo").text('请选择时间段')
  		})
  		.on('click', '.address .dropdown-menu li', function() {
  			var _thisval = $(this).attr('value');

  			var _thisvalt;
  			if (_thisval == ' ' || !_thisval || _thisval == 0) {
  				_thisvalt = '请选择';
  			} else {
  				_thisvalt = _thisval;
  			}
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
  				$(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvalt + '&nbsp;<span class="caret"></span>');
  				$(this).parent().siblings(".toggle-input").val(_thisval)
  			}
  		})
  		.on('click', '.condition .dropdown-menu li,.shoPpage .dropdown-menu li', function() {
  			var _thisval = $(this).attr('value');

  			var _thisvaltxt = $(this).text();
  			var _toggleval = $(this).parent().siblings(".toggle-input").val();
  			if (_thisval != _toggleval) {
  				$(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvaltxt + '&nbsp;<span class="caret"></span>');
  				$(this).parent().siblings(".toggle-input").val(_thisval)
  			}
  		})
  		.on('click', '#removerSub', function() {

  			$(".toggle-input").val('')
  			var dropdownLength = $('.dropdown').length;
  			$("#date_demo").text('');

  			$("#time1sub").val('')
  			$("#time2sub").val('')
  			$("#searchp").val('');

  			for (var i = 0; i < dropdownLength; i++) {
  				var dropLi = $('.dropdown li:first-of-type').eq(i).text();
  				var dropLival = $('.dropdown li:first-of-type').eq(i).val();

  				// console.log(dropLival)
  				$('.dropdown button').eq(i).text(dropLi);
              $('.dropdown button').eq(i).html(dropLi+'&nbsp;<span class="caret"></span>');
  				$('.dropdown .toggle-input').eq(i).val('');
  			}


  			return false;
  		})
  		.on('click', '.data-view', function() {
  			$('#dataView').css('display', 'block')
  		})
  		.on('click', '#Close', function() {
  			$('#dataView').css('display', 'none')
  		})
  		.on('click', '#Refresh,.data-refresh', function() {
  			PieChartRendering()
  			$('#dataView').css('display', 'none')
  		})
  		.on('click', '#submit', function() {
  			layer.open({
  				type: 1,
  				skin: 'layui-layer-demo', //样式类名
  				closeBtn: 0, //不显示关闭按钮
  				anim: 2,
  				shadeClose: false, //开启遮罩关闭
  				content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  			});
  		})

  })
  // 地址渲染
  initProvince();
  // 角色渲染
  roleList(agenty, $('#Agenty'));
  //roleList(agentf, $('#Agentf'));
  roleList(devfactory, $('#devfactory'));
  roleList(investor, $('#investor'));
  // 商品渲染
  water_brand_list(devbrand, devname, $("#devbrand"), $("#devname"))
  // 运营中心与服务中心关联渲染

  use_type_list(use_type)

  Agentflist()
  salesVolume()

  mapRendering()
  PieChartRendering()

  initAddress()

  _hover($(".volumeHover"), $(".volumeHover-text"))
  _hover($(".compareHover"), $(".compareHover-text"))
  _hover($(".AverageHover"), $(".AverageHover-text"))
  _hover($(".pageHover"), $(".pageHover-text"))
  //伪类
  function _hover(Class, ClassText) {
  	Class.hover(function() {
  		ClassText.css("display", "block");

  		Class.css("background", "url(/static/images3/volumeHover2.png) no-repeat");
  	}, function() {
  		ClassText.css("display", "none");
  		Class.css("background", "url(/static/images3/volumeHover1.png) no-repeat");
  	});
  }
  // console.log(datas2)


  FoldLineDiagramCalculation()


function use_type_list(use_type){
   if(use_type.length){

    var use_typeVal = $("#usetype").parents('.dropdown').children(".dropdown-menu");
     use_typeVal.children().not(":first").remove()
     for(var i=0;i<use_type.length;i++){
      var item = use_type[i];
       use_typeVal.append("<li  class='downLi' value='" + item.use_type + "'>" + item.use_type + "</li>");
     }
  }
}







  function initAddress() {
  	if (where_datas) {
  		// 		// 记录选项
  		var select_where = where_datas;
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
  	}
  var _Agentyval = $("#Agenty").attr('value');
  var _Agentfval = $("#Agentf").attr('value')||'';
  

    if(_Agentyval){
        $.get('index.php?r=water-use/get-use-type',{'agenty_id':_Agentyval,'agentf_id':_Agentfval}, function(data) {
          var data =JSON.parse(data)
            console.log(data)
              use_type_list(data.datas)
        })

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
  	} else if (i == 'agenty_id') {
  		// console.log(agenty)
  		var _title = roleList_id(agenty, _name)
  		Agentflistp(_name)

  		return _title;
  	} else if (i == 'agentf_id') {

  		var _title = roleList_id(agentf, _name)
  		return _title;
  	} else if (i == 'devfactory_id') {
  		var _title = roleList_id(devfactory, _name)
  		return _title;
  	} else if (i == 'investor_id') {
  		var _title = roleList_id(investor, _name)
  		return _title;
  	} else if (i == 'devbrand_id') {
  		// 	console.log(where_datas)
  		for (var index = 0; index < devbrand.length; index++) {
  			var item = devbrand[index];
  			// 		// console.log(item)
  			var BrandNo = $.trim(item.BrandNo);
  			if (BrandNo != "" && BrandNo == _name) {
  				initWater_goodsChange(_name)
  				return item.BrandName;
  			}
  		}
  		return _name;
  	} else if (i == 'devname_id') {
  		for (var index = 0; index < devname.length; index++) {
  			var item = devname[index];
  			var id = $.trim(item.id);
  			if (id != "" && id == _name) {
  				//      initWater_goodsChange(_name) 
  				return item.name;
  			}
  		}
  	}  

  else if (i == 'usetype') {
    var usetypetitle = _name
    switch (_name * 1) {
      case 0:
        usetypetitle = '全部用户类型';
        break;
    }
    return usetypetitle;
  }



   //  else if (i == 'usetype') {
  	// 	var usetypetitle = '全部用户类型'
  	// 	switch (_name * 1) {
  	// 		case 1:
  	// 			usetypetitle = '自购';
  	// 			break;
  	// 		case 2:
  	// 			usetypetitle = '押金';
  	// 			break;
  	// 		case 3:
  	// 			usetypetitle = '买水送机';
  	// 			break;
  	// 		case 4:
  	// 			usetypetitle = '买机送水';
  	// 			break;
  	// 		case 5:
  	// 			usetypetitle = '免费';
  	// 			break;
  	// 		case 99:
  	// 			usetypetitle = '其他';
  	// 			break;
  	// 		default:
  	// 			usetypetitle = '全部用户类型'

  	// 	}
  	// 	return usetypetitle;
  	// } 
    else if (i == 'customertype') {
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
  			default:
  				usetypetitle = '全部用户类型'
  		}
  		return customertype;
  	}

  	return _name;
  }


  function roleList_id(dataList, _name) {
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



  // 角色渲染方法
  function roleList(dataList, $id) {

  	var water_brandVal = $id.parents('.dropdown').children(".dropdown-menu");
  	water_brandVal.children().not(":first").remove()
  	if (dataList) {

  		for (var i = 0; i < dataList.length; i++) {
  			var item = dataList[i];
  			water_brandVal.append("<li  class='downLi' value='" + item.Id + "'>" + item.Name + "</li>").css('minWidth', '150px');
  		}
  	}
  }

  function Agentflist() {
  	$("#Agenty").parents('.dropdown').children(".dropdown-menu").children().click(function() {
  		var _thisval = $(this).attr('value');
      $("#Agentf").html('请选择服务中心&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
  		$("#usetype").html('入网属性&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
  		Agentflistp(_thisval)
  		

    $.get('index.php?r=sales-volume/get-use-type',{'agenty_id':_thisval}, function(data) {
      /*optional stuff to do after success */
      var data =JSON.parse(data)
        console.log(data)
         use_type_list(data.datas)
    });

  	})
  }

  function Agentflistp(_thisval) {
  	var water_brandVal = $("#Agentf").parents('.dropdown').children(".dropdown-menu")
  	water_brandVal.children().not(":first").remove();
  	for (var i = 0; i < agentf.length; i++) {
  		var item = agentf[i];
  		item.ParentId
  		if (_thisval == item.ParentId) {
  			water_brandVal.append("<li  class='downLi' value='" + item.Id + "'>" + item.Name + "</li>").css('minWidth', '150px');
  		}

  	}

    $("#Agentf").parents('.dropdown').children(".dropdown-menu").children().click(function() {
      $("#usetype").html('入网属性&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
    var _thisval = $(this).attr('value');
    var _Agentyval = $("#Agenty").attr('value');
    if(_thisval){
        $.get('index.php?r=water-use/get-use-type',{'agenty_id':_Agentyval,'agentf_id':_thisval}, function(data) {
          var data =JSON.parse(data)
            console.log(data)
              use_type_list(data.datas)
        })

    }
})
  }


  // 品牌后渲染方法
  function water_brand_list(devbrand, devname, $id, $goodsid) {
  	if (devbrand) {
  		var water_brandVal = $id.parents('.dropdown').children(".dropdown-menu")
  		water_brandVal.children().not(":first").remove()
  		$("#water_goods").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
  		for (var i = 0; i < devbrand.length; i++) {
  			var item = devbrand[i];
  			// console.log(item)
  			water_brandVal.append("<li  class='downLi' value=" + item.BrandNo + ">" + item.BrandName + "</li>").css('minWidth', '200px');
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

  	// var devname = where_datas.devname;
  	// console.log(devname)
  	if (devname) {

  		var water_brandVal = $("#devname").parents('.dropdown').children(".dropdown-menu");
  		water_brandVal.children().not(":first").remove()
  		for (var i = 0; i < devname.length; i++) {
  			var item = devname[i];

  			if (item.brand_id == _thisval) {
  				// console.log(item)

  				water_brandVal.append("<li  class='downLi' value='" + item.id + "'>" + item.name + "</li>").css('minWidth', '150px');
  			}
  		}
  	}
  }



  // 省渲染
  function initProvince() {
  	// $('#province option').not(":first").remove(); 
  	var provinceVal = $("#province").parents('.dropdown').children(".dropdown-menu")
  	provinceVal.children().not(":first").remove()
  	for (var index = 0; index < areas.length; index++) {
  		var item = areas[index];
  		// console.log(item)
  		if (item.PId == 0) {
  			provinceVal.append("<li value='" + item.Name + "'>" + item.Name + "</li>");
  		}
  	}
  }
  // 选择省后渲染市
  $("#province").parents('.dropdown').children(".dropdown-menu").children().click(function() {

  	var _thisval = $(this).attr('value');

  	$("#city").html('请选择市&nbsp;<span class="caret"></span>').attr("value", '').parent().find(".toggle-input").val('0');
  	$("#area").html('请选择区&nbsp;<span class="caret"></span>').attr("value", '').parent().find(".toggle-input").val('0');
  	var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
  	var _togglevalooo = $("#city").parent().find(".toggle-input").val();

  	if (_thisval != _toggleval) {
  		initCityOnProvinceChange(_thisval)
  	}
  	// 选择市后渲染区
  	$("#city").parents('.dropdown').children(".dropdown-menu").children().click(function() {
  		var _thisval = $(this).attr('value');
  		$("#area").html('请选择&nbsp;<span class="caret"></span>').attr("value", '').parent().siblings(".toggle-input").val('');
  		var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
  		if (_thisval != _toggleval) {
  			initThree(_thisval)
  		}
  	})
  })

  // 选择省后渲染区的方法
  function initCityOnProvinceChange(_thisval) {
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
  			pcityVal.append("<li value='" + item.Name + "'>" + item.Name + "</li>");
  		}
  	}
  }

  function initThree(_thisval) {
  	var pid = getAddressIdByName(_thisval);

  	var areaVal = $("#area").parents('.dropdown').children(".dropdown-menu")
  	areaVal.children().not(":first").remove();
  	if (pid == 0) {
  		return;
  	}
  	for (var index = 0; index < areas.length; index++) {
  		var item = areas[index];
  		if (item.PId != 0 && item.PId == pid) {
  			areaVal.append("<li value='" + item.Name + "'>" + item.Name + "</li>");
  		}
  	}
  }
  // 获取id比较
  function getAddressIdByName(_name) {
  	_name = $.trim(_name);
  	if (_name == "") {
  		return 0;
  	}
  	for (var index = 0; index < areas.length; index++) {
  		var item = areas[index];
  		var name = $.trim(item.Name);
  		if (name != "" && name == _name) {

  			return item.Id;
  		}
  	}
  	return;
  }

  // 同期
  function salesVolume() {
  	if (!datas2[0]) {
  		return;
  	}



 var use_totalA=datas2[0].use_total;
 //(use_totalA >0) ? use_totalA=use_totalA : use_totalA=0;








  	$("#sales1").text(use_totalA);

  	var sales2Val = Percentage3(datas2[0].same_time_total, datas2[0].use_total);

  	if (sales2Val < 0) {
  		$("#sales2").text(sales2Val + "%")
  		$("#sales2").append('&nbsp;<img src="/static/images3/Arrowb.png" alt="">')
  	} else if (sales2Val > 0) {
  		$("#sales2").text(sales2Val + "%")
  		$("#sales2").append('&nbsp;<img src="/static/images3/arrowA.png" alt="">')
  	} else {
  		$("#sales2").text('持平')
  		$("#sales2").append('&nbsp;<img src="/static/images3/rectangle.png" alt="">')
  	}
  	$("#user_num").text(datas2[0].user_num);

  	$("#sales_of").text(Percentage2(datas2[0].use_total, datas2[0].user_num));


  	$("#sales_of_year").text(datas2[0].year_use)

  }


  function Percentage2(number1, number2) {
  	if (number2 == 0) {
  		number2 = 1
  	}
  	return (Math.round((number1 / number2) * 10000) / 10000); // 小数点后两位百分比
  }

  function Percentage3(number1, number2) {
    var numberPercentage3='';
  	if (number2 <= 0) {
  		   number2 = 1
  	}
  if(number2>0){
    numberPercentage3=Math.round((number1 / number2) * 10000) / 100
    return numberPercentage3; // 小数点后两位百分比
  }

  	return 0 // 小数点后两位百分比
  }


  function Percentage4(number1, number2) {
  	if (number2 == 0) {
  		number2 = 1
  	}
  	return (Math.round((number1 - number2) * 10000) / 100.00); // 小数点后两位百分比
  }

  function FoldLineDiagramCalculation() {
  	var use_statusdata = datas2[0].use_status;
  	 // console.log(datas2)
  	var _date = []
  	var xin = 7;


  	if (where_datas.time2 != 0 && where_datas.time2 && where_datas.time2 != null && where_datas.time2 != '') {
  		var use_statusXin = diy_time(where_datas.time1, where_datas.time2) + 1;
  		xin = use_statusXin

  	} else {
  		// 今天昨天渲染
  		if (where_datas.time1 == 1) {
  			// alert(1)
  			xin = 1;
  			// _date = [timedatae]
  		} else if (where_datas.time1 == 2) {
  			xin = 1

  		} else if (where_datas.time1 == 3) {


  			xin = 7
  		} else if (where_datas.time1 == 4) {
  			xin = 30
  		} else if (where_datas.time1 == 5) {
  			xin = 90
  		} else if (where_datas.time1 == null) {
  			xin = 7
  			lop = 0;
  		}
  	}

  	var lop = 0;
  	var timedatae = GetDateStr(0, 1)
  	if (where_datas.time2 && where_datas.time2 != null && where_datas.time2 != '') {
  		lop = diy_time(where_datas.time2, timedatae) - 1

  	}



  	var darax = NumberDays(xin, _date, lop)



  	var daray = [];


  	if (darax.length <= 2) {
  		var itmesum = []
  		for (var i = 0; i < use_statusdata.length; i++) {
  			var itme = use_statusdata[i].ActTime;
  			var itmesumTer = itme.split(" ")[1]
  			itmesum.push(itmesumTer.replace(':', '.'))
  		}
  		var daraxp = []
  		var daraxpdata = [];
  		var daraxpdataL = []
  		var ppp = 0
  		for (var i = 0; i < 25; i++) {
  			var date = (i) + ":00"
  			daraxp.push(date)
  			daraxpdata.push("0")
  			daraxpdataL.push("0")
  			for (var y = 0; y < itmesum.length; y++) {
  				var _itmesum = itmesum[y].split(".")[0]

  				if (_itmesum == i) {
  					daraxpdata[i]++
  						daraxpdataL[i] = Math.round((daraxpdataL[i] * 1 + ((use_statusdata[y].WaterUse>0)? use_statusdata[y].WaterUse:0) * 1) * 100000) / 100000

  				}
  			}
  		}
  		darax = daraxp
  		daray = daraxpdataL

  	} else {

  		for (var i = 0; i < darax.length; i++) {
  			daray.push(0)

  			var daraxDate = Date.parse(darax[i]);
  			for (var j = 0; j < use_statusdata.length; j++) {
  				var nowDate = Date.parse(use_statusdata[j].ActDate);
  				if (daraxDate == nowDate) {
  				  	daray[i] = Math.round((daray[i] * 1 + ((use_statusdata[j].WaterUse>0)?use_statusdata[j].WaterUse:0) * 1) * 100000) / 100000
  				}
  			}
  		}
  	}

  	// console.log(daray)

  	FoldLineDiagram(darax, daray, '用水量')
  }



  function diy_time(time1num, time2num) {
  	time1data = Date.parse(new Date(time1num));
  	time2data = Date.parse(new Date(time2num));
  	return time3 = Math.abs(parseInt((time2data - time1data) / 1000 / 3600 / 24)) + 1;
  }



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
  }

  function NumberDays(xin, _date, _datenume) {

  	var xin = xin || 7
  	var _datenume = _datenume || 0;
  	for (var i = -_datenume; i > -(xin + _datenume-1); i--) {
  		// console.log(i)
  		_date.push(GetDateStr(i, 1))
  	}
  	_date.reverse();
  	return _date;
  }



  // 地图
  function mapRendering() {

  	var map_datas = datas2[0].map_datas;
  	var mapProvince = [];
  	var mapCity = [];
  	var mapArea = [];
  	for (var j = 0; j < map_datas.length; j++) {
  		mapProvince.push(map_datas[j].Province);
  		mapCity.push(map_datas[j].City);
  		mapArea.push(map_datas[j].Area);

  	};

  	// console.log(mapCity)
  	var mapProvinceUnique = unique(mapProvince);
  	var mapCityUnique = unique(mapCity);
  	var mapAreaUnique = unique(mapArea);

  	var mapProvinceNUm = [];
  	var mapCityNUm = [];
  	var mapAreaNUm = [];
  	var mapProvinceNUm = mapNumll(mapProvinceUnique, mapProvinceNUm, mapProvince);
  	var mapCityNUm = mapNumll(mapCityUnique, mapCityNUm, mapCity);
  	var mapAreaNUm = mapNumll(mapAreaUnique, mapAreaNUm, mapArea);
  	$("#percentum").empty();
//console.log(map_datas)
  	var mapProvinceBar = []
  	var mapCityBar = []
  	for (var j = 0; j < mapCityUnique.length; j++) {
  		if (mapCityUnique[j] == null) {
  			mapCityUnique[j] = '其它'
  		}
  		mapCityBar.push(Math.round(mapCityNUm[j] / map_datas.length * 100))
  	}
  	var mapProvinceL = [];
  	var mapCityL = [];
  	var mapAreaL = [];
  	// 县的用水量

  	for (var i = 0; i < mapProvinceUnique.length; i++) {
  		mapProvinceL.push({
  			'key': '0',
  			'value': 0
  		})
  		for (var j = 0; j < map_datas.length; j++) {
  			if (map_datas[j] == null || map_datas[j] == '') {
  				map_datas[j] = 0
  			}
  			var mapProvinceLnum = map_datas[j].total_volume - map_datas[j].WaterRest
  			    mapProvinceLnum =  (mapProvinceLnum>0)?mapProvinceLnum:0;
  			if (mapProvinceUnique[i] == map_datas[j].Province) {
  				mapProvinceL[i].value = mapProvinceL[i].value + mapProvinceLnum;
  				mapProvinceL[i].key = mapProvinceUnique[i];
  			}

  		}
  	};

  	function mapProvinceLBar(mapceL) {
  		var mapLBartotal = 0;
  		for (var i = 0; i < mapceL.length; i++) {
  			mapLBartotal = mapLBartotal + mapceL[i].value
  		}
  		return mapLBartotal;
  	}
  	// 市的用水量
  	for (var i = 0; i < mapCityUnique.length; i++) {
  		mapCityL.push({
  			'key': '0',
  			'value': 0,
  			'Province': ''
  		})
  		for (var j = 0; j < map_datas.length; j++) {
  			if (map_datas[j] == null || map_datas[j] == '') {
  				map_datas[j] = 0
  			}
  			
  			var mapCityLnum = map_datas[j].total_volume - map_datas[j].WaterRest;

  				mapCityLnum = (mapCityLnum>0)?mapCityLnum:0;



  			var mapCityLnumname = map_datas[j].Province
  			if (mapCityUnique[i] == map_datas[j].City) {
  				mapCityL[i].value = mapCityL[i].value + mapCityLnum;
  				mapCityL[i].key = mapCityUnique[i];
  				mapCityL[i].Province = mapCityLnumname;
  			}
  		}
  	};
  	var mapProvinceNump = mapProvinceLBar(mapProvinceL)
  	var mapCityLNump = mapProvinceLBar(mapCityL)

  	var mapProvinceLBaropi = [];
  	var mapCityLBaropi = [];

  	var mapProvinceNUmColor = ['#D29616', '#4ADCDD', '#C248DC', '#EA5638', '#D29717', '#4ADCDD', '#C248DC', '#EA5638', '#D29717', '#4ADCDD', '#C248DC', '#EA5638', '#D29717']
  	for (var i = 0; i < mapProvinceL.length; i++) {
  		mapProvinceLBaropi.push(Percentage3(mapProvinceL[i].value, mapProvinceNump))
  	}

  	for (var i = 0; i < mapCityL.length; i++) {
  		mapCityLBaropi.push(Percentage3(mapCityL[i].value, mapProvinceNump))
  	}

  	for (var j = 0; j < mapProvinceL.length; j++) {

  		if (mapProvinceUnique[j] == null) {
  			mapProvinceUnique[j] = '其它'
  		}
  		if (!mapProvinceNump) {
  			mapProvinceNump = 1
  		}


      var baifrnbi = Math.round((mapProvinceL[j].value / mapProvinceNump) * 10000) / 100 ;
      if(baifrnbi<0){
        baifrnbi=0;
      }else if(baifrnbi>100){
         baifrnbi=100;
      }

      
  		var html = '<div class="progress" style="height:10px;    background-color: #1d1f23;">' +
  			'<span class="name" style="margin-top:-5px;left: 25px;">' + mapProvinceL[j].key + '</span>' +
  			'<div class="progress-bar"   role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' +
  			Math.round((mapProvinceL[j].value / mapProvinceNump) * 10000) / 100 + '%; ' +
  			'background-color: ' + mapProvinceNUmColor[j] + '">' + '</div>' +
  			'<span class="baifenbi" style="color: #fff; position: absolute;  ' +
  			' right: 50px;right: 45px;margin-top: -5px;">' + baifrnbi+ '%' +
  			'</span> </div>';

  		$("#percentum").append(html);
  	}


  	mapmapRendering(mapProvinceL, mapCityL, mapProvinceNump, mapCityLNump, mapProvinceNUmColor)
  }



  function mapNumll(mapUnique, mapNUm, mapData) {

  	for (var j = 0; j < mapUnique.length; j++) {
  		mapNUm.push(0)
  		for (var i = 0; i < mapData.length; i++) {
  			if (mapUnique[j] == mapData[i]) {
  				mapNUm[j]++
  			}
  		}
  	}
  	return mapNUm;
  }



  // 饼图
  function PieChartRendering() {
  	// 饼状图渲染 
  	var map_datas = datas2[0].map_datas;
//console.log(map_datas)

  	var CustomerType = [];
  	var CustomerTypeNum = [0, 0, 0, 0];
  	var CustomerTypeNumL = [];
  	var CustomerTypeDataNumL = 0;
  	for (var i = 0; i < map_datas.length; i++) {
  		CustomerType.push(map_datas[i].CustomerType)
  		// CustomerTypeNumL.push(map_datas[i].CustomerType)
  		// CustomerTypeDataNumL=CustomerTypeDataNumL+
  	}
  	var CustomerTypeunique = ['家庭', '公司', '集团', '其他']
  	// var CustomerTypeunique = unique(CustomerType);
  	var use_totalNUm = 0;
  	for (var i = 0; i < CustomerType.length; i++) {
              
  		var WaterRestA = ((map_datas[i].total_volume - map_datas[i].WaterRest)>0)?(map_datas[i].total_volume - map_datas[i].WaterRest):0;
  		use_totalNUm=use_totalNUm+WaterRestA;
  		if (CustomerType[i] == 1) {
  			CustomerTypeNum[0] = Percentage2(CustomerTypeNum[0] + WaterRestA, 1)
  		} else if (CustomerType[i] == 2) {
  			CustomerTypeNum[1] = Percentage2(CustomerTypeNum[1] + WaterRestA, 1)
  		} else if (CustomerType[i] == 3) {
  			CustomerTypeNum[2] = Percentage2(CustomerTypeNum[2] + WaterRestA, 1)
  		} else if (CustomerType[i] == 99) {
  			CustomerTypeNum[3] = Percentage2(CustomerTypeNum[3] + WaterRestA, 1)
  		}
  	}

     //   console.log(use_totalNUm)
  	for (var i = 0; i < CustomerTypeNum.length; i++) {
  		$("#dataView tbody tr td:nth-child(2)").eq(i + 1).text(CustomerTypeNum[i])


  		var num = Percentage3(CustomerTypeNum[i], use_totalNUm)


  		if (num) {
  			$(".baifenbiA .baifenbi").eq(i).text(num)
  		}
  	}
  	var $name = '用户类型用水量占比'


  	PieChart(CustomerTypeunique, CustomerTypeNum, $name)
  }

  function usetype(usetype) {
  	var res = ''


  for(var i=0;i<all_use_type.length;i++){
        var item = all_use_type[i];
        if(item.code==usetype){
              res = item.use_type;
        }
    }
  	// if (usetype == 1) {
  	// 	res = "自购"
  	// } else if (usetype == 2) {
  	// 	res = "押金"
  	// } else if (usetype == 3) {
  	// 	res = "买水送机"
  	// } else if (usetype == 4) {
  	// 	res = "买水送机"
  	// } else if (usetype == 3) {
  	// 	res = "买机送水"
  	// } else if (usetype == 5) {
  	// 	res = "免费"
  	// } else if (usetype == 99) {
  	// 	res = "其他"
  	// }
  	return res;
  }


  function customertype(usetype) {
  	var res = ''
  	if (usetype == 1) {
  		res = "家庭"
  	} else if (usetype == 2) {
  		res = "公司"
  	} else if (usetype == 3) {
  		res = "集团"
  	} else if (usetype == 99) {
  		res = "其他"
  	} else {
  		res = ''
  	}

  	return res;
  }


  // 表格渲染


  var sales_detail = datas2[0].sales_detail;
  dev_listdata(sales_detail)



  $("#page").paging({
  	pageNo: 1,
  	totalPage: Math.ceil(datas2[0].total / 10),
  	totalLimit: 10,
  	totalSize: datas2[0].total,
  	callback: function(num, nbsp) {

  		var searchParameters = {
  			agentf_id: where_datas.agentf_id,
  			agenty_id: where_datas.agenty_id,
  			area: where_datas.area,
  			city: where_datas.city,

  			customertype: where_datas.customertype,
  			devbrand_id: where_datas.devbrand_id,
  			devfactory_id: where_datas.devfactory_id,
  			devname_id: where_datas.devname_id,
  			investor_id: where_datas.investor_id,
  			province: where_datas.province,
  			search: where_datas.search,
  			time1: where_datas.time1,
  			time2: where_datas.time2,
  			usetype: where_datas.usetype,
        



  			offset: num * nbsp - nbsp,
  			limit: nbsp
  		}


  		// console.log(searchParameters)

  		Get_datas(searchParameters)
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
  	$.post("./index.php?r=water-use/get-datas", searchParameters, function(data) {
  		var sales_detail = data[0].sales_detail
  		layer.close(ii);
  		$("#tableData").empty()
  		dev_listdata(sales_detail)
  	})
  }


  function dev_listdata(data) {
  	var j = 0;
  	for (var i = 0; i < data.length; i++) {
  		var item = data[i]
  		for (var z in item) {
  			if (item[z] == null) {
  				item[z] = '--'
  			}
  		}
  		j++
  		var UseType = usetype(item.UseType)
  		var CustomerType = customertype(item.CustomerType)
  		var WaterUse = 0;
  		if (item.WaterUse == '--') {
  			WaterUse == 0
  		} else {
  			WaterUse = Math.round(item.WaterUse * 100) / 100
  		}
  		var html = '<tr>'
  		html += '<td>' + j + '</td>'
  		html += '<td>' + item.UserName + '</td>'
  		html += '<td>' + item.Tel + '</td>'
  		html += '<td>' + item.DevNo + '</td>'
  		html += '<td>' + item.DevBrand + '</td>'
  		html += '<td>' + item.DevName + '</td>'
  		html += '<td>' + item.DevFactoryName + '</td>'
  		html += '<td>' + item.investor + '</td>'
  		html += '<td>' + item.AgentName + '</td>'
  		html += '<td>' + item.AgentPname + '</td>'
  		html += '<td>' + item.Province + '-' + item.City + '-' + item.Area + '</td>'
  		html += '<td>' + UseType + '</td>'
  		html += '<td>' + CustomerType + '</td>'
  		html += '<td>' + WaterUse + '</td>'
  		html += '</tr>'
  		$("#tableData").append(html);
  	}
  }