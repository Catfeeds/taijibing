<!DOCTYPE html>
<html>
<head>
  <title>版本管理</title>

  <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
  <link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>
  <link rel="stylesheet" type="text/css" href="/static/css/version-manage/index.css?v=1"/>
</head>
   <style type="text/css" media="screen">
   .page-head {
    background-color: #393E45;
    padding: 35px;
    padding: 3.5rem;
    border-radius: 4px 4px 0 0;
    -moz-box-shadow: 0px 0px 10px 1px #000;
    -webkit-box-shadow: 0px 0px 10px 1px #000;
    box-shadow: 0px 0px 10px 1px #000;
}
	   .dropdown-menu{
	    max-height: 250px;
	    overflow: auto;
	  }
.ta_date, .date_title {
    background-color: #2D3136;
}
#date_demo {
    width: 200px;
    height: 30px;
    line-height: 30px;
    line-height: 15px;
    background-color: #2D3136;
    border: none;
    display: inline-block;
}
.head-txt{
	margin-top:20px;
}
select{
	height:30px;
	min-width: inherit;
}
.selection-text {
    line-height: 30px;
    width: 80px;
}
 .chosen-container-active,.chosen-container {
    width: inherit !important;
    /* min-width: 150px; */
}
.btnbatch p {
    padding: 8px 20px;
    border-radius: 5px;
    background-color: #424952;
    border: none;
    cursor: pointer;
    display: -webkit-inline-box;
    float: left;
}


   </style>
