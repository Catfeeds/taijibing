<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/static/css/common.css"/>
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>数据总览</title>
    <style>
        .header,.operate{
            height: 140px;
            width: 100%;
            /*background: url("/static/images/bg.png");*/
            /*background-size: 100% 240px;*/
            /*background-position: center;*/
            /*background-repeat: no-repeat;*/
            padding-top: 20px;
            border-bottom: 2px solid #f3f3f3
        }

        #header_total {
          width: 100px;
    height: 100px;
    background: red;
    margin: 0 auto;
    background: url(/static/images/data_view_bg2.png);
    background-size: 100px 100px;
    background-position: center;
    background-repeat: no-repeat;
    padding-top: 30px;
    position: relative;

        }

        .table_header {
            display: inline-block;
            width: 25%;
            text-align: center;
            height: 40px;
            line-height: 40px;

        }

        .table-hr {
            border-bottom: 1px solid #f3f3f3;
        }

        .table_bd {
 /*           border-bottom: 1px solid #f3f3f3;
            border-right: 1px solid #f3f3f3;*/
            display: inline-block;
            /*width: 25%;*/
            text-align: center;
            height: 40px;
            line-height: 40px;

        }

        .table_bd_fir {
            border-left: 1px solid #f3f3f3;
        }

        .icon_rise {
            background-image: url("/static/images/rise.png");
            background-size: 10px 10px;
            width: 10px;
            height: 10px;
            display: inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }

        .icon_drop {
            background-image: url("/static/images/drop.png");
            background-size: 10px 10px;
            width: 10px;
            height: 10px;
            display: inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }
        td,th{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="form">
    <div class="header">
        <div id="header_total">
            
            <p style="text-align:center;font-size:24px;color:#fe811b;"><span class="sell_out">2000</span><span style="color:#979494;font-size:15px;">袋</span>
            </p>

            <p style="font-size:18px;text-align:center;height:20px;font-size:13px;">累计销量</p>
        </div>
        <div style="position:absolute;top: 0;    height: 134px;padding-top:40px;width:100%;margin-top:14px;">
            <div
                style="position:absolute;left:0px;display:inline-block;width:35%;text-align:center;padding-right:20px;">
              

                   <p  class="sell_out"></p>

                  <p style="font-size:18px;color:#979494;">累计销量</p>
            </div>
            <div style="position:absolute;right:0px;display:inline-block;width:35%;text-align:center;padding-left:20px;">
                
                <p  class="regis_num">100000</p>
                <p style="font-size:18px;color:#979494;">累计用户</p>

            </div>
        </div>
    </div>
    <div class="operate" style="padding:15px;height:190px;">
            <div style="height:46px;float:left;width:100%;">
                <!-- <img src="/static/images/jysj.png" style="float:left;height:24px;margin-top:10px;padding:0 10px;"/> -->
                <P style=""><span  style="height:46px;line-height: 46px;font-weight: bold;border-left:4px solid red">&nbsp;&nbsp;&nbsp;经营数据</span></P>
                 <table style="width:100%;">
                     <thead style="background-color: #FFF2E8" >
                         <tr>
                             <th>经营类型</th>
                             <th>数量</th>
                             <th>日增长</th>
                             <th>月增长</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>销量(袋)</td>
                             <td> <span class="table_bd sell_out"></span></td>
                             <td><span class="table_bd">
                                    <i class="icon"></i>
                                    <span id="sell_day_per"></span>
                                </span>
                            </td>
                             <td> <span class="table_bd">
                                    <i class="icon"></i>
                                    <span id="sell_month_per"></span>
                                </span>
                            </td>
                         </tr>
                         <tr>
                             <td>用户数量(台)</td>
                             <td> <span class="table_bd regis_num"></span></td>
                             <td>
                                 <span class="table_bd">
                                    <i class="icon"></i>
                                    <span id="regis_day_per"></span>
                                </span>
                             </td>
                             <td>
                                 <span class="table_bd">
                                    <i  class="icon"></i>
                                    <span id="regis_month_per"></span>
                                </span>
                             </td>
                            
                         </tr>

                     </tbody>
                 </table>
            </div>

        
    </div>
   
  <!--   <div class="table-hr">
        <p><span class="table_header">经营类型</span><span class="table_header">数量</span><span
                class="table_header">日增长</span><span class="table_header">月增长</span></p>
    </div> -->
    <div class="table-bd">
       <!--  <p>
            <span class="table_bd table_bd_fir">销量(袋)</span>
            <span class="table_bd sell_out"></span>
            <span class="table_bd">
                <i class="icon"></i>
                <span id="sell_day_per"></span>
            </span>
            <span class="table_bd">
                <i class="icon"></i>
                <span id="sell_month_per"></span>
            </span>
        </p> -->

        <!-- <p>
            <span class="table_bd table_bd_fir">用户数量(台)</span>
            <span class="table_bd regis_num"></span>
            <span class="table_bd">
                <i class="icon"></i>
                <span id="regis_day_per"></span>
            </span>
            <span class="table_bd">
                <i  class="icon"></i>
                    <span id="regis_month_per"></span>
                </span>
            </p> -->
    </div>
</div>

<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js"></script>
<script>
    var data =<?=json_encode($data)?>;
// console.log(data)

</script>
<script>
    $(function () {
        if (data.state != 0) {
            $.alert("数据读取错误");
            return;
        }
        initPage();
    });

    
    function initPage() {
        var watersale = data.result.watersale;
        var customer = data.result.customer;
        $(".sell_out").text(watersale.total);
        $(".regis_num").text(customer.total);
        var sell_day_per = Number(watersale.curdaycnt) - Number(watersale.prvdaycnt);
        var regis_day_per = Number(customer.curdaycnt) - Number(customer.prvdaycnt);
        $("#sell_day_per").text(Math.abs(sell_day_per));
        $("#regis_day_per").text(Math.abs(regis_day_per));
        updateRiseOrDropStatus($("#sell_day_per"), sell_day_per);
        updateRiseOrDropStatus($("#regis_day_per"), regis_day_per);

        var sell_month_per = Number(watersale.curmonthcnt) - Number(watersale.prvmonthcnt);
        var regis_month_per = Number(customer.curmonthcnt) - Number(customer.prvmonthcnt);
        $("#sell_month_per").text(Math.abs(sell_month_per));
        $("#regis_month_per").text(Math.abs(regis_month_per));
        updateRiseOrDropStatus($("#sell_month_per"), sell_month_per);
        updateRiseOrDropStatus($("#regis_month_per"), regis_month_per);

    }
    function updateRiseOrDropStatus(_obj, num) {
        $(_obj).parents(".table_bd").find(".icon").addClass(num >= 0 ? "icon_rise" : "icon_drop");
    }
</script>
</body>
</html>