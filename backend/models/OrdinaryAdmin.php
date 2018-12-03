<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\ForbiddenHttpException;


class OrdinaryAdmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ordinary_admin';
    }



    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['Name', 'ContractTel','ContractUser','Address','ParentId','Level','Province','City','Area','BaiDuLat','BaiDuLng'],
            'create' => ['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat'],
            'update' => ['LoginName','Name', 'ContractTel','ContractUser','Address','Province','City','Area','RowTime','BaiDuLng','BaiDuLat'],
        ];
    }



    public static function getRoleNameByUid($uid = '')
    {
        if( $uid == '' ) $uid = yii::$app->getUser()->getIdentity()->getId();
        $role_id = AdminRoleUser::getRoleId($uid);
        $data = self::findOne(['id'=>$role_id]);
        return isset($data->role_name) ? $data->role_name : null;
    }

//    public function beforeDelete()
//    {
//        if($this->id == 1) throw new ForbiddenHttpException(yii::t('app', 'Not allowed to delete {attribute}', ['attribute'=>yii::t('app', 'super administrator roles')]));
//        return true;
//    }

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

}