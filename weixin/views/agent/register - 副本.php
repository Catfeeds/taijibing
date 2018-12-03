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
    <link rel="stylesheet" href="/css/weui.css" />
    <link rel="stylesheet" href="/css/weui2.css" />
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>登记</title>
    <style>
        .wrap_line{
            height:46px;
            width:100%;
            border-bottom:1px solid #f3f3f3;
            position:relative;
        }
        input{
            border:0px;
            font-size:13px;
        }
        .wrap_line label{
            display:inline-block;
            width:80px;
            height:46px;
            line-height:46px;
            padding-left:10px;
            font-size:14px;
        }
        .wrap_line .normal_input{
            display:inline-block;
            height:44px;
            position:absolute;
            left:90px;
            right:0px;
        }
        .wrap_line .vcode_input{
            display:inline-block;
            height:44px;
            position:absolute;
            left:90px;
            right:0px;
        }
         #devfactory  ,#devfact{
            display:inline-block;
            position:absolute;
            left:90px;
            right:10px;
            margin-top:10px;
        }
        .btn{

            background:#34a0f8;border-radius: 4px;color:white;
        }
		#devfact{
		width:30%;
		}
		#devfa {
		position: absolute;
		width: 30%;
		top: 38px;
		left: 90px;
		}
    </style>
</head>
<body>
<div class="form">
    <div class="wrap_line">
        <label for="username">姓名</label><input class="normal_input" type="text" id="username" placeholder="请输入用户名"/>
    </div>
    <div class="wrap_line">
        <label for="tel">联系电话</label><input class="normal_input" type="text" id="tel" placeholder="请输入手机号"/>
    </div>
    <div class="wrap_line">
        <label for="vcode">验证码</label><input class="vcode_input" type="text" id="vcode" placeholder="请输入验证码"  style="right:160px;"/>
        <input type="button" class="btn" style="position:absolute;top:8px;right:20px;width:80px;height:30px;" value="获取验证码" id="getCodeBtn"/>
    </div>
    <div class="wrap_line">
        <label for="address">地址</label><input class="normal_input" type="text" id="address" placeholder="请输入地址"/>
    </div>
    <div class="wrap_line">
        <label for="devicetel">设备ICCID</label><input class="normal_input" type="text" id="devicetel" placeholder="请输入设备ICCID"/>
    </div>
    <div class="wrap_line">
        <label for="name">入网属性</label>
        <select  id="usertype">
           <option value="1">0元押金</option>
            <option value="2">99元押金</option>
            <option value="3">880元自购</option>
        </select>
    </div>
    <div class="wrap_line">
        <label for="name">客户类型</label>
        <select  id="customertype">
            <option value="1">家庭</option>
            <option value="2">办公</option>
            <option value="3">集团</option>
            <option value="99">其他</option>
        </select>
    </div>
    <div class="wrap_line">
        <label for="name">所在地区</label>
        <select id="province">
            <option value="" selected>请选择</option>
        </select>
        <select id="city">
            <option value="">请选择</option>
        </select>
        <select id="area">
            <option value="">请选择</option>
        </select>
    </div>
<!--     <div class="wrap_line" style="display: none;">
        <label for="name">成都设备厂</label>
        <select  id="devfactory">

        </select>
    </div> -->
    <div class="wrap_line" style="height:80px">
        <label for="name">设备型号</label>
            <select  id="devfact">
                <option value="" >请选择品牌</option>
            </select>
            <select  id="devfa">
                <option value="">请选择型号</option>
            </select>

    </div>
    <p>
        <input type="button" class="btn submit" style="font-size:16px;margin-top:40px;display:inline-block;width:80%;margin-left:10%;height:45px;line-height:45px;text-align:center;" value="下一步"/>
    </p>

</div>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script>

// function unique($data) {
//   var res = [];
//   var json = {};

