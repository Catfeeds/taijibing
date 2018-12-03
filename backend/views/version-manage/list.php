<!DOCTYPE html>
<html>
<head>
  <title>版本控制</title>
  <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
  <link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
  	<link rel="stylesheet" href="/static/css/chosen.css"/>
  <!-- <link rel="stylesheet" type="text/css" href="/static/css/conmones.css"/> -->
      <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>
  <link rel="stylesheet" type="text/css" href="/static/css/version-manage/index.css"/>
</head>
<style type="text/css">
	.condition {
    background-color: #393E45;
    margin-top: 20px;
    padding: 15px;
    border-radius: 4px 4px 0 0;
}
.chosen-container-active, .chosen-container {
    width: inherit !important;
     min-width: 100px; 
}
#upload{
background-color: rgb(66, 73, 82); color: rgb(255, 255, 255);padding:5px 10px;	
}
#upload:hover{
	background-color: rgb(201, 48, 44)
}

.popupa {
    width: 100%;
    height: 100%;
    background-color: #393E45;
    border-top: 3px solid #E46045;
    text-align: center;
    padding-top: 100px;
}
.popupa .butt {
    padding: 10px;
}
.popupa button, .popupa .submitBtn button {
    width: inherit;
    font-size: 18px;
    color: rgb(233,233,233);
    border-radius: 5px;
    margin-top: 65px;
    background-color: #4ADCDD;
    border: none;
        padding: 5px 15px;
}
</style>
<body>
  <div id='home'>
  	<div class='condition'>
    <form action="./index.php?r=version-manage/dev-manage-list" method="post" accept-charset="utf-8">
          
                <label> 设备类型：</label>
                <select id="type_id" name="type">
					<option value="" selected="selected">请选择</option>
				</select>
				<label style="margin-left: 10%;"> 版本号：</label>
                <select id="version" name="version">
					<option value="" selected="selected">请选择</option>
				</select>
				<input style="padding-left:10px;    margin-left: 20px;" type="submit" value="查询" id="btn">
      

    </form>
		<div class="selection btnbatch" style="min-width:230px;margin-top: 20px;height: 30px">
		      <p id="upload" style="">
		      	<!-- <img src="/static/images3/batchPromoteImg.png" alt="">  -->
		      上传版本文件</p>
		</div>  
  </div>
    <table class="table" style="width: 100%;">
    	<thead>
    		<tr>
    			<th>序号</th>
    			<th>设备类型</th>
    			<th>版本号</th>
    		  <th><span class="sort" style="color:#E46045;    cursor: pointer;  ">添加时间</span></th>
    		</tr>
    	</thead>
    	<tbody id="tableData">
    	<!-- 	<tr>
    			<td>001</td>
    			<td>1</td>
    			<td>24</td>
    			<td>data</td>
    		</tr> -->
    	</tbody>
    </table>

  </div>
  <div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
    <div id="page" class="page_div"></div>
</div>
</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script> 
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>
<script type="text/javascript" src="/static/js/monthPicker.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script> 
<script type="text/javascript" src="/static/js/Common2.js?v=4"></script>

<script type="text/javascript">

  var iy =  layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });

	var data = {
		 select_type:jQuery.parseJSON(<?=json_encode($select_type)?>),
		 select_version:jQuery.parseJSON(<?=json_encode($select_version)?>),
		 type_Id:'type_id',
		 version_Id:'version',
		 where:{
	        _type:<?=json_encode($type)?>,
	        version:<?=json_encode($version)?>
	     }
   	}
var sort = jQuery.parseJSON(<?=json_encode($sort)?>);
var datas = jQuery.parseJSON(<?=json_encode($datas)?>);
var total = <?=json_encode($total)?>
  


$(".sort").click(function(){
     sort++;
  if(sort>1){
    sort=0
  }
     var Url = location.href.split("sort")[0];
     console.log(Url);
     if(Url.indexOf('&')==-1){
    location.href=Url+'&sort='+sort;
     }else{
        location.href=Url+'sort='+sort;
     }
     
})
   addressSelect(data)
