<?php
/**
 * Created by PhpStorm.
 * User: 12195
 * Date: 2017/8/22
 * Time: 9:47
 */

namespace backend\controllers;


use backend\models\AgentInfo;
use yii\db\ActiveRecord;
use yii\web\Controller;

class ShopController extends Controller
{
    public function actionIndex(){
        return $this->render('shop');
    }


    public function actionAgentList(){

        $search_content=null;
        $lon=null;
        $lat=null;
        $lat=\Yii::$app->request->get('lat');
        $lng=\Yii::$app->request->get('lng');
        $search_content=\Yii::$app->request->get('search_content');

//        $lng=104.111;
//        $lat=30.1333;

        if($lng==null || $lat==null){
            return ['status'=>0,'msg'=>'请获取定位'];
        }

        $where="level=5";//社区运营中心
        if($lng!=null && $lat!=null && $search_content!=null){
            $where.=" and Name Like '%$search_content%'";
        }
//        var_dump($where);exit;


        $datas=AgentInfo::findBySql("select * from agent_info where $where")->asArray()->all();
//        var_dump($datas);exit;
        if(!$datas || !is_array($datas)){
            return ['status'=>-1,'msg'=>'无法获取数据'];
        }
        //获取距离
        foreach($datas as &$data){
            $data['distance']=$this->getDistance($data['BaiDuLat'],$data['BaiDuLng'],$lat,$lng);
        }
//        var_dump($datas);exit;

        //获取20km以内的
        $kms=$datas;//恢复范围限定后删除此行
//        $kms=[];
//        foreach($datas as $data){
//            if($data['distance']<=20){
//                $kms[]=$data;
//            }
//        }

        if(count($kms)>1){
            //排序
            foreach($kms as $key=>$km){
                $distance[$key] = $km['distance'];
            }
            array_multisort($distance,SORT_ASC,$kms);
        }

//        var_dump($kms);exit;

        return ['status'=>1,'data'=>$kms];

    }



    //计算距离
    public function getDistance($lat1, $lng1, $lat2, $lng2)
    {

        $earthRadius = 6367000; //approximate radius of earth in meters

        /*
        Convert these degrees to radians
        to work with the formula
        */

        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;

        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;

        /*
        Using the
        Haversine formula

        http://en.wikipedia.org/wiki/Haversine_formula

        calculate the distance
        */

        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;

        return round($calculatedDistance/1000,2);
    }






    //进入某个店面后根据id获取该面对的信息
    public function actionGetAgent(){
        $agent_id=\Yii::$app->request->get('id');
        $agent_info=ActiveRecord::findBySql("select * from agent_info where id='$agent_id'")->asArray()->all();
        return $agent_info;
    }

    //获取该门店下的袋装水
    public function actionGetWater(){
        $agent_id=\Yii::$app->request->get('id');//该门店的id(暂时没用上)
        $waters=ActiveRecord::findBySql('select b.*,i.url from goods_info_base b JOIN goods_info_img i on b.id=i.goodsid and i.type=1 where b.EndTime > now() and b.startTime <= now()')->asArray()->all();
        //根据价格升序排
        if(count($waters)>1) {
            foreach ($waters as $key=>$water) {

                $price[$key] = $water['OriginalPrice'];
            }
            array_multisort($price,SORT_ASC,$waters);

        }
        return $waters;

    }


    //获取门店id返回商品页面
    public function actionGetGoods(){

        $agent_id=\Yii::$app->request->get('id');

        return $this->render('water',['agent_id'=>$agent_id]);
    }


    //获取省份信息
    function actionGetProvince(){
        $province=ActiveRecord::findBySql('select * from address_tree where PId=0')->asArray()->all();
        return $province;
    }

    //获取选择省份下的市信息
    function actionGetCity(){
        $pid=\Yii::$app->request->get('id');

        $city=ActiveRecord::findBySql("select * from address_tree where PId=$pid")->asArray()->all();
        return $city;
//        var_dump($city);
    }

    //获取选择市下的县的信息
    function actionGetCounty(){
        $pid=\Yii::$app->request->get('id');
        $county=ActiveRecord::findBySql("select * from address_tree where PId=$pid")->asArray()->all();
        return $county;
    }





    //获取商品
//    public function actionGetGoods(){
//
//        $agent_id=\Yii::$app->request->get('id');
////        var_dump($agent_id);exit;
////        $agent_id=7;
//        //获取商品数据(根据分类读取袋装水、茶吧机 )
//        $waters=ActiveRecord::findBySql('select b.*,i.url from goods_info_base b JOIN goods_info_img i on b.id=i.goodsid and i.type=1 where b.EndTime > now() and b.startTime <= now()')->asArray()->all();
//
//        //根据价格升序排
//        if(count($waters)>1) {
//            foreach ($waters as $key=>$water) {
//
//                $price[$key] = $water['OriginalPrice'];
//            }
//            array_multisort($price,SORT_ASC,$waters);
//
//        }
//
//
////        var_dump($waters);exit;
//        //获取该商家信息
//        $agent_info=ActiveRecord::findBySql("select * from agent_info where id='$agent_id'")->asArray()->all();
////var_dump($agent_info[0]['Name']);exit;
//        return $this->render('water',['waters'=>$waters,'agent_info'=>$agent_info]);
//    }



}