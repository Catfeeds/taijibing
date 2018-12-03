<!DOCTYPE html>
<html>
<head>
	<title>添加库存</title>
</head>

 <link rel="stylesheet" href="./static/css/chosen.css"/>

 <script type="text/javascript" src="./static/js/jquery.min.js"></script>
 <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
     <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
<style type="text/css" media="screen">
table tr{
height:50px;
line-height:50px;
}
	td:first-of-type{
		width:20%;
		text-align:right;
		
	}
	td:last-of-type{
		/*width:80%;*/
		text-align:left;
		padding-left:20px;
	}
	.inp{
    width: 250px;
    background-color: #2D3136;
    border: 1px solid #2D3136;
    height: 30px;
    color: #fff;
    padding: 5px;
    border-radius: 2px;
}
input {
    width: 200px;
    height: 20px;
    background-color: #2D3136;
    border: 1px solid #2D3136;
    padding: 5px;
    border-radius: 2px;
    color: #BABABF;
    outline: none;
}
.tail{
width:100%;
		    display: inline-box;
		    display: -webkit-inline-box;margin-top: 65px;
}
  .tail p{
		margin:0;
		margin-left:10px;
		padding:5px 10px;
		background:#2D3136;
		border-radius: 5px;
		color:#fff;
	}
	.tail *:hover{
		background:#42474e;
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
	select, .chosen-container {
   width: 160px !important;
    height: 30px;
    min-width: inherit !important;
    border: none;
}

  #dvCBs{
 
      width: 100%;
      margin:0 auto;
      padding-left:5px; 
         display: inline;
  }
  
   #dvCBs .radio_btn{
     background: #2D3136;
     display: inline-block;
     width: 20px;
     height:20px;
     border-radius: 250px;
     position: relative;
     vertical-align: middle;
     margin-top: -13px;
  }
    #dvCBs input{
     width: 100%;
     height: 100%;
     position: absolute;
     top: 0;
     left: 0;
     z-index: 100;
     opacity: 0;
  }
    #dvCBs span{
     background: #EE5030;
     width: 10px;
     height: 10px;
     display: inline-block;
     position: absolute;
     z-index: 1;
     top: 5px;
     left: 5px;
     border-radius: 10px;
  }
   #dvCBs input[type="radio"] + span{
     opacity: 0;
  }
  #dvCBs input[type="radio"]:checked + span{
     opacity: 1;
  }
  #dvCBs label {
	    position: relative;
	    margin-left: 15px;
	}
</style>
<body style=" padding: 20px;">
	<!-- <form action="./index.php?r=goods-type/add-goods-type" method="post" accept-charset="utf-8"> -->
	     
        <a href="./index.php?r=stock-manage/index" id="Return"><p class='Return'>返回</p></a>
       <table>
    	<caption style="    text-align: left;">添加商品库存</caption>
    	<tbody>
    		<tr>
    			<td >选择商品&nbsp;:</td>
    			<td>
    				<select  name="category_one"  style="width:250px;" id="category_one" class="category_one"> 
					    <option  value='' >选择商品分类</option>
					</select>
					<select  name="category_two"  style="width:250px;" id="category_two" class="category_two"> 
					    <option  value='' >选择二级分类</option>
					</select>
    			</td>
          <!-- <td colspan="" rowspan="" headers=""><p>当不选择上级分类时自动为顶级分类</p> </td> -->
    		</tr>
    		<tr>
    			<td></td>
    			<td>
    				<select  name="BrandName"  style="width:250px;" id="BrandName" class="BrandName"> 
					    <option  value='' >选择商品品牌</option>
					</select>
    			</td>
            <!-- <td colspan="" rowspan="" headers="">  </td> -->
    		</tr>
    		<tr>
    			<td></td>
    			<td>
    				<select  name="goods_name"  style="width:250px;" id="goods_name" class="goods_name"> 
					    <option  value="0" >选择商品名称</option>
					</select>
    			</td>
            <!-- <td colspan="" rowspan="" headers="">  </td> -->
    		</tr>
			<tr>
    			<td>商品规格：</td>
    			<td>
					<div class="volumeGoods" data="" style="padding-left:5px;  margin-top: 5px;">
						<div id="dvCBs" style="      width: inherit;  display: inline-block;">       
							<span class="radio_btn"> 
								<input name="false" type="radio" checked="" value="" id="state1" class="state">
								<span></span>
							</span>
							<label for="state1" style="">无L</label>
						</div>
					</div>
    			</td>
    		</tr>
    		<tr>
    			<td>选择厂家：</td>
    			
    			<td>
    				<select  name=""  style="width:250px;" id="get_factory" class=""> 
					      <option  value="" >选择厂家/供应商</option>
					</select>
    			</td>
            <!-- <td colspan="" rowspan="" headers="">  </td> -->
    		</tr>
    			<tr>
    			<td>添加库存数量：</td>
    			<td>
    				<input type="number" name="" value="" id="volume_num">
    				<span>（已有库存：<span id="volume_num1">0</span>,上级库存<span id="volume_num2">0</span> ）</span>
    			</td>
            <!-- <td colspan="" rowspan="" headers="">  </td> -->
    		</tr>
    	</tbody>

    	    <div style="display:none" >
          	<input type="text" name='level' value='0' class="level">
          </div>
    </table>
    <div class='tail'>
        	<button  class='Reset inp submit'  disa=true style='width:60px;text-align: center;    background-color: #E46045;' > 保存</button >
    	<p class='Reset' id='removerSub' style="cursor: pointer;width:50px;display: inline-block;"> 重置</p>
    </div>
	<!-- </form> -->
