<!DOCTYPE html>
<html>
<head>
	<title>充值</title>
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
  .dropdown-menu{
        max-height: 250px;
        overflow: auto;
   }
</style>
<div id='Delivery'>

	
		<header id="header" style= 'padding: 20px;position: relative;'>
			 <span style='position: relative;'> <img style='position: absolute;top:1px' src="static/images3/caption.png" alt=""><span class="titoe">充值</span></span>
			    <a href="/index.php?r=send-water-log/index<?=$url?>"> <button type="text" class="pull-right btnHeader">返回</button></a>
		</header>
	<div style = 'clear:both'></div>
	<div class='page-head' style="    border-top: 3px solid #E46045;">
		<table>
			<tbody>
			
				<tr>
					<td>剩余金额：</td>
					<td> <input type="number" id="Surplus_price" name="" readonly value="" placeholder="单位 ： 元"></td>
					<td>元</td>
				</tr>
				<tr>
					<td>充值方式：</td>
					<td style="position: relative;"> 	 
                     <!-- 省级 -->
                       <select class="control-label" name="pay_type" id="pay_type"  class="pay_type">
                          <option value="1">现金</option>
                          <option value="2">微信</option>
                          <option value="3">支付宝</option>
                          <option value="4">转账</option>
                       </select>

				 	  	<!--    <div class="dropdown pull-left" >
						      <button class="btn btn-default dropdown-toggle"  style=" background-color: #2D3136;color:#f0f0f0;"  type="button" id="Payment_method" data-toggle="dropdown"  value="1"  aria-haspopup="true" aria-expanded="true">
									    现金&nbsp;&nbsp;&nbsp;
									    <span><img src="static/images3/biao4.png"></span>
								</button>
  								 <input  class="toggle-input" type="text" min="1" name="pay_type" value="" >

									  <ul class="dropdown-menu" aria-labelledby="Payment_method">
									    <li  class='downLi' value='1'>现金</li>
									    <li  class='downLi' value='2'>微信</li>
									    <li  class='downLi' value='3'>支付宝</li>
									   
								 	 </ul>
						    </div> -->
						   		
						</td>
						<td>元 </td>
				 </tr>
				<tr>
					<td>充值金额：</td>
					<td> <input type="number" id="Recharge_price" min="0" name=""  value="" placeholder="请输入大于1的金额"></td>
					<td>元</td>
				</tr>
				 <tr>
					<td>合计金额：</td>
					<td> <input type="number" id="total_rest_money" readonly name=""  value="" ></td>
						<td>元 </td>
				</tr>

			</tbody>
		</table>

     	 <div class="submitBtn" s style='display: inline-block;' >
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="submit" class="btn btn-danger Close"  >   重置</button>
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

     	var rest_money = eval('(' + <?=json_encode($rest_money)?> + ')');


        var CustomerType = eval('(' + <?=json_encode($CustomerType)?> + ')');

        var UserId = <?=json_encode($UserId)?>;
     var AgentId = <?=json_encode($AgentId)?>;



