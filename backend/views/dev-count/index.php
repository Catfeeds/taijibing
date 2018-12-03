<!DOCTYPE html>
<html>
<head>
	<title>设备统计</title>
  
	<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
 	<link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
	<link rel="stylesheet" href="/static/css/chosen.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
  <link rel="stylesheet" href="/static/css/Common.css?v=1.1"/>
  <link rel="stylesheet" href="/static/css/sales-volume/index.css?v=1.1"/>
</head>
<style type="text/css">
#device_statistics form select{
	background-color:#393e45;
}
.watertab th{
  text-indent: 0
}
 #tableBox td{
      position: relative;
}
 #tableBox   td hr{
  position: absolute;
    top: 50%;
    /* height: 30px; */
    border: 1px solid;
    width: 100%;
}
.tableBox, .tableBox tr{
  overflow: hidden;
}
</style>
<body>
	<div id='device_statistics'>
			<form action="./index.php?r=dev-count/index" method="post" accept-charset="utf-8">
				<div class='page-head' style='margin-top: 0;background-color: #2D3136'>
					<div class="selection Title">
						<img src="/static/images3/sidebar.png" alt="搜索" >
						<span class="font-size-S" >&nbsp;筛选条件</span>
					 </div>
	 			 <div class='head-txt'>
		             <!-- 天数选择 -->
						<div class="selection pull-left">
							<span  class="selection-text  pull-left">时间选择：</span>
							<div class="dataUlLI  pull-left"  >
						      	<ul class="selection-time" >
										<li value = "1" style='border-radius: 4px'><p type="">今日</p></li>
										<li  value = "2"><p type="">昨日</p></li>
										<li class="activer"  value = "3"><p type="text">最近7天</p></li>
										<li  value = "4"><p type="">最近30天</p></li>
										<li  value = "5"><p style="border-right:none;border-radius: 3px;" type="">最近90天</p></li>
									</ul>
						    </div>
					    </div>
				 		<!-- 时间容器 -->
				 		 <div class="selection pull-left" style='margin-left: 30px;'>
							<span  class="selection-text  pull-left">时间段选择：</span>
									 <div class="ta_date" id="div_date_demo">
								        <span class="date_title" id="date_demo">请选择时间段</span>
								        <a class="opt_sel" id="input_trigger_demo" href="#">
								            <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
								        </a>
								     </div>
						    <div id="datePicker"></div>
					    </div>
						  <div style="display: none">
				          	    <input type="text" name="time1" id="time1sub"  value="3">
				                <input type="text" name="time2" id="time2sub" value="">
				                <input type="text" name="offset" id="offsetsub" value="0">
				                <input type="text" name="limit" id="limitsub" value="10">
				          </div> 
			 		</div>
			 		<div class='head-txt'>
					   <!-- 地区容器 -->
					   <div class="selection pull-left" >
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
					</div>
			<!-- 角色容器 -->
			<div class='head-txt'>
	            <!-- 角色：-->
	            <div class="selection pull-left">
	              <span  class="selection-text  pull-left">角色选择：</span>
	               <div class="region pull-left address  role"  >
	             <div class="wrap_line">
	                <select class="control-label" name="agenty_id"  id="agenty_id" class="agenty_id">
	                                <option value="" selected>请选择运营中心</option>
	                        </select>
	                        <select class="control-label" name="pqcenter_id"  id="pqcenter_id" class="pqcenter_id">
	                                <option value="" selected>请选择片区中心</option>
	                        </select>
	                        <select class="control-label" name="agentf_id"  id="agentf_id" class="agentf_id">
	                                <option value="" selected>请选择服务中心</option>
	                        </select>
	                        <select class="control-label" name="devfactory_id"  id="devfactory_id" class="devfactory_id">
	                                <option value="" selected>请选择设备厂家</option>
	                        </select>
	                        <select class="control-label" name="investor_id"  id="investor_id" class="investor_id">
	                                <option value="" selected>请选择设备投资商</option>
	                        </select>
	             </div>
	           </div>
	             </div>
	       </div>
    
		         <!-- 商品选择 -->
		       <div class='head-txt'>
		            <div class="selection pull-left">
		              <span  class="selection-text  pull-left">商品选择：</span>
		               <div class="region pull-left address role"  >
		             <div class="wrap_line">
		                        <select class="control-label" name="devbrand_id"  id="devbrand_id" class="devbrand_id">
		                                <option value="" selected >请选择设备品牌</option>
		                        </select>
		                        <select class="control-label" name="devname_id"  id="devname_id" class="devname_id">
		                                <option value="" selected  date=''>请选择设备型号</option>
		                        </select>
		             </div>
		                    <div class="wrap_line">
		                    	   <select class="control-label" name="dev_state"  id="dev_state" class="dev_state">
		                                <!-- <option value="" selected>全部设备</option> -->
		                                <option value="1" selected >全部设备</option>
		                                <option value="2" >正常设备</option>
		                                <option value="3" >已初始化设备</option>
		                        </select>
		                    </div>
		           </div>
		             </div>
		       </div>
 <!-- 用户选择 -->
       <div class='head-txt'>
            <div class="selection pull-left">
              <span  class="selection-text  pull-left">用&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;户：</span>
               <div class="region pull-left address"  >
               <div class="wrap_line">
                          <select class="control-label" name="usetype"  id="usetype" class="usetype">
                                  <option value="" selected>入网属性</option>
                          </select>
                          <select class="control-label" name="customertype"  id="customertype" class="customertype">
                                  <option value="" selected>用户类型</option>
                                  <option value="1" >家庭</option>
                                  <option value="2" >公司</option>
                                  <option value="3" >集团</option>
                                  <option value="4" >酒店</option>
                                  <option value="99" >其他</option>
                          </select>
               </div>
             </div>
             </div>
       
                   <!-- 搜索容器 -->
             <div class="selection pull-left" id="searchbg" style='margin-left: 30px;'>
               <span  class="selection-text  pull-left">搜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;索：</span>
                  <div class="wrap_line" style="    display: initial;">
                     <input style='background-color: #393e45;border: none;' type="text" name="search"  id="searchp" value="" placeholder="请输入关键字">
                  </div>
             </div>
