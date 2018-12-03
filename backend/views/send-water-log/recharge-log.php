
<!DOCTYPE html>
<html>
<head>
	<title>充值记录</title>

	<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
 	<link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/conmones2.css"/>
		 <link rel="stylesheet" href="./static/css/chosen.css"/>
		 	  <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
</head>
<style type="text/css">
	.condition {
	padding: 0;margin:0;
}
</style>
<body>
<div id='electronicBill'>
	<header id="header" style= 'padding: 20px;position: relative;'>
			 <span style='position: relative;'> <img style='position: absolute;top:1px' src="static/images3/caption.png" alt=""><span class="titoe">充值记录</span></span>
	    <a href="/index.php?r=send-water-log/index<?=$url?>"> <button type="text" class="pull-right btnHeader">返回</button></a>
		</header>
	<!--内容主题-->
	  <form  id='See' action="./index.php?r=send-water-log/recharge-log" method="post" accept-charset="utf-8">
	 <div class='page-head'>
	 	<div class='head-txt'>
	 		<!-- 时间容器 -->
	 		<div class="selection pull-left">
				<span  class="selection-text  pull-left">时间段：</span>
				 <div class="ta_date" id="div_date_demo">
			        <span class="date_title" id="date_demo"></span>
			        <a class="opt_sel" id="input_trigger_demo" href="#">
			            <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
			        </a>
			    </div>
				 <input type="text" name="selecttime" id='selecttime1' value="" style="display: none">
			    <div id="datePicker"></div>
		   </div>
	 	</div>
	<div class='head-txt'>
	 		<!-- 充值方式 -->
	 		<div class="selection pull-left">
				<span  class="selection-text  pull-left">充值方式：</span>
				 	<div class="region pull-left condition"  >
				 	   <div class="wrap_line">
				 	   	 <select class="control-label" name="pay_type" id="pay_type"  class="pay_type">
			                     <option value="">全部充值方式</option>
			                     <option value="1">现金</option>
			                     <option value="2">微信</option>
			                     <option value="3">支付宝</option>
			                     <option value="4">转账</option>
			               </select>
				 	  	<!--    <div class="dropdown" >
						      <button class="btn btn-default dropdown-toggle"  style=" background-color: #2D3136;color:#f0f0f0;"  type="button" id="pay_type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									    全部充值方式
									    <span class="caret"></span>
								</button>
								 <input  class="toggle-input" type="text" name="pay_type" value="">
									  <ul class="dropdown-menu" aria-labelledby="pay_type" style='max-width: 200px;'>
									    <li  value>全部充值方式</li>
									    <li  class='downLi' value='1'>现金</li>
									    <li  class='downLi' value='2'>微信</li>
									    <li  class='downLi' value='3'>支付宝</li>
								 	 </ul>
						    </div> -->
					    </div>	
				 </div>
		   </div>
           <!-- 条件按钮 -->
		   	 <div class="submitBtn" s style='display: inline-block;' >
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="submit" class="btn btn-danger" id="submit" >   查看</button>
				&nbsp;&nbsp;
				<button type="text"  class="btn btn-danger" id="removerSub">清空条件</button>
	         </div>
		 </div>
	 	   <input type="text" name="CustomerType"  id='CustomerType'  value="" style="display: none">
	 	   <input type="text" name="AgentId" id='AgentId' value="" style="display: none">
	 	   <input type="text" name="UserId" id='UserId' value="" style="display: none">
	 	   <input type="text" name="offset" id='offset' value="0" style="display: none">
	 	   <input type="text" name="limit" id='limit' value="10" style="display: none">
	</div>
</form>
	<div class='middle'>
		   <table class="table"  style="">
		   	<thead>
		   		<tr>
		   			<th>序号</th>
		   			<th>用户姓名</th>
		   			<th>手机号</th>
		   			<th>用户类型</th>
		   			<th>充值方式</th>
		   			<th>备注</th>
		   			<th>充值金额</th>
		   			<th>购水余额</th>
		   			<th>时间</th>
		   		</tr>
		   	</thead>
		   	<tbody id="dev_list_body">
		<!-- <tr>
		   		  <td >1</td>
		   		  <td >小黄</td>
		   		  <td >17602006610</td>
		   		  <td >03251544</td>
		   		  <td >微信</td>
		   		  <td >100</td>
		   		  <td >100</td>
		   		  <td >2017-8-22 ，16：30：30</td>
		   		</tr> -->
		   	</tbody>
		   </table>	
	</div>
	<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
 
		<div id="page" class="page_div"></div>
	</div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>	
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>
<script type="text/javascript" src="/static/js/monthPicker.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>
<script type="text/javascript" >
	
	
var data = eval('(' + <?=json_encode($data)?> + ')');
var DevNo = eval('(' + <?=json_encode($DevNo)?> + ')');
var total = eval('(' + <?=json_encode($total)?> + ')');
var where_data = eval('(' + <?=json_encode($where_data)?> + ')');
var CustomerType = eval('(' + <?=json_encode($CustomerType)?> + ')');
var UserId = <?=json_encode($UserId)?>;
var AgentId = <?=json_encode($AgentId)?>;
var CreateTime = <?=json_encode($CreateTime)?>;


console.log(data) 


var Create='0'
if(CreateTime!=0){
	Create = new Date(CreateTime.replace("-", "/").replace("-", "/"));
}
console.log(where_data)
$("#UserId").val(UserId)
$("#CustomerType").val(CustomerType)
$("#AgentId").val(AgentId)
customertypea({
name:'pay_type',
where:where_data.pay_type
})




</script>

<script type="text/javascript"  src="/static/js/send-water-log/recharge-log.js?v=1.2"></script>

</body>
</html>