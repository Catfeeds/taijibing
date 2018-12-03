<?php
namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);
//设备预警
use backend\models\AdminRoleUser;
use backend\models\DevRegist;
use backend\models\DevWarning;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use backend\models\Address;
use yii\db\Exception;
use yii\web\Controller;

class DevWarningController extends BaseController{


    public function actionWarningDayOnece(){

        $date=date('Y-m-d',strtotime('-15 day'));//倒退15天的日期
//        var_dump($date);exit;

        //获取所有（注册时间在15天前的并且是激活的）设备编号(去掉已初始化的和测试设备)//设备编号为0、1 的为测试设备，不用预警
        $DevNos=ActiveRecord::findBySql("select DevNo
from dev_regist
where DevNo not in (select DevNo from dev_cmd where CmdType=4 and State=1 GROUP BY DevNo)
AND DevNo <> 0 and DevNo <> 1
and `Date` < '$date'
and IsActive=1
")->asArray()->all();
//        var_dump($DevNos);exit;

        $str="(select DevNo
from dev_regist
where DevNo not in (select DevNo from dev_cmd where CmdType=4 and State=1 GROUP BY DevNo)
AND DevNo <> 0 and DevNo <> 1
and `Date` < '".$date."' and IsActive=1)";


        //类型一.无数据上传 （没插电，信号连接问题，设备损坏），与最近上传时间，间隔超过半个月报警。
        //类型二.长期未操作 （连接正常，功能正常，但是没进行任何操作）。与最近上传时间，间隔超过半个月报警。
        //类型三.长时间未抽水 设备情况正常，能开关机，只是长时间未抽水，有抽水，未扫码视为正常，仅当长时间未抽水报警），与最近上传时间，超过半个月报警。
        //类型五.位置变更 （位置变更超过十公里预警），规则为：用户注册填写的位置信息对比当天设备上传的位置。
        //类型六.重复条码 （不同机器扫了同一条码）。

        //半个月前注册的、近半个月内有扫码的设备（扫码成功）
        $dev_water_scan_log=ActiveRecord::findBySql("select DevNo
from dev_water_scan where DevNo in $str
and RowTime > '$date'")->asArray()->all();


        //半个月前注册的、近半个月内有定位信息的设备
        $location=ActiveRecord::findBySql("select DevNo
from dev_location where DevNo in $str
and RowTime > '$date' ")->asArray()->all();
//        var_dump($location);exit;
        //半个月前注册的、近半个月内有链接的设备
        $dev_connect=ActiveRecord::findBySql("select DevNo
from dev_status where DevNo in $str
and LastConnectDate > '$date' ")->asArray()->all();
//        var_dump($location,$dev_connect);exit;
        //半个月前注册的、近半个月内有操作记录的设备
        $dev_act=ActiveRecord::findBySql("select DevNo
from dev_action_log where DevNo in $str
and ActDate > '$date' ")->asArray()->all();
        //半个月前注册的、近半个月内有抽水记录的设备
        $dev_pump=ActiveRecord::findBySql("select DevNo
from dev_action_log where DevNo in $str
and ActDate > '$date' and ActType=16 ")->asArray()->all();

        //---------------
        //无数据上传预警存在，并没有解决的设备
        $warning_no_datas=ActiveRecord::findBySql("select DevNo from dev_warning where  `Type`='无数据上传' and (State=0 or State=1)")->asArray()->all();
        //解决时间不超过5天的设备(解决后5内不再预警)
        $date_5=strtotime('-5 day');
        $warning_no_datas2 = ActiveRecord::findBySql("select DevNo from dev_warning where `Type`='无数据上传' and State=2 and Solve_Time>'$date_5'")->asArray()->all();

        //位置便更
        //获取对应设备的经纬度
        $datas=ActiveRecord::findBySql("select DevNo,BaiDuLat,BaiDuLng from dev_location")->asArray()->all();
        $lat_lng=[];
        foreach($datas as $data){
           $lat_lng[$data['DevNo']]=['BaiDuLat'=>$data['BaiDuLat'],'BaiDuLng'=>$data['BaiDuLng']];
        }
        //对应设备的注册地址
        $datas2=ActiveRecord::findBySql("select DevNo,Address from dev_regist")->asArray()->all();
        $addresses=[];
        foreach($datas2 as $data2){
            $addresses[$data2['DevNo']]=['Address'=>$data2['Address']];
        }

        //判断是否该预警已经存在
        $address_change=ActiveRecord::findBySql("select DevNo from dev_warning where `Type` like '位置变更%' and (State=0 or State=1)")->asArray()->all();;
        //解决后5内不再预警
        $address_change2 = ActiveRecord::findBySql("select DevNo from dev_warning where `Type` like '位置变更%' and State=2 and Solve_Time>'$date_5'")->asArray()->all();

        //长期未抽水
        //判断是否该预警已经存在
        $no_pump_devnos=ActiveRecord::findBySql("select DevNo from dev_warning where Type='长期未抽水' and (State=0 or State=1)")->asArray()->all();;
        //解决后5内不再预警
        $no_pump_devnos2 = ActiveRecord::findBySql("select DevNo from dev_warning where Type='长期未抽水' and State=2 and Solve_Time>'$date_5'")->asArray()->all();

        //长期未操作
        //判断是否该预警已经存在
        $no_act=ActiveRecord::findBySql("select DevNo from dev_warning where Type='长期未操作' and (State=0 or State=1)")->asArray()->all();
        //解决后5内不再预警
        $no_act2 = ActiveRecord::findBySql("select DevNo from dev_warning where  Type='长期未操作' and State=2 and Solve_Time>'$date_5'")->asArray()->all();


        //---------------


        foreach($DevNos as $DevNo) {

            //无数据上传
            //没有扫码记录、没有定位信息、没有链接设备、没有操作记录
            if (!in_array($DevNo, $dev_water_scan_log) && !in_array($DevNo, $location)
                && !in_array($DevNo, $dev_connect) && !in_array($DevNo, $dev_act)
            ) {
//                //判断该预警是否存在，并没有解决
//                $data = ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and `Type`='无数据上传' and (State=0 or State=1)")->asArray()->all();
//                //解决后5内不再预警
//                $date_5=date('Y-m-d',strtotime('-5 day'));
//                $data2 = ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and `Type`='无数据上传' and State=2 and Solve_Time>'$date_5'")->asArray()->all();


                if (!in_array($DevNo,$warning_no_datas)&&!in_array($DevNo,$warning_no_datas2)) {
//                if (!$data&&!$data2) {
                    $dev_warning = new DevWarning();

                    $dev_warning->DevNo = $DevNo['DevNo'];
                    $dev_warning->Type = '无数据上传';
                    $dev_warning->Level = 3;
                    $dev_warning->State = 0;
                    $dev_warning->UpTime = time();
                    //上次链接设备的时间
                    $last_time = ActiveRecord::findBySql("select LastConnectDate,LastConnectTime from dev_status where DevNo='{$DevNo['DevNo']}' ")->asArray()->all();
//                        var_dump($last_time);exit;
                    if (!$last_time) {
                        $dev_warning->RowTime = '';
                    } else {
                        $dev_warning->RowTime = $last_time[0]['LastConnectDate'] . ' ' . $last_time[0]['LastConnectTime'];
                    }

                    $dev_warning->save(false);
                }
                continue;

            }


            //位置变更
            //有定位信息、有链接设备
            if (in_array($DevNo, $location)&& in_array($DevNo, $dev_connect)
            ){
                //设备定位的经纬度
//                $data=ActiveRecord::findBySql("select BaiDuLat,BaiDuLng
//from dev_location where DevNo='{$DevNo['DevNo']}'")->asArray()->one();

                $BaiDuLat=$lat_lng[$DevNo['DevNo']]['BaiDuLat'];
                $BaiDuLng=$lat_lng[$DevNo['DevNo']]['BaiDuLng'];

                //获取用户注册的地址
//                $address=DevRegist::findOne(['DevNo'=>$DevNo['DevNo']])->Address;
                $address=$addresses[$DevNo['DevNo']]['Address'];

                if($address){
                    //获取用户用户注册时填写地址的经纬度
                    $data=$this->GetLatLng($address);
                    if($data){
                        $lat=$data['lat'];
                        $lng=$data['lng'];

                        //计算两个地址的距离
                        $distance=$this->getDistance($BaiDuLat,$BaiDuLng,$lat,$lng);
                        //距离超过10公里
                        if($distance>10){

//                            //判断是否该预警已经存在
//                            $data=ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and `Type` like '位置变更%' and (State=0 or State=1)")->asArray()->all();;
//
//                            //解决后5内不再预警
//                            $date_5=date('Y-m-d',strtotime('-5 day'));
//                            $data2 = ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and `Type` like '位置变更%' and State=2 and Solve_Time>'$date_5'")->asArray()->all();


                            if(!in_array($DevNo,$address_change)&&!in_array($DevNo,$address_change2)){
//                            if(!$data&&!$data2){
                                $dev_warning=new DevWarning();
                                $dev_warning->DevNo=$DevNo['DevNo'];
                                $dev_warning->Type="位置变更".$distance."公里";
                                $dev_warning->Level=3;
                                $dev_warning->State=0;
                                $dev_warning->UpTime=time();
                                $time=ActiveRecord::findBySql("select RowTime from dev_location where DevNo='{$DevNo['DevNo']}'")->asArray()->one();
                                $dev_warning->RowTime=$time['RowTime'];
                                $dev_warning->save(false);

                            }

                        }
                    }
                }
            }


            //长时间未抽水
            //有定位信息、有链接设备、有操作记录、没有抽水记录
            if (in_array($DevNo, $location)&& in_array($DevNo, $dev_connect)
                && in_array($DevNo, $dev_act)&& !in_array($DevNo, $dev_pump)
            ){
//                //判断是否该预警已经存在
//                $data=ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and Type='长期未抽水' and (State=0 or State=1)")->asArray()->all();;
//
//                //解决后5内不再预警
//                $date_5=date('Y-m-d',strtotime('-5 day'));
//                $data2 = ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and Type='长期未抽水' and State=2 and Solve_Time>'$date_5'")->asArray()->all();


                if(!in_array($DevNo,$no_pump_devnos)&&!in_array($DevNo,$no_pump_devnos2)){
//                if(!$data&&!$data2){
                    $dev_warning=new DevWarning();
                    $dev_warning->DevNo=$DevNo['DevNo'];
                    $dev_warning->Type='长期未抽水';
                    $dev_warning->Level=2;
                    $dev_warning->State=0;
                    $dev_warning->UpTime=time();
                    $last_pump_time=ActiveRecord::findBySql("select RowTime from dev_action_log where DevNo='{$DevNo['DevNo']}' and ActType=16  order by RowTime desc limit 1")->asArray()->all();
                    if(!$last_pump_time){
                        $dev_warning->RowTime='';
                    }else{
                        $dev_warning->RowTime=$last_pump_time[0]['RowTime'];
                    }

                    $dev_warning->save(false);

                }

                continue;

            }

            //长期未操作
            //有定位信息、有链接设备、没有操作记录

            if (in_array($DevNo, $location)
                && in_array($DevNo, $dev_connect) && !in_array($DevNo, $dev_act)
            ){
//                //判断是否该预警已经存在
//                $data=ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and Type='长期未操作' and (State=0 or State=1)")->asArray()->all();
//
//                //解决后5内不再预警
//                $date_5=date('Y-m-d',strtotime('-5 day'));
//                $data2 = ActiveRecord::findBySql("select DevNo from dev_warning where DevNo='{$DevNo['DevNo']}' and Type='长期未操作' and State=2 and Solve_Time>'$date_5'")->asArray()->all();


                if(!in_array($DevNo,$no_act)&&!in_array($DevNo,$no_act2)){
//                if(!$data&&!$data2){
                    $dev_warning=new DevWarning();
                    $dev_warning->DevNo=$DevNo['DevNo'];
                    $dev_warning->Type='长期未操作';
                    $dev_warning->Level=3;
                    $dev_warning->State=0;
                    $dev_warning->UpTime=time();
                    $last_act_time=ActiveRecord::findBySql("select RowTime from dev_action_log where DevNo='{$DevNo['DevNo']}' order by RowTime desc limit 1 ")->asArray()->all();
                    if(!$last_act_time){
                        $dev_warning->RowTime='';
                    }else{
                        $dev_warning->RowTime=$last_act_time[0]['RowTime'];
                    }

                    $dev_warning->save(false);

                }
            }



        }

        return $this->redirect(['timed-task/task-day-onece']);
    }


    //预警（重复条码、不正常烧水）
    public function actionWarningHourOnece(){
        //被非同一台设备重复扫码的条码
//$str="(SELECT BarCode FROM (SELECT BarCode FROM dev_water_scan_log
//WHERE ErrorCode=10 GROUP BY BarCode,DevNo HAVING COUNT(BarCode)>1)AS temp GROUP BY BarCode HAVING COUNT(BarCode)>1)";
        $str="(SELECT BarCode FROM (SELECT BarCode FROM dev_water_scan_log
where ErrorCode <> 90 and DevNo <> 0 and BarCode in (select `Code` from wcode_info) GROUP BY BarCode,DevNo)AS temp GROUP BY BarCode HAVING COUNT(BarCode)>1)";

        //---------------------
        $reBarCodes=ActiveRecord::findBySql("select DevNo,BarCode,RowTime
from dev_water_scan_log
where BarCode in $str and DevNo<>0
group by BarCode,DevNo
")->asArray()->all();
//var_dump(666);exit;

        //----------------


        if(!empty($reBarCodes)){
            $transaction=\Yii::$app->db->beginTransaction();
            try{
                //-------
                //查询所有预警过的数据（判断是否该预警已经存在）
                $datas=ActiveRecord::findBySql("select DevNo,BarCode,RowTime from dev_warning
                    where Type='重复条码'")->asArray()->all();

                //-------
                foreach($reBarCodes as $reBarCode){

                    //判断是否该预警已经存在
//                    $data=ActiveRecord::findBySql("select DevNo from dev_warning
//                    where DevNo={$reBarCode['DevNo']}
//                    and Type='重复条码'
//                    and (State=0 or State=1 or State=2)
//                    and BarCode='{$reBarCode['BarCode']}'
//                    and RowTime='{$reBarCode['RowTime']}'")->asArray()->all();

                    if(!in_array($reBarCode,$datas)){
//                    if(!$data) {
                        $dev_warning = new DevWarning();
                        $dev_warning->DevNo = $reBarCode['DevNo'];
                        $dev_warning->BarCode = $reBarCode['BarCode'];
                        $dev_warning->Type = "重复条码";
                        $dev_warning->Level = 2;//级别2：中
                        $dev_warning->State = 0;
                        $dev_warning->UpTime = time();
                        $dev_warning->RowTime = $reBarCode['RowTime'];
                        $re=$dev_warning->save(false);
                        if(!$re){
                            throw new Exception('失败');
                        }
                    }

                }


                $transaction->commit();
//                return $this->redirect(['dev-warning/index']);
            }catch (Exception $e){
                $transaction->rollBack();
                var_dump('失败');
            }



            //设置redis缓存和有效时间
//            $no=1;
//            $dateStr = date('Y-m-d', time());
//            $timestamp24 = strtotime($dateStr) + 86400;
//            $redis->set('no', $no,$timestamp24-time());//设置今天有效
//
//        }
        }


        //不正常烧水预警
        $last_day=date('Y-m-d',strtotime('-1 day'));

        //上午7点后，每小时只查询前一小时的
//        $time_7=strtotime(date('Y-m-d'.'07:00:00',time()));
//        if(time()>$time_7){
//            $last_day=date('Y-m-d H:i:s',strtotime('-2 hour'));
//        }
        $today=date('Y-m-d H:i:s',time());

        //获今天到现在烧水次数大于等于10次的设备及烧水次数
        $sql="select DevNo,count(DevNo) as num from (SELECT * from (select DevNo,ActType,ActTime from dev_action_log where ActType=4 and ActTime > '$last_day'
and ActTime < '$today' order by ActTime ASC ) as temp where DevNo in
(select DevNo from (SELECT * from (select DevNo,ActType,ActTime from dev_action_log where ActType=4 and ActTime > '$last_day' and DevNo<>0
and ActTime < '$today' order by ActTime ASC ) as temp group by DevNO,ActTime)as temp GROUP BY DevNo HAVING count(DevNo)>=10)
  group by DevNO,ActTime)as temp GROUP BY DevNo";

        //获取今天到现在烧水次数大于等于10次的设备及烧水时间
        $sql2="SELECT * from (select DevNo,ActType,ActTime from dev_action_log where ActType=4 and ActTime > '$last_day'
and ActTime < '$today' order by ActTime ASC ) as temp where DevNo in
(select DevNo from (SELECT * from (select DevNo,ActType,ActTime from dev_action_log where ActType=4 and ActTime > '$last_day' and DevNo<>0
and ActTime < '$today' order by ActTime ASC ) as temp group by DevNO,ActTime)as temp GROUP BY DevNo HAVING count(DevNo)>=10)
  group by DevNO,ActTime";

        //获取今天到现在烧水次数大于等于10次并且有抽水的设备及抽水时间
        $sql3="SELECT * from (select DevNo,ActType,ActTime from dev_action_log where ActType=16 and ActTime > '$last_day'
and ActTime < '$today' order by ActTime ASC ) as temp where DevNo in
(select DevNo from (SELECT * from (select DevNo,ActType,ActTime from dev_action_log where ActType=4 and ActTime > '$last_day' and DevNo<>0
and ActTime < '$today' order by ActTime ASC ) as temp group by DevNO,ActTime)as temp GROUP BY DevNo HAVING count(DevNo)>=10)
  group by DevNO,ActTime";

        $datas=ActiveRecord::findBySql($sql)->asArray()->all();//烧水设备对应次数
        $hot=ActiveRecord::findBySql($sql2)->asArray()->all();//烧水
        $pump=ActiveRecord::findBySql($sql3)->asArray()->all();//抽水
//        var_dump($pump);exit;
        $no_pump=[];
        foreach($datas as $data){
//            var_dump($data['DevNo'],$data['num']);exit;
            $hot_one=[];//对应一台设备的烧水记录
            foreach($hot as $v){
                if($v['DevNo']==$data['DevNo']){
                    array_push($hot_one,$v);
                }
            }

//var_dump($hot_one);exit;
            $num=floor($data['num']/10);

            for($i=0;$i<=$num-1;$i++){
                //第一次烧水10次的开始时间
                $starttime=$hot_one[$i*10]['ActTime'];
                //第一次烧水10次的结束时间
                $endtime=$hot_one[($i+1)*10-1]['ActTime'];
                //计算时间差
                $re=strtotime($endtime)-strtotime($starttime);
                if($re>3600){//大于1小时

                    //判断在这个时间段内是否有抽水
                    $pump_one=[];
                    foreach($pump as $v){
                        if($v['DevNo']==$hot_one[$i]['DevNo']&&$v['ActTime']>$starttime&&$v['ActTime']<$endtime){//有抽水
//                        var_dump($v['DevNo'],$v['ActTime']);exit;
                            array_push($pump_one,$v);
                        }
                    }
//                var_dump($pump_one);exit;

                    if(empty($pump_one)){//期间没有抽水
                        $re=['DevNo'=>$hot_one[$i]['DevNo'],'starttime'=>$starttime,'endtime'=>$endtime];
                        array_push($no_pump,$re);
                    }
                }

            }

        }

        if(!empty($no_pump)){

            //判断该预警是否存在
            $datas=ActiveRecord::findBySql("select DevNo,StartTime as starttime,EndTime as endtime from dev_warning
where Type='不正常烧水' ")->asArray()->all();

            //保存到预警表
            foreach($no_pump as $v){
                //判断该预警是否存在
//                $data=ActiveRecord::findBySql("select DevNo from dev_warning
//where DevNo='{$v['DevNo']}' and Type='不正常烧水'
// and RowTime='{$v['starttime']}'")->asArray()->all();
                if(!in_array($v,$datas)){
                    //保存
                    $dev_warning=new DevWarning();
                    $dev_warning->DevNo=$v['DevNo'];
                    $dev_warning->Type='不正常烧水';
                    $dev_warning->Level=2;
                    $dev_warning->State=0;
                    $dev_warning->UpTime=time();
                    $dev_warning->RowTime='';
                    $dev_warning->StartTime=$v['starttime'];
                    $dev_warning->EndTime=$v['endtime'];
                    $dev_warning->warning_detail="{$v['starttime']}到{$v['endtime']}期间烧水10次没有抽水";


                    $dev_warning->save(false);

                }

            }

        }

        return $this->redirect(['timed-task/task-hour-onece']);
    }





    //不同角色登陆显示对应设备的预警
    function LoginRole(){
        //登陆者角色id
        $login_id=\Yii::$app->getUser()->getId();
        $login_name=ActiveRecord::findBySql("select username from admin_user where Id=$login_id")->asArray()->one()['username'];
        $role_id=(new AdminRoleUser())->findOne(['uid'=>$login_id])->role_id;

        //各角色用户能看到对应的设备预警列表
        $str='';
        //设备厂家
        if($role_id==4){
            $dev_factory_id=ActiveRecord::findBySql("select Id from dev_factory where LoginName='$login_name'")->asArray()->one()['Id'];
            $str="(select DevNo from dev_regist
            where IsActive=1
            and DevNo in (select DevNo from dev_regist
                where goods_id  in
                    (select goods_id
                    from investor
                    INNER JOIN goods on investor.goods_id=goods.id
                    where investor.factory_id=$dev_factory_id)
                and brand_id  in
                    (select goods.brand_id
                    from investor
                    INNER JOIN goods on investor.goods_id=goods.id
                    where investor.factory_id=$dev_factory_id)
            and DevNo not in (select DevNo from dev_cmd
                where CmdType=4 and State=1 GROUP BY DevNo))";
        }
        //运营中心
        if($role_id==3){
            //获取运营中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=4 and LoginName='$login_name'")->asArray()->one()['Id'];

            //该运营中心下面的所有设备编号
            $str="(select DevNo
            from dev_regist
            where IsActive=1
            and (AgentId=".$agent_id."
                or AgentId in (select Id from agent_info
                where ParentId=".$agent_id."))
            and DevNo not in (select DevNo from dev_cmd
                where CmdType=4 and State=1 GROUP BY DevNo))";

        }
        //服务中心
        if($role_id==5){
            //获取服务中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=5 and LoginName='$login_name'")->asArray()->one()['Id'];

            //该服务中心下面的所有用户
            $str="(select DevNo
            from dev_regist
            where IsActive=1 and DevNo<>0
            and AgentId=".$agent_id.")";
        }
        return $str;
    }