<body>
  <div id='home'>
        <!--内容主题-->
      <form action="./index.php?r=version-manage/index" method="post" accept-charset="utf-8">
	   <div class='page-head'>
			  <div class='head-txt'> 
			  	<!-- 时间容器 -->
			      <div class="selection pull-left">
			          <span  class="selection-text  pull-left">时&nbsp;&nbsp;间&nbsp;&nbsp;段：</span>
			         <div class="ta_date" id="div_date_demo">
			              <span class="date_title" id="date_demo"></span>
			              <a class="opt_sel" id="input_trigger_demo" href="#">
			                  <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
			              </a>
			          </div>
			          <input type="text" name="selecttime" id='selecttime1' value="" style="display: none">
			          <div id="datePicker"></div>
			      </div>
			       <!-- 地区容器 -->
			       <div class="selection pull-left" style="margin-left:1%">
					 <span  class="selection-text  pull-left">地区选择：</span>
					 <div class="region pull-left address" >
					 	   <div class="wrap_line">
					 	        <select class="control-label" name="province"  id="province" class="province">
		                            <option value="" selected>请选择省</option>
				                </select>
				                <select class="control-label" name="city" id="city"  class="city">
				                     <option value="">请选择市</option>
				                </select>
				                <select class="control-label" name="area" id="area"  class="area">
				                  <option value="">请选择区</option>
				                </select>
					 	   </div>
					 </div>

                    	
					 

			      </div>
			        <div class="selection pull-left" style="margin-left:1%">
			   <select class="control-label" name="state" id="state"  class="state" style="width:120px;">
			                  <option value="">全部升级状态</option>
			                  <option value="-1">未在升级</option>
			                  <option value="1">等待升级</option>
			                  <option value="2">升级中</option>
			                  <option value="3">升级完成</option>
			          </select>
                    </div>
                    <div	style="clear:both "></div> 
	 		 </div>
	<!-- 版本号 -->
	 		<div class='head-txt'>
	 			<!-- 设备 -->
      			<div class="selection pull-left">
       				 <span  class="selection-text  pull-left">设&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;备：</span>
       				  <div class="wrap_line"> 
       				  	 <select class="control-label" name="devbrand_id"  id="devbrand_id" class="devbrand_id">
                                <option value="" selected>请选择设备品牌</option>
                        </select>
                        <select class="control-label" name="devname_id"  id="devname_id" class="devname_id">
                                <option value="" selected>请选择设备型号</option>
                        </select>
                        <select class="control-label" name="select_type"  id="select_type" class="select_type">
                                <option value="" selected>请选择设备类型</option>
                        </select>
                        <select class="control-label" name="select_version"  id="select_version" class="select_version">
                                <option value="" selected>请选择设备版本号</option>
                        </select>
       				  </div>
       			</div>
       			<div	style="clear:both "></div> 
	 		</div>

	 		   <!-- 角色 -->
	 		<div class='head-txt'>
      			<div class="selection pull-left">
       				 <span  class="selection-text  pull-left">角&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;色 ：</span>
       				  <div class="wrap_line"> 
       				  	 <select class="control-label" name="devfactory_id"  id="devfactory_id" class="devfactory_id">
                                <option value="" selected>请选择设备厂家</option>
                        </select>
                        <select class="control-label" name="investor_id"  id="investor_id" class="investor_id">
                                <option value="" selected>请选择设备投资商</option>
                        </select>
                        <select class="control-label" name="agenty_id"  id="agenty_id" class="agenty_id">
                                <option value="" selected>请选择运营中心</option>
                        </select>
                        <select class="control-label" name="agentf_id"  id="agentf_id" class="agentf_id">
                                <option value="" selected>请选择服务中心</option>
                        </select>
       				  </div>
       			</div>
       			<div	style="clear:both "></div> 
	 		</div>
         <!-- 状态 -->
	 		<div class='head-txt'>
      			<div class="selection pull-left">
       				 <span  class="selection-text  pull-left">类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型 ：</span>
       				  <div class="wrap_line"> 
       				  	 <select class="control-label" name="customertype"  id="customertype" class="customertype">
                                 <option value="" selected>用户类型</option>
                                  <option value="1" >家庭</option>
                                  <option value="2" >公司</option>
                                  <option value="3" >集团</option>
                                  <option value="4" >酒店</option>
                                  <option value="99" >其他</option>
                        </select>
                        	
                         <select class="control-label" name="dev_state"  id="dev_state" class="dev_state">
                                <option value="1" selected>正常设备</option>
                                <option value="2" >未激活设备</option>
                        </select>
       				  </div>

       			</div>

       			<div	style="clear:both "></div> 
	 		</div>
	 		   <!-- ICCID -->
	 		<div class='head-txt'>
      			<div class="selection pull-left">
       				 <span  class="selection-text  pull-left">ICCID号段：</span>
       				  <!-- <div class="wrap_line">  -->
                            <input type="text" class="startIccid" name="start" value="" placeholder="请输入ICCID号段">-
                            <input type="text"  class="endIccid"  name="end" value="" placeholder="请输入ICCID号段">
       				  <!-- </div> -->
       			</div>
       			<div	style="clear:both "></div> 
	 		</div>
	 		   <!-- 搜索-->
	 		<div class='head-txt'>
      			<div class="selection pull-left">
       				 <span  class="selection-text  pull-left">搜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;索：</span>
       				  <!-- <div class="wrap_line">  -->
                          <input type="text" name="search" id="searchp" value="" placeholder="请输入搜索内容">
       				  <!-- </div> -->


       				   <!-- 条件按钮 -->
   
       			</div>
       			      <div class="submitBtn" s style='display: inline-block;    float: right;margin-right: 20%;' >
					        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					        <button type="submit" class="btn btn-danger" id="submit" >   查看</button>
					        &nbsp;&nbsp;
					        <button type="text"  class="btn btn-danger" id="removerSub">清空条件</button>
			           </div>
       			      <div	style="clear:both "></div> 
	 		</div>
	 		<div class='head-txt'>
		      <!-- 状态 -->
		        <div class="selection pull-left btnbatch" style='min-width:230px;'>
		              <p  id='batchPromote'><img src="/static/images3/batchPromoteImg.png" alt=""> 批量升级</p>
		              <p   id="AllEquipment" style='margin-left: 20px;'><img src="/static/images3/AllEquipmentImg.png" alt="" >  升级所有设备</p>  


				<!-- 	&nbsp;
					&nbsp;
					&nbsp;
					<div class="Notes" style="    display: inline-block; line-height: 35px;">
						 <span type="btn"  id="Refresh"   style='padding:10px;    cursor: pointer;'><img src="/static/images3/RefreshImg.png" alt="">  刷新</span>
				         &nbsp;
				          <span style="font-weight: bold;">（注释：
				            <span style="width: 50px;height:1px;text-decoration:line-through;color:#EE5030">&nbsp;&nbsp;&nbsp;</span>&nbsp; 等待升级 &nbsp; 
				            <span style="width: 50px;height:1px;text-decoration:line-through;color:#3EDADB">&nbsp;&nbsp;&nbsp;</span>&nbsp; 升级中 &nbsp; 
				          	 <span style="width: 50px;height:1px;text-decoration:line-through;color:#BC49CF">&nbsp;&nbsp;&nbsp;</span>&nbsp;升级完成 ）
				          </span>
					</div> -->
		       
		        </div>
		        <div	style="clear:both "></div> 
		      </div>
	  </div>





	</form>
  </div>
