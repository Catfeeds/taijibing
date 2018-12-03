// 地址渲染 
addressResolve(data,where_datas.province,where_datas.city,where_datas.area)
// 服务中心 、运营中心
addressOperateService({
   agenty:'agenty_id',
   agenty_data:agenty,
   agentf:'agentf_id',
   agentf_data:agentf,
   where_agenty:where_datas.agenty_id,
   where_agentf:where_datas.agentf_id
})
// 设备厂家，
devlistFu({
  data:devfactory,
  name:'devfactory_id',
  where:where_datas.devfactory_id
})

// 设备投资商
devlistFu2({
  data:investor,
  name:'investor_id',
  where:where_datas.investor_id
})


//水厂。品牌。容量
water_ommodity({
    waterfactoryName:'waterfactory_precode',
    waterfactoryData:factory,
    waterbrandName:'waterbrand_id',
    waterbrandData:waterbrand,
    waternameName:'watername_id',
    waternameData:watername,
    water_volumeName:'water_volume',
    water_volumeData:watervolume,
    where:{
       factory:where_datas.waterfactory_precode,
       devbrand_id:where_datas.waterbrand_id,
       devname_id:where_datas.watername_id,
       water_volume:where_datas.water_volume,
    }
    ,role:role_id
    ,factory_precode:factory_precode
})
// 设备品牌型号
addresEquipmente({
     devbrand:'devbrand_id',
     devbrand_data:devbrand,
     devname:'devname_id',
     devname_data:devname,
     where:{
        devbrand:where_datas.devbrand_id,
        devname:where_datas.devname_id
     }
})
//入网属性
usetypeFun({
  name:'usetype',
  data:use_type,
  where:where_datas.usetype
})
//用户类型
customertypea({
  name:'customertype',
  where:where_datas.customertype
})





//时间记录判断
var  time1nbs = GetDateStr(-6, 1);
var  time2nbs = GetDateStr(0, 1);
var timeOf = where_datas.time1;
var timeOf2 = where_datas.time2;
 // console.log(timeOf)
if(timeOf){
  $("#time1sub").val(timeOf)
 // $("#timesub").val(timeOf2)
// console.log(timeOf2)

    $('.activer').removeClass('activer');
    $("#time1sub").val(timeOf)
     time2nbs = GetDateStr(0, 1);
    if(timeOf==1){
       $(".dataUlLI li").eq(0).addClass('activer');
        time1nbs = GetDateStr(0, 1);
        $("#date_demo").text('请选择时间段')
    }else if(timeOf==2){
       $(".dataUlLI li").eq(1).addClass('activer');
        time1nbs = GetDateStr(-1, 1);
         $("#date_demo").text('请选择时间段')
    }else if(timeOf==3){
       $(".dataUlLI li").eq(2).addClass('activer');
        time1nbs = GetDateStr(-6, 1);
         $("#date_demo").text('请选择时间段')
    }else if(timeOf==4){
       $(".dataUlLI li").eq(3).addClass('activer');
        time1nbs = GetDateStr(-29, 1);
         $("#date_demo").text('请选择时间段')
    }
    else if(timeOf==5){
       $(".dataUlLI li").eq(4).addClass('activer');
        time1nbs = GetDateStr(-89, 1);
       
       $("#date_demo").text('请选择时间段')
    }else{
      time1nbs = timeOf;
      time2nbs =where_datas.time2;
      $("#time1sub").val(time1nbs)
      $("#time2sub").val(timeOf2)
    }
}

  _hover($(".volumeHover"), $(".volumeHover-text"))
  _hover($(".compareHover"), $(".compareHover-text"))
  _hover($(".AverageHover"), $(".AverageHover-text"))
  _hover($(".pageHover"), $(".pageHover-text"))
  //伪类
  function _hover(Class, ClassText) {
    Class.hover(function() {
      ClassText.css("display", "block");

      Class.css("background", "url(/static/images3/volumeHover2.png) no-repeat");
    }, function() {
      ClassText.css("display", "none");
      Class.css("background", "url(/static/images3/volumeHover1.png) no-repeat");
    });
  }
// 同期渲染
  salesVolume(datas);
  $('.dataUlLI li').on('click', function() {
      $('.activer').removeClass('activer');
      $(this).addClass('activer');
      $('.dataUlLI li p').css('borderRight', "1px #000 solid");
      $(".dataUlLI li:last-of-type p").css('borderRight', "0px #000 solid");
      $(this).prev().find('p').css('border', "none");
      $(this).find('p').css('border', "none");
      $("#time1sub").val($(this).val())
      $("#time2sub").val('')
      $("#date_demo").text('请选择时间段')
  });
