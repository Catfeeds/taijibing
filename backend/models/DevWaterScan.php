<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午9:33
 */

namespace backend\models;
error_reporting(E_ALL & ~ E_NOTICE);

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
                                                                                                                                                                //过滤掉编号为零的、未激活
//        $res=  static::findBySql("select *,sum(WaterUse) as total_volume from dev_action_log where RowTime>=DATE_SUB(CURDATE(),INTERVAL 30 DAY) and ActType=16 and DevNo<>0 and DevNo in(select DevNo from dev_regist where IsActive=1)
//group by ActDate")->asArray()->all();
        //--------------


        $res=self::GetWaterUse();

        //-------------------


        $daysArr=self::getLatest30Days();
        $data['x']=$daysArr;
        $data["y"]=array_fill_keys( array_flip($daysArr),0);


            for($index=0;$index<count($res);$index++){
                $x_alias=$res[$index]["ActDate"];
                $key=array_search($x_alias,$daysArr);
                if($key===false){
                    continue;
                }
//                $data['y'][$key]=intval($res[$index]["total_volume"]);
                $data['y'][$key]=$res[$index]["total_volume"];
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
                                                                                                        //不统计编号为零的、未激活
        $res=  static::findBySql("select dev_water_scan.*,count(Date) as amount from dev_water_scan where DevNo<>0 and DevNo in(select DevNo from dev_regist where IsActive=1)
and RowTime>=DATE_SUB(CURDATE(),INTERVAL 30 DAY) group by Date")->asArray()->all();
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
    public static function totalQuery2($pid,$brand_id,$goods_id,$Volume,$content,$selecttime,$sort,$sort2){
        $startTime='';
        $endTime='';
        $where='';
        if($content){
            $where=" and w.BrandName like '%$content%' ";
        }

        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){

            $where.=" and f.EndTime >= '$startTime' and f.EndTime <= '$endTime'";
        }

        //排序（剩余条码数）
        $order='';
        if($sort && $sort%2==0){//偶数 升序
            $order=" order by LeftAmount asc";

        }
        if($sort && $sort%2==1){//降序
            $order=" order by LeftAmount desc";

        }
        //排序(使用条码数)
        if($sort2 && $sort2%2==0){//偶数 升序
            $order=" order by Amount asc";

        }
        if($sort2 && $sort2%2==1){
            $order=" order by Amount desc";
        }


        $sql=" select * from (select f.*,w.BrandName,goods.name,f2.LeftAmount
 from factory_wcode_print_log as f
 LEFT JOIN factory_wcode as f2 on f.Fid=f2.Fid and f.Volume=f2.Volume
 and f.BrandNo=f2.WaterBrand and f.GoodsId=f2.GoodsId
 LEFT JOIN brands as w on f.BrandNo=w.BrandNo
 LEFT JOIN goods on f.GoodsId=goods.id
 where f.Fid=$pid and f.BrandNo='$brand_id'
 and f.GoodsId='$goods_id' and f.Volume=$Volume
 $where order by EndTime DESC) as temp "."$order";

        return ActiveRecord::findBySql($sql);
    }



    public static function totalQuery3($factory_id,$water_brandno,$water_goods_id,$water_volume,$DevNo,$selecttime,$content,$sort){
//        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
//        $logic_type=$model->getAttribute("logic_type");
//        $username='';
//        if($logic_type==3||$logic_type==4){
//            //代理商
//            $username=$model->getAttribute("username");
//        }
        $where =self::getSaomaListWhereStr2($factory_id,$water_brandno,$water_goods_id,$water_volume,$DevNo,$content,$username);

        $startTime='';
        $endTime='';
        $where2='';
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){

            $where2="RowTime >= '$startTime' and RowTime <= '$endTime'";
        }




        //排序（扫码时间）
        $order=" order by RowTime desc ";
        if($sort && $sort%2==1){
            $order=" order by RowTime asc ";
        }


        $sql="select * from (select * from (select DISTINCT
dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,
factory_info.`Name` as factoryName,water_brand.BrandName as water_brand,
watergoods.name as water_name,dev_water_scan_log.Volume,dev_regist.`Province`,
dev_regist.`City`,dev_regist.`Area`,dev_location.`Address`,goods.name as goodsname,
brands.BrandName,dev_factory.Name as devfactoryname,agent_info.Name as investor,
agent.Name as agentname,agent2.Name as agentpname,dev_regist.UseType,
dev_regist.CustomerType,user_info.`Name`,user_info.`Tel`,dev_water_scan_log.RowTime
 from dev_water_scan_log
 LEFT join user_info on dev_water_scan_log.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan_log.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan_log.`DevNo`=dev_location.`DevNo`

