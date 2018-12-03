<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport"  content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">

    <meta charset="utf-8"/>
	<title>送水</title>
	<link rel="stylesheet" type="text/css" href="/static/js/layer.mobile-v2.0/layer_mobile/need/layer.css">
</head>
<style type="text/css" media="screen">
        body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
        #allmap {
            height: -webkit-calc(100% - 100px);height: -moz-calc(100% - 100px);height: calc(100% - 100px) ;   margin-top: 50px;;
        }
        .address-search{
                /*position: absolute;*/
                bottom: 0;
                z-index: 1;
                width: 100%;
                text-align: left;
                text-indent: 20px;
                max-height: 200px;
                overflow: auto;
                /*background-color: #fff;*/
                /*margin-top: -15px;*/
        }
        .address-details{
            position: relative;
        }
           .address-details>img{
                float: right;
    margin-right: 16px;
    position: absolute;
    right: 0;
    top: 50%;
    margin-top: -6px;
           }

 .address-details:first-child{
        background: #f3f3f3;
        padding: 1px 0;
 }
body{
	background-color:#f3f3f3;
}
a {
	color: black;
	text-decoration: none;
	}
	input	{
		    width: -webkit-calc(100% - 50px);
    width: -moz-calc(100% - 50px);
    width: calc(100% - 50px);
		    height: 30px;
    line-height: 30px;
    text-indent: 10px;  margin-top: 20px;
    border:none;
	}
	label{
		width: 40px;
    text-align: center;
    /*display: inline-block;*/
	}
select{
	margin-top: 20px;
	width:100%;
    height: 34px;
    text-indent: 10px;    border:none;
}
 select, input{
      font-size: 13px;
    }
.bton span{
    background-color: #d9d9e6;
    width: 45%;
    display: inline-block;
    float: left;
    margin-left: 2.5%;
    padding: 7px 0;
    border-radius: 5px;
}
.cancel2{
	    float: right;
    display: inline-block;
    width: 30px;
    height: 30px;
    margin-top: 5px;
    margin-right: 10px;
    background: #fff;
    line-height: 35px;
    border-radius: 50%;	
}
.datamyHours p{
	padding:10px;    margin: 0;
}
.date2{
	background-color: #efeff4;padding: 5px 15px;    text-align: left;
}
.ativer{
background: #fff
}
.ativer2{
	/*background: #FF9843*/
	    background: #efeff4;
}
.water_datum{
	height: 100%;
    overflow: auto;height: 100%;

}.water_datum{
	height: 100%;
    overflow: auto;height: 100%;

}
#date-wrapper h3,#d-confirm{
background-color: #FF5F00 !important;
}
</style>
<body>
<div class='water_datum'>
	<form action="save-send-water.php" method="get" accept-charset="post" style="    padding: 0 10px;">
		
  
		<!-- 购水余额:  --><input type="number" id="rest_money" readonly unselectable="on"  placeholder="购水余额" name="" value=""><label>&nbsp;元</label>
		<br/>
		<!-- 选择品牌: --> <select id="water_brand" name='water_brand'><option value="" >请选择品牌</option></select> <label></label>	<br/>
	<!-- 	选择商品:  --><select id="water_goods" name="water_goods"><option value="" >请选择商品</option></select><label></label>	<br/>
		<!-- 选择容量: --> <select id="water_volume" name = "water_volume"><option value="" >请选择容量</option></select><label></label>	<br/>
	<!-- 	单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价: --><input type="number" readonly unselectable="on" id="water_price"  placeholder="单价" name="water_price" value="" ><label>&nbsp;元</label>	<br/>
	<!-- 	送水数量:  --><input type="number" id="water_stock_name"  style="width: -webkit-calc(100% - 85px);width: -moz-calc(100% - 85px);width: calc(100% - 85px);"  placeholder="送水数量" name="water_stock" value="" ><label style="width:100px;">&nbsp;库存 <span id='water_stock' style="display: -webkit-inline-box; width: 26px;">0</span></label>	<br/>

		<!--购水数量: <input type="number" id="amount"  placeholder="赠水数量" name="amount" value="" ><label></label>	<br/>-->

		<!-- 合计金额: --> <input type="number" id="use_money" readonly unselectable="on"  placeholder="合计金额" name="use_money" id="use_money" value="" ><label>&nbsp;元</label>	<br/>
		<!-- 剩余金额: --> <input type="number" readonly unselectable="on"  placeholder="剩余金额" name="" class="rest_money" value="" ><label>&nbsp;元</label>	<br/>
		<!-- 送水时间:  -->

			<!-- <input type="text"  value="" placeholder="选择时间" unselectable="on" readonly  name="send_time" id="send_time"> <label></label>	<br/> -->

	<input type="text" id="date3"  placeholder="选择时间" data-options="{'type':'YYYY-MM-DD hh:mm','beginYear':2010,'endYear':2088}" >
	<p class="bton" style="position:relative;margin-top: 40px;text-align: center;    padding-bottom: 50px;"> 
	<span class="cancel" style="color: #000">取消</span>
		 <span  class="Determine"  dataof='0' style="background-color:#FF5F00; color:#fff;    margin-left: 5%; ">确认</span> 
     <div style="clear:both "></div>
	</p>
 <div style="clear:both "></div>
	 </form>
