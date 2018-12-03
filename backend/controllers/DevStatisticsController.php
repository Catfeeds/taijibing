<?php
namespace backend\controllers;
//设备统计
use backend\models\AdminRoleUser;
use yii\db\ActiveRecord;
class DevStatisticsController extends BaseController{

    //设备统计首页
    public function actionIndex(){
        if(\Yii::$app->getUser()->isGuest){
            return $this->redirect(['site/login']);
        }
        $urlobj = $this->getParam("Url");//返回参数记录
        //如果是管理员查看某个对象的统计信息(需要带的参数)
        $LoginName=$this->getParam('LoginName');
        $role_id=$this->getParam('role_id');
        if(!$LoginName||!$role_id){
            //获取登陆角色id
            $id=\Yii::$app->user->getId();
            $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;
            //登陆名称
            $LoginName = ActiveRecord::findBySql("select username from admin_user where id=$id")->asArray()->one()['username'];

        }

        if($role_id==1){
            return $this->render('index',['role_id'=>$role_id,'LoginName'=>$LoginName]);
        }else{
            return $this->render('index2',['role_id'=>$role_id,'LoginName'=>$LoginName,'url'=>$urlobj]);
        }
    }


    //设备统计概况
    public function actionSalesDetail(){

        //如果是管理员查看某个对象的统计信息(需要带的参数)
        $LoginName=$this->getParam('LoginName');
        $role_id=$this->getParam('role_id');
        if(!$LoginName || !$role_id){//对应角色自己登陆

            if(\Yii::$app->getUser()->isGuest){
                return $this->redirect(['site/login']);
            }
            $id=\Yii::$app->user->getId();
            //获取登陆角色id
            $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;
            //登陆名称
            $LoginName = ActiveRecord::findBySql("select username from admin_user where id=$id")->asArray()->one()['username'];
        }


        $model=[];
        $dev_register=0;//新注册设备
        $dev_init=0;//注销设备
        $dev_total=0;//累计设备数
        //新注册设备
        $add_today=0;//今天、
        $add_yesterday=0;//昨天
        $add_seven_days=0;//近7天、
        $add_fourteen_days=0;//近14天到近7天
        $add_thirty_days=0;//近30天、
        $add_sixty_days=0;//近60天到近30天
        //注销设备
        $init_today=0;//今天、
        $init_yesterday=0;//昨天
        $init_seven_days=0;//近7天、
        $init_fourteen_days=0;//近14天到近7天
        $init_thirty_days=0;//近30天、
        $init_sixty_days=0;//近60天到近30天

        $date_before1=date('Y-m-d',strtotime('-59 day'));//倒退60天的日期
        $date_before2=date('Y-m-d',strtotime('-29 day'));//倒退30天的日期
        $date_before3=date('Y-m-d',strtotime('-6 day'));//倒退7天的日期
        $date_before4=date('Y-m-d',strtotime('-13 day'));//倒退14天的日期
        $date_yesterday=date('Y-m-d',strtotime('-1 day'));//昨天的日期
        $date_today=date('Y-m-d',time());//今天的日期

        if($role_id==1){//超级管理员
            //近7天的设备数量----------------------
            //1、新注册设备数
            $dev_register=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before3' and AgentId > 0 and IsActive=1
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备数
            $dev_init=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //3、累计设备数
            $dev_total=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and IsActive=1
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //----------------------

            //同期比-----------------
            //1、新注册设备
            //今天
            $add_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_today' and AgentId > 0 and IsActive=1
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $add_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_yesterday' and RowTime < '$date_today' and AgentId > 0 and IsActive=1
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $add_seven_days=$dev_register;
            //近14天到近7天
            $add_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before4' and RowTime < '$date_before3' and AgentId > 0 and IsActive=1
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $add_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before2' and AgentId > 0 and IsActive=1
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $add_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before1' and RowTime < '$date_before2' and AgentId > 0 and IsActive=1
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备
            //今天
            $init_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_today' and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $init_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_yesterday' and RowTime < '$date_today' and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $init_seven_days=$dev_init;
            //近14天到近7天
            $init_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before4' and RowTime < '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $init_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before2' and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $init_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before1' and RowTime < '$date_before2'
            and DevNo=dev_regist.DevNo )")->count();

//            //3、累计设备数
//            //今天
//            $total_today=ActiveRecord::findBySql("select DevNo from dev_regist
//            where AgentId > 0 and IsActive=1
//            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
//            //昨天
//            $total_yesterday=ActiveRecord::findBySql("select DevNo from dev_regist
//            where RowTime < '$date_today' and AgentId > 0 and IsActive=1
//            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
//
//            //近7天
//            $total_seven_days=$dev_register;
//            //近14天
//            $add_fourteen_days=ActiveRecord::findBySql("select DevNo from dev_regist
//            where RowTime < '$date_before3' and AgentId > 0 and IsActive=1
//            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
//
//            //近30天
//            $total_thirty_days=ActiveRecord::findBySql("select DevNo from dev_regist
//            where RowTime > '$date_before2' and AgentId > 0 and IsActive=1
//            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
//            //近60天到近30天
//            $total_sixty_days=ActiveRecord::findBySql("select DevNo from dev_regist
//            where RowTime > '$date_before1' and RowTime < '$date_before2' and AgentId > 0 and IsActive=1
//            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
//


        }
        if($role_id==2){//水厂

            $factory=ActiveRecord::findBySql("select PreCode,Id from factory_info where LoginName='$LoginName'")->asArray()->one();
            //水厂代码
            $PreCode=$factory['PreCode'];
            //水厂id
            $factory_id=$factory['Id'];

            //近7天的设备数量----------------------
            //1、新扫码设备
            $dev_register=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where RowTime > '$date_before3' and AgentId > 0 and PreCode='$PreCode'
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->count();

            //2、注销设备数
            $dev_init=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where AgentId > 0 and PreCode='$PreCode'
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_before3' and DevNo=dev_water_scan.DevNo )")->count();

            //3、累计设备数
            $dev_total=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where AgentId > 0 and PreCode='$PreCode'
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //----------------------

            //同期比-----------------
            //1、新注册设备
            //今天
            $add_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where RowTime > '$date_today' and AgentId > 0 and PreCode='$PreCode'
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->count();
            //昨天
            $add_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where RowTime > '$date_yesterday' and RowTime < '$date_today' and AgentId > 0 and PreCode='$PreCode'
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->count();

            //近7天
            $add_seven_days=$dev_register;
            //近14天到近7天
            $add_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where RowTime > '$date_before4' and RowTime < '$date_before3' and AgentId > 0 and PreCode='$PreCode'
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->count();

            //近30天
            $add_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where RowTime > '$date_before2' and AgentId > 0 and PreCode='$PreCode'
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->count();
            //近60天到近30天
            $add_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where RowTime > '$date_before1' and RowTime < '$date_before2' and AgentId > 0 and PreCode='$PreCode'
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->count();

            //2、注销设备
            //今天
            $init_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where AgentId > 0 and PreCode='$PreCode'
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_today' and DevNo=dev_water_scan.DevNo )")->count();
            //昨天
            $init_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where AgentId > 0 and PreCode='$PreCode'
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_yesterday' and RowTime < '$date_today' and DevNo=dev_water_scan.DevNo )")->count();

            //近7天
            $init_seven_days=$dev_init;
            //近14天到近7天
            $init_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where AgentId > 0 and PreCode='$PreCode'
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_before4' and RowTime < '$date_before3' and DevNo=dev_water_scan.DevNo )")->count();

            //近30天
            $init_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where AgentId > 0 and PreCode='$PreCode'
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_before2' and DevNo=dev_water_scan.DevNo )")->count();
            //近60天到近30天
            $init_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_water_scan
            where AgentId > 0 and PreCode='$PreCode'
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_before1' and RowTime < '$date_before2' and DevNo=dev_water_scan.DevNo )")->count();


        }

