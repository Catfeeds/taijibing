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
    <style>
        body{
            height:100%;
            width:100%;
            overflow:auto;
        }
    </style>
</head>
<body>

<div class="main-title">
    <h2 id="mytitle"></h2>
</div>
<div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['goods/list'],['class'=>'btn btn-primary'])?></div>
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

                <select style="background-color: #e6e6e6" id="categoryid" class="baseinput">
                </select>

                <select style="background-color: #e6e6e6" id="merchantid" class="baseinput">
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
        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">商户ID号：</span></div>
            <div class="fcontent">
                <input id="id" type="text" class="baseinput"/>
            </div>
        </div>
        <div class="item" style="height:auto;">
            <div class="ftitle"><span class="tip">*</span><span class="title">选择商品：</span></div>
            <div class="fcontent" style="height:auto;">
                <div id="good_sub_type_c">

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
                    <div class="item">1.最多上传6张相关图片。</div>
                    <div class="item">2.显示尺寸大小：缩略图(220*220)，详情图（720×1080）</div>
                    <div  class="item" style="float: left;width: 18px;">3.</div>
                    <div class="item" style="float: left;width: 260px;word-wrap: break-word; ">手机详情总体大小：图片+文字+音频应小于等于1.5M，图片仅支持JPG、GIF、PNG格式；</div>
                </div>
            </div>
        </div>
    </div>

    <div class="separator">
        3、上下架管理
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
            <div class="ftitle"><span class="tip">*</span><span class="title">上架时间：</span></div>
            <div class="fcontent" style="height: 30px">
                <div style="float: left;width: 200px">
                    <input  id="starttime" type="text" class="baseinput" value="<?=date('Y-m-d H:i:s',time())?>"/>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ftitle"><span class="tip">*</span><span class="title">下架时间：</span></div>
            <div class="fcontent" style="height: 30px">
                <div style="float: left;width: 200px">
                    <input  id="endtime" type="text" class="baseinput" value="2099-1-1 00:00:00"/>
                </div>
                <div style="float: left;width: 440px;line-height: 18px">
                    <span class="mark" style="height: 30px;line-height:18px">（勾选“立即销售”，设置下架时间后，点击“保存”，系统会在您设置的时间自动进行下架操作，下架时间为空时，默认该商品下架时间很长。）</span>
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
</form>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="./static/js/good/addgood_edit.js"></script>
<!--<script type="text/javascript" src="./static/js/good/updategood.js"></script>-->



<script type="text/javascript">
    var category=<?=json_encode($agent1)?>;
    var merchant=<?=json_encode($agent2)?>;
    var baseGood=<?=json_encode($data)?>;
    var agent=<?=json_encode($agent)?>;
    var shop=<?=json_encode($shop)?>;
    var sms='';

</script>
<script type="text/javascript">
    $('#merchantid').attr("disabled","disabled");
    $('#categoryid').attr("disabled","disabled");
//alert(shop[0].close_time)
    $('#opentime').val(shop[0].open_time);
    $('#closetime').val(shop[0].close_time);
//    console.log(baseGood[0]);
    $('#starttime').val(baseGood[0].starttime);
    $('#endtime').val(baseGood[0].endtime);



//console.log(shop)
    //显示店铺信息
    $('#name').val(shop[0].shop_name);
    $('#title').val(shop[0].shop_detail);
    $('#id').val(shop[0].shop_id);
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


for(var index= 0;index < baseGood.length;index++){
    addGoodTypeWithData(index);

}


    //显示商品信息
