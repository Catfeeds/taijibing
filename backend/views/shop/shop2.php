<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>éè¿æå¡åº?/title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">


    <link rel="stylesheet" href="./static/css/sm.min.css">
    <link rel="stylesheet" href="./static/css/sm-extend.min.css">
    <link rel="stylesheet" href="./static/css/index.css">
<!--    <link rel="stylesheet" href="./static/css/address.css">-->
<style>
/*å¤´é¨æ ·å¼å¼å§?/
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



/*å¤´é¨æ ·å¼ç»æ*/





</style>


</head>
<body style="position: relative;overflow: auto;">

<header class="site" >
    <div id="search"><input type="text" placeholder="æªå®ä½? id="address" /><input type="text" placeholder="è¾å¥åå®¶åç§°" id="search_content"/><input id="search_btn"  type="button" value="æç´¢" /></div>
    <div id="select"><select class="xiala" id="address-province"><option>è¯·éæ©ç?/option></select><select class="xiala" id="address-city"><option>è¯·éæ©å¸?/option></select><select class="xiala" id="address-county"><option>è¯·éæ©å?/option></select><div>
</header>

<div class="content shop-content" style="margin-top: 30px;">

    <div class="list-block media-list" style="margin-top: 10px">
        <!--å¸¸ç¨é¨åºåéèï¼åææ·»å -->
        <p class="shop-title " style="display: none;margin-top:10px;border-bottom:solid #e6e6e6 1px">å¸¸ç¨é¨åº</p>
        <ul id="changyong" style="display: none">
            <!--å¸¸ç¨é¨åºä¿¡æ¯-->
        </ul>

        <p class="shop-title" style="border-bottom:solid #e6e6e6 1px">ç¦»ææè¿?/p>
        <ul id="list">
            <!--ç¦»ææè¿é¨åºä¿¡æ?->
        </ul>
    </div>

</div>


