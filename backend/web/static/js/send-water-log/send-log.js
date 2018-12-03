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
		// $("#dCon_demo3").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
		$("#selecttime1").val($("#date_demo").val());
	}
});
// console.log(DevNo)
// console.log(select_where)
// $("#DevNo").val(DevNo);

// alert(DevNo)
if (data) {
	dev_listdata(data,UserId,1)
	// console.log(UserId)
}

//分页
$("#page").paging({
	pageNo: 1,
	totalPage: total / 10,
	totalLimit: 10,
	totalSize: total,
	callback: function(num, nbsp) {
		// console.log(num*nbsp-nbsp)
		if (num <= 0) {
			return false;
		}
		var opipu = {
			UserId: UserId||'',
			CustomerType: CustomerType||'',
			AgentId: AgentId||'',
			offset: num * nbsp - nbsp,
			limit: nbsp,
			selecttime: select_where.selecttime || '',
			brand_id: select_where.brand_id||'',
			water_name: select_where.water_name || '',
			water_volume: select_where.water_volume || '',
			from: select_where.from || ''
		}


		// console.log(opipu)
		Get_datas(opipu,num)

	}
})


function Get_datas(searchParameters,num) {
	var ii = layer.open({
		type: 1,
		skin: 'layui-layer-demo', //样式类名
		closeBtn: 0, //不显示关闭按钮
		anim: 2,
			shade:  [0.5, '#393D49'],
		shadeClose: false, //开启遮罩关闭
		content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
	});
	$.post('index.php?r=send-water-log/send-log-page', searchParameters, function(data) {
		layer.close(ii);
		var data = eval('(' + data + ')');
		// console.log(data)

		if(data.state==-1){
			layer.msg(data.mas);
			return;
		}
		// dev_listdata(data.data)
		dev_listdata(data.data,UserId,num)
	})
};


	$(document).on('click', '#removerSub', function() {

		$(".toggle-input").val('')
		var dropdownLength = $('.dropdown').length;
		$("#date_demo").text('');
		
		$("#DevNo").val(DevNo * 1);
		return false;
	})


	.on('click', '#submit', function() {
	layer.open({
   		type: 1,
   		skin: 'layui-layer-demo', //样式类名
   		closeBtn: 0, //不显示关闭按钮
   		anim: 2,
   			shade:  [0.5, '#393D49'],
   		shadeClose: false, //开启遮罩关闭
   		content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
   	});


		// $("#DevNo").val(DevNo * 1);
		// var opi = $("#DevNo").val();
	})
	.on('click', '.RechargeRecord a', function() {
		var _this = $(this)


		var html = '<div class="popupa">' +
			'<div class="popup-text" style="padding:20px;"><span style="font-size:20px; color: rgb(233,233,233)"> 警告！确定要删除吗？</span></div>' +
			'<div class="butt pull-left" style="    margin-left: 60px;">' +
			'<button type="button"  class="Close" >取消</button>' +
			'</div>' +
			'<div  class="butt">' +
			'<button type="submit" class="confirm" style="background-color: #E46045" >确认</button>' +
			'</div>' +
			'</div>'
		var ppp = layer.open({
			type: 1,
			title: false,
			area: ['500px', '400px'],
			closeBtn: 0,
				shade:  [0.5, '#393D49'],
			shadeClose: true,
			// shade: false,
			skin: 'yourclass',
			content: html

		});

		$(".Close").click(function() {
			layer.close(ppp);
			// window.location.reload(); 	
		})
		$(".confirm").click(function() {
			// layer.close(ppp);
			// // location.href='/index.php?r=send-water-log/index';
				var itemId = _this.parent().siblings('.itemId').attr('datea');

				var UserId = _this.parent().siblings('.itemId').attr('data');
				var CustomerType = _this.parent().siblings('.itemId').attr('CustomerType');



			$.get('/index.php?r=send-water-log/del&UserId=' + UserId + '&id=' + itemId + '&CustomerType=' + CustomerType+'&AgentId='+AgentId, function(data) {
				var data = eval('(' + data + ')');
				// console.log(data)
				//   layer.msg(data.mas)
				window.location.reload();
			});
		})
	})

	.on('click', '.Equipment a', function() {
		var _this = $(this)
		var html = '<div class="popupa">' +
			'<div class="popup-text" style="padding:20px;"><img src="static/images3/caption2.png" alt=""><span style="font-size:15px; color: rgb(233,233,233)"> 点击已出单，状态将变为已完成，且不可修改，确定完成送水了吗？</span></div>' +
			'<div class="butt pull-left" style="    margin-left: 60px;">' +
			'<button type="button"  class="Close" >取消</button>' +
			'</div>' +
			'<div  class="butt">' +
			'<button type="submit" class="confirm" style="background-color: #E46045" >确认</button>' +
			'</div>' +
			'</div>'
		var ppp = layer.open({
			type: 1,
			title: false,
			area: ['500px', '400px'],
			closeBtn: 0,
			shadeClose: true,
				shade:  [0.5, '#393D49'],
			skin: 'yourclass',
			content: html

		});

		$(".Close").click(function() {
			layer.close(ppp);
			// window.location.reload(); 	
		})
		$(".confirm").click(function() {
			layer.close(ppp);
			location.href = '/index.php?r=send-water-log/index';
           
			var itemId = _this.parent().siblings('.itemId').attr('datea');
				var UserId = _this.parent().siblings('.itemId').attr('data');
				var CustomerType = _this.parent().siblings('.itemId').attr('CustomerType');

			$.get('/index.php?r=send-water-log/change-state&UserId=' + UserId + '&id=' + itemId + '&CustomerType=' + CustomerType+ '&AgentId='+AgentId, function(data) {
				var data = eval('(' + data + ')');
		
				// window.location.reload();
				// console.log(data)
				//  	if(data.state){
				// layer.msg(data.mas)
				//  }
			});
		})



	})