</body>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>	
<script> 
	  var checkde_datas = eval('(' + <?=json_encode($checkde_datas)?> + ')');
	  var select_datas = eval('(' + <?=json_encode($select_datas)?> + ')');
	   var url=<?=json_encode($url)?>;
	
     console.log(checkde_datas);
     console.log(select_datas);
$("#Return").click(function(){
    if(url){
    	  var _thisURl = $(this).attr('href');
    	$(this).attr('href',_thisURl+url);
   
    }
})






	  for(var i=0 in checkde_datas){

	  	if(!checkde_datas[i]){
	  		checkde_datas[i]=''
	  	}
	  }
	  // console.log(checkde_datas)
	 $("#category_one").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
     $("#category_two").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
     $("#BrandName").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
     $("#goods_name").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
     $("#get_factory").chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true}); //初始化chosen
 $(function(){
  	// 渲染下拉框

 select_datas_init(select_datas,checkde_datas); 	


   // get_volume()
$("#goods_name").change(function(event) {
	if($(this).val()){
     get_volume()
	}else{
		  $("#get_factory").html('<option value="">选择厂家/供应商</option>').trigger("chosen:updated");
		   $("#volume_num1").text(0);
		   $("#volume_num2").text(0);
	}


});
 

$("#volume_num").change(function(event) {
	/* Act on the event */
	var goods_name=$("#goods_name").val()
	var volume_num1=$("#volume_num1").text()
	var volume_num2=$("#volume_num2").text()
	if(!whether(goods_name)){
		layer.msg('请先选择商品');
	
	}else
	// if($(this).val()*1<1){
	//  layer.msg('添加库存不能小于1');
	//  $(this).val(1)

	// }
	// else 
		if($(this).val()*1>(volume_num2-volume_num1)){
		layer.msg('添加库存不能大于上级库存');
	    $(this).val(volume_num2-volume_num1	)

	}
});




$(".submit").click(function(){
   var disa =  $(".submit").attr('disa')  //使不可用
	var volume_num1=$("#volume_num1").text()
	var volume_num2=$("#volume_num2").text()
	// if($("#volume_num").val()*1<1){
	// 	 layer.msg('添加库存不能小于1');
	// 	 $("#volume_num").val(1)
	// 	 disa = false
	//     return;
	// 	}
	 if($("#volume_num").val()*1>(volume_num2-volume_num1)){
		layer.msg('添加库存不能大于上级库存');
	 $(this).val(volume_num2-volume_num1)
     	 disa = false
	}

 	// alert(disa)
  if(disa){
 
  	 $(".submit").attr('disa',false);
	   var category_one_val = $("#category_one").val();
	   var category_two_val = $("#category_two").val();
	   var BrandName_val = $("#BrandName").val();
	   var goods_name_val =  $("#goods_name option:selected").text();
	   var volume_num_val =  $("#volume_num").val();
	    var input_checked_val=$("#dvCBs input:checked").val(); 
   var get_factory= $("#get_factory").val();
	      var val_radio = $('#dvCBs input[type="radio"]:checked').val()||'';
	    // alert(input_checked_val)
	   var obj = {
		   	brand_id:BrandName_val,
		   	category_id:category_one_val,
		   	category2_id:category_two_val,
		   	goods_name:goods_name_val,
		   	agent_id:checkde_datas.agent_id,
		   	level:checkde_datas.level,
		   	volume:input_checked_val,
		   	volume:val_radio,
	    	factory_id:get_factory,
		   	add_stock:volume_num_val
	   }

	   var check_stock=false;
	   if(obj.level==5){
	   		   $.ajax
		   ({cache: false,
		       async: false,
		       type: 'get',
		       data:obj,
		       url: "./index.php?r=stock-manage/check-stock",
		       success: function (data) {
		        // console.log(data)
		             if(typeof(data)=='string'){
                        data=  jQuery.parseJSON(data);
                      }
                     if(data.state==-1){
                           // alert(data.msg)
                           layer.msg(data.msg)
                    }else{
                      check_stock=true;
                    }
		    }
		})
		}else{
			check_stock=true;
		}
	   // console.log(check_stock)
	   if(check_stock){
console.log(obj)


            $.get("./index.php?r=stock-manage/save-stock",obj, function(data) {
            	/*optional stuff to do after success */
            	if(typeof(data)=='string'){
                        data=  jQuery.parseJSON(data);
                }
                console.log(data)
                 if(data.state==-1){
                        layer.msg(data.msg)
                     $("#get_factory").val(checkde_datas.brand_id).trigger("chosen:updated");
                    }else{
                     $(".submit").attr('disa',true);

                      layer.msg('添加成功')
                       window.location.href='./index.php?r=stock-manage/index'+url
                    }
            });

	   }else{
	   }

	    }
})


 })


