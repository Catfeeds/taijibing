<?php
namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);

use backend\models\Address;
use backend\models\DevRegist;
use backend\models\Goods;
use backend\models\TeaBrand;
use yii\db\ActiveRecord;
use Yii;
use app\models\UploadForm;
use yii\web\UploadedFile;

//版本管理
class VersionManageController extends BaseController{

    //升级包目录
    public  $upgrade_dir='../../../../proxy/file/';
    //public  $upgrade_dir='../../../111/222/';

    public function actionIndex(){
        //将超时 等待升级的设备状态 修改为 未在升级
        $this->CheckState();

        //ICCID 号段
        $start=$this->getParam('start');
        $end=$this->getParam('end');

        //下拉框数据
        $where_datas=$this->GetSelect();


        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //接收条件
        $selecttime=$this->getParam('selecttime');//时间段

        $province=$this->getParam("province");//省
        $city=$this->getParam("city");//市
        $area=$this->getParam("area");//区
        $state=$this->getParam('state');//升级状态：0全部，1等待升级，2升级中，3升级完成
        $dev_state=$this->getParam('dev_state');//设备状态：1 正常，2 未激活（未绑定用户）
        if(!$dev_state){
            $dev_state=1;//默认 正常
        }
        $select_type=$this->getParam("select_type");//设备类型
        $select_version=$this->getParam("select_version");//设备版本

        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号

        $devfactory_id=$this->getParam('devfactory_id');//设备厂家
        $investor_id=$this->getParam('investor_id');//设备投资商

        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心id

        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、ICCID、设备编号、版本号）
        $search=$this->getParam('search');
//        var_dump($state);exit;
        $datas=$this->GetDatas($start,$end,$dev_state,$select_type,$select_version,$offset,$limit,$selecttime,$province,$city,$area,$state,
            $devbrand_id,$devname_id,$devfactory_id,$investor_id,$agenty_id,$agentf_id,
            $customertype,$search);

//var_dump($datas);exit;


        return $this->render('index',[
            //下拉框条件数据
            'where_datas'=>json_encode($where_datas),
            //表格数据
            'datas'=>json_encode([
                'dev_list'=>$datas['dev_list'],//设备列表
                'total'=>$datas['total'],//数据总条数
                //已选条件数据
                'where'=>[
                    'start'=>$start,
                    'end'=>$end,
                    'select_version'=>$select_version,
                    'select_type'=>$select_type,
                    'dev_state'=>$dev_state,
                    'selecttime'=>$selecttime,
                    'province'=>$province,
                    'city'=>$city,
                    'area'=>$area,
                    'state'=>$state,
                    'devbrand_id'=>$devbrand_id,
                    'devname_id'=>$devname_id,
                    'devfactory_id'=>$devfactory_id,
                    'investor_id'=>$investor_id,
                    'agenty_id'=>$agenty_id,
                    'agentf_id'=>$agentf_id,
                    'customertype'=>$customertype,
                    'search'=>$search,
                ],
            ])

        ]);
    }

    //ICCID验证并获取相同号段
    public function CheckAndGetSame($start='',$end=''){

        $arr1=[];//哪些号段不同(键值)
        $arr2=[];//哪些号段相同(键值)
        $same1='';//相同部分(第一段)
        $same2='';//相同部分(第二段)
        $num=0;//判断第几段
        for($i=0;$start[$i]!='';$i++){

            if($start[$i]!=$end[$i]){
                $arr1[]=$i;
            }else{
                $arr2[]=$i;
                if(count($arr2)==1){//第一个，先放入
                    $same1.=$start[$i];
                }
                if(count($arr2)>1&&$arr2[$i]-$arr2[$i-1]==1&&$num==0){//相邻(第一段)
                    $same1.=$start[$i];
                }
                if(count($arr2)>1&&$arr2[$i]-$arr2[$i-1]!=1){
                    $num++;
                    $same2.=$start[$i];
                }
                if(count($arr2)>1&&$arr2[$i]-$arr2[$i-1]==1&&$num==1){//相邻(第二段)
                    $same2.=$start[$i];
                }

            }

        }
        for($j=0;$j<count($arr1);$j++){
            //不同部分号段是否连续，是否有不相等的非数字
            if(strlen($start)!=strlen($end)||intval($start[$arr1[$j]])==intval($end[$arr1[$j]])||$arr1[$j+1]-$arr1[$j]>1){
                return ['state'=>-1,'msg'=>'号段错误'];
            }
        }

        return ['state'=>0,'same1'=>$same1,'same2'=>$same2];

    }

    //ajax 检验ICCID
    public function actionCheckIccid($start='',$end=''){
        $result=$this->CheckAndGetSame($start,$end);
        if($result['state']==-1){
            return json_encode(['state'=>-1,$result['msg']]);
        }
        return json_encode(['state'=>0]);
    }



    //获取下拉框数据
    public function GetSelect(){
        //获取地址
        $areas=Address::allQuery()->asArray()->all();
        //所有设备品牌
        $devbrand=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=2")->asArray()->all();
        //所有设备商品型号
        $devname=ActiveRecord::findBySql("select id,`name`,brand_id from goods where state=0 and category_id=2")->asArray()->all();

        //所有设备厂家
        $devfactory=ActiveRecord::findBySql("select Id,`Name` from dev_factory")->asArray()->all();
        //所有设备投资商
        $investor=ActiveRecord::findBySql("select Id,`Name` from agent_info where Level=6")->asArray()->all();

        //获取所有运营中心
        $agenty=ActiveRecord::findBySql("select Id,`Name` from agent_info where Level=4")->asArray()->all();
        //获取所有服务中心
        $agentf=ActiveRecord::findBySql("select Id,`Name`,ParentId from agent_info where Level=5")->asArray()->all();
        //设备类型
        $select_type=ActiveRecord::findBySql("select DISTINCT `Type` from upload_version_log")->asArray()->all();
        //设备版本号
        $select_version=ActiveRecord::findBySql("select DISTINCT `Type`,Version from upload_version_log")->asArray()->all();


        //下拉框条件数据
        $where_datas=['areas'=>$areas,//地址
            'agenty'=>$agenty,//运营中心
            'agentf'=>$agentf,//服务中心
            'devfactory'=>$devfactory,//设备厂家
            'investor'=>$investor,//设备投资商
            'devbrand'=>$devbrand,//设备品牌
            'devname'=>$devname,//设备商品型号
            'select_type'=>$select_type,//设备类型
            'select_version'=>$select_version,//设备版本号
        ];
        return $where_datas;

    }

