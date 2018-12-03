<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>设备统计</title>
      <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
      <link rel="stylesheet" href="./static/css/chosen.css"/>

      <link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
      <link rel="stylesheet" type="text/css" href="./static/css/sales-api/sales-api.css">
      <link rel="stylesheet" href="./static/css/sales-volume/index.css?v=1.1"/>
</head>

<style type="text/css">

    .Hovertitle{
        display: none;
    }
  select{
    height: 30px;
  }
  #date_demo{
     width: 190px;
    height: 30px;
    line-height: 30px;
    line-height: 15px;

    border: none;
    display: inline-block;
}

.chosen-container{
      float: right;    min-width: 100px;    margin-left: 10px;
}

#percentum .tyfole{
      position: absolute;
    right: 10%;
    color:#fff;
}
#percentum .name{
      background-color: #292834;
}
.chosen-container .chosen-results li.highlighted {
    background-color: #3875d7;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(20%, #E46045), color-stop(90%, #E46045));
    background-image: linear-gradient(#E46045 20%, #E46045 90%);
    border-radius: 0px;
    color: #fff;
}

#IsTurnOut_chosen{
    min-width: 90px !important;
}



/*分页*/
  .page_div {
  margin-top:20px;
  margin-bottom:20px;
  font-size:15px;
  font-family:"microsoft yahei";
  color:rgb(233,233,233);
  margin-right:10px;
  padding-left:20px;
  text-align:center;
  box-sizing:border-box;

}
.page_div a {
  min-width:30px;
  height:28px;
  border:0 solid #dce0e0!important;
  text-align:center;
  margin:0 4px;
  cursor:pointer;
  border-radius:5px;
  line-height:28px;
  color:#666;
  font-size:13px;
  display:inline-block
}
#firstPage,#lastPage {
  width:50px;
  color:#0073A9;
  border:1px solid #0073A9!important
}
#nextPage,#prePage {
    width: 28px;
  color:#EE5030;
  background-color:#393E45;
  border:0 solid #393E45!important;
  border-radius:0 10px 10px 0
}
#prePage {
  border-radius:10px 0 0 10px
}
.page_div .current {
  background-color:#EE5030;
  border-color:#0073A9;
  color:#FFF
}
.totalPages {
  margin:0 10px
}
.totalPages span,.totalSize span {

  margin:0 5px;
}


#Jumpnump {
  background:none;
  border-radius:6px;
  border:1px solid #393E45;
  outline:0;
  height: 30px;
  color: #ee5030;
}
#JumpPagesbtn {
  padding:3px 10px;
  border-radius:5px;
  background:#393E45;
  border-color:#666;
  color:#EE5030;
  outline:0;
    border: none;
}
#Jumpdisplay {
  border-color: #666;
      border: none;
    border-radius: 2px;
    width: 60px;
    height: 26px;
    background: #393E45;line-height: 0;

}
#Jumpdisplay option {
  border-color:#666;
  background:#393e45;
  outline:0
}
.shoPpage {
   display: -webkit-inline-box;
  color:rgb(233,233,233);
  width: 170px;
}


.btnHeader{
      position: absolute;
    right: 20px;
    top: 15px;
    padding: 0 10px;
    border-radius: 4px;
    border: none;
    color: #fff;
    background: #d9534f;
}
.btnHeader a{
      color: #fff;
}


.dropdown-menu li {
    padding: 5px 15px;
    cursor: pointer;
    white-space: nowrap;
}
.dropdown-menu {
    color: #000;
    min-width: 100px;
    padding: 5px 0;
    line-height: 15px;
}
  
.dropdown-menu li:hover{
 background-color: #EE5030;
 color:#fff;
}

.layui-layer-title {
  display:none;
}
 .oReturn button {

    background-color: #E46045;
    border-radius: 5px;
    padding: 9px;
    top: 10px;
    right: 10px;
    color: #fff;
    z-index: 10000;
    /*position: absolute;*/
}
</style>
<body>
   <div style="width:100%;text-align: right;padding-bottom: 10px;">
      <a href="./index.php?r=dev-statistics/index"  class="oReturn"><button type="text">返回</button></a>
  </div>
