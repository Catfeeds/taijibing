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
    <link rel="stylesheet" href="/static/css/login.css?v=1.1"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>手机验证</title>
    <style type="text/css">
        .login_input{
            width: -webkit-calc(100% - 170px);
            width: -moz-calc(100% - 170px);
            width: calc(100% - 170px);
        }
        .btn_blue{
        background-color: #ddd
        }
        .login_input_item_right{
            height: 30px;    margin-top: 10px;
        }
        .layui-m-layercont{
            padding: 0 !important;;
        }
        .btn{
            padding:10px 25px;
            color: #040404;
            font-weight: bold;
        }
        .ativer{
        background: -moz-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -webkit-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -webkit-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -o-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -ms-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background:linear-gradient(left, #ff8a20 0%, #ff5e20 100%);;padding:10px 25px;color:#fff
        }
    </style>
</head>
<body>
<div class="login_c" id="login_c">
        <div style="text-align: center;">
         <img src="/static/images/logo.png" alt="" width='100px'>
        <p style="font-size: 28px;font-weight: bold;    letter-spacing: 7px;    margin-top: 15px;">欢迎登陆</p>
        </div>
    <!-- 手机号码   -->
    <div class="login_input_item" style='margin-top: 30px;'>
        <!-- <img src="/static/images/sm_phone.png" class="login_icon fl" style="width:18px;margin-top:9px;margin-left:2px;" /> -->
             <span class="login_icon fl" style="width:70px;margin-top:13px;margin-left:2px;display: inline-block;">手机号：</span>
        <input type="tel" id="phoneNum" class="login_input fl" v-on:input="getChange()" maxlength="11" placeholder="请填写手机号码"  v-model="mobile"/>
         <input type="button" v-model="getValidateBtnLabel"  class="login_input_item_right btn_blue" v-on:click="getValidateCode()">
    </div>
    <div class="clear"></div>
    <div class="divider_line"></div>
    <!-- 手机号码   -->
    <div class="login_input_item" style="margin-top: 25px;width: 100%;">
        <!---->
        <div class="login_input_item_left" style="width: 100%;">
            <!-- <img src="/static/images/sm_msg.png" class="login_icon fl" style="width:27px;margin-top:17px;" /> -->
            <span class="login_icon fl" style="width:70px;margin-top:13px;margin-left:2px;display: inline-block;">验证码：</span>
            <input type="tel" class="login_input_code fl" maxlength="4"  v-on:input="getVcodeChange()" id="randomCode" placeholder="请填写短信验证码" v-model="vcode"/>
        </div>
    </div>
    <div class="clear"></div>
    <div class="divider_line"></div>
    <!--提交登录-->
    <input type="button" value="验 证" class="btn_blue submitBtn" v-on:click="submit()"/>
</div>
<script>
    var mobile='<<$mobile>>';
</script>
<script type="text/javascript" src="/static/js/vue.min.js"></script>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>

<script type="text/javascript" src="/static/js/ctr_login_page.js?v=2.8"></script>
</body>

<script type="text/javascript">
// layer.open({
//     title: [
//       '<div style="width:80%;height:60px;margin:auto;background: url(/static/images/bftitle.png) 100% 100% no-repeat;     background-position: center;background-size: 100% 40px;">免费赠机</div>',


//       'color:#fe7b00;font-weight: bold;background: -moz-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -webkit-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -webkit-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -o-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background: -ms-linear-gradient(left, #ff8a20 0%, #ff5e20 100%);background:linear-gradient(left, #ff8a20 0%, #ff5e20 100%);'
//     ]
//     ,content:   '<div style="padding:30px 35px;font-weight: bold;"><img src="/static/images/bgliwu.png" alt="" style="width:140px;">'+
//                 '<p style="margin-top: 20px ;color:#313131">你还未登记!</p>'+
//                 '<p style="margin-top: 10px ;color:#313131">快去免费领取一台智能茶吧机吧！</p>'+
//                 '</div>'+
//                 '<a href="https://e.eqxiu.com/s/IY2MCPqM"><p class="btn ativer"  >马上去</p></a>' +
//                 '<a href="http://test.wx.taijibing.cn/index.php/water-shop/index"><p class="btn">去商城逛逛</p></a>'
//      });

//          $(".btn").click(function(){
//             $(this).css({'background':'#fdf6f6','color':'#fe7200','border-top':'1px solid #f3f3f3','border-bottom':'1px solid #f3f3f3'})
//             $(".ativer").removeClass('ativer')
//             $(this).addClass('ativer')
//           })
</script>
</html>


