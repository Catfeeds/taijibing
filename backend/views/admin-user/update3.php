<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;

$this->title = "Admin";
?>



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
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <style>
        body{
            height:100%;
            width:100%;
            overflow:auto;
        }
    </style>
</head>
<body>


<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            
            <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['admin-user/index'],['class'=>'btn btn-primary'])?></div>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model['model'], 'Name')->textInput(['maxlength' => 64])->label('账户名称') ?>
                <?= $form->field($model['model'], 'ContractUser')->textInput(['maxlength' => 64])->label('联系人') ?>
                <?= $form->field($model['model'], 'ContractTel')->textInput(['maxlength' => 11])->label('联系电话') ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model['model'], 'LoginName')->textInput(['maxlength' => 11])->label('登陆账号') ?>
                <?= $form->field($model['admin_user'], 'email')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>

                <!--地址-->
                <div class="form-group field-adminroleuser-role_id required" style="margin-bottom: 80px">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">地址</label>
                    <div class="col-sm-10" id="check_address">
                        <select class="control-label" name="<?=$name?>[Province]" id="province" style="width:150px;margin-right: 20px">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="<?=$name?>[City]" id="city" style="width:150px;margin-right: 20px">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="<?=$name?>[Area]" id="area" style="width:150px;margin-right: 20px">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>

                <div class="item"  style="margin-bottom: 15px">
                    <div class="ftitle"><span class="title"> </span></div>
                    <div class="fcontent" style="padding-left: 0">
                        <input id="address" value="<?=$model['model']['Address']?>" name="<?=$name?>[Address]" type="text" class="baseinput" placeholder="请输入详细地址"/>
                        <!--                        <div class=" col-md-3 field-address">-->
                        <!---->
                        <!--                            <div class="col-sm-10"><input type="text" id="address" class="baseinput form-control" name="User[address]" placeholder="请填写详细地址信息">-->
                        <!--                                <div class="help-block m-b-none"></div></div>-->
                        <!---->
                        <!--                        </div>-->


                        <input type="button"  class="btn select_btn" style="height: 26px;margin-bottom: 5px;line-height: 15px;margin-left: 0px" value="+标记位置" onclick="get_lat_lng()"/>
                        <span>经度：</span>
                        <!--                        <div class="baseinput col-md-2 field-lng">-->
                        <!---->
                        <!--                            <div class="col-sm-10"><input type="text" id="lng" class="baseinput form-control" style="width: 80px" name="User[lng]">-->
                        <!--                                <div class="help-block m-b-none"></div></div>-->
                        <!---->
                        <!--                        </div>-->


                        <input id="lng" value="<?=$model['model']['BaiDuLng']?>" name="<?=$name?>[BaiDuLng]" type="text" class="baseinput" style="width: 80px"/>

                        <span>纬度：</span>
                        <!--                        <div class="baseinput col-md-2 field-lat">-->
                        <!---->
                        <!--                            <div class="col-sm-10"><input type="text" id="lat" class="baseinput form-control" name="User[lat]">-->
                        <!--                                <div class="help-block m-b-none"></div></div>-->
                        <!---->
                        <!--                        </div>-->

                        <input id="lat" value="<?=$model['model']['BaiDuLat']?>" name="<?=$name?>[BaiDuLat]" type="text" class="baseinput" style="width: 80px"/>
                        <span class="mark">（用于部分商品前端显示距离）</span>
                    </div>
                </div>

                <!--账户类型-->
                <div class="form-group field-adminroleuser-role_id required" style="margin-bottom: 100px;">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">账户类型</label>
                    <div class="col-sm-2">
                        <select class="control-label" name="User[type]" id="type" style="width:150px;margin-right: 20px">
                            <option  value="">请选择</option>
                            <option value="管理员">管理员</option>
                            <option value="水厂">水厂</option>
                            <option value="设备厂家">设备厂家</option>
                            <option value="运营中心">运营中心</option>
                            <option value="服务中心">服务中心</option>
                        </select>
                    </div>
                    <div id="parent" style="display: none">
                        <label class="col-sm-2 control-label" for="adminroleuser-role_id">所属运营中心</label>
                        <div class="col-sm-2">
                            <select class="control-label" name="User[agent]" id="agent" style="width:150px;margin-right: 20px">
                                <option value="">请选择</option>

                            </select>
                        </div>
                    </div>
                </div>


                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