function addGoodTypeWithData(index){

    var itemAmount=$("#good_sub_type_c").find(".item").length;
    //alert(itemAmount);
    if(isNaN(itemAmount)){
        return;
    }
    var currentIndex=itemAmount+1;
    var itemStr=' <div class="item" id="item'+currentIndex+'" itemid="100">'+
        '<div class="good_sub_type">'+
        '<select onchange="change1('+currentIndex+')" id="goodscategory'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品属性</option></select>'+
        '<select onchange="change2('+currentIndex+')" id="goodsname'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品名称</option></select>'+
        '<select onchange="change3('+currentIndex+')" id="goodsbrand'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品品牌</option></select>'+
        '<select id="goodsfactory'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:100px;margin-right:15px"><option value="">商品厂家</option></select>'+
        '<label for="realPrice'+currentIndex+'" style="margin-left:10px;" class="fl">商品结算价</label><input value="'+baseGood[index].realPrice+'" id="realPrice'+currentIndex+'" type="text" class="realPrice baseinput fl" style="width:50px;"/>'+
        '<label for="originalPrice'+currentIndex+'" style="margin-left:10px;" class="fl"><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;商品原价</label><input value="'+baseGood[index].originalPrice+'" id="originalPrice'+currentIndex+'" type="text" class="originalPrice baseinput fl" style="width:50px;"/>'+
        '<a href="javascript:void(0);"  class="delGoodType" style="margin-left:5px;float:left;height:25px;line-height: 25px;"><span style="color: red">元</span>&nbsp;&nbsp;&nbsp;删除</a>'+
        '</div>'+
        '<div style="clear:both;"></div>'+
        '</div>';


    //添加商品分类数据
    $.get('./?r=goods/get-category',function(data){
        var html="";
        $(data).each(function(i,v){
            if(v){
                if(v.category_id==baseGood[index].goodscategory){
                    html+="<option selected='selected' value='"+v.category_id+"'>"+ v.Name+"</option>"
                }else {
                    html += "<option value='" + v.category_id + "'>" + v.Name + "</option>"
                }
            }

        });
        $(html).appendTo('#goodscategory'+currentIndex);

        //console.log(data);
    });

    //选中商品
    var category_id=baseGood[index].goodscategory;

    if(category_id){
        //添加商品名称数据
        $.get('./?r=goods/get-goods',{'category_id':category_id},function(data){
            if(data!=''){
                var html="<option value=''>选择商品名称</option>";
                $(data).each(function(i,v){
                    if(v){

                        if(v.name==baseGood[index].goodsname){
                            html+="<option selected='selected' value='"+v.name+"'>"+ v.name+"</option>"
                        }else{
                            html+="<option value='"+v.name+"'>"+ v.name+"</option>"
                        }



//                        html+="<option value='"+v.name+"'>"+ v.name+"</option>"
                    }

                });
                $('#goodsname'+currentIndex).html('');
                $(html).appendTo('#goodsname'+currentIndex);
            }else{
                var html="<option value=''>选择商品名称</option>";
                $('#goodsname'+currentIndex).html('');
                $(html).appendTo('#goodsname'+currentIndex);
            }

        });
    }else{
        var html="<option value=''>选择商品名称</option>";
        $('#goodsname'+currentIndex).html('');
        $(html).appendTo('#goodsname'+currentIndex);
    }



//选中商品品牌
    var goodsname=baseGood[index].goodsname;
    if(category_id){
        //添加商品名称数据
        $.get('./?r=goods/get-brand',{'goodsname':goodsname,'category_id':category_id},function(data){
            //console.log(data);
            if(data!=''){
                var html="<option value=''>选择商品品牌</option>";
                $(data).each(function(i,v){
                    if(v){
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
            }else{
                var html="<option value=''>选择商品品牌</option>";
                $('#goodsrand'+currentIndex).html('');
                $(html).appendTo('#goodsbrand'+currentIndex);
            }

        });
    }else{
        var html="<option value=''>选择商品品牌</option>";
        $('#goodsbrand'+currentIndex).html('');
        $(html).appendTo('#goodsbrand'+currentIndex);
    }

//选中厂家
    var brand_id=baseGood[index].goodsbrand;

    if(brand_id){
        //添加商品名称数据
        $.get('./?r=goods/get-factory',{'goodsname':goodsname,'category_id':category_id,'brand_id':brand_id},function(data){
            //console.log(data);
            if(data!=''){
                var html="<option value=''>选择厂家</option>";
                $(data).each(function(i,v){
                    if(v){
                        if(v.Id==baseGood[index].goodsfactory){
                            html+="<option selected='selected' value='"+v.Id+"'>"+v.Name+"</option>"
                        }else {
                            html += "<option value='" + v.Id + "'>" + v.Name + "</option>"
                        }

                    }

                });
                //console.log(html);
                $('#goodsfactory'+currentIndex).html('');
                $(html).appendTo('#goodsfactory'+currentIndex);
            }else{
                var html="<option value=''>选择厂家</option>";
                $('#goodsfactory'+currentIndex).html('');
                $(html).appendTo('#goodsfactory'+currentIndex);
            }

        });
    }else{
        var html="<option value=''>选择厂家</option>";
        $('#goodsfactory'+currentIndex).html('');
        $(html).appendTo('#goodsfactory'+currentIndex);
    }


    $("#good_sub_type_c").append($(itemStr));
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



</script>
</body>
</html>

