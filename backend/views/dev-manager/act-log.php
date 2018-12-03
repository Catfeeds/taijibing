<?php
use yii\widgets\LinkPager;
function getActType($type){
    $desc="";
    switch($type){
        case 1:$desc="开关机";break;
        case 2:$desc="调温";break;
        case 4:$desc="加热";break;
        case 8:$desc="消毒";break;
        case 16:$desc="抽水";break;
    }
    return $desc;
}

?>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
<div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['dev-manager/list','State'=>1],['class'=>'btn btn-primary'])?></div>

<div class="wrapper wrapper-content">

    <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('设备动态',['dev-manager/act-log','State'=>0,'DevNo'=>$DevNo],['class'=>'btn btn-primary','id'=>'btn0'])?>
        <?= \yii\bootstrap\Html::a('扫码记录',['dev-manager/act-log','State'=>1,'DevNo'=>$DevNo],['class'=>'btn btn-primary','id'=>'btn1'])?></div>


    <div class="form-group" >
        <form action="/index.php?r=dev-manager/act-log" method="post">
            <div class="col-sm-12" style="margin-bottom:20px;">
                <!--               <span><label>设备手机号:</label> <input name="tel" type="text" id="tel" placeholder="设备手机号" value="--><?//=$tel?><!--"/></span>-->
                <span style="padding-left:5px;"><label>搜索内容:</label><input name="content" type="text"  id="content" <?= $State==0?"placeholder='操作类型'":"placeholder='水厂条码'" ?> value="<?=$content?>"/></span>
                <span style="padding-left:10px;"><label>时间段:</label><input type="text" placeholder="" name="selecttime" id="selecttime" /></span>
                <input type="hidden" name="DevNo" value="<?=$DevNo?>">
                <!--                <span style="padding-left:5px;">地区</span>-->
<!--                <select name="province" id="province">-->
<!--                    <option value="">请选择</option>-->
<!--                </select>-->
<!--                <select name="city" id="city">-->
<!--                    <option value="">请选择</option>-->
<!--                </select>-->
<!--                <select name="area" id="area">-->
<!--                    <option value="">请选择</option>-->
<!--                </select>-->
                <!--                <button style="padding-left:10px;" class="btn-primary btn form-label" type="button" style="padding:0px;line-height:26px;height:26px;width:60px;" id="query">查询</button>-->
                <input type="submit" class="btn" value="查询" style="height:26px;line-height:14px;"/>
            </div>
        </form>
    </div>

    <table class="table table-hover" style="background:white;">
        <thead>
        <?php
        $header='';
        if($State==0){
            $header="<th style='width:6%'>序号</th>
                    <th style='width: 10%'>设备编号</th>
                    <th style='width: 10%'>最近操作</th>
                    <th style='width: 10%'>用水量</th>
                    <th style='width: 10%'>剩余水量</th>
                    <th style='width: 10%'>TDS</th>
                    <th style='width: 10%'>水温</th>
                    <th style='width: 17%'>操作时间</th>
                    <th style='width: 17%'>上传时间</th>";
        }else{
            $header="<th style='width: 5%'>序号</th>
                    <th style='width: 8%'>设备编号</th>
                    <th style='width: 9%'>水厂条码</th>
                    <th style='width: 9%'>水厂</th>
                    <th style='width: 8%'>商品容量(L)</th>
                    <th style='width: 8%'>所在区域</th>
                    <th style='width: 12%'>位置信息</th>
                    <th style='width: 8%'>用户</th>
                    <th style='width: 8%'>手机号</th>
                    <th style='width: 9%'>扫码时间</th>";
        }
        echo $header;
        ?>
        </thead>
        <tbody>
        <?php
        $str='';
        $no=1;
        if($State==0){
            foreach($model as $key=>$val)
            {
                $str.= "<tr>
                        <td>".$no."</td>
                        <td>".$val["DevNo"]."</td>
                        <td>".(getActType($val["ActType"]))."</td>
                        <td>".(empty($val["WaterUse"])?"——":$val["WaterUse"])."</td>
                        <td>".(empty($val["WaterRest"])?"——":round($val["WaterRest"] ,2))."</td>
                        <td>".(empty($val["Dts"])?"——":$val["Dts"])."</td>
                        <td>".(empty($val["Degrees"])?"":$val["Degrees"])."</td>
                        <td>".$val["ActTime"]."</td>
                        <td>".$val["ActEndTime"]."</td>
                    </tr>";
                $no++;

            }
        }else {
            foreach ($model as $key => $val) {
                $str .= "<tr>
                        <td>" . $no . "</td>
                        <td>" . $val["DevNo"] . "</td>
                        <td>" . $val["BarCode"] . "</td>
                        <td>" . $val["factoryName"] . "</td>
                        <td>" . $val["Volume"] . "</td>
                        <td>".$val["Province"]."-".$val["City"]."-".$val["Area"]."</td>
                        <td>".$val["Address"]."</td>
                        <td>" . $val["Name"] . "</td>
                        <td>" . $val["Tel"] . "</td>
                        <td>" . $val["RowTime"] . "</td>
                    </tr>";
                $no++;
            }
        }

        echo $str;

        ?>
        </tbody>
    </table>
    <table>
        <th
    </table>


</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script>
//    var data =<?//=json_encode($areas)?>//;
    //    var areas=<?//=json_encode($areas)?>//;
//    var province=<?//=json_encode($province)?>//;
//    var city=<?//=json_encode($city)?>//;
//    var area=<?//=json_encode($area)?>//;
//    var sort=<?//=$sort?>//;
var State=<?=$State?>;
</script>
<script>

//    initProvince();
//    initListener();
//    initAddress();
$(function(){
    //隐藏或显示（正常设备按钮）
    if(State==0){
        $('#btn0').css('background-color','#e6e6e6');
        $('#btn0').css('border-color','#e6e6e6');
        $('#btn0').attr('href','javascript:void(0);');

    }
    if(State==1){
        $('#btn1').css('background-color','#e6e6e6');
        $('#btn1').css('border-color','#e6e6e6');
        $('#btn1').attr('href','javascript:void(0);');
    }
});

    $(function(){
        $('.pagination a').click(function(){

            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&content='+content+'&selecttime='+selecttime+'&per-page='+page_size);
//                var href2=$(this).attr('href');
//                alert(href2)
        });
    });


$(function(){
    var dateRange = new pickerDateRange('selecttime', {
        aRecent7Days : '', //最近7天
        isTodayValid : true,
        //startDate : '2013-04-14',
        //endDate : '2013-04-21',
        //needCompare : true,
        //isSingleDay : true,
        //shortOpr : true,
        defaultText : '至',
        inputTrigger : 'selecttime',
        theme : 'ta',
        success : function(obj) {
//                startTimeStr = obj.startDate;
//                endTimeStr = obj.endDate;
        }
    });
    $("#selecttime").val('<?=$selecttime?>');
});



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

<?php
echo "<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>";
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=dev-manager/dynamic' id='butn'>确定</a></span>
</dev>"

?>
<script>
    //分页
    $('#page_size').val(<?=$page_size?>);
    $('#butn').click(function () {
        var content=$('#content').val();
        var province=$('#province option:selected').val();
        var city=$('#city option:selected').val();
        var area=$('#area option:selected').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort);
        var href2=$(this).attr('href');
//            alert(href2);

    });
</script>