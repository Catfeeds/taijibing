    $(function(){
         initProvince();
         initListener();
         RenderingAgent(agenty,$("#Agenty"))
         RenderingAgent(agentf,$("#Agentf"))
         RenderingAgent(devfactory,$("#devfactory"))
         RenderingAgent(investor,$("#investor"))
         RenderingAgent(factory,$("#factory"))
         Renderingdev(devbrand,$("#devbrand"))
         Renderingdev(devname,$("#devname"))
         Renderingdev(waterbrand,$("#waterbrand"))
         Renderingdev(watername,$("#watername"))
         initAddress();
$(document).on('click','.selection-time li',function(){
  $('.selection-time .activer').removeClass('activer');
$(this).addClass('activer')

}).on('click',"#submit",function(){
 var searchParameters   ={

  time:$("#selectionTime  .activer").attr("value"),
  time1:$("#adddate").val().split("到")[0],
  time2: $("#adddate").val().split("到")[1],



  province:$('#province option:selected').val(),
  city:$('#city option:selected').val(),
  area:$('#area option:selected').val(),

  agenty_id:$('#Agenty option:selected').val(),
  agentf_id:$('#Agentf option:selected').val(),
  devfactory_id:$('#devfactory option:selected').val(),
  investor_id:$('#investor option:selected').val(),
  waterfactory_precode:$('#factory option:selected').val(),

  devbrand_id:$('#devbrand option:selected').val(),
  devname_id:$('#devname option:selected').val(),
  waterbrand_id:$('#waterbrand option:selected').val(),
  watername_id:$('#watername option:selected').val(),
  watervolume:$('#watervolume option:selected').val(),



  usetype:$('#usetype option:selected').val(),
  customertype:$('#customertype option:selected').val(),
  search:$('#search').val()
 }     
     $.post('./?r=sales-volume/get-all-datas', searchParameters, function(data){
        salesVolume(data)


var sales_status = data[0].sales_status;
 
var xin = sales_status.length;

var _date = []
NumberDays(xin,_date)
// console.log(_date)

var darax = _date;
var daray = [];
 var sales_status = data[0].sales_status;
for(var i=0;i<darax.length;i++){
   daray.push(0)
  var daraxDate = Date.parse(darax[i]);
  for(var j=0;j<sales_status.length;j++){
  var nowDate = Date.parse(sales_status[j].Date);
  // console.log(nowDate)

    if(daraxDate == nowDate){
    daray[i]++
         
    }
  }
}
// console.log(daray)
FoldLineDiagram(darax,daray)

 
 mapCityBar(sales_status)
     })
 

}).on('click',"#removerSub",function(){




})
_hover($(".volumeHover"), $(".volumeHover-text"))
_hover($(".compareHover"), $(".compareHover-text"))
_hover($(".AverageHover"), $(".AverageHover-text"))
_hover($(".pageHover"), $(".pageHover-text"))
$.post('./?r=sales-volume/get-all-datas', function(data){
salesVolume(data)
var sales_status = data[0].sales_status;
var xin = 7;
var _date = []
NumberDays(xin,_date)

var darax = _date;
var daray = [];
for(var i=0;i<darax.length;i++){
daray.push(0)
  var daraxDate = Date.parse(darax[i]);
  for(var j=0;j<sales_status.length;j++){
  var nowDate = Date.parse(sales_status[i].Date);
    if(daraxDate == nowDate){
            daray[i]++
    }
  }
}

   FoldLineDiagram(darax,daray)


 mapCityBar(sales_status)
     // map()
       })
  })

