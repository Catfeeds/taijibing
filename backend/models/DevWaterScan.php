<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午9:33
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii;
class DevWaterScan extends  ActiveRecord
{
    public static function tableName()
    {
        return 'dev_water_scan';
    }

    /**
     * 今日销售数量
     * @return int|string
     */
    public static function getSellAmountOfToday(){
        $now= date("Y-m-d");
       return  static::findBySql("select * from dev_water_scan where Date=$now")->asArray()->count();
    }

    /**
     * 累计销售数量
     * @return int|string
     */
    public static function getSellAmount(){
        return  static::findBySql("select * from dev_water_scan")->asArray()->count();
    }
    public static function getTodaySellAmount(){
        $now= date("Y-m-d")." 00:00:00";
        $res=  static::findBySql("select * from dev_water_scan where RowTime>='$now'")->asArray()->all();
        $data["x"]=["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00"
                    ,"12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00"];
        $data["y"]=[];
        foreach($data["x"] as $val){
            $amount=0;
            for($index=0;$index<count($res);$index++){

                $start=date("Y-m-d")." ".$val;
                $arr= explode(":",$val);
                $end=date("Y-m-d")." ".$arr[0].":59";
                if($res[$index]["RowTime"]< $end&&$res[$index]["RowTime"]>=$start){
                    $amount+=$res[$index]["Volume"];
                }
            }
            $data["y"][]=$amount;
        }
        return $data;
    }
    public static function getMonthSellAmount(){
        $res=  static::findBySql("select *,sum(WaterUse) as total_volume from dev_action_log where RowTime>=DATE_SUB(CURDATE(),INTERVAL 30 DAY) and ActType=16 group by ActDate")->asArray()->all();

        $daysArr=self::getLatest30Days();
        $data['x']=$daysArr;
        $data["y"]=array_fill_keys( array_flip($daysArr),0);


            for($index=0;$index<count($res);$index++){
                $x_alias=$res[$index]["ActDate"];
                $key=array_search($x_alias,$daysArr);
                if($key===false){
                    continue;
                }
                $data['y'][$key]=intval($res[$index]["total_volume"]);
            }

        return $data;
    }
    public static function getLatest30Days(){
        $days=array();
        for($i=0;$i<30;$i++){
            $days[$i]=date("Y-m-d",strtotime('-'.$i.'day'));
        }
        return array_reverse($days);
    }
    public static function getTodaySellPackageAmount(){
        $now= date("Y-m-d")." 00:00:00";
        $res=  static::findBySql("select * from dev_water_scan where RowTime>='$now'")->asArray()->all();
        $data["x"]=["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00"
            ,"12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00"];
        $data["y"]=[];
        foreach($data["x"] as $val){
            $amount=0;
            for($index=0;$index<count($res);$index++){

                $start=date("Y-m-d")." ".$val;
                $arr= explode(":",$val);
                $end=date("Y-m-d")." ".$arr[0].":59";
                if($res[$index]["RowTime"]< $end&&$res[$index]["RowTime"]>=$start){
                    $amount+=1;
                }
            }
            $data["y"][]=$amount;
        }
        return $data;
    }
    public static function getMonthSellPackageAmount(){

        $res=  static::findBySql("select dev_water_scan.*,count(Date) as amount from dev_water_scan where RowTime>=DATE_SUB(CURDATE(),INTERVAL 30 DAY) group by Date")->asArray()->all();
        $daysArr=self::getLatest30Days();
        $data['x']=$daysArr;
        $data["y"]=array_fill_keys( array_flip($daysArr),0);
        for($index=0;$index<count($res);$index++){
            $x_alias=$res[$index]["Date"];
            $key=array_search($x_alias,$daysArr);
            if($key===false){
                continue;
            }
            $data['y'][$key]=intval($res[$index]["amount"]);
        }

        return $data;
    }



    //查询水厂条码使用记录
    public static function totalQuery2($waterfname_id){


        $sql="select f.*,w.BrandName from factory_wcode as f JOIN water_brand as w on f.WaterBrand=w.BrandNo where f.Fid={$waterfname_id}";

        return ActiveRecord::findBySql($sql);
    }



    public static function totalQuery3($DevNo,$selecttime,$content){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $username='';
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
        }
        $where =self::getSaomaListWhereStr2($selecttime,$content,$username);
//        var_dump($DevNo);exit;
//        var_dump($where);exit;
        //先排序，再分组。获取每个设备最近的一条扫码记录（点击详情时才读取该设备的所有记录）
        $sql="select DISTINCT dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`DevFactory`,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,factory_info.`Name` as factoryName
 from dev_water_scan
 right join dev_water_scan_log on dev_water_scan_log.`BarCode` = dev_water_scan.`BarCode`
INNER join user_info on dev_water_scan.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan.`DevNo`=dev_location.`DevNo`
left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId` ".(empty($username)?"":"agent_info.LoginName='$username' ")."
left join wcode_info on dev_water_scan.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId` where dev_water_scan_log.DevNo={$DevNo}
 ".(empty($where)?"":" and $where")." order by dev_water_scan_log.`RowTime` Desc ";

//        var_dump($sql);exit;
//        return $sql;
        return static::findBySql($sql);
    }

    public static function pageQuery3($DevNo,$offset=0,$limit=0,$selecttime,$content){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $username='';
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
        }
        $where =self::getSaomaListWhereStr2($selecttime,$content,$username);
        $sql="select DISTINCT agent_info.Id as agentId,agent_info.Level,dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`DevFactory`,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,factory_info.`Name` as factoryName
 from dev_water_scan
 right join dev_water_scan_log on dev_water_scan_log.`BarCode` = dev_water_scan.`BarCode`
 INNER join user_info on dev_water_scan.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan.`DevNo`=dev_location.`DevNo`
