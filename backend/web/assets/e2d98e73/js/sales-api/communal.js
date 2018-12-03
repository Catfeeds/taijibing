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
   	 var nowDate = Date.parse(GetDateStr(1, 1))
   	    // 作日时间戳
   	 var tomorrowDate = Date.parse(GetDateStr(-1, 1))
   	    // 前日时间戳
   	 var FrontrowDate = Date.parse(GetDateStr(-2, 1))
   	    // 本周时间戳
   	 var weekDate = Date.parse(GetDateStr(-7, 1))
   	    // 上周时间戳
   	 var upperDate = Date.parse(GetDateStr(-14, 1))
   	    // 本月时间戳
   	 var monthDate = Date.parse(GetDateStr(1, 0))
   	    // 上月时间戳
   	 var uppermonthDate = Date.parse(GetDateStr(1, -1))
   	    // 一季度时间戳
   	 var quarterDate = Date.parse(GetDateStr(1, -3))
   	    // 上季度时间戳
   	 var upperquarterDate = Date.parse(GetDateStr(1, -7))

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


   	 // 折线图X轴

   	 function forDataTime($data, $e) {
   	    for (var i = 0; i < $data.length; i++) {
   	       if (isNaN($data[i])) {
   	          $data[i] = 0;
   	       }
   	       $e.eq(i + 1).text(Math.ceil($data[i]))
   	    }
   	 };

   	 // 定义一个换页方法
   	 function hortlick(e) {
   	    var sconter = e;
   	    var page_size = $('#page_size option:selected').val()
   	    var parameter = {
   	       "offset": sconter * page_size - page_size, //起始,
   	       'limit': page_size
   	    }
   	    $('#numTotal').text(sconter);
   	    postData(parameter, a)


   	 }

   	 $('#btn a').click(function() {
   	    var sconter = $('#numTotal').val(); //当前页数
   	    paging()
   	 })
   	 $(document).on('click', ".Previous", function() {

   	    var sconter = $('#numTotal').text(); //当前页数
   	    var page_size = $('#page_size option:selected').val()

   	    sconter--
   	    if (sconter <= 1) {
   	       sconter = 1
   	    }
   	    var parameter = {
   	       "state": role_id,
   	       "offset": sconter * page_size - page_size, //起始,
   	       'limit': page_size
   	    }
   	    postData(parameter, a)
   	    $('#numTotal').text(sconter);

   	 }).on('click', '.Next', function() {
   	    var _this = this;
   	    var sconter = $('#numTotal').text(); //当前页数
   	    var page_size = $('#page_size option:selected').val()
   	    var parameter = {
   	       "state": role_id,
   	       "offset": sconter * page_size, //起始,
   	       'limit': page_size
   	    }
   	    if (sconter >= $("#sconter").attr("max")) {
   	       sconter == $("#sconter").attr("max")
   	       return false;
   	    }
   	    postData(parameter, a)
   	    sconter++
   	    $('#numTotal').text(sconter);

   	 })



   	 function paging() {
   	    $('#numTotal').text(sconter);
   	    var page_size = $('#page_size option:selected').val()
   	    var parameter = {
   	       "state": role_id,
   	       "offset": sconter * page_size - page_size, //起始,
   	       'limit': page_size
   	    }
   	    postData(parameter, a)
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

