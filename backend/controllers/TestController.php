<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午6:36
 */

namespace backend\controllers;


use backend\components\SocketService;
use backend\models\DevActiveLog;
use backend\models\Goods;
use backend\models\TeaBrand;
use backend\models\WaterBrand;
use yii;


ini_set("display_errors", "on");

require_once dirname(__DIR__) . '../api_sdk/vendor/autoload.php';

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

// 加载区域结点配置
Config::load();

class TestController extends  yii\web\Controller
{
    public $ar=[];
    public function actionTest2(){

        $this->Show();
        $red=$this->BubbleSort($this->ar);


        return $this->renderPartial('test2',['red'=>$red]);
    }
    public function Show(){
        static $arr=[];
        $rand=mt_rand(0,9);
        if(!in_array($rand,$arr)){
//        $rand=substr(strval($rand+100),1,2);
            $arr[]=$rand;
            array_push($this->ar,$rand);

            //echo $rand.'&nbsp;&nbsp;';
        }

        if(count($arr)<5){
            $this->Show();
        }


    }

    public  function BubbleSort($array){
        $count = count($array);
        if ($count <= 0) return false;

        for($i=0; $i<$count; $i++){
            for($j=$count-1; $j>$i; $j--){
                if ($array[$j] < $array[$j-1]){
                    $tmp = $array[$j];
                    $array[$j] = $array[$j-1];
                    $array[$j-1] = $tmp;
                }
            }
        }
        return $array;
    }
    public function actionTest(){
        return $this->renderPartial('test');
    }

    //测试发送短信
    static $acsClient = null;

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient() {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = "LTAIAGpTWUAJTnDn"; // AccessKeyId

        $accessKeySecret = "1y6sXfOgswmGmWTlaDLWiXSUViASMW"; // AccessKeySecret

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if(static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public static function sendSms() {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置短信接收号码
        $request->setPhoneNumbers("15228110515");

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName("太极兵智能饮水平台");

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode("SMS_122292355");

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
            "name"=>"小徐",
            "time"=>date('Y-m-d H:i:s',time()+3600*3),
        ), JSON_UNESCAPED_UNICODE));

