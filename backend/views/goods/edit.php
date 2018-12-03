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


    </style>
</head>
<body>

<div class="main-title">
    <h2 id="mytitle"></h2>
</div>
<div style="text-align: right;margin-bottom: 10px"> 
    <!-- <?= \yii\bootstrap\Html::a('返回',['goods/list'],['class'=>'btn btn-primary'])?> -->
     <a class="btn btn-primary" href="index.php?r=goods/list<?=$url?>">返回</a>  
        
    </div>
<div class="content_middle">
    <!--    <div class="f1">-->
    <!--        <input type="button" class="btn select_btn" value="+添加新频道" onclick="openUrl()"/>-->
    <!--    </div>-->

    <div class="separator">
        1、基本信息
    </div>
    <div class="detail1" style="">
        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">账户名称：</span></div>

            <div class="fcontent">

                <select   id="categoryid" class="baseinput" style='width: 150px !important;display:none'>
                </select>

                <select  id="merchantid" class="baseinput"  style='width: 150px !important;'> 
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
            <div class="fcontent" style="height:auto;">
                <div id="good_sub_type_c" style="min-width:1400px;">

                </div>

                <p><a href="javascript:addGoodType();">继续添加</a></p>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="split"></div>

        <div class="item" style="height: 700px;line-height: 240px">
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
                    <div class="item">1.最多上传6张相关图片。</div>
                    <div class="item">2.显示尺寸大小：缩略图(220*220)，详情图（720×1080）</div>
                    <div  class="item" style="float: left;width: 18px;">3.</div>
                    <div class="item" style="float: left;width: 260px;word-wrap: break-word; ">手机详情总体大小：图片+文字+音频应小于等于1.5M，图片仅支持JPG、GIF、PNG格式；</div>
                </div>
            </div>
        </div>
    </div>

    <div class="separator">
        3、营业时间
    </div>
    <div class="detail5">
        <!--        <div class="item onlinetimec">-->
        <!--            <div class="ftitle"><span class="tip">*</span><span class="title">上架：</span></div>-->
        <!--            <div class="fcontent">-->
        <!--                <label style="padding-right:20px;">-->
        <!--                    <input value="0" type="radio" name="f2" />-->
        <!--                    <span>立即销售</span>-->
        <!--                </label>-->
        <!--                <label>-->
        <!--                    <input value="1" type="radio" name="f2"/>-->
        <!--                    <span>待销售</span>-->
        <!--                </label>-->
        <!--            </div>-->
        <!--        </div>-->
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
            <div class="fcontent" style="height: 30px">
                <div style="float: left;width: 200px">
                    <input  id="closetime" type="text" class="baseinput" value="2099-1-1 00:00:00"/>
                </div>
                <div style="float: left;width: 440px;line-height: 18px">
                    <!--                    <span class="mark" style="height: 30px;line-height:18px">（勾选“立即销售”，设置下架时间后，点击“保存”，系统会在您设置的时间自动进行下架操作，下架时间为空时，默认该商品下架时间很长。）</span>-->
                </div>
            </div>
        </div>
    </div>





    <!--    <div class="detail5">-->
    <!--        <input type="button" class="btn select_btn" value="保存" onclick="updategood()"/>-->
    <!--        <input type="button" class="btn select_btn" value="预览" onclick="previewgood()" style="margin-left:20px;"/>-->
    <!--    </div>-->


    <div class="detail5">
        <input type="button" class="btn select_btn" value="保存" onclick="savegood()"/>
    </div>


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

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>

<script type="text/javascript" src="./static/js/good/addgood_edit.js?v=1.2"></script>

<!--<script type="text/javascript" src="./static/js/good/updategood.js"></script>-->
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


<script type="text/javascript">

    var category=<?=json_encode($agent1)?>;
    var merchant=<?=json_encode($agent2)?>;

    var baseGood=<?=json_encode($data)?>;


    var agent=<?=json_encode($agent)?>;

    var shop=<?=json_encode($shop)?>;



    for(var index=0;index<shop.length;index++){
         var item = shop[index]
          for(var i in item){
                 
                  if(item[i])
                      if(item[i].indexOf("7xpcl7.com2.z0.glb.qiniucdn.com") != -1 ){
                          item[i] =   item[i].replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
                       }
             }
    }

    var sms='';
    // console.log(baseGood)
    // console.log(agent)
