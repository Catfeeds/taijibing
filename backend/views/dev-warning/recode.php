<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
 <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<div class="wrapper wrapper-content">

    <div style="text-align: right;margin-bottom: 10px"><a <?=$State==0?"href='./?r=dev-warning/detail&Id=$Id&DevNo=$DevNo&Type=$Type'":($State==1?"href='./?r=dev-warning/handle-detail&Id=$Id&DevNo=$DevNo&Type=$Type'":"href='./?r=dev-warning/solve-detail&Id=$Id&DevNo=$DevNo&Type=$Type'")?>>返回</a></div>
    <div style="margin-bottom:10px;">
        <form method="post" action="/index.php?r=dev-warning/recode">
            <input type="hidden" name="BarCode" value="<?=$BarCode?>">
            <input type="hidden" name="State" value="<?=$State?>">
            <input type="hidden" name="Id" value="<?=$Id?>">
            <input type="hidden" name="DevNo" value="<?=$DevNo?>">
            <input type="hidden" name="Type" value="<?=$Type?>">
            <span style="padding-left:10px;"><label>搜索内容:</label><input type="text" placeholder="请输入关键字" id="content" name="content" value="<?=$content?>"/></span>
            <span style="padding-left:10px;"><label>时间段:</label><input type="text" placeholder="" name="selecttime" id="selecttime" /></span>
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

            <input style="padding-left:10px;" type="submit" value="查询" id="btn"/>
        </form>
    </div>

    <table class="table table-hover" style="color:#B0B0BA">
        <thead>
        <th style="width: 4%">序号</th>
        <th style="width: 10%">水厂条码</th>
        <th style="width: 10%">设备编号</th>
        <th style="width: 8%">设备厂家</th>
        <th style="width: 8%">服务中心</th>
        <th style="width: 8%">运营中心</th>
        <th style="width: 8%">所在区域</th>
        <th style="width: 22%">位置信息</th>
        <th style="width: 6%">用户</th>
        <th style="width: 8%">手机号</th>
        <th style="width: 8%">扫码时间</th>
        </thead>
        <tbody>
        <?php
        $str='';
        $no=1;
        foreach($model as $key=>$val)
        {
            $str.= "<tr>
                        <td>".$no."</td>
                        <td>".$val["BarCode"]."</td>
                        <td>".$val["DevNo"]."</td>
                        <td>".$val["DevFactory"]."</td>
                        <td>".$val["AgentName"]."</td>
                        <td>".$val["ParentName"]."</td>
                        <td>".$val["Province"].'-'.$val["City"].'-'.$val["Area"]."</td>
                        <td>".$val["Address"]."</td>
                        <td>".$val["Name"]."</td>
                        <td>".$val["Tel"]."</td>
                        <td>".$val["RowTime"]."</td>
                     </tr>";
            $no++;
        }
        echo $str;
        ?>
        </tbody>
    </table>
    <table>

    </table>
    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script>
        var data=<?=json_encode($areas)?>;
        var province=<?=json_encode($province)?>;
        var city=<?=json_encode($city)?>;
        var area=<?=json_encode($area)?>;
        var BarCode=<?=json_encode($BarCode)?>;
        var State=<?=json_encode($State)?>;
        var id=<?=json_encode($id)?>;
        var DevNo=<?=json_encode($DevNo)?>;
        var Type=<?=json_encode($Type)?>;
        //        var areas=<?//=json_encode($areas)?>//;
        //        var sort=<?//=$sort?>//;
    </script>
    <script type="text/javascript">

        //排序
        //        $('#sort').click(function(){
        //            sort++;
        //
        //            var content=$('#content').val();
        //            var selecttime=$('#selecttime').val();
        //            var province=$('#province option:selected').val();
        //            var city=$('#city option:selected').val();
        //            var area=$('#area option:selected').val();
        //
        //            $(this).attr('href','./?r=saoma/list&sort='+sort+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&selecttime='+selecttime);
        //
        //        });


        $(function(){
            $('.pagination a').click(function(){

                var content=$('#content').val();
                var selecttime=$('#selecttime').val();
                var province=$('#province option:selected').val();
                var city=$('#city option:selected').val();
                var area=$('#area option:selected').val();
                var page_size=$('#page_size option:selected').val();

                var href=$(this).attr('href');

//                $(this).attr('href',href+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&sort='+sort+'&selecttime='+selecttime+'&per-page='+page_size);
                $(this).attr('href',href+'&content='+content+'&province='+province+'&city='+city+'&area='+area+'&selecttime='+selecttime+'&per-page='+page_size);
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
















        //    $(function(){
        //
        //        $("#query").on("click",function(){
        ////          var tel=$("#tel").val();
        //            var content=$("#content").val();
        //            var province=$("#province").val();
        //            var city=$("#city").val();
        //            var area=$("#area").val();
        //            window.location.href="/index.php?r=dev-manager/dynamic&content="+content+"&province="+province+"&city="+city+"&area="+area;
        //        });
        //        $("#province").on("change",function(){
        //            onProvinceChange();
        //        });
        //        $("#city").on("change",function(){
        //
        //            onCityChange();
        //        });
        //        initProvince(0,$("#province"));
        //        $("#province").val('<?//=$province?>//');
        //        $("#city").val('<?//=$city?>//');
        //        $("#area").val('<?//=$area?>//');
        //        onProvinceChange();
        //        onCityChange();
        //
        //
        //
        //
        //        var dateRange = new pickerDateRange('selecttime', {
        //            aRecent7Days : '', //最近7天
        //            isTodayValid : true,
        //            //startDate : '2013-04-14',
        //            //endDate : '2013-04-21',
        //            //needCompare : true,
        //            //isSingleDay : true,
        //            //shortOpr : true,
        //            defaultText : '至',
        //            inputTrigger : 'selecttime',
        //            theme : 'ta',
        //            success : function(obj) {
        ////                startTimeStr = obj.startDate;
        ////                endTimeStr = obj.endDate;
        //            }
        //        });
        //        $("#selecttime").val('<?//=$selecttime?>//');
        //    });
        //
        //
        //    function initProvince(){
        //        for(var index=0;index<areas.length;index++){
        //            var item=areas[index];
        //            if(item.PId==0){
        //                $("#province").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
        //            }
        //        }
        //    }
        //    function onProvinceChange(){
        //        var areaId=getAreaIdByName($("#province").val());
        //        emptySelect($("#city"),"请选择");
        //        initAddress(areaId,$("#city"));
        //    }
        //    function onCityChange(){
        //        var areaId=getAreaIdByName($("#city").val());
        //        emptySelect($("#area"),"请选择");
        //        initAddress(areaId,$("#area"));
        //    }
        //    function initAddress(_pid,_obj){
        //        if(areas.length==0){
        //            return;
        //        }
        //        for(var areaIndex=0;areaIndex<areas.length;areaIndex++){
        //            var area=areas[areaIndex];
        //            if(area.PId==_pid){
        //                $(_obj).append('<option value="'+area.Name+'">'+area.Name+'</option>');
        //            }
        //
        //        }
        //    }
        //    function emptySelect(_obj,_emptyLabel){
        //        $(_obj).empty();
        //        $(_obj).append('<option value="">'+_emptyLabel+'</option>');
        //    }
        //    function getAreaIdByName(_name){
        //        for(var areaIndex=0;areaIndex<areas.length;areaIndex++) {
        //            var area = areas[areaIndex];
        //            if(area.Name==_name){
        //                return area.Id;
        //            }
        //        }
        //        return -1;
        //    }




    </script>

</div>

<?php
echo "<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>";
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=dev-warning/recode' id='butn'>确定</a></span>
</dev>"

?>
<script>
    //分页
        $('#page_size').val(<?=$page_size?>);
        $('#butn').click(function () {
            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            var province=$('#province option:selected').val();
            var city=$('#city option:selected').val();
            var area=$('#area option:selected').val();

            var page_size=$('#page_size option:selected').val();
            var pages=$('#pages').val();
    //            alert(page_size);
            var href=$(this).attr('href');
            $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&selecttime='+selecttime+'&province='+province+'&city='+city+'&area='+area+'&Id='+id+'&DevNo='+DevNo+'&Type='+Type+'&BarCode='+BarCode+'&State='+State);
//            var href2=$(this).attr('href');
//                alert(href2);

        });
</script>