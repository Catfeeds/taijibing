<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta itemprop="name" content="">
    <meta name="description" itemprop="description" content="">
       <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
            <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>
    <style>
        body, html, #allmap {
            width: 100%;
            height: 100%;
            overflow: hidden;
            margin: 0;
            font-family: "微软雅黑";
        }
       select, option, .ta_calendar input, input[type=checkbox], input[type=radio] {
      width: initial;width: background-color:#fff;
   
}
.allmapheader{
    position:fixed;
       z-index:999;background:#1D1F23; line-height:30px;padding: 10px;font-size:14px;
       color:rgb(233,233,233);line-height: 50px;width:100%;
}

input[type='checkbox'] {
  display: none;
} 
.usertype{
    background-color: #2D3136
}
.usertype + label{
    background-color: #2D3136;
    border-radius: 5px;
    /*border:1px solid #d3d3d3;*/
    width:20px;
    height:20px;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    line-height: 20px;
    color: #000
}
.usertype:checked + label{
    background-color: #E46045;
}
.usertype:checked + label:after{
      content:"\2713";
      color: #fff;
    font-weight: 400;
     /*background-color: #000*/
     /*width:100%;*/
}


button, html input[type="button"]{
    background: #292834;
    /* border: 1px solid #BABABF; */
    color: #BABABF;
    line-height: 20px;
    margin-top: -4px;
}
.BMap_pop input,.BMap_pop button,.BMap_pop option{
      background: #fff;
      color: #000
}
     .anchorBL{  
        display:none;  
    }  
    .BMap_bubble_title{  
        color:black;  
        font-size:13px;  
        font-weight: bold;  
        text-align:left;  
    }  
    .BMap_pop div:nth-child(1){  
        border-radius:7px 0 0 0; 
         
    }  
    .BMap_pop div:nth-child(3){  
        border-radius:0 7px 0 0;
        /*background: #ABABAB;*/  
        width:23px;  
        width:0px;height;0px;  
           
    }  
    .BMap_pop div:nth-child(3) div{  
        border-radius:7px;  
          
    }  
    .BMap_pop div:nth-child(5){  
        border-radius:0 0 0 7px;  
      
    }  
    .BMap_pop div:nth-child(5) div{  
        border-radius:7px;  
    }  
    .BMap_pop div:nth-child(7){  
        border-radius:0 0 7px 0 ; 
    
    }  
    .BMap_pop div:nth-child div(7){  
        border-radius:7px ;  
    }  
    .BMap_pop div:nth-child(9){  
         border-radius:7px ;  
    }  

.BMap_pop img{
  width:100%;
}
select, option{
  width:100px;
  border-radius: 2px
}
.allmapheader button{
  padding: 2px   15px;
}
.arrow{

    font-size: 0px;
    line-height: 0px;
    top: -30px;
    margin-top: -40px;
    z-index: -1;
    margin-left: -35px;
}

.BMap_Marker img{
 width:100%;

}

    </style>
</head>
<body style="background-color:#1D1F23 ">
  <div>
    
  
<div  class="allmapheader pull-left"  style="">
    
     <span  > 用户角色：</span>
     <span style="background: #393E45;padding: 5px;border-radius: 2px ;    margin-right: 20px;"> 

     <span  class="userleft">
        <input type="checkbox" class="usertype" usertype="5" id="custom_user" checked/>
        <label for="custom_user"></label>
        <span>用户</span>
         <img src="/static/images3/icon05.png" alt="">
    </span>

 
    &nbsp;
    &nbsp;

    <span class="userleft">
        <input type="checkbox" class="usertype" usertype="3" id="agent_f" checked/>
        <label for="agent_f"></label> 
        <span>服务中心</span>
         <img src="/static/images3/icon03.png" alt="">
    </span>
 
    &nbsp;
    &nbsp;

      <span class="userleft">
        <input type="checkbox" class="usertype" usertype="2" id="agent_x" checked/>
        <label for="agent_x"></label> 
        <span>运营中心</span>
          <img src="/static/images3/icon02.png" alt="">
    </span>
 
    &nbsp;
    &nbsp;


     <span class="userleft">
            <input type="checkbox" id="water_f"  class="usertype" usertype="1" checked >
            <label for="water_f"></label>
            <span  >水厂</span>
              <img src="/static/images3/icon01.png" alt="">
        </span>
 
    &nbsp;
    &nbsp;

     <span class="userleft">
        <input type="checkbox" class="usertype" usertype="4" id="dev_f" checked/>
        <label for="dev_f"></label>
        <span >设备厂家</span>
          <img src="/static/images3/icon04.png" alt="">
    </span>
 
    &nbsp;
    &nbsp;


     <span class="userleft">
        <input type="checkbox" class="usertype" usertype="6" id="usertype_f" checked/>
        <label for="usertype_f"></label>
        <span >设备投资商</span>
          <img src="/static/images3/icon06.png" alt="">
    </span>

     </span>

      
