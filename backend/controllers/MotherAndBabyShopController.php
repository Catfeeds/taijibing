<?php
namespace backend\controllers;
//母婴商铺
use yii;
use yii\db\ActiveRecord;
use yii\base\Exception;

class MotherAndBabyShopController extends BaseController{

    //创建商铺
    public function actionCreateShop(){
        $urlobj = $this->getParam("Url");//返回参数记录
        //账户（服务中心）去掉已经创建过的
        $agent=ActiveRecord::findBySql("select Id,Name from agent_info
        where Level=5 and not exists (select 1 from mother_baby_shop where agent_id=agent_info.Id)")->asArray()->all();

        //一级分类数据
        $type1=ActiveRecord::findBySql("select Id,`Name` from goods_category where `Level`=1")->asArray()->all();
        //二级分类数据
        $type2=ActiveRecord::findBySql("select Id,`Name`,ParentId from goods_category where `Level`=2")->asArray()->all();

        return $this->renderPartial('create-shop',
            ['type1'=>$type1,
            'type2'=>$type2,
            'agent'=>$agent,
//            'volume'=>'',
            'url'=>$urlobj,
        ]);
    }


    //ajax根据一级和二级分类获取对应的商品品牌
    public function actionGetBrands(){
        $category1_id=$this->getParam('category1_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        if($category1_id==''||$category2_id==''){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }

        $brands=ActiveRecord::findBySql("select brands.BrandNo,brands.BrandName from goods
left join brands on brands.BrandNo=goods.brand_id
where goods.category_id=$category1_id and goods.category2_id=$category2_id
group by goods.brand_id
")->asArray()->all();
//var_dump($brands);exit;
        return json_encode(['state'=>0,'datas'=>$brands]);

    }

    //ajax根据一级、二级分类和品牌获取对应的商品名称
    public function actionGetGoods(){
        $category1_id=$this->getParam('category1_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//一级分类id
        $brand_id=$this->getParam('brand_id');//品牌
        if($category1_id==''||$category2_id==''||$brand_id==''){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $goods=ActiveRecord::findBySql("select id,`name` from goods
where goods.category_id=$category1_id and goods.category2_id=$category2_id and brand_id='$brand_id'
")->asArray()->all();
//var_dump($goods);exit;
        return json_encode(['state'=>0,'datas'=>$goods]);

    }

    //ajax根据一级、二级分类、品牌、商品名称获取容量
    public function actionGetVolume(){
        $category1_id=$this->getParam('category1_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//一级分类id
        $brand_id=$this->getParam('brand_id');//品牌id
        $goods_name=$this->getParam('goods_name');//商品名称
        if($category1_id==''||$category2_id==''||$brand_id==''||$goods_name==''){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $goods=ActiveRecord::findBySql("select volume from goods
where goods.category_id=$category1_id and goods.category2_id=$category2_id
and brand_id='$brand_id' and name='$goods_name'
")->asArray()->all();
//var_dump($goods);exit;
        return json_encode(['state'=>0,'datas'=>$goods]);

    }

    //保存创建的商铺
    public function actionSaveShop()
    {


        $agent_id = urldecode($this->getParam("agent_id"));//服务中心id
        $name = urldecode($this->getParam("name"));//商户店铺名称
        $detail = urldecode($this->getParam("detail"));//商户简介
        $tel1 = urldecode($this->getParam("tel1"));//订水电话1
        $tel2 = urldecode($this->getParam("tel2"));//订水电话2
        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//商品数据
        $image1 = urldecode($this->getParam("image1"));//图片1
        $image2 = urldecode($this->getParam("image2"));//图片2
        $image3 = urldecode($this->getParam("image3"));//图片3
        $image4 = urldecode($this->getParam("image4"));//图片4
        $image5 = urldecode($this->getParam("image5"));//图片5
        $image6 = urldecode($this->getParam("image6"));//图片6
        $starttime = urldecode($this->getParam("starttime"));//开始时间
        $endtime = urldecode($this->getParam("endtime"));//结束时间

        $open_time=urldecode($this->getParam("opentime"));//开店时间
        $close_time=urldecode($this->getParam("closetime"));//关店时间

        if(!$agent_id||!$name||!$detail||!$tel1||!$subgoodtypes||!$image1){
            return json_encode(['state'=>-1,'msg'=>'数据不完整']);
        }

        if (!$open_time) {
            $open_time = date('Y-m-d H:i:s',time());
        }
        if (!$close_time) {
            $close_time = "2099-1-1";
        }

        if (!$starttime) {
            $starttime = '8:00';
        }

        if (!$endtime) {
            $endtime = "22:00";
        }



        //判断商户店铺名称是否重复
        $res = ActiveRecord::findBySql("select id from mother_baby_shop where `shop_name`='$name'")->asArray()->one();
        if ($res) {
            return json_encode(['state'=>-1,'msg'=>'商户店铺名称重复']);
        }

        //判断该代理商是否已经创建过店铺
        $shop=ActiveRecord::findBySql("select id from mother_baby_shop where agent_id=$agent_id")->asArray()->one();
        if($shop){
            return json_encode(['state'=>-1,'msg'=>'同一个账户不能重复创建店铺']);
        }


//            var_dump($agent_id);exit;
        //保存商户店铺信息
        $sql = "insert into mother_baby_shop (`agent_id`,shop_name,shop_tel1,shop_tel2,`open_time`,`close_time`,image1,image2,image3,image4,image5,image6,shop_detail,morning,night)
                                         values('$agent_id','$name','$tel1','$tel2','$open_time','$close_time','$image1','$image2','$image3','$image4','$image5','$image6','$detail','$starttime','$endtime')";
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try{

            $r = yii::$app->getDb()->createCommand($sql)->execute();
            if (!$r) {
                throw new yii\db\Exception('失败');
            }
            //保存商品信息保存得到对应的代理商
            $GoodsTypeArr = json_decode($subgoodtypes);
            $sql_str=" insert into mother_baby_goods(`agent_id`,`goods_id`,`realprice`,`originalprice`,`stock`)  values ";
            for ($index = 0; $index < count($GoodsTypeArr); $index++) {
                $item = $GoodsTypeArr[$index];

                //获取对应的商品id
                $str=" and volume=$item->goodsvolume ";
                $sql="select id from goods where `category_id`=$item->category1_id and `category2_id`=$item->category2_id and `name`='{$item->goodsname}' and `brand_id`='{$item->goodsbrand}' ".($item->goodsvolume?$str:'');
                $goods=ActiveRecord::findBySql($sql)->asArray()->one();
                if(!$goods){
                    throw new yii\db\Exception('该商品不存在');
                }
                $goods_id=$goods['id'];
                //添加到mother_baby_goods表
                if($index==0){
                    $sql_str.="($agent_id,$goods_id,$item->realPrice,$item->originalPrice,$item->goodsstock)";
                }else{
                    $sql_str.=",($agent_id,$goods_id,$item->realPrice,$item->originalPrice,$item->goodsstock)";
                }


            }
            if($sql_str=='')throw new yii\db\Exception('没有添加商品');

            $res= yii::$app->getDb()->createCommand($sql_str)->execute();
            if(!$res){
                throw new yii\db\Exception('失败2');
            }



            $transaction->commit();
            return json_encode(['state'=>0]);
        } catch (Exception $e) {
            $transaction->rollBack();
            $msg = $e->getMessage();
            return json_encode(['state'=>-1,'msg'=>$msg]);
//            return json_encode(['state'=>-1,'msg'=>'保存失败']);

        }

    }

    //母婴商铺列表
    public function actionList(){
        //分页
        $offset = $this->getParam("offset");
        $limit = $this->getParam("limit");

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //获取搜索内容
        $search=addslashes(trim($this->getParam('shop_name')));
        $where='';
        if(!empty($search)){
            $where="where mother_baby_shop.shop_name like '%{$search}%' or agent_info.Name like '%{$search}%'";
        }

        $sql="select mother_baby_shop.*,agent_info.Name from mother_baby_shop LEFT JOIN agent_info ON mother_baby_shop.agent_id=agent_info.Id $where";

        $datas=ActiveRecord::findBySql($sql);
        $total=$datas->count();
        //排序（开店时间）
        $order=" order by open_time desc ";

        $sql.=" $order limit ".$offset.",".$limit;
        $shops=ActiveRecord::findBySql($sql)->asArray()->all();

        return $this->render('list',
                [
                    'shops'=>json_encode($shops),
                    'total'=>$total,
                    'shop_name'=>$search,
                    'offset' =>$offset,
                    'limit' =>$limit,
                ]);
    }

    //ajax分页
    public function actionPageList(){
        //分页
        $offset = $this->getParam("offset");
        $limit = $this->getParam("limit");

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //获取搜索内容
        $search=addslashes(trim($this->getParam('shop_name')));
        $where='';
        if(!empty($search)){
            $where="where mother_baby_shop.shop_name like '%{$search}%' or agent_info.Name like '%{$search}%'";
        }

        $sql="select mother_baby_shop.*,agent_info.Name from mother_baby_shop LEFT JOIN agent_info ON mother_baby_shop.agent_id=agent_info.Id $where";

        $datas=ActiveRecord::findBySql($sql);
        $total=$datas->count();
        //排序（开店时间）
        $order=" order by open_time desc ";

        $sql.=" $order limit ".$offset.",".$limit;
        $shops=ActiveRecord::findBySql($sql)->asArray()->all();

        return
            json_encode([
                'shops'=>$shops,
                'total'=>$total,
                'shop_name'=>$search,
                'offset' => $offset,
                'limit' => $limit,
            ]);
    }


    //删除店铺
    public function actionDelShop(){

        $agent_id=$this->getParam('agent_id');
        if(!$agent_id) return json_encode(['state'=>-1,'msg'=>'参数错误']);
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try{
            //将该代理商的商品删除
            $sql="delete from mother_baby_goods where agent_id=$agent_id";
            $r = yii::$app->getDb()->createCommand($sql)->execute();
            if (!$r) {
                throw new yii\db\Exception('失败1');
            }
            //将该代理商母婴店删除
            $sql="delete from mother_baby_shop where agent_id=$agent_id";
            $r = yii::$app->getDb()->createCommand($sql)->execute();
            if (!$r) {
                throw new yii\db\Exception('失败2');
            }

            $transaction->commit();
            return json_encode(['state'=>0]);
        } catch (Exception $e) {
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>'失败']);
        }

    }

    //修改商铺及商品（获取修改数据）
    public function actionEdit(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $agent_id=$this->getParam('agent_id');
        if(!$agent_id) return json_encode(['state'=>-1,'msg'=>'参数错误']);



        //获取店铺数据
        $shop=ActiveRecord::findBySql("select * from mother_baby_shop where agent_id=$agent_id ")->asArray()->one();

        //获取商品数据
        $mother_baby_goods=ActiveRecord::findBySql("select * from mother_baby_goods where agent_id=$agent_id")->asArray()->all();

        //一级分类数据
        $type1=ActiveRecord::findBySql("select Id,`Name` from goods_category where `Level`=1")->asArray()->all();
        //二级分类数据
        $type2=ActiveRecord::findBySql("select Id,`Name`,ParentId from goods_category where `Level`=2")->asArray()->all();

//        var_dump($agent_goods);exit;
        $goods=[];
        foreach($mother_baby_goods as $mother_baby_good){
            $good=ActiveRecord::findBySql("select name,category_id as category1_id,category2_id,brand_id,volume from goods where id={$mother_baby_good['goods_id']}")->asArray()->one();
            $goods[]=[
                'category1_id'=>$good['category1_id'],//一级分类
                'category2_id'=>$good['category2_id'],//二级分类
                'goodsname'=>$good['name'],
                'goodsbrand'=>$good['brand_id'],
                'goodsvolume'=>$good['volume'],
                'realPrice'=>$mother_baby_good['realprice'],
                'originalPrice'=>$mother_baby_good['originalprice'],
                'goodsstock'=>$mother_baby_good['stock'],
            ];
        }
//        var_dump($goods);exit;

        //获取服务中心数据
        $agent=ActiveRecord::findBySql("select Id,Name from agent_info where Level=5")->asArray()->all();

        return $this->renderPartial('edit',[
            'shop'=>$shop,
            "goods" => $goods,
            'agent'=>$agent,
            "agent_id" => $agent_id,
            "type1" => $type1,
            "type2" => $type2,
            'url'=>$urlobj
        ]);
    }

    //修改保存
    public function actionSaveEdit(){

        $agent_id = urldecode($this->getParam("agent_id"));//服务中心id
        $name = urldecode($this->getParam("name"));//商户店铺名称
        $detail = urldecode($this->getParam("detail"));//商户简介
        $tel1 = urldecode($this->getParam("tel1"));//订水电话1
        $tel2 = urldecode($this->getParam("tel2"));//订水电话2
        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//商品数据
        $image1 = urldecode($this->getParam("image1"));//图片1
        $image2 = urldecode($this->getParam("image2"));//图片2
        $image3 = urldecode($this->getParam("image3"));//图片3
        $image4 = urldecode($this->getParam("image4"));//图片4
        $image5 = urldecode($this->getParam("image5"));//图片5
        $image6 = urldecode($this->getParam("image6"));//图片6
        $starttime = urldecode($this->getParam("starttime"));//开始时间
        $endtime = urldecode($this->getParam("endtime"));//结束时间

        $open_time=urldecode($this->getParam("opentime"));//开店时间
        $close_time=urldecode($this->getParam("closetime"));//关店时间

        if(!$agent_id||!$name||!$detail||!$tel1||!$subgoodtypes||!$image1){
            return json_encode(['state'=>-1,'msg'=>'数据不完整']);
        }

        if (!$open_time) {
            $open_time = date('Y-m-d H:i:s',time());
        }
        if (!$close_time) {
            $close_time = "2099-1-1";
        }

        if (!$starttime) {
            $starttime = '8:00';
        }

        if (!$endtime) {
            $endtime = "22:00";
        }


        $sql="update mother_baby_shop set shop_name='$name',shop_tel1='$tel1',shop_tel2='$tel2',`open_time`='$open_time',
            `close_time`= '$close_time',image1='$image1',image2='$image2',
            image3='$image3',image4='$image4',image5='$image5',image6='$image6',
            morning='$starttime',night='$endtime',
            shop_detail='$detail' where agent_id=$agent_id";

        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try{

            $r = yii::$app->getDb()->createCommand($sql)->execute();
            if ($r===false) {
                throw new yii\db\Exception('失败');
            }

            //将该代理商原来的商品删除
            $sql="delete from mother_baby_goods where agent_id=$agent_id";
            $r = yii::$app->getDb()->createCommand($sql)->execute();
//            var_dump($r);exit;
            if (!$r) {
                throw new yii\db\Exception('失败2');
            }

            //保存商品信息保存得到对应的代理商
            $GoodsTypeArr = json_decode($subgoodtypes);

            $sql_str=" insert into mother_baby_goods(`agent_id`,`goods_id`,`realprice`,`originalprice`,`stock`)  values ";
            for ($index = 0; $index < count($GoodsTypeArr); $index++) {
                $item = $GoodsTypeArr[$index];

                //获取对应的商品id
                $str=" and volume=$item->goodsvolume ";
                $sql="select id from goods where `category_id`=$item->category1_id and `category2_id`=$item->category2_id and `name`='{$item->goodsname}' and `brand_id`='{$item->goodsbrand}' ".($item->goodsvolume?$str:'');
                $goods=ActiveRecord::findBySql($sql)->asArray()->one();
                if(!$goods){
                    throw new yii\db\Exception('该商品不存在');
                }
                $goods_id=$goods['id'];
                //添加到mother_baby_goods表

                if($index==0){
                    $sql_str.="($agent_id,$goods_id,$item->realPrice,$item->originalPrice,$item->goodsstock)";
                }else{
                    $sql_str.=",($agent_id,$goods_id,$item->realPrice,$item->originalPrice,$item->goodsstock)";
                }


            }

            $res= yii::$app->getDb()->createCommand($sql_str)->execute();
            if(!$res){
                throw new yii\db\Exception('失败2');
            }
            $transaction->commit();
            return json_encode(['state'=>0]);
        } catch (Exception $e) {
            $transaction->rollBack();
//            return json_encode(['state'=>-1,'msg'=>'失败']);
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);
        }

    }

}
