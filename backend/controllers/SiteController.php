<?php
namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);
use backend\models\AdminRoleUser;
use backend\models\AgentInfo;
use backend\models\CustomSearch;
use backend\models\DevError;
use backend\models\DevWaterScan;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\filters\VerbFilter;


/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $today_use=0;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','language', 'captcha'],
                        'allow' => true,
                    ],
                    [
//                        'actions' => ['logout', 'index', 'main','get-province','today-datas','agenty-sales','agentf-sales','user-type-sales','dev-distribution','real-time-datas','line-datas'],
                        'actions' => ['logout', 'index', 'main','get-datas-by-where'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0x66b3ff,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 10,//间距
                'height'=>34,//高度
                'width' => 100,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>16,        //设置字符偏移量 有效果
            ],
        ];
    }

    public function actionIndex()
    {
        $province=$this->getParam('province');
        $real_time=$this->getParam('real_time');//1 实时获取，0
        $login_id=Yii::$app->getUser()->id;
        $role_id=(new AdminRoleUser())->findOne(['uid'=>$login_id])->role_id;
        $all_datas=$this->GetAllDatas($province,$real_time);
        return $this->renderPartial('index',['role_id'=>$role_id,'all_datas'=>$all_datas]);
    }
    //根据省份获取首页数据
    public function actionGetDatasByWhere(){
        $province=$this->getParam('province');
        $real_time=$this->getParam('real_time');
        $all_datas=$this->GetAllDatas($province,$real_time);
        return json_encode($all_datas);
    }

    //获取首页所有数据
    public function GetAllDatas($province='',$real_time){
        //1、省份数据
        $all_province=$this->GetProvince();
        //2、今日数据
        $today_datas=$this->TodayDatas($province);

            $AgentySales=$this->AgentySales($province);
            $AgentfSales=$this->AgentfSales($province);
            $DevDistribution=$this->DevDistribution($province);
            $RealTimeDatas=$this->RealTimeDatas($province);
            $UserTypeSales=$this->UserTypeSales($province);
            $LineDatas=$this->LineDatas($province);//执行在RealTimeDatas 之后 好复用 今日用水量数据
//        }

        return ['all_province'=>$all_province,//1、省份数据
                'today_datas'=>$today_datas,//2、今日数据
                'AgentySales'=>$AgentySales,//3、运营中心销量排名（本月前五）
                'AgentfSales'=>$AgentfSales,//4、服务中心销量排名（本月前五）
                'DevDistribution'=>$DevDistribution,//5、设备分布情况
                'RealTimeDatas'=>$RealTimeDatas,//6、实时数据
                'UserTypeSales'=>$UserTypeSales,//7、用户类型和销量占比
                'LineDatas'=>$LineDatas,//8、折线图数据
        ];
    }



    public function actionMain()
    {
        //角色id
        $login_id=Yii::$app->getUser()->id;
        $role_id=(new AdminRoleUser())->findOne(['uid'=>$login_id])->role_id;


//        $dynamicAgentData=  AgentInfo::getLatestData();
//        $dynamicUserData=CustomSearch::getLatestData();
//        $dynamicDevErrData=DevError::getLatestData();
//
//        $xagentTotal=AgentInfo::findBySql("select * from agent_info where Level = 4")->count();
//        $sagentTotal=AgentInfo::findBySql("select * from agent_info where Level = 5")->count();
////        $userinfoTotal=CustomSearch::findBySql("select * from user_info")->count();
//        $userinfoTotal=CustomSearch::findBySql("select * from dev_regist where IsActive=1 and DevNo>0
//and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
//")->count();
////        $devError=ActiveRecord::findBySql("select * from msg_notify_dev_error")->count();
//        $devError=ActiveRecord::findBySql("select DevNo from dev_warning where State=0 group by DevNo")->count();
//        $sellout=DevWaterScan::getMonthSellAmount();
//        $selloutPackage=DevWaterScan::getMonthSellPackageAmount();

        //从缓存文件获取数据
        $province=$this->getParam('province');
        $real_time=$this->getParam('real_time');
        $all_datas=$this->GetAllDatas($province,$real_time);




        return $this->render("main",[
//            "data"=>$sellout,
//            "dynamicAgentData"=>$dynamicAgentData,
//            "dynamicUserData"=>$dynamicUserData,
//            "dynamicDevErrData"=>$dynamicDevErrData,
//            "xagentTotal"=>$xagentTotal,
//            "sagentTotal"=>$sagentTotal,
//            "userinfoTotal"=>$userinfoTotal,
//            "devError"=>$devError,
//            "selloutPackage"=>$selloutPackage,
            "role_id"=>$role_id,
            'all_datas'=>$all_datas,
            'province'=>$province,
        ]);
    }
    public function actionLogin()
    {

        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->getUser()->logout(false);
        return $this->goHome();
    }
    public function actionLanguage(){
        $language=  Yii::$app->getRequest()->get('lang');
        if(isset($language)){
            Yii::$app->session['language'] = $language;
        }
        $this->goBack(Yii::$app->getRequest()->headers['referer']);
    }

    //省份数据
    public function GetProvince(){
        $province=ActiveRecord::findBySql("select `Name` from address_tree where PId=0")->asArray()->all();
        return json_encode($province);
    }

    //今日数据
    public function TodayDatas($province){
        //$province=$this->getParam('province');

        //用户数量
        $user_num=ActiveRecord::findBySql("select DevNo from dev_regist where ".(empty($province)?'':" Province='$province' and ")." IsActive=1 and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and AgentId > 0")->count();
        //运营中心数量
        $agenty_num=ActiveRecord::findBySql("select Id from agent_info where ".(empty($province)?'':" Province='$province' and ")." `Level`=4")->count();
        //服务中心数量
        $agentf_num=ActiveRecord::findBySql("select Id from agent_info where ".(empty($province)?'':" Province='$province' and ")." `Level`=5")->count();
        //水厂数量
        $factory_num=ActiveRecord::findBySql("select Id from factory_info ".(empty($province)?'':" where Province='$province'"))->count();
        //设备厂家数量
        $devfactory_num=ActiveRecord::findBySql("select Id from dev_factory".(empty($province)?'':" where Province='$province'"))->count();

        return json_encode(['user_num'=>$user_num,'agenty_num'=>$agenty_num,'agentf_num'=>$agentf_num,'factory_num'=>$factory_num,'devfactory_num'=>$devfactory_num]);

    }

    //运营中心销量排名（本月前五）
    public function AgentySales($province){

        //本月第一天0点
        $first_day=date('Y-m-01'.' 00:00:00', strtotime(date("Y-m-d")));
        //当前时间
        $now=date('Y-m-d H:i:s',time());

        $sql="select agent_info.Name,temp4.num from
agent_info
INNER JOIN

(select ParentId,SUM(num) AS num from (
(select agent.ParentId,temp.num  from
(
select * from
(SELECT `Level`,ParentId,sum(num) as num from

(select agent2.`Level`,agent_info.Id,agent_info.Name,temp2.num,agent_info.ParentId from agent_info
left join
(select AgentId,count(BarCode) as num from
(select BarCode,AgentId from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now')as temp
GROUP BY AgentId)as temp2
on agent_info.Id=temp2.AgentId
left join agent_info as agent2 on agent2.Id=agent_info.ParentId
where agent_info.Level=5
)as temp3

GROUP BY ParentId
ORDER BY num desc)as temp where `Level`=7)as temp
left join agent_info as agent on agent.Id=temp.ParentId)
UNION
(select temp.ParentId,temp.num  from
(
select * from
(SELECT Level,ParentId,sum(num) as num from

(select agent2.`Level`,agent_info.Id,agent_info.Name,temp2.num,agent_info.ParentId from agent_info
left join
(select AgentId,count(BarCode) as num from
(select BarCode,AgentId from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now')as temp
GROUP BY AgentId)as temp2
on agent_info.Id=temp2.AgentId
left join agent_info as agent2 on agent2.Id=agent_info.ParentId
where agent_info.Level=5
)as temp3

GROUP BY ParentId
ORDER BY num desc)as temp where Level=4)as temp
))as now_table

GROUP BY ParentId
ORDER BY num desc limit 5)as temp4
on agent_info.Id=temp4.ParentId
where agent_info.`Level`=4".(empty($province)?'':" and agent_info.Province='$province' ");
        $datas=ActiveRecord::findBySql($sql)->asArray()->all();
        $total_sales=ActiveRecord::findBySql("select BarCode from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now'")->count();

        //}
        return json_encode(['total_sales'=>$total_sales,'datas'=>$datas]);

    }

    //服务中心销量排名（本月前五）
    public function AgentfSales($province){

            //本月第一天0点
            $first_day = date('Y-m-01' . ' 00:00:00', strtotime(date("Y-m-d")));
            //当前时间
            $now = date('Y-m-d H:i:s', time());

            $sql = "select agent_info.Name,temp2.num from agent_info
left join
(select AgentId,count(BarCode) as num from
(select BarCode,AgentId from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now')as temp
GROUP BY AgentId)as temp2
on agent_info.Id=temp2.AgentId
where agent_info.Level=5
" . (empty($province) ? '' : " and agent_info.Province='$province' ") . "
ORDER BY num desc limit 5";
            $datas = ActiveRecord::findBySql($sql)->asArray()->all();
            $total_sales = ActiveRecord::findBySql("select BarCode from dev_water_scan where DevNo > 0 and RowTime > '$first_day' and RowTime < '$now'")->count();
//        }
        return json_encode(['total_sales'=>$total_sales,'datas'=>$datas]);

    }

    //设备分布情况
    public function DevDistribution($province){

            //设备分布省份
            $datas = ActiveRecord::findBySql("select Province,City,Area from dev_regist
where " . (empty($province) ? '' : " Province='$province' and ") . " IsActive=1
and DevNo > 0 and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and AgentId > 0")->asArray()->all();
            //设备分布坐标(没有预警的设备)
            $str = "select dev_location.BaiDuLat,dev_location.BaiDuLng,dev_regist.DevNo
from dev_location
inner join dev_regist on dev_location.DevNo=dev_regist. DevNo
where " . (empty($province) ? '' : " dev_regist.Province='$province' and ") . "
dev_regist.DevNo > 0
and dev_regist.IsActive=1
and not exists
(select DevNo from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0";

            $dev_location = ActiveRecord::findBySql("$str
and  not exists (select 1 from dev_warning where state=0 and DevNo=dev_regist.DevNo)
")->asArray()->all();

            //预警的设备
            $warning_devnos = ActiveRecord::findBySql("$str
and  exists (select 1 from dev_warning where state=0 and DevNo=dev_regist.DevNo)")->asArray()->all();

            //待激活设备数量
            $not_active = ActiveRecord::findBySql("select DevNo from dev_regist where
" . (empty($province) ? '' : " Province='$province' and ") . "IsActive=0
and DevNo > 0 and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0")->count();
            //正常设备数量
            $dev_active = ActiveRecord::findBySql("select DevNo from dev_regist where
" . (empty($province) ? '' : " Province='$province' and ") . " IsActive=1
and DevNo > 0 and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
and  not exists (select 1 from dev_warning where state=0 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0
")->count();
            //预警设备数量
//        $dev_warning=ActiveRecord::findBySql("select temp.DevNo from (select DevNo from dev_warning
//where State=0 group by DevNo)as temp
//INNER JOIN dev_regist on dev_regist.DevNo=temp.DevNo
//where dev_regist.IsActive=1 and dev_regist.DevNo > 0
//and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
//".(empty($province)?'':" and dev_regist.Province='$province' "))->count();
            //非重复条码预警数量
            $dev_warning1 = ActiveRecord::findBySql("select dev_warning.DevNo from dev_warning
INNER JOIN dev_regist on dev_regist.DevNo=dev_warning.DevNo
where dev_regist.IsActive=1 and dev_regist.AgentId > 0
and dev_warning.State=0 and dev_warning.Type <> '重复条码'
" . (empty($province) ? '' : " and dev_regist.Province='$province' "))->count();
            //重复条码预警数量
            $dev_warning2 = ActiveRecord::findBySql("select dev_warning.DevNo from dev_warning
INNER JOIN dev_regist on dev_regist.DevNo=dev_warning.DevNo
where dev_regist.IsActive=1 and dev_regist.AgentId > 0
and dev_warning.State=0 and dev_warning.Type = '重复条码'
" . (empty($province) ? '' : " and dev_regist.Province='$province' ") . " group by dev_warning.BarCode ")->count();
            $dev_warning = $dev_warning1 + $dev_warning2;
//        }
        return json_encode(['dev_location'=>$dev_location,'not_active'=>$not_active,'dev_active'=>$dev_active,'dev_warning'=>$dev_warning,'datas'=>$datas,'warning_devnos'=>$warning_devnos]);
    }

    //实时数据
    public function RealTimeDatas($province){

            $str = '';
            if ($province) {
                $str = " left join dev_regist on dev_water_scan.DevNo=dev_regist.DevNo ";
            }
            //今日销量
            $today = date('Y-m-d' . ' 00:00:00', time());//今日0点
            $last_30 = date('Y-m-d' . ' 00:00:00', strtotime('-30 day'));//近30天0点
            $now = date('Y-m-d H:i:s', time());//当前时间

            $today_sales = ActiveRecord::findBySql("select BarCode
from dev_water_scan
$str
where " . (empty($province) ? '' : "  dev_regist.Province='$province' and ") . "
 dev_water_scan.RowTime >= '$today'  and dev_water_scan.DevNo > 0 ")->count();
            //近30天销量
            $total_sales = ActiveRecord::findBySql("select BarCode
from dev_water_scan
$str
where " . (empty($province) ? '' : "  dev_regist.Province='$province' and ") . "
dev_water_scan.RowTime >= '$last_30' and dev_water_scan.DevNo > 0 ")->count();

            //今日用水量
            $today_wateruse = $this->TodayUse($province);
            $this->today_use=$today_wateruse;//保存到全区，方便折线图数据取
            //近30天用水量(统计到昨天的 + 今天的)
            $total_wateruse = $this->WaterUseVolume($last_30, date('Y-m-d'), $province)+$today_wateruse;
//        }
        return json_encode(['today_sales'=>$today_sales,
            'total_sales'=>$total_sales,
            'today_wateruse'=>$today_wateruse,
            'total_wateruse'=>$total_wateruse]);

    }

    //用户类型和销量占比
    public function UserTypeSales($province){

            //饼状图（用户类型占比）
            $usertype = ActiveRecord::findBySql("select CustomerType,count(CustomerType) as num from
(select DevNo,CustomerType from dev_regist where
" . (empty($province) ? '' : " Province='$province' and ") . "
DevNo > 0 and IsActive=1 and AgentId > 0
and  not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo))as temp
GROUP BY CustomerType")->asArray()->all();

            //各类型销量占比（本月）
            //本月第一天0点
            $first_day = date('Y-m-01' . ' 00:00:00', strtotime(date("Y-m-d")));
            //当前时间
            $now = date('Y-m-d H:i:s', time());
            $datas = ActiveRecord::findBySql("SELECT CustomerType,SUM(num) AS num FROM

        (SELECT dev_regist.CustomerType,temp2.num FROM dev_regist
INNER JOIN
        (SELECT DevNo,COUNT(DevNo) AS num FROM
        (SELECT DevNo FROM dev_water_scan WHERE DevNo > 0 AND RowTime > '$first_day' AND RowTime < '$now')AS temp
GROUP BY DevNo)AS temp2
ON dev_regist.DevNo=temp2.DevNo
" . (empty($province) ? '' : " where dev_regist.Province='$province' ") . "
)AS temp3
GROUP BY CustomerType")->asArray()->all();
//        }

        return json_encode(['usertype'=>$usertype,'datas'=>$datas]);

    }


    //折线图数据
    public function LineDatas($province){

            $date_15 = date('Y-m-d', strtotime('-15 day'));
            //用户增长
            $user_increase = $this->UserIncrease($province, $date_15);
            //销量
            $user_sales = $this->Sales($province, $date_15);
            //用水量
            $use_status = $this->WaterUse($date_15,date('Y-m-d'),$province);
            //将上面计算的今天的用水量加入
            array_push($use_status,['WaterUse'=>$this->today_use,'ActDate'=>date('Y-m-d')]);

        return json_encode(['user_increase'=>$user_increase,
                            'user_sales'=>$user_sales,
                            'use_status'=>$use_status,
                            ]);

    }




    //用户增长接口(近15天的增长情况)
    public function UserIncrease($province,$date_15){
//        $province=$this->getParam('province');

//        $date_15=date('Y-m-d',strtotime('-14 day'));
        $datas=ActiveRecord::findBySql("select CustomerType,`Date` from dev_regist
where ".(empty($province)?'':" dev_regist.Province='$province' and ")."
DevNo > 0 and IsActive=1
and  not exists (select DevNo from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
 and RowTime > '$date_15' and dev_regist.AgentId > 0")->asArray()->all();
        return $datas;
    }

    //销量（近15天的销量情况）
    public function Sales($province,$date_15){
//        $province=$this->getParam('province');
        $str='';
        if($province){
            $str=" left join dev_regist on dev_regist.DevNo=dev_water_scan.DevNo ";
        }

//        $date_15=date('Y-m-d',strtotime('-14 day'));
        $datas=ActiveRecord::findBySql("select dev_water_scan.Volume,dev_water_scan.`Date` from dev_water_scan
$str
where ".(empty($province)?'':" dev_regist.Province='$province' and ")."
dev_water_scan.DevNo > 0 and dev_water_scan.RowTime > '$date_15'")->asArray()->all();
        return $datas;
    }


    public function WaterUse($time1,$time2,$province){
        $where_str='';
        $join_str='';
        if($province){
            $where_str=" and dev_regist.Province='$province' ";
            $join_str='inner join dev_regist on dev_regist.DevNo=dev_use_water_every_day.DevNo';
        }
        $datas=ActiveRecord::findBySql("select sum(UseVolume) as WaterUse,Date as ActDate
            from dev_use_water_every_day $join_str
            where dev_use_water_every_day.Date > '$time1'
            and dev_use_water_every_day.Date < '$time2' $where_str
            group by dev_use_water_every_day.Date order by dev_use_water_every_day.Date asc")->asArray()->all();
        return $datas;

    }




    //计算用水量
    public function WaterUseVolume($time1,$time2,$province){
        $where_str='';
        $join_str='';
        if($province){
            $where_str=" and dev_regist.Province='$province' ";
            $join_str='inner join dev_regist on dev_regist.DevNo=dev_use_water_every_day.DevNo';
        }
            $datas=ActiveRecord::findBySql("select sum(UseVolume) as all_volume
            from dev_use_water_every_day $join_str
            where dev_use_water_every_day.Date > '$time1'
            and dev_use_water_every_day.Date < '$time2' $where_str")->asArray()->one();
            //总用水量
            $total=round($datas['all_volume'],2);
            return $total;
    }

    //今日用水量
    public function TodayUse($province=''){

        if($province){
            $where_str=" and dev_regist.Province='$province' ";
            $time1=date('Y-m-d');
            $time2=date('Y-m-d H:i:s');
            $sql1="select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime > '$time1' and ActTime < '$time2' and DevNo > 0 ";
            $sql2="select * from (select DevNo,WaterRest,ActTime from dev_action_log where ActType=99 and ActTime < '$time1' and DevNo > 0 order by ActTime desc)as temp group by DevNo ";//前一次
            $data=ActiveRecord::findBySql("
        select DISTINCT temp2.* from ((".$sql1.") union (".$sql2."))as temp2
        inner join dev_regist on dev_regist.DevNo=temp2.DevNo
        where dev_regist.DevNo > 0 and dev_regist.AgentId >0 $where_str
        order by temp2.ActTime asc,temp2.WaterRest desc")->asArray()->all();
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


                }
            }

            return round($water_use,2);
        }
        $use_data=json_decode(trim(substr(file_get_contents('../web/datas/TodayUseWater.php'), 15)));

        return round($use_data->TodayUseWater,2);


    }

}
