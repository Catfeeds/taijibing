<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/23
 * Time: 17:51
 */
use feehi\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\AdminRoles;
use feehi\widgets\Bar;
use backend\models\LogicUserInfo;

$assignment = function($url, $model){
    return Html::a('<i class="fa fa-tablet"></i> '.yii::t('app', 'Assign Roles'), Url::to(['assign','uid'=>$model['id']]), [
        'title' => 'assignment',
        'class' => 'btn btn-white btn-sm'
    ]);
};

$this->title = "Admin";
?>
<link rel="stylesheet" type="text/css" href="./static/css/conmones.css">
<div class="row">
    <div class="col-sm-12">
        <form action="./?r=auth-user/authlist" method="post">
            搜索内容：<input id="search" placeholder="请输入账号、类型" value="<?=$content?>" type="text" name="content">


            <input type="submit" value="搜索" >
        </form>


        <div class="ibox">

            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => '{refresh}{delete}'
                ])?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'columns'=>[
                        [
                            'class' => 'feehi\grid\CheckboxColumn',
                        ],
                        [
                            'attribute'=>'id',
                            'label' => '平台Id',
                        ],

                        [
                            'attribute' => 'username',
                        ],
                        [
                            'attribute' => 'nickname',
                            'label' => '账户名称',
                            'value' => function($model){
                                return LogicUserInfo::getNickNameByRoleType($model);
                            },
                        ],

                        [
                            'attribute' => 'type',
                            'label'=>'账户类型',
                        ],

                        [
                            'attribute' => 'contactName',
                            'label' => '联系人',
                            'value' => function($model){
                                if($model->logic_type==0){
                                    return "--";
                                }
                                $user=LogicUserInfo::getLogicModel($model);
                                return $user["ContractUser"];
                            },
                        ],
                        [
                            'attribute' => 'contactTel',
                            'label' => '联系电话',
                            'value' => function($model){
                                if($model->logic_type==0){
                                    return "--";
                                }
                                $user=LogicUserInfo::getLogicModel($model);
                                return $user["ContractTel"];
                            },
                        ],

                        [
                            'attribute' => 'role',
                            'label' => '分配角色',
                            'value' => function($model){
                                return AdminRoles::getRoleNameByUid($model->id);
                            },
                        ],



                        [
                            'attribute' => 'created_at',
                            'format' => 'date',
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' => 'date',
                        ],

                        [
                            'class' => 'feehi\grid\ActionColumn',
                            'template' => '{assignment}',
                            'buttons' => ['assignment'=>$assignment],
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
