<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;
use backend\models\LogicUserInfo;

$this->title = "Admin";
?>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div style="text-align: right;margin-bottom: 10px"> <?= \yii\bootstrap\Html::a('返回',['auth-user/authlist'],['class'=>'btn btn-primary'])?></div>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <div class="form-group field-user-username required has-success">
                    <label class="col-sm-2 control-label" for="user-username">登录账号</label>
                    <div class="col-sm-10"><input type="text" id="user-username" class="form-control"  value="<?=$model->username?>"  disabled maxlength="64" aria-required="true" aria-invalid="false">
                        <div class="help-block m-b-none"></div></div>

                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group field-user-username required has-success">
                    <label class="col-sm-2 control-label" for="user-username">账户名称</label>
                    <div class="col-sm-10"><input type="text" id="user-username" class="form-control"  value="<?=LogicUserInfo::getNickNameByRoleType($model)?>"  disabled maxlength="64" aria-required="true" aria-invalid="false">
                        <div class="help-block m-b-none"></div></div>

                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group field-user-username required has-success">
                    <label class="col-sm-2 control-label" for="user-username">联系人</label>
                    <div class="col-sm-10"><input type="text" id="user-username" class="form-control"  value="<?php
                        if($model->logic_type==0){
                            echo "--";
                        }
                        $user=LogicUserInfo::getLogicModel($model);
                       echo $user["ContractUser"];
                        ?>"  disabled maxlength="64" aria-required="true" aria-invalid="false">
                        <div class="help-block m-b-none"></div></div>

                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group field-user-username required has-success">
                    <label class="col-sm-2 control-label" for="user-username">账户类型</label>
                    <div class="col-sm-10"><input type="text" id="user-username" class="form-control"  value="<?php


                        ?>"  disabled maxlength="64" aria-required="true" aria-invalid="false">
                        <div class="help-block m-b-none"></div></div>

                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group field-user-username required has-success">
                    <label class="col-sm-2 control-label" for="user-username">联系电话</label>
                    <div class="col-sm-10"><input type="text" id="user-username" class="form-control"  value="<?php
                        if($model->logic_type==0){
                            echo "--";
                        }
                        $user=LogicUserInfo::getLogicModel($model);
                        echo $user["ContractTel"];
                        ?>"  disabled maxlength="64" aria-required="true" aria-invalid="false">
                        <div class="help-block m-b-none"></div></div>

                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group field-user-username required has-success">
                    <label class="col-sm-2 control-label" for="user-username">账户类型</label>
                    <div class="col-sm-10"><input type="text" id="user-username" class="form-control"  value="<?php
                        $role="--";
                       switch($model->logic_type){
                           case 0 : $role="--";break;
                           case 1:$role="水厂";break;
                           case 2:$role="设备厂家";break;
                           case 3:$role="县区代理商";break;
                           case 4:$role="社区代理商";break;
                       }
                        echo $role;
                        ?>"  disabled maxlength="64" aria-required="true" aria-invalid="false">
                        <div class="help-block m-b-none"></div></div>

                </div>
                <div class="hr-line-dashed"><





                <?php ?>
<!--                --><?//= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