<table class="table" style="background-color: #292834;text-align: center;">
   <thead>
     <tr class="header" style="font-weight: bold">
      <td class="name">设备统计概况  <i class="volumeHover glyphicon glyphicon-question-sign" style="color: #1d1f23">
         <div class="volumeText" >
                  设备统计概况：是用户登记注册激活设备之后的设备数量，和实际用户可能有延迟，可能出现微小误差，一般在0.1%范围内。
         </div>
       </i>
    </td>
    <td>新注册设备 &nbsp;<span style="color:#E46045"></span>&nbsp;</td>
    <td>注销设备  </td>
    <td>净增设备</td>
   <td >累计设备数  <i class="AverageHover glyphicon glyphicon-question-sign" style="color: #1d1f23">
         <div class="AverageHover-text" style="right: 0;top:25px">
                累计设备数为该角色除开已初始化设备，正常使用的设备数量累计。
         </div>
       </i>
    </td>
     </tr>
   </thead>
   <tbody>
    <tr   class="consumer">
      <td  class="name ">设备数量（台）：</td>
      <td id="dev_register"></td>
      <td id="dev_init"></td>
      <td id="dev_growth"></td>
      <td id="dev_total"></td>
    </tr>
    <tr class="relatively" >
      <td class="name" rowspan="4"   style="text-align:center;vertical-align:middle;">同期  <i class="compareHover glyphicon glyphicon-question-sign" style="color: #1d1f23" >
        <div class="compareText">
        同期表示：该销量和上一日、7天、30天、90天的百分比的对比显示
        </div>
      </td>
      <td><p><span>今日：</span><span id="add_today"></span></p></td>
      <td> <p><span>今日：</span><span id="init_today"></span></p></td>
      <td> <p><span>今日：</span><span id="add_today_today"></span></p> </td>
       <td></td>
    </tr>

    <tr>

       <td> <p><span>7天：</span><span id="add_seven_days"></span></p></td>
       <td> <p><span>7天：</span><span id="init_seven_days"></span></p></td>
       <td>  <p><span>7天：</span><span id="add_seven_days_days"></span></p></td>
              <td></td>
    </tr>

    <tr>

      <td> <p><span>30天：</span><span id="add_thirty_days"></span></p></td>
      <td>  <p><span>30天：</span><span id="init_thirty_days"></span></p></td>
      <td>   <p><span>30天：</span><span id="add_thirty_days_days"></span></p></td>
      <td></td>
    </tr>
   </tbody>
</table>
<div style="clear:both;padding:15px"></div>
<div style="padding:0 20px">
    <div class="container-fluid"  >
        <div class="row" style="margin-left: -50px; margin-right: -50px;">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
                <div style="background-color: #292834; color: #fff">
                       <div class="title">
                            <div >
                                <label style="font-weight: border;font-size: 18px;    margin-left: -20px;">
                                   设备情况 
                                </label>
                               <!--  <select  id=goods>
                                   <option value="4">全部商品</option>
                                </select> -->

                         <!-- 时间容器 -->
                                 <div class="selection pull-right" style=' margin-left: 20px;margin-top:-2px'>
                                  <!-- <span  class="selection-text  pull-left">时间段选择：</span> -->
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
                                </div> 
                     
                                <select id='IsTurnOut'>  
                                  <option value ="">选择时间</option>  
                                  <option value ="1">今天</option>  
                                  <option value ="2" selected = "selected">最近7天</option>  
                                  <option value ="3">最近30天</option>  
                                </select>  
                              <select id='dev_state'>  
                                  <!-- <option value ="">选择设备时间</option>  -->
                                  <option value ="1" selected = "selected" >新注册设备</option>  
                                  <option value ="2">注销设备</option>  
                                  <option value ="3">净增设备</option>  
                              </select>  
                            </div>
                       </div>
                     <div id="main"   style=" height:400px;"></div>
                </div>
            </div>


            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
                <div style="background-color: #292834; ">
                 <div id="echarts3"   style="width: 100%;height:400px;min-width: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div style="clear:both;padding:20px 0 "></div>
<div class="container-fluid" style="background-color: #292834;padding: 20px 0px; margin-left: 0px ;">
    <div class="row" style="">
        <div class="col-lg-6 col-md-6col-sm-12 col-xs-12">
            <div id="echarts2"  style="width: 100%;height:360px;" ></div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 Percentage" >
        </div>

         占比 -->
       <!--    <div class="col-lg-4  col-md-4 col-sm-6 col-xs-12">
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
                   
                  </div>
                   <span class="tyfole">60% </span>
                </div> 
                <div class="progress">
                  <span class="name">广东</span>
                  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                   
                  </div>
                   <span class="tyfole">60% </span>
                </div> 
              </div>
            </div>
          </div>
    </div>