<div id="selectionBg">
      <!-- 条件按钮 -->
               <div class="submitBtn"  style='display: inline-block;margin-left: 10%;' >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn " id="submit" >   查看</button>
                &nbsp;&nbsp;
                <button type="text"  class="btn " id="removerSub">清空条件</button>
                </div>
             </div>
   </div>
				</div>
			</form>
     <div class='page-head'>
        <header  class="header" style="position: relative;">
          <div class='pull-left'>
               <div class="selection Title">
                <img src="/static/images3/sidebar.png" alt="搜索" >
                <span class="font-size-S" >&nbsp;设备统计概况</span>
             <div class='Hovertitle'>
              <div  class="volumeHover">  </div>
              <div class="volumeHover-text">
                <p> 设备统计概况：是用户登记注册激活设备之后的设备数量，和实际用户可能有延迟，可能出现微小误差，一般在0.1%范围内。</p>
              </div>
            </div>  
            </div>
          </div>
            <div class="pull-right">
              <span>  
                <img src="/static/images3/rectangle.png" alt="">
              持平
              </span> 
              <span>  
                <img src="/static/images3/arrowA.png" alt="">
              上涨
              </span> 
              <span>  
                <img src="/static/images3/Arrowb.png" alt="">
              下降
              </span> 
            </div>
          </header>
          <div style="clear:both;"></div>
        <div class="table-text">
          <table class='watertab' style="  ">
            <thead>
              <tr>
              	 <th style="text-indent: -30px;">名称</th>
                <th>新注册设备： &nbsp;<span style="color:#E46045"></span>&nbsp;</th>
                <th>已初始化设备  
                </th>
                <th>净增设备</th>
                <th>累计设备数  &nbsp;<span style="color:#E46045"></span>
                  <div class='Hovertitle'>
                    <div  class="AverageHover"></div>
                    <div class="AverageHover-text">
                      <p> 累计设备数为该角色除开已初始化设备，正常使用的设备数量累计。</p>
                    </div>
                  </div>
                </th>
           		<!--      
                <th>净增设备  &nbsp;<span style="color:#E46045">(L)</span>
                  <div class='Hovertitle'>
                    <div  class="pageHover">  </div>
                    <div class="pageHover-text">
                    <p>今年累计销量：为所有用户从1月1日开始的累计销量</p>
                    </div>
                  </div>
                </th> -->
              </tr>
            </thead>
            <tbody>
              <tr>
                <td id="sales1">设备数量（台）</td>
                <td  id="new_regist">0</td>
                <td id="dev_init">0</td>
                <td id="net_equipment">0</td>
                <td  id="all_dev_num">0</td>
              </tr>
              <tr>
              	  <td>同期  &nbsp;
	                  <div class='Hovertitle'>
	                    <div  class="compareHover"> </div>
	                    <div class="compareHover-text">
	                      <p> 同期表示：该销量和上一日、7天、30天、90天或者选择的时间段的百分比的对比显示</p>
	                    </div>
	                  </div>
	              </td>
	              <td id='same_time_regist'>0</td>
	              <td id='same_time_init'>0</td>
	              <td id='net_equipment_init'>0</td>
	              <td id='same_time_all_dev_num'></td>
              </tr>
            </tbody>
            </table>
      </div>
     </div>
