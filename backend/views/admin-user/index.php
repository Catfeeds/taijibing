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
        <div class="ibox">
        	
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => '{refresh} {create} {delete}'
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
                            'label'=>'平台Id',
                        ],

                        [
                            'attribute' => 'username',
                        ],
                        [
                            'attribute' => 'nickname',
                            'label'=>'账户名称',
                            'value' => function($model){
                                return LogicUserInfo::getNickNameByRoleType($model);
                            },
                        ],

                        [
                            'attribute' => 'role',
                            'label' => '账户类型',
                            'value' => function($model){
                                return AdminRoles::getRoleNameByUid($model->id);
                            },
                        ],

                        [
                            'attribute' => 'address',
                            'label'=>'所在地区',
                            'value' => function($model){
                                return LogicUserInfo::getAddressDes($model);
                            },
                        ],
                        [
                            'attribute' => 'contactName',
                            'label'=>'联系人',
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
                            'label'=>'联系电话',
                            'value' => function($model){
                                if($model->logic_type==0){
                                    return "--";
                                }
                                $user=LogicUserInfo::getLogicModel($model);
                                return $user["ContractTel"];
                            },
                        ],
//                        [
//                            'attribute' => 'address',
//                            'value' => function($model){
//                                return LogicUserInfo::getAddressDes($model);
//                            },
//                        ],



                        [
                            'attribute' => 'email',
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
                            'template' => '{assignment}{update}{delete}',
                            'buttons' => ['assignment'=>$assignment],
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>