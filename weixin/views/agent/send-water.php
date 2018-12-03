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
    <title>智能送水</title>
    <style>
      body{
           background: #fff;
      }
      .table-hr{
      border-bottom:1px solid #f2f2f2;
      position: fixed;
      width: 100%;
      top: 0;    
      font-weight: bold;    background: #fff;
      z-index: 998;
    /*      padding-right: 10px;background: #f3f3f3 url('/static/images2/163463112660427649.png') no-repeat;
      background-position: 100% ;
      background-size: 100% 140px;*/
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
    top: 1px;    margin-left: -15px;

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
      border-bottom: 1px solid #EFEFEF;
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
        font-size: 14px;
    /* height: 30px; */
    min-height: 25px;
    line-height: 22px;
    float: left;    background: #fff;
    width: 70%;
    padding-left: 2px;
    /* position: relative; */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
      }
      .title:nth-child(1) {
          padding-bottom: 12px;
      }
      .title>p:nth-child(2){
      float:right;position: relative; text-align: right;   text-align: left;  
      }
      .title .name .dian{
  /*position: absolute;*/
    width: 5px;
    height: 5px;
    /* background-color: #53B1F9; */
    /* display: inherit; */
    /* padding: 2px 5px; */
    /* border-radius: 50%; */
    margin-right: 10px;
    left: -10px;
    top: 17%;
    margin-top: -2.5px;
    left: -17px;
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
      /*width: 100%;*/
      /* min-width: 111px; */
    /*  display: inherit;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;*/
      position: relative;
      }
.deliver_water{
    float: right;
    padding: 0 5px;font-size: 12px;
}
.demand{
position: absolute;
    right: -20px;
}.table-foot{
  /*border-top:1px solid #b5abab;*/
  height: 50px;
    line-height: 50px;position: fixed;width: 100%; bottom:0;font-weight: bold;background: #fff;z-index: 997;font-size: 13px;    padding: 0 20px;
    padding-top: 10px;
    box-sizing: border-box;
}
    .nuber{
    position: absolute;
    margin-left: -25px;
    color: #666666;
    font-weight: 400;
    width: 20px;
    text-align: right;
    }
</style>
</head>
<body>
  <div class="form">
      <div class="table-hr">
           <div class='search'>
           <label>
            <input type="text" name="" value=""  placeholder="">  <!-- //请输入搜索的用户名 -->
            <p class="inputP"><img src="/static/images2/search_img.png" width='15px' alt="">请输入用户名/电话</p>

          </label>
            </div>
      </div>
    <div class="table_bd" style="padding:0 8px;margin: 55px 0;">
         <ul class="agent_list" id='list_data'>
              <li>
               <div class="agent_icon"> 
                   <img src="/static/images2/timg (1).png" />
               </div>
               <div class="item_ab">
                <div class="title">
                 <p class="name" style="font-weight: bold"><span class="Brand"><span style="float: left;    font-size: 15px;">黄晓霞</span> <span class="demand">需送货</span></span></p>
                 <p class="name"><span class="Brand">  <span class='deliver_water' >需送货</span></span></span></p>
                 <div style="clear:both;"></div>
                </div> 
                <div class="title">
                 <p class="name" style="font-size: 12px;width: 100%;"><span class="dian" style="background-color: #FF9562"></span><span class="Brand">剩余水量：<span>18L</span></span></p>
               
                 <div style="clear:both;"></div> 
                </div>
                 <div class="title">
                 <p class="name" style="font-size: 12px;width: 100%;"><span class="dian" style="background-color: #FF9562"></span><span class="Brand">送水时间：<span>12545455</span></span></p>
                
                 <div style="clear:both;"></div> 
                </div>

              <img src="/static/images/arrow_right.png" style="position:absolute;right:-10px;top:50%;height:20px;width:auto;    margin-top: -10px;"/>

               </div>
             </li>
        </ul>
    </div>

        <div class="table-foot">
       

             <p style="text-align: center ;     color: #A4A4A4;border-top: 1px solid #d4d4d4  ;line-height: 36px;;"> 总用户数为：<span  class='total_num' style="color:#FA6B38"></span>    </p>
    </div>

  </div>
 </body>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js?" ></script>
<script>

var datas=   JSON.parse(<?=json_encode($datas) ?>);
console.log(datas)
data_init(datas.datas)


var  valp = $('.search input').val();

