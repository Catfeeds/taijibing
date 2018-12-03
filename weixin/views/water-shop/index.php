<!DOCTYPE html>
<html>
<meta charset="UTF-8">
    <title>订水门店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
</head>
<style type="text/css" media="screen">
	body{
	background-color:#f3f3f3;
	padding:0;
	margin: 5px 0;
	}
	p{
		padding:0;
		margin:0;
	}
	.list,.list_head{
		background-color:#fff;
		border:solid #f3f3f3 1px;
			border-left:none;
		border-right:none;
	}
	.list_head{
		padding:15px 20px;
		color:#999;
	}
	.list_body{

	}
	.content{
		width:33.3%;
		    position: relative;
		    height:100px;
		float:left;
		border:1px solid #f3f3f3;
		border-left:none;
		border-top:none;
		text-align:center;
		    padding: 13px 5px;
		    box-sizing: border-box;
		    color:#000;
	}
		.content img{
			height:40px;
		}
</style>
<body>
    <div class="list">
    	  <div class="list_head">
    	  	  太极兵服务
    	  </div>
    	  <div class="list_body get_category">
    	 <!--   	<a href="/index.php/water-shop/list" >
    	  	  <div class="content">
    	  	  	
    	  	  	    <div class ="img">
    	  	  	    	<img src="/static/images/Water_drop.png" >
    	  	  	    </div>
    	  	  	    <p>水</p> 
    	  	  	
    	  	  </div>
    	  	</a>
 -->
    	  	<div class="content">
    	  	  	   <div class ="img">
    	  	  	    	<img src="/static/images/Ellipsis1.png"  height=30px 	>
    	  	  	    </div>
    	  	  	    <p>敬请期待</p> 
    	 </div>
    	  
    	
    	  	  <div style="clear:both "> </div>
    	  </div>
    </div>
        <div class="list">
    	  <div class="list_head">
    	  	  第三方服务
    	  </div>
    	  <div class="list_body">
    	  	<a href="javascript:void(0);" >
    	  	  <div class="content">
    	  	  	    <div class ="img">
    	  	  	    	<img src="/static/images/Tea_set.png">
    	  	  	    </div>
    	  	  	    <p>茶具</p>
    	  	  </div>
    	  	</a>
    	  	<a href="javascript:void(0);" >
    	  	  <div class="content">
    	  	  	    <div class ="img">
    	  	  	    	<img src="/static/images/Tea2.png">
    	  	  	    </div>
    	  	  	    <p>茶叶</p>
    	  	  </div>
    	  	</a>
    	  	<a href="javascript:void(0);" >
    	  	  <div class="content">
    	  	  	    <div class ="img">
    	  	  	    	<img src="/static/images/Mother_baby.png">
    	  	  	    </div>
    	  	  	    <p>母婴</p>
    	  	  </div>
    	  	</a>
    	  	<a href="javascript:void(0);" >
    	  	  <div class="content">
    	  	  	    <div class ="img">
    	  	  	    	<img src="/static/images/Life.png">
    	  	  	    </div>
    	  	  	    <p>生活服务</p>
    	  	  </div>
    	  	</a>
    	  	<a href="javascript:void(0);" >
    	  	  <div class="content">
    	  	  	    <div class ="img">
    	  	  	    	<img src="/static/images/service.png">
    	  	  	    </div>
    	  	  	    <p>蓉城生活</p>
    	  	  </div>
    	  	</a>


    	  	 
    	  	  <div class="content">
    	  	  	     <div class ="img">
    	  	  	    	<img src="/static/images/Ellipsis2.png" height=30px >
    	  	  	    </div>
    	  	  	    <p>即将上线</p> 
    	  	  </div>
    	
    	  	  <div style="clear:both ">
    	  	  	
    	  	  </div>
    	  </div>
    </div>

</body>

<script src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>     
<script type="text/javascript">
function  Datas(obj,url){
 var csj_data;

console.log(url);
     if(!obj){
        obj=''
     }
      $.ajax
       ({
           cache: false,
           async: false,
           type: 'get',
           data: obj,
           url: url,
           success: function (data) {
                 layer.closeAll()

             if(typeof(data)=='string'){
                data= eval('(' + data + ')');
                }
               csj_data = data;
             }
       });
       // console.log(csj_data)
        return csj_data;
     }


var $power_data=Datas('','/index.php/water-shop/get-power-data')
var $res=Datas('','/index.php/water-shop/get-category')
console.log($res);
  var  lng = '104.206473';
  var  lat = '30.743847';
if($res.length){
        $.each($res, function(index, item){   
           console.log(item );  // true
              var html = '<a href="javascript:void(0);" >';
                 html += '<div class="content" data="'+item.category_id+'">';
                html+='<div class ="img">';

                html+='<img src="/static/images3/'+item.category_id+'.png" >';

                html+='</div>';
                html+='<p>'+item.CategoryName+'</p> ';
                html+='</div>';
                html+='</a>';
            $(".get_category").prepend(html)
            }); 
}
if($power_data){
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

     wx.config({
      debug: false,
      appId: $power_data.appId,
      timestamp:$power_data.timestamp,
      nonceStr:$power_data.nonceStr,
      signature: $power_data.signature,
      jsApiList: [ 'getLocation', 'getWXDeviceInfos']
    });
      wx.ready(function () {
          wx.getLocation({
            type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                   var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                      var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                      var speed = res.speed; // 速度，以米/每秒计
                      var accuracy = res.accuracy; // 位置精度
                      // console.log(latitude)
                        // alert(longitude+0.09154+'=>'+latitud+0.003184)
                        var ouer =gcj02tobd09(longitude,latitude);
                        // alert(ouer);
                        var ouercoordinate=ouer.join("-")

                        console.log(ouer)
                        lng=ouer[0]
                        lat=ouer[1]
                        console.log(lng+','+lat);
                       sessionStorage.setItem("coordinate", ouercoordinate);   
            },
            cancel: function (res){ 

            },
            fail: function (res){

            }
          })
    });
}
$(function(){

    $('.list:eq(0) a').click(function(event) {
       // alert(lng+','+lat);
        var category_id= $(this).find('.content').attr('data');


       // var category_id=
     location.href="/index.php/water-shop/agent-shop?category_id="+category_id+"&lat="+lat+"&lng="+lng; 
     
    })


	$('.list:eq(1) a').click(function(event) {
         
		var _this_href = $(this).attr("href");
		if(_this_href== "javascript:void(0);" ){
			        var html = '<div id="conter" style="padding-bottom: 50px;width: 100%;position: relative;">'  ;
        html+='<div class="empty_goods">'  ;
        html+='<div style="width:110px;margin:0 auto;margin-top:60px;">'  ;
        html+=' <p style="text-align:center;font-size:25px;color:#000;margin-bottom:10px;width: 200px;margin-left: -35px;line-height: 35px;">即将上线!</p>';
        html+=  '<img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>'  ;
        html+='</div>'  ;
        html+=' </div>'  ;
        html+='<div  id="imgUrl" style="margin-top:0px">'  ;
        html+='</div>' ;
        html+='</div>';
// console.log()
// $(".conter").html(html)
 //信息框
  layer.open({
    content: html
    ,btn: '确定'
  });
		}
	});
})
   </script>
</html>