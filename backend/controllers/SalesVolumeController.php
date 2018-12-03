<?php
namespace backend\controllers;

//销量统计接口
use backend\models\AdminRoleUser;
use backend\models\FactoryInfo;
use backend\models\User;
use yii\db\ActiveRecord;
use backend\models\Address;


class SalesVolumeController extends BaseController{

    //销量统计首页
    public function actionIndex(){

        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //获取时间条件
        $time1=$this->getParam('time1');
        $time2=$this->getParam('time2');

        //获取地址条件
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');

        //获取角色条件
        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心id
        $devfactory_id=$this->getParam('devfactory_id');//设备厂家
        $investor_id=$this->getParam('investor_id');//设备投资商
        $waterfactory_precode=$this->getParam('waterfactory_precode');//水厂

        //商品条件
        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号
        $waterbrand_id=$this->getParam('waterbrand_id');//水品牌
        $watername_id=$this->getParam('watername_id');//水商品名称
        $water_volume=$this->getParam('water_volume');//水商品容量

        //用户类型和入网属性条件
        $usetype=$this->getParam('usetype');//入网属性
        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、手机号、设备编号）
        $search=$this->getParam('search');


        //获取地址
        $areas=Address::allQuery()->asArray()->all();
        //获取所有运营中心
        $agenty=ActiveRecord::findBySql("select Id,`Name` from agent_info where Level=4")->asArray()->all();
        //获取所有服务中心
        $agentf=ActiveRecord::findBySql("select Id,`Name`,ParentId1 as ParentId from (
select a.Id,a.`Name`,a.ParentId as ParentId1,b.ParentId as ParentId2
from agent_info as a
LEFT JOIN agent_info as b on b.Id=a.ParentId and b.`Level`=7
LEFT JOIN agent_info as c on (c.Id=b.ParentId or c.Id=a.ParentId) and c.`Level`=4
where a.Level=5)as temp where ParentId2 is NULL
UNION
select Id,`Name`,ParentId2 as ParentId from (
select a.Id,a.`Name`,a.ParentId as ParentId1,b.ParentId as ParentId2
from agent_info as a
LEFT JOIN agent_info as b on b.Id=a.ParentId and b.`Level`=7
LEFT JOIN agent_info as c on (c.Id=b.ParentId or c.Id=a.ParentId) and c.`Level`=4
where a.Level=5)as temp where ParentId2 is not NULL")->asArray()->all();
        //所有设备厂家
        $devfactory=ActiveRecord::findBySql("select Id,`Name` from dev_factory")->asArray()->all();
        //所有设备投资商
        $investor=ActiveRecord::findBySql("select Id,`Name` from agent_info where Level=6")->asArray()->all();
        //所有设备品牌
        $devbrand=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=2 ")->asArray()->all();
        //所有设备商品型号
        $devname=ActiveRecord::findBySql("select id,`name`,brand_id from goods where category_id=2 and state=0 ")->asArray()->all();
        //所有水厂
        $factory=ActiveRecord::findBySql("select Id,`Name`,PreCode from factory_info")->asArray()->all();
        //所有品牌
        $waterbrand=ActiveRecord::findBySql("select DISTINCT factory_wcode.Fid,
brands.BrandNo,brands.BrandName
from brands
left join factory_wcode on factory_wcode.WaterBrand=brands.BrandNo
")->asArray()->all();
        //所有水商品
        $watername=ActiveRecord::findBySql("select DISTINCT factory_wcode.Fid,goods.id,goods.`name`,goods.brand_id
from goods
left join factory_wcode on factory_wcode.GoodsId=goods.id
where category_id=1
and state=0
group by brand_id,`name`
")->asArray()->all();
        //所有水商品容量
        $watervolume=ActiveRecord::findBySql("select brand_id,`name`,volume from goods where category_id=1 and state=0 group by brand_id,`name`,volume")->asArray()->all();
        //入网属性（去重）
//        $use_type=ActiveRecord::findBySql("select DISTINCT use_type from agent_usetype_code ")->asArray()->all();
        $use_type=$this->GetUseType();
        //所有入网属性
//        $all_use_type=ActiveRecord::findBySql("select code,use_type from agent_usetype_code ")->asArray()->all();
        $all_use_type=$this->GetAllUseType();

        //获取登陆者角色id
        $role_id=0;
        $factory_precode=0;
        $login_id=\Yii::$app->getUser()->getId();
        $role=(new AdminRoleUser())->findOne(['uid'=>$login_id]);
        if($role){
            $role_id=$role->role_id;
        }
        if($role_id==2){//水厂
            $user_login=(new User())->findOne(['Id'=>$login_id]);
            if($user_login){
                $login_name=$user_login->username;
                $factory_info=(new FactoryInfo())->findOne(['LoginName'=>$login_name]);
                if($factory_info){
                    $factory_precode=$factory_info->PreCode;
                    $waterfactory_precode=$factory_precode;
                }

            }

        }


        $datas=$this->GetAllDatas($status=1,$offset,$limit,$time1,$time2,$province,
            $city,$area,$agenty_id,$agentf_id,$devfactory_id,$investor_id,
            $waterfactory_precode,$devbrand_id,$devname_id,$waterbrand_id,
            $watername_id,$water_volume,$usetype,$customertype,$search);

//var_dump($watername);exit;


        return $this->render('index',
            [
                //下拉框条件数据
                'areas'=>$areas,
                'agenty'=>$agenty,
                'agentf'=>$agentf,
                'devfactory'=>$devfactory,
                'investor'=>$investor,
                'devbrand'=>$devbrand,
                'devname'=>$devname,
                'factory'=>$factory,
                'waterbrand'=>$waterbrand,
                'watername'=>$watername,
                'watervolume'=>$watervolume,
                'use_type'=>$use_type,//入网属性
                'all_use_type'=>$all_use_type,//所有入网属性

                //渲染数据
                'datas'=>$datas,
                'role_id'=>$role_id,//登陆者角色id
                'factory_precode'=>$factory_precode,//水厂precode

                //返回已筛选条件
                'province'=>$province,
                'city'=>$city,
                'area'=>$area,
                'agenty_id'=>$agenty_id,//运营中心id
                'agentf_id'=>$agentf_id,//服务中心id
                'devfactory_id'=>$devfactory_id,//设备厂家
                'investor_id'=>$investor_id,//设备投资商
                'waterfactory_precode'=>$waterfactory_precode,//水厂
                'devbrand_id'=>$devbrand_id,//设备品牌
                'devname_id'=>$devname_id,//设备型号
                'waterbrand_id'=>$waterbrand_id,//水品牌
                'watername_id'=>$watername_id,//水商品名称
                'water_volume'=>$water_volume,//水商品容量
                'usetype'=>$usetype,//入网属性
                'customertype'=>$customertype,//用户类型
                'search'=>$search,//搜索内容
                'offset'=>$offset,//起始位置
                'limit'=>$limit,//条数
                'time1'=>$time1,//时间1
                'time2'=>$time2,//时间2

            ]);

    }

    //ajax 请求 根据服务中心或运营中心 获取对应的入网属性
    public function actionGetUseType(){
        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心id
        $use_type=$this->GetUseTypeByAgent($agenty_id,$agentf_id);
        return json_encode(['datas'=>$use_type]);
    }


    //根据条件获取数据
    public function GetAllDatas($status,$offset,$limit,$time1,$time2,$province,
        $city,$area,$agenty_id,$agentf_id,$devfactory_id,$investor_id,
        $waterfactory_precode,$devbrand_id,$devname_id,$waterbrand_id,
        $watername_id,$water_volume,$usetype,$customertype,$search){


//        $time1='2017-01-5';
//        $time2='2017-11-10';

        $time_where='';
        $same_time_where='';//同期时间
        $cmd_time_where='';//初始化时间分割条件
        if(!empty($time1)&&!empty($time2)){//传的时间段
            $time_where=" dev_water_scan.RowTime >= '$time1' and dev_water_scan.RowTime < '$time2 23:59:59' ";
            //同期时间
            $d1 = strtotime($time1);
            $d2 = strtotime($time2);
            $d3 = strtotime(date('Y-m-d',time()));
            $Days1 = round(($d2-$d1)/3600/24);
            $Days2 = round(($d3-$d1)/3600/24);
            $Days = $Days2+$Days1+1;
            $date1=date('Y-m-d',strtotime("-$Days day"));
            $same_time_where=" dev_water_scan.RowTime >='$date1' and dev_water_scan.RowTime < '$time1' ";
            $cmd_time_where=" and ExpiredTime < '$time1' ";
        }elseif($time1==1&&empty($time2)){//今日
            $date1=date('Y-m-d'.' 00:00:00',time());
            $time_where=" dev_water_scan.RowTime >= '$date1' ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-1 day'));
            $same_time_where=" dev_water_scan.RowTime > '$date2' and dev_water_scan.RowTime < '$date1'";
            $cmd_time_where=" and ExpiredTime < '$date1' ";
        }elseif($time1==2&&empty($time2)){//昨日
            $date1=date('Y-m-d',strtotime('-1 day'));
            $date2=date('Y-m-d',time());
            $time_where=" dev_water_scan.RowTime >= '$date1' and dev_water_scan.RowTime < '$date2' ";
            //同期时间
            $date3=date('Y-m-d',strtotime('-2 day'));
            $same_time_where=" dev_water_scan.RowTime >= '$date3' and dev_water_scan.RowTime < '$date1' ";
            $cmd_time_where=" and ExpiredTime < '$date1' ";
        }elseif(($time1==3&&empty($time2))||(empty($time1)&&empty($time2))){//7天
            $date1=date('Y-m-d',strtotime('-6 day'));
            $time_where="  dev_water_scan.RowTime >= '$date1' ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-13 day'));
            $same_time_where=" dev_water_scan.RowTime >= '$date2' and dev_water_scan.RowTime < '$date1' ";
            $cmd_time_where=" and ExpiredTime < '$date1' ";
        }elseif($time1==4&&empty($time2)){//30天
            $date1=date('Y-m-d',strtotime('-29 day'));
            $time_where="  dev_water_scan.RowTime >= '$date1' ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-59 day'));
            $same_time_where=" dev_water_scan.RowTime >= '$date2' and dev_water_scan.RowTime < '$date1' ";
            $cmd_time_where=" and ExpiredTime < '$date1' ";
        }elseif($time1==5&&empty($time2)){//90天
            $date1=date('Y-m-d',strtotime('-89 day'));
            $time_where="  dev_water_scan.RowTime >= '$date1' ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-179 day'));
            $same_time_where=" dev_water_scan.RowTime >= '$date2' and dev_water_scan.RowTime < '$date1' ";
            $cmd_time_where=" and ExpiredTime < '$date1' ";
        }
//var_dump($time_where,$same_time_where);exit;


        //用户数量条件
        $user_num_where=" dev_regist.IsActive=1 and dev_regist.DevNo > 0
        and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)";

        $search_where=" dev_water_scan.DevNo > 0 ";
        if($province){
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_regist.Province='$province' ";
            $user_num_where.=" and dev_regist.Province='$province' ";
        }
        if($city){
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_regist.City='$city' ";
            $user_num_where.=" and dev_regist.City='$city' ";
        }
        if($area){
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_regist.Area='$area' ";
            $user_num_where.=" and dev_regist.Area='$area' ";
        }
        if(($agenty_id&&$agentf_id)||(!$agenty_id&&$agentf_id)){//运营中心和服务中心都选择了 或 只选了服务中心
            if($search_where){
                $search_where.=" and ";
            }
//            $search_where.=" dev_regist.AgentId=$agentf_id and dev_water_scan.AgentId=$agentf_id";
            $search_where.="  dev_water_scan.AgentId=$agentf_id";
            $user_num_where.=" and dev_regist.AgentId=$agentf_id ";
        }
        if($agenty_id&&!$agentf_id){//只选了运营中心
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" (dev_regist.AgentId in (select Id from agent_info
where (ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5)) or dev_regist.AgentId=$agenty_id) ";
            $search_where.=" and (dev_water_scan.AgentId in (select Id from agent_info
where (ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5)) or dev_water_scan.AgentId=$agenty_id) ";
            $user_num_where.=" and (dev_regist.AgentId in (select Id from agent_info