//   for (var p = 0; p < $data.length; p++) {
//     if (!json[$data[p]]) {
//       res.push($data[p]);
//       json[$data[p]] = 1;
//     } else {}
//   }
//   return res;
// };




//     var maxtime=0;

//         var info = localStorage.getItem('userInfo');
//         var infoi = JSON.parse(info);
//         console.log(infoi);
//         if(infoi.result.level==5){
//         $(".devicetel label").text("ICCID")
//         $("#devicetel").attr('placeholder','请输入ICCID')
//         }
//         if(infoi.result.level==4){
//         $('body').html('<div style="width:200px;height: 400px;margin: auto;margin-top:50%;text-align: center;font-size: 25px"> 哎呀！此功能暂未开放!!去别处看看吧!!! <a href="javascript:history.go(-1)"><p stylr="color:#fff">返回</p></a></div>')
//         }
//   
//       console.log(bdata)
//       var brandidName=[];
//       var brandNameID=[];
//        for(var i=0;i<bdata.length;i++){
//              brandidName.push(bdata[i].brandid)
//              brandNameID.push(bdata[i].brandname)
//                   //      $("#devfact").append('<option value='+bdata[i].brandid +'>'+bdata[i].brandname+'</option>')   
//        }
//    var brandidName = unique(brandidName)
//    var brandNameID = unique(brandNameID)
//        console.log(brandidName.length)
//  for(var y=0;y<brandidName.length;y++){
//          $("#devfact").append('<option value='+brandidName[y] +'>'+brandNameID[y] +'</option>')   
//  }
// $('#devfact').change(function() { 
//         // var myselect=document.getElementById("devfact");
//         // var index=myselect.selectedIndex ;
//          // alert($(this).val())
//          var devfactVal = $(this).val();
//      for(var i=0;i<bdata.length;i++){
//          if(bdata[i].brandid==devfactVal){
//                // alert(1)
//                 $("#devfa").append('<option value='+bdata[i].goodsid+'>'+bdata[i].goodsname+'</option>')
//          }
//         }
//         //

// });  




