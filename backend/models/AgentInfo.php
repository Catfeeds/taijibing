<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午12:04
 */

namespace backend\models;


use yii\db\ActiveRecord;

/**
 * 区域代理
 * Class AgentInfo
 * @package backend\models
 */
class AgentInfo extends  ActiveRecord
{
    public static function tableName()
    {
        return 'agent_info';
    }
    public static function allQuery(){

    }
    public static function pageQuery(){

    }
    public  function insertBaseInfo2($ParentId,$Admin_User_Id,$loginName='',$name,$Address,$ContractTel,$ContractUser,
        $Province,$City,$Area,$BaiDuLng,$BaiDuLat, $logic_type){
        $this->setAttribute("ParentId",$ParentId);
        $this->setAttribute("Admin_User_Id",$Admin_User_Id);
        $this->setAttribute("LoginName",$loginName);
        $this->setAttribute("ContractTel",$ContractTel);
        $this->setAttribute("ContractUser",$ContractUser);
        $this->setAttribute("Address",$Address);
        $this->setAttribute("Province",$Province);
        $this->setAttribute("City",$City);
        $this->setAttribute("Area",$Area);
        $this->setAttribute("BaiDuLng",$BaiDuLng);
        $this->setAttribute("BaiDuLat",$BaiDuLat);
//        $this->setAttribute("LoginPwd",md5($pwd));
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
//        $this->setAttribute("RegTime",date("Y-m-d H:i:s"));
        $this->setAttribute("Name",$name);
        $this->setAttribute("Level",$logic_type==3?4:5);
        return $this->save(false);
    }

    function insertBaseInfo($ParentId,$Admin_User_Id,$loginName='',$name,$ContractTel,$ContractUser,$Address,
                            $Province,$City,$Area,$BaiDuLng,$BaiDuLat, $logic_type=3,$pwd=''){
        $this->setAttribute("ParentId",$ParentId);
        $this->setAttribute("Admin_User_Id",$Admin_User_Id);
        $this->setAttribute("LoginName",$loginName);
        $this->setAttribute("ContractTel",$ContractTel);
        $this->setAttribute("ContractUser",$ContractUser);
        $this->setAttribute("Address",$Address);
        $this->setAttribute("Province",$Province);
        $this->setAttribute("City",$City);
        $this->setAttribute("Area",$Area);
        $this->setAttribute("BaiDuLng",$BaiDuLng);
        $this->setAttribute("BaiDuLat",$BaiDuLat);
        $this->setAttribute("LoginPwd",md5($pwd));
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
        $this->setAttribute("RegTime",date("Y-m-d H:i:s"));
        $this->setAttribute("Name",$name);
        $this->setAttribute("Level",$logic_type==3?4:5);
        return $this->save(false);
    }
    public function updateForm(){
        $provinceid=$this["Province"];
        $cityid=$this["City"];
        $areaid=$this["Area"];
        $this->setAttribute("Province",$provinceid);
        $this->setAttribute("City",$cityid);
        $this->setAttribute("Area",$areaid);
        return $this->save();
    }
    public function getNameById($id){
        if($id==""){
            return "";
        }
        $res=Address::findBySql("select Name from address_tree where Id=".$id)->asArray()->one();
        if(empty($res)){
            return "";
        }
        return $res["Name"];
    }
    public function getAgentInfoById($id){

        $res=AgentInfo::findBySql("select * from agent_info where Id=".$id)->asArray()->one();
        if(empty($res)){
            return null;
        }
        return $res;
    }
    public function attributeLabels()
    {
        return [
            'Name' => '名称',
            'ContractTel' => '手机号',
            'ContractUser' => '联系人',
            'Address' => '地址',
            'LoginName' => '登录名',
            'LoginPwd'=>'密码',
            'Level'=>'代理类型',
            'Province'=>'省份',
            'City'=>'城市',
            'Area'=>'区县',

        ];
    }

    public function rules()
    {
        return [
            [['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat', 'PreCode','WaterBrandNo','Level'], 'required'],
        ];
    }


