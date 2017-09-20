<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
<div class="wrapper wrapper-content">
    <div style="margin-bottom:10px;">
        <form method="post" action="/index.php?r=saoma/detail">
            <input type="hidden" name="DevNo" value="<?=$DevNo?>">
            <span style="padding-left:10px;"><label>搜索内容:</label><input type="text" placeholder="请输入水厂条码" name="content" value="<?=$content?>"/></span>
            <span style="padding-left:10px;"><label>时间段:</label><input type="text" placeholder="" name="selecttime" id="selecttime" /></span>
<!--            <span style="padding-left:5px;display:inline-block">-->
<!--                    <label>地区:</label>-->
<!--                     <select class="control-label" name="province"  id="province">-->
<!--                         <option value="" selected>请选择</option>-->
<!--                     </select>-->
<!--                    <select class="control-label" name="city" id="city">-->
<!--                        <option value="">请选择</option>-->
<!--                    </select>-->
<!--                    <select class="control-label" name="area" id="area">-->
<!--                        <option value="">请选择</option>-->
<!--                    </select>-->
<!--            </span>-->


            <input style="padding-left:10px;" type="submit" value="查询" id="btn"/>
        </form>
    </div>
    <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['saoma/list'],['class'=>'btn btn-primary'])?></div>
        <table class="table table-hover" style="background:white;">
            <thead>
            <th style="width: 45px">序号</th>
            <th style="width: 110px">水厂条码</th>
            <th style="width: 80px">设备编号</th>
<!--            <th>设备厂家</th>  <td>".$val["DevFactory"]."</td>-->
<!--            <th>县区运营中心</th><td>".$val["agentpname"]."</td> <td>".$val["agentname"]."</td>-->

<!--            <th>社区服务中心</th>-->
            <th style="width: 160px">所在区域</th>
            <th>位置信息</th>
            <th style="width: 80px">用户姓名</th>
            <th style="width: 60px">手机号</th>
<!--            <th>水厂</th>  <td>".$val["factoryName"]."</td>-->
            <th style="width: 100px">扫码时间</th>
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
                            <td>".$val["Province"]."-".$val["City"]."-".$val["Area"]."</td>
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

    <script>
//        var areas=<?//=json_encode($areas)?>//;
    </script>
<script type="text/javascript">
    $(function(){
        $("#query").on("click",function(){
//          var tel=$("#tel").val();
            var content=$("#content").val();
//            var province=$("#province").val();
//            var city=$("#city").val();
//            var area=$("#area").val();
//            window.location.href="/index.php?r=dev-manager/dynamic&content="+content+"&province="+province+"&city="+city+"&area="+area;
            window.location.href="/index.php?r=dev-manager/dynamic&content="+content;
        });
//        $("#province").on("change",function(){
//            onProvinceChange();
//        });
//        $("#city").on("change",function(){

//            onCityChange();
//        });
//        initProvince(0,$("#province"));
//        $("#province").val('<?//=$province?>//');
//        $("#city").val('<?//=$city?>//');
//        $("#area").val('<?//=$area?>//');
//        onProvinceChange();
//        onCityChange();





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

<?= LinkPager::widget(['pagination' => $pages]); ?>