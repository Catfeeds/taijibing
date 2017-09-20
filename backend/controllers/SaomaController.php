<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/9
 * Time: 上午9:33
 */

namespace backend\controllers;

use backend\models\Address;
use backend\models\AgentInfo;
use backend\models\DevWaterScan;
use yii\data\Pagination;
use yii;
class SaomaController extends  BaseController
{
    public function actionList()
    {
        $province=yii::$app->request->post("province");
        $city=yii::$app->request->post("city");
        $area=yii::$app->request->post("area");
//        var_dump($province,$city,$area);exit;

        $selecttime=yii::$app->request->post("selecttime");
        $content=yii::$app->request->post("content");
//        $xname=yii::$app->request->post("xname");
//        $sname=yii::$app->request->post("sname");
//        $waterfname=yii::$app->request->post("waterfname");

        $datas = DevWaterScan::totalQuery($selecttime,$content,$province,$city,$area);
//        var_dump($content,$datas);exit;
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model =$this->listWrapData(DevWaterScan::pageQuery($pages->offset,$pages->limit,$selecttime,$content,$province,$city,$area)->asArray()->all());
//        var_dump($model);exit;
        $areas=Address::allQuery()->asArray()->all();


        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,
            'selecttime'=>$selecttime,
            'content'=>$content,
            'areas' =>$areas,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
        ]);
    }
    public function actionFlist()
    {
        $waterfname=yii::$app->request->get("waterfname");
        //根据水厂的名字获取id
        $waterfname_id=yii\db\ActiveRecord::findBySql("select id from factory_info where Name='{$waterfname}'")->asArray()->one()['id'];
        $datas = DevWaterScan::totalQuery2($waterfname_id);

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
//        var_dump($pages);exit;
//        $model =$this->listWrapData(DevWaterScan::pageQuery($pages->offset,$pages->limit,'','','',$waterfname)->asArray()->all());
        $model =$datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
//        var_dump($model);exit;
        return $this->render('flist2', [
            'model' => $model,
            'pages' => $pages,
        ]);




//        $waterfname=yii::$app->request->get("waterfname");
//        $datas = DevWaterScan::totalQuery('','','',$waterfname);
//        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
//        $model =$this->listWrapData(DevWaterScan::pageQuery($pages->offset,$pages->limit,'','','',$waterfname)->asArray()->all());
//        return $this->render('flist', [
//            'model' => $model,
//            'pages' => $pages,
//        ]);
    }
    public function listWrapData($list){

        $listTemp=[];
        foreach($list as $val){
            $agentId=$val["agentId"];
            if(empty($agentId)){
                continue;
            }
            $agentInfo=(new AgentInfo())->getAgentInfoById($agentId);
            if(empty($agentInfo)){
                continue;
            }
            if($agentInfo["Level"]==4){
                $val["agentpname"]=$agentInfo["LoginName"];
                $val["agentname"]="-";
            }else{
                //社区
                $parentId=$agentInfo["ParentId"];
                $val["agentname"]=$agentInfo["LoginName"];
                if(empty($parentId)){
                    $val["agentpname"]="-";
                }else{
                    $agentpInfo=(new AgentInfo())->getAgentInfoById($parentId);
                    $val["agentpname"]=$agentpInfo["LoginName"];

                }
            }
            $listTemp[]=$val;
        }
        return $listTemp;
    }

    //获取对应设备的扫码详情
    public function actionDetail(){
        $DevNo=$this->getParam("DevNo");
        $selecttime=yii::$app->request->post("selecttime");
//        $province=yii::$app->request->post("province");
//        $city=yii::$app->request->post("city");
//        $area=yii::$app->request->post("area");
        $content=yii::$app->request->post("content");

        $datas = DevWaterScan::totalQuery3($DevNo,$selecttime,$content);
//var_dump($datas);exit;
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model =$this->listWrapData(DevWaterScan::pageQuery3($DevNo,$pages->offset,$pages->limit,$selecttime,$content)->asArray()->all());

        $areas=Address::allQuery()->asArray()->all();

        return $this->render('detail', [
            'model' => $model,
            'DevNo' => $DevNo,
            'pages' => $pages,
            'selecttime'=>$selecttime,
            'content'=>$content,
//            'province'=>$province,
//            'city'=>$city,
//            'area'=>$area,
            'areas' =>$areas,
        ]);









    }



}