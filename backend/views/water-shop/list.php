<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>太极兵订水门店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="http://oowgxt7h1.bkt.clouddn.com/wx/static/coderlu.css"/>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
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
            <input readonly style="border:0px;font-size:13px;position:absolute;left:35px;top:5px;" id="address"
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
    <div style="height:30px;line-height:46px;padding-left:10px;">离我最近</div>
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
<script type="text/javascript" src="http://oowgxt7h1.bkt.clouddn.com/wx/static/labjs.min.js"></script>
<script>
     var app=null;
    $LAB.script("http://oowgxt7h1.bkt.clouddn.com/wx/static/zepto.min.js").wait()
        .script("http://oowgxt7h1.bkt.clouddn.com/wx/static/common.js")
        .script("http://oowgxt7h1.bkt.clouddn.com/wx/static/fastClick.js")
        .script("http://oowgxt7h1.bkt.clouddn.com/wx/static/coderlu.js")
        .wait(function () {
            FastClick.attach(document.body);
             app = {
                lat: "",
                lng: "",
                data: null,
                init: function () {
                    this.locate();
                    this.initListener();
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
                    });


                },
                updatePage: function (data) {
                    $(".agent_list").empty();
                    for (var index = 0; index < data.length; index++) {
                        var item = data[index];
                        var liStr = ' <a href="/index.php/water-shop/goods-list?id=' + item.agent_id + '"> <li>' +
                            '<img src=' + item.image1 + ' class="agent_icon"/>' +
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
                initListener: function () {
                    $(".pre_search_input").on("click", function () {
                        $(".search_input_c").show();
                        $(this).hide();
                    });
                    $(".cancel_btn").on("click", function () {
                        $(".pre_search_input").show();
                        $(".search_input_c").hide();
                    });

                },


                onKeyInputChange: function (_key) {
                    if (app.data == null) {
                        return;
                    }
                    var key= $.trim(_key);
                    if (key == "") {
                        app.updatePage(app.data);
                        return;
                    }
                    var temp = new Array;
                    for (var index = 0; index < app.data.length; index++) {
                        var item = app.data[index];
                        if (item.Name!=null&&item.Address!=null&&(item.Name.indexOf(key) != -1 || item.Address.indexOf(key) != -1)) {
                            temp.push(item);
                        }
                    }
                    app.updatePage(temp);

                }
                ,
                locate: function () {
                    $.showIndicator();
                    var geolocation = new BMap.Geolocation();
                    geolocation.getCurrentPosition(function (r) {

                        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                            app.lng = r.point.lng;
                            app.lat = r.point.lat;
                        }
                        app.query();
                        if (app.lng == null || app.lat == null) {
                            $('#address').val("定位失败");
                            $(".tips").show();
                        } else {
                            //根据经纬度获取位置信息
                            var gpsPoint = new BMap.Point(app.lng, app.lat);
                            BMap.Convertor.translate(gpsPoint, 0, function (point) {
                                var geoc = new BMap.Geocoder();
                                geoc.getLocation(point, function (rs) {
                                    var addComp = rs.addressComponents;
                                    $('#address').val(addComp.district);
                                    app.query();
//                    alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
                                });
                            });
                        }

                    }, {enableHighAccuracy: true});

                }


            };
            app.init();
        })
    ;
    function onInput(event) {
        app.onKeyInputChange(event.target.value);
    }
    function onPropertyChange (event) {
        if (event.propertyName.toLocaleLowerCase() == "value") {
            app.onKeyInputChange(event.srcElement.value);
        }
    }

</script>
</body>
</html>