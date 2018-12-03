<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="./static/css/sm.min.css">
    <link rel="stylesheet" href="./static/css/sm-extend.min.css">
    <link rel="stylesheet" href="./static/css/index.css">
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <style>

        .aaa{
            width: 70%;
            -webkit-flex-shrink: 1;
            -ms-flex: 0 1 auto;
            /*-webkit-flex-shrink: 1;*/
            flex-shrink: 1;
            /*white-space: nowrap;*/
            position: relative;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            font-size: .6rem;
            color: #666;

            /*display: -webkit-box;*/
            /*-webkit-line-clamp:2;*/
            /*-webkit-box-orient: vertical;*/
            /*word-break:break-all;*/
        }

        .aaa .item-name {
             /*overflow: hidden;*/
             /*text-overflow:ellipsis;*/
             white-space: nowrap;
             font-size: .8rem;
             color: #000;
         }

        .aaa .item-intro {
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient: vertical;
            word-break:break-all;
        }

        .list-block .aaa .item-money {
            font-size: .8rem;
            color: #fd3d21;
        }

        .list-block .aaa .item-money span {
            font-size: .5rem;
            color: #666;
            text-decoration: line-through;
        }

        /*.list-block .aaa .label {*/
            /*width: 35%;*/
            /*-webkit-flex-shrink: 0;*/
            /*-ms-flex: 0 0 auto;*/
            /*-webkit-flex-shrink: 0;*/
            /*flex-shrink: 0;*/
            /*margin: 4px 0*/
        /*}*/



            /*隐藏滚动条*/
        ::-webkit-scrollbar{width:0;height:0}

        .wrapper{
            padding:0;
            position: fixed;
            left: 0;
            top: 0;
        }
        .wrapper-content{
            padding:0;
        }
    </style>
    <title>商品信息</title>

