<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="/static/js/layer.mobile-v2.0/layer_mobile/need/layer.css">
     <style type="text/css">
body, html {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
.map{
padding:20px;position: relative;    height: 100%;
padding: 20px;
position: relative;
height: 100%;
width: 100%;
box-sizing: border-box;
}
#allmap {
height: -webkit-calc(100% - 300px);height: -moz-calc(100% - 300px);height: calc(100% - 300px)height: 100%; ; margin-top:10px;
width:100%;

}
.bgallmap{
  /*width:100%;height: -webkit-calc(100% - 300px);height: -moz-calc(100% - 300px);height: calc(100% - 300px) ;   margin-top: 10px;*/
}
.address-search{
/*position: absolute;*/
bottom: 0;
z-index: 1;
width: 100%;
text-align: left;
text-indent: 0px;
max-height: 200px;
overflow: auto;
}
.address-search p{
margin-left: 40px
}
.address-details{
position: relative;
}
.address-details>img{
    float: left;
    margin-right: 16px;
    position: absolute;
    left: 10px;
    top: 50%;
    width: 15px;
    margin-top: -10px;
}

.address-details:first-child{
background: #f3f3f3;
padding: 1px 0;
color: #FF662E
}
.header{
padding-bottom: 9px;
border-bottom: 1px solid #f3f3f3;
}
.header p{
border-left: 8px solid #E46045;    text-indent: 10px;    font-size: 20px;
font-weight: bold;
}
.search{
  width: -webkit-calc(100% - 60px);width: -moz-calc(100% - 60px);width: calc(100% - 60px);
  height: 25px;
}
.search input{
    height: 35px;
    margin-top:10px;  
    border-radius: 5px 0 0 5px;
    text-indent:20px; 
    border: none;    
    font-size: 15px;
    background-color: #f3f3f3;
    font-weight: bold;
    color: #999;
    font-size: 15px;
    display: inline-block;
}
.submit{
  background: url(/static/images/brnW.png) no-repeat;    background-size: 100% 100%;
  position: absolute;
  right: 0;
  width:50px;
  height: 30px;
  top: 10px;
  }
.tagging{
   width: 40px;
    height: 40px;
    position: absolute;
    top: 45%;
    left: 50%;
    margin-top: -30px;
    margin-left:-20px;

    display: none;
}

    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=riGCh76icYkT3OXnxPnNEvB54F3ADvzB"></script>

    
    <title>地址解析</title>
</head>
<body>
   <div class="map">
       <div class="header">
              <p>地图详情</p>
        </div> 


    <div clss="address-search" style='padding-top: 10px;width: 100%; position: relative;height:35px;'>
         <input class="search" style=''  lng="" lat="" type="text" name="" value="" placeholder="请输入具体地址">
         <input type="button"  class="submit" name="" value="搜索" style=" 
    border: none;
    color: #fff;">

    <br/>
    </div>

   <!-- <div class="bgallmap" > -->
        <div id="allmap"></div>
  <div class="tagging">
     <img src="/static/images/bgcolopoi.gif" width=100%>
</div>
   <!-- </div> -->
  <div class="Addmap" style='width: 100%;    height: 220px;text-align: left;text-indent:20px;background-color: #fff;padding:15px;    padding: 20px;
    box-sizing: border-box;'>
          <div  class="address-search">

            <div style="clear:both"></div>
                 <div class="address-details"   datalat="104.207482" datalng = "30.74303" > 
                    <p class="name">成都龙和国际茶城</p>
                    <p class="province" style="color:#666;margin-top:-15px;font-size: 14px;">四川省成都市</p>
                 </div> 
          </div>
    </div>
       </div>
</body>
</html>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript">

var $address =JSON.parse(<?=json_encode($address)?>);
var addresstxt = $address.province+$address.city+$address.area;

// var datamap = JSON.parse($address.address) 
 var pointobj = JSON.parse(sessionStorage.getItem('pointobj'));
  // console.log(pointobj);

  // alert(sessionStorage.getItem('pointobj'))

var lat=30.74303;
var lng= 104.207482;

if(pointobj){
  lat=pointobj.lat
  lng=pointobj.lng
}

