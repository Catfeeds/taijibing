   

    $(function() {
      initProvince();
      initListener();
      RenderingAgent(agenty, $("#Agenty"))
      RenderingAgent(agentf, $("#Agentf"))
      RenderingAgent(devfactory, $("#devfactory"))
      RenderingAgent(investor, $("#investor"))
      RenderingAgent(factory, $("#factory"))
      Renderingdev(devbrand, $("#devbrand"))
      Renderingdev(devname, $("#devname"))
      Renderingdev(waterbrand, $("#waterbrand"))
      Renderingdev(watername, $("#watername"))
      initAddress();
      if (time1) {
        if (time1.length > 9) {
          $(".selection-time .activer").removeClass('activer');
               var _timeval = time1 + '到' + time2;
          $("#adddate").text(_timeval)
        } else {
          $(".selection-time .activer").removeClass('activer');
          $(".selection-time li").eq(time1 - 1).addClass('activer');
        }
      }
      $(document).on('click', '.selection-time li', function() {
          $('.selection-time .activer').removeClass('activer');
          $(this).addClass('activer')
          $("#time1sub").val($(this).val())
          $("#time2sub").val('')
        })
        // 同期渲染
      _hover($(".volumeHover"), $(".volumeHover-text"))
      _hover($(".compareHover"), $(".compareHover-text"))
      _hover($(".AverageHover"), $(".AverageHover-text"))
      _hover($(".pageHover"), $(".pageHover-text"))
      salesVolume(datas)

      // 折线图渲染
      var sales_status = datas[0].sales_status;
      var xin = sales_status.length || 7;
      var _date = []
      NumberDays(xin, _date)
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
  // 今天昨天渲染
    var timeVal = $(".selection-time .activer").val();


 // if (_date.length < 3) {
 //               _date = [];
 //              var   _dateX = [];
 //              var   _dateXdata = [];
 //              var _dataData=[];
 //                 for( var i=0; i<24;i++){
 //                   var date = (i)+":00"
 //                    _date.push(date)
 //                    _dataData.push("0")
 //                    for(var  y=0;y<_dateY.length;y++){
 //                          if(_dateY[y][0]==i){
 //                          _dataData[i]++
 //                      }
 //                      }
 //                   }
 //                sales_to=_dataData
               
 //            }

 // brokenLine(myChart,_date,sales_to)



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
                              console.log(_itmesum)
                          if(_itmesum==i){
                          daraxpdata[i]++
                      }
                      }
             }
          darax=daraxp;
          daray=daraxpdata


    }
    

    FoldLineDiagram(darax, daray)
      // 饼状图渲染
      mapCityBar(sales_status)
      var CustomerType = []
      var CustomerTypeNum = []
      for (var i = 0; i < sales_status.length; i++) {
        CustomerType.push(sales_status[i].CustomerType)
      }

      var CustomerTypeunique = CustomerType.unique();
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

      PieChart(CustomerTypeunique, CustomerTypeNum)
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
        var html = '<tr><td>' + j + '</td><td>' + item.UserName + '</td><td>' + item.Tel + '</td><td>' + item.DevNo + '</td>' + '<td>' + item.BarCode + '</td><td>' + item.FactoryName + '</td><td>' + item.water_brand + '</td><td>' + item.water_name + '</td><td>' + item.Volume + '</td>' + '<td>' + item.DevName + '</td><td>' + item.DevBrand + '</td><td>' + item.DevFactoryName + '</td><td>' + item.investor + '</td><td>' + item.AgentName + '</td>' + '<td>' + item.AgentPname + '</td><td>' + item.Province + '-' + item.City + '-' + item.Area + '</td><td>' + item.UseType + '</td><td>' + item.CustomerType + '</td><td>' + item.RowTime + '</td></tr>'
        $("#tableData").append(html);
      }




    })



    // 地图数据计算渲染方法
    function mapCityBar(sales_status) {
      var mapProvince = [];
      var mapCity = [];
      for (var j = 0; j < sales_status.length; j++) {
        mapProvince.push(sales_status[j].Province)
        mapCity.push(sales_status[j].City)
      }
      var mapProvinceNUm = mapProvince.unique()
      var mapProvincebox = []
      var progressBar = []
       $("#percentum").empty();

       console.log(mapProvinceNUm)
      for (var j = 0; j < mapProvinceNUm.length; j++) {
        mapProvincebox.push(0)
        for (var i = 0; i < mapProvince.length; i++) {
          if (mapProvinceNUm[j] == mapProvince[i]) {
            mapProvincebox[j]++
          }
        }
        progressBar.push(Math.round(mapProvincebox[j] / sales_status.length * 100))
               var html = '<div class="progress"><span class="name">' + mapProvinceNUm[j] + '</span>' + '<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressBar[j] + '%;">' + '<span class="">' + progressBar[j] + '%; </span>' + '</div>' + '</div>'
        $("#percentum").append(html);
      }
      var mapmapCityNUM = mapCity.unique()
      var mapCitybox = []
      var CityBar = []
      for (var j = 0; j < mapmapCityNUM.length; j++) {
        mapCitybox.push(0)

        for (var i = 0; i < mapCity.length; i++) {
          if (mapmapCityNUM[j] == mapCity[i]) {
            mapCitybox[j]++
          }

        }

        CityBar.push(Math.round(mapCitybox[j] / sales_status.length * 100))

      }


      map(mapProvincebox, mapCitybox, progressBar, CityBar, mapProvinceNUm, mapmapCityNUM)

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

    function salesVolume(data) {

      if (!data) {
        return;
      }
      var $data = data[0] || '';
      $("#sales1").text($data.sales1)
      if ($data.sales2 < 1) {
        $data.sales2 = 1;
        // var sales2 = Percentage($data.sales1, $data.sales2)+"%";
        // $("#sales2").text(sales2+"%")
      }
      var sales2 = Percentage($data.sales1, $data.sales2);

      if (sales2 < 0) {
        $("#sales2").text(sales2 + "%")
        $("#sales2").append('<img src="/static/images3/Arrowb.png" alt="">')
      } else if (sales2 > 0) {
        $("#sales2").text(sales2 + "%")
        $("#sales2").append('<img src="/static/images3/arrowA.png" alt="">')
      } else {
        $("#sales2").text(sales2 + "%")
        $("#sales2").append('<img src="/static/images3/rectangle.png" alt="">')
      }
      // $("#sales2").text(sales2+"%")

      $("#user_num").text($data.user_num)

      $("#sales_of").text(Percentage2($data.sales1, $data.user_num))


      $("#sales_of_year").text($data.sales_of_year)
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
        ClassText.css("display", "block");
      }, function() {
        ClassText.css("display", "none");
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


      initDevname($("#devname"), $("#devbrand"), devbrand)

      initDev($("#waterbrand"), $("#watername"), watername)

      initDevname($("#watername"), $("#waterbrand"), waterbrand)
        // 水容量渲染
      waternamechange()

    }

    function waternamechange() {


      $("#watername").on("change", function() {

        $("#watervolume").empty();
        $("#watervolume").append("<option value='' selected>请选择设备商品型号</option>");
        var _thisId = $('#watername option:selected').val();
        for (var index = 0; index < watervolume.length; index++) {
          var item = watervolume[index];

          if (_thisId == item.id) {

            $("#watervolume").append("<option value='" + item.id + "'>" + item.volume + "</option>");
          }
        }
      });
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
          Renderingdev($data, $Id2)
          return;
        }
        var _thisId = $(this).val();
        $Id2.empty();
        $Id2.append("<option value='' selected>请选择设备商品型号</option>");
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

    function initDevname($Id1, $Id2, $data) {

      $Id1.on("change", function() {
        if ($(this).val() == '') {
          Renderingdev($data, $Id2)
          return;
        }
        var _thisId = $('option:selected', this).attr("datei");
        $Id2.empty();
        $Id2.append("<option value='' selected>请选择设备品牌 </option>");
        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];

          // console.log(item)
          if (_thisId == item.BrandNo) {

            $Id2.append("<option value='" + item.BrandNo + "'selected = 'selected'>" + item.BrandName + "</option>");
          }


        }
        Renderingdev($data, $Id2)
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


    // 运营中心先选
    function initAgent($Id1, $Id2, $data) {
      $Id1.on("change", function() {
        if ($(this).val() == '') {
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
        if ($(this).val() == '') {
          RenderingAgent($data, $Id2)
          return;
        }
        var _thisId = $('option:selected', $Id1).attr("data");
        $Id2.empty();
        $Id2.append("<option value='' selected>请选择运营中心</option>");
        for (var i = 0; i < $data.length; i++) {
          var item = $data[i];
          if (_thisId == item.Id) {
            $Id2.append("<option value='" + item.Id + "' selected = 'selected'>" + item.Name + "</option>");
          }
        }
        RenderingAgent($data, $Id2)
      });
    }

    function initAddress() {
      $("#province").val(province);
      initCityOnProvinceChange();
      $("#city").val(city);
      initThree();

      $("#area").val(area);
      $("#Agenty").val(agenty_id);
      $("#Agenty").val(agenty_id);

      $("#devfactory").val(devfactory_id);
      $("#investor").val(investor_id);
      $("#factory").val(waterfactory_precode);
      $("#devbrand").val(devbrand_id);
      $("#devname").val(devname_id);
      $("#waterbrand").val(waterbrand_id);
      $("#watername").val(watername_id);
      $("#usetype").val(usetype);
      $("#customertype").val(customertype);
      if (water_volume) {
        $("#watervolume").empty();
        $("#watervolume").append("<option value='' selected>请选择设备商品型号</option>");
        var _thisId = $('#watername option:selected').val();
        for (var index = 0; index < watervolume.length; index++) {
          var item = watervolume[index];
          if (_thisId == item.id) {
            $("#watervolume").append("<option value='" + item.id + "'>" + item.volume + "</option>");
          }
        }
        $("#watervolume").val(water_volume);

      }

    }
    var pid = getAddressIddevbrand(devbrand_id, devbrand)
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
    $("#adddate").change(function() {
      $("#time1sub").val($("#adddate").val().split("到")[0]);
      $("#time2sub").val($("#adddate").val().split("到")[1]);
    })

    $(".inscreen li").click(function() {
      $("#time1sub").val($("#selectionTime  .activer").attr("value"));
      $("#time2sub").val('');
    })