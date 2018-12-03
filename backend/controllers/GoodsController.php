<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/6/20
 * Time: 下午6:05
 */

namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);

use backend\api\BaseApi;
use backend\models\AgentInfo;
use backend\models\Brands;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsImage;
use backend\models\GoodsMerchant;
use backend\models\TeaBrand;
use backend\models\WaterBrand;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii;

class GoodsController extends BaseController
{

//    public function actionList()
//    {
//
//        $data = $this->getCategoryAndMerchant();
//        return $this->renderPartial("list", [
//            "category" => $data["cate"],
//            "merchant" => $data["mer"],
//            "preview" => "http://wx.ebopark.com/index.php/Home/Eshop/gooddetail_"
//        ]);
//    }

    private function getGoodsCategory()
    {
        $categoryarray = (new GoodsCategory())->query();
//        $merchantarray = (new GoodsMerchant())->query();
        $category = array();
//        $merchant = array();
        foreach ($categoryarray as $key => $value) {
            $category[] = array("name" => $value["Name"], "category_id" => $value["category_id"]);
        }
//        foreach ($merchantarray as $key => $value) {
//            $merchant[] = array("name" => $value["name"], "id" => $value["id"]);
//        }

        return $category;

    }




    //获取所有店铺
    public function actionList(){

        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

        //开店时间
        $sort=$this->getParam("sort");//点击排序
        if($sort==''){
            $sort=0;
        }


        //获取搜索内容
        $search=addslashes(trim($this->getParam('content')));
        $where='';
        if(!empty($search)){
            $where="where agent_shop.shop_name like '%{$search}%' or agent_info.Name like '%{$search}%'";
        }

            $sql="select agent_shop.*,agent_info.Name from agent_shop LEFT JOIN agent_info ON agent_shop.agent_id=agent_info.Id $where";

//        var_dump($sql);exit;
        $datas=ActiveRecord::findBySql($sql);

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }


        //排序（开店时间）
        $order=" order by open_time desc ";
        if($sort && $sort%2==1){//奇数 升序
            $order=" order by open_time asc ";

        }
//var_dump($sort);exit;

        $pages = new yii\data\Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
        $sql.=" $order limit ".$pages->offset.",".$pages->limit;
        $shops=ActiveRecord::findBySql($sql)->asArray()->all();

