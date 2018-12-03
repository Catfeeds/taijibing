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
width:100px;height:30px; background: url(/static/images/brnW.png) 0% 0% / 100% 100% no-repeat;color:#fff;float: right;
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
            <span class='regNav'>
                1.填写基本信息
                <img src="/static/images/you5.png" alt="">
            </span>
            <span class='regNav ativer'>
               2.输入设备信息
                 <img src="/static/images/you5.png" alt="">
            </span>
            <span class='regNav'>
               3.创建电子水票
            </span>
        </p>
   </div>
   <div class="conter">
        <div id="view" style="width: 100%;">
         <ul id="viewUl" style="width:300%;margin-left:0%;">
                 <li>
                    <select id="devfact"   class="view-list"  name='water_brand'>
                    <option value="">请选择设备品牌</option>
                    </select>  
                    <select id="devfa"   class="view-list"  name='water_brand'>
                    <option value="">请选择设备型号</option>
                    </select>
                    <!-- <div class='address' style="width: 100%;height: 30px;background: #fff;    margin-top: 20px;"> -->
                        <select id="province"   class="view-list"  name='province'>
                             <option value="">选择省</option>
                        </select>
                        <select id="city"  class="view-list"  name='city'>
                             <option value="">选择市</option>
                        </select>
                        <select id="area"  class="view-list"  name='area'>
                             <option value="">选择区</option>
                        </select>
                      <!-- </div>   -->
                 <div class='address' style="width: 100%;background: #fff;    margin-top: 20px;    position: relative;">
                       <textarea type="text"  class="view-list"    name="" id="search" lat='' lng='' value="" placeholder="请输入详细地址" style="margin: 0;width:100%;resize: none;height: 70px;    padding-right: 30px;"></textarea>
                        <p style="clear:both;"></p>
                       <span style='position: absolute;width: 30px;padding: 5px;box-sizing: border-box;height: 30px;    right: 0;
    top: 0;display: none'  onclick='openMark()' > 
                      <img src="/static/images/mape-oringe.png" style=" margin-left: 5px;">
                          <p style="clear:both;"></p>
                     </span>
                       <p style="clear:both;"></p>
                 </div>  
                 <!-- <input type="text" name="" value=" "  class="view-list door"  placeholder="请输入门牌号">  -->
                 <!-- <input type="text" name="" value=""  class="view-list"  placeholder="备注">  -->
                    <p style="clear:both;" id='DeterminePTwo' dataof=0 style="background:#f3f3f3">下一步</p>
             </li>
              <p style="clear:both;"></p>
         </ul>
   <!-- <p style="clear:both;" id='DetermineP' style="background:#f3f3f3">下一步</p> -->
   </div>
   </div>
<!-- <input type="hidden" id="_csrf" value="<?php echo Yii::$app->request->csrfToken; ?>" name="_csrf" > -->
</div>
<!--         <div id="allmap" style="width:100%;height:400px;"></div> -->
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=riGCh76icYkT3OXnxPnNEvB54F3ADvzB"></script> -->
<!-- <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script> -->

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=riGCh76icYkT3OXnxPnNEvB54F3ADvzB"></script>

<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script> 
<script>
var urlLost =window.location.href;
localStorage.setItem("urlLost", urlLost);
var  datas=  <?=json_encode($datas)?>;
console.log(datas)
// var map = new BMap.Map("allmap");
// var point =  new BMap.Point(104.207482,30.74303);
// alert('对对对;'+JSON.stringify(datas.saoma_data));
// alert('对对对;'+JSON.stringify(datas.saoma_data));

// alert()
var lng1= 104.207482;
var lat1= 30.74303;

// console.log()
var opr = JSON.stringify(datas.adata);
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
//通过ready接口处理成功验证，加载直接调用的程序放在ready中，这里目前为空
// var configfg={'lng':'','lat':''};
 if (is_weixn()) {
     wx.config({  
          debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
          appId: datas.saoma_data.appId,
          timestamp: datas.saoma_data.timestamp,
          nonceStr: datas.saoma_data.nonceStr,
          signature:  datas.saoma_data.signature,//签名
          jsApiList: [ 'onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'getLocation', 'openLocation','scanQRCode'
       ] 
    });
  }