<span> 
<span>

<span  > 地区选择：</span>
    <select class="control-label" name="DevFactory[Province]" id="province">
        <option value="" selected>请选择</option>
    </select>
    <select class="control-label" name="DevFactory[City]" id="city">
        <option value="">请选择</option>
    </select>
    <select class="control-label" name="DevFactory[Area]" id="area">
        <option value="">请选择</option>
    </select>
</span>
<div style='    display: inline-block; width: 300px;'>
      <button type="button" class="btn" value="查看" style="margin-left:10px;" id="queryBtn">查看</button>
    <button type="button" class="btn" value="清除条件" style="margin-left:10px;" id="removerBtn" style='width: 200px'>清除条件</button>

</div>

<div class="pull-right normal-mode"  style='float: right;    width: 100px;display:none'>
     <a href="javascript:window.history.go(-1);" class="pull-right" style="color:white;font-size:13px;text-decoration: none;">
            <img src="/static/images3/map.png" alt="" style='border:none;    margin-right: 10px;' >
    </a>
</div>

 </span>
  <div style=';clear:both  '>
    
  </div>
</div>
</div>
<div id="allmap" style="z-index: -1;height: 100%;"></div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script>
<script>
     var data =<?=json_encode($address)?>;

       var role_id=<?=$role_id?>;
       var type='<?=$type?>';
       if(type==1){
           $('.normal-mode').css('display','block')
       }
       // console.log(data)
if(role_id==2){
  $('#usertype_f,#dev_f,#agent_x,#agent_f').parent().remove()
  $(".normal-mode").remove()
}

     var map;

     var currMarkers=[];
     var currMarkerObj=[];
     var currMarkers2=[];

