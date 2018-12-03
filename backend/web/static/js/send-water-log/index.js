initProvince()

// 表格渲染
if (dev_list) {
   dev_listdata(dev_list, 1)
}
// 记录选项
function initAddress() {
   // console.log(where_datas)
   if (where_datas) {
      if (where_datas.state) {
         var Equipment;
         if (where_datas.state == 1) {
            Equipment = '已出单';
         } else if (where_datas.state == 2) {
            Equipment = '未处理';
         } else if (where_datas.state == 3) {
            Equipment = '已完成';
         } else {
            Equipment = '全部';
         }
         $("#Equipment").html(Equipment + '&nbsp;<span class="caret"></span>').parents('.dropdown').children(".toggle-input").val(where_datas.state)
      }
      if (where_datas.user_state) {
         var user_state;
         if (where_datas.user_state == 1) {
            user_state = '正常用户';
         } else if (where_datas.user_state == 2) {
            user_state = '已初始化用户';
         } else if (where_datas.user_state == 3) {
            user_state = '全部用户';
         } else {
            user_state = '未激活用户';
         }
         $("#customertype").html(user_state + '&nbsp;<span class="caret"></span>').parents('.dropdown').children(".toggle-input").val(where_datas.user_state)
      }
      if (where_datas.search) {
         $("#searchp").val(where_datas.search)
      }
      if (where_datas.selecttime) {
         $("#date_demo").text(where_datas.selecttime);
         $("#selecttime1").val(where_datas.selecttime);
      }
      for (var i in where_datas) {
         var item = where_datas[i];
         if (!item || item == '' || item == 0) {
            item = false;
         }
         if (item && item != null && item != ' ') {
            $("#" + i).html(item + '&nbsp;<span class="caret"></span>').parents('.dropdown').children(".toggle-input").val(item)
         }
      }
      if (where_datas.province) {
         initCityOnProvinceChange(where_datas.province)
      }
      if (where_datas.city) {
         initThree(where_datas.city)
      }
      if (where_datas.user_state == 2) {
         $(".Ingp").css({
            "padding": '5px',
            'minWidth': '50px',
            'borderRadius': '4px',
            'background': '#6f6967'
         })
      }

   }
}
// 省渲染
function initProvince() {
   // $('#province option').not(":first").remove(); 
   var provinceVal = $("#province").parents('.dropdown').children(".dropdown-menu")
   provinceVal.children().not(":first").remove()
   for (var index = 0; index < areas.length; index++) {
      var item = areas[index];
      // console.log(item)
      if (item.PId == 0) {
         provinceVal.append("<li value='" + item.Name + "'>" + item.Name + "</li>");
      }
   }
}
// 选择省后渲染市
$("#province").parents('.dropdown').children(".dropdown-menu").children().click(function() {
   var _thisval = $(this).attr('value');
   $("#city").html('请选择&nbsp;<span class="caret"></span>').attr("value", '').parent().find(".toggle-input").val('0');
   $("#area").html('请选择&nbsp;<span class="caret"></span>').attr("value", '').parent().find(".toggle-input").val('0');
   var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
   var _togglevalooo = $("#city").parent().find(".toggle-input").val();
   // alert(_togglevalooo);
   if (_thisval != _toggleval) {
      initCityOnProvinceChange(_thisval)
   }
   // 选择市后渲染区
   $("#city").parents('.dropdown').children(".dropdown-menu").children().click(function() {
      var _thisval = $(this).attr('value');
      $("#area").html('请选择&nbsp;<span class="caret"></span>').attr("value", '').parent().siblings(".toggle-input").val('');
      var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
      if (_thisval != _toggleval) {
         initThree(_thisval)
      }
   })
})
// 选择省后渲染区的方法
function initCityOnProvinceChange(_thisval) {
   var pid = getAddressIdByName(_thisval);
   var pcityVal = $("#city").parents('.dropdown').children(".dropdown-menu")
   pcityVal.children().not(":first").remove();
   $("#area").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove();

   if (pid == 0) {
      return;
   }
   for (var index = 0; index < areas.length; index++) {
      var item = areas[index];
      if (item.PId != 0 && item.PId == pid) {
         pcityVal.append("<li value='" + item.Name + "'>" + item.Name + "</li>");
      }
   }
}