$("#removerSub").bind('click',function(){
  $('.activer').removeClass('activer');
   $('.dataUlLI li').eq(2).addClass('activer');

   $("#time1sub").val(3)
   $("#time2sub").val('')
   $("#searchp").val('')
   return false;
})

$("#submit").on('click',function(){
    $(this).css('background','#e46045')
})
   $('.data-view') .on('click', function() {
      $('#dataView').css('display', 'block')
    })
    $('#Close,.data-refresh').on('click', function() {
      $('#dataView').css('display', 'none')
    })

   // 时间选择
    var dateRange = new pickerDateRange('date_demo', {
      //aRecent7Days : 'aRecent7DaysDemo3', //最近7天
      isTodayValid: true,
      startDate: time1nbs,
      endDate:time2nbs,
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
        $("#time1sub").val(obj.startDate)
        $("#time2sub").val(obj.endDate)
       $('.dataUlLI .activer').removeClass('activer');  

      }
    });


 FoldLineDiagramCalculation() 
// 折线图
// 折线数据渲染方法
function FoldLineDiagramCalculation() {
  var use_statusdata = datas[0].sales_status;
  console.log(use_statusdata)
  var _date = []
  var xin = 7;
  var lop = 0;
  var timedatae = GetDateStr(0, 1)



    if (where_datas.time1==1) {
      // alert(1)
       xin = 1;
    } else if (where_datas.time1 == 2) {
      xin = 1
    } else if (where_datas.time1 == 3) {
      xin = 7
    } else if (where_datas.time1 == 4) {
      xin = 30
    } else if (where_datas.time1 == 5) {
      xin = 90
    } else if (where_datas.time1 == null) {
      xin = 7
    }  else if (!where_datas.time1) {
        xin = 7
    }

    else{
       xin =diy_time(where_datas.time1, where_datas.time2) + 1;

        lop = diy_time(where_datas.time2, timedatae)
    }

  var darax = NumberDays(xin, _date, lop)


  var daray = [];

  if (where_datas.time1&&where_datas.time1 <= 2) {

    var itmesum = []
    for (var i = 0; i < use_statusdata.length; i++) {
      var itme = use_statusdata[i].RowTime;
      var itmesumTer = itme.split(" ")[1]
      itmesum.push(itmesumTer.replace(':', '.'))
    }
 //    // console.log(1)
    // console.log(itmesum)
    var daraxp = []
    var daraxpdata = [];
    var daraxpdataL = []
    var ppp = 0
    for (var i = 0; i < 25; i++) {
      var date = (i) + ":00"
      daraxp.push(date)
      daraxpdata.push("0")
      daraxpdataL.push("0")
      for (var y = 0; y < itmesum.length; y++) {
        var _itmesum = itmesum[y].split(".")[0]

        if (_itmesum == i) {
            daraxpdata[i]++
            daraxpdataL[i]++
        }
      }
    }
    darax = daraxp
    daray = daraxpdataL

  } else {
    for (var i = 0; i < darax.length; i++) {
      daray.push(0)

      var daraxDate = Date.parse(darax[i]);
      for (var j = 0; j < use_statusdata.length; j++) {
        var nowDate = Date.parse(use_statusdata[j].Date);
        if (daraxDate == nowDate) {
          daray[i]++
        }
      }
    }
  }
  // console.log(darax)
 // console.log(daray)

 
  FoldLineDiagram(darax, daray, '销量')



  mapCityBar(use_statusdata)
}




