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
        body{
            background:white;
        }
        * {
            margin: 0px;
            padding: 0px;
        }
        .header{
            width:100%;
            height:144px;
            background-image: url(/static/images/background.png);
            background-position:center;
            background-size: 100% 144px;

        }
        #content{
            width:100%;
            height:100%;
            overflow: hidden;
            position:absolute;
        }
        .header_content{
            height:144px;
            width:
        }
        .header_p_icon{
            height:100px;width:auto;position:absolute;top:22px;
            border-radius: 72px;
            left:10px;
        }
        .container{
            width:100%;
            height:100%;
            position: relative;
        }
        .container_left{
            position: absolute;
            top:0px;
            left:0px;
            width:105px;
            bottom:0px;
            background: #f8f8f8;
        }
        .container_right{
            position:absolute;
            left:125px;
            right:0px;
            bottom:0px;
            top:144px;
            padding-right:10px;
            padding-bottom:80px;
            top:0px;
            background:white;
        }
        .container_right_content{
            width:100%;
            height:100%;
            background:white;
            overflow: auto;
        }

        .tab_list li{
            height:54px;
            position:relative;
            text-align: center;
            line-height:54px;
            border-bottom: 1px solid #e9e9e9;
            font-size:14px;

        }
        .tab_list .selected{
            background:white;
        }
        .tab_list .unselected{
            background:#f8f8f8;
        }
        .water_hot {
            display: inline-block;
            width: 13px;
            height: 14px;
            background-image: url(/static/images/water_hot.png);
            background-size: 13px 14px;
            background-position: center;
            line-height: 40px;
            position: absolute;
            top: 19px;

        }
        .water_icon {
            display: inline-block;
            width: 10px;
            height: 15px;
            background-image: url(/static/images/icon_water.png);
            background-size: 10px 15px;
            background-position: center;
            line-height: 40px;
            position: absolute;
            top: 19px;

        }
        .water_tea {
            display: inline-block;
            width: 10px;
            height: 15px;
            background-image: url(/static/images/water_tea.png);
            background-size: 10px 15px;
            background-position: center;
            line-height: 40px;
            position: absolute;
            top: 19px;

        }

        .goods_ul li{
            height:110px;
            border-bottom: 1px solid #e9e9e9;
            padding-top:15px;
            overflow: auto;
            background:white;
        }

        .list_container{
            height:80px;
            width:100%;
            position:relative;
        }
        .list_c_right{
            position:absolute;
            left:90px;
        }
        .buy_bnt{
            position:absolute;
            right:0px;
            width:66px;
            height:30px;
            display:inline-block;
            background:#ff4e00;
            color:white;
            line-height: 30px;
            text-align: center;
            border-radius: 8px;
            top:50px;
            right:0px;
        }
        .agent_address{
            color: #f2f0f0;line-height: inherit;font-size:13px;overflow: hidden;
            margin-top:21px;
        }
        .header_right{
            position: absolute;left:130px;top:18px;
        }
        .agent_contact{
            color: #f2f0f0;font-size:13px;
            margin-top:5px;
        }
        .goods_title{
            font-size:15px;
        }
        .price_fz{
            font-size:14px;
        }
        @media screen and (max-width: 320px) {

            .goods_title{
                font-size:14px;
            }
            .agent_address{
                font-size:12px;
            }
            .container_left{
                left:0px;
                width:70px;
                bottom:0px;
            }

            .container_right{
                left: 75px;
            }
            .agent_contact{
                font-size:12px;
            }
        }
    </style>
</head>
<body>
<div id="content">
    <div class="header">
        <img src="<?=$agent_info[0]['image1']?>" class="header_p_icon"/>
        <div class="header_right">
            <p style="color: #f2f0f0;font-size:18px;"><?=$agent_info[0]['shop_name']?></p>
            <p class="agent_address">地址：<?=$agent_info[0]['Address']?></p>
            <p class="agent_contact">简介：<?=$agent_info[0]['shop_detail']?></p>
        </div>
    </div>
    <div class="container">
        <div class="container_left">
            <ul class="tab_list">
                <li class="tab_menu_item selected" type="1">热销&nbsp;<icon class="water_hot"></icon></li>
                <li class="tab_menu_item unselected" type="2">袋装水&nbsp;<icon class="water_icon"></icon></li>
                <li class="tab_menu_item unselected" type="3">茶吧机&nbsp;<icon class="water_tea"></icon></li>
            </ul>
        </div>
        <div class="container_right">
            <p style="height:32px;line-height:32px;border-bottom:1px solid #e9e9e9;font-size:13px;" id="title"></p>
               <div class="container_right_content">
                   <ul class="goods_ul">
                       <li>
                           <div class="list_container">
                               <img src="/static/images/background.png" style="height:80px;width:80px;position:absolute;left:0px;"/>
                               <div class="list_c_right">
                                   <p style="font-size:16px;">茶之宝+实木柜系列</p>
                                   <p style="font-size:12px;"> 更为优质的矿泉水</p>
                                   <p style="font-size:12px;">已售:123</p>
                                   <p><span style="font-size:17px;color:red;">￥1288</span><span style="text-decoration: line-through;font-size:12px;">￥2288</span></p>

                               </div>
                               <span class="buy_bnt">购买</span>
                           </div>
                       </li>

                   </ul>
                   <div class="empty_goods" style="display:none;">
                       <div style="width:110px;margin:0 auto;margin-top:60px;">
                           <p style="text-align:center;font-size:18px;color:#e8e8e8;margin-bottom:10px;">暂无商品</p>
                           <img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>
                       </div>
                   </div>
               </div>

        </div>

    </div>


