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

</style>
<body>
<div id='water_use'>
	<!--内容主题-->
	<form action="./index.php?r=sales-volume/index" method="post" accept-charset="utf-8">
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
                        <select class="control-label" name="waterfactory_precode"  id="waterfactory_precode" class="waterfactory_precode">
                                <option value="" selected>请选择水厂</option>
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

                        <select class="control-label" name="waterbrand_id"  id="waterbrand_id" class="waterbrand_id">
                                <option value="" selected>请选择水品牌</option>
                        </select>
                        <select class="control-label" name="watername_id"  id="watername_id" class="watername_id">
                                <option value="" selected>请选择水商品</option>
                        </select>
                        <select class="control-label" name="water_volume"  id="water_volume" class="water_volume">
                                <option value="" selected>请选择水商品容量</option>
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

	</form>
</div>
     <div class='page-head'>
        <header  class="header" style="position: relative;">
          <div class='pull-left'>
               <div class="selection Title">
                <img src="/static/images3/sidebar.png" alt="搜索" >
                <span class="font-size-S" >&nbsp;销量概况</span>
            
             <div class='Hovertitle'>
              <div  class="volumeHover">  </div>

              <div class="volumeHover-text">
                <p> 销量概况统计的是用户通过设备扫过条码的数量，表示销量，和实际销量有延迟，可能出现微小误差，一般在5%范围内。</p>
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
                <th>用户销量： &nbsp;<span style="color:#E46045">(袋)</span>&nbsp;</th>
                <th>同期  &nbsp;
                   
                  <div class='Hovertitle'>
                    <div  class="compareHover"> </div>

                    <div class="compareHover-text">
                      <p> 同期表示：该销量和上一日、7天、30天、90天或者选择的时间段的百分比的对比显示</p>
                    </div>
                  </div>

                </th>
                <th>用户总数（人）</th>
                <th>客户均销量  &nbsp;<span style="color:#E46045">(袋)</span>&nbsp;
                  <div class='Hovertitle'>
                    <div  class="AverageHover"> </div>
                    <div class="AverageHover-text">
                      <p> 客户均销量：为所有用户的销量除以用户总数量的结果数据，数据实时动态变化</p>
                    </div>
                  </div>
                </th>
                <th>今年累计销量  &nbsp;<span style="color:#E46045">(袋)</span>
                  <div class='Hovertitle'>
                    <div  class="pageHover">  </div>
                    <div class="pageHover-text">
                    <p>今年累计销量：为所有用户从1月1日开始的累计销量</p>
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
            <span class="font-size-S">&nbsp;销量概况 :&nbsp;<span style="color:#E46045;font-weight:400;font-size:12px">单位 ：袋  </span></span>  
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
                      <span class="font-size-S">&nbsp;全国销量分布情况:<span style="color:#E46045">单位 ：(袋 )  </span></span>
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
                      <span class="font-size-S">&nbsp;用户类型净增占比:<span style="color:#E46045">单位 ：(袋) </span></span>
                      <div class='pull-right' style='height: 30px;line-height: 30px;'>
                      <span class='data-view'><img src="/static/images3/chankan.png"  ></span>
                      <span class='data-refresh'><img src="/static/images3/shuaxin.png"  ></span>
                      &nbsp;
                      <div id='dataView'>
                         <table  class="table" style=' width: 200px;border-radius: 5px;background: #fff; border-collapse: collapse;' >
                          <thead>
                            <tr>
                              <th  colspan="2" style="position: relative;color:#fff">用户类型净增占比
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
                  <div class = 'baifenbiA'style="right:0">
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
                <a href=""  id="methodBox" >
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
                    <th>水厂条码</th>
                    <th>水厂</th>
                    <th>水品牌</th>
                    <th>商品名称</th>
                    <th>商品容量：<span style="    color: #E46045;">L</span></th>
                    <th>商品设备型号</th>
                    <th>设备品牌</th>
                    <th>设备厂家</th>
                    <th>设备投资商</th>
                    <th>服务中心</th>
                    <th>运营中心</th>
                    <th>地区</th>
                    <th>入网属性</th>
                    <th>用户类型</th>
                    <th>扫码时间</th>
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

<script type="text/javascript" src="/static/js/jquery.min.js"></script>

<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript">

  var iy =  layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });



</script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>	
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script src="/static/js/echarts/echarts.js"></script>
<script src="/static/js/echarts/dist/echarts.js"></script>
<script type="text/javascript" src="/static/js/sales-volume/map.js?v=2.4"  charset="utf-8"></script> 
<script type="text/javascript" src="/static/js/sales-volume/lineChart.js?v=2.4"  charset="utf-8"></script> 
<script type="text/javascript" src="/static/js/Common2.js"></script>
<script type="text/javascript" src="/static/js/paging3.js"></script>
<script type="text/javascript">

    // 地址数据
	var data=<?=json_encode($areas)?>;
