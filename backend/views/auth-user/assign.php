<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/11
 * Time: 22:34
 */
use feehi\widgets\ActiveForm;
?>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<div class="col-sm-12">
    <div class="ibox">

<!--        <div style="text-align: right;margin-bottom: 10px">  \yii\bootstrap\Html::a('返回',['auth-user/authlist'],['class'=>'btn btn-primary'])</div>-->
        <div style="text-align: right;margin-bottom: 10px"> 
            <!-- <?= \yii\bootstrap\Html::a('返回',['admin-user/index'],['class'=>'btn btn-primary'])?> -->
                      <a class="btn btn-primary" href="index.php?r=admin-user/index<?=$url?>">返回</a>    
                
            </div>
        <div class="ibox-content">

            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'role_id', ['labelOptions'=>['style'=>'display:none']])->radioList($roles) ?>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
