<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>太极兵订水门店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="http://image.ebopark.com/wx/static/coderlu.css"/>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        .location_icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-image: url(/static/images/location_error.png);
            background-size: 20px 20px;
            background-position: center;
            line-height: 40px;
            position: absolute;
            top: 5px;
        }

        .loc_icon {
            display: inline-block;
            width: 10px;
            height: 14px;
            background-image: url(/static/images/loc_icon.png);
            background-size: 10px 14px;
            background-position: center;
            line-height: 40px;
            position: absolute;
            top: 7px;
            left: 24px;
        }

        .sear_icon {
            display: inline-block;
            width: 13px;
            height: 14px;
            background-image: url(/static/images/sear_icon.png);
            background-size: 13px 14px;
            background-position: center;
            line-height: 40px;
            position: absolute;
            top: 7px;
            left: 12px;
        }

        .org_sear_icon {
            display: inline-block;
            width: 14px;
            height: 18px;
            background-image: url(/static/images/org_loc.png);
            background-size: 14px 18px;
            background-position: center;
            line-height: 40px;
            position: absolute;
            top: 6px;
            left: 12px;
        }

        .tips {
            height: 32px;
            line-height: 30px;
            text-align: center;
            width: 100%;
            font-size: 14px;
            display: none;
        }

        .search_box_c {
            height: 50px;
            width: 100%;
            background: #f25d22;
            position: relative;
        }

        .location_c {
            position: absolute;
            left: 10px;
            width: 110px;
            height: 40px;
            top: 11px;
        }

        .pre_search_input {
            position: absolute;
            left: 130px;
            right: 10px;
            top: 11px;
            overflow: hidden;

        }

        .search_input {
            position: absolute;
            left: 130px;
            right: 55px;
            top: 11px;
            overflow: hidden;
        }

        .pre_search_key {
            border: 0px;
            font-size: 13px;
            position: absolute;
            left: 27px;
            top: 5px;
            display: inline-block;
            height: 28px;
            width: 100%;
        }

        .radius {
            background: white;
            border-radius: 8px;
            height: 28px;
            overflow: hidden;
        }

        .search_key {
            border: 0px;
            font-size: 13px;
            position: absolute;
            left: 27px;
            top: 0px;
            display: inline-block;
            height: 28px;
            width: 100%;
        }

        .cancel_btn {
            position: absolute;
            right: 0px;
            display: inline-block;
            width: 55px;
            height: 50px;
            line-height: 50px;
            color: white;
            text-align: center;
            font-size: 14px;
        }

        .search_input_c {
            display: none;
        }

        li {
            list-style-type: none;
        }

        .agent_list li {
            height: 139px;
            border-bottom: 1px solid #e8e8e8;
            position: relative;
            padding-bottom: 14px;
            padding-top: 14px;
        }

        .agent_icon {
            height: 110px;
            width: 135px;
            position: absolute;
            left: 10px;
        }

        .item_right {
            position: absolute;
            left: 175px;
            top: 24px;
        }

        .loc_icon_pos {
            left: 175px;
            top: 90px;
        }

        .title_top {
            font-size: 17px;
            height: 38px;
            line-height: 38px;
        }

        #manual_loc_header {
            position: relative;
            height: 30px;
            line-height: 30px;

        }

        .add_item {
            display: inline-block;
            width: 33%;
            text-align: center;
            height: 30px;
            line-height: 30px;
            position: absolute;
            color:#dbdbdb;
        }
        .add_item .arrow_down_icon{
            background-image: url("/static/images/arrow_down_light.png");
            background-size: 9px 7px;
            background-position: center;
            display: inline-block;
            width: 9px;
            height: 7px;
            position: absolute;
            top: 12px;

        }
        .add_item_selected{
            color:#6b6b6b;
        }
        .add_item_selected .arrow_down_icon{
            background-image: url("/static/images/arrow_down_dark.png");
            background-size: 9px 7px;
            background-position: center;
            display: inline-block;
            width: 9px;
            height: 7px;
            position: absolute;
            top: 12px;
        }
        .address_ul{
            font-size:14px;
            padding-left:22px;
            padding-right:22px;
        }
        .address_ul li{
            border-bottom: 1px solid #eeeeee;
            height:44px;
            line-height:44px;
        }
        .address_list{
            position:relative;
        }
        .flags_list{
            position:fixed;
            top:120px;
            right:2px;
            color:#666666;
            font-size:14px;
        }
        .flags_list li{
            height:20px;
            line-height:20px;
            text-align:center;
            width:20px;
            padding-right:2px;
        }
        .cancel_loc {
            background-image: url("/static/images/loc_cancel.png");
            background-size: 12px 12px;
            background-position: center;
            display: inline-block;
            width: 12px;
            height: 12px;
            position: absolute;
            top: 9px;
            right: 10px;
        }
        @media screen and (max-width: 320px) {
            .agent_icon {
                height: 90px;
                width: 115px;
                position: absolute;
                left: 18px;
            }

            .item_right {
                position: absolute;
                left: 145px;
                top: 14px;
            }

            .loc_icon_pos {
                left: 145px;
                top: 80px;
            }

            .title_top {
                font-size: 14px;
                height: 38px;
                line-height: 38px;
            }
        }
    </style>