console.log(valp)

if(valp){
        propertychangeFUn(valp)
}


$('.search input').on('input propertychange', function() {
       var search=Trim($('.search input').val());
      propertychangeFUn(search)
})



function propertychangeFUn(search){
       if(search){
        $(".inputP").hide()
       }else{
           $(".inputP").show()
       }
           var dataD=[]; 
          $.each(datas.datas, function(key, value){
                if(value.Name.indexOf(search) != -1 ){
                  dataD.push(value)
                }else if(value.Tel.indexOf(search) != -1 ){
                         dataD.push(value)
                } ;
          })

        // console.log(dataD)
   data_init(dataD)
}


 function data_init(data){

       $(".total_num").text(data.length);
        // 清除表格数据
          $("#list_data").empty();
          for(var index=0;index<data.length;index++){
            var item=data[index];
             for(var i in item){
               if(item[i]==null){
                item[i]=''
               }
             }

             var html = '<li>';
             html+='<a href="/index.php/agent/send-water-detail?UserId='+item.UserId+'&CustomerType='+item.CustomerType+'&AgentId='+item.AgentId+'">';
             html+='<div class="agent_icon"> ';
     if(item.HeadPortrait!=''||item.HeadPortrait){
         html+='<img src="'+item.HeadPortrait+'" />';
     }else{
      html+='<img src="/static/images2/timg (1).png" />';

     }
    html+=' </div>';
    html+=' <div class="item_ab">';
    html+='<div class="title">';
    html+='<p class="name  name_item_ab" style="font-weight: bold;width:calc(100% - 90px)"> <span class="nuber">'+(index+1)+'</span> <span class="Brand"><span style="">'+Trim(item.Name)+'</span>'; 
    
    if(item.State==1){
      html+='<span class="demand" style="margin-left:10px;"><img src="/static/images2/736025147528460388.png" style="width: 0.7rem;" /></span>';
      // html+='<span class="demand" style="margin-left:10px;background-color:'+StateColor(item.State)+'">'+condition2(item.State)+'</span>';
    }else if(item.State==2){
          html+='<span class="demand" style="margin-left:10px;"><img src="/static/images2/55466247744536837.png" style="width: 0.7rem;" /></span>';
    }
      html+='</span></p>';
     html+='<p class="name" style="width:50px"><span class="Brand" >  <span class="deliver_water"  style="color:'+StateColor(item.State)+'">'+condition(item.State)+'</span></span></span></p>';
     html+='<div style="clear:both;"></div>';
     html+='</div> ';
     html+='<div class="title">';
     html+='<p class="name" style="font-size: 12px;width: 100%;"><span class="dian"><img src="/static/images2/722972804639442003.png" style="width: 0.7rem;" /></span><span class="Brand">剩余水量：<span>'+item.RestWater+'L</span></span></p>';
     html+='<div style="clear:both;"></div> ';
     html+='</div>';
     html+='<div class="title">';
     html+=' <p class="name" style="font-size: 12px;width: 100%;"><span class="dian"><img src="/static/images2/205214726853717428.png" style="width: 0.7rem;" /></span><span class="Brand">建议送水时间：<span>'+item.SendWaterTime+'</span></span></p>';
     html+='<div style="clear:both;"></div> ';
     html+='</div>';
     html+='<img src="/static/images/arrow_right.png" style="position:absolute;right:-10px;top:50%;height:12px;width:auto;    margin-top: -10px;"/>';
     html+='</div>';
     html+='</a>';
     html+=' </li>';
      $("#list_data").append(html)  
      }  
 }
function condition(State){
             if(State==''||State==null||State==0){
                State='';
             }
              if(State == 1){
              return "需送水";
              }
              else if(State == 2){
              return "已配送";
              }
              else if(State==3){
              return "已完成";

              }else{
              return "其他";
              }
 }

 function condition2(State){
             if(State==''||State==null||State==0){
                State='';
             }
             if(State == 1){
                return "需";
              }
              else if(State == 2){
                  return "配";
                  
              }
              else if(State==3){

                 return "";
      
              }else{
                return "其他";
              }
 }
function StateColor(State){
               if(State == 1){
                  return "#FA6B38";
                }
                else if(State == 2){
                    return "#5DB5F9";
                }
                else if(State==3){

                   return "";
        
                }else{
                  return "";
                }
       }
  </script>
 
</html>