        if($role_id==3){//运营中心
            //运营中心的id 以及下面的所有服务中心的id
            //1直属运营中心下的服务中心 + 2运营中心下的所有片区中心下的服务中心
            $agent_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName'")->asArray()->one()['Id'];

            //近7天的设备数量----------------------
            //1、新注册设备数
            $dev_register=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before3' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备数
            $dev_init=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where  AgentId > 0
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //3、累计设备数
            $dev_total=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //----------------------

            //同期比-----------------
            //1、新注册设备
            //今天
            $add_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_today' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $add_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_yesterday' and RowTime < '$date_today' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $add_seven_days=$dev_register;
            //近14天到近7天
            $add_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before4' and RowTime < '$date_before3' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $add_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before2' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $add_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before1' and RowTime < '$date_before2' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备
            //今天
            $init_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_today' and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $init_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_yesterday' and RowTime < '$date_today' and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $init_seven_days=$dev_init;
            //近14天到近7天
            $init_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before4' and RowTime < '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $init_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before2' and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $init_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before1' and RowTime < '$date_before2' and DevNo=dev_regist.DevNo )")->count();


        }

        if($role_id==4){//设备厂家
            //设备厂家id
            $dev_factory_id=ActiveRecord::findBySql("select Id from dev_factory where LoginName='$LoginName'")->asArray()->one()['Id'];

            //近7天的设备数量----------------------
            //1、新注册设备数
            $dev_register=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.RowTime > '$date_before3' and dev_regist.AgentId > 0
            and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备数
            $dev_init=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.AgentId > 0
            and dev_factory.Id=$dev_factory_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //3、累计设备数
            $dev_total=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where  dev_regist.AgentId > 0
            and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //----------------------

            //同期比-----------------
            //1、新注册设备
            //今天
            $add_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.RowTime > '$date_today' and dev_regist.AgentId > 0
            and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //昨天
            $add_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.RowTime > '$date_yesterday'  and dev_regist.RowTime < '$date_today'
            and dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $add_seven_days=$dev_register;
            //近14天到近7天
            $add_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.RowTime > '$date_before4'  and dev_regist.RowTime < '$date_before3'
            and dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $add_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.RowTime > '$date_before2'
            and dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近60天到近30天
            $add_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.RowTime > '$date_before1' and dev_regist.RowTime < '$date_before2'
            and dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备
            //今天
            $init_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_today' and DevNo=dev_regist.DevNo )")->count();

            //昨天
            $init_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_yesterday' and RowTime < '$date_today' and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $init_seven_days=$dev_init;
            //近14天到近7天
            $init_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before4' and RowTime < '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $init_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before2' and DevNo=dev_regist.DevNo )")->count();

            //近60天到近30天
            $init_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            inner join investor on investor.agent_id=dev_regist.investor_id
            and investor.goods_id=dev_regist.goods_id
            inner join dev_factory on dev_factory.Id=investor.factory_id
            where dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before1'  and RowTime < '$date_before2' and DevNo=dev_regist.DevNo )")->count();


        }

        if($role_id==5||$role_id==10){//服务中心或酒店中心
            //服务中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName'")->asArray()->one()['Id'];

            //近7天的设备数量----------------------
            //1、新注册设备数
            $dev_register=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before3' and AgentId > 0 and IsActive=1 and AgentId=$agent_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备数
            $dev_init=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and AgentId=$agent_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //3、累计设备数
            $dev_total=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and IsActive=1 and AgentId=$agent_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //----------------------

            //同期比-----------------
            //1、新注册设备
            //今天
            $add_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_today' and AgentId > 0 and IsActive=1 and AgentId=$agent_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $add_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_yesterday' and RowTime < '$date_today' and AgentId > 0
            and IsActive=1 and AgentId=$agent_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $add_seven_days=$dev_register;
            //近14天到近7天
            $add_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before4' and RowTime < '$date_before3'
            and AgentId > 0 and IsActive=1 and AgentId=$agent_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $add_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before2' and AgentId > 0
            and IsActive=1 and AgentId=$agent_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $add_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before1' and RowTime < '$date_before2'
            and AgentId > 0 and IsActive=1 and AgentId=$agent_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备
            //今天
            $init_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and AgentId=$agent_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_today' and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $init_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and AgentId=$agent_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_yesterday' and RowTime < '$date_today' and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $init_seven_days=$dev_init;
            //近14天到近7天
            $init_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and AgentId=$agent_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before4' and RowTime < '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $init_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and AgentId=$agent_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before2' and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $init_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and AgentId=$agent_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before1' and RowTime < '$date_before2' and DevNo=dev_regist.DevNo )")->count();

        }

        if($role_id==6){//设备投资商
            //设备投资商的id
            $investor_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName' and `Level`=6")->asArray()->one()['Id'];

            //近7天的设备数量----------------------
            //1、新注册设备数
            $dev_register=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before3' and AgentId > 0 and IsActive=1 and investor_id=$investor_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备数
            $dev_init=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and investor_id=$investor_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //3、累计设备数
            $dev_total=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and IsActive=1 and investor_id=$investor_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //----------------------

            //同期比-----------------
            //1、新注册设备
            //今天
            $add_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_today' and AgentId > 0 and IsActive=1 and investor_id=$investor_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $add_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_yesterday' and RowTime < '$date_today' and AgentId > 0
            and IsActive=1 and investor_id=$investor_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $add_seven_days=$dev_register;
            //近14天到近7天
            $add_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before4' and RowTime < '$date_before3'
            and AgentId > 0 and IsActive=1 and investor_id=$investor_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $add_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before2' and AgentId > 0
            and IsActive=1 and investor_id=$investor_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $add_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before1' and RowTime < '$date_before2'
            and AgentId > 0 and IsActive=1 and investor_id=$investor_id
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备
            //今天
            $init_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and investor_id=$investor_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_today' and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $init_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and investor_id=$investor_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_yesterday' and RowTime < '$date_today' and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $init_seven_days=$dev_init;
            //近14天到近7天
            $init_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and investor_id=$investor_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before4' and RowTime < '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $init_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and investor_id=$investor_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before2' and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $init_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and investor_id=$investor_id
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before1' and RowTime < '$date_before2' and DevNo=dev_regist.DevNo )")->count();

        }

        if($role_id==7){//片区中心
            //运营中心的id 以及下面的所有服务中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName'")->asArray()->one()['Id'];

            //近7天的设备数量----------------------
            //1、新注册设备数
            $dev_register=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before3' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备数
            $dev_init=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where  AgentId > 0
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and  RowTime > '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //3、累计设备数
            $dev_total=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //----------------------

            //同期比-----------------
            //1、新注册设备
            //今天
            $add_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_today' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $add_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_yesterday' and RowTime < '$date_today' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $add_seven_days=$dev_register;
            //近14天到近7天
            $add_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before4' and RowTime < '$date_before3' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $add_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before2' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $add_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where RowTime > '$date_before1' and RowTime < '$date_before2' and AgentId > 0 and IsActive=1
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->count();

            //2、注销设备
            //今天
            $init_today=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_today' and DevNo=dev_regist.DevNo )")->count();
            //昨天
            $init_yesterday=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_yesterday' and RowTime < '$date_today' and DevNo=dev_regist.DevNo )")->count();

            //近7天
            $init_seven_days=$dev_init;
            //近14天到近7天
            $init_fourteen_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before4' and RowTime < '$date_before3' and DevNo=dev_regist.DevNo )")->count();

            //近30天
            $init_thirty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before2' and DevNo=dev_regist.DevNo )")->count();
            //近60天到近30天
            $init_sixty_days=ActiveRecord::findBySql("select DISTINCT DevNo from dev_regist
            where AgentId > 0
            and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
            and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
            and RowTime > '$date_before1' and RowTime < '$date_before2' and DevNo=dev_regist.DevNo )")->count();


        }


        $model=[
            'dev_register'=>$dev_register,//新注册设备
            'dev_init'=>$dev_init,//注销设备
            'dev_total'=>$dev_total,//累计设备数
            //新注册设备
            'add_today'=>$add_today,//今天、
            'add_yesterday'=>$add_yesterday,//昨天
            'add_seven_days'=>$add_seven_days,//近7天、
            'add_fourteen_days'=>$add_fourteen_days,//近14天到近7天
            'add_thirty_days'=>$add_thirty_days,//近30天、
            'add_sixty_days'=>$add_sixty_days,//近60天到近30天
            //注销设备
            'init_today'=>$init_today,//今天、
            'init_yesterday'=>$init_yesterday,//昨天
            'init_seven_days'=>$init_seven_days,//近7天、
            'init_fourteen_days'=>$init_fourteen_days,//近14天到近7天
            'init_thirty_days'=>$init_thirty_days,//近30天、
            'init_sixty_days'=>$init_sixty_days,//近60天到近30天
        ];

        return json_encode($model);


    }

    //销量情况(折线)
    public function actionSalesDetailLine(){
        $starttime1=$this->getParam('starttime');//开始时间
        $endtime1=$this->getParam('endtime');//结束时间
        $dev_state=$this->getParam('dev_state');//设备类型（1新注册设备，2注销设备，3净增设备，4累计设备数）
        $LoginName=$this->getParam('LoginName');//登陆名称
        $role_id=$this->getParam('role_id');//角色id

        if(!$starttime1||!$endtime1){//默认近7天
            $starttime=date('Y-m-d',strtotime('-6 day'));
            $endtime=date('Y-m-d H:i:s',time());
        }else{
            $starttime=$starttime1;
            $endtime=$endtime1.' 23:59:59';//接收时间处理一下
        }
        if(!$dev_state)$dev_state=1;//默认：1新注册设备


        if(!$LoginName || !$role_id){

            if(\Yii::$app->getUser()->isGuest){
                return $this->redirect(['site/login']);
            }

            //根据登陆的角色获取销量数据
            //获取登陆角色id
            $id=\Yii::$app->user->getId();
            $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;
            //登陆名称
            $LoginName = ActiveRecord::findBySql("select username from admin_user where id=$id")->asArray()->one()['username'];
        }
        $line_datas=[];
        $where_data=['starttime'=>$starttime1,'endtime'=>$endtime1];//已选条件数据
        if($role_id==1){//超级管理员

            if($dev_state==1){//新注册设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,Province,City,Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==2){//2注销设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==3){//3净增设备
                //新注册设备
                $line_datas1=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,Province,City,Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
                ////注销设备
                $line_datas2=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();

                $line_datas=['add'=>$line_datas1,'init'=>$line_datas2];
            }


        }
        if($role_id==2){//水厂
            //获取扫过该水厂条码的所有用户
            //获取该水厂的编号
            $PreCode=ActiveRecord::findBySql("select PreCode from factory_info
where LoginName='$LoginName'")->asArray()->one()['PreCode'];

            if($dev_state==1){//新注册设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_water_scan.DevNo,dev_regist.CustomerType,dev_regist.UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,dev_water_scan.RowTime from dev_water_scan
                inner join dev_regist on dev_regist.DevNo=dev_water_scan.DevNo
                where dev_water_scan.RowTime > '$starttime' and dev_water_scan.RowTime < '$endtime'
                and dev_water_scan.AgentId > 0 and dev_water_scan.PreCode='$PreCode'
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->asArray()->all();
            }
            if($dev_state==2){//2注销设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_water_scan.DevNo,dev_regist.CustomerType,dev_regist.UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_water_scan
                 inner join dev_regist on dev_regist.DevNo=dev_water_scan.DevNo
                 left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_water_scan.DevNo
                where dev_water_scan.AgentId > 0 and dev_water_scan.PreCode='$PreCode'
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_water_scan.DevNo )")->asArray()->all();
            }
            if($dev_state==3){//3净增设备
                //新注册设备
                $line_datas1=ActiveRecord::findBySql("select DISTINCT dev_water_scan.DevNo,dev_regist.CustomerType,dev_regist.UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,dev_water_scan.RowTime from dev_water_scan
                inner join dev_regist on dev_regist.DevNo=dev_water_scan.DevNo
                where dev_water_scan.RowTime > '$starttime' and dev_water_scan.RowTime < '$endtime'
                and dev_water_scan.AgentId > 0 and dev_water_scan.PreCode='$PreCode'
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_water_scan.DevNo )")->asArray()->all();
                ////注销设备
                $line_datas2=ActiveRecord::findBySql("select DISTINCT dev_water_scan.DevNo,dev_regist.CustomerType,dev_regist.UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_water_scan
                inner join dev_regist on dev_regist.DevNo=dev_water_scan.DevNo
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_water_scan.DevNo
                where dev_water_scan.AgentId > 0 and dev_water_scan.PreCode='$PreCode'
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_water_scan.DevNo )")->asArray()->all();
                $line_datas=['add'=>$line_datas1,'init'=>$line_datas2];
            }

        }
        if($role_id==3){//运营中心
            //获取该运营中心下的所有用户扫码数据
            //获取该运营中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info
where LoginName='$LoginName' and `Level`=4")->asArray()->one()['Id'];

            if($dev_state==1){//新注册设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime
                from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1
                and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==2){//2注销设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0
                and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==3){//3净增设备
                //新注册设备
                $line_datas1=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1
                and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
                ////注销设备
                $line_datas2=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0
                and (AgentId=$agent_id or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
                $line_datas=['add'=>$line_datas1,'init'=>$line_datas2];
            }


        }
        if($role_id==4){//设备厂家

            //获取该运营中心下的所有用户扫码数据
            //获取该设备厂家的id
            $dev_factory_id=ActiveRecord::findBySql("select Id from dev_factory
where LoginName='$LoginName'")->asArray()->one()['Id'];

            if($dev_state==1){//新注册设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,dev_regist.CustomerType,dev_regist.UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.RowTime from dev_regist
                inner join investor on investor.agent_id=dev_regist.investor_id
                and investor.goods_id=dev_regist.goods_id
                inner join dev_factory on dev_factory.Id=investor.factory_id
                where dev_regist.RowTime > '$starttime' and dev_regist.RowTime < '$endtime'
                and dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==2){//2注销设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                inner join investor on investor.agent_id=dev_regist.investor_id
                and investor.goods_id=dev_regist.goods_id
                inner join dev_factory on dev_factory.Id=investor.factory_id
                where dev_regist.AgentId > 0 and dev_factory.Id=$dev_factory_id
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==3){//3净增设备
                //新注册设备
                $line_datas1=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,dev_regist.CustomerType,dev_regist.UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.RowTime from dev_regist
                inner join investor on investor.agent_id=dev_regist.investor_id
                and investor.goods_id=dev_regist.goods_id
                inner join dev_factory on dev_factory.Id=investor.factory_id
                where dev_regist.RowTime > '$starttime' and dev_regist.RowTime < '$endtime'
                and dev_regist.AgentId > 0 and dev_regist.IsActive=1 and dev_factory.Id=$dev_factory_id
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
                ////注销设备
                $line_datas2=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                inner join investor on investor.agent_id=dev_regist.investor_id
                and investor.goods_id=dev_regist.goods_id
                inner join dev_factory on dev_factory.Id=investor.factory_id
                where dev_regist.AgentId > 0 and dev_factory.Id=$dev_factory_id
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
                $line_datas=['add'=>$line_datas1,'init'=>$line_datas2];
            }

        }
        if($role_id==5||$role_id==10){//服务中心或酒店中心
            //获取该服务中心下的所有用户扫码数据
            //获取该服务中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info
where LoginName='$LoginName'")->asArray()->one()['Id'];

            if($dev_state==1){//新注册设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1 and AgentId=$agent_id
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==2){//2注销设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0 and AgentId=$agent_id
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==3){//3净增设备
                //新注册设备
                $line_datas1=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1 and AgentId=$agent_id
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
                ////注销设备
                $line_datas2=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0 and AgentId=$agent_id
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
                $line_datas=['add'=>$line_datas1,'init'=>$line_datas2];
            }
        }
        if($role_id==6){//设备投资商
            //设备投资商的id
            $investor_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName' and `Level`=6")->asArray()->one()['Id'];

            if($dev_state==1){//新注册设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1 and investor_id=$investor_id
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==2){//2注销设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0 and investor_id=$investor_id
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==3){//3净增设备
                //新注册设备
                $line_datas1=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1 and investor_id=$investor_id
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
                ////注销设备
                $line_datas2=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0 and investor_id=$investor_id
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
                $line_datas=['add'=>$line_datas1,'init'=>$line_datas2];
            }

        }
        if($role_id==7){//片区中心
            //获取该片区中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info
where LoginName='$LoginName' and `Level`=7")->asArray()->one()['Id'];

            if($dev_state==1){//新注册设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1
                and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==2){//2注销设备
                $line_datas=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0
                and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
            }
            if($dev_state==3){//3净增设备
                //新注册设备
                $line_datas1=ActiveRecord::findBySql("select DISTINCT DevNo,CustomerType,UseType,
                dev_regist.Province,dev_regist.City,dev_regist.Area,RowTime from dev_regist
                where RowTime > '$starttime' and RowTime < '$endtime'
                and AgentId > 0 and IsActive=1
                and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
                and not exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1 and DevNo=dev_regist.DevNo )")->asArray()->all();
                ////注销设备
                $line_datas2=ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.Province,
                dev_regist.City,dev_regist.Area,dev_cmd.RowTime
                from dev_regist
                left join (select DevNo,RowTime from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' group by DevNo)as dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
                where AgentId > 0
                and (AgentId=$agent_id or AgentId in (select b.Id from agent_info as a
LEFT JOIN agent_info as b ON b.ParentId=a.Id
where a.LoginName='$LoginName') )
                and exists (select 1 from dev_cmd where dev_cmd.CmdType=4 and State=1
                and RowTime > '$starttime' and RowTime < '$endtime' and DevNo=dev_regist.DevNo )")->asArray()->all();
                $line_datas=['add'=>$line_datas1,'init'=>$line_datas2];
            }


        }

//        var_dump($line_datas);exit;
        return array_merge(['line_datas'=>$line_datas],$where_data);

    }

    //表格数据(管理员登陆)
    public function actionDatas(){

        if(\Yii::$app->getUser()->isGuest){
            return $this->redirect(['site/login']);
        }

        //判断是否是管理员登陆
        $id=\Yii::$app->getUser()->getId();
        $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;

        if($role_id!=1){
            return '';
        }

        $title_column=json_decode($this->getParam('title_column'), True);//导出表格时（表头对应字段）
        $state=$this->getParam('state');
        $starttime=$this->getParam('starttime');
        $endtime=$this->getParam('endtime');
        $search=$this->getParam('search');//搜索条件
        $offset=$this->getParam('offset');//起始
        $limit=$this->getParam('limit');//条数

        //最多导出50000条数据
        if($limit>50000)$limit=50000;
        if($offset=='' || $limit==''){
            $offset=0;
            $limit=10;
        }
        //排序
        $sort=$this->getParam('sort');//排序(奇数升序，偶数降序)
        $column=$this->getParam('column');//排序字段

        $day_before=date('Y-m-d',strtotime('-6 day'));
        if ($starttime == '' || $endtime == '') {//默认显示近7天的
            $str="  RowTime > '$day_before' ";
        }else{
            $str="  RowTime > '$starttime' and RowTime < '$endtime 23:59:59' ";
        }


        $model=['users'=>'','total'=>'','role_id'=>''];

        if($state==1||!$state){//默认显示用户（管理员登陆，显示所有用户）
            //搜索条件
            $string='';
            if($search){
                $string=" and (user_info.Name like '%$search%'
            or user_info.Tel like '%$search%'
            or dev_regist.DevNo like '%$search%'
            )";
            }

            $data=ActiveRecord::findBySql("select * from (select DISTINCT user_info.Name,user_info.Tel,dev_regist.DevNo,
            goods.name as GoodsName,brands.BrandName,dev_regist.Province,
dev_regist.City,dev_regist.Area,dev_regist.UseType,dev_regist.CustomerType,dev_active.RowTime as ActiveTime,dev_regist.RowTime
from dev_regist
left join user_info on dev_regist.UserId=user_info.Id
left join goods on dev_regist.goods_id=goods.id
left join brands on brands.BrandNo=dev_regist.brand_id
left join dev_active on dev_active.DevNo=dev_regist.DevNo
where dev_regist.IsActive=1 $string
and dev_regist.AgentId>0 and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
        order by dev_active.RowTime desc)as temp where $str");

            $total=$data->count();//数据总条数

            //获取用户数据
            $users=$data->asArray()->all();
            //排序
            if($sort&&$users&&array_key_exists($column,$users[0])){
                $users=$this->Order($sort,$users,$column);
            }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            //获取上级
            foreach($users as &$v){
                $parent=$this->GetParentByDevNo($v['DevNo']);
                $v['agentFname']=$parent['agentFname'];
                $v['agentPname']=$parent['agentPname'];
                $v['agentYname']=$parent['agentYname'];
            }

//            var_dump($users);exit;
            //所以入网属性（表格渲染）
            $all_use_type=$this->GetAllUseType();
            $model=['users'=>$users,'total'=>$total,'all_use_type'=>$all_use_type];

        }

        if($state==2){//服务中心
            //搜索条件
            $string='';
            if($search){
                $string=" and (a.Name like '%$search%'
            or a.ContractTel like '%$search%'
            )";
            }

            //获取服务中心数据（所有）
            $data=ActiveRecord::findBySql("select DISTINCT a.Id,a.Name,a.LoginName,a.ContractTel as Tel,
a.Province,a.City,a.Area
from agent_info as a
where a.Level=5 $string ");

            $total=$data->count();//数据总条数

            //获取服务中心数据
            $users=$data->asArray()->all();
            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {
                    //服务中心的上级
                    $parent=$this->GetParentByAgentF($user['Id']);
                    $user['agentPname']=$parent['agentPname'];
                    $user['agentYname']=$parent['agentYname'];

                    //-------------------
                    //统计该服务中心下不同用户类型的设备数量


                    //家庭
                    $user['family_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId = {$user['Id']} and IsActive=1 and CustomerType=1
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId = {$user['Id']} and IsActive=1 and CustomerType=2
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId = {$user['Id']} and IsActive=1 and CustomerType=3
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId = {$user['Id']} and IsActive=1 and CustomerType=99
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();

                    //设备总数
                    $user['total_sales']=intval($user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales']);

                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            }
//            var_dump($users);exit;

            $model=['users'=>$users,'total'=>$total,'role_id'=>5];

        }

        if($state==3){//运营中心

            //搜索条件
            $string='';
            if($search){
                $string=" and (Name like '%$search%'
            or ContractTel like '%$search%')";
            }

            //获取运营中心数据
            $data=ActiveRecord::findBySql("select Id,`Name`,ContractTel as Tel,Province,City,
Area,LoginName from agent_info where `Level`=4 $string");

            $total=$data->count();//数据总条数
            $users=$data->asArray()->all();

            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    //-------------------
                    //统计该运营中心下不同用户类型的销量

                    //家庭
                    $user['family_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id
from agent_info
where (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5)))
and IsActive=1 and CustomerType=1
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id
from agent_info
where (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5)))
and IsActive=1 and CustomerType=2
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id
from agent_info
where (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5)))
and IsActive=1 and CustomerType=3
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id
from agent_info
where (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5)))
and IsActive=1 and CustomerType=99
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //酒店用户
                    $user['hotel_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id
from agent_info
where (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5)))
and IsActive=1 and CustomerType=4
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();


                    //设备总数
                    $user['total_sales']=intval($user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales']+$user['hotel_sales']);

                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            }

