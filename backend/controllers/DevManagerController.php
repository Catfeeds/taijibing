<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/6
 * Time: 下午5:35
 */

namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);
use backend\models\Address;
use backend\models\AdminRoles;
use backend\models\AdminRoleUser;
use backend\models\AgentInfo;
use backend\models\CustomSearch;
use backend\models\DevCmd;
use backend\models\DevFactory;
use backend\models\DevLocation;
use backend\models\DevWaterScan;
use backend\models\FactoryInfo;
use backend\models\User;
use EasyWeChat\Core\Exception;
use yii\data\Pagination;
use backend\models\DevRegist;
use yii;

//require 'F:\TJB\vendor\vendor\phpoffice\phpexcel\Classes/PHPExcel.php';
class DevManagerController extends BaseController
{

    //入网属性
    public $UserType=[
        ''=>'',
        0=>'',
        1=>'自购',
        2=>'押金',
        3=>'买水借机',
        4=>'买机送水',
        5=>'免费',
        99=>'其他',
    ];
    //客户类型
    public $CustomerType=[
        ''=>'',
        0=>'',
        1=>'家庭',
        2=>'公司',
        3=>'集团',
        4=>'酒店',
        99=>'其他',
    ];

    public function actionList()
    {

        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页
//var_dump($page_size);exit;
        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }


        $sort=$this->getParam("sort");//点击排序
        if($sort==''){
            $sort=0;
        }


        $search=addslashes($this->getParam("search"));
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $state=$this->getParam("state");//状态：1 正常，2 已初始化，3 未登记（编号为0）
        if($state==''){
            $state=1;
        }

//        $datas =DevRegist::allQuery($devno,$xname,$sname,$mobile,$devf,$tel,$province,$city,$area);
        $datas =DevRegist::allQuery2($state,$search,$province,$city,$area,$sort);
//var_dump($datas->sql);exit;
        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        $querys =DevRegist::pageQuery2($pages->offset,$pages->limit,$search,$province,$city,$area,$sort);
        $querys=yii\db\ActiveRecord::findBySql($datas->sql.' limit '.$pages->offset.','.$pages->limit);
//        $model =$this->listWrapData($querys->asArray()->all());
        $model =$querys->asArray()->all();
        //上级
        foreach($model as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['agentname']=$parent['agentFname'];
//            $v['agentPname']=$parent['agentPname'];
            $v['agentpname']=$parent['agentYname'];
        }

        //获取已初始化的设备编号
        $DevNos=yii\db\ActiveRecord::findBySql("select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo")->asArray()->all();
        $users_of_init=[];
        foreach($DevNos as $DevNo){
            $users_of_init[]=$DevNo['DevNo'];
        }
        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;



