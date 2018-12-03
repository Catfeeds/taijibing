<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>酒店订单</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
		<link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
		<link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
		<link rel="stylesheet" href="./static/css/chosen.css"/>
		<link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
		<link rel="stylesheet" href="./static/css/sales-volume/index.css?v=1.1"/>
	<link rel="stylesheet" href="">
</head>
<style type="text/css" media="screen">
.wrap_line, .chosen-container-active.chosen-with-drop .chosen-single, .chosen-container-single .chosen-single{
	    background-color: #2D3136;
    border: none;
}
	#date_demo {
    width: 200px;
    height: 30px;
    line-height: 30px;
    line-height: 15px;
    background-color: #2D3136;
    border: none;
    display: inline-block;
}
.submitBtn button {
    background-color: #E46045;
}
.submitBtn button:hover{
	background-color: #E24727
}
.selection>span{
	width: 70px;
}
</style>
<body>
	<div id='hotelOrder' style="padding: 10px">
	<!--内容主题-->
	  <form action="./index.php?r=hotel-order/index" method="post" accept-charset="utf-8">
	  	   <div class='page-head' style='    padding: 35px;padding-bottom: 0;'>
	  	   		 <div class='head-txt'>
			 		<!-- 时间容器 -->
			 		<div class="selection pull-left">
						<span  class="selection-text  pull-left">时间段：</span>
						 <div class="ta_date" id="div_date_demo" style=" background-color: #2D3136;">
					        <span class="date_title" id="date_demo"></span>
					        <a class="opt_sel" id="input_trigger_demo" href="#">
					            <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
					        </a>
					    </div>
					    <input type="text" name="selecttime" id='selecttime1' value="" style="display: none">
					    <div id="datePicker"></div>
				   </div>
		 <!-- 地区容器 -->
					   <div class="selection pull-left" style="width:400px;margin-left: 5%;">
							 <span  class="selection-text  pull-left">地区选择：</span>
							 <div class="region pull-left address" >
							 	   <div class="wrap_line">
							 	        <select class="control-label" name="province"  id="province" class="province">
				                            <option value="" selected>请选择省</option>
						                </select>
						                <select class="control-label" name="city" id="city"  class="city">
						                     <option value="">请选择市</option>
						                </select>
						                <select class="control-label" name="area" id="area"  class="area">
						                  <option value="">请选择区</option>
						                </select>
							 	   </div>
							 </div>

					   </div>
			 	</div>
	            <!-- 商品选择 -->
			       <div class='head-txt'>
			            <div class="selection pull-left">
			              <span  class="selection-text  pull-left">商品选择：</span>
			               <div class="region pull-left address role"  >
			             <div class="wrap_line">
			                        <select class="control-label" name="brand_id"  id="brand_id" class="brand_id">
			                                <option value="" selected>请选择商品品牌</option>
			                        </select>
			                        <select class="control-label" name="goods_id"  id="goods_id" class="goods_id">
			                                <option value="" selected>请选择商品型号</option>
			                        </select>
			             </div>
			           </div>
			             </div>
			       </div>


				<!-- 状态选择 -->
			       <div class='head-txt'>
			            <div class="selection pull-left">
			              <span  class="selection-text  pull-left">支付状态:</span>
			               <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                        <select class="control-label" name="pay_state"  id="pay_state" class="pay_state">
		                                <option value="" >请选择支付状态</option>
		                                <option value="1" selected >成功</option>
		                                <option value="0">失败</option>
		                        </select>
				             </div>
			           </div>
			          </div>
					 </div>
				   <div class='head-txt'>
 						<div class="selection pull-left">
				              <span  class="selection-text  pull-left">订单状态:</span>
				               <div class="region pull-left address role"  >
				             <div class="wrap_line">
				                        <select class="control-label" name="order_state"  id="order_state" class="order_state">
				                                <option value="">请选择订单状态</option>
				                                <option value="0">交易关闭</option>
				                                <option value="1" selected >交易成功</option>
				                                <option value="3" >退款成功</option>
				                                <option value="4" >退款失败</option>
				                              
				                        </select>
				                     <!--   <select class="control-label" name=""  id="" class="">
				                                <option value="" selected>全部用户</option>
				                        </select> -->
				             </div>
				           </div>
			             </div>
					 </div>
					   <div class='head-txt'>
			            <div class="selection pull-left">
				              <span  class="selection-text  pull-left">设备状态:</span>
				               <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                       <select class="control-label" name="dev_state"  id="dev_state" class="dev_state">
	                                <option value="" selected>全部设备</option>
	                                <option value="1" >正常设备</option>
	                                <option value="2" >已初始化设备</option>
		                        </select>
				             </div>
				           </div>
			             </div>
			       </div>
					<div class='head-txt'>
						   <!-- 搜索容器 -->
             <div class="selection pull-left" id="searchbg">
               <span  class="selection-text  pull-left">搜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;索：</span>
               <div class="region pull-left address" style='background-color: #2D3136;border-radius: 2px'>
                  <div class="wrap_line" style="    display: initial;">
                     <input style='border: none;' type="text" name="search"  id="searchp" value="" placeholder="请输入关键字">
                  </div>
              </div>
             </div>
             <div class="submitBtn"  style='display: inline-block; float: left;margin-left: 15%;' >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn " id="submit" >   查看</button>
                &nbsp;&nbsp;
                <button type="text"  class="btn " id="removerSub">清空条件</button>
                </div>
					</div>
	  	   </div>
	  </form>

	  		<div class='middle'  style="    margin-top: 20px;">
		   <table class="table" style=' border-spacing:0px 10px;' >
		   	<thead>
		   		<tr>
		   			<th>序号</th>
		   			<th>交易单号</th>
		   			<th>订单号</th>
		   			<th>设备编号</th>
		   			<th>二维码编号</th>
		   			<th>门牌号</th>
		   			<th>酒店中心</th>
		   			<th>联系电话</th>
		   			<th>所在区域</th>
		   			<th>地址</th>
		   			<th>购水容量</th>
		   			<th>购水金额</th>
		   			<th>商品品牌</th>
		   			<th>商品名称</th>
		   			<th>购水时间</th>
		   			<th>支付方式</th>
		   			<th>支付	状态</th>
		   			<th>订单状态</th>
		   			<th>购水时间</th>
		   			<th>操作</th>

		   		</tr>
		   	</thead>
		   	<tbody id="dev_list_body">
		   	<!-- 	<tr>
		   		  <td >1</td>
		   		  <td >208011125820180515101010</td>
		   		  <td >420000000102310203101410</td>
		   		  <td >9876543210</td>
		   		  <td >TCL0102J-0180500100</td>
		   		  <td >2011</td>
		   		  <td >太极兵酒店</td>
		   		  <td >12345678900</td>
		   		  <td >四川省-成都市-高新区</td>
		   		  <td >XX街道XX号，协信中心502</td>
		   		  <td >1</td>
		   		  <td >1</td>
		   		  <td >冰川时代</td>
		   		  <td >冰川时代</td>
		   		  <td >微信</td>
		   		  <td >成功</td>
		   		  <td >2017-8-22 ，16：30：30</td>
		   		  <td >退款</td>
		   		 </tr> -->
		   	</tbody>
		   </table>	
	</div>
