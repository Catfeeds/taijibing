<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<button type="btn"  id='box'>测试</button>
</body>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script> 
<script>
var  data=  <?=json_encode($data)?>;
console.log(data)
var url = window.location.href.split('#')[0];
var encodeurl=url.replace(new RegExp("&","gm"),"@-");
  wx.config({
    debug: true,
    appId: data.appId,
    timestamp: data.timestamp,
    nonceStr: data.nonceStr,
    signature: data.signature,
    jsApiList: [
        'scanQRCode'//使用的JS接口
    ]
  });

console.log(encodeurl);
$("#box").click(function(event) {
	/* Act on the event */
   wx.ready(function() {
        wx.scanQRCode({   
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
                alert(4)
            }
        });
    });
   
    wx.error(function(res){
        // alert(res);
        console.log(res)
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
    });
});


</script>
</html>