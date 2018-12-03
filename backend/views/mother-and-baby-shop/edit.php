<!DOCTYPE html>
<html style="overflow-x:hidden;overflow-y:hidden">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible"content="IE=9; IE=8; IE=7; IE=EDGE">

    <link rel="stylesheet" href="./static/js/zui/css/zui.css"/>
    <link rel="stylesheet" href="./static/js/zui/css/style.css"/>
    <link rel="stylesheet" href="./static/css/addgood.css"/>
    <link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>
    <link rel="stylesheet" href="./static/js/datepicker/dateRange.css"/>
    <link rel="stylesheet" href="./static/js/page/jquery.pagination.css"/>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
     <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <style>

	body{
		height:100%;
		width:100%;
		overflow:auto;
        padding:10px;
	}
	   .good_sub_type label {
    height: 25px;
    line-height: 35px;
    }

	    .exchang{
    position:absolute;
    cursor: pointer;    width: 40px;
    }
	select, .chosen-container {
		width: 100px !important;
		height: 30px;
		min-width:  100px  !important;  
		border:none;
	}
	.GoodsA  .chosen-container{
	   min-width:  150px  !important;  
	}
	#good_sub_type_c .item:first-child{
		margin-top:0;
	}
    .separator{
        padding:10px 20px;
    }
 </style>
 <body>
<div class="main-title">
    <h2 id="mytitle">母婴修改商品</h2>
</div>
<div class="content_middle">
	<div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['mother-and-baby-shop/list'],['class'=>'btn btn-primary  connection'])?></div>
	<div class="separator">
	    1、基本信息
	</div>	
</div>
 <div class="detail1">
 	       <div class="item GoodsA">
            <div class="ftitle"><span class="tip">*</span><span class="title">账户名称：</span></div>

            <div class="fcontent">
                <select id="merchantid" class="baseinput"  " disabled="disabled">
                	<option value="">请选择服务中心</option>
                </select>
            </div>
        </div>
         <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">商户店铺名称：</span></div>
            <div class="fcontent"><input placeholder="请输入店铺名称" id="name" type="text" class="baseinput"/></div>
        </div>
        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">商户简介：</span></div>
            <div class="fcontent">
                <input placeholder="商户简介" id="title" type="text" class="baseinput"/>
                <span class="mark">（用于前端显示）</span>
            </div>
        </div>
        <div class="item" style="margin-bottom: 40px">
            <div class="ftitle"><span class="tip">*</span><span class="title">订水电话：</span></div>
            <div class="fcontent">
