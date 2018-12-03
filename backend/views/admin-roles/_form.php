<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/11
 * Time: 22:03
 */
use feehi\widgets\ActiveForm;

$this->title = "Roles";
?>

<style type="text/css" media="screen">
	.form-control:focus, .single-line:focus {
    border-color:  #e7eaec !important
}

.has-success .form-control {
    border-color: #e7eaec
}

.has-warning .form-control {
    border-color: #e7eaec
}

.has-error .form-control {
    border-color: #e7eaec
}

.has-success .control-label {
    color: #999C9E
}

.has-warning .control-label {
    color: #999C9E
}

.has-error .control-label {
    color:#999C9E
}
.btn-white {
    display: inline-block;
}

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['admin-roles/index'],['class'=>'btn btn-primary'])?></div>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(); ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'role_name')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'remark')->textInput(['maxlength' => 64]) ?>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

 