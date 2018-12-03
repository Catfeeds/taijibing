<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>附近服务店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">


    <link rel="stylesheet" href="./static/css/sm.min.css">
    <link rel="stylesheet" href="./static/css/sm-extend.min.css">
    <link rel="stylesheet" href="./static/css/index.css">
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<!--    <link rel="stylesheet" href="./static/css/address.css">-->
<style>
/*头部样式开始*/
    #address{
        margin-top: 10px;
        height:30px;
        border: solid #B2B2B2 1px;
        color:#B2B2B2;
        width:25%;
        border-radius:6px;
        margin-left: 4%;
        background-image:url("./static/images/location1.png");
        background-repeat: no-repeat;

        background-size:11px 15px ;
        background-position:4px center;
        padding-left:20px;
    }

    #search_content{
        margin-top: 10px;
        height:30px;
        width:45%;
        background-image:url("./static/images/search.png");
        background-repeat:no-repeat;
        background-size:15px 17px ;
        background-position:2px center;
        padding-left:20px;

        border: solid #B2B2B2 1px;

        border-radius:6px;
        margin-left: 5%
    }

    #search_btn{
        margin-top: 10px;
        width: 12%;
        height: 30px;
        margin-left: 5%;
        border: solid #B2B2B2 1px;
        border-radius:6px;
    }

    input::-webkit-input-placeholder { /* WebKit browsers */
        color:#B2B2B2;
    }
    .site{
        width:100%;
        /*height:80px;*/
        height:50px;
        position: fixed;
        top:0;
        left:0;
        z-index: 99;

    }
    .site #search{
        background: url('./static/images/search_background.png') no-repeat;
        background-size:100% 50px ;
        height: 50px;
        width:100%;
        margin-top: 0;
        margin-left: 0;

    }
    .site #select{
        background-color: white;
        display: none;
        height:40px;
        width: 100%;
        margin-top: 0;
    }

.address{
    width:70%;
    /*border:1px solid #ccc;*/
    overflow : hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient: vertical;
    word-break:break-all;
}



    /*.site #select  select{*/
        /*height: 30px;*/
        /*width: 28%;*/
        /*padding-left: 4%;*/
        /*margin-left: 4%;*/
    /*}*/
    /*#select  select option{*/
        /*width: 10px;*/
    /*}*/
/*.list-block{*/
    /*margin-top: 60px*/
/*}*/



/*头部样式结束*/





</style>


</head>
<body style="position: relative;overflow: auto;">

<header class="site" >
    <div id="search"><input type="text" placeholder="未定位" id="address" /><input type="text" placeholder="输入商家名称" id="search_content"/><input id="search_btn"  type="button" value="搜索" /></div>
    <div id="select"><select class="xiala" id="address-province"><option>请选择省</option></select><select class="xiala" id="address-city"><option>请选择市</option></select><select class="xiala" id="address-county"><option>请选择县</option></select><div>
</header>

<div class="content shop-content" style="margin-top: 30px;">

    <div class="list-block media-list" style="margin-top: 10px">
        <!--常用门店先隐藏，后期添加-->
        <p class="shop-title " style="display: none;margin-top:10px;border-bottom:solid #e6e6e6 1px">常用门店</p>
        <ul id="changyong" style="display: none">
            <!--常用门店信息-->
        </ul>


        <p class="shop-title" style="border-bottom:solid #e6e6e6 1px">离我最近</p>
        <ul id="list">
            <!--离我最近门店信息-->
        </ul>
    </div>

</div>


<script type='text/javascript' src='./static/js/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm-extend.min.js' charset='utf-8'></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>

<!--引用百度地图API-->
<!--<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.1&services=true"></script>-->

<!--/*地址数据*/-->
<!--<script type='text/javascript' src='./static/js/address.js' charset='utf-8'></script>-->

<script>

<?php

/**
 * @var $this \yii\web\View
 */
