<!DOCTYPE html>
<html>
<head>
	<title>送水</title>
</head>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="/static/css/conmones2.css"/>
	 <link rel="stylesheet" href="./static/css/chosen.css"/>
	  <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
<body>

<style>
	.region{
		height: 35px;
	}
	table 
  {   border-collapse:   separate;   border-spacing: 5px  30px; text-align: left;  } 
  table  td:first-of-type{
  	text-align: right;
  }
  .dropdown{
  	border-radius: 2px;
  }
  .littleHint{
  	/*position: absolute;bottom: -33px;left: -25%;*/
  	/*display: none*/
color: #f00;
  }


.laydate_body .laydate_ym {
    border: 1px solid #292834;
    background-color: #292834;
}
.laydate_body .laydate_top {
    background-color:#292834;
    border-top: 1px solid #292834;
}
.laydate_body .laydate_box,.laydate_body .laydate_table td,.laydate_body .laydate_bottom #laydate_hms,.laydate_body .laydate_bottom .laydate_sj,.laydate_btn{
    background-color: #292834;
    color: #fff;
}
.laydate_body .laydate_bottom .laydate_btn a{
	background-color: #292834;
	color: #fff;
	border: none
}


.btnHeader{
	    position: absolute;
    right: 20px;
    top: 15px;
    padding: 0 10px;
    border-radius: 4px;
    border: none;
    color: #fff;
    background: #d9534f;
}
.btnHeader a{
	    color: #fff;
}
.titoe{
	margin-left: 20px; font-size: 15px;font-size: 1.5rem;font-weight: bold;
}


.popupa{
	width: 500px;
	height:400px;
	background-color: #393E45;
	border-top: 3px solid #E46045; 
	text-align: center;
	padding-top: 100px;
}
.popupa button,.popupa .submitBtn button{
	 width: 140px;
	 height: 50px;
    font-size: 18px;
    color: rgb(233,233,233);
    border-radius: 5px;
    margin-top: 85px;
    background-color: #4ADCDD;
    border: none;
}
.popupa .butt{
	padding:10px;
}
.dropdown-menu{
		max-height: 250px;
		overflow: auto;
	}
	select, .chosen-container {
    width: inherit  !important;
    min-width: 100px;
}
</style>
<div id='Delivery'>
		<header id="header" style= 'padding: 20px;position: relative;'>
			 <span style='position: relative;'> <img style='position: absolute;top:1px' src="static/images3/caption.png" alt=""><span class="titoe">送水</span></span>
	    <a href="/index.php?r=send-water-log/index<?=$url?>"> <button type="text" class="pull-right btnHeader">返回</button></a>
		</header>
		     
	<div style = 'clear:both'></div>
	<div class='page-head'>

		<table>
			<tbody>
				<tr>
					<td>购水余额：</td>
					<td> <input type="number" id="rest_money" name="rest_money" readonly value="" placeholder="单位 ： 元"></td>
						<td>元</td>
				</tr>
				<tr>
					<td>选择水品牌：</td>
					<td style='    position: relative;'> 
				 	   	  <!-- 水品牌 -->
                              <select class="control-label" name="water_brand" id="water_brand"  class="water_brand">
				                     
				                     <option value="">请选择水品牌</option>
				               </select>
						  <!-- 品牌 -->
						  <select class="control-label" name="water_goods" id="water_goods"  class="water_goods">
			                     <option value="">请选择水商品</option>
			               </select>
					</td>
				</tr>
				<tr>
					<td>选择容量：</td>
					<td style="position: relative;"> 
							<select class="control-label" name="water_volume" id="water_volume"  class="water_volume">
			                     <option value="">请选择水容量</option>
			               </select>
		
						</td>
						<td> <p class='littleHint' style=''>* 请选择 先 品牌 商品 容量 </p> </td>
				 </tr>
               <tr>
					<td>送水数量：</td>
					<td> <input type="number" id="stockNum" name="" min="0"  readonly  value=""  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"> 

					</td>
					<td>（库存：<span id='water_stock'>0</span> ）</td>
				</tr>
				<tr>
					<td>单价：</td>
					<td> <input type="number" id="water_price" name="" readonly value="" placeholder="单位 ： 元"></td>
					<td>元</td>
				</tr>
				<tr>
					<td>合计金额：</td>
					<td> <input type="number" id="Total_price" name="" readonly value="" placeholder="单位 ： 元"></td>
					<td>元</td>
				</tr>
				<tr>
					<td>剩余金额：</td>
					<td> <input type="number" id="Surplus_price" name="" readonly value="" placeholder="单位 ： 元"></td>
					<td>元</td>
				</tr>
				<tr>
					<td>送水时间：</td>
					<td>
					<input type="text"  value="" placeholder="选择时间" unselectable="on" readonly  name="StartTime" id="J-xl"> 
					</td>
				</tr>
			</tbody>
		</table>

     	 <div class="submitBtn" s style='display: inline-block;' >
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="text" class="btn btn-danger Close"  >   重置</button>
				&nbsp;&nbsp;
				<button type="text"  class="btn btn-danger submit" >保存</button>
	      </div>

	</div>
</div>

</body>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>	
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var datas = eval('(' + <?=json_encode($datas)?> + ')');
    console.log(datas)

var whereData=''
  if (datas.id != null && datas.log.length) {
  	   var datasLog = datas.log[0];
        if (datasLog.WaterBrandNo && datasLog.WaterBrandNo != '') {
         whereData={
         	 water_brand_where:datasLog.WaterBrandNo,
         	 water_goods_where:datasLog.goodsName,
         	 water_volume_where:datasLog.Volume
         }
        }
  }
  addresWater({
  	 waterbrandName:'water_brand',
  	 waternameName:'water_goods',
  	 water_volumeName:'water_volume',
  	 waterbrandData:datas.water_brand,
  	 waternameData:datas.water_goods	,
  	 water_volumeData:datas.water_volume,
  	 where:whereData
  })
     
</script>
<script type="text/javascript"  src="/static/js/send-water-log/send-water2.js?v=1"></script>
</html>