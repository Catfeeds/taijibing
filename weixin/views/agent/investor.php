


<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <title>设备详情</title>
   <body>
    	<style type="text/css">
    		#equipment tr{
    		height: 50px
    		}
    	</style>
    
<div id="equipment" style="text-align: center;padding: 0;margin: 0">
	<!-- <header style="text-align: center;background-color:#F8F8F8;padding: 15px;margin: 0;border-bottom: 1px #BBBBBB solid; ">
		<a href="javascript:history.back(-1);" class="glyphicon glyphicon-remove" style=" color:#000 ;float: left;"> 
			<img src="/static/images/bose.png" alt="关闭">
		</a>
		<h3 style="  display: initial;">设备详情</h3>
	</header> -->
	<table style="text-align: center;width: 100% ;margin-top:10px">
		<thead>
			<tr>
				<th>商品品牌</th>
				<th>商品型号</th>
				<th>区域/数量</th>
			</tr>
		</thead>
		<tbody>
		 
		</tbody>
	</table>
</div>
</body>

    <script type="text/javascript" src="/static/js/jquery.min.js" ></script>
	<script>
		     window.onload=function(){
		     var info = localStorage.getItem('userInfo');
		            var infoi = JSON.parse(info);
		            
		             if(infoi.result.level==5){
		                   $("title").text('设备列表');
		                   $('#equipment table  th').eq(0).text('用户姓名');
		                   $('#equipment table  th').eq(1).text('设备编号');
		                   $('#equipment table  th').eq(2).text('设备状态');
		             }
		              if(infoi.result.level==6){
		              	$("title").text('投资设备详情');
		                   $('#equipment table  th').eq(0).text('品牌名称');
		                   $('#equipment table  th').eq(1).text('设备商品型号');
		                   $('#equipment table  th').eq(2).text('区域/数量');
		              }
		     	     var  data=<?=json_encode($data) ?>;
	                 if(data.result){
	                	for(var i =0;i<data.result.length;i++){
	                 var html = '<tr><td>'+data.result[i].brandname+' </td><td>'+data.result[i].goodsname+'</td><td>'+data.result[i].area +' <br/>'+
	                 ''+data.result[i].count + '</td></tr>'
	              		$("tbody").append(html)
			     	   }
	               }
		     }
	</script>

</head>
</html>