var parameter = {
  "state": '',
  "offset": 0,
  'limit': 10,
  "startime": $('#mydatepicker2').val(),
  "endtime": $('#mydatepicker3').val(),
  "search": $("#search").val(),
}


postData(parameter)

var j;

function postData(parameter, num) {
  if (num >= 1) {
    $(".navdata .active").removeClass("active")
    $(".navdata ul li").eq(num - 1).addClass('active')
  }
  $.post('./?r=sales-api/datas', parameter, function(data) {
    if (data || data != null) {
      var data = JSON.parse(data);

      // 清空模板
      $("#tableBoxData").html('')
        // 判断角色id
      if (data.role_id) {
        $("#tableBoxData").html('');


        for (var i in data) {

    

          // 　　data.sort(compare("name")); 
          j = i + 1
            //当出现未定义是为空
            // if (data[i].user == 'undefined') {
            //     data[i].user == [];
            // }
          var user_1 = 0; //家庭
          var user_2 = 0; //办公
          var user_3 = 0; //集团
          var user_4 = 0; //其他
     
          for (var o in data[i].user) {

            if (data[i].user[o].CustomerType == 1) {
              user_1++
            }
            if (data[i].user[o].CustomerType == 2) {
              user_2++
            }
            if (data[i].user[o].CustomerType == 3) {
              user_3++
            }
            if (data[i].user[o].CustomerType == 99) {
              user_4++
            }
          }

          if (num == 2) {
            if (data[i]) {
              // console.log(data)
              var htmlheader = '<tr><th>序号</th><th>服务中心</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              // alert(data.total)
              $(".tableBox thead").html(htmlheader)
                // console.log(data[i].user

              var html = '  <tr><td>' + j + '</td><td class="Name"> <a href="./index.php?r=sales-api/index&role_id=' + data.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'

              $("#tableBoxData").append(html);

            } else {
              console.log('数据错误')
            }
          } else if (num == 3) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>运营中心</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总设备销量</th></tr>';

              $(".tableBox thead").html(htmlheader)

              var html = '  <tr><td>' + j + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + data.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'

              $("#tableBoxData").append(html);

            } else {
              console.log('数据错误')
            }
          } else if (num == 4) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>水厂</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总设备销量</th></tr>';

              $(".tableBox thead").html(htmlheader)
              var html = '  <tr><td>' + j + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + data.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'

              $("#tableBoxData").append(html);
            } else {
              console.log('数据错误')
            }

          } else if (num == 5) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>设备厂家</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总设备销量</th></tr>';

              $(".tableBox thead").html(htmlheader)
                // console.log(data[i].user
              var html = '  <tr><td>' + j + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + data.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'
              $("#tableBoxData").append(html);
            } else {
              console.log('数据错误')
            }
          } else if (num == 6) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>设备投资商</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总设备销量</th></tr>';
              $(".tableBox thead").html(htmlheader)
                // console.log(data[i].user
              var html = '  <tr><td>' + j + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + data.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'
              $("#tableBoxData").append(html);

            } else {
              console.log('数据错误')
            }
          } else {
            var htmlheader = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th> <th>服务中心</th><th>运营中心</th><th>地区</th> <th>用户类型</th><th>总设备销量</th></tr>';
            $(".tableBox thead").html(htmlheader)
          }

        }

      } else {
        $("._tfoot>tr>td").attr("colspan", '9')
        $("#tableBoxData").html('')
        var htmlheader = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th> <th>服务中心</th><th>运营中心</th><th>地区</th> <th>用户类型</th><th>总设备销量</th></tr>';
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

      }
      $("#tableBoxData tr:last-child").remove();
      $("#Total").text('共' + data['total'] + '条');
      var page_size = $('#page_size option:selected').val()
      $("#sconter").attr('max', Math.ceil(data['total'] / page_size))
      var current = Math.ceil(data['total'] / page_size)
      $("#Circula .hort").remove()
      if (current <= 5) {
        for (var i = 1; i <= current; i++) {
          $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
        }
      } else {
        var current_num = 3;
        for (var i = current_num - 2; i <= current_num + 2; i++) {
          $("#Circula li:last-child").before('<li class="hort">' + i + '</li>')
        }
        $("#Circula li:nth-last-child(3) a").text("...").attr('href', 'javascript:void(0)');;
        $("#Circula li:nth-last-child(2) a").text("...");
      }
    }
  })

}
var a
$(document).on("click", ".navdata ul li", function() {
    a = ($(".navdata ul li").index(this)) + 1;
    $("#tableBoxData").html('')
    var parameter = {
       "state": a,
       "offset": 0,
       'limit': 10,
       "startime": $('#mydatepicker2').val(),
       "endtime": $('#mydatepicker3').val(),
       "search": $("#search").val(),
    }
    postData(parameter, a)
  })
  .on("click", "#submiex", function() {
    postData(parameter, a)
  })

function method(tableid) {
  var curTbl = document.getElementById(tableid);
  var oXL;
  try {
    oXL = new ActiveXObject("Excel.Application"); //创建AX对象excel 
  } catch (e) {
    alert("无法启动Excel!\n\n如果您确信您的电脑中已经安装了Excel，");
    //"+"那么请调整IE的安全级别。\n\n具体操作：\n\n"+"工具 → Internet选项 → 安全 → 自定义级别 → 对没有标记为安全的ActiveX进行初始化和脚本运行 → 启用
    return false;
  }
  var oWB = oXL.Workbooks.Add();
  var oSheet = oWB.ActiveSheet;
  var sel = document.body.createTextRange();
  sel.moveToElementText(curTbl);
  sel.select();
  sel.execCommand("Copy");
  oSheet.Paste();
  oXL.Visible = true;
}