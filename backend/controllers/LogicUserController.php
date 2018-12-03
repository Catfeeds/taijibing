<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 17:01
 */
namespace backend\controllers;

use backend\models\Address;
use backend\models\AdminRoles;
use backend\models\AdminRoleUser;
use backend\models\AgentInfo;
use backend\models\DevFactory;
use backend\models\FactoryInfo;
use yii;
use yii\data\Pagination;

class LogicUserController extends BaseController
{


    /**
     * 设备厂家列表
     */
     public function actionDevfactoryList(){

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

         $datas = DevFactory::findWithCondition($username,$mobile,$province,$city,$area,$sort);

         if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
             $page=ceil($datas->count()/$page_size);
         }

         $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//         $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
         $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
         $address=(new Address())->allQuery()->asArray()->all();

         //根据登陆者的信息，获取登陆者的角色
         $login_id=Yii::$app->user->id;
         //获取角色id
         $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;

//         var_dump($no);exit;
         return $this->render('devfactoryList', [
             'role_id' => $role_id,
             'model' => $model,
             'pages' => $pages,
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
    public function actionAgentList(){

        $datas = AgentInfo::find();
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('agentList', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }
    //县区运营中心
    public function actionAgentxlist(){

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
        $level=4;//县区运营中心
        $datas = AgentInfo::pageQueryWithCondition2($username,$mobile,$province,$city,$area,$level,$sort);

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model =  $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        //县级代理
        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;
        //获取角色



        return $this->render('agentList', [
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

    //社区服务中心
    public function actionAgentslist(){

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
        $level=5;//社区服务中心
        $datas =AgentInfo::pageQueryWithCondition($username,$mobile,$province,$city,$area,$level,$sort);

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

//var_dump($datas);exit;
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
        //上级
//        foreach($model as &$v){
//            $parent=$this->GetParentByAgentF($v['Id']);
//            $v['AreaCenterName']=$parent['agentPname'];
//            $v['ParentName']=$parent['agentYname'];
//        }

//        var_dump($datas);exit;
        $address=(new Address())->allQuery()->asArray()->all();
        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;

        return $this->render('agentList2', [
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

    //选择该服务中心的可卖设备
    public function actionSelectDev(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $agent_id=$this->getParam('agent_id');
        $name=$this->getParam('name');
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');
        $page=$this->getParam('page');//前端要求添加
        if(empty($agent_id)||empty($name)||empty($province)||empty($city)||empty($area)){
//        if(empty($agent_id)||empty($name)){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

        //前端要求添加
        $page_url = 'hotel-center/index';
        if(is_null($page)){
            $page_url= 'logic-user/agentslist';
        }

        //获取该服务中心已添加的设备
//        $datas=yii\db\ActiveRecord::findBySql("select * from dev_agent_investor where agent_id=$agent_id and agent_name='$name'")->asArray()->all();
        $datas=yii\db\ActiveRecord::findBySql("select dev_agent_investor.*, agent_info.Name,brands.BrandName,goods.name as GoodsName
        from dev_agent_investor
        left join agent_info on agent_info.Id=dev_agent_investor.investor_id
        left join brands on brands.BrandNo=dev_agent_investor.brand_id
        left join goods on goods.id=dev_agent_investor.goods_id
        where dev_agent_investor.agent_id=$agent_id ")->asArray()->all();
        //获取该服务中心已添加的入网属性（agent_id=0是共有的，state=-1是删除的）
        $use_types_add=yii\db\ActiveRecord::findBySql("select code,use_type from agent_usetype_code where (agent_id=$agent_id or agent_id=0) and state=0")->asArray()->all();
        //服务中心已勾选的入网属性代号
        $use_types_select=yii\db\ActiveRecord::findBySql("select code from agent_usetype where agent_id=$agent_id")->asArray()->one();

        //该服务中心的电话白名单数据
//        $white_datas=yii\db\ActiveRecord::findBySql("select id,tel,max from tel_white_list where agent_id=$agent_id")->asArray()->all();
        $white_datas='';

        return $this->renderPartial('set-dev',
            [
                'name'=>$name,
                'agent_id'=>$agent_id,
                "data" => $datas,
                "use_types_add" => $use_types_add,//入网属性
                "use_types_select" => $use_types_select,//已勾选的
                "province" => $province,
                "city" => $city,
                "area" => $area,
                "page_url" => $page_url,//前端要求添加
                'url'=>$urlobj,
                'white_datas'=>$white_datas,//电话白名单数据
            ]);




    }

    //获取该服务中心所在区域 与投资商投资区域相符 的所有设备投资商
    public function actionGetDevinvestor(){
        $province=str_replace('省','',$this->getParam('province'));
        $city=str_replace('市','',$this->getParam('city'));
        $area=$this->getParam('area');

        if(empty($province)||empty($city)||empty($area)){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

//        $datas=yii\db\ActiveRecord::findBySql("select Id as agent_id,`Name` as investor from agent_info
//where Level=6 and Id in (select agent_id from investor GROUP BY agent_id )
// ")->asArray()->all();


//        $datas1=yii\db\ActiveRecord::findBySql("select agent_id,investor from investor where province='全国' AND city='全部' group by agent_id")->asArray()->all();
        $datas=yii\db\ActiveRecord::findBySql("select Id as agent_id,`Name` as investor
from agent_info
where Level=6
and (Id in (select agent_id from investor
        where province='全国' AND city='全部' GROUP BY agent_id )
    or Id in (select agent_id from investor
        where province='$province' AND city='全部' GROUP BY agent_id )
    or Id in (select agent_id from investor
        where province='$province' AND city='$city' GROUP BY agent_id ))
group by Id
")->asArray()->all();

        return $datas;
//        var_dump($datas);
    }
    //获取对应投资商的品牌
    public function actionGetDevbrand(){
        $agent_id=$this->getParam('agent_id');

        $province=str_replace('省','',$this->getParam('province'));
        $city=str_replace('市','',$this->getParam('city'));
        $area=$this->getParam('area');

        if(empty($agent_id)||empty($province)||empty($city)||empty($area)){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

        $datas=yii\db\ActiveRecord::findBySql("select brands.BrandName,
brands.BrandNo
from investor
LEFT JOIN goods ON investor.goods_id=goods.id
LEFT JOIN brands ON goods.brand_id=brands.BrandNo
where investor.`agent_id`=$agent_id
and ((investor. province='全国' AND investor.city='全部')
    or (investor.province='$province' AND investor.city='全部')
    or (investor.province='$province' AND investor.city='$city'))
GROUP BY BrandName
")->asArray()->all();
        return $datas;

    }

    //获取对应投资商、对应品牌的设备
    public function actionGetDev(){
        $agent_id=$this->getParam('agent_id');
        $brand_id=$this->getParam('brand_id');

        $province=str_replace('省','',$this->getParam('province'));
        $city=str_replace('市','',$this->getParam('city'));
        $area=$this->getParam('area');

        if(empty($agent_id)||empty($brand_id)||empty($province)||empty($city)||empty($area)){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

        $datas=yii\db\ActiveRecord::findBySql("SELECT id,goodsname FROM (
select brands.BrandNo,goods.name as goodsname,goods.id
from investor
LEFT JOIN goods ON investor.goods_id=goods.id
LEFT JOIN brands ON goods.brand_id=brands.BrandNo
where investor.`agent_id`=$agent_id
and ((investor. province='全国' AND investor.city='全部')
    or (investor.province='$province' AND investor.city='全部')
    or (investor.province='$province' AND investor.city='$city'))
) as temp
where BrandNo='$brand_id'
")->asArray()->all();

        return $datas;

    }


    //添加入网属性
    public function actionAddUseType(){
        $use_type=addslashes($this->getParam("use_type"));//入网属性
        $agent_id=addslashes($this->getParam("agent_id"));//服务中心id
        $service_charge=addslashes($this->getParam("service_charge"));//服务费
        $water_charge=addslashes($this->getParam("water_charge"));//水费
        if($use_type==''||$agent_id==''||$service_charge==''||$water_charge==''){
            return json_encode(['state'=>-1,'mas'=>'参数错误']);
        }

        $transaction=Yii::$app->db->beginTransaction();
        try{

            //生成入网属性代号
            $max_code=yii\db\ActiveRecord::findBySql("select max(`code`) as code from `agent_usetype_code`")->asArray()->one()['code'];
            $code=intval($max_code)+1;//入网属性代号
            //保存
            $re=Yii::$app->db->createCommand("insert into agent_usetype_code (`code`,`use_type`,`agent_id`,`service_charge`,`water_charge`) VALUES ($code,'$use_type',$agent_id,$service_charge,$water_charge)")->execute();

            if(!$re)throw new yii\db\Exception('添加失败');

            //将刚添加的入网属性默认选中
            //判断agent_usetype表是否有该条记录
            $data=yii\db\ActiveRecord::findBySql("select code from agent_usetype where agent_id=$agent_id")->asArray()->one();
            if($data){//有该条记录并且修改了入网属性，直接修改
                if($data['code']) {
                    $use_types = $data['code'] . ',' . $code;
                }else{
                    $use_types=$code;
                }

                    $re = \Yii::$app->getDb()->createCommand("update agent_usetype set `code` = '$use_types' where agent_id=$agent_id")->execute();
                    if (!$re) {
                        throw new yii\db\Exception('修改失败1');
                    }


            }else{//添加
                $re = \Yii::$app->getDb()->createCommand("insert into agent_usetype(`agent_id`,`code`) values($agent_id,'$code')")->execute();
                if (!$re) {
                    throw new yii\db\Exception('修改失败2');
                }
            }

                $transaction->commit();
                return json_encode(['state'=>0,'code'=>$code]);

        }catch (yii\db\Exception $e) {
            $transaction->rollBack();
            return  json_encode(['state'=>-1,'mas'=>$e->getMessage()]);
        }
    }
    //删除入网属性
    public function actionDelUseType(){
        $code=addslashes($this->getParam("code"));//入网属性代号
        $agent_id=addslashes($this->getParam("agent_id"));//服务中心id
        if($code==''||$agent_id==''){
            return json_encode(['state'=>-1,'mas'=>'参数错误']);
        }

        $transaction=Yii::$app->db->beginTransaction();
        try{

            //在agent_usetype_code将对应code的state改成-1
            $res=Yii::$app->db->createCommand("update agent_usetype_code set state=-1 where code=$code and agent_id=$agent_id")->execute();
            if(!$res) {//修改
                throw new yii\db\Exception('删除失败1');
            }
            //判断删除的该属性是否是之前已勾选的
            $data=yii\db\ActiveRecord::findBySql("select code from agent_usetype where agent_id=$agent_id")->asArray()->one();
            if($data){
                $codes_str=$data['code'];
                $code_arr = explode(",", $codes_str);
                if(in_array($code,$code_arr)){//删除的属性之前勾选了的
                    //将删除的去除
                    unset($code_arr[array_search($code , $code_arr)]);
                    //将数组转换成字符串
                    $codes=implode(",", $code_arr);
                    $re=Yii::$app->db->createCommand("update agent_usetype set code='$codes' where agent_id=$agent_id")->execute();
                    if(!$re){
                        throw new yii\db\Exception('删除失败2');
                    }
                }
            }



            $transaction->commit();
            return json_encode(['state'=>0]);

        }catch (yii\db\Exception $e){

            $transaction->rollBack();
    //                var_dump($e->getMessage());exit;

            return json_encode(['state'=>-1,'mas'=>'删除失败']);


        }

    }

    //保存对应服务中心的入网属性
    public function actionSaveUseType(){
        $use_types = urldecode($this->getParam("use_types"));//对应服务中心已勾选入网属性数据
        $agent_id = urldecode($this->getParam("agent_id"));//服务中心agent_info表的id
        if($use_types==''&&$agent_id==''){
            return json_encode(['state'=>-1,'mas'=>'参数错误']);
        }
        if($use_types==''&&$agent_id!=''){
            return json_encode(['state'=>-1,'mas'=>'至少勾选一个购水套餐']);
        }

        //保存对应服务中心的入网属性
        //判断agent_usetype表是否有该条记录
        $data=yii\db\ActiveRecord::findBySql("select code from agent_usetype where agent_id=$agent_id")->asArray()->one();
        $re='';
        if($data){//有该条记录并且修改了入网属性，直接修改
            if($data['code']!=$use_types){

                $re = \Yii::$app->getDb()->createCommand("update agent_usetype set `code` = '$use_types' where agent_id=$agent_id")->execute();

            }

        }else{//添加
            $re = \Yii::$app->getDb()->createCommand("insert into agent_usetype(`agent_id`,`code`) values($agent_id,'$use_types')")->execute();
        }
        if (!$re) {
            $datas["state"] = -1;
            $datas["msg"] = '失败';
        }else{
            $datas["state"] = 0;
            $datas["msg"] = '成功';
        }

        $this->jsonReturn($datas);

    }


    //保存对应服务中心的可卖设备信息
    public function actionSaveSellDev(){
        $agent_id = urldecode($this->getParam("agent_id"));//服务中心agent_info表的id
        $agent_name = urldecode($this->getParam("name"));//服务中心name
        $investor_id = urldecode($this->getParam("investor_id"));//投资商id
        $brand_id = urldecode($this->getParam("brand_id"));//品牌id
        $goods_id = urldecode($this->getParam("goods_id"));//商品id
        if(!$agent_id||!$agent_name||!$investor_id||!$brand_id||!$goods_id){
            return ['state'=>-1,'msg'=>'参数错误'];
        }
        //检查是否添加过该设备
        $resule=$this->CheckSameDev($agent_id,$investor_id,$brand_id,$goods_id);
        if($resule){
            return ['state'=>-1,'msg'=>'该设备已添加过了'];
        }

        //添加到dev_agent_investor表
        $res = \Yii::$app->getDb()->createCommand("insert into dev_agent_investor(`agent_id`,`investor_id`,`brand_id`,`goods_id`,`agent_name`) values($agent_id,$investor_id,'$brand_id',$goods_id,'$agent_name')")->execute();
        $insert_id=Yii::$app->db->getLastInsertID();
        if (!$res) {
            return ['state'=>-1,'msg'=>'失败'];
        }
        return ['state'=>0,'id'=>$insert_id];


    }
    //删除对应服务中心的可卖设备信息
    public function actionDelSellDev(){
        $id = urldecode($this->getParam("id"));//dev_agent_investor表的id
        if(!$id){
            return ['state'=>-1,'msg'=>'参数错误'];
        }
        //删除
        $re=\Yii::$app->getDb()->createCommand("delete from dev_agent_investor where id=$id ")->execute();

        if(!$re) {
            return ['state'=>-1,'msg'=>'失败'];
        }

        return ['state'=>0,'msg'=>'成功'];


    }

    //修改对应服务中心的可卖设备信息
    public function actionUpdateSellDev(){
        $id = urldecode($this->getParam("id"));//dev_agent_investor表的id
        $agent_id = urldecode($this->getParam("agent_id"));//服务中心id
        $agent_name = urldecode($this->getParam("name"));//服务中心name
        $investor_id = urldecode($this->getParam("investor_id"));//投资商id
        $brand_id = urldecode($this->getParam("brand_id"));//品牌id
        $goods_id = urldecode($this->getParam("goods_id"));//商品id
        if(!$id||!$agent_id||!$agent_name||!$investor_id||!$brand_id||!$goods_id){
            return ['state'=>-1,'msg'=>'参数错误'];
        }
        //检查是否添加过该设备
        $resule=$this->CheckSameDev($agent_id,$investor_id,$brand_id,$goods_id);
        if($resule){
            return ['state'=>-1,'msg'=>'该设备已添加过了'];
        }

        $re=\Yii::$app->getDb()->createCommand("update dev_agent_investor
         set investor_id=$investor_id,agent_name='$agent_name',brand_id='$brand_id',
         goods_id=$goods_id
         where id=$id and agent_id=$agent_id ")->execute();

        if(!$re) {
            return ['state'=>-1,'msg'=>'失败'];
        }

        return ['state'=>0,'msg'=>'成功'];

    }

    //检查是否添加过该设备
    public function CheckSameDev($agent_id,$investor_id,$brand_id,$goods_id){
        $data=yii\db\ActiveRecord::findBySql("select id from dev_agent_investor
        where agent_id=$agent_id and investor_id=$investor_id and brand_id='$brand_id'
        and goods_id=$goods_id
        ")->asArray()->one();
        if($data){
            return true;
        }
        return false;
    }


    //ajax添加电话白名单
    public function actionAddWhiteList(){
        $agent_id=$this->getParam('agent_id');
        $tel=$this->getParam('tel');
        $max=$this->getParam('max');
        if($agent_id==''||$tel==''||$max==''){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $re=Yii::$app->db->createCommand("insert into tel_white_list (`agent_id`,`tel`,`max`) values($agent_id,'$tel',$max)")->execute();
        if(!$re){
            return json_encode(['state'=>-1,'msg'=>'添加失败']);
        }
        return json_encode(['state'=>0]);
    }

    //ajax修改电话白名单
    public function actionEditWhiteList(){
        $id=$this->getParam('id');
        $max=$this->getParam('max');
        if($id==''||$max==''){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $re=Yii::$app->db->createCommand("update tel_white_list set max=$max where id=$id")->execute();
        if(!$re){
            return json_encode(['state'=>-1,'msg'=>'修改失败']);
        }
        return json_encode(['state'=>0]);
    }

    //ajax删除电话白名单
    public function actionDelWhiteList(){
        $id=$this->getParam('id');
        if($id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $re=Yii::$app->db->createCommand("delete from tel_white_list where id=$id ")->execute();
        if(!$re){
            return json_encode(['state'=>-1,'msg'=>'删除失败']);
        }
        return json_encode(['state'=>0]);
    }



    //保存可卖设备
    public function actionSaveDev(){
        $subgoodtypes = urldecode($this->getParam("subgoodtypes"));//对应服务中心可卖设备数据
//        $use_types = urldecode($this->getParam("use_types"));//对应服务中心已勾选入网属性数据
        $agent_id = urldecode($this->getParam("agent_id"));//服务中心agent_info表的id
        $name = urldecode($this->getParam("name"));//服务中心name
        if(empty($agent_id)||empty($name)){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
//var_dump($use_types);exit;
        //对应服务中心可卖设备数据
        $GoodsTypeArr = json_decode($subgoodtypes,true);
        //判断添加的可卖设备是否有重复的
//        for ($index = 0; $index < count($GoodsTypeArr); $index++) {
//
//            $item = $GoodsTypeArr[$index];
//
//            if(!empty($item)){
//                $re=$this->CheckSameDev($agent_id,$item->devinvestor,$item->devbrand,$item->devname);
//                if($re){
//                    $this->jsonReturn(['state'=>-1,'msg'=>'不能添加重复的可卖设备']);
//                }
//
//            }
//        }
        $a=array_column($GoodsTypeArr,'devname');
        if (count($a) != count(array_unique($a))){
            $data["state"] = -1;
            $data["msg"] = '不能添加重复的商品';
            $this->jsonReturn($data);
            return;
        }
        //开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $investor=\yii\db\ActiveRecord::findBySql("select * from dev_agent_investor where agent_id=$agent_id ")->asArray()->all();
//            $tels=\yii\db\ActiveRecord::findBySql("select * from tel_white_list where agent_id=$agent_id ")->asArray()->all();

            if(!empty($investor)){
                //先删除原来的再重新保存
                $re=\Yii::$app->getDb()->createCommand("delete from dev_agent_investor where agent_id=$agent_id ")->execute();
                if(!$re) {
                    throw new yii\db\Exception('删除原来的数据失败');
                }
            }

            //保存可卖设备
            if($GoodsTypeArr){
                $sql_str='insert into dev_agent_investor(`agent_id`,`investor_id`,`brand_id`,`goods_id`,`agent_name`) values ';
                $tag='';//标记sql_str后面是否需要加逗号
                for ($index = 0; $index < count($GoodsTypeArr); $index++) {

                    $item = $GoodsTypeArr[$index];

                    if($item&&$tag==''){
                        $sql_str.="($agent_id,{$item['devinvestor']},'{$item['devbrand']}',{$item['devname']},'$name')";
                        $tag=1;
                    }elseif($item&&$tag==1){
                        $sql_str.=",($agent_id,{$item['devinvestor']},'{$item['devbrand']}',{$item['devname']},'$name')";

                    }
                }
                //添加到dev_agent_investor表
                $res = \Yii::$app->getDb()->createCommand($sql_str)->execute();

                if (!$res) {
                    throw new yii\db\Exception('保存可卖设备失败');
                }
            }

            //保存成功后，将添加的数据返回
            $datas=yii\db\ActiveRecord::findBySql("select dev_agent_investor.investor_id,
            dev_agent_investor.brand_id,dev_agent_investor.goods_id,agent_info.Name,
            brands.BrandName,goods.name as GoodsName
            from dev_agent_investor
            inner join agent_info on dev_agent_investor.investor_id=agent_info.Id
            inner join brands on dev_agent_investor.brand_id=brands.BrandNo
            inner join goods on dev_agent_investor.goods_id=goods.id
            where dev_agent_investor.agent_id=$agent_id
            ")->asArray()->all();

            //保存对应服务中心的入网属性
                    //判断agent_usetype表是否有该条记录
//                    $data=yii\db\ActiveRecord::findBySql("select code from agent_usetype where agent_id=$agent_id")->asArray()->one();
////                    $re=0;
//                    if($data){//有该条记录并且修改了入网属性，直接修改
//                        if($data['code']!=$use_types){
//
//                            $re = \Yii::$app->getDb()->createCommand("update agent_usetype set `code` = '$use_types' where agent_id=$agent_id")->execute();
//                            if (!$re) {
//                                throw new yii\db\Exception('失败');
//                            }
//                        }
//
//                    }else{//添加
//                        $re = \Yii::$app->getDb()->createCommand("insert into agent_usetype(`agent_id`,`code`) values($agent_id,'$use_types')")->execute();
//                        if (!$re) {
//                            throw new yii\db\Exception('失败');
//                        }
//                    }



            $transaction->commit();

            $data["state"] = 0;
            $data["datas"] = $datas;
            $this->jsonReturn($data);
        }catch (yii\db\Exception $e){
            $transaction->rollBack();
            $data["state"] = -1;
            $data["msg"] = $e->getMessage();
            $this->jsonReturn($data);
        }


    }




    //水厂 已弃用
    public function actionFactoryList()
    {
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

        $sort = $this->getParam("sort");//点击排序
        if ($sort == '') {
            $sort = 0;
        }


        $username = addslashes($this->getParam("username"));
        $mobile = addslashes($this->getParam("mobile"));
        $province = $this->getParam("province");
        $city = $this->getParam("city");
        $area = $this->getParam("area");
        $water_brand = $this->getParam("water_brand");
        $water_name = $this->getParam("water_name");
//        var_dump($water_brand,$water_name);exit;
        $datas = FactoryInfo::findWithCondition($water_brand,$water_name,$username, $mobile, $province, $city, $area, $sort);
//        var_dump($datas);exit;

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }


        $pages = new Pagination([
            'totalCount' => $datas->count(),
            'pageSize' => $page_size,
        ]);
//        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model = yii\db\ActiveRecord::findBySql($datas->sql . " limit " . $pages->offset . "," . $pages->limit)->asArray()->all();
//        var_dump($model);exit;
        $address = (new Address())->allQuery()->asArray()->all();
//var_dump($model);exit;

        //根据登陆者的信息，获取登陆者的角色
        $login_id = Yii::$app->user->id;
        //获取角色id
        $role_id = AdminRoleUser::findOne(['uid' => $login_id])->role_id;

        //水品牌
        $water_brands=yii\db\ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=1")->asArray()->all();
        //水商品型号
        $water_names=yii\db\ActiveRecord::findBySql("select id,`name`,brand_id from goods where category_id=1 and state=0")->asArray()->all();

        return $this->render('factoryList', [
            'role_id' => $role_id,
//            'BrandName' => $BrandName,
//            'LeftAmount' => $LeftAmount,
            'model' => $model,
            'pages' => $pages,
            'address' => $address,
            'username' => empty($username) ? "" : $username,
            'mobile' => empty($mobile) ? "" : $mobile,
            'province' => empty($province) ? "" : $province,
            'city' => empty($city) ? "" : $city,
            'area' => empty($area) ? "" : $area,
            'sort' => $sort,
            'page_size' => $page_size,
            'page' => $page,
            'water_brands' => $water_brands,
            'water_names' => $water_names,
            'water_brand' => $water_brand,
            'water_name' => $water_name,

        ]);
    }


}