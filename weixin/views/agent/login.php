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
    <link rel="stylesheet" href="/static/css/login.css?v=1.2"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>手机验证</title>
</head>
<style type="text/css">
   .submitBtn{
       background:#ddd;
      /*background: url(/static/images/canding.png) 100% 100% no-repeat ;;*/
   }
.login_input_item{
      margin-top: 10px;
    height: inherit;
}
.login_input{

    width: -webkit-calc(100% - 120px);
    width: -moz-calc(100% - 120px);
    width: calc(100% - 120px);
}
   .submitBtn{
    margin-top:20px;
   }
</style>
<body>
<div class="login_c" id="login_c">
    <div style="text-align: center;">
         <img src="/static/images/logo.png" alt="" width='100px'>
    <p style="font-size: 28px;font-weight: bold;    letter-spacing: 7px;    margin-top: 15px;">欢迎登陆</p>
    </div>
    
    <!-- 手机号码   -->
    <div class="login_input_item" style="margin-top:20px">
        <!-- <img src="/static/images/sm_phone.png"  /> -->
        <span class="login_icon fl" style="width:60px;margin-top:13px;margin-left:2px;display: inline-block;">账 号：</span>
        <input type="text" id="username" class="login_input fl" maxlength="11" placeholder="请填写登录账号"  v-model="username"/>
        <span class="login_icon fl" style="width:50px;margin-top:13px;margin-right:2px;display: inline-block;"><img src="/static/images/custer.png" style="margin-left: 10px;width:15px"></span>
    </div>
    <div class="clear"></div>
    <div class="divider_line"></div>
    <!-- 手机号码   -->
    <div class="login_input_item">
        <!-- <img src="/static/images/sm_msg.png" class="login_icon fl"  style="width:27px;margin-top:17px;" /> -->
         <span class="login_icon fl" style="width:60px;margin-top:13px;margin-left:2px;display: inline-block;">密 码：</span>
        <input type="password" id="password" class="login_input fl" maxlength="11" placeholder="请填写登录密码"  v-model="password"/>
        <span class="login_icon fl password" style="width:50px;margin-top:13px;margin-right:2px;display: inline-block;"><img src="/static/images/cock.png"  style="margin-left: 10px;width:15px"></span>
    </div>

    <div class="clear"></div>

    <div class="divider_line"></div>
    <!--提交登录-->
    <input type="button" value="验 证"  class="btn_blue submitBtn" v-on:click="submit()"/>
</div>


<script type="text/javascript" src="/static/js/vue.min.js"></script>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script type="text/javascript" src="/static/js/ctr_agent_login_page.js?v=1.5"></script>
<script type="text/javascript">
    $(function(){
        var clickTrue=true;
       $('.password').click(function(event) {
              if(clickTrue){
                 $("#password").parent().find("input").attr("type","text");
                 $('img',this).attr('src','/static/images/cock2.png')
                  clickTrue=false;
              }else{
                $("#password").parent().find("input").attr("type","password");
                $('img',this).attr('src','/static/images/cock.png')
                clickTrue=true;
              }
       });

Verification()
  function Verification(){
       var username_val =  $("#username").val();
       var password_val =  $("#password").val();
       if(username_val&&password_val){
          $(".submitBtn").css("background"," url(/static/images/canding.png) 100% 100% no-repeat ")
       }else{
        $(".submitBtn").css("background","#ddd")
       }   
  }


  $('input').bind('input porpertychange',function(){
       Verification()
  });




    })
</script>
</body>
</html>