<table width="100%" class="table">
	<thead>
		<tr>
			 <th><input type="checkbox" name="statet" value="1" id="statet" class="state" onclick="swapCheck()">
    	    <label for="statet"></label></th>
			<th>
                
    		<!-- 	 <span>	</span> -->
				序号
			</th>
			<th>设备编号</th>
			<th>ICCID</th>
			<th>设备类型</th>
			<th>用户姓名</th>
			<th>手机号</th>
			<th>用户类型</th>
			<th>服务中心</th>
			<th>运营中心</th>
			<th>设备商品型号</th>

			<th>设备品牌</th>
			<th>设备厂家</th>
			<th>设备投资商</th>
			<th>所在区域</th>
			<th style='width: 10%;	'>位置信息</th>

			<th>下发时间</th>
			<th>结束时间</th>
			<th>升级完成时间</th>
			<th>设备联网时间</th>


			<!-- <th>升级时间</th> -->
			<th>设备版本号</th>
			<th>升级状态</th>
			<th>版本升级</th>
		</tr>
	</thead>
	<tbody   id='dev_list_body'>
	 
	</tbody>
</table>

	<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
		<div id="page" class="page_div"></div>
	</div>
</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script> 
<script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/static/js/Common2.js?v=1.5"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>
<script type="text/javascript" src="/static/js/monthPicker.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script> 
<script type="text/javascript">
     var where_datas =<?=json_encode($where_datas)?>;
     var datas =<?=json_encode($datas)?>;
     var where_datas  = eval('(' + where_datas + ')'); 
     var datas  = eval('(' + datas + ')'); 
     var datasNum =datas.total;
console.log(datasNum)

</script>
<script type="text/javascript" src="static/js/version-manage/index.js?v=1.2"></script>
<script type="text/javascript">

  var isCheckAll = false;