//            var_dump($users);exit;
            $model=['users'=>$users,'total'=>$total,'role_id'=>3];

        }


        if($state==4){//设备厂家

            //搜索条件
            $string='';
            if($search){
                $string=" and (Name like '%$search%'
            or ContractTel like '%$search%')";
            }

            //获取设备厂家数据
            $data=ActiveRecord::findBySql("select Id,`Name`,ContractTel as Tel,LoginName,
Province,City,Area from dev_factory $string");

            $total=$data->count();//数据总条数
            $users=$data->asArray()->all();



            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    //-------------------
                    //统计设备属于该设备厂家的不同用户类型的销量

                    //家庭销量
                    $user['family_sales']=ActiveRecord::findBySql("
select * from (select distinct dev_regist.DevNo,dev_regist.RowTime
from dev_regist
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id={$user['Id']}
and IsActive=1 and CustomerType=1
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)) as temp where $str")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select * from (select distinct dev_regist.DevNo,dev_regist.RowTime
from dev_regist
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id={$user['Id']}
and IsActive=1 and CustomerType=2
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)) as temp where $str")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select * from (select distinct dev_regist.DevNo,dev_regist.RowTime
from dev_regist
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id={$user['Id']}
and IsActive=1 and CustomerType=3
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)) as temp where $str")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select * from (select distinct dev_regist.DevNo,dev_regist.RowTime
from dev_regist
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id={$user['Id']}
and IsActive=1 and CustomerType=99
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)) as temp where $str")->count();
                    //酒店用户
                    $user['hotel_sales']=ActiveRecord::findBySql("
select * from (select distinct dev_regist.DevNo,dev_regist.RowTime
from dev_regist
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id={$user['Id']}
and IsActive=1 and CustomerType=4
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)) as temp where $str")->count();


                    //设备总数
                    $user['total_sales']=intval($user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales']+$user['hotel_sales']);

                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            }

