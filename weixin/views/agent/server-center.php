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
    <title>服务中心</title>
    <style>
      
      .table-hr{
      border-bottom:1px solid #f3f3f3;
      position: fixed;
      width: 100%;
      top: 0;       
       /*height: 90px;*/
      font-weight: bold;    background: #fff;
      z-index: 998;
/*    padding-right: 10px;background: #f3f3f3 url('/static/images2/163463112660427649.png') no-repeat;
      background-position: 100% ;
      background-size: 100% 140px;*/
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
      width: 80%;
      border-radius: 17px;
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
      .search button{
      width: 70px;
      /*text-align: right;  */
      font-size: 14px;height: 25px;
      border:none;
      color: #FA6B38;
      background-color: transparent;
      border-radius:900px;
      border:1px solid rgba(250,107,56,1);

      }
      .agent_list li {
      height: 110px;
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
      /*height: 30px;*/
      line-height: 25px;
      float: left;
      width: 50%; 
      }

      .title>p:nth-child(2){
      float:right;position: relative; text-align: right;   text-align: left;  
      }

      .item_ab{
    position: absolute;
    left: 110px;
    top: 26px;
    height: 65px;
    width: calc(100% - 130px);
      }
      .agent_icon{
      margin-left: 30px;
      width: 50px;
          margin-top: 10px;
      height: 50px;
      border-radius: 50%;
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
            .title .name{
          float: left;
        }
             .title .name p{
              display: block;text-align: center;position: relative;
             }
                .title .name p span{
                position: absolute;
    width: 5px;
    height: 5px;
    background-color: #E0E0E0;
    left: -10px;
    top: 6px;
    border-radius: 50%;
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
    /*  display: inherit;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      position: relative;*/
      }
.deliver_water{
    float: right;
    padding: 0 5px;
}.demand{

    width: 5px;
    height: 5px;
    background-color: #FA6B38;
    float: left;
    position: absolute;
    top: 5px;
    margin-left: 10px;
    border-radius: 50%
}
.sign{
  position: absolute;
    top: 50%;
    margin-top: -10px;
}

</style>
</head>
<body>
  <div class="form">
      <div class="table-hr">
           <div class='search'>
               <label>
                  <input type="text" name="" value=""  placeholder="请输入搜索的用户名">
              </label>
            </div>

          <!--   <div class="fixing-total">
              <span class="total-tiele"><img src="/static/images2/fixing_list.png" width='100%'></span>
              <p  style="font-size: 12px;;line-height: 24px;float: left"> 总数：</p>
              <p style="font-size: 24px;;line-height: 24px;color: #FFFA00;;float: right" class='total_num'> 0</p>
              <div class="total-d"> </div>
               <p  style="clear:both;"></p>
           </div> -->
      </div>
    <div class="table_bd" style="padding:0 15px;margin-top: 55px;">
         <ul class="agent_list" id='list_data'>
              <li>
                <span class="sign">1</span>
               <div class="agent_icon"> 
                   <img src="/static/images2/timg (1).png" />
               </div>
               <div class="item_ab">
                <div class="title"
                 <p class="name" style="font-weight: bold"><span class="Brand"><span style="float: left;    font-size: 15px;">黄晓霞</span> <span class="demand"></span></span></p>
                   <div style="clear:both;"></div>
                </div> 
                <div class="title"  style="position: absolute;bottom:0;width: 100%">
                 <div  class="name" style="font-size: 12px">
                         <p style="font-size: 14px"><span></span>72</p>
                         <p><span></span>总用户数</p>
                 </div>
                 <div  class="name" style="font-size: 12px;float: right;">
                          <p  style="font-size: 14px"><span></span>  72</p>
                         <p><span></span>水销量总数</p>
                 </div>
                 <div style="clear:both;"></div> 
               </div>
             </li>
        </ul>
    </div>
  </div>
 </body>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js?" ></script>
<script>

  var res=<?=json_encode($data)?>;

        // console.log(res)

data_init(res.result)

$('.search input').on('input propertychange', function() {
       var search=Trim($('.search input').val());

           var dataD=[]; 
          $.each(res.result, function(key, value){
                if(value.name.indexOf(search) != -1 ){
                         dataD.push(value)
                };
          })

        // console.log(dataD)
   data_init(dataD)
})

  function data_init(list){

     $("#list_data").empty();
           var total_num=0;
       $(".total_num").text(list.length)
         for(var index=0;index<list.length;index++){
           var item=list[index];
                 // console.log(item);
             total_num++
          var html='<li>';
              html+='<span class="sign">'+total_num+'</span>';
              html+='<div class="agent_icon"> ';
             if(item.image!=''){
                var image=item.image;
                 if(image.indexOf("7xpcl7.com2.z0.glb.qiniucdn.com") != -1 ){
                         image =image.replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
                       }
                html+='<img src="'+image+'" />';
             }else{
              html+='<img src="/static/images2/timg (1).png" />';
             }
              


              html+='</div>';
              html+='<div class="item_ab">';
              html+='<div class="title">';
           html+='<p class="name" style="font-weight: bold;    width: 100%;margin-left: -15px;"><span class="Brand"><span style="float: left;line-height: 12px;">'+item.name+'</span> <span class="demand"></span></span></p>';
              html+=' <div style="clear:both;"></div>';
              html+='</div>';
              html+='<div class="title"  style="position: absolute;bottom:0;width: 100%">';
              html+='<div  class="name" style="font-size: 12px">';
              html+='<p style="font-size: 14px"><span style="background: none;top: 0;left: -15px;"><img src="/static/images2/507622878295410784.png" style="width: 1rem;" /></span>'+item.totaluser+'</p>';
              html+='<p><span></span>总用户数</p>';
              html+='</div>';
              html+='<div  class="name" style="font-size: 12px;float: right;">';
              html+='<p  style="font-size: 14px"><span style="background: none;top: 0;left: -15px;"><img src="/static/images2/536539445301906880.png" style="width: 1rem;" /></span>  '+item.totalwatersale+'</p>';
              html+='<p><span></span>水销量总数</p>';
              html+='</div>';
              html+='<div style="clear:both;"></div> ';
              html+='</div>';
              html+='</li>';
                $("#list_data").append(html);
         }
  }
  </script>
 
</html>