    //表格数据（分页）
    public function actionDevList(){
        //ICCID 号段
        $start=$this->getParam('start');
        $end=$this->getParam('end');


        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //接收条件
        $selecttime=$this->getParam('selecttime');//时间段

        $province=$this->getParam("province");//省
        $city=$this->getParam("city");//市
        $area=$this->getParam("area");//区
        $state=$this->getParam('state');//升级状态：0全部，1等待升级，2升级中，3升级完成
        $dev_state=$this->getParam('dev_state');//设备状态：1 正常，2 未激活（未绑定用户）
        if(!$dev_state){
            $dev_state=1;//默认 正常
        }
        $select_type=$this->getParam("select_type");//设备类型
        $select_version=$this->getParam("select_version");//设备版本

        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号

        $devfactory_id=$this->getParam('devfactory_id');//设备厂家
        $investor_id=$this->getParam('investor_id');//设备投资商

        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心id

        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、ICCID、设备编号、版本号）
        $search=$this->getParam('search');

        $datas=$this->GetDatas($start,$end,$dev_state,$select_type,$select_version,$offset,$limit,$selecttime,$province,$city,$area,$state,
            $devbrand_id,$devname_id,$devfactory_id,$investor_id,$agenty_id,$agentf_id,
            $customertype,$search);
        return json_encode($datas['dev_list']);
    }


    //获取表格数据
    public function GetDatas($start,$end,$dev_state,$select_type,$select_version,$offset,$limit,$selecttime,$province,$city,$area,$state,
                             $devbrand_id,$devname_id,$devfactory_id,$investor_id,$agenty_id,$agentf_id,
                             $customertype,$search){


        $where='';
        $startTime='';
        $endTime='';
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            $where.="dev_upgrade.UpgradeTime >= '$startTime' and dev_upgrade.UpgradeTime <= '$endTime'";
        }
        if($province){
            if($where){
                $where.=" and ";
            }
            $where.="dev_regist.Province='$province'";
        }
        if($city){
            if($where){
                $where.=" and ";
            }
            $where.="dev_regist.City='$city'";
        }
        if($area){
            if($where){
                $where.=" and ";
            }
            $where.="dev_regist.Area='$area'";
        }


        //升级状态
        if($state==-1||$state==1||$state==2||$state==3){
            $now=date('Y-m-d H:i:s',time());
            if(!empty($where)){
                $where.=" and ";
            }
            //-1未在升级，1等待升级，2升级中，3升级完成
            if($state==-1){
                $where.=" ((dev_upgrade.StartTime is NULL and dev_upgrade.ExpiredTime is NULL)
                            or (dev_upgrade.IsUpgrade=0 and '$now' > dev_upgrade.ExpiredTime)
                            or (dev_upgrade.IsUpgrade=1 and '$now' < dev_upgrade.StartTime))";
            }
            if($state==1){
                $where.=" dev_upgrade.IsUpgrade=1 and dev_upgrade.State=0 and '$now' > dev_upgrade.StartTime and '$now' < dev_upgrade.ExpiredTime";
            }
            if($state==2){
                $where.=" dev_upgrade.IsUpgrade=1 and dev_upgrade.State=1";
            }
            if($state==3){
                $where.=" dev_upgrade.State=2 and '$now' > dev_upgrade.StartTime and '$now' < dev_upgrade.ExpiredTime";
            }
        }

        //设备状态
        if($dev_state==1){//正常
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0 and dev_regist.IsActive=1 ";
        }
        if($dev_state==2){//未激活（未绑定用户）
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.AgentId = 0 and dev_regist.Iccid not in
        (select Iccid from dev_regist where AgentId > 0 and Iccid is not null
        and DevNo not in (select DevNo from dev_cmd where CmdType=4 and State=1)) ";
        }
        if($select_type){//设备类型
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.DevType = $select_type ";
        }
        if($select_version){//设备版本号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_upgrade.Version = $select_version ";
        }


        if($devbrand_id){//设备品牌
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.brand_id='$devbrand_id' ";
        }
        if($devname_id){//设备型号
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.goods_id=$devname_id ";
        }
        if($devfactory_id){//设备厂家
            if($where){
                $where.=" and ";
            }
            $where.=" dev_factory.Id=$devfactory_id ";
        }
        if($investor_id){//设备投资商
            if($where){
                $where.=" and ";
            }
            $where.=" investor.agent_id=$investor_id ";
        }
        if(($agenty_id&&$agentf_id)||(!$agenty_id&&$agentf_id)){//运营中心和服务中心都选择了 或 只选了服务中心
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.AgentId=$agentf_id ";
        }
        if($agenty_id&&!$agentf_id){//只选了运营中心
            if($where){
                $where.=" and ";
            }
            $where.=" exists (select 1 from agent_info where
            ((ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5))
            and Id=dev_regist.AgentId) ";
        }
        if($customertype){//用户类型
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.CustomerType=$customertype ";
        }
        if($search!=''){//用户搜索（用户名称、手机号、设备编号）
            if($where){
                $where.=" and ";
            }
            $where.=" (user_info.Name = '$search' or dev_regist.Iccid =  '$search' or dev_regist.DevNo =  '$search' or dev_upgrade.Version =  '$search') ";
        }
        //ICCID 号段
        if($start&&$end){
            $result=$this->CheckAndGetSame($start,$end);
            if($result['state']==0){
                $same1=$result['same1'];
                $same2=$result['same2'];
                if($where){
                    $where.=" and ";
                }
                $where.=" dev_regist.Iccid like '$same1%$same2' and dev_regist.Iccid >= '$start' and dev_regist.Iccid <= '$end' ";
            }
        }



        //根据条件获取数据
        $datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,dev_regist.Iccid as HwNo,
