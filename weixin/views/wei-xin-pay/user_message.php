<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=0.5,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8" />
  <title>付款扫码错误</title>
  <style type="text/css">
      .text{
        width: 150px;
        margin: auto;
        margin-top: 50%;
        text-align: center;
      }
      button {
        background-color: #E46045;
      }
      button:hover{
       background-color: #E24727
      }
  </style>
  <link rel="stylesheet" href="">

</head>
<body>
   <div class="text">
    <p> <?=$msg?></p>
  </div>
    <!-- <button type="submit" class="btn " id="submit"  onclick="WeixinJSBridge.call('closeWindow');" > 确定</button> -->
</body>
<script src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script>
 var mas =<?=json_encode($msg)?>;
// var  urlLost = localStorage.getItem('urlLost');
 //询问框
  layer.open({
    content: mas
    ,btn: ['确定']
    ,yes: function(index){

    	WeixinJSBridge.call('closeWindow');

    }
    
     
 
  });


</script>
</html>