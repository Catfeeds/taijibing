<?php
namespace backend\controllers;
use backend\models\Address;
use yii\base\Exception;
use yii\db\ActiveRecord;
error_reporting(E_ALL & ~ E_NOTICE);
//电子水票
class SendWaterLogController extends BaseController{

    public function actionIndex(){

        $datas=$this->GetDatas(1);

        return $this->render('index',[
            'areas'=>json_encode($datas['areas']),//地址数据
            'where_datas'=>json_encode($datas['where_datas']),//已选条件
            'total'=>json_encode($datas['total']),//总条数
            'dev_list'=>json_encode($datas['dev_list']),//表格数据
            'init_devnos'=>json_encode($datas['init_devnos']),//已初始化的设备

        ]);
    }

    //分页接口
    public function actionDevList(){


        $datas=$this->GetDatas();

        return json_encode(['dev_list'=>$datas['dev_list'],'sort'=>$datas['sort']]);
    }

    //获取表格数据
    public function GetDatas($tag=''){
        //接收条件
        //分页
        $offset=trim($this->getParam('offset'));
        $limit=trim($this->getParam('limit'));

        if(!$offset){
            $offset=0;
        }
        if(!$limit){
            $limit=10;
        }
        $province=$this->getParam('province');//省
        $city=$this->getParam('city');//市
        $area=$this->getParam('area');//区
        $selecttime=$this->getParam('selecttime');//时间段
        $state=$this->getParam('state');//状态
        $user_state=$this->getParam('user_state');//用户状态 0 未激活，1 正常，2 已初始化，3 全部
        if($user_state==''){
            $user_state=1;//默认显示正常的
        }
        $search=addslashes($this->getParam('search'));//搜索内容
        $sort=$this->getParam('sort');//操作时间排序（1 升序，2 降序）
        if($sort==''){
            $sort=0;
        }
        $str="(select user_restmoney.UserId,user_restmoney.AgentId,user_restmoney.CustomerType,
            user_restmoney.Id
            from user_restmoney
            where user_restmoney.GroupId=0
            UNION
            select user_restmoney.UserId,user_restmoney.AgentId,user_restmoney.CustomerType,
            re.GroupId as Id
            from user_restmoney
            INNER JOIN user_restmoney as re on re.Id=user_restmoney.GroupId
            where user_restmoney.GroupId>0)as user_restmoney";
        //获取对应状态的设备编号
        $DevNoState='';
        //账户状态  默认正常电子账户
        $account_state='';
        if($user_state==1){
            //正常电子账户，没有初始化的用户（只要还有设备没有被初始化就是正常用户）
            $DevNoState="not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
and dev_regist.IsActive=1 and dev_regist.AgentId > 0";
        }elseif($user_state==2){
            //已初始化的用户（只要有一台设备被初始化就是已初始用户）
            $DevNoState="exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
and dev_regist.AgentId > 0";
        }elseif($user_state==0){
            //已登记（未激活）的电子账户，没有初始化的用户（只要还有设备没有被初始化就是正常用户）
            $DevNoState="not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
and dev_regist.IsActive=0 and dev_regist.AgentId > 0";
        }




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
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="user_restmoney.LastActTime >= '$startTime' and user_restmoney.LastActTime <= '$endTime'";
        }
        if(!empty($province)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" user_info.Province = '$province' ";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" user_info.City = '$city' ";

        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" user_info.Area = '$area' ";

        }
        //0 全部，1 需送水，2 已配送，3 已完成
        if($state){
            if(!empty($where)){
                $where.=' and ';
            }

            $where.=" user_restmoney.State = $state ";

        }
        $order=' order by user_restmoney.State asc,user_restmoney.SendWaterTime asc ';
        if($sort&&$sort%2==1){//操作时间排序（奇数 升序，偶数 降序）
            $order=" order by user_restmoney.LastActTime asc ";
        }
        if($sort&&$sort%2==0){//操作时间排序（奇数 升序，偶数 降序）
            $order=" order by user_restmoney.LastActTime desc ";
        }

        $member_str='';
        //搜索内容$search
        if($search!=''){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" (user_info.Name like '%$search%' or user_info.Tel like '%$search%'
            or agent_info.Name like '%$search%'
            or member.username like '%$search%' or member.Tel like '%$search%'
            or member.agentname like '%$search%'
            )";

            //成员
            $member_str="(select DISTINCT user_restmoney.Id,
user_restmoney.UserId,user_info.Name as username,user_info.Tel,
agent_info.Name as agentname,user_restmoney.GroupId
from user_restmoney
inner join user_info on user_restmoney.UserId=user_info.Id
inner join agent_info on user_restmoney.AgentId=agent_info.Id
inner join dev_regist on user_restmoney.UserId=dev_regist.UserId
            and user_restmoney.AgentId=dev_regist.AgentId
            and user_restmoney.CustomerType=dev_regist.CustomerType
where user_restmoney.GroupId > 0 and user_restmoney.Id <> user_restmoney.GroupId
".(empty($DevNoState)?'':' and '.$DevNoState)." )as member";
        }
