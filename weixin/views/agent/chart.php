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
    <title>数据报表</title>
    <style>
        #main {
            margin-left: 5%;
            width: 90%;
            height: 400px;
            border: 1px solid #f3f3f3;
            border-radius: 2px;
            /*box-shadow: 2px 2px 2px #dbdbdb;*/
        }
        #agent{
            margin-left: 5%;
            width: 90%;
            height: 400px;
            border: 1px solid #f3f3f3;
            border-radius: 2px;
            /*box-shadow: 2px 2px 2px #dbdbdb;*/
        }
                .header,.operate{
            /*height: 140px;*/
            width: 100%;
            /*background: url("/static/images/bg.png");*/
            /*background-size: 100% 240px;*/
            /*background-position: center;*/
            /*background-repeat: no-repeat;*/
            padding-top: 20px;
            border-bottom: 4px solid #f3f3f3
        }
         .header{
            position: relative;
            margin-top: 60px;
            padding-bottom: 60px;
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
            padding-top: 22px;
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
            background-size: 10px 13px;
            width: 10px;
            height: 13px;
            display: inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }

        .icon_drop {
            background-image: url("/static/images/drop.png");
            background-size: 10px 13px;
            width: 10px;
            height: 13px;
            display: inline-block;
            background-repeat: no-repeat;
            background-position: center;;
        }
        table  tbody>tr{
            width: 100%;
             display: inline-table;
                 text-align: center;
            border-bottom: 1px solid #f3f3f3
        }

        table td,th{
                  display: inline-table;
                 text-align: center;
                padding: 5px;
                    width: 25%;

        }
      
        .btonm_left{
            width:5px;
            height:15px;
            position: absolute;
            top: 15px;
             background: -webkit-linear-gradient(right,#ff8a20,#FF5E20);  
            background: -o-linear-gradient(right,#ff8a20,#FF5E20);  
            background: -moz-linear-gradient(right,#ff8a20,#FF5E20); 
            background: -mos-linear-gradient(right,#ff8a20,#FF5E20);  
            background: linear-gradient(right,#ff8a20,#FF5E20);   
        }
        #agent table td,#main table td{
            width:50%;
        }
    </style>
</head>
<body>

	
<div class="form">
    <div class="header">
        <div id="header_total">
            
            <p style="text-align:center;font-size:24px;color:#fe811b;"><span class="sell_out" style="font-size: 30px;">0</span><span style="color:#979494;font-size:15px;">&nbsp;袋</span>
            </p>

            <p style="font-size:18px;text-align:center;height:20px;font-size:13px;">累计销量</p>
        </div>
        <div style="position:absolute;top: 0;    height: 134px;padding-top:40px;width:100%;margin-top:14px;">
            <div
                style="position:absolute;left:0px;display:inline-block;width:35%;text-align:center;padding-right:20px;  top:50%;  margin-top: -29px;">
                   <p  class="sell_out" style="font-size: 22px;"></p>

                  <p style="font-size:16px;color:#979494;">累计设备</p>
            </div>
            <div style="position:absolute;right:0px;display:inline-block;width:35%;text-align:center;padding-left:20px;  top:50%;  margin-top: -29px;">
                
                <p  class="regis_num"  style="font-size: 22px;">0</p>
                <p style="font-size:16px;color:#979494;">累计用户</p>

            </div>
        <div style="clear:both;"></div>    
        </div>
    </div>
    <div class="operate" style="padding:15px;    padding-bottom: 30px;">
            <div style="float:left;width:100%;position: relative;">
                <!-- <img src="/static/images/jysj.png" style="float:left;height:24px;margin-top:10px;padding:0 10px;"/> -->
                <P style="">
                    <div class="btonm_left"></div>
                    <span  style="height:46px;line-height: 46px;font-weight: bold;">&nbsp;&nbsp;&nbsp;经营数据</span>
                </P>
                 <table style="width:100%;" >
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
                 <div style="clear:both;"></div>    
            </div>
            <div style="clear:both;"></div>    
    </div>
     <div style="clear:both;"></div>   
</div>
<div style="position: relative;">
    

     <div style="margin-left:15px;    margin-top: 10px;position: relative;">
        <div class="btonm_left"></div>
        <span style="height:46px;line-height: 46px;font-weight: bold;">&nbsp;&nbsp;&nbsp;数据报表</span>

    </div>
    <div style="height:46px;float:left;position: absolute;left: 36px;   width: -webkit-calc(100% - 190px);width: -moz-calc(100% - 190px); width: calc(100% - 190px);">
        <img  src="/static/images/ren.png" style="float:left;height:15px;margin-top:15px;padding:0 10px;"/><span style="height:46px;line-height: 46px;color:#666666;">用户数(人)</span>
        <img class="biaocheng"  src="/static/images/biaocheng.png" style=" position: absolute; width: 15px;top: 17px;right: 0px;}">
    </div>
    <div style="clear:both;"></div>


     <div id="agent"></div>
</div>
<div style="margin-top:20px;">
</div>

<div style="position: relative;">


  <div style="height:46px;float:left;position: absolute;left: 36px;   width: -webkit-calc(100% - 190px);width: -moz-calc(100% - 190px); width: calc(100% - 190px);">
<img  src="/static/images/dai.png" style="float:left;height:15px;margin-top:15px;padding:0 10px;"/><span style="height:46px;line-height: 46px;color:#666666;">销售数量(袋)</span>
    <img class="biaocheng" src="/static/images/biaocheng.png" style="    position: absolute; width: 15px;top: 17px;right: 0px;}">
</div>
<div style="clear:both;"></div>
<div id="main"></div>
</div>

<div style="clear:both;height:50px;width: 100%;"></div>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js?"></script>
<script type="text/javascript" src="http://echarts.baidu.com/asset/theme/macarons.js"></script>
<!-- <script type="text/javascript" src="/static/js/coderlu.js"></script> -->
<script type="text/javascript" src="/static/js/westeros.js?v=1.6"></script>
<script type="text/javascript">
    var datax=<?=json_encode($datax)?>;
    var datay=<?=json_encode($datay)?>;
    var userdatax=<?=json_encode($userdatax)?>;
    var userdatay=<?=json_encode($userdatay)?>;

    var data=<?=json_encode($data)?>;
    // console.log(userdatax);
    // console.log(userdatay);


    $(".biaocheng")
    // 基于准备好的dom，初始化echarts实例
    var userchart = echarts.init(document.getElementById('agent'), 'westeros');
    var chart = echarts.init(document.getElementById('main'), 'westeros');
    option = {
        title: {
//            text: '今日饮水记录',
//            subtext: '纯属虚构'
        },
        tooltip: {
            trigger: 'axis',
             backgroundColor: '#fe811b',
             color:'#000'
           
        },

        grid: {  
    	      left: '20px',
              top:'80px',  
    	      right: '40px',  
    	      bottom: '3%',  
    	      containLabel: true  
    	} , 
        legend: {
            data: ['今日销量']
        },
        toolbox: {
            show: true,
            top:'10px',  

            feature: {
               mark : {show: true},
                // dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar'],title:''},
                restore : {show: true},
                saveAsImage : {show: true},
                // dataView:{
                //    optionToContent: function(opt) {
                //     var nameuserdatax = JSON.stringify(datax);
                //     var datauserdatay = JSON.stringify(datay);
                //         location.href='chart-type?userdatax='+nameuserdatax+'&userdatay='+datauserdatay;
                //     return false;
                //     }
                // }
             }
        },
        calculable: true,

        xAxis: [
            {
                type: 'category',
                boundaryGap: false,
                data: datax,
                 axisLabel: {
                            show: true,
                            textStyle: {
                                color: '#000'
                            }
                        }   
            }
        ],
        yAxis: [
            {
                type: 'value',
                color:'#000',
                minInterval : 1,
                axisLabel : {
                            formatter: '{value} 袋',
                            textStyle: {
                                color: '#000'
                            }
                        },
                boundaryGap : [ 0, 0.1 ],

            }
        ],
        series: [
            {
                name: '销售数量',
                type: 'line',
                data: datay,
                markPoint: {
                    symbolSize:30,
                    data: [
                        {type: 'max', name: '最大值'},
                    ]
                },
                markLine: {
                    data: [
                        {type: 'average', name: '平均值'}
                    ]
                }
            }
        ]
    };


    var useroption = {
        title: {
//            text: '今日饮水记录',
//            subtext: '纯属虚构'
        },
        tooltip: {
            trigger: 'axis'
            ,         backgroundColor: '#fe811b'
        },

        legend: {
            data: ['今日新增用户数']
        },
          grid: {  
              top:'80px', 
    	     left: '20px',  
    	     right: '40px',  
    	     bottom: '3%',  
    	     containLabel: true  
	   } , 
        toolbox: {
            show: true,
                top:'10px',  
                feature: {
                mark: {show: true},
                // dataView: {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar'],title:''},
                restore: {show: true},
                saveAsImage: {show: true},
                // dataView:{
                //    // optionToContent: function(opt) {
                //    //  var nameuserdatax = JSON.stringify(userdatax);
                //    //  var datauserdatay = JSON.stringify(userdatay);
                //    //      location.href='chart-type?userdatax='+nameuserdatax+'&userdatay='+datauserdatay;

                //    //      return false;
                //    //  }

                // }
            }
        },
        calculable: true,
        xAxis: [
            {
                type: 'category',
                boundaryGap: false,
                data: userdatax,
                 axisLabel: {
                    show: true,
                    textStyle: {
                        color: '#000'
                    }
                } 
            }
        ],
        yAxis: [
            {
                type: 'value',
                minInterval : 1,
                axisLabel: {
                    formatter: '{value} 人',
                    textStyle: {
                                color: '#000'
                            }
                },
               boundaryGap : [ 0, 0.1 ]
            }
        ],
        series: [
            {
                name: '新增用户数',
                type: 'line',
                data: userdatay,
                markPoint: {
                      symbolSize:30,
                    data: [
                        {type: 'max', name: '最大值'},
                    ]
                },
                markLine: {
                    data: [
                        {type: 'average', name: '平均值'}
                    ]
                }
            }
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    chart.setOption(option);
    userchart.setOption(useroption);


    $(function () {
        if (data.state != 0) {
            $.alert("数据读取错误");
            return;
        }
        initPage();
    });

    
    function initPage() {

        console.log(data)
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