    //未处理的
    public function actionIndex(){
        $where_str=' dev_warning.State=0 ';
        $datas=$this->GetDatas($where_str);
//        var_dump($datas);exit;
        return $this->render('index',$datas);

    }
    //已处理的
    public function actionAlreadyHandle(){
        $where_str=' dev_warning.State=1 ';
        $datas=$this->GetDatas($where_str);
        return $this->render('already_handle',$datas);
    }
    //已解决的
    public function actionAlreadySolve(){
        $where_str=' dev_warning.State=2 ';
        $datas=$this->GetDatas($where_str);
        return $this->render('already_solve',$datas);
    }

    public function GetDatas($where_str){
        $urlobj = $this->getParam("Url");//返回参数记录
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }
        //预警时间
        $sort1=$this->getParam("sort");//点击排序
//        var_dump($sort);exit;
        if($sort1==''){
            $sort1=0;
        }




        //搜索内容
        $province=trim($this->getParam("province"));
        $city=trim($this->getParam("city"));
        $area=trim($this->getParam("area"));
        $selecttime=trim($this->getParam("selecttime"));
        $content=addslashes(trim($this->getParam("content")));

//        var_dump($province,$city,$area);exit;
        $where='';
        if(!empty($province)){
            $where=" dev_regist.Province='$province' ";
        }
//        var_dump($where);exit;
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.City='$city' ";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.Area='$area' ";
        }
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=strtotime($dateArr[0]);
//                $endTime=$dateArr[1];
//                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
                $endTime=strtotime($dateArr[1])+24*3600-1;