//$this->registerCssFile('./static/css/address.css');
//$this->registerJsFile('./static/js/address.js');
//$this->registerJs(new \yii\web\JsExpression(
//        <<<JS
//
//    //填充省的数据
//    $(address).each(function(){
//        //console.log(this.name);
//        var option = '<option value="'+this.name+'">'+this.name+'</option>';
//        $("#address-province").append(option);
//    });
//    //切换（选中）省，读取该省对应的市，更新到市下拉框
//    $("#address-province").change(function(){
//        var province = $(this).val();//获取当前选中的省
//        if(province != ''){
//            //将地址写入搜索框
//        $('#address').val(province);
//
//        //console.log(province);
//        //获取当前省对应的市 数据
//        $(address).each(function(){
//            if(this.name == province){
//                var option = '<option value="">请选择市</option>';
//                $(this.city).each(function(){
//                    option += '<option value="'+this.name+'">'+this.name+'</option>';
//                });
//                $("#address-city").html(option);
//            }
//        });
//        //将县的下拉框数据清空
//        $("#address-county").html('<option value="">请选择县</option>');
//        }
//
//        if(province == '请选择省'){
//        $('#address').val('');
//        //将市的下拉框数据清空
//        $("#address-city").html('<option value="">请选择市</option>');
//        //将县的下拉框数据清空
//        $("#address-county").html('<option value="">请选择县</option>');
//        }
//
//
//
//    });
//    //切换（选中）市，读取该市 对应的县，更新到县下拉框
//    $("#address-city").change(function(){
//        var city = $(this).val();//当前选中的城市
//        if(city == ''){
//            //将县的下拉框数据清空
//        $("#address-county").html('<option value="">请选择县</option>');
//        }
//
//        //将地址写入搜索框
//        var province=$('#address-province').val();
//        //判断省和市是否相对
//        if(province != city){
//            var province_city=province + city;
//            $('#address').val(province_city);
//        }
//
//
//        $(address).each(function(){
//            if(this.name == $("#address-province").val()){
//                $(this.city).each(function(){
//                    if(this.name == city){
//                        //遍历到当前选中的城市了
//                        var option = '<option value="">请选择县</option>';
//                        $(this.area).each(function(i,v){
//
//                            option += '<option value="'+v+'">'+v+'</option>';
//                        });
//                        $("#address-county").html(option);
//                    }
//                });
//            }
//        });
//    });
//
//    $('#address-county').change(function(){
//        var county = $(this).val();//当前选中的县（区）
//        //将地址写入搜索框
//        var province=$('#address-province').val();
//        var city=$('#address-city').val();
//        //判断省、市和县（区）是否相等
//        if(county != city && province != city){
//            var province_city_county=province + city + county;
//            $('#address').val(province_city_county);
//        }
//
//        if(province == city && county != city){
//            var province_county=province + county;
//            $('#address').val(province_county);
//        }
//
//
//
//    });
//
//
//JS
//
//));


?>

