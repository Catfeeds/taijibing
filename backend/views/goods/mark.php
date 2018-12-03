<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <title>地图标记</title>
     <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
</head>
<style type="text/css">
 .layui-layer{
    border-radius: 10px;
    overflow: hidden;
        padding: 10px;
    background: #fff;
 }
 .select_btn{
    margin-left: 50px;
 }
/* .layui-layer-iframe .layui-layer-btn, .layui-layer-page .layui-layer-btn {
    margin-top: -2em;
}*/
.layui-layer-page .layui-layer-content{
    height: 450px !important; 
}
.layui-layer-btn{
margin-top:10px;
}
</style>
<body style="width: 550px;height: 500px">

<div id="mapContainer" style="width: 100%;height: 450px;overflow: hidden;margin:0;"></div>


</body>
</html>
<script type="text/javascript">
    var cur = null;
    var _addr=null;
    var map = new BMap.Map("mapContainer");
    var geoc = new BMap.Geocoder();
    map.enableScrollWheelZoom(); //可滑动
    map.addControl(new BMap.NavigationControl()); //导航条


    var point = new BMap.Point(104.067923, 30.679943); //成都市(116.404, 39.915);


    map.centerAndZoom(point, 13);
 if ($(window.parent.document).find("#address").val() != "") {
   var nameUrl = $("#province").val()+$("#city").val()+$("#area").val()+$("#address").val();
geoc.getPoint(nameUrl, function(point){      
    if (point) {      
        map.centerAndZoom(point, 13);      
        map.addOverlay(new BMap.Marker(point));  
        cur = point;    
     } else {
                alert("您选择地址没有解析到结果!");
            }    
 }, 
"成都市");
    }




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

       function ok(){
        if(cur==null){
            alert("请先标注点！");
        // return;

        }
        mark(cur);
    }
</script>