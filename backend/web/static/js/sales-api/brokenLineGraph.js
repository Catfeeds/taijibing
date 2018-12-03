var xin = 7;
var _date = []

function NumberDays(xin) {
  for (var i = 0; i >= -xin + 1; i--) {
    _date.push(GetDateStr(i, 1))
      // console.log(GetDateStr(i,1))
  }
  _date.reverse();
}
NumberDays(xin)
javaData(_date)
var time_id = {
  'time': 3
}

function javaData(_date, time_id) {
  $.post('./?r=sales-api/sales-detail-line', time_id, function(json) {

    var json = JSON.parse(json);
    var sales_to = [];
    var user_1 = 0; //家庭
    var user_2 = 0; //办公
    var user_3 = 0; //集团
    var user_4 = 0; //其他
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
    var pieChartName = ['家庭', '公司', '集团', '其他'];
    var pieChartVue = [user_3, user_2, user_1, user_4];
    pieChart(myChart5, pieChartName, pieChartVue)
  })
}

// $("#IsTurnOut").

$("#IsTurnOut").change(function() {
  var ss = $(this).children('option:selected').val();
  if (ss == "1") {
    time_id = {
      'time': '1'
    }
    xin = 1;
    // _date=['0:00','6:00','12:00','16:00','22:00'];
    _date = []
    NumberDays(xin)
    javaData(_date, time_id)
  } else if (ss == "2") {
    time_id = {
      'time': '2'
    }
    _date = []
    xin = 2;
    // date=['0:00','6:00','12:00','16:00','22:00'];
    NumberDays(xin)
    javaData(_date, time_id)

  } else if (ss == "3") {
    time_id = {
      'time': '3'
    }

    _date = []
    xin = 7;
    NumberDays(xin)

    javaData(_date, time_id)
  } else if (ss == "4") {
    time_id = {
      'time': '4'
    }
    xin = 30;
    _date = []
    NumberDays(xin)
    javaData(_date, time_id)
  } else if (ss == "5") {
    time_id = {
      'time': '5'
    }
    xin = 90;
    _date = []
    NumberDays(xin)
    javaData(_date, time_id)
  } else if (ss == "6") {
    time_id = {
      'time': '6'
    }
    xin = 360;
    _date = []
    NumberDays(xin)
    javaData(_date, time_id)
  } else {

    xin = 7;
    _date = []
    NumberDays(xin)
    javaData(_date, time_id)
  }
});