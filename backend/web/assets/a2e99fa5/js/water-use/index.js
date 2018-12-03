// 地址
addressResolve(areas,where_datas.province,where_datas.city,where_datas.area)

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
// console.log(where_datas)
if(where_datas.search){
  $("#searchp").val(where_datas.search)
}

//时间记录判断
var  time1nbs = GetDateStr(-6, 1);
var  time2nbs = GetDateStr(0, 1);
var timeOf = where_datas.time1
if(timeOf){
    $('.activer').removeClass('activer');
     time2nbs = GetDateStr(0, 1);
     $("#time1sub").val(timeOf)
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
      $("#time1sub").val('')
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
  salesVolume();
  // 点击事件
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
      inputTrigger: 'input_trigger_demo',
      theme: 'ta',
      success: function(obj) {
        // $("#dCon_demo").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
        $("#time1sub").val(obj.startDate)
        $("#time2sub").val(obj.endDate)
       $('.dataUlLI .activer').removeClass('activer');  
      }
    });











  // 同期
function  salesVolume(){
      if (!datas2) {
          return;
      }
 
  
      $("#sales1").text(datas2.use_total);
       var sales2Val=0; 
    if(datas2.same_time_total!=datas2.use_total){
     sales2Val=Percentage(datas2.same_time_total,datas2.use_total);
    }
 

     if (sales2Val < 0) {
        $("#sales2").text(sales2Val + "%")
        $("#sales2").append('&nbsp;<img src="/static/images3/Arrowb.png" alt="">')
      } else if (sales2Val > 0) {
        $("#sales2").text(sales2Val + "%")
        $("#sales2").append('&nbsp;<img src="/static/images3/arrowA.png" alt="">')
      } else {
        $("#sales2").text('持平')
        $("#sales2").append('&nbsp;<img src="/static/images3/rectangle.png" alt="">')
      }
      $("#user_num").text(datas2.user_num);

      $("#sales_of").text(Math.round(datas2.use_total,datas2.user_num));
           $("#sales_of_year").text(datas2.year_use)
    }




 FoldLineDiagramCalculation()
//折线图
function FoldLineDiagramCalculation(){
    var use_statusdata = datas2.use_status;

   // console.log(use_statusdata);

   // console.log(1111111)

    var _date = []
     var daray=[];
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
      }
      else if (!where_datas.time1) {
        xin = 7
      }

      else{
         xin =diy_time(where_datas.time1, where_datas.time2) + 1;

          lop = diy_time(where_datas.time2, timedatae)
      }

  var darax = NumberDays(xin, _date, lop)

// console.log(xin)
  // console.log(darax)


// alert(where_datas.time1)


// console.log(where_datas.time1)
  if (xin<=1) {

  
    var itmesum = []
    // for(var i=0;i<use_statusdata.length;i++){  

       for(var i=0 in use_statusdata){
        var itme=use_statusdata[i].ActTime;

        var itmesumTer = itme.split(" ")[1]
          itmesum.push( itmesumTer.replace(':', '.'))
    }
  // console.log(itmesum)
  // console.log(8955)

    var daraxp = [] 
    var   daraxpdata = [];
    var daraxpdataL = []
var ppp = 0
    for( var i=0; i<25;i++){
        var date = (i)+":00"
        daraxp.push(date)
        daraxpdata.push("0")
        daraxpdataL.push("0")
        for(var  y=0;y<itmesum.length;y++){
            var _itmesum= itmesum[y].split(".")[0]

            if(_itmesum==i){
                  daraxpdata[i]++
                  daraxpdataL[i] =Math.round( (daraxpdataL[i]*1+use_statusdata[y].WaterUse*1)*100000)/100000

            }
        }
    }
    darax=daraxp
    daray=daraxpdataL
 } else {


    for (var i = 0; i < darax.length; i++) {


        daray.push(0)
     // console.log(darax[i])
        var daraxDate = Date.parse(darax[i]);

           // for (var j = 0; j < use_statusdata.length; j++) {

            for(var j=0 in use_statusdata){

             // console.log(4545454)
            var nowDate = Date.parse(use_statusdata[j].ActDate);
             if (daraxDate == nowDate) {

                    daray[i]= Math.round((daray[i]*1+use_statusdata[j].WaterUse*1)*100000)/100000

             }
           }
      }

  }


  // console.log(darax)
  // console.log(daray)

 FoldLineDiagram(darax, daray,'用水量');


}

mapRendering()