</div>
</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.date.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script> 

var $datas =   JSON.parse(<?=json_encode($datas) ?>);
     console.log($datas)

     	$.date('#date3');
// 提交
 $('.Determine').click(function(){
 var dataof  = $(this).attr('dataof')
// return;
if(dataof==0){
	$(".Determine").attr('dataof',1)
 	// 品牌
 	var brand_id = $("#water_brand").val();
 	// 商品名称
 	var water_name = $("#water_goods").val();
 	// 容量
 	var water_volume = $("#water_volume").val();
 	// 数量
 	var water_stock = $("#water_stock_name").val();
 	// 单价
 	var price = $("#water_price").val();
 	// use_money
 	var use_money = $("#use_money").val();
 	// rest_money
 	var rest_money = $(".rest_money").val();
 	// send_time
 	var send_time = $("#date3").val();
  if(!brand_id){
		  	  //提示
		  layer.open({
		    content: '品牌不能为空'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });

	return
  }
 if(!water_name){
		  	  //提示
		  layer.open({
		    content: '商品名称不能为空'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });
			return
  }
   if(!water_volume){
		  	  //提示
		  layer.open({
		    content: '容量不能为空'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });
			return
  } 
   if(!water_stock){
		  	  //提示
		  layer.open({
		    content: '购水数量不能为空'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });
			return
  }
      if(!price){
		  	  //提示
		  layer.open({
		    content: '单价不能为空'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });
			return
  }
  if(!use_money){
		  	  //提示
		  layer.open({
		    content: '合计金额不能为空'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });
			return
  }
     if(!rest_money){
		  	  //提示
		  layer.open({
		    content: '剩余金额'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });
			return
  }
   if(!send_time){
		  	  //提示
		  layer.open({
		    content: '时间不能为空'
		    ,skin: 'msg'
		    ,time: 2 //2秒后自动关闭
		  });
			return
  }


if(send_time.search(/[\(（][^\)）]+[\)）]/i) >0){
       　var datee = new Date();
		 var year = datee.getFullYear();
    send_time= year+"年"+ send_time.replace(/[\(（][^\)）]+[\)）]/i,"");
}
 var obj={
 		UserId:$datas.UserId,
 		CustomerType:$datas.CustomerType,
 		brand_id:brand_id,
 		water_name:water_name,
 		water_volume:water_volume,
 		amount:water_stock,
 		price:price,
 		use_money:use_money,
 		rest_money:rest_money,
 		send_time:send_time,
 		AgentId:$datas.AgentId,
 	}
	console.log(obj)
	$.get('save-send-water',obj, function(data) {
		$(".Determine").attr('dataof',1)
      console.log(data)

	      var data =JSON.parse(data)
			 if(data.state==-1){
 	            $('.Determine').attr('dataof',0)
		      		layer.open({
					  content: data.mas ,
					  btn: '确定',
					  shadeClose: false,
					  yes: function(){
					   layer.closeAll()
					  }
					});

 	
		     }else{
		     	$('.Determine').attr('dataof',1)
		     	layer.open({
				    content:data.mas 
				    ,btn: '确定'
				     ,shadeClose: false
				    ,shade: 'background-color: rgba(0,0,0,.3)'
				 	, yes:function(){
		
				       window.location.href='/index.php/agent/send-water-detail?UserId='+$datas.UserId+'&CustomerType='+$datas.CustomerType+'&AgentId='+$datas.AgentId; 
				 	}
				 });

		      	}
		  });
	 }
    })
 $(".cancel").click(function(){
    window.location.href='/index.php/agent/send-water-detail?UserId='+$datas.UserId+'&CustomerType='+$datas.CustomerType+'&AgentId='+$datas.AgentId; ; 
    })
           // 购水余额渲染
            $("#rest_money").val($datas.rest_money)
            if($datas){
            	// 品牌渲染

            	$('#water_brand').empty().append('<option value="" >请选择品牌</option>')
                $('#water_volume').empty().append('<option value="" >请选择容量</option>')
                   $('.water_datum input:not(:first)').val('')
                   $("#water_stock").text(0)
            	$($datas.water_brand).each(function(i, v){
            		var html='';
            		if(v){
            		  html+='<option value="'+v.BrandNo+'" >'+v.BrandName+'</option>'
            		}
	               $(html).appendTo('#water_brand');
            	});
            // 商品渲染
            	$('#water_brand').change(function(event) {
            		// $('#water_goods').val().empty()
            		var _val  =  $(this).val()
            		if(_val){
            			$('#water_goods').empty().append('<option value="" >请选择商品</option>')
            			$('#water_volume').empty().append('<option value="" >请选择容量</option>')
            			   $('.water_datum input:not(:first)').val('')
            			    $("#water_stock").text(0)
            			$($datas.water_goods).each(function(i, v){
		            		var html='';
		            		if(v.brand_id==_val){
		            		  html+='<option value="'+v.name+'" >'+v.name+'</option>'
		            		}
			               $(html).appendTo('#water_goods');
		            	});
            		 }
            	});
            	// 容量渲染
			   	$('#water_goods').change(function(event) {
					var brand_val  =  $('#water_brand').val();
					var goods_val  =  $(this).val();
						$('#water_volume').empty().append('<option value="" >请选择容量</option>')
					   $('.water_datum input:not(:first)').val('')
					    $("#water_stock").text(0)
					$($datas.water_volume).each(function(i, v){
					            	var html='';
	            		if(v.brand_id==brand_val&&v.name==goods_val){
	            		  html+='<option value="'+v.volume+'" >'+v.volume+'</option>'
	            		}
		               $(html).appendTo('#water_volume');
	            	});
			   	})
			   	// 单价/库存渲染
			    	$('#water_volume').change(function(event) {
			   		/* Act on the event */
			   		var brand_val  =  $('#water_brand').val();
					var goods_val  =  $('#water_goods').val();
					var volume_val  =  $(this).val();
	             $('.water_datum input:not(:first)').val('')
					var obj = {
						UserId:$datas.UserId,
						CustomerType:$datas.CustomerType,
						brand_id:brand_val,
						water_name:goods_val,
						water_volume :volume_val,
						AgentId:$datas.AgentId,
					}
					$.get('stock-price',obj, function(data) {
					// 	optional stuff to do after success 
						var data = JSON.parse(data);
						// console.log(data)
						if(data.state<0){
							layer.alert(data.mas,function(){
								 window.location.reload(); 
							})
						}else{
							// console.log(data.data.water_price)
							$("#water_price").val(data.data.water_price);
							$("#water_stock").text(data.data.water_stock);
						}
					});
			   	});
                // 合计金额计算
			   	$("#water_stock_name").change(function(event) {

                      if($(this).val()<=0){
			   	    	layer.open({
						    content: '送水数量不能小于1'
						    ,skin: 'msg'
						    ,time: 2 //2秒后自动关闭
						  });
			   	    	$(this).val(1)
			   	    	return
			   	    }

			   	    var water_stock_val = $("#water_stock").text();
			   	     if(water_stock_val){
			   	     	 if($(this).val()>water_stock_val*1){
			   	     	 	 layer.open({
						    content: '送水数量不能大于库存'
						    ,skin: 'msg'
						    ,time: 2 //2秒后自动关闭
						  });
			   	    	$(this).val(water_stock_val)
			   	    	return
			   	     	 }
			   	     }

			   	    var use_money = $("#water_price").val();
			   	    var water_stock_name_val = $(this).val();
			   	    if(water_stock_name_val.indexOf('.')>0 ){
			   	    var  water_stock = water_stock_name_val.split('.');
			   	    $(this).val(water_stock[0])
                    console.log(water_stock)


			   	    };
			   	    if(!use_money){
		
			   	    	layer.open({
						    content: '单价不能为空'
						    ,skin: 'msg'
						    ,time: 2 //2秒后自动关闭
						  });
			   	    	return
			   	    }
			   	    if(!water_stock_name_val){
		
			   	    	layer.open({
						    content: '购买水量不能不能为空'
						    ,skin: 'msg'
						    ,time: 2 //2秒后自动关闭
						  });
			   	    	return
			   	    }
			   	    $("#use_money").val(Math.round(use_money*water_stock_name_val*100)/100);
			   	    $(".rest_money").val($datas.rest_money-Math.round(use_money*water_stock_name_val*100)/100);
			  	 	});
					$("#send_time").click(function(){
						　var date = new Date();
						var mydateData = ["周天","周一","周二","周三","周四","周五","周六"]

						var dateObj=year+'-'+month+'-'+day
						// console.log(month)
						  //底部对话框
					     var html = '<div style="width:100%;height: 40px; color:#000;     line-height: 40px;  border-radius: 5px 5px 0 0;position: absolute;left:0;top:0;background:url(/static/images/canding.png)">';
					    // html+='<img src="/static/images/canding.png" width=100% height=100%>'
						  	  html +='<span>选择时间</span><span class="cancel2"><img src="/static/images/ridaus2.png"  /></span>';   
						 	  html +='</div>';
						 	  html +='<div style="width:100%;      position: absolute;left: 0;  margin-top: 20px;">';
						 	  html +='<div class="dateyear" style="width:140px;float:left;background-color:#efeff4;border-radius:4px">';
		                     // 年月日渲染
						 	  var date2 = new Date(date);
						 	  for(var i=0;i<7;i++){
       							    date2.setDate(date.getDate()+i);
				       					// 获取年
										var year = date2.getFullYear();
										// 获取月
										var month = date2.getMonth()+1;
										// 获取日
										var day = date2.getDate();
										// 获取星期
										var mydate = date2.getDay();
										// var myHours = date2.getHours()
       							      // console.log(day)
						 	  	var date_day = month;
						 	  	 html +='<p class="date2" datae='+year+'-'+month+'-'+day+'>' +month+'月'+day+'日<span>('+mydateData[mydate]+')</span></p>';
						 	  }
				
						 	  html +=' </div>';
						 	  html +='<div class="datamyHours" style="width: -webkit-calc(100% - 140px);width: -moz-calc(100% - 140px);width: calc(100% - 140px);float:left;text-align: conter;height: 310px;padding:5px;  background-color:#fff;   box-sizing: border-box;   overflow: auto;">';
 
								// 小时渲染
                               	    // 获取当前小时
                               	    var myHours = date.getDate()
                                    datamyHours(myHours);
                                 
						 	  html +='</div>';
						 	  html +='<div style="clear:both"></div>';
						 	  html +='</div>';
						 	  html +='<div style="width:100%;height:310px;">';
						 	  html +='</div>';
							   var ii =  layer.open({
							    content: html
							    ,skin: 'footer'
							 });
                            // 点击事件渲染
							  $(".date2:first-child").addClass("ativer").css('margin','0').find('span').text("(今天)")
							  $(".date2:last-child").css('margin','0')


							  $(".date2").click(function(){
							  	  var ativer_val = $(".ativer").attr('datae');
	  							  var dataert =  $(this).attr('datae');
							  	  var daye = dataert.split('-');
							  	  $(".ativer").removeClass('ativer');
							  	   $(this).addClass("ativer");

							  	  // console.log(dataert)
							  	 
                                   //	 $("#send_time").val(dataert);
                                     datamyHours(daye[2]);

                                     var  _val = $(this).text()
                                     $("#send_time").val(_val);
                                      $('.datamyHours p').click(function(){
                                 var _this_val_One =     $(this).find('span').eq(0).text();
                                 var _this_val_Two =     $(this).find('span').eq(1).text();
                                 var ativer_datae =  $(".dateyear .ativer").attr("datae");

                                 var ativer_text=  $(".dateyear .ativer").text();
                                 $('.ativer2').removeClass('ativer2');
                                 $(this).addClass('ativer2');

                                  var send_time =  ativer_text+' '+_this_val_One+'-'+_this_val_Two
             
 								  $("#send_time").val(send_time);
                                   layer.close(ii);
							  })	

							  })

							  $('.datamyHours p').click(function(){
                                 var _this_val_One =     $(this).find('span').eq(0).text();
                                 var _this_val_Two =     $(this).find('span').eq(1).text();
                                 var ativer_datae =  $(".dateyear .ativer").attr("datae");

                                 var ativer_text=  $(".dateyear .ativer").text();
                                 $('.ativer2').removeClass('ativer2');
                                 $(this).addClass('ativer2');

                                  var send_time =  ativer_text+' '+_this_val_One+'-'+_this_val_Two
             
 								  $("#send_time").val(send_time);
                                   layer.close(ii);
							  })
								$('.cancel2').click(function(){
								  	   layer.close(ii);
								})
						
							  // 关闭时间



function    datamyHours(daye){
	   $(".datamyHours").empty();
//var dataativer =   $(".dateyear .ativer").text();
//alert(dataativer)
		// 获取日
	var daynay = date.getDate();
	// 获取当前小时
	 var myHoursnay = date.getHours()+1;
   	   var myHours = 8;
   	   // console.log(daye);
	//console.log(daynay);

	if(daye*1==daynay*1){
	 $(".date2:first-child span").text('(今天)');
	     myHours=myHoursnay;
	    // console.log(myHours);
	}
   	 // 获取当前小时
   	   var datatay ='晚上';
   	   var html2='';
       for(var i=myHours;i<22;i++){	
       	if(myHours<10){
       		datatay='早上'
       	}else if(myHours>=10&&myHours<12){
       			datatay='上午'
       	}else if(myHours>=12&&myHours<15){
       			datatay='中午'
       	}else if(myHours>=15&&myHours<18){
       			datatay='下午'
       	}else if(myHours>=18&&myHours<52){
       			datatay='晚上'
       	}else{
       		datatay ='夜晚';
       	}


       var myHours2=myHours;

    

		html2 +='<a href="javascript:void(0);"><p>'+datatay+' <span>'+(myHours++)+':00</span> ——   <span>'+(myHours)+'：00 </span></p></a>';

		html +='<a href="javascript:void(0);"><p>'+datatay+'  <span>'+(myHours2++)+':00 </span> ——   <span>'+(myHours2)+'：00 </span></p></a>';

	  }
	  

	   $(html2).appendTo($(".datamyHours"))
   }





	})
            }

   //var date = new Date();
		 //   var year = date.getFullYear();
			// var month = date.getMonth()+1;
			// var day = date.getDate();
			// var dateObj=year+'-'+month+'-'+day
	  //          laydate.render({
			// 	  elem: '#test1', //指定元素
	  //  			  min: dateObj //最小日期
			// 	});
   function clearNoNum(obj) {  
  		obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符  
        obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字而不是  
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的  
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");  
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数  
	}  


</script>
</html>