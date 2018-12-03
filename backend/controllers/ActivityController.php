<?php
namespace backend\controllers;
//微信运营活动
use yii\base\Exception;
use yii\db\ActiveRecord;

class ActivityController extends BaseController{
    public $enableCsrfValidation = false;
    //创建运营活动
    public function actionCreateActivity(){
        return $this->renderPartial('create-activity');
    }
    //ajax获取所有没有参加活动的用户（除开参加默认活动的用户）
    public function actionGetUser(){
        $user=ActiveRecord::findBySql("
        select user_info.Id,user_info.Name as UserName,
        user_info.Tel,agent_info.Name as AgentName
        from user_info
        inner join dev_regist on dev_regist.UserId=user_info.Id
        inner join agent_info on agent_info.Id=dev_regist.AgentId
        where not exists (select 1 from user_activity_log
            LEFT JOIN activity on activity.Id=user_activity_log.ActivityId
            where activity.EndTime > NOW() and user_activity_log.UserId=user_info.Id)
        group by user_info.Id
        ")->asArray()->all();
        $array=[];
        foreach($user as $v){
            $array[$v['AgentName']][]=$v;
        }
        return json_encode($array);
    }

    //进入添加用户页面
    public function actionAppUserActivity(){
        return $this->render('app-user-activity');
    }

    //ajax保存活动内容及参加该活动的用户
    public function actionSaveActivityUser(){
        $title=$this->getParam('title');//主题
        $start_time=$this->getParam('start_time');//开始时间
        $end_time=$this->getParam('end_time');//结束时间
        $first_money=$this->getParam('first_money');//首次赏金
        $drink_money=$this->getParam('drink_money');//长期奖金
        $remark=$this->getParam('remark');//备注
        $user_id_str=$this->getParam('user_id_str');//参加该活动的用户id
        if(!$title||!$start_time||!$end_time||!$first_money
            ||!$drink_money||!$user_id_str||!is_numeric($first_money)
            ||!is_numeric($drink_money)){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $now=date('Y-m-d H:i:s');
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            //保存活动
            $re=\Yii::$app->db->createCommand("insert into activity (`Title`,`StartTime`,`EndTime`,`FirstMoney`,`DrinkMoney`,`Remark`,`RowTime`,`State`)
        values('$title','$start_time','$end_time',$first_money,$drink_money,'$remark','$now',0)")->execute();
            if($re){
              throw new Exception('保存活动失败');
            }
            $activity_id=\Yii::$app->db->getLastInsertID();//活动id
            //保存用户参加活动记录、修改user_info参加的活动id
            $user_array=explode(',',$user_id_str);
            $sql='insert into user_activity_log (`UserId`,`ActivityId`,`RowTime`)values';
            $tag=0;
            $str='';
            foreach($user_array as $k=>$v){
                if($tag==0){
                    $sql.="('$v',$activity_id,'$now')";
                }else{
                    $sql.=",('$v',$activity_id,'$now')";
                }
                //拼接sql
                $str.=" WHEN $v THEN $activity_id ";
                $tag++;
            }
            $re=\Yii::$app->db->createCommand($sql)->execute();
            if($re){
                throw new Exception('保存用户参加活动记录失败');
            }
            //修改用户参加的活动id
            $update_sql="update user_info set ActivityId = CASE Id $str END where Id in ($user_id_str)";
            $re=\Yii::$app->db->createCommand($update_sql)->execute();
            if($re){
                throw new Exception('修改用户参加的活动失败');
            }
            $transaction->commit();
            return json_encode(['state'=>0]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);
        }
    }

    //ajax 将活动设为默认活动
    public function actionSetDefaultActivity(){
        $activity_id=$this->getParam('activity_id');//活动id
        if(!$activity_id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            $now=date('Y-d-m H:i:s');
            //判断是否已经有默认获得（默认活动只能有一个）
            $data=ActiveRecord::findBySql("select Id from activity where State=1")->asArray()->one();
            if($data){
                //将已有默认活动截至到当前，状态修改成非默认获得
                $re=\Yii::$app->db->createCommand("update activity set State=0,UpdateTime='$now',EndTime='$now' where State=1")->execute();
                throw new Exception('修改成已有默认活动失败');
            }
            $re=\Yii::$app->db->createCommand("update activity set State=1,UpdateTime='$now' where Id=$activity_id")->execute();
            if(!$re){
                throw new Exception('设置失败');
            }

            $transaction->commit();
            return json_encode(['state'=>0]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);
        }

    }

    //ajax 获取需要修改的活动、参加该活动的用户
    public function actionGetActivityAndUserData(){
        $activity_id=$this->getParam('activity_id');//活动id
        if(!$activity_id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $activity=ActiveRecord::findBySql("select `Title`,`StartTime`,`EndTime`,`FirstMoney`,`DrinkMoney`,`Remark` from activity where Id=$activity_id")->asArray()->one();
        $users=ActiveRecord::findBySql("
        select user_activity_log.Id,user_info.Name as UserName, user_info.Tel
        from user_activity_log
        inner join activity on activity.Id=user_activity_log.ActivityId
        inner join user_info on user_info.Id=user_activity_log.UserId
        where ActivityId=$activity_id")->asArray()->all();
        $data=['activity'=>$activity,'users'=>$users];
        return json_encode(['data'=>$data]);
    }

    //ajax 保存修改的活动内容 及新添加的用户
    public function actionSaveEdit(){
        $activity_id=$this->getParam('activity_id');//活动id
        $title=$this->getParam('title');//主题
        $start_time=$this->getParam('start_time');//开始时间
        $end_time=$this->getParam('end_time');//结束时间
        $first_money=$this->getParam('first_money');//首次赏金
        $drink_money=$this->getParam('drink_money');//长期奖金
        $remark=$this->getParam('remark');//备注
        $user_id_str=$this->getParam('user_id_str');//新增的参加该活动的用户id
        if(!$title||!$start_time||!$end_time||!$first_money
            ||!$drink_money||!$user_id_str||!is_numeric($first_money)
            ||!is_numeric($drink_money)||!$activity_id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }

        $now=date('Y-m-d H:i:s');
        //判断该活动是否已经开始
        $data=ActiveRecord::findBySql("select StartTime,EndTime from activity where Id=$activity_id")->asArray()->one();
        if($now>$data['StartTime']){
            return json_encode(['state'=>-1,'msg'=>'活动开始后不可修改']);
        }
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            //保存活动
            $re=\Yii::$app->db->createCommand("update activity set `Title`='$title',`StartTime`='$start_time',
            `EndTime`='$end_time',`FirstMoney`=$first_money,`DrinkMoney`=$drink_money,`Remark`='$remark',`UpdateTime`='$now'
            where Id=$activity_id")->execute();
            if($re){
                throw new Exception('修改活动失败');
            }
            //保存用户参加活动记录
            $user_array=explode(',',$user_id_str);
            $sql='insert into user_activity_log (`UserId`,`ActivityId`,`RowTime`)values';
            foreach($user_array as $k=>$v){
                if($k==0){
                    $sql.="('$v',$activity_id,'$now')";
                }else{
                    $sql.=",('$v',$activity_id,'$now')";
                }
            }
            $re=\Yii::$app->db->createCommand($sql)->execute();
            if($re){
                throw new Exception('保存用户参加活动记录失败');
            }
            $transaction->commit();
            return json_encode(['state'=>0]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);
        }
    }

    //ajax 删除用户参加某个活动
    public function actionDelUser(){
        $id=$this->getParam('id');
        if(!$id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $re=\Yii::$app->db->createCommand("delete from user_activity_log where Id=$id")->execute();
        if(!$re){
            return json_encode(['state'=>-1,'msg'=>'删除失败']);
        }
        return json_encode(['state'=>0]);
    }

    //进入运营活动页面
    public function actionIndex(){
        return $this->renderPartial('index');
    }

    //ajax 获取运营活动数据
    public function actionGetIndexData(){
        $search=$this->getParam('search');
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset&&$limit){
            $offset=0;
            $limit=10;
        }
        $where='';
        if($search){
            $where="activity.Title like '%$search%'";
        }
        $data=ActiveRecord::findBySql("
        select activity.Title,activity.StartTime,activity.EndTime,
        activity.FirstMoney,activity.DrinkMoney,count(user_activity_log.Id)as UserNum,activity.`Remark`,activity.RowTime
        from activity
        left join user_activity_log on user_activity_log.ActivityId=activity.Id
        ".(empty($where)?'':" where $where"));
        $total=$data->count();
        $datas=ActiveRecord::findBySql($data->sql." limit $offset,$limit")->asArray()->all();
        $result=['total'=>$total,'search'=>$search,'datas'=>$datas,'offset'=>$offset,'limit'=>$limit];
        return json_encode(['data'=>$result]);
    }

    //进入提现记录页面
    public function actionCashWithdrawal(){
        return $this->renderPartial('cash-withdrawal');
    }

    //ajax获取提现记录数据
    public function actionGetCashWithdrawalLog(){
        $search=trim(addslashes($this->getParam('search')));
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if(!$offset&&!$limit){
            $offset=0;
            $limit=10;
        }
        $where='';
        if($search){
            $where=" where user_cash_withdrawal_log.UserName like '%$search%' ";
        }
        $datas=ActiveRecord::findBySql("select distinct Id,user_info.Name,user_info.Tel,
        user_cash_withdrawal_log.UserId,user_cash_withdrawal_log.BankName,
        user_cash_withdrawal_log.BankCardNumber,user_cash_withdrawal_log.UserName,
        user_cash_withdrawal_log.Money,user_cash_withdrawal_log.State,
        user_cash_withdrawal_log.RowTime,user_cash_withdrawal_log.ActTime
        from user_cash_withdrawal_log
        left join user_info on user_info.Id=user_cash_withdrawal_log.UserId
        ");
        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." $where order by user_cash_withdrawal_log.RowTime desc limit $offset,$limit")->asArray()->all();
        return json_encode(['total'=>$total,'data'=>$data]);
    }

    //ajax 提交审核
    public function actionSubmitCheck(){
        $id=$this->getParam('id');//提现记录id
        $state=$this->getParam('state');//审核状态：4 提现失败，5 提现成功
        if(!$id||!$state||($state!=4&&$state!=5)){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $data=ActiveRecord::findBySql("select `UserId`,`BankName`,`BankCardNumber`,`UserName`,`Money` from user_cash_withdrawal_log where Id=$id and State=3")->asArray()->one();
        if(!$data){
            return json_encode(['state'=>-1,'msg'=>'没有该记录']);
        }
        $now=date('Y-m-d H:i:s');
        //修改记录状态
        $sql="update user_cash_withdrawal_log set State=$state,ActTime='$now' where Id=$id";
        $sql2='';
        $sql3='';
        //判断审核状态
        if($state==4){//提现失败
            //将提交 提现记录时扣的赏金 返回账户
            $sql2="update user_info set Money=Money+{$data['Money']} where Id='{$data['UserId']}'";
            //插入退款记录
            $sql3="insert into user_cash_withdrawal_log (`UserId`,`BankName`,`BankCardNumber`,`UserName`,`Money`,`State`,`RowTime`)
            values ('{$data['UserId']}','{$data['BankName']}','{$data['BankCardNumber']}','{$data['UserName']}',{$data['Money']},6,'$now')";
        }
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            $re=\Yii::$app->db->createCommand($sql)->execute();
            if(!$re){
                throw new Exception('更新状态失败');
            }
            if($sql2&&$sql3){
                $re=\Yii::$app->db->createCommand($sql2)->execute();
                if(!$re){
                    throw new Exception('更新账户余额失败');
                }
                $re=\Yii::$app->db->createCommand($sql3)->execute();
                if(!$re){
                    throw new Exception('保存退款记录失败');
                }
            }
            $transaction->commit();
            return json_encode(['state'=>0]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);
        }

    }


}