$("#pay_type").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen

     	$("#Surplus_price").val(rest_money)

     	$("#Recharge_price").change(function(event) {
     		// if ($(this).val() <= 0) {
     		// layer.msg('充值金额必须大于1');
     		//    $(this).val('')
     		// }
          var vle = Math.round(($(this).val()) * 100) / 100;
            $(this).val(vle);
     		$("#total_rest_money").val(  Math.round((rest_money * 1 + vle * 1)*100)/100);
     	});
     
     	$(".Close").click(function() {
     		window.location.reload();
     	})
     	$(".submit").click(function() {
     	   //$(this).attr('disabled', 'disabled')
        var Recharge_priceval=$("#Recharge_price").val()
            var Recharge_pricetext='是否确认充值'
            // if(Recharge_priceval<=0){

            //     layer.msg('充值金额不能为0');
            //             return;
            //     Recharge_pricetext='不能充值'
            // }


            console.log(Recharge_pricetext)
          	var html = '<div class="popupa">' +
     					'<div class="popup-text"><span style=" color: rgb(233,233,233)"> 当前充值金额：'+Recharge_priceval+'&nbsp;元&nbsp;&nbsp;&nbsp;'+Recharge_pricetext+'</span></div>' +
     					'<div class="butt pull-left" style="    margin-left: 60px;">' +
     					'<button type="button"  class="Closealery" >取消</button>' +
     					'</div>' +
     					'<div  class="butt">' +
     					'<button type="submit" class="confirmalery" style="background-color: #E46045" >确认</button>' +
     					'</div>' +
     					'</div>'
     		      var alery = layer.open({
     					type: 1,
     					title: false,
     					area: ['500px', '400px'],
     					closeBtn: 0,
     					shadeClose: true,
     					shade:  [0.5, '#393D49'],
     					skin: 'yourclass',
     					content: html

     				});
         	       $(".Closealery").click(function() {
     					//$('.submit').attr('disabled', false)
     					layer.close(alery);
     					//window.location.reload();
     				})

         	         $(".confirmalery").click(function() {
         	         	layer.close(alery);
         	         	// if(Recharge_priceval>0){
			 			 rechargermb()
			            // }
     				})

   function   rechargermb(){
   			$('.submit').attr('disabled', 'disabled')
   			$('.Close').attr('disabled', 'disabled')
   			 $('.btnHeader').attr('disabled', 'disabled')
   	       var ii = layer.open({
     			type: 1,
     			skin: 'layui-layer-demo', //样式类名
     			closeBtn: 0, //不显示关闭按钮
     			anim: 2,
     			shadeClose: true, //开启遮罩关闭
     			content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">支付中,请稍后.....</div>'
     		});
		var Valdata = {

                UserId: UserId,
                CustomerType:CustomerType,
                AgentId:AgentId,
     			rest_money: rest_money,
     			pay_type: $("#pay_type").val(),
     			pay_money: $("#Recharge_price").val(),
     			total_rest_money: rest_money * 1 + $("#Recharge_price").val() * 1,


     		}


     		$.post('./index.php?r=send-water-log/recharge', Valdata, function(data) {
     			var data = eval('(' + data + ')');
     			// console.log(data)
     			if (data.state < 0) {
     				layer.msg(data.mas);
                      setInterval(function(){ location.reload()},3000);

     			} else if (!data.state) {
     				var html = '<div class="popupa">';

     					 html +='<div class="popup-text"><img src="static/images3/caption2.png" alt=""><span style=" color: rgb(233,233,233)"> 充值成功,请返回电子水票历史详情中,查看充值详情！</span></div>' +
     					'<div class="butt pull-left" style="    margin-left: 60px;">' +
     					'<button type="button"  class="Close" >继续充值</button>' +
     					'</div>' +
     					'<div  class="butt">' +
     					'<button type="submit" class="confirm" style="background-color: #E46045" >确认</button>' +
     					'</div>' +
     					'</div>'
     					layer.close(ii);
     				var ppp = layer.open({
     					type: 1,
     					title: false,
     					area: ['500px', '400px'],
     					closeBtn: 0,
     					shadeClose: true,
     					shade: false,
     					skin: 'yourclass',
     					content: html

     				});

     				$(".Close").click(function() {
     					$('.submit').attr('disabled', false)
     					

     					$("button").attr("disabled",'disabled')
     					window.location.reload();
						//layer.close(ppp);
     				})
     				$(".confirm").click(function() {
     				//	layer.close(ppp);
     					 $("button").attr("disabled",'disabled')

     					 location.href = '/index.php?r=send-water-log/index';
						//	layer.close(ppp);
     					//$('.submit').attr('disabled', disabled)
     				})

     			}

     		})

   } 

     		

     		
     		// console.log(Valdata)




     	})
</script>
</html>