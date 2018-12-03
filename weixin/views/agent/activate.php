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
    <link rel="stylesheet" href="/static/css/agile.layout.css"/>
    <link rel="stylesheet" href="/static/css/seedsui.min.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>饮水机激活</title>
    <style>
    body{
      /*background:#313f4c;*/
    }
      .code_bg{
      text-align: center;
      margin-top:20px;
      background:white;
      margin-left:20px;
      margin-right:20px;
      /* height:280px;
      background:url("/static/images/code_bg.png");*/
      background-repeat:no-repeat;
      background-position: center;
      background-size: 100% 280px;

      /*margin-top:30px;*/
      /*padding-top:10px;*/
      }
      #code{
      padding:20px;    border-bottom: 4px solid #f3f3f3;
      }
      .header{
      padding-bottom: 25px;

      }
      .header p{
      border-left: 8px solid #E46045;    text-indent: 10px;    font-size: 20px;
      font-weight: bold;
      }
      .name{
      font-size: 15px;font-weight: bold;

      }
      #code>p{
      float: left;    padding-right: 20px;
      }
      .bgt{
      width: 200px; height:50px;line-height:50px;text-align: center;    margin: auto;
      margin-top: 20px;
      background: url(/static/images/brnW.png) no-repeat;
      background-size: 100% 100%;
      }
      .progress-bg{
      width: 90%;
      height: 5px;
      background:#f3f3f3 url(/static/images/brnW.png) no-repeat;
         background-size: 0% 100%;
      margin: auto;
      margin-top: 30px;
      border-radius: 11px;
      position: relative;    margin-bottom: 50px;
      }
      .bton{
      width:80%;margin:auto;    margin-top: 20px;
      }
      .bton p{
      float: left;
      padding: 5px 15px;
      background: #0394F9;
      color: #fff;
      border-radius: 4px;
      }
    </style>
</head>
<body>
    <div id="code">
         <div class="header">
              <p>登记配置</p>
        </div> 

        <p><span class='name'>设备品牌：<span id="BrandName" style="color:#999"></span></span></p>
        <p><span  class='name'>商品型号：<span id="GoodsName" style="color:#999"></span></span></p>
        <div style="clear:both "> </div>
</div>
   <div>
         <p class="bgt">请在机器上扫码激活</p>
   </div>
    <p class="code_bg"> <img id="barcode"/></p>
     <div style="   position: relative;padding:0 15px;">
        <p class="progress-bg"></p>
        <p style="float:left   ; color: #FF662E;"><span class='Time'>0</span>秒激活中</p>
        <p style="float:right;"><span  class='name'>若超过<span style=" color: #FF662E;"> 120s</span>未激活，请重新扫码</p>
        <div style="clear:both "> </div>
     </div>
   <div class="bton" style="">
      <p class="Continue" style="float:left">继续登记</p>
       <a href="index"  style="float: right;"><p style="  background: url(/static/images/brnW.png) no-repeat;
    background-size: 100% 100%;">完成登记</p></a>

    <div style="clear:both;padding-bottom: 50px;"></div>
   </div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
 <script type="text/javascript" src="/static/js/zepto.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>
 <script type="text/javascript" src="/static/js/coderlu.js"></script>
 <script type="text/javascript" src="/static/js/common.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script> 
<script>
    var vcode='';
    var BrandName='';
    var GoodsName='';
    var $saoma_data= <?=json_encode($saoma_data) ?>;

console.log($saoma_data.appid)

         if($saoma_data){
             wx.config({
                debug: false,
                appId: $saoma_data.appId,
                timestamp:$saoma_data.timestamp,
                nonceStr:$saoma_data.nonceStr,
                signature: $saoma_data.signature,
                jsApiList: [
                    'scanQRCode'//使用的JS接口
                ]
              });
       }

  $(function(){
    vcode= getQueryString("code");
    BrandName= decodeURI(getQueryString("BrandName"));

    GoodsName=decodeURI( getQueryString("GoodsName"));

    var brandNameId = document.getElementById('BrandName');
    var GoodsNameId = document.getElementById('GoodsName');
    $("#BrandName").text(BrandName);
     $("#GoodsName").text(GoodsName);
    if(vcode==null){
        $.alert("无效链接",function(){
           window.history.go(-1);
        });
    };
    var barcode = document.getElementById('barcode'),
        str = "12345678",
        options = {
            format:"CODE128",
            displayValue:true,
            fontSize:18,
            height:100
        };
      JsBarcode(barcode, vcode, options);//原生
     var  num =1;
     var numbt = 0.833;
      var timer1=    setInterval(getLoc,1000);
        function getLoc(){
            //var timer1=window.setTimeout(function(){},1000);  //timer1->1 当前是第一个定时器
            if(num>120){
                num=120;
                window.clearTimeout(timer1);
            }
            $(".Time").text(num);
            $(".progress-bg").css("backgroundSize",""+numbt+"% 100%;");
            num++
            numbt=numbt+ 0.833
        }
var info =  JSON.parse( sessionStorage.getItem("info"));
 $(".Continue").click(function(){
    if(info.Level==8){
        wx.ready(function() {
        wx.scanQRCode({   
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
              var url = res.resultStr;
              var inof = url.split("info=");
               // alert(inof[1])
               sessionStorage.setItem("CodeNumber", inof[1]);
               window.open(url +' &hotel=YES&DevNo='+vcode);
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
         // location.href='index';
    }else{
        location.href='register?DevNo='+vcode
    }
 })


});


</script>
</body>

</html>
