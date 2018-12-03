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
    <title>电子水票</title>
    <style>
      body{
           background: #fff;
      }
      .table-hr{
        width: 100%;background-color: #fff;background:  url('/static/images2/Rectanglebg.png') no-repeat;    padding: 15px;
              background-position: 100% ;
      background-size: 100% 100%;color: #fff
      }
      .agent_icon {
          margin-left: 10px;
          width: 70px;
          height: 70px;
          border-radius: 50%;
          margin:auto;    border: 2px solid #fff;
          overflow: hidden;
   
      }
      .agent_icon>img{
        width: 100%;
      }

/*  td:nth-child(1){
      text-align: right
  }
td:nth-child(2){
  text-align: left
}
*/
 .table-hr  p{
    position: relative;
    font-size: 12px
   }
/* .table-hr p span:nth-child(1){
    position: absolute;
    margin-left: -13px;
    }*/
.hr-tail{
  width:80%;
  margin:auto; text-align: center;margin-top:10px;    margin-top: 15px;
}
.hr-tail .txt{
  text-align: center;width:50%;font-size: 12px;    float: left;position: relative;
}
.table_bd{
  padding: 10px;
}
.list{
width:100%;
border-bottom: solid 1px #ddd;padding:20px;  
}
.text{
  width: 100%;
  font-size: 12px;margin-top: 10px

}
.text>p{
  position: relative;

}
.txt>p:nth-child(1){
font-size: 15px;
    color:#fff;
    font-weight: bold;
}

.txt>p:nth-child(2){
font-size: 10px;
    color:#fff;
    margin-top:5px;
}
.text>p>img{
    position: absolute;
    width: 11px;
    /* height: 12px; */
    top: 1px;
    left: -15px;
}
.relation>div{
  width: 33%;float: left;text-align: center;
}
.relation>div p{
  line-height: 25px;
    font-size: 13px;
}

.layer_bg{
  text-align: center;
    position: relative;
    width: 90px;
    margin: auto;
    font-weight: bold;margin-top:10px;
}
.layer_bg img{
position: absolute;
    top: 4px;
    width: 12px;
}
.rank{
      display: block;
    width: 20px;
    height: 20px;
    position: absolute;
    background: #FA6B38;
    line-height: 23px;
    text-align: center;
    left: -25px;
    border-radius: 50%;
    color: #fff;
    top: -2px;
}
.iten_lay_list .list{
  padding-left: 25px
}
#complete,#Continuous_scanning
{

    height: 24px;
    padding: 2px 10px;
    font-size: 12px;
    background: rgba(229,229,229,1);
    border-radius: 900px;
    border: 1px solid rgba(199,199,199,1);
}
.layui-m-layer .table-hr ,.layui-m-layer .iten_lay_list *{
-webkit-box-sizing: border-box; 
    -moz-box-sizing: border-box;
     box-sizing: border-box; 
}
#Name{
    text-align: center;
    /*font-weight: bold;*/
    line-height: 40px;
    font-size: 14px
}
.NameTxt{
  width: 131px;    font-size: 13px;position: relative;    margin-left: 25px;
}
.NameTxt span{
  position: absolute;
    left: -15px;
        color: #FFEADB;
}
.NameTxt p{
position: absolute;
    margin-left: 54px;
    font-size: 12px;
    line-height: 15px;
    width: 99px;
    top: 0;
}
.table-hr .demarcation{
    position: absolute;
    width: 1px;
    height: 15px;
    background: #F26431;
    top: 50%;
    right: 0;
    margin-top: -7px;
}
.mode{
      padding-right: 15px;
    font-size: 13px;
    font-weight: bold;
    color: #00A1EC;position: relative; 
}.mode img{    position: absolute;}
</style>
</head>

<script type="text/html" charset="utf-8"  id="Ewm_html">
  <style>
    .layui-m-layer1 .layui-m-layercont{
          height: 100%;
    }
  </style>
  <div style="    overflow: auto;
    height: 100%;">
    

<div class="table-hr">
   <div class="agent_icon"> <img src="/static/images2/star.png"> </div>

     <div class="layer_bg" style="text-align: center;position: relative;">
      <img src="/static/images2/medal.png" style="    left: -5px;"> 
     扫码成功
       <img src="/static/images2/like.png" style="    right: -5px;"> 
   </div>
