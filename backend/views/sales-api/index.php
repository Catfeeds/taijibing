<!DOCTYPE html>
<html>
<head>
  <title>销量统计</title>

  <link rel="stylesheet" href="/static/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
  <!-- <link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/> -->
  <link rel="stylesheet" href="./static/css/chosen.css"/>
  <!-- <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/> -->
  <!-- <link rel="stylesheet" href="./static/css/sales-volume/index.css?v=1.1"/> -->
    <link rel="stylesheet" href="./static/css/sales-volume/index.css?v=1.1"/>
  <link rel="stylesheet" type="text/css" href="./static/css/sales-api/sales-api.css">
</head>
<style type="text/css" media="screen">
body{
background-color: #363643;
}
.chosen-container{
      width: 74px;
    float: right;
    right: 25px;
    min-width: 100px;
}
.chosen-container .chosen-results li.highlighted {
    background-color: #3875d7;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(20%, #E46045), color-stop(90%, #E46045));
    background-image: linear-gradient(#E46045 20%, #E46045 90%);
    border-radius: 0px;
    color: #fff;  
}
.chosen-container .chosen-results {
    padding: 0;
}
.chosen-container .chosen-results li.active-result{
width:100%;
text-align: left

}
.tfData select,.tfData .chosen-container{
      min-width: 50px;
      margin-left:10px;
}
.tfData button, .tfData input {
    background: #393e45;
    border-radius: 5px;
}
.pagination-sm>li:last-child>a, .pagination-sm>li:last-child>span,.pagination-sm>li:first-child>a, .pagination-sm>li:first-child>span{
      background: #393e45;
}


 .pagination-sm>li:first-child>span:hover,.pagination-sm>li:last-child>span:hover {
    border: none; color: #fff;  
    background: #393e45;
}
.selection{
      color: #C2C2C5;
}

#selectionBg{
    position: absolute;
    top: 0;
    right: -300px;
    width: 300px;
}
.navdata li {
margin-left: 0
}

#date_demo{
     width: 200px;
    height: 30px;
    line-height: 30px;
    line-height: 15px;

    border: none;
    display: inline-block;
}
.tableBox{
  height:100%;
}

.tfData{
   color: #fff;
}

    .tfData,.tfData span{
    font-size: 12px;
    display: -webkit-inline-box;
    line-height: 30px;
    }
    .pagination > li > a, .pagination > li > span{
    border:none;
    }
    .pagination > li > a:hover, .pagination > li > span:hover{
    background-color: #292834
    }
    .tfbody li   {
    display: inline;
   cursor:pointer;
    color: #fff;
    border: none;
    font-size: 12px;
    /*background-color: #363643;*/
    color: inherit;
    float: left;
    line-height: 29px;
    margin-left: -1px;
    padding: 0px 10px;
    }


.pagination>li>a, .pagination>li>span{
      background-color: #292834;   
        color: #fff;
 }

 #page .active{
   border-radius: 5px;
 }
</style>
<body>
  <table class="table" style="background-color: #292834;text-align: center;">
   <thead>
     <tr class="header" style="font-weight: bold">
      <td class="name">销量概况  <i class="volumeHover glyphicon glyphicon-question-sign" style="color: #01B1D6">
         <div class="volumeText" >
          销量概况统计的是用户通过设备扫过条码的数量，表示销量，和实际销量有延迟，可能出现微小误差，一般在5%范围内。日期是表示近7天，最近30天，最近90天的时间
         </div>
       </i>
    </td>
      <td> 今天</td>
      <td>昨天</td>
      <td>7天</td>
      <td>30天</td>
      <td>90天</td>
    </tr>
   </thead>
   <tbody>
    <tr class="consumer">
      <td class="name ">用户销量（袋）</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr  class="relatively" >
      <td class="name ">同期  <i class="compareHover glyphicon glyphicon-question-sign" style="color: #01B1D6" >
        <div class="compareText">
             同期表示：该销量和上一日、7天、30天、90天的百分比的对比显示
        </div>
      </td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr class="equally">
      <td class="name ">客户均销量 <i class="AverageHover glyphicon glyphicon-question-sign" style="color: #01B1D6" >
        <div class="AverageText">
          平均销量：为所有用户的销量除以用户总数量的结果数据，数据实时动态变化
        </div>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
   </tbody>
