<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/9/14
 * Time: 下午2:12
 */

namespace app\controllers;



use yii\base\Exception;
use yii\web\Controller;
use app\models\AgentInfo;
use yii\db\ActiveRecord;

class WaterShopController extends Controller
{

    public function actionList(){

        return $this->renderPartial("list");
    }
    public function actionGoodsList(){
        $agent_id=\Yii::$app->request->get('id');
        //获取商品数据(根据分类读取袋装水、茶吧机 )

        $waters=ActiveRecord::findBySql('select b.*,i.url from goods_info_base b JOIN goods_info_img i on b.id=i.goodsid and i.type=1 where b.EndTime > now() and b.startTime <= now()')->asArray()->all();
        //获取该商家信息
        $agent_info=ActiveRecord::findBySql("select * from agent_info where id='$agent_id'")->asArray()->all();

        return $this->renderPartial("goods_list",['waters'=>$waters,'agent_info'=>$agent_info]);
    }
    public function actionAgentList(){
    try{
        $lat=\Yii::$app->request->get('lat');
        $lng=\Yii::$app->request->get('lng');
        $where="level=5";
        $datas=AgentInfo::findBySql("select * from agent_info where $where")->asArray()->all();
//        var_dump($datas);exit;
        if(!$datas || !is_array($datas)){
            return $this->asJson(['status'=>-1,'msg'=>'获取数据失败!']);
        }
        //获取距离
        foreach($datas as &$data){
            $data['distance']=$this->getDistance($data['BaiDuLat'],$data['BaiDuLng'],$lat,$lng);
        }
        $kms=[];
        foreach($datas as $data){
            $kms[]=$data;
        }
        if(count($kms)>1){
            //排序
            foreach($kms as $key=>$km){
                $distance[$key] = $km['distance'];
            }
            array_multisort($distance,SORT_ASC,$kms);
        }

        return $this->asJson(['status'=>0,'data'=>$kms]);
    }catch (Exception $e){
        return $this->asJson(['status'=>-1,'msg'=>'获取数据失败!']);
    }

    }
    //计算距离
    public function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        if(empty($lat2)||empty($lng2)){
            return 9999;
        }
        $earthRadius = 6367000; //approximate radius of earth in meters
        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;
        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;
        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        return round($calculatedDistance/1000,2);
    }
}