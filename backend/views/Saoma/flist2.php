<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>

   <link rel="stylesheet" href="./static/css/chosen.css"/>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
  <style type="text/css">
        
        .table td:first-child {
        border-left: 2px solid #E46045;
    }
    </style>
      <div style="padding:10px 30px">
		 <img src="/static/images3/sidebar.png" alt="" width=20 >
		 <span class="font-size-S">&nbsp;条码使用记录</span>
		 <div class="pull-right" style="text-align: right;margin-bottom: 10px"> 
            <!-- <?= \yii\bootstrap\Html::a('返回',['logic-user/factory-list'],['class'=>'btn btn-primary'])?> -->
                 <a class="btn btn-primary" href="/index.php?r=logic-user/factory-list<?=$url?>">返回</a>
                
            </div>
	</div>

    <div class="condition" style="margin:10px;padding: 30px 10px; margin-bottom: -20px;">
    	
      
    <form method="post" action="/index.php?r=saoma/flist">
        <input type="hidden" name="pid" value="<?=$pid?>">
        <input type="hidden" name="BrandName" value="<?=$BrandName?>">
        <input type="hidden" name="goodsname" value="<?=$goodsname?>">
        <input type="hidden" name="Volume" value="<?=$Volume?>">
             <input  style="display: none" type="text" name="real_search" value="1">
        <span style="padding-left:10px;"><label>时间段:</label><input type="text" placeholder="" name="selecttime" id="selecttime" /></span>
        <span style="padding-left:10px;"><label>品牌:</label><input type="text" placeholder="请输品牌" id="content" name="content" value="<?=$content?>"/></span>

        <input style="padding-left:10px;" type="submit" value="查询" id="btn"/>
    </form>

</div>
<div class="wrapper wrapper-content">

        <table class="table table-hover"  >
            <thead>
            <th>品牌</th>
            <th>商品名称</th>
<!--            <th>每袋容量(L)</th>-->
            <th><a id="sort2" href="">使用条码</a></th>
<!--            <th><a id="sort" href="">剩余条码</a></th>-->
            <th>剩余条码</th>
            <th>使用总容量(L)</th>
            <th>剩余总容量(L)</th>
            <th>使用时间</th>
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
                            <td>".$val["LeftAmount"]."</td>
                            <td>".$val["Volume"]*$val["Amount"]."</td>
                            <td>".$val["Volume"]*$val["LeftAmount"]."</td>
                            <td>".$val["EndTime"]."</td>
                        </tr>";
            }
            echo $str;
            ?>
            </tbody>
        </table>
        <table>
            <th>
        </table>


    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
    <script>
        var sort=<?=$sort?>;
        var sort2=<?=$sort2?>;
        var pid='<?=$pid?>';
        var BrandName='<?=$BrandName?>';
        var goodsname='<?=$goodsname?>';
        var Volume='<?=$Volume?>';
    </script>
    <script>
        //排序
        $('#sort').click(function(){
            sort++;
            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            $(this).attr('href','./?r=saoma/flist&sort='+sort+'&pid='+pid+'&BrandName='+BrandName+'&goodsname='+goodsname+'&Volume='+Volume+'&content='+content+'&selecttime='+selecttime);
//            alert($(this).attr('href'));

        });

        //排序
        $('#sort2').click(function(){
            sort2++;
            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            $(this).attr('href','./?r=saoma/flist&sort2='+sort2+'&pid='+pid+'&BrandName='+BrandName+'&goodsname='+goodsname+'&Volume='+Volume+'&content='+content+'&selecttime='+selecttime);
//            alert($(this).attr('href'));

        });


        $(function(){
            $('.pagination a').click(function(){

                var content=$('#content').val();
                var selecttime=$('#selecttime').val();
                var page_size=$('#page_size option:selected').val();

                var href=$(this).attr('href');

                $(this).attr('href',href+'&content='+content+'&selecttime='+selecttime+'&sort='+sort+'&sort2='+sort2+'&pid='+pid+'&BrandName='+BrandName+'&goodsname='+goodsname+'&Volume='+Volume+'&per-page='+page_size);
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

<?php
echo "";
echo "<from actio='./?r=logic-user/factory-list' method='post'><dev style='float:left;margin-top: 22px;margin-left: 50px'>每页显示：<select type='text' name='page_size' id='page_size' style='width:50px;'>
<option value='10'>10</option>
<option value='20'>20</option>
<option value='50'>50</option>
</select>条
&nbsp;&nbsp;&nbsp;&nbsp;共：$pages->totalCount 条
<span style='margin-left: 20px'>".LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 10 ])."</span>
&nbsp;&nbsp;&nbsp;&nbsp;<span style='margin-left: auto'>第：<input style='width: 50px' type='text' id='pages' name='pages' value='$page'>页
&nbsp;&nbsp;&nbsp;&nbsp;<a href='./?r=saoma/flist' id='butn'>确定</a></span>
</dev></from>"

?>
<script>
    $('#page_size').val(<?=$page_size?>);
        $('#page_size').chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
    $('#butn').click(function () {

            var content=$('#content').val();
            var selecttime=$('#selecttime').val();
            var page_size=$('#page_size option:selected').val();
            var pages=$('#pages').val();
//            alert(page_size);
            var href=$(this).attr('href');
            $(this).attr('href',href+'&page='+pages+'&pid='+pid+'&BrandName='+BrandName+'&goodsname='+goodsname+'&Volume='+Volume+'&per-page='+page_size+'&content='+content+'&selecttime='+selecttime+'&sort='+sort+'&sort2='+sort2);
//            var href2=$(this).attr('href');
//            alert(href2);
    })

</script>
