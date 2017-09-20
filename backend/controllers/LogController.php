<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 16/4/1
 * Time: 23:26
 */
namespace backend\controllers;

use yii;
use backend\models\AdminLogSearch;
use backend\models\AdminLog;

class LogController extends BaseController{

    public function actionIndex($user_id='')
    {
        $searchModel = new AdminLogSearch();

        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams(),$user_id);
//        var_dump($dataProvider);exit;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'user_id' => $user_id,
        ]);
    }

    public function actionView($id)
    {
        $model = AdminLog::findOne(['id'=>$id]);
        return $this->render('view', [
           'model' => $model,
        ]);
    }

    public function getModel($id = '')
    {
        return AdminLogSearch::findOne(['id'=>$id]);
    }

}