	  	  	// console.log(datas)
	  	  	$(function() {

	  	  		$("#rest_money").val(datas.rest_money);
	  	  		function getAddressIdByName(_name, i, brand_id, water_name) {
	  	  			// console.log(i)
	  	  			_name = $.trim(_name);
	  	  			if (_name == "" || _name == 0) {
	  	  				return '请选择';
	  	  			}


	  	  			for (var index = 0; index < datas.water_brand.length; index++) {
	  	  				var item = datas.water_brand[index];
	  	  				var name = $.trim(item.BrandNo);
	  	  				if (name != "" && name == _name) {
	  	  					return item.BrandName;
	  	  				}
	  	  			}
	  	  			return '请选择';
	  	   		}
            	 var alertodc= 
	  	  		

              
	  	  		// 渲染商品
	  	  		list_water_brand()

	  	  		function list_water_brand() {

	  	  			if (datas.water_brand) {
	  	  				var water_brandVal = $("#water_brand").parents('.dropdown').children(".dropdown-menu")
	  	  				water_brandVal.children().not(":first").remove()
	  	  				$("#water_goods").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
	  	  				for (var i = 0; i < datas.water_brand.length; i++) {
	  	  					var item = datas.water_brand[i];
	  	  					// $("#water_brand")
	  	  					// console.log(item)
	  	  					water_brandVal.append("<li  class='downLi' value='" + item.BrandNo + "'>" + item.BrandName + "</li>").css('minWidth', '150px');
	  	  				}

	  	  			}
	  	  		}



	  	  		// 次序渲染
	  	  		$("#water_brand").parents('.dropdown').children(".dropdown-menu").children().click(function() {
	  	  			var _thisval = $(this).attr('value');
	  	  			$("#water_goods").html('请选择&nbsp;<span><img src="static/images3/biao4.png"></span>').attr('value', '').parent().siblings(".toggle-input").val('');
	  	  			$("#water_volume").html('请选择&nbsp;<span><img src="static/images3/biao4.png"></span>').attr('value', '')
	  	  			$("#water_volume").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove();
	  	  			var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();

	  	  			if (_thisval != _toggleval) {
	  	  				initWater_goodsChange(_thisval)
	  	  			}

	  	  			$("#water_goods").parents('.dropdown').children(".dropdown-menu").children().click(function() {

	  	  				var _thisvalgoods = $(this).attr('value');
	  	  				var _togglevalgoods = $(this).parent().siblings(".dropdown-toggle").val();
	  	  				var _thisvalgoodsText = $(this).text();
	  	  				$("#water_volume").html('请选择&nbsp;<span><img src="static/images3/biao4.png"></span>');
	  	  				$("#water_volume").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
	  	  				if (_thisvalgoods != _togglevalgoods) {
	  	  					initWater_volume_Change(_thisval, _thisvalgoodsText)
	  	  				}
	  	  			})

	  	  		})

	  	  		// 选择品牌后渲染商品的方法
	  	  		function initWater_goodsChange(_thisval) {

	  	  			if (datas.water_goods) {
	  	  				var water_brandVal = $("#water_goods").parents('.dropdown').children(".dropdown-menu")
	  	  				water_brandVal.children().not(":first").remove()

	  	  				// $("#water_goods").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
	  	  				for (var i = 0; i < datas.water_goods.length; i++) {
	  	  					var item = datas.water_goods[i];


	  	  					if (item.brand_id == _thisval) {
	  	  						water_brandVal.append("<li  class='downLi' value='" + item.name + "'>" + item.name + "</li>").css('minWidth', '150px');
	  	  					}
	  	  				}
	  	  			}
	  	  		}
	  	  		// 选择商品后渲染容量的方法
	  	  		function initWater_volume_Change(_thisval, _thisvalgoos) {
	  	  			if (datas.water_volume) {

	  	  				var water_brandVal = $("#water_volume").parents('.dropdown').children(".dropdown-menu")
	  	  				water_brandVal.children().not(":first").remove()
	  	  				for (var i = 0; i < datas.water_volume.length; i++) {
	  	  					var item = datas.water_volume[i];

	  	  					if (item.brand_id == _thisval && item.name == _thisvalgoos) {

	  	  						water_brandVal.append("<li  class='downLi' value='" + item.volume + "'>" + item.volume + "&nbsp;(L)</li>").css('minWidth', '150px');
	  	  					}
	  	  				}
	  	  			}
	  	  		}

	  	  		function Univalent() {

	  	  			var rest_moneyVal = $("#rest_money").val();
	  	  			var water_brandVal = $("#water_brand").attr('value');
	  	  			var water_goodsVal = $("#water_goods").attr('value');
	  	  			var water_volumeVal = $("#water_volume").attr('value');


	  	  			$(".littleHint").css('display', 'block');
	  	  			if (water_brandVal && water_brandVal != ' ' && water_brandVal != null) {
	  	  				if (water_goodsVal && water_goodsVal != ' ' && water_goodsVal != null) {
	  	  					if (water_volumeVal && water_volumeVal != ' ' && water_volumeVal != null) {
	  	  						$("#stockNum").attr('readonly', false)

	  	  						$(".littleHint").css('display', 'none');
	  	  						var Valdata = {
	  	  							UserId: datas.UserId,
	  	  							CustomerType: datas.CustomerType,
	  	  							AgentId: datas.AgentId,
	  	  							brand_id: water_brandVal,
	  	  							water_name: water_goodsVal,
	  	  							water_volume: water_volumeVal,
	  	  						}
	  	  						// console.log(Valdata)
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


	  	  						} else {
	  	  							stockPriceList(Valdata)
	  	  						}


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

	  	  					}
	  	  				}
	  	  			}
	  	  		}


	  	  		function stockPriceList(Valdata, Amount) {
	  	  			// console.log(Valdata)



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
	  	  				// console.log(objdata)

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



	  	  		$(document).on('click', '.dropdown-menu li', function() {
	  	  			var _class = $(this).attr('class')
	  	  			 if (_class == 'downLi') {
	  	  				var _thisval = $(this).attr('value');
	  	  				var _thisvalText = $(this).text();
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
	  	  					$(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvalText + '&nbsp;&nbsp;&nbsp;<span><img src="static/images3/biao4.png"></span>');
	  	  					$(this).parent().siblings(".toggle-input").val(_thisval)
	  	  				}
	  	  				Univalent()
	  	  			}


	  	  		})

	  	  		$(".Close").click(function() {
	  	  			window.location.reload();
	  	  		})


	  	  		// 
	  	  		$(".submit").click(function() {
	  	  			var rest_moneyVal = $("#rest_money").val();
	  	  			var water_brandVal = $("#water_brand").attr('value');
	  	  			// var water_goodsVal=   $("#water_goods").attr('value');
	  	  			var water_volumeVal = $("#water_volume").attr('value');
	  	  			var water_goodsVal = $.trim($("#water_goods").text())
	  	  			var Surplus_price = $("#Surplus_price").val();
	  	  			var stockNum = $("#stockNum").val();
	  	  			var water_price = $("#water_price").val();
	  	  			var Total_price = $("#Total_price").val();

	  	  			var J_xl = $("#J-xl").val();

	  	  			if (!rest_moneyVal || water_brandVal == null) {
	  	  				layer.msg('购水余额为空');
	  	  				return;
	  	  			}
	  	  			if (!water_brandVal || water_brandVal == '' || water_brandVal == null) {
	  	  				layer.msg('品牌不能为空');
	  	  				return;
	  	  			}
	  	  			if (!water_goodsVal || water_goodsVal == '' || water_goodsVal == null) {
	  	  				layer.msg('商品不能为空');
	  	  				return;
	  	  			}

	  	  			if (!stockNum || stockNum == '' || stockNum == null) {
	  	  				layer.msg('送水数量不能为空');
	  	  				return;
	  	  			}

	  	  			if (!water_price || water_price == '' || water_price == null) {
	  	  				layer.msg('单价不能为空');
	  	  				return;
	  	  			}
	  	  			if (!Total_price || Total_price == '' || Total_price == null) {
	  	  				layer.msg('合计金额不能为空');
	  	  				return;
	  	  			}
	  	  			if (!Surplus_price) {
	  	  				layer.msg('剩余金额不能为空');
	  	  				return;
	  	  			}
	  	  			if (Surplus_price*1 <= -500) {
	  	  				layer.msg('剩余金额最小为-500');
	  	  				return;
	  	  			}
	  	  			if (!J_xl) {

	  	  				layer.msg('建议送水时间不能为空');
	  	  				return;
	  	  			}

				var ordertext = '是否确认送水'
     
                 if(stockNum<0){
 			            ordertext='不能送水'
                 }
                   
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

     					shadeClose: true,
     					shade:  [0.5, '#393D49'],
     						shade: false,
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
                		$('.submit').attr('disabled', 'disabled')
   			           $('.Close').attr('disabled', 'disabled')
   			           $('.btnHeader').attr('disabled', 'disabled')
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
                // console.log(Valdata)
	  	  			$.post('index.php?r=send-water-log/save-order', Valdata, function(data) {
				       var objdata = eval('(' + data + ')');
				     		// console.log(objdata)
	  	  				if (objdata.state < 0) {
	  	  					layer.msg(objdata.mas,function(){
	  	  						 window.location.reload(); 	
	  	  					});

	  	  					return;
	  	  				}
	  	  					// return;
	  	  		
                          var htmlText = '创建成功,请返回电子水票-送水历史查看详情！';
                          var htmlTextBtn = '继续送水';

                        	if (datas.id != null && datas.log.length) {
                        			htmlText = '修改成功,请返回电子水票-送水历史查看详情！'
                        			 htmlTextBtn = '继续修改';
                        	}
	  	  				// console.log(objdata)
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
	  	  			$("#rest_money").val(datas.rest_money * 1 + UseMoney);

	  	  			var datasLog = datas.log[0];
	  	  			if (datasLog.WaterBrandNo && datasLog.WaterBrandNo != '') {
	  	  				var WaterBrandNo = getAddressIdByName(datasLog.WaterBrandNo);
	  	  				$("#water_brand").attr('value', datasLog.WaterBrandNo).html(WaterBrandNo + '&nbsp;&nbsp;&nbsp;<span><img src="static/images3/biao4.png"></span>').parent().find('.toggle-input').val(datasLog.WaterBrandNo);
	  	  			}
	  	  			if (datasLog.goodsName && datasLog.goodsName != '') {
	  	  				// var WaterBrandNo = getAddressIdByName(datasLog.WaterBrandNo);
	  	  				$("#water_goods").attr('value', datasLog.goodsName).html(datasLog.goodsName + '&nbsp;&nbsp;&nbsp;<span><img src="static/images3/biao4.png"></span>').parent().find('.toggle-input').val(datasLog.goodsName);
	  	  				initWater_goodsChange(datasLog.WaterBrandNo)

	  	  			}

	  	  			if (datasLog.Volume && datasLog.Volume != '') {
	  	  				// var WaterBrandNo = getAddressIdByName(datasLog.WaterBrandNo);
	  	  				$("#water_volume").attr('value', datasLog.Volume).html(datasLog.Volume + '&nbsp;&nbsp;&nbsp;<span><img src="static/images3/biao4.png"></span>').parent().find('.toggle-input').val(datasLog.Volume);
	  	  				initWater_volume_Change(datasLog.WaterBrandNo, datasLog.goodsName)

	  	  			}
	  	  			$(".littleHint").css('display', 'none');

	  	  			$("#stockNum").attr("readonly", false)

	  	  			Univalent()



	  	  		}


	  	  	})