<!--                <input id="id" type="text" class="baseinput"/>-->
                <input id="tel1" placeholder="请输入订水电话" type="text" class="baseinput"/><br />
                <input id="tel2" placeholder="请输入订水电话" type="text" class="baseinput"/>
            </div>
        </div>
        <div class="item" style="height:auto;">
            <div class="ftitle"><span class="tip">*</span><span class="title">选择商品：</span></div>
            <div class="fcontent" style="height:auto;width:1000px;">
                <div id="good_sub_type_c" style="min-width:1400px;">

                </div>

                <p><a href="javascript:addGoodType();">继续添加</a></p>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="split"></div>

        <div class="item" style="height: 640px;line-height: 240px">
            <div class="ftitle"><span class="tip">*</span><span class="title"> 2、商户店铺图片：</span></div>
            <div class="fcontent">
            	 <div class="goodpic" style="float: left;background: none;border: none;width:400px;height: 240px">
            	 	 <div  class="item" style="margin-bottom:10px;height: 100px;line-height: 100px">
                        <div class="c3" style="height: 100px">
                            <div class="img_add_c">
                                <span id="image1span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+添加</span>
                                <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image1btn"/>
                                <img id="image1" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="">
                            </div>
                        </div>
                        <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image1')"/>
                        <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image1')"/>

                    </div>
	


                    <div class="item" style="margin-bottom:10px;height: 100px;line-height: 100px">
                        <div class="c3" style="height: 100px">
                            <div class="img_add_c">
                                <span id="image2span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+添加</span>
                                <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image2btn"/>
                                <img id="image2" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="">
                            </div>
                        </div>
                        <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image2')"/>
                        <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image2')"/>

                    </div>

                    <div class="item" style="margin-bottom:10px;height: 100px;line-height: 100px">
                        <div class="c3" style="height: 100px">
                            <div class="img_add_c">
                                <span id="image3span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+添加</span>
                                <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image3btn"/>
                                <img id="image3" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="">
                            </div>
                        </div>
                        <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image3')"/>
                        <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image3')"/>

                    </div>

                    <div class="item" style="margin-bottom:10px;height: 100px;line-height: 100px">
                        <div class="c3" style="height: 100px">
                            <div class="img_add_c">
                                <span id="image4span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+添加</span>
                                <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image4btn"/>
                                <img id="image4" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="">
                            </div>
                        </div>
                        <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image4')"/>
                        <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image4')"/>

                    </div>

                    <div class="item" style="margin-bottom:10px;height: 100px;line-height: 100px">
                        <div class="c3" style="height: 100px">
                            <div class="img_add_c">
                                <span id="image5span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+添加</span>
                                <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image5btn"/>
                                <img id="image5" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="">
                            </div>
                        </div>
                        <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image5')"/>
                        <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image5')"/>

                    </div>

                    <div class="item" style="margin-bottom:10px;height: 100px;line-height: 100px">
                        <div class="c3" style="height: 100px">
                            <div class="img_add_c">
                                <span id="image6span" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index: -1">+添加</span>
                                <input type="button" class="btn_blue"  value="" style="background:transparent;width:100%; height:100%;border: none" ng-click="upload()" id="image6btn"/>
                                <img id="image6" style="position:absolute;top:0px;left:0px;width:100%;height:100%;" src="">
                            </div>
                        </div>
                        <input type="button"  class="btn select_btn" style="margin-left: 10px;" value="预览" onclick="showimg('商品详情','image6')"/>
                        <input type="button"  class="btn select_btn" style="margin-left: 3px" value="删除" onclick="delimg('image6')"/>

                    </div>
            	 </div>
            	 <div class="goodpic" style="float: left;height: 240px">
                    <div class="item">提示：</div>
                    <div class="item">1. 最多上传6张相关图片。</div>
                    <div class="item">2. 显示尺寸大小：缩略图(220*220)，详情图（720×1080）</div>
                    <div  class="item" style="float: left;width: 18px;">3. </div>
                    <div class="item" style="float: left;width: 260px;word-wrap: break-word; ">手机详情总体大小：图片+文字+音频应小于等于1.5M，图片仅支持JPG、GIF、PNG格式；</div>
                </div>
            </div>
        </div>
 </div>
 <div id="previewDetails"  style="clear:both;padding:50px 15px;text-align: center; "></div>
    <div class="separator">
         3、营业时间
    </div>

        <div class="detail5">

        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">早上时间：</span></div>
            <div class="fcontent" style="height: 30px">
                <div style="float: left;width: 200px">
                    <input  id="starttime" type="text" class="baseinput" value="8:00"/>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">晚上时间：</span></div>
            <div class="fcontent" style="height: 30px">
                <div style="float: left;width: 200px">
                    <input  id="endtime" type="text" class="baseinput" value="22:00"/>
                </div>
                <div style="float: left;width: 440px;line-height: 18px">
                    <span class="mark" style="height: 30px;line-height:18px">（选择商户送水时间段，默认显示早上8点到晚上10点。）</span>
                </div>
            </div>
        </div>
    </div>

        <div class="separator">
        4、商户店铺管理
    </div>
    <div class="detail5">
        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">开店时间：</span></div>
            <div class="fcontent" style="height: 30px">
                <div style="float: left;width: 200px">
                    <input  id="opentime" type="text" class="baseinput" value="<?=date('Y-m-d H:i:s',time())?>"/>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">关店时间：</span></div>
            <div class="fcontent" style="height: 30px;">
                <div style="float: left;width: 200px">
                    <input  id="closetime" type="text" class="baseinput" value="2099-1-1 00:00:00"/>
                </div>
                <div style="float: left;width: 440px;line-height: 18px">
<!--                    <span class="mark" style="height: 30px;line-height:18px">（勾选“立即销售”，设置下架时间后，点击“保存”，系统会在您设置的时间自动进行下架操作，下架时间为空时，默认该商品下架时间很长。）</span>-->
                </div>
            </div>
        </div>
    </div>

     <div class="detail5">
        <input type="button" class="btn select_btn" value="保存" onclick="savegood()"/>
    </div>
