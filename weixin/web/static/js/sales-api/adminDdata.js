var parameter = {
  "state": '',
  "offset": 0,
  'limit': 10,

  "search": $("#search").val(),
}
postData(parameter, 1)
var j;
localStorage.setItem('itmenum', 1)

function postData(parameter, num) {
  if (num >= 1) {
    $(".navdata .active").removeClass("active")
    $(".navdata ul li").eq(num - 1).addClass('active')
  }
  var w = 0;
  $.post('./?r=sales-api/datas', parameter, function(objdata) {
    if (objdata || objdata != null) {
      var objdata = JSON.parse(objdata);
      data = objdata.users
      $("#tableBoxData").html('');

      if (objdata.role_id) {

        for (var i = 0; i < data.length; i++) {
          w++
          var user_1 = 0; //家庭
          var user_2 = 0; //办公
          var user_3 = 0; //集团
          var user_4 = 0; //其他
          for (var y = 0; y < data[i].user.length; y++) {

            if (data[i].user[y].CustomerType * 1 == 1) {
              user_1++
            }
            if (data[i].user[y].CustomerType == "2") {
              user_2++
            }
            if (data[i].user[y].CustomerType == "3") {
              user_3++
            }
            if (data[i].user[y].CustomerType == "99") {
              user_4++
            }
          }
          if (num == 2) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>服务中心</th><th>联系电话</th> <th>运营中心</th><th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              $(".tableBox thead").html(htmlheader)
              var html = '  <tr><td>' + w + '</td><td class="Name"> <a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].parentname + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'
              $("#tableBoxData").append(html);
            } else {
              console.log('数据错误')
            }
          } else if (num == 3) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>运营中心</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              $(".tableBox thead").html(htmlheader)

              var html = '  <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'

              $("#tableBoxData").append(html);
            } else {
              console.log('数据错误')
            }
          } else if (num == 4) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>水厂</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              $(".tableBox thead").html(htmlheader)
              var html = '  <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'

              $("#tableBoxData").append(html);
            } else {
              console.log('数据错误')
            }
          } else if (num == 5) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>设备厂家</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              $(".tableBox thead").html(htmlheader)
                // console.log(data[i].use
              var html = ' <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'
              $("#tableBoxData").append(html);
            }
          } else if (num == 6) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>设备投资商</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              $(".tableBox thead").html(htmlheader)
                // console.log(data[i].user
              var html = '  <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'
              $("#tableBoxData").append(html);
            }
          }
        }
      } else {
        $("._tfoot>tr>td").attr("colspan", '8')
        $("#tableBoxData").html('')
        var htmlheader = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th> <th>服务中心</th><th>运营中心</th><th>地区</th> <th>用户类型</th><th>总销量</th></tr>';
        $(".tableBox thead").html(htmlheader)
        var j = 0;
        for (var i in data) {
          var CustomerType = custType(data[i].CustomerType)
          j++
          var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].DevNo + '</td>' +
            '<td>' + data[i].agentname + '</td><td>' + data[i].parentname + '</td> <td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td><td>' + CustomerType + '</td> <td>' + data[i].sales + '</td>' +
            '</tr>'
          $("#tableBoxData").append(html);



        }


        $("#tableBoxData tr:last-child").remove()
        $("#tableBoxData tr:last-child").remove()
      }
      $("#Total").text('共' + objdata.total + '条');
      var page_size = $('#page_size option:selected').val()
      $("#sconter").attr('max', Math.ceil(objdata.total / page_size))
      var current = Math.ceil(objdata.total / page_size)
      $("#Circula .hort").remove()
        // if (current <= 5) {
      for (var i = 1; i <= current; i++) {
        $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
      }
      // }

      //  else  {
      //   var current_num = $("#numTotal").text();
      //   for (var i = current_num - 2; i <= current_num + 2; i++) {
      //        $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
      //   }

      //   // $("#Circula li:nth-last-child(3) a").text("...").attr('href', 'javascript:void(0)');;
      //   // $("#Circula li:nth-last-child(2) a").text("...");
      // }
    }
  })
}
$('#btn a').click(function() {
  var num = localStorage.getItem('itmenum')
  var sconter = $('#sconter').val(); //输入页
  var page_size = $('#page_size option:selected').val()
  var parameter = {
      
    "state": role_id,
    "offset": sconter * page_size - page_size, //起始,
    'limit': page_size
  }
  postData(parameter, num)
})


$(document).on('click', ".Previous", function() {

  var num = localStorage.getItem('itmenum')
  var sconter = $('#numTotal').text(); //当前页数
  var page_size = $('#page_size option:selected').val()

  sconter--
  if (sconter <= 1) {
    sconter = 1
  }
  var parameter = {

    "search": $("#search").val(),
    "state": num,
    "offset": sconter * page_size - page_size, //起始,
    'limit': page_size
  }
  postData(parameter, num)
  $('#numTotal').text(sconter);

}).on('click', '.Next', function() {
  var num = localStorage.getItem('itmenum')
  var _this = this;
  var sconter = $('#numTotal').text(); //当前页数
  var page_size = $('#page_size option:selected').val()
  var parameter = {

    "search": $("#search").val(),
    "state": num,
    "offset": sconter * page_size, //起始,
    'limit': page_size
  };
  if (sconter >= $('#sconter').attr('max')) {
    sconter = $('#sconter').attr('max');
    return false;
  }
  postData(parameter, num)
  sconter++
  $('#numTotal').text(sconter);

})

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


var adddate = $("#adddate").val('')


var a;
$(document).on("click", ".navdata ul li", function() {
  a = ($(".navdata ul li").index(this)) + 1;
  localStorage.setItem('itmenum', a)
    // console.log($(this).attr('dataView'))
  $("#tableBoxData").html('')
  var parameter = {
    "state": a,
    "offset": 0,
    'limit': 10,
    "search": $("#search").val(),
  }
  postData(parameter, a)
})

function begin_linlst_time_clea() {

  var num = localStorage.getItem('itmenum')
  var adddate = $("#adddate").val()
  var adddatea = adddate.split("到");
  var startime = adddatea[0]
  var endtime = adddatea[1]

  var parameter = {
    "state": num,
    "offset": 0,
    'limit': 10,
    "startime": startime,
    "endtime": endtime,
    "search": $("#search").val()
  }
  postData(parameter, num)
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

  postData(parameter, num)

}