//            var_dump($users);exit;
            $model=['users'=>$users,'total'=>$total,'role_id'=>4];

        }

        if($state==5){//设备投资商
            //搜索条件
            $string='';
            if($search){
                $string=" and (Name like '%$search%'
            or ContractTel like '%$search%')";
            }

            //获取所有设备投资商数据
            $data=ActiveRecord::findBySql("select Id,`Name`,ContractTel as Tel,Province,City,
Area,LoginName
from agent_info where `Level`=6 $string");

            $total=$data->count();//数据总条数
            $users=$data->asArray()->all();

            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {
                    //-------------------
                    //统计设备属于该设备投资商的不同用户类型的销量

                    //家庭
                    $user['family_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId > 0 and investor_id={$user['Id']}
and IsActive=1 and CustomerType=1
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId > 0 and investor_id={$user['Id']}
and IsActive=1 and CustomerType=2
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId > 0 and investor_id={$user['Id']}
and IsActive=1 and CustomerType=3
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId > 0 and investor_id={$user['Id']}
and IsActive=1 and CustomerType=99
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //酒店用户
                    $user['hotel_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId > 0 and investor_id={$user['Id']}
and IsActive=1 and CustomerType=4
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();


                    //设备总数
                    $user['total_sales']=intval($user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales']+$user['hotel_sales']);
                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            }

//            var_dump($users);exit;
            $model=['users'=>$users,'total'=>$total,'role_id'=>6];

        }

        if($state==6){//酒店中心
            //搜索条件
            $string='';
            if($search){
                $string=" and (a.Name like '%$search%'
            or a.ContractTel like '%$search%'
            )";
            }

            //获取酒店中心数据（所有）
            $data=ActiveRecord::findBySql("select DISTINCT a.Id,a.Name,a.LoginName,a.ContractTel as Tel,
a.Province,a.City,a.Area
from agent_info as a
where a.Level=8 $string ");

            $total=$data->count();//数据总条数

            //获取服务中心数据
            $users=$data->asArray()->all();
            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {
                    //服务中心的上级
                    $parent=$this->GetParentByAgentF($user['Id']);
                    $user['agentPname']=$parent['agentPname'];
                    $user['agentYname']=$parent['agentYname'];

                    //-------------------
                    //统计该服务中心下的设备总数量


                    //设备总数
                    $user['total_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and AgentId = {$user['Id']} and IsActive=1
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();

                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            }
//            var_dump($users);exit;

            $model=['users'=>$users,'total'=>$total,'role_id'=>10];

        }

        if($state==7){//片区中心

            //搜索条件
            $string='';
            if($search){
                $string=" and (Name like '%$search%'
            or ContractTel like '%$search%')";
            }

            //获取片区中心数据
            $data=ActiveRecord::findBySql("select Id,`Name`,ContractTel as Tel,Province,City,
Area,LoginName from agent_info where `Level`=7 $string");

            $total=$data->count();//数据总条数
            $users=$data->asArray()->all();

            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    //-------------------
                    //统计该运营中心下不同用户类型的销量

                    //家庭
                    $user['family_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id from agent_info where ParentId={$user['Id']}))
and IsActive=1 and CustomerType=1
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id from agent_info where ParentId={$user['Id']}))
and IsActive=1 and CustomerType=2
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id from agent_info where ParentId={$user['Id']}))
and IsActive=1 and CustomerType=3
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id from agent_info where ParentId={$user['Id']}))
and IsActive=1 and CustomerType=99
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();
                    //酒店用户
                    $user['hotel_sales']=ActiveRecord::findBySql("
select distinct DevNo
from dev_regist where $str
and (AgentId = {$user['Id']} or AgentId in (select Id from agent_info where ParentId={$user['Id']}))
and IsActive=1 and CustomerType=4
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->count();


                    //设备总数
                    $user['total_sales']=intval($user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales']+$user['hotel_sales']);

                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            }

//            var_dump($users);exit;
            $model=['users'=>$users,'total'=>$total,'role_id'=>7];

        }