</div>
          <div class="iten_lay_list" style="padding: 10px;padding-bottom: 150px;">
              <ul>


              </ul>
            </div>
      <footer style="position: fixed;bottom: 0; height: 50px; text-align: center;line-height: 10px; padding: 5px;background: #fff;box-shadow:2px 2px 4px 3px rgba(169,169,169,0.5);width: 100%">
           <div class="relation" style="    width: 80%;margin:auto;    margin-top: 10px;">
                <button class="btn ativer" ativer='1' id='complete' style="   margin-left: 0px;">登记完成</button>
               <button class="btn ativer" id='Continuous_scanning' >继续扫描</button>     
           </div>
      </footer>

  </div>
</script>
<body>
  <div class="form" style="padding-bottom: 60px;">
      <div class="table-hr">
           <div class="agent_icon" style="position: absolute;top: 25px;"> <img src="/static/images2/timg (1).png"> </div>

           <div class="agent_text" style="    padding-left: 75px;">
             <p style="text-align: left;    text-indent: 10px;"><span id="Name"></span><span id='CustomerTypeName'></span></p>
            <div class="NameTxt"><span><img src="/static/images2/talbg.png" width="10"></span>电话：
              <p><span id="Tel"></span></p>
            </div>
             <div  class="NameTxt" style="margin-top:10px"><span><img src="/static/images2/mapbg.png" width="10"></span>地址：
              <p ><span  id="Address" style="    width: 135px;"></span></p>
            </div>             
           </div>
<!--            <table style=" width: 100%;margin:auto;border-collapse:separate; border-spacing:0px 10px;text-align: center">
             <thead>
               <tr>
                 <th  colspan="" headers="" style="text-align: center">中国移动</th>
               </tr>
             </thead>
             <tbody>
               <tr> 

                 <td ><p><span><img src="/static/images2/talbg.png" width="10"></span>电话：<span id="Tel"></span></p></td>
                
               </tr>
             <tr>
             <td colspan="" ></td>
        
             </tr>
             </tbody>
           </table> -->
           <div class="hr-tail">
                <div class="txt">
                  <p ><span id="RestWater"></span>L</p>
                  <p style="color:#FFEADB">剩余水量</p>
                  <p class="demarcation"></p>
                </div>
          <!--      <div class="txt" style="width:50%;">
                  <p  id="SendTime"></p>
                  <p  style="color:#FFEADB">送水要求</p>
                </div> -->
                <div class="txt" >
                  <p >￥<span id="RestMoney" ></span></p>
                  <p  style="color:#FFEADB">余额</p>
                </div>
              <div style="clear:both;"></div>
           </div>
      </div>
          <div class="table_bd">
              <ul>

              </ul>
          </div>
  </div>

      <footer style="position: fixed;bottom: 0; height: 70px; text-align: center;line-height: 10px; padding: 5px;background: #fff;box-shadow:2px 2px 4px 3px rgba(169,169,169,0.5);width: 100%;">
           <div class="relation" style="    width: 80%;margin:auto">
                <div id="buy_bnt" >
                  <img src="/static/images2/336301661886478879.png" style="width: 2rem;" /><p>电话联系</p>
                </div>
                <div id="fillIn" >
                  <img src="/static/images2/683530631146881841.png" style="width: 2rem;" /><p>填写送水</p>
                </div>
                <div id="purchase" >
                  <img src="/static/images2/264911799502841925.png" style="width: 2rem;" /><p>扫码送水</p>
                </div>

           </div>

      </footer>
 </body>
 <script type="text/javascript" src="/static/js/jquery.min.js"></script>
 <script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<!-- <script type="text/javascript" src="/static/js/zepto.min.js"></script> -->
<!-- <script type="text/javascript" src="/static/js/coderlu.js"></script> -->
<!-- <script type="text/javascript" src="/static/js/common.js?" ></script> -->
<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script> 
<script>
          var $BaseInfo=   JSON.parse(<?=json_encode($BaseInfo) ?>);
            var $datas=   JSON.parse(<?=json_encode($datas) ?>);
            var $UserId= <?=json_encode($UserId) ?>;
            var $CustomerType = <?=json_encode($CustomerType) ?>;
            var $AgentId = <?=json_encode($AgentId) ?>;
            var $saoma_data = <?=json_encode($saoma_data) ?>;
            console.log( $datas)