// 地图数据计算渲染方法
function mapCityBar(sales_status) {
  var mapProvince = [];
  var mapCity = [];
  for (var j = 0; j < sales_status.length; j++) {
    mapProvince.push(sales_status[j].Province)
    mapCity.push(sales_status[j].City)
  }


  var mapProvinceNUm = unique(mapProvince)
  var mapCityNUm = unique(mapCity)
  var mapProvincebox = [];
  var mapCitybox = [];
  var progressBar = []

  $("#percentum").empty();
  var mapProvinceNUmColor = ['#D29616', '#4ADCDD', '#C248DC', '#EA5638', '#D29717'];


  for (var j = 0; j < mapProvinceNUm.length; j++) {
    mapProvincebox.push({
      'key': mapProvinceNUm[j],
      'value': 0,
      'tadal': sales_status.length
    })
    for (var i = 0; i < mapProvince.length; i++) {
      if (mapProvinceNUm[j] == mapProvince[i]) {
        mapProvincebox[j].value++
      }
    }
// console.log(mapProvincebox)
    if (mapProvinceNUm[j] == null) {
      mapProvinceNUm[j] = '其它'
    }
    progressBar.push(Math.round(mapProvincebox[j].value / sales_status.length * 100))

    var html = '<div class="progress" style="height:10px;    background-color: #1d1f23;"><span class="name" style="margin-top:-5px;left: 25px;">' + mapProvinceNUm[j] + '</span>' + '<div class="progress-bar"   role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressBar[j] + '%; background-color: ' + mapProvinceNUmColor[j] + '">' + '</div>' +
      '<span class="baifenbi" style="color: #fff; position: absolute;    right: 50px;right: 45px;margin-top: -5px;">' + progressBar[j] + '%' + '</span> </div>'

    $("#percentum").append(html);
  }

  for (var i = 0; i < mapCityNUm.length; i++) {
    mapCitybox.push({
      'key': '0',
      'value': 0,
      'Province': '',
      'tadal': 0
    })
    for (var j = 0; j < sales_status.length; j++) {
      var mapCityLnumname = sales_status[j].Province
      if (mapCityNUm[i] == sales_status[j].City) {
        mapCitybox[i].value++
          mapCitybox[i].key = mapCityNUm[i]
        mapCitybox[i].Province = mapCityLnumname;
      }
    }
  };

  for (var i = 0; i < mapProvincebox.length; i++) {

    for (var j = 0; j < mapCitybox.length; j++) {
      if (mapProvincebox[i].key == mapCitybox[j].Province) {
        mapCitybox[j].tadal = mapProvincebox[i].value
      }
    }
  };

      var map_obj={
     'Name':'销量',
     'Unit':'袋',
  }
console.log(mapProvinceNUm)
console.log(mapProvincebox)
console.log(mapProvinceNUmColor)

  map(mapProvinceNUm, mapProvincebox, mapCityNUm, mapCitybox, mapProvinceNUmColor,map_obj);

  PieChartRendering()
}






// 饼图
function PieChartRendering() {
  var sales_status = datas[0].sales_status;
  var CustomerType = []
  var CustomerTypeNum = [];
  for (var i = 0; i < sales_status.length; i++) {
    CustomerType.push(sales_status[i].CustomerType)
  }

  var CustomerTypeunique = (CustomerType);
  for (var i = 0; i <5 ; i++) {
    if (CustomerTypeNum.length < 5) {
      if (!CustomerTypeNum[i]) {
         CustomerTypeNum.push(0)
      }
    }
  }

  // console.log(CustomerTypeunique)
  // for (var i = 0; i < CustomerTypeunique.length; i++) {
  //   CustomerTypeNum.push(0)
  //   for (var j = 0; j < CustomerType.length; j++) {

  //     if (CustomerTypeunique[i] == CustomerType[j]) {
  //       CustomerTypeNum[i]++
  //     }
  //   }
  // }
  for (var index = 0; index < CustomerTypeunique.length; index++) {
    if (CustomerTypeunique[index] == 1) {
      CustomerTypeNum[0]++
    } else if (CustomerTypeunique[index] == 2) {
      CustomerTypeNum[1]++
    } else if (CustomerTypeunique[index] == 3) {
      CustomerTypeNum[2]++
    } else {
      CustomerTypeNum[3]++
    }
  }

  var CustomerTypeuniqueName = ['家庭', '集团', '公司','酒店', '其他'];

  for (var i = 0; i < CustomerTypeNum.length; i++) {
    $("#dataView tbody tr td:nth-child(2)").eq(i + 1).text(CustomerTypeNum[i])
    var num = Math.round(CustomerTypeNum[i] / sales_status.length * 100)
    if (num) {
      $(".baifenbiA .baifenbi").eq(i).text(num)
    }
  }
  var $name = '用户类型销量占比'
// 
  // console.log(CustomerTypeuniqueName)
  // console.log(CustomerTypeNum)
  PieChart(CustomerTypeuniqueName, CustomerTypeNum, $name)
  $("#Refresh,.data-refresh").click(function() {
    PieChart(CustomerTypeunique, CustomerTypeNum)
    $('#dataView').css('display', 'none')
  });

}
// 销量概况
function salesVolume(data) {
  if (!data) {
    return;
  }
  var $data = data[0] || '';
  $("#sales1").text($data.sales1)
  var sales2=0;
  if($data.sales1!=$data.sales2){
    sales2  = Percentage($data.sales1, $data.sales2);
  }
 
  if (sales2 < 0) {
    $("#sales2").text(sales2 + "%")
    $("#sales2").append('&nbsp;&nbsp;<img src="/static/images3/Arrowb.png" alt="">')
  } else if (sales2 > 0) {
    $("#sales2").text(sales2 + "%")
    $("#sales2").append('&nbsp;&nbsp;<img src="/static/images3/arrowA.png" alt="">')
  } else {
    $("#sales2").text('持平')
    $("#sales2").append('&nbsp;&nbsp;<img src="/static/images3/rectangle.png" alt="">')
  }
  $("#user_num").text($data.user_num)
  $("#sales_of").text(Math.round($data.sales1/$data.user_num))
  $("#sales_of_year").text($data.sales_of_year)

  // console.log(data.sales_of_year)
}


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
//去重
function unique($data) {
  var res = [];
  var json = {};

  for (var p = 0; p < $data.length; p++) {
    if (!json[$data[p]]) {
      res.push($data[p]);
      json[$data[p]] = 1;
    } else {}
  }
  return res;
}

 var sales_detail = datas[0].sales_detail;

  dev_listdata(datas[0].sales_detail,1)