function initThree(_thisval) {
   var pid = getAddressIdByName(_thisval);
   var areaVal = $("#area").parents('.dropdown').children(".dropdown-menu")
   areaVal.children().not(":first").remove();
   if (pid == 0) {
      return;
   }
   for (var index = 0; index < areas.length; index++) {
      var item = areas[index];
      if (item.PId != 0 && item.PId == pid) {
         areaVal.append("<li value='" + item.Name + "'>" + item.Name + "</li>");
      }
   }
}
// 获取id比较
function getAddressIdByName(_name) {
   _name = $.trim(_name);
   if (_name == "") {
      return 0;
   }
   for (var index = 0; index < areas.length; index++) {
      var item = areas[index];
      var name = $.trim(item.Name);
      if (name != "" && name == _name) {

         return item.Id;
      }
   }
   return;
}

var sorttext = '0';
// 下拉选择
$(document).on('click', '.address .dropdown-menu li', function() {
      var _thisval = $(this).attr('value');

      var _thisvalt;
      if (_thisval == ' ' || !_thisval || _thisval == 0) {
         _thisvalt = '请选择';
      } else {
         _thisvalt = _thisval;
      }
      var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
      if (_thisval != _toggleval) {
         $(this).siblings().css({
            'backgroundColor': 'transparent',
            'color': '#000'
         });
         $(this).css({
            'backgroundColor': '#E46045',
            'color': 'rgb(233,233,233)'
         });
         $(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvalt + '&nbsp;<span class="caret"></span>');
         $(this).parent().siblings(".toggle-input").val(_thisval)
      }
   })

   .on('click', '.condition .dropdown-menu li,.shoPpage .dropdown-menu li', function() {
      var _thisval = $(this).attr('value');

      var _thisvaltxt = $(this).text();
      var _toggleval = $(this).parent().siblings(".toggle-input").val();
      if (_thisval != _toggleval) {
         $(this).parent().siblings(".dropdown-toggle").val(_thisval).html(_thisvaltxt + '&nbsp;<span class="caret"></span>');
         $(this).parent().siblings(".toggle-input").val(_thisval)
      }
   })
   .on('click', '#removerSub', function() {
      var dropdownLength = $('.dropdown').length;
      for (var i = 0; i < dropdownLength; i++) {
         var dropLi = $('.dropdown li:first-of-type').eq(i).text();
         var dropLival = $('.dropdown li:first-of-type').eq(i).val();
         $('.dropdown button').eq(i).html(dropLi + '&nbsp;<span class="caret"></span>');
         $('.dropdown .toggle-input').eq(i).val(dropLival);
      }
      $("#searchp").val('')
      $('.dropdown button').eq(4).html('正常用户&nbsp;<span class="caret"></span>');
      $('.dropdown .toggle-input').eq(4).val(1);
      $("#date_demo").text('');
      $("#selecttime1").val('')

      // e.preventDefault()
      return false;
   })
   .on('click', '#sorttext', function() {



      sorttext++
      if (sorttext >= 3) {
         sorttext = 0;
      }


      $("#sortVal").val(sorttext);
      var _current = $("#page .current").text();
      var nbsp = $("#Jumpdisplay").text();
      var searchParameters = {
         province: where_datas.province,
         city: where_datas.city,
         area: where_datas.area,
         selecttime: where_datas.selecttime,
         state: where_datas.state,
         user_state: where_datas.user_state,
         search: where_datas.search,


         offset: _current * nbsp - nbsp,
         limit: nbsp,
         sort: sorttext
      }
      // console.log(searchParameters)



      Get_datas(searchParameters)
   })



   .on('click', '#submit', function() {
      layer.open({
         type: 1,
         skin: 'layui-layer-demo', //样式类名
         closeBtn: 0, //不显示关闭按钮
         anim: 2,
         shadeClose: false, //开启遮罩关闭
         content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
      });
   })