<script type='text/javascript' src='./static/js/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm-extend.min.js' charset='utf-8'></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
<!--/*å°åæ°æ®*/-->
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
//    //å¡«åççæ°æ®
//    $(address).each(function(){
//        //console.log(this.name);
//        var option = '<option value="'+this.name+'">'+this.name+'</option>';
//        $("#address-province").append(option);
//    });
//    //åæ¢ï¼éä¸­ï¼çï¼è¯»åè¯¥çå¯¹åºçå¸ï¼æ´æ°å°å¸ä¸ææ¡?
//    $("#address-province").change(function(){
//        var province = $(this).val();//è·åå½åéä¸­çç
//        if(province != ''){
//            //å°å°ååå¥æç´¢æ¡?
//        $('#address').val(province);
//
//        //console.log(province);
//        //è·åå½åçå¯¹åºçå¸?æ°æ®
//        $(address).each(function(){
//            if(this.name == province){
//                var option = '<option value="">è¯·éæ©å¸?/option>';
//                $(this.city).each(function(){
//                    option += '<option value="'+this.name+'">'+this.name+'</option>';
//                });
//                $("#address-city").html(option);
//            }
//        });
//        //å°å¿çä¸ææ¡æ°æ®æ¸ç©º
//        $("#address-county").html('<option value="">è¯·éæ©å?/option>');
//        }
//
//        if(province == 'è¯·éæ©ç?){
//        $('#address').val('');
//        //å°å¸çä¸ææ¡æ°æ®æ¸ç©º
//        $("#address-city").html('<option value="">è¯·éæ©å¸?/option>');
//        //å°å¿çä¸ææ¡æ°æ®æ¸ç©º
//        $("#address-county").html('<option value="">è¯·éæ©å?/option>');
//        }
//
//
//
//    });
//    //åæ¢ï¼éä¸­ï¼å¸ï¼è¯»åè¯¥å¸?å¯¹åºçå¿ï¼æ´æ°å°å¿ä¸ææ¡
//    $("#address-city").change(function(){
//        var city = $(this).val();//å½åéä¸­çåå¸?
//        if(city == ''){
//            //å°å¿çä¸ææ¡æ°æ®æ¸ç©º
//        $("#address-county").html('<option value="">è¯·éæ©å?/option>');
//        }
//
//        //å°å°ååå¥æç´¢æ¡?
//        var province=$('#address-province').val();
//        //å¤æ­çåå¸æ¯å¦ç¸å¯?
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
//                        //éåå°å½åéä¸­çåå¸äº
//                        var option = '<option value="">è¯·éæ©å?/option>';
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
//        var county = $(this).val();//å½åéä¸­çå¿ï¼åºï¼?
//        //å°å°ååå¥æç´¢æ¡?
//        var province=$('#address-province').val();
//        var city=$('#address-city').val();
//        //å¤æ­çãå¸åå¿ï¼åºï¼æ¯å¦ç¸ç­?
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

    //æ ¹æ®åå°çå°åæ°æ®  å¡«åçä»½æ°æ®
    $.get('index.php?r=shop/get-province',function(data){
        $(data).each(function(i,v){
            var option = '<option value="'+v.Id+'">'+v.Name+'</option>';
            $("#address-province").append(option);
        });
    });

    //åæ¢ï¼éä¸­ï¼çï¼è¯»åè¯¥çå¯¹åºçå¸ï¼æ´æ°å°å¸ä¸ææ¡?
    $("#address-province").change(function(){
        var province = $("#address-province  option:selected").text();//è·åå½åéä¸­çç
        var province_value = $(this).val();//è·åå½åéä¸­ççid

        if(province != 'è¯·éæ©ç?){
            //å°å°ååå¥æç´¢æ¡?
            $('#address').val(province);
		
		$('#address-city').html('');

            //console.log(province);
            //è·åå½åçå¯¹åºçå¸?æ°æ®
            $.get('index.php?r=shop/get-city',{'id':province_value},function(data){
                var option = '<option value="">è¯·éæ©å¸?/option>';
                $(data).each(function(i,v){
                    option += '<option value="'+v.Id+'">'+v.Name+'</option>';
                });
                $("#address-city").html(option);
                //å°å¿çä¸ææ¡æ°æ®æ¸ç©º
                $("#address-county").html('<option value="">è¯·éæ©å?/option>');
            });

//            $(address).each(function(){
//                if(this.name == province){
//                    var option = '<option value="">è¯·éæ©å¸?/option>';
//                    $(this.city).each(function(){
//                        option += '<option value="'+this.name+'">'+this.name+'</option>';
//                    });
//                    $("#address-city").html(option);
//                }
//            });
//            //å°å¿çä¸ææ¡æ°æ®æ¸ç©º
//            $("#address-county").html('<option value="">è¯·éæ©å?/option>');
        }

        if(province == 'è¯·éæ©ç?){
            $('#address').val('');
            //å°å¸çä¸ææ¡æ°æ®æ¸ç©º
            $("#address-city").html('<option value="">è¯·éæ©å¸?/option>');
            //å°å¿çä¸ææ¡æ°æ®æ¸ç©º
            $("#address-county").html('<option value="">è¯·éæ©å?/option>');
        }



    });
    //åæ¢ï¼éä¸­ï¼å¸ï¼è¯»åè¯¥å¸?å¯¹åºçå¿ï¼æ´æ°å°å¿ä¸ææ¡
    $("#address-city").change(function(){

        var city = $("#address-city  option:selected").text();//å½åéä¸­çåå¸?
        var city_value = $(this).val();//å½åéä¸­çåå¸id
        var province = $("#address-province  option:selected").text();

        if(city == 'è¯·éæ©å¸?){

            $('#address').val(province);
            //å°å¿çä¸ææ¡æ°æ®æ¸ç©º
            $("#address-county").html('<option value="">è¯·éæ©å?/option>');
        }else{
            //å°å°ååå¥æç´¢æ¡?
//            var province=$("#address-province  option:selected").text();

            //å¤æ­çåå¸æ¯å¦ç¸å¯?

            if(province != city && city!='è¯·éæ©å¸?){
                var province_city=province + city;
                $('#address').val(province_city);

			$('#address-county').html('');

                //è·åå½åå¸å¯¹åºçåºå¿ æ°æ®
                $.get('index.php?r=shop/get-county',{'id':city_value},function(data){
                    var option = '<option value="">è¯·éæ©å?/option>';
                    $(data).each(function(i,v){
                        option += '<option value="'+v.Id+'">'+v.Name+'</option>';
                    });
                    $("#address-county").html(option);

                });
            }

        }








//        $(address).each(function(){
//            if(this.name == $("#address-province").val()){
//                $(this.city).each(function(){
//                    if(this.name == city){
//                        //éåå°å½åéä¸­çåå¸äº
//                        var option = '<option value="">è¯·éæ©å?/option>';
//                        $(this.area).each(function(i,v){
//
//                            option += '<option value="'+v+'">'+v+'</option>';
//                        });
//                        $("#address-county").html(option);
//                    }
//                });
//            }
//        });
    });

    $('#address-county').change(function(){
        var county = $("#address-county  option:selected").text();//å½åéä¸­çå¿ï¼åºï¼?
        //å°å°ååå¥æç´¢æ¡?
        var province=$("#address-province  option:selected").text();
        var city=$('#address-city  option:selected').text();
        //å¤æ­çãå¸åå¿ï¼åºï¼æ¯å¦ç¸ç­?
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

    //å¼¹æ¡æç¤ºå¼å¯GPS
    loadpopup();


    var address = $('#address').val();
    if(address=='') {

        //è·åæå¨ä½ç½®çåæ  å¹¶å°ä½ç½®ä¿¡æ¯æ¾ç¤ºå¨å°åæ¡?
        var geolocation = new BMap.Geolocation();

        geolocation.getCurrentPosition(function (r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
               var lng = r.point.lng;
               var lat = r.point.lat;

            }
//            alert('ç»åº¦1ï¼? + lng + 'ç»´åº¦1ï¼? + lat);

            if (lng == null || lat == null) {
                alert('è¯·å¼å¯å®ä½åè?);
            } else {
                //æ ¹æ®ç»çº¬åº¦è·åä½ç½®ä¿¡æ?
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
                            $('#address').val(addComp.street);
//                    alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
//                    alert('æ¨çä½ç½®ï¼?+rs.point.lng+','+rs.point.lat);
                        });
                    });
                }, 1000);

