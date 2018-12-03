
<!DOCTYPE html>
<html>
<head>
	<title>送水明细</title>

	<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
 	<link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/conmones2.css"/>
	 <link rel="stylesheet" href="./static/css/chosen.css"/>
	  <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
</head>
<body>
<style type="text/css" media="screen">
.table>tbody>tr{
    background-color: #393E45
}
.table>thead>tr>th:first-of-type,.table>tbody>tr>td:first-of-type{
       border-top-left-radius: 4px;
       border-bottom-left-radius: 4px;
}

.table>thead>tr>th:last-of-type,.table>tbody>tr>td:last-of-type{
       border-top-right-radius: 4px;
       border-bottom-right-radius: 4px;
}

.table>thead>tr>th:nth-child(14),.table>tbody>tr>td:nth-child(14){
     border-right:1px solid #1D1F23;
     border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

.table>thead>tr>th:nth-child(16),.table>tbody>tr>td:nth-child(16){
     border-left:1px solid #1D1F23;
       border-top-left-radius: 4px;
       border-bottom-left-radius: 4px;
}
.table>thead>tr>th:nth-child(15),.table>tbody>tr>td:nth-child(15){
padding: 4px;
    background-color: #1d1f23;
}
.ShareBtn{
	padding:5px;   
}
.ShareBtn a p{
	padding: 5px;
    background: #E46045;
    min-width: 50px;
    color: rgb(233,233,233);
    border-radius: 4px; cursor: pointer;
}

.ShareBtn a p:hover{
	   background: #e24727;
}
.ShareBtn a .Ing{
	padding: 5px;
    border-radius: 4px; cursor: pointer;
}
.ShareBtn a .Ing:hover{
	    background: #1D1F23;
}
.dropdown-menu{
		max-height: 250px;
		overflow: auto;
	}
.condition {
	padding: 0;margin:0;
}
</style>
<div id='electronicBill'>
	<header id="header" style= 'padding: 20px;position: relative;'>
			 <span style='position: relative;'> <img style='position: absolute;top:1px' src="static/images3/caption.png" alt=""><span class="titoe">送水明细</span></span>
			    <a href="/index.php?r=send-water-log/index<?=$url?>"> <button type="text" class="pull-right btnHeader">返回</button></a>
		</header>
	<!--内容主题-->
	  <form   action="./index.php?r=send-water-log/send-log" method="post" accept-charset="utf-8">
	 <div class='page-head'>

	 	<div class='head-txt'>
	 		<!-- 时间容器 -->
	 		<div class="selection pull-left">
				<span  class="selection-text  pull-left">时&nbsp;间&nbsp;段&nbsp;：</span>
				 <div class="ta_date" id="div_date_demo">
			        <span class="date_title" id="date_demo"></span>
			        <a class="opt_sel" id="input_trigger_demo" href="#">
			            <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
			        </a>
			    </div>
				 <input type="text" name="selecttime" class='toggle-input' id='selecttime1' value="" style="display: none">
			    <div id="datePicker"></div>
		   </div>
		   <!-- 品牌  -->
	 		<div class="selection pull-left" style='margin-left: 10%;'>
				<span  class="selection-text  pull-left">选择水品牌：</span>
				 	<div class="region pull-left condition"  >
				 	   <div class="wrap_line"  >
						  <!-- 水品牌 -->
                              <select class="control-label" name="brand_id" id="brand_id"  class="brand_id">
				                     
				                     <option value="">请选择水品牌</option>
				               </select>
						  <!-- 品牌 -->
						  <select class="control-label" name="water_name" id="water_name"  class="water_name">
			                     <option value="">请选择水商品</option>
			               </select>
					    </div>	
				 </div>
		   </div>
	 	</div>
	<div class='head-txt'>
	 		<!-- 选择容量 -->
	 		<div class="selection pull-left">
				<span  class="selection-text  pull-left">选择容量：</span>
				 	<div class="region pull-left condition"   style='background-color: transparent' >
				 	   <div class="wrap_line">

 							<select class="control-label" name="water_volume" id="water_volume"  class="water_volume">
			                     <option value="">请选择水商品</option>
			               </select>
				 	 
					    </div>	
				 </div>
		   </div>
			<!-- 充值方式 -->
	 		<div class="selection pull-left"  style='margin-left: 10%;'>
				<span  class="selection-text  pull-left">订水来源：</span>
				 	<div class="region pull-left condition">
				 	   <div class="wrap_line">
				 	   	<select class="control-label" name="from" id="from"  class="from">
			                     <option value="">全部</option>
			                     <option value="1">客户</option>
			                     <option value="2">服务中心</option>
			                     <option value="3">太极兵</option>
			               </select>
					    </div>	
				 </div>
		   </div>
		     <input type="text" name="AgentId" id='AgentId' value="" style="display: none">
		     <input type="text" name="CustomerType" id='CustomerType' value="" style="display: none">
		     <input type="text" name="UserId" id='UserId' value="" style="display: none">
           <!-- 条件按钮 -->
		   	 <div class="submitBtn" s style='display: inline-block;' >
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="submit" class="btn btn-danger" id="submit" >   查看</button>
				&nbsp;&nbsp;
				<button type="text"  class="btn btn-danger" id="removerSub">清空条件</button>
	         </div>
		 </div>
	</div>
</form>
	<div class='middle'>
		   <table class="table"  style="">
		   	<thead>
		   		<tr>
		   			<th>序号</th>
		   			<th>用户姓名</th>
		   			<th>手机号</th>
		   			<th>类型</th>
		   			<th>订水来源</th>
		   			<th>水品牌</th>
		   			<th>水商品</th>
		   			<th>容量（L）</th>
		   			<th>数量</th>
		   			<th>单价</th>
		   			<th>合计（元）</th>
		   			<th>购水余额</th>
		   			<th>送水时间</th>
		   			<th>完成时间</th>
		   			<th class="Division"></th>
		   			<th>状态</th>
		   			<!-- <th>修改</th> -->
		   			<th>删除</th>
		   		</tr>
		   	</thead>
		   	<tbody id="dev_list_body">
		   		
		   	</tbody>
		   </table>	
	</div>

	<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
 
		<div id="page" class="page_div"></div>
	</div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>	
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>
<script type="text/javascript" src="/static/js/monthPicker.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>
<script> 
   	  	var data  = eval('(' + <?=json_encode($data)?> + ')'); 

   	  	// var DevNo  = eval('(' + <?=json_encode($DevNo)?> + ')'); 
   	  	// alert(DevNo);
   	  	var total  = eval('(' + <?=json_encode($total)?> + ')'); 
   	  	var where_data  = eval('(' + <?=json_encode($where_data)?> + ')'); 
   	  	var select_where  = eval('(' + <?=json_encode($select_where)?> + ')'); 


   	  	var UserId  =<?=json_encode($UserId)?>;
   	  	var CustomerType  =<?=json_encode($CustomerType)?>; 
   	  	var AgentId = <?=json_encode($AgentId)?>;
   	  	var CreateTime = <?=json_encode($CreateTime)?>;

            // console.log(where_data	)
console.log(CreateTime) 
var Create=''


if(CreateTime!=0&&CreateTime){
	Create = new Date(CreateTime.replace("-", "/").replace("-", "/"));
}
            // console.log(CustomerType)
            // console.log(CustomerType)
            //  console.log(UserId)
            //  console.log(AgentId)


        $("#UserId").val(UserId)
        $("#CustomerType").val(CustomerType)
        $("#AgentId").val(AgentId);
  addresWater({
  	 waterbrandName:'brand_id',
  	 waternameName:'water_name',
  	 water_volumeName:'water_volume',
  	 waterbrandData:where_data.water_brand,
  	 waternameData:where_data.water_goods,
  	 water_volumeData:where_data.water_volumes,
  	 where:{
  	 	water_brand_where:select_where.brand_id,
  	 	water_goods_where:select_where.water_name,
  	 	water_volume_where:select_where.water_volume
  	 }
  })
 // if(select_where.from){
 // 	$("#from").val(select_where.from)
 // }

customertypea({
	name:'from',
	where:select_where.from
})


// $("#from").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
</script>
<script type="text/javascript"  src="/static/js/send-water-log/send-log.js?v=1.2"></script>
</body>
</html>