//分页
$("#page").paging({
   pageNo: 1,
   totalPage: Math.ceil(total / 10),
   totalLimit: 10,
   totalSize: total,
   callback: function(num, nbsp) {
      var searchParameters = {
         province: where_datas.province,
         city: where_datas.city,
         area: where_datas.area,

         selecttime: where_datas.selecttime,
         state: where_datas.state,
         user_state: where_datas.user_state,
         search: where_datas.search,
         offset: num * nbsp - nbsp,
         limit: nbsp,
         sort: sorttext
      }
      //console.log(searchParameters)
      // alert(sorttext)
      Get_datas(searchParameters, num)
   }
})

$('.pageTest').setLength(10)


function Get_datas(searchParameters, num) {
   var ii = layer.open({
      type: 1,
      skin: 'layui-layer-demo', //样式类名
      closeBtn: 0, //不显示关闭按钮
      anim: 2,
      shadeClose: false, //开启遮罩关闭
      content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
   });
   $.post('./index.php?r=send-water-log/dev-list', searchParameters, function(data) {
      layer.close(ii);

      var data = eval('(' + data + ')');
      // console.log(data)
      dev_listdata(data.dev_list, num)

      $("#sortVal").val(data.sort)

   })
};

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

   if (m * 1 <= 0) {
      y--;
      m = 12
   }
   return y + "-" + m + "-" + d;
};

var poiuy3 = GetDateStr(0, 1)

