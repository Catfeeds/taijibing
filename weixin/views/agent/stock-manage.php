<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/static/css/common.css" />
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>库存管理</title>
    <style>
      .table-hr{
      border-bottom:1px solid #f3f3f3;
      position: fixed;
      width: 100%;
      top: 0;        height: 90px;
      font-weight: bold;    background: #fff;
      z-index: 998;
            padding-right: 10px;background: #f3f3f3 url('/static/images2/163463112660427649.png') no-repeat;
      background-position: 100% ;
      background-size: 100% 140px;
      }
   .fixing-total{
      width: fit-content;
      margin: auto;    padding: 5px 20px;    position: relative;color: #fff;font-size: 12px;line-height: 12px;padding-right: 10px;
      }
            .total-tiele{
      position: absolute;
      left: 0px;
      top: 11px;
      width: 13px;
      }      .total-d{
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: rgba(255,250,0,1);
      position: absolute;
      right: 0;
      top: 50%;
      margin-top: -2.5px;
      }
      .fixing-bd{
      padding:10px;
      }
      .search{
      text-align: center;padding:10px;height: 50px;position: relative;
      }
      .search .img_btn{
      position: absolute;    padding: 0 5px;
      box-sizing: border-box;
      }
      .search .img_btn p{
      width: 200px;
      position: absolute;
      right: 0;
      background: #fff;
      text-align: left;
      font-size: 14px;
      font-weight: 400;
      line-height: 21px;
      padding: 5px;top: 40px;
      border-radius: 5px;    z-index: 14;
      border: 1px solid #000;    display: none
      }
      .table_tr{
      position: relative;
      }
      .center{
       display: inline-block;width: 100%;
      }

      .search .img_btn p>.dian{
      position: absolute;
      right: 10px;
      top: -10px;
      width: 0;
      height: 0;
      border-left: 7px solid transparent;
      border-right: 7px solid transparent;
      border-bottom: 10px solid #000;  z-index: 15;
      }
      .search input {
      height: 30px;
      border-radius: 17px;
      width: 80%;
      text-indent: 10px;outline:none; 
      border: none;
      font-size: 12px;text-align: center;
      padding-right: 10px;background: #f3f3f3 url('/static/images2/search_img.png') no-repeat;
      background-position: 5px 5px;
      background-size: 20px;
      }

      .search button,.footer button{
      height: 30px;      width: 100px;
      border-radius: 10px;
      border: none;border-bottom: 3px solid #dddddd;   outline:none; 
      }
.search input {
    /* height: 30px; */
    border-radius: 17px;
    text-indent: 20px;
    outline: none;
    border: none;
    width: 60%;
    font-size: 12px;
    text-align: center;
    padding-right: 10px;
    background: #f3f3f3;
    height: 25px;
    line-height: 25px;
}
.search p{
    position: absolute;
    width: 56%;
    /* padding: 0 10px; */
    /* margin: auto; */
    left: 50%;
    /* padding-right: 17px; */
    top: 15px;
    margin-left: -27%;
    font-size: 12px;
    overflow: hidden;font-weight: 400;
}
.search p img{
    width: 13px;
    position: absolute;
    top: 2px;    margin-left: -15px;

}

      .agent_list li {
      /*height: 110px;*/
      border-bottom: 1px solid #e8e8e8;
      position: relative;
      padding-bottom: 14px;
      padding-top: 14px;
      }
      input[type="checkbox"] + label::before {
      content: "\a0";
      display: inline-block;
      vertical-align: .2em;
      width: 1.2em;
      /*  height: 1.2em;*/
      margin-right: .2em;
      border-radius: .2em;
      /* background-color: silver; */

      text-indent: .19em;
      line-height: 1.2;
      position: absolute;
      top: 15px;
      right: 0;
      margin-top: -0.6em;
      background-color: #fff;
      border: 1px solid #999;
      color: #f97241;z-index: 100
      }
      input[type="checkbox"]:checked + label::before {
      content: "\2713";
      }

      .agent_list input {
      position: absolute;
      clip: rect(0, 0, 0, 0);
      }
      .title>p{
      font-size: 12px;
      height: 30px;
      line-height: 30px;
      float: left;
      /*width: 50%; */
      }

      .title>p:nth-child(2){
      float:right;position: relative; text-align: right;   text-align: left;  
      }
      .title .name .dian{
      position: absolute;
      width: 5px;
      height: 5px;
      background-color: #53B1F9;
      /* display: inherit; */
      /* padding: 2px 5px; */
      /* border-radius: 50%; */
      margin-right: 10px;
      /* left: -10px; */
      top: 50%;
      margin-top: -2.5px;
      left: -6px;
      color: #fff;
      /* box-shadow: 0px 0px 5px #000; */
      }
      .item_ab{
      position: absolute;
      left: 110px;
      top: 16px;

      height: 75px;
      width: calc(100% - 130px);
      }
      .agent_icon{
      margin-left: 10px;
      width: 70px;
      height: 70px;
      /*border-radius: 50%;*/
      overflow: hidden;
      }


      .agent_icon>img{
      height: 100%;width: 100%;
      }

      .right img:nth-child(2){
      position: absolute;
      top: 12px;
      right: 10px;
      }
      .title .name .it_name{
      border-radius: 2px;
      background-color: #FA6B38;
      box-shadow: none;
      }
      .small{
      position: absolute;
      top: 6px;
      width: 20px;
      right: 4px;
      height: 20px;
      line-height: 16px;
      border-radius: 3px;
      padding: 3px;
      box-sizing: border-box;
      }

      .item-link .agent_icon{

      margin-top: 20px;
      width: 50px;
      height: 50px;
      } 
      .item-link .item_ab{


      left: 120px;
      top: 25px;
      width: calc(100% - 120px);
      } 
      .item_ab .title{
      position: relative;
      }
      .Brand {
      width: 100%;
      /* min-width: 111px; */
      display: inherit;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      position: relative;
      }

