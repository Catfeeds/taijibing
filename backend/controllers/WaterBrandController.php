<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午2:21
 */

namespace backend\controllers;


use backend\models\FactoryInfo;
use backend\models\Goods;
use backend\models\WaterBrand;
use yii;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class WaterBrandController extends BaseController
{

    public function getModel($id='')
    {
        return WaterBrand::findOne(["BrandNo"=>$id]);
    }
    public function getIndexData()
    {
        $query = WaterBrand::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return [
            'dataProvider' => $dataProvider,
        ];
    }
    public function actionList()
    {
        $datas=yii\db\ActiveRecord::findBySql("select goods.*,
            water_brand.BrandName,water_brand.BrandNo, factory_info.Name as factory_name from goods
           JOIN water_brand on goods.brand_id=water_brand.BrandNo
           JOIN factory_info on goods.factory_id=factory_info.Id
           where goods.state=0 and goods.category_id=1
           ");//state -1 表示已删除 0 正常   category_id 1：表示袋装水 2：茶吧机
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 5]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
//        var_dump($model);exit;
        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,
        ]);




//        var_dump($datas);exit;




//        $datas =WaterBrand::allQuery();
//        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 5]);
//        $querys =WaterBrand::pageQuery($pages->offset,$pages->limit);
//        $model = $querys->asArray()->all();
//        return $this->render('list', [
//            'model' => $model,
//            'pages' => $pages,
//        ]);
    }
//    public function actionDelete($brandno)
//    {
//        if(empty($brandno)){
//                $this->jsonErrorReturn("参数错误");
//            return;
//        }
//        $res=WaterBrand::deleteByBrandno($brandno);
//        if($res===false){
//            $this->jsonErrorReturn("操作错误,请稍后再试");
//            return ;
//        }
//        $this->jsonReturn(["state"=>0]);
//
//    }

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





    //修改
    public function actionUpdate($id){
        if(!$id) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        //获取该商品信息
         $goods=Goods::findOne(['id'=>$id]);
        //水品牌
        $waterbrand = (new WaterBrand())->find()->all();
        //水厂
        $factory=FactoryInfo::find()->all();


        if(!$goods) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);

//        var_dump($goods);exit;

        $goods->setScenario('create');
        if ( Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(yii::$app->getRequest()->post());
            $goods->updatetime=time();

            if($goods->validate()&&$goods->save()){

                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
            'waterbrand' => $waterbrand,
            'goods'=>$goods,
            'factory'=>$factory,
        ]);




    }



    public function actionCreate()
    {
        //水品牌
        $waterbrand = (new WaterBrand())->find()->all();
        //水厂
        $factory=FactoryInfo::find()->all();


        $goods=new Goods();

        $goods->setScenario('create');
        if ( Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(yii::$app->getRequest()->post());
            $goods->addtime=time();
            $goods->category_id=1;//1为袋装水，2为茶吧机
//            var_dump($goods->goods_image1,$goods->goods_image2,$goods->goods_image3,$goods->goods_image4,$goods->goods_image5,$goods->goods_image6);exit;
            if($goods->validate()&&$goods->save()){

                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }

        return $this->render('create', [
                                            'waterbrand' => $waterbrand,
                                            'goods'=>$goods,
                                            'factory'=>$factory,
                                        ]);
    }



    //添加品牌
    public function actionAdd(){
        $model = new WaterBrand();
        $model->setScenario('add');
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

        return $this->render('add', [
            'model' => $model,
        ]);
    }



}