<!DOCTYPE html>
<html>
<head>
	<title>修改商品分类</title>
</head>

 <link rel="stylesheet" href="./static/css/chosen.css?v=1"/>
      <link rel="stylesheet" type="text/css" href="./static/css/conmones.css?v=1">
 <script type="text/javascript" src="./static/js/jquery.min.js"></script>
 <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<style type="text/css" media="screen">
	td:first-of-type{
		width:20%;
		text-align:right;    background-color: transparent;
	}
	td:last-of-type{
		width:80%;
		text-align:left;
		padding-left:20px;    background-color: transparent;
	}
	.inp,#dept{
    width: 250px;
    background-color: #2D3136;
    border: 1px solid #2D3136;
    height: 30px;
    color: #fff;
    padding: 5px;
    border-radius: 2px;line-height: 20px;
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
<body style="    padding: 30px;">
	<form action="./index.php?r=goods-type/edit" method="post" accept-charset="utf-8">
      <a href="./index.php?r=goods-type/index<?=$url?>"><p class="Return">返回</p></a>
       <table style="width:500px;height:100px;">
    	<caption>修改商品分类</caption>
    	<tbody>
    		<tr>
    			<td >上级分类</td>
    			<td>
    				<select  name="" style="width:250px;" id="dept" class="parent_id"> 
              		<option  value='0' >顶级分类</option>		   
					  </select>
    			</td>
    		</tr>
    		<tr>
    			<td>分类名字</td>
    			<td><input  class='inp inputy' type="text" name="name" value="" placeholder="请输入分类名称"></td>
    		</tr>
    	</tbody>
    	 <div  style='display: none'>
    	<input type="text" name='parent_id' value='' class='parent'>
    	 <input type="text" name='level' value='' class="level">
 	     <input type="text" name='type1_id' value='<?=$type1_id?>' >
    	 <input type="text" name='type2_id' value='<?=$type2_id?>' >
    </div>
    </table>  
    <div class='tail'>
    	<input class='inp' type="submit" style='width:50px;' value="保存" >
    </div>
	</form>
</body>
<script> 
  var data=<?=json_encode($datas)?>;
  var types=<?=json_encode($types)?>;
console.log(data)
console.log(types)
   if(types.length){
  for(var i=0;i<types.length;i++){
  		$("#dept").append(' <option   data-id="'+types[i].Id+'"  data-Level="'+types[i].Level+'"  value="'+types[i].Id+'">'+types[i].Name+'</option>')
  }
     $('.inputy').val(data[0].Name);

      var _this = $('.parent_id');

      $('.inputy').val(data[0].Name);  

      $(".level").val(data[0].Level)


      _this.val(data[0].ParentId)


    _this.attr("disabled", "disabled") .chosen({no_results_text: "没有找到",disable_search_threshold: 10,search_contains: true,}); 
//       _this.prop('disabled', true).trigger("chosen:updated");
      }
$(".inputy").change(function(event) {
	    var name =$("#dept  option:selected").val();
    	 var parent_id =$("#dept  option:selected").attr('data-id')||'';
   		var Level =$("#dept  option:selected").attr('data-Level')||"";
   		$(".level").val(Level)
   		$(".parent").val(name)	  
});
</script>
</html>