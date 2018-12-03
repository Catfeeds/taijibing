<?php
use yii\widgets\LinkPager;
?>
   <!-- <link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/> -->
      <link rel="stylesheet" type="text/css" href="/static/css/dateRange.css"/>
  <link rel="stylesheet" type="text/css" href="/static/css/monthPicker.css"/>
           <link rel="stylesheet" href="./static/css/chosen.css"/>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<link rel="stylesheet" href="./static/css/Common.css"/>

    <style type="text/css">
      .table td, .table th{
        text-align: center;
      }   
     .table td:first-child {
        border-left: 2px solid #E46045;
    }#date_demo {
    width: 200px;
    height: 30px;
    line-height: 30px;
    line-height: 15px;
    background-color: #2D3136;
    border: none;
    display: inline-block;
}
    </style>
<div class="wrapper wrapper-content">
<!--    <a href="./?r=logic-user/factory-list">返回</a>-->

      <div style="padding:10px 30px">
     <img src="/static/images3/sidebar.png" alt="" width=20 >
     <span class="font-size-S">&nbsp;条码充值记录</span>
         <div class="pull-right"  style="text-align: right;margin-bottom: 10px">
          
         <a class="btn btn-primary returnA" href="/index.php?r=supplier/list<?=json_decode($select_where)->url?>">返回</a>
              </div>
  </div>

      <div class="condition" style="padding: 30px 10px;">

    <form method="post" action="/index.php?r=supplier/recharge-log">

        <input type="hidden" name="Fid" value="<?=json_decode($select_where)->Fid?>">
        <input type="hidden" name="logic_type" value="<?=json_decode($select_where)->logic_type?>">
        <input type="hidden" name="GoodsId" value="<?=json_decode($select_where)->GoodsId?>">
        
          <div class="selection pull-left">
        <span  class="selection-text  pull-left" style='height: 30px;
    line-height: 30px;'>时间段：</span>
      <div class="ta_date" id="div_date_demo">
              <span class="date_title" id="date_demo"></span>
              <a class="opt_sel" id="input_trigger_demo" href="#">
                  <i> <img src="static/images3/regb.png" alt="" style='    margin-top: -7px;'></i>
              </a>
          </div>
          <input type="text" name="selecttime" id='selecttime1' value="" style="display: none">
          <div id="datePicker"></div>
       </div>
              <div style="display: none">
                    <input type="text" name="start_time" id="time1sub"  value="">
                    <input type="text" name="end_time" id="time2sub" value="">
              </div> 
              
              <input style="padding:0 10px;margin-left: 100px;    margin-top: 0px;" type="submit" value="查询" id="btn"/>
                              <button type="text"  class="btn " id="removerSub">清空条件</button>
          </form>


</div>


        <table class="table table-hover" style="text-align: center;">
            <thead>
            <th  id="sort" data="1">品牌</th>
            <th>商品名称</th>
            <!-- <th>商品规格</th> -->
            <th>商品规格 <span style="color:#E46045">(L)</span></th>
            <th>应付金额 <span style="color:#E46045">(元)</span></th>
            <th>支付金额<span style="color:#E46045">(元)</span></th>
            <th>优惠金额<span style="color:#E46045">(元)</span></th>
       
            <th>购买数量</th>
            <th>总条码数量</th>
            <th><a id="sort" data='RestAmount' >剩余条码数量</a></th>
            <th><a id="sort2" data='RowTime'>充值时间</a></th>
            </thead>
            <tbody id='tableData'>

            </tbody>
        </table>
        <table>
            <th>
        </table>


  <div id="page" class="page_div"  style="padding-bottom: 150px;">></div>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script> 
        <script src="/static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script> 
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
    <script type="text/javascript" src="/static/js/dev-statistics/paging.js"></script>
    <script>

         var total =<?=$total?>;
         var select_where =<?=$select_where?>;
         var form_datas =<?=$form_datas?>;
         // console.log(select_where)
         // console.log(total)
      for (var z in select_where) {
          if (select_where[z] == null) {
            select_where[z] = ''
          }
        }

    </script>
    <script>

  paging({
    pageNo: 1,
    totalPage: Math.ceil(total / 10),
    totalLimit: 10,
    totalSize:total,
    callback: function(num, nbsp) {
      var searchParameters =select_where;
          searchParameters.offset=num * nbsp - nbsp;
          searchParameters.limit=nbsp;
      
 // console.log(searchParameters)
           Get_datas(searchParameters,num)
    }
  })
  function  Get_datas(searchParameters,num){
 // console.log(searchParameters)
    
     var ii =   layer.open({
          type: 1,
          skin: 'layui-layer-demo', //样式类名
          closeBtn: 0, //不显示关闭按钮
          anim: 2,
          shade: [0.8, '#000'],
          shadeClose: false, //开启遮罩关闭
          content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
        });

  $.post("./index.php?r=supplier/recharge-log-page", searchParameters, function(data){
       layer.close(ii); 
           if(typeof(data)=='string'){
                data=  jQuery.parseJSON(data);
           }
      // console.log(data)
      var sales_detail=data.form_datas
         dev_listdata(sales_detail,num)
  })
}


var time1sub=select_where.start_time;
var time2sub=select_where.start_time;


   // 时间选择
    var dateRange = new pickerDateRange('date_demo', {
      //aRecent7Days : 'aRecent7DaysDemo3', //最近7天
      isTodayValid: true,
      startDate: time1sub,
      endDate:time2sub,
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

      }
    });
$("#removerSub").click(function(){
    $("#time1sub").val('')
    $("#time2sub").val('')
    $("#date_demo").text('');
    return false
})

 dev_listdata(form_datas) 

       function dev_listdata(data) {
           var j = 0;
         $("#tableData").empty();
             for (var i = 0; i < data.length; i++) {
              var item = data[i]
                for (var z in item) {
                  if (item[z] == null) {
                    item[z] = '--'
                  }
                }
                j++;
            var html = '<tr><td>'+j+'</td>';
                html += '<td>'+item.BrandName  +'</td>';
                html += '<td>'+item.Volume  +'</td>';
                html += '<td>'+item.TotalMoney  +'</td>';
                html += '<td>'+item.OrderMoney  +'</td>';
                html += '<td>'+item.CouponMoney  +'</td>';
                html += '<td>'+item.Amount  +'</td>';
                html += '<td>'+item.RechargeAmount  +'</td>';
                html += '<td>'+item.RestAmount  +'</td>';
                html += '<td>'+item.RowTime  +'</td>';
                  html += '</tr>';
                $("#tableData").append(html);
             }
       }

            $(".table th a").click(function(){
            var _thisdata = $(this).attr('data');
            var _sortdata = $("#sort").attr('data');
            _sortdata++
            $("#sort").attr('data',_sortdata)
            // console.log(_thisdata)
            // console.log(_sortdata)
          select_where.order_column=_thisdata;
          select_where.sort=_sortdata;
          // console.log(select_where)
                Get_datas(select_where)
                paging({
                    pageNo: 1,
                    totalPage: Math.ceil(total / 10),
                    totalLimit: 10,
                    totalSize:total,
                    callback: function(num, nbsp) {
                      var searchParameters =select_where;
                          searchParameters.offset=num * nbsp - nbsp;
                          searchParameters.limit=nbsp;
                           // console.log(searchParameters)
                           Get_datas(searchParameters,num)
                    }
                  })         
        })
    </script>




</div>