    public function scenarios()
    {
        return [
            'default' => ['Name', 'ContractTel','ContractUser','Address','ParentId','Level','Province','City','Area','BaiDuLat','BaiDuLng'],
            'create' => ['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat'],
            'update' => ['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat'],
        ];
    }
    public function queryByLevel($level=4){
        return AgentInfo::findBySql("select * from agent_info where LEVEL =".$level)->asArray()->all();
    }
    public function findOneLowerAgent($agentid){
        return AgentInfo::findBySql("select * from agent_info where ParentId =".$agentid)->asArray()->one();
    }
    public static function setParentId($agentid,$parentId){
       return AgentInfo::updateAll(['ParentId'=>$parentId],'Id='.$agentid);
    }
    public function pagequeryByLevel($level=4){
        return AgentInfo::findBySql("select * from agent_info where LEVEL =".$level);
    }
    public static function pageQueryWithCondition($username,$mobile,$province,$city,$area,$level){
        $where=" a.Level =".$level;
        if(!empty($username)){
            $where.=" and a.Name like '%$username%' or b.Name like '%$username%'";
        }
        if(!empty($mobile)){
            $where.=" and a.ContractTel='$mobile' ";
        }
        if(!empty($province)){
            $where.=" and a.Province='$province' ";
        }
        if(!empty($city)){
            $where.=" and a.City='$city' ";
        }
        if(!empty($area)){
            $where.=" and a.Area='$area' ";
        }

        //根据登陆者的信息，获取登陆者的角色
        $login_id=\Yii::$app->user->id;
        $username=User::findOne(['id'=>$login_id])->username;
//        var_dump($username);exit;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;
        //获取角色
//        $role=AdminRoles::findOne(['id'=>$role_id])->role_name;

        $data=AgentInfo::findOne(['LoginName'=>$username]);
        if($data){
            $parentid=$data->Id;
        }else{
            $parentid=-1;
        }
        if($role_id==3){//获取该运营中心下的所有服务中心
            $where.=" and a.ParentId = $parentid ";
        }

//return $role_id;
        return AgentInfo::findBySql("select a.*,b.Name as ParentName from agent_info as a JOIN agent_info as b on a.ParentId=b.Id where ".$where);

    }

    public static function pageQueryWithCondition2($username,$mobile,$province,$city,$area,$level){
        $where=" Level =".$level;
        if(!empty($username)){
            $where.=" and Name like '%$username%'";
        }
        if(!empty($mobile)){
            $where.=" and ContractTel='$mobile' ";
        }
        if(!empty($province)){
            $where.=" and Province='$province' ";
        }
        if(!empty($city)){
            $where.=" and City='$city' ";
        }
        if(!empty($area)){
            $where.=" and Area='$area' ";
        }
        return AgentInfo::findBySql("select * from agent_info where ".$where);

    }




    public static function getLatestData(){
        $dayData=self::getDatasBefore(2,4);
        $weekData=self::getWeekData(21,4);
        $monthData=self::getMonthData(60,4);

        $dayDatas=self::getDatasBefore(2,5);
        $weekDatas=self::getWeekData(21,5);
        $monthDatas=self::getMonthData(60,5);

        return ["date"=>$dayData,"week"=>$weekData,"month"=>$monthData,
                "dates"=>$dayDatas,"weeks"=>$weekDatas,"months"=>$monthDatas];

    }
    public static function getDatasBefore($dayNum,$level){
        $dayData= self::findBySql("select count(Id) as count,DATE_FORMAT(`RowTime`,'%Y%m%d') as dt from agent_info where Level=$level and DATE_SUB(CURDATE(),INTERVAL $dayNum DAY)<=RowTime GROUP BY dt")->asArray()->all();
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
    public static function getWeekData($weekNum,$level){
        $weeknow=intval(date('W'));
        $week=0;
        $weekBefore=0;
        $weekData=   self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%v') as weeks  from agent_info where Level=$level and DATE_SUB(CURDATE(),INTERVAL $weekNum DAY)<=RowTime GROUP BY weeks")->asArray()->all();
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
    public static function getMonthData($monthNum,$level){
        $monthNow=intval(date("Ym"));
        $monthDay= self::findBySql("select count(Id) as count,DATE_FORMAT(RowTime,'%Y%m') as mh  from agent_info where Level=$level and DATE_SUB(CURDATE(),INTERVAL $monthNum DAY)<=RowTime GROUP BY mh")->asArray()->all();
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

    public static function findByName($name=""){
        return self::findBySql("select * from agent_info where LoginName='$name'")->asArray()->one();
    }

}