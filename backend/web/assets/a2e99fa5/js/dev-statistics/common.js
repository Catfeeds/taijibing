
_hover($(".volumeHover"), $(".volumeText"))
_hover($(".compareHover"), $(".compareText"))
_hover($(".AverageHover"), $(".AverageHover-text"))

  //伪类
function _hover(Class, ClassText) {
  Class.hover(function() {
    ClassText.css("display", "block");
  }, function() {
    ClassText.css("display", "none");
  });
}






      
    // 日期  
 new pickerDateRange('date_demo', {
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

         if(obj.startDate){
            $("#time1sub").val(obj.startDate)
            $("#time2sub").val(obj.endDate)
            $("#IsTurnOut").val('');

            if(!obj.endDate){
                 $("#time2sub").val(GetDateStr(0,1))  
                 obj.endDate= GetDateStr(0,1);
                  $("#date_demo").html(obj.startDate + '至' + obj.endDate);
            }
             salesDetailLine()
         }

     console.log(appendfIsTurnOut.IsTurnOut)
          appendfIsTurnOut.IsTurnOut.val('').trigger("chosen:updated");
      }
    });
// 图表计算
function javaData(dataArr) {
    // 饼图的y轴
    var LineY=[]
    var LineX=[];
    var PicY=[0,0,0,0,0];
    var PicX=['家庭','办公','集团','酒店','其他'];
    var MapY=[];
    var MapX=[];
    var time1sub=$("#time1sub").val();
    var time2sub=$("#time2sub").val();

   // 折线计算
    var Today = GetDateStr(0,1);
        // 选中了几天
    var time = diy_time(time1sub, time2sub)+1;
        //结束时间到今天的天数
    var Today_time =  diy_time(time2sub, Today);
        // X轴
         LineX = NumberDays(time, LineX, Today_time);

      // 今日时间全
    var time_Today=LineX;


    var   LineXNum =   LineX.length;   


    //  console.log(LineXNum)
     // console.log(LineX)

    // return;


    var  LineXN =[];
      if(LineX.length<2){
        LineX = ['0:30','1:00','1:30','2:00','2:30','3:00','3:30','4:00','4:30','5:00','5:30','6:00','6:30','7:00','7:30','8:00','8:30','9:00','9:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30','24:00'] ;

            for(var i=0;i<LineX.length;i++){
                  time_Today.push(  time1sub+" "+LineX[i]+':00')
            }
      }else{
          for(var i=0;i<LineX.length;i++){

                 // console.log(LineX[i])


              LineXN.push(LineX[i]);
             time_Today[i] =  LineX[i]+ " 00:00:00" ;
          }
      }
       $.each(LineX, function (index, item) {  
            LineY.push(0)
       })
console.log(LineXN) 
console.log(time_Today)
   

   var mapProvince=[] //定义一个人地图省级数组 名字；
   var mapCity = [] //定义一个人地图市级数组 名字；
   var mapArea = [] //定义一个人地图区级数组 名字；


   console.log(dataArr)



   if(dataArr){


    for(var index=0;index<dataArr.length;index++){
         // 折线时间戳计算
          var dataArr_RowTime = Date.parse(dataArr[index].RowTime)/1000;
          // console.log(dataArr_RowTime)
          for(var y=0;y<time_Today.length;y++){
              var Today_RowTime = Date.parse(time_Today[y])/1000;
               if(LineXNum<2){
                   if(dataArr_RowTime<(Today_RowTime+60*60*0.5)&&dataArr_RowTime>=Today_RowTime){
                         LineY[y-1]++

                         // console.log(Today_RowTime)
                   }
               }else{
                if(dataArr_RowTime<(Today_RowTime+60*60*24)&&dataArr_RowTime>=Today_RowTime){
                     LineY[y]++
                }
               }
          }


            // console.log(PicYType)

      // 饼状图计算
          var PicYType = dataArr[index].CustomerType;

          // console.log(PicYType)
          if(!PicYType){
            PicYType=-1;
          }
          // console.log()
          switch(Number(PicYType))
            {
            case 1:
               PicY[0]++
              break;
            case 2:
                PicY[1]++
              break;
              case 3:
                PicY[2]++
              break;
                case 4:
                PicY[3]++
              break;
              default:
                PicY[4]++
             };
        
        // 地图数据取出
         var dataArr_mapProvince =dataArr[index].Province||'其它';
         var dataArr_mapCity =dataArr[index].City||'其它';
         var dataArr_mapArea =dataArr[index].Area||'其它';
          mapProvince.push(dataArr_mapProvince)
          mapCity.push(dataArr_mapCity)
          mapArea.push(dataArr_mapArea)
   			 }
      }
// console.log(LineX)
// console.log(LineY)
// console.log(PicY)
// console.log(PicX)
// console.log(mapProvince)

if(LineXNum<2){
  LineXN=LineX
}

FoldLineDiagram(LineXN,LineY,'设备');

PieChart(PicX, PicY, '设备统计')
// 地图数据计算
 // var ProvinceUn = unique(mapProvince);
 // var CityUn = unique(mapCity);
 // var AreaUn = unique(mapArea);
 //  console.log(ProvinceUn);

// 计算多少台数量
var repeatProvince =repeatNum(mapProvince);
var repeatCity =repeatNum(mapCity);
var repeatArea =repeatNum(mapArea);

  $("#percentum").empty(  )
  for (var i = 0; i < repeatProvince.length; i++) {
        var itemNum = repeatProvince[i][1];
        var itemName = repeatProvince[i][0];
         
        var scaling = Math.floor(itemNum/mapProvince.length* 10000) / 100;

          var Percentage_html =' <div class="progress">';
              Percentage_html+='<span class="name">'+itemName+'</span>'  
              Percentage_html+='<div class="progress-bar" role="progressbar" aria-valuenow="'+scaling+'" aria-valuemin="0" aria-valuemax="100" style="width:' + scaling + '%;">';
              Percentage_html+='  </div>'
              Percentage_html+='  <span class="tyfole">' + scaling + '% </span>'
              Percentage_html+='  </div>'
                
            $("#percentum").append(Percentage_html)
   }

  var mapProvinceNUmColor = ['#D29616', '#4ADCDD', '#C248DC', '#EA5638', '#D29717'];
        var map_obj={
           'Name':'销量',
           'Unit':'台',
           'tadalProvince':mapProvince.length,
           'tadalCity':mapCity.length
        }

        // console.log(map_obj)
		if(role_id==1){

		  map(repeatProvince, repeatCity, mapProvinceNUmColor,map_obj);
		}

}