//            alert('ç»åº¦ï¼?+lng+'ç»´åº¦ï¼?+lat);

                initPage(lat,lng);
            }

        }, {enableHighAccuracy: true});
    }



});

    //å°åè¾å¥æ¡è·åç¦ç¹æ¸ç©?
    $("#address").focus(function(){
//        $(this).val('');
        //æ·»å ä¸ææ¡?
        $('#select').css('display','block');
        $('.xiala').css({'height': '30px', 'width': '33.33%','text-align':'center','padding-left':'5%' });
        $('.list-block').css({'margin-top': '40px'});
        $('.site').css({'height':'80px'});



    });


    /**
     * ç¹å»è·ååæ ï¼ç¹å»æç´¢æé®æ¶è·åå°åæ¡çä½ç½®ä¿¡æ¯è·åç»çº¬åº¦ï¼
     */
    $('#search_btn').click(function(){
        var adds = $('#address').val();
        if(adds == ''){
            alert('è¯·å¡«åä¸ä¸ªå°å');
        }else{

//            alert(adds);
            getPoint(adds);
        }

    });


    //æ ¹æ®è¾å¥çå°åè·åç»çº¬åº?ä»åå°è·åè¦æç´¢çæ°æ?
    function getPoint(adds){
        // åå»ºå°åè§£æå¨å®ä¾?
        var myGeo = new BMap.Geocoder();
        // å°å°åè§£æç»ææ¾ç¤ºå¨å°å¾ä¸,å¹¶è°æ´å°å¾è§é?
        myGeo.getPoint(adds, function(point){
            var lg=JSON.parse(JSON.stringify(point)).lng;
            var lt=JSON.parse(JSON.stringify(point)).lat;
//            console.log(JSON.parse(JSON.stringify(point)));

            search(lg,lt);
//        $('#shopcoord').val(JSON.stringify(point));
        }, "æé½å¸?);



    }



    //æ ¹æ®è¾å¥çåå®¶åç§°è·åæ°æ?
    function search(lg,lt){

        var search_content=$('#search_content').val();

        //æ ¹æ®æç´¢åå®¹è·åæ°æ®
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

                //æ¸ç©º
                $('#list').html('');

                //å°æ°æ®è¿½å å°é¡µé¢
                var html = '';
                $.each(data.data, function (i, v) {

                    html += '<li">\
                                <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-link item-content" style="color:blackï¼?>\
                                <div class="item-media"><img src="./static/images/mendian.jpg" style="width: 4rem;"></div>\
                                    <div id="fuhao" class="item-inner">\
                                        <span style="width: 5px;height: 9px; float: right;margin-top:20px"><img src="./static/images/go.png" style="width: 10px;height: 19px;"></span>\
                                        <div class="item-title-row">\
                                            <div class="item-subtitle" style="font-size: 18px;color: #333">' + v.Name + '</div>\
                                        </div>\
                                            <div class="item-title" style="font-size: 14px;color: #6a6a6a">' + v.Address + '</div>\
                                        <div class="item-title" style="font-size: 14px"><img src="./static/images/location2.png" alt="" style="color: #6a6a6a;width: 11px;height: 14px"/> &nbsp;' + v.distance + 'km</div>\
                                    </div>\
                                </a>\
                        </li>';

                });
                $(html).appendTo('#list');

            }



        });

    }


    //åå§åé¡µé?
    function initPage(lat,lng) {
//    alert('ç»åº¦ï¼?+lng+'ç»´åº¦ï¼?+lat)
        //è·ååå®¶æ°æ®
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

                //å°æ°æ®è¿½å å°é¡µé¢
                var html = '';
                var num=1;
                $.each(data.data, function (i, v) {

                    html += '<li">\
                                <a href="index.php?r=shop/get-goods&id=' + v.Id + '" class="item-link item-content" style="color:blackï¼?>\
                                <div class="item-media"><img src="./static/images/mendian.jpg" style="width: 4rem;"></div>\
                                    <div id="fuhao" class="item-inner">\
                                        <span style=" float: right;margin-top:20px"><img src="./static/images/go.png " style="width: 10px;height: 19px;"></span>\
                                        <div class="item-title-row">\
                                            <div class="item-subtitle" style="font-size: 18px;color: #333">' + v.Name + '</div>\
                                        </div>\
                                            <div class="item-title" style="font-size: 14px;color: #6a6a6a">' + v.Address + '</div>\
                                        <div class="item-title" style="font-size: 14px"><img src="./static/images/location2.png" alt="" style="color: #6a6a6a;width: 11px;height: 14px"/> &nbsp;' + v.distance + 'km</div>\
                                    </div>\
                                </a>\
                        </li>';

                    //æ·»å ä¸ä¸ªå¸¸ç¨é¨åºï¼åé¢åæ¹è¿ï¼
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
//æ§å¶å¼¹æ¡

function tankuang(){
    alert('ç¡®ä¿å®ä½åç¡®ï¼è¯·å¼å¯GPSï¼?);
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
        exp.setTime(exp.getTime() + 30*60 * 1000);//è¿ææ¶é´ 60åé
//        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
        document.cookie="popped=yes;expires="+ exp.toGMTString();

//        document.cookie="popped=yes"

    }

}




</script>



</body>
</html>