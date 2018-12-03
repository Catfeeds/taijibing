<!DOCTYPE html>
<html>
<head>
	<title>创建商品分类</title>
</head>

 <link rel="stylesheet" href="./static/css/chosen.css"/>

 <script type="text/javascript" src="./static/js/jquery.min.js"></script>
 <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<style type="text/css" media="screen">
	td:first-of-type{
		width:20%;
		text-align:right;
	}
	td:last-of-type{
		width:80%;
		text-align:left;
		padding-left:20px;
	}
	.inp{
    width: 250px;
    background-color: #2D3136;
    border: 1px solid #2D3136;
    height: 30px;
    color: #fff;
    padding: 5px;
    border-radius: 2px;
}
.tail{
width:100%;
		    display: inline-box;
		    display: -webkit-inline-box;
}

.tail p{
		margin:0;
		margin-left:10px;
		padding:5px 10px;
		background:#2D3136;
		border-radius: 5px;
		color:#fff;
	}
	.tail *:hover{
		background:#42474e;
	}
	.Return{
		    display: inline-block;
    text-align: center;
    border: none;
    color: #fff;background-color: #E46045;
    padding: 5px 15px;
    border-radius:5px;
    float:right;
	}
</style>
<body>
	
	     
      <a href="javascript:history.go(-1)"><p class="Return">返回</p></a>
       <table style="width:500px;height:100px;">
    	<caption>创建品牌</caption>
    
    	<tbody>
    		<tr>
    			<td>品牌名字</td>
    			<td><input  class='inp  inputy' type="text" name="name" value="" placeholder="请输入分类名称"></td>
    		</tr>
    	</tbody>

    	 <div style="display:none" >

    	<input type="text" name='level' value='0' class="level">

    	
    </div>
    </table>
   
    <div class='tail'>
    	<input class='inp submit' type="submit" style='width:50px;' value="保存" >
    	<p class='Reset'> 重置</p>
    	
    </div>


</body>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>	
<script> 
    var category1_id =<?=json_encode($category1_id)?>;
    console.log(category1_id)

$(".submit").click(function(){
   var inputy= $('.inputy').val();
    $.post('index.php?r=goods/create-brands', {'category1_id':category1_id,'BrandName': inputy}, function(data) {
        
    });
})
$(".Reset").click(function(event) {
  $('table input,select').val('');
    $('.dept_select').val('');




});



</script>
</html>