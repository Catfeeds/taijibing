
    $(function() {

      initProvince();
      initListener();
      RenderingAgent(agenty, $("#Agenty"))
      RenderingAgent(agentf, $("#Agentf"))
      RenderingAgent(devfactory, $("#devfactory"))
      RenderingAgent(investor, $("#investor"))
      RenderingAgentfactory(factory, $("#factory"))
      Renderingdev(devbrand, $("#devbrand"))
      Renderingdev(devname, $("#devname"))
      Renderingdev(waterbrand, $("#waterbrand"))
      Renderingdev(watername, $("#watername"))
   	  Renderingdevvolume(watervolumeDatanum,$("#watervolume"))
      initAddress(); 

   $(document).on('click', '.selection-time li', function() {
          $('.selection-time .activer').removeClass('activer');
          $(this).addClass('activer')
          $("#time1sub").val($(this).val())
          $("#time2sub").val('')
          $("#date_demo3").text('请选择时间段')
        })
   .on('click','.data-view',function(){
   	     $('#dataView').css('display','block')
   })
    .on('click','#Close',function(){
   	     $('#dataView').css('display','none')
   })

    .on('change','.inscreen input,.inscreen select',function(){
    	   $('.screening-conditions .referring button').css('background','#e46045')
    })

    .on('click','.screening-conditions .referring button',function(){
    	$(this).css('backgroundColor','#2D3136');
    })
  .on('click','#removerSub',function(){
    $('.inscreen select,.inscreen input').val('');
    $(".selection-time .activer").removeClass('activer');
    $(".selection-time li").eq(2).addClass('activer');
    return false;
     })

      if (time1) {
        if (time1.length > 9) {
          $(".selection-time .activer").removeClass('activer');
          var _timeval = time1 + '到' + time2;
           $("#date_demo3").text(_timeval)
           
        } else {
        	$("#date_demo3").text('选择时间段')
           $(".selection-time .activer").removeClass('activer');
           $(".selection-time li").eq(time1 - 1).addClass('activer');


        }
      }
              // 同期渲染
      _hover($(".volumeHover"), $(".volumeHover-text"))
      _hover($(".compareHover"), $(".compareHover-text"))
      _hover($(".AverageHover"), $(".AverageHover-text"))
      _hover($(".pageHover"), $(".pageHover-text"))
      salesVolume(datas)




      // 折线数据渲染
      var sales_status = datas[0].sales_status;
      var sales_statusXin=diy_time(time1,time2);
   		var timedatae=GetDateStr(0, 1);
  		var lop=1;
         if(time2!=null){
         	lop=  diy_time(time2,timedatae)
         }

       var xin = sales_statusXin|| 7;
         if(xin<3){
             var itmesum =[]
             for(var i=0;i<sales_status.length;i++){
              var itme=sales_status[i];
              var itmesumTer = itme.RowTime.split(" ")[1]
              itmesum.push( itmesumTer.replace(':', '.'))
            }
        var daraxp = [] 
        var   daraxpdata = [];
             for( var i=0; i<25;i++){
                var date = (i)+":00"
                  daraxp.push(date)
                  daraxpdata.push("0")
                    for(var  y=0;y<itmesum.length;y++){
                 
                         var _itmesum= itmesum[y].split(".")[0]
                         
                          if(_itmesum==i){
                          daraxpdata[i]++
                      }
                      }
             }
          darax=daraxp;
          daray=daraxpdata
       }else{

      var _date = []
      NumberDays(xin, _date, lop)
      var darax = _date;
      var daray = [];
      for (var i = 0; i < darax.length; i++) {
        daray.push(0)
        var daraxDate = Date.parse(darax[i]);
        for (var j = 0; j < sales_status.length; j++) {
          var nowDate = Date.parse(sales_status[j].Date);
          if (daraxDate == nowDate) {
            daray[i]++
          }
        }
       }
       }



  // 今天昨天渲染
    var timeVal = $(".selection-time .activer").val();
        if(timeVal<6){
        	       var xin =7;
          if(timeVal==3){
           xin = 7;
        }
       else if(timeVal==4){
           xin = 30;
        }
      else  if(timeVal==5){
          xin = 90;

      }
         var _date = []
            NumberDays(xin, _date,lop)
 
      var darax = _date;

      var daray = [];
      for (var i = 0; i < darax.length; i++) {
        daray.push(0)
        var daraxDate = Date.parse(darax[i]);
       
        for (var j = 0; j < sales_status.length; j++) {

          var nowDate = Date.parse(sales_status[j].Date);
           if (daraxDate == nowDate) {
                daray[i]++
           }
        }
      }
      if(timeVal<3){
            var itmesum =[]
             for(var i=0;i<sales_status.length;i++){
             var itme=sales_status[i];
             var itmesumTer = itme.RowTime.split(" ")[1]
             itmesum.push( itmesumTer.replace(':', '.'))
          }
         var daraxp = [] 
         var   daraxpdata = [];
             for( var i=0; i<25;i++){
                var date = (i)+":00"
                  daraxp.push(date)
                  daraxpdata.push("0")
                    for(var  y=0;y<itmesum.length;y++){
                         var _itmesum= itmesum[y].split(".")[0]
                          if(_itmesum==i){
                          daraxpdata[i]++
                         }
                      }
             }
          darax=daraxp;
          daray=daraxpdata
         }
        }
      FoldLineDiagram(darax, daray,'销量')
      mapCityBar(sales_status)



     // 饼状图渲染 
      var CustomerType = []
      var CustomerTypeNum = []
      for (var i = 0; i < sales_status.length; i++) {
        CustomerType.push(sales_status[i].CustomerType)
      }
       var CustomerTypeunique = unique(CustomerType);
 
      for (var i = 0; i < CustomerTypeunique.length; i++) {
        CustomerTypeNum.push(0)
        for (var j = 0; j < CustomerType.length; j++) {

          if (CustomerTypeunique[i] == CustomerType[j]) {
            CustomerTypeNum[i]++
          }
        }
      }
        for (var index = 0; index < CustomerTypeunique.length; index++) {
        if (CustomerTypeunique[index] == 1) {

          CustomerTypeunique[index] = "家庭"
        } else if (CustomerTypeunique[index] == 2) {
          CustomerTypeunique[index] = "集团"
        } else if (CustomerTypeunique[index] == 3) {
          CustomerTypeunique[index] = "公司"

        } else {
          CustomerTypeunique[index] = "其他"

        }
      }
     for (var i = 0; i < 4; i++) {
        if (CustomerTypeNum.length < 4) {
          if (!CustomerTypeNum[i]) {
            CustomerTypeNum.push(0)
          }
        }
      }
        for(var i=0;i<CustomerTypeNum.length;i++){
        		 $("#dataView tbody tr td:nth-child(2)").eq(i+1).text(CustomerTypeNum[i])
                var num =    Math.round( CustomerTypeNum[i]/ sales_status.length * 100)
                if(num){
                  $(".baifenbiA .baifenbi").eq(i).text(num) 
                } 
           }
     var $name= '用户类型销量占比'
      PieChart(CustomerTypeunique, CustomerTypeNum,$name)
    $("#Refresh,.data-refresh").click(function() {
     PieChart(CustomerTypeunique, CustomerTypeNum)
    $('#dataView').css('display','none')
    });

// 表格渲染
     var sales_detail = datas[0].sales_detail;

      var j = 0;
      for (var i = 0; i < sales_detail.length; i++) {
        var item = sales_detail[i]
        for (var z in item) {
          if (item[z] == null) {
            item[z] = '--'
          }
        }
        j++
        var  UseType = usetype(item.UseType )
        var  CustomerType = customertype(item.CustomerType )

        var html = '<tr><td>' + j + '</td><td>' + item.UserName + '</td><td>' + item.Tel + '</td><td>' + item.DevNo + '</td>' + '<td>' + item.BarCode + '</td><td>' + item.FactoryName + '</td><td>' + item.water_brand + '</td><td>' + item.water_name + '</td><td>' + item.Volume + '</td>' + '<td>' + item.DevName + '</td><td>' + item.DevBrand + '</td><td>' + item.DevFactoryName + '</td><td>' + item.investor + '</td><td>' + item.AgentName + '</td>' + '<td>' + item.AgentPname + '</td><td>' + item.Province + '-' + item.City + '-' + item.Area + '</td><td>' + UseType + '</td><td>' + CustomerType + '</td><td>' + item.RowTime + '</td></tr>'
        $("#tableData").append(html);
      }


  })