</div>
<script type="text/javascript" src="http://oowgxt7h1.bkt.clouddn.com/wx/static/labjs.min.js"></script>
<script>

    //接收商品数据
    var waters=<?=$waters?>;
    var elect_tea=<?=$teas?>;




    var hotsell=[
        {
            goods_image1:"/static/images/water14.jpg",
            name:"千堆雪",
            desc:"12年匠心制造的",
            sells:125,
            realprice:10,
            originalprice:15
        },
        {
            goods_image1:"/static/images/water13.jpg",
            name:"中伦",
            desc:"喝出自然味道的饮用水",
            sells:50,
            realprice:15,
            originalprice:16
        },
        {
            goods_image1:"/static/images/water12.jpg",
            name:"燕京",
            desc:"大品牌的天然矿泉水",
            sells:20,
            realprice:15,
            originalprice:20
        },
        {
            goods_image1:"/static/images/water11.jpg",
            name:"纽湾",
            desc:"新鲜健康时尚饮用水",
            sells:10,
            realprice:88,
            originalprice:88
        },
        {
            goods_image1:"/static/images/tea11.jpg",
            name:"金康仕立式茶吧机（白色）",
            desc:"",
            sells:50,
            realprice:300,
            originalprice:800
        },
        {
            goods_image1:"/static/images/tea13.jpg",
            name:"金康仕桌面茶吧机",
            desc:"",
            sells:20,
            realprice:300,
            originalprice:500
        }

    ];
//    var waters=[
//        {
//            img_url:"/static/images/water14.jpg",
//            title:"千堆雪",
//            desc:"12年匠心制造的",
//            sells:125,
//            price:10,
//            oriprice:15
//        },
//        {
//            img_url:"/static/images/water12.jpg",
//            title:"燕京",
//            desc:"大品牌的天然矿泉水",
//            sells:20,
//            price:15,
//            oriprice:20
//        },
//        {
//            img_url:"/static/images/water13.jpg",
//            title:"中伦",
//            desc:"喝出自然味道的饮用水",
//            sells:50,
//            price:15,
//            oriprice:16
//        },
//        {
//            img_url:"/static/images/water10.jpg",
//            title:"龙剪云",
//            desc:"优质天然矿泉水",
//            sells:10,
//            price:48,
//            oriprice:48
//        },
//        {
//            img_url:"/static/images/water11.jpg",
//            title:"纽湾",
//            desc:"新鲜健康时尚饮用水",
//            sells:10,
//            price:88,
//            oriprice:88
//        },
//    ];
//    var elect_tea=[
//        {
//            img_url:"/static/images/tea11.jpg",
//            title:"金康仕立式茶吧机（白色）",
//            desc:"",
//            sells:50,
//            price:300,
//            oriprice:800
//        },
//        {
//            img_url:"/static/images/tea13.jpg",
//            title:"金康仕桌面茶吧机",
//            desc:"",
//            sells:20,
//            price:300,
//            oriprice:500
//        },
//        {
//            img_url:" /static/images/tea12.jpg",
//            title:"金康仕立式茶吧机（黑色)",
//            desc:"",
//            sells:10,
//            price:300,
//            oriprice:800,
//
//        }
//    ];
</script>
<script>
    $LAB.script("http://oowgxt7h1.bkt.clouddn.com/wx/static/zepto.min.js").wait()
        .script("http://oowgxt7h1.bkt.clouddn.com/wx/static/common.js")
        .script("http://oowgxt7h1.bkt.clouddn.com/wx/static/fastClick.js")
        .script("http://oowgxt7h1.bkt.clouddn.com/wx/static/coderlu.js")
        .wait(function () {
            FastClick.attach(document.body);

            var app={
                type:1,
                init:function(){
                    this.initListener();
                    this.updatePage();
                },
                initListener:function(){
                    $(".tab_menu_item").on("click",function(){
                        $(".tab_menu_item").removeClass("selected").removeClass("unselected");
                        $(".tab_menu_item").addClass("unselected");
                        $(this).removeClass("unselected").addClass("selected");
                        app.type=$(this).attr("type");
                        app.updatePage();
                    });
                },
                updatePage:function(){
                    var datas=[];
                    var title="";
                    switch(Number(this.type)){
                        case 1:datas=hotsell;title="热销";break;
                        case 2:datas=waters;title="袋装水";break;
                        case 3:datas=elect_tea;title="茶吧机";break;
                    }
                    $("#title").text(title);
                    $(".goods_ul").empty();
                    if(datas.length==0){
                        $(".empty_goods").show();
                        return;
                    }
                    $(".empty_goods").hide();
                    for(var index=0;index<datas.length;index++){
                        var item=datas[index];
                        $(".goods_ul").append('<li>'+
                            '<div class="list_container">'+
                            '<img src="'+item.goods_image1+'" style="height:80px;width:80px;position:absolute;left:0px;"/>'+
                        '<div class="list_c_right">'+
                        '<p class="goods_title">'+item.name+'</p>'+
                            '<p style="font-size:12px;"></p>'+
                        '<p style="font-size:12px;">已售:99</p>'+
                        '<p><span class="price_fz" style="color:red;">￥'+item.realprice+'</span><span style="text-decoration: line-through;font-size:12px;">￥'+item.originalprice+'</span></p>'+
                        '</div>'+
                        '<a href="tel:0285593786"><span class="buy_bnt">购买</span></a>'+
                        '</div>'+
                        '</li>');
                    }
                    $(".goods_ul").append('<li style="border:0px;"></li>');
                    $(".goods_ul").append('<li style="border:0px;"></li>');


                }
            }
            app.init();

        });

</script>
</body>
</html>