$("#upload").click(function(event) {
	/* Act on the even */
	 // var html = '<div style="padding:15px;"><label> 上传版本文件：</label><input type="text" name="" value="" placeholder=""><div>'
	var  html = '<form action="/index.php?r=version-manage/upload-upgrade" method="post" enctype="multipart/form-data"  style="height:100%"> ';
	     html +='<div class="popupa">';
		 html +='<div class="popup-text">';

		// html +='<div style="padding:15px;"><label> 上传版本文件：</label>';
		// html +='<input type="text" id="file_name" readonly="readonly" value="5" name="OPOP" placeholder="选择版本文件" /><a href="javascript:void(0);" class="input">选择文件  <input type="file" id="file"  multiple="multiple"  name="file[]" value=""  ></a>
		    html += '<p>选择上传文件: '
 			html += '<input type="text" id="file_name" readonly="readonly" value="" placeholder="选择版本文件" /> '
 			html += '<a href="javascript:void(0);" class="input">选择文件  <input type="file" id="file"  name="file[]" value=""  multiple ></a>'
 			html += '</p>'
	
	//      html +=' <div>';

		  html +='</div>' +
			'<div class="butt pull-left" style="margin-left:30%;">' +
			'<button type="button"  class="Close">取消</button>' +
			'</div>' +
			'<div  class="butt">' +
			'<button type="submit" class="confirm" style="background-color: #E46045;  margin-right:30%;  float: right;" >确认</button>' +
			' </div>' +
			'<p style="clear:both "></p> ';
			html +='</div>';
			html +='</form>'
 layerdatefun(html)






 //弹窗
 function layerdatefun(html) {
		//页面层-自定义
		var uploadii = layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: ['600px', '350px'],
		  shadeClose: true,
		  skin: 'yourclass',
		  content: html
		});
	 	$('.Close').click(function() {
	 		layer.close(uploadii);
	 	})
		$('.confirm').click(function() {
	 	    // layer.close(uploadii);
	 		var file = $("#file").val()
	 		if(!file){
	 			layer.msg('请先选择上传文件包');
	 			return false;
	 		}

	 	})

 	var input = document.getElementById("file");
 	var result, div;
 	if (typeof FileReader === 'undefined') {
 		result.innerHTML = "抱歉，你的浏览器不支持 FileReader";
 		input.setAttribute('disabled', 'disabled');
 	} else {
 		input.addEventListener('change', readFile, false);
 	}
 	function readFile() {
 		var filesLength = this.files.length
 		if (filesLength > 3) {
 			// alert("上传数量超限")
 			layer.msg('上传数量超限');
 			return false;
 		}
 		for (var i = 0; i < filesLength; i++) {
 			if (!input['value'].match(/.bin|.ini/i)) {　　 //判断上传文件格式
 				layer.msg('上传的格式不正确，请重新选择');
 				return //     alert("上传的格式不正确，请重新选择")
 			}
 			var reader = new FileReader();
 			reader.readAsDataURL(this.files[i]);
 		}
 		$("#file_name").val('已选择' + this.files.length + '个文件'); //将 #file 的值赋给 #file_name
 	}
 }
});
	if(datas.length){
	   dev_listdata(datas,1) 
	}else{
       layer.close(iy);
  }

  function dev_listdata(dataObj,num) {
       var j = 0;
      $("#tableData").empty();

      

    for (var i = 0; i < dataObj.length; i++) {
    	var item = dataObj[i]
	    j++
      // ((num-1)*10 + j)*1
	    var html = '<tr><td>'+ j +'</td>';
			html += '<td>'+item.Type+'</td>';
			html += '<td>'+item.Version+'</td>';
			html += '<td>'+item.RowTime  +'</td>';

	  $("#tableData").append(html);
    }

     layer.close(iy); 
  }

  $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(total / 10),
    totalLimit: 10,
    totalSize:total,
    callback: function(num, nbsp) {
      var searchParameters = {
        type: data.where._type,
        version: data.where.version,
        offset: num * nbsp - nbsp,
        limit: nbsp
      }
      Get_datas(searchParameters,num)
      // console.log(searchParameters)
      // console.log(nbsp)
    }
  })



function  Get_datas(searchParameters,num){
     var ii =   layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    // shade: [0.8, '#000'],
    shadeClose: false, //开启遮罩关闭
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });

  $.post("./index.php?r=version-manage/list-page", searchParameters, function(data){
       layer.close(ii); 
       var data = jQuery.parseJSON(data);
       // console.log(data)
      var sales_detail=data.datas
         dev_listdata(sales_detail,num)
  })
}


</script>


</html>