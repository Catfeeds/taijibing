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
        $urlobj = $this->getParam("Url");//返回参数记录
        $model=new OrderSuccess();
        if(Yii::$app->request->getIsPost()){
            $model->setScenario("create");

            if($model->load(Yii::$app->request->post())&&$model->checkForm()&&$model->createOrder()){
//                var_dump($model->WaterBrand);exit;

                Yii::$app->getSession()->setFlash('success', "充值成功");
                return $this->redirect(['logic-user/factory-list']);
            }else{


                Yii::$app->getSession()->setFlash('error', "请检查数据是否完整或有效");
            }
        }

        $BrandName=Yii::$app->request->get("BrandName");
        $goodsname=Yii::$app->request->get("goodsname");
        $Volume=Yii::$app->request->get("Volume");
        $fid=Yii::$app->request->get("fid");
        if(empty($fid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
//            $this->goBack();
           return $this->redirect(['logic-user/factory-list']);
        }

        //获取水品牌
        $water_brands=WaterBrand::find()->all();
        $brands=yii\db\ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=2")->asArray()->all();
//var_dump($brands);exit;
       return  $this->renderPartial("recharge",[  "fid"=>$fid,
                                           "model"=>$model,
                                           'water_brands'=>$water_brands,
                                           'BrandName'=>$BrandName,
                                           'goodsname'=>$goodsname,
                                           'Volume'=>$Volume,
                                           'brands'=>$brands,
                                            'url'=>$urlobj

                            ]);
    }

    //当选择品牌改变时获取对应商品
    public function actionGetGoods(){
        $BrandNo=$this->getParam('BrandNo');
        if(empty($BrandNo)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
        }
        $goods=yii\db\ActiveRecord::findBySql("select id,`name` from goods
where brand_id='$BrandNo' and category_id=1 and State=0 group by `name`")->asArray()->all();
        return $goods;
    }

    //当选择品牌改变时获取对应品牌的容量
    public function actionGetVolume(){
        $BrandNo=$this->getParam('BrandNo');
        $name=$this->getParam('name');
        if(empty($BrandNo)||empty($name)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
        }

        $volumes=yii\db\ActiveRecord::findBySql("select volume from goods
where brand_id='$BrandNo'and `name`='$name' and category_id=1 group by volume")->asArray()->all();
        return $volumes;
    }

    //查看品牌
    public function actionSee(){

        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }


        $content=addslashes($this->getParam("content"));
        $where='';
        if($content){
            $where=" (brands.BrandName like '%$content%' or goods.name like '%$content%') ";
        }

        $sort=$this->getParam("sort");//点击排序
        $sort2=$this->getParam("sort2");//点击排序
        if($sort==''){
            $sort=0;
        }
        if($sort2==''){
            $sort2=0;
        }

        //排序（剩余条码数）
        $order=' order by factory_wcode.LeftAmount asc';
        if($sort && $sort%2==0){//偶数 升序
            $order=" order by factory_wcode.LeftAmount asc";

        }
        if($sort && $sort%2==1){
            $order=" order by factory_wcode.LeftAmount desc";

        }

        //排序(总条码数)
        if($sort2 && $sort2%2==0){//偶数 升序
            $order=" order by factory_wcode.Amount asc";

        }
        if($sort2 && $sort2%2==1){
            $order=" order by factory_wcode.Amount desc";

        }



        $fid=$this->getParam('fid');
        if(empty($fid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
        }
        $datas=yii\db\ActiveRecord::findBySql("select factory_wcode.*,
brands.BrandName,goods.name
from factory_wcode
left join brands on brands.BrandNo=factory_wcode.WaterBrand
left join goods on goods.id=factory_wcode.GoodsId
where factory_wcode.Fid=$fid ".(empty($where)?'':'and'.$where)."$order"
);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
        $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
        return $this->render('see',
            [   'model'=>$model,
                'pages' => $pages,
                'sort' => $sort,
                'sort2' => $sort2,
                'fid' => $fid,
                'content' => $content,
                'page_size' => $page_size,
                'page' => $page,
            ]);


    }





    public function actionList(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

//var_dump($page,$page_size);exit;


        $content=addslashes($this->getParam("content"));
        $selecttime=$this->getParam("selecttime");//点击排序
        $sort=$this->getParam("sort");//点击排序
        $sort2=$this->getParam("sort2");//点击排序
        if($sort==''){
            $sort=0;
        }
        if($sort2==''){
            $sort2=0;
        }

//var_dump($sort,$sort2);
        $pid=$this->getParam("pid");
        $BrandName=$this->getParam("BrandName");
        $goodsname=$this->getParam("goodsname");
        $Volume=$this->getParam("Volume");
//        var_dump($pid);exit;
        if(empty($pid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            return $this->redirect(['logic-user/factory-list']);
        }
        if(empty($BrandName)||empty($goodsname)||empty($Volume)){
            Yii::$app->getSession()->setFlash('error', "请先充值");
            return $this->redirect(['logic-user/factory-list']);
        }
        $brand_id=yii\db\ActiveRecord::findBySql("select BrandNo from brands where BrandName='$BrandName'")->asArray()->one()['BrandNo'];
        $goods_id=yii\db\ActiveRecord::findBySql("select id from goods
where `name`='$goodsname' and volume=$Volume and brand_id='$brand_id'")->asArray()->one()['id'];
        $datas=OrderSuccess::all($pid,$brand_id,$goods_id,$Volume,$content,$selecttime,$sort,$sort2);

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);

//        $querys =OrderSuccess::pageQuery($pages->offset,$pages->limit,$pid);
//        $model =$querys->asArray()->all();
        $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
//        var_dump($model);exit;

        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,
            'sort' => $sort,
            'sort2' => $sort2,
            'content' => $content,
            'selecttime' => $selecttime,
            'page_size' => $page_size,
            'page' => $page,

            'pid' => $pid,
            'BrandName' => $BrandName,
            'goodsname' => $goodsname,
            'Volume' => $Volume,
            'url'=>$urlobj

        ]);
    }

}