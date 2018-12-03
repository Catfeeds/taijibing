
	$(function() {
		if(datas.rest_money){
			$("#rest_money").val(datas.rest_money);
		}
       // 时间
       $("#J-xl").click(function() {
  			laydate({
  				elem: '#J-xl',
  				min:laydate.now()

  			});
  		});


	})
	  $("select").change(function(){
           	 // $("#stockNum").attr('readonly', false);
           Univalent()
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
 }


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