$("#get_factory").change(function(event) {

		var category_one_val = $("#category_one").val();
	   var category_two_val = $("#category_two").val();
	   var BrandName_val = $("#BrandName").val();
	   var val_radio = $('#dvCBs input[type="radio"]:checked').val()||'';
	   // console.log(val_radio)
	   var goods_name_val = $("#goods_name option:selected").text();
	   var obj = {
	   	brand_id:BrandName_val,
	   	category_id:category_one_val,
	   	category2_id:category_two_val,
	   	goods_name:goods_name_val,
        level:checkde_datas.level,
	   	agent_id:checkde_datas.agent_id,
	   	volume:val_radio,
	   	factory_id:$("#get_factory").val()
	   }
	   var _this = $(this).val()
// alert(_this)
if(_this!=0){
	get_stock(obj)
}else{
	$("#volume_num1").text(0);
		    	$("#volume_num2").text(0);
}

	 
})

function get_volume(){
	   var category_one_val = $("#category_one").val();
	   var category_two_val = $("#category_two").val();
	   var BrandName_val = $("#BrandName").val();
	   var val_radio = $('#dvCBs input[type="radio"]:checked').val()||'';
	   // console.log(val_radio)
	   var goods_name_val = $("#goods_name option:selected").text();
	   var obj = {
	   	brand_id:BrandName_val,
	   	category_id:category_one_val,
	   	category2_id:category_two_val,
	   	goods_name:goods_name_val,
        level:checkde_datas.level,
	   	agent_id:checkde_datas.agent_id,
	   	volume:val_radio,
	   	factory_id:checkde_datas.factory_id
	   }


	   // console.log(checkde_datas)
	    var ii =   layer.open({
			    type: 1,
			    skin: 'layui-layer-demo', //样式类名
			    closeBtn: 0, //不显示关闭按钮
			    anim: 2,
			    shade: [0.8, '#000'],
			    shadeClose: false, //开启遮罩关闭
			    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
			  });   



	   $.get('./index.php?r=stock-manage/get-volume-by-goods-name',obj,function(data) {
	   	/*optional stuff to do after success */
	   	// 
	   	  layer.close(ii); 
	   	  if(typeof(data)=='string'){
            data=  jQuery.parseJSON(data);
          }
          console.log(data)
            if(data.state==-1){
               layer.msg(data.msg)
       
            }else{
          
            	$("#dvCBs").empty();
                if(data.volumes.length){
                	for(var i=0;i<data.volumes.length;i++){
                     var volumes =data.volumes[i].volume;
                     if(!data.volumes[i].volume){
                     	volumes='无'
                     }

                     if(!data.volumes[i].volume){
                     	data.volumes[i].volume=''
                     }
                	  var html = '<span class="radio_btn"> ';
						if(i==0){
							obj.volume=data.volumes[i].volume
						   html+='<input name="radio" type="radio" checked  value="'+data.volumes[i].volume+'" id="state1" class="state">'  


						}else{
						     html+='<input name="radio" type="radio" value="'+data.volumes[i].volume+'" id="state1" class="state">'   	
						}
						html+='<span></span>' 
						html+='</span>'  
						html+='<label for="state1" style="">'+volumes+data.volumes[i].unit+'</label>';
					    $("#dvCBs").append(html)
                	}
                } else{
					
                	  var html = '<span class="radio_btn"> ';	
						html+='<input name="radio" type="radio" value="" id="state1" class="state">'   
						html+='<span></span>' 
						html+='</span>'  
						html+='<label for="state1" style="">无</label>';
					 $("#dvCBs").append(html)
                     $("#dvCBs").html(html)

                }

                get_factoryFun()

                get_stock(obj)
            }

         
   });
// 已经有库存


  }
