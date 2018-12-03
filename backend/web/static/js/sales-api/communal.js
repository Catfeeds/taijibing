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





   	 // 今日时间戳
   	 var nowDate = Date.parse(GetDateStr(0, 1))
   	   // 作日时间戳
   	 var tomorrowDate = Date.parse(GetDateStr(-1, 1))
   	   // 前日时间戳
   	 var FrontrowDate = Date.parse(GetDateStr(-2, 1))
   	   // 本周时间戳
   	 var weekDate = Date.parse(GetDateStr(-6, 1))
   	   // 上周时间戳
   	 var upperDate = Date.parse(GetDateStr(-13, 1))
   	   // 本月时间戳
   	 var monthDate = Date.parse(GetDateStr(-29, 1))
   	   // 上月时间戳
   	 var uppermonthDate = Date.parse(GetDateStr(-59, 1))
   	   // 一季度时间戳
   	 var quarterDate = Date.parse(GetDateStr(-89, 1))
   	   // 上季度时间戳
   	 var upperquarterDate = Date.parse(GetDateStr(-179, 1))

   	   //获取当月的天数
   	 function getDays() {
   	   //构造当前日期对象
   	   var date = new Date();
   	   //获取年份
   	   var year = date.getFullYear();
   	   //获取当前月份
   	   var mouth = date.getMonth() + 1;
   	   //定义当月的天数；
   	   var days;
   	   //当月份为二月时，根据闰年还是非闰年判断天数
   	   if (mouth == 2) {
   	     days = year % 4 == 0 ? 29 : 28;
   	   } else if (mouth == 1 || mouth == 3 || mouth == 5 || mouth == 7 || mouth == 8 || mouth == 10 || mouth == 12) {
   	     //月份为：1,3,5,7,8,10,12 时，为大月.则天数为31；
   	     days = 31;
   	   } else {
   	     //其他月份，天数为：30.
   	     days = 30;
   	   }
   	   return days;
   	 }

   	 // 概况平均值
   	 function forDataTime($data, $e) {
   	   for (var i = 0; i < $data.length; i++) {
   	     if (isNaN($data[i])) {
   	       $data[i] = 0;
   	     }
   	     $e.eq(i + 1).text(Math.ceil($data[i]))
   	   }
   	 };


   	 function forDataTimeyop($data, $e) {
   	   for (var i = 0; i < $data.length; i++) {
   	     if (isNaN($data[i])) {
   	       $data[i] = 0;

   	     }
   	      $e.eq(i + 1).text(Math.floor($data[i]))
   	   }
   	 };





   	 function custType(Type) {
   	   var CustomerType;
   	   if (Type == 1) {
   	     CustomerType = '家庭'
   	   } else if (Type == 2) {
   	     CustomerType = '办公'
   	   } else if (Type == 3) {
   	     CustomerType = '集团'
   	   } else if (Type == 99) {
   	     CustomerType = '其他'
   	   }
   	   return CustomerType;
   	 }



   	 //伪类
   	 function _hover(Class, ClassText) {
   	   Class.hover(function() {
   	     ClassText.css("display", "block");
   	   }, function() {
   	     ClassText.css("display", "none");
   	   });
   	 }

   	 // 数组去空
  function  notempty($data) {
   	     return $data.filter(t => t != undefined && t !== null);
   	   }
   	   // 数组去重
     //去重
