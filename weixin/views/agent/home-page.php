<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>太极兵智能饮水机</title>

	<link rel="stylesheet" href="">
	<style type="text/css" media="screen">
		.text{
		width: 150px;
		margin: auto;
		margin-top: 50%;
		text-align: center;
		}
	</style>
</head>
<body>
	<div class="text">
		<p>设备连接中。。。</p>
		<p>请稍后(*^_^*)   </p>
		<p style="font-size: 18px;margin-top:25%;font-weight: bold;color: #f30707;"> 倒计时 ：<span id='date'>60</span>s</p>
	</div>	
</body>
<script>
	var interval2 = window.setInterval(function(){		
			var textIndex = document.getElementById('date').innerHTML;
                textIndex--
			  console.log(textIndex)
			 if(textIndex<=0){
			 	window.location.href="no-networking";
                window.clearTimeout(interval2);
             }
			 document.getElementById('date').innerHTML = textIndex
	},1000); //  每隔5秒执行一次funcName()
</script>
</html>