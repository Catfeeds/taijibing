<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/9/14
 * Time: 下午2:12
 */

namespace backend\controllers;



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
        //获取该商家添加的所有商品（袋装水、茶吧机）category_id=1 袋装水、2茶吧机
//        $goods=ActiveRecord::findBySql("select agent_goods.*,goods.category_id,goods.name,goods.goods_image1 from agent_goods join goods on agent_goods.goods_id=goods.id where agent_goods.goods_endtime > now() and agent_goods.goods_starttime < now() and agent_id=$agent_id")->asArray()->all();
        $goods=ActiveRecord::findBySql("select agent_goods.*,goods.category_id,goods.name,goods.goods_image1 from agent_goods join goods on agent_goods.goods_id=goods.id where agent_id=$agent_id")->asArray()->all();
        $waters=[];
        $teas=[];
        //（name:商品名称、realprice:卖价、originalprice:原价、goods_image1:商品图片）已售和商品描述没有
        foreach($goods as $good){
            if($good['category_id']==1){
                $waters[]=$good;
            }

            if($good['category_id']==2){
                $teas[]=$good;
            }
        }

        //获取门店信息(shop_name:门店名称、shop_detail:门店简介、image1:门店图片、Address:地址)
        $agent_info=ActiveRecord::findBySql("select agent_shop.*,agent_info.Address from agent_shop JOIN agent_info on agent_shop.agent_id=agent_info.id where agent_shop.agent_id=$agent_id")->asArray()->all();
        $tel=[$agent_info[0]['shop_tel1'],$agent_info[0]['shop_tel2']];
//var_dump($tel);exit;
//        $waters=ActiveRecord::findBySql('select b.*,i.url from goods_info_base b JOIN goods_info_img i on b.id=i.goodsid and i.type=1 where b.EndTime > now() and b.startTime <= now()')->asArray()->all();
        //获取该商家信息
//        $agent_info=ActiveRecord::findBySql("select * from agent_info where id='$agent_id'")->asArray()->all();

        return $this->renderPartial("goods_list",['waters'=>json_encode($waters),'teas'=>json_encode($teas),'agent_info'=>$agent_info,'tel'=>$tel]);
    }

    public function actionAgentList(){
    try{
        $lat=\Yii::$app->request->get('lat');
        $lng=\Yii::$app->request->get('lng');

        //从门店表获取门店信息(shop_name:门店名称、Address:地址、image1:门店图片)
        $datas=ActiveRecord::findBySql("select agent_shop.*,agent_info.Address,agent_info.BaiDuLat,agent_info.BaiDuLng from agent_shop JOIN agent_info ON agent_shop.agent_id=agent_info.Id where agent_shop.close_time > now() and agent_shop.open_time < now()")->asArray()->all();

//        $where="level=5";
//        $datas=AgentInfo::findBySql("select * from agent_info where $where")->asArray()->all();
//        var_dump($datas);exit;
        if(!$datas || !is_array($datas)){
            return $this->asJson(['status'=>-1,'msg'=>'获取数据失败!']);
        }


        //获取距离
        foreach($datas as &$data){
            $data['distance']=$this->getDistance($data['BaiDuLat'],$data['BaiDuLng'],$lat,$lng);
        }


        $kms=[];
        for($i=0;$i<count($datas);$i++){
            $kms[]=$datas[$i];
        }

        if(count($kms)>1){
            //排序
            foreach($kms as $key=>$km){
                $distance[$key] = $km['distance'];
            }
            array_multisort($distance,SORT_ASC,$kms);
        }
//        var_dump($kms);exit;
        return $this->asJson(['status'=>0,'data'=>$kms]);
//        return $this->asJson(['status'=>0,'data'=>$kms]);
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