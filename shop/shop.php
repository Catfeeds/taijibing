<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">

    <style>
        ul{
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

<div class="content">
    <!--<header class="bar bar-nav">-->
        <!--<h1 class="title" style="background-color: #5A92E0;color: white">附近商家</h1>-->
    <!--</header>-->
    <div class="list-block"  style="margin-top: 0">

        <ul style="margin-bottom: 10px">
            <li class="item-content">
                <div class="item-media"><i class="icon icon-f7"><img src="images/1.jpg" width="80px"></i></div>
                <div class="item-inner">
                    <div class="item-title"><a href="water.php">协信服务中心</a></div>
                    <div class="item-after" style="font-size: 14px"><img src="images/tu.jpg" width="20px" height="20px">7.16km</div>
                </div>
            </li>
            <li class="item-content">
                <div class="item-media"><i class="icon icon-f7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></div>
                <div class="item-inner">
                    <div class="item-after" style="font-size: 14px">府青路协信中心5楼</div>
                    <div class="item-after" style="font-size: 14px"><a href="tel:15008434161"><img src="images/tel.jpg" width="30px" height="30px"></a></div>
                </div>
            </li>
        </ul>
        <ul style="margin-bottom: 10px">
            <li class="item-content">
                <div class="item-media"><i class="icon icon-f7"><img src="images/2.jpg" width="80px"></i></div>
                <div class="item-inner">
                    <div class="item-title"><a href="water.php">中和服务站</a></div>
                    <div class="item-after" style="font-size: 14px"><img src="images/tu.jpg" width="20px" height="20px">14.39km</div>
                </div>
            </li>
            <li class="item-content">
                <div class="item-media"><i class="icon icon-f7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></div>
                <div class="item-inner">
                    <div class="item-after" style="font-size: 14px">中和广场</div>
                    <div class="item-after" style="font-size: 14px"><a href="tel:15008434161"><img src="images/tel.jpg" width="30px" height="30px"></a></div>
                </div>
            </li>
        </ul>
        <ul style="margin-bottom: 10px">
            <li class="item-content">
                <div class="item-media"><i class="icon icon-f7"><img src="images/3.jpg" width="80px"></i></div>
                <div class="item-inner">
                    <div class="item-title"><a href="water.php">南湖服务站</a></div>
                    <div class="item-after" style="font-size: 14px"><img src="images/tu.jpg" width="20px" height="20px">20.51km</div>
                </div>
            </li>
            <li class="item-content">
                <div class="item-media"><i class="icon icon-f7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></div>
                <div class="item-inner">
                    <div class="item-after" style="font-size: 14px">成都南湖北路121号</div>
                    <div class="item-after" style="font-size: 14px"><a href="tel:15008434161"><img src="images/tel.jpg" width="30px" height="30px"></a></div>
                </div>
            </li>
        </ul>
    </div>

</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script>
    var cid='<?=$cid?>';
    var disid='<?=$distid?>';
    var lat='';
    var lng='';

    $(function(){

        //获取所在位置的坐标
        var geolocation = new BMap.Geolocation();

        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                lng=r.point.lng;
                lat=r.point.lat;

            }

//            alert('经度：'+lng+'维度：'+lat)

//            initPage();
        },{enableHighAccuracy: true});

    });


</script>



</body>
</html>