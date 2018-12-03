<?php
namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);

use yii\db\ActiveRecord;
use backend\models\Address;

//用水量统计接口
class WaterUseController extends BaseController{

    public $today_use=0;
    //销量统计首页
    public function actionIndex(){
//var_dump($this->today_use,$this->time);exit;
        //点击刷新时real_time=1
        $real_time=$this->getParam('real_time');//1 实时获取，0
        //点击查询时
        $real_search=$this->getParam('real_search');//1 实时获取，0

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

        //商品条件
        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号

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
        $agentf=ActiveRecord::findBySql("select Id,`Name`,ParentId from agent_info where Level=5")->asArray()->all();
        //所有设备厂家
        $devfactory=ActiveRecord::findBySql("select Id,`Name` from dev_factory")->asArray()->all();
        //所有设备投资商
        $investor=ActiveRecord::findBySql("select Id,`Name` from agent_info where Level=6")->asArray()->all();
        //所有设备品牌
        $devbrand=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=2 ")->asArray()->all();
        //所有设备商品型号
        $devname=ActiveRecord::findBySql("select id,`name`,brand_id from goods where category_id=2 and state=0 ")->asArray()->all();
        //入网属性（去重）
        $use_type=$this->GetUseType();
        //所有入网属性
        $all_use_type=$this->GetAllUseType();

        $where_datas=[
            'province'=>$province,
            'city'=>$city,
            'area'=>$area,
            'agenty_id'=>$agenty_id,//运营中心id
            'agentf_id'=>$agentf_id,//服务中心id
            'devfactory_id'=>$devfactory_id,//设备厂家
            'investor_id'=>$investor_id,//设备投资商
            'devbrand_id'=>$devbrand_id,//设备品牌
            'devname_id'=>$devname_id,//设备型号
            'usetype'=>$usetype,//入网属性
            'customertype'=>$customertype,//用户类型
            'search'=>$search,//搜索内容
            'offset'=>$offset,//起始位置
            'limit'=>$limit,//条数
            'time1'=>$time1,//时间1
            'time2'=>$time2,//时间2
        ];

        $datas=$this->GetAllDatas($status=1,$offset,$limit,$time1,$time2,$province,
            $city,$area,$agenty_id,$agentf_id,$devfactory_id,$investor_id,
            $devbrand_id,$devname_id,$usetype,$customertype,$search);

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
                'use_type'=>$use_type,//入网属性
                'all_use_type'=>$all_use_type,//所有入网属性

                //渲染数据
                'datas'=>$datas,

                //返回已筛选条件
                'where_datas'=>$where_datas,

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
                                $devbrand_id,$devname_id,$usetype,$customertype,$search){

        $init_time='';//初始时间
        $init_time2='';
        $same_time='';//同期时间
        $same_time2='';//同期时间
        if(!empty($time1)&&!empty($time2)){//传的时间段
            $init_time=$time1;
            $init_time2=$time2.' 23:59:59';
            //同期时间
            $d1 = strtotime($time1);
            $d2 = strtotime($time2);
            $d3 = strtotime(date('Y-m-d',time()));
            $Days1 = round(($d2-$d1)/3600/24);
            $Days2 = round(($d3-$d1)/3600/24);
            $Days = $Days2+$Days1+1;
            $date1=date('Y-m-d',strtotime("-$Days day"));
            $same_time=$date1;
            $same_time2=$time1;
        }elseif($time1==1&&empty($time2)){//今日
            $date=date('Y-m-d',time());
            $init_time=$date;
            $init_time2=date('Y-m-d H:i:s',time());
            $date1=date('Y-m-d H:i:s',time());
            //同期时间
            $date2=date('Y-m-d',strtotime('-1 day'));
            $same_time=$date2;
            $same_time2=$date;
        }elseif($time1==2&&empty($time2)){//昨日
            $date1=date('Y-m-d',strtotime('-1 day'));
            $init_time=$date1;
            $init_time2=date('Y-m-d'.' 23:59:59',strtotime('-1 day'));
            $date2=date('Y-m-d',time());
            //同期时间
            $date3=date('Y-m-d',strtotime('-2 day'));
            $same_time=$date3;
            $same_time2=$date1;
        }elseif(($time1==3&&empty($time2))||(empty($time1)&&empty($time2))){//7天
            $date1=date('Y-m-d',strtotime('-6 day'));
            $init_time=$date1;
            $init_time2=date('Y-m-d H:i:s',time());
            //同期时间
            $date2=date('Y-m-d',strtotime('-13 day'));
            $same_time=$date2;
            $same_time2=$date1;
        }elseif($time1==4&&empty($time2)){//30天
            $date1=date('Y-m-d',strtotime('-29 day'));
            $init_time=$date1;
            $init_time2=date('Y-m-d H:i:s',time());
            //同期时间
            $date2=date('Y-m-d',strtotime('-59 day'));
            $same_time=$date2;
            $same_time2=$date1;
        }elseif($time1==5&&empty($time2)){//90天
            $date1=date('Y-m-d',strtotime('-89 day'));
            $init_time=$date1;
            $init_time2=date('Y-m-d H:i:s',time());
            //同期时间
            $date2=date('Y-m-d',strtotime('-179 day'));
            $same_time=$date2;
            $same_time2=$date1;
        }

        //用户条件
        $user_where="";
        if($province){
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" dev_regist.Province='$province' ";
        }
        if($city){
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" dev_regist.City='$city' ";
        }
        if($area){
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" dev_regist.Area='$area' ";
        }
        if(($agenty_id&&$agentf_id)||(!$agenty_id&&$agentf_id)){//运营中心和服务中心都选择了 或 只选了服务中心
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" dev_regist.AgentId=$agentf_id ";
        }
        if($agenty_id&&!$agentf_id){//只选了运营中心
            if($user_where){
                $user_where.=" and ";
            }
//            $user_where.=" exists (select 1 from agent_info where ParentId=$agenty_id and Id=dev_regist.AgentId) ";
            $user_where.=" exists (select Id from agent_info
where ((ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5))
            and Id=dev_regist.AgentId) ";
        }
        if($devfactory_id){//设备厂家
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" dev_factory.Id=$devfactory_id ";
        }
        if($investor_id){//设备投资商
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" investor.agent_id=$investor_id ";
        }
        if($devbrand_id){//设备品牌
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" dev_regist.brand_id='$devbrand_id' ";
        }
        if($devname_id){//设备型号
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" goods.id=$devname_id ";
        }
        if($usetype){//入网属性
            if($user_where){
                $user_where.=" and ";
            }
//            $user_where.=" dev_regist.UseType=$usetype ";
            $user_where.=" exists (select 1 from agent_usetype_code where use_type='$usetype' and code = dev_regist.UseType)";
        }
        if($customertype){//用户类型
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" dev_regist.CustomerType=$customertype ";
        }
        if($search){//用户搜索（用户名称、手机号、设备编号）
            if($user_where){
                $user_where.=" and ";
            }
            $user_where.=" (user_info.Name like '%$search%' or user_info.Tel like  '%$search%' or dev_regist.DevNo like  '%$search%') ";
        }
        $num_str='';
        $use_str=' inner join dev_regist on dev_regist.DevNo=temp.DevNo ';
        $num_where='';
        if($user_where){

            $num_where=$user_where;
            $user_where.=" and ";

            $num_str="left join user_info on dev_regist.UserId=user_info.Id
left join goods on dev_regist.goods_id=goods.id
left join brands on dev_regist.brand_id=brands.BrandNo
left join investor on dev_regist.investor_id=investor.agent_id
and investor.goods_id=dev_regist.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id
left join agent_info on agent_info.Id=investor.agent_id
";

            $use_str.="left join user_info on dev_regist.UserId=user_info.Id
left join goods on dev_regist.goods_id=goods.id
left join brands on dev_regist.brand_id=brands.BrandNo
left join investor on dev_regist.investor_id=investor.agent_id
and investor.goods_id=dev_regist.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id
left join agent_info on agent_info.Id=investor.agent_id
";

        }
        $user_where.=" dev_regist.AgentId > 0 ";


//var_dump($user_where);exit;