</table>


<div style="clear:both;padding:15px"></div>
<div style="padding:0 20px">
    <div class="container-fluid"  >
        <div class="row" style="margin-left: -50px; margin-right: -50px;">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                <div style="background-color: #292834; color: #fff">
                       <div class="title">
                            <div >
                                <label >
                                   销量情况 
                                </label>
                               <!--  <select  id=goods>
                                   <option value="4">全部商品</option>
                                </select> -->
                                <select id='IsTurnOut' value='3'>  
                                  <option value ="1">今天</option>  
                                  <option value ="2">昨天</option>  
                                  <option selected = "selected" value ="3">7天销量</option>  
                                  <option value ="4">30天销量</option>  
                                  <option value="5">90天销量</option>
                                  <option value="6">今年销量</option>
                                </select>  
                            </div>
                       </div>
                     <div id="charts2"   style=" height:400px;"></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                <div style="background-color: #292834; ">
                 <div id="charts5"   style="width: 100%;height:400px;min-width: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="clear:both;padding:20px 0 "></div>
<div class="container-fluid" style="background-color: #292834;padding: 20px 0px; margin-left: 0px ;">
    <div class="row" style="">
        <div class="col-lg-6 col-md-6col-sm-12 col-xs-12">
            <div id="charts"  style="width: 100%;height:360px;" ></div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 Percentage"  id="Percentage">
        </div>
    </div>
</div>
<div style="clear:both;padding:20px 0 "></div>

<div class="container-fluid" style="background-color: #32323e;padding: 20px 0px; margin-left: 0px ;min-height: 400px;padding: 0px;">
        <div class="selection pull-left" style='margin-left: 20px;'>
          <span  class="selection-text  pull-left">时间选择：</span>

          <div class="dataUlLI  pull-left"  >
                <ul class="selection-time" >
                  <li value = "1" style='border-radius: 4px'><p type="">今日</p></li>
                  <li  value = "2"><p type="">昨日</p></li>
                  <li  value = "3"><p type="text">最近7天</p></li>
                  <li class="activer"  value = "4"><p type="">最近30天</p></li>
                  <li  value = "5"><p style="border-right:none;border-radius: 3px;" type="">最近90天</p></li>
                </ul>
            </div>
       </div>
        <!-- 时间容器 -->
         <div class="selection pull-left" style='margin-left: 30px;    margin-left: 20px;'>
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


<div style="clear:both; "></div>
                             <!-- 搜索容器 -->
             <div class="selection pull-left" id="searchbg" style='position:relative;    margin: 15px 0;margin-left: 20px;'>
               <span  class="selection-text  pull-left">搜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;索：</span>
                  <div class="wrap_line" style="    display: initial;">
                     <input style='background-color: #393e45;border: none;width: 250px; text-indent: 1em;' type="text" name="search"  id="searchp" value="" placeholder="请输入关键字">

                   
                  </div>

                       <div id="selectionBg">
                    <!-- 条件按钮 -->
                             <div class="submitBtn"  style='display: inline-block;margin-left: 10%;' >
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <button type="submit" class="btn " id="submit" style='width: 100px'>   查看</button>
                              &nbsp;&nbsp;
                              <button type="text"  class="btn " id="removerSub"   style='width: 100px'>清空条件</button>
                              </div>
                             </div>
             </div>
<div style="clear:both; "></div>
     <div class="tableBox" style="position: relative;">
        <span  id="method" >导出表格</span>
        <caption>
                <div  class="navdata">
                   
                    <ul >

                       <p style='margin-left: 10px;background-color:#363643'>角色选择:</p>
                        <li class="active">用户</li>
                        <li>服务中心</li>
                        <li>运营中心</li>
                        <li>水厂</li>
                        <li>设备厂家</li>
                        <li>设备投资商</li>
                    </ul>
                </div>
            </caption>
         <table id="table" style ="width:100%;text-align: center; position: relative;">
             
             <thead>  

                   <tr>
                     <th>序号</th>
                     <th>用户姓名</th>
                     <th>联系电话</th>
                     <th>设备编号</th>
                     <th>服务中心</th>
                     <th>运营中心</th>
                     <th>地区</th>
                     <th>用户类型</th>
                     <th><a href='javascript:void(0)'>销量</a></th>
                 </tr>
             </thead>
             <tbody id="tableBoxData">
             </tbody>
         </table>
         <div style="clear:both; "></div>
       </div>