// 地图
function  mapRendering(){    
    var map_datas = datas2.map_datas;
    // console.log(map_datas)
var mapProvinceNUmColor =['#D29616','#4ADCDD','#C248DC','#EA5638','#D29717','#4ADCDD','#C248DC','#EA5638','#D29717','#4ADCDD','#C248DC','#EA5638','#D29717']
       $("#percentum").empty();
   for (var j = 0; j < map_datas.province_datas.length; j++) {
        var item =map_datas.province_datas[j]

        // console.log(item)
         var html = '<div class="progress" style="height:10px;    background-color: #1d1f23;">'+
                         '<span class="name" style="margin-top:-5px;left: 25px;">' + item.Province+ '</span>' + 
                         '<div class="progress-bar"   role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' 
                         + Math.round((item.UseTotal/datas2.use_total) * 10000) / 100 + '%; '+
                         'background-color: '+mapProvinceNUmColor[j] +'">' + '</div>' 
                              + '<span class="baifenbi" style="color: #fff; position: absolute;  '+
                              ' right: 50px;right: 45px;margin-top: -5px;">' + Math.round((item.UseTotal/datas2.use_total) * 10000) / 100 + '%'+ 
                              '</span> </div>';
       $("#percentum").append(html);
   }
mapmapRendering(map_datas.province_datas,map_datas.city_datas,mapProvinceNUmColor,datas2.use_total)

}

 PieChartRendering() 
  // 饼图
  function PieChartRendering() {
    // 饼状图渲染 
     var map_datas = datas2.map_datas.customertype_use;
  var  Customerdata=[0,0,0,0,0]
      // console.log(map_datas)

    for (var i = 0; i < map_datas.length; i++) {
         var item = map_datas[i]
         // console.log(item.CustomerType)

        if(item.CustomerType==1){
           Customerdata[0]=Customerdata[0]+item.UseTotal*1
         }else if(item.CustomerType==2){
           Customerdata[1]=Customerdata[1]+item.UseTotal*1
         }else if(item.CustomerType==3){
           Customerdata[2]=Customerdata[2]+item.UseTotal*1
         }else if(item.CustomerType==4){
           Customerdata[3]=Customerdata[3]+item.UseTotal*1
         }else{
           Customerdata[4]=Customerdata[4]+item.UseTotal*1
         }
    }
// console.log(Customerdata);

    var CustomerTypeunique = ['家庭', '公司', '集团','酒店', '其他']
    var $name = '用户类型用水量占比'

    // console.log(CustomerTypeNum)
    PieChart(CustomerTypeunique, Customerdata, $name)

  }

    function Percentage3(number1, number2) {
     if(number2<=0){
        number2=1
      }
      if(number1<=0){
        number1=0
      }
      return (Math.round((number1 / number2) * 10000) / 100); // 小数点后两位百分比
    }

      function Percentage2(number1, number2) {
      if(number2==0){
        number2=1
      }
      return (Math.round((number1 / number2) * 10000)/10000); // 小数点后两位百分比
    }





  // 表格渲染


  var sales_detail = datas2.sales_detail;

// console.log(datas2)


  dev_listdata(sales_detail,1)
  $("#page").paging({
    pageNo: 1,
    totalPage: Math.ceil(datas2.total / 10),
    totalLimit: 10,
    totalSize: datas2.total,
    callback: function(num, nbsp) {
      var searchParameters =where_datas 
       searchParameters.offset=num * nbsp - nbsp;
      searchParameters.limit=nbsp;
      searchParameters.real_search=1;


      // {
      //   agentf_id: where_datas.agentf_id,
      //   agenty_id: where_datas.agenty_id,
      //   area: where_datas.area,
      //   city: where_datas.city,

      //   customertype: where_datas.customertype,
      //   devbrand_id: where_datas.devbrand_id,
      //   devfactory_id: where_datas.devfactory_id,
      //   devname_id: where_datas.devname_id,
      //   investor_id: where_datas.investor_id,
      //   province: where_datas.province,
      //   search: where_datas.search,
      //   time1: where_datas.time1,
      //   time2: where_datas.time2,
      //   usetype: where_datas.usetype,



      //   offset: num * nbsp - nbsp,
      //   limit: nbsp
      // }


      // console.log(searchParameters)

      Get_datas(searchParameters,num)
    }
  })



// Get_datas(searchParameters,1)

  function Get_datas(searchParameters,num) {
    var ii = layer.open({
      type: 1,
      skin: 'layui-layer-demo', //样式类名
      closeBtn: 0, //不显示关闭按钮
      anim: 2,
      shadeClose: false, //开启遮罩关闭
      content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
    });

    $.post("./index.php?r=water-use/get-datas", searchParameters, function(data) {
      // console.log(searchParameters)
      console.log(data)

      var sales_detail = data.sales_detail
      layer.close(ii);
      $("#tableData").empty()
      dev_listdata(sales_detail,num)
    })
  };
  function dev_listdata(data,num) {
    // console.log(data)

        if(!data){
           data=[]
          }
    var j = 0;
    for (var i = 0; i < data.length; i++) {
      var item = data[i]
      for (var z in item) {
        if (item[z] == null) {
          item[z] = '--'
        }
      }
      j++
      var UseType = usetype(item.UseType)
      var CustomerType = customertype(item.CustomerType)
      var WaterUse = 0;
      if (item.WaterUse == '--') {
        WaterUse == 0
      } else {
        WaterUse = Math.round(item.WaterUse * 100) / 100
      }
      var html = '<tr>'
       // ((num-1)*10+ j*1)
      html += '<td>' + j+ '</td>'
      html += '<td>' + item.UserName + '</td>'
      html += '<td>' + item.Tel + '</td>'
      html += '<td>' + item.DevNo + '</td>'
      html += '<td>' + item.DevBrand + '</td>'
      html += '<td>' + item.DevName + '</td>'
      html += '<td>' + item.DevFactoryName + '</td>'
      html += '<td>' + item.investor + '</td>'
      html += '<td>' + item.AgentName + '</td>'
      html += '<td>' + item.AgentPname + '</td>'
      html += '<td>' + item.Province + '-' + item.City + '-' + item.Area + '</td>'
      html += '<td>' + UseType + '</td>'
      html += '<td>' + CustomerType + '</td>'
      html += '<td>' + WaterUse + '</td>'
      html += '</tr>'
      $("#tableData").append(html);
    }

      function usetype(usetype) {
    var res = ''


  for(var i=0;i<all_use_type.length;i++){
        var item = all_use_type[i];
        if(item.code==usetype){
              res = item.use_type;
        }
    }
    return res;
  }


  function customertype(usetype) {
    var reso = ''
    if (usetype == 1) {
      reso = "家庭"
    } else if (usetype == 2) {
      reso = "公司"
    } else if (usetype == 3) {
      reso = "集团"
    } else if (usetype == 4) {
      reso = "酒店"
    } else if (usetype == 99) {
      reso = "其他"
    } else {
      reso = ''
    }

    return reso;
  }

  }





