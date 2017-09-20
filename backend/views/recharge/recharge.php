<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;
$this->title = "";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['logic-user/factory-list'],['class'=>'btn btn-primary'])?></div>

            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model, 'WaterBrand')->dropDownList(\yii\helpers\ArrayHelper::map($water_brands,'BrandNo','BrandName'),['prompt'=>'请选择']) ?>
                <?= $form->field($model, 'TotalMoney')->textInput(['id'=>'TotalMoney','maxlength' => 10]) ?>
                <input type="hidden" name="OrderSuccess[Fid]" value="<?=$fid ?>"/>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'OrderMoney')->textInput(['id'=>'OrderMoney','maxlength' => 11]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'CouponMoney')->textInput(['id'=>'CouponMoney','maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'Volume')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'Amount')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script>

    $('#CouponMoney').attr("readOnly","true");
    //自动计算优惠金额
    $('#TotalMoney').blur(function(){
        free()
    });
    $('#OrderMoney').blur(function(){
        free()
    });

    function free(){
        var t=$('#TotalMoney');
        var o=$('#OrderMoney');
        var TotalMoney=t.val();//应付
        var OrderMoney=o.val();//实付金额
        checknum(TotalMoney,t);
        checknum(OrderMoney,o);
        var CouponMoney=$('#CouponMoney').val(TotalMoney-OrderMoney);//优惠金额
    }

    function checknum(num,obj) {
        if (isNaN(num)) {
            alert("请输入数字");
            obj.val('');
            obj.focus();
            return false;
        }
    }



</script>
