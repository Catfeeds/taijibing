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
        *{
            margin:0px;
            padding:0px;
        }
        body{
            width:100%;
            height:100%;
            position:absolute;
        }
        .page{
            position:relative;
            width:100%;
            height:100%;
        }
        .container_left{
            /*background: green;*/
            width:100px;
            height:100%;
            left:0px;
            position: absolute;

        }
        .container_right{
            /*background: red;*/
            left:100px;
            position: absolute;
            right:0px;
            height:100%;

        }


    </style>
</head>
<body>


<div class="page">

    <div class="content container_right">


        <!--<div class="content-block-title"></div>-->
        <!--饮用水列表-->
        <div class="list-block" id="water" style="margin-top: 0;">
            <ul style="margin-bottom: 10px;">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/1.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">太极冰</a></div>
                        <div class="item-after" style="font-size: 14px">￥8</div>
                    </div>
                </li>

            </ul>
        <!--</div>-->
        <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/2.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">无为太极水</a></div>
                        <div class="item-after" style="font-size: 14px">￥9</div>
                    </div>
                </li>

            </ul>
        <!--</div>-->
        <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/3.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">千堆雪</a></div>
                        <div class="item-after" style="font-size: 14px">￥10</div>
                    </div>
                </li>

            </ul>
        <!--</div>-->
        <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/1.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">昆仑冰</a></div>
                        <div class="item-after" style="font-size: 14px">￥11</div>
                    </div>
                </li>

            </ul>
        <!--</div>-->
        <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/2.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">农夫冰泉</a></div>
                        <div class="item-after" style="font-size: 14px">￥12</div>
                    </div>
                </li>

            </ul>

            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/3.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">纯净冰泉水</a></div>
                        <div class="item-after" style="font-size: 14px">￥7</div>
                    </div>
                </li>

            </ul>

            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/1.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">甘甜冰泉水</a></div>
                        <div class="item-after" style="font-size: 14px">￥8</div>
                    </div>
                </li>

            </ul>
        </div>

        <!--茶吧机列表-->
        <div class="list-block" id="tea"  style="margin-top: 0;display: none">
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/1.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">太极茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥198</div>
                    </div>
                </li>

            </ul>
            <!--</div>-->
            <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/2.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">无为茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥299</div>
                    </div>
                </li>

            </ul>
            <!--</div>-->
            <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/3.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">千千茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥498</div>
                    </div>
                </li>

            </ul>
            <!--</div>-->
            <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/1.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">昆仑茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥598</div>
                    </div>
                </li>

            </ul>
            <!--</div>-->
            <!--<div class="list-block">-->
            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/2.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">冰泉茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥698</div>
                    </div>
                </li>

            </ul>

            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/3.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">冰冰茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥298</div>
                    </div>
                </li>

            </ul>

            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/1.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">智能茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥898</div>
                    </div>
                </li>

            </ul>

            <ul style="margin-bottom: 10px">
                <li class="item-content">
                    <div class="item-media"><i class="icon icon-f7"><img src="images/2.jpg" width="80px"></i></div>
                    <div class="item-inner">
                        <div class="item-title"><a href="#">净化茶吧机</a></div>
                        <div class="item-after" style="font-size: 14px">￥998</div>
                    </div>
                </li>

            </ul>
        </div>


        <div  style="position:fixed;width: 80px;bottom: 20px;right: 10px;">
            <div class="item-inner">
                <div class="col-50" style= "margin-right: 0;"><a href="tel:15008434161"  ><img src="images/tel.jpg" style="width: 100px"></a></div>
            </div>
        </div>

    </div>

    <!--菜单-->
    <div class="container_left panel panel-left panel-reveal theme-dark" id='panel-left-demo' style="display:block; background-color: black">
        <div class="content-block">
            <p><a href="javascript:void(0);" style="color: white;" id="w" onclick="water()">袋装水<img src="images/water.jpg" width="10px"></a></p>
            <p><a href="javascript:void(0);" style="color: slateblue"  id="t" onclick="tea()">茶吧机<img src="images/tea.jpg" width="15px"></a></p>

        </div>

    </div>

</div>
<div class="panel-overlay"></div>


<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
<script>
    function water(){
        $('#water').show();
        $('#tea').hide();
        $('#w').css('color','white');
        $('#t').css('color','slateblue');
    }
    function tea(){
        $('#tea').show();
        $('#water').hide();
        $('#t').css('color','white');
        $('#w').css('color','slateblue');
    }
</script>
</body>
</html>