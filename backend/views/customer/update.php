<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;

$this->title = "";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['customer/list'],['class'=>'btn btn-primary'])?></div>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model["model"], 'Name')->textInput(['maxlength' => 64,'readonly'=>'true']) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["model"], 'Tel')->textInput(['maxlength' => 11,'readonly'=>'true']) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'CustomerType')->dropDownList(['1' => '家庭','2' => '公司','3' => '集团','99' => '其他'])->label('客户类型') ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'UseType')->dropDownList(['1' => '自购','2' => '押金','3' => '买水送机','4' => '买机送水','5' => '免费','99' => '其他'])->label('入网属性') ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'DevNo')->textInput(['maxlength' => 64,'readonly'=>'true'])->label('设备编号') ?>
                <div class="hr-line-dashed"></div>

                <!--地址-->
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">地址</label>
                    <div class="col-sm-10">
                        <select class="control-label" name="DevRegist[Province]" id="province">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="DevRegist[City]" id="city">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="DevRegist[Area]" id="area">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'Address')->textInput(['maxlength' => 64])->label('地址') ?>
                <div class="hr-line-dashed"></div>

                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>



<script>
var data=<?=$model["data"]?>;
var province='<?=$model["model"]["Province"]?>';
var city='<?=$model["model"]["City"]?>';
var area='<?=$model["model"]["Area"]?>';


//var geoc;
//var cur;
//var map;
//var address='<?//=empty($model["model"]["Address"])?"":$model["model"]["Address"]?>//';
//var baiDuLat='<?//=empty($model["model"]["Address"])?"":$model["model"]["BaiDuLat"]?>//';
//var baiDuLng='<?//=empty($model["model"]["Address"])?"":$model["model"]["BaiDuLng"]?>//';
</script>

<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script>

    $(function(){

        initProvince();
        initListener();
        initAddress();
//        initMap();
    });

    function openMark(){
        if ($("#address").val() != "") {
            geoc.getPoint($("#address").val(), function (point) {
                if (point) {
                    map.centerAndZoom(point, 13);
                    map.addOverlay(new BMap.Marker(point));
                    cur = point;
                } else {
                    alert("您选择地址没有解析到结果!");

                }
            }, "成都市");
        }
        //监听点击地图事件
        map.addEventListener("click", function (e) {
            cur= e.point;
            getCircle(cur);
        });


        //创建标注点函数
        function getCircle(point) {
            map.clearOverlays();
            marker = new BMap.Marker(point);
            map.addOverlay(marker);
        }

        $("#mapContainer").show();
    }
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


</script>