function diy_time(time1num, time2num) {
   time1data = Date.parse(new Date(time1num));

   time2data = Date.parse(new Date(time2num));
   return time3 = Math.abs(parseInt((time2data - time1data) / 1000 / 3600 / 24));
}
// console.log(poiuy)
function dev_listdata(dev_list, num) {
   $("#dev_list_body").empty();
   // console.log(dev_list)
   var poiuy = GetDateStr(0, 1)

   for (var i = 0; i < dev_list.length; i++) {
      var item = dev_list[i];


      if (item && item != null) {
         // console.log(item.UserId)
         var UserId = item.UserId;



         var ploik = diy_time(poiuy, item.send_time);
         var colorTrSendTime = "";
         if (ploik <= 3) {
            colorTrSendTime = "#EE5030";
         } else if (ploik > 3 && ploik <= 6) {
            colorTrSendTime = "#3EDADB";
         }
         var Equipment = '——';
         var EquipmentURL = ' '; //<a href="javascript:void(0)">
         var EquipmentColor = '';
         var EquipmentURLA = '' //</a>

         var send_waterURL = '<a href="/index.php?r=send-water-log/send-water&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'

         var rechargeURL = '<a href="/index.php?r=send-water-log/recharge&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'

         var send_logURL = ' <a href="/index.php?r=send-water-log/send-log&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'

         var recharge_logURL = '<a href="/index.php?r=send-water-log/recharge-log&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'


         if (item.State == 1) {
            Equipment = '已出单';
            EquipmentColor = '#3EDADB'
            EquipmentURL = ' <a href="/index.php?r=send-water-log/send-log&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'

         } else if (!item.State && ploik < 3) {
            Equipment = '待处理';
            EquipmentColor = '#E46045'
            EquipmentURL = ' <a href="/index.php?r=send-water-log/send-water&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'

         } else if (item.State && ploik < 3) {
            Equipment = '待处理';
            EquipmentColor = '#E46045'
            EquipmentURL = ' <a href="/index.php?r=send-water-log/send-water&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'

         } else if (item.State != 1 && item.send_time == '没有送水记录') {
            Equipment = '待处理';
            EquipmentColor = '#E46045'
            EquipmentURL = ' <a href="/index.php?r=send-water-log/send-water&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'
         } else if (item.State != 1 && item.send_time == '近期还没有送水记录') {
            Equipment = '待处理';
            EquipmentColor = '#E46045'
            EquipmentURL = ' <a href="/index.php?r=send-water-log/send-water&UserId=' + item.UserId + '&CustomerType=' + item.CustomerType + '&AgentId=' + item.AgentId + '">'
         } else if (item.State != 1 && ploik > 3) {
            EquipmentURL = '';
            Equipment = '已完成';
            EquipmentColor = '#00f';

            // send_waterURL = '';
            // rechargeURL = '';
            // send_logURL = '';
            // recharge_logURL = '';

         } else {
            // Equipment ='——';
            EquipmentURL = '';
            Equipment = '已完成';
            EquipmentColor = '#00f';

         }


         if (where_datas.user_state == 2) {
            EquipmentURL = '';
            send_waterURL = '';
            rechargeURL = '';
         }



         for (var z in item) {
            if (item[z] == null) {
               item[z] = '——'
            }
         }
         if (item.CustomerType == 1) {
            CustomerType = '家庭'
         } else if (item.CustomerType == 2) {
            CustomerType = '公司'
         } else if (item.CustomerType == 3) {
            CustomerType = '集团'
         } else {
            CustomerType = '其他'
         }
         // var UserId = item.UserId;

         $.trim($("#title").val());
         // (((num-1)*10+ i*1) * 1 )
         var html = '<tr style="color:' + colorTrSendTime + '"> <td >' + i + '</td><td class="username">' + item.username + '</td>';
         html += '<td >' + item.Tel + '</td>';
         html += '<td style="cursor: pointer;"  class="userId' + i + '"   onclick=getDevno("' + item.UserId + ',' + item.CustomerType + ',' + i + ',' + item.AgentId + ',' + item.username + ',' + item.Tel + ',' + CustomerType + '")><p style="position:relative;color: #E46045; cursor: pointer;">   查看  </p></td>';
         html += '  <td >' + item.Province + '-' + item.City + '-' + item.Area + '</td>';
         html += '  <td >' + item.Address + '</td>';
         html += '  <td >' + item.agentname + '</td>';
         html += '  <td >' + CustomerType + '</td>';
         html += '  <td >' + item.rest_water + '</td>';
         html += '  <td >' + item.SendTime + '</td>';
         html += ' <td >' + item.send_time + '</td>';
         html += ' <td >' + item.RestMoney + '</td>';
         html += '  <td >' + item.LastActTime + '</td>';
         html += '  <td ></td>';
         html += '<td class="ShareBtn">' + EquipmentURL + '<div class="Ingp">' +
            '<p>' + Equipment + '</p></div>' + EquipmentURLA + '</td>';
         html += '    <td class=" ShareBtn give" >' + send_waterURL +
            ' <div class="Ing" ><img src="/static/images3/give.png" ></div>' + EquipmentURLA + ' </td>';
         html += ' <td class="ShareBtn Recharge" >  ' + rechargeURL + ' <div class="Ing"><img src="/static/images3/Recharge.png" ></div>' + EquipmentURLA + '</td>'
         html += ' <td class="ShareBtn giveRecord" >' + send_logURL + '<div class="Ing">  <img src="/static/images3/giveRecord.png" ></div>' + EquipmentURLA + '</td>'
         html += '<td class="ShareBtn RechargeRecord" > ' + recharge_logURL + ' <div class="Ing">  <img src="/static/images3/RechargeRecord.png" ></div>' + EquipmentURLA + '</td>'
         html += ' </tr>'
         $("#dev_list_body").append(html)
      } else {
         return false;
      }
   }
   // 状态小提示
   $(".ShareBtn").hover(function() {

      $('.Ing', this).css('position', 'relative');
      if ($(this).hasClass('give')) {
         var html = '<div class="IngHover" style="position:absolute;top: -101%;width: 50px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover1.png)  no-repeat;background-size:100% 100%;">送水</div>'
         $('.Ing', this).append(html)
      } else if ($(this).hasClass('Recharge')) {
         var html = '<div class="IngHover" style="position:absolute;top: -101%;width: 50px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover2.png)  no-repeat;background-size:100% 100%;">充值</div>'
         $('.Ing', this).append(html)
      } else if ($(this).hasClass('giveRecord')) {
         var html = '<div class="IngHover" style="position:absolute;top: -101%;width: 60px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover1.png)  no-repeat;background-size:100% 100%;">送水记录</div>'
         $('.Ing', this).append(html)
      } else if ($(this).hasClass('RechargeRecord')) {
         var html = '<div class="IngHover" style="position:absolute;top: -101%;left:-8px;width: 60px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover2.png)  no-repeat;background-size:100% 100%;">充值记录</div>'
         $('.Ing', this).append(html)
      }


   }, function() {
      $('.IngHover').remove();
   })
}
$('.ShareBtn p').text()
initAddress()

