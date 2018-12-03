<!DOCTYPE html>
<html>
<head>
	<title>用水量统计</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
	<link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
	<link rel="stylesheet" href="./static/css/chosen.css"/>
	<link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
	<link rel="stylesheet" href="./static/css/sales-volume/index.css?v=1.1"/>
</head>
<style type="text/css">
.dropdown-menu{
		max-height: 250px;
		overflow: auto;
	}
	.data-view, .data-refresh {
    display: -webkit-inline-box;
    background-color: #1D1E22;
    padding: 0 5px;
    border-radius: 5px;
    cursor: pointer;
    height: 23px;
    display: inline-block;
    line-height: 23px;
}
</style>
<body>
<div id='water_use'>
	<!--内容主题-->
	<form action="./index.php?r=water-use/index" method="post" accept-charset="utf-8">
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

		                             <input  style="display: none" type="text" name="real_search" value="1">
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
                                <option value="" selected>请选择设备品牌</option>
                        </select>
                        <select class="control-label" name="devname_id"  id="devname_id" class="devname_id">
                                <option value="" selected>请选择设备型号</option>
                        </select>
             </div>
           </div>
             </div>
       </div>
 <!-- 用户选择 -->
       <div class='head-txt'>
            <div class="selection pull-left">
              <span  class="selection-text  pull-left">用户选择：</span>
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
</div>
      <div class='page-head'>
        <header  class="header" style="position: relative;">
          <div class='pull-left'>
               <div class="selection Title">
                <img src="/static/images3/sidebar.png" alt="搜索" >
                <span class="font-size-S">&nbsp;用水量概况&nbsp;</span>
            
             <div class='Hovertitle'>
              <div  class="volumeHover">  </div>

              <div class="volumeHover-text">
                <p>	用户用水量概况统计：是用户通过设备抽水的水量，和实际用水量有延迟，可能出现微小误差，一般在1%范围内。</p>
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
              	<th>用户用水量： &nbsp;<span style="color:#E46045">(L)</span>&nbsp;</th>
                <th>同期  &nbsp;
                   
                  <div class='Hovertitle'>
                    <div  class="compareHover"> </div>

                    <div class="compareHover-text">
                      <p>	同期表示：该销量和上一日、7天、30天、90天或者选择的时间段的百分比的情况显示</p>
                    </div>
                  </div>

                </th>
                <th>用户总数（人）</th>
					<th>客户均用水量  &nbsp;<span style="color:#E46045">(L)</span>&nbsp;
						<div class='Hovertitle'>
							<div  class="AverageHover">	</div>
							<div class="AverageHover-text">
								<p>	客户均用水量：为所有用户的用水量除以用户总数量的结果数据，数据实时动态变化</p>
							</div>
						</div>


					</th>
					<th>今年累计用水量  &nbsp;<span style="color:#E46045">(L)</span>
						 
						<div class='Hovertitle'>
							<div  class="pageHover">	</div>

							<div class="pageHover-text">
							<p>今年累计用水量：为所有用户从1月1日开始的累计用量 </p>
							</div>
						</div>
					</th>
              </tr>
             </thead>
            <tbody>
              <tr>
                <td id="sales1">0</td>
                <td  id="sales2">0</td>
                <td id="user_num">0</td>
                <td id="sales_of">0</td>
                <td  id="sales_of_year">0</td>
              </tr>
            </tbody>
            </table>
      </div>
     </div>
     <div class='page-head' >
          <header  class="header">
            <div class="selection Title">
            <img src="/static/images3/sidebar.png" alt="搜索" >
            <span class="font-size-S">&nbsp;用水量概况 :&nbsp;<span style="color:#E46045;font-weight:400;font-size:12px">单位 ：(L)	  </span></span>  
            </div>
          </header>
            <div id="main" style="height:300px;"></div>
     </div>



