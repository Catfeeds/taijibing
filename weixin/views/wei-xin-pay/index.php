<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>支付订单</title>
<!--		<link rel="stylesheet" type="text/css" href="css/common.css"/>-->
<!--		<link rel="stylesheet" type="text/css" href="css/pay.css"/>-->
<!--		<script src="js/jquery-1.11.1.js"></script>-->
<!--		<script src="js/rem.js"></script>-->
	</head>
	<body>
		<div id="pay">
			<div class="text1">
				<p class="text1_1">支付单号 <span></span></p>
				<p class="text1_2">支付金额 <span></span></p>
			</div>
<!--			<img src="img/ic_wallet_orange.png" class="img" alt="" />-->
		</div>
		<button class="submit">微信支付</button>

		<div class="img_text">
			<div class="img_text2">
<!--				<img src="img/ic_close_white.png" class="quit" alt="退出"/>-->
<!--					<img src="" class="img2" alt="二维码"/>-->

			</div>
		</div>

        <script src="/static/js/jquery.min.js"></script>
        <script type="text/javascript">

        /*支付*/
        //function pay(){
        //
        //	var pay = window.location.href.split("?pay=")[1].split("&sn=")[0];
        //	var sn = window.location.href.split("&sn=")[1];

        $(".text1_1 span").text(201805150001);
        $(".text1_2 span").text(1);

        //	return {sn,pay}
        //}
        //pay();

        $(".submit").on("click",function(){
alert(111);
//        var sn = pay().sn;
        var sn = 201805150001;
        var pay_money = 1;
        var crsf = '<?=$crsf?>';

        if($(".text1_1 span").text() !=="" && $(".text1_2 span").text() !==""){

        $.ajax({
        type:"post",
        url:"/index.php/wei-xin-pay/pay",
        data:{
        sn:sn,
        pay_money:pay_money,
        _csrf:crsf,
//        u_id:localStorage.getItem("uid"),
//        token:localStorage.getItem("token")
        },
        datatType:"json",
        error: function(data) {
                alert(data.message);
        },
        success:function(res){
                alert(res.message);return;
        //微信支付
        function onBridgeReady(){

        WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        {
        "appId":res.data.appid,     //公众号名称，由商户传入
        "timeStamp":res.data.timestamp,         //时间戳，自1970年以来的秒数
        "nonceStr":res.data.noncestr, //随机串
        "package":"prepay_id="+res.data.prepayid,
        "signType":res.data.sign_type,         //微信签名方式：
        "paySign":res.data.sign		//微信签名
        },
        function(Res){

        if(Res.err_msg == "get_brand_wcpay_request:ok" ) {

        img();

        }else if(Res.err_msg == "get_brand_wcpay_request:cancel"){

        alert("支付过程中用户取消");

        }else if(Res.err_msg == "get_brand_wcpay_request:fail"){

        alert("支付失败");

        }
        }
        );
        }
        if (typeof WeixinJSBridge == "undefined"){

        if( document.addEventListener ){

        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);


        }else if (document.attachEvent){


        document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
        }else{

        onBridgeReady();
        }

        }
        });
        }
        });

        function img(){

        $(".img_text").css("display","block");

        $.ajax({
        type:"post",
        url:"http://daka.hlhjapp.com/index.php/Home/Weixinpay/create_ticket2",
        data:{
        u_id:localStorage.getItem("uid"),
        token:localStorage.getItem("token")
        },
        dataType:"json",
        success:function(res){

        console.log(res);
        $(".img_text").css("display","block");
        $(".img2").attr("src",res.data);

        }
        });
        }
        $(".quit").on("click",function(){

        window.location.href="index2.html";
        });

        </script>

</html>