where (ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5)) or dev_regist.AgentId=$agenty_id) ";
        }
        if($devfactory_id){//设备厂家
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_factory.Id=$devfactory_id ";
            $user_num_where.=" and dev_factory.Id=$devfactory_id ";
        }
        if($investor_id){//设备投资商
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" investor.agent_id=$investor_id ";
            $user_num_where.=" and investor.agent_id=$investor_id ";
        }
        if($waterfactory_precode){//水厂
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_water_scan.PreCode='$waterfactory_precode' ";
            $user_num_where.=" and dev_water_scan.PreCode='$waterfactory_precode' ";
        }
        if($devbrand_id){//设备品牌
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_regist.brand_id='$devbrand_id' ";
            $user_num_where.=" and dev_regist.brand_id='$devbrand_id' ";
        }
        if($devname_id){//设备型号
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" goods.id=$devname_id ";
            $user_num_where.=" and goods.id=$devname_id ";
        }
        if($waterbrand_id){//水品牌
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_water_scan.BrandNo='$waterbrand_id' ";
            $user_num_where.=" and dev_water_scan.BrandNo='$waterbrand_id' ";
        }
        if($watername_id){//水型号
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_water_scan.GoodsId=$watername_id ";
            $user_num_where.=" and dev_water_scan.GoodsId=$watername_id ";
        }
        if($water_volume){//水容量
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_water_scan.Volume=$water_volume ";
            $user_num_where.=" and dev_water_scan.Volume=$water_volume ";
        }
        if($usetype){//入网属性
            //获取对应入网属性的所有code值

            if($search_where){
                $search_where.=" and ";
            }
//            $search_where.=" dev_regist.UseType=$usetype ";
            $search_where.=" dev_regist.UseType in (select code from agent_usetype_code where use_type='$usetype') ";
            $user_num_where.=" and dev_regist.UseType in (select code from agent_usetype_code where use_type='$usetype') ";
//            $user_num_where.=" and dev_regist.UseType=$usetype ";
        }
        if($customertype){//用户类型
            if($search_where){
                $search_where.=" and ";
            }
            $search_where.=" dev_regist.CustomerType=$customertype ";
            $user_num_where.=" and dev_regist.CustomerType=$customertype ";
        }
        if($search){//用户搜索（用户名称、手机号、设备编号）
//            if($search_where){
//                $search_where.=" and ";
//            }
            $user_where=" (user_info.Name like '%$search%' or user_info.Tel like  '%$search%' or dev_water_scan.DevNo like  '%$search%') ";
            $user_num_where.=" and (user_info.Name like '%$search%' or user_info.Tel like  '%$search%' or dev_water_scan.DevNo like  '%$search%') ";
        }




        $str="";
        $str2="";
        if($search_where!=''){
            $str="left join user_info on dev_water_scan.UserId=user_info.Id
left join factory_info on dev_water_scan.PreCode=factory_info.PreCode
left join dev_regist on dev_water_scan.DevNo=dev_regist.DevNo
left join goods on dev_regist.goods_id=goods.id
left join brands on dev_regist.brand_id=brands.BrandNo

left join investor on dev_regist.investor_id=investor.agent_id
and investor.goods_id=dev_regist.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id";

            $str2="left join dev_water_scan on dev_regist.DevNo=dev_water_scan.DevNo
            left join user_info on dev_water_scan.UserId=user_info.Id
left join factory_info on dev_water_scan.PreCode=factory_info.PreCode
left join goods on dev_regist.goods_id=goods.id
left join brands on dev_regist.brand_id=brands.BrandNo

left join investor on dev_regist.investor_id=investor.agent_id
and investor.goods_id=dev_regist.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id";

        }


        if($status==1){
            //销量概况数据
            $sales1=ActiveRecord::findBySql("select count(BarCode) as num
from (
select DISTINCT BarCode from
dev_water_scan
$str
where $time_where ".(empty($search_where)?'':' and '.$search_where)."
".(empty($user_where)?'':' and '.$user_where)." )as temp "
            )->asArray()->one()['num'];
            //同期
            $sales2=ActiveRecord::findBySql("select count(*) as num
from (
select DISTINCT BarCode from
dev_water_scan
$str
where $same_time_where ".(empty($search_where)?'':' and '.$search_where)."
".(empty($user_where)?'':' and '.$user_where)." )as temp "
            )->asArray()->one()['num'];
            //年销量
            $year=date('Y'."-01-01",time());
            $sales_of_year=ActiveRecord::findBySql("select count(*) as num
from (
select DISTINCT BarCode from
dev_water_scan
$str
where dev_water_scan.RowTime > '$year' ".(empty($search_where)?'':' and '.$search_where)."
".(empty($user_where)?'':' and '.$user_where)." )as temp "
            )->asArray()->one()['num'];

            //用户数
            $user_num=ActiveRecord::findBySql("SELECT COUNT(*) as num FROM (SELECT * FROM (select DISTINCT dev_regist.DevNo
from dev_regist
$str2
".(empty($user_num_where)?'':' where '.$user_num_where)." )AS temp GROUP BY DevNo)AS temp")->asArray()->one()['num'];
            //$sales_of_users=['sales1'=>$sales1,'sales2'=>$sales2,'user_num'=>$user_num,'sales_of_year'=>$sales_of_year];