<!-- 地图 -->
<div class='page-head' >
		<div class="container-fluid" style="padding:20px 0">
			<div class="row" style="background-color: #393E45;padding: 15px 0px;position: relative;">
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
					<div class="sales-statistics" style="background-color: #393E45">
						<header  class="header" style='padding:0'>
							<img src="/static/images3/sidebar.png" alt="搜索" >
							<span class="font-size-S">&nbsp;全国用水量分布情况:<span style="color:#E46045">单位 ：(L)	</span></span>
						</header><!-- /header -->
					    <div id="echarts2" style="height:450px"></div>
					</div>
				</div>


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
			
				<div class="col-lg-4  col-md-4 col-sm-6 col-xs-12" >
					<header  class="header" style="width:90%;    padding: 5px;">
						<div class='pull-left'>
							<img src="/static/images3/sidebar.png" alt="搜索" >
						<span class="font-size-S">&nbsp;用户类型用水量占比:<span style="color:#E46045">单位 ：(L)	</span></span>
						</div>
						<div class='pull-right' style=''>
							<span class='data-view'><img src="/static/images3/chankan.png"  ></span>

							<span class='data-refresh'><img src="/static/images3/shuaxin.png"  ></span>

							<div id='dataView'>
								 <table   class="table" style=' width: 200px;    border-spacing: 0px 0px;' >
							
								 	<thead>
								 		<tr>
								 			<th  colspan="2" style="position: relative;">用户类型净增占比
								 				<div	class="triangle"></div>
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
					</header>
					<div id="echarts3" style="height:300px;margin-top:90px" ></div>
				<div class = 'baifenbiA'>
						<ul	>
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
<!-- 表格 -->
<div class='page-head' >
			<div class="container-fluid" style=" padding:0px 0px;">
			<div class="row" style="background-color: #393E45;color: #fff;padding:5px">
				<div class=" col-xs-12" >
					<div class="methodTab ">
						<theader>
							<div class="pull-left method">
								<img src="/static/images3/sidebar.png" alt="搜索" >
								<span class="  ">&nbsp;实时数据表</span>
							</div>
							   <div class="pull-right method"  id="method" style="cursor:pointer;margin-top:-20px;">
	               					 <a href=""  id="methodBox" >
	                				<img src="/static/images3/biao.png" alt="" style='    display: inline-block; padding: 5px;background: #1C1D21; border-radius: 5px;' >
	                				<span class="font-size-S">&nbsp;导出表格</span>
	               					 </a>
	         				    </div>

						</theader>
					</div>
				</div>
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
							<th>运营中心</th>
							<th>地区</th>
							<th>入网属性</th>
							<th>用户类型</th>
							<th>用水量<span style="    color: #E46045;">L</span></th>
						</tr>
					</thead>
					<tbody id="tableData">
					</tbody>
					</table>
				</div>
			</div>
		</div>

</div>

<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
		<div id="page" class="page_div"></div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>

<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/layer/layer.js"></script>


<script type="text/javascript" src="/static/js/dateRange.js"></script>	
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script src="/static/js/echarts/echarts.js"></script>
<script src="/static/js/echarts/dist/echarts.js"></script>
<script type="text/javascript" src="/static/js/sales-volume/map2.js?v=1"  charset="utf-8"></script> 
<script type="text/javascript" src="/static/js/sales-volume/lineChart.js"  charset="utf-8"></script> 
<script type="text/javascript" src="/static/js/Common2.js?v=4"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>




<script	> 
   var datas2=<?=json_encode($datas)?>; 
  console.log(datas2)
//   var arr = Array(datas2.use_status); 
//   alert(arr instanceof Array); 
//  console.log(arr)
// alert(typeof(arr))
   var areas=<?=json_encode($areas)?>;
    var province=<?=json_encode($province)?>;
    var city=<?=json_encode($city)?>;
    var area=<?=json_encode($area)?>;
    var where_datas=<?=json_encode($where_datas)?>;

     for(var i in where_datas){
			         if(where_datas[i]==null){
			where_datas[i]=''
			}
    }
    var agenty=<?=json_encode($agenty)?>;	
    var agentf=<?=json_encode($agentf)?>;
    var devfactory=<?=json_encode($devfactory)?>;		
    var investor=<?=json_encode($investor)?>;	
    var devbrand=<?=json_encode($devbrand)?>;		
    var devname=<?=json_encode($devname)?>;	
     var datasNum=0 ;
     if(datas2.total){
         datasNum  =  datas2.total;
      }
if(datas2.total==null){
datas2.total=0
datasNum  =  datas2.total;
}
var time1= where_datas.time1;
var time2= where_datas.time2;
//console.log(where_datas);
var all_use_type=<?=json_encode($all_use_type)?>;
var use_type=<?=json_encode($use_type)?>;
// console.log(where_datas)
</script>
<script type="text/javascript" src="/static/js/water-use/index.js?v=1.9"  charset="utf-8"></script> 
<script type="text/javascript">
// 导出表格
   $('#methodBox').click(function(){
 	       var searc={
	        agentf_id: where_datas.agentf_id||'',
			agenty_id: where_datas.agenty_id||'',
			area: where_datas.area||'',
			city: where_datas.city||'',
			customertype: where_datas.customertype||'',
			devbrand_id: where_datas.devbrand_id||'',
			devfactory_id: where_datas.devfactory_id||'',
			devname_id: where_datas.devname_id||'',
			investor_id: where_datas.investor_id||'',
			province: where_datas.province||'',
			search: where_datas.search||'',
			time1: where_datas.time1||'',
			time2: where_datas.time2||'',
			usetype: where_datas.usetype||'',
            offset:0,
            limit:datasNum
                 }
   // console.log(searc.time1)
   $(this).attr('href','./index.php?r=water-use/get-datas& excel=xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz&time1='+searc.time1+'&time2='+searc.time2+'&province='+searc.province+'&city='+searc.city+'&area='+searc.area+'&agenty_id='+searc.agenty_id+'&agentf_id='+searc.agentf_id+'&devfactory_id='+searc.devfactory_id+'&investor_id='+searc.investor_id+'&devbrand_id='+searc.devbrand_id+'&devname_id='+searc.devname_id+'&usetype='+searc.usetype+'&customertype='+searc.customertype+'&search='+searc.search+'&offset='+searc.offset+'&limit='+searc.limit)
		// layer.close(ii);
 })



</script>
</body>
</html>