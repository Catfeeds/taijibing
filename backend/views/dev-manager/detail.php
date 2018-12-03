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
        case 99:$desc="上传";break;
    }
    return $desc;
}
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
   <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
   <style type="text/css" media="screen">
       .table{
    position:relative;
    text-align: center;

}

 .tablehot{
width:5px;
height:5px;
background-color: #E46045;
border-radius: 50px;
margin-top: 10px;   
}
.table tbody  .tablehot{
    background-color: #4AD8D9;
}


   </style>
<div class="wrapper wrapper-content">
      <div style="float: left; margin-left: 20px;"><img src="/static/images3/sidebar.png" alt="搜索"><span class="font-size-S">&nbsp;设备动态详情</span></div>
    <div style="text-align: right;margin-bottom: 10px">

<!--      <?= \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-chevron-left"></span>返回',['dev-manager/dynamic'],['class'=>' btn btn-primary '])?> -->
         
              <a class="btn btn-primary" href="/index.php?r=dev-manager/dynamic<?=$url?>">返回</a>
     </div>
    <div class="condition" style="        padding-top: 40px;    height: 120px;">
     <form action="./?r=dev-manager/detail" method="post">


     	<label>时间段选择:</label><input type="text"  placeholder="请选择时间"  name="selecttime" id="selecttime" readonly  unselectable="on"  />
        
        <input  value="<?=$DevNo?>" type="hidden" name="DevNo" >
        <span style="padding-left:20px;">搜索内容：<input id="content" placeholder="请输操作类型" value="<?=$content?>" type="text" name="content"></span>


        <input type="submit" id='btn' value="搜索" >


     </form>

</div>

    <table class="table table-hover">
        <thead>
        <th> <p class="tablehot"></p> </th>
        <th>序号</th>
        <th>用户</th>
        <th>手机号</th>
        <th>设备编号</th>
        <th>最近操作</th>
        <th>用水量</th>
        <th>剩余水量</th>
        <th>TDS</th>
        <th>水温</th>
        <th>操作时间</th>
        <th><a id="sort" href="">上传时间</a></th>
        <th>设备商品型号</th>
        <th>设备品牌</th>
        <th>设备厂家</th>
        <th>设备投资商</th>
        <th>服务中心</th>
        <th>运营中心</th>
        <th>地区</th>
        <th>入网属性</th>
        <th>用户类型</th>
        </thead>
        <tbody>
        <?php
        $str='';
        $no=1;
//        $now=date('Y-m-d H:i:s',time());
        foreach($model as $key=>$val)
        {
            $str.= "<tr>
                        <th> <p class='tablehot'></p> </th>
                        <td>".$no."</td>
                        <td>".$val["Name"]."</td>
                        <td>".$val["Tel"]."</td>
                        <td>".$val["DevNo"]."</td>
                        <td>".(getActType($val["ActType"]))."</td>
                        <td>".(empty($val["WaterUse"])?"——":$val["WaterUse"])."</td>
                        <td>".($val["ActType"]==99?($val["WaterRest"]==''?"——":round($val["WaterRest"] ,2)):(empty($val["WaterRest"])?"——":round($val["WaterRest"] ,2)))."</td>
                        <td>".(empty($val["Dts"])?"——":$val["Dts"])."</td>
                        <td>".($val["Degrees"]==0.00?"——":$val["Degrees"])."</td>
                        <td>".($val["ActTime"]>$val["RowTime"]?$val["RowTime"]:$val["ActTime"])."</td>
                        <td>".$val["RowTime"]."</td>
                        <td>".$val["goodsname"]."</td>
                        <td>".$val["BrandName"]."</td>
                        <td>".$val["factoryname"]."</td>
                        <td>".$val["investor"]."</td>
                        <td>".$val["agentname"]."</td>
                        <td>".$val["agentpname"]."</td>
                        <td>".($val["Province"]."-".$val["City"]."-".$val["Area"])."</td>
                        <td>".($val["UseType"]?$UserType[$val["UseType"]]:'')."</td>
                        <td>".$CustomerType[$val["CustomerType"]]."</td>
                    </tr>";
            $no++;

        }
        echo $str;

        ?>
        </tbody>
    </table>
    <table>
<!--        <th-->
    </table>


</div>
<script type="text/javascript">
    var content='<?=$content?>';
    var selecttime='<?=json_encode($selecttime)?>';
 


    var DevNo=<?=$DevNo?>;
    var sort=<?=$sort?>;
    $(function(){
        var dateRange = new pickerDateRange('selecttime', {
            aRecent7Days : '', //最近7天
            isTodayValid : true,
            defaultText : '至',
            inputTrigger : 'selecttime',
            theme : 'ta',
            success : function(obj) {
            }
        });
    $("#selecttime").val('<?=$selecttime?>');
    });
    //排序
    $('#sort').click(function(){
        sort++;
        var content=$('#content').val();
        var selecttime=$('#selecttime').val();
        $(this).attr('href','./?r=dev-manager/detail&sort='+sort+'&content='+content+'&selecttime='+selecttime+'&DevNo='+DevNo);

    });
    $(function(){
        $('.pagination a').click(function(){

            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            var page_size=$('#page_size option:selected').val();

            var href=$(this).attr('href');

            $(this).attr('href',href+'&content='+content+'&sort='+sort+'&selecttime='+selecttime+'&DevNo='+DevNo+'&per-page='+page_size);
        });
    });


</script>



<?php
echo "";
echo "<dev style='float:left;margin-left: 50px    padding-bottom: 150px;'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=dev-manager/detail' id='butn'>确定</a></span>
</dev>"

?>
<script>
    //分页
    $('#page_size').val(<?=$page_size?>);
    $('#butn').click(function () {
        var content=$('#content').val();
        var selecttime=$('#selecttime').val();

        var page_size=$('#page_size option:selected').val();
        var pages=$('#pages').val();
//            alert(page_size);
        var href=$(this).attr('href');
        $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&selecttime='+selecttime+'&sort='+sort+'&DevNo='+DevNo);
        var href2=$(this).attr('href');
//            alert(href2);

    });
</script>

 