</head>
<body>
<div id="content">
    <!--    tips box-->
    <div class="tips">
        <div style="position:relative">
            <div style="position:absolute;left:50%;margin-left:-94px;">
                <icon class="location_icon"></icon>
                <span style="padding-left:24px;">定位失败!请您手动定位</span>
            </div>

        </div>
    </div>
    <!--search box-->
    <div class="search_box_c">
        <div class="location_c radius">
            <icon class="loc_icon"></icon>
            <input readonly style="border:0px;font-size:13px;position:absolute;left:37px;top:5px;" id="address"
                   value=''/>
        </div>
        <div class="search_input_c">
            <div class="search_input radius">
                <icon class="sear_icon"></icon>
                <input id="search_key" class="search_key" type="text" placeholder="输入商家、商品名称"
                       oninput="onInput(event)" onpropertychange="onPropertyChange(event)"/>
            </div>
            <span class="cancel_btn">取消</span>
        </div>
        <div class="pre_search_input radius">
            <icon class="sear_icon"></icon>
            <span class="pre_search_key" type="text">搜索</span>
        </div>
    </div>
    <div id="list_container">
        <div style="height:30px;line-height:46px;padding-left:10px;display:none;" id="distanceLabel">离我最近</div>
        <!--list-->
        <ul class="agent_list">
            <!--        <li>-->
            <!--             <img src="/static/images/jysj.png" class="agent_icon"/>-->
            <!--            <div style="position:absolute;left:175px;top:24px;">-->
            <!--                <p class="title" style="font-size:17px;height:38px;line-height:38px;">协信服务中心</p>-->
            <!--                <p class="title" style="font-size:13px;">府青路协信服务中心5楼</p>-->
            <!--                <p class="title" style="font-size:13px;height:38px;line-height:38px;padding-left:18px;">125米</p>-->
            <!--            </div>-->
            <!--            <icon class="org_sear_icon" style="left:175px;top:90px;"></icon>-->
            <!--            <img src="/static/images/arrow_right.png" style="position:absolute;right:10px;top:60px;height:20px;width:auto"/>-->
            <!--        </li>-->

        </ul>
    </div>
    <div id="manual_loc" style="display:none;">
        <div id="manual_loc_header">
            <span class="add_item add_item_selected" style="left:0px;" type="1"><span id="province">请选择省</span>&nbsp;<icon class="arrow_down_icon"></icon></span>
            <span class="add_item " style="width:32%;left:33%;" type="2"><span id="city">请选择市</span>&nbsp;<icon class="arrow_down_icon"></icon></span>
            <span class="add_item" style="left:64%" type="3"><span id="area">请选择区</span>&nbsp;<icon class="arrow_down_icon"></icon></span>
            <icon class="cancel_loc"></icon>
        </div>
        <div>
            <div  class="address_list" style="position:fixed;top:80px;width:100%;height:100%;overflow: scroll;padding-bottom:80px;">
            </div>
            <ul class="flags_list">
            </ul>
        </div>

    </div>
    <div style="margin-top:120px;border-top:1px solid #e8e8e8;display:none;" id="emptyView">
        <p style="font-size:17px;color:#e8e8e8;text-align:center;margin-top:10px;">附近暂无商家</p>
        <p style="text-align:center;margin-top:10px;"><img src="/static/images/WechatIMG5.png" style="width:107px;height:auto;"/></p>
    </div>