        // 可选，设置流水号
        //$request->setOutId("yourOutId");

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        //$request->setSmsUpExtendCode("1234567");

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;

    }

    /**
     * 短信发送记录查询
     * @return stdClass
     */
    public static function querySendDetails() {

        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();

        // 必填，短信接收号码
        $request->setPhoneNumber("12345678901");

        // 必填，短信发送日期，格式Ymd，支持近30天记录查询
        $request->setSendDate("20170718");

        // 必填，分页大小
        $request->setPageSize(10);

        // 必填，当前页码
        $request->setCurrentPage(1);

        // 选填，短信发送流水号
        $request->setBizId("yourBizId");

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;
    }

    public function actionTestSms(){
        $response=$this->sendSms();
        var_dump($response);
    }


    public function actionInsert(){
        set_time_limit(0);
        $a=0;
        for($i=1;$i<=1000;$i++){
            $sql="INSERT INTO `agent_shop`(agent_id,shop_name,shop_detail,shop_tel1,image1,open_time,close_time) VALUES ( 67, '压力测试$i', '压力测试', '12345678900','http://7xpcl7.com2.z0.glb.qiniucdn.com/o_1c98vcapk8pc9ea1qvt1gkqnmd11.jpg','2018-03-28 09:43:54','2020-03-28 09:43:54')";
            $re=Yii::$app->db->createCommand($sql)->execute();
            if($re){
                $a++;
            }
        }
        var_dump('添加了'.$a.'条记录');
    }

    public function actionDevRegist(){
        $data=yii\db\ActiveRecord::findBySql("select DISTINCT UserId,AgentId,CustomerType from dev_regist")->asArray()->all();
        var_dump($data);exit;
    }
    public function actionAddGoods(){
        $agent_ids=yii\db\ActiveRecord::findBySql('select DISTINCT agent_id from agent_shop')->asArray()->all();
        foreach($agent_ids as $id){
            $data=yii\db\ActiveRecord::findBySql("select id from agent_goods where agent_id={$id['agent_id']} and goods_id=37")->asArray()->one();
            if(!$data){
                $sql="insert into agent_goods (`agent_id`,`goods_id`,`realprice`,`originalprice`,`goods_starttime`,`goods_endtime`,`stock`)
                VALUES ({$id['agent_id']},37,30,40,'8:00','20:00',100)";
                Yii::$app->db->createCommand($sql)->execute();
            }

        }
        echo '成功';
    }
    public function actionTestGoods(){
        $DevNo='2079111290';
        $BrandName='';
        $GoodsName='';
        $data=yii\db\ActiveRecord::findBySql("select brand_id,goods_id from dev_regist where DevNo='$DevNo'")->asArray()->one();
        $Brand=TeaBrand::findOne(['BrandNo'=>$data['brand_id']]);
        $Goods=Goods::findOne(['id'=>$data['goods_id']]);
        if($Brand){
            $BrandName=$Brand ->BrandName;
        }
        if($Goods){
            $GoodsName=$Goods ->name;
        }        var_dump($BrandName,$GoodsName);
    }

    public function actionCheck(){
        $data1=yii\db\ActiveRecord::findBySql("SELECT DevNo FROM dev_regist WHERE AgentId > 0
        AND
        NOT EXISTS (SELECT 1 FROM dev_cmd
        WHERE CmdType=4 AND State=1 AND DevNo=dev_regist.DevNo) AND IsActive=1")->asArray()->all();
        $data2=yii\db\ActiveRecord::findBySql("select temp.DevNo from ( select DISTINCT dev_action_log.DevNo from dev_action_log where DevNo > 0
) as temp
inner join dev_regist on dev_regist.DevNo=temp.`DevNo`
where
 not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)")->asArray()->all();

        $data3=[];
        foreach($data1 as $v){
            if(!in_array($v,$data2)){
                array_push($data3,$v);
            }
        }

        var_dump($data3);
    }


    public function actionCreateGuid(){
        $charid = strtolower(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 6, 2).substr($charid, 4, 2).
            substr($charid, 2, 2).substr($charid, 0, 2).
            substr($charid, 10, 2).substr($charid, 8, 2).
            substr($charid,14, 2).substr($charid,12, 2).
            substr($charid,16, 4).
            substr($charid,20,12);
    return $uuid;
    }


    //读取文件
    public function actionReadFile(){
        $file = "F:/wt/wt_20180613/wt_20180613.sql";
        $length=3000;
        $line=261391;
        $returnTxt = null; // 初始化返回
        $i = 1; // 行数

        $handle = @fopen($file, "r");
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle, $length);
                if($line == $i) $returnTxt = $buffer;
                $i++;
            }
            fclose($handle);
        }
        return $returnTxt;//$2y$13$B7BPw2yLXCZjIpIE1HrKNuDCc5fB.XSFs8lChvOj5csNAxihYXk72
    }

    //添加模拟坐标数据
    public function actionAddLocation(){

        set_time_limit(0);
        $now=date('Y-m-d H:i:s',time());
        for($i=1;$i<1000;$i++){
            $a=rand(0,1000000)/1000000;
            $b=rand(0,1000000)/1000000;
            $BaiDuLat=rand(3,52)+$a;
            $BaiDuLng=rand(73,134)+$b;
            Yii::$app->db->createCommand("insert into dev_regist (DevNo,AgentId,IsActive,UserId,RowTime)
        values('$i',666,1,'666','$now')")->execute();
            Yii::$app->db->createCommand("insert into dev_location (DevNo,BaiDuLat,BaiDuLng,Lat,Lng)
        values('$i',$BaiDuLat,$BaiDuLng,0,0)")->execute();
        }
        var_dump('ok');

    }

    //删除太极兵服务中心下姓名为空（用户被删除）的电子水票
    Public function actionDeleteOrder(){
        $datas=yii\db\ActiveRecord::findBySql("select user_info.Name,user_restmoney.UserId,
        user_restmoney.CustomerType,user_restmoney.AgentId
        from user_restmoney
        left join user_info on user_restmoney.UserId=user_info.Id
        ")->asArray()->all();

        $result=[];
        foreach($datas as $data){
            if(!$data['Name']){
                $result[]=$data;
            }
        }
//        var_dump($result);exit;
        $num=0;
        if($result){
            foreach($result as $v){
                //删除
                $re=Yii::$app->db->createCommand("delete from user_restmoney where UserId='{$v['UserId']}' and CustomerType={$v['CustomerType']} and AgentId={$v['AgentId']}")->execute();
                if($re)$num++;
            }

        }

        var_dump('成功删除'.$num.'条电子水票！');
    }

    //查看那些用户没有设备
    public function actionCheckUser(){
        $users=yii\db\ActiveRecord::findBySql("select user_info.Id,user_info.Name,dev_regist.DevNo
        from user_info
        left join dev_regist on dev_regist.UserId=user_info.Id
        group by user_info.Id
        ")->asArray()->all();

        $result=[];//没有设备的用户
        foreach($users as $user){
            if(!$user['DevNo']){
                $result[]=$user;
            }
        }
        $num1=0;
        $num2=0;
        if($result){
            foreach($result as $v){
                //删除
                $re1=Yii::$app->db->createCommand("delete from user_info where Id='{$v['Id']}' ")->execute();
                $re2=Yii::$app->db->createCommand("delete from user_restmoney where UserId='{$v['Id']}' ")->execute();
                if($re1)$num1++;
                if($re2)$num2++;
            }

        }
        var_dump('成功删除'.$num1.'条用户信息，'.$num2.'条电子账户');
    }
    //test
    public function actionUserRestmoney(){
        $users=yii\db\ActiveRecord::findBySql("select user_info.Id,user_info.Name,dev_regist.DevNo
        from user_info
        left join dev_regist on dev_regist.UserId=user_info.Id
        group by user_info.Id
        ")->asArray()->all();
        $result=[];//没有设备的用户
        foreach($users as $user){
            if(!$user['DevNo']){
                $result[]=$user;
            }
        }
        $str=strtr(json_encode(array_column($result,'Id')),'[',' ');
        $str=strtr($str,']',' ');
        $str=strtr($str,'"',"'");
        $datas=yii\db\ActiveRecord::findBySql("
        select * from user_restmoney
        where UserId in (
        $str
        )
        ")->asArray()->all();
        var_dump($datas);exit;
    }

    //抓取数据
    public function actionGetDatas(){
        $html = file_get_contents('http://www.baidu.com');
        print_r($http_response_header);
        $fp = fopen('http://www.baidu.com', 'r');
        print_r(stream_get_meta_data($fp));
        fclose($fp);
    }

    //二维数组去重，重复的数量
    public function actionTestArray(){
        $arr=[
            ['a'=>1,'x'=>11],
            ['a'=>1,'x'=>11],
            ['a'=>1,'x'=>11],
            ['a'=>2,'x'=>22],
            ['a'=>2,'x'=>22],
            ['a'=>3,'x'=>33],
        ];
        $temp1=[];
        foreach ($arr as $k=>$v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp1[$k]=$v;
        }
        $temp2=array_unique($temp1); //去掉重复的字符串,也就是重复的一维数组
        $temp3=[];
        foreach ($temp2 as $k => $v){
            $array=explode(',',$v); //再将拆开的数组重新组装
            //下面的索引根据自己的情况进行修改即可
            $temp3[$k]['a'] =$array[0];
            $temp3[$k]['x'] =$array[1];
        }
//        var_dump($temp3);exit;



        foreach($temp3 as &$v){
            $num=0;
            foreach($arr as $v2){
                if($v==$v2){
                    $num++;
                }
            }
            $v['num']=$num;
        }
        var_dump($temp3);
    }



    //删除测试数据
    public function actionDelTestDatas(){
        $DevNo=Yii::$app->request->get('DevNo');
        if(!$DevNo){
           var_dump('参数错误');exit;
        }
        $data=yii\db\ActiveRecord::findBySql("select UserId,AgentId,CustomerType,goods_id from dev_regist where DevNo='$DevNo'")->asArray()->one();
        if(!$data){
            var_dump('没有该设备');exit;
        }
        $arr=[];
        $num=0;
        $transaction=Yii::$app->db->beginTransaction();
        try{
            //删除电子水票账户
            $data1=yii\db\ActiveRecord::findBySql("select Id from user_restmoney where UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}")->asArray()->one();
            if($data1){
                $re=Yii::$app->db->createCommand("delete from user_restmoney where UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']} ")->execute();
                if(!$re){
                    throw new yii\db\Exception('失败1');
                }
                $arr[]='删除电子账户成功';
                $num+=$re;
            }

            //删除充值记录
            $data2=yii\db\ActiveRecord::findBySql("select Id from user_recharge_log where UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}")->asArray()->one();
            if($data2){
                $re=Yii::$app->db->createCommand("delete from user_recharge_log where UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']} ")->execute();
                if(!$re){
                    throw new yii\db\Exception('失败2');
                }
                $arr[]='删除充值记录成功';
                $num+=$re;
            }

            //删除送水记录
            $data3=yii\db\ActiveRecord::findBySql("select Id from send_water_log where UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}")->asArray()->one();
            if($data3){
                $re=Yii::$app->db->createCommand("delete from send_water_log where UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']} ")->execute();
                if(!$re){
                    throw new yii\db\Exception('失败3');
                }
                $arr[]='删除送水记录成功';
                $num+=$re;
            }

            //删除用户
            $data4=yii\db\ActiveRecord::findBySql("select Id from user_info where Id='{$data['UserId']}'")->asArray()->one();
            if($data4){
                $re=Yii::$app->db->createCommand("delete from user_info where Id='{$data['UserId']}'")->execute();
                if(!$re){
                    throw new yii\db\Exception('失败4');
                }
                $arr[]='删除用户成功';
                $num+=$re;
            }

            //删除设备
            $re=Yii::$app->db->createCommand("delete from dev_regist where DevNo='$DevNo' ")->execute();
            if(!$re){
                throw new yii\db\Exception('失败5');
            }
            $arr[]='删除设备成功';
            $num+=$re;

            //还原库存
            $now=date('Y-m-d H:i:s');
            $re=Yii::$app->db->createCommand("update agent_stock set stock=stock+1,update_time='$now' where agent_id={$data['AgentId']} and goods_id={$data['goods_id']} ")->execute();
            if(!$re){
                throw new yii\db\Exception('失败6');
            }
            $arr[]='还原库存成功';
            $num2=$re;

            //删除之前的出库记录
            $data=yii\db\ActiveRecord::findBySql("select * from agent_stock_log where bar_code='$DevNo'")->asArray()->one();
            if($data){
                $re=Yii::$app->db->createCommand("delete from agent_stock_log where bar_code='$DevNo' ")->execute();
                if(!$re){
                    throw new yii\db\Exception('失败7');
                }
                $arr[]='删除之前的出库记录成功';
                $num+=$re;
            }

            $transaction->commit();
            var_dump("成功删除".$num."条数据<br/>成功删除了".$num2."条出库记录<br/>");
            var_dump($arr);
            exit;

        }catch (yii\db\Exception $e){
            $transaction->rollBack();
            var_dump('删除失败');exit;

        }
    }

    //计算每台设备每天的用水量
    public function actionUseWaterEveryDay(){
        set_time_limit(0);
        //1、将扫历史码记录中有用的数据（扫码增加了容量的）保存到一张新表dev_water_scan_log_new
        //只执行一次（最好凌晨执行）
//        $date=date('Y-m-d');
//        $sql1="select * from (select * from
// (select * from dev_water_scan_log where DevNo > 0 and UserId > 0 and Volume > 0
// order by RowTime asc)as dev_water_scan_log_new GROUP BY BarCode,DevNo) as temp where RowTime < '$date'";
//        $scan_log=yii\db\ActiveRecord::findBySql($sql1)->asArray()->all();
//        if($scan_log){
//            //保存今天的扫码数据到dev_water_scan_log_new
//            $sql_str="insert into `dev_water_scan_log_new` (`Id`, `BarCode`, `DevNo`, `UserId`, `Volume`, `Date`, `RowTime`, `ErrorCode`, `BrandNo`, `GoodsId`) values ";
//            foreach($scan_log as $k=>$data){
//                if($k==0){
//                    $sql_str.="('{$data['Id']}','{$data['BarCode']}','{$data['DevNo']}','{$data['UserId']}','{$data['Volume']}','{$data['Date']}','{$data['RowTime']}','{$data['ErrorCode']}','{$data['BrandNo']}','{$data['GoodsId']}')";
//                }else{
//                    $sql_str.=",('{$data['Id']}','{$data['BarCode']}','{$data['DevNo']}','{$data['UserId']}','{$data['Volume']}','{$data['Date']}','{$data['RowTime']}','{$data['ErrorCode']}','{$data['BrandNo']}','{$data['GoodsId']}')";
//                }
//
//            }
//            //插入
//            $re=Yii::$app->db->createCommand($sql_str)->execute();
//            var_dump($re);exit;
//        }

        //2、定时任务将每天码记录中有用的数据（扫码增加了容量的）保存到表dev_water_scan_log_new
        //第二天凌晨将前一天的保存
//        $time1=date('Y-m-d',strtotime('-1 day'));
//        $time1='2018-05-01';
//        $time2='2018-05-02';
////        $time2=date('Y-m-d');
//        $sql2="select * from (select * from
// (select * from dev_water_scan_log where DevNo > 0 and UserId > 0 and Volume > 0
// order by Rowtime asc)as dev_water_scan_log_new GROUP BY BarCode,DevNo) as temp
// where RowTime > '$time1' and RowTime < '$time2'";
//        $datas=yii\db\ActiveRecord::findBySql($sql2)->asArray()->all();
//        if($datas){
//            //保存今天的扫码数据到dev_water_scan_log_new
//            $sql3="insert into `dev_water_scan_log_new` (`Id`, `BarCode`, `DevNo`, `UserId`, `Volume`, `Date`, `RowTime`, `ErrorCode`, `BrandNo`, `GoodsId`) values ";
//            foreach($datas as $k=>$data){
//                if($k==0){
//                    $sql3.="('{$data['Id']}','{$data['BarCode']}','{$data['DevNo']}','{$data['UserId']}','{$data['Volume']}','{$data['Date']}','{$data['RowTime']}','{$data['ErrorCode']}','{$data['BrandNo']}','{$data['GoodsId']}')";
//                }else{
//                    $sql3.=",('{$data['Id']}','{$data['BarCode']}','{$data['DevNo']}','{$data['UserId']}','{$data['Volume']}','{$data['Date']}','{$data['RowTime']}','{$data['ErrorCode']}','{$data['BrandNo']}','{$data['GoodsId']}')";
//                }
//
//            }
//            //插入
//            $re=Yii::$app->db->createCommand($sql3)->execute();
////            var_dump($sql3);exit;
//        }


        //、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、、
        //1、将之前的每台设备的每天用水量保存（只执行一次）
//        $time1=date("Y",time()).'-02-01';
        $time1=Yii::$app->request->get('time1');
        if(!$time1){
            var_dump('参数错误');exit;
        }
        $time2=date("Y-m-d",(strtotime($time1) + 3600*24));
        //下个月的第一天
        $time3=date('Y-m-01',strtotime(date('Y',strtotime($time1)).'-'.(date('m',strtotime($time1))+1).'-01'));
        if($time1 >= date('Y-m-01')){//本月
            $time3=date('Y-m-d',strtotime('-1 day'));//当前日期的前一天
        }
//        var_dump($time1,$time2,$time3);exit;
//        $time2=date("Y",time()).'-02-02';
        $start=time();
//        while($time2 <= date("Y",time()).'-03-01'){//1月的
        while($time2 <= $time3){//1月的
            $this->SaveByDay($time1,$time2);
            $time1=date("Y-m-d",(strtotime($time1) + 3600*24));
            $time2=date("Y-m-d",(strtotime($time2) + 3600*24));
        }
        $end=time();
        var_dump($end-$start);exit;





        //2、凌晨计算每天设备前一天的用水量，保存到dev_use_water_every_day
//        $sql4="select * from (
//select distinct dev_regist.DevNo,(temp.total_volume-temp2.WaterRest)as WaterUse
//from dev_regist
//left join (select DevNo,sum(volume)as total_volume from ((select DevNo,sum(Volume)as volume from (select dev_regist.DevNo,dev_water_scan.Volume
//from dev_regist
//left join (select DevNo,Volume from
//dev_water_scan_log_new
//where RowTime > '$time1' and RowTime < '$time2'
//and DevNo >0) as dev_water_scan on dev_water_scan.DevNo=Dev_regist.DevNo
//where dev_regist.DevNo >0 and dev_regist.AgentId > 0
//)as temp  group by DevNo)
//UNION
//(select * from (select dev_regist.DevNo,temp_table.WaterRest as volume
//from dev_regist
//left join (select DevNo,WaterRest from
//(select DevNo,WaterRest from dev_action_log where ActType=99
//and RowTime < '$time1' and DevNo >0
//order by RowTime desc) as temp group by DevNo)as temp_table
//on dev_regist.DevNo=temp_table.DevNo
//where dev_regist.AgentId > 0)as a))as b group by DevNo) as temp
//on dev_regist.DevNo=temp.DevNo
//
//left join (select dev_regist.DevNo,temp_table.WaterRest
//from dev_regist
//left join (select DevNo,WaterRest from
//(select DevNo,WaterRest from dev_action_log where ActType=99
//and RowTime < '$time2' and DevNo >0
//order by RowTime desc) as temp group by DevNo)as temp_table
//on dev_regist.DevNo=temp_table.DevNo
//where dev_regist.AgentId > 0 )as temp2
//on dev_regist.DevNo=temp2.DevNo
//where dev_regist.AgentId > 0
//)as temp
//where WaterUse > 0";
//
//        $datas2=yii\db\ActiveRecord::findBySql($sql4)->asArray()->all();
//        if($datas2){
//            //保存今天天设备前一天的用水量到dev_use_water_every_day
//            $sql5="insert into `dev_use_water_every_day` ( `DevNo`,`UseVolume`, `Date`) values ";
//            foreach($datas2 as $k=>$data){
//                if($k==0){
//                    $sql5.="('{$data['DevNo']}','{$data['WaterUse']}','$time1')";
//                }else{
//                    $sql5.=",('{$data['DevNo']}','{$data['WaterUse']}','$time1')";
//                }
//
//            }
//            //插入
//            $re=Yii::$app->db->createCommand($sql5)->execute();
////            var_dump($re);exit;
//        }



    }

    public function SaveByDay($time1,$time2){
        //2、凌晨计算每天设备前一天的用水量，保存到dev_use_water_every_day
        $sql4="select * from (
select distinct dev_regist.DevNo,(temp.total_volume-temp2.WaterRest)as WaterUse
from dev_regist
left join (select DevNo,sum(volume)as total_volume from ((select DevNo,sum(Volume)as volume from (select dev_regist.DevNo,dev_water_scan.Volume
from dev_regist
left join (select DevNo,Volume from
dev_water_scan_log_new
where RowTime > '$time1' and RowTime < '$time2'
and DevNo >0) as dev_water_scan on dev_water_scan.DevNo=Dev_regist.DevNo
where dev_regist.DevNo >0 and dev_regist.AgentId > 0
)as temp  group by DevNo)
UNION
(select * from (select dev_regist.DevNo,temp_table.WaterRest as volume
from dev_regist
left join (select DevNo,WaterRest from
(select DevNo,WaterRest from dev_action_log where ActType=99
and RowTime < '$time1' and DevNo >0
order by RowTime desc) as temp group by DevNo)as temp_table
on dev_regist.DevNo=temp_table.DevNo
where dev_regist.AgentId > 0)as a))as b group by DevNo) as temp
on dev_regist.DevNo=temp.DevNo

left join (select dev_regist.DevNo,temp_table.WaterRest
from dev_regist
left join (select DevNo,WaterRest from
(select DevNo,WaterRest from dev_action_log where ActType=99
and RowTime < '$time2' and DevNo >0
order by RowTime desc) as temp group by DevNo)as temp_table
on dev_regist.DevNo=temp_table.DevNo
where dev_regist.AgentId > 0 )as temp2
on dev_regist.DevNo=temp2.DevNo
where dev_regist.AgentId > 0
)as temp
where WaterUse > 0";

        $datas2=yii\db\ActiveRecord::findBySql($sql4)->asArray()->all();
        if($datas2){
            //保存今天天设备前一天的用水量到dev_use_water_every_day
            $sql5="insert into `dev_use_water_every_day` ( `DevNo`,`UseVolume`, `Date`) values ";
            foreach($datas2 as $k=>$data){
                if($k==0){
                    $sql5.="('{$data['DevNo']}','{$data['WaterUse']}','$time1')";
                }else{
                    $sql5.=",('{$data['DevNo']}','{$data['WaterUse']}','$time1')";
                }

            }
            //插入
            $re=Yii::$app->db->createCommand($sql5)->execute();
//            var_dump($re);exit;

        }
        return true;
    }



    public function actionStr(){
        $data=yii\db\ActiveRecord::findBySql("select info.Id as UserId, count(dev_water_scan.UserId)as Amount
from user_info
INNER JOIN (select UserId from dev_water_scan where RowTime > '2018-11-29' and RowTime < '2018-11-30') as dev_water_scan
on dev_water_scan.UserId=user_info.Id
INNER JOIN user_info as info on info.Tel=user_info.RecommendUserTel
where user_info.RecommendUserTel > 0")->asArray()->all();
var_dump($data);exit;
        $str='';
        $new_str=str_replace('`.`','dev_water_scan_log_new',$str);
        var_dump($new_str);exit;

    }



    //修改电子账户及历史数据
    public function actionEditAccount(){
        $num=[];
        $AgentId2=192;
        $DevNo=Yii::$app->request->get('DevNo');
        if(!$DevNo){
            var_dump('参数错误');exit;
        }
        $data=yii\db\ActiveRecord::findBySql("select UserId,AgentId,CustomerType from dev_regist where DevNo='$DevNo'")->asArray()->one();
        if(!$data){
            var_dump('设备不存在');exit;
        }
        //创建事务
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if(!in_array($DevNo,['2810007679','2810007589','2810007578'])){
                //1、修改设备所属服务中心
                $re=Yii::$app->db->createCommand("update dev_regist set AgentId=$AgentId2 where DevNo='$DevNo'")->execute();
                if(!$re){
                    throw new \Exception('修改设备失败！');
                }
                $num[]=1;
                //2、修改电子账户
                $re=Yii::$app->db->createCommand("
                    update user_restmoney set AgentId=$AgentId2
                    where UserId='{$data['UserId']}'
                    and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}
                    ")->execute();
                if(!$re){
                    throw new \Exception('修改电子账户失败！');
                }
                $num[]=2;

            }

            $send_water_log=yii\db\ActiveRecord::findBySql("select 1 from send_water_log where UserId='{$data['UserId']}'
                    and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}")->asArray()->one();
            $recharge_log=yii\db\ActiveRecord::findBySql("select 1 from user_recharge_log where UserId='{$data['UserId']}'
                    and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}")->asArray()->one();
            $scan_log=yii\db\ActiveRecord::findBySql("select 1 from dev_water_scan where DevNo='$DevNo'")->asArray()->one();

            if($send_water_log){
                //3、修改送水记录
                $re=Yii::$app->db->createCommand("
                        update send_water_log set AgentId=$AgentId2
                        where UserId='{$data['UserId']}'
                    and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}
                        ")->execute();
                if(!$re){
                    throw new \Exception('修改送水记录失败！');
                }
                $num[]=3;
            }
            if($recharge_log){
                //4、修改充值记录
                $re=Yii::$app->db->createCommand("
                        update user_recharge_log set AgentId=$AgentId2
                        where UserId='{$data['UserId']}'
                    and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}
                        ")->execute();
                if(!$re){
                    throw new \Exception('修改充值记录失败！');
                }
                $num[]=4;
            }
            if($scan_log){
                //5、修改扫码记录
                $re=Yii::$app->db->createCommand("
                        update dev_water_scan set AgentId=$AgentId2
                        where DevNo='$DevNo'
                        ");
                if(!$re){
                    throw new \Exception('修改扫码记录失败！');
                }
                $num[]=5;

            }


            $transaction->commit();

            var_dump('成功');
            var_dump($num);exit;

        }catch (yii\db\Exception $e) {
            //回滚
            $transaction->rollBack();
            var_dump('失败');
            var_dump($e->getMessage());  //打印抛出的错误
        }

    }


    //保存登记成功拍照图片
    public function actionSavePicture(){
        //通过这个id可以下载上传到微信服务器上的图片文件，把它保存到自己的服务器中
        $serverId=Yii::$app->request->get('serverId');
        $DevNo=Yii::$app->request->get('DevNo');//设备编号
        if(!$serverId||!$DevNo){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $data=yii\db\ActiveRecord::findBySql("select DevNo from dev_regist where DevNo='$DevNo'")->asArray()->one();
        if(!$data){
            return json_encode(['state'=>-1,'msg'=>'该设备不存在']);
        }
        $file_name='http://www.taijibing.cn/static/upload/'.$this->GetMedia($serverId,$DevNo);//图片名称
//        $file_name='http://test.www.taijibing.cn/static/upload/'.$this->GetMedia($serverId,$DevNo);//图片名称
        //保存上传记录
        $now=date('Y-m-d H:i:s',time());
        Yii::$app->db->createCommand("insert into upload_dev_image_log (DevNo,Image,RowTime) values('$DevNo','$file_name','$now')")->execute();

        //保存到对应设备临时图片（等待确认）
        $re=Yii::$app->db->createCommand("update dev_regist set TempImage='$file_name',ImageState=1 where DevNo='$DevNo'")->execute();
        if(!$re){
            return json_encode(['state'=>-1,'msg'=>'保存图片失败']);
        }
        return json_encode(['state'=>0,'image'=>$file_name]);
    }

    // 从微信下载图片保存并获取地址
    public function GetMedia($media_id,$DevNo){
        $access_token=$this->getAccessToken();
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
        if (!file_exists("E:/www/yun/static/upload")) {
            mkdir("E:/www/yun/static/upload", 0777, true);
        }
//        if (!file_exists("E:/www/testwww/static/upload")) {
//            mkdir("E:/www/testwww/static/upload", 0777, true);
//        }
        $file_name=date('YmdHis').'-'.$DevNo.'.jpg';
        $targetName = 'E:/www/yun/static/upload/'.$file_name;
//        $targetName = 'E:/www/testwww/static/upload/'.$file_name;
        $ch = curl_init($url); // 初始化
        $fp = fopen($targetName, 'wb'); // 打开写入
        curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $file_name;
    }

    public function actionSocketService(){
        return $this->renderPartial('sockt');
    }
    public function actionSocketService5(){
        return $this->renderPartial('socket5');
    }


    //计算每台设备每天的用水量
    public function actionWaterUseDay(){
        $time1=Yii::$app->request->get('time1');
        $time2=Yii::$app->request->get('time2');
        $sql1="select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime > '$time1' and ActTime < '$time2' and DevNo > 0 ";
        $sql2="select * from (select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime < '$time1' and DevNo > 0 order by ActTime desc)as temp group by DevNo ";//前一次
        $data=yii\db\ActiveRecord::findBySql("
        select DISTINCT temp2.* from ((".$sql1.") union (".$sql2."))as temp2
        inner join dev_regist on dev_regist.DevNo=temp2.DevNo
        where dev_regist.DevNo > 0 and dev_regist.AgentId >0
        order by ActTime asc,WaterRest desc")->asArray()->all();
        $arr=[];//将设备编号一样的放在一个数组内
        foreach($data as $k=>$v){
            $arr[$v['DevNo']][] = $v;
        }
        //计算每台设备这一天的用水量
        $array=yii\db\ActiveRecord::findBySql("select DevNo,UserId,CustomerType,AgentId from dev_regist
        where AgentId > 0
        ")->asArray()->all();//and not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo = dev_regist.DevNo)
        //将设备编号转换成键名
        $user=array_column($array,null,'DevNo');


//        $water_use=[];
        $sql_str="insert into `dev_use_water_every_day` ( `DevNo`,`UseVolume`, `Date`,`UserId`,`AgentId`,`CustomerType`) values ";
        $tag=0;
        foreach($arr as $key=>$value){
            $UserId=0;
            $AgentId=0;
            $CustomerType=0;
            if(array_key_exists($key,$user)){
                $UserId=$user[$key]['UserId'];
                $AgentId=$user[$key]['AgentId'];
                $CustomerType=$user[$key]['CustomerType'];
            }
            $total=count($value);
            if($total > 1){
//                $water_use[$key]=0;
                $water_use=0;
                foreach($value as $k=>$v){
                    if($k+1 <= $total-1){
                        $use=$v['WaterRest']-$value[$k+1]['WaterRest'];
                        if($use>0){
//                            $water_use[$key]+=$use;
                            $water_use+=$use;
                        }

                    }
                }

                //拼接sql
                if($water_use > 0){
                    $tag++;
                    if($tag==1){
                        $sql_str.="('$key','$water_use','$time1','$UserId',$AgentId,$CustomerType)";
                    }else{
                        $sql_str.=",('$key','$water_use','$time1','$UserId',$AgentId,$CustomerType)";
                    }

                }

            }
        }
        if($tag > 0){
            //执行保存
            $re=Yii::$app->db->createCommand($sql_str)->execute();
            return $re;
        }

        return 0;
    }

//    public function actionEveryDayUse(){
//        set_time_limit(0);
//        $total=0;
//        for($i=0;$i<30;$i++){
//            $a=120-$i;
//            $b=120-$i-1;
//            $time1=date('Y-m-d',strtotime("-$a day"));
//            $time2=date('Y-m-d',strtotime("-$b day"));
//            $re=$this->WaterUse($time1,$time2);
//            $total+=$re;
//        }
//        var_dump($total);exit;
//
//    }



    //批量添加商品
    public function actionAllAgentAddGoods(){
        //获取所有有店铺的代理商id
        $sql="select distinct agent_id from agent_shop ";
        $ids=yii\db\ActiveRecord::findBySql($sql)->asArray()->all();
//        var_dump($ids);exit;
        //拼接sql
        $sql_str="insert into agent_goods (`agent_id`,`goods_id`,`realprice`,`originalprice`,`stock`,`sort`) values ";
        foreach($ids as $k=>$id){
            if($k==0){
                $sql_str.="({$id['agent_id']},45,21,25,1000,1)";
            }else{
                $sql_str.=",({$id['agent_id']},45,21,25,1000,1)";
            }
        }
//        var_dump($sql_str);exit;
        $re=0;
        if($ids){
            //执行sql
            $re=Yii::$app->db->createCommand($sql_str)->execute();
        }
        var_dump('批量为'.count($ids).'家店铺添加商品，执行成功'.$re);

    }

    //查找没有创建电子账户的设备
    public function actionCheckAccount(){
        //正常设备
        $dev=yii\db\ActiveRecord::findBySql("
        select dev_regist.DevNo,dev_regist.UserId,dev_regist.AgentId,
        dev_regist.CustomerType
        from dev_regist
        where AgentId > 0
        ")->asArray()->all();
        //电子账户
        $account=yii\db\ActiveRecord::findBySql("
        select user_restmoney.UserId,user_restmoney.AgentId,
        user_restmoney.CustomerType
        from user_restmoney
        where AgentId=69
        ")->asArray()->all();
        $tag=0;
        $array=[];
        foreach ($dev as $v){
            foreach($account as $a){

                if($v['UserId']==$a['UserId']&&$v['AgentId']==$a['AgentId']&&$v['CustomerType']==$a['CustomerType']){
                    $tag=1;
                }
            }
            if($tag==0){
                $array[]= $v;
            }
        }
        var_dump($array,count($dev),count($account));
    }


    public function actionTestA(){
        $date=yii\db\ActiveRecord::findBySql("select DevNo,UserId,CustomerType,AgentId from dev_regist where AgentId > 0")->asArray()->all();
        $user=array_column($date,null,'DevNo');
        var_dump($user);
    }

    //将水品牌、设备品牌 保存到brands表
    public function actionBrands(){
        $water_brands=yii\db\ActiveRecord::findBySql("select BrandNo,BrandName,RowTime from water_brand")->asArray()->all();
        $dev_brands=yii\db\ActiveRecord::findBySql("select BrandNo,BrandName,RowTime from tea_brand")->asArray()->all();
        $sql="insert into brands (`BrandNo`,`BrandName`,`RowTime`,`CategoryId`) values";
        $tag=0;
        foreach($water_brands as $v){
            if($v){
                if($tag==0){
                    $sql.="('{$v['BrandNo']}','{$v['BrandName']}','{$v['RowTime']}',1)";
                }else{
                    $sql.=",('{$v['BrandNo']}','{$v['BrandName']}','{$v['RowTime']}',1)";
                }
                $tag++;
            }

        }
        foreach($dev_brands as $v){
            if($v){
                if($tag==0){
                    $sql.="('{$v['BrandNo']}','{$v['BrandName']}','{$v['RowTime']}',2)";
                }else{
                    $sql.=",('{$v['BrandNo']}','{$v['BrandName']}','{$v['RowTime']}',2)";
                }
                $tag++;
            }

        }
        $re=Yii::$app->db->createCommand($sql)->execute();
        var_dump($re);

    }


    //今日用水量
    public function actionTodayUse(){
        $time1=date('Y-m-d');
        $time2=date('Y-m-d H:i:s');
        $sql1="select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime > '$time1' and ActTime < '$time2' and DevNo > 0 ";
        $sql2="select * from (select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime < '$time1' and DevNo > 0 order by ActTime desc)as temp group by DevNo ";//前一次
        $data=yii\db\ActiveRecord::findBySql("
        select DISTINCT temp2.* from ((".$sql1.") union (".$sql2."))as temp2
        inner join dev_regist on dev_regist.DevNo=temp2.DevNo
        where dev_regist.DevNo > 0 and dev_regist.AgentId >0
        order by ActTime asc,WaterRest desc")->asArray()->all();
        $arr=[];//将设备编号一样的放在一个数组内
        foreach($data as $k=>$v){
            $arr[$v['DevNo']][] = $v;
        }

        $water_use=0;//用水量
        foreach($arr as $key=>$value){
            $total=count($value);
            if($total > 1){
                foreach($value as $k=>$v){
                    if($k+1 <= $total-1){
                        $use=$v['WaterRest']-$value[$k+1]['WaterRest'];
                        if($use>0){
                            $water_use+=$use;
                        }

                    }
                }
                if($water_use > 100){
                    var_dump($value);exit;
                }else{
                    $water_use=0;
                }
            }
        }

        return $water_use;
    }

    public function actionInfo(){
        $array1=['a'=>1,'b'=>2,'c'=>3];

        var_dump(array_key_exists('a',$array1));exit;
        var_dump(phpinfo());
    }

    //今日用水量 按用户类型、省、市 分别用水量
    public function actionEveryDevUse(){
        $time1=date('Y-m-d');
        $time2=date('Y-m-d H:i:s');
        $sql1="select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime > '$time1' and ActTime < '$time2' and DevNo > 0 ";
        $sql2="select * from (select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime < '$time1' and DevNo > 0 order by ActTime desc)as temp group by DevNo ";//前一次
        $sql="select DISTINCT temp2.*,dev_regist.CustomerType,dev_regist.Province,dev_regist.City
        from ((".$sql1.") union (".$sql2."))as temp2
        inner join dev_regist on dev_regist.DevNo=temp2.DevNo
        where dev_regist.DevNo > 0 and dev_regist.AgentId >0
        order by ActTime asc,WaterRest desc";
        $datas=yii\db\ActiveRecord::findBySql($sql)->asArray()->all();
        //将设备编号一样的放在一个数组内
        $arr=[];
        foreach($datas as $data){
            $arr[$data['DevNo']][]=$data;
        }

        $customertype_data=[];
        $province_data=[];
        $city_data=[];
        foreach($arr as $key=>$value) {
            $total = count($value);
            if ($total > 1) {
                $water_use = 0;
                foreach ($value as $k => $v) {
                    if ($k + 1 <= $total - 1) {
                        $use = $v['WaterRest'] - $value[$k + 1]['WaterRest'];
                        if ($use > 0) {
                            $water_use += $use;
                        }

                    }
                }
                if($water_use > 0){
                    $customertype_data[$value[0]['CustomerType']]+=$water_use;
                    $province_data[$value[0]['Province']]+=$water_use;
                    $city_data[$value[0]['City']]+=$water_use;
                }
            }
        }


        var_dump($customertype_data,$province_data,$city_data);exit;

    }

    //为了兼容之前送水的账户逻辑
    //将之前最后一次送水的容量和时间更新到已有逻辑
    public function actionAddDatas(){
        //新上线后没有送水的账户
        //获取这些账户最后一次送水的容量、时间

        $sql_str="select * from (
    SELECT Id,date,RowTime,SUM(TotalSendV) as TotalSendV FROM (
    SELECT new_table.Id,DATE(send_water_log.RowTime)AS `date`,
            send_water_log.RowTime,(send_water_log.Volume*send_water_log.Amount)AS TotalSendV
            FROM send_water_log
            INNER JOIN (SELECT Id,UserId,AgentId,CustomerType
                FROM user_restmoney
                WHERE GroupId=0 AND LastSendTime < '2018-10-20')AS new_table
            ON new_table.UserId=send_water_log.UserId
            AND new_table.AgentId=send_water_log.AgentId
            AND new_table.CustomerType=send_water_log.CustomerType
            WHERE send_water_log.RowTime > '2018-08-25'
            AND send_water_log.RowTime < '2018-10-20'
            ORDER BY RowTime DESC

)AS temp GROUP BY Id,date ORDER BY date desc)AS temp GROUP BY Id";

        $datas=yii\db\ActiveRecord::findBySql($sql_str)->asArray()->all();

        //拼接sql
        $str1='';
        $str2='';
        $str3='';
        $ids='';
        foreach($datas as $data){
            //拼接sql

            if($ids==''){
                $ids.="{$data['Id']}";
            }else{
                $ids.=",{$data['Id']}";
            }
            $str1.=" WHEN {$data['Id']} THEN {$data['TotalSendV']} ";//上次送水量
            $str2.=" WHEN {$data['Id']} THEN '{$data['date']}' ";//日期
            $str3.=" WHEN {$data['Id']} THEN '{$data['RowTime']}' ";//时间
        }

        $sql="update user_restmoney set
        LastSendV = CASE Id $str1 END,
        LastSendDate = CASE Id $str2 END,
        LastSendTime = CASE Id $str3 END where Id in ($ids)";
        $re=Yii::$app->db->createCommand($sql)->execute();
        var_dump($re);
    }

    //恢复删除的数据
    public function actionComeDel(){
        $DevNo='2810006296';
        $data=yii\db\ActiveRecord::findBySql("SELECT * FROM dev_regist WHERE DevNo='2810006296'")->asArray()->one();
        $dev_sql="insert into dev_regist (`DevNo`,`AgentId`,`UserId`,`DevBindMobile`,`RowTime`,`IsActive`,`Date`,`UseType`,`CustomerType`,`Province`,`City`,`Area`,`Address`,`brand_id`,`goods_id`,`investor_id`,`Lat`,`Lng`,`Iccid`,`DevType`)
        values('{$data['DevNo']}',{$data['AgentId']},'{$data['UserId']}','{$data['DevBindMobile']}','{$data['RowTime']}',{$data['IsActive']},'{$data['Date']}',{$data['UseType']},
        {$data['CustomerType']},'{$data['Province']}','{$data['City']}','{$data['Area']}','{$data['Address']}','{$data['brand_id']}',{$data['goods_id']},{$data['investor_id']},'{$data['Lat']}','{$data['Lng']}','{$data['Iccid']}','{$data['DevType']}')";

        $user_restmoney=yii\db\ActiveRecord::findBySql("SELECT * FROM user_restmoney WHERE UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}")->asArray()->one();
        $restmoney_sql="insert into user_restmoney (`UserId`,`CustomerType`,`AgentId`,`RestMoney`,`LastActTime`,`TotalSendV`,`LastSendV`,`LastSendDate`,`LastSendTime`,`UseVolume`,`RestWater`,`SendWaterTime`,`AverageUse`,`State`,`GroupId`,`CreateTime`)
        values ('{$user_restmoney['UserId']}',{$user_restmoney['CustomerType']},{$user_restmoney['AgentId']},{$user_restmoney['RestMoney']},'{$user_restmoney['LastActTime']}',
        {$user_restmoney['TotalSendV']},{$user_restmoney['LastSendV']},'{$user_restmoney['LastSendDate']}','{$user_restmoney['LastSendTime']}',{$user_restmoney['UseVolume']},{$user_restmoney['RestWater']},'{$user_restmoney['SendWaterTime']}',{$user_restmoney['AverageUse']},{$user_restmoney['State']},{$user_restmoney['GroupId']},'{$user_restmoney['CreateTime']}')";

        $user_info_sql="insert into user_info (`Id`,`Name`,`Tel`,`Address`,`RowTime`,`Province`,`City`,`Area`)
VALUES ('e713db9bba5846beb895de6eeb1a3505','陈学冠','13678106868','郦景东城怡福路266号7幢2单元6号','2018-06-10 18:46:56',
'四川省','成都市','成华区')";

        $recharge_log_sql="insert into user_recharge_log (`UserId`,`CustomerType`,`AgentId`,`PayMoney`,`PayType`,`RestMoney`,`RowTime`,`OutOrIn`,`GroupMemberId`)
        values ('e713db9bba5846beb895de6eeb1a3505',1,141,600,1,600,'2018-06-10 18:46:55',0,0)";

        $send=yii\db\ActiveRecord::findBySql("select * from send_water_log where UserId='{$data['UserId']}' and AgentId={$data['AgentId']} and CustomerType={$data['CustomerType']}")->asArray()->all();
        $str='';
        $send_water_sql="insert into send_water_log (`UserId`,`CustomerType`,`AgentId`,`WaterBrandNo`,`WaterGoodsId`,`Volume`,`Amount`,`UseMoney`,`RestMoney`,`SendTime`,`Price`,`State`,`RowTime`,`From`) values ";
        foreach($send as $v){
            if(!$str){
                $str.="('{$v['UserId']}',{$v['CustomerType']},{$v['AgentId']},'{$v['WaterBrandNo']}',{$v['WaterGoodsId']},{$v['Volume']},{$v['Amount']},{$v['UseMoney']},{$v['RestMoney']},'{$v['SendTime']}',{$v['Price']},{$v['State']},'{$v['RowTime']}',{$v['From']})";
            }else{
                $str.=",('{$v['UserId']}',{$v['CustomerType']},{$v['AgentId']},'{$v['WaterBrandNo']}',{$v['WaterGoodsId']},{$v['Volume']},{$v['Amount']},{$v['UseMoney']},{$v['RestMoney']},'{$v['SendTime']}',{$v['Price']},{$v['State']},'{$v['RowTime']}',{$v['From']})";

            }
        }
        $send_water_sql=$send_water_sql.$str;


    var_dump($send_water_sql);exit;
    var_dump($dev_sql.'<bar/>'.$restmoney_sql.'<bar/>');

    }

}