</div> -->
<div style="clear:both;padding:20px 0 "></div>
<div class="container-fluid" style="background-color: #32323e;padding:0px; margin-left: 0px ;padding-top: 20px;color:#fff">
          <div class="selection pull-left" style='margin-left: 20px;'>
          <span  class="selection-text  pull-left">时间选择：</span>

            <!-- <div class="dataUlLI  pull-left"  >
                  <ul class="selection-time" >
                    <li value = "1" style='border-radius: 4px'><p type="">今日</p></li>
                    <li  value = "2"><p type="">昨日</p></li>
                    <li  value = "3"><p type="text">最近7天</p></li>
                    <li class="activer"  value = "4"><p type="">最近30天</p></li>
                    <li  value = "5"><p style="border-right:none;border-radius: 3px;" type="">最近90天</p></li>
                  </ul>
              </div> -->
       </div>

               <!-- 时间容器 -->
         <div class="selection pull-left" style='margin-left: 30px;    margin-left: 20px;    display: inline-block;
    min-width: 900px;'>
          <!-- <span  class="selection-text  pull-left">时间段选择：</span> -->
               <div class="ta_date" id="div_date_demo2">
                    <span class="date_title" id="date_demo2">请选择时间段</span>
                    <a class="opt_sel" id="input_trigger_demo2" href="#">
                        <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
                    </a>
                 </div>
       
            <div id="datePicker2"></div>
             <span  class="selection-text  pull-left" style='margin-left: 30px;'>搜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;索：</span>
                  <div class="wrap_line" style="    display: initial;    background-color: #32323e;">
                     <input style='background-color: #393e45;border: none;width: 250px; text-indent: 1em;' type="text" name="search"  id="search" value="" placeholder="请输入关键字">

                   
                  </div>

                       <div id="selectionBg" style="display: inline;">
                    <!-- 条件按钮 -->
                             <div class="submitBtn"  style='display: inline-block;margin-left: 30px;' >
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <button type="submit" class="btn " id="submit" style='width: 100px'>   查看</button>
                              &nbsp;&nbsp;
                              <button type="text"  class="btn " id="removerSub"   style='width: 100px'>清空条件</button>
                              </div>
                             </div>
          </div>
          <div style="display: none">
                    <input type="text" name="time1" id="time1sub2"  value="3">
                    <input type="text" name="time2" id="time2sub2" value="">
          </div> 

          <div style="clear:both; height: 20px;"></div>
                             <!-- 搜索容器 -->
     
<div style="clear:both; "></div>
     <div class="tableBox" style="position: relative;height: 100%;">
        <span  id="method" >导出表格</span>
   <!--      <caption>
                <div  class="navdata" column='ActiveTime'>
                    <ul >
                       <p style='margin-left: 10px;background-color:#363643'>角色选择:</p>
                        <li class="active">用户</li>
                        <li>服务中心</li>
                        <li>运营中心</li>
                        <li>设备厂家</li>
                        <li>设备投资商</li>
                        <li>酒店中心</li>
                        <li>片区中心</li>
                    </ul>
                </div>
            </caption> -->
         <table id="table" style ="width:100%;text-align: center; position: relative; ">
             <thead>  

                   <tr>
                     <th>序号</th>
                     <th>用户姓名</th>
                     <th>联系电话</th>
                     <th>设备编号</th>
                     <th>设备商品型号</th>
                     <th>设备品牌</th>
                     <th>地区</th>
                     <th>购水套餐</th>
                     <th>用户类型</th>
                     <th class="connect"  date='2'><a href='javascript:void(0)' >激活时间</a></th>
                 </tr>
             </thead>
             <tbody id="tableBoxData">

             </tbody>
              <!-- <div style="clear:both; "></div> -->
         </table>

       </div>
        <!-- <div style="clear:both; "></div> -->

  </div>
 <!-- <div style="clear:both; "></div> -->
<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
    <div id="page" class="page_div"></div>
</div>

</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>  
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<!-- <script type="text/javascript" src="/static/js/sales-volume/map.js"  charset="utf-8"></script>  -->
<script src="/static/js/echarts/echarts.js"></script>
<script src="/static/js/echarts/dist/echarts.js"></script>
<script type="text/javascript" src="/static/js/dev-statistics/paging.js"></script>
<script type="text/javascript" src="/static/js/dev-statistics/common.js?v=1.1"></script>
<script>
        var role_id=<?=json_encode($role_id)?>;
        var LoginName=<?=json_encode($LoginName)?>;
        // console.log(role_id)
        // console.log(LoginName)
   var LoginObj =''
   var empty={};
 var ii=layer.msg("加载中……");
 $("#time1sub,#time1sub2").val(GetDateStr(-6,1))