user_info.Name as username,user_info.Tel,dev_regist.CustomerType,temp1.Name as agentname,
temp2.Name as agentpname,goods.name as devname,brands.BrandName as devbrand,
dev_factory.Name as devfactory,agent.Name as investor,dev_regist.Province,dev_regist.City,
dev_regist.Area,dev_location.Address,dev_upgrade.UpgradeTime,dev_upgrade.Version,
dev_upgrade.IsUpgrade,dev_upgrade.State,dev_regist.brand_id,dev_regist.goods_id,
dev_upgrade.StartTime,
concat( dev_status.LastConnectDate,' ' ,dev_status.LastConnectTime)as LastConnectTime,
dev_upgrade.ExpiredTime as EndTime,dev_regist.DevType
from dev_regist

left join user_info on dev_regist.UserId=user_info.Id
left join dev_upgrade on dev_regist.DevNo=dev_upgrade.DevNo
left join dev_status on dev_regist.DevNo=dev_status.DevNo
left join agent_info as temp1 on dev_regist.AgentId=temp1.Id
left join agent_info as temp2 on temp1.ParentId=temp2.Id
left join brands on dev_regist.brand_id=brands.BrandNo

left join investor on dev_regist.investor_id=investor.`agent_id`
and dev_regist.goods_id=investor.goods_id

left join agent_info as agent on investor.agent_id=agent.Id

 left join goods on goods.brand_id=dev_regist.brand_id
and goods.id=dev_regist.goods_id

left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id

left join dev_location on dev_regist.DevNo=dev_location.DevNo
".(empty($where)?'':' where '.$where));

        $total=$datas->count();//数据总条数

        //设备列表（表格）
        $dev_list=ActiveRecord::findBySql($datas->sql.' limit '.$offset.','.$limit)->asArray()->all();

        //上级
        foreach($dev_list as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['agentname']=$parent['agentFname'];
//            $v['agentPname']=$parent['agentPname'];
            $v['agentpname']=$parent['agentYname'];
        }

        return ['total'=>$total,'dev_list'=>$dev_list];

    }


    //上传升级包和筛选升级
    public function actionUploadUpgrade2()
    {
        if (!Yii::$app->request->isPost) {
            return false;
        }

        $file = $_FILES['file'];//升级文件

        $selecttime=$this->getParam('selecttime');//时间段
        $province=$this->getParam("province");//省
        $city=$this->getParam("city");//市
        $area=$this->getParam("area");//区
        $state=$this->getParam('state');//升级状态：0全部，1等待升级，2升级中，3升级完成

        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号

        $devfactory_id=$this->getParam('devfactory_id');//设备厂家
        $investor_id=$this->getParam('investor_id');//设备投资商

        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心id

        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、ICCID、设备编号、版本号）
        $search=$this->getParam('search');

//        //如果是只升级一台设备或一批设备必须传设备编号
        $devno=$this->getParam('devno');//设备编号

        $StartTime=$this->getParam('StartTime');//允许升级时间
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }
//--------------------------出错时将已选条件带回
        $wheres=[
            'selecttime'=>$selecttime,
            'province'=>$province,
            'city'=>$city,
            'area'=>$area,
            'state'=>$state,
            'devbrand_id'=>$devbrand_id,
            'devname_id'=>$devname_id,
            'devfactory_id'=>$devfactory_id,
            'investor_id'=>$investor_id,
            'agenty_id'=>$agenty_id,
            'agentf_id'=>$agentf_id,
            'customertype'=>$customertype,
            'search'=>$search,
            'offset'=>$offset,
            'limit'=>$limit,
        ];
 //-------------------

        $where='';
        $startTime='';
        $endTime='';
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            $where.="dev_regist.UpgradeTime >= '$startTime' and dev_regist.UpgradeTime <= '$endTime'";
        }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
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


        //升级状态
        if($state!=''){
            if(!empty($where)){
                $where.=" and ";
            }
            //0全部，1等待升级，2升级中，3升级完成
            if($state==1){
                $where.="dev_regist.IsUpgrade=0 and dev_regist.State=0";
            }
            if($state==2){
                $where.="dev_regist.IsUpgrade=1 and dev_regist.State=0";
            }
            if($state==3){
                $where.="dev_regist.IsUpgrade=1 and dev_regist.State=1";
            }
        }


        if($devbrand_id){//设备品牌
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.brand_id='$devbrand_id' ";
        }
        if($devname_id){//设备型号
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.goods_id=$devname_id ";
        }
        $str='';
        if($devfactory_id||$investor_id){
            $str.=' left join investor on dev_regist.investor_id=investor.`agent_id`
 and dev_regist.goods_id=investor.goods_id
left join dev_factory on dev_factory.id=investor.factory_id ';
            if($devfactory_id){//设备厂家
                if($where){
                    $where.=" and ";
                }

                $where.=" dev_factory.Id=$devfactory_id ";
            }
            if($investor_id){//设备投资商
                if($where){
                    $where.=" and ";
                }
                $where.=" investor.agent_id=$investor_id ";
            }

        }

        if(($agenty_id&&$agentf_id)||(!$agenty_id&&$agentf_id)){//运营中心和服务中心都选择了 或 只选了服务中心
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.AgentId=$agentf_id ";
        }
        if($agenty_id&&!$agentf_id){//只选了运营中心
            if($where){
                $where.=" and ";
            }
//            $where.=" (dev_regist.AgentId in (select Id from agent_info where ParentId=$agenty_id) or dev_regist.AgentId=$agenty_id) ";
            $where.=" (dev_regist.AgentId in (select Id from agent_info
where (ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5)) or dev_regist.AgentId=$agenty_id) ";
        }
        if($customertype){//用户类型
            if($where){
                $where.=" and ";
            }
            $where.=" dev_regist.CustomerType=$customertype ";
        }

        if($search){//用户搜索（用户名称、手机号、设备编号）
            if($where){
                $where.=" and ";
            }
            $where.=" (user_info.Name like '%$search%' or dev_active.HwNo like  '%$search%' or dev_regist.DevNo like  '%$search%' or dev_regist.Version like  '%$search%') ";
            $str.=" left join dev_active on dev_regist.DevNo=dev_active.DevNo
                    left join user_info on dev_regist.UserId=user_info.Id";
        }

