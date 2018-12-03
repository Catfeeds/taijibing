<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>库存管理</title>
		<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
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
</style>
<body>
	<div id='hotelOrder' style="padding: 10px">
	<!--内容主题-->
	  <form action="./index.php?r=stock-manage/index" method="post" accept-charset="utf-8">
	  	   <div class='page-head' style='    padding: 35px;'>
	  	   		
	            <!-- 商品选择 -->
			       <div class='head-txt'>
			            <div class="selection pull-left">
				              <span  class="selection-text  pull-left">商品一级分类：</span>
				               <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                        <select class="control-label" name="category_one"  id="category_one" class="category_one">
		                                <option value="" selected>请选一级分类</option>
		                        </select>
				             </div>
				           </div>
			             </div>
			             <div class="selection pull-left" style="margin-left: 20px;">
				              <span  class="selection-text  pull-left">商品二级分类：</span>
				              <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                        <select class="control-label" name="category_two"  id="category_two" class="category_two">
		                          <option value="" selected>请选二级分类</option>
		                        </select>
				             </div>
				           </div>
			             </div>
			       </div>
			        <!-- 商品选择 -->
			       <div class='head-txt'>
			            <div class="selection pull-left">
				              <span  class="selection-text  pull-left">商品品牌：</span>
				               <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                        <select class="control-label" name="BrandName"  id="BrandName" class="BrandName">
		                               <option value="" selected>请选商品品牌</option>
		                        </select>
				             </div>
				           </div>
			             </div>
			             <div class="selection pull-left" style="margin-left: 20px;">
				              <span  class="selection-text  pull-left">商品名称：</span>
				               <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                        <select class="control-label" name="goods_name"  id="goods_name" class="goods_name">
		                            <option value="" selected>请选商品名称</option>
		                        </select>
				             </div>
				           </div>
			             </div>
			       </div>
					<div class='head-txt'>
						   <div class="selection pull-left" >
				              <span  class="selection-text  pull-left">角色选择：</span>
				               <div class="region pull-left address role"  >
				             <div class="wrap_line">
		                        <select class="control-label" name="level"  id="level" class="level">
	                                <option value="" selected>请选角色选择</option>
	                                <option value="4" >运营中心</option>
	                                <option value="5" >服务中心</option>
		                        </select>
				             </div>
				           </div>
			             </div>
				 <!-- 搜索容器 -->
             <div class="selection pull-left" id="searchbg" style="margin-left: 20px;">
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
		   			<th class="sort" data='1'>序号</th>
		   			<th>角色</th>
		   			<th>名称</th>
		   			<th>联系人</th>
		   			<th>联系电话</th>
		   			<th>厂家</th>
		   			<th>商品品牌</th>
		   			<th>商品名称</th>
		   			<th>商品规格</th>
		   			<th>商品分类</th>
		   			<th>商品二级分类</th>
		   			<th> <a  class="stock"  data="stock">库存</a></th>

		   			<th><a class="update_time"  data="update_time">更新时间</a></th>
		   			<th>库存记录</th>
		   			<th>设置</th>

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
<!-- <script type="text/javascript" src="/static/js/dateRange.js"></script> -->
<!-- <script type="text/javascript" src="/static/js/monthPicker.js"></script> -->
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<!-- <script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script> -->
<script type="text/javascript" src="/static/js/paging3.js"></script>

<script>
  var select_datas = eval('(' + <?=json_encode($select_datas)?> + ')');
  var checked_datas = eval('(' + <?=json_encode($checked_datas)?> + ')');
  var form_datas = eval('(' + <?=json_encode($form_datas)?> + ')');
  console.log(checked_datas);
  if(whether(checked_datas.level)){
  	    $("#level").val(checked_datas.level)
  }
 $("#category_one").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
 $("#category_two").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
 $("#BrandName").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
 $("#goods_name").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
 $("#level").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
 $(function(){
  	// 渲染下拉框
  	select_datas_init(select_datas,checked_datas);

  if(whether(checked_datas.search)){
  	  $("#searchp").val(checked_datas.search )
  }

$(document).on('click','table  td a',function(){

var where_datas=checked_datas;
var url='';
// var result = JSON.stringify(where_datas)
for(var i in where_datas){
  if(where_datas[i]==null){
     where_datas[i]=''
  }
  url= url +"&"+ i+'='+where_datas[i]
}

    var _thisURl = $(this).attr('href');
  // console.log(where_datas);
      var Urlobj = encodeURIComponent(url);
    $(this).attr('href',_thisURl+"&Url="+Urlobj)

    // console.log(_thisURl+"&offset="+checked_datas.offset+"&limit="+checked_datas.limit+"&Url="+Urlobj)
    // return false;
}).on('click','.stock,.update_time',function(){
	  var sort_column= $(this).attr('data');
	  var stock= $('.sort').attr('data');
	   stock++
	   $('.sort').attr('data',stock)
	 console.log(stock)
	 console.log(sort_column);
	 console.log(checked_datas);

	 checked_datas.sort=stock;
	 checked_datas.sort_column=sort_column;
	 checked_datas.sort_column=sort_column;

     
    get_dev_listdata(checked_datas)

});

 })