//        var_dump($model['users']);
        if($title_column){//导出表格

            $filename=date('Y-m-d');
//            var_dump($model['users']);exit;
            $this->Excel($model['users'],$filename,$title_column);
            exit;

        }

        return json_encode($model);
    }

    //对应角色登陆，获取对应的用户数据（表格的数据）
    public function actionGetUser(){

        if(\Yii::$app->getUser()->isGuest){
            return $this->redirect(['site/login']);
        }



        $LoginName=$this->getParam('LoginName');//登陆名称
        $role_id=$this->getParam('role_id');//角色id


        $title_column=json_decode($this->getParam('title_column'), True);//导出表格时（表头对应字段）
        $starttime=$this->getParam('starttime');
        $endtime=$this->getParam('endtime');
        $search=$this->getParam('search');//搜索条件

        $offset=$this->getParam('offset');//起始
        $limit=$this->getParam('limit');//条数
        $sort=$this->getParam('sort');//排序
        $order=' order by dev_active.RowTime desc ';
        if(!$sort||$sort%2==1){//奇数升序
            $order=' order by dev_active.RowTime asc ';
        }
        //最多导出50000条数据
        if($limit>50000)$limit=50000;
        if(!$offset && !$limit){
            $offset=0;
            $limit=10;
        }


        $day_before = date('Y-m-d', strtotime('-6 day'));//默认7天
        if ($starttime == '' || $endtime == '') {//默认显示近7天的
            $str=" and dev_regist.RowTime > '$day_before' ";
        }else{
            $str=" and dev_regist.RowTime > '$starttime' and dev_regist.RowTime < '$endtime 23:59:59' ";
        }

        if(!$role_id||!$LoginName){
            //登陆信息
            //获取登陆者id
            $id=\Yii::$app->user->getId();
            //获取登陆者角色id
            $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;
            //登陆名称
            $LoginName = ActiveRecord::findBySql("select username from admin_user where id=$id")->asArray()->one()['username'];

        }

        $where='';
        //所以入网属性（表格渲染）
        $all_use_type=$this->GetAllUseType();
        $model=['users'=>'','total'=>'','all_use_type'=>$all_use_type];

        if($role_id==3){//运营中心
            //搜索条件
            if($search){
                $str.=" and (user_info.Name like '%$search%'
                or user_info.Tel like '%$search%'
                or dev_regist.DevNo like '%$search%'
                or goods.name like '%$search%'
                or brands.BrandName like '%$search%'
                )";
            }

            //获取运营中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=4 and LoginName='$LoginName'")->asArray()->one()['Id'];

            //该运营中心下面的所有用户
            $data=ActiveRecord::findBySql("select distinct user_info.Name,user_info.Tel,
dev_regist.DevNo,goods.name as GoodsName,brands.BrandName,
dev_regist.UseType,dev_regist.CustomerType,dev_active.RowTime as ActiveTime
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
LEFT JOIN goods ON dev_regist.goods_id=goods.id
LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
LEFT JOIN dev_active ON dev_regist.DevNo=dev_active.DevNo
where dev_regist.IsActive=1 $str and (AgentId=$agent_id
or AgentId in (select Id
from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)))
and dev_regist.DevNo>0
    and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
");
            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.$order.' limit '.$offset.','.$limit)->asArray()->all();
            //上级
            foreach($users as &$v){
                $parent=$this->GetParentByDevNo($v['DevNo']);
                $v['agentFname']=$parent['agentFname'];
                $v['agentPname']=$parent['agentPname'];
                $v['agentYname']=$parent['agentYname'];
            }

            $model['users']=$users;
            $model['total']=$total;