</head>
<body >
<div class="header" style="background: url('./static/images/background.png') no-repeat;background-size:100% 7rem ;">
<!--    <div class="header_img fl"><img src="http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1bm7fff414h8m8510ck14ac1laur.jpg" alt=""/></div>-->
<!--    <div class="header_info fl">-->
<!--        <p class="info_title row_one" style="color: #f2f0f0;">--><?//=$agent_info[0]['Name']?><!--</p>-->
<!--        <p class="row_two" style="color: #f2f0f0;">地址：--><?//=$agent_info[0]['Address']?><!--</p>-->
<!--        <p class="row_two" style="color: #f2f0f0;">简介：我们只做优质水，让家人喝到安全放心的水</p>-->
<!--    </div>-->
</div>
<div class="page">


    <div class="content list-content" style="width: 66%;">
        <!--热销列表-->
        <div class="list-block" id="hot" style="width: 96%;overflow: hidden;" >
            <p class="list-title">热销</p>
            <ul style="width: 100%;overflow: auto;">
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water14.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">千堆雪</a>
                            <p class="item-intro row_two">12年匠心制造的</p>
                            <p class="item-sell">已售：<span>125</span></p>
                            <p class="item-money">￥10 <span>￥15</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water13.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="aaa">
                            <a href="#" class="item-name">中伦中</a>
                            <p class="item-intro row_two">喝出自然味道的饮用水</p>
                            <p class="item-sell">已售：<span>50</span></p>
                            <p class="item-money">￥15 <span>￥16</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water12.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">燕京</a>
                            <p class="item-intro row_two">大品牌的天然矿泉水</p>
                            <p class="item-sell">已售：<span>20</span></p>
                            <p class="item-money">￥15 <span>￥20</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water11.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">纽湾</a>
                            <p class="item-intro row_two">新鲜健康时尚饮用水</p>
                            <p class="item-sell">已售：<span>10</span></p>
                            <p class="item-money">￥88 <span>￥88</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>

                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea11.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">金康仕立式茶吧机（白色）</a>
                            <p class="item-sell" style="color: #666">已售：<span>50</span></p>
                            <p class="item-money">￥300 <span>￥800</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>

                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea13.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">金康仕桌面茶吧机</a>
                            <p class="item-sell" style="color: #666">已售：<span>20</span></p>
                            <p class="item-money">￥300 <span>￥500</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
            </ul>
        </div>
        <!--饮用水列表-->
        <div class="list-block " id="water" style="width: 96%;overflow: hidden; display: none;" >
            <p class="list-title">饮用水</p>
            <ul id="water_list" style="width: 100%;overflow: auto;">
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water14.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">千堆雪</a>
                            <p class="item-intro row_two">12年匠心制造的</p>
                            <p class="item-sell">已售：<span>125</span></p>
                            <p class="item-money">￥10 <span>￥15</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water12.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">燕京</a>
                            <p class="item-intro row_two">大品牌的天然矿泉水</p>
                            <p class="item-sell">已售：<span>20</span></p>
                            <p class="item-money">￥15 <span>￥20</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water13.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">中伦</a>
                            <p class="item-intro row_two">喝出自然味道的饮用水</p>
                            <p class="item-sell">已售：<span>50</span></p>
                            <p class="item-money">￥15 <span>￥16</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>

                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water10.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">龙剪云</a>
                            <p class="item-intro row_two">优质天然矿泉水</p>
                            <p class="item-sell">已售：<span>10</span></p>
                            <p class="item-money">￥48 <span>￥48</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>
                <li class="item-content">
                    <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/water11.jpg"></i></div>
                    <div class="item-inner fl">
                        <div class="item-title">
                            <a href="#" class="item-name">纽湾</a>
                            <p class="item-intro row_two">新鲜健康时尚饮用水</p>
                            <p class="item-sell">已售：<span>10</span></p>
                            <p class="item-money">￥88 <span>￥88</span></p>
                        </div>
                        <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                    </div>
                </li>


            </ul>
        </div>

        <!--茶吧机列表-->
        <div class="list-block" id="tea" style="width: 96%;overflow: hidden; display: none;" >
            <p class="list-title">茶吧机</p>
                <ul style="width: 100%;overflow: auto;">
                    <li class="item-content">
                        <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea11.jpg"></i></div>
                        <div class="item-inner fl">
                            <div class="item-title">
                                <a href="#" class="item-name">金康仕立式茶吧机（白色）</a>
                                <p class="item-sell">已售：<span>50</span></p>
                                <p class="item-money">￥300 <span>￥800</span></p>
                            </div>
                            <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea13.jpg"></i></div>
                        <div class="item-inner fl">
                            <div class="item-title">
                                <a href="#" class="item-name">金康仕桌面茶吧机</a>
                                <p class="item-sell" style="color: #666">已售：<span>20</span></p>
                                <p class="item-money">￥300 <span>￥500</span></p>
                            </div>
                            <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-media fl"><i class="icon icon-f7"><img src="./static/images/tea12.jpg"></i></div>
                        <div class="item-inner fl">
                            <div class="item-title">
                                <a href="#" class="item-name">金康仕立式茶吧机（黑色</a>
                                <p class="item-sell">已售：<span>10</span></p>
                                <p class="item-money">￥300 <span>￥800</span></p>
                            </div>
                            <div class="item-after" style="background-color: #f3652d; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>
                        </div>
                    </li>


                </ul>
        </div>


    </div>
    <!--菜单-->
    <div class="panel panel-left panel-reveal theme-dark container_left" id='panel-left-demo'>
        <div class="content-block">
            <p style="height: 50px"><a href="javascript:void(0);" id="h">热销&nbsp;<img src="./static/images/hot.png"></a></p>
            <p style="height: 50px"><a href="javascript:void(0);" id="w">袋装水&nbsp;<img src="./static/images/water.png"></a></p>
            <p style="height: 50px"><a href="javascript:void(0);" id="t">茶吧机&nbsp;<img src="./static/images/tea.png"></a></p>

        </div>
    </div>
</div>


