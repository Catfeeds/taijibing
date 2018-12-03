<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>库存管理</title>
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
	width: 100px;
}
.selection {
    height: 30px;
    height: 3rem;
    margin-top: 5px;
    line-height: 30px;
    line-height: 3rem;
    min-width: 250px;
}
.selection {

    min-width: 250px;
}
	.Return{
		    display: inline-block;
    text-align: center;
    border: none;
    color: #fff;background-color: #E46045;
    padding: 5px 15px;
    border-radius:5px;
    float:right;
	}

	a{
	cursor: pointer;
	}
</style>
<body>
	<div id='hotelOrder' style="padding: 10px">
		<div style='    padding: 20px;'>
			<a href="./index.php?r=stock-manage/index" id="Return"><p class='Return'>返回</p></a>
		</div>
		  
	<!--内容主题-->
	  <form action="./index.php?r=stock-manage/stock-log-list" method="post" accept-charset="utf-8">
	  	   <div class='page-head' style='    padding: 35px;padding-bottom: 0;'>
	  	   		
	            <!-- 商品选择 -->
			       <div class='head-txt'>
			            <div class="selection pull-left">
				              <span  class="selection-text  pull-left">操作：</span>
				               <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                        <select class="control-label" name="action_type"  id="action_type" class="action_type">
		                                <option value="" selected>请选操作</option>
		                                <option value="1">入库</option>
		                                <option value="2">出库</option>
		                        </select>
		                      
				             </div>
				             <div class="wrap_line" style="margin-left: 15px;">
		                    
		                         <select class="control-label" name="remark"  id="remark" class="remark">
		                          <option value="" selected>请选备注</option>
		                          <option value="1">进货</option>
		                          <option value="2">送水</option>
		                          <option value="3">退货</option>
		                          <option value="4">登记</option>
		                          <option value="5">初始化</option>
		                        </select>
				             </div>
				           </div>
			             </div>
			             <div class="selection pull-left" style="margin-left: 20px;    margin-top: -2px;">
				             	 <!-- 时间容器 -->
						 		 <div class="selection pull-left" >
									<span  class="selection-text  pull-left">时间段选择：</span>
											 <div class="ta_date" id="div_date_demo">
										        <span class="date_title" id="date_demo">请选择时间段</span>
										        <a class="opt_sel" id="input_trigger_demo" href="#">
										            <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
										        </a>
										     </div>
							 
								    <div id="datePicker"></div>
			  					  </div>

			  					  <div style="display: none">
						          	    <input type="text" name="start_time" id="time1sub"  value="">
						                <input type="text" name="end_time" id="time2sub" value="">
						                <input type="text" name="agent_id" value="<?=json_decode($where_datas)->agent_id?>">
						                <input type="text" name="brand_id" value="<?=json_decode($where_datas)->brand_id?>">
						                <input type="text" name="factory_id" value="<?=json_decode($where_datas)->factory_id?>">
						                <input type="text" name="goods_id" value="<?=json_decode($where_datas)->goods_id?>">
						                <input type="text" name="volume" value="<?=json_decode($where_datas)->volume?>">
						               
						          </div> 
			             </div>
			       </div>
			  

					<div class='head-txt'>
						   
						   <!-- 搜索容器 -->
             <div class="selection pull-left" id="searchbg" >


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
		   			<th class='sort' sort='0'>序号</th>
		   			<th>名称</th>
		   			<th>电话</th>
		   			<th>厂家</th>
		   			<th>条码</th>
		   			<th>品牌</th>
		   			<th>商品名称</th>
		   			<th>商品规格</th>
		   			<th>操作</th>
		   			<th><a  data = 'num'>数量</a></th>
		   			<th><a  data = 'rest_stock'>剩余库存</a></th>
		   			<th><a  data = 'total'>累计总数量</a></th>
		   			<th>备注</th>
		   			<th><a  data = 'row_time'>时间</a></th>

		   		</tr>
		   	</thead>
		   	<tbody id="dev_list_body">
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
<!-- <script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script> -->
<script type="text/javascript" src="/static/js/paging3.js"></script>

<script>
var where_datas=<?=$where_datas?>;
var form_datas=<?=$form_datas?>;
var total = <?=$total?>;
   var url=<?=json_encode($url)?>;
console.log(form_datas)
 for(var z in where_datas){
  	 if(where_datas[z]==null){
  	 	where_datas[z]=''
  	 }
  }

$("#action_type").val(where_datas.action_type);
$("#remark").val(where_datas.remark);
$("#searchp").val(where_datas.search);

     $("#action_type").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
     $("#remark").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen

if(whether(where_datas.start_time)){
	 $("#date_demo").text('请选择时间段');
}

$("#Return").click(function(){
    if(url){
    	  var _thisURl = $(this).attr('href');
    	$(this).attr('href',_thisURl+url);
   
    }
})

 $("#removerSub").bind('click',function(){
	$("#action_type").val('').trigger("chosen:updated");;
	$("#remark").val('').trigger("chosen:updated");
	$("#searchp").val('')
	$("#time1sub").val('');
	$("#time2sub").val('');
    $("#date_demo").text('请选择时间段');
		 return false;
   })
  var sort = $('.sort').attr('sort');

$(document).on('click','table  a',function(){
   var date = $(this).attr('data');
    sort++
	where_datas.sort_column=date;
    where_datas.sort=sort;
		console.log(where_datas)
		Get_datas(where_datas)

});