//            var_dump($total,$users);exit;


        }

        if($role_id==4){//设备厂家
            //搜索条件
            if($search){
                $str.=" and (user_info.Name like '%$search%'
                or user_info.Tel like '%$search%'
                or dev_regist.DevNo like '%$search%'
                or goods.name like '%$search%'
                or brands.BrandName like '%$search%'
                )";
            }

            //获取设备厂家id
            $dev_factory_id=ActiveRecord::findBySql("select Id
from dev_factory where LoginName='$LoginName'")->asArray()->one()['Id'];

            //使用该设备厂家的设备的所有用户
            $data=ActiveRecord::findBySql("select distinct user_info.Name,user_info.Tel,
dev_regist.DevNo,goods.name as GoodsName,brands.BrandName,
dev_regist.CustomerType,dev_active.RowTime as ActiveTime
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
LEFT JOIN goods ON dev_regist.goods_id=goods.id
LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
LEFT JOIN dev_active ON dev_regist.DevNo=dev_active.DevNo
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id=$dev_factory_id $str
and dev_regist.IsActive=1 and dev_regist.AgentId > 0
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)");

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.$order.' limit '.$offset.','.$limit)->asArray()->all();
            //上级
            foreach($users as &$v){
                $parent=$this->GetParentByDevNo($v['DevNo']);
                $v['agentFname']=$parent['agentFname'];
                $v['agentPname']=$parent['agentPname'];
                $v['agentYname']=$parent['agentYname'];
            }


            $model['users']=$users;
            $model['total']=$total;