function unique($data) {
  var res = [];
  var json = {};

  for (var p = 0; p < $data.length; p++) {
    if (!json[$data[p]]) {
      res.push($data[p]);
      json[$data[p]] = 1;
    } else {}
  }
  return res;
}


   	 function percenttage(number1, number2) {
   	   if (!number2) {
   	     number2 = 1
   	     return (Math.round((number1 / number2) * 10000) / 100)
   	   }
   	   //   else if(number1==0){
   	   //          return (-(Math.round(number2*10000 ) /100) ) 
   	   // }
   	   else {

   	     return (Math.round((number1 / number2 - 1) * 10000) / 100)
   	   }

   	 }

   	 function Percentage(number1, number2) {
   	   return (Math.round(num / total * 10000) / 100.00); // 小数点后两位百分比

   	 }

   	 function toDecimal(x) {
   	   var f = parseFloat(x);
   	   if (isNaN(f)) {
   	     return;
   	   }
   	   f = Math.round(x * 100) / 100;
   	   return f;
   	 }

   	 function getLocalTime(nS) {
   	   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
   	 }


   	 // 饼状图
   	 function pieChart(myChart, pieChartName, pieChartVue) {
   	   option5 = {
   	     title: {
   	       text: '用户类型销量占比',
   	       textStyle: {
   	         color: '#fff',
   	         x: '100px',
   	       },
           y: '10px',
   	       x: 'center'

   	     },
   	     toolbox: { //工具箱,每个图表最多仅有一个工具箱
   	       show: true, //显示策略,默认只是false.可选为:true显示|false隐藏
   	       feature: { //启用功能,目前支持feature，工具箱自定义功能回调处理.
   	         mark: {
   	           show: true
   	         }, 
             //辅助线标志,此处启用.
   	         dataView: { //打开数据视图，可设置更多属性 
   	           show: true,
   	           readOnly: false //readOnly默认数据视图为只读,可指定readOnly为false打开编辑功能
   	         },

   	         restore: {
   	           show: true,
   	            title:"刷新",	
   	         }, 

   	 
   	       },
            axisLabel: {
             show: true,
             textStyle: {
               color: '#fff'
             }
           }
   	     },
   	     tooltip: {
   	       trigger: 'item',
   	       formatter: "{a} <br/>{b} : {c} ({d}%)"
   	     },
   	     legend: {
   	       orient: 'vertical',
   	       left: 'right',
   	       top: 'bottom',
   	       data: pieChartName,
   	       textStyle: {
   	         color: '#fff'
   	       }
   	     },
   	     label: {
   	       normal: {
   	         formatter: '{b}:{c}: ({d}%)',
   	         textStyle: {
   	           fontWeight: 'normal',
   	           fontSize: 15
   	         }
   	       }
   	     },
   	     series: [{
   	       name: '销量',
   	       type: 'pie',
   	       radius: '55%',
   	       center: ['50%', '60%'],
   	       data: [{
   	         value: pieChartVue[0],
   	         name: pieChartName[0]
   	       }, {
   	         value: pieChartVue[1],
   	         name: pieChartName[1]
   	       }, {
   	         value: pieChartVue[2],
   	         name: pieChartName[2]
   	       }, {
             value: pieChartVue[3],
             name: pieChartName[3]
           }, {
             value: pieChartVue[4],
             name: pieChartName[4]
           }],
   	       itemStyle: {

   	         emphasis: {
   	           shadowBlur: 10,
   	           shadowOffsetX: 0,
   	           shadowColor: 'rgba(0, 0, 0, 0.5)'
   	         }
   	       }
   	     }],
   	     // color:['#00448a','#0580b9','#28c6b9','#84e6f1','#dddddd'],
   	   };
   	   myChart.setOption(option5, true);
   	 }
   	 // 折线图
   	 function brokenLine(myChart, brokenLineX, brokenLineData) {
   	   option2 = {
   	     tooltip: {
   	       trigger: 'axis'
   	     },
   	     toolbox: {
   	       show: false,
   	       feature: {
   	         mark: {
   	           show: true
   	         },
   	         dataView: {
   	           show: true,
   	           readOnly: false
   	         },
   	         magicType: {
   	           show: true,
   	           type: ['line', 'bar']
   	         },
   	         restore: {
   	           show: true
   	         },
   	         saveAsImage: {
   	           show: true
   	         }
   	       }
   	     },
   	     calculable: false,
   	     xAxis: [{
   	       type: 'category',
   	       boundaryGap: false,
   	       //data : selloutPackage.x,
   	       data: brokenLineX,
   	       axisLabel: {
   	         //X轴刻度配置
   	         interval: 2 //0：表示全部显示不间隔；auto:表示自动根据刻度个数和宽度自动设置间隔个数
   	       },
   	       axisLabel: {
   	         show: true,
   	         textStyle: {
   	           color: '#fff'
   	         }
   	       }
   	     }],
   	     yAxis: [{
   	       type: 'value',
   	       axisLabel: {
   	         show: true,
   	         formatter: '{value} (袋)',
   	         textStyle: {
   	           color: '#fff'
   	         }
   	       }
   	     }],

   	     series: [{
   	       name: '销量',
   	       type: 'line',
   	       //data:selloutPackage.y,
   	       data: brokenLineData
   	     }]
   	   };
   	   myChart.setOption(option2, true);

   	 }





           function _detail(time_id,url) {
             $.post(url, time_id, function(json) {
               var data = JSON.parse(json);
               console.log(data)
               // 取出单个扫码时间
               var salesVolume = [0, 0, 0, 0, 0, 0, 0, 0, 0];
               for (var i = 0; i < data.datas.length; i++) {
                 var strs = data.datas[i].RowTime.split(" ");
                 var str = Date.parse(strs[0]);
                 if (nowDate <= str) {
                   salesVolume[0]++
                 }
                 // 昨天一天
                 if (tomorrowDate <= str && str < nowDate) {
                   var tt = new Date(str).toLocaleString().replace(/\//g, "-");

                   salesVolume[1]++
                     // 前天到昨天
                 } else if (FrontrowDate <= str && str < tomorrowDate) {
                   salesVolume[2]++
                 }
                 // 一周到今天  七天前
                 if (weekDate <= str) {
                   salesVolume[3]++
                 }
                 // 两周
                 else if (upperDate <= str && str < weekDate) {
                   salesVolume[4]++
                 }
                 // 一月
                 if (monthDate <= str) {
                   salesVolume[5]++
                 }
                 // 两月
                 else if (uppermonthDate <= str && str < monthDate) {
                   salesVolume[6]++
                 }
                 // 一季度到今天
                 if (quarterDate < str) {
                   salesVolume[7]++
                 }
                 // 上个季度到这个季度
                 else if (upperquarterDate <= str && str < quarterDate) {
                   salesVolume[8]++
                 }
               }
               var sales_volume = {
                 "volume": [
                   salesVolume[0], //今天销量
                   salesVolume[1], //两天的销量
                   salesVolume[3], //一周的销量
                   salesVolume[5], //一个月的销量
                   salesVolume[7] //一个季度的销量
                 ],
                 "compare": [ //  今日 /  昨日
                   percenttage(salesVolume[0], (salesVolume[1])), //今日同期
                   percenttage(salesVolume[1], (salesVolume[2])), //昨日同期
                   percenttage(salesVolume[3], (salesVolume[4])), //一周同期
                   percenttage(salesVolume[5], (salesVolume[6])), //一月同期
                   percenttage(salesVolume[7], (salesVolume[8])) //一季度同期 
                 ],
                 //均销量
                 "Average": [ //  总销量 /  现在的销量
                   salesVolume[0] / json.user_number,
                   salesVolume[1] / json.user_number,
                   salesVolume[3] / json.user_number,
                   salesVolume[5] / json.user_number,
                   salesVolume[7] / json.user_number
                 ]
               };
               forDataTime(sales_volume.volume, $(".consumer td"))
               forDataTimeyop(sales_volume.Average, $(".equally td"))
                 // 渲染同期
               for (var i = 0; i < sales_volume.compare.length; i++) {
                 if (isNaN(sales_volume.compare[i])) {
                   sales_volume.compare[i] = 0;
                 }
                 var sales_volume_num = sales_volume.compare[i]
                 if (sales_volume.compare[i] === "Infinity") {
                   sales_volume.compare[i] == 0;
                 }
                 if (!sales_volume_num) {

                   $(".relatively td").eq(i + 1).html('持平 &nbsp;<img src="/static/images3/rectangle.png">')

                 } else if (sales_volume_num < 0) {

                   $(".relatively td").eq(i + 1).html(sales_volume_num + '%&nbsp;<img src="/static/images3/Arrowb.png">')

                 } else if (sales_volume_num > 0) {
                   $(".relatively td").eq(i + 1).html(sales_volume_num + '%&nbsp;<img src="/static/images3/arrowA.png">')

                 }
               }
             })
           }




function javaData(_date, time_id,url) {
  $.post(url, time_id, function(json) {
    var json = JSON.parse(json);
    var sales_to = [];
    var user_1 = 0; //家庭
    var user_2 = 0; //办公
    var user_3 = 0; //集团
    var user_4 = 0; //酒店
    var user_5 = 0; //其他
    var map = 0;
    var _dateY = []
    if (json.length) {
      for (var i = 0; i < json.length; i++) {
        // for (var i in json) {
        //    // //销量时间 （天）
        var strjson = json[i].RowTime.split(" ");
        // 截取年月日
        var strjsondata = parseInt(Date.parse(strjson[0]));
        // var   _dateYData=strjson[1].replace(":","");
        var _dateYData = strjson[1].split(":");
        // 添加注册时间
        _dateY.push(_dateYData);
        // 循环需要的x轴天数
        for (var j = 0; j < _date.length; j++) {
          sales_to.push('0');
          var _datel_ratio = parseInt(Date.parse(_date[j]));
          // console.log(_datel_ratio);
          if (_datel_ratio == strjsondata) {
            sales_to[j]++
          }
        };
        // console.log(strjsondata)
        if (json[i].CustomerType == 'undefined') {
          json[i].CustomerType == [];
        }
        if (json[i].CustomerType == 1) {
          user_1++
        }

        if (json[i].CustomerType == 2) {
          user_2++
        }
        if (json[i].CustomerType == 3) {
          user_3++
        }

        if (json[i].CustomerType == 4) {
          user_4++
        }
        if (json[i].CustomerType == 99) {
          user_4++
        }
      }
    } else {
      for (var j = 0; j < _date.length; j++) {
        sales_to.push('0');
      }
    }
    if (_date.length < 3) {
      _date = [];
      var _dateX = [];
      var _dateXdata = [];
      var _dataData = [];
      for (var i = 0; i < 24; i++) {
        var date = (i) + ":00"
        _date.push(date)
        _dataData.push("0")
        for (var y = 0; y < _dateY.length; y++) {
          if (_dateY[y][0] == i) {
            _dataData[i]++
          }
        }
      }
      sales_to = _dataData

    }
    var myChart = echarts.init(document.getElementById('charts2'));
    var option2;
    brokenLine(myChart, _date, sales_to)


    var myChart5 = echarts.init(document.getElementById('charts5'));
    var option5;
    var pieChartName = ['家庭', '公司', '集团','酒店', '其他'];
    var pieChartVue = [user_1, user_2, user_3, user_4, user_5];
    pieChart(myChart5, pieChartName, pieChartVue)
  })
}

$(function(){

$("#date_demo").text('请选择时间段')
var   dataUlLIactiveNum=1;
  $('.dataUlLI li').on('click', function() {

        dataUlLIactiveNum = ($(".dataUlLI li").index(this)) + 1;

            if(dataUlLIactiveNum==1){
                 $("#time1sub").val(GetDateStr(0,1))
                 $("#time2sub").val(GetDateStr(0,1))
            }else if(dataUlLIactiveNum==2){
                 $("#time1sub").val(GetDateStr(-1,1))
                 $("#time2sub").val(GetDateStr(-1,1))
            }else if(dataUlLIactiveNum==3){
                 $("#time1sub").val(GetDateStr(-6,1))
                 $("#time2sub").val(GetDateStr(0,1))
            }else if(dataUlLIactiveNum==4){
                 $("#time1sub").val(GetDateStr(-29,1))
                 $("#time2sub").val(GetDateStr(0,1))
            }else if(dataUlLIactiveNum==5){
                 $("#time1sub").val(GetDateStr(-89,1))

                 $("#time2sub").val(GetDateStr(0,1))
            }

      $('.dataUlLI  .activer').removeClass('activer');
      $(this).addClass('activer');
      $('.dataUlLI li p').css('borderRight', "1px #000 solid");
      $(".dataUlLI li:last-of-type p").css('borderRight', "0px #000 solid");
      $(this).prev().find('p').css('border', "none");
      $(this).find('p').css('border', "none");
      // $("#time1sub").val($(this).val())
      // $("#time2sub").val('')
      $("#date_demo").text('请选择时间段')
  });



})


// 分页
function  paging(total){

   $("#Total").text('共' + total + '条');
   var page_size = $('#page_size option:selected').val()
var current = Math.ceil(total / page_size)
$("#sconter").attr('max',current);
  var numTotal = $('#numTotal').text();


        $("#Circula .hort").remove()
 console.log(current)
console.log(numTotal)
      if (current > 5) {
               if(numTotal<=3){

                  for (var i = 1; i <= 5; i++) {
                    if(numTotal==i){

                     $("#Circula li:last-child").before('<li class="hort active" style="  color: #fff;" onclick="hortlick(' + i + ')">' + i + '</li>')
                    }else{
                       $("#Circula li:last-child").before('<li class="hort" style="  color: #fff;" onclick="hortlick(' + i + ')">' + i + '</li>') 
                    }
                  }
                   $("#Circula li:last-child").before('<li class="hort"  style="  color: #fff;">...</li>')
                   $("#Circula li:last-child").before('<li class="hort" style="  color: #fff;" onclick="hortlick(' + current + ')">' +current + '</li>')
               }
                else  if(numTotal>=current-3){
                 for (var i = current*1-4*1; i <= current; i++) {

                    if(numTotal==i){
                       $("#Circula li:last-child").before('<li class="hort active" style="  color: #fff;" onclick="hortlick(' + i + ')">' + i + '</li>')
                     }else{
                        $("#Circula li:last-child").before('<li class="hort" style="  color: #fff;" onclick="hortlick(' + i + ')">' + i + '</li>')
                     }
                  
                  }

                   $("#Circula li:nth-of-type(2)").before('<li  style="color: #fff;" class="hort">...</li>')


               }
               else{
                  for (var i = numTotal*1-2; i <= numTotal*1+2; i++) {
                      if(numTotal==i){
                        $("#Circula li:last-child").before('<li class="hort active"  style="color: #fff;"   onclick="hortlick(' + i + ')">' + i + '</li>')
                      }else{
                        $("#Circula li:last-child").before('<li class="hort "  style="color: #fff;"   onclick="hortlick(' + i + ')">' + i + '</li>')     
                      }

                    // $("#Circula li:last-child").before('<li class="hort"  style="color: #fff;"   onclick="hortlick(' + i + ')">' + i + '</li>')
                  }

                  $("#Circula li:last-child").before('<li class="hort"  style="color: #fff;">...</li>')
                  $("#Circula li:nth-of-type(2)").before('<li class="hort"  style="color: #fff;">...</li>')






               }
        }else { 
          for (var i = 1; i <= current; i++) {
            $("#Circula li:last-child").before('<li class="hort"     style="  color: #fff;"  onclick="hortlick(' + i + ')">' + i + '</li>')
          }
        }

}


