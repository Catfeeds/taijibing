<?php
namespace app\controllers;

use yii\base\Exception;
use yii\web\Controller;
use yii\db\ActiveRecord;
//母婴店
class MotherAndBabyShopController extends WxController{

    public function actionShopList(){
        $lat=\Yii::$app->request->get('lat');
        $lng=\Yii::$app->request->get('lng');
        //权限参数（获取坐标）
        $power_data=$this->GetSignPackage();
        return $this->renderPartial("shop-list",['lat'=>$lat,'lng'=>$lng,'power_data'=>json_encode($power_data)]);
    }

    //ajax 获取微信权限参数
//    public function actionGetPowerData(){
//        //权限参数（获取坐标）
//        $power_data=$this->GetSignPackage();
//        return json_encode($power_data);
//    }

    //ajax获取门店列表数据
    public function actionGetShopListData(){
        try{
            $lat=\Yii::$app->request->get('lat');
            $lng=\Yii::$app->request->get('lng');
            if(!$lat||!$lng){
                return $this->asJson(['state'=>-1,'msg'=>'参数错误']);
            }

            //从门店表获取门店信息(shop_name:门店名称、Address:地址、image1:门店图片)
            $datas=ActiveRecord::findBySql("select mother_baby_shop.shop_name,
            mother_baby_shop.agent_id,mother_baby_shop.image1,
            agent_info.Address,agent_info.BaiDuLat,agent_info.BaiDuLng
            from mother_baby_shop
            JOIN agent_info ON mother_baby_shop.agent_id=agent_info.Id
            where mother_baby_shop.close_time > now()
            and mother_baby_shop.open_time < now()")->asArray()->all();

            if(!$datas || !is_array($datas)){
                return $this->asJson(['state'=>-1,'msg'=>'获取数据失败!']);
            }


            //获取距离
//            $new_datas=[];
            foreach($datas as $key=>&$data){
                $data['distance']=$this->getDistance($data['BaiDuLat'],$data['BaiDuLng'],$lat,$lng);
//                if($data['distance']<=10){//10公里内的
//                    $new_datas[]=$data;
                    $distance[$key] = $data['distance'];
//                }
            }

            if(count($datas)>1){
                //排序
                array_multisort($distance,SORT_ASC,$datas);
            }
            return $this->asJson(['state'=>0,'data'=>$datas]);
        }catch (Exception $e){
            return $this->asJson(['state'=>-1,'msg'=>'获取数据失败!']);
        }

    }

    //进入某个门店的首页
    public function actionShopSite(){
        $lat=\Yii::$app->request->get('lat');
        $lng=\Yii::$app->request->get('lng');
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        return $this->renderPartial("shop-site",['agent_id'=>$agent_id,'lat'=>$lat,'lng'=>$lng]);
    }

    //ajax获取对应门店详情
    public function actionGetShopDetail(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        if(!$agent_id){
            return $this->asJson(['state'=>-1,'msg'=>'参数错误']);
        }
        //获取门店信息(shop_name:门店名称、shop_detail:门店简介、image1:门店图片、Address:地址)
        $shop_info=ActiveRecord::findBySql("select mother_baby_shop.shop_name,
        mother_baby_shop.agent_id,mother_baby_shop.image1,agent_info.Address,
         mother_baby_shop.shop_detail,mother_baby_shop.morning,mother_baby_shop.night
        from mother_baby_shop
        inner JOIN agent_info on mother_baby_shop.agent_id=agent_info.id
        where mother_baby_shop.agent_id=$agent_id")->asArray()->one();
        return $this->asJson(['state'=>0,'data'=>$shop_info]);

    }

    //ajax获取首页的一级分类数据
    public function actionGetCategory(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        $category_id=\Yii::$app->request->get('category_id');//分类id
        if(!$agent_id){
            return $this->asJson(['state'=>-1,'msg'=>'参数错误']);
        }
        //根据该门店下的商品，获取对应的商品一级分类
        $data=ActiveRecord::findBySql("select DISTINCT goods_category.Id,goods_category.Name
        from mother_baby_goods
        inner join goods on mother_baby_goods.goods_id=goods.id
        inner join goods_category on goods_category.id=goods.category_id
        where mother_baby_goods.agent_id=$agent_id
        ")->asArray()->all();
        return $this->asJson(['state'=>0,'data'=>$data,'category_id'=>$category_id]);

    }

    //ajax获取热销商品(热销）
    public function actionGetHotGoods(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        $category_id=\Yii::$app->request->get('category_id');//一级分类
        if(!$agent_id){
            return $this->asJson(['state'=>-1,'msg'=>'参数错误']);
        }
        $str='';
        if($category_id){
            $str="and goods.category_id=$category_id";
        }
        $goods=ActiveRecord::findBySql("select mother_baby_goods.goods_id,
        goods.name,mother_baby_goods.realprice,goods_image.goods_image1
        from mother_baby_goods
        inner JOIN goods on mother_baby_goods.goods_id=goods.id
        inner JOIN goods_image on mother_baby_goods.goods_id=goods_image.goods_id
        where mother_baby_goods.agent_id=$agent_id $str limit 0,4")->asArray()->all();
        return $this->asJson(['state'=>0,'data'=>$goods]);
    }

    //ajax 获取首页对应门店的商品(精品)
    public function actionGetGoodsData(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        $category_id=\Yii::$app->request->get('category_id');//一级分类
        if(!$agent_id){
            return $this->asJson(['state'=>-1,'msg'=>'参数错误']);
        }
        $str='';
        if($category_id){
            $str="and goods.category_id=$category_id";
        }
        $goods=ActiveRecord::findBySql("select mother_baby_goods.goods_id,
        goods.name,mother_baby_goods.realprice,goods_image.goods_image1
        from mother_baby_goods
        inner JOIN goods on mother_baby_goods.goods_id=goods.id
        inner JOIN goods_image on mother_baby_goods.goods_id=goods_image.goods_id
        where mother_baby_goods.agent_id=$agent_id $str")->asArray()->all();
        //取前4个作为热销
        return $this->asJson(['state'=>0,'data'=>$goods]);

    }

    //商品详情页面
    public function actionGoodsDetail(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        $goods_id=\Yii::$app->request->get('goods_id');//商品id
        return $this->renderPartial("goods-detail",['goods_id'=>$goods_id,'agent_id'=>$agent_id]);

    }
    //ajax获取商品的详情
    public function actionGetGoodsDetail(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        $goods_id=\Yii::$app->request->get('goods_id');//商品id
        if(!$agent_id||!$goods_id){
            return $this->asJson(['state'=>-1,'msg'=>'参数错误']);
        }
        //电话
        $tels=ActiveRecord::findBySql("select mother_baby_shop.shop_tel1,
        mother_baby_shop.shop_tel2
        from mother_baby_shop
        where mother_baby_shop.agent_id=$agent_id
        ")->asArray()->one();
        //详情图片
        $images=ActiveRecord::findBySql("select goods_image7,goods_image8,
        goods_image9,goods_image10,goods_image11,goods_image12
        from goods_image where goods_id=$goods_id
        ")->asArray()->all();
        $data=['tels'=>$tels,'images'=>$images];
        return $this->asJson(['state'=>0,'data'=>$data]);

    }

    //点击更多或分类进入分类页面
    public function actionCategory(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        $lat=\Yii::$app->request->get('lat');
        $lng=\Yii::$app->request->get('lng');//门店id
        return $this->renderPartial("category",['lat'=>$lat,'lng'=>$lng,'agent_id'=>$agent_id]);

    }

    //ajax 获取门店一级分类下的二级分类及商品
    public function actionGetAllGoods(){
        $agent_id=\Yii::$app->request->get('agent_id');//门店id
        if(!$agent_id){
            return $this->asJson(['state'=>-1,'msg'=>'参数错误']);
        }
        $data=ActiveRecord::findBySql("
        select goods_category.Name as FirstCategoryName,goods_category2.Name as SecondCategoryName,
        goods.name as GoodsName,mother_baby_goods.originalprice,mother_baby_goods.realprice,
        goods_image.goods_image1,mother_baby_goods.goods_id
        from mother_baby_goods
        inner join goods on goods.id=mother_baby_goods.goods_id
        inner join goods_image on goods.id=goods_image.goods_id
        inner join goods_category on goods.category_id=goods_category.Id
        inner join goods_category as goods_category2  on goods.category2_id=goods_category2.Id
        where mother_baby_goods.agent_id=$agent_id
        ")->asArray()->all();

        $array=[];
        foreach($data as $v){
            $array[$v['FirstCategoryName']][$v['SecondCategoryName']][]=$v;
        }
        return $this->asJson(['state'=>0,'data'=>$array]);
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