<div style="  position: relative;margin: auto; width: 100%;text-align: center; height: 100px;">
    <div id="page" class="page_div">
         <div class="tfbody" style="text-align: center; padding: 20px;width: 100%;margin:auto;">
                <nav aria-label='Page navigation' style='     display: initial;  margin-top: -25px;padding-right: 20px;'>
                  <ul class='pagination pagination-sm' id='Circula' style=' margin: -10px;'>
                    <li class="Previous">
                            <span aria-hidden='true'>&laquo;</span>
                    </li>
                     <!-- <li  class='hort'><a href='#'>1</a></li> -->
    
                    <li class="Next">
                        <span aria-hidden='true'>&raquo;</span>
                    </li>
                  </ul>
                </nav> 

               <div class="tfData">
                <span>跳转到：</span> 
                <input type="number" id="sconter" value="1" max='' min="1"> 
                 <button type="btn" id="btn" value="确定"><a href="javascript:void(0)">确定</a></button>
                <span>每页显示：&nbsp;&nbsp;
                      <select type='text' name='page_size' id='page_size' style='width:50px;background-color:#292834;border-radius:5px;border:none;'>
                      <option value='10'>10</option>
                      <option value='20'>20</option>
                      <option value='50'>50</option>
                      </select> 
                      </span>&nbsp;&nbsp;&nbsp;&nbsp;当前显示：第
                       <span id='numTotal'> 1</span>页
                         &nbsp;&nbsp;&nbsp;&nbsp;
                  <span id='Total'> 共：0 条</span>
                </div> 
              </div>
    </div>
</div>


</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
  <script type="text/javascript">
       var ii=layer.msg("加载中……");
      var role_id='<?=$role_id  ?>';
      var LoginName='<?=$LoginName ?>';
      var total = 0;
  </script>
<script type="text/javascript" src="/static/js/dateRange.js"></script>  
<script src="/static/js/echarts/echarts.js"></script>
<script src="/static/js/echarts/dist/echarts.js"></script>
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="./static/js/sales-api/communal.js"></script>
<script type="text/javascript" src="./static/js/sales-api/map.js"></script> 