// 提计算两个数组中一样的个数
          function    repeatNum(_arr){
            var _res = [];
              _arr.sort();
              for (var i = 0; i < _arr.length;) {
                  var count = 0;
                  for (var j = i; j < _arr.length; j++) {
                      if (_arr[i] == _arr[j]) {
                          count++;
                      }
                  }
                  _res.push([_arr[i], count]);
                  i += count;
              }
              //_res 二维数维中保存了 值和值的重复数
              var _newArr = [];
              for (var i = 0; i < _res.length; i++) {
                  // console.log(_res[i][0] + "重复次数:" + _res[i][1]);
                  _newArr.push(_res[i][0] + 'x' + _res[i][1]);
              }
              // console.log(_newArr);
          return _res;
          } 


// 测试净增设备
// var array = [{'DevNo':1},{'DevNo':2},{'DevNo':3},{'DevNo':4},{'DevNo':5}]
// var array2 = [{'DevNo':3},{'DevNo':4},{'DevNo':5}]

// console.log(arrayObjUnique(array,array2))


// 数组去重
function unique(arr){
　　var res =[];
　　var json = {};
　　for(var i=0;i<arr.length;i++){
　　　　if(!json[arr[i]]){
　　　　　　res.push(arr[i]);
　　　　　　json[arr[i]] = 1;

　　　　}

　　}
　　return res;
}






// 计算时间天数
function diy_time(time1num, time2num) {
  time1data = Date.parse(new Date(time1num));
  time2data = Date.parse(new Date(time2num));
  return time3 = Math.abs(parseInt((time2data - time1data) / 1000 / 3600 / 24));
}

// x轴的时间
function NumberDays(xin, _date, _datenume) {

  // console.log(xin)
// console.log(_datenume)
  var xin = xin+_datenume-1;
  // console.log(xin)
  var _datenume = _datenume || 0;
  for (var i = -_datenume; i >= -xin; i--) {
    // console.log(i)
    _date.push(GetDateStr(i, 1))
  }
  _date.reverse();
  return _date;
}