</style>
</head>
<body>
  <div class="form">
         <div class="table-hr">
           <div class='search'>
         <label>
            <input type="text" name="" value=""  placeholder="">  <!-- //请输入搜索的用户名 -->
            <p class="inputP"><img src="/static/images2/search_img.png" width='15px' alt="">请输入商品名称</p>

          </label>
            </div>

            <div class="fixing-total">
              <span class="total-tiele"><img src="/static/images2/fixing_list.png" width='100%'></span>
              <p  style="font-size: 12px;;line-height: 24px;float: left"> 总数：</p>
              <p style="font-size: 24px;;line-height: 24px;color: #FFFA00;;float: right" class='total_num'> 0</p>
              <div class="total-d"> </div>
               <p  style="clear:both;"></p>
           </div>
      </div>

    <div class="table_bd" style="padding:0 8px;margin-top:95px">
         <ul class="agent_list" id='list_data'>
              <li>
                  <img src="/static/images2/timg (1).png" class="agent_icon" />
                  <div class="item_ab">
                         <div class="title" >
                           <p  class="name" style="font-weight: bold">
                               <span></span>
                               黄宝兴
                           </p>
                           
                            <p  class="name">
                               <span style="background-color: #50CA9C"></span>
                               库存<i style="color:#FA6B38;font-weight: bold">100</i>
                           </p>
                           

                           <div style="clear:both;"></div>
                         </div>

                        <div class="title" >
                           <p  class="name"  style="font-size: 12px">
                               <span style="background-color: #FF9562"></span>
                               黄宝兴
                           </p>
                           
                          
                               <div   class="name"style="width:50px;    float: right;height: 3px;  margin-top: 13px;background-color: #F2F2F2; border-radius: 2px;overflow: hidden;">
                                  <p style="background-color: #f00;height: 5px;width: 50%;  "></p>
                              </div>
                           
                           

                           <div style="clear:both;"></div>
                         </div>
                  </div>


              </li>
        </ul>
    </div>
  </div>
 </body>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js?v=1" ></script>
<script>
 var stock_datas=<?=$stock_datas?>;
 // console.log(stock_datas)


$(function(){
  var info = JSON.parse(sessionStorage.getItem('info'));
   // console.log(info)

    data_init(stock_datas)
});

$('.search input').on('input propertychange', function() {
       var search=Trim($('.search input').val());
        if(search){
        $(".inputP").hide()
       }else{
           $(".inputP").show()
       }
           var dataD=[]; 
          $.each(stock_datas, function(key, value){
      
             if(value.BrandName){
              if(value.BrandName.indexOf(search) != -1 ){
                         dataD.push(value)
                     };
             }
                
          })
        // console.log(dataD)
         data_init(dataD)

         if(!search){
          data_init(stock_datas)
         }
 // list_item(dataD)
})






function data_init(list){
    $("#list_data").empty();
       $(".total_num").text(list.length)

       for(var index=0;index<list.length;index++){
       var item=list[index];
         // total_num++ 

        var html='<li>';
            if(item.goods_image1){
             var image  =item.goods_image1;
            if(item.goods_image1.indexOf("7xpcl7.com2.z0.glb.qiniucdn.com") != -1 ){
                  image =   item.goods_image1.replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
                html+='<div  class="agent_icon"> <img src="'+image+'"  /></div>';
             }else{
               html+='<div  class="agent_icon"> <img src="'+image+'"  /></div>';
             }
            }else{
               html+='<div  class="agent_icon"> <img src="/static/images2/timg (1).png"  /></div>';
             }
            html+='<div class="item_ab">';
            html+='<div class="title" >';
            html+='<p  class="name" style="font-weight: bold">';
            html+='<span class="dian"></span><span class="Brand">'+item.BrandName+'</span>';
            html+='</p>';
            html+='<p  class="name">';
            html+='<span  class="dian" style="background-color: #50CA9C" ></span>';
            html+='库存<span style="color:#FA6B38;font-weight: bold;    float: right;    padding:0 5px"><span class="Brand">'+item.stock+'</span></span>';
            html+='</p>';
            html+='<div style="clear:both;"></div>';
            html+='</div>';
            html+=' <div class="title" >';
            html+='<p  class="name"  style="font-size: 12px;width:100%">';
            html+='<span  class="dian" style="background-color: #FF9562"></span><span class="Brand">'+item.GoodsName+'</span>';
            html+='</p>';
            // html+='<div   class="name"style="width:50%;    float: right;height: 3px;  margin-top: 13px;background-color: #F2F2F2; border-radius: 2px;overflow: hidden;">';
            // html+='<p style="background-color: #f00;height: 5px;width: '+(item.stock/200)*100+'%;  "></p>';
            // html+='</div>';
            html+='<div style="clear:both;"></div>';
            html+=' </div>';
            html+='</div>';
            html+='</li>';                           
         $("#list_data").append(html);   
       }
     }


  </script>
 
</html>