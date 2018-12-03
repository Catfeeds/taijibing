$(function() {


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

  salesVolume(datas)


  $(document).on('click', '.dataUlLI li', function() {
      $('.activer').removeClass('activer');
      $(this).addClass('activer');
      $('.dataUlLI li p').css('borderRight', "1px #000 solid");
      $(".dataUlLI li:last-of-type p").css('borderRight', "0px #000 solid");
      $(this).prev().find('p').css('border', "none");
      $(this).find('p').css('border', "none");
      $("#time1sub").val($(this).val())
      $("#time2sub").val('')
      $("#date_demo").text('请选择时间段')
    })
    .on('click', '.address .dropdown-menu li', function() {
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

      $(".toggle-input").val('')
      var dropdownLength = $('.dropdown').length;
      $("#date_demo").text('');

      $("#time1sub").val('')
      $("#time2sub").val('')
      $("#searchp").val('');

      for (var i = 0; i < dropdownLength; i++) {
        var dropLi = $('.dropdown li:first-of-type').eq(i).text();
        var dropLival = $('.dropdown li:first-of-type').eq(i).val();

        // console.log(dropLival)
     
            $('.dropdown button').eq(i).html(dropLi+'<span class="caret"></span>');
        $('.dropdown .toggle-input').eq(i).val('');
      }


      return false;
    })
    .on('click', '.data-view', function() {
      $('#dataView').css('display', 'block')
    })
    .on('click', '#Close', function() {
      $('#dataView').css('display', 'none')
    })

  // 渲染省
  initProvince(data)
  // 选择省后渲染市
  $("#province").parents('.dropdown').children(".dropdown-menu").children().click(function() {
    var _thisval = $(this).attr('value');
    $("#city").html('请选择&nbsp;<span class="caret"></span>').attr("value", '').parent().find(".toggle-input").val('0');
    $("#area").html('请选择&nbsp;<span class="caret"></span>').attr("value", '').parent().find(".toggle-input").val('0');
    var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
    var _togglevalooo = $("#city").parent().find(".toggle-input").val();
    // alert(_togglevalooo);
    if (_thisval != _toggleval) {

      initCityOnProvinceChange(_thisval, data)
    }
    // 选择市后渲染区
    $("#city").parents('.dropdown').children(".dropdown-menu").children().click(function() {
      var _thisval = $(this).attr('value');
      $("#area").html('请选择&nbsp;<span class="caret"></span>').attr("value", '').parent().siblings(".toggle-input").val('');
      var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
      if (_thisval != _toggleval) {
        initThree(_thisval, data)
      }
    })
  })

  // 角色渲染
  roleList(agenty, $('#Agenty'));
  // roleList(agentf, $('#Agentf'));
  roleList(devfactory, $('#devfactory'));
  roleList(investor, $('#investor'));






  // // 商品渲染
  //  water_brand_list(devbrand, devname, $("#devbrand"), $("#devname"))

  use_type_list(use_type)
// console.log(use_type)

  Agentflist()
  // 商品渲染
  water_brand_list(devbrand, devname, $("#devbrand"), $("#devname"));

  initAddress();
  // 折线数据渲染
  FoldLineDiagramCalculation()

})


function use_type_list(use_type){
   if(use_type.length){

    var use_typeVal = $("#usetype").parents('.dropdown').children(".dropdown-menu");
     use_typeVal.children().not(":first").remove()
     for(var i=0;i<use_type.length;i++){
      var item = use_type[i];
       use_typeVal.append("<li  class='downLi' value='" + item.use_type + "'>" + item.use_type + "</li>");
     }
  }
}