function diy_time(time1num,time2num){
	
    time1data = Date.parse(new Date(time1num));
 
    time2data = Date.parse(new Date(time2num));

    return  time3 = Math.abs(parseInt((time2data - time1data)/1000/3600/24))+1;

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
	   // 地图数据计算渲染方法
    function mapCityBar(sales_status) {
      var mapProvince = [];
      var mapCity = [];
      for (var j = 0; j < sales_status.length; j++) {
        mapProvince.push(sales_status[j].Province)
        mapCity.push(sales_status[j].City)
      }
      var mapProvinceNUm =unique(mapProvince)
      var mapCityNUm =unique(mapCity)
      var mapProvincebox = [];
      var mapCitybox = [];
      var progressBar = []

       $("#percentum").empty();
      var mapProvinceNUmColor =['#D29616','#4ADCDD','#C248DC','#EA5638','#D29717'];
 
      for (var j = 0; j < mapProvinceNUm.length; j++) {
        mapProvincebox.push({'key':mapProvinceNUm[j],'value':0,'tadal':sales_status.length})
        for (var i = 0; i < mapProvince.length; i++) {
          if (mapProvinceNUm[j] == mapProvince[i]) {
                 mapProvincebox[j].value++
          }
        }

        if(mapProvinceNUm[j] == null){
                mapProvinceNUm[j] ='其它'
             }
               progressBar.push(Math.round(mapProvincebox[j].value / sales_status.length * 100))

               var html = '<div class="progress" style="height:10px;    background-color: #1d1f23;"><span class="name" style="margin-top:-5px;left: 25px;">' + mapProvinceNUm[j] + '</span>' + '<div class="progress-bar"   role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressBar[j] + '%; background-color: '+mapProvinceNUmColor[j]+'">' + '</div>' 
               + '<span class="baifenbi" style="color: #fff; position: absolute;    right: 50px;right: 45px;margin-top: -5px;">' + progressBar[j] + '%'+ '</span> </div>'

         $("#percentum").append(html);
      }

 for (var i = 0; i < mapCityNUm.length; i++) {
          mapCitybox.push({'key':'0','value':0,'Province':'','tadal':0})
         for (var j = 0; j < sales_status.length; j++) {
             var mapCityLnumname = sales_status[j].Province
              if(mapCityNUm[i]==sales_status[j].City){
                      mapCitybox[i].value++
                      mapCitybox[i].key=mapCityNUm[i]
                      mapCitybox[i].Province= mapCityLnumname;
            }
          }
        };

 for (var i = 0; i < mapProvincebox.length; i++) {

         for (var j = 0; j < mapCitybox.length; j++) {
              if(mapProvincebox[i].key==mapCitybox[j].Province){
                   mapCitybox[j].tadal = mapProvincebox[i].value
             }
        }
 };
      map(mapProvinceNUm,mapProvincebox,mapCityNUm,mapCitybox,mapProvinceNUmColor)
      layer.close(ii);
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

    function NumberDays(xin, _date,_datenume) {
       var _datenume = _datenume-1||0;
      for (var i = -_datenume; i >= -xin-_datenume+1 ; i--) {
        _date.push(GetDateStr(i, 1))
      }
      _date.reverse();
      return _date;
    }
    function salesVolume(data) {

      console.log($data);
      if (!data) {
        return;
      }
      var $data = data[0] || '';
      $("#sales1").text($data.sales1)

        // if ($data.sales2 < 1) {
        //   $data.sales2 = 1;
        //    // var sales2 = Percentage($data.sales1, $data.sales2)+"%";
        //    // $("#sales2").text(sales2+"%")
        // }
      var sales2 = Percentage($data.sales1, $data.sales2);
    
      if (sales2 < 0) {
        $("#sales2").text(sales2 + "%")
        $("#sales2").append('<img src="/static/images3/Arrowb.png" alt="">')
      } else if (sales2 > 0) {
        $("#sales2").text(sales2 + "%")
        $("#sales2").append('<img src="/static/images3/arrowA.png" alt="">')
      } else {
        $("#sales2").text('持平')
        $("#sales2").append('<img src="/static/images3/rectangle.png" alt="">')
      }
      // $("#sales2").text(sales2+"%")

      $("#user_num").text($data.user_num)

      $("#sales_of").text(Percentage2($data.sales1, $data.user_num))


      $("#sales_of_year").text($data.sales_of_year)

      console.log(data.sales_of_year)
    }

    function Percentage(number1, number2) {
      return (Math.round((number1 / number2 - 1) * 10000) / 100.00); // 小数点后两位百分比
    }

    function Percentage2(number1, number2) {
      return (Math.round(number1 / number2)); // 小数点后两位百分比
    }

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

    function initListener() {
      $("#province").on("change", function() {
        initCityOnProvinceChange();
      });
      $("#city").on("change", function() {
        initThree();
      });
      initAgent($("#Agenty"), $("#Agentf"), agentf)
      initAgenty($("#Agentf"), $("#Agenty"), agenty)
      initDev($("#devbrand"), $("#devname"), devname)
      initDevname($("#devname"), $("#devbrand"), devbrand,devname)
      initDev($("#waterbrand"), $("#watername"), watername)
      initDevname($("#watername"), $("#waterbrand"), waterbrand,watername)
       // waternamechange()
        // 水容量渲染

     $("#waterbrand").change(function(){
         $("#watervolume").empty();
         $("#watervolume").append("<option value='' selected>请选择水容量</option>");

      })


$("#watername").on("change", function() {
	waternamechange()
})



    }
    function waternamechange() {
      // $("#watername").on("change", function() {
      	if ( $("#watername").val() == '') {
      		 $("#watervolume").empty();
             $("#watervolume").append("<option value='' selected>请选择水容量</option>");
             Renderingdevvolume(watervolumeDatanum,$("#watervolume"))
            return;
        }

        $("#watervolume").empty();
        $("#watervolume").append("<option value='' selected>请选择水容量</option>");
        var _thisId = $('#watername option:selected').text();

        var _thisdate = $('option:selected',$("#watername")).attr("datei"); 
        for (var index = 0; index < watervolume.length; index++) {
          var item = watervolume[index];
           if(item.brand_id==_thisdate  && item.name==_thisId){
                  $("#watervolume").append("<option value='" + item.volume + "'>" + item.volume + "</option>")
                   $("#watervolume").val(item.volume)
            }
        }


      // });
    }
var  watervolumeDatanum    =   unique2(watervolume)



	function Renderingdevvolume($data, $id) {

      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        var volume =  item.volume ; 

        $id.append("<option value='" + volume + "'>" + volume + "</option>");
      }
    }
function  unique2($data){
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

   // 商品选择 /水品牌 渲染
    function Renderingdev($data, $id) {
      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        var brand = item.BrandNo || item.brand_id
        var Name = item.name || item.BrandName
        if (item.id) {
          $id.append("<option value='" + item.id + "' datei =" + brand + ">" + Name + "</option>");
        } else {
          $id.append("<option value='" + brand + "'>" + Name + "</option>");
        }

      }
    }

    // 商品选择先选
    function initDev($Id1, $Id2, $data) {
      $Id1.on("change", function() {

        if ($(this).val() == '') {
            $Id2.empty();
 
        if($Id2.selector =='#watername'){
           $Id2.append("<option value='' selected>请选择</option>");
         }else{
           $Id2.append("<option value='' selected>请选择设备商品型号</option>");
         }
          Renderingdev($data, $Id2)
          return;
        }
        var _thisId = $(this).val();
        $Id2.empty();
 

        if($Id2.selector =='#watername'){
           $Id2.append("<option value='' selected>请选择水商品</option>");
         }else{
           $Id2.append("<option value='' selected>请选择设备商品型号</option>");
         }
       

        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];
          var brand = item.BrandNo || item.brand_id
          var Name = item.name || item.BrandName

            if (_thisId == brand) {
             if (item.id) {
              $Id2.append("<option value='" + item.id + "' datei =" + brand + ">" + Name + "</option>");
             } else {
              $Id2.append("<option value='" + brand + "'>" + Name + "</option>");
            }

          }
        }
      });
    }
    function initDevname($Id1, $Id2, $data,$dataname) {
      $Id1.on("change", function() {
        if ($(this).val() == '') {
           $Id2.empty();
        if($Id2.selector!='#devbrand'){
              $Id2.append("<option value='' selected>请选择水品牌 </option>");
        }else{
            $Id2.append("<option value='' selected>请选择设备品牌 </option>");
        }
          Renderingdev($data, $Id2)
          return;
        }
        var _thisId = $('option:selected', this).attr("datei");
        $Id2.empty();
        if($Id2.selector!='#devbrand'){
          $Id2.append("<option value='' selected>请选择水品牌 </option>");
        }else{
            $Id2.append("<option value='' selected>请选择设备品牌 </option>");
        }
          Renderingdev($data, $Id2)
        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];
          if (_thisId == item.BrandNo) {
              $Id2.val(_thisId)
        
              // $Id2.append("<option value='" + item.BrandNo + "'selected = 'selected'>" + item.BrandName + "</option>");

          }

        }
      
      });
    }

    // 角色选择渲染
    function RenderingAgent($data, $id) {
      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        if (item.ParentId) {
          $id.append("<option value='" + item.Id + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
        } else {
          $id.append("<option value='" + item.Id + "'>" + item.Name + "</option>");
        }
      }
    }
    // 角色水厂选择渲染
    function RenderingAgentfactory($data, $id) {
    	
      for (var index = 0; index < $data.length; index++) {
        var item = $data[index];
        if (item.ParentId) {
          $id.append("<option value='" + item.PreCode + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
        } else {
          $id.append("<option value='" + item.PreCode + "'>" + item.Name + "</option>");
        }
      }
    }
    // 运营中心先选
    function initAgent($Id1, $Id2, $data) {
      $Id1.on("change", function() {

        if ($(this).val() == '') {
               $Id2.empty();
        $Id2.append("<option value='' selected>请选择服务中心</option>");
             RenderingAgent($data, $Id2)
          return;
        }
        var _thisId = $(this).val();
        $Id2.empty();
        $Id2.append("<option value='' selected>请选择服务中心</option>");
        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];
          // if(item.ParentId){
          //   $Id2.append("<option value='" + item.Id + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
          //  }
          if (_thisId == item.ParentId) {

            $Id2.append("<option value='" + item.Id + "' data ='" + item.ParentId + "' >" + item.Name + "</option>");
          }
        }
      });
    }
    // 服务中心先选

    function initAgenty($Id1, $Id2, $data) {
      $Id1.on("change", function() {
      $Id2.empty();
        if ($(this).val() == '') {
            $Id2.empty();
        $Id2.append("<option value='' selected>请选择运营中心</option>");
          RenderingAgent($data, $Id2)
          return;
        }
        var _thisId = $('option:selected', $Id1).attr("data");
        $Id2.empty();
        $Id2.append("<option value='' selected>请选择运营中心</option>");
         RenderingAgent($data, $Id2)
        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];
          if (_thisId == item.Id) {
            $Id2.val(item.Id)
              // $Id2.append("<option value='" + item.Id + "' selected = 'selected'>" + item.Name + "</option>");
          }
        }
       
      });
    }	
    function initAddress() {
      $("#province").val(province);
      initCityOnProvinceChange();
      $("#city").val(city);
      initThree();
      $("#area").val(area);
      $("#Agenty").val(agenty_id);
      $("#Agentf").val(agentf_id);
      $("#devfactory").val(devfactory_id);
      $("#investor").val(investor_id);
      $("#factory").val(waterfactory_precode);
      $("#devbrand").val(devbrand_id);
      $("#devname").val(devname_id);
      $("#waterbrand").val(waterbrand_id);
      $("#watername").val(watername_id);
      $("#customertype").val(customertypea);
      $("#usetype").val(usetypea);
 		waternamechange()
      $("#time1sub").val(time1)
      $("#time2sub").val(time2)
      $("#watervolume").val(water_volume)
      $("#search").val(search)
    }
   // var pid = getAddressIddevbrand(devbrand_id, devbrand)
      // alert(pid)
    function getAddressIddevbrand(_name, data) {

      _name = $.trim(_name);
      if (_name == "") {
        return 0;
      }
      for (var index = 0; index < data.length; index++) {
        var item = data[index];
        var BrandNo = $.trim(item.BrandNo);


        if (BrandNo != "" && BrandNo == _name) {
          return item.BrandName;
        }
      }
      return 0;
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

    function initstate(data, $id) {
      var pid = getAddressIdByName($("#province").val());
      if (pid == 0) {
        return;
      }
      for (var index = 0; index < data.length; index++) {
        var item = data[index];
        if (item.PId != 0 && item.PId == pid) {
          $id.append("<option value='" + item.Name + "'>" + item.Name + "</option>");

        }
      }
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
    $(".inscreen li").click(function() {
    $('.screening-conditions .referring button').css('background','#e46045')
      $("#time1sub").val($("#selectionTime  .activer").attr("value"));
      $("#time2sub").val('');
    })
function  Get_datas(searchParameters){
	$.post("./index.php?r=sales-volume/get-datas", searchParameters, function(data){
              
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

			 var  UseType = usetype(item.UseType )
      var  CustomerType = customertype(item.CustomerType )

			var html = '<tr><td>'+j+'</td><td>'+item.UserName  +'</td><td>'+item.Tel+'</td><td>'+item.DevNo+'</td>'
						+'<td>'+item.BarCode+'</td><td>'+item.FactoryName+'</td><td>'+item.water_brand+'</td><td>'+item.water_name+'</td><td>'+item.Volume+'</td>'
						+'<td>'+item.DevName+'</td><td>'+item.DevBrand+'</td><td>'+item.DevFactoryName+'</td><td>'+item.investor+'</td><td>'+item.AgentName+'</td>'
						+'<td>'+item.AgentPname+'</td><td>'+item.Province+'-'+item.City+'-'+item.Area+'</td><td>'+UseType+'</td><td>'+CustomerType+'</td><td>'+item.RowTime+'</td></tr>'
					$("#tableData").append(html);
			}
	})
}