//            var_dump($total,$users);exit;

        }

        if($role_id==5){//服务中心
            //搜索条件
            if($search){
                $str.=" and (user_info.Name like '%$search%'
                or user_info.Tel like '%$search%'
                or dev_regist.DevNo like '%$search%'
                or goods.name like '%$search%'
                or brands.BrandName like '%$search%'
                )";
            }

            //获取服务中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=5 and LoginName='$LoginName'")->asArray()->one()['Id'];

            //该服务中心下面的所有用户
            $data=ActiveRecord::findBySql("select distinct user_info.Name,user_info.Tel,
dev_regist.DevNo,goods.name as GoodsName,brands.BrandName,dev_regist.Address,
dev_regist.UseType,dev_regist.CustomerType,dev_active.RowTime as ActiveTime
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
LEFT JOIN goods ON dev_regist.goods_id=goods.id
LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
LEFT JOIN dev_active ON dev_regist.DevNo=dev_active.DevNo
where dev_regist.IsActive=1 and dev_regist.AgentId=$agent_id
and dev_regist.DevNo > 0 and IsActive=1 $str
    and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
");

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.$order.' limit '.$offset.','.$limit)->asArray()->all();


            $model['users']=$users;
            $model['total']=$total;
//            var_dump($total,$users);exit;

        }

        if($role_id==6){//设备投资商
            //搜索条件
            if($search){
                $str.=" and (user_info.Name like '%$search%'
                or user_info.Tel like '%$search%'
                or dev_regist.DevNo like '%$search%'
                or goods.name like '%$search%'
                or brands.BrandName like '%$search%'
                )";
            }

            //设备投资商id
            $investor_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=6 and LoginName='$LoginName'")->asArray()->one()['Id'];


            $data=ActiveRecord::findBySql("select distinct user_info.Name,user_info.Tel,
dev_regist.DevNo,goods.name as GoodsName,brands.BrandName,
dev_regist.CustomerType,dev_active.RowTime as ActiveTime
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
LEFT JOIN goods ON dev_regist.goods_id=goods.id
LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
LEFT JOIN dev_active ON dev_regist.DevNo=dev_active.DevNo
where AgentId > 0 and investor_id=$investor_id and IsActive=1 $str
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)");

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.$order.' limit '.$offset.','.$limit)->asArray()->all();
            //上级
            foreach($users as &$v){
                $parent=$this->GetParentByDevNo($v['DevNo']);
                $v['agentFname']=$parent['agentFname'];
                $v['agentPname']=$parent['agentPname'];
                $v['agentYname']=$parent['agentYname'];
            }

            $model['users']=$users;
            $model['total']=$total;
//            var_dump($total,$model);exit;
        }

        if($role_id==10){//酒店中心
            //搜索条件
            if($search){
                $str.=" and (user_info.Name like '%$search%'
                or user_info.Tel like '%$search%'
                or dev_regist.DevNo like '%$search%'
                or goods.name like '%$search%'
                or brands.BrandName like '%$search%'
                )";
            }

            //获取酒店中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=8 and LoginName='$LoginName'")->asArray()->one()['Id'];

            //该服务中心下面的所有用户
            $data=ActiveRecord::findBySql("select distinct user_info.Name,user_info.Tel,
dev_regist.DevNo,goods.name as GoodsName,brands.BrandName,dev_regist.Address,
dev_regist.UseType,dev_active.RowTime as ActiveTime
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
LEFT JOIN goods ON dev_regist.goods_id=goods.id
LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
LEFT JOIN dev_active ON dev_regist.DevNo=dev_active.DevNo
where dev_regist.IsActive=1 and dev_regist.AgentId=$agent_id
and dev_regist.DevNo > 0 and IsActive=1 $str
    and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
");

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.$order.' limit '.$offset.','.$limit)->asArray()->all();


            $model['users']=$users;
            $model['total']=$total;
//            var_dump($total,$users);exit;

        }

        if($role_id==7){//片区中心
            //搜索条件
            if($search){
                $str.=" and (user_info.Name like '%$search%'
                or user_info.Tel like '%$search%'
                or dev_regist.DevNo like '%$search%'
                or goods.name like '%$search%'
                or brands.BrandName like '%$search%'
                )";
            }

            //获取片区中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=7 and LoginName='$LoginName'")->asArray()->one()['Id'];

            //该片区中心下面的所有用户
            $data=ActiveRecord::findBySql("select distinct user_info.Name,user_info.Tel,
dev_regist.DevNo,goods.name as GoodsName,brands.BrandName,
dev_regist.UseType,dev_regist.CustomerType,dev_active.RowTime as ActiveTime
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
LEFT JOIN goods ON dev_regist.goods_id=goods.id
LEFT JOIN brands ON dev_regist.brand_id=brands.BrandNo
LEFT JOIN dev_active ON dev_regist.DevNo=dev_active.DevNo
LEFT JOIN agent_info ON dev_regist.AgentId=agent_info.Id
where dev_regist.IsActive=1 $str and (AgentId=$agent_id
or AgentId in (select Id from agent_info
where ParentId=$agent_id))
and dev_regist.DevNo>0
    and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
");

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.$order.' limit '.$offset.','.$limit)->asArray()->all();
            //上级
            foreach($users as &$v){
                $parent=$this->GetParentByDevNo($v['DevNo']);
                $v['agentFname']=$parent['agentFname'];
                $v['agentPname']=$parent['agentPname'];
                $v['agentYname']=$parent['agentYname'];
            }

            $model['users']=$users;
            $model['total']=$total;
