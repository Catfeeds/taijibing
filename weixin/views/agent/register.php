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
    <link rel="stylesheet" type="text/css" href="/static/js/layer.mobile-v2.0/layer_mobile/need/layer.css">
    <link rel="stylesheet" href="/static/css/common.css" />
    <link rel="stylesheet" href="/css/weui.css" />
    <link rel="stylesheet" href="/css/weui2.css" />
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <link rel="stylesheet" href="/static/css/agent/register.css?v=1.1"/>
    <title>登记</title>
    <style type="text/css">
      #DeterminePOne, #DeterminePTwo {
		    width: 100%;
		    height: 40px;
		    background: #ddd;
		    margin-top: 40px;
		    text-align: center;
		    line-height: 40px;
		    font-size: 20px;
		    font-weight: bold;
		    color: #fff;
	  }
    #getCodeBtn{
     /*width:100px;height:30px; background: url(/static/images/brnW.png) 0% 0% / 100% 100% no-repeat;color:#fff;float: right;*/
     width:100px;height:30px;color:#fff;float: right;
     background:#ddd;
    }
    select, input{
      font-size: 13px;
    }
    </style>
</head>
<body>
<div class="register">
   <div class="nav">
       <p> 
            <span class='regNav ativer'>
                1.填写基本信息
                <img src="/static/images/you5.png" alt="">
            </span>
            <span class='regNav'>
               2.输入设备信息
                 <img src="/static/images/you5.png" alt="">
            </span>
            <span class='regNav'>
               3.完成登记
            </span>
        </p>
   </div>
   <div class="conter">
        <div id="view" style="width: 100%;">
         <ul id="viewUl" style="width:300%;margin-left:0%;">
             <li>
                <select id="usertype" class="view-list" name='usertype'>
                     <option value="">请选择购水套餐</option>
                </select>
                <select id="customertype" class="view-list" name='customertype'>
                     <option value="4">酒店</option>
                </select>
                <input type="text" name="" value=""  class="view-list" id="username" placeholder="请输入用户姓名"> 
                <input class="normal_input view-list" type="number" id="tel" placeholder="请输入手机号" style=" width: -webkit-calc(100% - 110px);width: -moz-calc(100% - 110px);width: calc(100% - 110px);">
                <input type="button" class="btn" style="" value="获取验证码" id="getCodeBtn"/>
                <input class="vcode_input view-list" type="number" id="vcode" placeholder="请输入验证码"/>
                <p style="clear:both;" id='DeterminePOne' style="background:#f3f3f3">下一步</p>
             </li>
           
              <p style="clear:both;"></p>
         </ul>
      <!-- <p style="clear:both;" id='DetermineP' style="background:#f3f3f3">下一步</p> -->
   </div>
   </div>
<input type="hidden" id="_csrf" value="<?php echo Yii::$app->request->csrfToken; ?>" name="_csrf" >
</div>
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=riGCh76icYkT3OXnxPnNEvB54F3ADvzB"></script> -->
<!-- <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script> -->
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script>
   var  datas=  <?=json_encode($datas)?>;
   // var  datas='';
   console.log(datas)
    $(function(){
      // 验证码,手机号码验证
    initGetVcodeBtn();
     initAddress()
    })


var info =  JSON.parse( sessionStorage.getItem("info"));
     if(info.Level==8){
      $("#customertype").val(4)
     }else{
       $("#customertype option").eq(4).remove()
     }