// 分页

  $("#page").paging({
    pageNo: (checked_datas.offset*1+checked_datas.limit*1)/checked_datas.limit,
    totalPage: Math.ceil(form_datas.total / 10),
    totalLimit: 10,
    totalSize: form_datas.total,
    callback: function(num, nbsp) {

      var searchParameters = checked_datas;
      for(var i in searchParameters){
      	  if(searchParameters[i]==null){
      	  	searchParameters[i]=''
      	  }
      }
      searchParameters.offset= num * nbsp - nbsp;
      searchParameters.limit=nbsp;

	  checked_datas.offset= num * nbsp - nbsp;
      checked_datas.limit=nbsp;


      console.log(searchParameters)
             get_dev_listdata(searchParameters)

    }
  })


function  get_dev_listdata(searchParameters){
             var ii =   layer.open({
			    type: 1,
			    skin: 'layui-layer-demo', //样式类名
			    closeBtn: 0, //不显示关闭按钮
			    anim: 2,
			    shade: [0.8, '#000'],
			    shadeClose: false, //开启遮罩关闭
			    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
			  });

			  $.post("./index.php?r=stock-manage/get-page", searchParameters, function(data){
			       layer.close(ii); 
			       if(typeof(data)=='string'){
			       	    data=  jQuery.parseJSON(data);
			       }
			        // console.log(data)
 					dev_listdata(data.datas)
			  })
}
 dev_listdata(form_datas.datas)
   function dev_listdata(dev_list) {
   	$("#dev_list_body").empty();
   console.log(dev_list)
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
	   var Level;
	   // OrderState,PayType;
	//     item.State==1?(State = '成功'):(State = '失败');
	      switch(item.Level*1){
	      	case 4:
			  Level='运营中心'
			  break;
			  case 5:
			  Level='服务中心'
			  break;
			  default:
			  Level='其它'
	       }
	        var html = '<tr>';
		   		html +='<td >'+j+'</td>';
		   		html +='<td >'+Level+'</td>';
		   		html +='<td >'+item.Name+'</td>';
		   		html +='<td >'+item.ContractUser+'</td>';
		   		html +='<td >'+item.ContractTel+'</td>';
		   		html +='<td >'+item.FactoryName+'</td>';
		   		html +='<td >'+item.BrandName+'</td>';
		   		html +='<td >'+item.goods_name+'</td>';
		   		html +='<td >'+item.volume+'</td>';
		   		html +='<td >'+item.category_one+'</td>';
		   		html +='<td >'+item.category_two+'</td>';

                if(item.stock*1<200){
                	html +='<td style="color:red">'+item.stock+'</td>';
                }else{
                	html +='<td >'+item.stock+'</td>';
                }

				

				 html +='<td >'+item.update_time+'</td>';
                if(item.category_id==1){
                	if(item.Id&&item.factory_id&&item.goods_id&&item.brand_id&&item.volume){
	                 	html +='<td ><a href="./index.php?r=stock-manage/stock-log-list&factory_id='+item.factory_id+'&agent_id='+item.Id+'&goods_id='+item.goods_id+'&brand_id='+item.brand_id+'&volume='+item.volume+'">查看</a></td>';
	                 }else{
	                 	html +='<td >查看</td>';
	                 }
	             }else{
	             	if(item.Id&&item.factory_id&&item.goods_id&&item.brand_id){
	                 	html +='<td ><a href="./index.php?r=stock-manage/stock-log-list&factory_id='+item.factory_id+'&agent_id='+item.Id+'&goods_id='+item.goods_id+'&brand_id='+item.brand_id+'&volume='+item.volume+'">查看</a></td>';
	                 }else{
	                 	html +='<td >查看</td>';
	                 }
	             }
                 

		   		html +='<td ><a href="./index.php?r=stock-manage/add-stock&level='+item.Level+'&agent_id='+item.Id+'&goods_name='+item.goods_name+'&brand_id='+item.brand_id+'&category_id='+item.category_id+'&category2_id='+item.category2_id+'&volume='+item.volume+'&factory_id='+item.factory_id+'">添加库存</a></td>';	
		   		html += '/<tr>';

	      $("#dev_list_body").append(html)	
	   	}
    }
  }