function initProvince(areas) {
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

// 选择省后渲染区的方法
function initCityOnProvinceChange(_thisval, areas) {
  var pid = getAddressIdByName(_thisval, areas);

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

function initThree(_thisval, areas) {
  var pid = getAddressIdByName(_thisval, areas);

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
function getAddressIdByName(_name, areas) {

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


// 角色渲染方法
function roleList(dataList, $id) {
  var water_brandVal = $id.parents('.dropdown').children(".dropdown-menu");
  water_brandVal.children().not(":first").remove()
  if (dataList) {

    for (var i = 0; i < dataList.length; i++) {
      var item = dataList[i];
      water_brandVal.append("<li  class='downLi' value='" + item.Id + "'>" + item.Name + "</li>");
    }
  }
}


// 水厂渲染方法
function roleListppp(dataList, $id) {
  var water_brandVal = $id.parents('.dropdown').children(".dropdown-menu");
  water_brandVal.children().not(":first").remove()
  if (dataList) {
    for (var i = 0; i < dataList.length; i++) {
      var item = dataList[i];
      water_brandVal.append("<li  class='downLi' dataId ='" + item.Id + "'  value='" + item.PreCode + "'>" + item.Name + "</li>");
    }
  }
}
function Agentflist() {
  $("#Agenty").parents('.dropdown').children(".dropdown-menu").children().click(function() {
    var _thisval = $(this).attr('valchildren(".dropdown-menu")ue');
  
    $("#Agentf").html('请选择服务中心&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
    $("#usetype").html('入网属性&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
    Agentflistp(_thisval)
$.get('index.php?r=sales-volume/get-use-type',{'agenty_id':_thisval}, function(data) {
  /*optional stuff to do after success */
  var data =JSON.parse(data)
    // console.log(data)
     use_type_list(data.datas)
});
    // alert(1)

  })
}



function Agentflistp(_thisval) {
  var water_brandVal = $("#Agentf").parents('.dropdown').children(".dropdown-menu")
  water_brandVal.children().not(":first").remove();
  for (var i = 0; i < agentf.length; i++) {
    var item = agentf[i];
    item.ParentId
    if (_thisval == item.ParentId) {
        water_brandVal.append("<li  class='downLi' value='" + item.Id + "'>" + item.Name + "</li>").css('minWidth', '150px');
    }

  }

$("#Agentf").parents('.dropdown').children(".dropdown-menu").children().click(function() {
  $("#usetype").html('入网属性&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
    var _thisval = $(this).attr('value');
    var _Agentyval = $("#Agenty").attr('value');
    if(_thisval){
        $.get('index.php?r=water-use/get-use-type',{'agenty_id':_Agentyval,'agentf_id':_thisval}, function(data) {
          var data =JSON.parse(data)
            // console.log(data)
              use_type_list(data.datas)
        })

    }
})

}


// 品牌后渲染方法
function water_brand_list(devbrand, devname, $id, $goodsid) {
  if (devbrand) {

    var water_brandVal = $id.parents('.dropdown').children(".dropdown-menu")
    water_brandVal.children().not(":first").remove()
    $goodsid.parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
    for (var i = 0; i < devbrand.length; i++) {
      var item = devbrand[i];
      // console.log(item)
      water_brandVal.append("<li  class='downLi' value=" + item.BrandNo + ">" + item.BrandName + "</li>").css('minWidth', '200px');
    }
  }



  // 次序渲染
  $id.parents('.dropdown').children(".dropdown-menu").children().click(function() {
    var _thisval = $(this).attr('value');

    $goodsid.html('请选择设备型号&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
    var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();
    if (_thisval != _toggleval) {
      // alert(_thisval)
      initWater_goodsChange(_thisval)
    }
  })
}

// 选择品牌后渲染商品的方法
function initWater_goodsChange(_thisval) {

  // var devname = where_datas.devname;
  // console.log(_thisval)
  if (devname) {

    var water_brandVal = $("#devname").parents('.dropdown').children(".dropdown-menu");
    water_brandVal.children().not(":first").remove()


    for (var i = 0; i < devname.length; i++) {

      var item = devname[i];


      if (item.brand_id == _thisval) {
        water_brandVal.append("<li  class='downLi' value='" + item.id + "'>" + item.name + "</li>");

      }
    }
  }
}




// 水厂渲染

//   $("#factory").parents('.dropdown').children(".dropdown-menu").children().click(function() {
// alert(5)
// })




// 渲染水商品


function list_water_brand(water_brand,Id) {
  if (water_brand) {
    // console.log(water_brand)
    var water_brandVal = $("#waterbrand").parents('.dropdown').children(".dropdown-menu")
    water_brandVal.children().not(":first").remove()
    $("#water_goods").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()

    for (var i = 0; i < water_brand.length; i++) {
      var item = water_brand[i];
      // $("#water_brand")
      // console.log(item)
      if(item.Fid==Id){
         console.log(item)
        water_brandVal.append("<li  class='downLi' value='" + item.BrandNo + "'>" + item.BrandName + "</li>").css('minWidth', '150px');
      }
    }

  }
}



roleListppp(factory, $('#factory'));
 $("#factory").parents('.dropdown').children(".dropdown-menu").children().click(function() {
  var _thisval = $(this).attr('dataid');
    console.log(_thisval)
    list_water_brand(waterbrand,_thisval)
    initwaterbrandChange()
 })
   initwaterbrandChange()
// 次序渲染
function initwaterbrandChange(){


$("#waterbrand").parents('.dropdown').children(".dropdown-menu").children().click(function() {
  var _thisval = $(this).attr('value');
  // $("#watername").html('请选择&nbsp;<span class="caret"></span>').attr('value', '').parent().siblings(".toggle-input").val('');
  // 
    $("#watername").html('请选择水商品&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');
    $("#watervolume").html('请选择水容量&nbsp;<span class="caret"></span>').parent().find(".toggle-input").val('');

      $("#watername").parent().find(".toggle-input").val('');
      $("#watervolume").parent().find(".toggle-input").val('');
  $("#watervolume").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove();
  var _toggleval = $(this).parent().siblings(".dropdown-toggle").val();


  if (_thisval != _toggleval) {
    initwaternameChange(_thisval)
  }

  $("#watername").parents('.dropdown').children(".dropdown-menu").children().click(function() {

    var _thisvalgoods = $(this).attr('value');
    var _togglevalgoods = $(this).parent().siblings(".dropdown-toggle").val();
    var _thisvalgoodsText = $(this).text();
    $("#watervolume").html('请选择&nbsp;<span class="caret"></span>');
    $("#watervolume").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
    if (_thisvalgoods != _togglevalgoods) {
      initWater_volume_Change(_thisval, _thisvalgoodsText)

      // alert(_thisvalgoodsText)
    }
  })

})
}

// 选择水品牌后渲染水商品的方法
function initwaternameChange(_thisval) {

  if (watername) {
    var water_brandVal = $("#watername").parents('.dropdown').children(".dropdown-menu")
    water_brandVal.children().not(":first").remove()

    // $("#water_goods").parents('.dropdown').children(".dropdown-menu").children().not(":first").remove()
    for (var i = 0; i < watername.length; i++) {
      var item = watername[i];
      if (item.brand_id == _thisval) {
        water_brandVal.append("<li  class='downLi' value='" + item.id + "'>" + item.name + "</li>").css('minWidth', '150px');
      }
    }
  }
}

// 选择商品后渲染容量的方法
function initWater_volume_Change(_thisval, _thisvalgoos) {
  if (watervolume) {
    // console.log(watervolume)
    // alert(_thisval)
    // alert(_thisvalgoos)

    var water_brandVal = $("#watervolume").parents('.dropdown').children(".dropdown-menu")
    water_brandVal.children().not(":first").remove()
    for (var i = 0; i < watervolume.length; i++) {
      var item = watervolume[i];

      if (item.brand_id == _thisval && item.name == _thisvalgoos) {

        water_brandVal.append("<li  class='downLi' value='" + item.volume + "'>" + item.volume + "</li>").css('minWidth', '150px');
      }
    }
  }
}



function initAddress() {
  
  if (where_datas) {
    console.log(where_datas)
    //  // 记录选项
    var select_where = where_datas;
    // console.log(select_where)
    for (var i in select_where) {
      var item = select_where[i];
      if (item&& item!=0) {
        var form_input = $("form input").length;
        // console.log(item)
        // console.log(i)

        for (var y = 0; y < form_input; y++) {
          var formName = $("form input").eq(y).attr('name')
        // console.log(formName)
      
          if (formName == i) {
        // console.log(item)

            $("form input").eq(y).val(item);
            $("form input").eq(y).parent().find(".dropdown-toggle").attr('value', item);
            var oppo = getAddressIdName(item, i)
            $("form input").eq(y).parent().find(".dropdown-toggle").html(oppo + '&nbsp;&nbsp;&nbsp;<span class="caret"></span>');
          }
        }
      }
    }
    if (where_datas.time2) {

      $('.selection-time .activer').removeClass('activer');
      $("#date_demo").text(where_datas.time1 + '到' + where_datas.time2);
    } else if (where_datas.time1) {

      $('.selection-time .activer').removeClass('activer');
      $(".selection-time li").eq(where_datas.time1 - 1).addClass('activer')
            $("#date_demo").text('');
      // alert(where_datas.time1 )
    }
  var _Agentyval = $("#Agenty").attr('value');
  var _Agentfval = $("#Agentf").attr('value')||'';
    if(_Agentyval){
        $.get('index.php?r=water-use/get-use-type',{'agenty_id':_Agentyval,'agentf_id':_Agentfval}, function(data) {
          var data =JSON.parse(data)
            // console.log(data)
              use_type_list(data.datas)
        })
    }

if(role_id==2){

$("#method").css('display','none')
$("#Agenty,#Agentf,#devfactory,#investor,#devbrand,#devname").parent().css('display','none')
$("#investor").parent().parent().css('minWidth','0')

$("#customertypebfc").parent().css('display','none')
var html = $(".submitBtn").html();
$(".submitBtn").remove();
$(".head-txt:nth-last-of-type(2)").append(html)
  if(factory_precode&&factory_precode!=0){
    // console.log(factory_precode)
    var water_brandVal = $("#factory").parents('.dropdown').children(".dropdown-menu")
    water_brandVal.children().not(":first").remove();
    var _title = roleList_idpp(factory, factory_precode)
    var _Id = roleList_idppto(factory, factory_precode)
    // console.log(_Id)
     water_brandVal.append("<li  class='downLi'  dataId ='" + _Id + "' value='"+factory_precode+"'>" + _title+ "</li>").css('minWidth', '150px');
 
      list_water_brand(waterbrand,_Id)
      initwaterbrandChange()

  }


}






  }
}


function  roleList_idppto(dataList, _name) {
  var poikl = ''
  for (var i = 0; i < dataList.length; i++) {
    var item = dataList[i];
          // console.log(item)
    var id = $.trim(item.PreCode);
    if (id != "" && id == _name) {
      poikl = item.Id
      // return ;
    }
  }
  return poikl;
}
// console.log(factory)

function getAddressIdName(_name, i) {
  // console.log(_name)
  // console.log(i)
  _name = $.trim(_name);
  if (_name == "" && _name == 0 && !_name) {
    return;
  }

  if (i == 'province') {

    initCityOnProvinceChange(_name, data)
    return _name;
  } else if (i == 'city') {
    if (_name == 0) {
      return '选择市';
    }
    initThree(_name, data)

    return _name;
  } else if (i == 'area') {
    if (_name == 0) {
      return '选择区';
    }
    return _name;
  } else if (i == 'agenty_id') {

    // console.log(agenty)
    var _title = roleList_id(agenty, _name)
    Agentflistp(_name)

    return _title;
  } else if (i == 'agentf_id') {

    var _title = roleList_id(agentf, _name)
    return _title;
  } else if (i == 'devfactory_id') {
    var _title = roleList_id(devfactory, _name)
    return _title;
  } else if (i == 'investor_id') {
    var _title = roleList_id(investor, _name)
    return _title;
  } else if (i == 'waterfactory_precode') {

    var _title = roleList_idpp(factory, _name)
    return _title;
  } else if (i == 'devbrand_id') {
    //  console.log(where_datas)
    for (var index = 0; index < devbrand.length; index++) {
      var item = devbrand[index];
      //    // console.log(item)
      var BrandNo = $.trim(item.BrandNo);
      if (BrandNo != "" && BrandNo == _name) {

        initWater_goodsChange(_name)
        return item.BrandName;
      }
    }
    return _name;
  } else if (i == 'devname_id') {
    for (var index = 0; index < devname.length; index++) {
      var item = devname[index];
      var id = $.trim(item.id);
      if (id != "" && id == _name) {
        //      initWater_goodsChange(_name) 
        return item.name;
      }
    }
  } else if (i == 'waterbrand_id') {


for (var index = 0; index < waterbrand.length; index++) {
      var item = waterbrand[index];
      var id = $.trim(item.BrandNo);
      if (id != "" && id == _name) {
        // alert(_name)
        initwaternameChange(_name)
        return item.BrandName;
      }
    }
  } else if (i == 'watername_id') {



    for (var index = 0; index < watername.length; index++) {
      var item = watername[index];
      var name = $.trim(item.id);
      if (name != "" && name == _name) {
        //       alert(where_datas.waterbrand_id)
        // alert(item.name)

        initWater_volume_Change(where_datas.waterbrand_id, item.name)


        return item.name;
      }
    }
  } 
  else if (i == 'usetype') {
    var usetypetitle = _name
    switch (_name * 1) {
      case 0:
        usetypetitle = '全部用户类型';
        break;
      // case 2:
      //   usetypetitle = '押金';
      //   break;
      // case 3:
      //   usetypetitle = '买水送机';
      //   break;
      // case 4:
      //   usetypetitle = '买机送水';
      //   break;
      // case 5:
      //   usetypetitle = '免费';
      //   break;
      // case 99:
      //   usetypetitle = '其他';
      //   break;
      // default:
      //   usetypetitle = '全部用户类型'

    }
    return usetypetitle;
  }
  return _name;
}

function roleList_idpp(dataList, _name) {
  // console.log(_name)
  var poikl = ''
  for (var i = 0; i < dataList.length; i++) {
    var item = dataList[i];
    var id = $.trim(item.PreCode);
    if (id != "" && id == _name) {
      // console.log(item.Name)
      //      initWater_goodsChange(_name) 
      poikl = item.Name
      // return ;
    }
    // water_brandVal.append("<li  class='downLi' value='" + item.Id  + "'>" + item.Name  + "</li>").css('minWidth','150px');
  }
  return poikl;

}

function roleList_id(dataList, _name) {
  // console.log(_name)
  var poikl = ''
  for (var i = 0; i < dataList.length; i++) {
    var item = dataList[i];
    var id = $.trim(item.Id);
    if (id != "" && id == _name) {
      // console.log(item.Name)
      //      initWater_goodsChange(_name) 
      poikl = item.Name
      // return ;
    }
    // water_brandVal.append("<li  class='downLi' value='" + item.Id  + "'>" + item.Name  + "</li>").css('minWidth','150px');
  }
  return poikl;

}

// 销量概况
function salesVolume(data) {
  if (!data) {
    return;
  }
  var $data = data[0] || '';
  $("#sales1").text($data.sales1)
  var sales2 = Percentage($data.sales1, $data.sales2);
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
  // $("#sales2").text(sales2+"%")

  $("#user_num").text($data.user_num)

  $("#sales_of").text(Percentage2($data.sales1, $data.user_num))


  $("#sales_of_year").text($data.sales_of_year)

  // console.log(data.sales_of_year)
}

function Percentage(number1, number2) {
  if (number2 == 0) {
      number2 = 1;
  }

  return (Math.round(((number1 / number2) - 1) * 10000) / 100.00); // 小数点后两位百分比
}

function Percentage2(number1, number2) {
  return (Math.round(number1 / number2)); // 小数点后两位百分比
}

function diy_time(time1num, time2num) {

  time1data = Date.parse(new Date(time1num));

  time2data = Date.parse(new Date(time2num));

  return time3 = Math.abs(parseInt((time2data - time1data) / 1000 / 3600 / 24)) + 1;

}

function unique2($data) {
  var res = [];
  var rel = [];

  var json = {};

  for (var p = 0; p < $data.length; p++) {
    if (!json[$data[p].volume]) {
      res.push($data[p].volume);
      rel.push($data[p]);
      json[$data[p].volume] = 1;
    } else {}
  }

  return rel;
}

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

// 折线数据渲染方法
function FoldLineDiagramCalculation() {

  var use_statusdata = datas[0].sales_status;
  // console.log(use_statusdata)
  var _date = []
  var xin = 7;

  if (where_datas.time2 != 0 && where_datas.time2 && where_datas.time2 != null && where_datas.time2 != '') {
    var use_statusXin = diy_time(where_datas.time1, where_datas.time2) + 1;
    xin = use_statusXin

  } else {
    // 今天昨天渲染
    if (where_datas.time1 == 1) {
      // alert(1)
      xin = 1;
      // _date = [timedatae]
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
  }

  var lop = 0;
  var timedatae = GetDateStr(0, 1)
  if (where_datas.time2 && where_datas.time2 != null && where_datas.time2 != '') {
    lop = diy_time(where_datas.time2, timedatae) - 1

  }



  var darax = NumberDays(xin, _date, lop)

  var daray = [];


  if (darax.length <= 2) {
    var itmesum = []
    for (var i = 0; i < use_statusdata.length; i++) {
      var itme = use_statusdata[i].RowTime;
      var itmesumTer = itme.split(" ")[1]
      itmesum.push(itmesumTer.replace(':', '.'))
    }
    // console.log(1)
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



function NumberDays(xin, _date, _datenume) {
  var xin = xin || 7
  var _datenume = _datenume || 0;
  for (var i = -_datenume; i > -(xin + _datenume - 1); i--) {
    // console.log(i)
    _date.push(GetDateStr(i, 1))
  }
  _date.reverse();
  return _date;
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
  map(mapProvinceNUm, mapProvincebox, mapCityNUm, mapCitybox, mapProvinceNUmColor);

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
  for (var i = 0; i < 4; i++) {
    if (CustomerTypeNum.length < 4) {
      if (!CustomerTypeNum[i]) {
        CustomerTypeNum.push(0)
      }
    }
  }
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

  var CustomerTypeuniqueName = ['家庭', '集团', '公司', '其他'];

  for (var i = 0; i < CustomerTypeNum.length; i++) {
    $("#dataView tbody tr td:nth-child(2)").eq(i + 1).text(CustomerTypeNum[i])
    var num = Math.round(CustomerTypeNum[i] / sales_status.length * 100)
    if (num) {
      $(".baifenbiA .baifenbi").eq(i).text(num)
    }
  }
  var $name = '用户类型销量占比'

  // console.log(CustomerTypeunique)
  // console.log(CustomerTypeNum)
  PieChart(CustomerTypeuniqueName, CustomerTypeNum, $name)
  $("#Refresh,.data-refresh").click(function() {
    PieChart(CustomerTypeunique, CustomerTypeNum)
    $('#dataView').css('display', 'none')
  });
}
 // 表格渲染
  var sales_detail = datas[0].sales_detail;
  dev_listdata(datas[0].sales_detail)
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
        customertype: where_datas.customertypea,
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
      Get_datas(searchParameters)
      // console.log(searchParameters)
    }
  })
  function  Get_datas(searchParameters){


  $.post("./index.php?r=sales-volume/get-datas", searchParameters, function(data){
       console.log(data)
      var sales_detail=data[0].sales_detail
         dev_listdata(sales_detail)
  })
}
  function dev_listdata(data) {
// console.log(data)
    var j = 0;
    // alert(1)
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


   function customertype(usetype){

    var res =''
        if(usetype == 1){
            res = "家庭"
        }
        else if(usetype == 2){
            res = "公司"
        }
        else if(usetype == 3){
            res = "集团"
        }
        else if(usetype == 99){
            res = "其他"
        }else{
          res =''
        }
        return res;
   }