function get_stock(obj){
   $.get('./index.php?r=stock-manage/get-stock',obj,function(data) {
	   	/*optional stuff to do after success */
	   	console.log(obj)
		if(typeof(data)=='string'){
		    data=  jQuery.parseJSON(data);
		  }
		  console.log(data)
		   if(data.state==-1){
		       layer.msg(data.msg)
		    }else{
		    	$("#volume_num1").text(data.stock);
		    	$("#volume_num2").text(data.stock2);
		    }
	   });
}

function  get_factoryFun(obj){

	if(!obj){
		var category_one_val = $("#category_one").val();
	   var category_two_val = $("#category_two").val();
	   var BrandName_val = $("#BrandName").val();
	   var val_radio = $('#dvCBs input[type="radio"]:checked').val()||'';
	   // console.log(val_radio)
	   var goods_name_val = $("#goods_name option:selected").text();
	   var obj = {
	   	brand_id:BrandName_val,
	   	category_id:category_one_val,
	   	category2_id:category_two_val,
	   	goods_name:goods_name_val,
        level:checkde_datas.level,
	   	agent_id:checkde_datas.agent_id,
	   	volume:val_radio,
	   	factory_id:checkde_datas.factory_id
	   }	
	}

	   // console.log(obj)
        $.get('./index.php?r=stock-manage/get-factory',obj,function(data) {
	 //   	/*optional stuff to do after success */
		if(typeof(data)=='string'){
		    data=  jQuery.parseJSON(data);
		  }
		  // console.log(obj)
		  console.log(data)
		   if(data.state==-1){
		       layer.msg(data.msg)
		    }else{
		    	if(data.factory.length){
		    		// console.log(55555555)
		    		$("#get_factory").empty();
		    		     $("#get_factory").trigger("chosen:updated");
		    		    var html = '<option value="0">选择厂家/供应商</option>';
				       for(var i=0;i<data.factory.length;i++){
				      		var item =data.factory[i];
				      	
				      		if(checkde_datas.factory_id==item.Id){
				      			 html += '<option value="'+item.Id+'"  selected="selected" >'+item.Name+'</option>';
				      		}else{
				      		     html += '<option value="'+item.Id+'">'+item.Name+'</option>';
				      		}
				        

				      	}
				      	  $("#get_factory").append(html)
				          $("#get_factory").trigger("chosen:updated");
		    	}
		    }
	   });
}






