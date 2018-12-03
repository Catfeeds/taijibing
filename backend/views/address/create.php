<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/11
 * Time: 22:02
 */
?>

    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css?v=1">

    <style type="text/css" media="screen">
       /* .chosen-container-single .chosen-search input[type="text"]{
            color:#000;
        }*/
        #w0 select{
            width:23%;
        }
    </style>
        <div class="col-sm-12" style="height:400px">
            <div class="ibox">
                <div class="ibox-title" style='height: 60px;'>
                    <div class="ibox-tools">
                        <a class="btn btn-xs" style= 'width: 50px; height: 30px; line-height: 30px; color: #fff;    background-color: #E46045;' href="/index.php?r=address%2Findex">返回</a></div>
                </div>
                <div class="ibox-content">
                    <form id="w0" class="form-horizontal" action="/index.php?r=address/create" method="post">
                        <div class="form-group field-user-username required ">
                         <div style="display: none">
                            <input type="text"  name="Address[Id]" id="addresses" value="1024578">
                         </div>
                         
                  <label  class="col-sm-2 control-label" style="padding-left:10px;">选择地区:</label>
                    <div class="col-sm-10"> 
                    <select class="control-label"  id="province" class="province">
                     
                    </select>
                    <select class="control-label" id="city"  class="city">
                        
                    </select>
                    <select class="control-label" id="area"  class="area">
                    
                    </select>
                  </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2" style='margin-top: 44px;'>
                                <button class="btn btn-primary" type="submit">保存</button>
                            </div>
                        </div>
                    </form>
                       <p style="clear:both "></p>
                </div>
            </div>
        </div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="./static/js/address.js"></script>

<script>
    var data=<?=$data?>;
</script>
<script>
    // $('#addresses').chosen({no_results_text: "没有找到",disable_search: true}); //初始化chosen    
var addresses=$('#addresses').val();
// alert(addresses)
    if(addresses==0&&address!=''){
        //填充省市的数据
//        var html='<option value="全国">全国</option>';
        var html='';
        $(address).each(function(){

            html += '<option value="'+this.name+'">'+this.name+'</option>';

        });
        $(html).appendTo('#address');

    }




var addressResolve = function (options) {
    //检测用户传进来的参数是否合法
    if (!isValid(options))
        return this;
    //默认参数
    var defaluts = {
        proId: 'province',
        cityId: 'city',
        areaId: 'area'
    };
    var opts = $.extend({}, defaluts, options);//使用jQuery.extend 覆盖插件默认参数
    var addressInfo = this;
    this.provInfo = $("#" + opts.proId);//省份select对象
    this.cityInfo = $("#" + opts.cityId);//城市select对象
    this.areaInfo = $("#" + opts.areaId);//区县select对象
    /*省份初始化方法*/
    this.provInfoInit = function () {
        var proOpts = "";
        $.each(options, function (index, item) {
            // console.log(item.PId)
           // proOpts += "<option value='" + item.ProID + "'>" + item.name + "</option>";
        if (item.PId == 0) {
            //$("#province").append();
            proOpts+="<option value='" + item.Name + "'>" + item.Name + "</option>"
        }
    });

    addressInfo.provInfo.append(proOpts);
    addressInfo.provInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    addressInfo.cityInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    addressInfo.areaInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    };
    /*城市选择绑定方法*/
    this.selectCity = function () {
        addressInfo.cityInfo.empty();
        addressInfo.cityInfo.append("<option value=>选择城市</option>");
        addressInfo.areaInfo.empty();
        addressInfo.areaInfo.append("<option value=>选择区县</option>");
        if (addressInfo.provInfo.val() == "") { //选择无效时直接返回
            addressInfo.cityInfo.trigger("liszt:updated");
            addressInfo.areaInfo.trigger("liszt:updated");
            return;
        }
        var poiuy = addressInfo.provInfo.val();//获取选择的省份值
        var provId = getAddressIdByName(poiuy)
        var cityOpts = "";
        $.each(options, function (index, item) {
            if (item.PId == provId) {
                cityOpts += "<option value='" + item.Name + "'>" + item.Name + "</option>";
            }
        });
   // alert(provId)
     // $("#addresses").val(provId)


        addressInfo.cityInfo.append(cityOpts);
        addressInfo.cityInfo.trigger("chosen:updated");
        addressInfo.areaInfo.trigger("chosen:updated");
    };
    /*区县选择绑定方法*/
    this.selectArea = function () {
        if (addressInfo.cityInfo.val() == "") return;
        addressInfo.areaInfo.empty();
        addressInfo.areaInfo.append("<option value=>选择区县</option>");

        var cityuy = addressInfo.cityInfo.val();//获取选择的城市值
          var cityId = getAddressIdByName(cityuy)
        var areaOpts = "";

        $.each(options, function (index, item) {
            if (item.PId == cityId) {
                areaOpts += "<option value='" + item.Name + "'>" + item.Name + "</option>";
            }
        });
   // alert(cityId)
        // $("#addresses").val(cityId)



        addressInfo.areaInfo.append(areaOpts);
        addressInfo.areaInfo.trigger("chosen:updated");
    };
        /*区县选择绑定方法*/
    this.selectarea = function () {
        if (addressInfo.areaInfo.val() == "") return;
        var area = addressInfo.areaInfo.val();//获取选择的城市值
          var areaId = getAddressIdByName(area)
     // alert(areaId)
      

         $("#addresses").val(areaId)

    }

    /*对象初始化方法*/
    this.init = function () {


        addressInfo.provInfo.append("<option value=''>选择省</option>");
        addressInfo.cityInfo.append("<option value=''>选择城市</option>");
        addressInfo.areaInfo.append("<option value=''>选择区县</option>");

        addressInfo.provInfoInit();
        addressInfo.provInfo.bind("change", addressInfo.selectCity);
        addressInfo.cityInfo.bind("change", addressInfo.selectArea);
        addressInfo.areaInfo.bind("change", addressInfo.selectarea);
            

    }
        init()
        function getAddressIdByName(_name) {
            _name = $.trim(_name);
            if (_name == "") {
                return 0;
            }
            for (var index = 0; index < options.length; index++) {
                var item = options[index];
                var name = $.trim(item.Name);
                if (name != "" && name == _name) {
                    return item.Id;
                }
            }
            return 0;
        }

    //私有方法，检测参数是否合法
    function isValid(options) {
        return !options || (options && typeof options === "object") ? true : false;
    }
}
  addressResolve(data)


    function getListByPid(pid){
            var temp=[];
            for(var index=0;index<data.length;index++){
                var item=data[index];
                if(item.PId!=0&&item.PId==pid){
                    temp.push(item);
                }
            }
        return temp;
    }


    $(".btn-primary").click(function(){
     var addresses =  $("#addresses").val()

     // alert(addresses)
  var province =  $("#province").val()
  var city =  $("#city").val()
  var area =  $("#area").val()

    if(!area){
          layer.msg('请选择完整地址');
          return false;
    }
     // $("#addresses").val(area)

     


         // return false;
    })


</script>