<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
 <div id="page" class="page_div"></div>
</div>
</body>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>	
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>
<script type="text/javascript" src="/static/js/monthPicker.js"></script>
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>

<script>
	   var total = eval('(' + <?=json_encode($total)?> + ')');
	   var data = eval('(' + <?=json_encode($data)?> + ')');
	   var sort = eval('(' + <?=json_encode($sort)?> + ')');
	   var search_where = eval('(' + <?=json_encode($search_where)?> + ')');
	   var brands  =  <?=json_encode($brands)?> ;
	   var goods  = <?=json_encode($goods)?> ;

	    var address = <?=json_encode($address)?>;


   // var address = eval('(' + address + ')');

	for(i in search_where){
		
		if(search_where[i]==null){
			search_where[i]='';
		}
	}
// console.log(search_where)

    // 地址
   addressResolve(address,search_where.province,search_where.city,search_where.area);

// 设备品牌型号
addresEquipmente({
     devbrand:'brand_id',
     devbrand_data:brands,
     devname:'goods_id',
     devname_data:goods,
     where:{
        devbrand:search_where.brand_id,
        devname:search_where.goods_id
     }
})

   //支付状态
	dev_state2({
	  name:'pay_state',
	  where:search_where.pay_state
	})
   //设备类型
	dev_state({
	  name:'dev_state',
	  where:search_where.dev_state
	})

   //订单状态
	customertypea({
	  name:'order_state',
	  where:search_where.order_state
	})


   
	var selecttime = search_where.selecttime;
	// 
	 	var time1='';
	 	var time2='';
	 	if(selecttime){
	 	var timeData= selecttime.split("至");
	 	
	 		time1=timeData[0];
	 		time2=timeData[1];
	 		$("#selecttime1").val( search_where.selecttime)
	 	}