<!-- 折现 -->
    <div class='page-head' >
          <header  class="header">
            <div class="selection Title">
            <img src="/static/images3/sidebar.png" alt="搜索" >
            <span class="font-size-S">&nbsp;设备情况 :&nbsp;<span style="color:#E46045;font-weight:400;font-size:12px">单位 ：台 </span></span>  
            </div>
          </header>
            <div id="main" style="height:300px;"></div>
     </div>
     <!-- 地图 -->
      <div class='page-head' >
             <div class="container-fluid">
              <div class="row">
                <!-- 地图 -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
                  <div class="sales-statistics" style="background-color: #393E45">
                   <header  class="header" style='padding:0'>
                           <div class="selection Title">
                      <img src="/static/images3/sidebar.png" alt="搜索" >
                      <span class="font-size-S">&nbsp;全国设备分布情况:<span style="color:#E46045">单位 ：(台)  </span></span>
                      </div>  
                  </header>
                  <div id="echarts2" style="height:400px"></div>
                  </div>
                </div>
                <!-- 占比 -->
                <div class="col-lg-4  col-md-4 col-sm-6 col-xs-12">
                  <div class="Provincial  pull-left ProvincialActiove"  id="Provincial">
                    <p>全国地图</p>
                  </div >
                  <div class="CityMap pull-right" id="CityMap">
                    <p>省级地图</p>
                  </div>
                  <div class="block" style="height: 300px;">
                    <div class="centered" id="percentum">
                    <div class="progress">
                        <span class="name">广东</span>
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                          <span class="">60% </span>
                        </div>
                      </div> 
                    </div>
                  </div>
                </div>
                    <!-- 饼图 -->
                <div class="col-lg-4  col-md-4 col-sm-6 col-xs-12" >
                  <header  class="header">
                    <div class="selection Title">
                      <img src="/static/images3/sidebar.png" alt="搜索" >
                      <span class="font-size-S">&nbsp;用户类型净增占比:<span style="color:#E46045">单位 ：(台) </span></span>
                      <div class='pull-right' style='height: 30px;line-height: 30px;'>

                      <span class='data-view'><img src="/static/images3/chankan.png"  ></span>

                      <span class='data-refresh'><img src="/static/images3/shuaxin.png"  ></span>
          &nbsp;
                      <div id='dataView'>
                         <table  class="table" style=' width: 200px;border-radius: 5px;background: #fff; border-collapse: collapse;' >
                      
                          <thead>
                            <tr>
                              <th  colspan="2" style="position: relative;">用户类型净增占比
                                <div  class="triangle"></div>
                              </th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>用户类型</td>
                              <td>增长数量</td>
                            </tr>
                              <tr>
                              <td>家庭</td>
                              <td>0</td>
                            </tr>
                            <tr>
                              <td>公司</td>
                              <td>0</td>
                            </tr>
                            <tr>
                              <td>集团</td>
                              <td>0</td>
                            </tr>
                             <tr>
                              <td>酒店</td>
                              <td>0</td>
                            </tr>
                            <tr>
                              <td>其他</td>
                              <td>0</td>
                            </tr>
                             <tr>
                              <td id="Refresh">刷新</td>
                              <td id='Close'>关闭</td>
                            </tr>
                          </tbody>

                         </table>
                      </div>
                    </div>
                    </div>
                    
                  </header>
                  <div id="echarts3" style="height:300px;margin-top:40px" ></div>
                  <div class = 'baifenbiA'>
                      <ul >
                        <li><span class="hor" style="background-color: #E46045;"></span><span class="baifenbi">0</span>%<br/>家庭</li>
                        <li><span class="hor" style="background-color: #C248DC;"></span><span class="baifenbi">0</span>%<br/>公司</li>
                        <li><span class="hor" style="background-color: #4ADCDD;"></span><span class="baifenbi">0</span>%<br/>集团</li>
                        <li><span class="hor" style="background-color: #21f507;"></span><span class="baifenbi">0</span>%<br/>酒店</li>
                        <li><span class="hor" style="background-color: #FEC751;"></span><span class="baifenbi">0</span>%<br/>其他</li>
                      </ul>
                  </div> 
                </div>

              </div>
            </div>
        </div>

         <div class='page-head' >
           <header  class="header" style='padding:0'>
                   <div class="selection Title">
              <img src="/static/images3/sidebar.png" alt="搜索" >
              <span class="  ">&nbsp;实时数据表</span>
                <div class="pull-right method"  id="method" style="cursor:pointer;margin-top:-20px;">
                <a href="javascript:void(0)"  id="methodBox" >
                <img src="/static/images3/biao.png" alt="" style='    display: inline-block; padding: 5px;background: #1C1D21; border-radius: 5px;' >
                <span class="font-size-S">&nbsp;导出表格</span>
                </a>
              </div>

              </div>  
            </header>
              <div class="">
              <table class="tableBox" id="tableBox" style="width:100%" >  
                <thead>
                  <tr id='tabhrader'>
                    <th>序号</th>
                    <th>用户姓名</th>
                    <th>联系电话</th>
                    <th>设备编号</th>
                    <th>设备商品型号</th>
                    <th>设备品牌</th>
                    <th>设备厂家</th>
                    <th>设备投资商</th>
                    <th>服务中心</th>
                    <th>片区中心</th>
                    <th>运营中心</th>
                    <th>地区</th>
                    <th>入网属性</th>
                    <th>用户类型</th>
                    <th><a id="sort" sort=0> 激活时间</a></th>
          
                  </tr>
                </thead>
                <tbody id="tableData">
                </tbody>
                </table>
              </div>
       </div>


