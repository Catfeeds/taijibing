<?php
use yii\widgets\LinkPager;
?>
<div class="wrapper wrapper-content">
<!--    <a href="./?r=logic-user/factory-list">返回</a>-->
    <link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
    <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>


    <form method="post" action="/index.php?r=recharge/see">
        <input type="hidden" name="fid" value="<?=$fid?>">
        <input type="hidden" name="fid" value="<?=$fid?>">
        <span style="padding-left:10px;"><label>搜索内容:</label><input type="text" placeholder="请输品牌、名称" id="content" name="content" value="<?=$content?>"/></span>
<!--        <span style="padding-left:10px;"><label>时间段:</label><input type="text" placeholder="" name="selecttime" id="selecttime" /></span>-->
        <input style="padding-left:10px;" type="submit" value="查询" id=""/>
    </form>

    <div style="text-align: left;"> <?= \yii\bootstrap\Html::a('添加品牌',['recharge/create','fid'=>$fid,'state'=>1],['class'=>'btn btn-primary'])?></div>
   <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['logic-user/factory-list'],['class'=>'btn btn-primary'])?></div>


        <table class="table table-hover" style="background:white;">
            <thead>
            <th>品牌</th>
            <th>商品名称</th>
            <th><a id="sort2" href="">总条码数量</a></th>
            <th>使用条码</th>
            <th><a id="sort" href="">剩余条码数量</a></th>
            <th>使用容量(L)</th>
            <th>剩余容量(L)</th>
            <th>添加时间</th>
            <th>操作</th>
            </thead>
            <tbody>
            <?php
            $str='';
            foreach($model as $key=>$val)
            {
                $str.= "<tr>
                            <td>".$val["BrandName"]."</td>
                            <td>".$val["name"]."</td>
                            <td>".$val["Amount"]."</td>
                            <td>".$val["PrintAmount"]."</td>
                            <td>".$val["LeftAmount"]."</td>
                            <td>".$val["Volume"]*$val["PrintAmount"]."</td>
                            <td>".$val["Volume"]*$val["LeftAmount"]."</td>
                            <td>".$val["RowTime"]."</td>
                            <td><a href='./index.php?r=recharge/create&fid=$fid&BrandName={$val['BrandName']}&GoodsId={$val['GoodsId']}&Volume={$val['Volume']}&state=1'>充值</a>
                             删除</td>
                        </tr>";
            }
            echo $str;
            ?>
            </tbody>
        </table>
        <table>
            <th
        </table>

<?php
echo "<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>";
echo "<dev style='float:left;margin-top: 22px;margin-left: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=recharge/see&fid=$fid' id='butn'>确定</a></span>
</dev>"

    ?>




    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script>
        var sort=<?=$sort?>;
        var sort2=<?=$sort2?>;
        var fid=<?=$fid?>;
//        var page_size =><?//=$page_size?>//,
//        var page =><?//=$page?>//,
//        var content='<?//=$content?>//';
//        var selecttime='<?//=$selecttime?>//';

    </script>
    <script>

        $('#page_size').val(<?=$page_size?>);
        $('#butn').click(function () {
            var content=$('#content').val();
            var selecttime=$('#selecttime').val();

            var page_size=$('#page_size option:selected').val();
            var pages=$('#pages').val();
//            alert(page_size);
            var href=$(this).attr('href');
            $(this).attr('href',href+'&page='+pages+'&per-page='+page_size+'&content='+content+'&selecttime='+selecttime+'&sort='+sort);
            var href2=$(this).attr('href');
//            alert(href2);

        });






        //排序
        $('#sort').click(function(){
            sort++;
            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            $(this).attr('href','./?r=recharge/see&sort='+sort+'&fid='+fid+'&content='+content+'&selecttime='+selecttime);
//            alert($(this).attr('href'));

        });

        //排序
        $('#sort2').click(function(){
            sort2++;
            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            $(this).attr('href','./?r=recharge/see&sort2='+sort2+'&fid='+fid+'&content='+content+'&selecttime='+selecttime);
//            alert($(this).attr('href'));

        });


        $(function(){
            $('.pagination a').click(function(){

                var content=$('#content').val();
                var selecttime=$('#selecttime').val();

                var page_size=$('#page_size option:selected').val();
//                var pages=$('#pages').val();

                var href=$(this).attr('href');

                $(this).attr('href',href+'&content='+content+'&selecttime='+selecttime+'&sort='+sort+'&sort2='+sort2+'&fid='+fid+'&per-page='+page_size);
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





    </script>




</div>


<script>

</script>