//var_dump($where,$devno);exit;

        //判断设备品牌和设备型号和开始升级时间是否传过来
        if($devbrand_id&&$devname_id&&$StartTime){
            $brand=TeaBrand::findOne(['BrandNo'=>$devbrand_id])->BrandName;
            $name=Goods::findOne(['id'=>$devname_id])->name;

            //根据设备品牌和名称获取文件夹名
            $filename=$brand.'_'.$name;
            $dir = iconv("UTF-8", "GBK", "$this->upgrade_dir$filename");//目录

//            var_dump(empty($file['tmp_name'][0]));exit;
            //验证
            if (!empty($file['tmp_name'][0])) {//有上传升级包
                //验证
                $data=$this->CheckFiles($file);
                if($data['state']==-1){//未通过验证
                    Yii::$app->getSession()->setFlash('error', $data['mas']);
                    return $this->render('index',$this->GoLast($wheres));
                }
                //判断是否有设备正在升级
//                $upgrade=ActiveRecord::findBySql("select DevNo from dev_regist where brand_id='$devbrand_id' and goods_id=$devname_id and IsUpgrade=1 and State=0")->asArray()->all();
//                if($upgrade){
//                    Yii::$app->getSession()->setFlash('error', '有设备正在升级');
//                    return $this->render('index',$this->GoLast($wheres));
//                }



                if(is_dir($dir)){
//                    var_dump($file);exit;
                    foreach ($file['name'] as $k=>$name) {
                        //判断上传版本是否和已有版本一样
                        if ($name == 'ReleaseConfig.ini') {//配置文件

                            $old = $this->GetVersion($devbrand_id, $devname_id);
                            if ($old['state'] == 0) {
                                $old_version = $old['version'];
                            } elseif ($old['state'] == -1 && $old['mas'] = '您还未上传升级包') {
                                $old_version = 0;
                            } else {
                                Yii::$app->getSession()->setFlash('error', $old['mas']);
                                return $this->render('index', $this->GoLast($wheres));
                            }
                            $new_dir=$file['tmp_name'][$k];//要上传的配置文件位置

                            $new_dir = iconv("UTF-8", "GBK", $new_dir);
                            if(is_file($new_dir)){
                                //打开文件读取版本号
                                $myfile = fopen($new_dir, "r") or die("Unable to open file!");
                                $str= explode('Version=',fread($myfile,filesize($new_dir)))[1];
                                $new_version= intval(explode('[',$str)[0]);
                                fclose($myfile);

                            }else{
                                Yii::$app->getSession()->setFlash('error', '文件上传失败，请重新上传');
                                return $this->render('index', $this->GoLast($wheres));
                            }

                            //比较
                            if($old_version==$new_version){
                                Yii::$app->getSession()->setFlash('error', '该版本的升级包已经上传过了');
                                return $this->render('index', $this->GoLast($wheres));
                            }

                        }
                    }

                        $number=0;
                        foreach ($file['tmp_name'] as $k=>$tmp_name) {

                            $re=move_uploaded_file($tmp_name,$dir."/" .$file['name'][$k]);

                            if($re){
                                $number++;
                            }

                        }
                    if($number!=3){
                        Yii::$app->getSession()->setFlash('error', '文件上传失败，请重新上传');
                        return $this->render('index',$this->GoLast($wheres));
                    }

                    //将对应品牌和型号的设备，上传包版本保存到数据库
                    $sql1="update goods set new_version=$new_version where id=$devname_id and brand_id='$devbrand_id' ";

                    $re1= Yii::$app->db->createCommand($sql1)->execute();

                        //修改对应设备的状态
                        $sql2="update dev_regist set IsUpgrade=0,State=0 where brand_id = '$devbrand_id' and goods_id = $devname_id
                    and DevNo <> 0 and IsActive=1
                    and DevNo not in (select DevNo from dev_cmd where CmdType=4 and State=1 group by DevNo)";

                    $re2= Yii::$app->db->createCommand($sql2)->execute();




                }else{
                    Yii::$app->getSession()->setFlash('error', '您还未创建升级包文件夹');
                    return $this->render('index',$this->GoLast($wheres));
                }


            }

            //获取对应的最新升级版本号
            $data=$this->GetVersion($devbrand_id,$devname_id);
//            var_dump($data);exit;
            $version=0;
            if($data['state']==0){
                $version=$data['version'];
            }else{
                Yii::$app->getSession()->setFlash('error', $data['mas']);
                return $this->render('index',$this->GoLast($wheres));
//                return json_encode($data);
//                return $data;
            }

            //判断是升级所有设备、升级一台设备、还是升级一批设备
            $result=0;
            if($devno!=''){//升级一台设备或一批设备

//                    $sql="update dev_regist set IsUpgrade=1,State=0,StartTime='$StartTime'  where DevNo in (".$devno.") and Version < $version";
                    $sql="update dev_regist set IsUpgrade=1,State=0,StartTime='$StartTime'  where DevNo in (".$devno.")";
//                var_dump($sql);exit;
                $result=Yii::$app->db->createCommand($sql)->execute();


            }elseif($devno==''&&$where){//升级所有设备

                $sql1="select dev_regist.DevNo
                        from dev_regist
                        $str
                        where dev_regist.DevNo <> 0 and dev_regist.IsActive=1
                        and dev_regist.DevNo not in (select DevNo from dev_cmd where CmdType=4 and State=1 group by DevNo)

                        ".(empty($where)?'':' and '.$where);//and Version < $version
                $DevNos=ActiveRecord::findBySql($sql1)->asArray()->all();
                if($DevNos){
                    $DevNos=json_encode(array_column($DevNos,'DevNo'));
                    $DevNos_str=str_replace('[','',$DevNos);
                    $DevNos_str=str_replace(']','',$DevNos_str);
//                var_dump($DevNos_str);exit;

                    $sql="update dev_regist set IsUpgrade=1,State=0,StartTime='$StartTime'  where DevNo in (".$DevNos_str.")";
                    $result=Yii::$app->db->createCommand($sql)->execute();
//                    var_dump($result);exit;
                }

            }

            Yii::$app->getSession()->setFlash('success', '您已有'.$result.'台设备升级中');
            return $this->render('index',$this->GoLast($wheres));
        }
        Yii::$app->getSession()->setFlash('error', '您的数据不完整！');
        return $this->render('index',$this->GoLast($wheres));
    }
    //上传升级包
    public function actionUploadUpgrade()
    {
        if (!Yii::$app->request->isPost) {
//            return false;
            Yii::$app->getSession()->setFlash('error', '提交方式不正确');
            return $this->redirect(['index']);
        }

        $file = $_FILES['file'];//升级文件

            //验证
            if (!empty($file['tmp_name'][0])) {//有上传升级包
                //验证
                $data=$this->CheckFiles($file);
                if($data['state']==-1){//未通过验证
                    Yii::$app->getSession()->setFlash('error', $data['mas']);
                    return $this->redirect(['index']);
                }


//                    var_dump($file);exit;
                    $dir_version='';
                    foreach ($file['name'] as $k=>$name) {
                        //判断上传版本是否和已有版本一样
                        if ($name == 'ReleaseConfig.ini') {//配置文件

                            $new_dir=$file['tmp_name'][$k];//要上传的配置文件位置

                            $new_dir = iconv("UTF-8", "GBK", $new_dir);
                            if(is_file($new_dir)){
                                //打开文件读取版本号
                                $myfile = fopen($new_dir, "r") or die("Unable to open file!");
                                $str= explode('Version=',fread($myfile,filesize($new_dir)))[1];
                                $new_version= intval(explode('[',$str)[0]);//上传包的版本号
                                $str2= explode('DevType=',$str)[1];//上传包的设备类型
                                $new_type= intval(explode('[',$str2)[0]);//上传包的设备类型
                                fclose($myfile);

                                //获取上传文件的目录
                                $dir_type = iconv("UTF-8", "GBK", "$this->upgrade_dir$new_type");//设备类型目录
                                $dir_version = iconv("UTF-8", "GBK", "$this->upgrade_dir$new_type/$new_version");//设备类型对应版本目录
//                               var_dump(!file_exists($dir_type));exit;
                                //判断之前是否上传过
                                if(!file_exists($dir_type)){//没有上传过该类型的包
                                    //创建该设备类型文件夹、版本文件夹
                                    mkdir ($dir_version,0777,true);//创建新的
                                }elseif(file_exists($dir_type) && !file_exists($dir_version)){//上传过该类型的包,但没有上传该版本的包
                                    mkdir ($dir_version,0777,true);//创建新的
                                }
                                //保存到目录下


                            }else{
                                Yii::$app->getSession()->setFlash('error', '文件上传失败，请重新上传');
                                return $this->redirect(['dev-manage-list']);
                            }



                        }
                    }

                    if($dir_version==''){
                        Yii::$app->getSession()->setFlash('error', '创建上传包文件夹失败');
                        return $this->redirect(['dev-manage-list']);
                    }
                    //保存到目录下
                    $number=0;
                    foreach ($file['tmp_name'] as $k=>$tmp_name) {

                        $re=move_uploaded_file($tmp_name,$dir_version."/" .$file['name'][$k]);

                        if($re){
                            $number++;
                        }

                    }
                    if($number!=3){
                        Yii::$app->getSession()->setFlash('error', '文件上传失败，请重新上传');
                        return $this->redirect(['dev-manage-list']);
                    }

                    //将上传包信息保存到数据库
                    $now=date('Y-m-d H:i:s',time());
                    $sql="insert into upload_version_log (`Type`,`Version`,`RowTime`) VALUES ($new_type,$new_version,'$now')";
                    $re=Yii::$app->db->createCommand($sql)->execute();

                    Yii::$app->getSession()->setFlash('success', '上传成功');
                    return $this->redirect(['dev-manage-list']);


            }

        Yii::$app->getSession()->setFlash('error', '没有文件');
        return $this->redirect(['dev-manage-list']);

    }

    //升级设备
    public function actionUpgradeDev()
    {

        $selecttime = $this->getParam('selecttime');//时间段
        $province = $this->getParam("province");//省
        $city = $this->getParam("city");//市
        $area = $this->getParam("area");//区
        $state = $this->getParam('state');//升级状态：0全部，1等待升级，2升级中，3升级完成
        $dev_state = $this->getParam('dev_state');//设备状态：1 正常，2 未激活（未绑定用户）
        if (!$dev_state) {
            $dev_state = 1;//默认 正常
        }
        $select_type = $this->getParam("select_type");//设备类型
        $select_version = $this->getParam("select_version");//设备版本

        $devbrand_id = $this->getParam('devbrand_id');//设备品牌
        $devname_id = $this->getParam('devname_id');//设备型号

        $devfactory_id = $this->getParam('devfactory_id');//设备厂家
        $investor_id = $this->getParam('investor_id');//设备投资商

        $agenty_id = $this->getParam('agenty_id');//运营中心id
        $agentf_id = $this->getParam('agentf_id');//服务中心id

        $customertype = $this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、ICCID、设备编号、版本号）
        $search = $this->getParam('search');

        //分页
        $offset = $this->getParam('offset');
        $limit = $this->getParam('limit');

        if ($offset == '' || $limit == '') {
            $offset = 0;
            $limit = 10;
        }


        $where = '';
        $startTime = '';
        $endTime = '';
        if (!empty($selecttime)) {
            $dateArr = explode("至", $selecttime);
            if (count($dateArr) == 2) {
                $startTime = $dateArr[0];
//                $endTime=$dateArr[1];
                $endTime = date('Y-m-d H:i:s', strtotime($dateArr[1]) + 24 * 3600 - 1);
            }
        }
        if (!empty($startTime) && !empty($endTime)) {
            $where .= "dev_upgrade.UpgradeTime >= '$startTime' and dev_upgrade.UpgradeTime <= '$endTime'";
        }
        if (!empty($province)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= "dev_regist.Province='$province'";
        }
        if (!empty($city)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= "dev_regist.City='$city'";
        }
        if (!empty($area)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= "dev_regist.Area='$area'";
        }


        //升级状态
        if($state==-1||$state==1||$state==2||$state==3){
            $now=date('Y-m-d H:i:s',time());
            if (!empty($where)) {
                $where .= " and ";
            }
            //-1未在升级，1等待升级，2升级中，3升级完成
            if($state==-1){
                $where.=" ((dev_upgrade.StartTime is NULL and dev_upgrade.ExpiredTime is NULL)
                            or (dev_upgrade.IsUpgrade=0 and '$now' > dev_upgrade.ExpiredTime)
                            or (dev_upgrade.IsUpgrade=1 and '$now' < dev_upgrade.StartTime))";
            }
            if($state==1){
                $where.=" dev_upgrade.IsUpgrade=1 and dev_upgrade.State=0 and '$now' > dev_upgrade.StartTime and '$now' < dev_upgrade.ExpiredTime";
            }
            if($state==2){
                $where.=" dev_upgrade.IsUpgrade=1 and dev_upgrade.State=1";
            }
            if($state==3){
                $where.=" dev_upgrade.State=2 and '$now' > dev_upgrade.StartTime and '$now' < dev_upgrade.ExpiredTime";
            }
        }

        //设备状态
        if ($dev_state == 1) {//正常
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0 and dev_regist.IsActive=1 ";
        }
        if ($dev_state == 2) {//未激活（未绑定用户）
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.AgentId = 0 and dev_regist.Iccid not in
        (select Iccid from dev_regist where AgentId > 0 and Iccid is not null
        and DevNo not in (select DevNo from dev_cmd where CmdType=4 and State=1))";
        }
        if ($select_type) {//设备类型
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.DevType = $select_type ";
        }
        if ($select_version) {//设备版本号
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_upgrade.Version = $select_version ";
        }


        if ($devbrand_id) {//设备品牌
            if ($where) {
                $where .= " and ";
            }
            $where .= " dev_regist.brand_id='$devbrand_id' ";
        }
        if ($devname_id) {//设备型号
            if ($where) {
                $where .= " and ";
            }
            $where .= " dev_regist.goods_id=$devname_id ";
        }
        $str = '';
        if ($devfactory_id || $investor_id) {
            $str .= ' left join investor on dev_regist.investor_id=investor.`agent_id`
 and dev_regist.goods_id=investor.goods_id
left join dev_factory on dev_factory.id=investor.factory_id ';
            if ($devfactory_id) {//设备厂家
                if ($where) {
                    $where .= " and ";
                }

                $where .= " dev_factory.Id=$devfactory_id ";
            }
            if ($investor_id) {//设备投资商
                if ($where) {
                    $where .= " and ";
                }
                $where .= " investor.agent_id=$investor_id ";
            }

        }

        if (($agenty_id && $agentf_id) || (!$agenty_id && $agentf_id)) {//运营中心和服务中心都选择了 或 只选了服务中心
            if ($where) {
                $where .= " and ";
            }
            $where .= " dev_regist.AgentId=$agentf_id ";
        }
        if ($agenty_id && !$agentf_id) {//只选了运营中心
            if ($where) {
                $where .= " and ";
            }
//            $where .= " exists (select 1 from agent_info where ParentId=$agenty_id and Id=dev_regist.AgentId) ";
            $where .= " exists (select 1 from agent_info
            where ( (ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5))
            and Id=dev_regist.AgentId) ";
        }
        if ($customertype) {//用户类型
            if ($where) {
                $where .= " and ";
            }
            $where .= " dev_regist.CustomerType=$customertype ";
        }

        if ($search) {//用户搜索（用户名称、设备编号）
            if ($where) {
                $where .= " and ";
            }
            $where .= " (user_info.Name = '$search' or dev_regist.Iccid =  '$search' or dev_regist.DevNo =  '$search' or dev_upgrade.Version = '$search') ";
            $str .= " left join user_info on dev_regist.UserId=user_info.Id
                      left join user_info on dev_upgrade.DevNo=dev_regist.DevNo";
        }


        //升级时弹框
        $dev_type = $this->getParam('dev_type');//设备类型
        $target_version = $this->getParam('target_version');//设备升级到的目标版本
        $start_time = $this->getParam('start_time');//设备升级开始时间
        $end_time = $this->getParam('end_time');//设备升级结束时间

        //升级某一台，或通过复选框勾选 升级一批设备 必须传递DevNos
        $DevNos = $this->getParam('DevNos');
        //升级所有设备 必须传 iccid 号段
        $start = $this->getParam('start');
        $end = $this->getParam('end');

        //--------------------------出错时将已选条件带回
        //$start,$end,$dev_state,$select_type,$select_version,
        $wheres = [
            'dev_state' => $dev_state,
            'select_version' => $select_version,
            'select_type' => $select_type,
            'DevNos' => $DevNos,
            'start' => $start,
            'end' => $end,
            'selecttime' => $selecttime,
            'province' => $province,
            'city' => $city,
            'area' => $area,
            'state' => $state,
            'devbrand_id' => $devbrand_id,
            'devname_id' => $devname_id,
            'devfactory_id' => $devfactory_id,
            'investor_id' => $investor_id,
            'agenty_id' => $agenty_id,
            'agentf_id' => $agentf_id,
            'customertype' => $customertype,
            'search' => $search,
            'offset' => $offset,
            'limit' => $limit,
        ];
        //-------------------