var CustomerTypeName='';
    switch(Number($CustomerType)){
              case 1:CustomerTypeName = '(家庭)';break;
              case 2:CustomerTypeName ='(集团)';break;
              case 3:CustomerTypeName ='(公司)';break;
              default:CustomerTypeName = '(其他)';
    };

// $("#CustomerTypeName").text(CustomerTypeName)
      if($saoma_data.appId&&$saoma_data.appId!=''){
                  // console.log(5);
                  wx.config({  
                    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
                    appId: $saoma_data.appId,
                     timestamp: $saoma_data.timestamp,
                        nonceStr: $saoma_data.nonceStr,
                        signature: $saoma_data.signature,//签名
                        jsApiList: [ 'onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'getLocation', 'openLocation','scanQRCode'
                     ,"chooseImage", "previewImage", "uploadImage", "downloadImage"] 
         });
      }


            if($BaseInfo){
              console.log($BaseInfo)
                  for(var i in $BaseInfo){
                  
                      if($BaseInfo[i]==''||$BaseInfo[i]==null){
                        $BaseInfo[i]='无'
                      }
                      if(i=='Address'){
                          if($BaseInfo.RoomNo){
                            $("#"+i).text($BaseInfo[i]+$BaseInfo.RoomNo)
                          }else{
                          $("#"+i).text($BaseInfo[i])
                          }
                      }else if(i=='Tel'){
                        var str=$BaseInfo[i];
                        var newStr = ''+str.substr(0,3)+'-'+str.substr(3,4)+'-'+str.substr(7);
                            $("#"+i).text(newStr)
                      }
                      else if(i=='Name'){
                       
                            $("#"+i).text($BaseInfo.Name+'-'+CustomerTypeName)
                      }
                      else if(i=='RestWater'){
                       
                            $("#"+i).text($BaseInfo.RestWater*1)
                      }
                      else if(i=='HeadPortrait'){
                               if($BaseInfo.HeadPortrait&&$BaseInfo.HeadPortrait!='无'){
                                $(".agent_icon img").attr('src',$BaseInfo.HeadPortrait)
                               }
                      }
                      else{
                        $("#"+i).text($BaseInfo[i])
                      }
                 }
            }