<script type='text/javascript' src='./static/js/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='./static/js/sm-extend.min.js' charset='utf-8'></script>
<script>
    var agent_id=<?=$agent_id?>;
    var html='';
    var tel='';
    $(function(){
        var height=$(document.body).outerHeight(true);
        $(".list-block ul").css({"height":height-200});
        $(".panel").css({"height":height});

        //获取门店信息
        $.get('index.php?r=shop/get-agent',{'id':agent_id},function(data){
            tel=data[0].ContractTel;
             html='<div class="header_img fl"><img src="./static/images/mendian.jpg" alt=""/></div>\
                    <div class="header_info fl">\
                        <p class="info_title row_one" style="color: #f2f0f0;">'+ data[0].Name+'</p>\
                        <p class="row_two" style="color: #f2f0f0;">地址：'+ data[0].Address+'</p>\
                        <p class="row_two" style="color: #f2f0f0;">简介：我们只做优质水，让家人喝到安全放心的水</p>\
                    </div>' ;
            $(html).appendTo('.header');

        });



        //点击热销菜单
        $("#h").on("click",function(){
            $('#hot').show();
            $('#water').hide();
            $('#tea').hide();
            $('#h').css('background','#fff');
            $('#w').css('background','#f8f8f8');
            $('#t').css('background','#f8f8f8');
        });
        //点击袋装水菜单
        $("#w").on("click",function(){
            $('#water').show();
            $('#hot').hide();
            $('#tea').hide();
            $('#w').css('background','#fff');
            $('#h').css('background','#f8f8f8');
            $('#t').css('background','#f8f8f8');
            //获取袋装水数据，并追加到页面显示
            html='';

            //点击袋装水菜单时，先判断有内容没（避免多次请求）
//            var water_goods=$('#water_list').html();
//
//            if(!water_goods){
//                $.get('index.php?r=shop/get-water',{'id':agent_id},function(data){
//                    if(data==null){//没有商品时显示一个空箱子图片
//                        html='<li class="item-content">\
//                        <div class="item-inner fl">\
//                        <img src="./static/images/empty.png">\
//                        </div>\
//                        </li>';
//
//                        $(html).appendTo('#water_list');
//
//                    }else{
//
//                        $(data).each(function(i,v){
//                            var num=Math.round(Math.random()*1000);
//                            html +='<li class="item-content">\
//                            <div class="item-media fl"><i class="icon icon-f7"><img src="'+ v.url+'"></i></div>\
//                        <div class="item-inner fl">\
//                            <div class="item-title">\
//                            <a href="#" class="item-name">'+v.Name+'</a>\
//                            <p class="item-intro row_two">更优质的矿泉水</p>\
//                            <p class="item-sell">已售：<span>'+num+'</span></p>\
//                            <p class="item-money">￥'+v.OriginalPrice+' <span>￥'+Number(v.OriginalPrice)+Number(5)+'</span></p>\
//                        </div>\
//                        <div class="item-after" style="background-color: #f36b35; margin-right: .2rem;"><a href="javascript:void(0);" onclick="callphone()" style="color: #f2f0f0;">购买</a></div>\
//                        </div>\
//                        </li>'
//                        });
//                        $(html).appendTo('#water_list');
//
//                    }
//
//                })
//            }



        });
        //点击茶吧机菜单
        $("#t").on("click",function(){
            $('#tea').show();
            $('#water').hide();
            $('#hot').hide();
            $('#t').css('background','#fff');
            $('#w').css('background','#f8f8f8');
            $('#h').css('background','#f8f8f8');
        });


        //监听手机返回，
        pushHistory();
        window.addEventListener("popstate", function(e) {
            //返回时刷新页面
            goback();
//            alert("我监听到了浏览器的返回按钮事件啦");//根据自己的需求实现自己的功能
        }, false);
        function pushHistory() {
            var state = {
                title: "title",
                url: "#"
            };
            window.history.pushState(state, "title", "#");
        }






    });

    //打电话弹框
    function callphone(){

        //利用对话框返回的值 （true 或者 false）
        if (confirm("确定拨打"+tel+"吗？")) {
            window.location.href = "tel:"+tel+"";
        }
        else {
            return;
        }
    }

    //返回并刷新
    function goback(){
//        history.go(-1);
        window.location.href = document.referrer;
    }

</script>
</body>
</html>