<!--<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>-->
<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>

<!--<script type="text/javascript" src="./static/js/good/addgood.js"></script>-->


<script type="text/javascript">
    //    var category=<?//=json_encode($category)?>//;
    //    var merchant=<?//=json_encode($merchant)?>//;
    var category='';
    var merchant='';

</script>
<script type="text/javascript">

</script>




<script>
        var data=<?=$model["data"]?>;
        var province='<?=$model["model"]["Province"]?>';
        var city='<?=$model["model"]["City"]?>';
        var area='<?=$model["model"]["Area"]?>';


    //    var geoc;
    //    var cur;
    //    var map;
    //    var address='<?//=empty($model["model"]["Address"])?"":$model["model"]["Address"]?>//';
    //    var baiDuLat='<?//=empty($model["model"]["Address"])?"":$model["model"]["BaiDuLat"]?>//';
    //    var baiDuLng='<?//=empty($model["model"]["Address"])?"":$model["model"]["BaiDuLng"]?>//';
</script>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script>

//修改时不能更改账户类型
$('#type').attr("disabled","disabled");
// $('#type').css("background-color"," #e6e6e6");
$('#agent').attr("disabled","disabled");
// $('#agent').css("background-color"," #e6e6e6");
$('.btn-primary').click(function () {
    $('#type').attr("disabled",false);
    $('#agent').attr("disabled",false);
});



    //账户类型改变时
    $('#type').change(function(){

//        if(data=='服务中心'){
        //获取地址
        var province=$('#province option:selected').attr('value');
        var city=$('#city option:selected').attr('value');
        var area=$('#area option:selected').attr('value');

        if(province==''){
            alert('请选择地址');
            $('#type').val('');
        }else{

            var data=$('#type option:selected').attr('value');

            if(data=='服务中心'){
                //获取符合该地址的所有运营中心
                $.get('./?r=admin-user/get-agent',{'province':province,'city':city,'area':area},function(data){

                    if(data!=''){
                        $("#agent").html('');
                        var html="<option value=''>请选择</option>";
                        $(data).each(function(i,v){
                            html+="<option value="+ v.Name+">"+ v.Name+"</option>";
                        });


                        $(html).appendTo("#agent");
                        $('#parent').show();
                    }
                    if(data==''){
                        $("#agent").html('');
                        html="<option value='太极兵运营中心'>太极兵运营中心</option>";
                        $(html).appendTo("#agent");
                        $('#parent').show();
                    }


                });

            }else{
                $('#agent').val('');
                $('#parent').hide();
            }
        }
//        alert(data);
    });




    $(function(){

//        $("#type").attr("disabled","disabled").css("background-color","#e6e6e6;");



            var type= "<?=$model['admin_user']['type']?>";
        var agent= "<?=$model['admin_user']['agent']?>";
        var role_id= "<?=$model['role_id']?>";
//        var agent= "<?//=$model['agent']?>//";

//alert(role_id);
        if(role_id!=3){
            //选择地址改变时
            $('#check_address select').change(function(){
                $('#type').val('');
                $('#parent').hide();

            });
        }





//        alert(agent);
//        alert(agent);
        if(type){
            $('#type').val(type);
            if(type=='服务中心'){



                //运营中心登陆，选中不能修改
                if(role_id==3){

                    var sex=document.getElementById("type");
                    sex.onclick = function() {
                        var index = this.selectedIndex;
                        this.onchange = function () {
                            this.selectedIndex = index;
                        };
                    };

                    $('#type').css({'background':'#e6e6e6'});
                    $('#agent').css({'background':'#e6e6e6'});
                    $("#agent").html('');
                    $("#type").html('');
                    var html="<option value="+ agent+">"+ agent+"</option>";
                    var html2="<option value='服务中心'>服务中心</option>";
                    $(html).appendTo("#agent");
                    $(html2).appendTo("#type");
                    $('#parent').show();
                }else{
                    //获取地址
                    var province=$('#province option:selected').attr('value');
                    var city=$('#city option:selected').attr('value');
                    var area=$('#area option:selected').attr('value');

                    //获取符合该地址的所有运营中心
                    $.get('./?r=admin-user/get-agent',{'province':province,'city':city,'area':area},function(data){
                        // console.log(data);
                        if(data!=''){
                            $("#agent").html('');
                            var html="<option value=''>请选择</option>";
                            $(data).each(function(i,v){
                                html+="<option value="+ v.Name+">"+ v.Name+"</option>";
                            });


                            $(html).appendTo("#agent");
                            $('#agent').val(agent);
//                        alert(agent);

                            $('#parent').show();
                        }
                        if(data==''){
                            $("#agent").html('');
                            html="<option value='太极兵运营中心'>太极兵运营中心</option>";
                            $(html).appendTo("#agent");
                            $('#parent').show();
                        }


                    });
                }





            }
        }

        initProvince();
        initListener();
        initAddress();
//        initMap();
    });

    //    function openMark(){
    //        if ($("#address").val() != "") {
    //            geoc.getPoint($("#address").val(), function (point) {
    //                if (point) {
    //                    map.centerAndZoom(point, 13);
    //                    map.addOverlay(new BMap.Marker(point));
    //                    cur = point;
    //                } else {
    //                    alert("您选择地址没有解析到结果!");
    //
    //                }
    //            }, "成都市");
    //        }
    //        //监听点击地图事件
    //        map.addEventListener("click", function (e) {
    //            cur= e.point;
    //            getCircle(cur);
    //        });
    //
    //
    //        //创建标注点函数
    //        function getCircle(point) {
    //            map.clearOverlays();
    //            marker = new BMap.Marker(point);
    //            map.addOverlay(marker);
    //        }
    //
    //        $("#mapContainer").show();
    //    }
    function hideMark(){
        $("#mapContainer").hide();
    }
    function  sureLocation(){
        if(cur==null){
            alert("请先标注点！");
            return;
        }
        $("#lat").val(cur.lat);
        $("#lng").val(cur.lng);
        hideMark();
    }
    function initMap(){
        $("#address").val(address);
        $("#lat").val(baiDuLat);
        $("#lng").val(baiDuLng);


        map = new BMap.Map("map");
        geoc = new BMap.Geocoder();
        map.enableScrollWheelZoom(); //可滑动
        map.addControl(new BMap.NavigationControl()); //导航条
        var point = new BMap.Point(104.067923, 30.679943); //成都市(116.404, 39.915);
        map.centerAndZoom(point, 13);
        $("#map").css({"height":"100%"});
    }
    function initAddress(){
        $("#province").val(province);
        initCityOnProvinceChange();
        $("#city").val(city);
        initThree();
        $("#area").val(area);
    }
    function getAddressIdByName(_name){
        _name= $.trim(_name);
        if(_name==""){
            return 0;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            var name= $.trim(item.Name);
            if(name!=""&&name==_name){
                return item.Id;
            }
        }
        return 0;
    }
    function initListener(){
        $("#province").on("change",function(){
            initCityOnProvinceChange();
        });
        $("#city").on("change",function(){
            initThree();
        });
    }
    function initCityOnProvinceChange(){
        var pid=getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#area").empty();
        $("#area").append("<option value=''>请选择</option>");
        $("#city").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#city").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
                initThree()
            }
        }
    }
    function initThree(){
        var pid=getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#area").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }
    function initProvince(){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId==0){
                $("#province").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }

    //获取经纬度
    function get_lat_lng(){
        var address = $('#address').val();

        if(!address) {
            alert('请输入详细地址');
        }else {


            // 创建地址解析器实例
            var myGeo = new BMap.Geocoder();
            // 将地址解析结果显示在地图上,并调整地图视野
            myGeo.getPoint(address, function (point) {
                var lg = JSON.parse(JSON.stringify(point)).lng;
                var lt = JSON.parse(JSON.stringify(point)).lat;
//            console.log(JSON.parse(JSON.stringify(point)));
                //将经纬度写进input框
                $('#lng').val(lg);
                $('#lat').val(lt);


//                search(lg, lt);
//        $('#shopcoord').val(JSON.stringify(point));
            }, "成都市");

        }
    }





</script>

</body>
</html>