function mapCityBar(sales_status){
var mapProvince = [];
var mapCity = [];
for(var j=0;j<sales_status.length;j++){
 mapProvince.push(sales_status[j].Province)
 mapCity.push(sales_status[j].City)
}
var mapProvinceNUm = mapProvince.unique()
var mapProvincebox=[]
 var  progressBar = []
for(var j=0;j<mapProvinceNUm.length;j++){
 mapProvincebox.push(0)
for(var i=0;i<mapProvince.length;i++){
   if(mapProvinceNUm[j] ==mapProvince[i] ){
     mapProvincebox[j]++
   }
}
  progressBar.push(Math.round( mapProvincebox[j] / sales_status.length*100))
  $("#Percentage").empty();
  var html = '<div class="progress"><span class="name">'+mapProvinceNUm[j]+'</span>'
           +'<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '+progressBar[j]+'%;">'
              +'<span class="">'+progressBar[j]+'%; </span>'
            +'</div>'
          +'</div>'
  $("#Percentage").append(html);
}
var mapmapCityNUM =mapCity.unique()
var mapCitybox=[]
var  CityBar = []
for(var j=0;j<mapmapCityNUM.length;j++){
   mapCitybox.push(0)

  for(var i=0;i<mapCity.length;i++){
   if(mapmapCityNUM[j] ==mapCity[i] ){
     mapCitybox[j]++
   }


  }

CityBar.push(Math.round( mapCitybox[j] / sales_status.length*100)) 

}
 map(mapProvincebox,mapCitybox,progressBar,CityBar,mapProvinceNUm,mapmapCityNUM)


}


function NumberDays(xin, _date) {
  for (var i = 0; i >= -xin + 1; i--) {
    _date.push(GetDateStr(i, 1))
      // console.log(GetDateStr(i,1))
  }
  _date.reverse();
  return _date;
}

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

function  salesVolume(data){
           
  if(!data){
   return;
  }
    var $data =data[0]|| ''; 
  $("#sales1").text($data.sales1)
if($data.sales2<1){
  $data.sales2=1;
  // var sales2 = Percentage($data.sales1, $data.sales2)+"%";
  // $("#sales2").text(sales2+"%")
}
  var sales2 = Percentage($data.sales1, $data.sales2);

  if(sales2<0){
         $("#sales2").text(sales2+"%")
         $("#sales2").append('<img src="/static/images3/Arrowb.png" alt="">')
  }else if(sales2>0){
     $("#sales2").text(sales2+"%")
         $("#sales2").append('<img src="/static/images3/arrowA.png" alt="">')
  }else{
     $("#sales2").text(sales2+"%")
         $("#sales2").append('<img src="/static/images3/rectangle.png" alt="">')
  }
  // $("#sales2").text(sales2+"%")

  $("#user_num").text($data.user_num)
  $("#sales_of").text($data.sales1/$data.user_num)
  $("#sales_of_year").text($data.sales_of_year)
}
     function Percentage(number1, number2) {
       return (Math.round((number1 / number2-1) * 10000) / 100.00); // 小数点后两位百分比
     }  
     //伪类
     function _hover(Class, ClassText) {
       Class.hover(function() {
         ClassText.css("display", "block");
       }, function() {
         ClassText.css("display", "none");
       });
     }
    function initListener() {
        $("#province").on("change", function () {
            initCityOnProvinceChange();
        });
        $("#city").on("change", function () {
            initThree();
        });
        initAgent($("#Agenty"),$("#Agentf"),agentf)
        initAgenty($("#Agentf"),$("#Agenty"),agenty)


        initDev($("#devbrand"),$("#devname"),devname)
        initDevname($("#devname"),$("#devbrand"),devbrand)
        initDev($("#waterbrand"),$("#watername"),watername)
        initDevname($("#watername"),$("#waterbrand"),waterbrand)
// 水容量渲染
         $("#watername").on("change", function () {
    $("#watervolume").empty();
    $("#watervolume").append("<option value='' selected>请选择设备商品型号</option>");
          var _thisId=  $('#watername option:selected').attr("data");
            for (var index = 0; index < watervolume.length; index++) {
            var item = watervolume[index];

                 if(_thisId == item.id){

                  $("#watervolume").append("<option value='" + item.id + "'>" + item.volume + "</option>");
                 }
        }
        });

    }