$("#time2sub,#time2sub2").val(GetDateStr(0,1))           
var typstartDate = GetDateStr(-6,1)
var typendDate = GetDateStr(0,1)
 new pickerDateRange('date_demo2', {
      // aRecent7Days : 'aRecent7DaysDemo', //最近7天
      isTodayValid: true,
      startDate: typstartDate,
      endDate:typendDate,
      //needCompare : true,
      //isSingleDay : true,
      //shortOpr : true,
      //autoSubmit : true,
      defaultText: ' 至 ',
      // format : 'YYYY-MM-DD HH:mm:ss', //控件中from和to 显示的日期格式
      inputTrigger: 'input_trigger_demo',
      theme: 'ta',
      success: function(obj) {
          $("#time1sub2").val(obj.startDate)
          $("#time2sub2").val(obj.endDate)
      $('.dataUlLI .activer').removeClass('activer');  
          if(!obj.endDate){
              $("#time2sub2").val(GetDateStr(0,1))  
                 obj.endDate= GetDateStr(0,1);
              $("#date_demo2").html(obj.startDate + '至' + obj.endDate);
            }
      }
    });

 

      var total = 0;

$("#method").click(function() {
  var methodOneData   ='[{"Name":"用户姓名"},{"Tel":"联系电话"},{"DevNo":"设备编号"},{"GoodsName":"设备商品型号"},{"BrandName":"设备品牌"},{"Address":"地址"},{"UseType":"购水套餐"},{"CustomerType":"用户类型"},{"ActiveTime":"激活时间"}]';

 var methodTwoData   ='[{"Name":"用户姓名"},{"Tel":"联系电话"},{"DevNo":"设备编号"},{"GoodsName":"设备商品型号"},{"BrandName":"设备品牌"},{"agentFname":"服务中心"},{"UseType":"购水套餐"},{"CustomerType":"用户类型"},{"ActiveTime":"激活时间"}]';

  var methodThreeData ='[{"Name":"用户姓名"},{"Tel":"联系电话"},{"DevNo":"设备编号"},{"GoodsName":"设备商品型号"},{"BrandName":"设备品牌"},{"agentYname":"运营中心"},{"UseType":"购水套餐"},{"CustomerType":"用户类型"},{"ActiveTime":"激活时间"}]';

var methodFourData  ='[{"Name":"用户姓名"},{"Tel":"联系电话"},{"DevNo":"设备编号"},{"GoodsName":"设备商品型号"},{"BrandName":"设备品牌"},{"agentYname":"运营中心"},{"CustomerType":"用户类型"},{"ActiveTime":"激活时间"}]';

['序号','设备投资商','联系电话','设备编号','设备商品型号','设备品牌','地址','购水套餐','激活时间'];
var methodFiveData  ='[{"Name":"用户姓名"},{"Tel":"联系电话"},{"DevNo":"设备编号"},{"GoodsName":"设备商品型号"},{"BrandName":"设备品牌"},{"Address":"地址"},{"UseType":"购水套餐"},{"ActiveTime":"激活时间"}]';

var methodSixData   ='[{"Name":"用户姓名"},{"Tel":"联系电话"},{"DevNo":"设备编号"},{"GoodsName":"设备商品型号"},{"BrandName":"设备品牌"},{"agentFname":"服务中心"},{"UseType":"购水套餐"},{"CustomerType":"用户类型"},{"ActiveTime":"激活时间"}]';
// alert(activeNum)

      var time1subDate=  $("#time1sub2").val();
      var time2subDate=  $("#time2sub2").val();
      var searchp=$("#search").val()
      var title_column = methodOneData;


         if(role_id==5){
          title_column=methodOneData;
        }else 
        if(role_id==3||role_id==7){
            title_column=methodTwoData;
        }else  if(role_id==4||role_id==6){
          title_column=methodFourData;
        }else if(role_id==10){
          title_column=methodFiveData;
        };
  

      var obj = {
        "role_id": role_id,
        'LoginName:':LoginName,
        "starttime": time1subDate,
        "endtime": time2subDate,
        'search':searchp,
        'title_column':title_column
      }

 console.log(obj)
 console.log(total)
// alert()

 window.location.href="./?r=dev-statistics/get-user&role_id="+role_id+"&LoginName="+LoginName+"&starttime="+time1subDate+"&offset=0&limit="+total+"&endtime="+time2subDate+"&search="+searchp+"&title_column="+title_column+"&sort=2";

})

</script>
<script type="text/javascript" src="/static/js/dev-statistics/index2.js?v=1.3  "></script>
</html>