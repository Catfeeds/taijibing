<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>
 <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<div class="wrapper wrapper-content">
    <div style="text-align: right;margin-bottom: 10px">
        <!-- <?=\yii\bootstrap\Html::a('返回',['dev-warning/already-solve'],['class'=>'btn btn-primary'])?> -->
         <a class="btn btn-primary" href="index.php?r=dev-warning/already-solve<?=$url?>">返回</a>    
            
        </div>
    <h1 style="margin-left: 40px;color: red;">预警详情:</h1>
    <table class="table table-hover" style="color:#B0B0BA; width: 800px;margin: 0 auto">
        <tr>
            <td>用户</td>
            <td><?=$model['Name']?></td>
        </tr>
        <tr>
            <td>手机号</td>
            <td><?=$model['Tel']?></td>
        </tr>
        <tr>
            <td>设备编号</td>
            <td><?=$model['DevNo']?></td>
        </tr>
        <tr>
            <td>预警类型</td>
            <td><?=$model['Type']?></td>
        </tr>
        <tr>
            <td>预警级别</td>
            <td><?php
                if($model["Level"]==3){echo '<span style="color: red">高<span>';}
                elseif($model["Level"]==2){echo '<span style="color: blue">中<span>';}
                elseif($model["Level"]==1){echo '<span style="color: blueviolet">低<span>';}
                ?>
            </td>
        </tr>
        <tr>
            <td>预警设备详情</td>
            <td><?=$model['Detail']?></td>
        </tr>
        <tr>
            <td>最近状态</td>
            <td><?=$model['LastStatus']?></td>
        </tr>
        <tr>
            <td>解决时间</td>
            <td><?=date('Y-m-d H:i:s',$model['Solve_Time'])?></td>
        </tr>
        <tr>
            <td>设备机型</td>
            <td><?=$model['DevType']?></td>
        </tr>
        <tr>
            <td>设备厂家</td>
            <td><?=$model['DevFactory']?></td>
        </tr>
        <tr>
            <td>处理描述</td>
            <td><textarea rows="4" cols="80" id="content" readonly="readonly"><?=$model['Handle_Description']?></textarea></td>
        </tr>
        <tr>
            <td>解决描述</td>
            <td><textarea rows="4" cols="80" id="content2" readonly="readonly" ><?=$model['Solve_Description']?></textarea></td>
        </tr>

    </table>
<!--    <div style="text-align: center;margin: 20px auto"><a href="javascript:void(0);" id="sub">确定</a></div>-->

    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script>
        $('#sub').click(function() {

            var content=$.trim($('#content').val());
            var content2=$.trim($('#content2').val());

            if(content==''||content2==''){
                alert('请填写处理描述或解决描述');
            }else{
                var DevNo=<?=$model['DevNo']?>;
                var Type='<?=$model['Type']?>';

                $.get('./?r=dev-warning/solve-detail',{'DevNo':DevNo,'Type':Type,'content':content,'content2':content2},function(data){
                    console.log(data);
                    if(data==1){
                        alert('保存成功');
                        window.location.replace("/index.php?r=dev-warning/index");
                    }
                    if(data==-1){
                        alert('该数据不存在');
                        window.location.replace("/index.php?r=dev-warning/index");
                    }
                    if(data==0){
                        alert('失败')
                    }
                });

            }

        });
    </script>