// 商品选择 /水品牌 渲染
function Renderingdev($data,$id){

      for (var index = 0; index < $data.length; index++) {
            var item = $data[index];
            var  brand =  item.BrandNo|| item.brand_id
            var  Name = item.name ||item.BrandName
               if(item.id){
                $id.append("<option value='" + brand + "' data ="+item.id+">" + Name + "</option>");
          }else{
          $id.append("<option value='" + brand + "'>" + Name + "</option>");  

          }
        
        }
}

// 商品选择先选


function initDev($Id1,$Id2,$data){
        $Id1.on("change", function () {
          if($(this).val()==''){
           Renderingdev($data,$Id2)
           return;
        }
        var _thisId=   $(this).val();
          $Id2.empty();
          $Id2.append("<option value='' selected>请选择设备商品型号</option>");
          for(var i=0;i<$data.length;i++){
            var item =  $data[i];
    var  brand = item.BrandNo || item.brand_id
            var  Name = item.name ||item.BrandName
        if(_thisId == brand){
        if(item.id){
                $Id2.append("<option value='" + brand + "' data ="+item.id+">" + Name + "</option>");
        }
        else{
            $Id2.append("<option value='" + brand + "'>" + Name + "</option>");
        }
     
            }
          }
        });
}


function initDevname($Id1,$Id2,$data){
        $Id1.on("change", function () {
          if($(this).val()==''){
           Renderingdev($data,$Id2)
           return;
        }
          var _thisId=   $(this).val();
          $Id2.empty();
          $Id2.append("<option value='' selected>请选择设备商品型号</option>");
          for(var i=0;i<$data.length;i++){
            var item =  $data[i];
            if(_thisId == item.BrandNo){
               
             $Id2.append("<option value='" + item.BrandNo + "'selected = 'selected'>" + item.BrandName + "</option>");
            }
          }
        });
}


// 角色选择渲染
function RenderingAgent($data,$id){
      for (var index = 0; index < $data.length; index++) {
            var item = $data[index];

                  if(item.ParentId){
               $id.append("<option value='" + item.Id + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
              }else{
                $id.append("<option value='" + item.Id + "'>" + item.Name + "</option>");
              }
        }
}


// 运营中心先选
function initAgent($Id1,$Id2,$data){
        $Id1.on("change", function () {
          if($(this).val()==''){
           RenderingAgent($data,$Id2)
           return;
        }
          var _thisId=   $(this).val();
          $Id2.empty();
          $Id2.append("<option value='' selected>请选择服务中心</option>");
          for(var i=0;i<$data.length;i++){
            var item =  $data[i];
            // if(item.ParentId){
            //   $Id2.append("<option value='" + item.Id + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
            //  }

     if(_thisId == item.ParentId){
                  $Id2.append("<option value='" + item.Id + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
            }
          }
        });
}

// 服务中心先选

function initAgenty($Id1,$Id2,$data){
        $Id1.on("change", function () {
          if($(this).val()==''){
           RenderingAgent($data,$Id2)
           return;
        }
          var _thisId=  $('option:selected',$Id1).attr("data");
          $Id2.empty();
          $Id2.append("<option value='' selected>请选择运营中心</option>");
          for(var i=0;i<$data.length;i++){
            var item =  $data[i];
              if(_thisId == item.Id){
                  $Id2.append("<option value='" + item.Id + "' selected = 'selected'>" + item.Name + "</option>");
            }
          }
        });
}
  function initAddress() {
        // $("#province").val(province);
        initCityOnProvinceChange();
        // $("#city").val(city);
        initThree();
        // $("#area").val(area);
    }
    function getAddressIdByName(_name) {
        _name = $.trim(_name);
        if (_name == "") {
            return 0;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            var name = $.trim(item.Name);
            if (name != "" && name == _name) {
                return item.Id;
            }
        }
        return 0;
    }

    function initCityOnProvinceChange() {
        var pid = getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        $("#city").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#city").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
                initThree()
            }
        }
    }
    function initThree() {
        var pid = getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if (pid == 0) {
            return;
        }
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#area").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
    function initProvince() {
        for (var index = 0; index < data.length; index++) {
            var item = data[index];
            if (item.PId == 0) {
                $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }

    }
 