        return $this->render('list2',
            [
                'shops'=>$shops,
                'pages'=>$pages,
                'search'=>$search,
                'page_size' => $page_size,
                'page' => $page,
                'sort' => $sort,
            ]);
    }


    public function actionListNouse()
    {
        $data = $this->getCategoryAndMerchant();
        return $this->renderPartial("nouse", [
            "category" => $data["cate"],
            "merchant" => $data["mer"],
            "preview" => "http://wx.ebopark.com/index.php/Home/Eshop/gooddetail_"
        ]);
    }

    public function actionListForsale()
    {
        $data = $this->getCategoryAndMerchant();
        return $this->renderPartial("forsale", [
            "category" => $data["cate"],
            "merchant" => $data["mer"],
            "preview" => "http://wx.ebopark.com/index.php/Home/Eshop/gooddetail_"
        ]);
    }

    private function getCategoryAndMerchant()
    {
        $categoryarray = (new GoodsCategory())->query();
        $merchantarray = (new GoodsMerchant())->query();
        $category = array();
        $merchant = array();
        foreach ($categoryarray as $key => $value) {
            $category[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        foreach ($merchantarray as $key => $value) {
            $merchant[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        return ["cate" => $categoryarray, "mer" => $merchant];

    }

    /**
     * 创建商品
     * @return string
     */
    public function actionAddgood()
    {
        $urlobj = $this->getParam("Url");//返回参数记录
//        $data = $this->getPageDataWhenAddOrUpdate();

        //获取运营中心和服务中心数据
        $data=$this->getAgents();
        return $this->renderPartial("create2", [
            "agent1" => $data["agent1"],
            "agent2" => $data["agent2"],
            'url'=>$urlobj

        ]);
    }

//获取运营中心和服务中心数据
    private function getAgents()
    {
        //运营中心
        $agentarray1 = ActiveRecord::findBySql("select Id,Name from agent_info where Level=4")->asArray()->all();
        //服务中心
        $agentarray2 = ActiveRecord::findBySql("select Id,Name from agent_info where Level=5")->asArray()->all();
        $agent1 = array();
        $agent2 = array();
        foreach ($agentarray1 as $key => $value) {
            $agent1[] = array("name" => $value["Name"], "id" => $value["Id"]);
        }
        foreach ($agentarray2 as $key => $value) {
            $agent2[] = array("name" => $value["Name"], "id" => $value["Id"]);
        }
        return ["agent1" => $agent1, "agent2" => $agent2];
    }


    //ajax获取对应的服务中心
    public function actionGetAgent($agent_id){
        $agent=AgentInfo::findAll(['ParentId'=>$agent_id]);
        return $agent;
    }

    //ajax获取商品一级分类数据
    public function actionGetCategory(){
        $data=ActiveRecord::findBySql("select Id as category_id,`Name` from goods_category where `Level`=1")->asArray()->all();
        return $data;
    }
    //ajax获取商品对应一级分类下的二级分类数据
    public function actionGetCategory2(){
        $category_id=$this->getParam('category_id');
        $datas=ActiveRecord::findBySql("select Id,`Name` from goods_category where `Level`=2 and ParentId=$category_id")->asArray()->all();
        return json_encode(['datas'=>$datas]);
    }

    //ajax获取对应一级分类、二级分类商品品牌数据
    public function actionGetBrand(){
        $category1_id=$this->getParam('category1_id');
        $category2_id=$this->getParam('category2_id');
        $datas=ActiveRecord::findBySql("select brands.BrandNo,brands.BrandName
        from goods
        left join brands on brands.BrandNo=goods.brand_id
        where goods.category_id=$category1_id and goods.category2_id=$category2_id
        group by goods.brand_id ")->asArray()->all();

        return json_encode(['datas'=>$datas]);

    }




    //ajax获取商品数据
    public function actionGetGoods(){
        $category1_id=$this->getParam('category1_id');
        $category2_id=$this->getParam('category2_id');
        $brand_id=$this->getParam('brand_id');
        $datas=ActiveRecord::findBySql("select DISTINCT name from goods where category_id=$category1_id and category2_id=$category2_id and brand_id='$brand_id' and state=0")->asArray()->all();
        return json_encode(['datas'=>$datas]);
    }


    //ajax获取对应商品容量
    public function actionGetVolume(){
        $category1_id=$this->getParam('category1_id');
        $category2_id=$this->getParam('category2_id');
        $brand_id=$this->getParam('brand_id');
        $goodsname=$this->getParam('goodsname');

        $datas=ActiveRecord::findBySql("select DISTINCT volume from goods where category_id=$category1_id and category2_id=$category2_id and `name`='{$goodsname}' and brand_id='{$brand_id}'")->asArray()->all();

        return json_encode(['datas'=>$datas]);
    }



    //获取修改数据
    public function actionEdit($agent_id){
        $urlobj = $this->getParam("Url");//返回参数记录
        if(empty($agent_id)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }



        //获取店铺数据
        $shop=ActiveRecord::findBySql("select * from agent_shop where agent_id=$agent_id ")->asArray()->all();

        //获取商品数据
        $agent_goods=ActiveRecord::findBySql("select * from agent_goods where agent_id=$agent_id")->asArray()->all();

//        var_dump($agent_goods);exit;
        $goods=[];
        foreach($agent_goods as $agent_good){
//            var_dump($agent_good['goods_id']);exit;
            $good=ActiveRecord::findBySql("select name,category_id as category1_id,category2_id,brand_id,volume from goods where id={$agent_good['goods_id']}")->asArray()->one();
//            var_dump($good['category_id']);exit;
            $goods[]=[
                'category1_id'=>$good['category1_id'],//一级分类
                'category2_id'=>$good['category2_id'],//二级分类
                'goodsname'=>$good['name'],
                'goodsbrand'=>$good['brand_id'],
                'goodsvolume'=>$good['volume'],
                'realPrice'=>$agent_good['realprice'],
                'originalPrice'=>$agent_good['originalprice'],
                'goodsstock'=>$agent_good['stock'],
                'sort'=>$agent_good['sort'],//排序
//                'starttime'=>$agent_good['goods_starttime'],
//                'endtime'=>$agent_good['goods_endtime'],
            ];
        }
//        var_dump($goods);exit;
        //账户名称(判断是运营中心还是服务中心)
        $agent=['parent'=>0,'agent'=>0];
        $parent=ActiveRecord::findBySql("select ParentId,Level from agent_info where Id=$agent_id")->asArray()->one();
        if($parent['Level']==4){//运营中心
            $agent['parent']=$agent_id;
        }
        if($parent['Level']==5){//服务中心
            $agent['parent']=$parent['ParentId'];
            $agent['agent']=$agent_id;
            //判断服务中心的上级是运营中心还是片区中心
            $parent2=ActiveRecord::findBySql("select ParentId,Level from agent_info where Id={$parent['ParentId']}")->asArray()->one();
            if($parent2['Level']==7){
                $agent['parent']=$parent2['ParentId'];
            }

        }
        if($parent['Level']==7){//片区中心

            $parent2=ActiveRecord::findBySql("select ParentId,Level from agent_info where Id={$parent['ParentId']}")->asArray()->one();
            $agent['parent']=$parent2['ParentId'];
            $agent['agent']=$agent_id;

        }

//        var_dump($agent);exit;

        //获取运营中心和服务中心数据
        $datas=$this->getAgents();

        return $this->renderPartial('edit',['shop'=>$shop,
                            "data" => $goods,
                            'agent'=>$agent,
                            "agent1" => $datas["agent1"],
                            "agent2" => $datas["agent2"],
                            'url'=>$urlobj
                        ]);



    }

    //修改保存
    public function actionSaveEdit(){

        $agent1_id = urldecode($this->getParam("agent1"));//运营中心id
        $agent2_id = urldecode($this->getParam("agent2"));//服务中心id
        $name = urldecode($this->getParam("name"));//商户店铺名称
        $detail = urldecode($this->getParam("detail"));//商户简介
//        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//商品数据
        $image1 = urldecode($this->getParam("image1"));//图片1
        $image2 = urldecode($this->getParam("image2"));//图片2
        $image3 = urldecode($this->getParam("image3"));//图片3
        $image4 = urldecode($this->getParam("image4"));//图片4
        $image5 = urldecode($this->getParam("image5"));//图片5
        $image6 = urldecode($this->getParam("image6"));//图片6
        $starttime = urldecode($this->getParam("starttime"));//开始时间
//        $id = urldecode($this->getParam("id"));//商户id
        $tel1 = urldecode($this->getParam("tel1"));//订水电话1
        $tel2 = urldecode($this->getParam("tel2"));//订水电话2
        $open_time=urldecode($this->getParam("opentime"));//开店时间
        $close_time=urldecode($this->getParam("closetime"));//关店时间

        if (!$open_time) {
            $open_time = date('Y-m-d H:i:s',time());
        }
        if (!$close_time) {
            $close_time = "2099-1-1";
        }

//        var_dump($starttime);exit;

        if (!$starttime) {
            $starttime = date('Y-m-d H:i:s',time());
        }
        $endtime = urldecode($this->getParam("endtime"));//结束时间
        if (!$endtime) {
            $endtime = "2099-1-1";
        }
        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//商品数据

//        var_dump(json_decode($subgoodtypes)[0]->goodsname);exit;




        //判断商户店铺名称，或商户ID号是否重复
//        $res = ActiveRecord::findBySql("select * from agent_shop where `shop_id`='$id' or `shop_name`='$name'")->asArray()->all();
//        if ($res) {
//            foreach ($res as $key => $value) {
//                $_id = $value["shop_id"];
//                $_name = $value["shop_name"];
//                if ($_id == $id) {
//                    $data["state"] = -1;
//                    $data["msg"] = "商户ID号重复！";
//                    $this->jsonReturn($data);
//                    return;
//                }
//                if ($_name == $name) {
//                    $data["state"] = -1;
//                    $data["msg"] = "商户店铺名称重复！";
//                    $this->jsonReturn($data);
//                    return;
//                }
//            }
//        }
//            $user = Yii::$app->getUser()->getId();

        $agent_id=empty($agent2_id)?$agent1_id:$agent2_id;//判断是运营中心还是服务中心

//            var_dump($agent_id);exit;
        //保存商户店铺信息
//        $sql = "insert into agent_shop (`agent_id`,shop_name,shop_id,`open_time`,`close_time`,image1,image2,image3,image4,image5,image6,shop_detail)
//                                         values('$agent_id','$name','$id','$open_time','$close_time','$image1','$image2','$image3','$image4','$image5','$image6','$detail')";
        $sql="update agent_shop set shop_name='$name',shop_tel1='$tel1',shop_tel2='$tel2',`open_time`='$open_time',
            `close_time`= '$close_time',image1='$image1',image2='$image2',
            image3='$image3',image4='$image4',image5='$image5',image6='$image6',
            morning='$starttime',night='$endtime',
            shop_detail='$detail' where agent_id=$agent_id";
//var_dump($sql);exit;
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try{

            $r = yii::$app->getDb()->createCommand($sql)->execute();
//            throw new yii\db\Exception($r);
//            if ($r===false) {
            if ($r===false) {
                throw new yii\db\Exception($sql);
            }
//                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','1','1','$lb')")->execute();//列表图
//                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','2','2','$xj')")->execute();//细节图
//                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','3','3','$spxq')")->execute();
//                yii::$app->getDb()->createCommand("insert into goods_info_img(`GoodsId`,`Type`,`Order`,`Url`) values('$id','4','4','$cpts')")->execute();

            //将该代理商原来的商品删除
            $sql="delete from agent_goods where agent_id=$agent_id";
            $r = yii::$app->getDb()->createCommand($sql)->execute();
//            var_dump($r);exit;
            if (!$r) {
                throw new yii\db\Exception('失败2');
            }

            //保存商品信息保存得到对应的代理商
            $GoodsTypeArr = json_decode($subgoodtypes);
//        var_dump($GoodsTypeArr);exit;
            for ($index = 0; $index < count($GoodsTypeArr); $index++) {
                $item = $GoodsTypeArr[$index];
                //获取对应的商品id
//                    $goods_id=Goods::find()->where(['category_id'=>$item->goodscategory])->andWhere(['name'=>$item->goodsname])->andWhere(['brand_id'=>$item->goodsbrand])->andWhere(['factory_id'=>$item->goodsfactory])->one()->id;
                $str=" and volume=$item->goodsvolume ";
                $sql="select id from goods where `category_id`=$item->category1_id and `category2_id`=$item->category2_id and `name`='{$item->goodsname}'".($item->category1_id==1?$str:'');
                $goods_id=ActiveRecord::findBySql($sql)->asArray()->one()['id'];
//                    var_dump($goods_id);exit;
                if(!$goods_id){
                    throw new yii\db\Exception('该商品不存在');
                }
                //添加到agent_goods表
                $res= yii::$app->getDb()->createCommand("insert into agent_goods(`agent_id`,`goods_id`,`realprice`,`originalprice`,`goods_starttime`,`goods_endtime`,`stock`,`sort`) values($agent_id,$goods_id,$item->realPrice,$item->originalPrice,'{$starttime}','{$endtime}',$item->goodsstock,$item->sort)")->execute();
                if(!$res){
                    throw new yii\db\Exception('失败3');
                }

            }

            $transaction->commit();

            $data["state"] = 0;
            $data["id"] = $r;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $transaction->rollBack();
            $data["state"] = -1;
//            $data["msg"] = $e->getMessage();
            $data["msg"] = '修改失败';
            $this->jsonReturn($data);
        }

    }


    //删除店铺
    public function actionDelShop($agent_id){
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try{
        //将该代理商的商品删除
        $sql="delete from agent_goods where agent_id=$agent_id";
        $r = yii::$app->getDb()->createCommand($sql)->execute();
            if (!$r) {
                throw new yii\db\Exception('失败1');
            }
        //将该代理商门店删除
        $sql="delete from agent_shop where agent_id=$agent_id";
        $r = yii::$app->getDb()->createCommand($sql)->execute();
            if (!$r) {
                throw new yii\db\Exception('失败2');
            }

            $transaction->commit();

            $data["state"] = 0;
            $data["id"] = $r;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $transaction->rollBack();
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }

    }

    private function getPageDataWhenAddOrUpdate()
    {

        $categoryarray = ActiveRecord::findBySql("select id,name from goods_category")->asArray()->all();
        $merchantarray = ActiveRecord::findBySql("select id,name from goods_merchant")->asArray()->all();
        $sms = ActiveRecord::findBySql("select `name`,`id` from msg_smstemp")->asArray()->all();
        $category = array();
        $merchant = array();
        $array = array();
        foreach ($categoryarray as $key => $value) {
            $category[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        foreach ($merchantarray as $key => $value) {
            $merchant[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        foreach ($sms as $key => $value) {
            $array[] = array("name" => $value["name"], "id" => $value["id"]);
        }
        return ["category" => $category, "merchant" => $merchant, "sms" => $array];
    }

    public function actionWaittingsale()
    {
        $id = $this->getParam("id");
        try {
            $result = yii::$app->db->createCommand("update goods_info_base set starttime='2099-01-01',EndTime='2099-01-01' where id='$id'")->execute();
//            $result= D("GoodsMerchantUser")->execute("update goods_info_base set starttime='2099-01-01',EndTime='2099-01-01' where id='%s'",$id);
            $data["state"] = ($result >= 0 ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    /**
     * 商品下架
     */
    public function actionShelf()
    {
        $id = $this->getParam("id");
        try {
            $result = yii::$app->db->createCommand("update goods_info_base set EndTime=date_add(now(), interval -1 second) where id='$id'")->execute();
            $data["state"] = ($result >= 0 ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    /**
     * 商品上架
     */
    public function actionUnshelf()
    {
        $id = $this->getParam("id");
        try {
            $sql = "select 1 as count from goods_info_base where id='$id' and endtime<now() or endtime<starttime";
            $res = ActiveRecord::findBySql($sql)->asArray()->all();
            $total = 0;
            foreach ($res as $key => $value) {
                $total = $value["count"];
            }
            if ($total == 1) {
                $data["state"] = -2;
                $data["msg"] = "商品下架时间小于上架时间！";
                $this->jsonReturn($data);
                return;
            }
            $result = yii::$app->db->createCommand("update goods_info_base set starttime=now() where id='$id'")->execute();
            $data["state"] = ($result >= 0 ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    public function actionDel()
    {
        $id = $this->getParam("id");
        try {
            $executeresult = true;
            $trans = (new ActiveRecord())->getDb()->beginTransaction();
            //销售状态 分享链接 消息定义 商品型号 商品图片 商品控件属性值 基本信息
            $array = array("goods_stat_sale", "goods_info_share", "goods_info_msgdef", "goods_info_item", "goods_info_img", "goods_info_control", "goods_info_base");
            foreach ($array as $key => $value) {
                $r = false;
                if ($value == "goods_info_base") {
                    $r = yii::$app->db->createCommand("delete from $value where id='$id'")->execute();
                } else {
                    $r = yii::$app->db->createCommand("delete from $value where GoodsId='$id'")->execute();
                }

                if (!$r && $r !== 0) {
                    $trans->rollback();
                    $executeresult = false;
                    break;
                }
            }
            if ($executeresult) {
                $trans->commit();
            }

            $data["state"] = ($executeresult ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }

    }

    /**
     * 商品复制到待售
     */
    public function actionCopytounshelf()
    {
        $id = $this->getParam("id");
        try {
            $executeresult = true;
            $suffix = time();
            $goodid = "copy" . $suffix;
            //销售状态 分享链接 消息定义 商品型号 商品图片 商品控件属性值 基本信息
            $array = array(
                "insert into goods_info_item(GoodsId,Name,Total,CostPrice) select '" . $goodid . "',Name,Total,CostPrice from goods_info_item where GoodsId='" . $id . "'",
//                "insert into goods_stat_sale(ItemId,Date,GoodsId,Amount) select LAST_INSERT_ID(),Date,'".$goodid."',0 from goods_stat_sale where GoodsId='".$id."'",
                "insert into goods_info_share(GoodsId,`Title`,`Content`,Img) select '" . $goodid . "',`Title`,`Content`,Img from goods_info_share where GoodsId='" . $id . "'",
                "insert into goods_info_msgdef(GoodsId,MsgTailOfMerchant,MsgTailOfUser) select '" . $goodid . "',MsgTailOfMerchant,MsgTailOfUser from goods_info_msgdef where GoodsId='" . $id . "'",
                "insert into goods_info_img(GoodsId,`Type`,`Order`,`Url`) select '" . $goodid . "',`Type`,`Order`,`Url` from goods_info_img where GoodsId='" . $id . "'",
                "insert into goods_info_control(GoodsId,`ControlType`,`Data`,`Order`) select '" . $goodid . "',`ControlType`,`Data`,`Order` from goods_info_control where GoodsId='" . $id . "'",
                "insert into goods_info_base(`Id`,`MerchantId`,`CategoryId`,`LogicType`,`Name`,`Title`,`ExpressType`,`InitAmount`,`OriginalPrice`,`SalePrice`,`ShopHours`,`Tel`,`Lat`,`lng`,`Address`,`Tips`,`RowTime`,`LastOpUser`,`LastOpTime`,`OrderDescTemp`,`StartTime`,`EndTime`,`MemberDiscountType`,`MemberDiscountVal`,`ExistsDetail`,`total`) select '" . $goodid . "',`MerchantId`,`CategoryId`,`LogicType`,CONCAT_WS('','copy',`Name`),`Title`,`ExpressType`,`InitAmount`,`OriginalPrice`,`SalePrice`,`ShopHours`,`Tel`,`Lat`,`lng`,`Address`,`Tips`,now(),`LastOpUser`,now(),`OrderDescTemp`,'2099-1-1','2099-1-1',`MemberDiscountType`,`MemberDiscountVal`,`ExistsDetail`,`total` from goods_info_base where id='" . $id . "'"
            );
            $trans = (new ActiveRecord())->getDb()->beginTransaction();
            foreach ($array as $key => $value) {
                $r = yii::$app->db->createCommand($value)->execute();
                if ($r != 0 && !$r) {
                    $trans->rollback();
                    $executeresult = false;
                    break;
                }
            }
            if ($executeresult) {
                $trans->commit();
            }
            //更新e泊特价itemid
            $updateSuccess = $this->updatePricesControlAfterCopy($goodid);
            $data["state"] = ($updateSuccess && $executeresult ? 0 : -1);
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }

    public function updatePricesControlAfterCopy($goodid = "")
    {
        $res = ActiveRecord::findBySql("select Id from goods_info_item where GoodsId='$goodid'")->asArray()->all();
        if (!$res) {
            return false;
        }
        $control = ActiveRecord::findBySql("select Data from goods_info_control where GoodsId='$goodid' and ControlType=10102")->asArray()->all();
        if (!$control) {
            return false;
        }
        $controlObj = json_decode($control[0]["Data"]);
        if (count($controlObj->Items) != count($res)) {
            return false;
        }
        foreach ($res as $key => $val) {
            $controlObj->Items[$key]->ItemId = $val["Id"];
        }
        $json = json_encode($controlObj);
        $res = yii::$app->db->createCommand("update goods_info_control set Data='$json' where GoodsId='$goodid' and ControlType=10102")->execute();
        return !!$res;


    }

    /**
     * 获取商品列表
     */
    public function actionGetSales()
    {
        $pageIndex = $this->getParam("pageIndex") + 1;
        $pageSize = $this->getParam("pageSize");
        $goodid = $this->getParam("goodid");
        $name = $this->getParam("name");
        $categoryid = $this->getParam("categoryid");
        $merchantid = $this->getParam("merchantid");
        $starttime = $this->getParam("starttime");
        $endtime = $this->getParam("endtime");
        $saling = $this->getParam("saling");
        $shelfstarttime = $this->getParam("shelfstarttime");
        $shelfendtime = $this->getParam("shelfendtime");
        try {
            $where = "";
            if ($saling == "1") {
                $where = " where StartTime > now() and EndTime > now()";//待售
            } else if ($saling == "0") {
                $where = " where EndTime > now() and startTime <= now() ";//上架
            } else {
                $where = " where EndTime < now() and startTime < now()";//失效
            }


            if (!empty($merchantid)) {
                $where .= " and merchantid = '" . $merchantid . "'";
            }
            if (!empty($categoryid)) {
                $where .= " and categoryid = '" . $categoryid . "'";
            }
            if (!empty($name)) {
                $where .= " and `name` like '%" . $name . "%'";
            }
            if (!empty($starttime) && !empty($endtime)) {
                $where .= " and starttime between '" . $starttime . "' and '" . $endtime . "'";
            }
            if (!empty($shelfstarttime) && !empty($shelfendtime)) {
                $where .= " and endtime between '" . $shelfstarttime . "' and '" . $shelfendtime . "'";
            }
            if (!empty($goodid)) {
                $where .= " and Id='$goodid'";
            }
            //获取下拉框的数据
            $categoryarray = ActiveRecord::findBySql("select id,name from goods_category")->asArray()->all();
            $merchantarray = ActiveRecord::findBySql("select id,name from goods_merchant")->asArray()->all();
            $category = array();
            $merchant = array();
            foreach ($categoryarray as $key => $value) {
                $category[$value["id"]] = $value["name"];
            }
            foreach ($merchantarray as $key => $value) {
                $merchant[$value["id"]] = $value["name"];
            }

            //2017/04/06 添加商品类型
            //从goods_info_item表获取所有商品型号，从goods_stat_sale表获取对应商品的总数，从goods_info_control表获取对应商品的data值
            $typesarray = ActiveRecord::findBySql("select i.id as itemid, i.GoodsId,i.costprice,i.name,sum(s.amount) as amount ,goods_info_control.Data from goods_info_item i
                                                      left join goods_stat_sale s on i.id=s.itemid
                                                      left join goods_info_control on goods_info_control.GoodsId=i.GoodsId and goods_info_control.ControlType='10102'
                                                     group by i.costprice,i.name,i.GoodsId order by i.GoodsId desc")->asArray()->all();
            //得到同一种商品下的不同型号的一个三维数组
            $types = array();
            foreach ($typesarray as $key => $value) {
                $goodsid = $value["GoodsId"];
                $temp = array();
                if (array_key_exists($goodsid, $types)) {//同一种商品，不同型号
                    $temp = $types[$goodsid];
                }
                $temp[] = ["itemid" => $value["itemid"], "name" => $value["name"], "sale" => empty($value["amount"]) ? 0 : $value["amount"], "costprice" => $value["costprice"], "data" => $value["Data"]];
                $types[$goodsid] = $temp;//将goodsid 和对应的信息对应保存
            }
//            var_dump($types);exit;


            //total
            $total = 0;
            //goods_info_base表所有在售商品的数据条数 $totalarray
            $totalarray = ActiveRecord::findBySql("select count(1) as count from goods_info_base  " . $where)->asArray()->all();

            //获取goods_info_base表的所有商品数据，并从goods_stat_sale表获取对应商品的销售总数
            $sql = "select *, (select ifnull(sum(amount),0) from goods_stat_sale where GoodsId=goods_info_base.id) as amount from goods_info_base " . $where . " order by id desc"; //limit " . ($pageIndex - 1) * $pageSize . "," . $pageSize;
            $res = ActiveRecord::findBySql($sql)->asArray()->all();

            //获取商品id(获取所有在售商品的id)
            $ids = [];
            foreach ($res as $val) {
//                $ids.="'".$val["id"]."',";
                array_push($ids, "'" . $val["Id"] . "'");
            }

            //从goods_stat_sale表读取出所有满足条件的数据
            $sellData=[];//销售商品的所有数据
            if(!empty($ids)){
                $sql = "select goods_stat_sale.* from goods_stat_sale  left join goods_info_base on `goods_stat_sale`.`GoodsId`=goods_info_base.`Id` where goods_stat_sale.`GoodsId`  in  (" . implode(",", $ids) . ")";
                $sellData = ActiveRecord::findBySql($sql)->asArray()->all();
            }

            $data = array();
            $i = 1;
            foreach ($totalarray as $key => $value) {
                $total = $value["count"];
            }

            foreach ($res as $key => $value) {
                $item = array();
                $item["num"] = $i;//序号
                $item["id"] = is_null($value["Id"]) ? "" : $value["Id"];//商品id
                $item["name"] = is_null($value["Name"]) ? "" : $value["Name"];//商品名称
                $item["merchantname"] = "";
                if (array_key_exists($value["MerchantId"], $merchant)) {
                    $item["merchantname"] = $merchant[$value["MerchantId"]];//供货商名称
                }
                $item["categoryname"] = "";
                if (array_key_exists($value["CategoryId"], $category)) {
                    $item["categoryname"] = $category[$value["CategoryId"]];//分类名称
                }
                $item["total"] = array_key_exists("Total", $value) ? $value["Total"] : "";//总量
                $item["amount"] = array_key_exists("amount", $value) ? $value["amount"] : "";//销售总量
                $item["lastopuser"] = array_key_exists("LastOpUser", $value) ? $value["LastOpUser"] : "";
                $item["starttime"] = array_key_exists("StartTime", $value) ? $value["StartTime"] : "";
                $item["endtime"] = array_key_exists("EndTime", $value) ? $value["EndTime"] : "";


                if (array_key_exists($item["id"], $types)) {
                    $temp = $types[$item["id"]];
                    $item["data"] = $temp;//该商品下的所有型号
                } else {
                    $item["data"] = array();
                }
                array_push($data, $item);
                $i++;
            }
            $result["total"] = $total;
            $result["data"] = $data;
            $result["goods_sell_data"] = empty($sellData) ? [] : $sellData;//已销售商品的所有数据
            $result["state"] = 0;
            $this->jsonReturn($result);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $data["total"] = 0;
            $this->jsonReturn($data);
        }
    }

    /**
     * 获取七牛key
     */
    public function actionGetqiniukey()
    {
        $token = "";
        $privatekey = '0xOWPxOtXev3#$sCC4AxSoSJpr4LCY4b';//session("privatekey");
        $api = new BaseApi();
        $url = $api->getUrl("/resource/token", [], $token, $privatekey);
        $res = $api->curl($url, []);
        $this->jsonReturn(json_decode($res));
    }

    public function actionSavegood()
    {


        $agent1_id = urldecode($this->getParam("agent1"));//运营中心id
        $agent2_id = urldecode($this->getParam("agent2"));//服务中心id
        $name = urldecode($this->getParam("name"));//商户店铺名称
        $detail = urldecode($this->getParam("detail"));//商户简介
//        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//商品数据
        $image1 = urldecode($this->getParam("image1"));//图片1
        $image2 = urldecode($this->getParam("image2"));//图片2
        $image3 = urldecode($this->getParam("image3"));//图片3
        $image4 = urldecode($this->getParam("image4"));//图片4
        $image5 = urldecode($this->getParam("image5"));//图片5
        $image6 = urldecode($this->getParam("image6"));//图片6
        $starttime = urldecode($this->getParam("starttime"));//开始时间
//        $id = urldecode($this->getParam("id"));//商户id
        $tel1 = urldecode($this->getParam("tel1"));//订水电话1
        $tel2 = urldecode($this->getParam("tel2"));//订水电话2
        $open_time=urldecode($this->getParam("opentime"));//开店时间
        $close_time=urldecode($this->getParam("closetime"));//关店时间

        if (!$open_time) {
            $open_time = date('Y-m-d H:i:s',time());
        }
        if (!$close_time) {
            $close_time = "2099-1-1";
        }





        if (!$starttime) {
        $starttime = '8:00';
    }
        $endtime = urldecode($this->getParam("endtime"));//结束时间
        if (!$endtime) {
            $endtime = "22:00";
        }
        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//商品数据

//        $GoodsTypeArr = json_decode($subgoodtypes);
//        var_dump($GoodsTypeArr);exit;
//        for ($index = 0; $index < count($GoodsTypeArr); $index++) {
//            $item = $GoodsTypeArr[$index];
//            if (!$item->goodscategory || !$item->goodsname || !$item->goodsbrand || !$item->goodsfactory || !$item->realPrice || !$item->originalPrice) {
//                throw new yii\db\Exception('该商品不存在');
//            }
//        }




//        var_dump(json_decode($subgoodtypes)[0]->goodsname);exit;




            //判断商户店铺名称是否重复
            $res = ActiveRecord::findBySql("select * from agent_shop where `shop_name`='$name'")->asArray()->all();
            if ($res) {
                foreach ($res as $key => $value) {
//                    $_id = $value["id"];
                    $_name = $value["shop_name"];
//                    if ($_id == $id) {
//                        $data["state"] = -1;
//                        $data["msg"] = "商户ID号重复！";
//                        $this->jsonReturn($data);
//                        return;
//                    }
                    if ($_name == $name) {
                        $data["state"] = -1;
                        $data["msg"] = "商户店铺名称重复！";
                        $this->jsonReturn($data);
                        return;
                    }
                }
            }
//            $user = Yii::$app->getUser()->getId();

            $agent_id=empty($agent2_id)?$agent1_id:$agent2_id;//判断是运营中心还是服务中心

            //判断该代理商是否已经创建过店铺
        $shop=ActiveRecord::findBySql("select * from agent_shop where agent_id=$agent_id")->asArray()->all();
        if($shop){
            $data["state"] = -1;
            $data["msg"] = "商户店铺已经创建！";
            $this->jsonReturn($data);
            return;
        }


//            var_dump($agent_id);exit;
            //保存商户店铺信息
            $sql = "insert into agent_shop (`agent_id`,shop_name,shop_tel1,shop_tel2,`open_time`,`close_time`,image1,image2,image3,image4,image5,image6,shop_detail,morning,night)
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

                for ($index = 0; $index < count($GoodsTypeArr); $index++) {
                    $item = $GoodsTypeArr[$index];

                    //获取对应的商品id
                    $str=" and volume=$item->goodsvolume ";
                    $sql="select id from goods where `category_id`=$item->category1_id and `category2_id`=$item->category2_id and `name`='{$item->goodsname}' and `brand_id`='{$item->goodsbrand}' ".($item->category1_id==1?$str:'');
                    $goods=ActiveRecord::findBySql($sql)->asArray()->one();
                  if(!$goods){
                      throw new yii\db\Exception('该商品不存在');
                  }
                    $goods_id=$goods['id'];
//                    var_dump($goods_id);exit;
                    //添加到agent_goods表
                   $res= yii::$app->getDb()->createCommand("insert into agent_goods(`agent_id`,`goods_id`,`realprice`,`originalprice`,`stock`,`sort`) values($agent_id,$goods_id,$item->realPrice,$item->originalPrice,$item->goodsstock,$item->sort)")->execute();
                    if(!$res){
                        throw new yii\db\Exception('失败2');
                    }

                }

        $transaction->commit();

            $data["state"] = 0;
            $data["id"] = $r;
            $this->jsonReturn($data);
        } catch (Exception $e) {
        $transaction->rollBack();
            $data["state"] = -1;
//            $data["msg"] = $e->getMessage();
            $data["msg"] = '保存失败！';
            $this->jsonReturn($data);
        }

    }

    /**
     *
     */
    public function actionUpdate($id='')
    {

        $id =$this->getParam("id");
        $id ='BBTJS';
        $res = ActiveRecord::findBySql("select * from goods_info_base where id='$id'")->asArray()->all();
        if (empty($res)) {
            return "该商品,不存在";
        }
        $data = $this->getPageDataWhenAddOrUpdate();
        return $this->renderPartial("update", [
            "data" => $res,
            "category" => $data["category"],
            "merchant" => $data["merchant"],
            "sms" => $data["sms"]

        ]);
    }
    public function actionListgood(){
        $id =$this->getParam("id");
        try {
             $r=   ActiveRecord::findBySql("select * from goods_info_base where id='$id'")->asArray()->all();
            $msg= ActiveRecord::findBySql("select * from goods_info_msgdef where GoodsId='$id'")->asArray()->all();
            $itemList=ActiveRecord::findBySql("select * from goods_info_item where GoodsId='$id'")->asArray()->all();
            $imgList=ActiveRecord::findBySql("select * from goods_info_img where GoodsId='$id'")->asArray()->all();
            $share=ActiveRecord::findBySql("select * from goods_info_share where GoodsId='$id'")->asArray()->all();
            $controls=ActiveRecord::findBySql("select * from goods_info_control where GoodsId='$id'")->asArray()->all();

            $data["state"] = !$r?-1:0;
            $data["data"]=$r;
            $data["msg"]=$msg;
            $data["share"]=empty($share)?"":$share;
            $data["item_list"]=empty($itemList)?[]:$itemList;
            $data["img_list"]=empty($imgList)?[]:$imgList;
            $data["controls"]=empty($controls)?[]:$controls;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }
    public function actionUpdatebasenfo(){

        $id = urldecode($this->getParam("id"));
        $merchantid = urldecode($this->getParam("merchantid"));
        $categoryid = urldecode($this->getParam("categoryid"));
        $logictype = urldecode($this->getParam("logictype"));
        $name = urldecode($this->getParam("name"));
        $title = urldecode($this->getParam("title"));
        $expresstype = urldecode($this->getParam("expresstype"));
        $initamount = urldecode($this->getParam("initamount"));
        $originalprice = urldecode($this->getParam("originalprice"));
        $saleprice = urldecode($this->getParam("saleprice"));
        $shophours = urldecode($this->getParam("shophours"));
        $tel = urldecode($this->getParam("tel"));
        $lat = urldecode($this->getParam("lat"));
        $lng = urldecode($this->getParam("lng"));
        $address = urldecode($this->getParam("address"));
        $tips = urldecode($this->getParam("tips"));
        $orderdesctemp = urldecode($this->getParam("orderdesctemp"));
        $memberdiscounttype = urldecode($this->getParam("memberdiscounttype"));
        $memberdiscountval = $memberdiscounttype=="0"?0:urldecode($this->getParam("memberdiscountval"));
        $existsdetail = urldecode($this->getParam("existsdetail"));
        $lb=urldecode($this->getParam("lb"));
        $xj=urldecode($this->getParam("xj"));
        $spxq=urldecode($this->getParam("spxq"));
        $cpts=urldecode($this->getParam("cpts"));
        $subgoodtypes=urldecode($this->getParam("subgoodtypes"));
        try {
            $res=ActiveRecord::findBySql("select * from goods_info_base where `id`='$id'")->asArray()->all();
            if (!$res) {
                $data["state"] = -1;
                $data["msg"] = "商品不存在！";
                $this->jsonReturn($data);
                return;

            }
            $user =  Yii::$app->getUser()->getId();
            $r=Yii::$app->getDb()->createCommand("update goods_info_base set MerchantId='$merchantid',CategoryId='$categoryid',LogicType='$logictype',`name`='$name',title='$title',ExpressType='$expresstype',
                                                  InitAmount='$initamount',OriginalPrice='$originalprice',SalePrice='$saleprice',
                                                  ShopHours='$shophours',Tel='$tel',Lat='$lat',lng='$lng',
                                                  Address='$address',Tips='$tips',RowTime=now(),LastOpUser='$user',
                                                  LastOpTime=now(),OrderDescTemp='$orderdesctemp',MemberDiscountType='$memberdiscounttype',
                                                  MemberDiscountVal='$memberdiscountval',ExistsDetail='$existsdetail'
                                                  where id='$id'")->execute();

            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$lb' where GoodsId='$id' and Type='1'")->execute();
            //保存图片
            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$xj' where GoodsId='$id' and Type='2'")->execute();
            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$spxq' where GoodsId='$id' and Type='3'")->execute();
            Yii::$app->getDb()->createCommand("update goods_info_img set Url='$cpts' where GoodsId='$id' and Type='4'")->execute();
            //保存商品型号
            //清空商品型号
            Yii::$app->getDb()->createCommand("delete from goods_info_item where GoodsId='$id'")->execute();
            $GoodsTypeArr=json_decode($subgoodtypes);
            for($index=0;$index<count($GoodsTypeArr);$index++){
                $item=$GoodsTypeArr[$index];
                if(is_numeric($item->itemId)){
                    Yii::$app->getDb()->createCommand("insert into goods_info_item(`Id`,`GoodsId`,`Name`,`Total`,`CostPrice`) values('$item->itemId','$id','$item->typename','0','$item->realPrice')")->execute();
                }else{
                    Yii::$app->getDb()->createCommand("insert into goods_info_item(`GoodsId`,`Name`,`Total`,`CostPrice`) values('$id','$item->typename','0','$item->realPrice')");
                }
            }
            $data["state"] = 0;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }
    public function actionUpdategood(){
        try {
            $this->updateOrderDescTemp();
            $this->updateMsgAndPublishTime();
            $this->updateShareContent();
            $this->updateControls();
            $data["state"] =0;
            $this->jsonReturn($data);
        } catch (Exception $e) {
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }
    }
    private function updateOrderDescTemp(){
        $id = urldecode($this->getParam("id"));
        $descTemp=$this->getParam("orderdesctemp");
        yii::$app->getDb()->createCommand("update goods_info_base set OrderDescTemp='$descTemp' where id='$id'")->execute();

    }
    private function updateControls(){
        $id = urldecode($this->getParam("id"));
        $controls=json_decode($this->getParam("control"));
        if(!is_array($controls)){
            return;
        }
        //清空控件
        yii::$app->getDb()->createCommand("delete from goods_info_control where GoodsId='$id'")->execute();
        for($index=0;$index<count($controls);$index++){
            $item=$controls[$index];
            $ControlType=$item->ControlType;
            $Data=json_encode($item,JSON_UNESCAPED_UNICODE);
            $Order=$item->Order;
            yii::$app->getDb()->createCommand("insert into goods_info_control(`GoodsId`,`ControlType`,`Data`,`Order`) values('$id','$ControlType','$Data','$Order')")->execute();
            $this->handlerControl($id,$item);
        }
    }
    private function handlerControl($id,$item){
        if($item->ControlType=="10102"){
            //计算总库存
            $total=0;
            foreach($item->Items as $val){
                if(count($val->Prices)==0){
                    $total+=$val->DefaultTotal;
                    continue;
                }
                $tempTotal=$this->getTotal($val);
                $total+=$tempTotal;
            }
            yii::$app->getDb()->createCommand("update goods_info_base set Total=$total where Id='$id'")->execute();
        }

    }
    private function getTotal($val){
        $total=0;
        foreach($val->Prices as $price){
            $total+=$price->Total;
        }
        return $total;
    }
    private function updateMsgAndPublishTime(){
        $id = urldecode($this->getParam("id"));
        $starttime = urldecode($this->getParam("starttime"));
        $endtime = urldecode($this->getParam("endtime"));
        $msgtailofmerchant=urldecode($this->getParam("msgtailofmerchant"));
        $msgtailofuser=urldecode($this->getParam("msgtailofuser"));
        $smstempid=urldecode($this->getParam("smstempid"));
        $user =  Yii::$app->getUser()->getId();
        $r=Yii::$app->getDb()->createCommand("update goods_info_base set starttime='$starttime',endtime='$endtime',LastOpUser='$user',LastOpTime=now() where id='$id'")->execute();
        $msgarray= ActiveRecord::findBySql("select count(1) as `count` from goods_info_msgdef where goodsid='$id'")->asArray()->all();
        foreach ($msgarray as $key => $value) {
            if($value["count"]==0){
                Yii::$app->getDb()->createCommand("insert into goods_info_msgdef(GoodsId,MsgTailOfMerchant,MsgTailOfUser) values('$id','$msgtailofmerchant','$msgtailofuser') ")->execute();
            }
            else{
                Yii::$app->getDb()->createCommand("update goods_info_msgdef set MsgTailOfMerchant='$msgtailofmerchant',MsgTailOfUser='$msgtailofuser',SmsTempId='$smstempid' where goodsid='$id'")->execute();
            }
            break;
        }
    }
    private function updateShareContent(){
        $id = urldecode($this->getParam("id"));
        $shareimg=$this->getParam("shareimg");
        $sharetitle=$this->getParam("sharetitle");
        $sharecontent=$this->getParam("sharecontent");
        //清空分享内容
        Yii::$app->getDb()->createCommand("delete from goods_info_share where GoodsId='$id'")->execute();
        Yii::$app->getDb()->createCommand("insert into goods_info_share(`GoodsId`,`Title`,`Content`,`Img`) values('$id','$sharetitle','$sharecontent','$shareimg')")->execute();
    }
    public  function actionControl(){
        return $this->renderPartial("control");
    }
    public function actionCategory(){
        return $this->renderPartial("category");
    }
    /**
     * 类目管理
     */
    public function actionSavecategory(){
        $id=urldecode($this->getParam("id"));
        $name=urldecode($this->getParam("name"));
        try{
            $res=ActiveRecord::findBySql("select * from goods_category where `Id`='$id' or `Name`='$name'")->asArray()->all();
            if($res){
                $_id= "";
                $_name="";
                foreach ($res as $key => $value) {
                    $_id=$value["Id"];
                    $_name=$value["Name"];
                }
                if($_id==$id) {
                    $data["state"]=-1;
                    $data["msg"]="分类ID重复！";
                    $this->ajaxReturn($data);
                    return;
                }
                if($_name==$name) {
                    $data["state"]=-1;
                    $data["msg"]="分类名称重复！";
                    $this->ajaxReturn($data);
                    return;
                }
            }

            $user=yii::$app->getUser()->getId();
           $r= yii::$app->getDb()->createCommand("insert into goods_category(`id`,`name`,RowTime,LastOpUser,LastOpTime) values('$id','$name',now(),'$user',now())")->execute();
            $data["state"]=($r ? 0 : -1);
            $this->jsonReturn($data);
        }catch(Exception $e){
            $data["state"]=-1;
            $data["msg"]=$e->getMessage();
            $this->jsonReturn($data);
        }
    }
    public function actionMark(){
        return $this->renderPartial("mark");
    }

//----------------------------------------
    //商品管理列表
    public function actionGoodsList(){
        $offset=$this->getParam('offset');//分页开始
        $limit=$this->getParam('limit');//条数
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }
        $category1_id=$this->getParam('category1_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        $brand_id=$this->getParam('brand_id');//品牌id
        $goods_id=$this->getParam('goods_id');//商品id
        $sort=$this->getParam('sort');//排序
        if($sort){
            $sort=0;
        }


        $where='';
        if($category1_id){
            $where=" goods.category_id=$category1_id ";
        }
        if($category2_id){
            if($where){
                $where.=" and ";
            }
            $where.=" goods.category2_id=$category2_id ";
        }
        if($brand_id){
            if($where){
                $where.=" and ";
            }
            $where.=" goods.brand_id='$brand_id' ";
        }
        if($goods_id){
            if($where){
                $where.=" and ";
            }
            $where.=" goods.id='$goods_id' ";
        }

        //商品
        $data=ActiveRecord::findBySql("select goods.id,goods.`name`,
brands.BrandName,goods.volume,goods.unit,
a.Name as Type1Name,b.Name as type2Name,goods.addtime,goods.updatetime,
goods_image.goods_image1,goods_image.goods_image2,goods_image.goods_image3,
goods_image.goods_image4,goods_image.goods_image5,goods_image.goods_image6,
goods_image.goods_image7,goods_image.goods_image8,goods_image.goods_image9,
goods_image.goods_image10,goods_image.goods_image11,goods_image.goods_image12
from goods
left join brands on brands.BrandNo=goods.brand_id
left join goods_category as a on a.id=goods.category_id
left join goods_category as b on b.id=goods.category2_id
left join goods_image on goods_image.goods_id=goods.id
".(empty($where)?'':' where '.$where));

        $total=$data->count();//总条数

        //排序
        $order='order by goods.addtime desc';//默认降序排
        if($sort && $sort%2==1){
            $order='order by goods.addtime desc';//奇数，升序
        }
        $datas=ActiveRecord::findBySql($data->sql." $order limit $offset,$limit")->asArray()->all();


        //一级分类
        $type1=ActiveRecord::findBySql("select Id,`Name` from goods_category where `Level`=1")->asArray()->all();
        //二级分类
        $type2=ActiveRecord::findBySql("select Id,`Name`,ParentId from goods_category where `Level`=2")->asArray()->all();

        return $this->render('goods-list',[
                                           'type1'=>json_encode($type1), //一级分类
                                           'type2'=>json_encode($type2), //二级分类
                                           'category1_id'=>$category1_id, //一级分类
                                           'category2_id'=>$category2_id, //二级分类
                                           'brand_id'=>$brand_id, //品牌id
                                           'goods_id'=>$goods_id, //商品id
                                           'sort'=>$sort, //排序
                                           'offset'=>$offset, //分页开始
                                           'limit'=>$limit, //每页条数
                                           'total'=>$total, //数据总条数
                                           'datas'=>json_encode($datas), //表格数据
                                         ]);
    }

    //分页接口
    public function actionGoodsListPage(){
        $offset=$this->getParam('offset');//分页开始
        $limit=$this->getParam('limit');//条数
//        var_dump($offset,$limit);exit;
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }
        $category1_id=$this->getParam('category1_id');//一级分类id
        $category2_id=$this->getParam('category1_id');//二级分类id
        $brand_id=$this->getParam('brand_id');//品牌id
        $goods_id=$this->getParam('goods_id');//商品id
        $sort=$this->getParam('sort');//排序
        if($sort){
            $sort=0;
        }
        $where='';
        $order=' order by goods.addtime desc ';//默认降序排
        if($sort && $sort%2==1){
            $order=' order by goods.addtime asc ';//奇数，升序
        }

        if($category1_id){
            $where=" goods.category_id=$category1_id ";
        }
        if($category2_id){
            if($where){
                $where.=" and ";
            }
            $where.=" goods.category2_id=$category2_id ";
        }
        if($brand_id){
            if($where){
                $where.=" and ";
            }
            $where.=" goods.brand_id='$brand_id' ";
        }
        if($goods_id){
            if($where){
                $where.=" and ";
            }
            $where.=" goods.id='$goods_id' ";
        }

        //商品
        $data=ActiveRecord::findBySql("select goods.id,goods.`name`,
brands.BrandName,goods.volume,goods.unit,
a.Name as Type1Name,b.Name as type2Name,goods.addtime,goods.updatetime,
goods_image.goods_image1,goods_image.goods_image2,goods_image.goods_image3,
goods_image.goods_image4,goods_image.goods_image5,goods_image.goods_image6,
goods_image.goods_image7,goods_image.goods_image8,goods_image.goods_image9,
goods_image.goods_image10,goods_image.goods_image11,goods_image.goods_image12
from goods
left join brands on brands.BrandNo=goods.brand_id
left join goods_category as a on a.id=goods.category_id
left join goods_category as b on b.id=goods.category2_id
left join goods_image on goods_image.goods_id=goods.id
".(empty($where)?'':' where '.$where));

        $total=$data->count();//总条数
        //排序
        $order='order by goods.addtime desc';//默认降序排
        if($sort && $sort%2==1){
            $order='order by goods.addtime desc';//奇数，升序
        }
        $datas=ActiveRecord::findBySql($data->sql." $order limit $offset,$limit")->asArray()->all();

        return json_encode(['datas'=>$datas,'sort'=>$sort,'offset'=>$offset,'limit'=>$limit]);

    }

    //创建商品
    public function actionAddGoods(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $goods=new Goods();
        $goods_image=new GoodsImage();

        $goods->setScenario('create2');
        if ( Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(yii::$app->getRequest()->post());
            $goods_image->load(Yii::$app->getRequest()->post());

            $goods->addtime=time();
            $goods->stock=0;
            $goods->originalprice=0;
            $goods->saleprice=0;
            $goods->updatetime=0;
            $goods->state=0;
            $goods->factory_id=0;
            //验证商品是否重复
//            var_dump($goods->category_id,$goods->category2_id,$goods->brand_id,$goods->name,$goods->volume,$goods->unit,$goods_image->goods_image1,$goods_image->goods_image7);exit;
            $result=$this->CheckGoods($goods->category_id,$goods->category2_id,$goods->brand_id,$goods->name,$goods->volume,$goods->unit,$goods_image->goods_image1,$goods_image->goods_image7);

            if($result['state']==-1){
                Yii::$app->getSession()->setFlash('error', $result['msg']);
                return $this->redirect(['add-goods']);
            }
            if($goods->validate()&&$goods->save()){

                $goods_id=$goods->id;
                $goods_image->goods_id=$goods_id;
                if($goods_image->validate()&&$goods_image->save()){
                    Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                    return $this->redirect(['goods-list']);
                }else{
                    $errors = $goods->getErrors();
                    $err = '';
                    foreach($errors as $v){
                        $err .= $v[0].'<br>';
                    }
                    Yii::$app->getSession()->setFlash('error', $err);
                    return $this->redirect(['add-goods']);
                }


            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
                return $this->redirect(['add-goods']);
            }
        }

        //一级分类数据
        $type1=ActiveRecord::findBySql("select Id,`Name` from goods_category where `Level`=1")->asArray()->all();
        //二级分类数据
        $type2=ActiveRecord::findBySql("select Id,`Name`,ParentId from goods_category where `Level`=2")->asArray()->all();

        return $this->render('add-goods',['type1'=>$type1,
                                            'type2'=>$type2,
                                            'goods'=>$goods,
                                            'goods_image'=>$goods_image,
                                            'volume'=>'',
                                            'url'=>$urlobj
                                        ]);

    }

    //ajax创建商品时根据一级分类获取对应商品品牌
    public function actionGetBrands(){
        $category1_id=$this->getParam('category1_id');//一级分类id
        $data=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=$category1_id")->asArray()->all();

        return json_encode(['brands'=>$data]);

    }

    //ajax搜索商品时根据一级和二级分类获取对应的商品品牌
    public function actionGetBrandsWhenSearch(){
        $category1_id=$this->getParam('category1_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//一级分类id
        if($category1_id==''||$category2_id==''){
            return '';
        }

        $brands=ActiveRecord::findBySql("select brands.BrandNo,brands.BrandName from goods
left join brands on brands.BrandNo=goods.brand_id
where goods.category_id=$category1_id and goods.category2_id=$category2_id
group by goods.brand_id
")->asArray()->all();
//var_dump($brands);exit;
        return json_encode(['brands'=>$brands]);

    }

    //ajax搜索商品时根据一级、二级分类和品牌获取对应的商品名称
    public function actionGetGoodsWhenSearch(){
        $category1_id=$this->getParam('category1_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//一级分类id
        $brand_id=$this->getParam('brand_id');//品牌
        if($category1_id==''||$category2_id==''||$brand_id==''){
            return '';
        }
        $goods=ActiveRecord::findBySql("select id,`name` from goods
where goods.category_id=$category1_id and goods.category2_id=$category2_id and brand_id='$brand_id'
")->asArray()->all();
//var_dump($goods);exit;
        return json_encode(['goods'=>$goods]);

    }



    //修改
    public function actionEditGoods(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $id=$this->getParam('id');
        if(!$id) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        //获取该商品信息
        $goods=Goods::findOne(['id'=>$id]);
        $goods_image=GoodsImage::findOne(['goods_id'=>$id]);

        if(!$goods||!$goods_image) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Goods or GoodsImage doesn't exit"),
        ]);

//        var_dump($goods);exit;

        $goods->setScenario('create2');
        if ( Yii::$app->getRequest()->getIsPost() ) {

            $goods->load(yii::$app->getRequest()->post());
            $goods->updatetime=time();
            $goods_image->load(yii::$app->getRequest()->post());
            //验证商品是否重复
            $result=$this->CheckGoodsWhenEdit($id,$goods->category_id,$goods->category2_id,$goods->brand_id,$goods->name,$goods->volume,$goods->unit,$goods_image->goods_image1,$goods_image->goods_image7);
            if($result['state']==-1){
                Yii::$app->getSession()->setFlash('error', $result['msg']);
                return $this->redirect(['edit-goods','id'=>$id]);
            }
            if($goods->validate()&&$goods->save()&&$goods_image->validate()&&$goods_image->save()){

                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['goods-list']);
            }else{
                $errors = $goods->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
                return $this->redirect(['edit-goods','id'=>$id]);
            }
        }
        //一级分类数据
        $type1=ActiveRecord::findBySql("select Id,`Name` from goods_category where `Level`=1")->asArray()->all();
        //二级分类数据
        $type2=ActiveRecord::findBySql("select Id,`Name`,ParentId from goods_category where `Level`=2")->asArray()->all();


        return $this->render('add-goods', [
            'type1' => $type1,
            'type2' => $type2,
            'goods'=>$goods,
            'goods_image'=>$goods_image,
            'volume'=>$goods->volume,
            'url'=>$urlobj
        ]);

    }

    //删除文件夹及下面的文件
    function deldir($dir) {
        //先删除目录下的文件：
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }
//var_dump(file_exists($dir));exit;
        closedir($dh);
        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
//            return true;
        } else {
            return false;
        }
    }

    //复制文件夹下面的文件
    function copyfile($old_dir,$dir) {

        $dh=opendir($old_dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$old_dir."/".$file;
                if(!is_dir($fullpath)) {
                    @copy($fullpath,$dir."/".$file);
                }
            }
        }

        closedir($dh);

    }


    //删除
    public function actionDelGoods($id)
    {
        if(empty($id)){
            return json_encode(['state'=>-1,'mas'=>'参数错误']);
        }
        $goods=Goods::findOne(['id'=>$id]);
        $goods_image=GoodsImage::findOne(['goods_id'=>$id]);

        if(!$goods->delete()||!$goods_image->delete()){
            return json_encode(['state'=>-1,'mas'=>'操作错误,请稍后再试']);
        }
        return json_encode(['state'=>0,'mas'=>'成功']);

    }


    //创建品牌
    public function actionCreateBrands(){
        $category1_id=$this->getParam('category1_id');//一级分类id
        if(!$category1_id){
            Yii::$app->getSession()->setFlash('error','参数错误');
            return $this->redirect(['add-goods']);
        }
        if(Yii::$app->request->isPost){
            $BrandName=addslashes($this->getParam('BrandName'));
            if(!$BrandName){
                Yii::$app->getSession()->setFlash('error','品牌名称不能为空');
                return $this->redirect(['add-goods']);
            }
            //判断名称是否重复
            $data=ActiveRecord::findBySql("select BrandName from brands where BrandName='$BrandName' and CategoryId=$category1_id")->asArray()->one();
            if($data){
                Yii::$app->getSession()->setFlash('error','该品牌已经添加过了');
                return $this->redirect(['add-goods']);
            }

                $model=new Brands();
                $model->BrandNo=md5($BrandName.rand(1,999));
                $model->BrandName=$BrandName;
                $model->RowTime=date("Y-m-d H:i:s");
                $model->CategoryId=$category1_id;

            if($model->validate()&&$model->save()){
                Yii::$app->getSession()->setFlash('success','成功');
                return $this->redirect(['add-goods']);
            }
            Yii::$app->getSession()->setFlash('error','失败');
            return $this->redirect(['add-goods']);

        }
        return $this->render('create-brands',['category1_id'=>$category1_id]);
    }

    //修改用户标记坐标（前端添加的）
    public function actionMark2(){
        return $this->renderPartial("mark2");
    }

    //添加商品时验证商品是否重复
    public function CheckGoods($category_id,$category2_id,$brand_id,$name,$volume,$unit,$goods_image1,$goods_image7){
        if(!$category_id){
            return ['state'=>-1,'msg'=>'请选择商品分类'];
        }
        if(!$category2_id){
            return ['state'=>-1,'msg'=>'请选择商品二级分类'];
        }
        if(!$name){
            return ['state'=>-1,'msg'=>'请填写商品名称'];
        }
        if(!$brand_id){
            return ['state'=>-1,'msg'=>'请选择商品品牌'];
        }
        if(!$volume){
            return ['state'=>-1,'msg'=>'请选择商品规格'];
        }
        if(!is_numeric($volume)){
            return ['state'=>-1,'msg'=>'商品规格只能填写数字'];
        }
        if(!$unit){
            return ['state'=>-1,'msg'=>'请选择单位'];
        }
        if(!$goods_image1){
            return ['state'=>-1,'msg'=>'第一张商品图片必须要上传'];
        }
        if(!$goods_image7){
            return ['state'=>-1,'msg'=>'第一张商品详情页图片必须要上传'];
        }

        $data=ActiveRecord::findBySql("select 1 from goods
        where category_id=$category_id and category2_id=$category2_id
        and brand_id='$brand_id' and name='$name' and volume=$volume
        and unit='$unit'")->asArray()->one();
        if($data){
            return ['state'=>-1,'msg'=>'商品已存在'];
        }
        return ['state'=>0];
    }

    //修改商品时验证商品是否重复
    public function CheckGoodsWhenEdit($id,$category_id,$category2_id,$brand_id,$name,$volume,$unit,$goods_image1,$goods_image7){
        if(!$category_id){
            return ['state'=>-1,'msg'=>'请选择商品分类'];
        }
        if(!$category2_id){
            return ['state'=>-1,'msg'=>'请选择商品二级分类'];
        }
        if(!$name){
            return ['state'=>-1,'msg'=>'请填写商品名称'];
        }
        if(!$brand_id){
            return ['state'=>-1,'msg'=>'请选择商品品牌'];
        }
        if(!$volume){
            return ['state'=>-1,'msg'=>'请选择商品规格'];
        }
        if(!is_numeric($volume)){
            return ['state'=>-1,'msg'=>'商品规格只能填写数字'];
        }
        if(!$unit){
            return ['state'=>-1,'msg'=>'请选择单位'];
        }
        if(!$goods_image1){
            return ['state'=>-1,'msg'=>'第一张商品图片必须要上传'];
        }
        if(!$goods_image7){
            return ['state'=>-1,'msg'=>'第一张商品详情页图片必须要上传'];
        }

        $data=ActiveRecord::findBySql("select 1 from goods
        where category_id=$category_id and category2_id=$category2_id
        and brand_id='$brand_id' and name='$name' and volume=$volume
        and unit='$unit' and id <> $id")->asArray()->one();
        if($data){
            return ['state'=>-1,'msg'=>'商品已存在'];
        }
        return ['state'=>0];
    }

}