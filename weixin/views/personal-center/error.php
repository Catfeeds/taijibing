<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	
</body>
</html>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script>
	var msg = <?=json_encode($msg) ?>;
    //信息框
    layer.open({
      content: msg
      ,btn: '确定'
       ,shadeClose: false
      // ,anim: 'up'
      ,yes: function(index){
           window.location.href='/index.php/personal-center/drink-monitor';
      }
    });
</script>