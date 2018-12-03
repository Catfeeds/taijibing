




_hover($(".volumeHover"), $(".volumeHover-text"))
_hover($(".compareHover"), $(".compareHover-text"))
_hover($(".AverageHover"), $(".AverageHover-text"))
_hover($(".pageHover"), $(".pageHover-text"))
    //伪类
  function _hover(Class, ClassText) {
      Class.hover(function() {
        ClassText.css("display","block");
 			Class.css("background", "url(/static/images3/volumeHover2.png) no-repeat");
      }, function() {
        ClassText.css("display", "none");
        Class.css("background", "url(/static/images3/volumeHover1.png) no-repeat");
      });
  }


	var dateRange = new pickerDateRange('date_demo3', {
					//aRecent7Days : 'aRecent7DaysDemo3', //最近7天
					isTodayValid : true,
					startDate :GetDateStr(-6, 1) ,
					endDate :  GetDateStr(0, 1)  ,
					//needCompare : true,
					//isSingleDay : true,
					//shortOpr : true,
					//autoSubmit : true,
					defaultText : ' 至 ',
					inputTrigger : 'input_trigger_demo3',
					theme : 'ta',
					success : function(obj) {
					//	$("#dCon_demo3").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
					  $("#time1sub").val( obj.startDate)
            $("#time2sub").val( obj.endDate)
            $('#selectionTime .activer').removeClass('activer')
					}
});


  



//折线图
function FoldLineDiagramCalculation(){
    var use_statusdata = datas2[0].use_status;
    var xin=7;
    var use_statusXin=diy_time(where_datas.time1,where_datas.time2)+1;
     var lop=1;
     var timedatae=GetDateStr(0, 1)
    if(where_datas.time2!=null){
            lop=  diy_time(where_datas.time2,timedatae)
       }
 
  var _date = []
  // 今天昨天渲染
   if(where_datas.time1==1){

    // alert(1)
        xin = 1;

         // _date = [timedatae]
  }else if(where_datas.time1==2){
       xin = 1

  }
  else if(where_datas.time1==3){
      xin = 7
  }
  else if(where_datas.time1==4){
     xin = 30
  }
  else if(where_datas.time1==5){
      xin = 90
  }else if(where_datas.time1==null){
       xin = 7
       lop=0
 
  }else{
  	 xin = use_statusXin

  }

    NumberDays(xin, _date, lop)
    var darax = _date;
    var daray=[];
 
  if(darax.length<=1){
    var itmesum =[]
    for(var i=0;i<use_statusdata.length;i++){  
        var itme=use_statusdata[i].ActTime;
        var itmesumTer = itme.split(" ")[1]
          itmesum.push( itmesumTer.replace(':', '.'))
    }
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

}else{
        
      for (var i = 0; i < darax.length; i++) {
        daray.push(0)
     
        var daraxDate = Date.parse(darax[i]);
        for (var j = 0; j < use_statusdata.length; j++) {
          var nowDate = Date.parse(use_statusdata[j].ActDate);
           if (daraxDate == nowDate) {
                  daray[i]=  Math.round((daray[i]*1+use_statusdata[j].WaterUse*1)*100000)/100000

           }
        }
      }
}
 FoldLineDiagram(darax, daray,'用水量')
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

//地址
function initProvince() {
    for (var index = 0; index < areas.length; index++) {
        var item = areas[index];
        if (item.PId == 0) {
            $("#province").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
        }
    }

}

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
        }  }
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
	  for (var index = 0; index < areas.length; index++) {
            var item = areas[index];

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
        for (var index = 0; index < areas.length; index++) {
            var item = areas[index];
            if (item.PId != 0 && item.PId == pid) {
                $("#area").append("<option value='" + item.Name + "'>" + item.Name + "</option>");
            }
        }
    }
 function initAddress() {
	        $("#province").val(where_datas.province);
	         initCityOnProvinceChange();
	        $("#city").val(where_datas.city);
	        initThree();
	        $("#area").val(where_datas.area);
	        $("#Agenty").val(where_datas.agenty_id);
              initAgent( $("#Agenty"),$("#Agentf"),agentf)//关联运营中心
	        $("#Agentf").val(where_datas.agentf_id);
	        $("#devfactory").val(where_datas.devfactory_id);
	        $("#investor").val(where_datas.investor_id);
	        $("#devbrand").val(where_datas.devbrand_id);
           initDevbrand($("#devbrand"),$("#devname"),devname)
	        $("#devname").val(where_datas.devname_id);
	        $("#usetype").val(where_datas.usetype);
	        $("#customertype").val(where_datas.customertype);

	        $("#search").val(where_datas.search);

	        $("#time1sub").val(where_datas.time1);
	        $("#time2sub").val(where_datas.time2);

			   if (where_datas.time1) {
		        if (where_datas.time1.length > 9) {
		          $(".selection-time .activer").removeClass('activer');
		          var _timeval = where_datas.time1 + '到' + where_datas.time2;
		           $("#date_demo3").text(_timeval)
		       
		        } else {
		        	$("#date_demo3").text('选择时间段')
		           $(".selection-time .activer").removeClass('activer');
		    	   $(".selection-time li").eq(where_datas.time1 - 1).addClass('activer');
		        }
		      }

	 }



     // 设备品牌先选
   function initDevbrand($Id1, $Id2, $data) {
           if($Id2.selector=='#devbrand'){

            if ($Id1.val() == '') {
              $('option:not(:first-child)',$Id2).remove();
                   Renderingdev($data,$Id2);
                  return;
              }
        
                var _thisId = $('option:selected', $Id1).attr("datal");
              for (var i = 0; i < $data.length; i++) {
                var item = $data[i];
                  if (item.BrandNo== _thisId) {
                       $Id2.val(_thisId);
                }
              }
            }else{
              if ($Id1.val() == '') {
              $('option:not(:first-child)',$Id2).remove();
                   RenderingName($data,$Id2);
                  return;
              }
              var _thisId = $Id1.val();    
             $('option:not(:first-child)',$Id2).remove()
                  for (var i = 0; i < $data.length; i++) {
                var item = $data[i];
                  if (item.brand_id==_thisId) {
                  $Id2.append("<option value='" + item.id + "' datal ='" + item.brand_id + "' >" + item.name + "</option>");
                  }
                 }
            }
      // })
    }