$(function(){

    //根据后台的地址数据  填充省份数据
    $.get('index.php?r=shop/get-province',function(data){
        $(data).each(function(i,v){
            var option = '<option value="'+v.Id+'">'+v.Name+'</option>';
            $("#address-province").append(option);
        });
    });

    //切换（选中）省，读取该省对应的市，更新到市下拉框
    $("#address-province").change(function(){
        var province = $("#address-province  option:selected").text();//获取当前选中的省
        var province_value = $(this).val();//获取当前选中的省id

        if(province != '请选择省'){
            //将地址写入搜索框
            $('#address').val(province);

            //将市的内容先清空
            $("#address-city").html('');

            //console.log(province);
            //获取当前省对应的市 数据
            $.get('index.php?r=shop/get-city',{'id':province_value},function(data){
                var option = '<option value="">请选择市</option>';
                $(data).each(function(i,v){
                    option += '<option value="'+v.Id+'">'+v.Name+'</option>';
                });
                $("#address-city").html(option);
                //将县的下拉框数据清空
                $("#address-county").html('<option value="">请选择县</option>');
            });

        }

        if(province == '请选择省'){
            $('#address').val('');
            //将市的下拉框数据清空
            $("#address-city").html('<option value="">请选择市</option>');
            //将县的下拉框数据清空
            $("#address-county").html('<option value="">请选择县</option>');
        }



    });
    //切换（选中）市，读取该市 对应的县，更新到县下拉框
    $("#address-city").change(function(){

        var city = $("#address-city  option:selected").text();//当前选中的城市
        var city_value = $(this).val();//当前选中的城市id
        var province = $("#address-province  option:selected").text();

        if(city == '请选择市'){

            $('#address').val(province);
            //将县的下拉框数据清空
            $("#address-county").html('<option value="">请选择县</option>');
        }else{
            //将地址写入搜索框
            //判断省和市是否相对

            if(province != city && city!='请选择市'){
                var province_city=province + city;
                $('#address').val(province_city);
                //将县的内容先清空
                $("#address-county").html('');

                //获取当前市对应的区县 数据
                $.get('index.php?r=shop/get-county',{'id':city_value},function(data){
                    var option = '<option value="">请选择县</option>';
                    $(data).each(function(i,v){
                        option += '<option value="'+v.Id+'">'+v.Name+'</option>';
                    });
                    $("#address-county").html(option);

                });
            }

        }

    });

    $('#address-county').change(function(){
        var county = $("#address-county  option:selected").text();//当前选中的县（区）
        //将地址写入搜索框
        var province=$("#address-province  option:selected").text();
        var city=$('#address-city  option:selected').text();
        //判断省、市和县（区）是否相等
        if(county != city && province != city){
            var province_city_county=province + city + county;
            $('#address').val(province_city_county);

        }

        if(province == city && county != city){
            var province_county=province + county;
            $('#address').val(province_county);
        }



    });







//-------------------------------------





    //弹框提示开启GPS
    loadpopup();


    var address = $('#address').val();
    if(address=='') {


        //获取所在位置的坐标 并将位置信息显示在地址框
        var geolocation = new BMap.Geolocation();

        geolocation.getCurrentPosition(function (r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {

//                translate(r.point) ;

               var lng = r.point.lng;
               var lat = r.point.lat;

            }
//            alert('经度1：' + lng + '维度1：' + lat);

            if (lng == null || lat == null) {
                alert('请开启定位功能');
            } else {
                //根据经纬度获取位置信息
                setTimeout(function () {
                    var gpsPoint = new BMap.Point(lng, lat);
                    BMap.Convertor.translate(gpsPoint, 0, function (point) {
                        var geoc = new BMap.Geocoder();
                        geoc.getLocation(point, function (rs) {

//                    map.addControl(new BMap.NavigationControl());
//                    map.addControl(new BMap.ScaleControl());
//                    map.addControl(new BMap.OverviewMapControl());
//                    map.centerAndZoom(point, 18);
//                    map.addOverlay(new BMap.Marker(point)) ;

                            var addComp = rs.addressComponents;
                            var street=addComp.street;//街道
                            var district=addComp.district;//区县
                            //没有街道名称，写入县区
                            if(street){
                                $('#address').val(street);
                            }else{
                                $('#address').val(district);
                            }

//                    alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
//                    alert('您的位置：'+rs.point.lng+','+rs.point.lat);
                        });
                    });
                }, 1000);

//            alert('经度：'+lng+'维度：'+lat);

                initPage(lat,lng);
            }

        }, {enableHighAccuracy: true});
    }



});

    //地址输入框获取焦点清空
    $("#address").focus(function(){
//        $(this).val('');
        //添加下拉框
        $('#select').css('display','block');
        $('.xiala').css({'height': '30px', 'width': '33.33%','text-align':'center','padding-left':'5%' });
        $('.list-block').css({'margin-top': '40px'});
        $('.site').css({'height':'80px'});



    });


    /**
     * 点击获取坐标（点击搜索按钮时获取地址框的位置信息获取经纬度）
     */
    $('#search_btn').click(function(){
        var adds = $('#address').val();
        if(adds == ''){
            alert('请填写一个地址');
        }else{

//            alert(adds);
            getPoint(adds);
        }

    });


    //根据输入的地址获取经纬度,从后台获取要搜索的数据
    function getPoint(adds){
        // 创建地址解析器实例
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(adds, function(point){
            var lg=JSON.parse(JSON.stringify(point)).lng;
            var lt=JSON.parse(JSON.stringify(point)).lat;
//            console.log(JSON.parse(JSON.stringify(point)));

            search(lg,lt);
//        $('#shopcoord').val(JSON.stringify(point));
        }, "成都市");



    }



    //根据输入的商家名称获取数据
    function search(lg,lt){

        var search_content=$('#search_content').val().replace(/\s+/g, "");//去除所有空格

            //根据搜索内容获取数据
             $.get("index.php?r=shop/agent-list",{'search_content':search_content,'lng':lg,'lat':lt},function(data) {

            if (data.status == 0) {
                alert(data.msg);
                return;

            }
            if (data.status == -1) {
                alert(data.msg);
                return;

            }
            if (data.status == 1) {

                //清空
                $('#list').html('');

                //将数据追加到页面
                var html = '';
                $.each(data.data, function (i, v) {

                    html += '<li">\
                                <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-link item-content" style="color:black；">\
                                <div class="item-media"><img src="./static/images/mendian.jpg" style="width: 4rem;"></div>\
                                    <div id="fuhao" class="item-inner">\
                                        <span style="width: 5px;height: 9px; float: right;margin-top:20px"><img src="./static/images/go.png" style="width: 10px;height: 19px;"></span>\
                                        <div class="item-title-row">\
                                            <div class="item-subtitle" style="font-size: 18px;color: #333">' + v.Name + '</div>\
                                        </div>\
                                            <div class="address" style="font-size: 14px;color: #6a6a6a">' + v.Address + '</div>\
                                        <div class="item-title" style="font-size: 14px"><img src="./static/images/location2.png" alt="" style="color: #6a6a6a;width: 11px;height: 14px"/> &nbsp;' + v.distance + 'km</div>\
                                    </div>\
                                </a>\
                        </li>';

                });
                $(html).appendTo('#list');

            }



        });

    }


    //初始化页面
    function initPage(lat,lng) {
//    alert('经度：'+lng+'维度：'+lat)
        //获取商家数据
        $.get("index.php?r=shop/agent-list",{'lat': lat ,'lng':lng}, function (data) {
            if(data.status==0){
                alert(data.msg);
                return;

            }
            if(data.status==-1){
                alert(data.msg);
                return;

            }
            if(data.status==1) {

                //将数据追加到页面
                var html = '';
                var num=1;
                $.each(data.data, function (i, v) {

                    html += '<li">\
                                <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-link item-content" style="color:black；">\
                                <div class="item-media"><img src="./static/images/mendian.jpg" style="width: 4rem;"></div>\
                                    <div id="fuhao" class="item-inner">\
                                        <span style=" float: right;margin-top:20px"><img src="./static/images/go.png " style="width: 10px;height: 19px;"></span>\
                                        <div class="item-title-row">\
                                            <div class="item-subtitle" style="font-size: 18px;color: #333">' + v.Name + '</div>\
                                        </div>\
                                            <div class="address" style="font-size: 14px;color: #6a6a6a;">' + v.Address + '</div>\
                                        <div class="item-title" style="font-size: 14px"><img src="./static/images/location2.png" alt="" style="color: #6a6a6a;width: 11px;height: 14px"/> &nbsp;' + v.distance + 'km</div>\
                                    </div>\
                                </a>\
                        </li>';

                    //添加一个常用门店（后面再改进）
                    if(num==1){
                        $(html).appendTo('#changyong');
                    }
                    num++;

                });

                $(html).appendTo('#list');
            }

        });
    }


//-------------------------------
//控制弹框

function tankuang(){
    alert('确保定位准确，请开启GPS！');
}


function get_cookie(Name) {

    var search = Name + "=";

    var returnvalue = "";

    if (document.cookie.length > 0) {

        offset = document.cookie.indexOf(search);

        if (offset != -1) {

            offset += search.length;

            end = document.cookie.indexOf(";", offset);

            if (end == -1)

                end = document.cookie.length;

            returnvalue=unescape(document.cookie.substring(offset, end))

        }

    }

    return returnvalue;

}

function loadpopup(){

    if (get_cookie('popped')==''){

        tankuang();

        var exp = new Date();
        exp.setTime(exp.getTime() + 30*60 * 1000);//过期时间 60分钟
//        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
        document.cookie="popped=yes;expires="+ exp.toGMTString();

//        document.cookie="popped=yes"

    }

}




</script>



</body>
</html>