</script>
<script>
    $(function () {
        initMap();
        // initProvince();
        // initListener();
        // initAddress();
        // query();
        $("#removerBtn").click(function(event) {
           // $('.allmapheader input,.allmapheader select').val('')
           // function demo(){   $("#demo").attr("checked",false);}
           $('.allmapheader input,.allmapheader select').attr("checked",false);
           $('.allmapheader select').val('')
        });
    });
    // 地址
   addressResolve(data);

    function initMap(){
           map = new BMap.Map("allmap");

           // currMarkers
           var point = new BMap.Point(104.106083,30.687213);//默认位置
           map.centerAndZoom(point, 18);
           map.addControl(new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,offset: new BMap.Size(10, 150)}));        // 添加平移缩放控件
           map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

          map.addEventListener("moveend", queryInRect);  
          map.addEventListener("zoomend", queryInRect);  
          var bounds = map.getBounds();
          var sw = bounds.getSouthWest();
          var ne = bounds.getNorthEast();
          queryInRect ()
        
    }
  // 地图拖动及缩放监听事件
            function queryInRect (event) {  
                   // currMarkers=[1]
              var cp = map.getBounds(); // 返回map可视区域，以地理坐标表示  
                    var sw = cp.getSouthWest(); // 返回矩形区域的西南角  
                    var ne = cp.getNorthEast(); // 返回矩形区域的东北角  
                    var zoom = map.getZoom(); //当前缩放级别 
                    query(sw,ne,zoom);
              }

    function query(sw,ne,zoom) {
    
        var province = $("#province").val();
        var city = $("#city").val();
        var area = $("#area").val();

        if(province==null){
            province="";
        }
        if(city==null){
            city="";
        }
        if(area==null){
            area="";
        }
        var checkedTypes = $("input.usertype:checked");
        var arr = [];
        for (var index = 0; index < checkedTypes.length; index++) {
            var item = checkedTypes[index];
             arr.push($(item).attr("usertype"));
        }
        // console.log(arr)
        var usertype = arr.join(",");

     var ii=layer.msg("加载中……",{shade: 0 , time: 0 });//不自动关闭

          
        // alert(province)
        //地图区域边界显示  
       // function getBoundary(area) {  
       //    var bdary = new BMap.Boundary();  
       //     bdary.get(area, function (rs) { //获取行政区域  
       //      var arr = rs.boundaries; 
       //      var polyline = new BMap.Polyline(arr[0],{strokeColor:"blue", strokeWeight:6, strokeOpacity:0.5});  
            
       //      map.addOverlay(polyline);  
       //      });  
       //   }  
        var  mapLo=province+city+area||'中国';
        // console.log(usertype)
        $.getJSON("/index.php?r=dev-manager/get-markers&user_type=" + usertype + "&city=" + city + "&province=" + province + "&area=" + area, function (data  
           ){
          // console.log(data)
           var num = 0
           // getBoundary(mapLo);
           // 视图范围
           var  currMark2=[];
             for (var index = 0; index < data.length; index++) {
                   
                var item = data[index];
                 
                var lat = Number(item.BaiDuLat);
                var lng = Number(item.BaiDuLng);
              if(item.user_type==5){
                // console.log(4)
                    // var point = new BMap.Point(104.106083,30.687213)
                  }
                if(lng<=ne.lng&&lat<=ne.lat){
                     num++
                       currMarkers.push('{ "lat":'+lat+',"lng":'+lng+'}'); 
                       currMarkerObj.push(item); 
                       currMark2.push(item); 

                }
            }




          var     currMarkitem=  currMark2;
         var  currMarkersarrayUn=arrayUnique1(currMarkers);
         var appJson= temparrayArr(currMarkersarrayUn,currMarkers2);

         console.log(num)
       //
     map.clearOverlays(); 
      for (var index = 0; index < currMarkitem.length; index++) {
             var currMarkitemitem = currMarkitem[index];
           // console.log(currMarkitemitem);   
                 var lat = Number(currMarkitemitem.BaiDuLat);
                var lng = Number(currMarkitemitem.BaiDuLng);


                   var pt = new BMap.Point(lng, lat);
                   if(currMarkitemitem.user_type){
                    // console.log(1)
                    var myIcon = new BMap.Icon("/static/img/icon_"+currMarkitemitem.user_type+".png", new BMap.Size(20, 35));
                        var DevNoIdE;
                       if(currMarkitemitem.user_type==5){
                       DevNoIdE = currMarkitemitem.DevNo
                      }else{
                         DevNoIdE = currMarkitemitem.Id
                    }


                    addMarker(pt,index,currMarkitemitem.user_type,DevNoIdE);
                  }
      }
         // console.log(appJson)
         var io = 0;

 //        for (var index = 0; index < appJson.length; index++) {
 //           io ++
 //          var item = appJson[index];
 //            currMarkers2.push(item);
 //          // console.log(1)
 //            var itemJson =   $.parseJSON( item ) 
           
 //                var lat = Number(itemJson.lat);
 //                var lng = Number(itemJson.lng);

 //            // console.log(lat)
 //                for(var izindex=0;izindex<currMarkerObj.length;izindex++){
                    
 //                  var izindexemt=currMarkerObj[izindex]
 //              // console.log(izindexemt)
 //                    if(izindexemt.BaiDuLat==lat&&izindexemt.BaiDuLng==lng){
 //                          var point = new BMap.Point(lng, lat);
 //                           //创建小狐狸
 //                          var pt = new BMap.Point(lng, lat);
 //                              if(izindexemt.user_type){
 //                                var myIcon = new BMap.Icon("/static/img/icon_"+izindexemt.user_type+".png", new BMap.Size(20, 35));
 //                                    var DevNoIdE;
 //                                   if(izindexemt.user_type==5){
 //                                   DevNoIdE = izindexemt.DevNo
 //                                  }else{
 //                                     DevNoIdE = izindexemt.Id
 //                                }

 //                                addMarker(pt,index,izindexemt.user_type,DevNoIdE);
 //                              }
 //                       }
 //                   }
 //                // if(index==200) { 
 //                //    break; 
 //                // } 
 // }
                  //编写自定义函数，创建标注  
        function addMarker(point,index,user_type,DevNoIdE){ 


          
              var marker2 = new BMap.Marker(point,{icon: myIcon}); 
           

                 map.addOverlay(marker2);  


                 // var label = new BMap.Label('', point);  
                 // label.hide()



                        marker2.addEventListener("click",function(){ 
                               var ii=layer.msg("加载中……",{shade: 0 , time: 0 });//不自动关闭
                           var latp= Math.floor((this.point.lat)*10000000)/10000000
                           var lngp = this.point.lng
                           var user_typeId;
                            if(user_type==5){
                            user_typeId ='DevNo'
                            }else{
                              user_typeId = 'Id'
                           }
                      $.get("index.php?r=dev-manager/get-info&BaiDuLat="+latp+"&BaiDuLng="+lngp+"&user_type="+user_type+"&"+user_typeId+"="+DevNoIdE, function (data) {
                            layer.close(ii);
                            $('.BMapLabel').remove()
                            var dataConter;
                            var data= data;
                            var Name =data.Name ||'';
                            var ContractTel =data.ContractTel ||'';
                            var DevNo =data.DevNo ||'';
                            // var Address =data.Address ||'';
                            var Address ="***";
                            var labelStyleH;
                            var labelStyleB;
                        

                            var tString = ContractTel.substr(3,4);
                            var ContractT = ContractTel.replace(tString, "****")
                             if(user_type==5){

                              
                                 dataConter ='<p style="font-weight:bold">用 &nbsp;&nbsp;户：'+Name+'</p><p>电&nbsp;&nbsp;话：'+ContractT+'</p><p>设备编号：'+DevNo+'</p><p>地&nbsp;&nbsp;址：'+Address+'</p><div  class="Subtitle" style="position:absolute;float:right;width:20px;height:20px;top:-3px;right:0;background: #fff;border-radius: 50px;text-align: center;line-height: 20px;">'+
                                   '<img src="/static/images3/ridaus2.png" style="width:12px"></div> '
                              // $(".progress-text p:first-of-type").text
                                labelStyleH = '150';
                                labelStyleB = '#FB8D21';

                                     var html = '  <div  class="progress"> <div  class="progress-text" style="position:relative">'+dataConter+'</div><div class="snajiao"></div> '+
                                    '<div class="arrow" style=" margin-top: -30px;"><img src="/static/images3/arrowImg_'+user_type+'.png"> </div> </div>';
                               }else{
                                    labelStyleH = '110';
                                    var NameTitle ;
                                    if(user_type==1){
                                    NameTitle='水厂';
                                    labelStyleB = '#EE5030';
                                    }
                                    else if(user_type==2){
                                    NameTitle='运营中心';
                                    labelStyleB = '#C248DC';
                                    }
                                    else if(user_type==3){
                                    NameTitle='服务中心';
                                    labelStyleB = '#4691F7';
                                    }
                                    else if(user_type==4){
                                    NameTitle='设备厂家';
                                    labelStyleB = '#F3BA41';
                                    }
                                    else if(user_type==6){
                                    NameTitle='设备投资商';
                                    labelStyleB = '#36CACC';
                                    }
                                    dataConter ='<p style="font-weight:bold">'+Name+'（'+NameTitle+'）</p><p>电&nbsp;&nbsp;话：'+ContractT+'</p><p>地&nbsp;&nbsp;址：'+Address+'</p><div class="Subtitle" style="position:absolute;float:right;width:20px;height:20px;top:-3px;right:0;background: #fff;border-radius: 50px;text-align: center;line-height: 20px;">'+
                                    '<img src="/static/images3/ridaus2.png"  style="width:12px"></div> '

                                    var html = '  <div  class="progress"> <div  class="progress-text" style="position:relative">'+dataConter+'</div><div class="snajiao"></div> '+
                                    '<div class="arrow"  ><img src="/static/images3/arrowImg_'+user_type+'.png"> </div> </div>';
                                    }

                                    var infoWindow = new BMap.InfoWindow(html);//创建信息窗口对象  
                                     // map.openInfoWindow(infoWindow,point);//打开信息窗口  
                                    var opts = {
                                      position : point,    // 指定文本标注所在的地理位置
                                      offset   : new BMap.Size(20, -(labelStyleH*1+20))    //设置文本偏移量
                                    }

                                    var label = new BMap.Label(html, opts);  // 创建文本标注对象
                                    label.setStyle({
                                     color : "#000",
                                     height:labelStyleH+'px',
                                     minWidth:'250px',
                                     fontSize : "14px",
                                      boxShadow: ' 5px 5px 5px #888888',
                                     border:'none',
                                     backgroundColor:labelStyleB,
                                     borderRadius:'25px',
                                     padding:'0 20px',
                                     color:'#fff',
                                     fontFamily:"微软雅黑"
                                     });

                                    map.addOverlay(label);  
                                    $('.Subtitle').click(function(e){
                                      // console.log(this)
                                    label.hide()
                                    //BMapLabel
                                     });

                       })
                        })
        }
 // console.log(io)
function   temparrayArr(arr1,arr2){
      var temp = []; //临时数组1 
     var temparray = [];//临时数组2  
     for (var i = 0; i < arr2.length; i++) { 
      temp[arr2[i]] = true;//巧妙地方：把数组B的值当成临时数组1的键并赋值为真 
    };  
    for (var i = 0; i < arr1.length; i++) { 
      if (!temp[arr1[i]]) {  

    temparray.push(arr1[i]);//巧妙地方：同时把数组A的值当成临时数组1的键并判断是否为真，如果不为真说明没重复，就合并到一个新数组里，这样就可以得到一个全新并无重复的数组 
       } ;  
    };
    // console.log() 
    return temparray
}

 // 去重
function arrayUnique1(arr) { 
   var result = [], hash = {}; 
  for (var i = 0, elem; (elem = arr[i]) != null; i++) {
    if (!hash[elem]) {  
      result.push(elem);
          hash[elem] = true; 
       } else{
        
        
       }
    } 
      return result; 
   } 
            layer.close(ii);
    
   });

    }
    function getAddressIdByName(_name) {
        _name = $.trim(_name);
        if (_name == "") {
            return 0;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            var name = $.trim(item.Name);
            if (name != "" && name == _name) {
                return item.Id;
            }
        }
        return 0;
    }

    function initListener() {
        $("#province").on("change", function () {
            initCityOnProvinceChange();
        });
        $("#city").on("change", function () {
            initThree();
        });
       
    }

     $("#queryBtn").on("click",function(){

        // queryInRect()

        var province = $("#province").val();
        var city = $("#city").val();
        var area = $("#area").val();

        if(province==null){
            province="";
        }
        if(city==null){
            city="";
        }
        if(area==null){
            area="";
        }
        var checkedTypes = $("input.usertype:checked");
        var arr = [];
        for (var index = 0; index < checkedTypes.length; index++) {
            var item = checkedTypes[index];
             arr.push($(item).attr("usertype"));
        }
        // console.log(arr)
// 
        var usertype = arr.join(",");
              var ii=layer.msg("加载中……",{shade: 0 , time: 0 });//不自动关闭
        var  mapLo=province+city+area||'中国';




var appurl = province+city+area;

// alert(appurl)


var myGeo = new BMap.Geocoder();      
// 将地址解析结果显示在地图上，并调整地图视野    
myGeo.getPoint(appurl, function(point){      
    if (point) {      
        map.centerAndZoom(point, 12);      
        // map.addOverlay(new BMap.Marker(point));      
    }      
 }, 
"北京市");

queryInRect()

      });


    function initCityOnProvinceChange() {
        var pid = getAddressIdByName($("#province").val());
        $("#city").empty();
        $('option:not(:first-child)', $("#area")).remove();
        $("#city").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#city").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
                initThree()
            }
        }
    }
    function initThree() {
        var pid = getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#area").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
    function initProvince() {
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId == 0) {
                $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }



      var FullScreenFalse = false;

      $('#FullScreen', window.parent.document).click(function(){
         if(!FullScreenFalse){
                $('.brh').remove()
                FullScreenFalse = true;
               $("body").removeClass('mini-navbar')
             // $('.normal-mode').css('marginRight','65px')
             // $('.normal-mode').css('display','none')
            // $('#FullScreen', window.parent.document).css('top','-55px')
     
         }else{
            $(".allmapheader span:nth-of-type(6)").eq(0).after('<br class="brh"/ >')
            // $('#FullScreen', window.parent.document).css('top','55px')
         // $('.normal-mode').css('display','block')
         $("body").addClass('mini-navbar');
             FullScreenFalse = false;
         }
     })
</script>
</body>
</html>

