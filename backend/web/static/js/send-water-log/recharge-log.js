// 时间选择
var selecttime=[ , ]
if(where_data.selecttime){
	 var  selecttime = where_data.selecttime.split("至");
}

var dateRange = new pickerDateRange('date_demo', {
	//aRecent7Days : 'aRecent7DaysDemo3', //最近7天
	isTodayValid: true,
	startDate :selecttime[0],
	endDate :selecttime[1],
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

$("#dCon_demo3").html('')
// console.log(where_data)
if (DevNo) {
	$("#DevNo").val(DevNo)
}


if (data.length) {
	dev_listdata(data,1)
}



//分页
$("#page").paging({
	pageNo: 1,
	totalPage: total / 10,
	totalLimit: 10,
	totalSize: total,
	callback: function(num, nbsp) {
		var opipu = {

            UserId: UserId,
            CustomerType:CustomerType,
       
            AgentId:AgentId,
			offset: num * nbsp - nbsp,
			limit: nbsp,
			selecttime: $("#selecttime1").val(),
			pay_type: $("#pay_type").attr('value') || ''
		}
		// console.log(opipu)
		Get_datas(opipu,num)
	}
});
function Get_datas(searchParameters,num) {
	var ii = layer.open({
		type: 1,
		skin: 'layui-layer-demo', //样式类名
		closeBtn: 0, //不显示关闭按钮
		anim: 2,
		shadeClose: false, //开启遮罩关闭
		content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
	});



	// http://localhost/index.php?r=send-water-log/recharge-log-page&CustomerType=2&UserId=1692cfd75efd470d9ebf201f9ce08e98&limit=10&offset=10&
			// console.log(searchParameters)
	$.get('index.php?r=send-water-log/recharge-log-page', searchParameters, function(data) {
		layer.close(ii);
	
		var data = eval('(' + data + ')');

		dev_listdata(data.data,num)

	})
};

function dev_listdata(dev_list,num) {
console.log(dev_list)
	$("#dev_list_body").empty();
	for (var i = 0; i < dev_list.length; i++) {
		var item = dev_list[i];
		var PayType = '全部充值方式';
		var d = item.PayType * 1;
		switch (d) {
			case 1:
				PayType = '现金';
				break;
			case 2:
				PayType = '微信';
				break;
			case 3:
				PayType = '支付宝';
				break;
				case 4:
				PayType = '转账';
				break;
			default:
				PayType = '空';
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
   
var OutOrIn='';
if(item.OutOrIn==-1){
OutOrIn='退出小组';
}else if(item.OutOrIn==1){
OutOrIn='加入小组';	
}else if(item.OutOrIn==2){
OutOrIn='修改组长';	
}


console.log(item.OutOrIn)
 var Color='';
var RowTime = new Date(item.RowTime.replace("-", "/").replace("-", "/"));
if(Create>RowTime){
	Color="#76787b"
}
	var html = '<tr  style="background-color:'+Color+'">';
		 // ((num-1)*10 + i+1)*1
		html += '<td >' + (i+1) + '</td>'
		html += '  <td >' + item.Name + '</td>'
		html += '  <td >' + item.Tel + '</td>'
		html += '  <td >' + CustomerTypeName + '</td>'
		html += '  <td >' + PayType+'</td>'
        if(OutOrIn){
        	html += '  <td >' + item.GroupMemberName+OutOrIn +'</td>'	
        }else{
        		html += '  <td >无</td>'
        }
	

		html += '  <td >' + item.PayMoney +'</td>'
		html += '  <td >' + item.RestMoney + '</td>'
		html += '  <td >' + item.RowTime + '</td>'
		html += '</tr>'
		$("#dev_list_body").append(html);
	}
};


$(document).on('click', '.dropdown-menu li', function() {
		var _thisval = $(this).attr('value');

		var _thisvalText = $(this).text();
		var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();

		// if(_thisval!=_toggleval){
		$(this).siblings().css({
			'backgroundColor': 'transparent',
			'color': '#000'
		});
		$(this).css({
			'backgroundColor': '#E46045',
			'color': 'rgb(233,233,233)'
		});

		$(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvalText + '&nbsp;&nbsp;&nbsp;<span class="caret"></span>');
		$(this).parent().siblings(".toggle-input").val(_thisval);

		// }
	})
	.on('click', '#removerSub', function() {

		
		$("#pay_type").attr('value', '').html('全部充值方式&nbsp;<span class="caret"></span>').parent().siblings(".toggle-input").val('')
		$("#date_demo").text('');
		$("#selecttime1").text('');
		return false;
	})
.on('click','#submit',function(){
   		layer.open({
   		type: 1,
   		skin: 'layui-layer-demo', //样式类名
   		closeBtn: 0, //不显示关闭按钮
   		anim: 2,
   		shadeClose: false, //开启遮罩关闭
   		content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
   	});
   	})

if (where_data.pay_type) {
     
	var PayType = '全部充值方式';
	var d = where_data.pay_type * 1;
	switch (d) {
		case 1:
			PayType = '现金';
			break;
		case 2:
			PayType = '微信';
			break;
		case 3:
			PayType = '支付宝';
			break;
			case 4:
			PayType = '转账';
			break;
		default:
			PayType = '全部充值方式';
	}


	$("#pay_type").html(PayType + '&nbsp;<span class="caret"></span>').parents('.dropdown').children(".toggle-input").val(where_data.pay_type)

}
