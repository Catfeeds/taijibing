<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>太极兵智能饮水机</title>

	<link rel="stylesheet" href="">
	<style type="text/css" media="screen">
    *{
        padding: 0;margin: 0;
    }
	  .capacity{
      float: left;
    width: 25%;
    height: 30px;
    /* margin-left: 20px; */
    text-align: center;

    line-height: 30px;
   
    /*color: #ff0707;*/
    position: relative;
	  }

      .dvCBs{
        margin: auto;
        width: 50px;
        position: relative;
        border: 1px solid #d0c5c5;
        box-sizing: border-box;
        /*color:#d0c5c5;*/
      }

p{
	   font-size: 14px;	
       line-height: 25px;
}
.remarks {
    padding:20px;
}
.remarks p{
    	font-size: 12px;
    	/*color: #999*/
}
.remarks .ativer{
	   color: #ff0707;	
}
/*.remarks p span{
    	font-size: 14px;
    	color: #ff0707;	
}*/


.substr{
    	clear: both;
        padding: 5px 10px;
        border-radius: 4px;
        color: #fff;
    	background: -webkit-linear-gradient(right,#FF5E20,#ff8a20);
        background: -o-linear-gradient(right,#FF5E20,#ff8a20);
        background: -moz-linear-gradient(right,#FF5E20,#ff8a20);
        background: -mos-linear-gradient(right,#FF5E20,#ff8a20);
        background: linear-gradient(right,#FF5E20,#ff8a20);
        text-align: center;
}



.capacity .ativer{
    border:none;
    color: #ff0707;
    background: url(/static/images/check--two.png) 100% 100% no-repeat;
    background-size: 100% 100%;
}
</style>
</head>
<body>
	<div class="text">
        <div style="height: 200px;width:100%;    background: url(/static/images/backgroundt.png) 100% 100% no-repeat;padding:20px; box-sizing: border-box;        background-size: 100% 100%;">
             <div style="width:150px;height: 100px; text-align:center; margin-top:30px;   float: left;">
                       <img src="/static/images/xiongmao.png" alt="" height="100%">
             </div>
            <div style="height:100px;margin-top:40px;color:#fff;;width:-webkit-calc(100%-150px);width:-moz-calc(100%-150px);width:calc(100%-150px);"> 
                <p style="font-size:18px;font-weight:bold" >太极兵-健康饮水的守卫兵</p>
                <p>购买前请仔细阅读注释，帮助您选择合适的用水量</p>
            </div>
        </div>
	       <p style='    padding: 20px;
    font-size: 18px;font-weight: bold;'>请选择饮水容量：</p>
	     <div  class="choice" style='padding: 20px 0; box-shadow: 0 0 7px #e2dcdc;'>
	    	<div class="capacity">
              <div class="dvCBs">
                <p data='2'><span>1</span>L</p>
              <!--    <input type="radio" name="state" value="1"  id="state1" class='state' / >1L
    			 <label for="state1"></label> -->
    		 </div> 
	    	</div>
	    	<div class="capacity">
	    	<div class="dvCBs ativer">
            <p data='3'><span>2</span>L</p>
            <!-- 
             <input type="radio" checked  name="state" value="2"  id="state2" class='state' / >2L
             <label for="state2"></label> -->
    		 </div> 
    		 </div>
	    	<div class="capacity">
	    	  <div class="dvCBs"  >
                 <p data='6'><span>5</span>L</p>
             <!--<input type="radio" name="state" value="5"  id="state3" class='state' / >5L
    			 <label for="state3"></label> -->
    		 </div> 
    		 </div>
	    	<div class="capacity">
	    	  <div class="dvCBs"  >
                    <p data='0.1'><span>0.5</span>L</p>
                <!--  <input type="radio" name="state" value="7.5"  id="state4" class='state' / >7.5L
    			 <label for="state4"></label> -->
    		 </div> 
    		 </div>
          <div style='clear:both'></div>
	    </div>
             <div style='padding: 20px;'>
                <!-- <p style="float: left">合计：</p> -->
                <p style="float: right"> <span>合计：</span><span style="color: #ff0707;" id="rmb">3.00 </span>元</p>
                    <div style='clear:both'></div>         
             </div>
 <div style='padding: 0px 20px;'>
     <p class='substr' style='clear:both;color: #fff'>立即支付</p>  
 </div>
             <div style='clear:both' class='remarks'>
                
               <span style="font-weight: bold"> 注：</span>
                 <p> <span>1L：</span>价格2元，容量约等于两瓶普通矿泉水，适合1-2人饮用。</p>
                 <p > <span>2L：</span>价格3元，容量约等于四瓶普通矿泉水，适合2-3人饮用。</p>
                 <p> <span>5L：</span>价格6元，容量约等于十瓶普通矿泉水，适合3-4人饮用。</p>
                 <p> <span>7.5：</span>价格10元，换整袋新的一次性袋装水。</p>
             </div>
	</div>	
</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall(data)
        {
            var jsApiParameters = jQuery.parseJSON(data.jsApiParameters)
            console.log(data)
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                jsApiParameters,
                function(res){

            WeixinJSBridge.log(res.err_msg);

               if(res.err_msg=='get_brand_wcpay_request:ok'){
                     window.location.href='https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzU1OTU2NDcyNw==&scene=123#wechat_redirect';
               }else{
                   alert('支付失败')
               }
                    
                    // alert(res.err_code+res.err_desc+res.err_msg);
                     
                }
            );
        }


    function callpay(data)
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall(data);
        }
    }
    </script>
    <script type="text/javascript">
    //获取共享地址
    function editAddress(data)
    {
    
        WeixinJSBridge.invoke(
            'editAddress',
            data.editAddress,
            function(res){
                var value1 = res.proviceFirstStageName;
                var value2 = res.addressCitySecondStageName;
                var value3 = res.addressCountiesThirdStageName;
                var value4 = res.addressDetailInfo;
                var tel = res.telNumber;
                // alert(value1 + value2 + value3 + value4 + ":" + tel);
                  // window.location.href='https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzU1OTU2NDcyNw==&scene=124#wechat_redirect'
                // 
            }
        );
    }
    </script>
<script>
    var CodeNumber=<?=json_encode($CodeNumber) ?>;
    var DevNo=<?=json_encode($DevNo) ?>;

$(".dvCBs").click(function(){
    $(".ativer").removeClass('ativer');
    $(this).addClass('ativer');
    var rmb = $('p',this).attr('data')
    $("#rmb").html(rmb)
})

     $('.choice input').click(function(){
        var Index = $(this).attr('id')
        var stateIndex = Index.split("state");
        $(".ativer").removeClass('ativer')

        $(".remarks p").eq(stateIndex[1]*1-1).addClass('ativer');
        var rmb = '2.00';
            // alert(stateIndex[1])
        if(stateIndex[1]==1){
            rmb = '2.00 ';
        }
        else if(stateIndex[1]==2){
            rmb = '3.00';
        }
        else if(stateIndex[1]==3){
            rmb = '6.00 ';
        }
        else if(stateIndex[1]==4){
            rmb = '10.00';
        }
        $("#rmb").html(rmb)
     })

    $(".substr").click(function(){
       var checkedVal =  $('.capacity .ativer p span').text();
         var obj ={
            volume:checkedVal,
            CodeNumber:CodeNumber,
            DevNo:DevNo,
            price:$("#rmb").text()*1,
           }
        // callpay()

        console.log(obj)
     
//http://test.wx.taijibing.cn/index.php/wei-xin-pay/buy-water?info=TCL0102J01804000111
           $.get('http://wx.taijibing.cn/index.php/wei-xin-pay/pay-money', obj, function(data) {
               /*optional stuff to do after success */
               // alert(data);
                    var data =jQuery.parseJSON(data)
                     console.log(data)
                       if(data.state==0){
                            console.log(data);
                            callpay(data)
                            window.onload = function(data){
                                if (typeof WeixinJSBridge == "undefined"){
                                    if( document.addEventListener ){
                                        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
                                    }else if (document.attachEvent){
                                        document.attachEvent('WeixinJSBridgeReady', editAddress); 
                                        document.attachEvent('onWeixinJSBridgeReady', editAddress);
                                    }
                                }else{
                                    editAddress(data);

                                }
                            };
                       }else{
                            alert(data.msg);
                       }
           });
        });

</script>

</html>