// 提取两个数组中不一样的数组
function arrayObjUnique(arr1,arr2){
   var arr3 = [];
// console.log(arr2)
    for(key in arr1) {
      var stra = arr1[key];
       // console.log(stra.DevNo)
      var count = 0;
      for(var j = 0; j < arr2.length; j++) {
        var strb = arr2[j];
          if(stra.DevNo == strb.DevNo) {
 //            // 
              count++;
              // console.log(count)
          }
      }
     if(count === 0) { //表示数组1的这个值没有重复的，放到arr3列表中  
        arr3.push(stra);
      }
    }
 return arr3;
}







// 同期

function percenttage(number1, number2) {
     var html ='';
     var num ='';

     var number1 = Number(number1)
     var number2 = Number(number2)
      if (!number2) {
          number2 = 1
          num = 0;
      }
       else if (!number1) {
          // number1 = 1
          num = -100;
      }
      else {
         num = (Math.round((number1 / number2) * 10000) / 100)
      }

      if(num==0){
           html = ('&nbsp;&nbsp;&nbsp;<span  style="color:#e5af00;">持平</span> &nbsp;<img src="/static/images3/rectangle.png">')
      }else if(num>0){
      	    html = ('&nbsp;&nbsp;&nbsp;<span  style=" color: red;">'+num+'%</span>&nbsp;<img src="/static/images3/arrowA.png">')
  	  }else{
  		    html = ('&nbsp;&nbsp;&nbsp;<span style="color:#09a314;">'+(-num)+'%</span>&nbsp;<img src="/static/images3/Arrowb.png">')
  	 };
  	 return html;
}



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


// 折线图

// 折线图
function FoldLineDiagram(darax, daray, $name) {
    var myChart = echarts.init(document.getElementById('main'));
    var option = {
        title: {
            text: "",
            x: "center",
            textStyle: {
                color: '#989BA3',
                x: '100px',
            },
        },
        tooltip: {
            trigger: 'axis',
            backgroundColor: '#E6B64F',
            textStyle: {
                color: '#000',
            },
        },
        xAxis: [{
            type: "category",
            axisLabel: {
                //X轴刻度配置
                interval: 2 //0：表示全部显示不间隔；auto:表示自动根据刻度个数和宽度自动设置间隔个数
            },

            splitLine: {
                show: false
            },
            data: darax,
            axisLabel: {
                show: true,
                textStyle: {
                    color: 'rgb(255,255,255)',
                }
            }
        }],

        yAxis: [{
            type: 'value',
            axisLabel: {
                show: true,
                textStyle: {
                    color: 'rgb(255,255,255)',
                }
            }
        }],
        toolbox: {
            show: true,
            feature: {
                mark: {
                    show: false
                },
                dataView: {
                    show: false,
                    readOnly: false,

                },
                restore: {
                    show: false
                },
                saveAsImage: {
                    show: false
                }
            },

        },
       
        calculable: true,
        series: [{
            name: $name,
            type: 'line',
            //data:selloutPackage.y,
            data: daray,
            itemStyle: {
                normal: {

                    color: '#E6B64F',
                    width: 1

                }
            }
        }]
    };
    // 为echarts对象加载数据 
    myChart.setOption(option);

}



