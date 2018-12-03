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
    public static function pageQuery($picture_state,$state4,$state1,$state2,$state3,$content,$usetype,$customertype,$province,$city,$area,$sort,$sort2,$state5)
    {



        //读取状态为0的，-1 被删除
        $where = " user_info.State=0 and dev_regist.AgentId > 0
        and dev_regist.DevNo not in ('2080111157','2079111335',
        '2080111168','2079111324','2079111234','2080111270',
        '2810000021','2081111136','2085111118','2081111338')";
//        $where = " user_info.State=0 and dev_regist.AgentId > 0 ";

        if ($picture_state!=='') {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.ImageState='$picture_state' ";
        }

        if($state1==1&&!$state2&&!$state3){//只显示正常设备
            if (!empty($where)) {
                $where .= " and ";
            }

            if($state4){
                $where.=" dev_regist.IsActive=1 and
                EXISTS (SELECT 1 from (select dev_regist.UserId from dev_regist
                where not EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and dev_regist.AgentId > 0 and dev_regist.IsActive=1 GROUP BY UserId HAVING count(UserId) > 1)as temp where UserId=dev_regist.UserId)";
            }else{
                $where .= " dev_regist.IsActive=1 and not exists (select 1 from dev_cmd
                where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) ";
            }

        }

        if(!$state1&&$state2==1&&!$state3){//只显示未激活设备
            if (!empty($where)) {
                $where .= " and ";
            }

            if($state4){
                $where.=" dev_regist.IsActive=0 and
                EXISTS (SELECT 1 from (select dev_regist.UserId from dev_regist
                where not EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and dev_regist.AgentId > 0 and dev_regist.IsActive=0 GROUP BY UserId HAVING count(UserId) > 1)as temp where UserId=dev_regist.UserId) ";
            }else{
                $where .= " dev_regist.IsActive=0 and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) ";
            }

        }
        if(!$state1&&!$state2&&$state3==1){//只显示已初始化设备
            if (!empty($where)) {
                $where .= " and ";
            }

            if($state4){
                $where.=" EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and EXISTS (SELECT 1 from (select dev_regist.UserId from dev_regist
                where EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and dev_regist.AgentId > 0 GROUP BY UserId HAVING count(UserId) > 1)as temp where UserId=dev_regist.UserId) ";
            }else{
                $where .= "  exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) ";

            }
        }
        if($state1==1&&$state2==1&&!$state3){//只显示正常设备和未激活设备
            if (!empty($where)) {
                $where .= " and ";
            }

            //正常设备和未激活设备 的重复电话的设备
            if($state4){
                $where.=" not EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and  EXISTS (SELECT 1 from (select dev_regist.UserId from dev_regist
                where not EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and dev_regist.AgentId > 0 GROUP BY UserId HAVING count(UserId) > 1)as temp where UserId=dev_regist.UserId)";
            }else{
                $where .= "  not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) ";

            }
        }
        if($state1==1&&!$state2&&$state3==1){//只显示正常设备和已初始化设备
            if (!empty($where)) {
                $where .= " and ";
            }

            if($state4){
                $where.=" (dev_regist.IsActive = 1 or  EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))
                and EXISTS (SELECT 1 from (select dev_regist.UserId from dev_regist
                where (dev_regist.IsActive = 1 or  EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))
                and dev_regist.AgentId > 0 GROUP BY UserId HAVING count(UserId) > 1)as temp where UserId=dev_regist.UserId)";
            }else{
                $where .= " (dev_regist.IsActive = 1 or  exists (select 1 from dev_cmd
                where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))";

            }
        }
        if(!$state1&&$state2==1&&$state3==1){//只显示未激活设备和已初始化设备
            if (!empty($where)) {
                $where .= " and ";
            }

            if($state4){
                $where.=" (dev_regist.IsActive = 0 or  EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))
                and EXISTS (SELECT 1 from (select dev_regist.UserId from dev_regist
                where (dev_regist.IsActive = 0 or  EXISTS(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))
                and dev_regist.AgentId > 0 GROUP BY UserId HAVING count(UserId) > 1)as temp where UserId=dev_regist.UserId)";
            }else{
                $where .= " (dev_regist.IsActive = 0 or exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))";

            }
        }
        //正常设备、未激活设备、已初始化设备 都显示
        if($state1==1&&$state2==1&&$state3==1){
            if($state4){
                if (!empty($where)) {
                    $where .= " and ";
                }
                $where.=" EXISTS (SELECT 1 from (select dev_regist.UserId from dev_regist
                where dev_regist.AgentId > 0 GROUP BY UserId HAVING count(UserId) > 1)as temp where UserId=dev_regist.UserId)";
            }
        }




        if (!empty($content)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " (dev_regist.DevNo like '%$content%' or user_info.Name  like '%$content%'
                      or dev_regist.UseType like '%$content%' or dev_regist.CustomerType like '%$content%'
                       or agent_info.Name like '%$content%' or user_info.Tel like '%$content%'
                        or dev_regist.CodeNumber like '%$content%'
                       )";
        }

        if (!empty($usetype)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.UseType='$usetype' ";
        }

        if (!empty($customertype)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.CustomerType='$customertype' ";
        }


        if (!empty($province)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.Province='$province' ";
        }
        if (!empty($city)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.City='$city' ";
        }
        if (!empty($area)) {
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " dev_regist.Area='$area' ";
        }

        $order=" ORDER BY RowTime desc ";
        if ($sort && $sort % 2 == 0) {//偶数 升序
            $order=" ORDER BY RowTime asc ";
        }
        if ($sort2 && $sort2 % 2 == 0) {//偶数 升序
            $order=" ORDER BY ImageState asc ";
        }
        if ($sort2 && $sort2 % 2 == 1) {//奇数 降序
            $order=" ORDER BY ImageState desc ";
        }

        $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type = $model->getAttribute("logic_type");
        if ($logic_type == 3 || $logic_type == 4 || $logic_type == 6) {
            //代理商
            $username = $model->getAttribute("username");
            return CustomSearch::pageQueryByname($where, $username, $logic_type,$order);
        }
        if($state5==1&&!$state1&&!$state2&&!$state3&&!$state4) {//勾选了推荐用户，没有勾选重复电话
            if (!empty($where)) {
                $where .= " and ";
            }
            $where .= " not exists (
            select 1 from user_info as user_info1
            INNER JOIN dev_regist ON dev_regist.UserId=user_info1.Id where user_info.Id=user_info1.Id) ";
        }

        $str='';
        if($state5==1&&!$state4){//勾选了推荐用户，没有勾选重复电话

            if($picture_state||$customertype||$usetype||$province||$city||$area){
                $str='';
            }else {
                $where_str='';
                if($content){
                    $where_str=" and (user_info.Name  like '%$content%' or user_info.Tel  like '%$content%') ";
                }
                $str = " UNION
                select DISTINCT user_info.Id, user_info.Name,
                user_info.Tel,user_info.Province,user_info.City,user_info.Area,
                user_info.Address,null as DevNo ,null as UseType,user_info.IsUse,
                null as CustomerType,null as RowTime,null as AgentName,
                null as BrandName,null as goodsname,null as IsActive,
                null as CodeNumber,null as RoomNo,user_info.Remark,null as Image,
                null as TempImage,null as ImageState,null as ImageErrorReason,
                user_info.RecommendUserTel,user_info.Money,activity.Title
                from user_info
                LEFT JOIN activity on activity.Id=user_info.ActivityId
                and activity.StartTime < NOW() and activity.EndTime > NOW()
                where NOT exists
                (select 1 from user_info as user_info1 INNER JOIN dev_regist on dev_regist.UserId=user_info1.Id
                where user_info1.Id=user_info.Id) $where_str";
            }

        }


        return self::findBySql("select distinct * from (
        select DISTINCT user_info.Id, user_info.Name,
        user_info.Tel,dev_regist.Province,dev_regist.City,dev_regist.Area,
        dev_regist.Address,dev_regist.DevNo ,dev_regist.UseType,user_info.IsUse,
        dev_regist.CustomerType,dev_regist.RowTime,agent_info.Name as AgentName,
        brands.BrandName,goods.name as goodsname,dev_regist.IsActive,
        dev_regist.CodeNumber,dev_regist.RoomNo,user_info.Remark,dev_regist.Image,
        dev_regist.TempImage,dev_regist.ImageState,dev_regist.ImageErrorReason,
        user_info.RecommendUserTel,user_info.Money,activity.Title
        from dev_regist
        LEFT JOIN user_info ON user_info.Id=dev_regist.UserId
        LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
        LEFT JOIN goods ON dev_regist.goods_id=goods.id
        LEFT JOIN agent_info ON dev_regist.AgentId=agent_info.Id
        LEFT JOIN activity on activity.Id=user_info.ActivityId
        and activity.StartTime < NOW() and activity.EndTime > NOW()

        ".(empty($where)?"":" where ".$where)."
        $str
        )as temp $order ");

    }

    public static function pageQueryByname($where,$loginName,$logic_type,$order)
    {


        $str='';
        $agent_id=-1;
        if($logic_type==3){//运营中心
            //获取该运营中心下的所有服务中心
            //获取运营中心id
            $data=AgentInfo::findOne(['LoginName'=>$loginName]);

            if($data){
                $agent_id=$data->Id;//运营中心id
                //获取下面的服务中心id
//                $str="(select agent_info.Id from agent_info where agent_info.ParentId = $agent_id)";
                $str="(select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5))";

            }
        }elseif($logic_type==6){//片区中心
            $data=AgentInfo::findOne(['LoginName'=>$loginName]);
            if($data){
                $agent_id=$data->Id;//片区中心id
                //获取下面的服务中心id
                $str="(select agent_info.Id from agent_info where agent_info.ParentId = $agent_id)";

            }

        }else{//服务中心

            //根据登陆名称获取agentid
            $data=AgentInfo::findOne(['LoginName'=>$loginName]);
            if($data){

                $str="(select agent_info.Id from agent_info where agent_info.LoginName='{$loginName}')";
            }


        }

            //获取所有用户
            $sql="select * from (select user_info.Id, user_info.Name,
        user_info.Tel,dev_regist.Province,dev_regist.City,dev_regist.Area,
        dev_regist.Address,dev_regist.DevNo ,dev_regist.UseType,
        dev_regist.CustomerType,dev_regist.RowTime,agent_info.Name as AgentName,
        goods.name as goodsname,brands.BrandName,dev_regist.IsActive,
        dev_regist.CodeNumber,dev_regist.RoomNo,user_info.Remark,dev_regist.Image,
        dev_regist.TempImage,dev_regist.ImageState,dev_regist.ImageErrorReason
            from user_info
            LEFT JOIN dev_regist ON user_info.Id=dev_regist.UserId

            LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
            LEFT JOIN goods ON dev_regist.goods_id=goods.id

            LEFT JOIN agent_info ON dev_regist.AgentId=agent_info.Id
            where (dev_regist.AgentId={$agent_id} or dev_regist.AgentId in $str)
            ".(empty($where)?"":" and ".$where)." $order) as temp
            where DevNo not in (select DevNo from dev_cmd where CmdType=4 and State=1 GROUP BY DevNo)";


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