//        if (!$dev_type || !$target_version || !$start_time || !$end_time || (!$DevNos && (!$start || !$end))) {
        if (!$dev_type || !$target_version || !$start_time || !$end_time ) {
            Yii::$app->getSession()->setFlash('error', '参数错误');
            return $this->render('index', $this->GoLast($wheres));
        }

        if ($start && $end) {//用户类型
            //获取Iccid重复号段
            $data = $this->CheckAndGetSame($start, $end);
            if ($data['state'] == -1) {
                Yii::$app->getSession()->setFlash('error', $data['msg']);
                return $this->render('index', $this->GoLast($wheres));
            }
            if ($where) {
                $where .= " and ";
            }
            $where .= " dev_regist.Iccid like '{$data['same1']}%{$data['same2']}' and dev_regist.Iccid >= '$start' and dev_regist.Iccid <= '$end' ";
        }

//var_dump($DevNos,$start,$end);exit;
        //升级包目录
        $dir = $dev_type . '/' . $target_version;
        $num=0;
        //升级某一台，或通过复选框勾选 升级一批设备；通过筛选条件 升级所有设备

        if (!empty($DevNos)) {
            $DevNos=explode(',',$DevNos);
            foreach($DevNos as $DevNo){

                $data=ActiveRecord::findBySql("select DevNo from dev_upgrade where DevNo='$DevNo'")->asArray()->one();
                if($data){//存在，修改
                    $sql = " update dev_upgrade set IsUpgrade=1,State=0,StartTime='$start_time',ExpiredTime='$end_time',
                  UpgradeDir='$dir' where DevNo = '$DevNo'";
                }else{//不存在，插入
                    $sql = " insert into dev_upgrade (`DevNo`,`IsUpgrade`,`State`,`StartTime`,`ExpiredTime`,`UpgradeDir`)
                            VALUES ('$DevNo',1,0,'$start_time','$end_time','$dir')";
                }
                $result = Yii::$app->db->createCommand($sql)->execute();
                if($result){
                    $num++;
                }
            }

//            $sql = " update dev_upgrade set IsUpgrade=1,State=0,StartTime='$start_time',ExpiredTime='$end_time',
//                  UpgradeDir='$dir' where DevNo in (" . $DevNos . ")";
//            $result = Yii::$app->db->createCommand($sql)->execute();

            Yii::$app->getSession()->setFlash('success', '操作成功'.$num.'台设备');
            return $this->render('index',$this->GoLast($wheres));
        }
        //通过筛选条件 升级所有设备
