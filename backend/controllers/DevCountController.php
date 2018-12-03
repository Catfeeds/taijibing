<?php
namespace backend\controllers;
error_reporting(E_ALL & ~ E_NOTICE);
use yii\db\ActiveRecord;
use backend\models\Address;
//设备统计
class DevCountController extends BaseController{

    public function actionIndex(){
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //排序(默认激活时间倒序)
        $sort=$this->getParam('sort');
        if($sort==''){
            $sort=0;
        }

        //获取时间条件
        $time1=$this->getParam('time1');
        $time2=$this->getParam('time2');

        //获取地址条件
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');

        //获取角色条件
        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $pqcenter_id=$this->getParam('pqcenter_id');//片区中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心、酒店中心id
        $devfactory_id=$this->getParam('devfactory_id');//设备厂家
        $investor_id=$this->getParam('investor_id');//设备投资商

        //商品条件
        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号

        //用户类型和入网属性条件
        $usetype=$this->getParam('usetype');//入网属性
        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、手机号、设备编号）
        $search=$this->getParam('search');

        //设备状态 (1 全部，2 正常，3 已初始化)
        $dev_state =$this->getParam('dev_state');
        if(!$dev_state){//默认全部
            $dev_state=1;
        }

        //返回已筛选条件

        $where_datas=[
                'province'=>$province,
                'city'=>$city,
                'area'=>$area,
                'agenty_id'=>$agenty_id,//运营中心id
                'pqcenter_id'=>$pqcenter_id,//片区中心id
                'agentf_id'=>$agentf_id,//服务中心id
                'devfactory_id'=>$devfactory_id,//设备厂家
                'investor_id'=>$investor_id,//设备投资商
                'devbrand_id'=>$devbrand_id,//设备品牌
                'devname_id'=>$devname_id,//设备型号
                'usetype'=>$usetype,//入网属性
                'customertype'=>$customertype,//用户类型
                'search'=>$search,//搜索内容
                'dev_state'=>$dev_state,//设备状态
                'offset'=>$offset,//起始位置
                'limit'=>$limit,//条数
                'time1'=>$time1,//时间1
                'time2'=>$time2,//时间2
        ];


        //获取地址
        $areas=Address::allQuery()->asArray()->all();
        //获取所有运营中心
        $agenty=ActiveRecord::findBySql("select Id,`Name` from agent_info where Level=4")->asArray()->all();
        //获取所有的片区中心
        $pqdatas=ActiveRecord::findBySql('select Id,`Name`,ParentId from agent_info where Level=7')->asArray()->all();

        //获取所有服务中心、酒店中心
        $agentf=ActiveRecord::findBySql("select Id,`Name`,ParentId from agent_info where Level=5 or Level=8")->asArray()->all();
        //所有设备厂家
        $devfactory=ActiveRecord::findBySql("select Id,`Name` from dev_factory")->asArray()->all();
        //所有设备投资商
        $investor=ActiveRecord::findBySql("select Id,`Name` from agent_info where Level=6")->asArray()->all();
        //所有设备品牌
        $devbrand=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=2 ")->asArray()->all();
        //所有设备商品型号
        $devname=ActiveRecord::findBySql("select id,`name`,brand_id from goods where category_id=2 and state=0 ")->asArray()->all();
        //入网属性（去重）
        $use_type=$this->GetUseType();

        //下拉框数据
        $select_datas=[
            'areas'=>$areas,
            'agenty'=>$agenty,
            'pqdatas'=>$pqdatas,
            'agentf'=>$agentf,
            'devfactory'=>$devfactory,
            'investor'=>$investor,
            'devbrand'=>$devbrand,
            'devname'=>$devname,
            'use_type'=>$use_type,//入网属性

        ];


        //所有入网属性
        $all_use_type=$this->GetAllUseType();//渲染表格用


        $datas=$this->GetAllDatas($status=1,$offset,$limit,$time1,$time2,$province,
            $city,$area,$agenty_id,$agentf_id,$pqcenter_id,$devfactory_id,$investor_id,
            $devbrand_id,$devname_id,$usetype,$customertype,$search,$dev_state,$sort);

//var_dump($datas);exit;
//所有已初始化的设备（表格数据）
        $all_init_dev=ActiveRecord::findBySql('
        select DISTINCT DevNo from dev_cmd where CmdType=4 and State=1
        ')->asArray()->all();

        return $this->render('index',
            [
                //下拉框条件数据
                'select_datas'=>$select_datas,

                //渲染数据
                'datas'=>$datas,
                'all_use_type'=>$all_use_type,//所有入网属性(渲染表格数据使用)
                'all_init_dev'=>$all_init_dev,//所有初始化的设备编号

                //返回已筛选条件
                'where_datas'=>$where_datas,

            ]);

    }

    //ajax 请求 根据服务中心或运营中心 获取对应的入网属性
    public function actionGetUseType(){
        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心id
        $use_type=$this->GetUseTypeByAgent($agenty_id,$agentf_id);
        return json_encode(['datas'=>$use_type]);
    }


    //根据条件获取数据
    public function GetAllDatas($status,$offset,$limit,$time1,$time2,$province,
            $city,$area,$agenty_id,$agentf_id,$pqcenter_id,$devfactory_id,$investor_id,
            $devbrand_id,$devname_id,$usetype,$customertype,$search,$dev_state,$sort){

        //排序（默认按激活时间降序）
        $order=' order by dev_active.RowTime desc ';
        $sort=$this->getParam('sort');
        if($sort==''){
            $sort=0;
        }

        if($sort && $sort%2==1){//奇数，升序
            $order=' order by dev_active.RowTime asc ';
        }


        $time_where='';
        $time_where2='';
        $same_time_where='';//同期时间
        $cmd_time_where='';//初始化时间
        $same_time_cmd_time_where='';//同期初始化时间
        $all_dev_num_time_where=' 1=1 ';//设备累计数的时间条件
        $cmd_all_dev_num_time_where=' 1=1 ';//已初始化设备累计数的时间条件
        if(!empty($time1)&&!empty($time2)){//传的时间段
            $time_where=" dev_regist.RowTime >= '$time1' and dev_regist.RowTime < '$time2 23:59:59' ";
            $time_where2=" ((dev_regist.RowTime >= '$time1' and dev_regist.RowTime < '$time2 23:59:59')
             or (dev_cmd.RowTime >= '$time1' and dev_cmd.RowTime < '$time2 23:59:59' and dev_cmd.CmdType=4 and dev_cmd.State=1 )) ";
            //同期时间
            $d1 = strtotime($time1);
            $d2 = strtotime($time2);
            $d3 = strtotime(date('Y-m-d',time()));
            $Days1 = round(($d2-$d1)/3600/24);
            $Days2 = round(($d3-$d1)/3600/24);
            $Days = $Days2+$Days1+1;
            $date1=date('Y-m-d',strtotime("-$Days day"));
            $same_time_where=" dev_regist.RowTime >='$date1' and dev_regist.RowTime < '$time1' ";
            $cmd_time_where=" dev_cmd.RowTime >= '$time1' and dev_cmd.RowTime < '$time2 23:59:59' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $same_time_cmd_time_where=" dev_cmd.RowTime >= '$date1' and dev_cmd.RowTime < '$time1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $all_dev_num_time_where=" dev_regist.RowTime <= '$time2 23:59:59' ";
            $cmd_all_dev_num_time_where=" dev_cmd.RowTime <= '$time2 23:59:59' ";
        }elseif($time1==1&&empty($time2)){//今日
            $date1=date('Y-m-d'.' 00:00:00',time());
            $time_where=" dev_regist.RowTime >= '$date1' ";
            $time_where2=" ((dev_regist.RowTime >= '$date1') or (dev_cmd .RowTime >= '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 )) ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-1 day'));
            $same_time_where=" dev_regist.RowTime > '$date2' and dev_regist.RowTime < '$date1'";
            $cmd_time_where=" dev_cmd.RowTime > '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $same_time_cmd_time_where=" dev_cmd.RowTime > '$date2' and dev_cmd.RowTime < '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
        }elseif($time1==2&&empty($time2)){//昨日
            $date1=date('Y-m-d',strtotime('-1 day'));
            $date2=date('Y-m-d',time());
            $time_where=" dev_regist.RowTime >= '$date1' and dev_regist.RowTime < '$date2' ";
            $time_where2=" ((dev_regist.RowTime >= '$date1' and dev_regist.RowTime < '$date2')
             or (dev_cmd.RowTime >= '$date1' and dev_cmd.RowTime < '$date2'  and dev_cmd.CmdType=4 and dev_cmd.State=1)) ";
            //同期时间
            $date3=date('Y-m-d',strtotime('-2 day'));
            $same_time_where=" dev_regist.RowTime >= '$date3' and dev_regist.RowTime < '$date1' ";
            $cmd_time_where=" dev_cmd.RowTime > '$date1' and dev_cmd.RowTime < '$date2' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $same_time_cmd_time_where=" dev_cmd.RowTime >= '$date3' and dev_cmd.RowTime < '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $all_dev_num_time_where=" dev_regist.RowTime < '$date2' ";
            $cmd_all_dev_num_time_where=" dev_cmd.RowTime < '$date2' ";
        }elseif(($time1==3&&empty($time2))||(empty($time1)&&empty($time2))){//7天
            $date1=date('Y-m-d',strtotime('-6 day'));
            $time_where="  dev_regist.RowTime >= '$date1' ";
            $time_where2="  ((dev_regist.RowTime >= '$date1') or (dev_cmd.RowTime >= '$date1'  and dev_cmd.CmdType=4 and dev_cmd.State=1)) ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-13 day'));
            $same_time_where=" dev_regist.RowTime >= '$date2' and dev_regist.RowTime < '$date1' ";
            $cmd_time_where=" dev_cmd.RowTime > '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $same_time_cmd_time_where=" dev_cmd.RowTime > '$date2' and dev_cmd.RowTime < '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
        }elseif($time1==4&&empty($time2)){//30天
            $date1=date('Y-m-d',strtotime('-29 day'));
            $time_where="  dev_regist.RowTime >= '$date1' ";
            $time_where2="  ((dev_regist.RowTime >= '$date1') or (dev_cmd.RowTime >= '$date1'  and dev_cmd.CmdType=4 and dev_cmd.State=1)) ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-59 day'));
            $same_time_where=" dev_regist.RowTime >= '$date2' and dev_regist.RowTime < '$date1' ";
            $cmd_time_where=" dev_cmd.RowTime > '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $same_time_cmd_time_where=" dev_cmd.RowTime > '$date2' and dev_cmd.RowTime < '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
        }elseif($time1==5&&empty($time2)){//90天
            $date1=date('Y-m-d',strtotime('-89 day'));
            $time_where="  dev_regist.RowTime >= '$date1' ";
            $time_where2="  ((dev_regist.RowTime >= '$date1') or (dev_cmd.RowTime >= '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1)) ";
            //同期时间
            $date2=date('Y-m-d',strtotime('-179 day'));
            $same_time_where=" dev_regist.RowTime >= '$date2' and dev_regist.RowTime < '$date1' ";
            $cmd_time_where=" dev_cmd.RowTime > '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
            $same_time_cmd_time_where=" dev_cmd.RowTime > '$date2' and dev_cmd.RowTime < '$date1' and dev_cmd.CmdType=4 and dev_cmd.State=1 ";
        }
//var_dump($time_where,$same_time_where);exit;