function swapCheck() {
  if (isCheckAll) {
    $("input[type='checkbox']").each(function() {

      this.checked = false;
      
    });
    isCheckAll = false;
  } else {
    $("input[type='checkbox']").each(function() {
      this.checked = true;
    });
    isCheckAll = true;
  }
 }
	 $(function() {



// 表格
 dev_listdata(datas.dev_list,1);



	 	var selecttime = datas.where.selecttime;
	 	var time1='';
	 	var time2='';
	 	if(selecttime){

	 	var timeData= selecttime.split("至");
	 	
	 		time1=timeData[0];
	 		time2=timeData[1];
	 		$("#selecttime1").val( datas.where.selecttime)
	 	}


	var dateRange = new pickerDateRange('date_demo', {
 			//aRecent7Days : 'aRecent7DaysDemo3', //最近7天
 			isTodayValid: true,
 			startDate :time1,
 			endDate :time2,
 			//needCompare : true,
 			//isSingleDay : true,
 			//shortOpr : true,
 			//autoSubmit : true,
 			defaultText: ' 至 ',
 			inputTrigger: 'input_trigger_demo',
 			theme: 'ta',
 			success: function(obj) {
 				$("#dCon_demo").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
 				$("#selecttime1").val($("#date_demo").val());
 			}
 		});
		 $("#batchPromote").hover(function() {
		 	$(this).css({
		 		'backgroundColor': '#C9302C',
		 		'color': '#fff'
		 	})
		 	$("#batchPromote img").attr('src', '/static/images3/batchPromoteImg2.png');
		 }, function() {
		 	$(this).css({
		 		'backgroundColor': '#424952',
		 		'color': '#fff'
		 	})
		 	$("#batchPromote img").attr('src', '/static/images3/batchPromoteImg.png');
		 })


		 $("#AllEquipment").hover(function() {
		 	$(this).css({
		 		'backgroundColor': '#C9302C',
		 		'color': '#fff'
		 	})
		 	$("#AllEquipment img").attr('src', '/static/images3/AllEquipmentImg2.png');
		 }, function() {
		 	$(this).css({
		 		'backgroundColor': '#424952',
		 		'color': '#fff'
		 	})
		 	$("#AllEquipment img").attr('src', '/static/images3/AllEquipmentImg.png');
		 })


var iccidVerification = true;
// iccid
$(".endIccid").change(function(){
	var startIccid = $(".startIccid").val();
	var endIccid = $(this).val();
	 if(!startIccid){
	  	  layer.msg('请输入开始ICCID号段');
	  	  iccidVerification=false;
	  	  return;
	 }else{
	 	iccidVerification = true;
	 }
	var obj= {'start':startIccid,'end':endIccid}
	iccidFun(obj)
})


$(".startIccid").change(function(){
	var endIccid = $(".endIccid").val();
	var startIccid = $(this).val();
	 if(endIccid){
       	var obj= {'start':startIccid,'end':endIccid}
	    iccidFun(obj)
	    // alert(iccidVerification)
	 }else{
	 	 iccidVerification=false;
	 }
})
function iccidFun(obj){
  $.get('./index.php?r=version-manage/check-iccid',obj,function(data) {
  	/*optional stuff to do after success */
        // console.log(data)
             var data =  JSON.parse(data);
              // console.log(data)
		      if(data.state<0){
		      	layer.msg(data[0]);
		      	iccidVerification=false;
		      	   return;
		      }else{
		      	iccidVerification = true;
           }
      });
  }

$("#submit").click(function(){
        	var startIccid = $(".startIccid").val() ;
        	var endIccid=$(".endIccid").val();
        	// if(startIccid)
        	if(!endIccid){
        		  if(!startIccid){
        		  }else{
                   layer.msg('请填写完整ICCID号段')
        		  	return false;
        		  }
        	}else{
        		 if(startIccid){
	            	if(!iccidVerification){
	            		layer.msg('ICCID号段	错误')
	            		return false;
	            	}
                
        		  }else{
        		  	 layer.msg('请填写完整ICCID号段')
        		  	return false;
        		  }
        	}


        	// 
        })
	 	$("#Refresh").click(function() {
 			window.location.reload();
 		})
 	    $("#removerSub").click(function() {
 		  $("#date_demo").text('');
 		   $('input').val('')
 		})
 	

//       $(document).on('click','.promote',function(){
// alert(4)
//  		});
      $(document).on('click','.promote',function(){

 			var IsUpgrade= $(this).parent().siblings(".IsUpgrade ").text();
            if(IsUpgrade=='升级中'||IsUpgrade=='已完成'){
            	layer.msg('设备已经：'+IsUpgrade)
            	 return;
            }
			var DevType= $(this).parent().siblings(".DevType ").text();
            if(DevType=='-'){
            		layer.msg('设备类型不能为空')
            	return;
            }
			// console.log(DevType)
          var inputText = '';
			for(var z in datas.where){
				if(datas.where[z]==null){
					datas.where[z]='';
				}
				 // inputText+='<input  class="toggle-input" type="text" name="'+z+'" value="'+z+'" id="'+datas.where[z]+'" style="display:none">'
			} 
   // console.log(inputText)
          // return;
			var spCodesTemp =$(this).parent().siblings(".DevNo").text().toString();
			// console.log(spCodesTemp)
			// alert(typeof(spCodesTemp))
			$.get('index.php?r=version-manage/get-target-version&dev_type=' + DevType, function(data) {
 					var data = eval('(' + data + ')');
 					// console.log(data);

 					var opts = ''
 					if(data.target_version.length){
                       $.each(data.target_version, function (index, item) {
			            if (item) {
			            	// console.log(item)
			                opts += "<li value='" + item.Version + "'>" + item.Version + "</li>";
			            }
			        });
 					}
 					var html = '<div class="container"   style="height:100%;width: 100%;">'
 					html += '<form action="/index.php?r=version-manage/upgrade-dev" method="post" enctype="multipart/form-data"  style="height:100%">';
 					html += '<div class="opdate-details"><div class="opdate-list"> '
					html += '	<div class="selection" style="position:relative">';
					html += '<label style="margin-top: 20px;">设&nbsp;&nbsp;&nbsp;备&nbsp;&nbsp;类&nbsp;&nbsp;型&nbsp;：<input type="text" readonly unselectable="on"  name="dev_type" value="'+DevType+'"></label><br/>';
                   
					html += '<label style="margin-top: 20px;"> 选&nbsp;择&nbsp;版&nbsp;本&nbsp;号 ：</label>';
					html += '<div class="dropdown" style="display: inline-block;">';
					html += '<button class="btn btn-default dropdown-toggle"  type="button" id="target_version" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
					html += '请选择版本号  &nbsp;<span class="caret"></span>';
					html += '</button>';
					html += '<input  class="toggle-input" type="text" name="target_version" value="" id="target_val" style="display:none">';
					html += '<ul class="dropdown-menu" aria-labelledby="target_version">';
					html += '<li  value>请选择版本号</li>'+opts+'';
					html += '</ul>';
					html += '</div>';
                	html += '<input type="hidden"  name="DevNos" value="' + spCodesTemp + '" style="display:none" />'
					html += '<br/><label style="margin-top: 20px;"> 选&nbsp;择&nbsp;开&nbsp;始&nbsp;时&nbsp;间 ：<input type="text" name="start_time" readonly unselectable="on" value="" id="start_time" ></label>';
					html += '<label style="margin-top: 20px;"> 选&nbsp;择&nbsp;结&nbsp;束&nbsp;时&nbsp;间 ：<input type="text" name="end_time" readonly unselectable="on" id="end_time" value=""></label>';
					html += '<div	style=" position: absolute;width: 100px;top: 40%;right: 0;padding-left: 25px;text-indent: -25px;"> <p><span>注：</span>点击提交后，设备将在选择的时间内自动升级</p></div> ';
					html += '</div><div	style="clear:both "></div> ';
 					html += ' <button type="button"  class=" btnob Close" >取消</button>';
 					html += ' <button type="submit" class="btnob submit" style="background-color: #E46045" >提交</button>'
 					html += '</div><div></form><div>';
 					// console.log(html)
 					layerdatefun(html)
 			})
 		})
// 升级全部
 $("#AllEquipment").click(function(){
         var inputText = '';
			for(var z in datas.where){
				if(datas.where[z]==null){
					datas.where[z]='';
				}
				 inputText+='<input  class="toggle-input" type="text" name="'+z+'" value="'+datas.where[z]+'" id="'+z+'">'
	    } 

	    // datas.where.dev_state

	    if( datas.where.dev_state==1){
			if(!datas.where.devbrand_id){
	        layer.msg('您还未选择设备品牌')
	           return;
	        }
	        if(!datas.where.devname_id){
	        layer.msg('您还未选择设备型号')
	           return;
	        }
	    }
        
        if(!datas.where.select_type){
        layer.msg('您还未选择设备类型')
           return;
        }



        // if(!datas.where.dev_state){
        // layer.msg('您还未选择号段')
        //    return;
        // }
        // if(!datas.where.end){
        // layer.msg('您还未选择号段')
        //    return;
        // }

      var DevType = datas.where.select_type;
      console.log(DevType);



 	$.get('index.php?r=version-manage/get-target-version&dev_type=' + DevType, function(data) {
 				var data = eval('(' + data + ')');
 			// console.log(data)
 			if (data.state <0) {
 				  layer.msg(data.mas)
 				// version = data.version;
 				return false;
 			}
 			   var opts = ''
 					if(data.target_version.length){
                       $.each(data.target_version, function (index, item) {
			            if (item) {
			            	// console.log(item)
			                opts += "<li value='" + item.Version + "'>" + item.Version + "</li>";
			            }
			        });
 					}
			var html = '<div class="container"   style="height:100%;width: 100%;">'
				html += '<form action="/index.php?r=version-manage/upgrade-dev" method="post" enctype="multipart/form-data"  style="height:100%">';
				html += '<div class="opdate-details"><div class="opdate-list"> '
				html += '	<div class="selection" style="position:relative">';
				html += '<label style="margin-top: 20px;">设&nbsp;&nbsp;&nbsp;备&nbsp;&nbsp;类&nbsp;&nbsp;型&nbsp;：<input type="text" readonly unselectable="on"  name="dev_type" value="'+DevType+'"></label><br/>';
	           
				html += '<label style="margin-top: 20px;"> 选&nbsp;择&nbsp;版&nbsp;本&nbsp;号 ：</label>';
				html += '<div class="dropdown" style="display: inline-block;">';
				html += '<button class="btn btn-default dropdown-toggle"  type="button" id="target_version" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
				html += '请选择版本号  &nbsp;<span class="caret"></span>';
				html += '</button>';
				html += '<input  class="toggle-input" type="text" name="target_version" value="" id="target_val" style="display:none">';
				html += '<ul class="dropdown-menu" aria-labelledby="target_version">';
				html += '<li  value>请选择版本号</li>'+opts+'';
				html += '</ul>';
				html += '</div>';
	        	html += '<div style="display:none">'+inputText+'</div>'
				html += '<br/><label style="margin-top: 20px;"> 选&nbsp;择&nbsp;开&nbsp;始&nbsp;时&nbsp;间 ：<input type="text" name="start_time" readonly unselectable="on" value="" id="start_time" ></label>';
				html += '<label style="margin-top: 20px;"> 选&nbsp;择&nbsp;结&nbsp;束&nbsp;时&nbsp;间 ：<input type="text" name="end_time" readonly unselectable="on" id="end_time" value=""></label>';
				html += '<div	style=" position: absolute;width: 100px;top: 40%;right: 0;padding-left: 25px;text-indent: -25px;"> <p><span>注：</span>点击提交后，设备将在选择的时间内自动升级</p></div> ';
				html += '</div><div	style="clear:both "></div> ';
				html += ' <button type="button"  class=" btnob Close" >取消</button>';
				html += ' <button type="submit" class="btnob submit" style="background-color: #E46045" >提交</button>'
				html += '</div><div></form><div>';
 			    layerdatefun(html)
 	})
 });
      // 批量升级
 $("#batchPromote").click(function(){
 		  var spCodesTemp = [];
          var  isUpgrade=[];
	 		$('#dev_list_body input:checkbox[name=state]:checked').each(function(i) {
	 			spCodesTemp.push($(this).parent().siblings(".DevNo").text());
	 			isUpgrade.push($(this).parent().siblings(".IsUpgrade").text());  
	 		});
	 		    // console.log(spCodesTemp)
         for(var i=0;i<isUpgrade.length;i++){
         	 if(isUpgrade=='升级中'){
         	 	layer.msg('你的设备已经在升级中了')
         	 	return;
         	 }
         }
		for(var z in datas.where){
			if(datas.where[z]==null){
		        datas.where[z]='';
			}
		} 
        if(!spCodesTemp.length){
        layer.msg('您还未选择设备')
         return;
        }
        if(!datas.where.devbrand_id){
        layer.msg('您还未选择设备品牌')
           return;
        }
        if(!datas.where.devname_id){
        layer.msg('您还未选择设备型号')
           return;
        }
        if(!datas.where.select_type){
        layer.msg('您还未选择设备类型')
           return;
        }
        var DevType = datas.where.select_type;
        // alert(datas.where.select_type)



  

 	$.get('index.php?r=version-manage/get-target-version&dev_type=' + DevType, function(data) {
 			var data = eval('(' + data + ')');
 			// console.log(data)

 		// 	var version = '';
 			if (data.state <0) {
 				  layer.msg(data.mas)
 				// version = data.version;
 				return false;
 			}

 			   var opts = ''
 					if(data.target_version.length){
                       $.each(data.target_version, function (index, item) {
			            if (item) {
			            	// console.log(item)
			                opts += "<li value='" + item.Version + "'>" + item.Version + "</li>";
			            }
			        });
 					}
			var html = '<div class="container"   style="height:100%;width: 100%;">'
				html += '<form action="/index.php?r=version-manage/upgrade-dev" method="post" enctype="multipart/form-data"  style="height:100%">';
				html += '<div class="opdate-details"><div class="opdate-list"> '
				html += '	<div class="selection" style="position:relative">';
				html += '<label style="margin-top: 20px;">设&nbsp;&nbsp;&nbsp;备&nbsp;&nbsp;类&nbsp;&nbsp;型&nbsp;：<input type="text" readonly unselectable="on"  name="dev_type" value="'+DevType+'"></label><br/>';
	           
				html += '<label style="margin-top: 20px;"> 选&nbsp;择&nbsp;版&nbsp;本&nbsp;号 ：</label>';
				html += '<div class="dropdown" style="display: inline-block;">';
				html += '<button class="btn btn-default dropdown-toggle"  type="button" id="target_version" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
				html += '请选择版本号  &nbsp;<span class="caret"></span>';
				html += '</button>';
				html += '<input  class="toggle-input" type="text" name="target_version" value="" id="target_val" style="display:none">';
				html += '<ul class="dropdown-menu" aria-labelledby="target_version">';
				html += '<li  value>请选择版本号</li>'+opts+'';
				html += '</ul>';
				html += '</div>';
	        	html += '<input type="hidden"  name="DevNos" value="' + spCodesTemp + '" style="display:none" />'
				html += '<br/><label style="margin-top: 20px;"> 选&nbsp;择&nbsp;开&nbsp;始&nbsp;时&nbsp;间 ：<input type="text" name="start_time" readonly unselectable="on" value="" id="start_time" ></label>';
				html += '<label style="margin-top: 20px;"> 选&nbsp;择&nbsp;结&nbsp;束&nbsp;时&nbsp;间 ：<input type="text" name="end_time" readonly unselectable="on" id="end_time" value=""></label>';
				html += '<div	style=" position: absolute;width: 100px;top: 40%;right: 0;padding-left: 25px;text-indent: -25px;"> <p><span>注：</span>点击提交后，设备将在选择的时间内自动升级</p></div> ';
				html += '</div><div	style="clear:both "></div> ';
				html += ' <button type="button"  class=" btnob Close" >取消</button>';
				html += ' <button type="submit" class="btnob submit" style="background-color: #E46045" >提交</button>'
				html += '</div><div></form><div>';
 			    layerdatefun(html)
 		})

 		})


})



</script>


</html>