//        if (empty($DevNos) && !empty($start) && !empty($end)) {
        if (empty($DevNos)) {

            $sql1 = "select dev_regist.DevNo
                        from dev_regist
                        $str
                        where not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                        " . (empty($where) ? '' : ' and ' . $where);
            $DevNos = ActiveRecord::findBySql($sql1)->asArray()->all();
            $DevNos = array_column($DevNos,'DevNo');
            foreach($DevNos as $DevNo){
                $data=ActiveRecord::findBySql("select DevNo from dev_upgrade where DevNo='$DevNo'")->asArray()->one();
                if($data){//存在，修改
                    $sql = " update dev_upgrade set IsUpgrade=1,State=0,StartTime='$start_time',ExpiredTime='$end_time',
                  UpgradeDir='$dir' where DevNo = '$DevNo'";
                }else{//不存在，插入
                    $sql = " insert into dev_upgrade (`DevNo`,`IsUpgrade`,`State`,`StartTime`,`ExpiredTime`,`UpgradeDir`)
                            VALUES ('$DevNo',1,0,'$start_time','$end_time','$dir')";
                }
                $result = Yii::$app->db->createCommand($sql)->execute();
                if($result){
                    $num++;
                }
            }


            Yii::$app->getSession()->setFlash('success', '操作成功'.$num.'台设备');
            return $this->render('index',$this->GoLast($wheres));
        }
    }
    //ajax 获取目标版本号
    public function actionGetTargetVersion(){
        $dev_type=$this->getParam('dev_type');//设备类型
        $target_version='';
        if($dev_type){
            $target_version=ActiveRecord::findBySql("select DISTINCT Version from upload_version_log where `Type`=$dev_type")->asArray()->all();
        }
        return json_encode(['target_version'=>$target_version]);
    }

    //验证上传文件是否符合要求
    public function CheckFiles($file){
        $file_names=$file['name'];//文件名称
//        $tmp_names=$file['tmp_name'];//文件所在目录名称
        $file_size=$file['size'];//文件大小
        $errors=$file['error'];//文件上传是否成功 0 成功

        if(count($file_names)!=3){//只允许传3个文件
            return ['state'=>-1,'mas'=>'只允许传3个文件'];
        }

        //验证格式
        $num=0;
        foreach($file_names as $name){
            $ext=strrchr($name,'.');//通过文件名获取扩展名
            if($ext!='.bin' && $ext!='.ini'){
                return ['state'=>-1,'mas'=>'上传文件格式不正确'];
            }
            if($ext=='.bin'){
                $num++;
            }
        }
        if($num!=2){
            return ['state'=>-1,'mas'=>'必须上传两个bin文件和一个ini文件'];
        }
        //验证是否上传配置文件ReleaseConfig.ini
        if(!in_array('ReleaseConfig.ini',$file_names)){
            return ['state'=>-1,'mas'=>'必须上传配置文件'];
        }
        //验证文件上传是否成功
        foreach($errors as $k=>$error){
            if($error!=0){
                return ['state'=>-1,'mas'=>'文件上传失败,请重新上传'];
            }
        }



        return ['state'=>0];


    }


    //获取对应品牌型号的最新升级包版本
    public function actionGetVersion(){
        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号
        $result=$this->GetVersion($devbrand_id,$devname_id);

        return json_encode($result);


    }

    public function GetVersion($devbrand_id,$devname_id){
        if(empty($devbrand_id)||empty($devname_id)){
            return ['state'=>-1,'mas'=>'请传参数：品牌和型号'];
        }

        $brandname=TeaBrand::findOne(['BrandNo'=>$devbrand_id])->BrandName;
        $goodsname=Goods::findOne(['id'=>$devname_id])->name;

        if(empty($brandname)||empty($goodsname)){
            return ['state'=>-1,'mas'=>'该品牌或型号已不存在'];
        }
        //升级包文件名
        $filename=$brandname.'_'.$goodsname;
        $dir = iconv("UTF-8", "GBK", "$this->upgrade_dir$filename/ReleaseConfig.ini");
//        var_dump(is_file($dir));exit;
        if(is_file($dir)){
            //打开文件读取版本号
            $myfile = fopen($dir, "r") or die("Unable to open file!");
            $str= explode('Version=',fread($myfile,filesize($dir)))[1];
            $version= intval(explode('[',$str)[0]);
//            $version= explode('\r\n',$str)[0];
            fclose($myfile);
            return ['state'=>0,'version'=>$version];

        }else{
            return ['state'=>-1,'mas'=>'您还未上传升级包'];
        }

    }


    //升级出错时返回，并带上已选条件
    public function GoLast($wheres){

        //下拉框条件数据
        $where_datas=$this->GetSelect();

        $datas=$this->GetDatas($wheres['start'],$wheres['end'],$wheres['dev_state'],$wheres['select_type'],
            $wheres['select_version'],$wheres['offset'],$wheres['limit'],$wheres['selecttime'],$wheres['province'],
            $wheres['city'],$wheres['area'],$wheres['state'], $wheres['devbrand_id'],$wheres['devname_id'],
            $wheres['devfactory_id'],$wheres['investor_id'],$wheres['agenty_id'],$wheres['agentf_id'],
            $wheres['customertype'],$wheres['search']);

        return [
            //下拉框条件数据
            'where_datas'=>json_encode($where_datas),
            //表格数据
            'datas'=>json_encode([
                'dev_list'=>$datas['dev_list'],//设备列表
                'total'=>$datas['total'],//数据总条数
                //已选条件数据
                'where'=>[
                    'start'=>$wheres['start'],
                    'end'=>$wheres['end'],
                    'select_version'=>$wheres['select_version'],
                    'select_type'=>$wheres['select_type'],
                    'dev_state'=>$wheres['dev_state'],
                    'selecttime'=>$wheres['selecttime'],
                    'province'=>$wheres['province'],
                    'city'=>$wheres['city'],
                    'area'=>$wheres['area'],
                    'state'=>$wheres['state'],
                    'devbrand_id'=>$wheres['devbrand_id'],
                    'devname_id'=>$wheres['devname_id'],
                    'devfactory_id'=>$wheres['devfactory_id'],
                    'investor_id'=>$wheres['investor_id'],
                    'agenty_id'=>$wheres['agenty_id'],
                    'agentf_id'=>$wheres['agentf_id'],
                    'customertype'=>$wheres['customertype'],
                    'search'=>$wheres['search'],
                ],
            ])

        ];
    }


    //版本控制列表页
    public function actionDevManageList(){

        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''){
            $offset=0;
            $limit=10;
        }

        //排序
        $sort=$this->getParam('sort');
        if(!$sort){
            $sort=0;
        }

        $order=' order by RowTime desc ';//默认降序
        if($sort&&$sort%2==1){//奇数 升序
            $order=' order by RowTime asc ';
        }

        //搜索条件
        $type=$this->getParam('type');
        $version=$this->getParam('version');

        $where='';
        if($type){
            $where=" `Type`=$type ";
        }
        if($version){
            if($where){
                $where.=' and ';
            }
            $where.=" `Version`=$version ";
        }

        //条件数据
        $select_type=ActiveRecord::findBySql("select DISTINCT `Type` from upload_version_log")->asArray()->all();
        $select_version=ActiveRecord::findBySql("select DISTINCT `Type`,Version from upload_version_log")->asArray()->all();