var pointobj = JSON.parse(sessionStorage.getItem('pointobj'));
  // if(pointobj){
  //    $("#search").val(pointobj.name).attr('lng',pointobj.lng).attr('lat',pointobj.lat);
  // }
wx.ready(function () {
      wx.getLocation({
        type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
        success: function (res) {
          // alert(8)
        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
        var speed = res.speed; // 速度，以米/每秒计
        var accuracy = res.accuracy; // 位置精度
        // console.log(latitude)
          // alert(longitude+0.09154+'=>'+latitud+0.003184)
        var ouer =gcj02tobd09(longitude, latitude)
        // console.log(ouer)
        point =  new BMap.Point(ouer[0],ouer[1]);
        // 将标注添加到地图中 
        var geoc = new BMap.Geocoder(); 
        geoc.getLocation(point, function (rs) {
          // console.log(rs)
          var searchLng=rs.point.lng;
          var searchLat=rs.point.lat;
            var addComp = rs.addressComponents;


          $('#province').val(addComp.province);
                  initCityOnProvinceChange();
              $('#city').val(addComp.city);
              initThree();
              $('#area').val(addComp.district);
            var addCompText= addComp.province + "- " + addComp.city + ", " + addComp.district + "- " + addComp.street + "- " + addComp.streetNumber;
             if(rs.surroundingPois.length){
                addComp = rs.surroundingPois[0];
                addCompText=addComp.address+' , '+addComp.title;
                searchLng=addComp.point.lng;
                searchLat=addComp.point.lat;
              }
              var pointseing =JSON.stringify( {'lng':searchLng,'lat':searchLat,'name':addCompText});
              
               // console.log(addComp);
               // .val("详细地址："+addCompText)
             $("#search").attr('lng',searchLng).attr('lat',searchLat);
           if(pointobj){
                    // alert(sessionStorage.getItem('pointobj'))

                   $("#search").attr('lng',pointobj.lng).attr('lat',pointobj.lat);
             }else{
                  $("#search").attr('lng',searchLng).attr('lat',searchLat);
             }
            sessionStorage.setItem("pointobj",pointseing );
        });
        },
         cancel:function(res){
                 console.log('取消')
    $("#search").attr('lng',lng1).attr('lat',lat1);

          },
          fail:function(){
          console.log('调用失败')
              $("#search").attr('lng',lng1).attr('lat',lat1);
          }
      });
  });
//定义一些常量
var x_PI = 0.09154;
var y_PI = 0.003184;
var PI = 3.1415926535897932384626;
var a = 6378245.0;
var ee = 0.00669342162296594323;
function gcj02tobd09(lng, lat) {
    var z = Math.sqrt(lng * lng + lat * lat) + 0.00002 * Math.sin(lat * x_PI);

    var theta = Math.atan2(lat, lng) + 0.000003 * Math.cos(lng * x_PI);
    var bd_lng = z * Math.cos(theta) + 0.0065;
    var bd_lat = z * Math.sin(theta) + 0.006;
    return [bd_lng, bd_lat];
}


   if(datas.coordinate){
    var datacoordinate =  JSON.parse(datas.coordinate)
       
   }




   if(datacoordinate.jsonobj){
    var datalagData=  JSON.parse(datacoordinate.jsonobj)

   }