left join wcode_info on dev_water_scan_log.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId`

left join goods on dev_regist.goods_id=goods.id
left join brands on brands.BrandNo=dev_regist.brand_id
left join brands as water_brand on water_brand.BrandNo=dev_water_scan_log.BrandNo
left join goods as watergoods on watergoods.id=dev_water_scan_log.GoodsId
left join investor on dev_regist.investor_id=investor.agent_id
and dev_regist.goods_id=investor.goods_id
left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id
left join agent_info on agent_info.Id=investor.agent_id
left join agent_info as agent on agent.Id=dev_regist.AgentId
left join agent_info as agent2 on agent2.Id=agent.ParentId

".(empty($where)?"":" where $where  ")." order by dev_water_scan_log.RowTime asc )as temp1 ".(empty($DevNo)?"  group by BarCode,DevNo ":"  group by BarCode  ")." ) as temp ".(empty($where2)?"":" where $where2  ")."  $order ";


//        return $sql;
        return static::findBySql($sql);
    }

    public static function pageQuery3($DevNo,$selecttime,$content,$sort){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $username='';
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
        }
        $where =self::getSaomaListWhereStr2($selecttime,$content,$username);

        //排序（扫码时间）
        $order=" order by dev_water_scan_log.`RowTime` Desc ";
        if($sort && $sort%2==1){
            $order=" order by dev_water_scan_log.`RowTime` asc ";
        }


        $sql="select DISTINCT agent_info.Id as agentId,agent_info.Level,dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`DevFactory`,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,factory_info.`Name` as factoryName
 from dev_water_scan
 right join dev_water_scan_log on dev_water_scan_log.`BarCode` = dev_water_scan.`BarCode`
 INNER join user_info on dev_water_scan.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan.`DevNo`=dev_location.`DevNo`
left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId` ".(empty($username)?"":"agent_info.LoginName='$username' ")."
left join wcode_info on dev_water_scan.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId` where dev_water_scan_log.DevNo='$DevNo'
".(empty($where)?"":" and $where")." $order ";

//        var_dump($sql);exit;
        return static::findBySql($sql);
    }





    public static function totalQuery($state,$selecttime,$content,$province,$city,$area,$sort){

//        $where =self::getSaomaListWhereStr($selecttime,$content,$username,$province,$city,$area);
        $where =self::getSaomaListWhereStr($content,$province,$city,$area);

        //排序（剩余条码数）
        $order=" order by RowTime desc ";
        if($sort && $sort%2==1){//偶数 升序
            $order=" order by RowTime asc ";

        }

        $where2='';

        if($state==1){//显示正常设备（没有初始化的）动态
            if($where2)$where2.=' and ';
            $where2.=" not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=temp.DevNo) and CustomerType > 0 ";
        }
        if($state==2){//显示已初始化的动态
            if($where2)$where2.=' and ';
            $where2.=" exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=temp.DevNo)  and CustomerType > 0 ";
        }
        if($state==3){//显示未绑定用户的动态
            if($where2)$where2.=' and ';
            $where2.=" AgentId = 0 and
                    not EXISTS (select 1 from dev_regist as tempa where tempa.CustomerType > 0 and tempa.Iccid=temp.Iccid
                    and not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=tempa.DevNo)) ";

        }
        $startTime='';
        $endTime='';
//        $where3='';
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            if($where2)$where2.=' and ';
            $where2.="RowTime >= '$startTime' and RowTime <= '$endTime'";
        }


        $sql="select DISTINCT * from (select dev_water_scan_snapshot.BarCode,
dev_water_scan_snapshot.DevNo,dev_water_scan_snapshot.RowTime,dev_location.`Address`,
user_info.`Name`,user_info.`Tel`,a.Name as agentname,
b.Name as agentpname,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,
factory_info.`Name` as factoryName,agent.Name as investor,dev_regist.Iccid,dev_regist.CustomerType,dev_regist.AgentId
from dev_water_scan_snapshot
LEFT join user_info on dev_water_scan_snapshot.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan_snapshot.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan_snapshot.`DevNo`=dev_location.`DevNo`
left join `agent_info` as a on a.`Id`=dev_regist.`AgentId`
left join `agent_info` as b on a.`ParentId`=b.`Id`
left join wcode_info on dev_water_scan_snapshot.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId`