//                var_dump($startTime,$endTime);exit;
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_warning.UpTime >= '$startTime' and dev_warning.UpTime <= '$endTime'";
        }

        if(!empty($content)){
            if(!empty($where)){
                $where.=' and ';
            }
            if($content=='高'){
                $content=3;
                $where.="dev_warning.Level= $content";
            }elseif($content=='中'){
                $content=2;
                $where.="dev_warning.Level= $content";
            }elseif($content=='低'){
                $content=1;
                $where.="dev_warning.Level= $content";
            }else{
                $where.="(dev_warning.DevNo like '%$content%'
             or dev_warning.Type like '%$content%'
              or dev_warning.Level like '%$content%'
               or user_info.Name like '%$content%'
                or user_info.Tel like '%$content%'
                 or t1.Name like '%$content%'
                   or t2.Name like '%$content%'
                    or dev_factory.Type like '%$content%'
                     or dev_regist.DevFactory like '%$content%')";
            }

        }

        //搜索的时候，三种状态都搜出来
        if($where){
            $where_str=" (dev_warning.State=0 or dev_warning.State=1 or dev_warning.State=2) ";
        }

//var_dump($where);exit;


//        $date=date('Y-m-d',strtotime('-15 day'));//倒退15天的日期

        $str=$this->LoginRole();


