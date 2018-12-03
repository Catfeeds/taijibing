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
                                    $ContractUser,$Province,$City,$Area,$BaiDuLng,$BaiDuLat,$pwd='',$precode,$number){
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
        $this->setAttribute("Code",$precode);
        $this->setAttribute("Name",$Name);
        $this->setAttribute("Number",$number);
        $this->setScenario("create");
        return $this->save(false);
    }
    public function getMaxprecode(){
        $precodeRes=$this->findBySql("select max(factory_info.`PreCode`) as precode from `factory_info`")->asArray()->one();
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
            'create' => ['LoginName', 'LoginPwd','RowTime','WaterBrandNo','Level','Number'],
            'update' => ['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat'],

        ];
    }
    public static function findByName($name=""){
       return self::findBySql("select * from factory_info where LoginName='$name'")->asArray()->one();
    }
    public static function findWithCondition($water_brand,$water_name,$username,$mobile,$province,$city,$area,$sort){
            $where='';
            if(!empty($username)){
                $where.=" factory_info.Name like '%$username%'";
            }
        if(!empty($water_brand)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" brands.BrandName ='$water_brand'";
        }
        if(!empty($water_name)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" goods.name = '$water_name'";
        }
            if(!empty($mobile)){
                if(!empty($where)){
                    $where.=" and ";
                }
                $where.=" factory_info.ContractTel='$mobile' ";
            }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" factory_info.Province='$province' ";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" factory_info.City='$city' ";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" factory_info.Area='$area' ";
        }

        //根据登陆者的信息，获取登陆者的id
        $login_id=\Yii::$app->user->id;
        $LoginName=ActiveRecord::findBySql("select username from admin_user where Id=$login_id")->asArray()->one()['username'];
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;


        //如果是水厂登陆，只显示对应的水厂
        if($role_id==2){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="LoginName= '$LoginName' ";
        }

        $order=" order by  RowTime desc ";
        if($sort && $sort%2==1){// 升序
            $order=" order by  RowTime asc ";
        }


//        return self::findBySql("select * from factory_info ".(empty($where)?"":" where ".$where)."$order");
        return self::findBySql("select factory_info.*,factory_wcode.LeftAmount,
factory_wcode.Fid,factory_wcode.Volume,factory_wcode.WaterBrand,
factory_wcode.GoodsId,brands.BrandName,goods.name as goodsname
from factory_info
left join factory_wcode on factory_wcode.Fid=factory_info.Id
left join brands on factory_wcode.WaterBrand=brands.BrandNo
left join goods on factory_wcode.GoodsId=goods.id
".(empty($where)?"":" where ".$where)."$order");


    }
}