// 概况数据
    var datas=<?=json_encode($datas)?>;

    // console.log(datas)
    //状态选取
    var  where_datas = {
   	     province:<?=json_encode($province)?>,
   	     city:<?=json_encode($city)?>,
   	     area:<?=json_encode($area)?>,
   	     agentf_id:<?=json_encode($agentf_id)?>,
   	     agenty_id:<?=json_encode($agenty_id)?>,
   	     devfactory_id:<?=json_encode($devfactory_id)?>,
   	     investor_id:<?=json_encode($investor_id)?>,
   	     waterfactory_precode:<?=json_encode($waterfactory_precode)?>,
   	     devbrand_id:<?=json_encode($devbrand_id)?>,
   	     devname_id:<?=json_encode($devname_id)?>,
   	     waterbrand_id:<?=json_encode($waterbrand_id)?>,
   	     watername_id:<?=json_encode($watername_id)?>,
   	     water_volume:<?=json_encode($water_volume)?>,
   	     time1:<?=json_encode($time1)?>,
   	     time2:<?=json_encode($time2)?>,
   	     search:<?=json_encode($search)?>,
   	     usetype:<?=json_encode($usetype)?>,
   	     customertype:<?=json_encode($customertype)?>
   }
    // console.log(where_datas)
    //运营中心
   	var agenty=<?=json_encode($agenty)?>;
   	//服务中心
    var agentf=<?=json_encode($agentf)?>;
   // 设备厂家
    var devfactory=<?=json_encode($devfactory)?>;
// 设备投资商
    var investor=<?=json_encode($investor)?>;
    //水厂
    var factory=<?=json_encode($factory)?>;
    // 设备品牌
    var devbrand=<?=json_encode($devbrand)?>;
    // 设备型号
    var devname=<?=json_encode($devname)?>;
    //水品牌
    var waterbrand=<?=json_encode($waterbrand)?>;
    //水商品
    var watername=<?=json_encode($watername)?>;
    // 水容量
    var watervolume=<?=json_encode($watervolume)?>;
    var offset=<?=json_encode($offset)?>;
    var limit=<?=json_encode($limit)?>;
    var all_use_type=<?=json_encode($all_use_type)?>;
    var use_type=<?=json_encode($use_type)?>;
    var role_id=<?=json_encode($role_id)?>;
    var factory_precode=<?=json_encode($factory_precode)?>;
    // console.log(role_id)
    // console.log(where_datas)
if(role_id==2){
   var html = $("#selectionBg").html()
   $("#agenty_id,#agentf_id,#devfactory_id,#investor_id,#devbrand_id,#devname_id,.head-txt:last-of-type").remove()
   $(".head-txt:last-of-type").append(html);
   $("#methodBox").remove()
}

//导出表格
   $("#methodBox").click(function() {
    if(role_id==2){
      
    }
         var time1h = $("#time1sub").val()||where_datas.time1||'';
         var time2h = where_datas.time2||'';

       var province = where_datas.province||'';
       var city =  where_datas.city||'';
        var area =  where_datas.area||'';

         var agenty_id = $('#agenty_id option:selected').val()||'';
         var agentf_id = $('#agentf_id option:selected').val()||'';
         var devfactory_id = $('#devfactory_id option:selected').val()||'';

         var investor_id = $('#investor_id option:selected').val()||'';
         var waterfactory_precode = $('#waterfactory_precode option:selected').val()||'';
        var devbrand_id = $('#devbrand_id option:selected').val()||'';
        var devname_id = $('#devname_id option:selected').val()||'';
        var waterbrand_id = $('#waterbrand_id option:selected').val()||'';

         var watername_id = $('#watername_id option:selected').val()||'';
         var watervolume = $('#watervolume option:selected').val()||'';
         var usetype = $('#usetype option:selected').val()||'';
         var customertype = $('#customertype option:selected').val()||'';
         var search = $('#search').val()||'';
         var limit= datas[0].total||'';
       // var datasNum  =  datas[0].total;
       
        // console.log(time1h)

      $(this).attr('href','/index.php?r=sales-volume/get-datas&time1=5&excel=xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz&limit='+limit+'&offset=0&time1='+time1h+'&time2='+time2h+'&province='+province+'&city='+city+'&area='+area+'&agenty_id='+agenty_id+'&agentf_id='+agentf_id+'&devfactory_id='+devfactory_id+'&investor_id='+investor_id+'&waterfactory_precode='+waterfactory_precode+'&devbrand_id='+devbrand_id+'&devname_id='+devname_id+'&waterbrand_id='+waterbrand_id+'&watername_id='+watername_id+'&watervolume='+watervolume+'&usetype='+usetype+'&customertype='+customertype+'&search='+search)
       });

   // alert(4)
</script>
<script type="text/javascript" src="/static/js/sales-volume/index.js?v=1.6"></script>
</body>
</html>