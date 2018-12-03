<?php
namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);
//销量统计接口
use backend\models\AdminRoleUser;
use yii\db\ActiveRecord;


class SalesApiController extends BaseController{

    //销量统计首页
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


    //销量概况
    public function actionSalesDetail(){
//    public function actionIndex(){

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

        $date_before=date('Y-m-d',strtotime('-180 day'));//倒退180天的日期
        $model=[];
        if($role_id==1){//超级管理员
            //获取之前180天的销量（扫码的数量）
            $datas=ActiveRecord::findBySql("select BarCode,DevNo,RowTime
from dev_water_scan
where RowTime > $date_before and DevNo<>0
 and DevNo in(select DevNo from dev_regist where IsActive=1)
GROUP BY BarCode")->asArray()->all();
//            var_dump($datas);
            //用户数量
            $users_number=ActiveRecord::findBySql("select count(*) as num
from dev_regist
where IsActive=1 and DevNo<>0
")->asArray()->one()['num'];
            $model=['datas'=>$datas,'user_number'=>$users_number];
            return json_encode($model);
//            return $model;
//            var_dump($model);
        }
        if($role_id==2){//水厂

            $factory=ActiveRecord::findBySql("select PreCode,Id from factory_info where LoginName='$LoginName'")->asArray()->one();
            //水厂代码
            $PreCode=$factory['PreCode'];
            //水厂id
            $factory_id=$factory['Id'];

            //获取之前180天的销量（扫码的数量）
            $datas=ActiveRecord::findBySql("select BarCode,DevNo,RowTime
from dev_water_scan
where RowTime > $date_before and PreCode=$PreCode
and DevNo<>0
 and DevNo in(select DevNo from dev_regist where IsActive=1)
GROUP BY BarCode")->asArray()->all();
//            var_dump($datas);
            //用户数量
            $users_number=ActiveRecord::findBySql("select count(*) as num
from (select DevNo from dev_water_scan
where PreCode=$PreCode
and DevNo<>0
 and DevNo in(select DevNo from dev_regist where IsActive=1)
group by DevNo)as temp ")->asArray()->one()['num'];
            $model=['datas'=>$datas,'user_number'=>$users_number];
            return json_encode($model);
//            var_dump($model);
        }

        if($role_id==3){//运营中心
            //运营中心的id 以及下面的所有服务中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName'")->asArray()->one()['Id'];

            //获取之前180天的销量（扫码的数量）
            $datas=ActiveRecord::findBySql("select BarCode,DevNo,RowTime
from dev_water_scan where RowTime > $date_before
and (AgentId=$agent_id or AgentId in (select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)) )
 and DevNo>0
 and DevNo in(select DevNo from dev_regist where IsActive=1 and AgentId > 0)
 GROUP BY BarCode")->asArray()->all();
//            var_dump($datas);
            //用户数量
            $users_number=ActiveRecord::findBySql("select count(*) as num
from dev_regist where IsActive=1 and DevNo>0
and (AgentId=$agent_id or AgentId in (select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)))")->asArray()->one()['num'];
            $model=['datas'=>$datas,'user_number'=>$users_number];
            return json_encode($model);
//            var_dump($model);

        }

        if($role_id==4){//设备厂家
            //设备厂家id
            $dev_factory_id=ActiveRecord::findBySql("select Id from dev_factory where LoginName='$LoginName'")->asArray()->one()['Id'];
//            var_dump($dev_factory_id);exit;
            //获取属于该厂家的所有已经注册、激活的设备编号
//            $devnos=ActiveRecord::findBySql("select DevNo from dev_regist where DevFactoryId=$dev_factory_id and IsActive=1 group by DevNo")->asArray()->all();
            //获取之前180天的销量（扫码的数量）
            $datas=ActiveRecord::findBySql("select BarCode,DevNo,RowTime
from dev_water_scan
where RowTime > $date_before
and DevNo in (select DevNo from dev_regist
                where goods_id  in
                (select goods_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id)
                and brand_id  in
                (select goods.brand_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id) and IsActive=1 and DevNo<>0)
GROUP BY BarCode")->asArray()->all();
//            var_dump($datas);
            //用户数量
            $users_number=ActiveRecord::findBySql("select count(*) as num
from dev_regist
where DevNo in (select DevNo from dev_regist
                where goods_id  in
                (select goods_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id)
                and brand_id  in
                (select goods.brand_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id) and IsActive=1 and DevNo<>0)")->asArray()->one()['num'];

            $model=['datas'=>$datas,'user_number'=>$users_number];
            return json_encode($model);
//            var_dump($model);

        }

        if($role_id==5){//服务中心
            //服务中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName'")->asArray()->one()['Id'];
//var_dump($agent_id);exit;
            //获取之前180天的销量（扫码的数量）
            $datas=ActiveRecord::findBySql("select BarCode,DevNo,RowTime
from dev_water_scan where RowTime > $date_before
and AgentId=$agent_id
and DevNo>0
 and DevNo in(select DevNo from dev_regist where IsActive=1)
GROUP BY BarCode")->asArray()->all();
//            var_dump($datas);
            //用户数量
            $users_number=ActiveRecord::findBySql("select count(*) as num
from dev_regist where AgentId=$agent_id and IsActive=1
and DevNo>0
")->asArray()->one()['num'];
            $model=['datas'=>$datas,'user_number'=>$users_number];

            return json_encode($model);
//              var_dump($model);
        }

        if($role_id==6){//设备投资商
            //设备投资商的id
            $investor_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName' and `Level`=6")->asArray()->one()['Id'];


            //------------------------
            //销量
            $datas=ActiveRecord::findBySql("select * from (select BarCode,DevNo,RowTime
from dev_water_scan
where dev_water_scan.DevNo in (select dev_regist.DevNo
from dev_regist
RIGHT JOIN investor ON dev_regist.investor_id = investor.agent_id
and investor.goods_id=dev_regist.goods_id
where dev_regist.IsActive=1 and DevNo>0
and investor.agent_id= $investor_id )) as temp
where RowTime > $date_before GROUP BY BarCode
")->asArray()->all();
            //用户数量
            $users_number=ActiveRecord::findBySql("select count(*) as num from (select DevNo
from dev_regist
where DevNo in (select dev_regist.DevNo
from dev_regist
RIGHT JOIN investor ON dev_regist.investor_id = investor.agent_id
and investor.goods_id=dev_regist.goods_id
where dev_regist.IsActive=1 and DevNo>0
and investor.agent_id= $investor_id))as temp
")->asArray()->one()['num'];
            $model=['datas'=>$datas,'user_number'=>$users_number];
            return json_encode($model);
//            var_dump($model);exit;

        }
    }

    //销量情况(折线)
    public function actionSalesDetailLine(){
//    public function actionIndex(){
        $time=$this->getParam('time');//销量时间
        $LoginName=$this->getParam('LoginName');//登陆名称
        $role_id=$this->getParam('role_id');//角色id

        $starttime='';
        $endtime='';

        if(!$time){
            $time=4;//'30天销量'
        }
//        $name=$this->getParam('name');//商品名称
        if($time==1){//今日
            $starttime=date('Y-m-d',time());
            $endtime=date('Y-m-d '.'00:00:00',strtotime('+1 day'));
        }
        if($time==2){//'昨日销量'
            $starttime=date('Y-m-d',strtotime('-1 day'));
//            $endtime=date('Y-m-d H:i:s',(strtotime('-1 day')));
            $endtime=date('Y-m-d '.'00:00:00',time());
        }
        if($time==3){//'7天销量'
            $starttime=date('Y-m-d',strtotime('-6 day'));
            $endtime=date('Y-m-d '.'00:00:00',strtotime('+1 day'));
        }
        if($time==4){//'30天销量'
            $starttime=date('Y-m-d',strtotime('-30 day'));
            $endtime=date('Y-m-d '.'00:00:00',strtotime('+1 day'));
        }
        if($time==5){//'90天销量'
            $starttime=date('Y-m-d',strtotime('-90 day'));
            $endtime=date('Y-m-d '.'00:00:00',(strtotime('+1 day')));
        }
        if($time==6){//'今年销量'
            $year=date("Y",time());
            $starttime=$year."-01-01";
            $endtime=date('Y-m-d',time());
        }
//        var_dump($starttime,$endtime);exit;

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
               if($role_id==1){//超级管理员
//            $datas=ActiveRecord::findBySql("select BarCode,RowTime from dev_water_scan where RowTime > $starttime and RowTime < $endtime")->asArray()->all();
            //获取对应时间段所有的扫码数据及对应的用户类型
            $datas=ActiveRecord::findBySql("select dev_water_scan.BarCode,
dev_water_scan.RowTime,dev_regist.CustomerType,dev_water_scan.DevNo,
dev_regist.Province,dev_regist.City,dev_regist.Area
from dev_water_scan
LEFT JOIN dev_regist ON dev_water_scan.UserId=dev_regist.UserId
and dev_water_scan.DevNo=dev_regist.DevNO
where dev_water_scan.RowTime > '$starttime'
and dev_water_scan.RowTime < '$endtime 23:59:59'
and dev_water_scan.DevNo>0
 and dev_water_scan.DevNo in(select DevNo from dev_regist where IsActive=1)
")->asArray()->all();
            return json_encode($datas);
//            var_dump($datas);exit;
        }
        if($role_id==2){//水厂
            //获取扫过该水厂条码的所有用户
            //获取该水厂的编号
            $PreCode=ActiveRecord::findBySql("select PreCode from factory_info
where LoginName='$LoginName'")->asArray()->one()['PreCode'];

            //喝过该水厂用户的所有数据
            $datas = ActiveRecord::findBySql("select dev_water_scan.BarCode,
dev_water_scan.RowTime,dev_regist.CustomerType,
dev_regist.Province,dev_regist.City,dev_regist.Area
from dev_water_scan
LEFT JOIN dev_regist ON dev_water_scan.UserId=dev_regist.UserId
and dev_water_scan.DevNo=dev_regist.DevNO
where dev_water_scan.PreCode='$PreCode'
and dev_water_scan.RowTime > '$starttime'
and dev_water_scan.RowTime < '$endtime 23:59:59'
and dev_water_scan.DevNo>0
 and dev_water_scan.DevNo in(select DevNo from dev_regist where IsActive=1)
")->asArray()->all();

            return json_encode($datas);
//            var_dump($datas);exit;

        }
        if($role_id==3){//运营中心
            //获取该运营中心下的所有用户扫码数据
            //获取该运营中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info
where LoginName='$LoginName' and `Level`=4")->asArray()->one()['Id'];

            $datas = ActiveRecord::findBySql("select dev_water_scan.BarCode,
dev_water_scan.RowTime,dev_regist.CustomerType,
dev_regist.Province,dev_regist.City,dev_regist.Area
from dev_water_scan
LEFT JOIN dev_regist ON dev_water_scan.UserId=dev_regist.UserId
and dev_water_scan.DevNo=dev_regist.DevNO
where (dev_water_scan.AgentId=$agent_id
or dev_water_scan.AgentId in (select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)))
and dev_water_scan.RowTime > '$starttime'
and dev_water_scan.RowTime < '$endtime 23:59:59'
and dev_water_scan.DevNo>0
 and dev_water_scan.DevNo in(select DevNo from dev_regist where IsActive=1)
")->asArray()->all();

            return json_encode($datas);
//            var_dump($datas);exit;

        }
        if($role_id==4){//设备厂家

            //获取该运营中心下的所有用户扫码数据
            //获取该设备厂家的id
            $dev_factory_id=ActiveRecord::findBySql("select Id from dev_factory
where LoginName='$LoginName'")->asArray()->one()['Id'];

            $datas = ActiveRecord::findBySql("select * from (select dev_water_scan.BarCode,
dev_water_scan.RowTime,dev_regist.CustomerType,dev_water_scan.DevNO,
dev_regist.Province,dev_regist.City,dev_regist.Area
from dev_regist
LEFT JOIN dev_water_scan ON dev_water_scan.UserId=dev_regist.UserId
where dev_regist.DevNo in (select DevNo from dev_regist
                where goods_id  in
                (select goods_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id)
                and brand_id  in
                (select goods.brand_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id) and IsActive=1 and DevNo>0)) as temp
where RowTime > '$starttime' and RowTime < '$endtime 23:59:59'
")->asArray()->all();

            return json_encode($datas);
//            var_dump($datas);exit;

        }
        if($role_id==5){//服务中心
            //获取该服务中心下的所有用户扫码数据
            //获取该服务中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info
where LoginName='$LoginName' and `Level`=5")->asArray()->one()['Id'];

            $datas = ActiveRecord::findBySql("select * from (select dev_water_scan.BarCode,
dev_water_scan.RowTime,dev_regist.CustomerType,dev_water_scan.DevNO,
dev_regist.Province,dev_regist.City,dev_regist.Area
from dev_water_scan
LEFT JOIN dev_regist ON dev_water_scan.UserId=dev_regist.UserId
and dev_water_scan.DevNo=dev_regist.DevNO
where dev_water_scan.AgentId=$agent_id) as temp
where RowTime > '$starttime' and RowTime < '$endtime 23:59:59'
and DevNo>0
 and DevNo in(select DevNo from dev_regist where IsActive=1)
")->asArray()->all();

            return json_encode($datas);
//            var_dump($datas);exit;
        }


        if($role_id==6){//设备投资商
            //设备投资商的id
            $investor_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName' and `Level`=6")->asArray()->one()['Id'];

            //-----------------------------------------
            $datas=ActiveRecord::findBySql("select * from (select dev_water_scan.BarCode,
dev_water_scan.RowTime,dev_regist.CustomerType,dev_water_scan.DevNO,
dev_regist.Province,dev_regist.City,dev_regist.Area
from dev_water_scan
LEFT JOIN dev_regist ON dev_water_scan.UserId=dev_regist.UserId
and dev_water_scan.DevNo=dev_regist.DevNO
where dev_water_scan.DevNo in (select dev_regist.DevNo
from dev_regist
inner JOIN investor ON dev_regist.investor_id = investor.agent_id
and investor.goods_id=dev_regist.goods_id
where dev_regist.IsActive=1
and investor.investor_id= $investor_id )) as temp
where RowTime > '$starttime' and RowTime < '$endtime 23:59:59'
and DevNo>0
 and DevNo in(select DevNo from dev_regist where IsActive=1)
")->asArray()->all();
            return json_encode($datas);
//            var_dump($datas);exit;


            //---------------------------


//
//            //获取该投资商的设备编号
//            //获取该投资商的设备分布到的服务中心的id、品牌id、商品id
//            $ids=ActiveRecord::findBySql("select agent_id,brand_id,goods_id
//from dev_agent_investor
//where investor_id=$investor_id
//")->asArray()->all();
//
//            if(!$ids||!is_array($ids)){//该投资商没有投资或没有添加得到可卖设备
//                $datas='';
//                return json_encode($datas);
//            }
////            var_dump($ids);exit;
//            //根据注册列表的信息获取该投资商的设备编号
//            $DevNos=[];
//            foreach($ids as $v){
//                $devnos=ActiveRecord::findBySql("select DevNo
//from dev_regist
//where AgentId={$v['agent_id']}
//and brand_id='{$v['brand_id']}'
//and goods_id={$v['goods_id']}")->asArray()->all();
////                var_dump($DevNo);exit;
//                if($devnos){
//                    $DevNos=array_merge($DevNos,$devnos);
//                }
//
//            }
//            if(!$DevNos){//该投资商的设备还没有注册过
//                $datas='';
//                return json_encode($datas);
//            }
//
////            var_dump($DevNos);exit;
//            //获取该投资商的销量数据
//            $datas=[];
//            foreach($DevNos as $DevNo){
//                $data = ActiveRecord::findBySql("select * from (select dev_water_scan.BarCode,
//dev_water_scan.RowTime,dev_regist.CustomerType,dev_water_scan.DevNO,
//dev_regist.Province,dev_regist.City,dev_regist.Area
//from dev_water_scan
//LEFT JOIN dev_regist ON dev_water_scan.UserId=dev_regist.UserId
//and dev_water_scan.DevNo=dev_regist.DevNO
//where dev_water_scan.DevNo='{$DevNo['DevNo']}') as temp
//where RowTime > '$starttime' and RowTime < '$endtime'")->asArray()->all();
//                $datas=array_merge($data,$datas);
//            }
//
////            return json_encode($datas);
//            var_dump($datas);exit;

        }


    }

    //表格数据(管理员登陆)
    public function actionDatas(){
//    public function actionIndex(){

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
        $startime=$this->getParam('startime');
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

        $where='';
        $now=date('Y-m-d H:i:s',time());
        $day_before=date('Y-m-d',strtotime('-29 day'));
        if ($startime == '' || $endtime == '') {//默认显示近30天的销量
            $str=" RowTime > '$day_before' ";
            $str1=" RowTime < '$now' ";
            $str2=" RowTime > '$day_before' and RowTime < '$now' ";//统计设备数量
        }else{
            $str=" RowTime > '$startime' and RowTime < '$endtime 23:59:59' ";
            $str1=" RowTime < '$endtime 23:59:59' ";
            $str2=" RowTime > '$startime' and RowTime < '$endtime 23:59:59' ";
        }

        $model=['users'=>'','total'=>'','role_id'=>''];

        if($state==1||!$state){//默认显示用户（管理员登陆，显示所有用户）
            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            $data=ActiveRecord::findBySql("select * from (select user_info.Name,user_info.Tel,dev_regist.DevNo,
            dev_regist.Province,
dev_regist.City,dev_regist.Area,dev_regist.CustomerType,dev_regist.UserId
from dev_regist
left join user_info on dev_regist.UserId=user_info.Id
where dev_regist.IsActive=1
and dev_regist.AgentId>0 and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
) as temp ".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数

            //获取用户数据
//            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();
            $users=$data->asArray()->all();

            //统计每个用户的销量

            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    $user['sales'] = ActiveRecord::findBySql("
                        select BarCode
                        from dev_water_scan
                        where UserId='{$user['UserId']}' and DevNo='{$user['DevNo']}'
                        and $str and DevNo>0")->count();
                    //                var_dump($user);exit;

                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
                //上级
                foreach($users as &$v){
                    $parent=$this->GetParentByDevNo($v['DevNo']);
                    $v['agentname']=$parent['agentFname'];
                    $v['agentPname']=$parent['agentPname'];
                    $v['parentname']=$parent['agentYname'];
                }
            }
//            var_dump($users);exit;
            $model=['users'=>$users,'total'=>$total];
//            return json_encode($model);
//            var_dump($users);

        }

        if($state==2){//服务中心
            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取服务中心数据（所有）
            $data=ActiveRecord::findBySql("select * from (select a.Id,a.Name,a.LoginName,a.ContractTel as Tel,
a.Province,a.City,a.Area,a.ContractUser
from agent_info as a
where a.Level=5) as temp ".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数

            //获取服务中心数据
//            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();
            $users=$data->asArray()->all();
            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    //服务中心的上级
                    $parent=$this->GetParentByAgentF($user['Id']);
                    $user['agentPname']=$parent['agentPname'];
                    $user['parentname']=$parent['agentYname'];

                    //-------------------
                    //统计该服务中心下不同用户类型的销量


                    //家庭销量
                    $user['family_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=1 and AgentId={$user['Id']} and DevNo=dev_water_scan.DevNo)
")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=2 and AgentId={$user['Id']} and DevNo=dev_water_scan.DevNo)
")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=3 and AgentId={$user['Id']} and DevNo=dev_water_scan.DevNo)
")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=99 and AgentId={$user['Id']} and DevNo=dev_water_scan.DevNo)
")->count();

                    //总销量
                    $user['total_sales']=intval($user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales']);


                    //设备总数
                    //正常设备数
                    $num1=ActiveRecord::findBySql("
select DevNo
from dev_regist where $str1
and AgentId={$user['Id']}
and DevNo > 0 and IsActive=1
")->count();
                    //这段时间初始化的设备数
                    $num2=ActiveRecord::findBySql("
select DISTINCT DevNo
from dev_cmd where $str2
and CmdType=4 and State=1
and exists(select 1 from dev_regist where AgentId={$user['Id']} and DevNo=dev_cmd.DevNo )
")->count();
                    //设备总数
                    $user['dev_total']=$num1+$num2;
                    //平均销量
                    $user['average_sales']=$user['total_sales']==0?0:round($user['total_sales']/$user['dev_total'],2);

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
//            return json_encode($model);
//            var_dump($model);

        }

        if($state==3){//运营中心

            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取运营中心数据
            $data=ActiveRecord::findBySql("select * from (select Id,`Name`,ContractTel as Tel,Province,City,
Area,LoginName
from agent_info where `Level`=4) as temp ".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //获取运营中心数据
//            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();
            $users=$data->asArray()->all();

            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    //-------------------
                    //统计该运营中心下不同用户类型的销量

                    //家庭销量
                    $user['family_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo >0 and  CustomerType=1
and exists (select 1 from agent_info where
( (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5))
and Id=dev_regist.AgentId)
and DevNo=dev_water_scan.DevNo)
")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo >0 and  CustomerType=2
and exists (select 1 from agent_info where
( (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5))
and Id=dev_regist.AgentId)
and DevNo=dev_water_scan.DevNo)
")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo >0 and  CustomerType=3
and exists (select 1 from agent_info where
( (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5))
and Id=dev_regist.AgentId)
and DevNo=dev_water_scan.DevNo)
")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo >0 and  CustomerType=99
and exists (select 1 from agent_info where
( (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5))
and Id=dev_regist.AgentId)
and DevNo=dev_water_scan.DevNo)
")->count();
                    //总销量
                    $user['total_sales']=$user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales'];


                    //设备总数
                    //正常设备数
                    $num1=ActiveRecord::findBySql("
select DevNo
from dev_regist where $str1
and exists (select 1 from agent_info where
( (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5))
and Id=dev_regist.AgentId)
and DevNo > 0 and IsActive=1
")->count();
                    //这段时间初始化的设备数
                    $num2=ActiveRecord::findBySql("
select DISTINCT DevNo
from dev_cmd where $str2
and CmdType=4 and State=1
and exists(select 1 from dev_regist
where exists (select 1 from agent_info where
( (ParentId={$user['Id']} and Level=5)
or (ParentId in (select Id from agent_info where ParentId={$user['Id']} and Level=7 ) and Level=5)) and Id=dev_regist.AgentId)
and DevNo=dev_cmd.DevNo )
")->count();
                    //设备总数
                    $user['dev_total']=$num1+$num2;
                    //平均销量
                    $user['average_sales']=$user['total_sales']==0?0:round($user['total_sales']/$user['dev_total'],2);

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
//            return json_encode($model);
//            var_dump($model);

        }

        if($state==4){//水厂

            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取水厂数据
            $data=ActiveRecord::findBySql("select * from (select Id,PreCode,`Name`,ContractTel as Tel,
Province,City,Area,LoginName
from factory_info) as temp ".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //获取用户数据
//            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();
            $users=$data->asArray()->all();


            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    //-------------------
                    //统计喝过该水厂水的不同用户类型的销量

                    //家庭销量
                    $user['family_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=1 and DevNo=dev_water_scan.DevNo)
and PreCode='{$user['PreCode']}'
")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=2 and DevNo=dev_water_scan.DevNo)
and PreCode='{$user['PreCode']}'
")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=3 and DevNo=dev_water_scan.DevNo)
and PreCode='{$user['PreCode']}'
")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select BarCode
from dev_water_scan where $str
and exists (select 1 from dev_regist
where DevNo>0 and  CustomerType=99 and DevNo=dev_water_scan.DevNo)
and PreCode='{$user['PreCode']}'
")->count();

                    //总销量
                    $user['total_sales']=$user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales'];



                    //设备总数

                    $user['dev_total']=ActiveRecord::findBySql("
select DISTINCT DevNo
from dev_water_scan where $str1 and DevNo > 0
and PreCode='{$user['PreCode']}'
")->count();
                    //平均销量
                    $user['average_sales']=$user['total_sales']==0?0:round($user['total_sales']/$user['dev_total'],2);

                }

                //排序
                if($sort&&array_key_exists($column,$users[0])){
                    $users=$this->Order($sort,$users,$column);
                }
                //获取这一页的数据
                $users=array_slice($users,$offset,$limit);
            }

//            var_dump($users);exit;
            $model=['users'=>$users,'total'=>$total,'role_id'=>2];
//            return json_encode($model);
//            var_dump($model);

        }

        if($state==5){//设备厂家

            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取设备厂家数据
            $data=ActiveRecord::findBySql("select * from (select Id,`Name`,ContractTel as Tel,LoginName,
Province,City,Area from dev_factory) as temp ".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //获取用户数据
//            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();
            $users=$data->asArray()->all();



            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {

                    //-------------------
                    //统计设备属于该设备厂家的不同用户类型的销量

                    //家庭销量
                    $user['family_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and DevNo in (select DISTINCT DevNo from dev_regist
                inner join investor on investor.goods_id=dev_regist.goods_id
                and investor.agent_id=dev_regist.investor_id
                where investor.factory_id={$user['Id']}
                and dev_regist.DevNo>0 and  dev_regist.CustomerType=1
                )
")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and DevNo in (select DISTINCT DevNo from dev_regist
                inner join investor on investor.goods_id=dev_regist.goods_id
                and investor.agent_id=dev_regist.investor_id
                where investor.factory_id={$user['Id']}
                and dev_regist.DevNo>0 and  dev_regist.CustomerType=2
                )
")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and DevNo in (select DISTINCT DevNo from dev_regist
                inner join investor on investor.goods_id=dev_regist.goods_id
                and investor.agent_id=dev_regist.investor_id
                where investor.factory_id={$user['Id']}
                and dev_regist.DevNo>0 and  dev_regist.CustomerType=3
                )
")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and DevNo in (select DISTINCT DevNo from dev_regist
                inner join investor on investor.goods_id=dev_regist.goods_id
                and investor.agent_id=dev_regist.investor_id
                where investor.factory_id={$user['Id']}
                and dev_regist.DevNo>0 and  dev_regist.CustomerType=4
                )
")->count();

                    //总销量
                    $user['total_sales']=$user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales'];


                    //设备总数

                    $num1=ActiveRecord::findBySql("
select DISTINCT DevNo from dev_regist
                inner join investor on investor.goods_id=dev_regist.goods_id
                where investor.factory_id={$user['Id']}
                and investor.agent_id=dev_regist.investor_id
                and DevNo>0 and IsActive=1 and  AgentId > 0 and $str1

")->count();
                    $num2=ActiveRecord::findBySql("
select DISTINCT DevNo from dev_regist
                inner join investor on investor.goods_id=dev_regist.goods_id
                where investor.factory_id={$user['Id']}
                and investor.agent_id=dev_regist.investor_id
                and DevNo>0
                and exists(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and  AgentId > 0 and $str2

")->count();
                    //设备总数
                    $user['dev_total']=$num1+$num2;
                    //平均销量
                    $user['average_sales']=$user['total_sales']==0?0:round($user['total_sales']/$user['dev_total'],2);

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
//            return json_encode($model);
//            var_dump($model);

        }

        if($state==6){//设备投资商
            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取所有设备投资商数据
            $data=ActiveRecord::findBySql("select * from (select Id,`Name`,ContractTel as Tel,Province,City,
Area,LoginName
from agent_info where `Level`=6) as temp ".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //投资商数据
//            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();
            $users=$data->asArray()->all();

            if(!empty($users)&&is_array($users)) {
                foreach ($users as &$user) {
                    //-------------------
                    //统计设备属于该设备投资商的不同用户类型的销量

                    //家庭销量
                    $user['family_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and exists (select 1
                from dev_regist
                where investor_id={$user['Id']}
                and DevNo=dev_water_scan.DevNo
                and CustomerType=1)
")->count();
                    //公司用户
                    $user['company_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and exists (select 1
                from dev_regist
                where investor_id={$user['Id']}
                and DevNo=dev_water_scan.DevNo
                and CustomerType=2)
")->count();
                    //集团用户
                    $user['group_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and exists (select 1
                from dev_regist
                where investor_id={$user['Id']}
                and DevNo=dev_water_scan.DevNo
                and CustomerType=3)
")->count();
                    //其他用户
                    $user['other_sales']=ActiveRecord::findBySql("
select DISTINCT BarCode
from dev_water_scan where $str
and exists (select 1
                from dev_regist
                where investor_id={$user['Id']}
                and DevNo=dev_water_scan.DevNo
                and CustomerType=99)
")->count();

                    //总销量
                    $user['total_sales']=$user['family_sales']+$user['company_sales']+$user['group_sales']+$user['other_sales'];


                    //设备总数

                    $num1=ActiveRecord::findBySql("
select DISTINCT DevNo from dev_regist
                where investor_id={$user['Id']}
                and IsActive=1 and AgentId > 0 and $str1

")->count();
                    $num2=ActiveRecord::findBySql("
select DISTINCT DevNo from dev_regist
                where investor_id={$user['Id']}
                and exists(select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                and  AgentId > 0 and $str2

")->count();
                    //设备总数
                    $user['dev_total']=$num1+$num2;
                    //平均销量
                    $user['average_sales']=$user['total_sales']==0?0:round($user['total_sales']/$user['dev_total'],2);

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
//            return json_encode($model);
//            var_dump($model);

        }

        if($title_column){//导出表格
            $header=[];
            $index=[];
            foreach($title_column as $k=>$v){
                array_push($index,array_keys($v)[0]);
                array_push($header,array_values($v)[0]);

            }
            $filename=date('Y-m-d');
            $this->Excel($model['users'],$filename,$header,$index);

        }

        return json_encode($model);
    }

    //对应角色登陆，获取对应的用户数据（表格的数据）
    public function actionGetUser(){
//    public function actionIndex(){

        if(\Yii::$app->getUser()->isGuest){
            return $this->redirect(['site/login']);
        }



        $LoginName=$this->getParam('LoginName');//登陆名称
        $role_id=$this->getParam('role_id');//角色id


        $title_column=json_decode($this->getParam('title_column'), True);//导出表格时（表头对应字段）
        $startime=$this->getParam('startime');
        $endtime=$this->getParam('endtime');
        $search=$this->getParam('search');//搜索条件

        $offset=$this->getParam('offset');//起始
        $limit=$this->getParam('limit');//条数
        //最多导出50000条数据
        if($limit>50000)$limit=50000;
        if(!$offset && !$limit){
            $offset=0;
            $limit=10;
        }


        $day_before = date('Y-m-d', strtotime('-29 day'));//默认30天

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
        $model=['users'=>'','total'=>''];
        if($role_id==2){//水厂

            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }



            $factory=ActiveRecord::findBySql("select PreCode,Id from factory_info where LoginName='$LoginName'")->asArray()->one();
            //水厂代码
            $PreCode=$factory['PreCode'];
            //水厂id
            $factory_id=$factory['Id'];

            //获取该水厂的所有用户（扫过该水厂条码的）
            $data=ActiveRecord::findBySql("select * from (select dev_regist.Province,dev_regist.City,
dev_regist.Area,dev_regist.DevNo,dev_regist.CustomerType,
user_info.Name,user_info.Tel,user_info.Id as UserId,b.Name as ParentName
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
LEFT JOIN agent_info as a ON dev_regist.AgentId=a.Id
LEFT JOIN agent_info as b ON a.ParentId=b.Id
where dev_regist.DevNo in
(select DevNo from dev_water_scan
where PreCode=$PreCode group by DevNo)
and dev_regist.DevNo>0 and dev_regist.IsActive=1
    and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
) as temp".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();


            if(!empty($users)&&is_array($users)) {
                //统计每个用户的销量

                foreach ($users as &$user) {
                    if ($startime == '' || $endtime == '') {//默认显示近7天的销量
                        $user['sales'] = ActiveRecord::findBySql("select count(*) as num from
    (select DevNo from dev_water_scan where UserId='{$user['UserId']}' and DevNo='{$user['DevNo']}' and RowTime > $day_before) as temp")->asArray()->one()['num'];
                        //                var_dump($user);exit;
                    } else {
                        $user['sales'] = ActiveRecord::findBySql("select count(*) as num from
    (select DevNo from dev_water_scan where UserId='{$user['UserId']}' and DevNo='{$user['DevNo']}' and RowTime > '$startime' and RowTime < '$endtime 23:59:59') as temp")->asArray()->one()['num'];
                    }

                }
            }
            $model=['users'=>$users,'total'=>$total];
//            return json_encode($model);


//            var_dump($users);
        }

        if($role_id==3){//运营中心
            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取运营中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=4 and LoginName='$LoginName'")->asArray()->one()['Id'];

                //该运营中心下面的所有用户
                $data=ActiveRecord::findBySql("select * from (select dev_regist.DevNo,
dev_regist.CustomerType,user_info.Name,user_info.Tel,user_info.Id as UserId

from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
where dev_regist.IsActive=1 and (AgentId=$agent_id
or AgentId in (select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)))
and dev_regist.DevNo>0
    and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
) as temp".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();


            //统计每个用户的销量
            if(!empty($users)&&is_array($users)){

                foreach($users as &$user){

                    //上级
                        $parent=$this->GetParentByDevNo($user['DevNo']);
                        $user['AgnetName']=$parent['agentFname'];
                        $user['agentPname']=$parent['agentPname'];
                        $user['agentYname']=$parent['agentYname'];

                    if($startime==''||$endtime==''){//默认显示近7天的销量
                        $user['sales']=ActiveRecord::findBySql("select count(*) as num from
(select DevNo from dev_water_scan where UserId='{$user['UserId']}' and DevNo='{$user['DevNo']}' and RowTime > $day_before) as temp")->asArray()->one()['num'];
//                var_dump($user);exit;
                    }else{
                        $user['sales']=ActiveRecord::findBySql("select count(*) as num from
(select DevNo from dev_water_scan where UserId='{$user['UserId']}' and DevNo='{$user['DevNo']}' and RowTime > '$startime' and RowTime < '$endtime 23:59:59') as temp")->asArray()->one()['num'];
                    }

                }

            }

            $model=['users'=>$users,'total'=>$total];
//            return json_encode($model);
//            var_dump($users);


        }

        if($role_id==4){//设备厂家
            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取设备厂家id
            $dev_factory_id=ActiveRecord::findBySql("select Id
from dev_factory where LoginName='$LoginName'")->asArray()->one()['Id'];

            //使用该设备厂家的设备的所有用户
            $data=ActiveRecord::findBySql("select * from (select dev_regist.DevNo,
dev_regist.CustomerType,user_info.Name,user_info.Tel,user_info.Id as UserId,
dev_regist.Province,dev_regist.City,dev_regist.Area
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
where dev_regist.DevNo in (select DevNo from dev_regist
                where goods_id  in
                (select goods_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id)
                and brand_id  in
                (select goods.brand_id
                from investor
                INNER JOIN goods on investor.goods_id=goods.id
                where investor.factory_id=$dev_factory_id) and dev_regist.IsActive=1 and dev_regist.DevNo>0
                and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo))
) as temp".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();


            //统计每个用户的销量

            if(!empty($users)&&is_array($users)){

                foreach($users as &$user){

                    //上级
                    $parent=$this->GetParentByDevNo($user['DevNo']);
                    $user['AgnetName']=$parent['agentFname'];
                    $user['agentPname']=$parent['agentPname'];
                    $user['ParentName']=$parent['agentYname'];

                    if($startime==''||$endtime==''){//默认显示近7天的销量
                        $user['sales']=ActiveRecord::findBySql("select count(*) as num from
(select DevNo from dev_water_scan where UserId='{$user['UserId']}' and DevNo='{$user['DevNo']}' and RowTime > $day_before) as temp")->asArray()->one()['num'];
//                var_dump($user);exit;
                    }else{
                        $user['sales']=ActiveRecord::findBySql("select count(*) as num from
(select DevNo from dev_water_scan where UserId='{$user['UserId']}'
and DevNo='{$user['DevNo']}' and RowTime > '$startime'
and RowTime < '$endtime 23:59:59') as temp")->asArray()->one()['num'];
                    }

                }

            }

            $model=['users'=>$users,'total'=>$total];
//            return json_encode($model);
//            var_dump($users);

        }

        if($role_id==5){//服务中心
            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //获取服务中心id
            $agent_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=5 and LoginName='$LoginName'")->asArray()->one()['Id'];

            //该服务中心下面的所有用户
            $data=ActiveRecord::findBySql("select * from (select dev_regist.DevNo,
dev_regist.CustomerType,dev_regist.Address,user_info.Name,user_info.Tel,user_info.Id as UserId
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id
where dev_regist.IsActive=1 and dev_regist.AgentId=$agent_id
and dev_regist.DevNo > 0
    and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
) as temp".(empty($where)?'':' where '.$where));

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();


            //统计每个用户的销量
            if(!empty($users)&&is_array($users)){

                foreach($users as &$user){
                    if($startime==''||$endtime==''){//默认显示近7天的销量
                        $user['sales']=ActiveRecord::findBySql("select count(*) as num from
(select DevNo from dev_water_scan where UserId='{$user['UserId']}' and DevNo='{$user['DevNo']}' and RowTime > $day_before) as temp")->asArray()->one()['num'];
//                var_dump($user);exit;
                    }else{
                        $user['sales']=ActiveRecord::findBySql("select count(*) as num from
(select DevNo from dev_water_scan where UserId='{$user['UserId']}'
and DevNo='{$user['DevNo']}' and RowTime > '$startime'
and RowTime < '$endtime 23:59:59') as temp")->asArray()->one()['num'];
                    }

                }

            }

            $model=['users'=>$users,'total'=>$total];
//            return json_encode($model);
//            var_dump($users);exit;

        }

        if($role_id==6){//设备投资商
            //搜索条件
            if($search){
                $where=" Name like '%$search%' or Tel like '%$search%'";
            }

            //设备投资商id
            $investor_id=ActiveRecord::findBySql("select Id
from agent_info where `Level`=6 and LoginName='$LoginName'")->asArray()->one()['Id'];


            $data=ActiveRecord::findBySql("select DISTINCT * from (select dev_regist.DevNo,
dev_regist.CustomerType,dev_regist.Province,dev_regist.City,dev_regist.Area,
user_info.Name,user_info.Tel,user_info.Id as UserId
from dev_regist
LEFT JOIN user_info ON dev_regist.UserId=user_info.Id

where dev_regist.IsActive=1 and AgentId > 0
and dev_regist.DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)
and dev_regist.investor_id= $investor_id)
 as temp" . (empty($where) ? '' : ' where ' . $where));
//RIGHT JOIN dev_agent_investor ON dev_regist.AgentId = dev_agent_investor.agent_id
//            and dev_regist.brand_id = dev_agent_investor.brand_id
//            and dev_regist.goods_id = dev_agent_investor.goods_id

            $total=$data->count();//数据总条数
            //获取用户数据
            $users=ActiveRecord::findBySql($data->sql.' limit '.$offset.','.$limit)->asArray()->all();


            $time_where='';
            if ($startime == '' || $endtime == '') {//默认显示近7天的销量
                $time_where=" and RowTime > $day_before ";
            }else{
                $time_where=" and RowTime > '$startime' and RowTime < '$endtime 23:59:59' ";
            }

//            $users=ActiveRecord::findBySql("select count(*) from (select BarCode
//from dev_water_scan
//where DevNo in (select dev_regist.DevNo
//from dev_regist
//RIGHT JOIN dev_agent_investor ON dev_regist.AgentId = dev_agent_investor.agent_id
//            and dev_regist.brand_id = dev_agent_investor.brand_id
//            and dev_regist.goods_id = dev_agent_investor.goods_id
//where dev_regist.IsActive=1
//            and dev_agent_investor.investor_id= $investor_id )
//$time_where )as temp
//            ")->asArray()->one()['num'];






            foreach($users as &$user){

                //上级
                $parent=$this->GetParentByDevNo($user['DevNo']);
                $user['agentFname']=$parent['agentFname'];
                $user['agentPname']=$parent['agentPname'];
                $user['ParentName']=$parent['agentYname'];

                //统计每个用户的销量
                $num = ActiveRecord::findBySql("select count(*) as num
                                    from (select BarCode
                                     from dev_water_scan where DevNo='{$user['DevNo']}'
                                     $time_where
                                     GROUP BY BarCode)as temp")->asArray()->one()['num'];

                $user['sales']=$num;
            }


            $model=['users'=>$users,'total'=>$total];
//            return json_encode($model);
//            var_dump($model);
        }

        if($title_column){//导出表格
            $header=[];
            $index=[];
            foreach($title_column as $k=>$v){
                array_push($index,array_keys($v)[0]);
                array_push($header,array_values($v)[0]);

            }
            $filename=date('Y-m-d');
            $this->Excel($model['users'],$filename,$header,$index);
        }

        return json_encode($model);

    }

    //运营中心下的服务中心销量对比（柱状图）
    public function actionHistogram(){
//    public function actionIndex(){

        if(\Yii::$app->getUser()->isGuest){
            return $this->redirect(['site/login']);
        }

        //如果是管理员查看某个运营中心下的服务中心销量对比(需要带的参数)
        $LoginName=$this->getParam('LoginName');
        $role_id=$this->getParam('role_id');

        $startime=$this->getParam('startime');
        $endtime=$this->getParam('endtime');

        if(!$LoginName && !$role_id){//对应角色自己登陆

            //获取登陆角色id
            $id=\Yii::$app->user->getId();
            $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;
            //登陆名称
            $LoginName = ActiveRecord::findBySql("select username from admin_user where id=$id")->asArray()->one()['username'];
        }
        if($role_id==3){
            //获取运营中心的id
            $agent_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$LoginName'")->asArray()->one()['Id'];
            if(!$agent_id){
                return null;
            }
            //获取该运营中心下的所有服务中心
            $agent=ActiveRecord::findBySql("select Id,Name from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)")->asArray()->all();

            if(!empty($agent) && is_array($agent)){
                //获取每个服务中心的销量数据
                foreach($agent as &$v){

                    if(!$startime || !$endtime){
                        $v['datas']=ActiveRecord::findBySql("select dev_water_scan.BarCode,dev_regist.CustomerType
from dev_water_scan
LEFT JOIN dev_regist ON dev_water_scan.DevNo=dev_regist.DevNo
where dev_water_scan.AgentId={$v['Id']}
and dev_water_scan.DevNo<>0
    and dev_water_scan.DevNo in(select DevNo from dev_regist where IsActive=1)
")->asArray()->all();
                    }else{
                        $v['datas']=ActiveRecord::findBySql("select dev_water_scan.BarCode,dev_regist.CustomerType
from dev_water_scan
LEFT JOIN dev_regist ON dev_water_scan.DevNo=dev_regist.DevNo
where dev_water_scan.AgentId={$v['Id']}
and dev_water_scan.RowTime > '$startime'
and dev_water_scan.RowTime < '$endtime 23:59:59'
and dev_water_scan.DevNo<>0
    and dev_water_scan.DevNo in(select DevNo from dev_regist where IsActive=1)

")->asArray()->all();
                    }

                }
            }
            return json_encode($agent);
//            var_dump($agent);
        }


    }

    public function Order($sort1,$datas,$column){

        if($sort1 && $sort1%2==1){//奇数降序
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
        if($sort1 && $sort1%2==0){//升序
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
    public  function Excel($dataArray=[],$filename, $tileArray=[],$column=[] ){
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
                if($val=='Tel'||$val=='DevNo'){
                    $data[]="’".$item[$val];
                }else{
                    $data[]=$item[$val];
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