//        var_dump($select_version);
        //表格数据
        $query=ActiveRecord::findBySql("select `Type`,`Version`,`RowTime` from upload_version_log".(empty($where)?'':' where '.$where));
        $total=$query->count();
        $datas=ActiveRecord::findBySql($query->sql." $order limit ".$offset.','.$limit)->asArray()->all();

        return $this->render('list',[
            //下拉框数据
            'select_type'=>json_encode($select_type),
            'select_version'=>json_encode($select_version),
            //表格数据
            'datas'=>json_encode($datas),
            //已经选择的条件
            'type'=>$type,
            'version'=>$version,
            'sort'=>$sort,//排序
            //总条数
            'total'=>$total,
        ]);

    }

    //分页
    public function actionListPage(){
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''){
            $offset=0;
            $limit=10;
        }

        //排序
        $sort=$this->getParam('sort');
        if(!$sort){
            $sort=0;
        }

        $order=' order by RowTime desc ';//默认降序
        if($sort&&$sort%2==1){//奇数 升序
            $order=' order by RowTime asc ';
        }


        //搜索条件
        $type=$this->getParam('type');
        $version=$this->getParam('version');

        $where='';
        if($type){
            $where=" `Type`=$type ";
        }
        if($version){
            if($where){
                $where.=' and ';
            }
            $where.=" `Version`=$version ";
        }

        //表格数据
        $query=ActiveRecord::findBySql("select `Type`,`Version`,`RowTime` from upload_version_log".(empty($where)?'':' where '.$where));
        //." order by RowTime desc"
        $total=$query->count();
        $datas=ActiveRecord::findBySql($query->sql." $order limit ".$offset.','.$limit)->asArray()->all();

        return json_encode([
            //表格数据
            'datas'=>$datas,
            //已经选择的条件
            'type'=>$type,
            'version'=>$version,
            'sort'=>$sort,//排序
            //总条数
            'total'=>$total,
        ]);

    }

    //将超时 等待升级的设备状态 修改为 未在升级
    public function CheckState(){
        $now=date('Y-m-d H:i:s',time());
        $sql="update dev_upgrade set IsUpgrade=0 where '$now' > ExpiredTime and State=0 and IsUpgrade=1";
        $result=Yii::$app->db->createCommand($sql)->execute();
    }


    //生成guid
    public function CreateGuid(){
        $charid = strtolower(md5(uniqid(mt_rand(), true)));
//        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 6, 2).substr($charid, 4, 2).
            substr($charid, 2, 2).substr($charid, 0, 2)
    .substr($charid, 10, 2).substr($charid, 8, 2)
    .substr($charid,14, 2).substr($charid,12, 2)
    .substr($charid,16, 4).substr($charid,20,12);
    return $uuid;
    }

}