</div>
<script type="text/javascript" src="http://image.ebopark.com/wx/static/labjs.min.js"></script>
<script>
    var app = null;
    $LAB.script("http://image.ebopark.com/wx/static/zepto.min.js").wait()
        .script("http://image.ebopark.com/wx/static/common.js")
        .script("http://image.ebopark.com/wx/static/fastClick.js")
        .script("http://image.ebopark.com/wx/static/coderlu.js")
        .script("/static/js/pinyin.js")
        .script("/static/js/pinyin_dict_firstletter.js")
        .script("/static/js/city.js")
        .script("/static/js/address_picker.js?v=1.1")
        .wait(function () {
            FastClick.attach(document.body);
            app = {
                lat: "",
                lng: "",
                data:null,
                init: function () {
                    this.locate();
                    this.initListener();
                    citypicker.init();
                },
                showList:function(){
                    $("#list_container").show();
                    $("#manual_loc").hide();

                },
                showLocWidget:function(){
                    $("#list_container").hide();
                    $("#manual_loc").show();
                    $("#emptyView").hide();
                },
                showEmptyView:function(){
                    $("#list_container").hide();
                    $("#emptyView").show();
                },
                hideEmptyView:function(){
                    $("#list_container").show();
                    $("#emptyView").hide();
                },
                query: function () {
                    $.showIndicator();
                    var url = "/index.php/water-shop/agent-list?lat=" + this.lat + "&lng=" + this.lng;
                    $.getJSON(url, function (data) {
                        $.hideIndicator();
                        if (data.status != 0) {
                            $.toast(data.msg);
                            return;
                        }
                        app.data = data.data;
                        app.updatePage(app.data);
                        app.updateAddressInfo(0);
                    });
                },

                listOrder:function(){
                    this.lat="";
                    this.lng="";
                    var province=citypicker.province.name;
                    var city=citypicker.city.name;
                    var area=citypicker.area.name;
                    this.showList();
                    $("#distanceLabel").hide();
                    $("#address").val(area);
                    var firData=[];
                    var thirData=[];
                    var fourData=[];
                    var listData=[];
                        for(var index=0;index<app.data.length;index++){
                            var item=app.data[index];
                            if(item.Province.indexOf(province)!=-1&&(item.City.indexOf(city)!=-1||item.area.indexOf(area)!=-1)){
                                firData.push(item);
                            }else if(item.Province.indexOf(province)!=-1){
                                thirData.push(item);
                            }else if(item.Address.indexOf(area)!=-1){
                                fourData.push(item);
                            }
                        }
                    listData.addAll(firData);
                    listData.addAll(thirData);
                    listData.addAll(fourData);
                    app.updatePageWithoutLoc(listData);


                },
                updateAddressInfo:function(currentIndex){
                    var listData=[];
                    if(currentIndex>=app.data.length){
                        return;
                    }
                    var item=app.data[currentIndex];
                    app.mapGeocoder(item.BaiDuLng,item.BaiDuLat,function(addComp){
                        var item=app.data[currentIndex];
                        item.Province=addComp.province;
                        item.City=addComp.city;
                        item.area=addComp.district;
                        currentIndex++;
                        app.updateAddressInfo(currentIndex);
                    },currentIndex);
                },
                updatePageWithoutLoc:function(data) {
                    if(app.isEmpty(data)){
                        return;
                    }
                    $(".agent_list").empty();
                    for (var index = 0; index < data.length; index++) {
                        var item = data[index];
                        var liStr = ' <a href="/index.php/water-shop/goods-list?id=' + item.agent_id + '"> <li>' +
                            '<img src="/static/images/agent_shop_logo.jpeg" class="agent_icon"/>' +
                            '   <div class="item_right">' +
                            '   <p class="title title_top">' + item.shop_name + '</p>' +
                            '   <p class="title" style="font-size:13px;height:20px;padding-right:20px;overflow: hidden">' + item.Address + '</p>' +
                            '   <p class="title" style="font-size:13px;height:38px;line-height:38px;padding-left:18px;"></p>' +
                            '</div>' +
                            '<img src="/static/images/arrow_right.png" style="position:absolute;right:10px;top:60px;height:20px;width:auto"/>' +
                            '</li></a>';
                        $(".agent_list").append(liStr);
                    }
                },
                updatePage: function (data) {
                    if(app.isEmpty(data)){
                        return;
                    }
                    if(app.lng==""||app.lat==""){
                        app.updatePageWithoutLoc(data);
                        return;
                    }
                    $(".agent_list").empty();
                    var address= $('#address').val();
                    for (var index = 0; index < data.length; index++) {
                        var item = data[index];
                        var liStr = ' <a href="/index.php/water-shop/goods-list?id=' + item.agent_id + '"> <li>' +
                            '<img src="/static/images/agent_shop_logo.jpeg" class="agent_icon"/>' +
                            '   <div class="item_right">' +
                            '   <p class="title title_top">' + item.shop_name + '</p>' +
                            '   <p class="title" style="font-size:13px;height:20px;padding-right:20px;overflow: hidden">' + item.Address + '</p>' +
                            '   <p class="title" style="font-size:13px;height:38px;line-height:38px;padding-left:18px;">' + item.distance + 'km</p>' +
                            '</div>' +
                            '<icon class="org_sear_icon loc_icon_pos"></icon>' +
                            '<img src="/static/images/arrow_right.png" style="position:absolute;right:10px;top:60px;height:20px;width:auto"/>' +
                            '</li></a>';
                        $(".agent_list").append(liStr);
                    }
                },
                isEmpty:function(data){
                    var isEmpty=false;
                    if(data instanceof Array&&data.length!=0){
                        app.hideEmptyView();
                    }else{
                        isEmpty=true;
                        app.showEmptyView();

                    }
                    return isEmpty;

                },
                initListener: function () {
                    $(".pre_search_input").on("click", function () {
                        $(".search_input_c").show();
                        $(this).hide();
                    });
                    $(".cancel_btn").on("click", function () {
                        $("#search_key").val("");
                        app.onKeyInputChange("");
                        $(".pre_search_input").show();
                        $(".search_input_c").hide();
                    });
                    $("#address").on("click",function(){
                        app.showLocWidget();
                    })
                    $(".cancel_loc").on("click",function(){
                        app.showList();
                    });


                },
                onKeyInputChange: function (_key) {
                    if (app.data == null) {
                        return;
                    }
                    var key = $.trim(_key);
                    if (key == "") {
                        app.updatePage(app.data);
                        return;
                    }
                    var temp = new Array;
                    for (var index = 0; index < app.data.length; index++) {
                        var item = app.data[index];
                        if (item.shop_name != null && item.Address != null && (item.shop_name.indexOf(key) != -1 || item.Address.indexOf(key) != -1)) {
                            temp.push(item);
                        }
                    }
                    app.updatePage(temp);
                },
                locate: function () {
                    $.showIndicator();
                    navigator.geolocation.getCurrentPosition(function (position) {
                        $.hideIndicator();
                        app.lng = position.coords.longitude;
                        app.lat = position.coords.latitude;
                        if(app.lng==""||app.lat==""){
                            $('#address').val("手动定位");
                            $(".tips").show();
                            $("#distanceLabel").hide();
                            app.query();
                            return;
                        }
                       app.mapGeocoder(app.lng,app.lat,function(addComp,data){
                           $('#address').val(addComp.district);
                           app.query();
                       },"");
                    });
                },
                mapGeocoder:function(lng,lat,_callback,data){
                        var gpsPoint = new BMap.Point(lng,lat);
                        BMap.Convertor.translate(gpsPoint, 0, function (point) {
                            var geoc = new BMap.Geocoder();
                            geoc.getLocation(point, function (rs) {
                                var addComp = rs.addressComponents;
                                _callback(addComp,data);
                            });
                        });
                }
            };
            app.init();
        })
    ;
    function onInput(event) {
        app.onKeyInputChange(event.target.value);
    }
    function onPropertyChange(event) {
        if (event.propertyName.toLocaleLowerCase() == "value") {
            app.onKeyInputChange(event.srcElement.value);
        }
    }

</script>
</body>
</html>