//     $(function(){
//         initGetVcodeBtn();
//         $(".submit").on("click",function(){
//             submit();
//         });
//         initProvince();
//         initListener();
//         initAddress();
//     });
//     function initAddress(){
//         $("#province").val(province);
//         initCityOnProvinceChange();
//         $("#city").val(city);
//         initThree();
//         $("#area").val(area);
//     }
//     function getAddressIdByName(_name){
//         _name= $.trim(_name);
//         if(_name==""){
//             return 0;
//         }
//         for(var index=0;index<adata.length;index++){
//             var item=adata[index];
//             var name= $.trim(item.name);
//             if(name!=""&&name==_name){
//                 return item.id;
//             }
//         }
//         return 0;
//     }
//     function initListener(){
//         $("#province").on("change",function(){
//             initCityOnProvinceChange();
//         });
//         $("#city").on("change",function(){
//             initThree();
//         });
//     }
//     function initCityOnProvinceChange(){
//         var pid=getAddressIdByName($("#province").val());
//         $("#city").empty();
//         $("#city").append("<option value='' selected>请选择</option>");
//         if(pid==0){
//             return;
//         }
//         for(var index=0;index<adata.length;index++){
//             var item=adata[index];
//             if(item.pid!=0&&item.pid==pid){
//                 $("#city").append("<option value='"+item.name+"'>"+item.name+"</option>");
//                 initThree()
//             }
//         }
//     }
//     function initThree(){
//         var pid=getAddressIdByName($("#city").val());
//         $("#area").empty();
//         $("#area").append("<option value='' selected>请选择</option>");
//         if(pid==0){
//             return;
//         }
//         for(var index=0;index<adata.length;index++){
//             var item=adata[index];
//             if(item.pid!=0&&item.pid==pid){
//                 $("#area").append("<option value='"+item.name+"'>"+item.name+"</option>");
//             }
//         }
//     }
//     function initProvince(){
//         for(var index=0;index<adata.length;index++){
//             var item=adata[index];
//             if(item.pid==0){
//                 $("#province").append("<option value='"+item.name+"'>"+item.name+"</option>");
//             }
//         }
//     }
//     function submit(){
//         var username=$("#username").val();
//         var tel=$("#tel").val();
//         var vcode=$("#vcode").val();
//         var address=$("#address").val();
//         var devicetel=$("#devicetel").val();
//         var Province=$("#province").val();
//         var City=$("#city").val();
//         var area=$("#area").val();
//         var UseType=$("#usertype").val();
//         var customertype=$("#customertype").val();
//         var devfact =  $("#devfact").val()
//          var devfa =  $("#devfa").val()
//         if(!validateTel(tel)){
//             $.alert("用户手机号填写错误");
//             return;
//         }
//         if($.trim(devicetel)==""){
//             $.alert("设备手机号不能为空");
//             return;
//         }
//         if($.trim(Province)==""){
//             $.alert("所在地区不能为空");
//             return;
//         }
//         if($.trim(City)==""){
//             $.alert("请填写完整的所在地区");
//             return;
//         }
//        if($.trim(area)==""){
//             $.alert("请填写完整的所在地区");
//             return;
//         }
//         if($.trim(username)==""){
//             $.alert("用户名不能为空!");
//             return;
//         }
//         if($.trim(vcode)==""){
//             $.alert("验证码不能为空!");
//             return;
//         }
//         if($.trim(address)==""){
//             $.alert("地址不能为空!");
//             return;
//         }
//         if($.trim(devfa)==""){
//             $.alert("设备型号不能为空!");
//             return;
//         }
//         if($.trim(devfact)==""){
//             $.alert("设备品牌不能为空!");
//             return;
//         }
//         // var devfactoryIndex=$("#devfactory").val();
//         // var devfactory=data[Number(devfactoryIndex)].name;
//         // var Fid=data[Number(devfactoryIndex)].id;
//         var params={
//             "Name":username,
//             "Vcode":vcode,
//             "Tel":tel,
//             "Address":address,
//             "DevBindMobile":devicetel,
//             // "DevFactory":devfactory,
//             // "Fid":Fid,
//             "Province":Province,
//             "City":City,
//             "area":area,
//             "UseType":UseType,
//             "customertype":customertype,
//             "brandid":devfact,
//             "goodsid":devfa
//         }

//         $.showIndicator();
//         $.getJSON("/index.php/agent/user-register?"+ $.param(params),function(data){
//             $.hideIndicator();
//             if(data.state!=0){
//                 $.alert(data.msg);
//                 return;
//             }

//             window.location.href="/index.php/agent/activate?code="+data.result.devNo;
//         });
//     }
//     function initGetVcodeBtn(){
//         $("#getCodeBtn").on("click",function(){
//             var tel=$("#tel").val();
//             if(!validateTel(tel)){
//                 $.alert("请输入格式正确的手机号码");
//                 return;
//             }
//             $.getJSON('/index.php/agent/get-vcode?tel='+tel,function(data){
//                 if(data.state!=0){
//                     $.alert(data.msg);
//                   console.log(data)
//                     return;
//                 }
//                 $("#getCodeBtn").unbind();
//                 $.toast("操作成功,验证码即将发送到您的手机!");
//                 wait();
//             });
//         });
//     }
//     function wait(){
//         maxtime=20;
//         $("#getCodeBtn").val(maxtime+"s");
//         delTime();
//     }
//     function delTime(){
//         maxtime--;
//         if(maxtime<0){
//             $("#getCodeBtn").val("获取验证码");
//             initGetVcodeBtn();
//             return;
//         }
//         $("#getCodeBtn").val(maxtime+"s");
//         setTimeout(delTime,1000);
//     }

</script>
</body>
</html>