// 定义下拉框渲染函数
function select_datas_init(select_datas,checked_datas){
 category_one_init()
 category_two_init();
 BrandName_init();
 goods_init();
$("#category_one").change(function(event) {
	/* Act on the event */
category_two_init()
 BrandName_init()
 goods_init();
});

$("#category_two").change(function(event) {
 BrandName_init()
 goods_init()
});
$("#BrandName").change(function(event) {
 goods_init()

});

 $("#removerSub").bind('click',function(){
 	for(var i in checked_datas){
	          	 	checked_datas[i]=''
 	}
	$("#category_one").val('').trigger("chosen:updated");
	     category_two_init();
		 BrandName_init();
		 goods_init();

		 $("#level").val('').trigger("chosen:updated");
		 $("#searchp").val('')
		  return false;
    })

// 下来渲染开始
function category_one_init(){
		// 一级分类渲染
	  if( whether(select_datas.category_one)){
	  	  var html = ''
	  	    $.each(select_datas.category_one, function (index, item) {
		           // console.log(checked_datas)
		           if(checked_datas.category_one==item.Id){
		           	html+='<option value="'+item.Id+'" selected>'+item.Name+'</option>'
		           }else{
		           	 html+='<option value="'+item.Id+'">'+item.Name+'</option>'
		           }
		          
		    });
	  	   $("#category_one").append(html).trigger("chosen:updated");
	  	   $("#category_two").html('<option value="">请选二级分类</option>').val('').trigger("chosen:updated");
	  	   $("#BrandName").html('<option value="">请选商品品牌</option>').val('').trigger("chosen:updated");
	  	   $("#goods_name").html('<option value="">请选商品名称</option>').val('').trigger("chosen:updated");

	  }
}
  // 二级分类渲染
  function category_two_init(){
	 if( whether(select_datas.category_two)){
	  	 var html =''
	  	 var category_one_val = $("#category_one").val();
	     $("#category_two").html('<option value="">请选二级分类</option>')
	// console.log(category_one_val)
	  	  $.each(select_datas.category_two, function (index, item) {
		           if(category_one_val){
		           	    if(category_one_val==item.ParentId){
	           	    	  	if(checked_datas.category_two==item.Id){
	           	    	  	 	html+='<option value="'+item.Id+'" selected>'+item.Name+'</option>'
	           	    	  	 }else{
	           	    	  	 	html+='<option value="'+item.Id+'">'+item.Name+'</option>'
	           	    	  	 }
		           	     
		           	   }
		           }else{
	           	   			if(checked_datas.category_two==item.Id){
	           	    	  	 	html+='<option value="'+item.Id+'" selected>'+item.Name+'</option>'
	           	    	  	 }else{
	           	    	  	 	html+='<option value="'+item.Id+'">'+item.Name+'</option>'
	           	    	  	 }
		           	   };
		   });
	  	   $("#category_two").append(html).trigger("chosen:updated");
	  	  	 $("#BrandName").html('<option value="">请选商品品牌</option>').val('').trigger("chosen:updated");
	  	   $("#goods_name").html('<option value="">请选商品名称</option>').val('').trigger("chosen:updated");
	  }
  };
  // 商品分类渲染
  function BrandName_init(){
	   var category_one_val = $("#category_one").val();
	   var category_two_val = $("#category_two").val();
// console.log(category_two_val)

     var obj = {
      	category_id:category_one_val,
      	category2_id:category_two_val
      }

	   for (const key in obj) {              // 去除对象内多余的空值key
		    if (obj[key] === '') {
		      delete obj[key]
		    }else{
		    }
		};

      if( whether(select_datas.goods_brand)){
      	var brand = arrayUnique(select_datas.goods_brand,'brand_id');
          // var goods = arrayUnique(select_datas.goods_brand,'goods_id');
        var html =  goods_brand_Init(obj,select_datas.goods_brand,'BrandName','brand_id')
     // console.log(html)
        $("#BrandName").html('<option value="">请选商品品牌</option>')
 		$("#BrandName").append(html).trigger("chosen:updated");
   	    $("#goods_name").html('<option value="">请选商品名称</option>').val('').trigger("chosen:updated");
      }
   }


     // 商品名称渲染
  function goods_init(){
	   var category_one_val = $("#category_one").val();
	   var category_two_val = $("#category_two").val();
	   var BrandName_val = $("#BrandName").val();
     var obj = {
      	category_id:category_one_val,
      	category2_id:category_two_val,
      	brand_id:BrandName_val,
      }
	   for (const key in obj) {              // 去除对象内多余的空值key
		    if (obj[key] === '') {
		      delete obj[key]
		    }else{
		    }
		};
 // alert(Object.keys(obj).length);
     if( whether(select_datas.goods_brand)){
      	 // var goods = arrayUnique(select_datas.goods_brand,'goods_id');

        var html =  goods_brand_Init(obj,select_datas.goods_brand,'goods_name','goods_id')
     // console.log(html)

      	   $("#goods_name").html('<option value="">请选商品名称</option>');
	       $("#goods_name").append(html).trigger("chosen:updated");
      }
   }

// 下拉框渲染逻辑
      	function goods_brand_Init(obj,data,name,id){
		// console.log(obj)
		// console.log(data)
		// console.log(name)
		// console.log(id)
           var html = ''
           var objArr  = Object.keys(obj);

       
// console.log(objArr)
           var list = []
		    $.each(data, function (index, item) {
			if(objArr.length==1){
				if(obj[objArr[0]]==item[objArr[0]]){
                    list.push(item);
				}
                
			}else if(objArr.length==2){
				if(obj[objArr[0]]==item[objArr[0]]&&obj[objArr[1]]==item[objArr[1]]){
				    list.push(item);
				}
                
			}else if(objArr.length==3){
				if(obj[objArr[0]]==item[objArr[0]]&&obj[objArr[1]]==item[objArr[1]]&&obj[objArr[2]]==item[objArr[2]]){
                   list.push(item);
				}
                
			}else{
				list.push(item);
			}
		   	     
		   })
		    // console.log(id);
		    // console.log(list);
		    if(!list.length||!list){
                return html;
		    }
           var listData =  arrayUnique(list,id);

		    // console.log(listData);
 		    $.each(listData, function (index, item) {
                   			if(objArr.length==1){
								if(obj[objArr[0]]==item[objArr[0]]){
				                    

				         
									if(checked_datas[name]==item[id]){
										html+='<option value="'+item[id]+'" selected>'+item[name]+'</option>'

									}else{
										html+='<option value="'+item[id]+'" >'+item[name]+'</option>'
									}
								}
				                
							}else if(objArr.length==2){
								if(obj[objArr[0]]==item[objArr[0]]&&obj[objArr[1]]==item[objArr[1]]){

							


									if(checked_datas[name]==item[id]){
										html+='<option value="'+item[id]+'" selected>'+item[name]+'</option>'
									}else{
										html+='<option value="'+item[id]+'" >'+item[name]+'</option>'
									}
								}
				                
							}else if(objArr.length==3){

								if(obj[objArr[0]]==item[objArr[0]]&&obj[objArr[1]]==item[objArr[1]]&&obj[objArr[2]]==item[objArr[2]]){
				     


									if(checked_datas[name]==item[id]){
										html+='<option value="'+item[id]+'" selected>'+item[name]+'</option>'
									}else{
										html+='<option value="'+item[id]+'" >'+item[name]+'</option>'
									}
								}
				                
							}else{
				              // console.log(item)
						
								if(checked_datas[name]==item[id]){
								html+='<option value="'+item[id]+'" selected>'+item[name]+'</option>'
								}else{
									html+='<option value="'+item[id]+'" >'+item[name]+'</option>'
								}
							}
 		    })



        return html ;
		  
	}

};
// 下来渲染结束




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