// 记录选项
if (select_where) {
	for (var i in select_where) {
		var item = select_where[i];
		if (item) {
			var form_input = $("form input").length;
			for (var y = 0; y < form_input; y++) {
				var formName = $("form input").eq(y).attr('name')

				if (formName == i) {
					//console.log(formName)

					$("form input").eq(y).val(item);
					$("form input").eq(y).parent().find(".dropdown-toggle").attr('value', item);
					var oppo = getAddressIdByName(item, i, select_where.brand_id, select_where.water_name)
					$("form input").eq(y).parent().find(".dropdown-toggle").html(oppo + '&nbsp;&nbsp;&nbsp;<span class="caret"></span>');
				}
			}
		}
	}
}

function getAddressIdByName(_name, i, brand_id, water_name) {
	// console.log(i)
	_name = $.trim(_name);
	if (_name == "" || _name == 0) {
		return '请选择';
	}
	if (i == 'brand_id') {
		initWater_goodsChange(_name);
		for (var index = 0; index < where_data.water_brand.length; index++) {
			var item = where_data.water_brand[index];
			var name = $.trim(item.BrandNo);
			if (name != "" && name == _name) {
				return item.BrandName;
			}
		}
	} else if (i == 'water_name') {

		initWater_volume_Change(brand_id, water_name);

		for (var index = 0; index < where_data.water_goods.length; index++) {
			var item = where_data.water_goods[index];
			var name = $.trim(item.name);
			if (name != "" && name == _name) {
				return item.name;
			}
		}
	} else if (i == 'water_volume') {
		return _name;
	} else if (i == 'selecttime') {


		$("#date_demo").text(_name);
		return _name;
	} else if (i == 'from') {
		// console.log(_name);
		var _nameval = '客户';

		switch (_name * 1) {
			case 1:
				_nameval = '客户';
				break;
			case 2:
				_nameval = '服务中心';
				break;
			case 3:
				_nameval = '太极兵';
				break;

		}
		return _nameval;
	}
	return '请选择';
}


