<!DOCTYPE html>  
<html>
<head>  
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>Hello, World</title>  
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  
#mapContainer{height:100%}  
#search{width: 250px;}
</style>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=riGCh76icYkT3OXnxPnNEvB54F3ADvzB">
</script>
</head>  
<body>  
   <div style='padding: 10px;'>
    <label>
        <input type="txt" name="" id='search' value="" placeholder="输入更改地址">
        <button type="text"  class="btn">搜索</button>
    </label>       
   </div>
<div id="mapContainer"></div> 
<script type="text/javascript" src="/static/js/jquery.min.js"></script> 
<script type="text/javascript"> 
  var cur = null;
  var _addr=null;
// // 初始化地图，设置中心点坐标和地图级别  
var map = new BMap.Map("mapContainer");    
var point = new BMap.Point(104.067923, 30.679943); //成都市(116.404, 39.915);  
var devregistlat=parent.$("#devregist-lat").val();;//访问父页面元素值
var devregistlng=parent.$("#devregist-lng").val();
var geoc = new BMap.Geocoder();
if(devregistlng&&devregistlat){
    point = new BMap.Point(devregistlng, devregistlat); //成都市(116.404, 39.915); 
}
map.centerAndZoom(point, 15);    
map.enableScrollWheelZoom(); //可滑动
map.addControl(new BMap.NavigationControl()); //导航条
var marker = new BMap.Marker(point);        // 创建标注    
map.addOverlay(marker);                     // 将标注添加到地图中 
    //监听点击地图事件
    map.addEventListener("click", function (e) {
        cur= e.point;
        getCircle(cur);
    });
    //创建标注点函数
    function getCircle(point) {
        map.clearOverlays();
        marker = new BMap.Marker(point);
        map.addOverlay(marker);

    }
$(".btn").click(function(){
    var _this = $("#search").val()

    // console.log(_this)
  
var local = new BMap.LocalSearch(map, {      
    renderOptions:{map: map}      
});      
local.search(_this);
})
var btnOk =  parent.$(".layui-layer-btn .layui-layer-btn0");
var devregista=parent.$("#devregist-lat");
var devregistn=parent.$("#devregist-lng");
 var index = parent.layer.getFrameIndex(window.name);
btnOk.click(function(){
  // console.log(cur);
devregista.val(cur.lat)
devregistn.val(cur.lng)
parent.layer.close(index);
})
</script>  
</body>  
</html>