<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
  <div id="page" class="page_div"></div>
</div>
</div>
</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript">
// 下拉数据
   	var select_datas=<?=json_encode($select_datas)?>;
   	// 选择数据
   	var where_datas=<?=json_encode($where_datas)?>;
    var datas=<?=json_encode($datas)?>;
    var all_use_type=<?=json_encode($all_use_type)?>;
   	var all_init_dev=<?=json_encode($all_init_dev)?>;

    // console.log(where_datas)
    // console.log(select_datas.agentf)
    // console.log(select_datas.agenty)
   	// console.log(datas)all_init_dev
   	for(i in where_datas){
   	
   		if(where_datas[i]==null){
   			where_datas[i]='';
   		}
   	}

</script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>	
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script src="/static/js/echarts/echarts.js"></script>
<script src="/static/js/echarts/dist/echarts.js"></script>
<script type="text/javascript" src="/static/js/sales-volume/map.js?v=1.1"  charset="utf-8"></script> 
<script type="text/javascript" src="/static/js/sales-volume/lineChart.js"  charset="utf-8"></script> 
<script type="text/javascript" src="/static/js/Common3.js?v=1.1"></script>
<script type="text/javascript" src="/static/js/paging3.js?v=1.1"></script>
<script type="text/javascript">
// console.log(select_datas)


    // 地址渲染 
addressResolve(select_datas.areas,where_datas.province,where_datas.city,where_datas.area);



// // 运营中心
// devlistFu({
//   data:select_datas.agenty,
//   name:'agenty_id',
//   where:where_datas.agenty_id,
// })
// // 片区中心
// devlistFu2({
//   data:select_datas.pqdatas,
//   name:'pqcenter_id',
//   where:where_datas.pqcenter_id,
// });
// // 服务中心
// devlistFu3({
//   data:select_datas.agentf,
//   name:'agentf_id',
//   where:where_datas.agentf_id,
// });

// 三级联动
linkage({
  name1:'agenty_id',
  name2:'pqcenter_id',
  name3:'agentf_id',
  data1:select_datas.agenty,
  data2:select_datas.pqdatas,
  data3:select_datas.agentf,
  where1:where_datas.agenty_id,
  where2:where_datas.pqcenter_id,
  where3:where_datas.agentf_id,
})


// console.log(where_datas.customertype)






// 设备厂家
devlistFu4({
  data:select_datas.devfactory,
  name:'devfactory_id',
  where:where_datas.devfactory_id,
});
// 设备投资商
devlistFu5({
  data:select_datas.investor,
  name:'investor_id',
  where:where_datas.investor_id,
});

// 设备品牌型号
addresEquipmente({
     devbrand:'devbrand_id',
     devbrand_data:select_datas.devbrand,
     devname:'devname_id',
     devname_data:select_datas.devname,
     where:{
        devbrand:where_datas.devbrand_id,
        devname:where_datas.devname_id
     }
})


//入网属性
usetypeFun({
  name:'usetype',
  data:select_datas.use_type,
  where:where_datas.usetype
})
//用户类型
customertypea({
  name:'customertype',
  where:where_datas.customertype
})


dev_state3({
  name:'dev_state',
  where:where_datas.dev_state
})


// //入网属性
// usetypeFun({
//   name:'usetype',
//   data:use_type,
//   where:where_datas.usetype
// })
   	//时间记录判断
var  time1nbs = GetDateStr(-6, 1);
var  time2nbs = GetDateStr(0, 1);
var timeOf = where_datas.time1;
var timeOf2 = where_datas.time2;

	// console.log(timeOf2)