//var_dump($member_str);exit;

                //表格数据（未分组的+已分组的组长）
        $datas=ActiveRecord::findBySql("
select DISTINCT user_restmoney.Id,
user_restmoney.UserId,user_info.Name as username,user_info.Tel,
user_info.Province,user_info.City,user_info.Area,user_info.Address,
agent_info.Name as agentname,user_restmoney.CustomerType,user_restmoney.AgentId,
user_restmoney.RestWater as rest_water,
user_info.SendTime,user_restmoney.SendWaterTime as send_time,
user_restmoney.RestMoney,user_restmoney.State,user_restmoney.LastActTime,
user_restmoney.TotalSendV,user_restmoney.GroupId,user_restmoney.CreateTime
from user_restmoney
inner join user_info on user_restmoney.UserId=user_info.Id
inner join agent_info on user_restmoney.AgentId=agent_info.Id
".(empty($member_str)?'':" left join $member_str on member.GroupId=user_restmoney.GroupId")."
where EXISTS (select 1 from (
            select DISTINCT user_restmoney.GroupId
            from user_info
            inner join dev_regist on user_info.Id=dev_regist.UserId
            inner join (select user_restmoney.UserId,user_restmoney.AgentId,user_restmoney.CustomerType,
            user_restmoney.Id as GroupId
            from user_restmoney
            where user_restmoney.GroupId=0
            UNION
            select user_restmoney.UserId,user_restmoney.AgentId,user_restmoney.CustomerType,
            re.GroupId
            from user_restmoney
            INNER JOIN user_restmoney as re on re.Id=user_restmoney.GroupId
            where user_restmoney.GroupId>0)as user_restmoney
            on user_restmoney.UserId=dev_regist.UserId
            and user_restmoney.AgentId=dev_regist.AgentId
            and user_restmoney.CustomerType=dev_regist.CustomerType
            where  dev_regist.AgentId >0".(empty($DevNoState)?'':' and '.$DevNoState).")as temp
            where GroupId=user_restmoney.Id)
".(empty($where)?'':' and '.$where));
//var_dump($user_state,$datas->sql);exit;


        $total=$datas->count();
        $dev_list=ActiveRecord::findBySql($datas->sql." $order limit $offset,$limit")->asArray()->all();

        if($dev_list){
            //获取当前页组长Id 字符串
            $JsonStrId=json_encode(array_column($dev_list,'Id'));
            $StrId1=str_replace('[','',$JsonStrId);
            $StrId2=str_replace(']','',$StrId1);
            $StrId=str_replace('"','',$StrId2);

            //每个组长 电子账户下的设备编号
            $DevNos=ActiveRecord::findBySql("select DevNo,user_restmoney.Id
        from dev_regist
        inner join user_restmoney on user_restmoney.UserId=dev_regist.UserId
        and user_restmoney.AgentId=dev_regist.AgentId
        and user_restmoney.CustomerType=dev_regist.CustomerType
         where user_restmoney.Id in ($StrId)".($DevNoState?" and $DevNoState":''))->asArray()->all();
            $ArrDevNo=[];
            foreach($DevNos as $v){
                $ArrDevNo[$v['Id']][]=$v['DevNo'];
            }
            foreach($dev_list as &$v){
                if(array_key_exists($v['Id'],$ArrDevNo)){
                    $v['DevNo']=$ArrDevNo[$v['Id']];
                }else{
                    $v['DevNo']=[];
                }
            }
        }

        if($tag==1){
            //获取地址数据
            $areas=Address::allQuery()->asArray()->all();
            //已初始化的设备
            $init_devnos=ActiveRecord::findBySql("select DevNo from dev_cmd where CmdType=4 and State=1 group by DevNo")->asArray()->all();

            //已选条件
            $where_datas=[
                'province'=>$province,
                'city'=>$city,
                'area'=>$area,
                'selecttime'=>$selecttime,
                'state'=>$state,
                'user_state'=>$user_state,
                'search'=>$search,
                'sort'=>$sort,
            ];

            return ['total'=>$total,
                'dev_list'=>$dev_list,
                'areas'=>$areas,
                'init_devnos'=>$init_devnos,
                'where_datas'=>$where_datas,
            ];
        }

        return ['total'=>$total,'dev_list'=>$dev_list,'sort'=>$sort];
    }

    //Ajax获取组成员数据
    public function actionGetMemberData(){
        $GroupId=$this->getParam('GroupId');//组id
        if(!$GroupId){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        //获取除开组长的其他组员
        $data=ActiveRecord::findBySql("
        select distinct user_restmoney.Id,
user_restmoney.UserId,user_info.Name as username,user_info.Tel,
user_info.Province,user_info.City,user_info.Area,user_info.Address,
agent_info.Name as agentname,user_restmoney.CustomerType,user_restmoney.AgentId,
user_restmoney.RestWater as rest_water,
user_info.SendTime,user_restmoney.SendWaterTime as send_time,
user_restmoney.RestMoney,user_restmoney.State,user_restmoney.LastActTime,
user_restmoney.TotalSendV,user_restmoney.GroupId,user_restmoney.CreateTime
        from user_info
        inner join dev_regist on user_info.Id=dev_regist.UserId
        inner join user_restmoney on user_restmoney.UserId=dev_regist.UserId
        and user_restmoney.AgentId=dev_regist.AgentId
        and user_restmoney.CustomerType=dev_regist.CustomerType
        inner join agent_info on user_restmoney.AgentId=agent_info.Id
        where user_restmoney.GroupId=$GroupId and user_restmoney.Id <> $GroupId
        ")->asArray()->all();

        //每个组员 电子账户下的设备编号
        $DevNos=ActiveRecord::findBySql("select DevNo,rs.Id
        from dev_regist
        inner join user_restmoney as rs on rs.UserId=dev_regist.UserId
        and rs.AgentId=dev_regist.AgentId
        and rs.CustomerType=dev_regist.CustomerType
        where exists (select Id from user_restmoney
        where GroupId=$GroupId and Id <> $GroupId and Id=rs.Id)
        and not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
        and dev_regist.IsActive=1 and dev_regist.AgentId > 0")->asArray()->all();
        $ArrDevNo=[];
        foreach($DevNos as $v){
            $ArrDevNo[$v['Id']][]=$v['DevNo'];
        }
        foreach($data as &$v){
            if(array_key_exists($v['Id'],$ArrDevNo)){
                $v['DevNo']=$ArrDevNo[$v['Id']];
            }else{
                $v['DevNo']=[];
            }
        }

        return json_encode(['state'=>0,'data'=>$data]);
    }

    //Ajax 将某个账户 从一个组 剔除
    public function actionOut(){
        $Id=$this->getParam('Id');//要踢出的电子账户id
        $GroupId=$this->getParam('GroupId');//组长id
        //手动填写 分配的 余额、剩余水量
        $ToRestMoney=$this->getParam('ToRestMoney');//分配的余额
        $ToRestWater=$this->getParam('ToRestWater');//分配的剩余水量
        if(!$Id||!$GroupId||$ToRestMoney===null||$ToRestWater===null||$ToRestMoney===''||$ToRestWater===''){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        //分组前的数据
        $before_data=ActiveRecord::findBySql("select * from before_group_user_restmoney where Id=$Id")->asArray()->one();
        if(!$before_data) return json_encode(['state'=>-1,'msg'=>'没有找到该账户分组前的信息']);

        //组长信息
        $data=ActiveRecord::findBySql("select UserId,AgentId,CustomerType,RestMoney,State,
        RestWater,AverageUse,SendWaterTime from user_restmoney where Id=$GroupId")->asArray()->one();
        if(!$data) return json_encode(['state'=>-1,'msg'=>'没有找到组长账户信息']);

        //组长账户余额小于踢出 分配余额，或剩余水量小于分配水量
        if($data['RestMoney']<$ToRestMoney||$data['RestWater']<$ToRestWater){
            //组账户余额、剩余水量 小于 踢出账户余额、剩余水量 不能踢出
            return json_encode(['state'=>-1,'msg'=>'请先充值或送水，再踢出成员']);
        }
        $now=date('Y-m-d H:i:s');
        //分配的剩余水量 与 分组前的剩余水量 的 差值
        $volume=$ToRestWater - $before_data['RestWater'];
        //计算组长的下次预计送水时间
        $SendWaterTime='近期还没有用水';
        //组长 踢出成员后 的平均用水量、剩余水量
        $AverageUse=$data['AverageUse']-$before_data['AverageUse'];//平均用水量
        $lest_water=$data['RestWater']-$ToRestWater;//剩余水量
        $State=1;//组长账户状态 默认需送水
        if($lest_water > 0){
            if($AverageUse > 0){
                //还可以用几天
                $days=floor($lest_water/$AverageUse);
                $SendWaterTime=date('Y-m-d',strtotime("+$days day"));
                if($days > 3){//下次预计送水时间大于3天
                    $State=3;//已完成
                }
            }else{
                $SendWaterTime='近期还没有用水';
                $State=3;//已完成
            }
        }else{
            $SendWaterTime='没有送水记录';
        }

        if($data['State']==2){//组长之前状态是 已配送
            $State=2;//已配送
        }
        //踢出 组员的下次预计送水时间
        $SendWaterTime2='近期还没有用水';
        $State2=1;//成员账户状态 默认需送水
        if($ToRestWater > 0){
            if($before_data['AverageUse'] > 0){
                //还可以用几天
                $days=floor($ToRestWater/$before_data['AverageUse']);
                $SendWaterTime2=date('Y-m-d',strtotime("+$days day"));
                if($days > 3){//下次预计送水时间大于3天
                    $State2=3;//已完成
                }
            }else{
                $SendWaterTime2='近期还没有用水';
                $State2=3;//已完成
            }
        }else{
            $SendWaterTime2='没有送水记录';
        }
        if($before_data['State']==2){//原来是已配送状态
            //还是 已配送状态
            $State2=2;//已配送
        }

        //保存组长、组员的账户 转账记录
        $sql_str="insert into user_recharge_log (`UserId`,`AgentId`,`CustomerType`,`PayMoney`,`PayType`,`RestMoney`,`RowTime`,`OutOrIn`,`GroupMemberId`)
                 values ('{$data['UserId']}',{$data['AgentId']},{$data['CustomerType']},-$ToRestMoney,4,{$data['RestMoney']}-$ToRestMoney,'$now',-1,$Id),
                ('{$before_data['UserId']}',{$before_data['AgentId']},{$before_data['CustomerType']},$ToRestMoney,4,$ToRestMoney,'$now',-1,$GroupId)";


        //踢出该成员后是否还有其他成员
        $member=ActiveRecord::findBySql("select Id from user_restmoney where Id <> $GroupId and Id <> $Id and GroupId=$GroupId")->asArray()->one();
        if($member){
            //修改组账户余额、剩余水量、平均用水量、下次预计送水时间、最近操作时间
            $sql="update user_restmoney set RestMoney=RestMoney-$ToRestMoney,
            LastActTime='$now',RestWater=RestWater-$ToRestWater,
            AverageUse=AverageUse-{$before_data['AverageUse']},
            SendWaterTime='$SendWaterTime',State=$State where Id=$GroupId";
        }else{
            //修改组账户余额
            $sql="update user_restmoney set RestMoney=RestMoney-$ToRestMoney,
            LastActTime='$now',GroupId=0,RestWater=RestWater-$ToRestWater,
            AverageUse=AverageUse-{$before_data['AverageUse']},
            CreateTime='{$before_data['CreateTime']}',
            SendWaterTime='$SendWaterTime',State=$State where Id=$GroupId";
        }

        //还原成 之前的状态(余额、剩余水量 根据分配的来，上次送水量根据分配送水量 调整)
        $sql1="update user_restmoney set GroupId=0,
        LastSendV={$before_data['LastSendV']}+$volume,RestWater=$ToRestWater,
        AverageUse={$before_data['AverageUse']},SendWaterTime='$SendWaterTime2',
        RestMoney=$ToRestMoney,State=$State2,LastActTime='{$before_data['LastActTime']}',
        CreateTime='{$before_data['CreateTime']}' where Id=$Id";

        //删除 保存的分组前的信息 （下次分组时会重新保存）
        $sql2="delete from before_group_user_restmoney where Id=$Id";
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            //保存组长、组员 转账记录
            $re=\Yii::$app->db->createCommand($sql_str)->execute();
            if(!$re){
                throw new Exception('保存组长、组员转账记录失败');
            }
            //修改组账户余额
            $re=\Yii::$app->db->createCommand($sql)->execute();
            if(!$re){
                throw new Exception('修改组账户数据失败');
            }

            $re=\Yii::$app->db->createCommand($sql1)->execute();
            if(!$re){
                throw new Exception('还原踢出组员账户数据失败');
            }
            $re=\Yii::$app->db->createCommand($sql2)->execute();
            if(!$re){
                throw new Exception('删除分组前的信息失败');
            }
            $transaction->commit();
            return json_encode(['state'=>0]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);
        }

    }

  //------------已弃用接口----------------------------------

    //计算从第一次送水时间开始每台设备的总用水量
    public function TotalUse(){

            $total_use=ActiveRecord::findBySql("select dev_regist.DevNo,(temp.total_volume-status_dev_water.VlNum)as WaterUse
        from dev_regist

        left join (select DevNo,sum(volume)as total_volume from ((select DevNo,sum(Volume)as volume from (select dev_regist.DevNo,new_table.Volume
        from dev_regist
        left join (select temp2.* from
(
	select * from
	(
		select BarCode,DevNo,Volume,RowTime from dev_water_scan_log ORDER BY RowTime ASC
	)as temp group by BarCode,DevNo
)as temp2
INNER JOIN (select * from (select DevNo,FinishTime from send_water_log order by FinishTime asc )as temp group by DevNo)as temp3
ON temp2.DevNo=temp3.DevNo AND temp2.RowTime >= temp3.FinishTime )as new_table
        on new_table.DevNo=Dev_regist.DevNo
        where  dev_regist.DevNo<>0
        )as temp  group by DevNo)
        UNION
        (select dev_regist.DevNo,temp_table.WaterRest as volume
        from dev_regist
        left join (select * from (
select temp.* from
(
select DevNo,WaterRest,ActTime from dev_action_log where ActType=99
)as temp
LEFT JOIN (select * from (select DevNo,FinishTime from send_water_log order by FinishTime asc )as temp group by DevNo)as temp2
 ON temp.DevNo=temp2.DevNo and temp.ActTime < temp2.FinishTime
ORDER BY ActTime desc )as temp3 GROUP BY DevNo)as temp_table
        on dev_regist.DevNo=temp_table.DevNo))as b group by DevNo) as temp
        on dev_regist.DevNo=temp.DevNo

        left join status_dev_water
        on dev_regist.DevNo=status_dev_water.DevNo
         order by WaterUse desc")->asArray()->all();

            return $total_use;
    }

    //每台设备送水后的总用水量和总送水量
    public function TotalUseAndTotalSend(){//用水量=送水前最后一次上报容量+送水后扫码容量-现在上报容量
        $datas=ActiveRecord::findBySql("select dev_regist.DevNo,temp.TotalScanV,status_dev_water.VlNum,temp4.WaterRest as OldRest,(temp.TotalScanV+IFNULL(temp4.WaterRest,0)-status_dev_water.VlNum)as TotalUseV,user_restmoney.TotalSendV from dev_regist
LEFT JOIN (
select DevNo,sum(Volume)as TotalScanV from
(select temp2.DevNo,temp2.Volume from
(
	select * from
	(
		select BarCode,DevNo,Volume,RowTime from dev_water_scan_log ORDER BY RowTime ASC
	)as temp group by BarCode,DevNo
)as temp2
INNER JOIN (select * from (select DevNo,RowTime from send_water_log where State=2 order by FinishTime asc )as temp group by DevNo)as temp3
ON temp2.DevNo=temp3.DevNo AND temp2.RowTime > temp3.RowTime )as new_table GROUP BY DevNo
)as temp on dev_regist.DevNo=temp.DevNo
left join status_dev_water
on dev_regist.DevNo=status_dev_water.DevNo
LEFT JOIN user_restmoney on dev_regist.DevNo=user_restmoney.DevNo
LEFT JOIN (select * from (select dev_action_log.DevNo, dev_action_log.WaterRest from dev_action_log
					INNER JOIN (select * from (select DevNo,RowTime from send_water_log where State=2 ORDER BY FinishTime ASC)as a GROUP BY DevNo )as b
					on dev_action_log.DevNo=b.DevNo and dev_action_log.ActTime < b.RowTime
					where dev_action_log.ActType=99 order by dev_action_log.ActTime desc)as c group by DevNo)as temp4
on dev_regist.DevNo=temp4.DevNo
where  dev_regist.DevNo<>0")->asArray()->all();

        return $datas;
    }
    public function TotalUseAndTotalSend2(){//用水量=送水前最后一次上报容量+送水后扫码容量-现在上报容量
        $datas=ActiveRecord::findBySql("select dev_regist.DevNo,(temp.TotalScanV-status_dev_water.VlNum)as TotalUseV,user_restmoney.TotalSendV from dev_regist
LEFT JOIN (
select DevNo,sum(Volume)as TotalScanV from
(select temp2.DevNo,temp2.Volume from
(
	select * from
	(
		select BarCode,DevNo,Volume,RowTime from dev_water_scan_log ORDER BY RowTime ASC
	)as temp group by BarCode,DevNo
)as temp2
INNER JOIN (select * from (select DevNo,RowTime from send_water_log order by FinishTime asc )as temp group by DevNo)as temp3
ON temp2.DevNo=temp3.DevNo AND temp2.RowTime >= temp3.RowTime )as new_table GROUP BY DevNo
)as temp on dev_regist.DevNo=temp.DevNo
left join status_dev_water
on dev_regist.DevNo=status_dev_water.DevNo
LEFT JOIN user_restmoney on dev_regist.DevNo=user_restmoney.DevNo
where  dev_regist.DevNo<>0")->asArray()->all();

        return $datas;
    }
    //送水（$id!=''时，修改订单）
    public function actionSendWater(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $id=$this->getParam('id');//修改时要传id
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            return $this->redirect(['index']);
        }
//        //获取该设备所属服务中心id
//        $agent_id=0;
//        $Dev=ActiveRecord::findBySql("select AgentId from dev_regist where UserId='$UserId' and CustomerType=$CustomerType")->asArray()->one();
//        if($Dev){
//            $agent_id=$Dev['AgentId'];
//        }
        //获取该服务中心的水品牌
        $water_brand=ActiveRecord::findBySql("select brands.BrandNo,brands.BrandName from agent_goods
INNER JOIN goods on goods.id=agent_goods.goods_id
INNER JOIN brands on brands.BrandNo=goods.brand_id
where agent_goods.agent_id=$AgentId and brands.CategoryId=1 group by brands.BrandNo")->asArray()->all();
        //水商品
        $water_goods=ActiveRecord::findBySql("select goods.`name`,goods.brand_id from agent_goods
INNER JOIN goods on goods.id=agent_goods.goods_id
where agent_goods.agent_id=$AgentId
and goods.category_id=1 group by goods.`name`")->asArray()->all();
        //容量
        $water_volume=ActiveRecord::findBySql("select goods.`name`,goods.brand_id,goods.volume from agent_goods
INNER JOIN goods on goods.id=agent_goods.goods_id
where agent_goods.agent_id=$AgentId
and goods.category_id=1 ")->asArray()->all();




//var_dump($agent_id,$water_brand);exit;
        $log='';
        if($id!=''&&is_numeric($id)){//修改
            //获取该条记录的数据
            $log=ActiveRecord::findBySql("select send_water_log.WaterBrandNo,goods.name as goodsName,
send_water_log.Volume,send_water_log.Amount,send_water_log.UseMoney,send_water_log.RestMoney,
send_water_log.SendTime
 from send_water_log
 LEFT JOIN goods on goods.id=send_water_log.WaterGoodsId
 where send_water_log.Id=$id and send_water_log.State=1")->asArray()->all();

        }

        //剩余金额
        $rest_money=0;
        $data=ActiveRecord::findBySql("select RestMoney from user_restmoney where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId")->asArray()->one();
        if($data){
            $rest_money=$data['RestMoney'];
        }

        return $this->render('send-water',[
            'datas'=>json_encode([
                'UserId'=>$UserId,
                'CustomerType'=>$CustomerType,
                'AgentId'=>$AgentId,
                'id'=>$id,//修改时才有
                'log'=>$log,//修改时才有
                'rest_money'=>$rest_money,
                'water_brand'=>$water_brand,
                'water_goods'=>$water_goods,
                'water_volume'=>$water_volume,
            ]),
            'url'=>$urlobj

        ]);
    }

    //保存送水订单（$id!=''时，修改订单保存）
    public function actionSaveOrder(){
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        $id=$this->getParam('id');//id 修改订单保存时才传
        $brand_id=$this->getParam('brand_id');//品牌
        $water_name=$this->getParam('water_name');//名称
        $water_volume=$this->getParam('water_volume');//容量
        $amount=$this->getParam('amount');//数量
        $price=$this->getParam('price');//单价
        $use_money=$this->getParam('use_money');//合计
        $rest_money=$this->getParam('rest_money');//余额
        $send_time=$this->getParam('send_time');//预计送水时间

        if($UserId==''||$CustomerType==''||$AgentId==''||$brand_id==''||$water_name==''||$water_volume==''||
            $amount==''||$price==''||$use_money==''||$rest_money==''||$send_time==''||
            floor($amount)!=$amount||$amount<1){
//            var_dump(['state'=>-1,'mas'=>'参数错误']);exit;
            return json_encode(['state'=>-1,'mas'=>'参数错误']);
        }


        //获取该用户所属服务中心的Id
//        $Dev=ActiveRecord::findBySql("select AgentId from dev_regist where UserId='$UserId' and CustomerType=$CustomerType")->asArray()->one();
//        if(!$Dev){
//            return json_encode(['state'=>-1,'mas'=>"该用户不属于任何服务中心"]);
//        }
//        $agent_id=$Dev['AgentId'];


        //商品id
        $good=ActiveRecord::findBySql("select id from goods
where category_id=1 and `name`='$water_name' and brand_id='$brand_id' and volume=$water_volume")->asArray()->one();

        if(!$good){
//            var_dump(['state'=>-1,'mas'=>'该商品不存在']);exit;
            return json_encode(['state'=>-1,'mas'=>'该商品不存在']);
        }
        $goods_id=$good['id'];




//-------------------------修改保存----------------------------------------
        if($id!=''&&is_numeric($id)){//修改保存
            //获取该条记录的数据
            $log=ActiveRecord::findBySql("select send_water_log.WaterBrandNo,goods.name as goodsName,
send_water_log.Volume,send_water_log.Amount,send_water_log.UseMoney,send_water_log.RestMoney,
send_water_log.SendTime,send_water_log.Price,send_water_log.WaterGoodsId
 from send_water_log
 LEFT JOIN goods on goods.id=send_water_log.WaterGoodsId
 where send_water_log.Id=$id and send_water_log.State=1")->asArray()->one();

            if(!$log){
//                var_dump(['state'=>-1,'mas'=>'该条记录不存在']);exit;
                return json_encode(['state'=>-1,'mas'=>'该条记录不存在']);
            }

//var_dump($log['SendTime']==$send_time);exit;
            //判断修改后的商品还是不是之前的商品
            if($log['WaterBrandNo']==$brand_id&&$log['goodsName']==$water_name
                &&$log['Volume']==$water_volume&&$log['Amount']!=$amount) {//没有修改商品,修改了数量

                //获取此时数据库的库存和价格
                $data=ActiveRecord::findBySql("select stock,realprice from agent_goods where agent_id=$AgentId and goods_id=$goods_id")->asArray()->one();
                if(!$data){
                    return json_encode(['state'=>-1,'mas'=>'该服务中心没有该商品']);
                }
                $stock=$data['stock'];
                $price=$data['realprice'];
                //获取此时数据库的余额、总送水量
                $data=ActiveRecord::findBySql("select RestMoney,TotalSendV from user_restmoney where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId")->asArray()->one();
                if(!$data){
                    return json_encode(['state'=>-1,'mas'=>'该用户还未充值']);
                }
                $total_money=$data['RestMoney'];//余额
                $total_send=$data['TotalSendV'];//总送水量

                //新的合计使用金额
                $new_use_money=$amount*$price;
                //新的库存(加上之前减去的再减去现在应该减去的)
                $new_stock=$stock+$log['Amount']-$amount;
                if($new_stock<0){
//                    var_dump(['state'=>-1,'mas'=>'库存不足']);exit;
                    return json_encode(['state'=>-1,'mas'=>'库存不足']);
                }
                //新的总容量(减去之前加上的再加上现在应该加上的)
//                    $total_sendv=$total_send-($log['Amount']*$log['Volume'])+($water_volume*$amount);
                //新的余额(加上之前减去的再减去现在应该减去的)
                $rest_money=$total_money+($log['Amount']*$log['Price'])-$new_use_money;
                if($rest_money < -500){
//                    var_dump(['state'=>-1,'mas'=>'余额不足']);exit;
                    return json_encode(['state'=>-1,'mas'=>'余额不能小于-500']);
                }
                //保存修改的送水记录
                $sql1="update send_water_log set Amount=$amount,UseMoney=$new_use_money,RestMoney=$rest_money,Price=$price,SendTime='$send_time' where id=$id and State=1";

                //修改库存
                $sql2="update agent_goods set stock=$new_stock where agent_id=$AgentId and goods_id=$goods_id";

                //修改余额
                $sql3="update user_restmoney set RestMoney=$rest_money where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId";
//                $sql3="update user_restmoney set RestMoney=$rest_money,TotalSendV=$total_sendv where DevNo='$DevNo'";

                //事务
                $transaction=\Yii::$app->db->beginTransaction();
                try{
                    //保存修改的送水记录
                    $res= \Yii::$app->db->createCommand($sql1)->execute();
                    if(!$res){
                        throw new \Exception('操作失败1！');
                    }
                    //修改库存
                    $re= \Yii::$app->db->createCommand($sql2)->execute();
                    if(!$re){
                        throw new \Exception('操作失败2！');
                    }
                    //修改余额、总送水量
                    $r= \Yii::$app->db->createCommand($sql3)->execute();
                    if(!$r){
                        throw new \Exception('操作失败3！');
                    }

                    $transaction->commit();
//            var_dump(['state'=>-1,'mas'=>'修改成功']);exit;
                    return json_encode(['state'=>0,'mas'=>"修改成功"]);
                }catch (\Exception $e){
                    $transaction->rollBack();
//            var_dump(['state'=>-1,'mas'=>'修改失败1']);exit;
                    return json_encode(['state'=>-1,'mas'=>"修改失败"]);
                }


                //没有修改商品,没有修改数量，只修改了时间
            }elseif($log['WaterBrandNo']==$brand_id&&$log['goodsName']==$water_name
                &&$log['Volume']==$water_volume&&$log['Amount']==$amount&&$log['SendTime']!=$send_time) {

                $sql = "update send_water_log set SendTime='$send_time' where Id=$id and State=1";
                $re = \Yii::$app->db->createCommand($sql)->execute();
                if ($re) {
//                    var_dump(['state' => -1, 'mas' => '修改成功']);exit;
                    return json_encode(['state' => 0, 'mas' => "修改成功"]);
                }
//                var_dump(['state' => -1, 'mas' => '修改失败2']);exit;
                return json_encode(['state'=>-1,'mas'=>"修改失败"]);

                //没有修改
            }elseif($log['WaterBrandNo']==$brand_id&&$log['goodsName']==$water_name
                &&$log['Volume']==$water_volume&&$log['Amount']==$amount
                &&$log['SendTime']==$send_time){//没有修改

//                var_dump(['state' => 0, 'mas' => '修改成功']);exit;
                return json_encode(['state'=>0,'mas'=>"修改成功"]);

            }else{//修改了商品
                //将之前的数据还原
                //库存还原
                $old_goods_id=$log['WaterGoodsId'];//原来商品的id
                $old_data=ActiveRecord::findBySql("select stock from agent_goods where agent_id=$AgentId and goods_id=$old_goods_id")->asArray()->one();
                if(!$old_data){
                    return json_encode(['state'=>-1,'mas'=>'原来的服务中心没有该商品']);
                }
                $old_stock=$old_data['stock']+$log['Amount'];//现在的库存加上之前减去的数量
//                $price=$old_data['realprice'];
                ////库存还原
                $sql1="update agent_goods set stock=$old_stock where agent_id=$AgentId and goods_id=$old_goods_id";
                //还原余额
                $old_data=ActiveRecord::findBySql("select TotalSendV,RestMoney from user_restmoney where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId")->asArray()->one();
                if(!$old_data){
                    return json_encode(['state'=>-1,'mas'=>'没有充值记录']);
                }

//                $old_total_sendv=$old_data['TotalSendV']-($log['Amount']*$log['Volume']);
                $old_rest_money=$old_data['RestMoney']+($log['Amount']*$log['Price']);
                $sql2="update user_restmoney set RestMoney=$old_rest_money where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId";
//                $sql2="update user_restmoney set TotalSendV=$old_total_sendv,RestMoney=$old_rest_money where DevNo='$DevNo'";
                //删除原来的送水记录
                $sql3="delete from send_water_log where Id=$id and State=1";

                //事务
                $transaction=\Yii::$app->db->beginTransaction();
                try{
                    //保存修改的送水记录
                    $res= \Yii::$app->db->createCommand($sql1)->execute();
                    if(!$res){
                        throw new \Exception('操作失败1！');
                    }
                    //修改库存
                    $re= \Yii::$app->db->createCommand($sql2)->execute();
                    if(!$re){
                        throw new \Exception('操作失败2！');
                    }
                    //修改余额、总送水量
                    $r= \Yii::$app->db->createCommand($sql3)->execute();
                    if(!$r){
                        throw new \Exception('操作失败3！');
                    }

                    $transaction->commit();
//                    var_dump(['state'=>-1,'mas'=>'修改成功']);exit;
//                    return json_encode(['state'=>0,'mas'=>"修改成功"]);
                }catch (\Exception $e){
                    $transaction->rollBack();
//                    var_dump(['state'=>-1,'mas'=>'修改失败3']);exit;
                    return json_encode(['state'=>-1,'mas'=>"修改失败"]);
                }


            }


        }
//-----------------------------------------------------------------


        //获取此时数据库的库存和价格
        $data=ActiveRecord::findBySql("select stock,realprice from agent_goods where agent_id=$AgentId and goods_id=$goods_id")->asArray()->one();
        if(!$data){
//            var_dump(['state'=>-1,'mas'=>'该服务中心没有该商品']);exit;
            return json_encode(['state'=>-1,'mas'=>'该服务中心没有该商品']);
        }
        $stock=$data['stock'];
        $price=$data['realprice'];
        //获取此时数据库的余额、总送水量
        $data=ActiveRecord::findBySql("select RestMoney,TotalSendV from user_restmoney where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId")->asArray()->one();
        if(!$data){
//            var_dump(['state'=>-1,'mas'=>'该用户还未充值']);exit;
            return json_encode(['state'=>-1,'mas'=>'该用户还未充值']);
        }
        $total_money=$data['RestMoney'];//余额
        $total_send=$data['TotalSendV'];//总送水量

//var_dump($price);exit;
        $new_stock=$stock-$amount;//新的库存

        if($new_stock<0){
//            var_dump(['state'=>-1,'mas'=>'库存不足']);exit;
            return json_encode(['state'=>-1,'mas'=>'库存不足']);
        }


        //新的总容量
//        $total_sendv=$total_send+($water_volume*$amount);
        //余额
        $use_money=$amount*$price;
        $rest_money=$total_money-$use_money;//新的余额
        if($rest_money < -500){//最多欠500
//            var_dump(['state'=>-1,'mas'=>'余额不足']);exit;
            return json_encode(['state'=>-1,'mas'=>'余额不能小于-500']);
        }

        $now=date('Y-m-d H:i:s',time());
        //订单来源
        $login_id=\Yii::$app->getUser()->id;
        $role_id=ActiveRecord::findBySql("select admin_role_user.role_id from admin_user
LEFT join admin_role_user on admin_user.Id=admin_role_user.uid
where admin_user.Id=$login_id")->asArray()->one()['role_id'];//角色id
        $from=2;//服务中心  1 微信端（客户），2 服务中心，3 太极兵
        if($role_id==1){//admin
            $from=3;//太极兵
        }

        //保存送水记录 state 1 已出单，2 已完成
        $sql1="insert into send_water_log (UserId,CustomerType,AgentId,WaterBrandNo,WaterGoodsId,Volume,Amount,UseMoney,RestMoney,SendTime,FinishTime,Price,State,RowTime,`From`)
              values('$UserId',$CustomerType,$AgentId,'$brand_id',$goods_id,$water_volume,$amount,$use_money,$rest_money,'$send_time',NULL,$price,1,'$now',$from)";

        //减去库存
        $sql2="update agent_goods set stock=stock-$amount where agent_id=$AgentId and goods_id=$goods_id";

        //修改余额、操作时间
        $sql3="update user_restmoney set RestMoney=$rest_money,LastActTime='$now' where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId";
//        $sql3="update user_restmoney set RestMoney=$rest_money,LastActTime='$now',TotalSendV=$total_sendv where DevNo='$DevNo'";

        //事务
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            //保存送水数据
            $res= \Yii::$app->db->createCommand($sql1)->execute();
            if(!$res){
                throw new \Exception('操作失败1！');
            }
            //减去库存
            $re= \Yii::$app->db->createCommand($sql2)->execute();
            if(!$re){
                throw new \Exception('操作失败2！');
            }
            //修改余额、操作时间、总送水量
            $r= \Yii::$app->db->createCommand($sql3)->execute();
            if(!$r){
                throw new \Exception('操作失败3！');
            }

            $transaction->commit();
//            var_dump(['state'=>-1,'mas'=>'出单成功']);exit;
            return json_encode(['state'=>0,'mas'=>"出单成功"]);
        }catch (\Exception $e){
            $transaction->rollBack();
//            var_dump($e->getMessage());exit;
            return json_encode(['state'=>-1,'mas'=>"出单失败"]);
        }

    }

    //ajax 获取对应的库存和单价
    public function actionStockPrice(){
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        $brand_id=$this->getParam('brand_id');
        $water_name=$this->getParam('water_name');
        $water_volume=$this->getParam('water_volume');
        if($UserId==''||$CustomerType==''||$AgentId==''||$brand_id==''||$water_name==''||$water_volume==''){
            return json_encode(['state'=>-1,'mas'=>'参数错误']);

        }
//        //获取该用户所属服务中心的Id
//        $agent_id=0;
//        $Dev=ActiveRecord::findBySql("select AgentId from dev_regist where UserId='$UserId' and CustomerType=$CustomerType")->asArray()->one();
//        if($Dev){
//            $agent_id=$Dev['AgentId'];
//        }
        //商品id
        $data=ActiveRecord::findBySql("select id from goods
where category_id=1 and `name`='$water_name' and brand_id='$brand_id' and volume=$water_volume")->asArray()->one();
        if(!$data){
            return json_encode(['state'=>-1,'mas'=>'该商品不存在']);
        }
        $goods_id = $data['id'];

        $data2=ActiveRecord::findBySql("select stock,realprice from agent_goods where agent_id=$AgentId and goods_id=$goods_id")->asArray()->one();
        if(!$data2){
            return json_encode(['state'=>-1,'mas'=>'该服务中心没有此商品']);
        }
        //水库存
        $result['water_stock']=$data2['stock'];
        //单价
        $result['water_price']=$data2['realprice'];

        return json_encode(['state'=>0,'data'=>$result]);
    }


 //-----------已弃用接口----------------------------------
    //充值
    public function actionRecharge(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''){
            return json_encode(['state'=>-1,'mas'=>"参数错误"]);
        }
        //剩余金额
        $rest_money=0;
        $data=ActiveRecord::findBySql("select RestMoney from user_restmoney where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId")->asArray()->one();
        if($data){
            $rest_money=$data['RestMoney'];
        }



    if(\Yii::$app->request->isPost){//保存充值数据、充值记录

        $pay_type=$this->getParam('pay_type');//支付方式 1 现金，2 微信，3 支付宝
        $pay_money=addslashes($this->getParam('pay_money'));//支付金额
//        $total_rest_money=$this->getParam('total_rest_money');//合计金额
        $total_rest_money=$pay_money+$rest_money;//合计金额(充值后的余额)
//        if($pay_type==''||$pay_money==''||$pay_money<=0||!is_numeric($pay_money)){
        if($pay_type==''||$pay_money===''||!is_numeric($pay_money)){
            return json_encode(['state'=>-1,'mas'=>"参数错误"]);
        }
        $now=date('Y-m-d H:i:s',time());

            if($data){//之前充值过
                $sql1="update user_restmoney set RestMoney=RestMoney+$pay_money,LastActTime='$now' where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId ";
            }else{
                $sql1="insert into user_restmoney (UserId,CustomerType,AgentId,RestMoney,LastActTime) values('$UserId',$CustomerType,$AgentId,$pay_money,'$now') ";
            }

            $sql2="insert into user_recharge_log (UserId,CustomerType,AgentId,PayMoney,PayType,RestMoney,RowTime) values('$UserId',$CustomerType,$AgentId,$pay_money,$pay_type,$total_rest_money,'$now') ";

            $transaction = \Yii::$app->db->beginTransaction();
            try{
                //保存充值数据
                $res= \Yii::$app->db->createCommand($sql1)->execute();
                if(!$res){
                    throw new \Exception('操作失败1！');
                }

                //保存充值记录
                $rt= \Yii::$app->db->createCommand($sql2)->execute();
                if(!$rt){
                    throw new \Exception('操作失败2！');
                }


                //以上执行都成功，则对数据库进行实际执行
                $transaction->commit();
                return json_encode(['state'=>0,'mas'=>"充值成功"]);
            }catch (\Exception $e){
                //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
                $transaction->rollBack();
                return json_encode(['state'=>-1,'mas'=>"充值失败"]);

            }

        }

        return $this->render('recharge',['rest_money'=>$rest_money,'UserId'=>$UserId,'CustomerType'=>$CustomerType,'AgentId'=>$AgentId,'url'=>$urlobj]);

    }

    //充值记录
    public function actionRechargeLog(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $CreateTime=$this->getParam('CreateTime');//组创建时间（没有创建组 默认 "0"）
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            return $this->redirect(['index']);
        }
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        $selecttime=$this->getParam("selecttime");
        $pay_type=$this->getParam("pay_type");
        $startTime='';
        $endTime='';
        $where=" where user_recharge_log.UserId='$UserId'
        and user_recharge_log.CustomerType=$CustomerType
        and user_recharge_log.AgentId=$AgentId";
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            if($where){
                $where.=' and ';
            }
            $where.=" user_recharge_log.RowTime >= '$startTime' and user_recharge_log.RowTime <= '$endTime'";
        }
        if($pay_type!=''){
            if($where){
                $where.=' and ';
            }
            $where.=" user_recharge_log.PayType= $pay_type ";
        }

        $datas=ActiveRecord::findBySql("select user_info.Name,user_info.Tel,
user_recharge_log.CustomerType,user_recharge_log.PayType,user_recharge_log.PayMoney,
user_recharge_log.RestMoney,user_recharge_log.RowTime,user_recharge_log.OutOrIn,
user.Name as GroupMemberName
from user_recharge_log
inner join user_info on user_recharge_log.UserId=user_info.Id
left join user_restmoney on user_restmoney.Id=user_recharge_log.GroupMemberId
left join user_info as user on user_restmoney.UserId=user.Id
$where order by user_recharge_log.RowTime desc");

        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." limit $offset,$limit ")->asArray()->all();
        return $this->render('recharge-log',
            ['data'=>json_encode($data),
            'total'=>$total,
            'UserId'=>$UserId,
            'CustomerType'=>$CustomerType,
            'AgentId'=>$AgentId,
            'where_data'=>json_encode(['selecttime'=>$selecttime,'pay_type'=>$pay_type]),
            'url'=>$urlobj,
            'CreateTime'=>$CreateTime,
            ]
        );

    }

    //获取充值记录分页数据
    public function actionRechargeLogPage(){
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''){
            return json_encode(['state'=>-1,'mas'=>"参数错误"]);
        }
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        $selecttime=$this->getParam("selecttime");
        $pay_type=$this->getParam("pay_type");
        $startTime='';
        $endTime='';
        $where=" where user_recharge_log.UserId='$UserId' and user_recharge_log.CustomerType=$CustomerType and user_recharge_log.AgentId=$AgentId";
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            if($where){
                $where.=' and ';
            }
            $where.=" user_recharge_log.RowTime >= '$startTime' and user_recharge_log.RowTime <= '$endTime'";
        }
        if($pay_type!=''){
            if($where){
                $where.=' and ';
            }
            $where.=" user_recharge_log.PayType= $pay_type ";
        }

        $datas=ActiveRecord::findBySql("select user_info.Name,user_info.Tel,
user_recharge_log.CustomerType,user_recharge_log.PayType,user_recharge_log.PayMoney,
user_recharge_log.RestMoney,user_recharge_log.RowTime,user_recharge_log.OutOrIn,
user.Name as GroupMemberName
from user_recharge_log
inner join user_info on user_recharge_log.UserId=user_info.Id
left join user_restmoney on user_restmoney.Id=user_recharge_log.GroupMemberId
left join user_info as user on user_restmoney.UserId=user.Id
$where order by user_recharge_log.RowTime desc");

//        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." limit $offset,$limit ")->asArray()->all();
        return json_encode(['data'=>$data,'UserId'=>$UserId,'CustomerType'=>$CustomerType,'AgentId'=>$AgentId]);

    }


    //送水记录
    public function actionSendLog(){
        $CreateTime=$this->getParam('CreateTime');//组创建时间（没有创建组 默认 "0"）
        $urlobj = $this->getParam("Url");//返回参数记录
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''){
            \Yii::$app->session->setFlash('error','参数错误');
            return $this->redirect(['index']);
//            return json_encode(['state'=>-1,'mas'=>"参数错误"]);
        }
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }
        $selecttime=$this->getParam('selecttime');//时间段
        $brand_id=$this->getParam('brand_id');//品牌
        $water_name=$this->getParam('water_name');//商品
        $water_volume=$this->getParam('water_volume');//容量
        $from=$this->getParam('from');//来源

        //获取该设备所属服务中心id
//        $agent_id=0;
//        $Dev=ActiveRecord::findBySql("select AgentId from dev_regist where UserId='$UserId' and CustomerType=$CustomerType")->asArray()->one();
//        if($Dev){
//                $agent_id=$Dev['AgentId'];
//        }

        //获取该服务中心的水品牌
        $water_brand=ActiveRecord::findBySql("select brands.BrandNo,brands.BrandName from agent_goods
INNER JOIN goods on goods.id=agent_goods.goods_id
INNER JOIN brands on brands.BrandNo=goods.brand_id
where agent_goods.agent_id=$AgentId and brands.CategoryId=1 group by brands.BrandNo")->asArray()->all();
        //水商品
        $water_goods=ActiveRecord::findBySql("select goods.`name`,goods.brand_id from agent_goods
INNER JOIN goods on goods.id=agent_goods.goods_id
where agent_goods.agent_id=$AgentId
and goods.category_id=1 group by goods.`name`")->asArray()->all();
        //容量
        $water_volumes=ActiveRecord::findBySql("select goods.`name`,goods.brand_id,goods.volume from agent_goods
INNER JOIN goods on goods.id=agent_goods.goods_id
where agent_goods.agent_id=$AgentId
and goods.category_id=1 ")->asArray()->all();


        //获取表格数据
        $data=$this->GetSendLog($UserId,$CustomerType,$AgentId,$offset,$limit,$selecttime,$brand_id,
            $water_name,$water_volume,$from);

        return $this->render('send-log',[
            'CreateTime'=>$CreateTime,
            'url'=>$urlobj,
            'data'=>json_encode($data['data']),//表格数据
            'total'=>json_encode($data['total']),//总条数
            'UserId'=>$UserId,
            'CustomerType'=>$CustomerType,
            'AgentId'=>$AgentId,
            //已选条件
            'select_where'=>json_encode([
                'selecttime'=>$selecttime,
                'brand_id'=>$brand_id,
                'water_name'=>$water_name,
                'water_volume'=>$water_volume,
                'from'=>$from,
            ]),
            //下拉框数据
            'where_data'=>json_encode([
                'water_brand'=>$water_brand,
                'water_goods'=>$water_goods,
                'water_volumes'=>$water_volumes,
            ])
        ]);

    }
    //获取表格数据(送水记录)
    public function GetSendLog($UserId,$CustomerType,$AgentId,$offset,$limit,$selecttime,$brand_id,
                               $water_name,$water_volume,$from){
        $where=" where send_water_log.UserId='$UserId'
        and send_water_log.CustomerType=$CustomerType
        and send_water_log.AgentId=$AgentId ";
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
            $where.=" and send_water_log.FinishTime >= '$startTime' and send_water_log.FinishTime <= '$endTime'";
        }
        if($brand_id){
            $where.=" and send_water_log.WaterBrandNo = '$brand_id' ";
        }
        if($water_name){
            //获取goods_id
//            $data=ActiveRecord::findBySql("select id from goods where category_id=1 and `name`='$water_name'")->asArray()->all();
//            $goods_ids=json_encode(array_column($data,'id'));
//            $goods_ids=str_replace('[','',$goods_ids);
//            $goods_ids=str_replace(']','',$goods_ids);
//            $where.=" and send_water_log.WaterGoodsId in ($goods_ids) ";
            $where.=" and exists(select 1 from goods where category_id=1 and `name`='$water_name' and send_water_log.WaterGoodsId=id )";
        }
//        var_dump($where);exit;
        if($water_volume){
            $where.=" and send_water_log.Volume = $water_volume ";
        }
        if($from){
            $where.=" and send_water_log.From = $from ";
        }
        $datas=ActiveRecord::findBySql("select send_water_log.id,send_water_log.UserId,user_info.Name,user_info.Tel,send_water_log.CustomerType,
send_water_log.From,brands.BrandName,goods.name as goodsName,send_water_log.Volume,
send_water_log.Amount,send_water_log.Price,send_water_log.UseMoney,send_water_log.RestMoney,
send_water_log.SendTime,send_water_log.FinishTime,send_water_log.State,send_water_log.RowTime
from send_water_log
left join user_info on user_info.Id=send_water_log.UserId
left join brands on send_water_log.WaterBrandNo=brands.BrandNo
left join goods on send_water_log.WaterGoodsId=goods.id $where order by send_water_log.State asc,send_water_log.FinishTime Desc");

        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." limit $offset,$limit ")->asArray()->all();
        return ['total'=>$total,'data'=>$data];
    }

    //送水记录（分页）
    public function actionSendLogPage(){
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''){
            return json_encode(['state'=>-1,'mas'=>'参数错误']);
        }
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }
        $selecttime=$this->getParam('selecttime');//时间段
        $brand_id=$this->getParam('brand_id');//品牌
        $water_name=$this->getParam('water_name');//商品
        $water_volume=$this->getParam('water_volume');//容量
        $from=$this->getParam('from');//来源



        //获取表格数据
        $data=$this->GetSendLog($UserId,$CustomerType,$AgentId,$offset,$limit,$selecttime,$brand_id,
            $water_name,$water_volume,$from);

        return json_encode([
            'data'=>$data['data'],//表格数据
            'UserId'=>$UserId,
            'CustomerType'=>$CustomerType,
            'AgentId'=>$AgentId,

            ]);


    }

    //将已出单改成已完成
    public function actionChangeState(){
        $id=$this->getParam('id');
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''||$id==''){
            return json_encode(['state'=>-1,'mas'=>"参数错误"]);
        }
        $now=date('Y-m-d H:i:s',time());
        //修改状态
        $sql1="update send_water_log set State=2,FinishTime='$now' where Id=$id";
        $transaction=\Yii::$app->db->beginTransaction();
        try{
    //------------修改账户状态---------------

            //状态修改成功后，判断是否还有待确认的记录
            $data=ActiveRecord::findBySql("select UserId,AgentId,CustomerType
            from send_water_log
            where UserId='$UserId' and AgentId=$AgentId and CustomerType=$CustomerType
            and State=1 and Id not in ($id)")->asArray()->one();
            if(!$data){//没有待确认的状态
                //修改账户状态
                $state=1;//默认需送水
                //获取账户信息
                $account=ActiveRecord::findBySql("select Id,SendWaterTime from user_restmoney
                where UserId='$UserId' and AgentId=$AgentId and CustomerType=$CustomerType")->asArray()->one();
                if($account){
                    //判断预计送水时间是否大于 往后推3天的日期
                    $after_3_day=date("Y-m-d",strtotime("+3 day"));//往后推3天的日期
                    if($account['SendWaterTime']=='近期还没有用水'||$account['SendWaterTime']>$after_3_day){
                        $state=3;//已完成
                    }
                    //修改状态
                    $sql2="update user_restmoney set State=$state where Id={$account['Id']}";
                    $re=\Yii::$app->db->createCommand($sql2)->execute();
                    if(!$re){
                        throw new Exception('账户状态修改失败');
                    }
                }

            }

    //------------修改账户状态---------------

            $re=\Yii::$app->db->createCommand($sql1)->execute();
            if(!$re){
               throw new Exception('修改记录状态失败');
            }
            $transaction->commit();
            return json_encode(['state'=>0,'mas'=>"成功"]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'mas'=>$e->getMessage()]);
        }


    }


    //删除
    public function actionDel(){
        $id=$this->getParam('id');
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        if($UserId==''||$CustomerType==''||$AgentId==''||$id==''){
           return json_encode(['state'=>-1,'mas'=>"参数错误"]);
        }


        //获取该条记录的数据
        $log=ActiveRecord::findBySql("select send_water_log.WaterBrandNo,goods.name as goodsName,
send_water_log.Volume,send_water_log.Amount,send_water_log.UseMoney,send_water_log.RestMoney,
send_water_log.SendTime,send_water_log.Price,send_water_log.WaterGoodsId,agent_stock.factory_id as Fid,
goods.category_id,goods.category2_id,send_water_log.BarCode
 from send_water_log
 inner join goods on goods.id=send_water_log.WaterGoodsId
 inner join agent_stock on agent_stock.goods_id=send_water_log.WaterGoodsId
 where agent_stock.agent_id=$AgentId and agent_stock.stock > 0
 and send_water_log.Id=$id and send_water_log.State=1")->asArray()->one();

        if(!$log){
            return json_encode(['state'=>-1,'mas'=>'该条记录不存在']);
        }
        if($log['BarCode']){
            return json_encode(['state'=>-1,'mas'=>'扫码送水的记录不可删除']);
        }

        $now=date('Y-m-d H:i:s',time());
        //将之前的数据还原(删除送水记录、增加入库记录、加回库存、修改电子账户（余额、总送水量、剩余水量、操作时间、计算预计送水时间）)
        //1、删除送水记录
        $sql1="delete from send_water_log where id=$id";
        //2、增加入库记录
        $result=$this->GetTotalAndRestStock($AgentId,$log['WaterGoodsId'],$log['Fid']);
        $rest_stock=$result['rest_stock']+$log['Amount'];
        $total=$result['total'];
        $sql2="insert into agent_stock_log
                (agent_id,factory_id,goods_id,action_type,num,rest_stock,total,remark,row_time)
                values($AgentId,{$log['Fid']},{$log['WaterGoodsId']},1,{$log['Amount']},$rest_stock,$total,3,'$now')";

        //3、还原库存
        $sql3="update agent_stock set stock=stock+{$log['Amount']},update_time='$now'
        where agent_id=$AgentId and goods_id={$log['WaterGoodsId']} and factory_id={$log['Fid']}";

        //4、修改电子账户（余额、总送水量、剩余水量、操作时间、计算预计送水时间）
        $account=ActiveRecord::findBySql(" select Id,RestMoney,TotalSendV,RestWater,
        AverageUse,SendWaterTime,LastSendV
            from user_restmoney
            where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId ")->asArray()->one();
        if(!$account){
            return json_encode(['state'=>-1,'mas'=>"电子账户不存在"]);
        }



        $SendWaterTime='近期还没有用水';
        $volume=$log['Volume']*$log['Amount'];

        if($account['TotalSendV']==$volume){
            $SendWaterTime='没有送水记录';
        }
        if($account['LastSendV']==$volume){
            $SendWaterTime=$account['SendWaterTime'];
        }

        if($account['AverageUse']>0){
            //计算预计送水时间
            //还可以用几天
            $days=floor(($account['RestWater']-$volume)/$account['AverageUse']);
            $SendWaterTime=date("Y-m-d",strtotime("+$days day"));
        }

 //----------账户状态逻辑---------
        $state=1;//需送水
        //账户是否还有待确认送水记录(去掉要删除的这条记录)
        $send_log=ActiveRecord::findBySql("select Id from send_water_log
 where send_water_log.UserId='$UserId' and send_water_log.AgentId=$AgentId
 and send_water_log.CustomerType=$CustomerType and send_water_log.State=1
 and Id not in ($id)")->asArray()->one();
        if($send_log){//有待确认送水记录
            $state=2;//已配送
        }else{

            if($SendWaterTime=='近期还没有用水'){
                $state=3;//已完成
            }elseif($SendWaterTime=='没有送水记录'){
                $state=1;//需送水
            }else{
                //判断预计送水时间 是否大于 当前日期 往后推3天的日期
                $after_3_day=date("Y-m-d",strtotime("+3 day"));//当前日期往后推3天的日期
                if($SendWaterTime > $after_3_day){
                    $state=3;//已完成
                }else{
                    $state=1;//需送水
                }
            }


        }

 //----------账户状态逻辑---------

        $sql4="update user_restmoney set
        RestMoney=RestMoney+{$log['UseMoney']},LastActTime='$now',
        TotalSendV=TotalSendV-$volume,RestWater=RestWater-$volume,
        SendWaterTime='$SendWaterTime',LastSendV=LastSendV-$volume,
        State=$state
        where Id={$account['Id']}";


        //事务
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            //删除送水记录
            $res= \Yii::$app->db->createCommand($sql1)->execute();
            if(!$res){
                throw new \Exception('删除送水记录！');
            }
            //增加入库记录
            $re= \Yii::$app->db->createCommand($sql2)->execute();
            if(!$re){
                throw new \Exception('增加入库记录！');
            }
            //还原库存
            $r= \Yii::$app->db->createCommand($sql3)->execute();
            if(!$r){
                throw new \Exception('还原库存！');
            }
            //修改电子账户
            $r= \Yii::$app->db->createCommand($sql4)->execute();
            if(!$r){
                throw new \Exception('修改电子账户！');
            }

            $transaction->commit();
            return json_encode(['state'=>0,'mas'=>"删除成功"]);
        }catch (\Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'mas'=>$e->getMessage()]);
        }

    }

    //出、入库时获取累计入库总数量、剩余库存数量
    public function GetTotalAndRestStock($agent_id,$goods_id,$factory_id){
        //总入库数量
        $total=0;
        $data=ActiveRecord::findBySql("select MAX(total)as total from agent_stock_log
            where agent_id=$agent_id and goods_id=$goods_id and factory_id=$factory_id")->asArray()->one();
        if($data)$total=$data['total'];
        //剩余库存总数
        $rest_stock=0;
        $data2=ActiveRecord::findBySql("select stock from agent_stock
            where agent_id=$agent_id and goods_id=$goods_id and factory_id=$factory_id")->asArray()->one();
        if($data2)$rest_stock=$data2['stock'];

        return ['total'=>$total,'rest_stock'=>$rest_stock];
    }

    //获取对应账户的设备编号
    public function actionGetDevno(){
        $UserId=$this->getParam('UserId');
        $CustomerType=$this->getParam('CustomerType');
        $AgentId=$this->getParam('AgentId');
        $state=$this->getParam('state');//用户状态（0 未激活，1 正常，2 已初始化，3 全部）
        if($UserId==''||$CustomerType==''||$AgentId==''){
            return json_encode(['state'=>-1,'mas'=>'参数错误']);
        }

        $where='';
        if($state==0){//未激活
            $where=' and not exists(select 1 from dev_cmd where CmdType=4 AND State=1 and DevNo=dev_regist.DevNo) and dev_regist.IsActive=0 ';
        }
        if($state==1){//正常
            $where=' and not exists(select 1 from dev_cmd where CmdType=4 AND State=1 and DevNo=dev_regist.DevNo) and dev_regist.IsActive=1 ';
        }
        if($state==2){//已初始化
            $where=' and exists(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)';
        }

        $DevNos=ActiveRecord::findBySql("select DevNo from dev_regist where UserId='$UserId' and CustomerType=$CustomerType and AgentId=$AgentId $where")->asArray()->all();
        return json_encode(['DevNos'=>$DevNos]);
    }

}