function getDevno(obj) {


   var objArr = obj.split(',');
   // console.log(objArr)

   var objdata = {
      UserId: objArr[0],
      CustomerType: objArr[1],
      AgentId: objArr[3],
      state: where_datas.user_state
   }

   var _index = objArr[2];
   // console.log(objdata)

   var indexlayer = layer.load(2, {
      shade: false
   }); //0代表加载的风格，支持0-2
   $.get('index.php?r=send-water-log/get-devno', objdata, function(data) {
      layer.close(indexlayer);
      var data = $.parseJSON(data);
      if (data.DevNos.length > 0) {
         var htmll = '';
         for (var i = 0; i < data.DevNos.length; i++) {
            var item = data.DevNos[i];
            // console.log(item)
            htmll += '<p>编号：' + item.DevNo + '</p>';
         }


         var html = '<div class="popupa">' +
            '<table style="    margin: auto;">' +
            '<tbody>' +
            '<tr>' +
            '<td>用户姓名：<span>' + objArr[4] + '</span></td>' +
            '<td>电话：<span>' + objArr[5] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>设备数量：<span>' + data.DevNos.length + '</span></td>' +
            '<td>客户类型：<span>' + objArr[6] + '用户<span></td>' +
            '</tr>' +

            '</tbody>' +
            '</table>' +
            '<div class="popup-text" style="height: 165px;    padding-top: 20px; overflow: auto;"><span style="font-size:20px; color: rgb(233,233,233)">' + htmll + ' </span></div>' +
            '<div class="butt pull-left" style="    margin-left: 60px;">' +
            // '<button type="button"  class="Close" >取消</button>' +
            '</div>' +
            '<div  class="butt" style="padding:0">' +
            '<button type="submit" class="confirm" style="background-color: #E46045;    margin-left: -75px;" >确认</button>' +
            '</div>' +
            '</div>'
         var ppp = layer.open({
            type: 1,
            title: false,
            area: ['500px', '400px'],
            closeBtn: 0,
            shade: [0.5, '#393D49'],
            shadeClose: false,
            // shade: false,
            skin: 'yourclass',
            content: html

         });

         $(".confirm").click(function() {
            layer.close(ppp);

         })
      }


   });
}

// 状态小提示
$(".ShareBtn").hover(function() {

   $('.Ing', this).css('position', 'relative');


   if ($(this).hasClass('give')) {
      var html = '<div class="IngHover" style="position:absolute;top: -101%;width: 50px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover1.png)  no-repeat;background-size:100% 100%;">送水</div>'
      $('.Ing', this).append(html)
   } else if ($(this).hasClass('Recharge')) {
      var html = '<div class="IngHover" style="position:absolute;top: -101%;width: 50px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover2.png)  no-repeat;background-size:100% 100%;">充值</div>'
      $('.Ing', this).append(html)
   } else if ($(this).hasClass('giveRecord')) {
      var html = '<div class="IngHover" style="position:absolute;top: -101%;width: 60px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover1.png)  no-repeat;background-size:100% 100%;">送水记录</div>'
      $('.Ing', this).append(html)
   } else if ($(this).hasClass('RechargeRecord')) {
      var html = '<div class="IngHover" style="position:absolute;top: -101%;left:-8px;width: 60px;height: 30px;line-height: 25px;color: #fff;background: url(/static/images3/IngHover2.png)  no-repeat;background-size:100% 100%;">充值记录</div>'
      $('.Ing', this).append(html)
   }


}, function() {
   $('.IngHover').remove();
})