        //选择的时间条件包含今天的话，计算今天到现在的用水量()两次计算超过一小时
        if($init_time2 > date('Y-m-d')) {//今日
            //计算今天的用水量
            $result=$this->TodayUse($user_where,$num_str,$init_time,$init_time2);
            if(is_array($result)){
                $this->today_use=$result['total_water_use'];
            }else{
                $this->today_use=$result;
            }
        }


        if($status==1){

            //用水量概况数据
            //总用水量
            $use_total=$this->getvolume($init_time,$init_time2,$user_where,$num_str)+$this->today_use;

            //同期
            $same_time_total=$this->getvolume($same_time,$same_time2,$user_where,$num_str);

            //年销量
            $year_use=$this->getvolume(date('Y'."-01-01",time()),date('Y-m-d H:i:s',time()),$user_where,$num_str);

            //用户数
            $user_num=ActiveRecord::findBySql("select count(*) as num
from dev_regist
$num_str
where dev_regist.IsActive=1 and dev_regist.DevNo > 0
and  not exists
(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
".(empty($num_where)?'':' and '.$num_where))->asArray()->one()['num'];
            //用水情况（折线图）
            if((strtotime($init_time2)-strtotime($init_time)) > 3600*24){
                $sql="select dev_use_water_every_day.Date as ActDate,sum(UseVolume)as WaterUse
                from dev_use_water_every_day
                inner join dev_regist on dev_regist.DevNo=dev_use_water_every_day.DevNo
                $num_str
                where dev_use_water_every_day.Date >='$init_time'
                and dev_use_water_every_day.Date <='$init_time2' and dev_regist.AgentId > 0
                ".(empty($user_where)?'':' and '.$user_where)." GROUP BY dev_use_water_every_day.Date";

                $use_status=ActiveRecord::findBySql($sql)->asArray()->all();

                if($init_time2 > date('Y-m-d')) {//今日
                    //计算今天的用水量
                    array_push($use_status,['ActDate'=>date('Y-m-d'),'WaterUse'=>$this->today_use]);

                }
            }else{
                //如果选择的时间段是某一天，会根据这一天的小时来分段
                //查询该时间段内水量变化传上来的水量余额（每台设备向前多取一个）
                $sql="select DISTINCT temp.* from (
                    (select DevNo,WaterRest,ActTime,ActDate from dev_action_log where ActType=99 and ActTime > '$init_time' and ActTime < '$init_time2')
                     UNION
                    (select * from (select DevNo,WaterRest,ActTime,ActDate from dev_action_log where ActType=99 and ActTime < '$init_time' order by ActTime desc )as temp group by DevNo)
                    )as temp
                    $use_str ".(empty($user_where)?'':' where '.$user_where)."
                    order by temp.ActTime desc,temp.WaterRest asc";
                $datas=ActiveRecord::findBySql($sql)->asArray()->all();
                $DevNos=ActiveRecord::findBySql("select DevNo from dev_regist $num_str ".(empty($user_where)?'':' where '.$user_where))->asArray()->all();

                $use_status=[];
//            $arr2=[];
                for($k=0;$k<count($DevNos); $k++){
                    $arr=[];
                    for($i=0;$i<count($datas); $i++){
                        if($datas[$i]['DevNo']==$DevNos[$k]['DevNo']){
                            array_push($arr,$datas[$i]);
//                        array_push($arr2,$datas[$i]);
                        }
                    }
                    if(!empty($arr)&&count($arr)>1){
//                    var_dump($arr);exit;
                        for($j=0;$j<count($arr);$j++){
                            if($arr[$j+1]){
                                $use=$arr[$j+1]['WaterRest']-$arr[$j]['WaterRest'];
                                if($use>0){//扫码增加容量的过滤掉
                                    $use_status[]=['WaterUse'=>$use,
                                        'ActTime'=>$arr[$j]['ActTime'],
                                        'ActDate'=>$arr[$j]['ActDate']
                                    ];
                                }

                            }

                        }

                    }


                }

            }



            //地图、饼状数据
            //用户类型对应的用水量
            $customertype_use=ActiveRecord::findBySql("
            select dev_regist.CustomerType,sum(UseVolume)as UseTotal from dev_use_water_every_day
inner join dev_regist on dev_regist.DevNo=dev_use_water_every_day.DevNo
$num_str
where dev_use_water_every_day.Date >='$init_time'
and dev_use_water_every_day.Date <='$init_time2' and dev_regist.AgentId > 0
".(empty($user_where)?'':' and '.$user_where)." GROUP BY dev_regist.CustomerType")->asArray()->all();

            //区域对应的用水量
            $province_datas=ActiveRecord::findBySql("
        select dev_regist.Province,sum(UseVolume)as UseTotal from dev_use_water_every_day
inner join dev_regist on dev_regist.DevNo=dev_use_water_every_day.DevNo
$num_str
where dev_use_water_every_day.Date >='$init_time'
and dev_use_water_every_day.Date <='$init_time2' and dev_regist.AgentId > 0
".(empty($user_where)?'':' and '.$user_where)." GROUP BY dev_regist.Province")->asArray()->all();
            $city_datas=ActiveRecord::findBySql("
        select dev_regist.Province,dev_regist.City,sum(UseVolume)as UseTotal from dev_use_water_every_day
inner join dev_regist on dev_regist.DevNo=dev_use_water_every_day.DevNo
$num_str
where dev_use_water_every_day.Date >='$init_time'
and dev_use_water_every_day.Date <='$init_time2' and dev_regist.AgentId > 0
".(empty($user_where)?'':' and '.$user_where)." GROUP BY dev_regist.City")->asArray()->all();

            //如果时间段包含今天
            if($init_time2 > date('Y-m-d')) {
//                $result=$this->EveryDevUse();

                //将今天的用水量加入每个对应的用户类型
                foreach($result['customertype_data'] as $key=>$value){
                    $tag=0;
                    foreach($customertype_use as &$v){
                        if($v['CustomerType']==$key){
                            $v['UseTotal']+=$value;
                            $tag++;
                            continue;
                        }
                    }
                    if($tag==0){
                        $customertype_use[]=['CustomerType'=>$key,'UseTotal'=>$value];
                    }
                }

                //将今天的用水量加入每个对应的省
                foreach($result['province_data'] as $key=>$value){
                    $tag=0;
                    foreach($province_datas as &$v){
                        if($v['Province']==$key){
                            $v['UseTotal']+=$value;
                            $tag++;
                            continue;
                        }
                    }
                    if($tag==0){
                        $province_datas[]=['Province'=>$key,'UseTotal'=>$value];
                    }
                }

                //将今天的用水量加入每个对应的市
                foreach($result['city_data'] as $key=>$value){
                    $tag=0;
                    foreach($city_datas as &$v){
                        if($v['City']==$key){
                            $v['UseTotal']+=$value;
                            $tag++;
                            continue;
                        }
                    }
                    if($tag==0){
                        $city_datas[]=['Province'=>$result['city_province'][$key],'City'=>$key,'UseTotal'=>$value];
                    }
                }
            }

            $map_datas=['customertype_use'=>$customertype_use,
                'province_datas'=>$province_datas,
                'city_datas'=>$city_datas,
            ];

        }

        //销量详情（表格）
        $datas=ActiveRecord::findBySql("select distinct user_info.Name as UserName,
user_info.Tel,dev_regist.DevNo,goods.name as DevName,
brands.BrandName as DevBrand,dev_factory.Name as DevFactoryName,
agent_info.Name as investor,
dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.UseType,
dev_regist.CustomerType,temp.WaterUse
from dev_regist
left join user_info on dev_regist.UserId=user_info.Id
left join goods on dev_regist.goods_id=goods.id
left join brands on dev_regist.brand_id=brands.BrandNo
left join investor on dev_regist.investor_id=investor.agent_id
and investor.goods_id=dev_regist.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id
left join agent_info on agent_info.Id=investor.agent_id

left join (select DevNo,sum(UseVolume)as WaterUse from dev_use_water_every_day
where Date >='$init_time' and Date <= '$init_time2' group by DevNo)as temp
on dev_regist.DevNo=temp.DevNo
".(empty($user_where)?'':' where '.$user_where));


        //如果时间段包含今天,将今天每台设备的用水量加上
        if($init_time2 > date('Y-m-d')) {
            //销量详情（表格）
            $sales_detail=ActiveRecord::findBySql($datas->sql)->asArray()->all();
           if($sales_detail){
               foreach($sales_detail as &$v){
                   //将今天每台设备的用水量加上
                   if(array_key_exists($v['DevNo'],$result['dev_data'])){
                       $v['WaterUse']+=$result['dev_data'][$v['DevNo']];
                   }
                   $key_arrays[]=$v['WaterUse'];
               }
               //排序、分页
               array_multisort($key_arrays,SORT_DESC,$sales_detail);
               $sales_detail=array_slice($sales_detail,$offset,$limit);
           }

        }else{
            //销量详情（表格）
            $sales_detail=ActiveRecord::findBySql($datas->sql.'  order by WaterUse desc limit '.$offset.','.$limit)->asArray()->all();
        }

        //上级
        foreach($sales_detail as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['AgentName']=$parent['agentFname'];
//            $v['agentPname']=$parent['agentPname'];
            $v['AgentPname']=$parent['agentYname'];
        }

        if($status==-1){
            return $sales_detail;
        }

        $total=$datas->count();//数据总条数

        if($status==1){
            $model=[
                'use_total'=>$use_total,//总用水量
                'same_time_total'=>$same_time_total,//同期用水量
                'user_num'=>$user_num,//用户总人数
                'year_use'=>$year_use,//今年累计用水量
                'use_status'=>$use_status,//用水情况(折现图)
                'map_datas'=>$map_datas,//用水情况(饼状图、地图)
                'sales_detail'=>$sales_detail,//销量详情(表格数据)
                'total'=>$total,//数据总条数
            ];
        }else{
            $model=[

                'sales_detail'=>$sales_detail,//销量详情(表格数据)
                'total'=>$total,//数据总条数

            ];
        }

//        var_dump($model);exit;
        return $model;
    }

    //计算容量
    public function getvolume($time1,$time2,$user_where,$str){
        //用水量概况数据
        //总容量
        $volume_datas=ActiveRecord::findBySql("select sum(UseVolume)as UseTotal
        from dev_use_water_every_day
        inner join dev_regist on dev_regist.DevNo=dev_use_water_every_day.DevNo
        $str
        where dev_use_water_every_day.Date >='$time1'
        and dev_use_water_every_day.Date <='$time2'".(empty($user_where)?'':' and '.$user_where))->asArray()->one();

        return $volume_datas['UseTotal'];
    }

    //今日用水量
    public function TodayUse($user_where='',$num_str='',$init_time,$init_time2){
        //有搜索条件 或 选择的是今天
        if($num_str||((strtotime($init_time2)-strtotime($init_time)) <= 3600*24)||$init_time2 > date('Y-m-d')){
            $time1=date('Y-m-d');
            $time2=date('Y-m-d H:i:s');
            $sql1="select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime > '$time1' and ActTime < '$time2' and DevNo > 0 ";
            $sql2="select * from (select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime < '$time1' and DevNo > 0 order by ActTime desc)as temp group by DevNo ";//前一次
            $data=ActiveRecord::findBySql("
        select DISTINCT temp2.*,dev_regist.Province,dev_regist.City,dev_regist.CustomerType
        from ((".$sql1.") union (".$sql2."))as temp2
        inner join dev_regist on dev_regist.DevNo=temp2.DevNo
        $num_str
        where dev_regist.DevNo > 0 and dev_regist.AgentId >0 ".(empty($user_where)?'':' and '.$user_where)."
        order by temp2.ActTime asc,temp2.WaterRest desc")->asArray()->all();
            $arr=[];//将设备编号一样的放在一个数组内
            foreach($data as $k=>$v){
                $arr[$v['DevNo']][] = $v;
            }

            $customertype_data=[];
            $province_data=[];
            $city_province=[];
            $city_data=[];
            $dev_data=[];

            $total_water_use=0;//总用水量
            foreach($arr as $key=>$value) {
                $total = count($value);
                if ($total > 1) {
                    $water_use = 0;
                    foreach ($value as $k => $v) {
                        if ($k + 1 <= $total - 1) {
                            $use = $v['WaterRest'] - $value[$k + 1]['WaterRest'];
                            if ($use > 0) {
                                $water_use += $use;
                                $total_water_use += $use;
                            }

                        }
                    }
                    if($water_use > 0){
                        $customertype_data[$value[0]['CustomerType']]+=$water_use;
                        $province_data[$value[0]['Province']]+=$water_use;
                        $city_data[$value[0]['City']]+=$water_use;
                        $city_province[$value[0]['City']]=$value[0]['Province'];
                        $dev_data[$value[0]['DevNo']]=$water_use;
                    }
                }
            }


            return [
                'customertype_data'=>$customertype_data,
                'province_data'=>$province_data,
                'city_data'=>$city_data,
                'city_province'=>$city_province,
                'dev_data'=>$dev_data,
                'total_water_use'=>round($total_water_use,2),
            ];
        }
        $use_data=json_decode(trim(substr(file_get_contents('../web/datas/TodayUseWater.php'), 15)));

        return round($use_data->TodayUseWater,2);

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

        //商品条件
        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号

        //用户类型和入网属性条件
        $usetype=$this->getParam('usetype');//入网属性
        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、手机号、设备编号）
        $search=$this->getParam('search');

        $status=0;//获取分页数据
        if($excel=='xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz'){
            $status=-1;//导出数据
        }


            $datas=$this->GetAllDatas($status,$offset,$limit,$time1,$time2,$province,
                $city,$area,$agenty_id,$agentf_id,$devfactory_id,$investor_id,
                $devbrand_id,$devname_id,$usetype,$customertype,$search);

        if($excel=='xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz'&&$status==-1){
            $this->Excel($datas);
//            $this->WaterUse($datas);
            exit;
        }
//var_dump($datas);exit;
        return $datas;

    }

//------------------
//导出表格
    public function Excel($model){
        //------------
        $filename = '用水量统计'.date('Y-m-d H:i:s');
//        $header = array('用户姓名','联系电话','设备编号','商品设备型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','省','市','区','入网属性','用户类型','总容量','剩余容量');
        $header =  array('用户姓名','联系电话','设备编号','商品设备型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','省','市','区','入网属性','用户类型','用水量');
        $index = array('UserName','Tel','DevNo','DevName','DevBrand','DevFactoryName','investor','AgentName','AgentPname','Province','City','Area','UseType','CustomerType','WaterUse');
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
                $strexport.=$row[$val]."\t";
            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        exit($strexport);
    }
//---------------------

    //导出表格
    public function WaterUse($data){
        ini_set("memory_limit", "1024M");
        set_time_limit(0);

//        $data = ActiveRecord::findBySql($sql)->asArray()->all();

        //设置导出的文件名
        $fileName = iconv('utf-8', 'gbk', '用水量统计'.date("Y-m-d H:i:s"));

        //设置表头
        $headlist = array('用户姓名','联系电话','设备编号','商品设备型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','省','市','区','入网属性','用户类型','用水量');

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


}