        //设备条件
        $dev_where="";
        $string='';//有些条件需要关联表
        if($province){
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.Province='$province' ";
        }
        if($city){
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.City='$city' ";
        }
        if($area){
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.Area='$area' ";
        }
        //运营中心和服务中心都选择了 或 只选了服务中心
        // 或运营中心、片区中心和服务中心都选择了
        // 或只选择了片区中心和服务中心
        if(($agenty_id&&$agentf_id)||(!$agenty_id&&$agentf_id)
            ||($agenty_id&&$agentf_id&&$pqcenter_id)
            ||(!$agenty_id&&$agentf_id&&$pqcenter_id)){
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.AgentId=$agentf_id ";
        }
        if($agenty_id&&!$pqcenter_id&&!$agentf_id){//只选了运营中心
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.AgentId in (select Id
from agent_info
where (ParentId=$agenty_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agenty_id and Level=7 ) and Level=5) ) ";
//            $dev_where.=" exists (select 1 from agent_info where ParentId=$agenty_id and dev_regist.AgentId=Id) ";
        }
        //只选了运营中心和片区中心 或 只选了片区中心
        if(($agenty_id&&$pqcenter_id&&!$agentf_id)
        ||(!$agenty_id&&$pqcenter_id&&!$agentf_id)){
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" exists (select 1 from agent_info where ParentId=$pqcenter_id and dev_regist.AgentId=Id) ";
//            $dev_where.=" exists (select 1 from agent_info where area_center_id=$pqcenter_id and dev_regist.AgentId=Id )";
        }
        if($devfactory_id){//设备厂家
            if($dev_where){
                $dev_where.=" and ";
            }
            $string.='inner join investor on investor.agent_id=dev_regist.investor_id
                     inner join dev_factory on dev_factory.Id=investor.factory_id';
            $dev_where.=" dev_factory.Id=$devfactory_id ";
        }
        if($investor_id){//设备投资商
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.investor_id=$investor_id ";
        }

        if($devbrand_id){//设备品牌
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.brand_id='$devbrand_id' ";
        }
        if($devname_id){//设备型号
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.goods_id=$devname_id ";
        }

        if($usetype){//入网属性
            //获取对应入网属性的所有code值

            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" exists (select 1 from agent_usetype_code where use_type='$usetype' and dev_regist.UseType=code ) ";
        }
        if($customertype){//用户类型
            if($dev_where){
                $dev_where.=" and ";
            }
            $dev_where.=" dev_regist.CustomerType=$customertype ";
        }
        if($dev_state){//设备状态 (1 全部，2 正常，3 已初始化)
            if($dev_where){
                $dev_where.=" and ";
            }
            if($dev_state==1){//正常的和已初始化的
                $dev_where.=" dev_regist.AgentId > 0 and (dev_regist.IsActive=1 or exists (select 1 from dev_cmd where CmdType=4 and State=1 and dev_regist.DevNo=DevNo)) ";//去掉没有绑定用户的.(empty($time_where)?' and '.$time_where:'')
            }
            if($dev_state==2){//正常
                $dev_where.=" dev_regist.AgentId > 0 and dev_regist.IsActive=1 and not exists (select 1 from dev_cmd where CmdType=4 and State=1 and dev_regist.DevNo=DevNo) ";//.(empty($time_where)?' and '.$time_where:'');
            }
            if($dev_state==3){//已初始化
//                $string.=' inner join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo ';
                $dev_where.=" dev_regist.AgentId > 0 and exists (select 1 from dev_cmd where CmdType=4 and State=1 and dev_regist.DevNo=DevNo) ";//.(empty($cmd_time_where)?' and '.$cmd_time_where:'');
            }

        }
        if($search){//用户搜索（用户名称、手机号、设备编号）
            if($dev_where){
                $dev_where.=" and ";
            }
            $string.=' left join user_info on user_info.Id=dev_regist.UserId ';
            $dev_where.=" (user_info.Name like '%$search%' or user_info.Tel like  '%$search%' or dev_regist.DevNo like  '%$search%') ";
        }


        if($status==1) {
            //设备统计概况数据
            if ($dev_state == 1 || $dev_state == 2) {
                //1、新注册设备
                $new_regist = ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo
            from dev_regist
            $string
" . (empty($dev_where) ? ' where ' . $time_where : ' where ' . $dev_where . ' and ' . $time_where))->count();
                //同期
                $same_time_regist = ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo
            from dev_regist
            $string
" . (empty($dev_where) ? ' where ' . $same_time_where : ' where ' . $dev_where . ' and ' . $same_time_where))->count();

            } else {//筛选条件是已初始化设备，则没有新增设备
                $new_regist = 0;
                $same_time_regist = 0;
            }

            //已初始化设备
            if ($dev_state == 1 || $dev_state == 3) {
                //1、已初始化设备
                $dev_init = ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo
            from dev_regist
             inner join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
            $string
" . (empty($dev_where) ? ' where ' . $cmd_time_where : ' where ' . $dev_where . ' and ' . $cmd_time_where))->count();

                //同期
                $same_time_init = ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo
            from dev_regist
             inner join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
            $string
" . (empty($dev_where) ? ' where ' . $same_time_cmd_time_where : ' where ' . $dev_where . ' and ' . $same_time_cmd_time_where))->count();

            } else {//筛选条件是正常设备，则没有初始化设备
                $dev_init = 0;
                $same_time_init = 0;
            }
            //累计设备数
            if ($dev_state == 1 || $dev_state == 2) {
                $all_dev_num = ActiveRecord::findBySql("
            select DISTINCT dev_regist.DevNo
            from dev_regist
            $string" . (empty($dev_where) ? ' where ' . $all_dev_num_time_where : ' where ' . $dev_where . ' and ' . $all_dev_num_time_where)
                )->count();
//                //同期
//                $same_time_all_dev_num = ActiveRecord::findBySql("
//            select DISTINCT dev_regist.DevNo
//            from dev_regist
//            $string" . (empty($dev_where) ? ' where ' . $same_time_where : ' where ' . $dev_where . ' and ' . $same_time_where)
//                )->count();
            } else {//已初始化设备
                $all_dev_num = ActiveRecord::findBySql("
            select DISTINCT dev_regist.DevNo
            from dev_regist
             inner join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
            $string" . (empty($dev_where) ? ' where ' . $cmd_all_dev_num_time_where : ' where ' . $dev_where . ' and ' . $cmd_all_dev_num_time_where)
                )->count();
//                //同期
//                $same_time_all_dev_num = ActiveRecord::findBySql("
//            select DISTINCT dev_regist.DevNo
//            from dev_regist
//             inner join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
//            $string" . (empty($dev_where) ? ' where ' . $same_time_cmd_time_where : ' where ' . $dev_where . ' and ' . $same_time_cmd_time_where)
//                )->count();
            }

//var_dump($new_regist,$same_time_regist,$dev_init,$same_time_init,$all_dev_num,$same_time_all_dev_num);exit;

            //折线图数据(也是饼状图、柱状图、地图数据)
            if ($dev_state == 1 || $dev_state == 2) {
                $chart_datas = ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_regist.RowTime,
                dev_regist.Province,dev_regist.City,dev_regist.Area
            from dev_regist
            $string" . (empty($dev_where) ? ' where ' . $time_where : ' where ' . $dev_where . ' and ' . $time_where)
                    .' GROUP BY dev_regist.DevNo '
                )->asArray()->all();
            } else {
                $chart_datas = ActiveRecord::findBySql("select DISTINCT dev_regist.DevNo,
                dev_regist.CustomerType,dev_regist.UseType,dev_cmd.RowTime,
                dev_regist.Province,dev_regist.City,dev_regist.Area
            from dev_regist
            inner join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
            $string" . (empty($dev_where) ? ' where ' . $cmd_time_where : ' where ' . $dev_where . ' and ' . $cmd_time_where)
                    .' GROUP BY dev_regist.DevNo '
                )->asArray()->all();
            }


        }
            //表格数据
        if($dev_state==3){//已初始化
            $datas = ActiveRecord::findBySql("
            select DISTINCT user_info.Name as UserName,user_info.Tel,dev_regist.DevNo,
            goods.name as GoodsName,brands.BrandName,dev_factory.Name as FactoryName,
            agent_info.Name as InvestorName,
            dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.UseType,
            dev_regist.CustomerType,dev_active.RowTime as ActiveTime
            from dev_regist
            inner join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo
            inner join goods on goods.id=dev_regist.goods_id
            inner join brands on brands.BrandNo=dev_regist.brand_id
            inner join agent_info on agent_info.Id=dev_regist.investor_id
            left join dev_active as dev_active on dev_active.DevNo=dev_regist.DevNo
            $string
            " . (empty($search) ? ' left join user_info on user_info.Id=dev_regist.UserId ' : '')
                . (empty($devfactory_id) ? ' inner join investor on investor.agent_id=dev_regist.investor_id
                                      inner join dev_factory on dev_factory.Id=investor.factory_id ' : '')
                . (empty($dev_where) ? ' where ' . $cmd_time_where : ' where ' . $dev_where . ' and ' . $cmd_time_where) . " group by dev_regist.DevNo "
            );

        }elseif($dev_state==2) {//正常
            $datas = ActiveRecord::findBySql("
            select DISTINCT user_info.Name as UserName,user_info.Tel,dev_regist.DevNo,
            goods.name as GoodsName,brands.BrandName,dev_factory.Name as FactoryName,
            agent_info.Name as InvestorName,
            dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.UseType,
            dev_regist.CustomerType,dev_active.RowTime as ActiveTime
            from dev_regist
            inner join goods on goods.id=dev_regist.goods_id
            inner join brands on brands.BrandNo=dev_regist.brand_id
            inner join agent_info on agent_info.Id=dev_regist.investor_id
            left join dev_active as dev_active on dev_active.DevNo=dev_regist.DevNo
            $string
            " . (empty($search) ? ' left join user_info on user_info.Id=dev_regist.UserId ' : '')
                . (empty($devfactory_id) ? ' inner join investor on investor.agent_id=dev_regist.investor_id
                                      inner join dev_factory on dev_factory.Id=investor.factory_id ' : '')
                . (empty($dev_where) ? ' where ' . $time_where : ' where ' . $dev_where . ' and ' . $time_where) . " group by dev_regist.DevNo "
            );
        }else{
            $datas = ActiveRecord::findBySql("
            select DISTINCT user_info.Name as UserName,user_info.Tel,dev_regist.DevNo,
            goods.name as GoodsName,brands.BrandName,dev_factory.Name as FactoryName,
            agent_info.Name as InvestorName,
            dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.UseType,
            dev_regist.CustomerType,dev_active.RowTime as ActiveTime
            from dev_regist
            inner join goods on goods.id=dev_regist.goods_id
            inner join brands on brands.BrandNo=dev_regist.brand_id
            inner join agent_info on agent_info.Id=dev_regist.investor_id
            left join dev_active as dev_active on dev_active.DevNo=dev_regist.DevNo

            left join dev_cmd on dev_cmd.DevNo=dev_regist.DevNo

            $string
            " . (empty($search) ? ' left join user_info on user_info.Id=dev_regist.UserId ' : '')
                . (empty($devfactory_id) ? ' inner join investor on investor.agent_id=dev_regist.investor_id
                                      inner join dev_factory on dev_factory.Id=investor.factory_id ' : '')
                . (empty($dev_where) ? ' where ' . $time_where2 : ' where ' . $dev_where . ' and ' . $time_where2) . " group by dev_regist.DevNo "
            );
        }
//        var_dump($datas->sql);exit;
            $total = $datas->count();//数据总条数
            $form_datas = ActiveRecord::findBySql($datas->sql . " $order limit " . $offset . ',' . $limit)->asArray()->all();
        //上级
        foreach($form_datas as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['AgentfName']=$parent['agentFname'];
            $v['AgentpName']=$parent['agentPname'];
            $v['AgentyName']=$parent['agentYname'];
        }
//            var_dump($dev_where);exit;


        if($status==1){
            $model=[

                'new_regist'=>$new_regist,//1、新注册设备
                'same_time_regist'=>$same_time_regist,//同期
                'dev_init'=>$dev_init,//1、已初始化设备
                'same_time_init'=>$same_time_init,//同期
                'all_dev_num'=>$all_dev_num,//累计设备数
//                'same_time_all_dev_num'=>$same_time_all_dev_num,//同期
                'chart_datas'=>$chart_datas,//折线图数据(也是饼状图、柱状图、地图数据)
                'total'=>$total,//数据总条数
                'form_datas'=>$form_datas,//表格数据
                'sort'=>$sort,//排序


            ];
        }else{
            $model=[

                'form_datas'=>$form_datas,//表格数据
                'total'=>$total,//数据总条数
                'sort'=>$sort,//排序
                'sql'=>$datas->sql,//sql 导出表格时用


            ];
        }

//        var_dump($model['form_datas']);exit;
        return $model;
    }

    //表格数据分页接口
    public function actionGetPageDatas(){
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');

        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }

        //排序（默认按激活时间降序排列）
        $sort=$this->getParam('sort');
        if($sort==''){
            $sort=0;
        }

        //导出表格
        $excel=$this->getParam('excel');


        //获取时间条件
        $time1=$this->getParam('time1');
        $time2=$this->getParam('time2');

        //获取地址条件
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');

        //获取角色条件
        $agenty_id=$this->getParam('agenty_id');//运营中心id
        $pqcenter_id=$this->getParam('pqcenter_id');//片区中心id
        $agentf_id=$this->getParam('agentf_id');//服务中心、酒店中心id
        $devfactory_id=$this->getParam('devfactory_id');//设备厂家
        $investor_id=$this->getParam('investor_id');//设备投资商

        //商品条件
        $devbrand_id=$this->getParam('devbrand_id');//设备品牌
        $devname_id=$this->getParam('devname_id');//设备型号

        //用户类型和入网属性条件
        $usetype=$this->getParam('usetype');//入网属性
        $customertype=$this->getParam('customertype');//用户类型

        //搜索框输入（用户名称、手机号、设备编号）
        $search=$this->getParam('search');

        //设备状态 (1 全部，2 正常，3 已初始化)
        $dev_state =$this->getParam('dev_state');
        if(!$dev_state){//默认全部
            $dev_state=1;
        }

        $datas=$this->GetAllDatas($status=0,$offset,$limit,$time1,$time2,$province,
            $city,$area,$agenty_id,$agentf_id,$pqcenter_id,$devfactory_id,$investor_id,
            $devbrand_id,$devname_id,$usetype,$customertype,$search,$dev_state,$sort);
//var_dump($datas);exit;
        if($excel=='YES'){
            $dataArray=ActiveRecord::findBySql($datas['sql'])->asArray()->all();
            $tile_str = "用户姓名,联系电话,设备编号,设备商品型号,设备品牌,设备厂家,设备投资商,服务中心,运营中心,省,市,区,入网属性,用户类型,激活时间";
            $tileArray = explode(',',$tile_str);
            $this->exportToExcel('设备统计_'.date('Ymd').'.csv',$tileArray,$dataArray);
            exit;
        }
        unset($datas['sql']);
        return $datas;

    }

    //导出表格
//    public  function exportToExcel2($filename, $tileArray=[], $dataArray=[]){
//        ini_set('memory_limit','512M');
//        ini_set('max_execution_time',0);
//        ob_end_clean();
//        ob_start();
//        header("Content-Type: text/csv");
//        header("Content-Disposition:filename=".$filename.'.csv');
//        $fp=fopen('php://output','w');
//        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
//        fputcsv($fp,$tileArray);
//        $index = 0;
//        foreach ($dataArray as $item) {
//            if($index==1000){
//                $index=0;
//                ob_flush();
//                flush();
//            }
//            //将科学计算转换成文本
//            $item['Tel']='’'.$item['Tel'];
//            $item['DevNo']='’'.$item['DevNo'];
//            $item['ActiveTime']='’'.$item['ActiveTime'];
//            $index++;
//            fputcsv($fp,$item);
//        }
//
//        ob_flush();
//        flush();
//        ob_end_clean();
//        exit;
//    }

    //导出表格(带样式)
    public  function exportToExcel($filename, $tileArray=[], $dataArray=[]){
        ini_set('memory_limit','512M');
        ini_set('max_execution_time',0);
//        ob_end_clean();
//        ob_start();
        //----------

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename.xls");

        //所有已初始化的设备
        $all_init_dev=ActiveRecord::findBySql('
        select DISTINCT DevNo from dev_cmd where CmdType=4 and State=1
        ')->asArray()->all();
        $all_init_dev=array_column($all_init_dev,'DevNo');

        $UseType=[
            1=>'自购',
            2=>'押金',
            3=>'买水送机',
            4=>'买机送水',
            5=>'免费',
            99=>'其他',
        ];
        $CustomerType=[
            1=>'家庭',
            2=>'公司',
            3=>'集团',
            4=>'酒店',
            99=>'其他',
        ];

        //标题行
        $title='';
        $body='';
        foreach($tileArray as $v){
            $title.="<td style='width:54pt' align='center'>$v</td>";
        }
        foreach($dataArray as $v){
            $style='';
            if(in_array($v['DevNo'],$all_init_dev))$style=" style='background-color:#f00;'";
            $body.="<tr $style >
                    <td style='width:66pt' align='center'>{$v['UserName']}</td>
                    <td style='width:66pt' align='center'>`{$v['Tel']}</td>
                    <td style='width:66pt' align='center'>`{$v['DevNo']}</td>
                    <td style='width:70pt' align='center'>{$v['GoodsName']}</td>
                    <td style='width:66pt' align='center'>{$v['BrandName']}</td>
                    <td style='width:66pt' align='center'>{$v['FactoryName']}</td>
                    <td style='width:66pt' align='center'>{$v['InvestorName']}</td>
                    <td style='width:88pt' align='center'>{$v['AgentfName']}</td>
                    <td style='width:88pt' align='center'>{$v['AgentyName']}</td>
                    <td style='width:54pt' align='center'>{$v['Province']}</td>
                    <td style='width:54pt' align='center'>{$v['City']}</td>
                    <td style='width:54pt' align='center'>{$v['Area']}</td>
                    <td style='width:54pt' align='center'>{$UseType[$v['UseType']]}</td>
                    <td style='width:54pt' align='center'>{$CustomerType[$v['CustomerType']]}</td>
                    <td style='width:88pt' align='center'>`{$v['ActiveTime']}</td>
                    </tr>";
        }

        echo "<table border=1 cellpadding=0 cellspacing=0 width='100%' >
                <tr>
                <td colspan='15' align='center'>
                <h2>$filename</h2>
                </td>
                </tr>
                <tr>
                $title
                </tr>
                $body
                </table>";


    }


}