// alert(time2)

	   // 时间选择
   var dateRange = new pickerDateRange('date_demo', {
   	//aRecent7Days : 'aRecent7DaysDemo3', //最近7天
   	isTodayValid: true,
   	startDate :time1,
   	endDate :time2,
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
	if(search_where.search){
		$("#searchp").val(search_where.search)
	}
	$("#removerSub").bind('click',function(){
			$("#date_demo").text('')
		    $("input").val('')
		    return false;
    })


   $("#submit").bind('click',function(){
			var order_state_val = $("#order_state").val();
			var pay_state_val = $("#pay_state").val();
 			if(order_state_val==''){
 				$("#order_state").val('1')
 			}


			if(pay_state_val==''){
 				$("#pay_state_val").val('1')
 			}

		    // $("input").val('')
		    // return false;
    })
  
   //分页
   $("#page").paging({
   	pageNo: 1,
   	totalPage: Math.ceil(total / 10),//
   	totalLimit: 10,
   	totalSize: total,//
   	callback: function(num, nbsp) {
		   search_where.limit= nbsp;
		   search_where.offset= num * nbsp - nbsp;
  // console.log(search_where)
   	  	Get_datas(search_where)
   	}
   })	








   


   function Get_datas(searchParameters) {
          // console.log(searchParameters)
   	var ii = layer.open({
   		type: 1,
   		skin: 'layui-layer-demo', //样式类名
   		closeBtn: 0, //不显示关闭按钮
   		anim: 2,
   		shadeClose: false, //开启遮罩关闭
   		content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
   	});
   	$.post('./index.php?r=hotel-order/page', searchParameters, function(data) {
   		layer.close(ii);

   		var data = eval('(' + data + ')');
         // console.log(data)
   		dev_listdata(data.data)
   	})
   };
 dev_listdata(data)
   function dev_listdata(dev_list) {
   	$("#dev_list_body").empty();
   // console.log(data)
   	if(dev_list.length){
   		var j=0;
	   	for (var i = 0; i < dev_list.length; i++) {
            j++;
            var item = dev_list[i];
	          for(var z in item){
	          	 if(item[z]==null){
	          	 	item[z]=''
	          	 }
	          }
	   var State,OrderState,PayType;
	    item.State==1?(State = '成功'):(State = '失败');
	      switch(item.PayType*1){
	      	case 1:
			  PayType='微信'
			  break;
			  default:
			  PayType='其它'
	       }
	       switch(item.OrderState*1)
			{
			case 1:
			  OrderState='交易成功'
			  break;
			case 2:
			   OrderState='退款中'
			  break;
			  case 3:
			   OrderState='退款成功'
			  break;
			  case 4:
			   OrderState='退款失败'
			  break;
			 
			default:
			OrderState='交易关闭'
			}
 // console.log(OrderState)
	        var html = '<tr>';
		   		html +='<td >'+j+'</td>';
		   		html +='<td >'+item.OutTradeNo+'</td>';
		   		html +='<td >'+item.TransactionId+'</td>';
		   		html +='<td >'+item.DevNo+'</td>';
		   		html +='<td >'+item.CodeNumber+'</td>';
		   		html +='<td >'+item.RoomNo+'</td>';
		   		html +='<td >'+item.Name+'</td>';
		   		html +='<td >'+item.ContractTel+'</td>';
		   		html +='<td >'+item.Province+'-'+item.City+'-'+item.Area+'</td>';
		   		html +='<td >'+item.Address+'</td>';
		   		html +='<td >'+item.Volume+'</td>';
				html +='<td >'+item.PayMoney+'</td>';
				html +='<td >'+item.BrandName+'</td>';
		   		html +='<td >'+item.GoodsName+'</td>';
		   		html +='<td >'+item.RowTime+'</td>';	
		   		html +='<td >'+PayType+'</td>';
		   		html +='<td >'+  State +'</td>';
		   		html +='<td >'+OrderState+'</td>';
		   		html +='<td >'+item.ActTime+'</td>';
                if(item.State==1&&item.OrderState==1){
					html +='<td ><a href="Javascript: void(0)" onclick="refund(\''+item.OutTradeNo+'\',\''+item.TransactionId+'\')">退款</a></td>';
                }else if(item.State==1&&item.OrderState==4){
                	html +='<td ><a href="Javascript: void(0)" onclick="refund(\''+item.OutTradeNo+'\',\''+item.TransactionId+'\')">退款</a></td>';
                }
                else{
                	html +='<td >退款</td>';
                }
		   		html += '/<tr>';

	      $("#dev_list_body").append(html)	
	   	}
   	}
   }




 // out.print("<td><a href=# onclick='youhuiquan(\""+yhqNum[0]+"\")'>优惠券</a></td>"); 

function refund(OutTradeNo,TransactionId){
   // alert(OutTradeNo)
	var URl = window.location.host;
	   // console.log(data)
   //信息框-例2
		layer.msg('你确定要退款么？', {
		  time: 0 //不自动关闭
		  ,btn: ['确定', '取消']
		  ,shadeClose :false
		 , shade: [0.1, '#393D49']
		  ,yes: function(index){
		    layer.close(index);
		      	var ii = layer.open({
			   		type: 1,
			   		skin: 'layui-layer-demo', //样式类名
			   		closeBtn: 0, //不显示关闭按钮
			   		anim: 2,
			   		shadeClose: false, //开启遮罩关闭
			   		content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">退款.....</div>'
			   	});


setTimeout(function(){
     layer.close(ii);
},10000);
        
 
          
		    	$.get('http://wx.taijibing.cn/index.php/wei-xin-pay/return-money', {'out_trade_no': OutTradeNo,'transaction_id': TransactionId}, function(data) {
		   		/*optional stuff to do after success */
		   			layer.close(ii);
                 // console.log(data)
		   		 var data = eval('(' + data + ')');

		   		 if(data.state==-1){
		   		 		layer.msg(data.msg, {
							  time: 0 //不自动关闭
							  ,shadeClose :false
							  ,btn: ['确定']
							   , shade: [0.1, '#393D49']
							  ,yes: function(index){
							    layer.close(index);
							     location.reload();
							  }
							});
		   		   }else{
		   		 	 layer.msg('退款成功', {
					  time: 0 //不自动关闭
					  ,shadeClose :false
					  ,btn: ['确定']
					   , shade: [0.1, '#393D49']
					  ,yes: function(index){
					    layer.close(index);
					     location.reload();
					  }
					});
		   		 }
		   		});		    


		  }
		});




}




</script>
</html>