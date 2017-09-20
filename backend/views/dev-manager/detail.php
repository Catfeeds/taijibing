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
<div class="wrapper wrapper-content">

    <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['dev-manager/dynamic'],['class'=>'btn btn-primary'])?></div>
    <table class="table table-hover" style="background:white;">
        <thead>
        <th>序号</th>
        <th>设备编号</th>
        <th>最近操作</th>
        <th>用水量</th>
        <th>剩余水量</th>
        <th>TDS</th>
        <th>水温</th>
        <th>操作时间</th>
        <th>上传时间</th>
        </thead>
        <tbody>
        <?php
        $str='';
        $no=1;
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
        echo $str;

        ?>
        </tbody>
    </table>
    <table>
<!--        <th-->
    </table>


</div>

<?= LinkPager::widget(['pagination' => $pages]); ?>
