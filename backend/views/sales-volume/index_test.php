<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<form action="/index.php?r=sales-volume/index" method="post">
<span style="padding-left:5px;display:inline-block">
                <label>地区:</label>
                 <select class="control-label" name="province"  id="province">
                     <option value="">请选择</option>
                 </select>
                <select class="control-label" name="city" id="city">
                    <option value="">请选择</option>
                </select>
                <select class="control-label" name="area" id="area">
                    <option value="">请选择</option>
                </select>
            </span>
    <input type="submit" value="提交">
    </form>
<script>
    var data=<?=json_encode($areas)?>;
    var agenty=<?=json_encode($agenty)?>;
    var agentf=<?=json_encode($agentf)?>;
    var devfactory=<?=json_encode($devfactory)?>;
    var investor=<?=json_encode($investor)?>;
    var devbrand=<?=json_encode($devbrand)?>;
    var devname=<?=json_encode($devname)?>;
    var factory=<?=json_encode($factory)?>;
    var waterbrand=<?=json_encode($waterbrand)?>;
    var watername=<?=json_encode($watername)?>;
    var watervolume=<?=json_encode($watervolume)?>;
    var datas=<?=json_encode($datas)?>;
</script>
<script>
//    console.log(agenty);
//    console.log(agentf);
//    console.log(devfactory);
//    console.log(investor);
//    console.log(devbrand);
//    console.log(devname);
//    console.log(factory);
//    console.log(waterbrand);
//    console.log(watername);
//    console.log(watervolume);
//    console.log(datas);


// $.get("sales-volume/get-datas",function(data){
//     // console.log(data);
// })

    initProvince();
    initListener();
    initAddress();


	    function initAddress() {
	        $("#province").val(province);
	        initCityOnProvinceChange();
	        $("#city").val(city);
	        initThree();
	        $("#area").val(area);
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
    function initListener() {
        $("#province").on("change", function () {
            initCityOnProvinceChange();
        });
        $("#city").on("change", function () {
            initThree();
        });
//    $("#queryBtn").on("click",function(){
//        query();
//    });
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
</script>