// 分页

  $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(datas[0].total / 10),
    totalLimit: 10,
    totalSize: datas[0].total,
    callback: function(num, nbsp) {
      var searchParameters = {
        agentf_id: where_datas.agentf_id,
        agenty_id: where_datas.agenty_id,
        area: where_datas.area,
        city: where_datas.city,
        customertype: where_datas.customertype,
        devbrand_id: where_datas.devbrand_id,
        devfactory_id: where_datas.devfactory_id,
        devname_id: where_datas.devname_id,
        investor_id: where_datas.investor_id,
        province: where_datas.province,
        search: where_datas.search,
        time1: where_datas.time1,
        time2: where_datas.time2,
        usetype: where_datas.usetype,
        waterfactory_precode:where_datas.waterfactory_precode,
        waterbrand_id:where_datas.waterbrand_id,
        watername_id:where_datas.watername_id,
        watervolume:where_datas.watervolume,
        offset: num * nbsp - nbsp,
        limit: nbsp
      }
      Get_datas(searchParameters,num)
       // console.log(searchParameters)
    }
  })
  function  Get_datas(searchParameters,num){
     var ii =   layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    shadeClose: false, //开启遮罩关闭
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });

  $.post("./index.php?r=sales-volume/get-datas", searchParameters, function(data){
       layer.close(ii); 
      var sales_detail=data[0].sales_detail
         dev_listdata(sales_detail,num)
  })
}

  function dev_listdata(data,num) {
    var j = 0;
      $("#tableData").empty();
    for (var i = 0; i < data.length; i++) {
      var item = data[i]
      for (var z in item) {
        if (item[z] == null) {
          item[z] = '--'
        }
      }
      j++
   var Tel =item.Tel;
   var UseTy= item.UseType;

   var AgentPname= item.AgentPname;
   var AgentName= item.AgentName;
   var investor= item.investor;
   var DevFactoryName= item.DevFactoryName;
   var DevBrand= item.DevBrand;
   var BarCode= item.BarCode;
   var CustomerType=customertype(item.CustomerType);
   var UseTy=usetype(item.UseType );
   if(role_id==2){
      var  UseType = usetype(item.UseType )
      var tString = item.Tel.slice(3,7);
     Tel = item.Tel.replace(tString, "****");
     // console.log(Tel)
     UseTy = '***';
     AgentPname="***";
     AgentName="***";
     investor="***";
     DevFactoryName="***";
     DevBrand="***";
     BarCode='***';
   }
   // ((num-1)*10+ j*1)
      var html = '<tr><td>'+j+'</td>'
       html += '<td>'+item.UserName  +'</td>'
       html += '<td>'+Tel+'</td>'
       html += '<td>'+item.DevNo+'</td>'
       html += '<td>'+BarCode+'</td>'
       html += '<td>'+item.FactoryName+'</td>'
       html += '<td>'+item.water_brand+'</td>'
       html += '<td>'+item.water_name+'</td>'
       html += '<td>'+item.Volume+'</td>'
       html += '<td>'+item.DevName+'</td>'
       html += '<td>'+DevBrand+'</td>'
       html += '<td>'+DevFactoryName+'</td>'
       html += '<td>'+investor+'</td>'
       html += '<td>'+AgentName+'</td>'
       html += '<td>'+AgentPname+'</td>'
       html += '<td>'+item.Province+'-'+item.City+'-'+item.Area+'</td>'
       html += '<td>'+UseTy+'</td>'
       html += '<td>'+CustomerType+'</td>'
       html += '<td>'+item.RowTime+'</td>'
       html += '</tr>';
          $("#tableData").append(html);
    }




  function customertype(usetype){
    var res =''

    // console.log(usetype)
        if(usetype == 1){
            res = "家庭"
        }
        else if(usetype == 2){
            res = "公司"
        }
        else if(usetype == 3){
            res = "集团"
        }
        else if(usetype == 4){
            res = "酒店"
        }

        else if(usetype == 99){
            res = "其他"
        }else{
          res =' '
        }
        return res;
   }
   function usetype(usetype){
    var res ='';

    for(var i=0;i<all_use_type.length;i++){
        var item = all_use_type[i];
        if(item.code==usetype){
              res = item.use_type;
        }
    }
        return res;
   } 
   layer.closeAll()
  }










