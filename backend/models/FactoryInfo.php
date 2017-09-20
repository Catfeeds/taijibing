<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午12:55
 */

namespace backend\models;


use yii\db\ActiveRecord;

class FactoryInfo extends  ActiveRecord
{
    public static function tableName()
    {
        return 'factory_info';
    }
    //修改时用的
    public  function insertBaseInfo2($Admin_User_Id,$loginName='',$Name,$Address,$ContractTel,
         $ContractUser,$Province,$City,$Area,$BaiDuLng,$BaiDuLat){
        $this->setAttribute("Admin_User_Id",$Admin_User_Id);
        $this->setAttribute("LoginName",$loginName);
        $this->setAttribute("Address",$Address);
        $this->setAttribute("ContractTel",$ContractTel);
        $this->setAttribute("ContractUser",$ContractUser);
        $this->setAttribute("Province",$Province);
        $this->setAttribute("City",$City);
        $this->setAttribute("Area",$Area);
        $this->setAttribute("BaiDuLng",$BaiDuLng);
        $this->setAttribute("BaiDuLat",$BaiDuLat);
//        $this->setAttribute("LoginPwd",md5($pwd));
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
//        $this->setAttribute("Level",1);
//        $this->setAttribute("PreCode",$this->getMaxprecode());
        $this->setAttribute("Name",$Name);
        $this->setScenario("update");
        return $this->save(false);
    }
    //创建时用的
    public  function insertBaseInfo($Admin_User_Id,$loginName='',$Name,$Address,$ContractTel,
                                    $ContractUser,$Province,$City,$Area,$BaiDuLng,$BaiDuLat,$pwd=''){
        $this->setAttribute("Admin_User_Id",$Admin_User_Id);
        $this->setAttribute("LoginName",$loginName);
        $this->setAttribute("Address",$Address);
        $this->setAttribute("ContractTel",$ContractTel);
        $this->setAttribute("ContractUser",$ContractUser);
        $this->setAttribute("Province",$Province);
        $this->setAttribute("City",$City);
        $this->setAttribute("Area",$Area);
        $this->setAttribute("BaiDuLng",$BaiDuLng);
        $this->setAttribute("BaiDuLat",$BaiDuLat);
        $this->setAttribute("LoginPwd",md5($pwd));
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
        $this->setAttribute("Level",1);
        $this->setAttribute("PreCode",$this->getMaxprecode());
        $this->setAttribute("Name",$Name);
        $this->setScenario("create");
        return $this->save(false);
    }
    public function getMaxprecode(){
        $precodeRes=$this->findBySql("select max(factory_info.`PreCode`) as precode from `factory_info` ")->asArray()->one();
        $precode=intval($precodeRes["precode"])+1;
        $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
        return $precode;
    }
    public function rules()
    {
        return [
            [['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat', 'PreCode','WaterBrandNo','Level'], 'required'],
        ];
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
            'PreCode'=>'厂家代码(数字代号)',
            'WaterBrandNo'=>'水品牌'
        ];
    }
    public function scenarios()
    {
        return [
            'default' => ['Name', 'ContractTel','ContractUser','Address','PreCode','WaterBrandNo','Level','Province','City','Area','BaiDuLat','BaiDuLng'],
            'create' => ['LoginName', 'LoginPwd','RowTime','WaterBrandNo','Level'],
            'update' => ['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat'],

        ];
    }
    public static function findByName($name=""){
       return self::findBySql("select * from factory_info where LoginName='$name'")->asArray()->one();
    }
    public static function findWithCondition($username,$mobile,$province,$city,$area){
            $where='';
            if(!empty($username)){
                $where.=" Name like '%$username%'";
            }
            if(!empty($mobile)){
                if(!empty($where)){
                    $where.=" and ";
                }
                $where.="ContractTel='$mobile' ";
            }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Province='$province' ";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="City='$city' ";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Area='$area' ";
        }

        //根据登陆者的信息，获取登陆者的角色
        $login_id=\Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;
        //获取角色
//        $role=AdminRoles::findOne(['id'=>$role_id])->role_name;


        //如果是水厂登陆，只显示对应的水厂
        if($role_id==2){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="Admin_User_id= '$login_id' ";
        }




        return self::findBySql("select * from factory_info ".(empty($where)?"":" where ".$where));


    }
}