if(timeOf){
  $("#time1sub").val(timeOf)
 // $("#timesub").val(timeOf2)


    $('.activer').removeClass('activer');
    $("#time1sub").val(timeOf)
     time2nbs = GetDateStr(0, 1);
    if(timeOf==1){
       $(".dataUlLI li").eq(0).addClass('activer');
        time1nbs = GetDateStr(0, 1);
        $("#date_demo").text('请选择时间段')
    }else if(timeOf==2){
       $(".dataUlLI li").eq(1).addClass('activer');
        time1nbs = GetDateStr(-1, 1);
         $("#date_demo").text('请选择时间段')
    }else if(timeOf==3){
       $(".dataUlLI li").eq(2).addClass('activer');
        time1nbs = GetDateStr(-6, 1);
         $("#date_demo").text('请选择时间段')
    }else if(timeOf==4){
       $(".dataUlLI li").eq(3).addClass('activer');
        time1nbs = GetDateStr(-29, 1);
         $("#date_demo").text('请选择时间段')
    }
    else if(timeOf==5){
       $(".dataUlLI li").eq(4).addClass('activer');
        time1nbs = GetDateStr(-89, 1);
       
       $("#date_demo").text('请选择时间段')
    }else{
      time1nbs = timeOf;
      time2nbs =where_datas.time2;
      $("#time1sub").val(time1nbs)
      $("#time2sub").val(timeOf2)
    }
}


  $('.dataUlLI li').on('click', function() {
      $('.activer').removeClass('activer');
      $(this).addClass('activer');
      $('.dataUlLI li p').css('borderRight', "1px #000 solid");
      $(".dataUlLI li:last-of-type p").css('borderRight', "0px #000 solid");
      $(this).prev().find('p').css('border', "none");
      $(this).find('p').css('border', "none");
      $("#time1sub").val($(this).val())
      $("#time2sub").val('')
      $("#date_demo").text('请选择时间段')
  });
$("#removerSub").bind('click',function(){
  $('.activer').removeClass('activer');
   $('.dataUlLI li').eq(2).addClass('activer');

   $("#time1sub").val(3)
   $("#time2sub").val('')
   $("#searchp").val('')
   return false;
})

$("#sort").on('click',function(){
   var sort = $(this).attr('sort');
   sort++

   if(sort>1){
      sort=0
   }
$(this).attr('sort',sort);

      var searchParameters = where_datas;
          searchParameters.sort=sort;
          Get_datas(searchParameters)
        // console.log(searchParameters)

})
$("#submit").on('click',function(){
    $(this).css('background','#e46045')
})
   $('.data-view') .on('click', function() {
      $('#dataView').css('display', 'block')
    })
    $('#Close,.data-refresh').on('click', function() {
      $('#dataView').css('display', 'none')
    })

   // 时间选择
    var dateRange = new pickerDateRange('date_demo', {
      // aRecent7Days : 'aRecent7DaysDemo3', //最近7天
      isTodayValid: true,
      startDate: time1nbs,
      endDate:time2nbs,
      //needCompare : true,
      //isSingleDay : true,
      //shortOpr : true,
      //autoSubmit : true,
      defaultText: ' 至 ',
        // format : 'YYYY-MM-DD HH:mm:ss', //控件中from和to 显示的日期格式
      inputTrigger: 'input_trigger_demo',
      theme: 'ta',
      success: function(obj) {
        // $("#dCon_demo").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
        $("#time1sub").val(obj.startDate)
        $("#time2sub").val(obj.endDate)
       $('.dataUlLI .activer').removeClass('activer');  
      }
    });


  _hover($(".volumeHover"), $(".volumeHover-text"))
  _hover($(".compareHover"), $(".compareHover-text"))
  _hover($(".AverageHover"), $(".AverageHover-text"))
  _hover($(".pageHover"), $(".pageHover-text"))
  //伪类
  function _hover(Class, ClassText) {
    Class.hover(function() {
      ClassText.css("display", "block");

      Class.css("background", "url(/static/images3/volumeHover2.png) no-repeat");
    }, function() {
      ClassText.css("display", "none");
      Class.css("background", "url(/static/images3/volumeHover1.png) no-repeat");
    });
  }

// 概况
salesVolume() 

function  compare(num1,num2){

var html;
var num = num1*1-num2*1;
var percentage=(num)*100;
 if(num<0){
       html= -percentage+ "%&nbsp;&nbsp; <img src='/static/images3/Arrowb.png'> ";
  }else if(num>0){
           html= percentage+ "%&nbsp;&nbsp; <img src='/static/images3/arrowA.png'> ";
 }else{
     html= "持平&nbsp;&nbsp; <img src='/static/images3/rectangle.png'> ";
 }
  return html;
}