//        var_dump($sales_of_users);exit;

            //销量情况
            $sales_status=ActiveRecord::findBySql(" select DISTINCT dev_water_scan.RowTime,dev_water_scan.Date,
dev_regist.CustomerType,dev_regist.Province,dev_regist.City,dev_regist.Area
 from dev_water_scan
 ".(empty($str)?'left join dev_regist on dev_water_scan.DevNo=dev_regist.DevNo':$str)."
 where $time_where ".(empty($search_where)?'':' and '.$search_where)."
".(empty($user_where)?'':' and '.$user_where))->asArray()->all();
//        var_dump($sales_status);exit;
        }


        //销量详情（表格）
        $datas=ActiveRecord::findBySql("select DISTINCT dev_water_scan.DevNo,
dev_water_scan.BarCode,user_info.Name as UserName,user_info.Tel,dev_water_scan.AgentId,
factory_info.Name as FactoryName,dev_water_scan.Volume,goods.name as DevName,
brands.BrandName as DevBrand,dev_factory.Name as DevFactoryName,
agent_info.Name as investor,
dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.UseType,
dev_regist.CustomerType,dev_water_scan.RowTime,brands2.BrandName as water_brand,
watergoods.name as water_name
from dev_water_scan
left join user_info on dev_water_scan.UserId=user_info.Id
left join factory_info on dev_water_scan.PreCode=factory_info.PreCode
left join dev_regist on dev_water_scan.DevNo=dev_regist.DevNo
left join goods on dev_regist.goods_id=goods.id
left join brands on dev_regist.brand_id=brands.BrandNo
left join brands as brands2 on brands2.BrandNo=dev_water_scan.BrandNo
left join goods as watergoods on watergoods.id=dev_water_scan.GoodsId

left join investor on dev_regist.investor_id=investor.agent_id
and investor.goods_id=dev_regist.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id

left join agent_info on agent_info.Id=dev_regist.investor_id

where $time_where ".(empty($search_where)?'':' and '.$search_where)."
".(empty($user_where)?'':' and '.$user_where)."
order by dev_water_scan.RowTime desc");
        $total=$datas->count();//数据总条数

        //销量详情（表格）
        $sales_detail=ActiveRecord::findBySql($datas->sql.' limit '.$offset.','.$limit)->asArray()->all();

        //上级
        foreach($sales_detail as &$v){
            $parent=$this->GetParentByAgentF($v['AgentId']);
            $v['AgentName']=$parent['agentFname'];
//            $v['agentPname']=$parent['agentPname'];//片区中心
            $v['AgentPname']=$parent['agentYname'];
        }

        if($status==1){
            $model[]=[
                'sales1'=>$sales1,//用户销量
                'sales2'=>$sales2,//同期销量
                'user_num'=>$user_num,//用户总人数
                'sales_of_year'=>$sales_of_year,//今年累计销量
                'sales_status'=>$sales_status,//销量情况(折现图、饼状图、地图)
                'sales_detail'=>$sales_detail,//销量详情(表格数据)
                'total'=>$total,//数据总条数

            ];
        }else{
            $model[]=[

                'sales_detail'=>$sales_detail,//销量详情(表格数据)
                'total'=>$total,//数据总条数

            ];
        }

//        var_dump($model);exit;
        return $model;
    }

    //导出表格、分页接口
    public function actionGetDatas(){
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        $excel=$this->getParam("excel");

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //获取时间条件
        $time1=$this->getParam('time1');
        $time2=$this->getParam('time2');

        //获取地址条件
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');

        //获取角色条件
        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心id
        $devfactory_id=$this->getParam('devfactory_id');//设备厂家
        $investor_id=$this->getParam('investor_id');//设备投资商
        $waterfactory_precode=$this->getParam('waterfactory_precode');//水厂

        //商品条件
        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号
        $waterbrand_id=$this->getParam('waterbrand_id');//水品牌
        $watername_id=$this->getParam('watername_id');//水商品名称
        $water_volume=$this->getParam('water_volume');//水商品容量

        //用户类型和入网属性条件
        $usetype=$this->getParam('usetype');//入网属性
        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、手机号、设备编号）
        $search=$this->getParam('search');

        $datas=$this->GetAllDatas($status=0,$offset,$limit,$time1,$time2,$province,
            $city,$area,$agenty_id,$agentf_id,$devfactory_id,$investor_id,
            $waterfactory_precode,$devbrand_id,$devname_id,$waterbrand_id,
            $watername_id,$water_volume,$usetype,$customertype,$search);

        if($excel=='xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz'){
            $this->Excel($datas[0]['sales_detail']);
            exit;
        }

        return $datas;

    }

//导出表格
    public function Excel($model){
        //------------
        $filename = '销量统计'.date('YmdHis');
        $header = array('用户姓名','联系电话','设备编号','水厂条码','水厂','水品牌','商品名称','商品容量：L','商品设备型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','省','市','区','入网属性','用户类型','扫码时间');
        $index = array('UserName','Tel','DevNo','BarCode','FactoryName','water_name','water_brand','Volume','DevName','DevBrand','DevFactoryName','investor','AgentName','AgentPname','Province','City','Area','UseType','CustomerType','RowTime');
        $datas=$this->createtable($model,$filename,$header,$index);
//        var_dump($datas2);exit;
        return $datas;
        //--------------
    }

    protected function createtable($list,$filename,$header=array(),$index = array()){
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=".$filename.".xls");
        $teble_header = implode("\t",$header);
        $strexport = $teble_header."\r";

        foreach ($list as $row){
            foreach($index as $val){
//                $strexport.=$row[$val]."\t";
                if($val=='Tel'||$val=='DevNo'||$val=='BarCode'){
                    $strexport.="’".$row[$val]."\t";
                }else{
                    $strexport.=$row[$val]."\t";
                }


            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        exit($strexport);
    }

}