//获取非重复条码的数据LEFT JOIN dev_factory ON dev_regist.DevFactory=dev_factory.Name
        $datas_page=ActiveRecord::findBySql("select DISTINCT dev_warning.*,dev_regist.Province,
dev_regist.City,dev_regist.Area,dev_factory.Name as DevFactory,user_info.Name,user_info.Tel,
goods.name as DevType,dev_location.Address,t1.Name as AgentName,
t2.Name as ParentName,brands.BrandName
from dev_warning
LEFT JOIN dev_regist ON dev_warning.DevNo=dev_regist.DevNo
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id

LEFT JOIN dev_location ON dev_warning.DevNo=dev_location.DevNo
LEFT JOIN agent_info as t1 ON dev_regist.AgentId=t1.Id
LEFT JOIN agent_info as t2 ON t1.ParentId=t2.Id
LEFT JOIN brands ON brands.BrandNo=dev_regist.brand_id

left join investor on dev_regist.investor_id=investor.`agent_id`
 and dev_regist.goods_id=investor.goods_id

  left join goods on goods.id=dev_regist.goods_id

left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id


where $where_str ".(empty($str)?"":" and dev_warning.DevNO in $str")." and dev_warning.BarCode IS NULL
".(empty($where)?"":" and $where")." ORDER BY Level DESC, UpTime ASC ");
//        var_dump($datas_page);exit;



        //获取重复条码的数据
        $recode_page=ActiveRecord::findBySql("select * from(select dev_warning.*,dev_regist.Province,
dev_regist.City,dev_regist.Area,dev_factory.Name as DevFactory,user_info.Name,user_info.Tel,
goods.name as DevType,dev_location.Address,t1.Name as AgentName,
t2.Name as ParentName,brands.BrandName
from dev_warning
LEFT JOIN dev_regist ON dev_warning.DevNo=dev_regist.DevNo
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id

LEFT JOIN dev_location ON dev_warning.DevNo=dev_location.DevNo
LEFT JOIN agent_info as t1 ON dev_regist.AgentId=t1.Id
LEFT JOIN agent_info as t2 ON t1.ParentId=t2.Id
LEFT JOIN brands ON brands.BrandNo=dev_regist.brand_id

left join investor on dev_regist.investor_id=investor.`agent_id`
 and dev_regist.goods_id=investor.goods_id

 left join goods on goods.id=dev_regist.goods_id

left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id

where $where_str ".(empty($str)?"":" and dev_warning.DevNO in $str")." and dev_warning.BarCode IS NOT NULL
".(empty($where)?"":" and $where")." ORDER BY RowTime desc)as t group by BarCode"
        );
        //分页
        $pages=new Pagination(['totalCount' => ($datas_page->count()+$recode_page->count()), 'pageSize' => $page_size]);


        if(ceil(($datas_page->count()+$recode_page->count())/$page_size)<$page){//输入的页数大于总页数
            $page=ceil(($datas_page->count()+$recode_page->count())/$page_size);
        }

        $datas=ActiveRecord::findBySql($datas_page->sql)->asArray()->all();

        $recode=ActiveRecord::findBySql($recode_page->sql)->asArray()->all();

        foreach($recode as $v){
            array_push($datas,$v);
        }
        //搜索，按未处理、已处理、已解决排序
        if($where&&$datas&&count($datas)>1){
            $datas=$this->Order2($datas);
        }elseif($sort1&&$datas&&count($datas)>1){//按预警时间排序(奇数为升序，偶数为降序)
            $datas=$this->Order($sort1,$datas);
        }



        $datas_perpage=[];//每一页的数据
        for($i=$pages->offset;$i<$pages->offset+$pages->limit;$i++){
            if($datas[$i]){

                //上级
                $parent=$this->GetParentByDevNo($datas[$i]['DevNo']);
                $datas[$i]['AgentName']=$parent['agentFname'];
//                    $v['agentPname']=$parent['agentPname'];
                $datas[$i]['ParentName']=$parent['agentYname'];

                $datas_perpage[]=$datas[$i];
            }


        }