// // 概况
function salesVolume() {
  $("#new_regist").text(datas.new_regist);
  $("#same_time_regist").html(compare(datas.new_regist,datas.same_time_regist));
// // 初始化设备
  $("#dev_init").text(datas.dev_init);
  $("#same_time_init").html(compare(datas.dev_init,datas.same_time_init));
// // 净增设备
  $("#net_equipment").text(datas.new_regist-datas.dev_init);
  $("#net_equipment_init").html(compare(datas.new_regist-datas.dev_init,datas.same_time_regist-datas.same_time_init) );
//   // 累计设备数
  $("#all_dev_num").text(datas.all_dev_num);
  // $("#same_time_all_dev_num").html(compare(datas.all_dev_num,datas.same_time_all_dev_num) );
}



// 折线图
 FoldLineDiagramCalculation() 

 // var sales_detail = datas[0].sales_detail;

  // 

// console.log(datas)
  var use_statusdata =datas.form_datas;

  // dev_listdata(use_statusdata)
// 分页

  $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(datas.total / 10),
    totalLimit: 10,
    totalSize:datas.total,
    callback: function(num, nbsp) {
      var searchParameters = where_datas;

        if(searchParameters.excel){
          delete searchParameters.excel;
        }
          searchParameters.sort=$("#sort").attr('sort');
          searchParameters.limit=nbsp;
          searchParameters.offset=num * nbsp - nbsp;
          Get_datas(searchParameters,num)
        // console.log(where_datas)
      }
  })
Get_datas(where_datas,1)


  function  Get_datas(searchParameters,num){
     var ii =   layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    shadeClose: false, //开启遮罩关闭
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });

  $.post("./index.php?r=dev-count/get-page-datas", searchParameters, function(data){
       layer.close(ii); 
       // console.log(data.all_init_dev)
       // var sales_detail=data[0].sales_detail
        dev_listdata(data.form_datas,num);

  })
}
  function dev_listdata(data) {
     // console.log(data);

     if(data.length>0){
            var j = 0;
            $("#tableData").empty();
            for (var i = 0; i < data.length; i++) {
              var item = data[i]
              var blobk='none';


                for (var z in item) {
                  if (item[z] == null) {
                      item[z] = '--'
                  }
                }
                j++
                var Tel =item.Tel;
               var UseTy= item.UseType;

               var CustomerType=customertype(item.CustomerType);
               var UseTy=usetype(item.UseType);
               // console.log(UseTy)

                  var tString = item.Tel.slice(3,7);
                      Tel = item.Tel.replace(tString, "****");

                 var DevNo =  tString = item.DevNo.slice(3,7);
                var DevNoA=item.DevNo.replace(DevNo, "****");

                 
                 

                   for(var p=0;p<all_init_dev.length;p++){
                        if(all_init_dev[p].DevNo==item.DevNo){
                             blobk='block';
                         }
                   }
               var html = '<tr><td>'+j+'<hr/ style="display:'+blobk+'"></td>'
                   html += '<td>'+item.UserName  +'<hr/ style="display:'+blobk+'"></td>'
                   html += '<td>'+Tel+'<hr/ style="display:'+blobk+'"></td>'
                   html += '<td>'+DevNoA+'<hr/ style="display:'+blobk+'"></td>'
                   html += '<td>'+item.GoodsName+'<hr/  style="display:'+blobk+'"></td>'
                   html += '<td>'+item.BrandName+'<hr/  style="display:'+blobk+'"></td>'
                   html += '<td>'+item.FactoryName+'<hr/  style="display:'+blobk+'"></td>'
                   html += '<td>'+item.InvestorName+'<hr/ style="display:'+blobk+'"></td>'
                   html += '<td>'+item.AgentfName+'<hr/ style="display:'+blobk+'"></td>'
                   
                   html += '<td>'+item.AgentpName+'<hr/ style="display:'+blobk+'"></td>'

                   html += '<td>'+item.AgentyName+'<hr/ style="display:'+blobk+'"></td>'
                   html += '<td>'+item.Province+'-'+item.City+'-'+item.Area+'<hr/ style="display:'+blobk+'"></td>' 

                    html += '<td>'+UseTy+'<hr/  style="display:'+blobk+'"></td>'
                   html += '<td>'+CustomerType+'<hr/ style="display:'+blobk+'"></td>'
                  


                   html += '<td>'+item.ActiveTime+'<hr/ style="display:'+blobk+'"></td>'
                   
                   html += '</tr>';

                    


    
                $("#tableData").append(html);
            }
          }
 function customertype(usetype){
    var res =''

    // console.log(usetype)
        if(usetype == 1){
            res = "家庭"
        }
        else if(usetype == 2){
            res = "公司"
        }
        else if(usetype == 3){
            res = "集团"
        }
        else if(usetype == 4){
            res = "酒店"
        }else if(usetype == 99){
            res = "其他"
        }else{
          res =' '
        }
        return res;
   }

   function usetype(usetype){
    var res ='';
        // console.log(all_use_type)

    for(var i=0;i<all_use_type.length;i++){
        var item = all_use_type[i];

        if(item.code==usetype){
              res = item.use_type;
        }
    }
        return res;
   } 

 }