<!--弹出层时背景层DIV-->  
<div id="fade" class="black_overlay">  
</div>  
 <div id="MyDiv" class="white_content">  
  <div style="text-align: right; cursor: default; height: 40px;   position: fixed;
    background: #2d2d35;
    padding: 5px 15px;
    right: 11%;">  
   <span style="font-size: 16px;" onclick="CloseDiv('MyDiv','fade')">关闭</span>  
  </div>  
  
  <img src="" alt="" width=100%>
 </div> 


 </body>
 </html>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>


<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="./static/js/mother-and-baby-shop/conter.js"></script>
<script type="text/javascript">  
//弹出隐藏层  
function ShowDiv(show_div,bg_div){  
 document.getElementById(show_div).style.display='block';  
 document.getElementById(bg_div).style.display='block' ;  
 var bgdiv = document.getElementById(bg_div);  
 bgdiv.style.width = document.body.scrollWidth;   
 // bgdiv.style.height = $(document).height();  
 $("#"+bg_div).height($(document).height());  
};  
//关闭弹出层  
function CloseDiv(show_div,bg_div)  
{  
 document.getElementById(show_div).style.display='none';  
 document.getElementById(bg_div).style.display='none';  
};  
</script> 

<script>
var agent= <?=json_encode($agent)?>;
var agent_id= <?=json_encode($agent_id)?>;
var goods= <?=json_encode($goods)?>;
var shop = <?=json_encode($shop )?>;

	 var type1= <?=json_encode($type1)?>;
	 var type2= <?=json_encode($type2)?>;


    //开店时间弹框
    jeDate({
        dateCell:"#opentime",
        isinitVal:true,
        isTime: true
    });

    //关店时间弹框
    jeDate({
        dateCell:"#closetime",
        isinitVal:true,
        isTime: true
    });


    //限制电话
    $('#tel1').blur(function(){
        var tel1=$(this).val();
        if(tel1!=''){
            if(isNaN(tel1)||tel1.length!=10&&tel1.length!=11&&tel1.length!=12 ){
                alert("电话号码必须是10位或11位的数字或12位的数字");
                $(this).val('');
                $(this).focus();
            }

        }
    });
    $('#tel2').blur(function(){
        var tel2=$(this).val();
        if(tel2!=''){
            if(isNaN(tel2)||tel2.length!=10&&tel2.length!=11&&tel2.length!=12){
                alert("电话号码必须是10位或11位的数字或12位的数字");
                $(this).val('');
                $(this).focus();
            }

        }
    });




// console.log(goods )
// console.log(shop )
merchantidData(agent,agent_id)

htmlVal()


goodsHtml(goods)