var info =  JSON.parse( sessionStorage.getItem("info"));
$(function(){
  // 商品渲染
   brandid()
   //省渲染
    initProvince()
    initListener()
    // 状态记录
    initAddress()
})
function initAddress(){
// var key_a = JSON.parse(sessionStorage.getItem('data2'));
  $("#province").val(datas.agent_address.Province);
  initCityOnProvinceChange();
  $("#city").val(datas.agent_address.City);
  initThree();
  $("#area").val(datas.agent_address.Area);
  // console.log(datacoordinate)
  // console.log(datas.agent_address.Province)
  $('#devfact').val('4e4908505b89ae3eae99e0e8041a5307');
     var _this = $('#devfact').val();
     devfa(_this,datas.bdata)

if(info.Level==8){
 $('#devfa').val(52)
}else{
   $('#devfa').val(36)
}

var obj2 = JSON.parse(sessionStorage.getItem('data2'));
if(obj2){
  $("#province").val(obj2.province);
  initCityOnProvinceChange();
  $("#city").val(obj2.city);
  initThree();
  $("#area").val(obj2.area);
  // console.log(datacoordinate)
  // console.log(datas.agent_address.Province)
  $('#devfact').val(obj2.devfact);
  var _this = $('#devfact').val();
  devfa(_this,datas.bdata)
  $('#devfa').val(obj2.devfa )
}
// 地图回来时
  if(datalagData){
      for(var i=0 in datalagData){
         // console.log(datalagData[i])
           $("#"+i).val(datalagData[i])
         }

  var _this = $('#devfact').val();


         devfa(_this,datas.bdata)
         if(datalagData.devfa){
             $('#devfa').val(datalagData.devfa)
          }
      

    if(datalagData.province){

       $("#province").val(datalagData.province);
                initCityOnProvinceChange();
     }

     if(datalagData.city){
       $("#city").val(datalagData.city);
      initThree();
     }
     if(datalagData.area){
      $("#area").val(datalagData.area);
     }


if(datacoordinate.Lat){
  // $("#search").val(datacoordinate.Name);
    sessionStorage.setItem("datacoordinate", JSON.stringify(datacoordinate) );
  }

var datacoordinatedata = JSON.parse(sessionStorage.getItem('datacoordinate'));
// console.log(datacoordinatedata)
  if(search){
     // $("#search").val(datacoordinatedata.Name);
  }
}
if(datas.BaseInfo.length){
  var item = datas.BaseInfo[0];
      $("#devfact").val(item.brand_id);
      var _this = $('#devfact').val();
      devfa(item.brand_id,datas.bdata);
      // console.log(item.goods_id)
    $('#devfa').val(item.goods_id);
    $('#province').val(item.Province);
    initCityOnProvinceChange();
    $('#city').val(item.City);
        initThree();
    $('#area').val(item.Area);
}
if(datas.state==-1){
        layer.open({
          content:datas.mag
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      if(datas.mag=='该手机号已经登记了设备，请更换'){
          window.location.href="register";
      };
if(datas.user_base){
  var item=datas.user_base;
      $("#devfact").val(item.brandid);
      var _this = $('#devfact').val();
      devfa(item.brandid,datas.bdata);
      // console.log(item.goods_id)
    $('#devfa').val(item.goodsid);
    $('#province').val(item.Province);
    initCityOnProvinceChange();
      $('#city').val(item.City);
      initThree();
      $('#area').val(item.area);
     }
  }
}
$('.view-list').bind('input porpertychange',function(){
       var index = $("#viewUl li .view-list").length;
         for(var i=0;i<index;i++){
            if( !$("#viewUl li .view-list").eq(i).val()){
              $("#DeterminePTwo").css("background",'#ddd');
               return;
            }
          $("#DeterminePTwo").css({"background":" url(/static/images/brnW.png) no-repeat",'background-size':' 100% 100%'});
        }
  });

$("#DeterminePTwo").click(function(){
    // alert(1)
  var obj =    Verification2();
  // alert(2)
var datacoordinatedata = JSON.parse(sessionStorage.getItem('datacoordinate'));


 var pointobj = JSON.parse(sessionStorage.getItem('pointobj'));


  console.log(pointobj);
  // alert(3)

   // if(!pointobj){
   //     // $.toast("还未解析详细坐标!");
   //    layer.open({
   //        content: '还未解析详细坐标'
   //         ,skin: 'msg'
   //      });

   //   $("#search").attr('lng',lng1).attr('lat',lat1);
   //    return;  
   //  }
  var datacoordinate_Lat;
    var datacoordinate_Lng;
      var datacoordinate_Name=''
   if(pointobj){
        datacoordinate_Lng= pointobj.lat;
        datacoordinate_Lng = pointobj.lng;
        datacoordinate_Name= pointobj.name;
   }

  // if(!datacoordinate_Name){
  //   datacoordinate_Name=datacoordinatedata.Name
  // }
  if(!datacoordinate_Lat){
    datacoordinate_Lat=lat1
  }
  if(!datacoordinate_Lng){
      datacoordinate_Lng=lng1
  }
  // console.log(obj);

      // var   viewList = $(".door").val();
      var    devfact=$("#devfact").val()||"";
      var    devfa=$("#devfa").val()||"";
      var    province=$("#province").val()||"";
      var    city=$("#city").val()||"";
      var    area=$("#area").val()||"";
      var    viewList=$("#search").val()||"";
   if(!devfact){
          layer.open({
          content: '请选择设备品牌'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
   return false;
   }
   if(!devfa){
          layer.open({
          content: '请选择设备型号'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }
   if(!province){
          layer.open({
          content: '请选择省'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }
   if(!city){
          layer.open({
          content: '请选择市'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }
   if(!area){
          layer.open({
          content: '请选择区'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }



if(!viewList){
    // $.toast("请填写详细地址!");
    layer.open({content: '请填写详细地址',skin: 'msg' ,time: 2 });
     return;
  }
var obj1 = JSON.parse(sessionStorage.getItem('data1'));
var obj2 = JSON.parse(sessionStorage.getItem('data2'));
var CodeNumber =sessionStorage.getItem('CodeNumber');

// var    viewList=$(".door").val()||"";
var url = window.location.href.split('?')[0];
var encodeurl=url.replace(new RegExp("&","gm"),"@-");
// console.log(url)
        var params={
            "Name":obj1.username,
            "Vcode":obj1.vcode,
            "Tel":obj1.tel,
            "Address":viewList,
            "DevBindMobile":obj1.tel,
            // "DevFactory":devfactory,
            // "Fid":Fid,
            "Province":province,
            "City":city,
            "area":area,
            "UseType":obj1.usertype,
            "customertype":obj1.customertype,
            "brandid":devfact,
            "lat":datacoordinate_Lat,
            "lng":datacoordinate_Lng,
            "goodsid":devfa,
            'url':encodeURI(encodeurl),
            'RoomNo':'',
            'CodeNumber':CodeNumber
        }
        // console.log(params)
 
     var dataof  = $(this).attr('dataof')
     if(dataof==0){
        // alert(3)
     $(this).attr('dataof',1)
        // window.location.href="www.baidu.com";
       // console.log($.param(params))
        // alert(JSON.stringify(params));
      window.location.href="create-account?"+$.param(params);
    }else{
      // console.log(555555)
      // alert(4);

    }
})
// 点击链接到地图
function openMark(){
  var addressVal= $(".address input").val();
  var province= $("#province").val();
  var city= $("#city").val()||'';
  var area= $("#area").val()||'';
  if(!province){
      layer.open({
          content: '请选择省'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return;
  };
  // 验证填写是否有空
  var obj =Verification2();
   var objdata =   JSON.stringify(obj)
      if(objdata){
         sessionStorage.setItem("data2", objdata);
         // console.log(datas.user_base)
          location.href='mark?address='+objdata+'&user_base='+datas.user_base;
      }
  }
// 商品渲染
function brandid(){
      // 商品渲染
    var brandidName=[];
    var brandNameID=[];
    // 分离商品类型 与商品名字
       for(var i=0;i<datas.bdata.length;i++){
             var item = datas.bdata[i]
             // console.log(item)
             var brandname = item.brandname;
             var brandid = item.brandid;
            brandidName.push({brandname:brandname,brandid:brandid})
            brandNameID.push({goodsname:item.goodsname,goodsid:item.goodsid,brandid:brandid})
       }

       // console.log(brandidName)
     //   // 去重
     var brandidName = removeSame(brandidName,'brandid')
     // console.log(brandidName)
     // console.log(brandNameID)
     if(brandidName.length){
          for(var i=0;i<brandidName.length;i++){
              $("#devfact").append('<option value='+brandidName[i].brandid +'>'+brandidName[i].brandname +'</option>')  
          }
     }
       $("#devfact").change(function(event) {
          $("#devfa").empty().append("<option value=''>请选择设备型号</option>")
          var _this = $(this).val();
          devfa(_this,brandNameID)
     });
}
// 商品渲染
  function  devfa(brandid,brandNameID){
   // console.log(brandid)
        $("#devfa").empty();
          $("#devfa").append('<option value="">请选择设备型号</option>')
         for(var i=0;i<brandNameID.length;i++){
   
          if(brandid==brandNameID[i].brandid){
            $("#devfa").append('<option value='+brandNameID[i].goodsid+'>'+brandNameID[i].goodsname+'</option>')
          }
      }
   }
// 去重 同型号只取一个
function removeSame(brandidName,brandid){
        var checked = brandidName;
        var p_ids = [];
        var data = [];
        if(checked.length) {
            $.each(checked,function(i,ck){
                // console.log(ck)
                var p_id = ck.brandid;
                if($.inArray(p_id,p_ids) == -1){
                    p_ids.push(p_id);
                    data.push(ck)
                }
            });
        }
       return data;
    }
// 地址联动
  function initListener(){
    $("#province").on("change",function(){
        initCityOnProvinceChange();
    });

    $("#city").on("change",function(){
        initThree();
    });
}  
    // 区渲染
 function initThree(){
        var pid=getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<datas.adata.length;index++){
            var item=datas.adata[index];
            if(item.pid!=0&&item.pid==pid){
                $("#area").append("<option value='"+item.name+"'>"+item.name+"</option>");
            }
        }
    }
// 市渲染
    function initCityOnProvinceChange(){
        var pid=getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#city").append("<option value='' selected>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<datas.adata.length;index++){
            var item=datas.adata[index];
            if(item.pid!=0&&item.pid==pid){
                $("#city").append("<option value='"+item.name+"'>"+item.name+"</option>");
                initThree()
            }
        }
    }
// 省渲染
    function initProvince(){
        for(var index=0;index<datas.adata.length;index++){
            var item=datas.adata[index];
            if(item.pid==0){
              $("#province").append("<option value='"+item.name+"'>"+item.name+"</option>");
            }
         
        }
    }
    // 获取地址id
    function getAddressIdByName(_name){
    _name= $.trim(_name);
    if(_name==""){
        return 0;
    }
    for(var index=0;index<datas.adata.length;index++){
        var item=datas.adata[index];
        var name= $.trim(item.name);
        if(name!=""&&name==_name){
            return item.id;
        }
    }
    return 0;
}

var Verification2 = function (){
      var    devfact=$("#devfact").val()||"";
      var    devfa=$("#devfa").val()||"";
      var    province=$("#province").val()||"";
      var    city=$("#city").val()||"";
      var    area=$("#area").val()||"";
      var    viewList=$("#search").val()||"";
   if(!devfact){
          layer.open({
          content: '请选择设备品牌'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
   return false;
   }
   if(!devfa){
          layer.open({
          content: '请选择设备型号'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }
   if(!province){
          layer.open({
          content: '请选择省'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }
   if(!city){
          layer.open({
          content: '请选择市'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }
   if(!area){
          layer.open({
          content: '请选择区'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return false;
   }
  var obj = {
          devfact:$("#devfact").val()||"",
          devfa:$("#devfa").val()||"",
          province:$("#province").val()||"",
          city:$("#city").val()||"",
          area:$("#area").val()||"",
          search:$("#search").val()||'',
          address:$("#search").val()||''
    }
   return obj;
}
</script>
<!-- <script type="text/javascript" src="/static/js/agent/register.js" ></script> -->
</body>
</html>