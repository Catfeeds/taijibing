 
  var adddate = $("#adddate").val()


  var adddatea = adddate.split("到");
var startime = adddatea[0] +' 00:00';
  var endtime = adddatea[1]+' 24:00';

  var parameter = {
  "state": '',
  "offset": 0,
  "startime": startime,
  "endtime": endtime,
  'limit': 10,
  "search": $("#search").val(),
}

postData(parameter, 1, $(".tableBox thead"), $("#tableBoxData"))
var j;
localStorage.setItem('itmenum', 1)
function postData(parameter, num, Idtitle, idTybd) {
  // if (num >= 1) {
  //   $(".navdata .active").removeClass("active")
  //   $(".navdata ul li").eq(num - 1).addClass('active')
  // }
console.log(parameter)

   var numTotal = $('#numTotal').text();
   var w = 0;
  $.post('./?r=sales-api/datas', parameter, function(objdata) {
    if (objdata || objdata != null) {

      var objdata = JSON.parse(objdata);
      data = objdata.users
      localStorage.setItem('itmenum', num)
      localStorage.setItem('total', objdata.total)
      Idtitle.html('');
      idTybd.html('');
      if (objdata.role_id) {
        for (var i = 0; i < data.length; i++) {
          var sales = (data[i].family_sales * 1 + data[i].company_sales * 1 + data[i].group_sales * 1 + data[i].other_sales * 1)
          w++
          if (num == 2) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>服务中心</th><th>联系电话</th> <th>运营中心</th><th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              Idtitle.html(htmlheader)
              var html = '  <tr><td>' + w + '</td><td class="Name"> <a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].parentname + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + data[i].family_sales + '</td> <td>' + data[i].company_sales + '</td><td>' + data[i].group_sales + '</td> <td>' + data[i].other_sales + '</td>' +
                ' <td>' + sales + '</td></tr>'
              idTybd.append(html);
            } else {
              console.log('数据错误')
            }
          } else if (num == 3) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>运营中心</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              Idtitle.html(htmlheader)
              var html = '  <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + data[i].family_sales + '</td> <td>' + data[i].company_sales + '</td><td>' + data[i].group_sales + '</td> <td>' + data[i].other_sales + '</td>' +
                ' <td>' + sales + '</td></tr>'
              idTybd.append(html);
            } else {
              console.log('数据错误')
            }
          } else if (num == 4) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>水厂</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
              Idtitle.html(htmlheader)
              var html = '  <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                '<td>' + data[i].family_sales + '</td> <td>' + data[i].company_sales + '</td><td>' + data[i].group_sales + '</td> <td>' + data[i].other_sales + '</td>' +
                ' <td>' + sales + '</td></tr>'
              idTybd.append(html);
            } else {
              console.log('数据错误')
            }
          } else if (num == 5) {
            var htmlheader = '<tr><th>序号</th><th>设备厂家</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
            Idtitle.html(htmlheader)
              // console.log(data[i].use
            var html = ' <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
              '<td>' + data[i].family_sales + '</td> <td>' + data[i].company_sales + '</td><td>' + data[i].group_sales + '</td> <td>' + data[i].other_sales + '</td>' +
              ' <td>' + sales + '</td></tr>'
            idTybd.append(html);
          } else if (num == 6) {
            var htmlheader = '<tr><th>序号</th><th>设备投资商</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总销量</th></tr>';
            Idtitle.html(htmlheader)
              // console.log(data[i].user
            var html = '  <tr><td>' + w + '</td><td><a href="./index.php?r=sales-api/index&role_id=' + objdata.role_id + '&LoginName=' + data[i].LoginName + '">' + data[i].Name + '</a></td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '</td>' +
              '<td>' + data[i].family_sales + '</td> <td>' + data[i].company_sales + '</td><td>' + data[i].group_sales + '</td> <td>' + data[i].other_sales + '</td>' +
              ' <td>' + sales + '</td></tr>'
            idTybd.append(html);
          }
        }
      } else {
        $("._tfoot>tr>td").attr("colspan", '8')
        idTybd.html('')
        var htmlheader = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th> <th>服务中心</th><th>运营中心</th><th>地区</th> <th>用户类型</th><th>总销量</th></tr>';
        Idtitle.html(htmlheader)
        var j = 0;
        for (var i in data) {
          var CustomerType = custType(data[i].CustomerType)
          j++
          // (((numTotal-1)*10)+j*1)*1
          var html = '  <tr><td>' +  j+ '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].DevNo + '</td>' +
            '<td>' + data[i].agentname + '</td><td>' + data[i].parentname + '</td> <td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td><td>' + CustomerType + '</td> <td>' + data[i].sales + '</td>' +
            '</tr>'
          idTybd.append(html);
        }
        $("tr:last-child", idTybd).remove()
        $("tr:last-child", idTybd).remove()
      }

      $("#Total").text('共' + objdata.total + '条');
      var page_size = $('#page_size option:selected').val()
      $("#sconter").attr('max', Math.ceil(objdata.total / page_size))
      var current = Math.ceil(objdata.total / page_size)
      $("#Circula .hort").remove()

      console.log(current)
      console.log(numTotal)
      if (current > 5) {
               if(numTotal<=3){
                  for (var i = 1; i <= 5; i++) {
                    $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
                  }
                   $("#Circula li:last-child").before('<li class="hort">...</li>')
               }
                else  if(numTotal>=current-3){
                 for (var i = current*1-4*1; i <= current; i++) {
                    $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
                  }

                   $("#Circula li:nth-of-type(2)").before('<li class="hort">...</li>')
               }
               else{
                  for (var i = numTotal*1-2; i <= numTotal*1+2; i++) {
                    $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
                  }
                  $("#Circula li:last-child").before('<li class="hort">...</li>')
                  $("#Circula li:nth-of-type(2)").before('<li class="hort">...</li>')
               }
        }else { 
          for (var i = 1; i <= current; i++) {
            $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
          }
        }


      // if (numTotal > 9 ) {
      //   var  numi=numTotal+4;
      //   if(numi>objdata.total / page_size){
      //     numi=objdata.total / page_size
      //   }else{
      //     numi=numTotal+4
      //   }

      //   for (var i = numi-8; i <= numi; i++) {
      //     $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
      //   }

      //   $(".spot").remove()

      //   $(".hort").eq(0).before('<li class="spot">...</li>')

      // } else  {
      //     if(objdata.total / page_size>10){
      //       current = 10;
      //       for (var i = 1; i <= current; i++) {
      //         $(".spot").remove()
      //     $("#Circula li:last-child").before('<li class="hort" onclick="hortlick(' + i + ')">' + i + '</li>')
      //      $("#Circula li:last-child").before('<li class="spot">...</li>')
      //   }
      //     }
      // }
    }
  })
}
$('#btn a').click(function() {

var total = localStorage.getItem('total')
  var num = localStorage.getItem('itmenum')
  var sconter = $('#sconter').val(); //输入页
  var page_size = $('#page_size option:selected').val()

  var  size  =  Math.ceil(total / page_size) 
   if(sconter>size){
        sconter=size
      }else if(sconter<1){
        sconter = 1
      }

   var sconter =   parseInt(sconter)  
  $('#sconter').val(sconter)
  var adddate = $("#adddate").val()
  var adddatea = adddate.split("到");
var startime = adddatea[0] +' 00:00';
  var endtime = adddatea[1]+' 24:00';
  var parameter = {
    "state": num,
    "offset": sconter * page_size - page_size, //起始,
    "search": $("#search").val(),
    "startime": startime,
    "endtime": endtime,
    'limit': page_size
  }
  $('#numTotal').text(sconter);
  postData(parameter, num, $(".tableBox thead"), $("#tableBoxData"))
})




