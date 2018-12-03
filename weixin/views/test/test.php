<?php
error_reporting(E_ALL & ~ E_NOTICE);

header('Content-Type:text/html; charset=utf-8');

//设置时区
date_default_timezone_set('PRC');

//连接数据库
$conn=@mysqli_connect('127.0.0.1','root','W123_@#w','wt') or die('数据库连接失败');
//$conn=@mysqli_connect('127.0.0.1','root','root','wt') or die('数据库连接失败');
mysqli_query($conn,'set names utf8');

//装机赏金（账户赏金余额修改、修改即将获得赏金记录状态）
//已经提交推荐（即将获得赏金的记录）并且 已经装机 激活的
$sql1="select DISTINCT user_recommend_log.Id,user_recommend_log.UserId,
user_recommend_log.FirstMoney,user_recommend_log.DrinkMoney,user_info.Money
from user_recommend_log 
INNER JOIN dev_regist on dev_regist.UserId=user_recommend_log.UserId 
INNER JOIN user_info on user_info.Id=user_recommend_log.UserId 
where user_recommend_log.State=0 and dev_regist.AgentId > 0
and dev_regist.IsActive=1";

$rs=mysqli_query($conn,$sql1);
$arr=[];

while($row=mysqli_fetch_assoc($rs)){

    $arr[$row['UserId']][]=$row;//将用户id一样的放在一个数组内
}

//计算每个用户可获得的奖金、修改奖金余额、修改推荐记录状态

$ids='';//推荐记录id
$UserIds='';//用户id
$str1='';//修改即将获得赏金记录状态
$str2='';//修改用户赏金余额
$tag=0;
foreach($arr as $k=>$v){
    $tag++;
    $money=0;//可获得的赏金

    if(!$UserIds){
        $UserIds.="$k";
    }else{
        $UserIds.=",$k";
    }

    foreach($v as $value){
        $str1.=" WHEN {$value['Id']} THEN 1 ";//修改即将获得赏金记录状态
        if(!$ids){
            $ids.="{$value['Id']}";
        }else{
            $ids.=",{$value['Id']}";
        }
        $money+=$value['FirstMoney'];

    }
    $rest_money=$v['Money']+$money;

    //拼接sql
    $str2.=" WHEN $k THEN $rest_money ";//用户id与修改的赏金余额对应

    //批量执行
    if($tag==1000){
        $sql1="update user_recommend_log set State = CASE Id $str1 END where Id in ($Ids)";
        $sql2="update user_info set State = CASE Id $str2 END where Id in ($UserIds)";
        //执行更新
        $rs=mysqli_query($conn,$sql1);
        $rs=mysqli_query($conn,$sql2);
        $tag=0;
        $str1='';
        $str2='';
        $Ids='';
        $UserIds='';
    }
}

//批量执行
if($tag > 0){
    $sql1="update user_recommend_log set State = CASE Id $str1 END where Id in ($Ids)";
    $sql2="update user_info set State = CASE Id $str2 END where Id in ($UserIds)";
    //执行更新
    $rs=mysqli_query($conn,$sql1);
    $rs=mysqli_query($conn,$sql2);
}

//计算今天扫码用户的推荐人 应获取的赏金
//今天所有 有推荐人的用户 扫码数量、对应活动赏金（有效期内的）
$yesterday=date('Y-m-d',strtotime('-1 day'));//昨日
$today=date('Y-m-d');//今日
$sql1="select info.Id as UserId, count(info.Id)as Amount,dev_water_scan.RowTime,
	activity.FirstMoney,activity.DrinkMoney,activity.Id,user_info.Money
	from user_info 
	INNER JOIN (select UserId,RowTime from dev_water_scan where RowTime > '$yesterday' and RowTime < '$today')
	as dev_water_scan on dev_water_scan.UserId=user_info.Id
	INNER JOIN user_info as info on info.Tel=user_info.RecommendUserTel
	INNER JOIN activity on activity.Id=user_info.ActivityId
	where user_info.RecommendUserTel > 0 and activity.StartTime < NOW() and activity.EndTime > NOW()
	GROUP BY info.Id";

$rs=mysqli_query($conn,$sql1);
$array=[];

while($row=mysqli_fetch_assoc($rs)){
    $array[]=$row;
}
//有效期内的默认活动
$sql2="select FirstMoney,DrinkMoney from activity where State=1 and StartTime < NOW() and EndTime > NOW() limit 1";
$rs=mysqli_query($conn,$sql2);
$default_activity=mysqli_fetch_row($rs);
//修改账户赏金余额，添加赏金记录
$update_sql='';
$insert_sql="insert into user_recommend_log (`UserId`,`ActivityId`,`State`,`FirstMoney`,`DrinkMoney`,`Amount`,`RowTime`) values ";
$str='';
$UserIds='';
$tag=0;
foreach($array as $v){

    $user_id=$v['UserId'];
    $RowTime=$v['RowTime'];
    if($v['DrinkMoney']){//有指定活动 在有效期内
        $tag++;
        $rest_money=$v['Money']+$v['Amount']*$v['DrinkMoney'];
        if($UserIds){
            $UserIds.=",$user_id";
        }else{
            $UserIds.="$user_id";
        }
        //拼接sql
        //修改账户赏金余额
        $str.=" WHEN {$v['UserId']} THEN $rest_money ";
			//添加赏金记录
			if($tag > 1){
                $insert_sql.=",('user_id',{$v['Id']},2,{$v['FirstMoney']},{$v['DrinkMoney']},{$v['Amount']},'$RowTime')";
            }else{
                $insert_sql.="('user_id',{$v['Id']},2,{$v['FirstMoney']},{$v['DrinkMoney']},{$v['Amount']},'$RowTime')";
            }
			
			
			
		}elseif(!$v['DrinkMoney']&&$default_activity['DrinkMoney']){//有效期内的默认活动
            $tag++;
            $rest_money=$v['Money']+$v['Amount']*$default_activity['DrinkMoney'];
            if($UserIds){
                $UserIds.=",$user_id";
            }else{
                $UserIds.="$user_id";
            }
            //拼接sql
            //修改账户赏金余额
            $str.=" WHEN {$v['UserId']} THEN $rest_money ";
                //添加赏金记录
                if($tag > 1){
                    $insert_sql.=",('user_id',{$v['Id']},2,{$v['FirstMoney']},{$v['DrinkMoney']},{$v['Amount']},'$RowTime')";
                }else{
                    $insert_sql.="('user_id',{$v['Id']},2,{$v['FirstMoney']},{$v['DrinkMoney']},{$v['Amount']},'$RowTime')";
                }
            }

            if($tag==1000){
                $update_sql="update user_info set Money = CASE Id $str END where Id in ($UserIds)";

                //执行更新
                $rs=mysqli_query($conn,$update_sql);
                $rs=mysqli_query($conn,$insert_sql);
                $tag=0;
                $str='';
                $update_sql='';
                $insert_sql="insert into user_recommend_log (`UserId`,`ActivityId`,`State`,`FirstMoney`,`DrinkMoney`,`Amount`,`RowTime`) values ";
                $UserIds='';
            }
		
		
	}

if($tag > 0){
    $update_sql="update user_info set Money = CASE Id $str END where Id in ($UserIds)";

    //执行更新
    $rs=mysqli_query($conn,$update_sql);
    $rs=mysqli_query($conn,$insert_sql);
}




mysqli_close($conn);
		
 