// 定义下拉框渲染函数
function select_datas_init(select_datas,checked_datas){
 category_one_init()

 if(checkde_datas.brand_id!=''){
  category_two_init();
 BrandName_init();
 goods_init();


 get_volume() 	 
  	 }

// get_stock(checkde_datas)
//  get_factoryFun(checkde_datas)


$("#category_one").change(function(event) {
/* Act on the event */

	

 $("#dvCBs").html('<span class="radio_btn"><input name="radio" type="radio" value="" id="state1" class="state"><span></span></span><label for="state1" style="">无</label>')

 	 $("input").val('')
	 $("#volume_num1").text(0)
	 $("#volume_num2").text(0)
  $("#get_factory").html('<option value="">选择厂家/供应商</option>').trigger("chosen:updated");
category_two_init()

 if(checkde_datas.brand_id!=''){
   BrandName_init()
 goods_init();	 
  	 }

  // get_volume()

});

$("#category_two").change(function(event) {
	 
 $("#dvCBs").html('<span class="radio_btn"><input name="radio" type="radio" value="" id="state1" class="state"><span></span></span><label for="state1" style="">无</label>')
	 	 $("input").val('')
	 $("#volume_num1").text(0)
	 $("#volume_num2").text(0)
	  $("#get_factory").html('<option value="">选择厂家/供应商</option>').trigger("chosen:updated");
 BrandName_init()

 goods_init()
  // get_volume()
});
$("#BrandName").change(function(event) {

 $("#dvCBs").html('<span class="radio_btn"><input name="radio" type="radio" value="" id="state1" class="state"><span></span></span><label for="state1" style="">无</label>')
	 	 $("input").val('')
	 $("#volume_num1").text(0)
	 $("#volume_num2").text(0)
	  $("#get_factory").html('<option value="">选择厂家/供应商</option>').trigger("chosen:updated");
 goods_init()
  // get_volume()
});

 $("#removerSub").bind('click',function(){
 	    $("#get_factory").html('<option value="">选择厂家/供应商</option>').trigger("chosen:updated");
		  $('select').val('').trigger("chosen:updated");
		   
 $("#dvCBs").html('<span class="radio_btn"><input name="radio" type="radio" value="" id="state1" class="state"><span></span></span><label for="state1" style="">无</label>')
		  category_two_init();
		  BrandName_init();
		  goods_init();
		  return false;
  })


// 下来渲染开始
function category_one_init(){
		// 一级分类渲染
	  if( whether(select_datas.category_one)){
	  	  var html = ''
	  	    $.each(select_datas.category_one, function (index, item) {
		           // console.log(checked_datas)
		           if(checkde_datas.category_id==item.Id){
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
	           	    	  	if(checked_datas.category2_id==item.Id){
	           	    	  	 	html+='<option value="'+item.Id+'" selected>'+item.Name+'</option>'
	           	    	  	 }else{
	           	    	  	 	html+='<option value="'+item.Id+'">'+item.Name+'</option>'
	           	    	  	 }
		           	     
		           	   }
		           }
		           // else{
	           	//    			if(checked_datas.category_two==item.Id){
	           	//     	  	 	html+='<option value="'+item.Id+'" selected>'+item.Name+'</option>'
	           	//     	  	 }else{
	           	//     	  	 	html+='<option value="'+item.Id+'">'+item.Name+'</option>'
	           	//     	  	 }
		           // 	   };
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

 console.log(goods_brandArr)
          var goods_brandArr =  newArr(select_datas.goods_brand,'category2_id')
         if(!goods_brandArr){
         	$("#BrandName").html('<option value="">请选商品品牌</option>').trigger("chosen:updated");
          return;
         }
      	  var brand = arrayUnique(goods_brandArr,'brand_id',obj);
      	 brand = arrayUnique22(brand,'brand_id',obj);

      // var goods = arrayUnique(select_datas.goods_brand,'goods_id');
      // console.log(goods_brandArr)
       var html =  goods_brand_Init(obj,brand,'BrandName','brand_id')
     

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

      // console.log(obj)
	   for (const key in obj) {              // 去除对象内多余的空值key
		    if (obj[key] === '') {
		      delete obj[key]
		    }else{
		    }
		};
     if( whether(select_datas.goods_brand)){

     	 var goods_brandArr =  newArr(select_datas.goods_brand,'category2_id')

     	if(!goods_brandArr){
         	$("#goods_name").html('<option value="">请选商品名称</option>').trigger("chosen:updated");
          return;
        }
      	 var goods = arrayUnique(goods_brandArr,'goods_id',obj);

goods = arrayUnique22(goods,'goods_id',obj);
      	      // console.log(goods)
        var html =  goods_brand_Init(obj,goods,'goods_name','goods_id')

      	   $("#goods_name").html('<option value="">请选商品名称</option>');
	       $("#goods_name").append(html).trigger("chosen:updated");
      }
   }

// 下拉框渲染逻辑
      	function goods_brand_Init(obj,data,name,id){

           var html = ''
           var objArr  = Object.keys(obj);
           console.log(data)
            if(!data){
            	return '';
            }
             var  checked_datasName='';
              var itemName=''

                 if(name=='BrandName'){
                 	checked_datasName=checked_datas.brand_id;
                 
                	 // console.log()	
                 }else  if(name=='goods_name'){
                 	checked_datasName=checked_datas.goods_name;
                 		
                 }
		    $.each(data, function (index, item) {
		    	if(name=='BrandName'){
                 	itemName=item[id];
                	 // console.log()	
                 }else  if(name=='goods_name'){
                 				itemName=item[name];
                 }
			if(objArr.length==1){

				if(obj[objArr[0]]==item[objArr[0]]){
					if(checked_datasName==itemName){
						html+='<option value="'+item[id]+'" selected>'+item[name]+'</option>'
					}else{
						html+='<option value="'+item[id]+'" >'+item[name]+'</option>'
					}
				}
                
			}else if(objArr.length==2){
				      // console.log(item[objArr[0]])
				if(obj[objArr[0]]==item[objArr[0]]&&obj[objArr[1]]==item[objArr[1]]){


					if(checked_datasName==itemName){
						html+='<option value="'+item[id]+'" selected>'+item[name]+'</option>'
					}else{
						html+='<option value="'+item[id]+'" >'+item[name]+'</option>'
					}
				}
                
			}else if(objArr.length==3){
				if(obj[objArr[0]]==item[objArr[0]]&&obj[objArr[1]]==item[objArr[1]]&&obj[objArr[2]]==item[objArr[2]]){

					if(checked_datasName==itemName){
						html+='<option value="'+item[id]+'" selected>'+item[name]+'</option>'
					}else{
						html+='<option value="'+item[id]+'" >'+item[name]+'</option>'
					}
				}
                
			}else{
				if(checked_datasName==itemName){
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




function newArr(arr,name){
	var  newArr=[];//去除空对象
   if(arr.length){
		var hash = {};
		arr = arr.reduce(function(item, next) {
			// console.log(next)
		       // hash[next[name]] ? '' : hash[next[name]] = true && item.push(next);
		       if(next[name]){
		       	// console.log(next[name])
		         	newArr.push(next)
		       }
		    return item
		}, [])
		return newArr;
	}
	// console.log(newArr)
}
// 数组对象去重
function  arrayUnique(array,name,obj){
	if(array.length){
			  var temp = {}, r = [], len = array.length, val, type,category_id=[],category2_id=[],brand_id=[];
			    for (var i = 0; i < len; i++) {
			        val = array[i];
			        type = typeof val;
                    if(obj.category_id){
                    	if(val.category_id==obj.category_id){
                    		  // console.log(val) 
                    		  category_id.push(val)
                    	}
                    }
			    }
			     if(obj.category_id){
			     	r=category_id
			     }
			     for (var i = 0; i < len; i++) {
			        val = array[i];
                    if(obj.category2_id){
                    	if(val.category_id==obj.category_id){
                    		  // console.log(val) 
                    		  if(val.category2_id==obj.category2_id){
                    		  	 category2_id.push(val);

                    		  }
                    		 
                    	}
                    }
			    }

			    if(obj.category2_id){
			     	r=category2_id
			     }

			    for (var i = 0; i < len; i++) {
			        val = array[i];
                    if(obj.brand_id){
                    	if(val.brand_id==obj.brand_id){
                    		  // console.log(val) 
                    		  if(val.brand_id==obj.brand_id){
                    		  	 brand_id.push(val)
                    		  }
                    		 
                    	}
                    }
			    }
              if(obj.brand_id){
			     	r=brand_id
			     }

         // console.log(r) 

			    return r;
	}
}

// 数组对象去重
function  arrayUnique22(arr,name){
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