</script>
<script type="text/javascript">
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



              var exchange = function(a,b){
                var n = a.next(), p = b.prev();
                 b.insertBefore(n);
                 a.insertAfter(p);
                }; 



    $('#merchantid').attr("disabled","disabled");
    $('#categoryid').attr("disabled","disabled");
//alert(shop[0].close_time)
    $('#opentime').val(shop[0].open_time);
    $('#closetime').val(shop[0].close_time);
//    console.log(baseGood[0]);
    $('#starttime').val(shop[0].morning);
    $('#endtime').val(shop[0].night);
//console.log(shop)
    //显示店铺信息
    $('#name').val(shop[0].shop_name);
    $('#title').val(shop[0].shop_detail);
//    $('#id').val(shop[0].shop_id);
    $('#tel1').val(shop[0].shop_tel1);
    $('#tel2').val(shop[0].shop_tel2);
    $('#image1').attr('src',shop[0].image1);
    $('#image2').attr('src',shop[0].image2);
    $('#image3').attr('src',shop[0].image3);
    $('#image4').attr('src',shop[0].image4);
    $('#image5').attr('src',shop[0].image5);
    $('#image6').attr('src',shop[0].image6);
//    $('#open_time').val();//开店时间
//    $('#close_time').attr();//关店时间
//addGoodTypeWithData();
//addGoodTypeWithData();
layer.msg('加载中');
for(var index= 0;index < baseGood.length;index++){
    if(baseGood[index]){
        addGoodTypeWithData(index);
    }else{
        baseGood[index]=0
    }
    

}


    //显示商品信息
