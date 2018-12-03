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
    <title>运营中心系统</title>
    <style>
        #header{
            height:140px;
            width:100%;
            border-bottom:2px #f3f3f3 solid;
            background:url("/static/images/bgcp.png");
            background-size: 100% 140px;
            background-position: center;
            background-repeat: no-repeat;
        }
        .grid_item{
            float:left;
            width:33.3%;position: relative;
            height:100px;
        }
        .grid_item>a>div{
            left:50%;margin-left:-57px;position:relative;width:114px;text-align:center
        }
        .grid_item>a>div>img{
            display:inline-block;margin-top:20px;width:65px;height:65px;margin-right:5px;
        }
           .grid_item>a>div>p{
            font-size: 12px;
           }
        #gridContainer{
            border-bottom:4px #f3f3f3 solid;
            border-top:4px #f3f3f3 solid;
            float:left;
            width:100%;
        }
        #footer_left{
         
        }
        #footer_right{
           
        }
        .footer_1{
            height:110px; float:left;
            padding-top:10px;
            width:30%;text-align:center;

        }
        #footer{
            margin-top:40px;
        }
        .footer_header{
            float:left;        width: 100%;
        }
        .footer_footer{
             float:left;
        }
        .num_c{
            font-size:24px;
                position: absolute;
    right: 22%;
            text-align:center;
            height:50px;
            line-height:50px;   text-align: right;
        }
        .icon_rise{
            background-image: url("/static/images/rise.png");
            background-size: 10px 10px;
            width:10px;
            height:10px;
            display:inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }
        .icon_drop{
            background-image: url("/static/images/drop.png");
            background-size: 10px 10px;
            width:10px;
            height:10px;
            display:inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }
        .stat_label{
            text-align:center;
            font-size:12px;
            height:26px;
            line-height:26px;
        }

        
        .footer_footer{
            width:60%;
           padding-left: 20px;
            border-bottom:1px solid #999;
            padding-bottom:10px;
        }
        .footer_footer p{
            float:left;width:30%;
        }
        .hide{
            display: block;
        }
        .quipment{
            display: none;
         }
    </style>
</head>
<body>
    <div id="container">
        <header id="header">
            <p style="text-align:center;padding-top:20px;">
                <img src="/static/images/xiongmao.png" style="width:80px;height:auto;"/>
            </p>
            <p style="text-align:center;color:#fff" id="Name"></p>
        </header>
        <div id="gridContainer">
            <div class="gridnamr" style="width:100%;border-bottom:4px #f3f3f3 solid;    padding-bottom: 25px;">
                    <div class="grid_item" style="">
                <a href="/index.php/agent/chart">
                    <div style="">
                        <img src="/static/images/before-01.png" style=""/>
                        <p>报表</p>
                    </div>
                </a>
            </div>

            <div class="grid_item  hide register" style="">
                    <a href="/index.php/agent/ont-open">
                        <div style="">
                            <img src="/static/images/before-02.png" style=""/>
                            <p>登记</p>
                        </div>
                    </a>
                </div>
                <div class="grid_item  deliver_water" style="">
                <!-- <a href="/index.php/agent/send-water"> -->
                           <a href="/index.php/agent/ont-open">
                    <div style="">
                        <img src="/static/images/before-03.png" style=""/>
                        <p >智能送水</p>
                    </div>
                </a>
            </div>
                 <div style="clear:both;"></div>
            </div>
       <div class="gridnamr" style="width:100%;border-bottom:4px #f3f3f3 solid;    padding-bottom: 25px;">
            
            <div class="grid_item hide  level5" style="">
                <a href="/index.php/agent/server-center">
                    <div style="">
                        <img src="/static/images/server_icon.png" style=""/>
                        <p>服务中心</p>
                    </div>
                </a>
            </div>
            <div class="grid_item hide quipment" style="">
                <a href="/index.php/agent/investor">
                    <div style="">
                        <img src="/static/images/before-04.png" style=""/>
                        <p>设备列表</p>
                    </div>
                </a>
            </div>
            <div class="grid_item  user_ad" style="">
                <a href="/index.php/agent/users">
                    <div style="">
                        <img src="/static/images/before-05.png" style=""/>
                        <p>用户</p>
                    </div>
                </a>
            </div> 
             <div class="grid_item hide" style="">
                    <a href="/index.php/agent/dev-warning">
                        <div style="r">
                            <img src="/static/images/before-06.png" style=""/>
                            <p>硬件告警</p>
                        </div>
                    </a>
             </div>

            <div style="clear:both;"></div>
			</div>

      <div class="gridnamr" style="width:100%;    padding-bottom: 25px;">
            <div class="grid_item  server_icon " style="">
                <a href="/index.php/agent/stock-manage">
                    <div style="">
                        <img src="/static/images/server_icon.png" style=""/>
                        <p>库存管理</p>
                    </div>
                </a>
            </div>
        
            <div style="clear:both;"></div>
      </div>
        </div>
        <div style="clear:both;"></div>
        <div id="footer">
            <div id="footer_left">
                <div class="footer_1">

                  <div class="footer_header" >
                      <p style="text-align:center;"> <img src="/static/images/watersou.png" style="display:inline-block;width:70px"/></p>
                     
                  </div>
                </div>
                <div class="footer_footer"> 
                    <div  class="statDiv">
                         <p style="text-align:center;line-height:50px;">水销量</p>
                         <p class="num_c" id="agent_total">1000</p>
                    </div>
                    <div style="clear:both;"></div>
                   <div >
                       <p class="stat_label" id="agent_day_per">日 <i class="per_class"></i><span class="per_val">0%</span></p>
                       <p class="stat_label" id="agent_week_per">周 <i class="per_class"></i><span class="per_val">0%</span></p>
                       <p class="stat_label" id="agent_month_per">月 <i class="per_class"></i><span class="per_val">0%</span></p>
                   </div>
                    
                </div>
                  </div> <div style="clear:both;"></div>
            </div>


            <div id="footer_right" style='    margin-top: 20px;     padding-bottom: 20px; '>
                <div  class="footer_1">
                    <div class="footer_header" >
                        <p style="text-align:center;"> <img src="/static/images/custersou.png" style="display:inline-block;display:inline-block;width:70px"/></p>
                       
                    </div>
                </div>
                <div class="footer_footer">
                     <div  class="statDiv">
                        <p style="text-align:center;line-height:50px;">用户量</p>
                         <p class="num_c" id="user_total">1000</p>
                    </div>
                    
                    <div style="clear:both;"></div>
                   <div >
                    <p class="stat_label" id="user_day_per">日 <i class="per_class"></i><span class="per_val">0%</span></p>
                    <p class="stat_label" id="user_week_per">周 <i class="per_class"></i><span class="per_val">0%</span></p>
                    <p class="stat_label" id="user_month_per">月 <i class="per_class"></i><span class="per_val">0%</span></p>
                </div>
            </div>  <div style="clear:both;"></div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<!-- <script type="text/javascript" src="/static/js/coderlu.js"></script> -->