// 定义一个换页方法
function hortlick(e) {
  


  var num = localStorage.getItem('itmenum')

  var sconter = e;
  var page_size = $('#page_size option:selected').val()
  var parameter = {
    "state": num,
    "offset": sconter * page_size - page_size, //起始,
    'limit': page_size
  }
  $('#numTotal').text(sconter);
  // $('#Circula  li').eq(sconter).addClass('active');
  postData(parameter, num, $(".tableBox thead"), $("#tableBoxData"))
}

$(document).on('click', ".hort", function() {
    $(this).addClass('active');
  
       // $('#Circula  li').eq(sconter).addClass('active');
}).on('click', ".Previous", function() {
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
  postData(parameter, num, $(".tableBox thead"), $("#tableBoxData"))
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
  postData(parameter, num, $(".tableBox thead"), $("#tableBoxData"))
  sconter++


  $('#numTotal').text(sconter);


})

.on('change','#page_size',function(){
 
  var num = localStorage.getItem('itmenum')
    var page_size = $('#page_size option:selected').val()
    var parameter = {
    "state": num,
    "offset": 0,
    'limit': page_size,
    "search": $("#search").val()
  }

  postData(parameter, num, $(".tableBox thead"), $("#tableBoxData"))
  $("#numTotal").text(1)
})
var page_size = $('#page_size option:selected').val()
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
var num = localStorage.getItem('itmenum')
var total = localStorage.getItem('total')
// var parameter2 = {
//   "state": num,
//   "offset": 0,
//   'limit': total,
// }
$(document).on("click", ".navdata ul li", function() {
  var page_size = $('#page_size option:selected').val()
  a = ($(".navdata ul li").index(this)) + 1;
  localStorage.setItem('itmenum', a)
  $("#sconter,#numTotal").text("")
    // console.log($(this).attr('dataView'))
  $("#tableBoxData").html('')
  $('#numTotal').text(1);
  var parameter = {
    "state": a,
    "offset": 0,
    'limit': page_size
      // "search": $("#search").val(),
  }
  postData(parameter, a, $(".tableBox thead"), $("#tableBoxData"))
})


function begin_linlst_time_clea() {
  var page_size = $('#page_size option:selected').val()
  var num = localStorage.getItem('itmenum')
  var adddate = $("#adddate").val()
  var adddatea = adddate.split("到");
  var startime = adddatea[0] +' 00:00';
  var endtime = adddatea[1]+' 24:00';
  var parameter = {
    "state": num,
    "offset": 0,
    'limit': page_size,
    "startime": startime,
    "endtime": endtime,
    "offset": 0,
               'limit': page_size,
    "search": $("#search").val()
   
  }
  postData(parameter, num, $(".tableBox thead"), $("#tableBoxData"))
   $("#numTotal").text(1)

}



function begin_end_time_clear() {
  var num = localStorage.getItem('itmenum')
  $("#adddate").val('')
  $("#search").val('')
  var parameter = {
    "state": num,
    "offset": 0,
    'limit': page_size,

  }
  postData(parameter, num, $(".tableBox thead"), $("#tableBoxData"))
}


$("#method").click(function() {
  var num = localStorage.getItem('itmenum')
  var total = localStorage.getItem('total')

  var adddate = $("#adddate").val()
  var adddatea = adddate.split("到");
var startime = adddatea[0] +' 00:00';
  var endtime = adddatea[1]+' 24:00';
  var parameter2 = {
    "state": num,
    "offset": 0,
    'limit': total,
    "startime": startime,
    "endtime": endtime,
    "search": $("#search").val()


  }
  postData(parameter2, num, $("#tableData thead"), $("#tablebody"))
  setTimeout(function () {   
      method("tableData")
  }, 3000);

})
