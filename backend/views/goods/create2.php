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
          select, .chosen-container {
    width: 100px !important;
    height: 30px;
    min-width:  100px  !important;  
    border:none;
}

.GoodsA  .chosen-container{
  min-width:  150px  !important;  
   
}
 </style>

</head>
<body>

<div class="main-title">
    <h2 id="mytitle"></h2>
</div>

<div class="content_middle">
<!--    <div class="f1">-->
<!--        <input type="button" class="btn select_btn" value="+添加新频道" onclick="openUrl()"/>-->
<!--    </div>-->
    <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['goods/list'],['class'=>'btn btn-primary'])?></div>
    <div class="separator">
        1、基本信息
    </div>
    <div class="detail1" style="height:">


        <div class="item GoodsA">
            <div class="ftitle"><span class="tip">*</span><span class="title">账户名称：</span></div>

            <div class="fcontent">

                <select id="categoryid" class="baseinput" style="display: none">
                </select>

                <select id="merchantid" class="baseinput">
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
                <div id="good_sub_type_c" style='min-width: 1200px;'>
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
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>

<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>

<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="./static/js/good/addgood.js"></script>
<script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>



<script type="text/javascript">
    var category=<?=json_encode($agent1)?>;
    var merchant=<?=json_encode($agent2)?>;

    var sms='';
// console.log(category)
// console.log(merchant)
// alert(5)
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





    //选择运营中心后获取对应的服务中心
    $('#categoryid').change(function(){
        var agent_id=$('#categoryid option:selected').attr('value');
       

        if(agent_id==0){
        	$('#merchantid').html('');
            var html="<option value=''>请选择服务中心</option>";
             $(merchant).each(function(i,v){
             	// console.log(v)
                    html+="<option value="+ v.id+">"+ v.name+"</option>";
                });
            $(html).appendTo("#merchantid").trigger("chosen:updated");

        }else{
        	$.get('./?r=goods/get-agent',{'agent_id':agent_id},function(data){
        	// console.log(data)
            if(data!=''){
                $('#merchantid').html('');
                var html="<option value=''>请选择服务中心</option>";
                $(data).each(function(i,v){
                    html+="<option value="+ v.Id+">"+ v.Name+"</option>";
                });

                $(html).appendTo("#merchantid").trigger("chosen:updated");

            }else{
                $('#merchantid').html('');
                var html="<option value=''>请选择服务中心</option>";
                $(html).appendTo("#merchantid").trigger("chosen:updated");
            }
//            console.log(data);
        })
        }


    })



</script>
</body>
</html>

