<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/10
 * Time: 上午10:44
 */

namespace backend\controllers;
use backend\models\OrderSuccess;
use yii;
use yii\data\Pagination;
use backend\models\WaterBrand;
error_reporting( E_ALL&~E_NOTICE );

class RechargeController extends BaseController
{
    public function actionIndex(){

    }
    public function actionCreate(){
        $model=new OrderSuccess();
        if(Yii::$app->request->getIsPost()){
            $model->setScenario("create");

            if($model->load(Yii::$app->request->post())&&$model->checkForm()&&$model->createOrder()){
                Yii::$app->getSession()->setFlash('success', "充值成功");
            }else{

                Yii::$app->getSession()->setFlash('error', "参数错误");
            }
        }
        $fid=Yii::$app->request->get("fid");
        if(empty($fid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
        }

        //获取水品牌
        $water_brands=WaterBrand::find()->all();

       return  $this->render("recharge",["fid"=>$fid,"model"=>$model,'water_brands'=>$water_brands]);
    }
    public function actionList(){
        $pid=Yii::$app->request->get("pid");
        if(empty($pid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
        $datas=OrderSuccess::all($pid);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $querys =OrderSuccess::pageQuery($pages->offset,$pages->limit,$pid);
        $model =$querys->asArray()->all();
        //获取对应品牌的条码总数和剩余数量
        foreach($model as &$v){
            if($v['WaterBrand']){
                $data=yii\db\ActiveRecord::findBySql("select * from factory_wcode where Fid='{$v['Fid']}' and WaterBrand='{$v['WaterBrand']}' and Volume={$v['Volume']}")->asArray()->all();
//            var_dump($data);exit;

                    $v['total']=$data[0]['Amount'];
                    $v['least']=$data[0]['LeftAmount'];

            }else{
                $v['total']=0;
                $v['least']=0;
            }



        }



        //根据BrandNo获取品牌名称
        foreach($model as &$v){
            if($v['WaterBrand']) {
                $data = yii\db\ActiveRecord::findBySql("select BrandName from water_brand where BrandNo='{$v['WaterBrand']}'")->asArray()->all();
//                var_dump($data);
//                exit;
                $v['BrandName'] = $data[0]['BrandName'];

            }else{
                $v['BrandName'] = '';
            }
        }

//        var_dump($model);exit;



        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,

        ]);
    }

}