<script>

     // 、、当前时间
     function GetDateStr(AddDayCount, AddMonthCount) {
       var dd = new Date();
       dd.setDate(dd.getDate() + AddDayCount); //获取AddDayCount天后的日期
       var y = dd.getFullYear();
       var m = dd.getMonth() + AddMonthCount; //获取当前月份的日期
       var d = dd.getDate();
       if (String(d).length < 2) {
         d = "0" + d;
       }
       if (String(m).length < 2) {
         m = "0" + m;
       }
         return y + "-" + m + "-" + d;
     };
       $("#time1sub").val(GetDateStr(-29,1))
        $("#time2sub").val(GetDateStr(0,1))
   // 时间选择
    var dateRange = new pickerDateRange('date_demo', {
      // aRecent7Days : 'aRecent7DaysDemo', //最近7天
      isTodayValid: true,
      startDate: '',
      endDate:'',
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

  $("#IsTurnOut").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
  // $("#page_size").chosen(); //初始化chosen
var xin = 7;
function NumberDays(xin) {
  var _date = []
  for (var i = 0; i >= -xin + 1; i--) {
    _date.push(GetDateStr(i, 1))
      // console.log(GetDateStr(i,1))
  }
  _date.reverse();
return _date;
}
var _date = NumberDays(xin)
    javaData(_date,'','./?r=sales-api/sales-detail-line')
var time_id = {
  'time': 3
}
$("#IsTurnOut").change(function() {
  var ss = $(this).children('option:selected').val();
  layer.msg("加载中……");
  // alert(ss)
  if (ss == "1") {
    time_id = {
      'time': '1'
    }
    xin = 1;
    // _date=['0:00','6:00','12:00','16:00','22:00'];
     _date =_date =NumberDays(xin)
    
    javaData(_date, time_id,'./?r=sales-api/sales-detail-line')
  } else if (ss == "2") {
    time_id = {
      'time': '2'
    }
    
    xin = 2;
    _date =_date =NumberDays(xin)
    // date=['0:00','6:00','12:00','16:00','22:00'];
    // NumberDays(xin)
    javaData(_date, time_id,'./?r=sales-api/sales-detail-line')

  } else if (ss == "3") {
    time_id = {
      'time': '3'
    }
    xin = 7;
        _date =NumberDays(xin)
    // NumberDays(xin)
    javaData(_date, time_id,'./?r=sales-api/sales-detail-line')
  } else if (ss == "4") {
    time_id = {
      'time': '4'
    }
    xin = 30;

      // console.log(_date)
    _date = NumberDays(xin)
   
    javaData(_date, time_id,'./?r=sales-api/sales-detail-line')
  } else if (ss == "5") {
    time_id = {
      'time': '5'
    }
    xin = 90;
    // _date = []
    // NumberDays(xin)
      _date =NumberDays(xin)
      javaData(_date, time_id,'./?r=sales-api/sales-detail-line')
  } else if (ss == "6") {
    time_id = {
      'time': '6'
    }
    xin = 360;
    _date =NumberDays(xin)
    // console.log(_date)
     javaData(_date, time_id,'./?r=sales-api/sales-detail-line')
  } else {

    xin = 7;
    _date =NumberDays(xin)
    javaData(_date, time_id,'./?r=sales-api/sales-detail-line')
  }
});


           // console.log(role_ide)
           // 销量概况
           // var time_id = {
           //   'time': '5',
           //   'role_id': role_ide,
           //   'LoginName': LoginNam
           // }
           // // _detail(time_id)
           _hover($(".volumeHover"), $(".volumeText"))
           _hover($(".compareHover"), $(".compareText"))
           _hover($(".AverageHover"), $(".AverageText"))

// 访问--数据计算
 _detail(time_id,'./?r=sales-api/sales-detail')
var   activeNum=1;
$(".navdata li").on('click', function() {
layer.msg("加载中……");
// alert(1)
     activeNum = ($(".navdata ul li").index(this)) + 1;
     $(".navdata .active").removeClass('active');
     $(this).addClass('active')




     // begin_linlst_time_clea()

   var time1subDate=  $("#time1sub").val();
   var time2subDate=  $("#time2sub").val();
   var parameter = {
    "state": activeNum,
    "startime": time1subDate,
    "endtime": time2subDate,
    "offset": 0,
    'limit': 10,
    'sort':'1',
    'column':'total_sales',
    "search": $("#searchp").val()
  }
  console.log(parameter)
  rendering(parameter)



})

// 排序
$(document).on('click','.connect',function(){
  // alert(4)

  var ii= layer.msg("加载中……");
  var connectDate=$(this).attr('date')*1;
    // console.log(connectDate)
        connectDate++
      if(connectDate>=4){
          connectDate=2
        }
       $(".connect").attr('date','2');

      $('connect_date').removeClass('connect_date')
      $(this).attr('date',connectDate)

      $(this).addClass('connect_date');
   var time1subDate=  $("#time1sub").val();
   var time2subDate=  $("#time2sub").val();
var    salesTxt = $(this).text()
   var column='sales';
       if(salesTxt=='家庭用户'){
        column='family_sales'
       }else if(salesTxt=='公司用户'){
        column='company_sales'
       }else if(salesTxt=='集团用户'){
        column='group_sales'
       }else if(salesTxt=='其它'){
        column='other_sales'
       }else if(salesTxt=='总销量'){
        column='total_sales'
       }else if(salesTxt=='总设备数'){
        column='dev_total'
       }else if(salesTxt=='设备平均销量'){
        column='average_sales'
       }
    
     $(this).attr('column',column);

   var parameter = {
      "state": activeNum,
      "startime": time1subDate,
      "endtime": time2subDate,
      "offset": 0,
      'limit': 10,
      'sort':connectDate,
      'column':column,
      "search": $("#searchp").val()
    }
    console.log(parameter);
      rendering(parameter)


}).on('click','#submit',function(){
// console.log(activeNum)
   
  var ii= layer.msg("加载中……");
   var time1subDate=  $("#time1sub").val();
   var time2subDate=  $("#time2sub").val();
   var parameter = {
    "state": activeNum,
    "startime": time1subDate,
    "endtime": time2subDate,
    "offset": 0,
    'limit': 10,
    "search": $("#searchp").val()
  }


 console.log(parameter)
  rendering(parameter)
}).on('click', '#btn a', function() {

  var ii= layer.msg("加载中……");
  var sconter = $('#sconter').val(); //输入页
  console.log(sconter)
$('#numTotal').html(sconter);

// begin_linlst_time_clea()


   // console.log($('.hort',this).index())

      var page_size = $('#page_size option:selected').val()
       var  connect=  $(".connect_date").attr('date')||'3';
       var  connectTxt=$(".connect_date").attr('column')||'total_sales';
        var time1subDate=  $("#time1sub").val();
       var time2subDate=  $("#time2sub").val();
            if(activeNum==1){
                     connectTxt=$(".connect_date").attr('column')||'sales';
             }
       // console.log(connect)
       // console.log(connectTxt)
         var parameter = {
            "state": activeNum,
            "startime": time1subDate,
            "endtime": time2subDate,
            "offset": sconter * page_size - page_size, //起始,
            'limit': page_size,
            'sort':connect,
            'column':connectTxt,
            "search": $("#searchp").val()
          }

        // $('#numTotal').html(e);
       // console.log(parameter)
       rendering(parameter)
}).on('click', ".Previous", function() {
   var ii= layer.msg("加载中……");
    var sconter = $('#numTotal').text()*1-1; //当前页数
      if(sconter<=1){
      sconter=1
    }
    $('#numTotal').html(sconter);
  var page_size = $('#page_size option:selected').val()
     var  connect=  $(".connect_date").attr('date')||'3';
       var  connectTxt=$(".connect_date").attr('column')||'total_sales';
        var time1subDate=  $("#time1sub").val();
       var time2subDate=  $("#time2sub").val();
            if(activeNum==1){
                     connectTxt=$(".connect_date").attr('column')||'sales';
             }

       // console.log(connect)
       // console.log(connectTxt)
         var parameter = {
            "state": activeNum,
            "startime": time1subDate,
            "endtime": time2subDate,
            "offset": sconter * page_size - page_size, //起始,
            'limit': page_size,
            'sort':connect,
            'column':connectTxt,
            "search": $("#searchp").val()
          }
        // $('#numTotal').html(e);
       console.log(parameter)
       rendering(parameter)
})
.on('click', ".Next", function() {
  var ii= layer.msg("加载中……");
    var sconter = $('#numTotal').text()*1+1; //当前页数
   var currenttotal = Math.ceil(total / page_size)
if(sconter>=currenttotal){
  sconter=currenttotal
}


    $('#numTotal').html(sconter);
   var page_size = $('#page_size option:selected').val()
       var  connect=  $(".connect_date").attr('date')||'';
   var  connect=  $(".connect_date").attr('date')||'3';
       var  connectTxt=$(".connect_date").attr('column')||'total_sales';
        var time1subDate=  $("#time1sub").val();
       var time2subDate=  $("#time2sub").val();
            if(activeNum==1){
                     connectTxt=$(".connect_date").attr('column')||'sales';
             }

       // console.log(connect)
       // console.log(connectTxt)
         var parameter = {
            "state": activeNum,
            "startime": time1subDate,
            "endtime": time2subDate,
            "offset": sconter * page_size - page_size, //起始,
            'limit': page_size,
            'sort':connect,
            'column':connectTxt,
            "search": $("#searchp").val()
          }
        // $('#numTotal').html(e);
       console.log(parameter)
       rendering(parameter)


}).on('click', "#removerSub", function() {
      // $("#adddate").val('')
     $("#searchp").val('')

        $("#time1sub").val(GetDateStr(0,1))
        $("#time2sub").val( GetDateStr(-29,1))
       $('.dataUlLI .activer').removeClass('activer');  
       $('.dataUlLI li').eq(3).addClass('activer');  
      $("#date_demo").text('请选择时间段')
})

$("#method").click(function() {
  var methodOneData   ='[{"Name":"用户姓名"},{"Tel":"联系电话"},{"DevNo":"设备编号"},{"agentname":"服务中心"},{"parentname":"运营中心"},{"Province":"省"},{"City":"市"},{"Area":"区"},{"CustomerType":"用户类型"},{"sales":"销量"}]';

 var methodTwoData   ='[{"Name":"服务中心"},{"Tel":"联系电话"},{"parentname":"运营中心"},{"Province":"省"},{"City":"市"},{"Area":"区"},{"family_sales":"家庭用户"},{"company_sales":"公司用户"},{"group_sales":"集团用户"},{"other_sales":"其它"},{"total_sales":"总销量"},{"dev_total":"总设备数"},{"average_sales":"设备平均销量"}]';
  var methodThreeData ='[{"Name":"运营中心"},{"Tel":"联系电话"},{"Province":"省"},{"City":"市"},{"Area":"区"},{"family_sales":"家庭用户"},{"company_sales":"公司用户"},{"group_sales":"集团用户"},{"other_sales":"其它"},{"total_sales":"总销量"},{"dev_total":"总设备数"},{"average_sales":"设备平均销量"}]';

var methodFourData  ='[{"Name":"水厂" } ,{"Tel":"联系电话"},{"Province":"省"},{"City":"市"},{"Area":"区"},{"family_sales":"家庭用户"},{"company_sales":"公司用户"},{"group_sales":"集团用户"},{"other_sales":"其它"},{"total_sales":"总销量"},{"dev_total":"总设备数"},{"average_sales":"设备平均销量"}]';

var methodFiveData  ='[{"Name":"设备厂家"},{"Tel":"联系电话"},{"Province":"省"},{"City":"市"},{"Area":"区"},{"family_sales":"家庭用户"},{"company_sales":"公司用户"},{"group_sales":"集团用户"},{"other_sales":"其它"},{"total_sales":"总销量"},{"dev_total":"总设备数"},{"average_sales":"设备平均销量"}]';
var methodSixData   ='[{"Name":"设备投资商"},{"Tel":"联系电话"},{"Province":"省"},{"City":"市"},{"Area":"区"},{"family_sales":"家庭用户"},{"company_sales":"公司用户"},{"group_sales":"集团用户"},{"other_sales":"其它"},{"total_sales":"总销量"},{"dev_total":"总设备数"},{"average_sales":"设备平均销量"}]';


      var time1subDate=  $("#time1sub").val();
      var time2subDate=  $("#time2sub").val();
      var searchp=$("#searchp").val()
      var title_column = methodOneData;
        if(activeNum==2){
          title_column=methodTwoData;
        }else if(activeNum==3){
            title_column=methodThreeData;
        }else if(activeNum==4){
          title_column=methodFourData;
        }else if(activeNum==5){
          title_column=methodFiveData;
        }else if(activeNum==6){
          title_column=methodSixData;
        };
  

      var obj = {
        "state": activeNum,
        "startime": time1subDate,
        "endtime": time2subDate,
        'search':searchp,
        'title_column':title_column
      }

 console.log(obj)


 window.location.href="./?r=sales-api/datas&state="+activeNum+"&startime="+time1subDate+"&offset=0&limit="+total+"&endtime="+time2subDate+"&search="+searchp+"&title_column="+title_column;

})


begin_linlst_time_clea()
function begin_linlst_time_clea(){
   var time1subDate=  $("#time1sub").val();
   var time2subDate=  $("#time2sub").val();
   var parameter = {
    "state": activeNum,
    "startime": time1subDate,
    "endtime": time2subDate,
    "offset": 0,
    'limit': 10,
    'sort':'1',
    'column':'sales',
    // 'sort':2,
    // 'column':'sales',
    "search": $("#searchp").val()
  }
 console.log(parameter)
  rendering(parameter)
}
function   rendering(parameter){
 // console.log(parameter);
   // $.post('./?r=sales-api/datas', parameter, function(objdata) {
   //         var objdata = JSON.parse(objdata);
   //         console.log(objdata)
   //         total=objdata.objdata*1;
   // })
       var ii= layer.msg("加载中……");
      $.ajax
       ({
           cache: false,
           async: false,
           type: 'post',
           data:parameter,
           url: "./?r=sales-api/datas",
           success: function (data) {
                 var objdata = JSON.parse(data);
                 console.log(objdata)
                 total=objdata.total*1;
                var role_id=0;
                if(objdata.role_id){
                  role_id=objdata.role_id
                }

                var sort=0;
                 if(parameter.sort){
                  sort=parameter.sort;
                 }

                   dev_listdata(objdata.users,role_id,sort)

                 paging(total)
           }
       });

}


     // 定义一个换页方法
     function hortlick(e) {

    
    var ii= layer.msg("加载中……");


  var page_size = $('#page_size option:selected').val()
   var  connect=  $(".connect_date").attr('date')||'3';
       var  connectTxt=$(".connect_date").attr('column')||'total_sales';
        var time1subDate=  $("#time1sub").val();
       var time2subDate=  $("#time2sub").val();
            if(activeNum==1){
                     connectTxt=$(".connect_date").attr('column')||'sales';
             }

       // console.log(connect)
       // console.log(connectTxt)
         var parameter = {
            "state": activeNum,
            "startime": time1subDate,
            "endtime": time2subDate,
            "offset": e * page_size - page_size, //起始,
            'limit': page_size,
            'sort':connect,
            'column':connectTxt,
            "search": $("#searchp").val()
          }

        $('#numTotal').html(e);
       // console.log(parameter)
       rendering(parameter)
     }



     
  function dev_listdata(data,role_id,sort) {
    if(data){
var tableTheadOneData   =['序号','用户姓名','联系电话','设备编号','服务中心','运营中心','地区','用户类型','销量'];
var tableTheadTwoData   =['序号','服务中心','联系电话','运营中心','地区','家庭用户','公司用户','集团用户','其它','总销量','总设备数','设备平均销量'];
var tableTheadThreeData =['序号','运营中心','联系电话','地区','家庭用户','公司用户','集团用户','其它','总销量','总设备数','设备平均销量'];
var tableTheadFourData  =['序号','水厂'    ,'联系电话','地区','家庭用户','公司用户','集团用户','其它','总销量','总设备数','设备平均销量'];
var tableTheadFiveData  =['序号','设备厂家','联系电话','地区','家庭用户','公司用户','集团用户','其它','总销量','总设备数','设备平均销量'];
var tableTheadSixData   =['序号','设备投资商','联系电话','地区','家庭用户','公司用户','集团用户','其它','总销量','总设备数','设备平均销量'];

var tableThead=tableTheadOneData;
if(activeNum==2){
  tableThead=tableTheadTwoData;
}else if(activeNum==3){
  tableThead=tableTheadThreeData;
}else if(activeNum==4){
  tableThead=tableTheadFourData;
}else if(activeNum==5){
  tableThead=tableTheadFiveData;
}else if(activeNum==6){
  tableThead=tableTheadSixData;
}

// console.log(tableThead.length)
  var html = ' <tr>';
   for(var y=0;y<tableThead.length;y++){
       var head_item = tableThead[y];
       // console.log(head_item)
          if(activeNum==1){
             if(y>=8){

                 html+='<th ><a href="javascript:void(0)"><p class="connect" date="2">'+head_item+'<p></a></th>';
             }else{
               html+='<th ><p>'+head_item+'<p></th>';
             }
          }else if(activeNum==2){
             if(y>=5){
                 html+='<th ><a href="javascript:void(0)"><p class="connect"  date="2">'+head_item+'<p></a></th>';
             }else{
               html+='<th ><p>'+head_item+'<p></th>';
             }
          }else{
            if(y>=4){
                 html+='<th ><a href="javascript:void(0)"><p class="connect"  date="2">'+head_item+'<p></a></th>';
             }else{
               html+='<th ><p>'+head_item+'<p></th>';
             }
          }
   }
    html+='</tr>';
   // console.log(html)

   if(sort<2){
       $("#table thead").html(html)
   }


 // console.log(data)



  function custType(Type) {
    // console.log(Type)
  // var CustomerType;
  if (Type == 1) {
    Type= '家庭';
  } else if (Type == 2) {
    Type = '办公';
  } else if (Type == 3) {
    Type= '集团';
  } else if (Type == 4) {
    Type= '酒店';
  } else if (Type == 99) {
    Type = '其他';
  }else{
    Type ==Type
  };
      // console.log(CustomerType)  
   return Type;
}
$("#tableBoxData").empty()
       for(var i=0;i<data.length;i++){
          var item = data[i];
                for (var z in item) {
                    if (item[z] == null) {
                      item[z] = '--'
                    }
                  }
              // var CustomerType='';
               var CustomerType = custType(item.CustomerType)  ;
             // console.log(CustomerType)
            var bodyHtml = ' <tr>';
                bodyHtml += '<td>'+(i+1)+'</td>';
                
                if(activeNum==1){
                  bodyHtml += '<td>'+item.Name +'</td>';
                   bodyHtml += '<td>'+item.Tel +'</td>';
                  bodyHtml += '<td>'+item.DevNo +'</td>';
                  bodyHtml += '<td>'+item.agentname +'</td>';
                  bodyHtml += '<td>'+item.parentname +'</td>';
                  bodyHtml += '<td>'+item.Province +item.City +item.Area +'</td>';
                  bodyHtml += '<td>'+CustomerType +'</td>';
                  bodyHtml += '<td>'+item.sales +'</td>';
                }else if(activeNum==2){

                 var sales = (item.family_sales * 1 + item.company_sales * 1 + item.group_sales * 1 +item.other_sales * 1)
                  bodyHtml += '<td><a href="./index.php?r=sales-api/index&role_id=' + role_id + '&LoginName=' + item.LoginName + '"><p>'+item.Name +'</p></a></td>';
                  bodyHtml += '<td>'+item.Tel +'</td>';
                  bodyHtml += '<td>'+item.parentname +'</td>';
                  bodyHtml += '<td>'+item.Province +item.City +item.Area +'</td>';
                  bodyHtml += '<td>'+item.family_sales +'</td>';
                  bodyHtml += '<td>'+item.company_sales +'</td>';
                  bodyHtml += '<td>'+item.group_sales +'</td>';
                  bodyHtml += '<td>'+item.other_sales +'</td>';
                  bodyHtml += '<td>'+sales +'</td>';
                  bodyHtml += '<td>'+item.dev_total +'</td>';
                  bodyHtml += '<td>'+item.average_sales +'</td>';

                }else{
                       var sales = (item.family_sales * 1 + item.company_sales * 1 + item.group_sales * 1 +item.other_sales * 1)
                  bodyHtml += '<td><a href="./index.php?r=sales-api/index&role_id=' + role_id + '&LoginName=' + item.LoginName + '"><p>'+item.Name +'</p></a></td>';
                  bodyHtml += '<td>'+item.Tel +'</td>';
                  bodyHtml += '<td>' +item.Province + '-' +item.City + '-' + item.Area + '</td>';
                  bodyHtml += '<td>'+item.family_sales +'</td>';
                  bodyHtml += '<td>'+item.company_sales +'</td>';
                  bodyHtml += '<td>'+item.group_sales +'</td>';
                  bodyHtml += '<td>'+item.other_sales +'</td>';
                  bodyHtml += '<td>'+sales +'</td>';
                  bodyHtml += '<td>'+item.dev_total +'</td>';
                  bodyHtml += '<td>'+item.average_sales +'</td>';
                }
          bodyHtml += '</tr>';
                // bodyHtml += '<td>'+item.Tel +'</td>';

// console.log(bodyHtml)
                $("#tableBoxData").append(bodyHtml)
    
       }
      if(ii){

       layer.close(ii)  
      }
    }
  }











</script>

</html>