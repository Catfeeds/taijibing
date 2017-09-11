<?php
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" href="/static/js/datepicker/dateRange.css"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/datepicker/dateRange.js"></script>
<div class="wrapper wrapper-content">
    <?= $this->render('/widgets/_ibox-title') ?>
        <table class="table table-hover" style="background:white;">
            <thead>
            <th>品牌</th>
            <th>每袋容量(L)</th>
            <th>使用条码</th>
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
                $str.= "<tr><td>".$val["BrandName"]."</td><td>".$val["Volume"]."</td><td>".$val["PrintAmount"]."</td><td>".$val["LeftAmount"]."</td><td>".$val["Volume"]*$val["PrintAmount"]."</td><td>".$val["Volume"]*$val["LeftAmount"]."</td><td>".$val["RowTime"]."</td></tr>";
            }
            echo $str;
            ?>
            </tbody>
        </table>
        <table>
            <th
        </table>

</div>

<?= LinkPager::widget(['pagination' => $pages]); ?>