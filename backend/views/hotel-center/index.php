<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>酒店管理</title>
       <!-- <link rel="stylesheet" href="/static/css/style.min862f.css"/> -->

	<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
       <link rel="stylesheet" href="/static/css/chosen.css"/>
      <link rel="stylesheet" href="/static/css/Common.css"/>
      <style type="text/css" media="screen">
		
		.search span label{
			width:60px;
			margin-top: 5px;
		}
		table{width:100%;   
			border-collapse: separate;    
			margin-top: -20px;
			border-spacing: 0 15px;}
		table td,table th{
			text-align: center;    
			line-height: 1.42857;
			padding: 8px;
		}
		thead {
			background-color: #292834;
		}
</style>;
</head>;
<body>
	<div class="wrapper wrapper-content">
        <div class="search">
        	<div style="margin-bottom:10px;" class="condition">
	            <form action="/index.php?r=hotel-center/index" method="post">
	                <span><label>名称:</label>
	                	<input type="text" placeholder="请输入名称" id="search" name="search" value=""/>
	                </span>
	                <span style="padding-left:10px;">
	                	<label>手机号:</label><input type="text" placeholder="请输入手机号" id="login_name" value="" name="login_name"/>
	                </span>
	                
	                <div class="multiple-choice" style="border:none;background:none;    display: initial;    line-height: 60px;margin-left: 5%">
	                    <label style="    margin-top: 20px;width: 75px;">地区:</label>
	                    <select class="control-label" name="province"  id="province">
	                        <option value="" selected>请选择省</option>
	                    </select>
	                    <select class="control-label" name="city" id="city">
	                        <option value="">请选择市</option>
	                    </select>
	                    <select class="control-label" name="area" id="area">
	                        <option value="">请选择区</option>
	                    </select>
	                     <input type="submit" class="btn" value="查询"/ style="background: #e46045; color: white;height: 26px;line-height: 14px;padding-left: 10px;margin-top: -5px;    border: none;    margin-left: 15%;">
	                </div>
	            </form>
	        </div>
        </div>
        <table>
        	<thead>
        		<tr>
        			<th>序号</th>
        			<th>登录账号</th>
        			<th>名称</th>
        			<th>所在区域</th>
        			<th>地址</th>
        			<th>联系人</th>
        			<th>联系电话</th>
        			<th>运营中心</th>
        			<th>片区中心</th>
        			<th>最近操作时间</th>
        			<th>登记/设置</th>
        		</tr>
        	</thead>
        	<tbody id='datatBox'>
        		 <tr>
        			<!-- <td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td>
        			<td>data</td> -->
        		</tr>
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
	<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script> 
	<script type="text/javascript" src="/static/js/Common2.js"></script> 
	<script type="text/javascript" src="/static/js/paging3.js"></script>
<script>
	
	 var address =<?=json_encode($address)?>;
	 var total =<?=json_encode($total)?>;

	 var search_where  =jQuery.parseJSON(<?=json_encode($search_where)?>) ;
  	 var data =<?=$data?>;
      console.log(data)
      console.log(search_where)




// console.log(search_where)

// $("table  td a").click(function(){
//     var _thisURl = $(this).attr('href');
//       var Urlobj = encodeURIComponent('province='+search_where.province+'&city='+search_where.city+'&area='+search_where.area+'&search='+search_where.search+'&login_name='+search_where.login_name);
//    console.log(Urlobj)
//     $(this).attr('href',_thisURl+"&Url="+Urlobj)
//     // alert(1)
//     // return false;
// })




		for(var i in search_where){
			if(!search_where[i]){
				search_where[i]=''
			}
		}
	                 // 地址渲染方法
	      addressResolve(address,search_where.province,search_where.city,search_where.area);
	if(search_where.search){$("#search").val(search_where.search)}
	if(search_where.login_name){$("#login_name").val(search_where.search)}

dev_listdata(data)



// 分页
  $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(total / 10),
    totalLimit: 10,
    totalSize: total,
    callback: function(num, nbsp) {
    	// alert(num)
      var searchParameters = {
        search: search_where.search,
        login_name: search_where.login_name,
        province: search_where.province,
        city: search_where.city,
        area: search_where.area,
        offset: num * nbsp - nbsp,
        limit: nbsp
      }
      Get_datas(searchParameters,num,nbsp)
       // console.log(searchParameters)
    }
  })
  function  Get_datas(searchParameters,num,nbsp){
     var ii =   layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    shadeClose: false, //开启遮罩关闭
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });
  $.post("/index.php?r=hotel-center/page", searchParameters, function(data){
       layer.close(ii); 
       var obj = jQuery.parseJSON(data)
       console.log(obj)
       dev_listdata(obj.data,num,nbsp)
      // var sales_detail=data[0].sales_detail
         // dev_listdata(sales_detail,num)
  })
}

function dev_listdata(dataObj,num,nbsp){
 var num=num||1;
 var nbsp =nbsp||10;
 // console.log(nbsp)
$("#datatBox").empty()
if(dataObj){
	for(var i=0;i<dataObj.length;i++){
		var item = dataObj[i];
      var  html='<tr>';
      for(var z in item){
      	if(!item[z]){
      		item[z]='-'
      	}
      }
        html+='<td>'+((num-1)*(nbsp)+i+1)+'</td>';
        html+='<td>'+item.LoginName+'</td>';
        html+='<td>'+item.Name+'</td>';
        html+='<td>'+item.Province+ '-' +item.City + '- '+item.Area+'</td>';
        html+='<td>'+item.Address+'</td>';
        html+='<td>'+item.ContractUser+'</td>';
        html+='<td>'+item.ContractTel+'</td>';
        html+='<td>'+item.YyName+'</td>';
        html+='<td>'+item.PqName+'</td>';
        html+='<td>'+item.RowTime+'</td>';
        html+='<td> <a href="./?r=logic-user/select-dev&agent_id='+item.Id+'&name='+item.Name+'&province='+item.Province+'&city='+item.City+'&area='+item.Area+'&page=1">查看/编辑</td></a> ';
        html+='</tr>';
        $("#datatBox").append(html)
	   }
  }    
}

var url='';
for(var i in search_where){
  if(search_where[i]==null){
     search_where[i]=''
  }
  if(i!='offset'&&i!='limit'){
      url= url +"&"+ i+'='+ search_where[i];
  }
}
$(document).on('click',"#datatBox a",function(){
      var _thisURl = $(this).attr('href');
      var Urlobj = encodeURIComponent(url);
      console.log(Urlobj)
      $(this).attr('href',_thisURl+" &Url=" +Urlobj);
      console.log(_thisURl+" &Url="+Urlobj)

   // return false;
})



</script>
</html>