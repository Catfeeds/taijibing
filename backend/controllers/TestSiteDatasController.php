<?php
namespace backend\controllers;
use yii\db\ActiveRecord;


class TestSiteDatasController extends BaseController{
    public function actionSaveDatas(){

        //1、运营中心销量排名（本月前五）
        //本月第一天0点
        $first_day=date('Y-m-01'.' 00:00:00', strtotime(date("Y-m-d")));
        //当前时间
        $now=date('Y-m-d H:i:s',time());

        $sql="select agent_info.Name,temp4.num from
agent_info
INNER JOIN

(SELECT ParentId,sum(num) as num from

(select agent_info.Id,agent_info.Name,temp2.num,agent_info.ParentId from agent_info
left join
(select AgentId,count(BarCode) as num from
(select BarCode,AgentId from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now')as temp
GROUP BY AgentId)as temp2
on agent_info.Id=temp2.AgentId
where agent_info.Level=5)as temp3

GROUP BY ParentId
ORDER BY num desc limit 5)as temp4
on agent_info.Id=temp4.ParentId
where agent_info.`Level`=4";
        $datas1=ActiveRecord::findBySql($sql)->asArray()->all();
        $total_sales1=ActiveRecord::findBySql("select BarCode from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now'")->count();

        //2、服务中心销量排名（本月前五）
        //本月第一天0点
        $first_day=date('Y-m-01'.' 00:00:00', strtotime(date("Y-m-d")));
        //当前时间
        $now=date('Y-m-d H:i:s',time());

        $sql="select agent_info.Name,temp2.num from agent_info
left join
(select AgentId,count(BarCode) as num from
(select BarCode,AgentId from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now')as temp
GROUP BY AgentId)as temp2
on agent_info.Id=temp2.AgentId
where agent_info.Level=5 ORDER BY num desc limit 5";
        $datas2=ActiveRecord::findBySql($sql)->asArray()->all();
        $total_sales2=ActiveRecord::findBySql("select BarCode from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now'")->count();


        //3、设备分布情况
        //设备分布省份
        $datas3=ActiveRecord::findBySql("select Province,City,Area from dev_regist
where  IsActive=1
and DevNo > 0 and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and AgentId > 0")->asArray()->all();
        //设备分布坐标(没有预警的设备)
        $str="select dev_location.BaiDuLat,dev_location.BaiDuLng,dev_regist.DevNo
from dev_location
inner join dev_regist on dev_location.DevNo=dev_regist. DevNo
where dev_regist.DevNo > 0
and dev_regist.IsActive=1
and not exists
(select DevNo from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0";

        $dev_location=ActiveRecord::findBySql("$str
and  not exists (select 1 from dev_warning where state=0 and DevNo=dev_regist.DevNo)
")->asArray()->all();

        //预警的设备
        $warning_devnos=ActiveRecord::findBySql("$str
and  exists (select 1 from dev_warning where state=0 and DevNo=dev_regist.DevNo)")->asArray()->all();

        //待激活设备数量
        $not_active=ActiveRecord::findBySql("select DevNo from dev_regist where
IsActive=0 and DevNo > 0
and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0")->count();
        //正常设备数量
        $dev_active=ActiveRecord::findBySql("select DevNo from dev_regist where
 IsActive=1 and DevNo > 0
 and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
and  not exists (select 1 from dev_warning where state=0 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0
")->count();
        //非重复条码预警数量
        $dev_warning1=ActiveRecord::findBySql("select dev_warning.DevNo from dev_warning
INNER JOIN dev_regist on dev_regist.DevNo=dev_warning.DevNo
where dev_regist.IsActive=1 and dev_regist.AgentId > 0
and dev_warning.State=0 and dev_warning.Type <> '重复条码'
")->count();
        //重复条码预警数量
        $dev_warning2=ActiveRecord::findBySql("select dev_warning.DevNo from dev_warning
INNER JOIN dev_regist on dev_regist.DevNo=dev_warning.DevNo
where dev_regist.IsActive=1 and dev_regist.AgentId > 0
and dev_warning.State=0 and dev_warning.Type = '重复条码'
 group by dev_warning.BarCode ")->count();
        $dev_warning=$dev_warning1+$dev_warning2;


        //4、实时数据
        //今日销量
        $today=date('Y-m-d'.' 00:00:00',time());//今日0点
        $last_30=date('Y-m-d'.' 00:00:00',strtotime('-29 day'));//近30天0点
        $now=date('Y-m-d H:i:s',time());//当前时间

        $today_sales=ActiveRecord::findBySql("select BarCode
from dev_water_scan
where dev_water_scan.RowTime >= '$today'  and dev_water_scan.DevNo > 0 ")->count();
        //近30天销量
        $total_sales=ActiveRecord::findBySql("select BarCode
from dev_water_scan
where dev_water_scan.RowTime >= '$last_30' and dev_water_scan.DevNo > 0 ")->count();

        //今日用水量
        $today_wateruse=$this->WaterUseVolume($today,$now);

        //近30天用水量
        $total_wateruse=$this->WaterUseVolume($last_30,$now);

        //5、用户类型和销量占比
        //饼状图（用户类型占比）
        $usertype=ActiveRecord::findBySql("select CustomerType,count(CustomerType) as num from
(select DevNo,CustomerType from dev_regist where
DevNo > 0 and IsActive=1 and AgentId > 0
and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))as temp
GROUP BY CustomerType")->asArray()->all();

        //各类型销量占比（本月）
        //本月第一天0点
        $first_day=date('Y-m-01'.' 00:00:00', strtotime(date("Y-m-d")));
        //当前时间
        $now=date('Y-m-d H:i:s',time());
        $datas4=ActiveRecord::findBySql("SELECT CustomerType,SUM(num) AS num FROM

        (SELECT dev_regist.CustomerType,temp2.num FROM dev_regist
INNER JOIN
        (SELECT DevNo,COUNT(DevNo) AS num FROM
        (SELECT DevNo FROM dev_water_scan WHERE DevNo > 0 AND RowTime > '$first_day' AND RowTime < '$now')AS temp
GROUP BY DevNo)AS temp2
ON dev_regist.DevNo=temp2.DevNo
)AS temp3
GROUP BY CustomerType")->asArray()->all();


        //6、折线图数据
        $date_15=date('Y-m-d',strtotime('-14 day'));
        //用户增长
        $user_increase=$this->UserIncrease($date_15);
        //销量
        $user_sales=$this->Sales($date_15);
        //用水量
        $use_status=$this->WaterUse($date_15);



        //写入文件保存
        $site_data=json_decode(trim(substr(file_get_contents('../web/datas/SiteDatas.php'), 15)));
        //1、运营中心销量排名（本月前五）
        $site_data->datas1=json_encode($datas1);
        $site_data->total_sales1=json_encode($total_sales1);
        //2、服务中心销量排名（本月前五）
        $site_data->datas2=json_encode($datas2);
        $site_data->total_sales2=json_encode($total_sales2);
        //3、设备分布情况
        $site_data->dev_location=json_encode($dev_location);
        $site_data->not_active=json_encode($not_active);
        $site_data->dev_active=json_encode($dev_active);
        $site_data->dev_warning=json_encode($dev_warning);
        $site_data->datas3=json_encode($datas3);
        //4、实时数据
        $site_data->today_sales=json_encode($today_sales);
        $site_data->total_sales=json_encode($total_sales);
        $site_data->today_wateruse=json_encode($today_wateruse);
        $site_data->total_wateruse=json_encode($total_wateruse);
        //5、用户类型和销量占比
        $site_data->usertype=json_encode($usertype);
        $site_data->datas4=json_encode($datas4);
        //6、折线图数据
        $site_data->user_increase=json_encode($user_increase);
        $site_data->user_sales=json_encode($user_sales);
        $site_data->use_status=json_encode($use_status);


        $fp = fopen('../web/datas/SiteDatas.php', "w");
        fwrite($fp, "<?php exit();?>" . json_encode($site_data));
        fclose($fp);
        var_dump('成功');

    }

    public function actionReade(){
        $site_data=json_decode(trim(substr(file_get_contents('../web/datas/SiteDatas.php'), 15)));
        var_dump(json_decode($site_data->datas1));
    }



    //计算用水量
    public function WaterUseVolume($time1,$time2){
        $datas=ActiveRecord::findBySql("select sum(total_volume)as all_volume,sum(WaterRest)as rest_volume from (
        select temp.total_volume,temp2.WaterRest
        from dev_regist


        left join (select DevNo,sum(volume)as total_volume from (
        (select DevNo,sum(Volume)as volume from (
        select dev_regist.DevNo,dev_water_scan_log.Volume
        from dev_regist
        left join (select DevNo,Volume from
        (select * from
        (select BarCode,DevNo,Volume,RowTime from dev_water_scan_log order by Rowtime asc)as a GROUP BY BarCode,DevNo)as b
        where RowTime > '$time1' and RowTime < '$time2'
        and DevNo>0 )as dev_water_scan_log
        on dev_water_scan_log.DevNo=Dev_regist.DevNo
        )as temp  group by DevNo)
        UNION
        (select * from (select dev_regist.DevNo,temp_table.WaterRest as volume
        from dev_regist
        left join (select DevNo,WaterRest from
        (select DevNo,WaterRest from dev_action_log where ActType=99
        and RowTime < '$time1' and DevNo>0
        order by RowTime desc ) as temp group by DevNo)as temp_table
        on dev_regist.DevNo=temp_table.DevNo)as a)
        )as b group by DevNo) as temp
        on dev_regist.DevNo=temp.DevNo

        left join (select dev_regist.DevNo,temp_table.WaterRest
        from dev_regist
        left join (select DevNo,WaterRest from
        (select DevNo,WaterRest from dev_action_log where ActType=99
        and RowTime < '$time2' and DevNo>0
        order by RowTime desc) as temp group by DevNo)as temp_table
        on dev_regist.DevNo=temp_table.DevNo)as temp2
        on dev_regist.DevNo=temp2.DevNo
        )as temp")->asArray()->one();
        //总用水量
        $total=round(($datas['all_volume']-$datas['rest_volume']),2);
        return $total;
    }


    //用户增长接口(近15天的增长情况)
    public function UserIncrease($date_15){

        $datas=ActiveRecord::findBySql("select CustomerType,`Date` from dev_regist
where
DevNo > 0 and IsActive=1
and  not exists (select DevNo from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
 and RowTime > '$date_15' and dev_regist.AgentId > 0")->asArray()->all();
        return $datas;
    }

    //销量（近15天的销量情况）
    public function Sales($date_15){
        $datas=ActiveRecord::findBySql("select dev_water_scan.Volume,dev_water_scan.`Date` from dev_water_scan
where dev_water_scan.DevNo > 0
and dev_water_scan.RowTime > '$date_15'")->asArray()->all();
        return $datas;
    }

    //用水量（近15天的用水量情况）
    public function WaterUse($date_15){
        $start=$date_15;
        $end=date('Y-m-d H:i:s',time());

        $sql="select DISTINCT temp.* from (
                    (select dev_action_log.DevNo,dev_action_log.WaterRest,dev_action_log.ActTime,dev_action_log.ActDate from dev_action_log
                    where dev_action_log.ActType=99 and dev_action_log.ActTime > '$start' and dev_action_log.ActTime < '$end')
                     UNION
                    (select * from (select dev_action_log.DevNo,dev_action_log.WaterRest,dev_action_log.ActTime,dev_action_log.ActDate from dev_action_log
                    where dev_action_log.ActType=99 and dev_action_log.ActTime < '$start' order by dev_action_log.ActTime desc )as temp group by DevNo)
                    )as temp
                    inner join dev_regist on dev_regist.DevNo=temp.DevNo
                    where dev_regist.DevNo > 0 and dev_regist.AgentId >0
                    order by temp.ActTime desc,temp.WaterRest asc";
        $datas=ActiveRecord::findBySql($sql)->asArray()->all();

        $DevNos=ActiveRecord::findBySql("select DevNo from dev_regist where dev_regist.AgentId > 0")->asArray()->all();

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
                        $use=round(($arr[$j+1]['WaterRest']-$arr[$j]['WaterRest']),2);
                        if($use>0){//扫码增加容量的过滤掉
                            $use_status[]=['WaterUse'=>$use,
//                                'ActTime'=>$arr[$j]['ActTime'],
                                'ActDate'=>$arr[$j]['ActDate']
                            ];
                        }

                    }

                }
            }
        }
        return $use_status;
    }


    public function actionGuid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }

}