left join `investor` on investor.`agent_id`=dev_regist.`investor_id`
and investor.`goods_id`=dev_regist.`goods_id`
left join agent_info as agent on agent.Id=investor.agent_id

".(empty($where)?"":" where $where").") as temp".(empty($where2)?"":" where $where2")." $order ";


        return static::findBySql($sql);
    }

//已初始化设备的扫码记录
    public static function totalQueryA($content,$DevNo,$selecttime){
//        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
//        $logic_type=$model->getAttribute("logic_type");
//        $username='';
//        if($logic_type==3||$logic_type==4){
//            //代理商
//            $username=$model->getAttribute("username");
//        }
//        $where =self::getSaomaListWhereStr($selecttime,$content,$username,$province,$city,$area);
//
//        //排序（剩余条码数）
//        $order=" order by RowTime desc ";
//        if($sort && $sort%2==1){//偶数 升序
//            $order=" order by RowTime asc ";
//
//        }

        $where="";

        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            $where.="dev_water_scan_log.RowTime >= '$startTime' and dev_water_scan_log.RowTime <= '$endTime'";
        }

        if($content){
            if($where){
                $where.=" and ";
            }
            $where.=" dev_water_scan_log.BarCode like '%$content%' ";
        }


        $sql="select agent_info.Id as agentId,dev_water_scan_log.Volume,
agent_info.Level,dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,
dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,
user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`DevFactory`,
dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,
factory_info.`Name` as factoryName
 from dev_water_scan_log
 LEFT join user_info on dev_water_scan_log.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan_log.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan_log.`DevNo`=dev_location.`DevNo`
left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId`
left join wcode_info on dev_water_scan_log.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId`
where dev_water_scan_log.DevNo='$DevNo'
".(empty($where)?"":" and $where")." order by dev_water_scan_log.`RowTime` Desc";




//        $sql="select DISTINCT * from (select agent_info.Id as agentId,agent_info.Level,dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`DevFactory`,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,factory_info.`Name` as factoryName
// from dev_water_scan
// right join dev_water_scan_log on dev_water_scan_log.`BarCode` = dev_water_scan.`BarCode`
// INNER join user_info on dev_water_scan.`UserId`=user_info.`Id`
//left join dev_regist on dev_water_scan.`DevNo`=dev_regist.`DevNo`
//left join dev_location on dev_water_scan.`DevNo`=dev_location.`DevNo`
//left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId`
//left join wcode_info on dev_water_scan.`BarCode`=`wcode_info`.`Code`
//left join `factory_info` on factory_info.`Id`=wcode_info.`FId`
//".(empty($where)?"":" where $where")." order by dev_water_scan_log.`RowTime` Desc) as temp group by DevNo $order ";


        return static::findBySql($sql);
    }
    public static function pageQuery($offset=0,$limit=0,$selecttime,$content,$province,$city,$area,$sort){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $username='';
        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
        }
        $where =self::getSaomaListWhereStr($selecttime,$content,$username,$province,$city,$area);

        //排序（剩余条码数）
        $order=" order by RowTime asc ";
        if($sort && $sort%2==1){//偶数 升序
            $order=" order by RowTime desc ";

        }



        $sql="select * from (select agent_info.Id as agentId,agent_info.Level,dev_water_scan_log.BarCode,dev_water_scan_log.DevNo,dev_water_scan_log.RowTime,dev_location.`Address`,user_info.`Name`,user_info.`Tel`,agent_info.`Name` as agentName,dev_regist.`DevFactory`,dev_regist.`Province`,dev_regist.`City`,dev_regist.`Area`,factory_info.`Name` as factoryName
 from dev_water_scan
 right join dev_water_scan_log on dev_water_scan_log.`BarCode` = dev_water_scan.`BarCode`
 INNER join user_info on dev_water_scan.`UserId`=user_info.`Id`
left join dev_regist on dev_water_scan.`DevNo`=dev_regist.`DevNo`
left join dev_location on dev_water_scan.`DevNo`=dev_location.`DevNo`
left join `agent_info` on agent_info.`Id`=dev_regist.`AgentId`
left join wcode_info on dev_water_scan.`BarCode`=`wcode_info`.`Code`
left join `factory_info` on factory_info.`Id`=wcode_info.`FId`
".(empty($where)?"":" where $where")." order by dev_water_scan_log.`RowTime` Desc) as temp group by DevNo $order
  limit $offset , $limit ";
