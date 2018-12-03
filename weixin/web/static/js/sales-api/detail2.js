           // 非管理员登录

           var time_id = {
             'role_id': role_ide,
             'LoginName': LoginNam
           }

           function _CustomerType() {
             var CustomerType;
             if (data[i].CustomerType == 1) {
               CustomerType = '家庭'
             } else if (data[i].CustomerType == 2) {
               CustomerType = '办公'
             } else if (data[i].CustomerType == 3) {
               CustomerType = '集团'
             } else if (data[i].CustomerType == 99) {
               CustomerType = '其他'
             };
           }
           var parameter = {
             "search": $("#search").val(),
             'role_id': role_ide,
             'LoginName': LoginNam
           }
           getUser(parameter)

           function begin_linlst_time_clea() {
             var num = localStorage.getItem('itmenum')
             var adddate = $("#adddate").val()
             var adddatea = adddate.split("到");
             var startime = adddatea[0]
             var endtime = adddatea[1]
             var parameter = {
               "startime": startime,
               "endtime": endtime,
               "search": $("#search").val(),
               'role_id': role_ide,
               'LoginName': LoginNam
             }
             getUser(parameter, num)
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
             getUser(parameter, num)
           }
           // 定义一个换页方法
           function hortlick2(e) {
             var num = localStorage.getItem('itmenum')
             var sconter = e;
             var page_size = $('#page_size option:selected').val()
             var parameter = {
               "state": num,
               "offset": sconter * page_size - page_size, //起始,
               'limit': page_size,
               'role_id': role_ide,
               'LoginName': LoginNam
             }
             $('#numTotal').text(sconter);

             $('#Circula  li').eq(sconter).addClass('active');
             getUser(parameter, num)
           }

           function getUser(parameter) {
             var j = 0;
             $.post('./?r=sales-api/get-user', parameter, function(json) {
               var objData = JSON.parse(json);
               var data = objData.users
               console.log(parameter)
               $("#Total").text('共' + objData.total + '条');
               var page_size = $('#page_size option:selected').val()
               $("#sconter").attr('max', Math.ceil(objData.total / page_size));

               var current = Math.ceil(objData.total / page_size);
               $("#Circula .hort").remove()
                 // if (current <= 5) {
               for (var i = 1; i <= current; i++) {
                 $("#Circula li:last-child").before('<li class="hort"  onclick="hortlick2(' + i + ')">' + i + '</li>')
               }
               // } else {
               //   var current_num = 3;
               //   for (var i = current_num - 2; i <= current_num + 2; i++) {
               //     $("#Circula li:last-child").before('<li class="hort">' + i + '</li>')
               //   }
               //   $("#Circula li:nth-last-child(3) a").text("...").attr('href', 'javascript:void(0)');;
               //   $("#Circula li:nth-last-child(2) a").text("...");
               // }


               $("._tfoot>tr>td").attr("colspan", '9')
               $("#tableBoxData").html('')

               for (var i in data) {
                 var CustomerType;
                 if (data[i].CustomerType == 1) {
                   CustomerType = '家庭'
                 } else if (data[i].CustomerType == 2) {
                   CustomerType = '办公'
                 } else if (data[i].CustomerType == 3) {
                   CustomerType = '集团'
                 } else if (data[i].CustomerType == 99) {
                   CustomerType = '其他'
                 };
                 j = j + 1
                 var htmlheader2 = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th><th>运营中心</th><th>用户类型</th><th>总销量</th></tr>';
                 if (role_ide == 3) {

                   var htmlheader2 = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th><th>服务中心</th><th>用户类型</th><th>总销量</th></tr>';

                   $(".tableBox thead").html(htmlheader2)
                   var html2 = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].DevNo + '</td>' +
                     ' <td>' + data[i].AgnetName + '</td> <td>' + CustomerType + '</td></td> <td>' + data[i].sales + '</td>' +
                     '</tr>'
                   $("#tableBoxData").append(html2);
                 } else if (role_ide == 5) {

                   $(".tableBox thead").html(htmlheader2)

                   var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].DevNo + '</td>' +
                     ' <td>' + data[i].Address + '</td> <td>' + CustomerType + '</td> <td>' + data[i].sales + '</td>' +
                     '</tr>'
                   $("#tableBoxData").append(html);
                 } else if (role_ide == 2) {
                   var htmlheader = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th><th>地区</th> <th>用户类型</th><th>总销量</th></tr>';

                   $(".tableBox thead").html(htmlheader)
                   var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].DevNo + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                     '<td>' + CustomerType + '</td> <td>' + data[i].sales + '</td>' +
                     '</tr>'
                   $("#tableBoxData").append(html);
                 } else {

                   var htmlheader2 = '<tr><th>序号</th><th>姓名</th><th>联系电话</th> <th>设备编号</th><th>运营中心</th><th>地区</th><th>用户类型</th><th>总销量</th></tr>';
                   $(".tableBox thead").html(htmlheader2)
                   var html = '  <tr><td>' + j + '</td><td>' + data[i].Name + '</td><td>' + data[i].Tel + '</td><td>' + data[i].DevNo + '</td><td>' + data[i].ParentName + '</td><td>' + data[i].Province + '-' + data[i].City + '-' + data[i].Area + '</td>' +
                     '<td>' + CustomerType + '</td> <td>' + data[i].sales + '</td>' +
                     '</tr>'
                   $("#tableBoxData").append(html);
                 }
               }
               $("#tableBoxData tr:last-child").remove();

               $("#tableBoxData tr:last-child").remove();
             })
           }
           $('#btn a').click(function() {
             var num = localStorage.getItem('itmenum')
             var sconter = $('#sconter').val(); //当前页数
             var page_size = $('#page_size option:selected').val()
             var parameter = {
               "state": num,
               "offset": sconter * page_size - page_size, //起始,
               'limit': page_size， 'role_id': role_ide,
               'LoginName': LoginNam
             }
             getUser(parameter, num)
             $('#numTotal').text(sconter);
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
                 'limit': page_size,
                 'role_id': role_ide,
                 'LoginName': LoginNam
               }
               getUser(parameter, num)
               $('#numTotal').text(sconter);

             })
             .on('click', '.Next', function() {


               var num = localStorage.getItem('itmenum')
               var _this = this;
               var sconter = $('#numTotal').text(); //当前页数
               var page_size = $('#page_size option:selected').val()
               var parameter = {
                 "search": $("#search").val(),
                 "state": num,
                 "offset": sconter * page_size, //起始,
                 'limit': page_size,
                 'role_id': role_ide,
                 'LoginName': LoginNam
               };
               if (sconter >= $('#sconter').attr('max')) {
                 sconter = $('#sconter').attr('max');
                 return false;
               }


               getUser(parameter, num)
               sconter++
               $('#numTotal').text(sconter);

             })

           // 销量概况
           var time_id = {
             'time': '5',
             'role_id': role_ide,
             'LoginName': LoginNam
           }
           _detail(time_id)
           _hover($(".volumeHover"), $(".volumeText"))
           _hover($(".compareHover"), $(".compareText"))
           _hover($(".AverageHover"), $(".AverageText"))

           function _detail(time_id) {
             $.post('./?r=sales-api/sales-detail', time_id, function(json) {
               var data = JSON.parse(json);

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