        $waterFlist=FactoryInfo::find()->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        return $this->render('list', [

            'search' => $search,
            'role_id' => $role_id,
            'model' => $model,
            'pages' => $pages,
            'devno' =>empty($devno)?"":$devno,
            'xname' =>empty($xname)?"":$xname,
            'sname'=>empty($sname)?"":$sname,
            'mobile'=>empty($mobile)?"":$mobile,
            'devf'=>empty($devf)?"":$devf,
            'tel'=>empty($tel)?"":$tel,
            'address'=>$address,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
            'waterFs'=>$waterFlist,
            'sort' => $sort,
            'page_size' => $page_size,
            'page' => $page,
            'state' => $state,

            'users_of_init' => $users_of_init,
//            'State' => $State,
        ]);
    }

    //根据选择的状态获取条件
    public function getStr($state1,$state2,$state3){
        $str='';
        if($state1==1&&!$state2&&!$state3){//只显示正常设备

            $str = " where IsActive=1 and DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo) ";
        }
        if(!$state1&&$state2==1&&!$state3){//只显示未激活设备

            $str= " where IsActive=0 and DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo) ";
        }
        if(!$state1&&!$state2&&$state3==1){//只显示已初始化设备

            $str= " where DevNo in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo) ";
        }
        if($state1==1&&$state2==1&&!$state3){//只显示正常设备和未激活设备

            $str= " where DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo) ";
        }
        if($state1==1&&!$state2&&$state3==1){//只显示正常设备和已初始化设备

            $str= " where  (IsActive = 1 or DevNo in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo))";
        }
        if(!$state1&&$state2==1&&$state3==1){//只显示未激活设备和已初始化设备

            $str= " where (IsActive = 0 or DevNo in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo))";
        }
        return $str;
    }



    //已初始化设备的操作记录
    public function actionActLog(){
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

        $search=addslashes($this->getParam("search"));
        $DevNo=$this->getParam("DevNo");
        $selecttime=$this->getParam("selecttime");
        $State=$this->getParam("State");//显示设备动态或扫码记录
        if($State==''){
            $State=0;
        }
        if(empty($DevNo)){
            Yii::$app->getSession()->setFlash('error', '参数错误');
            return $this->redirect(['act-log']);
        }

        $str='';
        $model='';
        if($State==0){//设备动态
            //获取该设备的动态
            $datas=DevRegist::dynamicAllQuery2($search,$DevNo,$selecttime);
            if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
                $page=ceil($datas->count()/$page_size);
            }

            $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
            $model=yii\db\ActiveRecord::findBySql($datas->sql.' limit '.$pages->offset.','.$pages->limit)->asArray()->all();
        }
        if($State==1){//已初始化设备扫码记录
            //获取该设备的扫码记录
            $datas=DevWaterScan::totalQueryA($search,$DevNo,$selecttime);
            if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
                $page=ceil($datas->count()/$page_size);
            }

            $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
            $model=yii\db\ActiveRecord::findBySql($datas->sql.' limit '.$pages->offset.','.$pages->limit)->asArray()->all();
        }

        return $this->render('act-log', [
            'model' => $model,
            'content' => $search,
            'selecttime' => $selecttime,
            'pages' => $pages,
            'page_size' => $page_size,
            'page' => $page,
            'State' => $State,
            'DevNo' => $DevNo,
        ]);


    }

    public function actionDevList(){
        $devno=yii::$app->request->post("devno");
        $xname=yii::$app->request->post("xname");
        $sname=yii::$app->request->post("sname");

        $datas =DevRegist::allQuery($devno,$xname,$sname);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $querys =DevRegist::pageQuery($pages->offset,$pages->limit,$devno,$xname,$sname);
        $model =$this->listWrapData($querys->asArray()->all());
        $waterFlist=FactoryInfo::find()->asArray()->all();
        return $this->render('dev-list', [
            'model' => $model,
            'pages' => $pages,
            'devno' =>empty($devno)?"":$devno,
            'xname' =>empty($xname)?"":$xname,
            'sname'=>empty($sname)?"":$sname,
            'waterFs'=>$waterFlist
        ]);
    }
    public function listWrapData($list){
        $listTemp=[];
        foreach($list as $val){
            $agentId=$val["AgentId"];
            $agentInfo=(new AgentInfo())->getAgentInfoById($agentId);
            if($agentInfo["Level"]==4){//运营中心
//                $val["agentpname"]=$agentInfo["LoginName"];
                $val["agentpname"]=$agentInfo["Name"];//运营中心名称
                $val["agentname"]="-";
            }else{
                //社区
                $parentId=$agentInfo["ParentId"];
//                $val["agentname"]=$agentInfo["LoginName"];
                $val["agentname"]=$agentInfo["Name"];
                if(empty($parentId)){
                    $val["agentpname"]="-";
                }else{
                    $agentpInfo=(new AgentInfo())->getAgentInfoById($parentId);
//                    $val["agentpname"]=$agentpInfo["LoginName"];
                    $val["agentpname"]=$agentpInfo["Name"];

                }
            }
            $listTemp[]=$val;
        }
        return $listTemp;
    }
    public function actionDynamic(){

        //点击刷新时real_time=1
        $real_time=$this->getParam('real_time');//1 实时获取，0
        //点击查询时
        $real_search=$this->getParam('real_search');//1 实时获取，0

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
            $sort=0;
        }