//        return $sql;  ".(empty($username)?"":" and agent_info.LoginName='$username' ")."
        return static::findBySql($sql);
    }
    private static function getSaomaListWhereStr($content,$province,$city,$area){

        $where='';
        $login_id=yii::$app->getUser()->getIdentity()->getId();//登陆者id
        $model = User::findOne(['id'=>$login_id]);
        $logic_type=$model->getAttribute("logic_type");
        $agent_id=AgentInfo::findOne(['LoginName'=>$model->username])->Id;

        if($logic_type==4){//服务中心登陆
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="dev_regist.AgentId = $agent_id ";

        }
        if($logic_type==3){//运营中心登陆
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="(dev_regist.AgentId = $agent_id
             or dev_regist.AgentId in (select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)))";
        }


        if(!empty($content)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="(dev_water_scan_snapshot.DevNo like '%$content%' or user_info.Name like '%$content%' or a.Name like '%$content%' or b.Name like '%$content%' or user_info.Tel like '%$content%' or dev_water_scan_snapshot.BarCode like '%$content%')";
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

        return $where;


    }


    private static function getSaomaListWhereStr2($factory_id,$water_brandno,$water_goods_id,$water_volume,$DevNo,$content,$username){
        $where='';
        $login_id=yii::$app->getUser()->getIdentity()->getId();//登陆者id
        $model = User::findOne(['id'=>$login_id]);
        $logic_type=$model->getAttribute("logic_type");
        $agent_id=AgentInfo::findOne(['LoginName'=>$model->username])->Id;

        if($logic_type==4){//服务中心登陆
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="dev_regist.AgentId = $agent_id ";

        }
        if($logic_type==3){//运营中心登陆
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="(dev_regist.AgentId = $agent_id
             or dev_regist.AgentId in (select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)))";
        }

        if(!empty($content)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" dev_water_scan_log.BarCode like '%$content%'";
        }

//        if(!empty($username)){
//            if(!empty($where)){
//                $where.=' and ';
//            }
//            $where.="agent_info.LoginName = '$username'";
////            $where.="SELECT agent_info.Id from agent_info where agent_info.LoginName='$username'";
//        }

        if(!empty($factory_id)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="wcode_info.FId=$factory_id";
        }
        if(!empty($water_brandno)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="dev_water_scan_log.BrandNo='$water_brandno'";
        }
        if(!empty($water_goods_id)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="dev_water_scan_log.GoodsId=$water_goods_id";
        }
        if(!empty($water_volume)){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.="dev_water_scan_log.Volume=$water_volume";
        }
        if($DevNo!=''){
            if(!empty($where)){
                $where.=' and ';
            }
            $where.=" dev_water_scan_log.DevNo='$DevNo' ";
        }
        return $where;


    }

    //获取不同日期每天的用水量
    public static function GetWaterUse(){

        $start=date('Y-m-d',strtotime('-29 day'));
        $end=date('Y-m-d H:i:s',time());

        $sql="select DISTINCT temp.* from (
                    (select DevNo,WaterRest,ActTime,ActDate from dev_action_log where ActType=99 and ActTime > '$start' and ActTime < '$end')
                     UNION
                    (select * from (select DevNo,WaterRest,ActTime,ActDate from dev_action_log where ActType=99 and ActTime < '$start' order by ActTime desc )as temp group by DevNo)
                    )as temp
                    inner join dev_regist on dev_regist.DevNo=temp.DevNo
                    where dev_regist.DevNo <> 0
                    order by temp.ActTime desc,temp.WaterRest asc";
        $datas=ActiveRecord::findBySql($sql)->asArray()->all();
        $DevNos=ActiveRecord::findBySql("select DevNo from dev_regist where dev_regist.DevNo <> 0 ")->asArray()->all();

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
        $days=[];
        for($i=0;$i<30;$i++){
            $time=date('Y-m-d',strtotime('-'.$i.'day'));
            $days[]=$time;
        }
        $arr=[];
        foreach($days as $k=>$day){
            $sum=0;
            foreach($use_status as $v){
                if($v['ActDate']==$day){
                    $sum+=$v['WaterUse'];
                }
            }
            $arr[]=['ActDate'=>$day,'total_volume'=>$sum];
        }
        return $arr;


    }



}