// console.log(select_datas.use_type)

//导出表格
$("#methodBox").click(function() {
       
// where_datas
var objwhere_datas = where_datas;
objwhere_datas.limit=datas.total;
objwhere_datas.excel='YES';


// console.log(objwhere_datas)  

var href = '&agentf_id='+objwhere_datas.agentf_id+'&agenty_id='+objwhere_datas.agenty_id+'&area='+objwhere_datas.area+'&city='+objwhere_datas.city+'&customertype='+objwhere_datas.customertype+'&dev_state='+objwhere_datas.dev_state+'&devbrand_id='+objwhere_datas.devbrand_id+'&devfactory_id='+objwhere_datas.devfactory_id+'&devname_id='+objwhere_datas.devname_id+'&excel='+objwhere_datas.excel+'&investor_id='+objwhere_datas.investor_id+'&offset='+objwhere_datas.offset+'&limit='+objwhere_datas.limit+'&pqcenter_id='+objwhere_datas.pqcenter_id+'&province='+objwhere_datas.province+'&search='+objwhere_datas.search+'&time1='+objwhere_datas.time1+'&time2='+objwhere_datas.time2+'&usetype='+objwhere_datas.usetype;

  $(this).attr('href','./index.php?r=dev-count/get-page-datas'+href)


// location.href='./index.php?r=dev-count/get-page-datas'+href;

   })
















// 折线数据渲染方法
function FoldLineDiagramCalculation() {
    var use_statusdata =datas.chart_datas;
  // console.log(use_statusdata)
    var _date = []
    var xin = 7;
    var lop = 0;
   var timedatae = GetDateStr(0, 1);

   if(!where_datas.time1){
    where_datas.time1=3
   }
    if (where_datas.time1==1) {
      // alert(1)
       xin = 1;
    } else if ( where_datas.time1 == 2) {
      xin = 1
    } else if (where_datas.time1 == 3) {
      xin = 7
    } else if (where_datas.time1 == 4) {
      xin = 30
    } else if (where_datas.time1 == 5) {
      xin = 90
    } else if (where_datas.time1 == null) {
      xin = 7
    }else{
       xin =diy_time(where_datas.time1, where_datas.time2) + 1;
        lop = diy_time(where_datas.time2, timedatae)
    }
  // console.log(xin)
  var darax = NumberDays(xin, _date, lop);
  var daray = [];
  // console.log(where_datas.time1)
  if (where_datas.time1 <= 2) {
    var itmesum = []
    for (var i = 0; i < use_statusdata.length; i++) {

      var itme = use_statusdata[i].RowTime;
      var itmesumTer = itme.split(" ")[1]
      itmesum.push(itmesumTer.replace(':', '.'))
    }
  // console.log(use_statusdata)
    // console.log(itmesum)
    var daraxp = []
    var daraxpdata = [];
    var daraxpdataL = []
    var ppp = 0
    for (var i = 0; i < 25; i++) {
      var date = (i) + ":00"
      daraxp.push(date)
      daraxpdata.push("0")
      daraxpdataL.push("0")
      for (var y = 0; y < itmesum.length; y++) {
        var _itmesum = itmesum[y].split(".")[0]
        if (_itmesum == i) {
            daraxpdata[i]++
            daraxpdataL[i]++
        }
      }
    }
    darax = daraxp
    daray = daraxpdataL
  } else {

    for (var i = 0; i < darax.length; i++) {
      daray.push(0)

      var daraxDate = Date.parse(darax[i]);

      for (var j = 0; j < use_statusdata.length; j++) {
        var nowDate = Date.parse(use_statusdata[j].RowTime.split(" ")[0]);
        // console.log(nowDate)
        if (daraxDate == nowDate) {
           daray[i]++
        }
      }
    }
  }

   // console.log(darax)
   // console.log(daray)
  FoldLineDiagram(darax, daray, '净增')

 
  mapCityBar(use_statusdata)




}




