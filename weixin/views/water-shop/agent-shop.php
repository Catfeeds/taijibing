<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>太极兵订水门店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>


     
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
        line-height: 20px
        }
        .header_right{
        position: absolute;left:130px;top:18px;  line-height: 20px
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
       
        .tab_list .unselected{
        background:#f8f8f8;
        }
         .tab_list .selected{
        background:white;
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
        .tab_list ,ul{
            padding: 0
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
        .agent_contact,.agent_morning{
        font-size: 12px;
        color: #fff
        }
</style>
<body>
 <div id="content">
        <div class="header">
            <img src="" class="header_p_icon"/>
            <div class="header_right">
                <p style="color: #fff;font-size:18px;" class="agent_name"></p>
                <p class="agent_address">地址：<span></span></p>
                <p class="agent_contact">简介：<span></span></p>
                <p class="agent_morning">营业时间：<span></span></p>

            </div>

      <div id="shop_list" style="position: absolute;right:20px;top:20px;padding:5px">  <img src="/static/images/a_href.png" style="width:18px"/></div>


        </div>
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




<script type="text/javascript" src="/static/js/zepto.min.js"></script>



<script type="text/javascript">

        var lat=<?=$lat?>;
        var lng=<?=$lng?>;
        var category_id='<?=$category_id?>';
        var agent_id='<?=$agent_id?>';


console.log(category_id)
    $("#shop_list").click(function(event) {
        /* Act on the event */
         location.href="/index.php/water-shop/shop-list?category_id="+category_id+"&lat="+lat+"&lng="+lng; 
    }); 
var obj={
    lat:lat,
    lng:lng,
    category_id:category_id,
    agent_id:agent_id
};
console.log(obj)
var $res=Datas(obj,'/index.php/water-shop/get-shop-goods');
console.log($res)

if($res&&$res.state==0){

     var image = $res.datas.agent_info.image1;

       if(image.indexOf("7xpcl7.com2.z0.glb.qiniucdn.com") != -1 ){
           image = image.replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
        }

    $(".header_p_icon").attr("src",image)
    $(".agent_name").text($res.datas.agent_info.shop_name)
    $(".agent_address span").text($res.datas.agent_info.Address)
    $(".agent_contact span").text($res.datas.agent_info.shop_detail)
    $(".agent_morning span").text($res.datas.agent_info.morning+"-"+$res.datas.agent_info.night);


     if($res.datas.datas){
       var datas_type2= $res.datas.datas;
        var  tab_list = document.getElementById("tab_list");
        var html ='';
        
        for(var i in datas_type2){
            console.log(i)
              html += (' <li class="tab_menu_item unselected " type="'+i+'">'+i+'&nbsp;</li>');
        };
        $("#tab_list").html(html);
        $(".unselected").eq(0).addClass('selected');
        var selectedType =  $(".unselected").eq(0).attr('type');   
        $("#title").text(selectedType);
        console.log(datas_type2[selectedType])
         getList(datas_type2[selectedType])
     }
}
function getList(data){
    if(!data){
        return;
    }
    $(".goods_ul").empty()
     for(var y=0;y<data.length;y++){
        var item =data[y] 

      var itemImg=  item.goods_image1;
        if(itemImg.indexOf("7xpcl7.com2.z0.glb.qiniucdn.com") != -1 ){
            itemImg =   itemImg.replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
         };

        $(".goods_ul").append('<a href="./goods-detail?agent_id='+item.agent_id+'&goods_id='+item.goods_id+'"> <li>'+
        '<div class="list_container">'+
        '<img src="'+itemImg+'" style="height:80px;width:80px;position:absolute;left:0px;"/>'+
        '<div class="list_c_right">'+
        '<p class="goods_title">'+item.GoodsName+'</p>'+
        '<p style="font-size:12px;"></p>'+
        '<p style="font-size:12px;">已售:99</p>'+
        '<p><span class="price_fz" style="color:red;">￥'+item.realprice+'</span></p>'+
        '<span style="text-decoration: line-through;font-size:12px;">￥'+item.originalprice+'</span></p>'+
        '</div>'+
        '<span class="buy_bnt">购买</span>'+
        '</div>'+
        '</li></a>');

   
    }
}
$(".tab_menu_item").on("click",function(){
  var category2_id = $(this).attr('type');
       console.log(category2_id)
        $(".selected").removeClass('selected');
        $(this).addClass('selected');

        var selectedType =  $(this).attr('type');   
        $("#title").text(selectedType);
        console.log(datas_type2[selectedType])
         getList(datas_type2[selectedType])
})


    function  Datas(obj,url){
     var csj_data;
    console.log(url);
         if(!obj){
            obj=''
         }
          $.ajax
           ({
               cache: false,
               async: false,
               type: 'get',
               data: obj,
               url: url,
               success: function (data) {
                 if(typeof(data)=='string'){
                    data= eval('(' + data + ')');
                    }
                   csj_data = data;
                 }
           });
           // console.log(csj_data)
            return csj_data;
         }
    $(function(){
        //获取url参数
        function getQueryString(name) {
              var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
              var r = window.location.search.substr(1).match(reg); 
              if (r != null) return r[2]; return null;
        }

})
</script>
</html>