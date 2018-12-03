<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use yii\helpers\Url;
use feehi\widgets\ActiveForm;
use yii\bootstrap\Alert;

$this->title = "Admin";
?>
  <link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<style type="text/css" >
	.ibox-tools {

	float: right;
	margin-top: 0;
	position: relative;
	padding: 0;
	display:none;

	}
	.has-success .form-control{
	border:1px solid #fff;
	}
	.has-success .control-label{
	color:#B0B0BA;
	}
	body{
	width:100%;
	height:100%;
	overflow: auto;
	background-color: #1D1F23;
	color: #fff;
	}
	.form-control {
	background-color: #1d1f23;
	}
	.btn-white{
	display:none;
	}	

        
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => 64, 'disabled'=>'disabled']) ?>

                <div class="hr-line-dashed"></div>
                
                <?= $form->field($model, 'email')->textInput(['maxlength' => 64]) ?>


                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => 512]) ?>
                
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 512]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 512]) ?>
                <div class="hr-line-dashed"></div>
                <style>
				    .btn-white{
				        display: none;
				    }
				</style>
                <?= $form->defaultButtons() ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<!-- <div class="hr-line-dashed"></div>-->
<?php
//= $form->field($model, 'avatar')->imgInput(['width'=>'200px', 'baseUrl'=>yii::$app->params['admin']['url']])
?>