// 地图数据计算渲染方法
function mapCityBar(sales_status) {
  var mapProvince = [];
  var mapCity = [];
  for (var j = 0; j < sales_status.length; j++) {
    mapProvince.push(sales_status[j].Province)
    mapCity.push(sales_status[j].City)
  }


  var mapProvinceNUm = unique(mapProvince)
  var mapCityNUm = unique(mapCity)
  var mapProvincebox = [];
  var mapCitybox = [];
  var progressBar = []

  $("#percentum").empty();
  var mapProvinceNUmColor = ['#D29616', '#4ADCDD', '#C248DC', '#EA5638', '#D29717'];


  for (var j = 0; j < mapProvinceNUm.length; j++) {
    mapProvincebox.push({
      'key': mapProvinceNUm[j],
      'value': 0,
      'tadal': sales_status.length
    })
    for (var i = 0; i < mapProvince.length; i++) {
      if (mapProvinceNUm[j] == mapProvince[i]) {
        mapProvincebox[j].value++
      }
    }
// console.log(mapProvincebox)
    if (mapProvinceNUm[j] == null) {
      mapProvinceNUm[j] = '其它'
    }
    progressBar.push(Math.round(mapProvincebox[j].value / sales_status.length * 100))

    var html = '<div class="progress" style="height:10px;    background-color: #1d1f23;"><span class="name" style="margin-top:-5px;left: 25px;">' + mapProvinceNUm[j] + '</span>' + '<div class="progress-bar"   role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressBar[j] + '%; background-color: ' + mapProvinceNUmColor[j] + '">' + '</div>' +
      '<span class="baifenbi" style="color: #fff; position: absolute;    right: 50px;right: 45px;margin-top: -5px;">' + progressBar[j] + '%' + '</span> </div>'
    $("#percentum").append(html);
  }
  for (var i = 0; i < mapCityNUm.length; i++) {
    mapCitybox.push({
      'key': '0',
      'value': 0,
      'Province': '',
      'tadal': 0
    })
    for (var j = 0; j < sales_status.length; j++) {
      var mapCityLnumname = sales_status[j].Province
      if (mapCityNUm[i] == sales_status[j].City) {
        mapCitybox[i].value++
          mapCitybox[i].key = mapCityNUm[i]
        mapCitybox[i].Province = mapCityLnumname;
      }
    }
  };

  for (var i = 0; i < mapProvincebox.length; i++) {

    for (var j = 0; j < mapCitybox.length; j++) {
      if (mapProvincebox[i].key == mapCitybox[j].Province) {
        mapCitybox[j].tadal = mapProvincebox[i].value
      }
    }
  };

  var map_obj={
     'Name':'设备',
     'Unit':'台',
  }


  // console.log(map_obj)
  map(mapProvinceNUm, mapProvincebox, mapCityNUm, mapCitybox, mapProvinceNUmColor,map_obj);
  PieChartRendering(sales_status)

}


// 饼图
function PieChartRendering(sales_status) {
  var sales_status = sales_status;
  var CustomerType = []
  var CustomerTypeNum = [];
  for (var i = 0; i < sales_status.length; i++) {
    CustomerType.push(sales_status[i].CustomerType)
  }

  var CustomerTypeunique = (CustomerType);
  for (var i = 0; i < 5; i++) {
    if (CustomerTypeNum.length < 5) {
      if (!CustomerTypeNum[i]) {
        CustomerTypeNum.push(0)
      }
    }
  }
  // for (var i = 0; i < CustomerTypeunique.length; i++) {
  //   CustomerTypeNum.push(0)
  //   for (var j = 0; j < CustomerType.length; j++) {

  //     if (CustomerTypeunique[i] == CustomerType[j]) {
  //       CustomerTypeNum[i]++
  //     }
  //   }
  // }
  for (var index = 0; index < CustomerTypeunique.length; index++) {
    if (CustomerTypeunique[index] == 1) {
      CustomerTypeNum[0]++
    } else if (CustomerTypeunique[index] == 2) {
      CustomerTypeNum[1]++
    } else if (CustomerTypeunique[index] == 3) {
      CustomerTypeNum[2]++
    } else if (CustomerTypeunique[index] == 4) {
      CustomerTypeNum[3]++
    } else {
      CustomerTypeNum[4]++
    }
  }

  var CustomerTypeuniqueName = ['家庭', '集团', '公司', '酒店', '其他'];

  for (var i = 0; i < CustomerTypeNum.length; i++) {
    $("#dataView tbody tr td:nth-child(2)").eq(i + 1).text(CustomerTypeNum[i])
    var num = Math.round(CustomerTypeNum[i] / sales_status.length * 100)
    if (num) {
      $(".baifenbiA .baifenbi").eq(i).text(num)
    }
  }
  var $name = '用户类型净增占比'
// 
  // console.log(CustomerTypeuniqueName)
  // console.log(CustomerTypeNum)
  PieChart(CustomerTypeuniqueName, CustomerTypeNum, $name)
  $("#Refresh,.data-refresh").click(function() {
    PieChart(CustomerTypeunique, CustomerTypeNum)
    $('#dataView').css('display', 'none')
  });

}



</script>
</html>