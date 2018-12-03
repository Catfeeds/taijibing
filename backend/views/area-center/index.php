<!DOCTYPE html>
<html>
<head>
	<title>片区中心</title>
	 	<link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
           <link rel="stylesheet" href="./static/css/Common.css"/>
	<!-- <link rel="stylesheet" type="text/css" href="./static/css/conmones.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="./static/css/conmones2.css"> -->
	<link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="./static/css/Common.css?v=1.0"/>
<style type="text/css" media="screen">
        .table {

    margin-top: 20px;
}
select{
	width:100px;
}
.chosen-container .chosen-results li.highlighted {
    background-color: rgb(228,96,69);
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(20%, rgb(228,96,69)), color-stop(90%, rgb(228,96,69)));
    background-image: linear-gradient(rgb(228,96,69) 20%, rgb(228,96,69)c 90%);
    color: #fff;
}


</style>
</head>
<body>
	    <div class="wrapper wrapper-content"> 
	    	<div style="margin-bottom:10px;" class='condition'>
	            <form action="/index.php?r=area-center/index" method="post">
	                <span><label>关键字:</label><input type="text" placeholder="请输入名称" id="username" name="name" value=""/></span>
	                <span style="padding-left:10px;"><label>手机号:</label><input type="text" placeholder="请输入手机号" id="mobile" value="" name="tel_loginname"/></span>
	                <label style="padding-left:10px;">地区:</label>
	                <select class="control-label" name="province"  id="province" class="province">
	                            <option value="" selected>请选择省</option>
	                </select>
	                <select class="control-label" name="city" id="city"  class="city">
	                     <option value="">请选择市</option>
	                </select>
	                <select class="control-label" name="area" id="area"  class="area">
	                  <option value="">请选择区</option>
	                </select>
	             <input type="submit" class="btn" value="查询"  style="background: #e46045; color: white;height: 26px;line-height: 14px;padding-left: 10px;margin-top: 0px;      margin-left: 20px;  border: none;"/>
	            </form>
	        </div>
	        <table class="table table-hover" style="margin-top: -20px;"> 
	        	 <thead> 
	        	 	<tr>  
						<th>序号</th>
		        	 	<th>登录账号</th>
		        	 	<th>名称</th>
		        	 	<th>所在区域</th>
		        	 	<th>地址</th>
		        	 	<th>联系人</th>
		        	 	<th>联系电话</th>
		        	 	<th id='sort' data='0'><a href="javascript:void(0)" >最近操作时间</a></th>

	        	 	</tr>
	        	 	
	        	 </thead>
	        	 <tbody id="areaBody">
	        	 	   
	        	 </tbody>



	        </table>

	    </div>

<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
		<div id="page" class="page_div"></div>
</div>
</body>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="/static/js/Common2.js"></script>

        <script>
        var datas  = eval('(' + <?=json_encode($datas)?> + ')'); 
        var data = datas.address;
        var where = datas.where;
 		console.log(where)		
        $(function(){
            //  initProvince();
            // initListener();
             initAddress();
            rendering(datas.datas)
          
        });

  addressResolve(data,where.province,where.city,where.area)

function initAddress() {
            $("#username").val(where.name);
            $("#mobile").val(where.tel_loginname);
        }



var sort_data= $("#sort").attr("data");
$("#sort").click(function(){
     sort_data++;
     if(sort_data>1){
     	sort_data=0
     }
     $("#sort").attr("data",sort_data);


			var searchParameters = {
		        province: where.province,
		        city: where.city,
		        area: where.area,
		        name: where.name,
		        tel_loginname: where.tel_loginname,
		        sort:$("#sort").attr("data"),
		    }
				Get_datas(searchParameters)
})
	//分页
		$("#page").paging({
			pageNo:1,
			totalPage: Math.ceil(datas.total / 10),
			    totalLimit: 10,
			  totalSize: datas.total,
			 callback: function(num, nbsp) {
			if(!num){
				num=1
			}
			var searchParameters = {
		        province: where.province,
		        city: where.city,
		        area: where.area,
		        name: where.name,
		        tel_loginname: where.tel_loginname,
		        offset: num * nbsp - nbsp,
		        sort:$("#sort").attr("data"),
		        limit: nbsp
		      }
			Get_datas(searchParameters)

			}
		})

function Get_datas(searchParameters){

      var ii = layer.open({
      type: 1,
      skin: 'layui-layer-demo', //样式类名
      closeBtn: 0, //不显示关闭按钮
      anim: 2,
      shadeClose: false, //开启遮罩关闭
      content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
    });

	  $.post("./index.php?r=area-center/get-page",searchParameters, function(obj){
            var sales_detail=	eval('(' + obj + ')');
	        rendering(sales_detail.datas)
			layer.close(ii);

			      })
			}
     function rendering (dataobj){
           
         if(dataobj){
         	
         	       $("#areaBody").empty();
         	       var j = 0;
    		for (var i = 0; i < dataobj.length; i++) {
    			  var item = dataobj[i];
    			  for (var z in item) {
			        if (item[z] == null) {
			          item[z] = '--'
			        }
			      }
			     j++
			    var html = '<tr><td>'+j+'</td>';
			    html += '<td>'+item.LoginName  +'</td>'
			    html += '<td>'+item.Name  +'</td>'
			    html += '<td>'+item.Province +'-'+item.City +'-'+item.Area +'-</td>'
			    html += '<td>'+item.Address  +'</td>'
			    html += '<td>'+item.ContractUser  +'</td>'
			    html += '<td>'+item.ContractTel  +'</td>'
			    html += '<td>'+item.RowTime  +'</td>'
 				html += '</tr>';
          		$("#areaBody").append(html);
    		}
         }
     }


    </script>
</html>