left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId` ".(empty($username)?"":"agent_info.LoginName='$username' ")."
left join wcode_info on dev_water_scan.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId` where dev_water_scan_log.DevNo=$DevNo
".(empty($where)?"":" and $where")." order by dev_water_scan_log.`RowTime` Desc
  limit $offset , $limit ";

//        var_dump($sql);exit;
        return static::findBySql($sql);
    }








    public static function totalQuery($selecttime,$content,$province,$city,$area){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $username='';
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
        }
        $where =self::getSaomaListWhereStr($selecttime,$content,$username,$province,$city,$area);

        //先排序，再分组。获取每个设备最近的一条扫码记录（点击详情时才读取该设备的所有记录）
        $sql="select * from (select DISTINCT dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,dev_regist.`DevFactory`,factory_info.`Name` as factoryName
 from dev_water_scan
 right join dev_water_scan_log on dev_water_scan_log.`BarCode` = dev_water_scan.`BarCode`
INNER join user_info on dev_water_scan_log.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan.`DevNo`=dev_location.`DevNo`
left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId`
left join wcode_info on dev_water_scan.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId`
 ".(empty($where)?"":" where $where")." order by dev_water_scan_log.`RowTime` Desc) as temp group by DevNo ";
//       return $sql;  ".(empty($username)?"":" and agent_info.LoginName='$username' ")."
        return static::findBySql($sql);
    }
    public static function pageQuery($offset=0,$limit=0,$selecttime,$content,$province,$city,$area){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $username='';
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
        }
        $where =self::getSaomaListWhereStr($selecttime,$content,$username,$province,$city,$area);
        $sql="select * from (select DISTINCT agent_info.Id as agentId,agent_info.Level,dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`DevFactory`,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,factory_info.`Name` as factoryName
 from dev_water_scan
 right join dev_water_scan_log on dev_water_scan_log.`BarCode` = dev_water_scan.`BarCode`
 INNER join user_info on dev_water_scan.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan.`DevNo`=dev_location.`DevNo`
left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId`
left join wcode_info on dev_water_scan.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId`
".(empty($where)?"":" where $where")." order by dev_water_scan_log.`RowTime` Desc) as temp group by DevNo
  limit $offset , $limit ";
//        return $sql;  ".(empty($username)?"":" and agent_info.LoginName='$username' ")."
        return static::findBySql($sql);
    }
    private static function getSaomaListWhereStr($selecttime,$content,$username,$province,$city,$area){
        $startTime='';
        $endTime='';
        $where='';
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
                $endTime=$dateArr[1];
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            $where.="dev_water_scan_log.RowTime >= '$startTime' and dev_water_scan_log.RowTime <= '$endTime'";
        }


        if(!empty($content)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="(dev_water_scan_log.DevNo like '%$content%' or user_info.Name like '%$content%' or agent_info.Name like '%$content%' or user_info.Tel like '%$content%')";
        }


        if(!empty($province)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" dev_regist.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" dev_regist.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" dev_regist.Area='$area'";
        }

        if(!empty($username)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="agent_info.LoginName = '$username'";
//            $where.="SELECT agent_info.Id from agent_info where agent_info.LoginName='$username'";
        }
        return $where;


    }


    private static function getSaomaListWhereStr2($selecttime,$content,$username){
        $startTime='';
        $endTime='';
        $where='';
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
                $endTime=$dateArr[1];
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            $where.="dev_water_scan_log.RowTime >= '$startTime' and dev_water_scan_log.RowTime <= '$endTime'";
        }


        if(!empty($content)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" dev_water_scan_log.BarCode like '%$content%'";
        }


//        if(!empty($province)){
//            if(!empty($where)){
//                $where.=' and ';
//            }
//            $where.=" dev_regist.Province='$province'";
//        }
//        if(!empty($city)){
//            if(!empty($where)){
//                $where.=' and ';
//            }
//            $where.=" dev_regist.City='$city'";
//        }
//        if(!empty($area)){
//            if(!empty($where)){
//                $where.=' and ';
//            }
//            $where.=" dev_regist.Area='$area'";
//        }

        if(!empty($username)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="agent_info.LoginName = '$username'";
//            $where.="SELECT agent_info.Id from agent_info where agent_info.LoginName='$username'";
        }
        return $where;


    }



}