// 运营中心先选
function initAgent($Id1, $Id2, $data) {
 
    // $Id1.change(function() {

        if ($Id1.val() == '') {
            $('option:not(:first-child)', $Id2).remove();
             RenderingAgent($data, $Id2);
            return;
        }
        if ($Id2.selector == '#Agenty') {
            var _thisId = $('option:selected', $Id1).attr("datal");
        
            for (var i = 0; i < $data.length; i++) {
                var item = $data[i];
                if (item.Id == _thisId) {
                    $Id2.val(_thisId);
                }
            }
        } else {

            var _thisId = $Id1.val();

            $('option:not(:first-child)', $Id2).remove()

            for (var i = 0; i < $data.length; i++) {
                var item = $data[i];
                if (item.ParentId == _thisId) {

                    $Id2.append("<option value='" + item.Id + "' datal ='" + item.ParentId + "' >" + item.Name + "</option>");
                }
            }
        }
      //})
}
 

function initListener() {
    $("#province").on("change",
    function() {
        initCityOnProvinceChange();
    });
    $("#city").on("change",
    function() {
        initThree();
    });
}
// 角色选择渲染
function RenderingAgent($data, $id) {

    for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        if (item.ParentId) {

            $id.append("<option value='" + item.Id + "' datal ='" + item.ParentId + "' >" + item.Name + "</option>");
        } else {
            $id.append("<option value='" + item.Id + "'>" + item.Name + "</option>");
        }
    }
}

// 设备品牌
function Renderingdev($data, $id) {
    for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        var BrandNo = item.BrandNo;
        var Name = item.BrandName;
        $id.append("<option value='" + BrandNo + "'>" + Name + "</option>");
    }
}
// 设备商品型号
function RenderingName($data, $id) {
    for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        var Id = item.id;
        var Name = item.name;
        $id.append("<option value='" + Id + "' datal ='" + item.brand_id + "' >" + Name + "</option>");
    }
}