//        $tel=yii::$app->request->get("tel");
        $selecttime=$this->getParam("selecttime");
        $content=addslashes(trim($this->getParam("content")));
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");

        $state=$this->getParam("state");
        if (!$state) {
            $state = 1;//1:正常设备 2:已初始化的 3：没有绑定用户的设备
        }
        //有刷新或有搜索，实时读取
//        if($real_time||$real_search){

            $datas = DevRegist::dynamicAllQuery($state, $content, $province, $city, $area, $selecttime, $sort);

            if (ceil($datas->count() / $page_size) < $page) {//输入的页数大于总页数
                $page = ceil($datas->count() / $page_size);
            }

            $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);

            $querys = yii\db\ActiveRecord::findBySql($datas->sql . " limit $pages->offset,$pages->limit");

            $model = $querys->asArray()->all();
//        }else{//没有刷新、没有搜索，从缓存文件取
//            //登陆者
//            $user = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
//            $logic_type=$user->getAttribute("logic_type");
//
//            $devaction_data=json_decode(trim(substr(file_get_contents('../web/datas/DevActionDatas.php'), 15)));
//
//            $result=json_decode($devaction_data->datas,true);
//            if ($logic_type == 3||$logic_type == 4) {//代理商登陆
//                $login_name=$user->getAttribute("username");
//                $agent_info=AgentInfo::findOne(['LoginName'=>$login_name]);
//                $agent_id=$agent_info->Id;
//                $model=[];
//                if(!empty($result)){
//                    foreach($result as $v){
//
//                        if($v['AgentId']==$agent_id){
//                            $model[]=$v;
//                        }
//                    }
//                }
//
//                $pages = new Pagination(['totalCount' => count($model), 'pageSize' => $page_size]);
//                //var_dump($model);exit;
//
//            }else{
//                $pages = new Pagination(['totalCount' => json_decode($devaction_data->total), 'pageSize' => $page_size]);
//            }
//            if(!empty($result)){
//                $model=array_slice($result,$pages->offset,$pages->limit);
//            }else{
//                $model=$result;
//            }
//
////                foreach($model as &$v){
////                    if(is_object($v)){
////                        $v=(array)$v;
////                    }
////                }
////                var_dump($model);exit;
//
//        }
        $areas=Address::allQuery()->asArray()->all();

        //获取已初始化的设备编号
        $DevNos=yii\db\ActiveRecord::findBySql("select DISTINCT DevNo from dev_cmd
        where CmdType=4 and State=1 ")->asArray()->all();
        $users_of_init=array_column($DevNos,'DevNo');
        //获取导出表格时的数据总条数
        $total=yii\db\ActiveRecord::findBySql("select LogId from dev_action_log")->count();


        return $this->render('dynamic', [
            'selecttime'=>$selecttime,
            'model' => $model,
            'areas' =>$areas,
            'pages' => $pages,
//            'tel' =>empty($tel)?"":$tel,
            'content' =>empty($content)?"":$content,
            'province' =>empty($province)?"":$province,
            'city' =>empty($city)?"":$city,
            'area' =>empty($area)?"":$area,
            'sort' =>$sort,
            'page_size' => $page_size,
            'page' => $page,
            'state' => $state,
            'total' => $total,

            'users_of_init' => $users_of_init,

        ]);
    }

    public function actionSendOrder(){

        $CmdType=yii::$app->request->get("CmdType");
        $Cmd=yii::$app->request->get("Cmd");
        $StartTime=yii::$app->request->get("StartTime");
        $ExpiredTime=yii::$app->request->get("ExpiredTime");
        $DevNo=yii::$app->request->get("DevNo");
        if(!is_numeric($CmdType)||empty($StartTime)||empty($ExpiredTime)||empty($DevNo)){
            $this->jsonReturn($this->getWrapData(-1,null,"参数错误"));
            return;
        }

        //获取已分组的成员（判断是否是成员或组长）
        $group_data=yii\db\ActiveRecord::findBySql("
        select dev_regist.DevNo from user_restmoney
        inner join dev_regist on dev_regist.UserId=user_restmoney.UserId
        and dev_regist.AgentId=user_restmoney.AgentId
        and dev_regist.CustomerType=user_restmoney.CustomerType
        where dev_regist.AgentId > 0 and IsActive=1
        and not exists (select 1 from dev_cmd where CmdType=4 and State=1
        and DevNo=dev_regist.DevNo) and user_restmoney.GroupId > 0
        ")->asArray()->all();

        $group_no=array_column($group_data,'DevNo');

        //获取下发了初始化命令的设备编号
        $InitDatas=yii\db\ActiveRecord::findBySql("
        select distinct DevNo
        from dev_cmd
        where CmdType=4")->asArray()->all();
        $InitDatas=array_column($InitDatas,'DevNo');

        $datas=yii\db\ActiveRecord::findBySql("
        select distinct dev_regist.DevNo,dev_regist.AgentId,
        dev_regist.goods_id,dev_regist.brand_id,agent_stock.id,
        agent_stock.factory_id,agent_stock.stock
        from dev_regist
        inner join agent_stock on agent_stock.agent_id=dev_regist.AgentId
        and agent_stock.goods_id=dev_regist.goods_id
        where dev_regist.AgentId > 0")->asArray()->all();
        $Arr=[];
        foreach($datas as $v){
            $Arr[$v['DevNo']]=$v;
        }

//        $devnos=explode(",",$DevNo);
         $devcmd=new DevCmd();
        $transaction=Yii::$app->db->beginTransaction();
        try{
//            foreach($devnos as $val){
                //判断是否是成员或组长
                if(in_array($DevNo,$group_no)){
                    throw new yii\base\Exception('请先将该用户踢出所属组');
                }

                //初始化的时候将该用户对应的所有商品的自定义价格清除
                if($CmdType==4){
                    $user_price=yii\db\ActiveRecord::findBySql("
                    select dev_regist.UserId from dev_regist
                    inner join user_goods_price on user_goods_price.UserId=dev_regist.UserId
                    where dev_regist.DevNo='$DevNo'")->asArray()->one();
                    if($user_price){
                        $re=Yii::$app->db->createCommand("delete from user_goods_price where UserId='{$user_price['UserId']}'")->execute();
                        if(!$re){
                            throw new yii\base\Exception('删除价格失败');
                        }
                    }
                }

                //下发的是初始化命令，且之前没有下发过
                if($CmdType==4&&!in_array($DevNo,$InitDatas)){
                    if(!array_key_exists($DevNo,$Arr)){
                            throw new yii\base\Exception('没有库存');
                    }
                    $now=date('Y-m-d H:i:s');
                    //对应库存还原
                    $sql1="update agent_stock set stock=stock+1,update_time='$now' where id={$Arr[$DevNo]['id']}";
                    //入库记录
                    //累计入库数
                    $total=$this->GetTotal($Arr[$DevNo]['AgentId'],$Arr[$DevNo]['factory_id'],$Arr[$DevNo]['goods_id']);

                    $sql2="insert into agent_stock_log (agent_id,factory_id,bar_code,
                    goods_id,action_type,num,rest_stock,total,remark,row_time)
                    values ({$Arr[$DevNo]['AgentId']},{$Arr[$DevNo]['factory_id']},'$DevNo',
                    {$Arr[$DevNo]['goods_id']},1,
                    1,{$Arr[$DevNo]['stock']}+1,$total,5,'$now')";

                    $re=Yii::$app->db->createCommand($sql1)->execute();
                    if(!$re){
                        throw new yii\base\Exception('还原库存失败');
                    }
                    $re=Yii::$app->db->createCommand($sql2)->execute();
                    if(!$re){
                        throw new yii\base\Exception('添加入库记录失败');
                    }

                }
                $re=$devcmd->add($DevNo,$StartTime,$ExpiredTime,$Cmd,$CmdType);
                if(!$re){
                    throw new yii\base\Exception('下发命令失败');
                }
//            }
            $transaction->commit();
            $this->jsonReturn($this->getWrapData(0,null,''));
        }catch(yii\base\Exception $e){
            $transaction->rollBack();
            $this->jsonReturn($this->getWrapData(-1,null,$e->getMessage()));
        }

    }
    public function actionMap(){
        //登陆角色id
        $login_id=Yii::$app->getUser()->id;
        $role_id=(new AdminRoleUser())->findOne(['uid'=>$login_id])->role_id;
        $data=(new Address())->allQuery()->asArray()->all();
        $type=$this->getParam("type");
        return  $this->renderPartial("map",["address"=>$data,'role_id'=>$role_id,'type'=>$type]);
    }
    public function actionGetMarkers(){
        //登陆角色id
        $login_id=Yii::$app->getUser()->id;
        $role_id=(new AdminRoleUser())->findOne(['uid'=>$login_id])->role_id;

        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $usertype=$this->getParam("user_type");
        if(empty(trim($usertype))){
            return $this->jsonReturn($this->getWrapData(0,[],''));
        }
        $usertypeArr=explode(",",$usertype);
        $points=[];
        foreach($usertypeArr as $val){
            switch($val){
                //水厂
                case 1:$points=$this->array_push_all($points,$this->getFactoryPoints($role_id,$login_id));break;
                //县区运营中心
                case 2:$points=$this->array_push_all($points,$this->getAgentList(4,2));break;
                //社区服务中心
                case 3:$points=$this->array_push_all($points,$this->getAgentList(5,3));break;
                //设备厂家
                case 4:$points=$this->array_push_all($points,$this->getDevManagers());break;
                //饮水机用户
                case 5:$points=$this->array_push_all($points,$this->getCustomers($role_id,$login_id));break;
                //设备投资商
                case 6:$points=$this->array_push_all($points,$this->getAgentList(6,6));break;

            }
        }
        //根据地址获取中心坐标
        $address=$province.$city.$area;
        $data=$this->GetLatLng($address);
        if($data) {
            $center=['BaiDuLat'=>$data['lat'],'BaiDuLng'=>$data['lng'],'user_type'=>0];
            array_push($points,$center);

        }

            return $this->jsonReturn($points);
    }

    //根据地址获取经纬度
    function GetLatLng($address){
        if(!$address){
            return false;
        }
        $Url="http://api.map.baidu.com/geocoder?address=".$address."&output=json&key=96980ac7cf166499cbbcc946687fb414";
//        $Url="http://api.map.baidu.com/api?v=2.0&address=".$address."&output=json&ak=FCBpETlN4Snp2SfEl92y89WF";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出
        $result=curl_exec($ch);
        curl_close($ch);
        $infolist=json_decode($result);
        $array=array();
        if(isset($infolist->result->location) && !empty($infolist->result->location)){
            $array=array(
                'lng'=>$infolist->result->location->lng,
                'lat'=>$infolist->result->location->lat,
            );
//            var_dump($array);
            return $array;
        }
        else
        {
//            var_dump('失败');
            return false;
        }

    }


    //点击图标时显示对应的信息
    public function actionGetInfo(){
        $Id=$this->getParam("Id");
        $DevNo=$this->getParam("DevNo");
        $user_type=$this->getParam("user_type");
        $info='';
        switch($user_type){
            //水厂
            case 1:$info=yii\db\ActiveRecord::findBySql("select `Name`,ContractTel,Address from factory_info where Id=$Id")->asArray()->one();break;
            //县区运营中心
            case 2:$info=yii\db\ActiveRecord::findBySql("select `Name`,ContractTel,Address from agent_info where Id=$Id and Level=4")->asArray()->one();break;
            //社区服务中心
            case 3:$info=yii\db\ActiveRecord::findBySql("select `Name`,ContractTel,Address from agent_info where Id=$Id and Level=5")->asArray()->one();break;
            //设备厂家
            case 4:$info=yii\db\ActiveRecord::findBySql("select `Name`,ContractTel,Address from dev_factory where Id=$Id")->asArray()->one();break;
            //饮水机用户
            case 5:$info=yii\db\ActiveRecord::findBySql("select user_info.Name,user_info.Tel as ContractTel,user_info.Address,dev_regist.DevNo from dev_regist
                                                          left join user_info on dev_regist.UserId=user_info.Id
                                                          where dev_regist.DevNo='$DevNo'")->asArray()->one();break;
            //设备投资商
            case 6:$info=yii\db\ActiveRecord::findBySql("select `Name`,ContractTel,Address from agent_info where Id=$Id and Level=6")->asArray()->one();break;

        }
        return $this->jsonReturn($info);
    }


    public function getDevManagers(){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where='';
        if(!empty($province)){
            $where.="dev_factory.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_factory.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_factory.Area='$area'";
        }
        $devManagers=DevFactory::findBySql("select BaiDuLat,BaiDuLng,Id from dev_factory ".(empty($where)?"":" where ".$where))->asArray()->all();
        $temp=[];
        foreach($devManagers as $val){
            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
                continue;
            }
            $val["user_type"]=4;
            array_push($temp,$val);
        }
        return $temp;


    }
    public function getCustomers($role_id,$login_id){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where='';
        if(!empty($province)){
            $where.="dev_regist.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Area='$area'";
        }
        $str='';
        if($role_id==2){//水厂登陆
            $login_name=(new User())->findOne(['id'=>$login_id])->username;
            $per_code=(new FactoryInfo())->findOne(['LoginName'=>$login_name])->PreCode;
            if(!empty($where)){
                $where.=" and ";
            }
            $str=' inner join dev_water_scan on dev_water_scan.DevNo=dev_location.DevNo ';

            $where.="dev_water_scan.PreCode='$per_code'";
        }

        $users=DevLocation::findBySql("select dev_location.BaiDuLat,dev_location.BaiDuLng,dev_regist.DevNo
from dev_location
inner join dev_regist on dev_location.DevNo=dev_regist. DevNo
$str
where  dev_regist.AgentId > 0 and dev_regist.IsActive=1 and not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
".(empty($where)?"":" and ".$where)."
")->asArray()->all();
        $temp=[];
        foreach($users as $val){
//            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
            if($val["BaiDuLat"]<=0||$val["BaiDuLat"]>=90||$val["BaiDuLng"]<=0||$val["BaiDuLng"]>=180){
                continue;
            }
            $val["user_type"]=5;
            array_push($temp,$val);
        }
        return $temp;
    }
    public function getFactoryPoints($role_id,$login_id){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where='';
        if(!empty($province)){
            $where.="factory_info.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="factory_info.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="factory_info.Area='$area'";
        }
        if($role_id==2){//水厂登陆
            $login_name=(new User())->findOne(['id'=>$login_id])->username;
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="factory_info.LoginName='$login_name'";
        }


       $factList=  FactoryInfo::findBySql("select BaiDuLat,BaiDuLng,Id from factory_info".(empty($where)?"":" where ".$where))->asArray()->all();
       $temp=[];
        foreach($factList as $val){
            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
                continue;
            }
            $val["user_type"]=1;
            array_push($temp,$val);
        }
        return $temp;
    }
    public function getAgentList($level,$usertype){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where= "LEVEL =".$level;
        if(!empty($province)){
            $where.=" and agent_info.Province='$province'";
        }
        if(!empty($city)){

            $where.=" and agent_info.City='$city'";
        }
        if(!empty($area)){

            $where.=" and agent_info.Area='$area'";
        }
       $userList= AgentInfo::findBySql("select BaiDuLat,BaiDuLng,Id from agent_info where ".$where)->asArray()->all();
        $temp=[];
        foreach($userList as $val){
            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
                continue;
            }
            $val["user_type"]=$usertype;
            array_push($temp,$val);
        }
        return $temp;
    }

    public function array_push_all($oriArr,$arr){
        foreach($arr as $val){
            array_push($oriArr,$val);
        }
        return $oriArr;
    }


    //详情
    public function actionDetail(){
        $urlobj = $this->getParam("Url");//返回参数记录
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
            $sort=0;
        }
        $DevNo=$this->getParam('DevNo');
        $excel=$this->getParam("excel");

        $content=trim($this->getParam('content'));
        $selecttime=$this->getParam('selecttime');

//        if($DevNo=='') return $this->render('/error/error', [
//            'code' => '403',
//            'name' => 'Params required',
//            'message' => yii::t('app', "DevNo doesn't exit"),
//        ]);

        $startTime='';
        $endTime='';
        $where='';

        if($content){
            $ActType='';
            if($content=='开关机'){
                $ActType=1;
            }
            if($content=='调温'){
                $ActType=2;
            }
            if($content=='加热'){
                $ActType=4;
            }
            if($content=='消毒'){
                $ActType=8;
            }
            if($content=='抽水'){
                $ActType=16;
            }
            if($content=='上传'){
                $ActType=99;
            }
            if($ActType!=''){
                $where=" dev_action_log.ActType = $ActType ";
            }

        }

        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
//        var_dump($startTime,$endTime);exit;
        if(!empty($startTime)&&!empty($endTime)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" dev_action_log.RowTime >= '$startTime' and dev_action_log.RowTime <= '$endTime'";
        }

        //如果没有传设备编号就查询全部的
        if($DevNo!=''){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="dev_action_log.DevNo='$DevNo'";
        }

        //排序（操作时间）
        $order=" order by dev_action_log.RowTime desc ";
        if($sort && $sort%2==1){
            $order=" order by dev_action_log.RowTime asc ";
        }


        $sql="select DISTINCT user_info.Name,user_info.Tel,
dev_action_log.DevNo,dev_action_log.ActType,dev_action_log.WaterUse,dev_action_log.WaterRest,
dev_action_log.Dts,dev_action_log.Degrees,dev_action_log.ActTime,dev_action_log.RowTime,
goods.name as goodsname,brands.BrandName,
dev_factory.Name as factoryname,agent_info.Name as investor,agent.Name as agentname,
agent2.Name as agentpname,dev_regist.Province,dev_regist.City,dev_regist.Area,
dev_regist.UseType,dev_regist.CustomerType
from dev_action_log
left join user_info on dev_action_log.UserId=user_info.Id
left join dev_regist on dev_action_log.DevNo=dev_regist.DevNo
left join goods on dev_regist.goods_id=goods.id
left join brands on brands.BrandNo=dev_regist.brand_id
left join investor on dev_regist.investor_id=investor.agent_id
and dev_regist.goods_id=investor.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id
left join agent_info on agent_info.Id=investor.agent_id
left join agent_info as agent on agent.Id=dev_regist.AgentId
left join agent_info as agent2 on agent2.Id=agent.ParentId
".(empty($where)?"":" where $where")." $order  ";


        //---------------
        //导出表格
        if($DevNo==''&&$excel=='xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz'){
//            $this->Excel($sql);
//            $this->Phpexcel($sql);
//            $this->DevAct($sql."limit 0,$page_size");
            $this->DevAct($sql,$page_size);
            exit;
        }
        //----------------

        //获取该设备的所有操作记录
//        $datas=yii\db\ActiveRecord::findBySql("select DevNo from dev_action_log ".(empty($where)?"":" where $where")." ");
        $total=yii\db\ActiveRecord::findBySql($sql)->count();
//        $total=$datas->count();

        if(ceil($total/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($total/$page_size);
        }

        $pages = new Pagination(['totalCount' => $total, 'PageSize' => $page_size]);


        $model=yii\db\ActiveRecord::findBySql($sql." limit $pages->offset,$pages->limit")->asArray()->all();

        //上级
        foreach($model as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['agentname']=$parent['agentFname'];
//            $v['agentPname']=$parent['agentPname'];
            $v['agentpname']=$parent['agentYname'];
        }

        //获取入网属性数据
        $type=yii\db\ActiveRecord::findBySql("select `code`,use_type from agent_usetype_code")->asArray()->all();
        $UserType=array_column($type,'use_type','code');

        return $this->render('detail',['model'=>$model,
                                        'pages'=>$pages,
                                        'DevNo'=>$DevNo,
                                        'content'=>$content,
                                        'selecttime'=>$selecttime,
                                        'sort'=>$sort,
                                        'page_size' => $page_size,
                                        'page' => $page,
                                        'UserType' => $UserType,
                                        'CustomerType' => $this->CustomerType,
                                        'url'=>$urlobj
                                    ]);


    }


    //导出表格(方案三)
    public function DevAct2($sql,$page_size){
        ini_set("memory_limit", "1024M");
        set_time_limit(0);

        if($page_size>50000){//导出最近50000条
            //$start=$page_size-50000;
//            $sql=$sql." limit $start,50000 ";
            $sql=$sql." limit 0,50000 ";
        }else{
            $sql=$sql." limit 0,$page_size ";
        }
        $data = yii\db\ActiveRecord::findBySql($sql)->asArray()->all();

        //设置导出的文件名
        $fileName = iconv('utf-8', 'gbk', '设备动态'.date("Y-m-d H:i:s"));

        //设置表头
        $headlist = array('用户','手机号','设备编号','最近操作','用水量','剩余水量(L)','TDS','水温','操作时间','上传时间','设备商品型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','省','市','区','入网属性','用户类型');

        header('Content-Type: application/vnd.ms-excel');

        //指明导出的格式
        header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
        header('Cache-Control: max-age=0');

        //打开PHP文件句柄,php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        //输出Excel列名信息
        foreach ($headlist as $key => $value) {
            //CSV的Excel支持GBK编码，一定要转换，否则乱码
            $headlist[$key] = iconv('utf-8', 'gbk', $value);
        }

        //将数据通过fputcsv写到文件句柄
        fputcsv($fp, $headlist);

        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        //逐行取出数据，不浪费内存
        foreach ($data as $k => $v) {
            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($k % $limit == 0 && $k!=0) {
                ob_flush();
                flush();
            }
            $row = $data[$k];
            foreach ($row as $key => $value) {
                $row[$key] = iconv('utf-8', 'gbk', $value);
            }
            fputcsv($fp, $row);
        }

        return;
    }
    public  function DevAct($sql,$page_size){
        ini_set('memory_limit','1024M');
        ini_set('max_execution_time',0);

        if($page_size>50000){//导出最近50000条
            //$start=$page_size-50000;
//            $sql=$sql." limit $start,50000 ";
            $sql=$sql." limit 0,50000 ";
        }else{
            $sql=$sql." limit 0,$page_size ";
        }
        $dataArray = yii\db\ActiveRecord::findBySql($sql)->asArray()->all();

        //设置导出的文件名
        $filename ='设备动态'.date("Y-m-d H:i:s");

        //设置表头
        $tileArray = array('用户','手机号','设备编号','最近操作','用水量','剩余水量(L)','TDS','水温','操作时间','上传时间','设备商品型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','省','市','区','入网属性','用户类型');

        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=".$filename.'.csv');
        $fp=fopen('php://output','w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
        fputcsv($fp,$tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            if($index==1000){
                $index=0;
                ob_flush();
                flush();
            }

            $index++;
            $item['Tel']='’'.$item['Tel'];
            $item['DevNo']='’'.$item['DevNo'];
            $item['ActTime']='’'.$item['ActTime'];
            $item['RowTime']='’'.$item['RowTime'];
            $item['UseType']=$this->UserType[$item['UseType']];
            $item['CustomerType']=$this->CustomerType[$item['CustomerType']];
            fputcsv($fp,$item);
        }

        ob_flush();
        flush();
        ob_end_clean();
        exit;
    }

    //获取对应库存的累计入库数量
    public function GetTotal($AgentId,$factory_id,$goods_id){
        $total=0;
        $data=yii\db\ActiveRecord::findBySql("
        select MAX(total)as total from agent_stock_log
        where agent_id=$AgentId and factory_id=$factory_id
        and goods_id=$goods_id")->asArray()->one();
        if($data){
            $total= $data['total'];
        }
        return $total;
    }


}