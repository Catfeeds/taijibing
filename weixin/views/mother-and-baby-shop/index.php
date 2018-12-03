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
		    height:80px;
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
		height:30px;
	}
</style>
<body>
    <div class="list">
    	  <div class="list_head">
    	  	  太极兵服务
    	  </div>
    	  <div class="list_body">
    	   	<a href="/index.php/mother-and-baby-shop/list" >
    	  	  <div class="content">
    	  	  	    <div class ="img">
    	  	  	    	<img src="/static/images/Water_drop.png" >
    	  	  	    </div>
    	  	  	    <p>水</p> 
    	  	  </div>
    	  	  </a>
    	  	  <div class="content">
    	  	  	   <div class ="img">
    	  	  	    	<img src="/static/images/Ellipsis1.png"  height=30px 	>
    	  	  	    </div>
    	  	  	    <p>敬请期待</p> 
    	  	   </div>
    	  	  <div class="content"> </div>
    	
    	  	  <div style="clear:both ">
    	  	  	
    	  	  </div>
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
 var $saoma_datas=<?=json_encode($saoma_datas)?>;
console.log($saoma_datas)
if($saoma_datas){
     wx.config({
      debug: false,
      appId: $saoma_datas.appId,
      timestamp:$saoma_datas.timestamp,
      nonceStr:$saoma_datas.nonceStr,
      signature: $saoma_datas.signature,
      jsApiList: [ 'getLocation' ]
    });
                  wx.ready(function () {
                      wx.getLocation({
                        type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                        success: function (res) {
                        },
                        cancel: function (res) {
                        },
                        fail: function (res) {
                        }
                      })
                  })
}

$(function(){
	$('a').click(function(event) {
		var _this_href = $(this).attr("href");
		if(_this_href== "javascript:void(0);" ){


			        var html = '<div id="conter" style="padding-bottom: 50px;width: 100%;position: relative;">'  ;
        html+='<div class="empty_goods">'  ;
        html+='<div style="width:110px;margin:0 auto;margin-top:60px;">'  ;
        html+=' <p style="text-align:center;font-size:25px;color:#000;margin-bottom:10px;width: 200px;margin-left: -35px;line-height: 35px;">即将上线!</p>'  ;
        html+=  '<img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>'  ;
        html+='</div>'  ;
        html+=' </div>'  ;
        html+='<div  id="imgUrl" style="margin-top:0px">'  ;
        html+='</div>'  ;
        html+='</div>'  ;
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