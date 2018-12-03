<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 2017/9/13
 * Time: 下午2:46
 */

namespace backend\models;


use yii\db\ActiveRecord;
use backend\models\AgentInfo;
use backend\models\FactoryInfo;
use backend\models\DevFactory;

class LogicUserInfo extends ActiveRecord
{

    public static function getNickNameByRoleType($model){
        if($model->logic_type==0){
            return $model->username;
        }
        return self::getUserName($model);
    }
    public static function getAddressDes($model){
        if($model->logic_type==0){
            return "--";
        }
        return self::getUserAddr($model);
    }
    public static function getLogicModel($model){
        switch($model->logic_type){
            case 0:$obj= null;break;
            //水厂
            case 1:$obj= FactoryInfo::findByName($model->username);break;
            //设备厂家
            case 2:$obj=DevFactory::findByName($model->username);break;
            case 3:
            case 4://代理服务商
                $obj=AgentInfo::findByName($model->username);break;
            case 5://设备投资商
                $obj=AgentInfo::findByName($model->username);break;

        }
        return $obj;
    }
    public static function getUserAddr($model){
        $obj=  self::getLogicModel($model);
        return $obj['Province'].'-'.$obj['City'].'-'.$obj['Area'];
    }
    public static function getUserName($model){
        $obj=  self::getLogicModel($model);
        return $obj['Name'];
    }


}