// 同期
function  salesVolume(){
      if (!datas2[0]) {
          return;
      }
 
  
      $("#sales1").text(datas2[0].use_total);

   var sales2Val = Percentage3(datas2[0].same_time_total,datas2[0].use_total);

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
      $("#user_num").text(datas2[0].user_num);

      $("#sales_of").text(Percentage2(datas2[0].use_total,datas2[0].user_num));

      
           $("#sales_of_year").text(datas2[0].year_use)
        
    }


    function Percentage2(number1, number2) {
      if(number2==0){
        number2=1
      }
      return (Math.round((number1 / number2) * 10000)/10000); // 小数点后两位百分比
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


function Percentage4(number1, number2) {
     if(number2==0){
        number2=1
      }
      return (Math.round((number1 - number2) * 10000) / 100.00); // 小数点后两位百分比
    }

function diy_time(time1num,time2num){
    time1data = Date.parse(new Date(time1num));
    time2data = Date.parse(new Date(time2num));
    return  time3 = Math.abs(parseInt((time2data - time1data)/1000/3600/24));
}



function mapProvinceLBaraaaa($mapL,$mapNump,mapProvinceLBaropi){
    var mapProvinceLBaropi =[];
   for (var i = 0; i < $mapL.length; i++) {
       
           mapProvinceLBaropi.pus(0)

   }
return mapProvinceLBaropi;
}






 function mapNumll(mapUnique,mapNUm,mapData){

     for (var j = 0; j < mapUnique.length; j++) {
           mapNUm.push(0)
         for (var i = 0; i < mapData.length; i++) {
              if (mapUnique[j] == mapData[i]) {
                 mapNUm[j]++
              }
         }
   }
     return mapNUm;

}


function    unique($data) {
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

    function NumberDays(xin, _date,_datenume) {
        var xin=xin||7
       var _datenume = _datenume||0;
      for (var i = -_datenume; i >= -xin-_datenume+1 ; i--) {
         _date.push(GetDateStr(i, 1))
      }
      _date.reverse();
      return _date;
    }
function  Get_datas(searchParameters){
    $.post("./index.php?r=water-use/get-datas", searchParameters, function(data){
           var sales_detail=data[0].sales_detail
 

            $("#tableData").empty()
            var j=0;
            for (var i = 0; i < sales_detail.length; i++) {
                var item = sales_detail[i]
                for(var z in item){
                    if(item[z] == null){
                        item[z] = '--'
                    }
                }
            j++
     var WaterUse=0;
        if(item.WaterUse =='--'){
            WaterUse==0
        }else{
            WaterUse= Math.round(item.WaterUse*100)/100
        }
        var html = '<tr><td>' + j + '</td><td>' + item.UserName + '</td><td>' + item.Tel + '</td><td>' + item.DevNo + '</td>' + '<td>' +item.DevBrand + '</td><td>' + item.DevName + '</td><td>' + item.DevFactoryName + '</td><td>' + item.investor + '</td><td>' + item.AgentName + '</td>' + '<td>' + item.AgentPname + '</td><td>' + item.Province + '-' + item.City + '-' + item.Area + '</td><td>' + UseType + '</td><td>' + CustomerType + '</td><td>' + WaterUse + '</td></tr>'
            $("#tableData").append(html);
            }
    })
}
   function usetype(usetype){
    var res =''
        if(usetype == 1){
            res = "自购"
        }
        else if(usetype == 2){
            res = "押金"
        }
        else if(usetype == 3){
            res = "买水送机"
        }
        else if(usetype == 4){
            res = "买水送机"
        }
        else if(usetype == 3){
            res = "买机送水"
        }
        else if(usetype == 5){
            res = "免费"
        }
        else if(usetype == 99){
            res = "其他"
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


// 地图
function  mapRendering(){     
    var map_datas = datas2[0].map_datas;
     var mapProvince = [];
     var mapCity = [];
     var mapArea = [];
      for (var j = 0; j < map_datas.length; j++) {
        mapProvince.push(map_datas[j].Province);
        mapCity.push(map_datas[j].City);
        mapArea.push(map_datas[j].Area);

      };

  // console.log(mapCity)

      var mapProvinceUnique=unique(mapProvince);
      var mapCityUnique =unique(mapCity);
      var mapAreaUnique =unique(mapArea);

      var mapProvinceNUm=[];
      var mapCityNUm=[];
      var mapAreaNUm=[];
      var mapProvinceNUm =  mapNumll(mapProvinceUnique,mapProvinceNUm,mapProvince);
      var mapCityNUm =  mapNumll(mapCityUnique,mapCityNUm,mapCity);
      var mapAreaNUm =  mapNumll(mapAreaUnique,mapAreaNUm,mapArea);
       $("#percentum").empty();

   var   mapProvinceBar=[]
    var mapCityBar=[]
 for (var j = 0; j < mapCityUnique.length; j++) {
      if(mapCityUnique[j] == null){
           mapCityUnique[j] ='其它'
      }
          mapCityBar.push(Math.round(mapCityNUm[j] / map_datas.length * 100))
  }
    var mapProvinceL = [];
     var mapCityL = [];
     var mapAreaL = [];
// 县的用水量

 for (var i = 0; i < mapProvinceUnique.length; i++) {
          mapProvinceL.push({'key':'0','value':0})
         for (var j = 0; j < map_datas.length; j++) {
            if(map_datas[j]==null||map_datas[j]==''){
                map_datas[j]=0
            }
             var mapProvinceLnum= map_datas[j].total_volume-map_datas[j].WaterRest
               if(mapProvinceUnique[i]==map_datas[j].Province){
                    mapProvinceL[i].value=mapProvinceL[i].value+mapProvinceLnum;
                    mapProvinceL[i].key=mapProvinceUnique[i];
            }

         }
};




function mapProvinceLBar(mapceL ){
    var mapLBartotal = 0;
     for (var i = 0; i < mapceL.length; i++) {
          mapLBartotal=mapLBartotal+mapceL[i].value
     }
     return mapLBartotal;
}

// 市的用水量
 for (var i = 0; i < mapCityUnique.length; i++) {
          mapCityL.push({'key':'0','value':0,'Province':''})
         for (var j = 0; j < map_datas.length; j++) {
            if(map_datas[j]==null||map_datas[j]==''){
                map_datas[j]=0
            }
            var mapCityLnum= map_datas[j].total_volume-map_datas[j].WaterRest
             var mapCityLnumname = map_datas[j].Province
              if(mapCityUnique[i]==map_datas[j].City){
                   mapCityL[i].value=  mapCityL[i].value+mapCityLnum;
                   mapCityL[i].key=mapCityUnique[i];
                   mapCityL[i].Province= mapCityLnumname;
            }
         }
        };

var mapProvinceNump = mapProvinceLBar(mapProvinceL )
var mapCityLNump = mapProvinceLBar(mapCityL )
 
var mapProvinceLBaropi = [];
var mapCityLBaropi = [];

var mapProvinceNUmColor =['#D29616','#4ADCDD','#C248DC','#EA5638','#D29717','#4ADCDD','#C248DC','#EA5638','#D29717','#4ADCDD','#C248DC','#EA5638','#D29717']
  for (var i = 0; i < mapProvinceL.length; i++) {
        mapProvinceLBaropi.push( Percentage3(mapProvinceL[i].value,mapProvinceNump ))
   }

   for (var i = 0; i < mapCityL.length; i++) {
               mapCityLBaropi.push( Percentage3(mapCityL[i].value,mapProvinceNump ))
   }


   for (var j = 0; j < mapProvinceL.length; j++) {
 
      if(mapProvinceUnique[j] == null){
           mapProvinceUnique[j] ='其它'
      }
      if(!mapProvinceNump){
        mapProvinceNump=1
      }
         var html = '<div class="progress" style="height:10px;    background-color: #1d1f23;">'+
                         '<span class="name" style="margin-top:-5px;left: 25px;">' + mapProvinceL[j].key + '</span>' + 
                         '<div class="progress-bar"   role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' 
                         + Math.round((mapProvinceL[j].value/mapProvinceNump) * 10000) / 100 + '%; '+
                         'background-color: '+mapProvinceNUmColor[j] +'">' + '</div>' 
                              + '<span class="baifenbi" style="color: #fff; position: absolute;  '+
                              ' right: 50px;right: 45px;margin-top: -5px;">' + Math.round((mapProvinceL[j].value/mapProvinceNump) * 10000) / 100 + '%'+ 
                              '</span> </div>';

     $("#percentum").append(html);
   }
 

mapmapRendering(mapProvinceL,mapCityL,mapProvinceNump,mapCityLNump,mapProvinceNUmColor)
    //  mapmapRendering(mapProvinceNUm, mapProvinceUnique, mapCityNUm, mapCityUnique, mapAreaNUm, mapAreaUnique,mapProvinceL,mapCityL,mapProvinceLBaropi,mapCityLBaropi)
}

function  titmeChoice(){
 $(document).on('click', '.selection-time li', function() {
          $('.selection-time .activer').removeClass('activer');
          $(this).addClass('activer')
          $("#time1sub").val($(this).val())
          $("#time2sub").val('')
          $("#date_demo3").text('请选择时间段')
        })
    
       //  .on('click','.screening-conditions .submitBtn button',function(){
     //      $(this).css('backgroundColor','#393e45')
       // })
   .on('click','.data-view',function(){
         $('#dataView').css('display','block')
   })
    .on('click','#Close',function(){
         $('#dataView').css('display','none')
   })

         .on('change','.inscreen input,.inscreen select',function(){

           $('.screening-conditions .submitBtn button').css('background','#e46045')
    })

    .on('click','.screening-conditions .submitBtn button',function(){
            $(this).css('backgroundColor','#393e45');
    })

  .on('click','#removerSub',function(){
    $('.inscreen select,.inscreen input').val('');

    
    $(".selection-time .activer").removeClass('activer');
    $(".selection-time li").eq(2).addClass('activer');
    return false;
     })

$("#Refresh,.data-refresh").click(function() {
     PieChartRendering()
    $('#dataView').css('display','none')
    });
}