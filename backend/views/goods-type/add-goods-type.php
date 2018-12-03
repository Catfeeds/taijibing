<!DOCTYPE html>
<html>
<head>
	<title>创建商品分类</title>
</head>

 <link rel="stylesheet" href="./static/css/chosen.css"/>

 <script type="text/javascript" src="./static/js/jquery.min.js"></script>
 <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
     <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
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
	select, .chosen-container {
    width: 250px !important;
    height: 30px;
    min-width: inherit !important;
    border: none;
}
</style>
<body>
	<form action="./index.php?r=goods-type/add-goods-type" method="post" accept-charset="utf-8">
	     
        <a href="./index.php?r=goods-type/index<?=$url?>"><p class="Return">返回</p></a>
       <table style="width:650px;height:100px;">
    	<caption>创建商品分类</caption>
    
    	<tbody>
    		<tr>
    			<td >上级分类：&nbsp;</td>
    			<td>
    				<select  name="parent_id"  style="width:250px;" id="dept" class="parent_id"> 
					    <option  value="0" >顶级分类</option>
					</select>
    			</td>
          <!-- <td colspan="" rowspan="" headers=""><p>当不选择上级分类时自动为顶级分类</p> </td> -->
    		</tr>

    		<tr>
    			<td>分类名称：&nbsp;</td>
    			<td><input  class='inp  inputy' type="text" name="name" value="" placeholder="请输入分类名称"></td>
            <!-- <td colspan="" rowspan="" headers="">  </td> -->
    		</tr>
    	</tbody>
    	    <div style="display:none" >
          	<input type="text" name='level' value='0' class="level">
          </div>
    </table>
    <div class='tail'>
    	<input class='inp submit' type="submit" style='width:50px;' value="保存" >
    	<p class='Reset'  style="cursor: pointer;width:50px;display: inline-block;"> 重置</p>
    </div>
	</form>
</body>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>	
<script> 
  var data=<?=json_encode($parent)?>;
  //console.log(data)
  if(data.length){
  	   for(var i=0;i<data.length;i++){
  	       	$("#dept").append(' <option  data-id="'+data[i].Id+'"  data-Level="'+data[i].Level+'"  value="'+data[i].Id+'">'+data[i].Name+'</option>')
        }


  	      $('.parent_id').chosen({
		        no_results_text: "没有找到结果！",//搜索无结果时显示的提示
		        placeholder_text_single:"无"
		   });
       var  _this = $('.parent_id');
          $(".Reset").click(function(event) {
             _this.val(0).trigger("chosen:updated");;
      });
      }
$(".submit").click(function(event) {

	 if($(".parent_id").val()==''){
	 	layer.msg('分类不能为空');
	 	 return false;
	 }

	 if($(".inputy").val()==''){
	 	layer.msg('分类名不能为空');
	 	 return false;
	 }
	 
});

$(".parent_id").change(function(event) {
	    var name =$("#dept  option:selected").val();
    	var parent_id =$("#dept  option:selected").attr('data-id')||'';
   		var Level =$("#dept  option:selected").attr('data-Level')||"";
   		$(".level").val(Level)

});

</script>
</html>