
	

		if(datas.rest_money){
			$("#rest_money").val(datas.rest_money);
		}
       // 时间
       $("#J-xl").click(function() {
  			laydate({
  				elem: '#J-xl',
  				// min:laydate.now()

  			});
  		});

  $("select").change(function(){
       	 // $("#stockNum").attr('readonly', false);
       	 $("input:not(:first)").val('')
       	 $("#water_stock").text('')
       Univalent()

  })
// $("#stockNum").change(function(event) {
// 	/* Act on the event */
// 	var _this = $(this).val();
// 	var water_stock_val = $("#water_stock").val();
// 	if(_this<0){

// 	}

// });

	$("#stockNum").change(function() {
		var _this = $(this).val() * 1;
		var water_stockdata = $("#water_stock").text();
		if (_this * 1 > water_stockdata) {
			layer.msg('送水数量不能大于库存数量');
			$(this).val(water_stockdata)
		} else if (_this <= 0) {
			layer.msg('送水数量不能小于1');
			$(this).val('')
		}
		var stockNum = $("#stockNum").val()
		$("#Total_price").val($("#water_price").val() * stockNum);
		$("#Surplus_price").val($("#rest_money").val() - $("#Total_price").val());

		})


 function Univalent() {
 		var rest_moneyVal = $("#rest_money").val();
		var water_brandVal = $("#water_brand").val();
		var water_goodsVal = $("#water_goods").val();
		var water_volumeVal = $("#water_volume").val();

      $(".littleHint").css('display', 'block');
      if(water_brandVal&&water_goodsVal&&water_volumeVal){
      		$("#stockNum").attr('readonly', false)
	  	  	$(".littleHint").css('display', 'none');
	  	  	var Valdata = {
					UserId: datas.UserId,
					CustomerType: datas.CustomerType,
					AgentId: datas.AgentId,
					brand_id: water_brandVal,
					water_name: water_goodsVal,
					water_volume: water_volumeVal,
				};
               console.log(Valdata)

			    	if (datas.id != null && datas.log.length) { 
						var datasLog = datas.log[0]
						if (water_brandVal == datasLog.WaterBrandNo && water_goodsVal == datasLog.goodsName && water_volumeVal == datasLog.Volume) {
							// console.log(datasLog)
							stockPriceList(Valdata, datasLog.Amount);
							$("#Total_price").val(datasLog.UseMoney);

							$("#stockNum").val(datasLog.Amount);
							$("#Surplus_price").val($("#rest_money").val() - $("#Total_price").val());

							// $("#Surplus_price").val(datasLog.RestMoney)
							$("#J-xl").val(datasLog.SendTime)
						} else {
							$("#stockNum").val('');
							$("#Total_price").val('');
							$("#Surplus_price").val('')
							stockPriceList(Valdata)
						}
					}else {
							stockPriceList(Valdata)
						};
      }
 };
	  	  		function stockPriceList(Valdata, Amount) {
	  	  			console.log(Valdata)
	  	  			var ii = layer.open({
	  	  				type: 1,
	  	  				skin: 'layui-layer-demo', //样式类名
	  	  				closeBtn: 0, //不显示关闭按钮
	  	  				anim: 2,
	  	  				shade:  [0.5, '#393D49'],
	  	  				shadeClose: false, //开启遮罩关闭
	  	  				content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
	  	  			});
	  	  			var Amount = Amount || 0;

	  	  			$.post('./index.php?r=send-water-log/stock-price', Valdata, function(data) {
	  	  				layer.close(ii);
	  	  				var objdata = eval('(' + data + ')');
	  	  				console.log(objdata)

	  	  				if (objdata.state < 0) {

	  	  					layer.msg(eval('(' + data + ')').mas);
	  	  					$("#stockNum").attr('readonly', true);
	  	  					$("#water_stock").text('0');
	  	  					$("#water_price").val('');
	  	  					return;

	  	  				}
	  	  				var datat = eval('(' + data + ')').data;
	  	  				$("#water_stock").text(datat.water_stock * 1 + Amount * 1);
	  	  				$("#water_price").val(datat.water_price);
	  	  			})
	  	  		}
				$(".Close").click(function() {
	  	  			window.location.reload();
	  	  		})
	  	  		$(".submit").click(function() {
	  	  			var rest_moneyVal = $("#rest_money").val();

	  	  			var water_brandVal = $("#water_brand").val();
	  	  			// var water_goodsVal=   $("#water_goods").attr('value');
	  	  			var water_volumeVal = $("#water_volume").val();
	  	  			var water_goodsVal = $.trim($("#water_goods").val())
	  	  			var Surplus_price = $("#Surplus_price").val();
	  	  			var stockNum = $("#stockNum").val();
	  	  			var water_price = $("#water_price").val();
	  	  			var Total_price = $("#Total_price").val();
	  	  			var J_xl = $("#J-xl").val();
	  	  			if (!rest_moneyVal || rest_moneyVal == null) {
	  	  				layer.msg('购水余额为空');
	  	  				return;
	  	  			};
	  	  			if (!water_brandVal || water_brandVal == '' || water_brandVal == null) {
	  	  				layer.msg('品牌不能为空');
	  	  				return;
	  	  			};
	  	  			if (!water_goodsVal || water_goodsVal == '' || water_goodsVal == null) {
	  	  				layer.msg('商品不能为空');
	  	  				return;
	  	  			};

	  	  			if (!stockNum || stockNum == '' || stockNum == null) {
	  	  				layer.msg('送水数量不能为空');
	  	  				return;
	  	  			};

	  	  			if (!water_price || water_price == '' || water_price == null) {
	  	  				layer.msg('单价不能为空');
	  	  				return;
	  	  			};
	  	  			if (!Total_price || Total_price == '' || Total_price == null) {
	  	  				layer.msg('合计金额不能为空');
	  	  				return;
	  	  			};
	  	  			if (!Surplus_price) {
	  	  				layer.msg('剩余金额不能为空');
	  	  				return;
	  	  			};
	  	  			if (Surplus_price*1 <= -500) {
	  	  				layer.msg('剩余金额最小为-500');
	  	  				return;
	  	  			};
	  	  			if (!J_xl) {

	  	  				layer.msg('建议送水时间不能为空');
	  	  				return;
	  	  			};
	  	  			var ordertext = '是否确认送水'
     
	                 if(stockNum<0){
	 			            ordertext='不能送水'
	                 };
          			var html = '<div class="popupa">' +
     					'<div class="popup-text"><span style=" color: rgb(233,233,233)"> 当前送水数量：'+stockNum+'&nbsp;&nbsp;&nbsp;&nbsp;'+ordertext+'</span></div>' +
     					'<div class="butt pull-left" style="    margin-left: 60px;">' +
     					'<button type="button"  class="Closealery" >取消</button>' +
     					'</div>' +
     					'<div  class="butt">' +
     					'<button type="submit" class="confirmalery" style="background-color: #E46045" >确认</button>' +
     					'</div>' +
     					'</div>';
     					var alery = layer.open({
     					type: 1,
     					title: false,
     					area: ['500px', '400px'],
     					closeBtn: 0,
     					shadeClose: false,
     					shade:  [0.5, '#393D49'],
     					// shade: false,
     					skin: 'yourclass',
     					content: html

     				  });

	     			   $(".Closealery").click(function() {
	     					layer.close(alery);
	     				});

	         	         $(".confirmalery").click(function() {
	         	         	layer.close(alery);
	         	         	if(stockNum>0){
				 			    rechargermb()
				            };
	     				})

	       function rechargermb(){
              //   	$('.submit').attr('disabled', 'disabled')
   			        // $('.Close').attr('disabled', 'disabled')
   			        // $('.btnHeader').attr('disabled', 'disabled')
                    	var Valdata = {
		  	  				UserId: datas.UserId,
		  	  				CustomerType: datas.CustomerType,
		  	  				AgentId: datas.AgentId,
		  	  				brand_id: water_brandVal,
		  	  				water_name: water_goodsVal,
		  	  				water_volume: water_volumeVal,
		  	  				amount: stockNum,
		  	  				price: water_price,
		  	  				use_money: Total_price,
		  	  				rest_money: Surplus_price,
		  	  				send_time: J_xl,
		  	  				id: datas.id
	  	  			    }
	  	  			    console.log(Valdata)	
	  	  			    	$.post('index.php?r=send-water-log/save-order', Valdata, function(data) {
	  	  			    		var objdata = eval('(' + data + ')');
						     		console.log(objdata)
			  	  				if (objdata.state < 0) {
			  	  					layer.msg(objdata.mas,function(){
			  	  						 window.location.reload(); 	
			  	  					});

			  	  					return;
			  	  				}
			  	  				var htmlText = '创建成功,请返回电子水票-送水历史查看详情！';
		                        var htmlTextBtn = '继续送水';
		                        	if (datas.id != null && datas.log.length) {
		                        			htmlText = '修改成功,请返回电子水票-送水历史查看详情！'
		                        			 htmlTextBtn = '继续修改';
		                        	}
		                        var html = '<div class="popupa">' +
			  	  					'<div class="popup-text"><img src="static/images3/caption2.png" alt=""><span style=" color: rgb(233,233,233)"> '+htmlText+'    </span></div>' +
			  	  					'<div class="butt pull-left" style="    margin-left: 60px;">' +
			  	  					'<button type="button"  class="Close" >'+htmlTextBtn+'</button>' +
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
			  	  					shade: false,
			  	  					skin: 'yourclass',
			  	  					content: html

			  	  				});
			  	  				$(".Close").click(function() {
			  	  					//layer.close(ppp);
			  	  					 window.location.reload(); 	
			  	  				})
			  	  				$(".confirm").click(function() {
			  	  				
			  	  					location.href = '/index.php?r=send-water-log/index';
			  	  					//	layer.close(ppp);
			  	  				})
	  	  			    	})
	  	  		     }        


	  	  		})

 		if (datas.id != null && datas.log.length) {
	  	  			$("#header a").attr('href', '/index.php?r=send-water-log/send-log&UserId=' +datas.UserId + '&CustomerType='+ datas.CustomerType + '&AgentId='+ datas.AgentId )
	  	  			// $("#rest_money").val(datas.rest_money*1+datas.log)
	  	  			var UseMoney = 0;
	  	  			for (var i = 0; i < datas.log.length; i++) {
	  	  				UseMoney += datas.log[i].UseMoney * 1;
	  	  			}
                    console.log(UseMoney)
	  	  			$("#rest_money").val(datas.rest_money * 1 + UseMoney);
	  	  			var datasLog = datas.log[0];
	  	  			$(".littleHint").css('display', 'none');
	  	  			$("#stockNum").attr("readonly", false)

	  	  			Univalent()



	  	  		}