// 分页

  $("#page").paging({
    // pageNo: (checked_datas.offset*1+checked_datas.limit*1)/checked_datas.limit,
    pageNo: 1,
    totalPage: Math.ceil(total / 10),
    totalLimit: 10,
    totalSize: total,
    callback: function(num, nbsp) {
      var searchParameters = where_datas;
      for(var i in searchParameters){
      	  if(searchParameters[i]==null){
      	  searchParameters[i]=''
      	  }
      }
      searchParameters.offset= num * nbsp - nbsp;
      searchParameters.limit=nbsp;
	  where_datas.offset= num * nbsp - nbsp;
      where_datas.limit=nbsp;
      console.log(searchParameters)
             Get_datas(searchParameters)
    }
  });
  function  Get_datas(searchParameters){
    var ii =   layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    shadeClose: false, //开启遮罩关闭
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });
 $.post("./index.php?r=stock-manage/stock-log-page", searchParameters, function(data){
       layer.close(ii); 
       if(typeof(data)=='string'){
       	    data=  jQuery.parseJSON(data);
       }
        console.log(data.form_datas)

			dev_listdata(data.form_datas)
  })
}

 dev_listdata(form_datas)
   function dev_listdata(dev_list) {
   	$("#dev_list_body").empty();
   // console.log(dev_list)
   	if(dev_list.length){
   		var j=0;
	   	for (var i = 0; i < dev_list.length; i++) {
            j++;
            var item = dev_list[i];
	          for(var z in item){
	          	 if(item[z]==null||item[z]==''||item[z]==undefined){
	          	 	item[z]=''
	          	 }
	          }
	   var action_type,remark;
	   // OrderState,PayType;
	   //  item.State==1?(State = '成功'):(State = '失败');
	   // console.log(item.action_type)
	      switch(item.action_type*1){
	      	case 1:
			  action_type='入库'
			  break;
			  case 2:
			  action_type='出库'
			  break;
			  default:
			  Level='其它'
	       }
	        switch(item.remark*1){
	      	case 1:
			  remark= item.FromName+'进货'
			  break;
			  case 2:
			  remark=item.FromName+'送货'
			  break;
			  case 3:
                   if(item.Level==5){
                   	remark='退货给'+item.ToName
                   }else{
                   		remark=item.FromName+'退货'
                   }
			  break;
			  case 4:
			  remark='登记'
			  break;
			  case 5:
			  remark='初始化'
			  break;
			  case 6:
			  remark=item.FromName+'送货'
			  break;
			  default:
			  remark='其它'
	       }
	        var html = '<tr>';
		   		html +='<td >'+j+'</td>';
		   		html +='<td >'+item.Name+'</td>';
		   		html +='<td >'+item.ContractTel+'</td>';
		   		html +='<td >'+item.FactoryName+'</td>';
		   		html +='<td >'+item.bar_code+'</td>';
		   		html +='<td >'+item.BrandName+'</td>';
		   		html +='<td >'+item.GoodsName+'</td>';
		   		html +='<td >'+item.volume+'</td>';
		   		html +='<td >'+action_type+'</td>';
				html +='<td >'+item.num+'</td>';
				html +='<td >'+item.rest_stock+'</td>';
				html +='<td >'+item.total+'</td>';
				html +='<td >'+remark+'</td>';
				html +='<td >'+item.row_time+'</td>';

    //              if(item.Id&&item.factory_id&&item.goods_id&&item.brand_id&&item.volume){
    //              	html +='<td ><a href="./index.php?r=stock-manage/stock-log-list&factory_id='+item.factory_id+'&agent_id='+item.Id+'&goods_id='+item.goods_id+'&brand_id='+item.brand_id+'&volume='+item.volume+'">查看</a></td>';
    //              }else{
    //              	html +='<td >查看</td>';
    //              }
		  //  		html +='<td ><a href="./index.php?r=stock-manage/add-stock&level='+item.Level+'&agent_id='+item.Id+'&goods_name='+item.goods_name+'&brand_id='+item.brand_id+'&category_id='+item.category_id+'&category2_id='+item.category2_id+'&volume='+item.volume+'">添加库存</a></td>';	
		   		html += '/<tr>';

	      $("#dev_list_body").append(html)	
	   	}
    }
  }




  // 时间选择
    var dateRange = new pickerDateRange('date_demo', {
      //aRecent7Days : 'aRecent7DaysDemo3', //最近7天
      isTodayValid: true,
 		startDate: where_datas.start_time,
      endDate:where_datas.end_time,
      //needCompare : true,
      //isSingleDay : true,
      //shortOpr : true,
      //autoSubmit : true,
      defaultText: ' 至 ',
        // format : 'YYYY-MM-DD HH:mm:ss', //控件中from和to 显示的日期格式
      inputTrigger: 'input_trigger_demo',
      theme: 'ta',
      success: function(obj) {
        $("#dCon_demo").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
        $("#time1sub").val(obj.startDate)
        $("#time2sub").val(obj.endDate)

        console.log(obj.endDate)
      }
    });



// json 格式化
function  jsonObj(data){
var objData;
	if(typeof(data)=='string'){
	   objData=  jQuery.parseJSON(data);
	}

	return objData

}


// 数组对象去重
function  arrayUnique(arr,name){
	if(arr.length){
		var hash = {};
		arr = arr.reduce(function(item, next) {
			// console.log(next)
		    hash[next[name]] ? '' : hash[next[name]] = true && item.push(next);
		    return item
		}, [])
		return arr;
	}

}





// 判断是否有效
function whether(data){
  if(data&&data!=''&&data!=null&&data!=undefined){
  	return true;
  }else{
  	return false;
  }

}
</script>
</html>