<?php
/**
 * Created by PhpStorm.
 * User: 12195
 * Date: 2017/8/23
 * Time: 16:21
 */

namespace backend\controllers;


use backend\models\DevFactory;
use backend\models\Goods;
use backend\models\TeaBrand;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveRecord;

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
        //获取搜索内容
        $search=trim(\Yii::$app->request->post('content'));
        $where='';
        if(!empty($search)){
            $where=" and (goods.name like '%{$search}%' or tea_brand.BrandName like '%{$search}%' or dev_factory.Name  like '%{$search}%')";
        }



        $datas=ActiveRecord::findBySql("select goods.*,
            tea_brand.BrandName,tea_brand.BrandNo, dev_factory.Name as devfactory_name from goods
           JOIN tea_brand on goods.brand_id=tea_brand.BrandNo
           JOIN dev_factory on goods.factory_id=dev_factory.Id
           where goods.state=0 and goods.category_id=2 $where
           ");//state -1 表示已删除 0 正常   category_id 1：表示袋装水 2：茶吧机
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 5]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
//        var_dump($model);exit;
        return $this->render('list', [
            'search' => $search,
            'model' => $model,
            'pages' => $pages,
        ]);





//        $datas =TeaBrand::allQuery();
//        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 5]);
//        $querys =TeaBrand::pageQuery($pages->offset,$pages->limit);
//        $model = $querys->asArray()->all();
//        return $this->render('list', [
//            'model' => $model,
//            'pages' => $pages,
//        ]);
    }

    //创建商品
    public function actionCreate()
    {
        //茶吧机品牌
        $teabrand = (new TeaBrand())->find()->all();
        //茶吧机厂家
        $devfactory=DevFactory::find()->all();

        $goods=new Goods();

        $goods->setScenario('create');
        if ( \Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(\Yii::$app->getRequest()->post());
            $goods->addtime=time();
            $goods->stock=0;
            $goods->originalprice=0;
            $goods->saleprice=0;
            $goods->updatetime=0;
            $goods->state=0;
            $goods->category_id=2;//1为袋装水，2为茶吧机
//            var_dump($goods->goods_image1,$goods->goods_image2,$goods->goods_image3,$goods->goods_image4,$goods->goods_image5,$goods->goods_image6);exit;
            if($goods->validate()&&$goods->save()){

                \Yii::$app->getSession()->setFlash('success', \yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                \Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
            'teabrand' => $teabrand,
            'goods'=>$goods,
            'devfactory'=>$devfactory,
        ]);
    }


    //修改
    public function actionUpdate($id){
        if(!$id) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => \yii::t('app', "Id doesn't exit"),
        ]);
        //获取该商品信息
        $goods=Goods::findOne(['id'=>$id]);
        //茶吧机品牌
        $teabrand = (new TeaBrand())->find()->all();
        //茶吧机厂家
        $devfactory=DevFactory::find()->all();


        if(!$goods) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => \yii::t('app', "Id doesn't exit"),
        ]);

//        var_dump($goods);exit;

        $goods->setScenario('create');
        if ( \Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(\yii::$app->getRequest()->post());
            $goods->updatetime=time();

            if($goods->validate()&&$goods->save()){

                \Yii::$app->getSession()->setFlash('success', \yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                \Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
            'teabrand' => $teabrand,
            'goods'=>$goods,
            'devfactory'=>$devfactory,
        ]);

    }


    //删除
    public function actionDelete($id)
    {
        if(empty($id)){
            $this->jsonErrorReturn("参数错误");
            return;
        }
        $goods=Goods::findOne(['id'=>$id]);
        $goods->state=-1;//更改状态为-1
        $res=$goods->save(false);
        if($res===false){
            $this->jsonErrorReturn("操作错误,请稍后再试");
            return ;
        }
        $this->jsonReturn(["state"=>0]);

    }




    //添加品牌
    public function actionAdd()
    {
        $model = new TeaBrand();
        $model->setScenario('add');
        if (\Yii::$app->getRequest()->getIsPost()) {

            if ($model->load(\Yii::$app->getRequest()->post()) && $model->validate() && $model->createData()) {

                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
                return $this->redirect(['list']);
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                \Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);

    }

//    public function actionCreate()
//    {
//        $model = new TeaBrand();
//        $model->setScenario('create');
//        if ( \Yii::$app->getRequest()->getIsPost() ) {
//
//            if($model->load(\Yii::$app->getRequest()->post())&&$model->validate()&&$model->createData()){
//
//                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
//                return $this->redirect(['list']);
//            }else{
//                $errors = $model->getErrors();
//                $err = '';
//                foreach($errors as $v){
//                    $err .= $v[0].'<br>';
//                }
//                \Yii::$app->getSession()->setFlash('error', $err);
//            }
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

//    public function actionDelete($brandno)
//    {
//        if(empty($brandno)){
//            $this->jsonErrorReturn("参数错误");
//            return;
//        }
//        $res=TeaBrand::deleteByBrandno($brandno);
//        if($res===false){
//            $this->jsonErrorReturn("操作错误,请稍后再试");
//            return ;
//        }
//        $this->jsonReturn(["state"=>0]);
//
//    }

}