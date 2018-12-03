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


    <link rel="stylesheet" href="/static/css/mui.css">
     
</head>
<style type="text/css">

         #content{
            width:100%;
            height:100%;
            overflow: hidden;
            position:absolute;
        }
p{
	padding: 0px !important;
	margin:0;color: #000
}

     .header{
            width:100%;
            height:144px;
            background-image: url(/static/images/background.png);
            background-position:center;
            background-size: 100% 144px;
        }
       
      .header_content{
            height:144px;
            width:
        }
        .header_p_icon{
            height:100px;width:100px;position:absolute;top:22px;
            border-radius: 72px;
            left:10px;
        }
        .container{
            width:100%;
             height: calc(100% - 144px);
            position: relative;
        }
         .agent_address{
            color: #fff;line-height: inherit;font-size:13px;overflow: hidden;
            margin-top:21px;
        }
        .header_right{
            position: absolute;left:130px;top:18px;
        }


        .Catalog{
            border-top:5px solid #f3f3f3;

        }
        .list{
       width: 33.3%;
	    float: left;
	    padding: 10px;
	    text-align: center;
        }
                .container_left{
            position: absolute;
            top:0px;
             left:0px;
                width:90px;
                bottom:0px;
            background: #f8f8f8;
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
                .container_right{
            position:absolute;
             left: 90px;padding-left: 10px;
            right:0px;
            bottom:0px;
            top:144px;
            padding-right:10px;
            padding-bottom:80px;
            top:0px;
            background:white;
            height: 100%;
        }
     .container_right_content{
            width:100%;
            height:100%;
            background:white;
            overflow: auto;
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
     position: absolute;
    right: 0px;
    width: 50px;
    height: 25px;
    font-size: 13px;
    display: inline-block;
    background: #ff4e00;
    color: white;
    line-height: 25px;
    text-align: center;
    border-radius: 8px;
    top: 25px;
    right: 0px;
        }
    .goods_ul li{
    height:110px;
    border-bottom: 1px solid #e9e9e9;
    padding-top:15px;
    overflow: auto;
    background:white;
    }
    .goods_title{
    font-size:15px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    }
    .tab_menu_item{
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    }
    .layui-m-layerbtn span[yes]{
    font-size: 25px;
    }
    .agent_contact{
    	font-size: 12px;
    	color: #fff
    }
</style>
<body>
 <div id="content">
      <div class="header">
            <img src="<?=$shop_info['image1']?>" class="header_p_icon"/>
            <div class="header_right">
                <p style="color: #fff;font-size:18px;"><?=$shop_info['shop_name']?></p>
                <p class="agent_address">地址：<?=$shop_info['Address']?></p>
                <p class="agent_contact">简介：<?=$shop_info['shop_detail']?></p>
                <p class="agent_contact">营业时间：<?=$shop_info['morning'] ?>-<?=$shop_info['night']?></p></p>
            </div>
        </div>
    <!-- </div> -->
     <div class="container">
        <div class="container_left">
            <ul class="tab_list"  id='tab_list'>
                <li class="tab_menu_item selected" type="0">热销&nbsp;<icon class="water_hot"></icon></li>
            </ul>
        </div>
        <div class="container_right">
            <p style="height:40px;line-height:40px;border-bottom:1px solid #e9e9e9;font-size:16px;" type='' id="title">热销</p>
               <div class="container_right_content"  id="refreshContainer" >
                   <ul class="goods_ul">

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
</body>


<script src="/static/js/jquery.min.js"></script>

<script src="/static/js/mui.min.js"></script>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript">
    var datas_type2=<?=$datas_type2?>;
    console.log(datas_type2)

           var agent_id=getQueryString("agent_id")
           var category1_id=getQueryString("category1_id")

           console.log(category1_id)

    if(datas_type2){

        var  tab_list = document.getElementById("tab_list");
        var html ='';
        for(var i=0;i<datas_type2.length;i++){
        var item = datas_type2[i];
         for(var z in item){
                  if(item[z]==null){
                     item[z]='其它'
                   } 
              }
             html += (' <li class="tab_menu_item unselected " type="'+item.Id+'">'+item.SecondMenu+'&nbsp;</li>');
        };
          $("#tab_list").html(html)
         var obj ={
              agent_id:agent_id
         }
         console.log(obj)

         $(".tab_menu_item").eq(0).removeClass("unselected").addClass("selected");
           var category2_id = $(".tab_menu_item").eq(0).attr('type');
             var _text= $(".tab_menu_item").eq(0).text()
             $("#title").text(_text);

         var object= {'agent_id':agent_id,'category1_id':category1_id,'category2_id':category2_id} 
         getList(object)

     }

       $(".tab_menu_item").on("click",function(){
                        var category2_id = $(this).attr('type');
                                $(".tab_menu_item").removeClass("selected").removeClass("unselected");
                                $(".tab_menu_item").addClass("unselected");
                                $(this).removeClass("unselected").addClass("selected");
                                 var _text= $(this).text()
                                 $("#title").text(_text);
                                 $("#title").attr('type',category2_id);
                                var  _type= $("#title").attr('type')
                      if(!isNaN(category2_id)){
                                  layer.open({
                                    type: 2
                                    ,shade: false 
                                    // ,content: '加载中'
                                  });
                                var object= {'agent_id':agent_id,'category1_id':category1_id,'category2_id':category2_id} 
                                 getList(object)
                       }else{
                     
                         var html = '<div id="conter" style="padding-bottom: 50px;width: 100%;position: relative;">'  ;
                          html+='<div class="empty_goods">'  ;
                          html+='<div style="width:110px;margin:0 auto;margin-top:60px;">';
                          html+=' <p style="text-align:center;font-size:25px;color:#999;margin-bottom:10px;">敬请期待</p>'  ;
                          html+=  '<img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>'  ;
                          html+='</div>'  ;
                          html+=' </div>'  ;
                          html+='<div  id="imgUrl" style="margin-top:0px">'  ;
                          html+='</div>'  ;
                          html+='</div>'  ;
                          $(".goods_ul").empty();
                         $(".goods_ul").html(html)
                     return;
                       }
                });

function getList(object){
  $.get('/index.php/mother-and-baby-shop/get-goods',object,function(data) {
    
             var data = JSON.parse(data)
             if(data.state==-1){
                return;
             }
          console.log(data)   
         layer.closeAll()
        $(".goods_ul").empty()
        for(var y=0;y<data.datas.length;y++){
        var item2 = data.datas[y];
        var goods_image1 ='http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1bs2fphs011471gqs1pvv1k6ihn110.jpg';

        if(item2.goods_image1){
            goods_image1=item2.goods_image1;
        }
        // console.log(goods_image1)
        $(".goods_ul").append('<a href="./goods-details?agent_id='+agent_id+'&goods_id='+item2.id+'"> <li>'+
        '<div class="list_container">'+
        '<img src="'+goods_image1+'" style="height:80px;width:80px;position:absolute;left:0px;"/>'+
        '<div class="list_c_right">'+
        '<p class="goods_title">'+item2.name+'</p>'+
        '<p style="font-size:12px;"></p>'+
        '<p style="font-size:12px;">已售:99</p>'+
        '<p><span class="price_fz" style="color:red;">￥'+item2.realprice+'</span></p>'+
        '<span style="text-decoration: line-through;font-size:12px;">￥'+item2.originalprice+'</span></p>'+
        '</div>'+
        '<span class="buy_bnt">购买</span>'+
        '</div>'+
        '</li></a>');
    }
  }) 
}

    //获取url参数
function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
            var r = window.location.search.substr(1).match(reg); 
            if (r != null) return r[2]; return null;
}
</script>
</html>