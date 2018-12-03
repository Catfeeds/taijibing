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




   	 // 定义一个换页方法
   	 function hortlick(e) {

      console.log(e)
   	   var num = localStorage.getItem('itmenum')


   	   var sconter = e;
   	   var page_size = $('#page_size option:selected').val()
   	   var parameter = {
   	     "state": num,
   	     "offset": sconter * page_size - page_size, //起始,
   	     'limit': page_size
   	   }
   	   $('#numTotal').text(sconter);

   	   postData(parameter, 1,$(".tableBox thead"),$("#tableBoxData"))
   	 }

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
   	 Array.prototype.notempty = function() {
   	     return this.filter(t => t != undefined && t !== null);
   	   }
   	   // 数组去重

   	 Array.prototype.unique = function() {
   	   var res = [];
   	   var json = {};

   	   for (var p = 0; p < this.length; p++) {
   	     if (!json[this[p]]) {
   	       res.push(this[p]);
   	       json[this[p]] = 1;
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




     
// 导出表格

             var idTmr;  
        function  getExplorer() {  
            var explorer = window.navigator.userAgent ;  
            //ie  
            if (explorer.indexOf("MSIE") >= 0) {  
                return 'ie';  
            }  
            //firefox  
            else if (explorer.indexOf("Firefox") >= 0) {  
                return 'Firefox';  
            }  
            //Chrome  
            else if(explorer.indexOf("Chrome") >= 0){  
                return 'Chrome';  
            }  
            //Opera  
            else if(explorer.indexOf("Opera") >= 0){  
                return 'Opera';  
            }  
            //Safari  
            else if(explorer.indexOf("Safari") >= 0){  
                return 'Safari';  
            }  
        }  

      function method(tableid) {
         $(document).ready(function(){ 
            if(getExplorer()=='ie')  
            {  
                var curTbl = document.getElementById(tableid);  
                var oXL = new ActiveXObject("Excel.Application");  
                var oWB = oXL.Workbooks.Add();  
                var xlsheet = oWB.Worksheets(1);  
                var sel = document.body.createTextRange();  
                sel.moveToElementText(curTbl);  
                sel.select();  
                sel.execCommand("Copy");  
                xlsheet.Paste();  
                oXL.Visible = true;  
                try {  
                    var fname = oXL.Application.GetSaveAsFilename("Excel.xls", "Excel Spreadsheets (*.xls), *.xls");  
                } catch (e) {  
                    print("Nested catch caught " + e);  
                } finally {  
                    oWB.SaveAs(fname);  
                    oWB.Close(savechanges = false);  
                    oXL.Quit();  
                    oXL = null;  
                    idTmr = window.setInterval("Cleanup();", 1);  
                }  
  
            }  
            else  
            {  
                
                tableToExcel(tableid)  
            }  

      });      
        }  
        function Cleanup() {  
            window.clearInterval(idTmr);  
            CollectGarbage();  
        }  

        var tableToExcel = (function() {  
            var uri = 'data:application/vnd.ms-excel;base64,',  
                    template = '<html><head><meta charset="UTF-8"></head><body><table>{table}</table></body></html>',  
                    base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },  
                    format = function(s, c) {  
                        return s.replace(/{(\w+)}/g,  
                                function(m, p) { return c[p]; }) }  
            return function(table, name) {    
                if (!table.nodeType) table = document.getElementById(table)  
                var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}  
                window.location.href = uri + base64(format(template, ctx))  
            }  
        })()  

 