//        var_dump($datas_perpage);exit;




        $areas=Address::allQuery()->asArray()->all();

        if($content==3){
            $content='高';
        }
        if($content==2){
            $content='中';
        }
        if($content==1){
            $content='低';
        }

        return
            ['model'=>$datas_perpage,
                'areas' =>$areas,
                'province'=>empty($province)?"":$province,
                'city'=>empty($city)?"":$city,
                'area'=>empty($area)?"":$area,
                'selecttime'=>$selecttime,
                'content'=>$content,
                'pages'=>$pages,
                'page_size' => $page_size,
                'page' => $page,
                'sort' => $sort1,
                'url'=>$urlobj,
            ];
    }

    //按预警时间排序(奇数为降序，偶数为升序)
    public function Order($sort1,$datas){

        if($sort1 && $sort1%2==1){//降序
            if($datas&&count($datas)>1){
                //排序（预警时间升序）
                $sort = array(
                    'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field'     => 'UpTime',       //排序字段
                );
                $arrSort = array();
                foreach($datas AS $uniqid => $row){
                    foreach($row AS $key=>$value){
                        $arrSort[$key][$uniqid] = $value;
                    }
                }
                if($sort['direction']){
                    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $datas);
                }
            }
        }
        if($sort1 && $sort1%2==0){//升序
            if($datas&&count($datas)>1){
                //排序（预警时间降序）
                $sort = array(
                    'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field'     => 'UpTime',       //排序字段
                );
                $arrSort = array();
                foreach($datas AS $uniqid => $row){
                    foreach($row AS $key=>$value){
                        $arrSort[$key][$uniqid] = $value;
                    }
                }
                if($sort['direction']){
                    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $datas);
                }
            }
        }

        return $datas;

    }

    //搜索时按照未处理、已处理、已解决排序
    //按预警时间排序(奇数为降序，偶数为升序)
    public function Order2($datas){

            if($datas&&count($datas)>1){
                //排序（预警时间升序）
                $sort = array(
                    'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field'     => 'State',       //排序字段
                );
                $arrSort = array();
                foreach($datas AS $uniqid => $row){
                    foreach($row AS $key=>$value){
                        $arrSort[$key][$uniqid] = $value;
                    }
                }
                if($sort['direction']){
                    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $datas);
                }
            }


        return $datas;

    }


    //未处理的详情
    public function actionDetail(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $id=$this->getParam('Id');
        $DevNo=$this->getParam('DevNo');
        $Type=$this->getParam('Type');

        if($id==''||$DevNo==''||$Type==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

        $data=ActiveRecord::findBySql("select DevNo,`Type`,`Level`,BarCode,RowTime
from dev_warning
WHERE Id=$id and DevNo='$DevNo'
")->asArray()->one();


            $dev_regist=ActiveRecord::findBySql("select investor_id,UserId,goods_id,brand_id,AgentId from dev_regist where DevNo='$DevNo'")->asArray()->one();

        //获取设备厂家
        //投资商id
        if($dev_regist){
            $investor_id=$dev_regist['investor_id'];
            //设备厂家id
            $factory_id=ActiveRecord::findBySql("select factory_id from investor where agent_id=$investor_id and goods_id={$dev_regist['goods_id']}")->asArray()->one();
            $DevFactory=ActiveRecord::findBySql("select `Name` from dev_factory where Id={$factory_id['factory_id']}")->asArray()->one();
            if($DevFactory){
                $data['DevFactory']=$DevFactory['Name'];
            }else{
                $data['DevFactory']='';
            }

            $user_info=ActiveRecord::findBySql("select `Name`,Tel from user_info where Id='{$dev_regist['UserId']}'")->asArray()->one();
            if($user_info){
                $data['Name']=$user_info['Name'];
                $data['Tel']=$user_info['Tel'];
            }else{
                $data['Name']='';
                $data['Tel']='';
            }

            $dev_type=ActiveRecord::findBySql("select `name` from goods where id={$dev_regist['goods_id']}")->asArray()->one();
            if($dev_type){
                $data['DevType']=$dev_type['name'];
            }else{
                $data['DevType']='';
            }



        }




        //根据预警类型获取最近状态
        $act=[
         1=>"开关机",
         2=>"调温",
         4=>"加热",
         8=>"消毒",
         16=>"抽水",
        ];

        $LastStatus='';
        $detail='';
        if($Type=='无数据上传'){
            //获取上次上传数据了信息
            $last=ActiveRecord::findBySql("select LastConnectDate,LastConnectTime from dev_status where DevNo='$DevNo' limit 1")->asArray()->all();
//            var_dump($last);exit;
            if(!empty($last)){
                $LastTime=$last[0]['LastConnectDate'].' '.$last[0]['LastConnectTime'];
                $LastStatus=$LastTime.' 链接设备';
                $detail="从".$data['RowTime']."，之后再无数据上传，可能情况：1.设备损坏，2.未插电，3.设备信号无连接";
            }

        }elseif($Type=='长期未操作'){
            //获取上次操作的数据信息
            $last=ActiveRecord::findBySql("select ActTime,ActType from dev_action_log where DevNo='$DevNo' ORDER BY ActTime DESC limit 1")->asArray()->all();
            if(!empty($last)){
                $LastActTime=$last[0]['ActTime'];
                $LastActType=$last[0]['ActType'];
                $LastStatus=$LastActTime.' '.$act[$LastActType];
                $detail="从".$data['RowTime']."，".$act[$LastActType]."之后再无操作，设备连接正常，功能正常。";
            }

        }elseif($Type=='长期未抽水'){
            //获取上次抽水的数据信息
            $last=ActiveRecord::findBySql("select ActTime,ActType from dev_action_log where DevNo='$DevNo' and ActType=16 ORDER BY ActTime DESC limit 1")->asArray()->all();
            if(!empty($last)){
                $LastActTime=$last[0]['ActTime'];
                $LastActType=$last[0]['ActType'];
                $LastStatus=$LastActTime.' '.$act[$LastActType];
                $detail="从".$data['RowTime']."，用户抽水之后再无抽水，设备连接正常，功能正常。";
            }

        }elseif($Type=='重复条码'){
            //获取上次操作的数据信息
            $BarCode=ActiveRecord::findBySql("select BarCode from dev_warning where Id=$id and DevNo='$DevNo' and Type='重复条码' limit 1")->asArray()->one();
            if(!empty($BarCode)){
//                $LastStatus=$BarCode[0]['BarCode'];
                $detail="重复条码为：<a href='./index.php?r=dev-warning/recode&BarCode={$BarCode['BarCode']}&Id=$id&DevNo=$DevNo&Type=$Type&State=0'>{$BarCode['BarCode']}</a>";
            }

        }elseif($Type=='不正常烧水'){
            //获取上次抽水的数据信息
            $re=ActiveRecord::findBySql("select StartTime,warning_detail from dev_warning where DevNo='$DevNo' and Id=$id and Type='不正常烧水' limit 1 ")->asArray()->one();
            $starttime=$re['StartTime'];
            $detail=$re['warning_detail'];
            $last=ActiveRecord::findBySql("select ActTime,ActType from dev_action_log where DevNo='$DevNo' and ActType=16 and ActTime<'$starttime' order by ActTime desc limit 1")->asArray()->one();
            if(!empty($last)){
                $LastActTime=$last['ActTime'];
                $LastActType=$last['ActType'];
                $LastStatus=$LastActTime.' '.$act[$LastActType];
//                $detail="从".$LastActTime."，用户抽水之后再无抽水，设备连接正常，功能正常。";
            }

        }else{
            //位置变更
            //获取上次位置信息
            $address=ActiveRecord::findBySql("select Address,RowTime from dev_location where DevNo=$DevNo limit 1")->asArray()->all();
            if($address){

//                //获取原来注册时的地址
//                $address_original=ActiveRecord::findBySql("select Address from dev_regist where DevNo=$DevNo limit 1")->asArray()->one();
//                $detail=$address[0]['RowTime']."从注册位置 ".$address_original['Address'].'变更到'.$address[0]['Address'].'，'.$Type.'，设备连接正常，功能正常。';
                $detail='上次上传位置：'.$address[0]['Address'];

            }
//            $LastStatus="注册位置: ";

        }
//var_dump($LastStatus);exit;

        $data['LastStatus']=$LastStatus;
        $data['Detail']=$detail;

        return $this->render('detail',['model'=>$data,'url'=>$urlobj]);

//var_dump($datas);


    }

    //已处理详情
    public function actionHandleDetail(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $id=$this->getParam('Id');
        $DevNo=$this->getParam('DevNo');
        $Type=$this->getParam('Type');

        if($id==''||$DevNo==''||$Type==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
//        var_dump($dev_regist);exit;
        $data=ActiveRecord::findBySql("select dev_warning.*,
dev_regist.DevFactory
from dev_warning
LEFT JOIN dev_regist ON dev_warning.DevNo=dev_regist.DevNo
WHERE dev_warning.Id=$id and dev_warning.DevNo=$DevNo
")->asArray()->one();
        $dev_regist=ActiveRecord::findBySql("select * from dev_regist where DevNo=$DevNo")->asArray()->all();

        $user_info=ActiveRecord::findBySql("select * from user_info where Id='{$dev_regist[0]['UserId']}'")->asArray()->all();
        if($user_info){
            $data['Name']=$user_info[0]['Name'];
            $data['Tel']=$user_info[0]['Tel'];
        }else{
            $data['Name']='';
            $data['Tel']='';
        }

        $dev_type=ActiveRecord::findBySql("select * from dev_factory where Name='{$dev_regist[0]['DevFactory']}'")->asArray()->all();
        if($dev_type){
            $data['DevType']=$dev_type[0]['Type'];
        }else{
            $data['DevType']='';
        }

        //根据预警类型获取最近状态
        $act=[
            1=>"开关机",
            2=>"调温",
            4=>"加热",
            8=>"消毒",
            16=>"抽水",
        ];

        $LastStatus='';
        $detail='';
        if($Type=='无数据上传'){
            //获取上次上传数据了信息
            $last=ActiveRecord::findBySql("select LastConnectDate,LastConnectTime from dev_status where DevNo=$DevNo limit 1")->asArray()->one();
//            var_dump($last);exit;
            if(!empty($last)){
                $LastTime=$last['LastConnectDate'].' '.$last['LastConnectTime'];
                $LastStatus=$LastTime.' 链接设备';
                $detail="从".$data['RowTime']."，之后再无数据上传，可能情况：1.设备损坏，2.未插电，3.设备信号无连接";
            }

        }elseif($Type=='长期未操作'){
            //获取上次操作的数据信息
            $last=ActiveRecord::findBySql("select ActTime,ActType from dev_action_log where DevNo=$DevNo ORDER BY ActTime DESC limit 1")->asArray()->one();
            if(!empty($last)){
                $LastActTime=$last['ActTime'];
                $LastActType=$last['ActType'];
                $LastStatus=$LastActTime.' '.$act[$LastActType];
                $detail="从".$data['RowTime']."之后再无操作，设备连接正常，功能正常。";
            }

        }elseif($Type=='长期未抽水'){
            //获取上次抽水的数据信息
            $last=ActiveRecord::findBySql("select ActTime,ActType from dev_action_log where DevNo=$DevNo and ActType=16 ORDER BY ActTime DESC limit 1")->asArray()->one();
            if(!empty($last)){
                $LastActTime=$last['ActTime'];
                $LastActType=$last['ActType'];
                $LastStatus=$LastActTime.' '.$act[$LastActType];
                $detail="从".$data['RowTime']."，用户抽水之后再无抽水，设备连接正常，功能正常。";
            }

        }elseif($Type=='重复条码'){
            //获取上次操作的数据信息
            $BarCode=ActiveRecord::findBySql("select BarCode from dev_warning where DevNo=$DevNo and Type='重复条码' and Id=$id limit 1")->asArray()->one();
            if(!empty($BarCode)){
//                $LastStatus=$BarCode[0]['BarCode'];
                $detail="重复条码为：<a href='./index.php?r=dev-warning/recode&BarCode=".$BarCode['BarCode']."&Id=".$id."&DevNo=".$DevNo."&Type=".$Type."&State=1'>".$BarCode['BarCode']."</a>";
            }

        }else{
            //位置变更
            //获取上次位置信息
            $address=ActiveRecord::findBySql("select Address from dev_location where DevNo=$DevNo limit 1")->asArray()->one();
            if($address){

                $detail="上次上传位置：".$address['Address'];
            }

        }

        $data['LastStatus']=$LastStatus;
        $data['Detail']=$detail;
//        var_dump($data['Handle_Description']);exit;

        return $this->render('handle_detail',['model'=>$data,'url'=>$urlobj]);

    }

    //已解决详情

    public function actionSolveDetail(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $id=$this->getParam('Id');
        $DevNo=$this->getParam('DevNo');
        $Type=$this->getParam('Type');

        if($id==''||$DevNo==''||$Type==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
//        var_dump($dev_regist);exit;
        $datas=ActiveRecord::findBySql("select dev_warning.*,
dev_regist.DevFactory
from dev_warning
LEFT JOIN dev_regist ON dev_warning.DevNo=dev_regist.DevNo
WHERE dev_warning.Id=$id and dev_warning.DevNo=$DevNo
")->asArray()->all();
        $data=$datas[0];
        $dev_regist=ActiveRecord::findBySql("select * from dev_regist where DevNo=$DevNo")->asArray()->all();

        $user_info=ActiveRecord::findBySql("select * from user_info where Id='{$dev_regist[0]['UserId']}'")->asArray()->all();
        if($user_info){
            $data['Name']=$user_info[0]['Name'];
            $data['Tel']=$user_info[0]['Tel'];
        }else{
            $data['Name']='';
            $data['Tel']='';
        }

        $dev_type=ActiveRecord::findBySql("select * from dev_factory where Name='{$dev_regist[0]['DevFactory']}'")->asArray()->all();
        if($dev_type){
            $data['DevType']=$dev_type[0]['Type'];
        }else{
            $data['DevType']='';
        }

        //根据预警类型获取最近状态
        $act=[
            1=>"开关机",
            2=>"调温",
            4=>"加热",
            8=>"消毒",
            16=>"抽水",
        ];

        $LastStatus='';
        $detail='';
        if($Type=='无数据上传'){
            //获取上次上传数据了信息
            $last=ActiveRecord::findBySql("select LastConnectDate,LastConnectTime from dev_status where DevNo=$DevNo limit 1")->asArray()->all();
//            var_dump($last);exit;
            if(!empty($last)){
                $LastTime=$last[0]['LastConnectDate'].' '.$last[0]['LastConnectTime'];
                $LastStatus=$LastTime.' 链接设备';
                $detail="从".$LastTime."，之后再无数据上传，可能情况：1.设备损坏，2.未插电，3.设备信号无连接";
            }

        }elseif($Type=='长期未操作'){
            //获取上次操作的数据信息
            $last=ActiveRecord::findBySql("select ActTime,ActType from dev_action_log where DevNo=$DevNo ORDER BY ActTime DESC limit 1")->asArray()->all();
            if(!empty($last)){
                $LastActTime=$last[0]['ActTime'];
                $LastActType=$last[0]['ActType'];
                $LastStatus=$LastActTime.' '.$act[$LastActType];
                $detail="从".$LastActTime."，".$act[$LastActType]."之后再无操作，设备连接正常，功能正常。";
            }

        }elseif($Type=='长期未抽水'){
            //获取上次抽水的数据信息
            $last=ActiveRecord::findBySql("select ActTime,ActType from dev_action_log where DevNo=$DevNo and ActType=16 ORDER BY ActTime DESC limit 1")->asArray()->all();
            if(!empty($last)){
                $LastActTime=$last[0]['ActTime'];
                $LastActType=$last[0]['ActType'];
                $LastStatus=$LastActTime.' '.$act[$LastActType];
                $detail="从".$LastActTime."，用户抽水之后再无抽水，设备连接正常，功能正常。";
            }

        }elseif($Type=='重复条码'){
            //获取上次操作的数据信息
            $BarCode=ActiveRecord::findBySql("select BarCode from dev_warning where DevNo=$DevNo and Type='重复条码' and Id=$id limit 1")->asArray()->all();
            if(!empty($BarCode)){
//                $LastStatus=$BarCode[0]['BarCode'];
                $detail="重复条码为：<a href='./index.php?r=dev-warning/recode&BarCode=".$BarCode[0]['BarCode']."&Id=".$id."&DevNo=".$DevNo."&Type=".$Type."&State=2'>".$BarCode[0]['BarCode']."</a>";
            }

        }else{
            //位置变更
            //获取上次位置信息
            $address=ActiveRecord::findBySql("select Address from dev_location where DevNo=$DevNo limit 1")->asArray()->all();
            if($address){

                $detail="上次上传位置：".$address[0]['Address'];
            }

        }

        $data['LastStatus']=$LastStatus;
        $data['Detail']=$detail;
//        var_dump($data['Handle_Description']);exit;

        return $this->render('solve_detail',['model'=>$data,'url'=>$urlobj]);

    }

    //获取该重复条码的所有设备
    public  function actionRecode(){

        $page_size = $this->getParam("per-page");//每页显示条数

        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

        $BarCode=$this->getParam('BarCode');
        $State=$this->getParam('State');
//        var_dump($BarCode);exit;
        if($BarCode==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

        //返回时参数
        $id=$this->getParam('Id');
        $DevNo=$this->getParam('DevNo');
        $Type=$this->getParam('Type');
//var_dump($id,$DevNo,$Type);exit;

        //搜索内容
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $selecttime=$this->getParam("selecttime");
        $content=$this->getParam("content");

//        var_dump($province,$city,$area);exit;
        $where='';
        if(!empty($province)){
            $where=" dev_regist.Province='$province' ";
        }
//        var_dump($where);exit;
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.City='$city' ";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.Area='$area' ";
        }
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
//                $endTime=strtotime($dateArr[1])+24*3600-1;
//                var_dump($startTime,$endTime);exit;
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_warning.RowTime >= '$startTime' and dev_warning.RowTime <= '$endTime'";
        }

        if(!empty($content)){
            if(!empty($where)){
                $where.=' and ';
            }
//            $where.="(dev_warning.DevNo like '%$content%' or dev_warning.BarCode like '%$content%')";
            if($content=='高'){
                $content=3;
                $where.="dev_warning.Level= $content";
            }elseif($content=='中'){
                $content=2;
                $where.="dev_warning.Level= $content";
            }elseif($content=='低'){
                $content=1;
                $where.="dev_warning.Level= $content";
            }else {
                $where .= "(dev_warning.DevNo like '%$content%'
             or dev_warning.Type like '%$content%'
              or dev_warning.Level like '%$content%'
               or user_info.Name like '%$content%'
                or user_info.Tel like '%$content%'
                 or t1.Name like '%$content%'
                   or t2.Name like '%$content%'
                    or dev_factory.Type like '%$content%'
                     or dev_regist.DevFactory like '%$content%')";
            }
        }







        $datas_page=ActiveRecord::findBySql("select dev_warning.*,dev_regist.Province,
dev_regist.City,dev_regist.Area,dev_factory.Name as DevFactory,user_info.Name,user_info.Tel,
dev_factory.Type as DevType,dev_location.Address,t1.Name as AgentName,t2.Name as ParentName
from dev_warning
LEFT JOIN dev_regist ON dev_warning.DevNo=dev_regist.DevNo
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id

LEFT JOIN dev_location ON dev_warning.DevNo=dev_location.DevNo
LEFT JOIN agent_info as t1 ON dev_regist.AgentId=t1.Id
LEFT JOIN agent_info as t2 ON t1.ParentId=t2.Id

left join investor on dev_regist.investor_id=investor.`agent_id`
 and dev_regist.goods_id=investor.goods_id

 left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id

where dev_warning.BarCode='$BarCode' and dev_warning.Type='重复条码'".(empty($where)?"":" and $where")." group by dev_warning.DevNo"
);//dev_warning.State=$State and 已经解决的都要显示出来
//        var_dump($datas_page->sql);exit;
        if(ceil($datas_page->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas_page->count()/$page_size);
        }


        $pages=new Pagination(['totalCount' => $datas_page->count(), 'pageSize' => $page_size]);

        $datas=ActiveRecord::findBySql($datas_page->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();

//        var_dump($datas_page->sql);exit;
        $areas=Address::allQuery()->asArray()->all();

        if($content==3){
            $content='高';
        }
        if($content==2){
            $content='中';
        }
        if($content==1){
            $content='低';
        }

        return $this->render('recode',[
                'model'=>$datas,
                'areas' =>$areas,
                'province'=>empty($province)?"":$province,
                'city'=>empty($city)?"":$city,
                'area'=>empty($area)?"":$area,
                'selecttime'=>$selecttime,
                'content'=>$content,
                'BarCode'=>$BarCode,
                'Id'=>$id,
                'DevNo'=>$DevNo,
                'Type'=>$Type,
                'State'=>$State,
            'pages'=>$pages,
            'page_size' => $page_size,
            'page' => $page,
        ]);

    }


    //处理预警（未处理的）
    public function actionHandle(){
        $State=$this->getParam('State');
        $content=$this->getParam('content');
        $Type=$this->getParam('Type');
        $DevNo=$this->getParam('DevNo');
        $BarCode=$this->getParam('BarCode');

        if($State==''||$DevNo==''||$Type==''||$content==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }

        //如果是重复条码
        if($Type=='重复条码'){

            $model=DevWarning::find()->where(['BarCode'=>$BarCode])->andWhere(['Type'=>$Type])->andWhere(['State'=>0])->all();
//           var_dump($model);exit;
            if(!$model){
                return $this->asJson(-1);
            }

            $transaction=\Yii::$app->db->beginTransaction();
            try{
                foreach($model as $v){


                        $v->Handle_Description=$content;
                        $v->State=$State;
                        if($State==1){
                            $v->Handle_Time=time();//处理时间
                        }
                        if($State==2){
                            $v->Solve_Time=time();//解决时间
                        }

                        $re=$v->save(false);
                        if(!$re){
                           throw new Exception('处理失败');
                        }
                }

                $transaction->commit();
                return $this->asJson(1);

            }catch (Exception $e){
                $transaction->rollBack();
                return $this->asJson(0);
            }


        }else{
            $model=DevWarning::find()->where(['DevNo'=>$DevNo])->andWhere(['Type'=>$Type])->andWhere(['State'=>0])->one();
            if(!$model){
                return $this->asJson(-1);
            }

//        var_dump($model);exit;
            $model->Handle_Description=$content;
            $model->State=$State;
            if($State==1){
                $model->Handle_Time=time();//处理时间
            }
            if($State==2){
                $model->Solve_Time=time();//解决时间
            }

            $re=$model->save(false);

            if($re){
                return $this->asJson(1);
            }else{
                return $this->asJson(0);
            }
        }


//        return $this->asJson($data);


    }

    //处理预警（解决）
    public function actionSolve(){
        $State=$this->getParam('State');
        $content=$this->getParam('content');
        $content2=$this->getParam('content2');
        $Type=$this->getParam('Type');
        $DevNo=$this->getParam('DevNo');
        $BarCode=$this->getParam('BarCode');
//        var_dump($State,$content,$content2,$Type,$DevNo,$BarCode);exit;
        if($State==''||$DevNo==''||$Type==''||$content==''||$content2==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
        //如果是重复条码
        if($Type=='重复条码'){
            $model=DevWarning::find()->where(['BarCode'=>$BarCode])->andWhere(['Type'=>$Type])->andWhere(['State'=>1])->all();
//           var_dump($model);exit;
            if(!$model){
                return $this->asJson(-1);
            }

            $transaction=\Yii::$app->db->beginTransaction();
            try{
                foreach($model as $v){

                    $v->Handle_Description = $content;
                    $v->Solve_Description=$content2;
                    $v->State=$State;
                    if($State==1){
                        $v->Handle_Time=time();//处理时间
                    }
                    if($State==2){
                        $v->Solve_Time=time();//解决时间
                    }

                    $re=$v->save(false);
                    if(!$re){
                        throw new Exception('处理失败');
                    }
                }

                $transaction->commit();
                return $this->asJson(1);

            }catch (Exception $e){
                $transaction->rollBack();
                return $this->asJson(0);
            }


        }else {


            $model = DevWarning::find()->where(['DevNo' => $DevNo])->andWhere(['Type' => $Type])->andWhere(['State' => 1])->one();

            if (!$model) {
                return $this->asJson(-1);

            }

//        var_dump($model);exit;
            $model->Handle_Description = $content;
            $model->Solve_Description = $content2;
            $model->State = $State;
            if ($State == 1) {
                $model->Handle_Time = time();//处理时间
            }
            if ($State == 2) {
                $model->Solve_Time = time();//解决时间
            }

            $re = $model->save(false);

            if ($re) {
                return $this->asJson(1);
            } else {
                return $this->asJson(0);
            }

        }

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


    //计算距离
    public function getDistance($lat1, $lng1, $lat2, $lng2)
    {

        $earthRadius = 6367000; //approximate radius of earth in meters

        /*
        Convert these degrees to radians
        to work with the formula
        */

        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;

        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;

        /*
        Using the
        Haversine formula

        http://en.wikipedia.org/wiki/Haversine_formula

        calculate the distance
        */

        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;

        return round($calculatedDistance/1000,2);//公里数，两位小数
    }



    public function actionDistanceTest(){
//        $address1='四川省成都市新都区城北优品道';
//        $address2='四川省成都市双流县华阳镇街道海昌北路;红星路南延线一段与005乡道路口北377米';
        $BaiDuLat=30.687353;
        $BaiDuLng=103.999306;

        //获取用户用户注册时填写地址的经纬度
//        $data1=$this->GetLatLng($address1);
//        if($data1){
            $lat=30.687417;
            $lng=103.998905;
//            var_dump($lat,$lng);exit;float(40.008534) float(116.469416)
            //计算两个地址的距离
            $distance=$this->getDistance($BaiDuLat,$BaiDuLng,$lat,$lng);
            var_dump($distance);
//            var_dump($lat,$lng);

//        }


    }





}
