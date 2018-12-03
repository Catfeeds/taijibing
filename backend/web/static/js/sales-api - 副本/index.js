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


var now = 0,
  tomorrow = 0,
  week = 0,
  month = 0,
  quarter = 0;
if (upperquarterDate < quarterDate < uppermonthDate < monthDate < upperDate < weekDate < FrontrowDate < nowDate) {

  var ttt = new Date(FrontrowDate).toLocaleString();
  var tttt = new Date(tomorrowDate).toLocaleString();
}
// var synchronism=[0,0,0,0,0];

_hover($(".volumeHover"), $(".volumeText"))
_hover($(".compareHover"), $(".compareText"))
_hover($(".AverageHover"), $(".AverageText"))
  //伪类
function _hover(Class, ClassText) {
  Class.hover(function() {
    ClassText.css("display", "block");
  }, function() {
    ClassText.css("display", "none");
  });
}
// 访问--数据计算
$.post('./?r=sales-api/sales-detail', function(json) {
  if (json != null) {
    var json = JSON.parse(json);
    var salesVolume = [0, 0, 0, 0, 0, 0, 0, 0, 0];
    for (var i = 0; i < json.datas.length; i++) {
      // for (var i in json.datas) {
      // console.log(json.datas[i])
      //销量时间 （天）
      var strs = json.datas[i].RowTime.split(" ");
      // 判断是否和当前时间对比
      // 用户销量
      // 扫码时间戳
      var str = Date.parse(strs[0]);
      // 今天
      if (nowDate <= str) {
        salesVolume[0]++
      }
      // 昨天一天
      if (tomorrowDate <= str && str < nowDate) {
        var timestamp2 = new Date();
        timestamp2.setTime(tomorrowDate);
        // var tt = new Date(str).toLocaleString().replace(/\//g, "-");
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
    function percenttage(number1, number2) {
      if (!number2) {
        number2 = 1
        return (Math.round((number1 / number2) * 10000) / 100)
      }
      // else if(number1==0){
      //          return (-(Math.round(number2*10000 ) /100) ) 
      // }
      else {
        return (Math.round((number1 / number2 - 1) * 10000) / 100)
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
      "compare": [
        percenttage(salesVolume[0], (salesVolume[1])), //今日同期0
        percenttage(salesVolume[1], (salesVolume[2])), //昨日同期5
        percenttage(salesVolume[3], (salesVolume[4])), //一周同期5
        percenttage(salesVolume[5], (salesVolume[6])), //一月同期
        percenttage(salesVolume[7], (salesVolume[8])) //一季度同期
      ],
      //均销量
      "Average": [
        salesVolume[0] / json.user_number,
        salesVolume[1] / json.user_number,
        salesVolume[3] / json.user_number,
        salesVolume[5] / json.user_number,
        salesVolume[7] / json.user_number,
      ]
    };


    forDataTime(sales_volume.volume, $(".consumer td"))
    forDataTimeyop(sales_volume.Average, $(".equally td"))
      //渲染同期

    for (var i = 0; i < sales_volume.compare.length; i++) {
      if (isNaN(sales_volume.compare[i])) {
        sales_volume.compare[i] = 0;
      }
      var sales_volume_num = sales_volume.compare[i]
      if (sales_volume_num == "NaN") {
        sales_volume_num == 0;
      }

      if (!sales_volume_num) {

        if (sales_volume.compare[i] === "Infinity") {
          sales_volume.compare[i] == 0;
        }
        $(".relatively td").eq(i + 1).html('持平 &nbsp;<img src="/static/images3/rectangle.png">')

      } else if (sales_volume_num < 0) {
        if (sales_volume.compare[i] === "Infinity") {
          sales_volume.compare[i] == 0;
        }
        $(".relatively td").eq(i + 1).html(sales_volume_num + '%&nbsp;<img src="/static/images3/Arrowb.png">')

      } else if (sales_volume_num > 0) {
        if (sales_volume.compare[i] === "Infinity") {
          sales_volume.compare[i] == 0;
        }
        $(".relatively td").eq(i + 1).html(sales_volume_num + '%&nbsp;<img src="/static/images3/arrowA.png">')

      }
    }
  }
})

function getresult(num, n) {
  return num.toString().replace(new RegExp("^(\\-?\\d*\\.?\\d{0," + n + "})(\\d*)$"), "$1") + 0;
}

function begin_linlst_time_clea() {
  var num = localStorage.getItem('itmenum')
  var adddate = $("#adddate").val()
  var adddatea = adddate.split("到");
var startime = adddatea[0] +' 00:00';
  var endtime = adddatea[1]+' 24:00';

  var parameter = {
    "state": num,
    "offset": 0,
    'limit': 10,
    "startime": startime,
    "endtime": endtime,
    "search": $("#search").val()
  }
    postData(parameter, num,$(".tableBox thead"),$("#tableBoxData"))
}

function begin_end_time_clear() {

  var num = localStorage.getItem('itmenum')
  $("#adddate").val('')
  $("#search").val('')
  var parameter = {
    "state": num,
    "offset": 0,
    'limit': 10,
  }

  postData(parameter, num,$(".tableBox thead"),$("#tableBoxData"))

}