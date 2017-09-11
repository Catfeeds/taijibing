<?php
use yii\widgets\LinkPager;
?>
<div class="wrapper wrapper-content">
    <?= $this->render('/widgets/_ibox-title') ?>
        <table class="table table-hover" style="background:white;">
            <thead>
            <th>品牌</th>
            <th>应付金额</th>
            <th>支付金额</th>
            <th>优惠金额</th>
            <th>购买容量(L)</th>
            <th>购买数量</th>
            <th>总条码数量</th>
            <th>剩余条码数量</th>
            <th>操作时间</th>
            </thead>
            <tbody>
            <?php
            $str='';
            foreach($model as $key=>$val)
            {
                $str.= "<tr><td>".$val["BrandName"]."</td><td>".$val["TotalMoney"]."</td><td>".$val["OrderMoney"]."</td><td>".$val["CouponMoney"]."</td><td>".$val["Volume"]."</td><td>".$val["Amount"]."</td><td>".$val["total"]."</td><td>".$val["least"]."</td><td>".$val["RowTime"]."</td></tr>";
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