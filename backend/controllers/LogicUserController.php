<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 17:01
 */
namespace backend\controllers;

use backend\models\Address;
use backend\models\AdminRoles;
use backend\models\AdminRoleUser;
use backend\models\AgentInfo;
use backend\models\DevFactory;
use backend\models\FactoryInfo;
use yii;
use yii\data\Pagination;

class LogicUserController extends BaseController
{


    /**
     * 设备厂家列表
     */
     public function actionDevfactoryList(){

         $username=$this->getParam("username");
         $mobile=$this->getParam("mobile");
         $province=$this->getParam("province");
         $city=$this->getParam("city");
         $area=$this->getParam("area");

         $datas = DevFactory::findWithCondition($username,$mobile,$province,$city,$area);
         $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
         $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();

         $address=(new Address())->allQuery()->asArray()->all();
         return $this->render('devfactoryList', [
             'model' => $model,
             'pages' => $pages,
             'address'=>$address,
             'username'=>empty($username)?"":$username,
             'mobile'=>empty($mobile)?"":$mobile,
             'province'=>empty($province)?"":$province,
             'city'=>empty($city)?"":$city,
             'area'=>empty($area)?"":$area,
         ]);
     }
    public function actionAgentList(){

        $datas = AgentInfo::find();
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('agentList', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }
    //县区运营中心
    public function actionAgentxlist(){
        $username=$this->getParam("username");
        $mobile=$this->getParam("mobile");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $level=4;//县区运营中心
        $datas = AgentInfo::pageQueryWithCondition($username,$mobile,$province,$city,$area,$level);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        //县级代理
        return $this->render('agentList', [
            'model' => $model,
            'pages' => $pages,
            'level'=>$level,
            'address'=>$address,
            'username'=>empty($username)?"":$username,
            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
        ]);
    }

    //社区服务中心
    public function actionAgentslist(){
        $username=$this->getParam("username");
        $mobile=$this->getParam("mobile");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $level=5;//社区服务中心
        $datas =AgentInfo::pageQueryWithCondition($username,$mobile,$province,$city,$area,$level);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;
        //获取角色
        $role=AdminRoles::findOne(['id'=>$role_id])->role_name;

//        var_dump($role);exit;



        //县级代理
        return $this->render('agentList2', [
            'role' => $role,
            'model' => $model,
            'pages' => $pages,
            'level'=>$level,
            'address'=>$address,
            'username'=>empty($username)?"":$username,
            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
        ]);
    }
    public function actionFactoryList(){
        $username=$this->getParam("username");
        $mobile=$this->getParam("mobile");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $datas = FactoryInfo::findWithCondition($username,$mobile,$province,$city,$area);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
//var_dump($model);exit;
        //获取每个水厂剩余条码数最少的品牌
        $least=yii\db\ActiveRecord::findBySql('select * from (select * from factory_wcode ORDER BY LeftAmount ASC ) as tamp GROUP BY Fid ')->asArray()->all();
        $BrandName=[];
        $LeftAmount=[];
        foreach($least as $v){

            if($v['WaterBrand']){
//                var_dump($v['Fid']);exit;
                //根据WaterBrand获取品牌名称
                $data=yii\db\ActiveRecord::findBySql("select BrandName from water_brand where BrandNo='{$v['WaterBrand']}'")->asArray()->all();
//                var_dump($data[0]['BrandName']);exit;
//                $brandname[$v['Fid']]=$data[0]['BrandName'];
//                $least[$v['Fid']]=$v['LeftAmount'];
                $BrandName[$v['Fid']]=$data[0]['BrandName'];
                $LeftAmount[$v['Fid']]=$v['LeftAmount'];

            }
        }
//        var_dump($BrandName);exit;

        return $this->render('factoryList', [
            'BrandName'=>$BrandName,
            'LeftAmount'=>$LeftAmount,
            'model' => $model,
            'pages' => $pages,
            'address'=>$address,
            'username'=>empty($username)?"":$username,
            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,

        ]);
    }

    //服务中心操作详情
    public function actionActiveLog(){

    }


}