<script type="text/javascript" src="/static/js/common.js" ></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script> 
    <script>
     var totalData=<?=json_encode($totalData) ?>;
     var $UserInfo=<?=json_encode($UserInfo) ?>;
     var $saoma_data=<?=json_encode($saoma_data) ?>;
      console.log($saoma_data)
      // alert(JSON.stringify($saoma_data))
      sessionStorage.clear();
      sessionStorage.setItem("info", JSON.stringify($UserInfo));
    </script>
    <script type="text/javascript">
        $(function(){
            initpage();
            $(".grid_item").click(function(){
              var ImgUrl= $('img',this).attr('src').replace('before','colck');
            //  console.log(ImgUrl)
             $('img',this).attr('src',ImgUrl);
            })
        });
// 微信权限
  if($saoma_data){
       wx.config({
          debug: false,
          appId: $saoma_data.appId,
          timestamp:$saoma_data.timestamp,
          nonceStr:$saoma_data.nonceStr,
          signature: $saoma_data.signature,
          jsApiList: [ 'onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'getLocation', 'openLocation','scanQRCode'
         ,"chooseImage", "previewImage", "uploadImage", "downloadImage" ]
        });
  }
  // 是微信浏览器   
    function is_weixn(){  
      var ua = navigator.userAgent.toLowerCase();  
        if(ua.match(/MicroMessenger/i)=="micromessenger") {  
          return true;   
         }
        else {     
        return false;   
        }  
    }  