if($datas.length){
   $(".table_bd ul").empty()
        for(var i=0;i<$datas.length;i++){
          var item = $datas[i];
           var html ='';

             // console.log(item.PayType)
              if(item.PayType){


                var nameTxt = '充值';
                var nameCenter = '用户充值';


               
                if(item.PayType==4){
                  nameTxt='转账';

                   if(item.OutOrIn==-1){
                       nameCenter = item.GroupMemberName+'退组';
                    }else if(item.OutOrIn==1){
                      nameCenter = item.GroupMemberName+'入组';
                    }else if(item.OutOrIn==2){
                      nameCenter = item.GroupMemberName+'修改为组长';
                    }
                }


                 html='<li>';
                 html+='<div class="list" >';
                 // html+='<div class="text" style="margin: 0;">';
                 // // html+='<p   style="float: left;color:#313131;font-weight: bold">充值</p>';
                 // // html+='<p  style="float: right;width: 50px; text-align: left;">已完成</p>';
                 // // html+='<p  style="clear:both;"></p>';


                 // html+='</div>';
                 html+='<div class="text">';

                html+='<p   style="float: left;color:#313131;font-weight: bold"> <img src="/static/images2/435891328517834925.png" style="top: 4px;">'+nameTxt+'<span style="font-size: 10px;font-weight: 400;margin-left: 5px;">'+item.RowTime+'</span></p>' ;

                 html+='<p  style="float: right;width: 80px; text-align: right; "><span class="mode">'+ PayType(item.PayType)+'</span>已完成</p>';
                 html+='<p  style="clear:both;"></p>';
                 html+='</div>';
                 html+='<div class="text" style="margin-top:20px">';
                 html+='<p   style="float: left;font-weight: bold;">'+nameCenter+'<span></span></p>';
                 html+='<p  style="float: right;width: 50px; text-align: right;font-weight: bold">'+(item.PayMoney*1>0?'<span style="">+'+item.PayMoney+'</span>':item.PayMoney)+'</p>';
                 html+='<p  style="clear:both;"></p>';
                 html+='</div>';
                 html+='<div class="text">';
                 // html+='<p   style="float: left;"> <img src="/static/images2/teme.png" >充值时间：<span>'+item.RowTime+'</span></p>';
                 html+='<p  style="float: right; text-align: left;;font-weight: bold;">合计金额：<span  style="color: #D75302;">￥'+item.PayMoney+'</span></p>';
                 html+='<p  style="clear:both;"></p>';
                 html+='</div>';
                 html+=' </div> </li>'; 
              }else{
                   html='<li>';
                   html+='<div class="list" >'; 
                   html+='<div class="text" style="margin: 0;">'; 
                   html+='<p   style="float: left;color:#313131;font-weight: bold"> <img src="/static/images2/692967739677603094.png" style="top: 4px;">送水<span style="font-size: 10px;font-weight: 400;margin-left: 5px;">'+item.RowTime+'</span></p>'
          if(item.State==1){
          

           // html+='<p  style="float: right;width: 80px; text-align: right;    color: #D65100;"><span class="mode"> <img src="/static/images2/522033396470156587.png" style="top: 4px;width:10px"></span>';
            html+='<p style="float: right;"><img src="/static/images2/522033396470156587.png" style="top: 4px;width:10px">';
              html+='<span class="State" data="'+item.Id+'" style="float: right;width: 60px; text-align: center;padding: 2px;border-radius: 5px;color: #fff;background: red;">待确认</span>'; 
           html+='</p>';
          }else{
           html+='<p  style="float: right;width: 80px; text-align: right; "><span class="mode"> <img src="/static/images2/522033396470156587.png" style="top: 4px;width:10px"></span>已完成</p>';

          }


                   html+='<p  style="clear:both;"></p>'; 
                   html+='</div>'; 

                   html+='<div class="text" style="margin-top:20px"> '; 
                   html+='<p  style="float: left;;font-weight: bold;"><span>'+item.BrandName+'-'+item.GoodsName+item.Volume*1+'L</span></p>'; 
                   html+='<p   style="float: right;">-'+item.Price+'×'+item.Amount+'</p>'; 
                   // html+='<p   style="float: right;">水商品 ：<span>'+item.GoodsName+'</span></p>'; 
                   html+='<p  style="clear:both;"></p>'; 
                   html+='</div>'; 
                   html+='<div class="text">'; 
                   var rmb = item.Price*item.Amount
                   html+='<p  style="float: right; text-align: right;;font-weight: bold;">合计金额：<span style="color: #D75302;">￥-'+formatCurrency(rmb) +'</span></p>';
                   // html+='<p   style="float: right;">水品牌 ：<span>'+item.BrandName+'</span></p>'; 
                   html+='<p  style="clear:both;"></p>'; 
                   html+='</div>'; 
                   html+='</div></li>';  
              }
          $(".table_bd ul").append(html)
        }
function formatCurrency(num) {  
    num = num.toString().replace(/\$|\,/g,'');  
    if(isNaN(num))  
        num = "0";  
    sign = (num == (num = Math.abs(num)));  
    num = Math.floor(num*100+0.50000000001);  
    cents = num%100;  
    num = Math.floor(num/100).toString();  
    if(cents<10)  
    cents = "0" + cents;  
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)  
    num = num.substring(0,num.length-(4*i+3))+','+  
    num.substring(num.length-(4*i+3));  
    return (((sign)?'':'-') + num + '.' + cents);  
}  

   $('body').find(".State").click(function(){
       var ids= $(this).attr('data');
       // console.log(ids);
      //询问框
      layer.open({
            content: '<p style="    font-size: 15px;font-weight: bold;padding: 40px;text-align: center;line-height: 28px;">系统将会发送消息告知用户，确定已完成送水了吗?<p>'
            ,btn: ['确定', '取消']
            ,yes: function(index){
            $.get('/index.php/agent/update-state?ids='+ids, function(json) {
                  var data = json; 
                  if(typeof(json)=='string'){
                       data= eval('(' + json + ')');
                    }
                  var msg='';
                   if(data.state==-1){
                      msg=data.msg
                   }else{
                      msg='修改成功'
                   };
                   layer.open({
                        content:msg
                        ,btn: '确定'
                        ,shade: 'background-color: rgba(0,0,0,.3)'
                      , end:function(){
                          window.location.reload(); 
                        }
                       });
               }); 
              layer.close(index);
            }
          });
   });
 };
    $('body').find("#complete").click(function(){
             window.location.href='/index.php/agent/index';
      })
     $('body').find("#purchase").on('click', function () {
           if($saoma_data.appId&&$saoma_data.appId!=''){
               var pageii = layer.open({
                    type: 1
                    ,content: $("#Ewm_html").html()
                    ,anim: 'up'
                    ,shadeClose: false
                    ,style: 'position:fixed; left:0; top:0; width:100%; height:100%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s;'
                });
                Scanned_html()
              $('body').find("#Continuous_scanning").on('click', function () { Scanned_html() });
            }else{
              console.log('没有appId');
            }
     })
     $('body').find("#fillIn").on('click', function () {
            window.location.href="create-send-water?UserId="+$UserId+"&CustomerType="+$CustomerType+"&AgentId="+$AgentId;
      })
    $('body').find("#buy_bnt").on('click', function () {
            console.log(4)
            var html ='';
            html +='';
            html +=' <div style="width:100%;height:100px;padding:10px;text-align: center;   box-sizing: border-box;">';
            html +='    <img src="/static/images/telbfA.png" alt="" height="100%;" >';
            html +=' </div>';
            html +='  <div class="tel" style="text-align: center;padding: 0 20px 20px 20px;    margin-top: -20px;">'
            html += '<a href="tel:'+$BaseInfo.Tel+'"> <p style="background: url(/static/images/btnv.png) no-repeat center;background-size: 100% 100%;height: 50px;  border-radius: 5px;     width: 200px;margin: auto;    margin-top: 50px;color: #fff;line-height: 50px;">拨打：'+$BaseInfo.Tel+' </p></a> ';
            html +='   </div>'
            html +='  <p class="cancel" style="   border-radius: 5px;     width: 80%; background: #DEDEDE;background-size: 100% 100%;height: 50px;   margin:auto;text-align: center;  width: 200px;margin: auto; line-height: 50px;"> 取消 </p>'
              var titleHtml ='';
             titleHtml +='   <div  class="cancel"  style="position: absolute;width:30px;height:30px;background: #fff;border-radius:50px;top:13px;right:  15px;text-align: center;">';
            titleHtml +='<img src="/static/images/ridaus2.png" alt="" width="12px;" style="margin-top: 10px;">';
            titleHtml +=' </div>';
              var ii =layer.open({
            title: [
              titleHtml,
              'background: #FF4351 url(/static/images/btnBgA.png) no-repeat top;background-size: 161% 160%;background-position: 80% 70%;color:#fff;margin: 0;    padding: 0;height:50px;line-height:30px;'
            ]
            ,content:html
          });
              $(".tel p").hover(function(){
                 $(this).css('background','url(/static/images/btnBgB.png)  no-repeat  center;background-size: 100%  100%')
            },function(){
            $(this).css('background','url(/static/images/btnBgA.png)  no-repeat  center;background-size: 100%  100%')
            });
              $(".layui-anim").css("borderRadius",'50px');
              $(".cancel").click(function(){
                   layer.close(ii);
              });
        })