function goodsHtml(goods){
         for(var index= 0;index < goods.length;index++){
			    if(goods[index]){
			        addGoodTypeWithData(index);
			    }
			}
	
}
function addGoodTypeWithData(index) {
	// body...
	// console.log(index)
	   var itemAmount=$("#good_sub_type_c").find(".item").length;
	   var currentIndex=itemAmount+1;

// alert(currentIndex)
    var itemStr=' <div class="item"  style="position: relative;" id="item'+currentIndex+'" itemid="100">'+
        '<p class="exchang">上移<img src="/static/images3/arrowA.png" alt=""></p>'+
        '<div class="good_sub_type" style="margin-left:50px;">'+

        '<select onchange="change1('+currentIndex+')" id="category1_id'+currentIndex+'" type="text" class=" realPrice baseinput fl category1_id" style="width:100px;margin-right:15px"><option value="">商品属性</option></select>'+

        '<select onchange="change5('+currentIndex+')" id="category2_id'+currentIndex+'" type="text" class="category2_id realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品二级分类</option></select>'+


        '<select onchange="change2('+currentIndex+')" id="goodsbrand'+currentIndex+'" type="text" class="goodsbrandName realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品品牌</option></select>'+
        '<select onchange="change3('+currentIndex+')" id="goodsname'+currentIndex+'" type="text" class="goodsname realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品名称</option></select>'+

        '<select  id="goodsvolume'+currentIndex+'" type="text" class="goodsvolume realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品容量</option></select>'+

 
        '<label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="">商品结算价</label><input value="'+goods[index].realPrice+'" id="realPrice'+currentIndex+'" type="text" class="realPrice realPriceRmb baseinput " style="width:50px;"/>'+

 '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品原价</label><input value="'+goods[index].originalPrice+'" id="originalPrice'+currentIndex+'" type="text" class=" originalPrice originalPriceRmb baseinput " style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品库存</label><input value="'+goods[index].goodsstock+'" id="goodsstock'+currentIndex+'" type="text" class=" originalPrice goodsstock baseinput " style="width:50px;"/>'+


        // '<label for="sort'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;排序</label><input value="'+goods[index].sort+'" id="sort'+currentIndex+'" type="text" class="sort baseinput " style="width:50px;"/>'+


        '<a href="javascript:void(0);"  class="delGoodType" style="margin-left:5px;height:25px;line-height: 25px;">&nbsp;&nbsp;&nbsp;删除</a>'+
        '</div>'+
        '<div style="clear:both;"></div>'+
        '</div>';

  $("#good_sub_type_c").append($(itemStr));
      //添加商品分类数据
    $('#category1_id'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#category2_id'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#goodsbrand'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#goodsname'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#goodsvolume'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen

  //添加商品分类数据
    var html="";
    $(type1).each(function(i,v){
        if(v){
        	// console.log(v.Id)
        	if(goods[index].category1_id==v.Id){
        		 html+="<option value='"+v.Id+"' selected>"+ v.Name+"</option>"
        	}else{
        		 html+="<option value='"+v.Id+"' >"+ v.Name+"</option>"
        	}
           
         }
    });
// console.log(html)

     $(html).appendTo('#category1_id'+currentIndex);
      $('#category1_id'+currentIndex).trigger("chosen:updated");
      $(".delGoodType").on("click",function(){
        $(this).parents(".item").eq(0).remove();
      });

  if(goods[index].category1_id){
        var html = "<option value=''>选择二级分类</option>";
        $(type2).each(function(i,v){
            if(v){
            	if(goods[index].category1_id==v.ParentId){
            		   if(goods[index].category2_id==v.Id){
							 html+="<option value='"+v.Id+"' selected>"+ v.Name+"</option>"
			        	}else{
			        		 html+="<option value='"+v.Id+"' >"+ v.Name+"</option>"
			        	}
            		  
            	}
             }
        });
        // console.log(html)
        $('#category2_id' + currentIndex).html('');
        $(html).appendTo('#category2_id' + currentIndex);
        $('#category2_id' + currentIndex).trigger("chosen:updated");

  }


  if(goods[index].category2_id){
		  	var objCategory = {
		        'category2_id': goods[index].category2_id,
		        'category1_id': goods[index].category1_id
		    };
       var ii=layer.msg('加载品牌...', {time: 0 });
	     $.get('./?r=mother-and-baby-shop/get-brands',objCategory , function (data) {
	            	var data = stringArr(data)
	            	layer.close(ii)
	            		// console.log(objCategory)
	            		// console.log(data)
	            		if(data.state==-1){
	            			layer.msg(data.msg);
	            			return;
	            		}
	                 if (data.datas.length) {
	                     var html = "<option value=''>选择品牌</option>";
	                       $(data.datas).each(function (i, v) {
	                       	     
	                          if (v) {
	                          	var v =nullUndefined(v) ;
	                          	  if(goods[index].goodsbrand==v.BrandNo ){
	                          	  	 html += "<option value='" + v.BrandNo + "' selected>" + v.BrandName + "</option>"
	                          	  }else{
	                          	  	 html += "<option value='" + v.BrandNo + "'>" + v.BrandName + "</option>"
	                          	  }
	                             
	                            }
	                       })
	                         $('#goodsbrand' + currentIndex).html('');
	                         $(html).appendTo('#goodsbrand' + currentIndex).trigger("chosen:updated");
	                         // $('#goodsname'+currentIndex).html("<option value=''>选择商品</option>").trigger("chosen:updated");;
	                         // $('#goodsvolume' + currentIndex).html("<option value=''>选择容量</option>").trigger("chosen:updated");;
	                 }            
	            })
  }

  if(goods[index].goodsbrand){
	  	 var objCategory = {
	        'category2_id': goods[index].category2_id,
		    'category1_id': goods[index].category1_id,
	        'brand_id':goods[index].goodsbrand
	    };
	      var ii=layer.msg('加载名称...', {time: 0 });
		    $.get('./?r=mother-and-baby-shop/get-goods',objCategory,function(data){
		    	layer.close(ii)
				    var data = stringArr(data)
					// console.log(data)
					if(data.state==-1){
						layer.msg(data.msg);
						return;
					}
					if (data.datas.length) {
		                     var html = "<option value=''>选择品牌</option>";
		                       $(data.datas).each(function (i, v) {
		                          if (v) {
		                          	var v =nullUndefined(v) ;
		                              // html += "<option value='" + v.id + "'>" + v.name + "</option>"

		                                 if(goods[index].goodsname==v.name ){
	                          	  			 html += "<option value='" + v.id + "' selected>" + v.name + "</option>"
			                          	  }else{
			                          	  	 html += "<option value='" + v.id + "'>" + v.name + "</option>"
			                          	  }
		                            }
		                       })
		             $('#goodsname' + currentIndex).html('');
		             $(html).appendTo('#goodsname' + currentIndex).trigger("chosen:updated");
		             $('#goodsvolume' + currentIndex).html("<option value=''>选择容量</option>").trigger("chosen:updated");;
		              }
		        });
  }

  if(goods[index].goodsname){
  	 var objCategory = {
	        'category2_id': goods[index].category2_id,
		    'category1_id': goods[index].category1_id,
	        'brand_id':goods[index].goodsbrand,
	        'goods_name':goods[index].goodsname,
	    };
	              var ii=layer.msg('加载容量...', {time: 0 });
              
            $.get('./?r=mother-and-baby-shop/get-volume',objCategory,function(data){
          	layer.close(ii)
          	var data = stringArr(data)
      			// console.log(data)
      			if(data.state==-1){
      				layer.msg(data.msg);
      				return;
      			}
				if (data.datas.length) {
	                     var html = "<option value=''>选择容量</option>";
	                       $(data.datas).each(function (i, v) {
	                          if (v) {
	                          	var v =nullUndefined(v) ;
	                              // html += "<option value='" + v.volume + "'>" + v.volume + "</option>"
	                               if(goods[index].goodsvolume==v.volume ){
                      	  			  html += "<option value='" + v.volume + "' selected>" + v.volume + "</option>"
	                          	  }else{
	                          	  	  html += "<option value='" + v.volume + "'>" + v.volume + "</option>"
	                          	  }
	                            }
	                       })
	              $('#goodsvolume' + currentIndex).html('');
	              $(html).appendTo('#goodsvolume' + currentIndex).trigger("chosen:updated");
	              }

            });


  }
}

 $('#merchantid').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
// 账户名称渲染
    function merchantidData(data,val){
     	for(var i=0;i<data.length;i++){
     		 	// console.log(i)
     		 var item = data[i]
     		 if(val==item.Id){
	 	  		 var html = '<option value="'+item.Id+'" selected>'+item.Name+'</option>'
	 	  		}else
     		 var html = '<option value="'+item.Id+'">'+item.Name+'</option>'
     		 $("#merchantid").append(html)
     	}
 }
// console.log(agent)
// console.log(type2)

function htmlVal(){
	$("#name").val(shop.shop_name)
	$("#title").val(shop.shop_detail)
	$("#tel1").val(shop.shop_tel1)
	$("#tel2").val(shop.shop_tel2)
	$("#starttime").val(shop.morning)
	$("#endtime").val(shop.night)
	$("#opentime").val(shop.open_time)
	$("#closetime").val(shop.close_time)
	$("#image1").attr("src",shop.image1)
	$("#image2").attr("src",shop.image2)
	$("#image3").attr("src",shop.image3)
	$("#image4").attr("src",shop.image4)
	$("#image5").attr("src",shop.image5)
	$("#image6").attr("src",shop.image6)
}


function savegood(){

    var agent1=$("#categoryid").find("option:selected").attr('value');//运营中心
    var agent2=$("#merchantid").find("option:selected").attr('value');//服务中心

    var name=$.trim($("#name").val());
    if(name.length==0){
        alert("商户店铺名称不能为空！");
        $("#name").focus();
        return false;
    }
    var detail= $.trim($("#title").val());
    if(detail.length==0){
        alert("商户简介不能为空！");
        $("#title").focus();
        return false;
    }
    var tel1= $.trim($("#tel1").val());
    var tel2= $.trim($("#tel2").val());
    if(tel1==""&&tel2==''){
        alert("定水电话不能为空");
        $("#tel1").focus();
        return false;
    }

    // console.log(4)

    var goodType=getSubGoodTypeJson();//选择商品的内容

   if((JSON.parse(goodType)).length==0){
        alert("您还未添加商品!");
        return false;
    }

    var image1=  $("#image1").attr("src");
    var image2=  $("#image2").attr("src");
    var image3=  $("#image3").attr("src");
    var image4=  $("#image4").attr("src");
    var image5=  $("#image5").attr("src");
    var image6=  $("#image6").attr("src");
    if($.trim(image1)==""){
        alert("第一张商户店铺图片不能为空");
        return false;
    }
    if($.trim(image1)=="" && $.trim(image2)=="" && $.trim(image3)==""
        && $.trim(image4)=="" && $.trim(image5)=="" && $.trim(image6)==""){
        alert("商户店铺图片不能为空");
        return false;
    }

    var starttime= $.trim($("#starttime").val());
    var endtime= $.trim($("#endtime").val());
    if(endtime==""){
        endtime="22:00";
    }

    if(starttime==''){
        starttime='8:00';
    }


    var opentime= $.trim($("#opentime").val());
    var closetime= $.trim($("#closetime").val());
    if(closetime==""){
        closetime="2099-1-1 00:00:00";
    }
    var now=(new Date()).Format("yyyy-MM-dd hh:mm:ss");
    if(opentime=''){
        opentime=now;
    }

    if(closetime<now){
        alert("关店时间必须大于当前时间");
        return;
    }
    if(opentime!=""&&closetime!=""&&opentime>closetime){
        alert("关店时间必须大于开店时间");
        return;
    }
var ii=layer.msg("操作中……");
var obj = eval('(' + goodType+ ')') 
var datao={
       name:encodeURIComponent(name),
       tel1:encodeURIComponent(tel1),
       tel2:encodeURIComponent(tel2),
       // agent1:encodeURIComponent(agent1),
       agent_id:encodeURIComponent(agent2),
       starttime:encodeURIComponent(starttime),
       endtime:encodeURIComponent(endtime),
       opentime:encodeURIComponent(opentime),
       closetime:encodeURIComponent(closetime),
       detail:encodeURIComponent(detail),
      // goods:encodeURIComponent(JSON.parse(goodType)),
       image1:encodeURIComponent(image1),
       image2:encodeURIComponent(image2),
       image3:encodeURIComponent(image3),
       image4:encodeURIComponent(image4),
       image5:encodeURIComponent(image5),
       image6:encodeURIComponent(image6),
       subgoodtypes:encodeURIComponent(goodType)
}
// console.log(data)

   $.post("/index.php?r=mother-and-baby-shop/save-edit",datao,function(data){
    	var data = stringArr(data)
    	  console.log(data)
        if(data.state!=0){
            layer.alert(data.msg);
            layer.close(ii);
            return;
        }
        else{
            layer.alert('修改成功');
            // alert('添加成功');
            window.location.replace("/index.php?r=mother-and-baby-shop/list");
        }
    });


}
function getSubGoodTypeJson(){
    var itemAmount=$("#good_sub_type_c").find(".item").length;
    if(isNaN(itemAmount)){
        return "";
    }
    if(itemAmount==0){
        return "";
    }
    var objArr=$("#good_sub_type_c").find(".item");
    var typeList=[];
    var length=typeList.length;
    var index=1;
    while(length<itemAmount){
        var typeObj={};
        typeObj.category1_id=$("#category1_id"+index).find("option:selected").attr('value');//分类

        typeObj.category2_id=$("#category2_id"+index).find("option:selected").attr('value');//二级分类

        typeObj.goodsname=$("#goodsname"+index).find("option:selected").text();//名称
        typeObj.goodsbrand=$("#goodsbrand"+index).find("option:selected").attr('value');//品牌
        typeObj.goodsvolume=$("#goodsvolume"+index).find("option:selected").attr('value');//容量
        typeObj.realPrice=$("#realPrice"+index).val();//结算价
        typeObj.originalPrice=$("#originalPrice"+index).val();//原价
        typeObj.goodsstock=$("#goodsstock"+index).val();//库存
        typeObj.sort=$("#sort"+index).val();//排序

        //避免删除后有些数据保存不了
        if(typeObj.category1_id!=undefined&&typeObj.goodsname!=undefined
            &&typeObj.goodsbrand!=undefined&&typeObj.goodsvolume!=undefined
            &&typeObj.realPrice!=undefined
            &&typeObj.originalPrice!=undefined&&typeObj.goodsstock!=undefined){
            typeList.push(typeObj);
        }
        length=typeList.length;
        index++;

    }



    return JSON.stringify(typeList);
}





</script>