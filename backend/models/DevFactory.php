<?php
/**
 * 设备厂家
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/8
 * Time: 下午1:07
 */

namespace backend\models;


use yii\db\ActiveRecord;

class DevFactory extends ActiveRecord
{
    public static function tableName()
    {
        return 'dev_factory';
    }
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
        $this->setAttribute("Name",$Name);
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
        return $this->save(false);
    }

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
        $this->setAttribute("Name",$Name);
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
        $this->setAttribute("Number",$number);
        $this->setAttribute("PreCode",$precode);
        return $this->save(false);
    }
    public function getMaxprecode($City){
        $precodeRes=$this->findBySql("select max(dev_factory.`PreCode`) as precode from `dev_factory` where City='$City' ")->asArray()->one();
        $precode=intval($precodeRes["precode"])+1;
        $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
        return $precode;
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
            'Type'=>'设备型号',
            'CardFactory'=>'卡片厂家',
        ];
    }
    public function scenarios()
    {
        return [
            'default' => ['Name', 'ContractTel','ContractUser','Address','Type','CardFactory','Province','City','Area','BaiDuLat','BaiDuLng'],
            'update' => ['LoginName','Name', 'ContractTel','ContractUser','Address','Type','CardFactory','Province','City','Area','BaiDuLat','BaiDuLng'],
        ];
    }
    public static function findWithCondition($username,$mobile,$province,$city,$area,$sort){
        $where='';
        if(!empty($username)){
            $where.=" Name like '%$username%'";
        }
        if(!empty($mobile)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="ContractTel like '%$mobile%' ";
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

        if($sort && $sort%2==0){//偶数 降序
            return self::findBySql("select * from dev_factory ".(empty($where)?"":" where ".$where)."order by RowTime asc");
        }

        return self::findBySql("select * from dev_factory ".(empty($where)?"":" where ".$where)."order by RowTime desc");


    }


    public static function findByName($name=""){
        return self::findBySql("select * from dev_factory where LoginName='$name'")->asArray()->one();
    }


}