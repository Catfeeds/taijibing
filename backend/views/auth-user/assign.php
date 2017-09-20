<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/11
 * Time: 22:34
 */
use feehi\widgets\ActiveForm;
?>
<div class="col-sm-12">
    <div class="ibox">

        <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['auth-user/authlist'],['class'=>'btn btn-primary'])?></div>
        <div class="ibox-content">

            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'role_id', ['labelOptions'=>['style'=>'display:none']])->radioList($roles) ?>
            <div class="hr-line-dashed"></div>
            <?= $form->defaultButtons() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>