function PayType(data){
  var PayType=''
   switch(Number(data)){
        case 1:PayType = '<img src="/static/images2/212683863915201989.png" style="top: 2; width: 20px;left: -10px;">';break;
        case 2:PayType ='<img src="/static/images2/weixingrem.png" style="top: 0; width: 18px;left: 25px;">';break;
        case 3:PayType ='<img src="/static/images2/zhifubao.png" style="top: 0; width: 18px;left: 25px;">';break;
        case 4:PayType ='<img src="/static/images2/613039002635736151.png" style="top: 0; width: 18px;left: -10px;position:absolute">';break;
        default:PayType = ' ';
    }
    return PayType;
};
function Scanned_html(){
  console.log(5555555)
        var itemAmount=$(".iten_lay_list").find("li").length;
        wx.ready(function() {
                        wx.scanQRCode({   
                            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                            scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                            success: function (res) {
                            // var resultStr = res.resultStr;
                            var resultStr=  res.resultStr.split(',')[1];
                            // alert(resultStr)
                        
     // alert(itemAmount)

                            var infoByCode = checkTel({'code':resultStr,'UserId':$UserId,'AgentId':$AgentId,'CustomerType':$CustomerType},"/index.php/agent/get-info-by-code");
                             // alert(JSON.stringify(infoByCode))


                          if(infoByCode.state==-1){
                                    //询问框
                                    layer.open({
                                    content: infoByCode.msg
                                    ,btn: ['确定']
                                    ,anim: 'up'
                                    ,shadeClose: false
                                    ,yes: function(index){
                                      if(itemAmount>=1){
                                        // location.reload();
                                        layer.close(index);
                                        }else{
                                          location.reload(); 
                                        }
                                      }
                                  }); 
                            }else{
                              var date = new Date();
                              var d = date.getFullYear() + "年" + (date.getMonth() + 1) + "月" + date.getDate() + "日" +date.getHours()+ ":" + date.getMinutes()+":"+date.getSeconds();

                         
                                 
                                var html='<li>';
                                    html+='<div class="list">';
                                    html+='<div class="text" style="margin: 0;">';
                                    html+='<p style="color:#313131;font-weight: bold"><span class="rank">'+((itemAmount+1)<10?'0'+(itemAmount+1):(itemAmount+1))+'</span><span class="name">'+infoByCode.info.BrandName+'</span></p>';
                                    html+='</div>';
                                    html+='<div class="text">';
                                    html+='<p style="float: left;">商品名称：<span class="goods_L">'+infoByCode.info.GoodsName+'</span></p>';
                                    html+='<p style="float: right; text-align: center;">净含量：<span  class="goods_name">'+infoByCode.info.Volume+'</span>:L</p>';
                                    html+='<p style="clear:both;"></p>';
                                    html+='</div>';
                                    html+='<div class="text">';
                                    html+='<p >充值时间：<span class="goods_teme">2018-10-22 10:31:09</span></p>';
                                    html+='</div> ';
                                    html+='</div>';
                                    html+='</li>';
                                 $(".iten_lay_list ul").append(html);

                            }
                          //      // alert(3);
                          //   var date = new Date();
                          //  var d = date.getFullYear() + "年" + (date.getMonth() + 1) + "月" + date.getDate() + "日" +date.getHours()+ ":" + date.getMinutes()+":"+date.getSeconds();
                          //  var itemAmount=$(".iten_lay_list").find("li").length;
                          //   alert(1)
                          // var itemAmountIndex = itemAmount*1+1;
                          //  // alert(itemAmountIndex)
                          // var html='<tr class="item"> <td style="width:15px">';
                          //     html+='<div style="padding:5px;">';
                          //     html+='<span>'+itemAmountIndex+'</span>';
                          //     html+='</div>';
                          //     html+='</td>';
                          //     html+='<td >';
                          //     html+='<p>品牌：'+infoByCode.info.BrandName+'</p>';
                          //     html+='<p>商品名称：'+infoByCode.info.GoodsName+'  </p>';
                          //     html+='<p>净含量：'+infoByCode.info.Volume+'L</p>';
                          //     html+='<p>'+d+'</p>';
                          //     html+='</td>';
                          //     html+='</tr>';
                          //     $("#PhotoBarCode tbody").prepend(html);
                          //    // if(itemAmountIndex==1){
                          //    //  accountObj.codes_str=infoByCode.info.Code;
                             // }
                          // else{
                            // layer.close(pageii);
                            // pageii
                          //    //    accountObj.codes_str=accountObj.codes_str+","+infoByCode.info.Code;
                          //    // }

                          //    var  scanningIndex = mui(".mui-slider").slider().getSlideNumber()
                          //         if(scanningIndex<1){
                          //              mui('.mui-slider').slider().gotoItem(1);
                          //                  layer.closeAll();
                          //         }
                          //         }else{

                          //            layer.open({
                          //           content: infoByCode.msg
                          //             ,btn: '确定'
                          //             ,anim: 'up'
                          // });
                                  // }

                            },
                            cancel:function(res){
                            // alert('取消')
                               location.reload()

                               if(itemAmount>=1){
                                // location.reload();
                                // layer.close(index);
                                }else{
                                  location.reload(); 
                                }
                            },
                            fail:function(){
                            // alert('调用失败')
                                location.reload()
                            }
                        });
                    });
                        wx.error(function(res){
                            // alert(res);
                            // console.log(res)
                            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
                        });
}





// get访问方法
function checkTel(obj,$url){
  var dataNo='';
     $.ajax
       ({cache: false,
           async: false,
           type: 'get',
           data:obj,
           url: $url,
           success: function (data) {
             if(typeof(data)=='string'){
                dataNo=  jQuery.parseJSON(data);
              }else{
                dataNo = data;
              }
           }
       });
    return dataNo;
}



</script>
 
</html>