//            var_dump($total,$users);exit;


        }

        if($title_column){//导出表格
            $filename=date('Y-m-d');
            $this->Excel($model['users'],$filename,$title_column);
        }



        return json_encode($model);

    }

    //设备厂家、设备投资商（柱状图）
    public function actionHistogram(){

        if(\Yii::$app->getUser()->isGuest){
            return $this->redirect(['site/login']);
        }

        //如果是管理员查看某个运营中心下的服务中心销量对比(需要带的参数)
        $LoginName=$this->getParam('LoginName');
        $role_id=$this->getParam('role_id');

        $starttime=$this->getParam('starttime');
        $endtime=$this->getParam('endtime');

        if(!$LoginName && !$role_id){//对应角色自己登陆

            //获取登陆角色id
            $id=\Yii::$app->user->getId();
            $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;
            //登陆名称
            $LoginName = ActiveRecord::findBySql("select username from admin_user where id=$id")->asArray()->one()['username'];
        }

        //x轴所有设备型号数据
        $data_x=ActiveRecord::findBySql('select name from goods where category_id=2')->asArray()->all();

        $day_before = date('Y-m-d', strtotime('-6 day'));//默认7天
        $data='';
        if($role_id==4){//设备厂家
            //获取设备厂家的id
            $dev_factory_id=0;
            $dev_factory=ActiveRecord::findBySql("select Id from dev_factory where LoginName='$LoginName'")->asArray()->one();
            if($dev_factory){
                $dev_factory_id=$dev_factory['Id'];
            }
            if(!$dev_factory_id){
                return $data;
            }


            if(!$starttime || !$endtime){
                $data=ActiveRecord::findBySql("select goods.name as GoodsName,
dev_regist.CustomerType,count(dev_regist.CustomerType)as num
from dev_regist
LEFT JOIN goods ON dev_regist.goods_id=goods.id
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id=$dev_factory_id
and dev_regist.AgentId > 0  and dev_regist.IsActive=1
and dev_regist.RowTime > '$day_before'
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
group by goods.name,dev_regist.CustomerType
")->asArray()->all();
            }else{
                $data=ActiveRecord::findBySql("select goods.name as GoodsName,dev_regist.CustomerType,
count(dev_regist.CustomerType)as num
from dev_regist
LEFT JOIN goods ON dev_regist.goods_id=goods.id
inner join investor on investor.agent_id=dev_regist.investor_id
and investor.goods_id=dev_regist.goods_id
inner join dev_factory on dev_factory.Id=investor.factory_id
where dev_factory.Id=$dev_factory_id
and dev_regist.AgentId > 0  and dev_regist.IsActive=1
and dev_regist.RowTime > '$starttime' and dev_regist.RowTime < '$endtime 23:59:59'
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
group by goods.name,dev_regist.CustomerType
")->asArray()->all();
            }





        }

        if($role_id==6){//设备投资商
            //获取设备投资商的id
            $dev_investor_id=0;
            $dev_investor=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName' and Level=6")->asArray()->one();
            if($dev_investor){
                $dev_investor_id=$dev_investor['Id'];
            }
            if(!$dev_investor_id){
                return $data;
            }


            if(!$starttime || !$endtime){
                $data=ActiveRecord::findBySql("select goods.name as GoodsName,dev_regist.CustomerType,
count(dev_regist.CustomerType)as num
from dev_regist
LEFT JOIN goods ON dev_regist.goods_id=goods.id
where investor_id=$dev_investor_id
and AgentId > 0  and IsActive=1 and RowTime > '$day_before'
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
group by goods.name,dev_regist.CustomerType
")->asArray()->all();
            }else{
                $data=ActiveRecord::findBySql("select goods.name as GoodsName,dev_regist.CustomerType,
count(dev_regist.CustomerType)as num
from dev_regist
LEFT JOIN goods ON dev_regist.goods_id=goods.id
where investor_id=$dev_investor_id
and AgentId > 0  and IsActive=1 and RowTime > '$starttime' and RowTime < '$endtime 23:59:59'
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
group by goods.name,dev_regist.CustomerType
")->asArray()->all();
            }

        }

            return json_encode(['data_x'=>$data_x,'data'=>$data]);
//            var_dump(['data_x'=>$data_x,'data'=>$data]);



    }

    public function Order($sort1,$datas,$column){

        if($sort1 && $sort1%2==0){//偶数降序
            if($datas&&count($datas)>1){
                //排序（预警时间升序）
                $sort = array(
                    'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field'     => $column,       //排序字段
                );
                $arrSort = array();
                foreach($datas AS $uniqid => $row){
                    foreach($row AS $key=>$value){
                        $arrSort[$key][$uniqid] = $value;
                    }
                }
                if($sort['direction']){
                    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $datas);
                }
            }
        }
        if($sort1 && $sort1%2==1){//升序
            if($datas&&count($datas)>1){
                //排序（预警时间降序）
                $sort = array(
                    'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field'     => $column,       //排序字段
                );
                $arrSort = array();
                foreach($datas AS $uniqid => $row){
                    foreach($row AS $key=>$value){
                        $arrSort[$key][$uniqid] = $value;
                    }
                }
                if($sort['direction']){
                    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $datas);
                }
            }
        }

        return $datas;

    }


    //导出表格
    public  function Excel($dataArray=[],$filename, $title_column ){
        $tileArray=[];
        $column=[];
        foreach($title_column as $k=>$v){
            array_push($column,array_keys($v)[0]);
            array_push($tileArray,array_values($v)[0]);

        }

        ini_set('memory_limit','512M');
        ini_set('max_execution_time',0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=".$filename.'.csv');
        $fp=fopen('php://output','w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
        fputcsv($fp,$tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            if($index==1000){
                $index=0;
                ob_flush();
                flush();
            }
            $data=[];
            foreach($column as $val){
                if(array_key_exists($val,$item)){
                    if($val=='Tel'||$val=='DevNo'){
                        $data[]="’".$item[$val];
                    }else{
                        $data[]=$item[$val];
                    }
                }

            }



            $index++;
            fputcsv($fp,$data);
        }

        ob_flush();
        flush();
        ob_end_clean();
        exit;
    }


}
