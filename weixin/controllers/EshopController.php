<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/6/21
 * Time: 下午5:57
 */

namespace app\controllers;
use app\api\GoodsApi;
use yii;


class EshopController extends WxController
{
    public function beforeAction($action)
    {
        $this->checkOpenid();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
    public function actionGoodlist(){
        $cid=$this->getParam("cid");
        $title=$this->getParam("title");
        if(empty($title)){
            $title="";
        }
//        if(!$this->checkCustomerLogin()){
//            //未登录
//            yii::$app->session->set("last_url_params",$_GET);
//            yii::$app->session->set("last_url","/eshop/goodlist");
//            return $this->redirect(["/personal-center/login-page"]);
//        }
        $distid=$this->getParam("distid");
        if(empty($distid)){
            $distid="";
        }
        return $this->renderPartial("goodlist_c",[
            "title"=>"商品列表",
            "distid"=>$distid,
            "cid"=>$cid
        ]);
    }
    public function actionGoodsGet(){
        $categoryid=$this->getParam("categoryid");
        $skip=$this->getParam("skip");
        $take=$this->getParam("take");
        $disid=$this->getParam("disid");
        if(!empty($disid)){
            $postData["distid"]=$disid;
        }
        $postData["categoryid"]=$categoryid;
        $postData["skip"]=$skip;
        $postData["take"]=$take;
        $postData["lng"]=$this->getParam('lng');
        $postData["lat"]=$this->getParam('lat');
        $data=(new GoodsApi())->get($postData);
        $this->jsonReturn($data);
    }
    public function actionDetail(){
        $good_id=$this->getParam("id");
        $distidtemp=$this->getParam("distid");
        $distid=empty($distidtemp)?"":$distidtemp;

        if(empty($good_id)){
            return "参数错误";
        }
//        if(!$this->checkCustomerLogin()){
//            yii::$app->session->set("last_url","/eshop/detail");
//            yii::$app->session->set("last_url_params",$_GET);
//            return $this->redirect(["/personal-center/login-page"]);
//        }
        //商品id
        $data=(new GoodsApi())->detail($good_id,$distid);
        if($data->state!=0){
            return $data->desc;
        }
        $carnos=[];
        return $this->renderPartial("detail",["carnos"=>$carnos,"distid"=>$distid,"data"=>$data->result,"title"=>$data->result->title]);
    }
}