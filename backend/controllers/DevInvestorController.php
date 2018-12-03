<?php
namespace backend\controllers;
//设备投资商
use backend\models\AdminRoleUser;
use backend\models\AgentInfo;
use Codeception\Lib\Interfaces\ActiveRecord;
use yii\data\Pagination;
use backend\models\Address;
use yii\db\Exception;

class DevInvestorController extends BaseController{

    //设备投资商列表
    public function actionList(){

        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }



        $sort=$this->getParam("sort");//点击排序
        if($sort==''){
            $sort=1;
        }


        $username=addslashes($this->getParam("username"));
        $mobile=addslashes($this->getParam("mobile"));
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $level=6;//设备投资商
        $datas = AgentInfo::pageQueryWithCondition2($username,$mobile,$province,$city,$area,$level,$sort);

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model =  $model = \yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        //县级代理
        //根据登陆者的信息，获取登陆者的角色
        $login_id=\Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;
        //获取角色



        return $this->render('list', [
            'role_id' => $role_id,
            'model' => $model,
            'pages' => $pages,
            'level'=>$level,
            'address'=>$address,
            'username'=>empty($username)?"":$username,
            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
            'sort'=>$sort,
            'page_size' => $page_size,
            'page' => $page,
        ]);
    }

    //投资设置
    public function actionSetInvestment(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $agent_id=$this->getParam("id");
        $name=$this->getParam("name");
        if(empty($agent_id)||empty($name)){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

        //获取对应投资商商品
        $goods=[];
        $investor=\yii\db\ActiveRecord::findBySql("select * from investor where agent_id=$agent_id ")->asArray()->all();
        if($investor){
            foreach($investor as $v){
                $good=\yii\db\ActiveRecord::findBySql("select * from goods where id={$v['goods_id']}")->asArray()->one();
                $good['factory_id']=$v['factory_id'];
                $good['province']=$v['province'];
                $good['city']=$v['city'];
                $good['number']=$v['number'];
                $good['time']=$v['time'];
                $goods[]=$good;
//            var_dump($good);exit;
            }

        }

        return $this->renderPartial('set-investment',
                                    ['name'=>$name,
                                    'id'=>$agent_id,
                                    "data" => $goods,
                                     'url'=>$urlobj
                                    ]);


    }

    //保存设备投资信息
    public function actionSaveInvestment(){
        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//商品数据

        $agent_id = urldecode($this->getParam("id"));//投资商在agent_info表的id
        $name = urldecode($this->getParam("name"));//投资商name
        //保存商品信息到对应的投资商
        $GoodsTypeArr = json_decode($subgoodtypes);
//        var_dump($GoodsTypeArr);exit;
        //开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $investor=\yii\db\ActiveRecord::findBySql("select * from investor where agent_id=$agent_id")->asArray()->all();

            if(!empty($investor)){
                    //先删除原来的再重新保存
                    $re=\Yii::$app->getDb()->createCommand("delete from investor where agent_id=$agent_id")->execute();

                    if(!$re) {
                        throw new Exception('删除原来的数据失败');
                    }
                }


            for ($index = 0; $index < count($GoodsTypeArr); $index++) {

                $item = $GoodsTypeArr[$index];

                if(!empty($item)){
//                    var_dump($item);exit;
                    //获取对应的商品id
                    $sql = "select id from goods where `category_id`=2 and `name`='{$item->devname}' and `brand_id`='{$item->devbrand}' ";
                    $goods_id = \yii\db\ActiveRecord::findBySql($sql)->asArray()->one()['id'];

                    if (!$goods_id) {
                        throw new Exception('该商品不存在');
                    }
                    //                    var_dump($goods_id);exit;
                    //添加到agent_goods表
                    $res = \Yii::$app->getDb()->createCommand("insert into investor(`investor`,`agent_id`,`goods_id`,`factory_id`,`province`,`city`,`state`,`number`,`time`) values('$name',$agent_id,$goods_id,$item->devfactory,'$item->province','$item->city',0,$item->number,'$item->time')")->execute();

                    if (!$res) {
                        throw new Exception('失败');
                    }

                }
            }



            $transaction->commit();

            $data["state"] = 0;
            $data["id"] = $res;
            $this->jsonReturn($data);
        }catch (Exception $e){
            $transaction->rollBack();
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }

    }

    //查看投资详情
    public function actionSee(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }


        $agent_id = urldecode($this->getParam("id"));//投资商在agent_info表的id
        $name = urldecode($this->getParam("name"));//投资商name

        if(empty($agent_id)||empty($name)){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }


        $datas=\yii\db\ActiveRecord::findBySql("select investor.*,goods.name,
brands.BrandName,dev_factory.Name as factory_name
from investor
LEFT JOIN goods ON investor.goods_id=goods.id
LEFT JOIN brands ON goods.brand_id=brands.BrandNo
LEFT JOIN dev_factory ON investor.factory_id=dev_factory.Id
where investor.`agent_id`=$agent_id and goods.category_id=2 order by time desc");

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);

        $model = \yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();

        return $this->render('list-see',
            [
                'model'=>$model,
                'page_size' => $page_size,
                'page' => $page,
                'pages' => $pages,
                'agent_id'=>$agent_id,
                'name'=>$name,
                'url'=>$urlobj
            ]);

    }





    //获取设备品牌
    public function actionGetDevbrand(){
        $data=\yii\db\ActiveRecord::findBySql("select * from brands where CategoryId=2")->asArray()->all();
        return $data;
    }

    //获取对应品牌的设备
    public function actionGetDev(){
        $devbrand_id=$this->getParam('devbrand_id');
        $data=\yii\db\ActiveRecord::findBySql("select * from goods where brand_id='$devbrand_id'")->asArray()->all();
        return $data;
    }

    //获取所有的设备厂家
    public function actionGetDevfactory(){
        $data=\yii\db\ActiveRecord::findBySql("select * from dev_factory")->asArray()->all();
        return $data;
    }

}