// 饼状图
function PieChart($name, $data, $namedata) {

  // console.log( $data)
    var myChart = echarts.init(document.getElementById('echarts3'));
    var option = {
        title: {
           text: $namedata,
           textStyle: {
             color: '#fff',
             x: '100px',
           },
           y: '10px',
           x: 'center'

         },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    // legend: {
    //     orient : 'vertical',
    //     x : 'left',
    //     data:['直接访问','邮件营销','联盟广告','视频广告','搜索引擎']
    // },
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

            legend: {
           orient: 'vertical',
           left: 'right',
           top: 'bottom',
           data: $name,
           textStyle: {
             color: '#fff'
           }
         },

    // calculable : true,

         label: {
           normal: {
             formatter: '{b}:{c}: ({d}%)',
             textStyle: {
               fontWeight: 'normal',
               fontSize: 15
             }
           }
         },
    series : [
        {
            name:'访问来源',
            type:'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[
                {
                value: $data[0],
                name: '家庭'
            },
            {
                value: $data[1],
                name: '公司'
            },
            {
                value: $data[2],
                name: '集团'
            },
            {
                value: $data[3],
                name: '酒店'
            },
            {
                value: $data[4],
                name: '其他'
            }
            ]
        }
    ]
};
    myChart.setOption(option);
}
function  map(repeatProvince, repeatCity,mapProvinceNUmColor,map_obj){
  // console.log(repeatProvince)
  // console.log(repeatCity)
  // console.log(mapProvinceNUmColor)
  // console.log(map_obj)
  require.config({
    paths: {
      echarts: '/static/js/echarts/dist'
    }
  });
  require(
    [
      'echarts',
      'echarts/chart/map' // ，按需加载
    ],
    function(ec) {
      // 基于准备好的dom，初始化echarts图表
      var myChart = ec.init(document.getElementById('echarts2'));
      var ecConfig = require('echarts/config');
      var zrEvent = require('zrender/tool/event');
      var curIndx = 0;
      var mapType = [
        'china',
        // 23个省
        '广东', '青海', '四川', '海南', '陕西',
        '甘肃', '云南', '湖南', '湖北', '黑龙江',
        '贵州', '山东', '江西', '河南', '河北',
        '山西', '安徽', '福建', '浙江', '江苏',
        '吉林', '辽宁', '台湾',
        // 5个自治区
        '新疆', '广西', '宁夏', '内蒙古', '西藏',
        // 4个直辖市
        '北京', '天津', '上海', '重庆',
        // 2个特别行政区
        '香港', '澳门'
      ];
      myChart.on(ecConfig.EVENT.MAP_SELECTED, function(param) {
        var len = mapType.length;
        var mt = mapType[curIndx % len];
        if (mt == 'china') {

          // 全国选择时指定到选中的省份
          var selected = param.selected;
          for (var i in selected) {
            if (selected[i]) {
              mt = i;
              while (len--) {
                if (mapType[len] == mt) {
                  curIndx = len;
                  $(".ProvincialActiove").removeClass('ProvincialActiove');
                  $("#CityMap").addClass('ProvincialActiove')
                   if(repeatCity){


                    // console.log(54)
                        $("#percentum").empty();
                      for (var j = 0; j < repeatCity.length; j++) {
                      var scaling  =Math.round((repeatCity[j][1]/map_obj.tadalCity)* 10000)/100;

                        var Percentage_html =' <div class="progress">';
                              Percentage_html+='<span class="name">'+repeatCity[j][0]+'</span>'  
                              Percentage_html+='<div class="progress-bar" role="progressbar" aria-valuenow="'+scaling+'" aria-valuemin="0" aria-valuemax="100" style="width:' + scaling + '%;">';
                              Percentage_html+='  </div>'
                              Percentage_html+='  <span class="tyfole">' + scaling + '% </span>'
                              Percentage_html+='  </div>'
                         $("#percentum").append(Percentage_html);
                      }
                   }
                }
              }
              break;
            }
          };
          option.tooltip.formatter = function(data) {
            
            if(repeatCity){
              // console.log(repeatCity)
              // console.log(map_obj)
              for (var i = 0; i < repeatCity.length; i++) {
              while (repeatCity[i][0] == data[1]) {
                return '本月'+map_obj.Name+'情况：<br/>' + data[1] +map_obj.Name+ Math.round((repeatCity[i][1]) * 10000) / 10000 + map_obj.Unit+' <br/>本市占比' + Math.round((repeatCity[i][1]/map_obj.tadalCity) * 10000) / 100 + '%'
              }
             }
            }
            return '本地区还没有开放';
          }
        } else {

          $(".ProvincialActiove").removeClass('ProvincialActiove');
          $("#Provincial").addClass('ProvincialActiove')

               if(repeatProvince){
                // console.log(4)
                   $("#percentum").empty();

                  for (var i = 0; i < repeatProvince.length; i++) {
                var scaling  =Math.round((repeatProvince[i][1]/map_obj.tadalProvince)* 10000)/100;

                var Percentage_html =' <div class="progress">';
                    Percentage_html+='<span class="name">'+repeatProvince[i][0]+'</span>'  
                    Percentage_html+='<div class="progress-bar" role="progressbar" aria-valuenow="'+scaling+'" aria-valuemin="0" aria-valuemax="100" style="width:' + scaling + '%;">';
                    Percentage_html+='  </div>'
                    Percentage_html+='  <span class="tyfole">' + scaling + '% </span>'
                    Percentage_html+='  </div>'
                  $("#percentum").append(Percentage_html);
                      }

                 }
    




          curIndx = 0;
          mt = 'china';
          // option.tooltip.formatter = '设备分布情况：<br/>{b}分布888台<br/>全国占比50%';
          option.tooltip.formatter = function(data) {
            if(repeatProvince){
              // console.log(5)
                   for (var i = 0; i < repeatProvince.length; i++) {

                while (repeatProvince[i][0] == data[1] + '省'||repeatProvince[i][0] == data[1] + '市'||repeatProvince[i][0] == data[1]) {

              return '本月'+map_obj.Name+'情况：<br/>' + data[1] + map_obj.Name  + Math.round((repeatProvince[i][1]) * 10000) / 10000 + map_obj.Unit+' <br/>本市占比' + Math.round((repeatProvince[i][1]/map_obj.tadalProvince)* 10000) / 100 + '%'
                }
              }
            }
            return '本地区还没有开放';
          }
        }
        option.series[0].mapType = mt;
        // option.title.subtext = mt + ' （滚轮或点击切换）';
        myChart.setOption(option, true);
      });

      option = {
        title: {
          text: '',
          textStyle: {
            color: '#fff'
          },
          // subtext : 'china （滚轮或点击切换）'
        },
        tooltip: {
          trigger: 'item',
          // formatter: '设备分布情况：<br/>{b}分布888台<br/>全国占比50%'
          formatter: function(data) {
            if (repeatProvince) {
           // console.log(data[1])   
              for (var i = 0; i < repeatProvince.length; i++) {

                while (repeatProvince[i][0] == data[1] + '省'||repeatProvince[i][0] == data[1] + '市'||repeatProvince[i][0] == data[1]) {

return '本月'+map_obj.Name+'情况：<br/>' + data[1] + map_obj.Name  + Math.round((repeatProvince[i][1]) * 10000) / 10000 + map_obj.Unit+' <br/>本市占比' + Math.round((repeatProvince[i][1]/map_obj.tadalProvince) * 10000) / 100 + '%'
                }
              }
              return '本地区还没有开放';
            }
          }
        },
        legend: {
          orient: 'vertical',
          x: 'left',
          data: ['']
        },
        dataRange: {
             orient: 'horizontal',
        x: 'left',
        min: 0,
        max: 1000,
        color:['#E46045 ','#E6B64F'],
        text:['高','低'],           // 文本，默认为数值文本
        splitNumber:0,
           textStyle: {
            color: '#fff'
          },
        },

        series: [{
          name: '销量情况',
          type: 'map',
          mapType: 'china',
          selectedMode: 'single',
          color: '#e6b64f',

          itemStyle: {
            normal: {
              label: {
                show: true
              },
              borderWidth: 0.2,
              borderColor: '#231816',
              color: '#e6b64f',

          
            },
             emphasis: {
              areaStyle:{
              color:'#E46045'
      },

              label: {
                show: true,
                borderColor: '#231816',
     
              }
            }
          },
          data: [

            {
              name: '重庆市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '北京市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '天津市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '上海市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '香港',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '澳门',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '巴音郭楞蒙古自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '和田地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '哈密地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阿克苏地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阿勒泰地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '喀什地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '塔城地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '昌吉回族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '克孜勒苏柯尔克孜自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '吐鲁番地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '伊犁哈萨克自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '博尔塔拉蒙古自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '乌鲁木齐市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '克拉玛依市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阿拉尔市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '图木舒克市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '五家渠市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '石河子市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '那曲地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阿里地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '日喀则地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '林芝地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '昌都地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '山南地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '拉萨市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '呼伦贝尔市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阿拉善盟',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '锡林郭勒盟',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '鄂尔多斯市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '赤峰市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '巴彦淖尔市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '通辽市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '乌兰察布市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '兴安盟',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '包头市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '呼和浩特市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '乌海市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '海西蒙古族藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '玉树藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '果洛藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '海南藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '海北藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黄南藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '海东地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '西宁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '甘孜藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阿坝藏族羌族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '凉山彝族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '绵阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '达州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '广元市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '雅安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宜宾市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '乐山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '南充市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '巴中市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '泸州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '成都市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '资阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '攀枝花市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '眉山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '广安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '德阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '内江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '遂宁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '自贡市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黑河市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '大兴安岭地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '哈尔滨市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '齐齐哈尔市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '牡丹江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '绥化市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '伊春市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '佳木斯市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '鸡西市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '双鸭山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '大庆市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '鹤岗市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '七台河市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '酒泉市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '张掖市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '甘南藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '武威市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '陇南市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '庆阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '白银市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '定西市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '天水市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '兰州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '平凉市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '临夏回族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '金昌市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '嘉峪关市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '普洱市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '红河哈尼族彝族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '文山壮族苗族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '曲靖市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '楚雄彝族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '大理白族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '临沧市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '迪庆藏族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '昭通市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '昆明市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '丽江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '西双版纳傣族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '保山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '玉溪市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '怒江傈僳族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '德宏傣族景颇族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '百色市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '河池市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '桂林市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '南宁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '柳州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '崇左市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '来宾市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '玉林市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '梧州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '贺州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '钦州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '贵港市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '防城港市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '北海市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '怀化市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '永州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '邵阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '郴州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '常德市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '湘西土家族苗族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '衡阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '岳阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '益阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '长沙市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '株洲市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '张家界市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '娄底市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '湘潭市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '榆林市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '延安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '汉中市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '安康市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '商洛市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宝鸡市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '渭南市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '咸阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '西安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '铜川市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '清远市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '韶关市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '湛江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '梅州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '河源市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '肇庆市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '惠州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '茂名市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '江门市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阳江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '云浮市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '广州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '汕尾市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '揭阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '珠海市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '佛山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '潮州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '汕头市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '深圳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '东莞市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '中山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '延边朝鲜族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '吉林市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '白城市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '松原市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '长春市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '白山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '通化市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '四平市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '辽源市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '承德市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '张家口市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '保定市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '唐山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '沧州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '石家庄市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '邢台市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '邯郸市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '秦皇岛市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '衡水市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '廊坊市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '恩施土家族苗族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '十堰市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宜昌市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '襄樊市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黄冈市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '荆州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '荆门市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '咸宁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '随州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '孝感市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '武汉市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黄石市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '神农架林区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '天门市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '仙桃市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '潜江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '鄂州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '遵义市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黔东南苗族侗族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '毕节地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黔南布依族苗族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '铜仁地区',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黔西南布依族苗族自治州',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '六盘水市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '安顺市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '贵阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '烟台市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '临沂市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '潍坊市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '青岛市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '菏泽市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '济宁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '德州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '滨州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '聊城市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '东营市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '济南市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '泰安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '威海市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '日照市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '淄博市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '枣庄市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '莱芜市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '赣州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '吉安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '上饶市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '九江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '抚州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宜春市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '南昌市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '景德镇市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '萍乡市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '鹰潭市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '新余市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '南阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '信阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '洛阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '驻马店市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '周口市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '商丘市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '三门峡市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '新乡市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '平顶山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '郑州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '安阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '开封市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '焦作市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '许昌市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '濮阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '漯河市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '鹤壁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '大连市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '朝阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '丹东市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '铁岭市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '沈阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '抚顺市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '葫芦岛市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阜新市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '锦州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '鞍山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '本溪市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '营口市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '辽阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '盘锦市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '忻州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '吕梁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '临汾市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '晋中市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '运城市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '大同市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '长治市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '朔州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '晋城市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '太原市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阳泉市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '六安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '安庆市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '滁州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宣城市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '阜阳市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宿州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '黄山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '巢湖市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '亳州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '池州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '合肥市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '蚌埠市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '芜湖市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '淮北市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '淮南市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '马鞍山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '铜陵市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '南平市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '三明市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '龙岩市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宁德市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '福州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '漳州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '泉州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '莆田市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '厦门市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '丽水市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '杭州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '温州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宁波市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '舟山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '台州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '金华市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '衢州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '绍兴市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '嘉兴市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '湖州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '盐城市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '徐州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '南通市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '淮安市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '苏州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '宿迁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '连云港市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '扬州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '南京市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '泰州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '无锡市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '常州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '镇江市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '吴忠市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '中卫市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '固原市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '银川市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '石嘴山市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '儋州市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '文昌市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '乐东黎族自治县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '三亚市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '琼中黎族苗族自治县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '东方市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '海口市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '万宁市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '澄迈县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '白沙黎族自治县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '琼海市',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '昌江黎族自治县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '临高县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '陵水黎族自治县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '屯昌县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '定安县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '保亭黎族苗族自治县',
              value: Math.round(Math.random() * 1000)
            }, {
              name: '五指山市',
              value: Math.round(Math.random() * 1000)
            }


          ]
        }]
      };
      // 为echarts对象加载数据 
      myChart.setOption(option);
    }
  )

}
