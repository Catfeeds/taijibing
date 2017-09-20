<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午10:05
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii;
class CustomSearch extends ActiveRecord
{

    public static  function tableName()
    {
        return "user_info";
    }
    public static function pageQuery($content,$usetype,$customertype,$province,$city,$area)
    {

        //读取状态为0的，-1 被删除
        $where=' user_info.State=0 ';
//        if(!empty($username)){
//            $where.=" and Name='$username'";
//        }
//        if(!empty($mobile)){
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.="Tel='$mobile' ";
//        }

        if(!empty($content)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" (dev_regist.DevNo like '%$content%' or user_info.Name  like '%$content%'
                      or dev_regist.UseType like '%$content%' or dev_regist.CustomerType like '%$content%'
                       or agent_info.Name like '%$content%' or user_info.Tel like '%$content%')";
        }

        if(!empty($usetype)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.UseType='$usetype' ";
        }

        if(!empty($customertype)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.CustomerType='$customertype' ";
        }


        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.Province='$province' ";
        }
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
        $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type = $model->getAttribute("logic_type");
        if ($logic_type == 3||$logic_type == 4) {
            //代理商
            $username=$model->getAttribute("username");
            return CustomSearch::pageQueryByname($where,$username,$logic_type);
        }
        return self::findBySql("select DISTINCT user_info.Id, user_info.Name,
        user_info.Tel,dev_regist.Province,dev_regist.City,dev_regist.Area,
        dev_regist.Address,dev_regist.DevNo ,dev_regist.UseType,
        dev_regist.CustomerType,dev_regist.RowTime,agent_info.Name as AgentName
        from user_info
        JOIN dev_regist ON user_info.Id=dev_regist.UserId
        JOIN agent_info ON dev_regist.AgentId=agent_info.Id
        ".(empty($where)?"":" where ".$where)."ORDER BY dev_regist.RowTime DESC ");

    }
    public static function pageQueryByname($where,$loginName,$logic_type)
    {


        $str='';
        $agent_id=-1;
        if($logic_type==3){//运营中心
            //获取改运营中心下的所有服务中心
            //获取运营中心id
            $data=AgentInfo::findOne(['LoginName'=>$loginName]);

            if($data){
                $agent_id=$data->Id;//运营中心id
                //获取下面的服务中心id
                $str="(select agent_info.Id from agent_info where agent_info.ParentId = $agent_id)";
                //获取下面的服务中心
//                $datas=AgentInfo::findAll(['ParentId'=>$agint_id]);
//
//                foreach($datas as $v){
//                    $ids[]=$v->Id;//所有服务中心的id
//                }

                //根据agentid获取下面的所有用户id
//                $datas=DevRegist::find()->where(['in' , 'AgentId' , $ids])->all();

            }
        }else{//服务中心

            //根据登陆名称获取agentid
            $data=AgentInfo::findOne(['LoginName'=>$loginName]);
            if($data){
//                $agint_id=$data->Id;
                $str="(select agent_info.Id from agent_info where agent_info.LoginName='{$loginName}')";
//                $ids[]=$agint_id;
                //根据agentid获取下面的所有用户id
//                $datas=DevRegist::findAll(['AgentId'=>$agint_id]);
            }


        }



//        $sr="where dev_regist.AgentId in ".$ids;

//        return $str;

        //获取所有用户
        $sql="select user_info.Id, user_info.Name,
        user_info.Tel,dev_regist.Province,dev_regist.City,dev_regist.Area,
        dev_regist.Address,dev_regist.DevNo ,dev_regist.UseType,
        dev_regist.CustomerType,dev_regist.RowTime,agent_info.Name as AgentName
            from user_info
            JOIN dev_regist ON user_info.Id=dev_regist.UserId
            JOIN agent_info ON dev_regist.AgentId=agent_info.Id
            where dev_regist.AgentId={$agent_id} or dev_regist.AgentId in $str".(empty($where)?"":" and ".$where);

//        $sql2="select user_info.*,dev_regist.DevNo ,dev_regist.UseType,dev_regist.CustomerType,agent_info.Name as AgentName
// from user_info
//left join (select distinct dev_regist.UserId from dev_regist inner join agent_info where agent_info.`Id`=`dev_regist`.`AgentId` or agent_info.`ParentId`= `dev_regist`.`AgentId` and  agent_info.`LoginName`='$loginName') as temp
//on user_info.`Id`=temp.UserId
//JOIN dev_regist ON user_info.Id=dev_regist.UserId
//            JOIN agent_info ON dev_regist.AgentId=agent_info.Id
//".(empty($where)?"":" where ".$where);




        return CustomSearch::findBySql($sql);



//        $sql ="select user_info.*,dev_regist.DevNo from user_info JOIN dev_regist ON user_info.id=dev_regist.UserId
//left join (select distinct dev_regist.UserId from dev_regist inner join agent_info where agent_info.`Id`=`dev_regist`.`AgentId` or agent_info.`ParentId`= `dev_regist`.`AgentId` and  agent_info.`LoginName`='$loginName') as temp
//on user_info.`Id`=temp.UserId".(empty($where)?"":" where ".$where);
//            return CustomSearch::findBySql($sql);
    }
    public static function getLatestData(){
        $dayData=self::getDatasBefore(2);
        $weekData=self::getWeekData(21);
        $monthData=self::getMonthData(60);
        return ["date"=>$dayData,"week"=>$weekData,"month"=>$monthData];
    }
    public static function getDatasBefore($dayNum){
        $dayData= self::findBySql("select count(Id) as count,DATE_FORMAT(`RowTime`,'%Y%m%d') as dt from user_info where DATE_SUB(CURDATE(),INTERVAL $dayNum DAY)<=RowTime GROUP BY dt")->asArray()->all();
        $yesterday=0;
        $beforeYesday=0;
        $dateArr=explode("-",date("Y-m-d"));
        $yNum=intval($dateArr[2])-1;
        $yNumB=intval($dateArr[2])-2;
        foreach($dayData as $val){
            if($val["dt"]=="$dateArr[0]$dateArr[1]$yNum"){
                $yesterday=$val["count"];
            }
            if($val["dt"]=="$dateArr[0]$dateArr[1]$yNumB"){
                $beforeYesday=$val["count"];
            }
        }
        return $yesterday-$beforeYesday;
    }
    public static function getWeekData($weekNum){
        $weeknow=intval(date('W'));
        $week=0;
        $weekBefore=0;
        $weekData=   self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%v') as weeks  from user_info where  DATE_SUB(CURDATE(),INTERVAL $weekNum DAY)<=RowTime GROUP BY weeks")->asArray()->all();
        foreach($weekData as $val){
            if(intval($val["weeks"])==$weeknow-1){
                $week=intval($val["count"]);
            }
            if(intval($val["weeks"])==$weeknow-2){
                $weekBefore=intval($val["count"]);
            }
        }
        return $week-$weekBefore;

    }
    public static function getMonthData($monthNum){
        $monthNow=intval(date("Ym"));
        $monthDay= self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%Y%m') as mh  from user_info where DATE_SUB(CURDATE(),INTERVAL $monthNum DAY)<=RowTime GROUP BY mh")->asArray()->all();
        $month=0;
        $monthBefore=0;
        foreach($monthDay as $val){
            if(intval($val["mh"])==$monthNow-1){
                $month=intval($val["count"]);
            }
            if(intval($val["mh"])==$monthNow-2){
                $monthBefore=intval($val["count"]);
            }
        }
        return $month-$monthBefore;
    }






}