function addGoodTypeWithData(index){

    var itemAmount=$("#good_sub_type_c").find(".item").length;
    //alert(itemAmount);
    if(isNaN(itemAmount)){
        return;
    }

    var currentIndex=itemAmount+1;
    var itemStr=' <div class="item"  style="position: relative;" id="item'+currentIndex+'" itemid="100">'+
        '<p class="exchang">上移<img src="/static/images3/arrowA.png" alt=""></p>'+
        '<div class="good_sub_type" style="margin-left:50px;">'+
        '<select onchange="change1('+currentIndex+')" id="category1_id'+currentIndex+'" type="text" class=" realPrice baseinput fl category1_id" style="width:100px;margin-right:15px"><option value="">商品属性</option></select>'+

        '<select onchange="change5('+currentIndex+')" id="category2_id'+currentIndex+'" type="text" class="category2_id realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品二级分类</option></select>'+


        '<select onchange="change2('+currentIndex+')" id="goodsbrand'+currentIndex+'" type="text" class="goodsbrandName realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品品牌</option></select>'+
        '<select onchange="change3('+currentIndex+')" id="goodsname'+currentIndex+'" type="text" class="goodsname realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品名称</option></select>'+

        '<select  id="goodsvolume'+currentIndex+'" type="text" class="goodsvolume realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品容量</option></select>'+

        '<label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="">商品结算价</label><input value="'+baseGood[index].realPrice+'" id="realPrice'+currentIndex+'" type="text" class="realPrice realPriceRmb baseinput " style="width:50px;"/>'+

 '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品原价</label><input value="'+baseGood[index].originalPrice+'" id="originalPrice'+currentIndex+'" type="text" class=" originalPrice originalPriceRmb baseinput " style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品库存</label><input value="'+baseGood[index].goodsstock+'" id="goodsstock'+currentIndex+'" type="text" class=" originalPrice goodsstock baseinput " style="width:50px;"/>'+


        '<label for="sort'+currentIndex+'" style="margin-left:10px;" class=""><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;排序</label><input value="'+baseGood[index].sort+'" id="sort'+currentIndex+'" type="text" class="sort baseinput " style="width:50px;"/>'+


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
    // 添加商品分类数据
    // ('#category1_id'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $.get('./?r=goods/get-category',function(data){
        var html="";
        // console.log(data)
        $(data).each(function(i,v){
            if(v){
                if(v.category_id==baseGood[index].category1_id){
                    html+="<option selected='selected' value='"+v.category_id+"'>"+ v.Name+"</option>"
                }else {
                    html += "<option value='" + v.category_id + "'>" + v.Name + "</option>"
                }
            }
        });
        $('#category1_id'+currentIndex).html('');
        $(html).appendTo('#category1_id'+currentIndex);
        $('#category1_id'+currentIndex).trigger("chosen:updated");
        //console.log(data);
    });

    //选中商品品牌

    var category_id=baseGood[index].category1_id;

    if(category_id){
        //添加商品品牌数据
        $.get('./?r=goods/get-category2',{'category_id':category_id},function(data){
            var data = eval('(' + data+ ')')
             // console.log(data);
            if(data!=''){
                $('#category2_id'+currentIndex).html('');
                var html="<option value=''>选择品牌</option>";
                $(data.datas).each(function(i,v){
                    if(v){
                       // console.log(v);
//                        console.log(baseGood[index].goodsbrand);
                        if(v.Id==baseGood[index].category2_id){
                            html+="<option selected='selected' value='"+v.Id+"'>"+ v.Name+"</option>"
                        }else{
                            html+="<option value='"+v.Id+"'>"+ v.Name+"</option>"
                        }

//                        html+="<option value='"+v.name+"'>"+ v.name+"</option>"
                    }

                });

                $('#category2_id'+currentIndex).html('');
                $(html).appendTo('#category2_id'+currentIndex);
                 $('#category2_id'+currentIndex).trigger("chosen:updated");

            }else{
                var html="<option value=''>选择品牌</option>";
                $('#category2_id'+currentIndex).html('');
                $(html).appendTo('#category2_id'+currentIndex);
                $('#category2_id'+currentIndex).trigger("chosen:updated");
            }

        });
    }else{
        var html="<option value=''>选择品牌</option>";
        $('#goodsbrand'+currentIndex).html('');
        $(html).appendTo('#goodsbrand'+currentIndex);
        $('#category2_id'+currentIndex).trigger("chosen:updated");
    }




    var category2_id=baseGood[index].category2_id;

 if(category2_id){
           $.get('./?r=goods/get-brand',{'category1_id':category_id,'category2_id':category2_id},function(data){
                    var data = eval('(' + data+ ')');
                    if(data!=''){
                     var html="<option value=''>选择商品</option>";
                    $(data.datas).each(function(i,v){
                        if(v){
                            // console.log(v)
                            if(v.BrandNo==baseGood[index].goodsbrand){
                                html+="<option selected='selected' value='"+v.BrandNo+"'>"+ v.BrandName+"</option>"
                            }else{
                                html+="<option value='"+v.BrandNo+"'>"+ v.BrandName+"</option>"
                            }

                        }

                    });
                    //console.log(html);
                    $('#goodsbrand'+currentIndex).html('');
                    $(html).appendTo('#goodsbrand'+currentIndex);
                    $('#goodsbrand'+currentIndex).trigger("chosen:updated");
                }else{
                    var html="<option value=''>选择商品</option>";
                    $('#goodsbrand'+currentIndex).html('');
                    $(html).appendTo('#goodsbrand'+currentIndex);
                     $('#goodsbrand'+currentIndex).trigger("chosen:updated");
                }
           })
 }
