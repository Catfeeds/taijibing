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
        $this->setAttribute("Name",$Name);
        $this->setAttribute("RowTime",date("Y-m-d H:i:s"));
        return $this->save(false);
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
        ];
    }
    public static function findWithCondition($username,$mobile,$province,$city,$area){
        $where='';
        if(!empty($username)){
            $where.=" Name='$username'";
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
        return self::findBySql("select * from dev_factory ".(empty($where)?"":" where ".$where));


    }

}