weixin_html()
function weixin_html(){
// 微信环境下
if( is_weixn()){
//定义一些常量
var x_PI = 3.14159265358979324 * 3000.0 / 180.0;
var PI = 3.1415926535897932384626;
var a = 6378245.0;
var ee = 0.00669342162296594323;
function gcj02tobd09(lng, lat) {
    var z = Math.sqrt(lng * lng + lat * lat) + 0.00002 * Math.sin(lat * x_PI);
    var theta = Math.atan2(lat, lng) + 0.000003 * Math.cos(lng * x_PI);
    var bd_lng = z * Math.cos(theta) + 0.0065;
    var bd_lat = z * Math.sin(theta) + 0.006;
    return [bd_lng, bd_lat]
}


        

  wx.ready(function () {
      wx.getLocation({
        type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
        success: function (res) {
               var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
              var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
              var speed = res.speed; // 速度，以米/每秒计
              var accuracy = res.accuracy; // 位置精度
              // console.log(latitude)
                // alert(longitude+0.09154+'=>'+latitud+0.003184)
                var ouer =gcj02tobd09(longitude,latitude)
                lat=ouer[1];
                lng=ouer[0];
        },
        cancel: function (res) {
        },
        fail: function (res) {
        
        }
      })
  })
}else{
  }
}
        // console.log($UserInfo)
            if($UserInfo.Name)  {
                $("#Name").text($UserInfo.Name)  
            }
             if($UserInfo.Level==5||$UserInfo.Level==8){
                    $(".level5").css("display","none")
                    $(".quipment").css({"display":"block"})
                    $(".user_ad").css({"display":"block"})
                    $(".quipment a").attr('href','/index.php/agent/dev-list');
                    $(".register a").attr('href','/index.php/agent/new-register')
                    $(".deliver_water a").attr('href','/index.php/agent/send-water')
                    $(".quipment span").text('设备列表');
                    $(".deliver_water").css("display","block");
             }
             if($UserInfo.Level==8){
                $(".register a").attr('href','javascript:void(0)')
                  $(".deliver_water").css("display","none");
                    var nextObj =  $(".quipment")
                    var prevObj =  $(".deliver_water")

                    var server_level5=  $(".level5");
                    var server_icon =  $(".server_icon");
                     exchangep(nextObj,prevObj);
                     exchangep(server_icon,server_level5);
                    $(".gridnamr").eq(2).hide();
                    $(".register").click(function(){
                     wx.ready(function() {
                        wx.scanQRCode({   
                            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                            scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                            success: function (res) {
                              var url = res.resultStr;
                              var inof = url.split("info=");
                               sessionStorage.setItem("CodeNumber", inof[1]);
                                  // alert(url +' &hotel=YES')
                                  window.open(url +' &hotel=YES');
                            },
                            cancel:function(res){
                            // alert('取消')
                            },
                            fail:function(){
                            // alert('调用失败')
                            }
                        });
                      });
                        wx.error(function(res){
                            // alert(res);
                            console.log(res)
                            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
                        });
                })

             }
             if($UserInfo.Level==6){
                    $(".hide").css("display","none");
                    $(".quipment").css({"display":"block"})
                    $(".deliver_water").css("display","none");
                    $(".register a").attr('href','/index.php/agent/ont-open');
                  //  $(".user_ad").css("borderTop","1px #f3f3f3 solid;")
             }
             console.log($UserInfo.Level)
              if($UserInfo.Level==4){
                    $(".deliver_water").css("display","none");
                       // $(".quipment").css({"display":"block"})
                    $(".register a").attr('href','/index.php/agent/ont-open')
			        var nextObj =  $(".user_ad")
              var prevObj =  $(".deliver_water")
              var quipment =  $(".quipment")
			        var server_icon =  $(".server_icon")
              exchangep(nextObj,prevObj)
			        exchangep(server_icon,quipment)
               $(".gridnamr").eq(2).css("display","none");
             }
        function exchangep(a,b){
            var n = a.next(), p = b.prev();
             a.insertAfter(b);
             b.insertBefore(a);                    
        };    



        function initpage(){
            var agent=totalData.result.watersale;
            var customer=totalData.result.customer;
            $("#agent_total").text(agent.total);
            $("#user_total").text(customer.total);
            var agent_day=getPercent(agent.curdaycnt,agent.prvdaycnt);
            var agent_week=getPercent(agent.curweekcnt,agent.prvweekcnt);
            var agent_month=getPercent(agent.curmonthcnt,agent.prvmonthcnt);
            var user_day=getPercent(customer.curdaycnt,customer.prvdaycnt);
            var user_week=getPercent(customer.curweekcnt,customer.prvweekcnt);
            var user_month=getPercent(customer.curmonthcnt,customer.prvmonthcnt);
            $("#agent_day_per .per_class").addClass(getPerClass(agent_day));
            $("#agent_day_per .per_val").text((agent_day<0?-agent_day:agent_day));

            $("#agent_week_per .per_class").addClass(getPerClass(agent_week));
            $("#agent_week_per .per_val").text((agent_day<0?-agent_week:agent_week));

            $("#agent_month_per .per_class").addClass(getPerClass(agent_month));
            $("#agent_month_per .per_val").text((agent_day<0?-agent_month:agent_month));

            $("#user_day_per .per_class").addClass(getPerClass(user_day));
            $("#user_day_per .per_val").text((user_day<0?-user_day:user_day));

            $("#user_week_per .per_class").addClass(getPerClass(user_week));
            $("#user_week_per .per_val").text((user_week<0?-user_week:user_week));

            $("#user_month_per .per_class").addClass(getPerClass(user_month));
            $("#user_month_per .per_val").text((user_month<0?-user_month:user_month));
        }
        function getPerClass(_val){
            return _val<0?"icon_drop":"icon_rise";
        }
        function getPercent(_cur,_pre){
            var dif=Number(_cur)-Number(_pre);
            return dif;
        }
var u = navigator.userAgent;var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
// alert('是否是Android：'+isAndroid)

if(isiOS){
window.addEventListener('pageshow', function(e) {
    // 通过persisted属性判断是否存在 BF Cache
    if (e.persisted) {
        location.reload();
    }
});
}


    </script>
</body>
</html>