//选中商品
    var brand_id=baseGood[index].goodsbrand;
    if(brand_id){
        //添加商品名称数据
        $.get('./?r=goods/get-goods',{'category1_id':category_id,'brand_id':brand_id,'category2_id':category2_id},function(data){

                   var data = eval('(' + data+ ')');
            // console.log(data);
            if(data!=''){
                var html="<option value=''>选择商品</option>";
                $(data.datas).each(function(i,v){
                    if(v){
                        if(v.name==baseGood[index].goodsname){
                            html+="<option selected='selected' value='"+v.name+"'>"+ v.name+"</option>"
                        }else{
                            html+="<option value='"+v.name+"'>"+ v.name+"</option>"
                        }
                    }
                });
                //console.log(html);
                $('#goodsname'+currentIndex).html('');
                $(html).appendTo('#goodsname'+currentIndex);
                 $('#goodsname'+currentIndex).trigger("chosen:updated");
            }else{
                var html="<option value=''>选择商品</option>";
                $('#goodsname'+currentIndex).html('');
                $(html).appendTo('#goodsname'+currentIndex);
                $('#goodsname'+currentIndex).trigger("chosen:updated");
            }

        });
    }else{
        var html="<option value=''>选择商品</option>";
        $('#goodsname'+currentIndex).html('');
        $(html).appendTo('#goodsname'+currentIndex);
        $('#goodsname'+currentIndex).trigger("chosen:updated");
    }

    // $("#good_sub_type_c").append($(itemStr));


//选中容量

    if(category_id==2){//茶吧机默认选中其他
        var html="<option value='' >其它</option>";
        $('#goodsvolume'+currentIndex).html('');
        // $('#goodsvolume'+currentIndex).html(html)
        $(html).appendTo('#goodsvolume'+currentIndex);
        $('#goodsvolume'+currentIndex).trigger("chosen:updated");
    }else {
        var goodsname = baseGood[index].goodsname;


   // console.log(goodsname,category_id,brand_id);
        if (goodsname) {

            //添加商品容量数据
            $.get('./?r=goods/get-volume', {
                'goodsname': goodsname,
                'category1_id': category_id,
                'category2_id': category2_id,
                'brand_id': brand_id
            }, function (data) {

        var data = eval('(' + data+ ')');
                if (data != '') {
                    var html = "<option value=''>选择容量</option>";
                    $(data.datas).each(function (i, v) {
                        if (v) {
                            if (v.volume == baseGood[index].goodsvolume) {
                                html += "<option selected='selected' value='" + v.volume + "'>" + v.volume + "</option>"
                            } else {
                                html += "<option value='" + v.volume + "'>" + v.volume + "</option>"
                            }

                        }

                    });
                    //console.log(html);
                    $('#goodsvolume' + currentIndex).html('');
                    $(html).appendTo('#goodsvolume' + currentIndex);
                     $('#goodsvolume'+currentIndex).trigger("chosen:updated");
                } else {
                    var html = "<option value=''>选择容量</option>";
                    $('#goodsvolume' + currentIndex).html('');
                    $(html).appendTo('#goodsvolume' + currentIndex);
                     $('#goodsvolume'+currentIndex).trigger("chosen:updated");
                }

            });
        } else {
            var html = "<option value=''>选择容量</option>";
            $('#goodsvolume' + currentIndex).html('');
            $(html).appendTo('#goodsvolume' + currentIndex);
          $('#goodsvolume'+currentIndex).trigger("chosen:updated");
        }
    }



    $(".delGoodType").unbind();
    $(".delGoodType").on("click",function(){
        $(this).parents(".item").eq(0).remove();
    });

}


    //选择运营中心后获取对应的服务中心
    $('#categoryid').change(function(){
        var agent_id=$('#categoryid option:selected').attr('value');
        $.get('./?r=goods/get-agent',{'agent_id':agent_id},function(data){
            if(data!=''){
                $('#merchantid').html('');
                var html="<option value=''>请选择</option>";
                $(data).each(function(i,v){
                    html+="<option value="+ v.Id+">"+ v.Name+"</option>";
                });

                $(html).appendTo("#merchantid");

            }else{
                $('#merchantid').html('');
                var html="<option value=''>请选择</option>";
                $(html).appendTo("#merchantid");
            }
//            console.log(data);
        })

    })

 function exchangep(a,b){
                    var n = a.next(), p = b.prev();
                     a.insertAfter(b);
                     b.insertBefore(a);
                    
}; 
$(document).on('click','.exchang',function(){
        var nextObj = $(this).parent().prev();
        var  prevObj= $(this).parent();
        exchangep(nextObj,prevObj)
})
    // alert(4)
</script>
</body>
</html>