function dev_listdata(dev_list,UserId,num) {
	 console.log(dev_list)
	$("#dev_list_body").empty();
	for (var i = 0; i < dev_list.length; i++) {
		var item = dev_list[i];
		var _From = '';
		switch (item.From * 1) {
			case 1:
				_From = '客户';
				break;
			case 2:
				_From = '服务中心';
				break;
			case 3:
				_From = '太极兵';
				break;
			default:
				_From = '空';
		}

var onject = $.parseJSON( AgentId )

 var Color='';


var RowTimeOp = item.RowTime.replace("-","/")

console.log(RowTimeOp)
var RowTime = new Date(item.RowTime.replace("-", "/").replace("-", "/"));


if(Create>RowTime){
	Color="#76787b"
}
//  if(item.RowTime)
	var Equipment = '——';
		var EquipmentURL = '<a href="javascript:void(0)">';
		var EquipmentURLA = '</a>';

		var giveRecordURL = '<a href="/index.php?r=send-water-log/send-water&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&id='+item.id + '&AgentId='+onject+'">';
		var RechargeRecordURL = ' <a href="javascript:void(0)">';
		if (item.State == 1) {
			Equipment = '已配送';
			// EquipmentURL ='/index.php?r=send-water-log/send-log&DevNo='+item.DevNo+''; 

		} else {

			Equipment = '已完成';
			var EquipmentURL = '';
			var EquipmentURLA = '';
			var giveRecordURL = "";
			var RechargeRecordURL = "";

		}

           var CustomerTypeName = '';
	if (item.CustomerType == 1) {
   				CustomerTypeName = '家庭'
   			} else if (item.CustomerType == 2) {
   				CustomerTypeName = '公司'
   			} else if (item.CustomerType == 3) {
   				CustomerTypeName = '集团'
   			} else {
   				CustomerTypeName = '其他'
   			}

	      for (var z in item) {
   				if (item[z] == null) {
   					item[z] = '——'
   				}
   			}



		var html = '<tr class="item" style="background-color:'+Color+'">'
		 // ((num-1)*10 + i+1)*1
		html += '<td >' +( i+1 )+ '</td>'
		html += '  <td >' + item.Name + '</td>'
		html += '  <td >' + item.Tel + '</td>'
		html += '  <td >' + CustomerTypeName+ '</td>'
		html += '  <td >' + _From + '</td>'
		html += '  <td >' + item.goodsName + '</td>'
		html += '  <td >' + item.BrandName + '</td>'
		html += '  <td >' + item.Volume + '</td>'
		html += '  <td >' + item.Amount + '</td>'
		html += '  <td >' + item.Price + '</td>'
		html += '  <td >' + item.UseMoney + '</td>'
		html += '  <td >' + item.RestMoney + '</td>'
		html += '  <td >' + item.SendTime + '</td>'
		html += '  <td >' + item.FinishTime + '</td>'

		html += '  <td  class="itemId" datea = ' + item.id + ' CustomerType ="'+item.CustomerType+'"  data="'+item.UserId+'"></td>'


		html += '<td class="ShareBtn Equipment">' + EquipmentURL + '<div class="Ingp" CustomerType ="'+item.CustomerType+'"  data="'+item.UserId+'"><p>' + Equipment + '</p></div>' + EquipmentURLA + '</td>'
		// html += ' <td class="ShareBtn giveRecord" >' + giveRecordURL + '<div class="Ing">	<img src="/static/images3/modify.png" ></div>' + EquipmentURLA + '</td>'
		html += '<td class="ShareBtn RechargeRecord" > ' + RechargeRecordURL + '<div class="Ing">	<img src="/static/images3/delete.png" ></div>' + EquipmentURLA + '</td>'
		html += '</tr>'




		$("#dev_list_body").append(html);

	}
}