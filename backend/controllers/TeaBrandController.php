<?php
/**
 * Created by PhpStorm.
 * User: 12195
 * Date: 2017/8/23
 * Time: 16:21
 */

namespace backend\controllers;


use backend\models\TeaBrand;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class TeaBrandController extends BaseController
{

    public function getIndexData()
    {
        $query = TeaBrand::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return [
            'dataProvider' => $dataProvider,
        ];
    }

//茶吧机品牌首页
    public function actionList()
    {
        $datas =TeaBrand::allQuery();
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 5]);
        $querys =TeaBrand::pageQuery($pages->offset,$pages->limit);
        $model = $querys->asArray()->all();
        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    public function actionCreate()
    {
        $model = new TeaBrand();
        $model->setScenario('create');
        if ( \Yii::$app->getRequest()->getIsPost() ) {

            if($model->load(\Yii::$app->getRequest()->post())&&$model->validate()&&$model->createData()){

                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                \Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($brandno)
    {
        if(empty($brandno)){
            $this->jsonErrorReturn("参数错误");
            return;
        }
        $res=TeaBrand::deleteByBrandno($brandno);
        if($res===false){
            $this->jsonErrorReturn("操作错误,请稍后再试");
            return ;
        }
        $this->jsonReturn(["state"=>0]);

    }

}