function initAddress(){
    var data1 =  JSON.parse( sessionStorage.getItem("data1"));
    // console.log(data1)
    for(var i=0 in data1){
      // console.log(i)
      $("#"+i).val(data1[i])
     }
     $("#tel").val('')
     $("#vcode").val('')
}
    // 判断邓丽后的状态
     if(datas.state==-1){
      layer.open({
          content: datas.mag
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
   var select =   JSON.parse(datas.info.select);

   // console.log(select.use_type)
       var ii = layer.open({type: 2});
      if(select.use_type){
        layer.close(ii)
        $("#usertype").empty();
        $("#usertype").append(' <option value="">请选择购水套餐</option>')
         for(var i=0;i<select.use_type.length;i++){
          var item =select.use_type[i];
          // console.log(item.code)
          if(item.code==1){
           var html =  '<option selected="selected" value="'+item.code+'">'+item.use_type+'</option>'
          }else{
            var html =  '<option value="'+item.code+'">'+item.use_type+'</option>'
          }
          $("#usertype").append(html)
         }
      }
     }else{
        // 购水套餐选择
      var ii = layer.open({type: 2});
      if(datas.use_type){
        layer.close(ii)
        $("#usertype").empty();
        $("#usertype").append(' <option value="">请选择购水套餐</option>')
        for(var i=0;i<datas.use_type.length;i++){
          var item = datas.use_type[i];
           // var html =  '<option value="'+item.code+'">'+item.use_type+'</option>'
        if(item.code==1){
           var html =  '<option selected="selected" value="'+item.code+'">'+item.use_type+'</option>'
          }else{
            var html =  '<option value="'+item.code+'">'+item.use_type+'</option>'
          }


          $("#usertype").append(html)
        }
      }else{
           layer.close(ii)
      }

}

$("#tel").bind('input porpertychange',function(){
    var _this = $(this).val().length;
    if(_this==11){
        $("#getCodeBtn").css("background",' url(/static/images/brnW.png) 0% 0% / 100% 100% no-repeat')
    }else{
      $("#getCodeBtn").css("background",'#ddd')
    }
});

// 验证码,手机号码验证
    function initGetVcodeBtn(){
        $("#getCodeBtn").on("click",function(){
            var tel=$("#tel").val();
            // alert(tel)
            if(!validateTel(tel)){
                $.alert("请输入格式正确的手机号码");
                return;
            }
           if(info.Level!=8){
                    $.get('/index.php/agent/check-tel?tel='+tel, function(data) {
                    /*optional stuff to do after success */
                     var data=  jQuery.parseJSON(data);
                         console.log(data)
                         if(data.state<0){
                           $.toast(data.msg);
                            return;
                           }
                      $.getJSON('/index.php/agent/get-vcode?tel='+tel,function(data){
                          if(data.state!=0){
                              $.alert(data.msg);
                              //console.log(data);
                              return;
                          }
                          $("#getCodeBtn").unbind();
                          $.toast("操作成功,验证码即将发送到您的手机!");
                          wait();

                      });
                   });
               }else{
                     $.getJSON('/index.php/agent/get-vcode?tel='+tel,function(data){  
                          if(data.state!=0){
                              $.alert(data.msg);
                              //console.log(data);
                            return;
                          }
                          $("#getCodeBtn").unbind();
                          $.toast("操作成功,验证码即将发送到您的手机!");
                          wait();

                      });
               }
        });
    }

    
   function wait(){
        maxtime=60;
        $("#getCodeBtn").val(maxtime+"s");
        delTime();
       
    }


    function delTime(){
        maxtime--;
        if(maxtime<=0){
            $("#getCodeBtn").val("获取验证码");
            $("#getCodeBtn").css("background",' url(/static/images/brnW.png) 0% 0% / 100% 100% no-repeat')
            initGetVcodeBtn();
            return;
        }
        $("#getCodeBtn").css("background",'#ddd')
        
        $("#getCodeBtn").val(maxtime+"s");
          setTimeout(delTime,1000);
    }


// 首次下一步验证
function Verification1(){
      var    usertype=$("#usertype").val()||"";
      var    customertype=$("#customertype").val()||"";
      var    username=$("#username").val()||"";
      var    tel=$("#tel").val()||"";
      var    vcode=$("#vcode").val()||"";
   if(!usertype){
          layer.open({
          content: '请选择购水套餐'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return;
   }
  if(!customertype){
          layer.open({
          content: '请选择客户类型'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      return;
   } 
if(!username){
          layer.open({
          content: '请输入用户姓名'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      return;
   }
    if(!validateTel(tel)){

              
          layer.open({
          content: '请输入格式正确的手机号码'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      return;
   }
     if(!vcode){
          layer.open({
          content: '请输入验证码'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      return;
   }
  var obj = {
      usertype:$("#usertype").val()||"",
      customertype:$("#customertype").val()||"",
      username:$("#username").val()||"",
      tel:$("#tel").val()||"",
      vcode:$("#vcode").val()||""
    }
      return obj;
}
  $('input,select').bind('input porpertychange',function(){
       var index = $("#viewUl li:nth-child(1) .view-list").length;
         for(var i=0;i<index;i++){
            if( !$("#viewUl li:nth-child(1) .view-list").eq(i).val()){
               $("#DeterminePOne").css("background",'#ddd');
               return;
            }
          $("#DeterminePOne").css({"background":" url(/static/images/brnW.png) no-repeat",'background-size':' 100% 100%'});
        }
  });
$("#DeterminePOne").click(function(){
   var obj =   Verification1(); 
    console.log(obj)
    var tel=$("#tel").val();
    var check_tel=0;
     if(info.Level!=8){
            $.ajax({
                 cache: false,
                 async: false,
                 type: 'get',
                 data: { tel: tel},
                 url:'/index.php/agent/check-tel',
                 success: function (data) {
                  var data=  jQuery.parseJSON(data);
                  console.log(data)
                    if(data.state<0){
                     $.toast(data.msg);
                      return false;
                      }else{
                        check_tel=1;
                      }
                  }
             });
             console.log(check_tel)
      }else{
          check_tel=1;
      }
    if(obj&&check_tel){
// http://test.wx.taijibing.cn/index.php/agent/check-vcode?usertype=38&customertype=3&username=2222&tel=13693440306&vcode=7700       
     $.get('check-vcode?tel='+obj.tel+'&vcode='+obj.vcode, function(data) {
          var data = jQuery.parseJSON(data)
             console.log(data)
          var objData = JSON.stringify(obj)
           console.log(objData)
           if(data.state==-1){
            // console.log()
                   $.toast("验证码错误");
                   $("#DeterminePOne").css("background",'#ddd');
                   return;
           }
            sessionStorage.setItem("data1", objData);
           location.href='register-dev-info?user_base=52';       
    });      
  }
})
</script>
<!-- <script type="text/javascript" src="/static/js/agent/register.js" ></script> -->
</body>
</html>