// console.log($address)
//     // 百度地图API功能
  var map = new BMap.Map("allmap");
   var point =  new BMap.Point(lng,lat);
    map.centerAndZoom(point,16);
    map.enableScrollWheelZoom(); 
    var geolocation = new BMap.Geolocation();
     var marker  = new BMap.Marker(point)
    map.clearOverlays();
       map.addOverlay(marker);
        var geoc = new BMap.Geocoder();  
        var myIcon = new BMap.Icon("/static/images/jingtai.png", new BMap.Size(23, 25), {
         // 指定定位位置
         offset: new BMap.Size(10, 25),
         // 当需要从一幅较大的图片中截取某部分作为标注图标时，需要指定大图的偏移位置   
         // imageOffset: new BMap.Size(0, 0 - i * 25) // 设置图片偏移  
       });
          getLocationA(point)
           map.addEventListener('moveend',function(){
              // console.log(5)
              // alert("当前地图中心点：" + map.getCenter().lng + "," + map.getCenter().lat);
               point =  new BMap.Point( map.getCenter().lng, map.getCenter().lat);
                 map.addOverlay(new BMap.Marker(point));
                var geoc = new BMap.Geocoder();  
                $(".tagging").hide()
                getLocationA(point)
           })

       map.addEventListener('ondragging', function(){
              $(".tagging").show()
             // map.clearOverlays();
             // console.log(1)
             map.clearOverlays();
    });

function  getLocationA(point){
   geoc = new BMap.Geocoder();  
          geoc.getLocation(point, function (rs) {

            console.log(rs)
          var addArr = rs.surroundingPois;
          
          $(".address-search").empty()
          for(var i=0;i<addArr.length;i++){
               var item =  addArr[i];
                var html = '<div class="address-details"  datalat = "'+item.point.lat +'"  datalng = "'+item.point.lng +' "> ';
                      html+='    <img src="/static/images/loc_icon.png">';
                      html+=' <p class="name">'+item.title +'</p>';
                      html+=' <p class="province" style="color:#666;margin-top:-15px;font-size: 14px;">'+item.address +'</p>';
                      html+='</div> ';
                      $(".address-search").append(html)
          }
          addressClick()
        });
}
$(".submit").click(function(){
var _val = $(".search").val();
if(_val){
  
    var options = {      
    onSearchComplete: function(results){      
        if (local.getStatus() == BMAP_STATUS_SUCCESS){      
            // 判断状态是否正确      
            var s = [];  
            for (var i = 0; i < results.getCurrentNumPois(); i ++){      
                s.push(results.getPoi(i)); 
            }      
          if(s.length){
            map.centerAndZoom(s[0].point,16);
               $(".address-search").empty()
          for(var i=0;i<s.length;i++){
               var item =  s[i];
                var html = '<div class="address-details"  datalat = "'+item.point.lat +'"  datalng = "'+item.point.lng +' "> ';
                      html+='    <img src="/static/images/loc_icon.png">';
                      html+=' <p class="name">'+item.title +'</p>';
                      html+=' <p class="province" style="color:#666;margin-top:-15px;font-size: 14px;">'+item.address +'</p>';
                      html+='</div> ';
                      $(".address-search").append(html)
        }
        addressClick()

     }else{
      alert('没有搜索到位置')
     }
        }   else{
          alert('没有搜索到位置')
        }   
    }      
 };   
var local = new BMap.LocalSearch(map, options);  
    local.search(_val);
}
//   
// var local = new BMap.LocalSearch(map, options);      
// 

})





addressClick()

function addressClick(){
$('.address-details').click(function(){


  // alert(4)
  var polat = $(this).attr("datalat");
  var polng = $(this).attr("datalng");
  var _thisVal = $(this).find(".name").text();
  var _thisValprovince = $(this).find(".province").text();
// alert(4)
  // var ii = layer.open({type: 2,shadeClose:true});
  // console.log()
  // console.log(polat)
  // console.log(polng)

  var name = _thisVal+","+_thisValprovince;

   var pointseing =JSON.stringify( {'lng':polng,'lat':polat,'name':name});
    sessionStorage.setItem("pointobj",pointseing );
     var data1 =  JSON.parse( sessionStorage.getItem("data1"));
     // console.log(data1)

  location.href='register-dev-info?addressName='+_thisVal+'&coordinatelat='+polat+'&coordinatelng='+polng+'&user_base='+data1+'&jsonobj='+<?=json_encode($address)?>;
 

  })

// $(".search").on("focus",function(){
//       $(".Addmap").css('display','none');
// })
// $(".search").on("blur",function(){
//         $(".Addmap").css('display','block');
// })
}

</script>
