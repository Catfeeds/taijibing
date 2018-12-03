<?php
use yii\widgets\LinkPager;
use feehi\widgets\Bar;
?>
 <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<style type="text/css" media="screen">
	 	#sub{
 		display: block;
    width: 150px;
    font-size: 15px;
    margin: auto;
    padding: 11px 20px;
    border-radius: 5px;
    color: #fff;
    background-color: #393e45;
 	}
</style>
<div class="wrapper wrapper-content">
    <div style="text-align: right;margin-bottom: 10px">
        <!-- <?=\yii\bootstrap\Html::a('返回',['dev-warning/already-handle'],['class'=>'btn btn-primary'])?> -->
                         <a class="btn btn-primary" href="index.php?r=dev-warning/already-handle<?=$url?>">返回</a>     
        </div>
    <h1 style="margin-left: 40px;color: red;">预警详情:</h1>
    <table class="table table-hover" style="width: 800px;margin: 0 auto">
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
            <td>处理时间</td>
            <td><?=date('Y-m-d H:i:s',$model['Handle_Time'])?></td>
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
            <td><textarea rows="4" cols="80" id="content2" ></textarea></td>
        </tr>
        <tr>
            <td>是否处理</td>
            <td >
                <input type="radio" name="act" <?= $model['State']==1?'checked':''?>  value="1">未解决
                <input type="radio" name="act" <?= $model['State']==2?'checked':''?> value="2">已解决
            </td>
        </tr>

    </table>
    <div style="text-align: center;margin: 20px auto"><a href="javascript:void(0);" id="sub">确定</a></div>

    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script>
        $('#sub').click(function() {

            var content=$.trim($('#content').val());
            var content2=$.trim($('#content2').val());

            if(content==''||content2==''){
                 layer.msg('请填写处理描述或解决描述');
            }else{
                var DevNo=<?=$model['DevNo']?>;
                var Type='<?=$model['Type']?>';
                var BarCode='<?=$model['BarCode']?>';
                var State=$("input[name='act']:checked").val();
                $.get('./?r=dev-warning/solve',{'DevNo':DevNo,'Type':Type,'State':State,'content':content,'content2':content2,'BarCode':BarCode},function(data){
                    console.log(data);
                    if(data==1){
                         layer.msg('保存成功');
                        window.location.replace("/index.php?r=dev-warning/index");
                    }
                    if(data==-1){
                        layer.msg('该数据不存在');
                        window.location.replace("/index.php?r=dev-warning/index");
                    }
                    if(data==0){
                        layer.msg('失败')
                    }
                });

            }

        });
    </script>
 