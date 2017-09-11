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
        <span><label>水厂:</label><input type="text" placeholder="请输入水厂名称" name="waterfname" value="<?=$waterfname?>"/></span>
        <span style="padding-left:10px;"><label>县区运营中心:</label><input type="text" placeholder="请输入水厂名称" name="xname" value="<?=$xname?>"/></span>
        <span style="padding-left:10px;"><label>社区服务中心:</label><input type="text" placeholder="请输入水厂名称" name="sname" value="<?=$sname?>"/></span>
        <span style="padding-left:10px;"><label>时间段:</label><input type="text" placeholder="" name="selecttime" id="selecttime" /></span>
        <input style="padding-left:10px;" type="submit" value="查询" id="btn"/>
        </form>
    </div>
    <?= $this->render('/widgets/_ibox-title') ?>
        <table class="table table-hover" style="background:white;">
            <thead>
            <th>编号</th>
            <th>水厂条码</th>
            <th>设备编码</th>
            <th>设备厂家</th>
            <th>县区运营中心</th>
            <th>社区服务中心</th>
            <th>地址</th>
            <th>用户</th>
            <th>手机号</th>
<!--            <th>水厂</th>  <td>".$val["factoryName"]."</td>-->
            <th>最近扫码时间</th>
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
                            <td>".$val["agentpname"]."</td>
                            <td>".$val["agentname"]."</td>
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
            <th
        </table>
<script type="text/javascript">
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

<?= LinkPager::widget(['pagination' => $pages]); ?>