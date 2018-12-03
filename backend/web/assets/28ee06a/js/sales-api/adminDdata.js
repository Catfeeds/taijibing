var parameter = {
  "state": '',
  "offset": 0,
  'limit': 10,
  "startime": $('#mydatepicker2').val(),
  "endtime": $('#mydatepicker3').val(),
  "search": $("#search").val(),
}

postData(parameter)

var a
$(".navdata ul li").click(function() {
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
});

$("#submiex").click(function() {

  postData(parameter, a)
})













  $('#btn a').click(function () {
 var page_size =  $('#page_size option:selected').val(); //展示页数   
 var key_total = sessionStorage.getItem('total');
 if( key_total){
 $("#Total").text(key_total);
   $("#sconter").attr('max', Math.ceil(key_total/page_size))
   $("#sconter").attr('min', '1');
   }


    var state= a || 1 ;  // 用户类型
    var startime  =  $('#mydatepicker2').val(); //开始时间
    var endtime   =  $('#mydatepicker3').val(); //结束时间
    var search    =  $("#search").val();  //搜索内容
    var sconter =  $('#sconter').val();   //当前页数
    var page_size =  $('#page_size').val();
    var offsets   =  sconter*page_size-page_size//起始
    $('#sconter').val(sconter); 
 
  var parameter = {
    "state": state, 
    "offset": offsets,
    'limit': page_size,
    "startime": startime,
    "endtime": endtime,
    "search": search,
  }
  postData(parameter, a)

})

function postData(parameter, num) {

  if (num >= 1) {


    $(".navdata .active").removeClass("active")
    $(".navdata ul li").eq(num - 1).addClass('active')
  }

  var _url;
  if (role_id_texe) {
    _url = './?r=sales-api/datas'

  } else {
    _url = './?r=sales-api/get-user'
  }
  $.post(_url, parameter, function(data) {
    if (data || data != null) {
      var data = JSON.parse(data);
      // 清空模板
      $("#tableBoxData").html('')
        // 判断角色id
      if (data.role_id) {
        var j;
        $("#tableBoxData").html('');
        console.log(data)

        for (var i = 0; i < Object.keys(data).length - 2; i++) {
          j = i + 1
            //当出现未定义是为空
          // if (data[i].user == 'undefined') {
          //     data[i].user == [];
          // }
          var user_1 = 0; //家庭
          var user_2 = 0; //办公
          var user_3 = 0; //集团
          var user_4 = 0; //其他

          for (o = 0; o < data[i].user.length; o++) {

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
              var htmlheader = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>运营中心</th><th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>销量</th></tr>';

              $(".tableBox thead").html(htmlheader)
                // console.log(data[i].user
              var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].parentname + '</td>' +
                '<td>' + data[i].Area + '</td><td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'

              $("#tableBoxData").append(html);

            } else {
              console.log('数据错误')
            }
          } else if (num == 3) {
            if (data[i]) {
              var htmlheader = '<tr><th>序号</th><th>运营中心</th><th>联系电话</th> <th>地区</th><th>家庭用户</th><th>公司用户</th> <th>集团用户</th><th>其它</th><th>总设备销量</th></tr>';

              $(".tableBox thead").html(htmlheader)

              var html = '  <tr><td>' + j + '</td><td>' + data[i].Area + '</td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '</td>' +
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
              var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '</td>' +
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
              var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '</td>' +
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
              var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].Province + '</td>' +
                '<td>' + user_1 + '</td> <td>' + user_2 + '</td><td>' + user_3 + '</td> <td>' + user_4 + '</td>' +
                ' <td>' + data[i].sales + '</td></tr>'
              $("#tableBoxData").append(html);

            } else {
              console.log('数据错误')
            }
          }

        }

      }

       else 
       {
        $("#tableBoxData").html('')
       
        var j;
        for (var i = 0; i <  Object.keys(data).length - 1; i++) {
 
          j = i + 1
          var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].DevNo + '</td>' +
            '<td>' + data[i].agentname + '</td><td>' + data[i].parentname + '</td> <td>' + data[i].Area + '</td><td>' + data[i].CustomerType + '</td> <td>' + data[i].sales + '</td>' +
             '</tr>'
           $("#tableBoxData").append(html);
         }
         $("._tfoot>tr>td").attr("colspan", '9')


      }


     sessionStorage.setItem('total_d', data['total']);
     var page_size=$('#page_size option:selected').val()
     if(data['total']){
       $("#sconter").attr('max',Math.ceil( data['total']/ page_size))
     }
     var current = Math.ceil( data['total']/ page_size)
          $("#Circula .hort").remove()
          if(current<=5){
          for (var i = 1; i <=current; i++) {
                $("#Circula li:last-child").before('<li class="hort">'+i+'</li>')
              }
         }  else{
         var current_num=3;
         for (var i = current_num-2; i <=current_num+2; i++) {
             $("#Circula li:last-child").before('<li class="hort">'+i+'</li>')
        }
         $("#Circula li:nth-last-child(3) a").text("...").attr('href', 'javascript:void(0)');;
         $("#Circula li:nth-last-child(2) a").text("...");
    }

    }
  })

}

$("#Circula .hort").click(function(){
  alert(1)
    var page_size =  $('#page_size option:selected').val(); //展示页数   
    var state= a || 1 ;  // 用户类型
    var startime  =  $('#mydatepicker2').val(); //开始时间
    var endtime   =  $('#mydatepicker3').val(); //结束时间
    var search    =  $("#search").val();  //搜索内容
    var sconter =  $(this).text();   //当前页数

    var offsets   =  sconter*page_size-page_size//起始
    $('#sconter').val(sconter); 
 
  var parameter = {
    "state": state, 
    "offset": offsets,
    'limit': page_size,
    "startime": startime,
    "endtime": endtime,
    "search": search,
   }
   console.log(parameter)
   // postData(parameter, a)
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