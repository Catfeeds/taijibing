<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/6
 * Time: 下午5:59
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii;
use backend\models\User;

class DevRegist extends ActiveRecord
{
    public $tog=0;

    public static function tableName()
    {
        return 'dev_regist';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['CustomerType','UseType','Province','City','Area','Address','brand_id','goods_id','Lat','Lng','AgentId','UserId','RoomNo'],'safe'],
                [['CustomerType','UseType','Province','City','Area','Address','brand_id','goods_id','Lat','Lng','AgentId','DevNo'],'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'CustomerType' => '客户类型',
            'UseType' => '入网属性',
            'Province' => '省',
            'City' => '市',
            'Area' => '区',
            'Address' => '详细地址',
            'brand_id' => '商品品牌',
            'goods_id' => '商品型号',
            'Lat' => '纬度',
            'Lng' => '经度',
            'AgentId' => '所属服务中心',
            'DevNo' => '设备编号',
            'RoomNo' => '门牌号',

        ];
    }



    /**
     * 设备列表分页查询
     */
//    public static function pageQuery($offset = 0, $limit = 0,$devno,$xname,$sname,$mobile,$devf,$tel,$province,$city,$area)
//    {
//        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
//        $logic_type=$model->getAttribute("logic_type");
//        $where ="";
//
//        if(!empty($devno)){
//            $where.=" dev_regist.DevNo='$devno'";
//        }
//        if(!empty($xname)){
//            //县区
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" agent_info.Level=4 and agent_info.LoginName='$xname'";
//        }
//        if(!empty($sname)){
//            //社区
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" agent_info.Level=5 and agent_info.LoginName='$sname'";
//
//        }
//        if(!empty($mobile)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" dev_regist.DevBindMobile='$mobile'";
//        }
//        if(!empty($devf)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" dev_regist.DevFactory='$devf'";
//        }
//        if(!empty($tel)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.Tel='$tel'";
//        }
//        if(!empty($province)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.Province='$province'";
//        }
//        if(!empty($city)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.City='$city'";
//        }
//        if(!empty($area)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.Area='$area'";
//        }
//        if($logic_type==3||$logic_type==4){
//            //代理商
//            $username=$model->getAttribute("username");
//            return DevRegist::pageQueryByName($offset,$limit,$username,$where);
//        }
//        $url="select user_info.Tel,  dev_regist.DevNo,dev_regist.AgentId,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
//`dev_active`.`Date`,
//`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,dev_location.`BaiDuLat`,dev_location.`BaiDuLng`,
//dev_cmd_tb.`Cmd`,dev_cmd_tb.`RowTime`,
//`agent_info`.Name
// from dev_regist
// left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
// left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
// left join agent_info on agent_info.`Id`=dev_regist.`AgentId`
// left join user_info on dev_regist.UserId=user_info.`Id`
// left join 	(select * from dev_cmd ) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo` ".(empty($where)?"":" where $where")." group by dev_regist.`DevNo` order by dev_cmd_tb.`RowTime` desc   limit $offset , $limit ";
//        return static::findBySql($url);
//    }


    public static function pageQuery2($offset = 0, $limit = 0,$search,$province,$city,$area,$sort)
    {
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $where ="";

        if(!empty($search)){
            $where.=" dev_regist.DevNo like '%$search%' or dev_regist.DevFactory like '%$search%' or agent_info.Name like '%$search%' or user_info.Tel like '%$search%' or user_info.Name like '%$search%'";
        }

        if(!empty($province)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Province='$province'";
        }
        if(!empty($city)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.City='$city'";
        }
        if(!empty($area)){
            //设备手机号
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" user_info.Area='$area'";
        }

        //如果是设备厂家，只显示对应的设备
        if($logic_type==2){

            if(!empty($where)){
                $where.=" and ";
            }

            //获取该设备厂家登陆账号
            $loginName=$model->username;
            //获取该登陆账号的厂家id
            $factoryid=DevFactory::findOne(['LoginName'=>$loginName])->Id;
//            if($data){
//                $factoryid=$data->Id;
            $where.=" dev_regist.DevFactoryId = $factoryid";
//            }

        }


        //排序（设备激活时间）
        $order=" order by RowTime desc ";//默认按操作时间升序
        if($sort && $sort%2==1){//奇数 升序
            $order=" order by `RowTime` asc";

        }
        if($sort && $sort%2==0){//偶数数 降序
            $order=" order by `RowTime` desc";

        }


        if($logic_type==3||$logic_type==4){
            //代理商
            $username=$model->getAttribute("username");
            return DevRegist::pageQueryByName($offset,$limit,$username,$where,$order);
        }
        $url="select * from (select user_info.Tel, user_info.Name as UserName,dev_factory.Type, dev_regist.DevNo,dev_regist.AgentId,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
`dev_active`.`Date`,`dev_active`.`HwNo`,dev_regist.Province,dev_regist.City,dev_regist.Area,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,dev_location.`BaiDuLat`,dev_location.`BaiDuLng`,
dev_cmd_tb.`Cmd`,dev_active.`RowTime`,
`agent_info`.Name
 from dev_regist
 left join `dev_factory` on dev_factory.`Name`=dev_regist.DevFactory
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId`
 left join user_info on dev_regist.UserId=user_info.`Id`
 left join 	(select * from dev_cmd ) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo` ".(empty($where)?"":" where $where")." order by dev_active.`RowTime` desc ) as temp group by `DevNo` $order   limit $offset , $limit ";




        return static::findBySql($url);
    }





    /**
     * 设备列表分页查询
     */
    public static function pageQueryByName($offset = 0, $limit = 0,$username,$where,$order)
    {
        return static::findBySql("select user_info.Tel,user_info.Name as UserName,dev_factory.Type, dev_regist.DevNo,dev_regist.AgentId,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
`dev_active`.`Date`,`dev_active`.`HwNo`,dev_regist.Province,dev_regist.City,dev_regist.Area,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime`,
`agent_info`.Name
 from dev_regist
 left join `dev_factory` on dev_factory.`Name`=dev_regist.DevFactory
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId` or  agent_info.`ParentId`=dev_regist.`AgentId`
left join user_info on dev_regist.UserId=user_info.`Id`
 left join 	(select * from dev_cmd) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo`
  where ".(empty($where)?"":$where." and ")." agent_info.LoginName='$username' group by dev_regist.`DevNo` $order limit $offset , $limit");
    }


//    public static function allQuery($devno,$xname,$sname,$mobile,$devf,$tel,$province,$city,$area)
//    {
//        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
//        $logic_type=$model->getAttribute("logic_type");
//        $where ="";
//
//        if(!empty($devno)){
//            $where.=" dev_regist.DevNo='$devno'";
//        }
//        if(!empty($xname)){
//            //县区
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" agent_info.Level=4 and agent_info.LoginName='$xname'";
//        }
//        if(!empty($sname)){
//            //社区
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" agent_info.Level=5 and agent_info.LoginName='$sname'";
//
//        }
//        if(!empty($mobile)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" dev_regist.DevBindMobile='$mobile'";
//        }
//        if(!empty($devf)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" dev_regist.DevFactory='$devf'";
//        }
//        if(!empty($tel)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.Tel='$tel'";
//        }
//        if(!empty($province)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.Province='$province'";
//        }
//        if(!empty($city)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.City='$city'";
//        }
//        if(!empty($area)){
//            //设备手机号
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.=" user_info.Area='$area'";
//        }
//        if($logic_type==3||$logic_type==4){
//            //代理商
//            $username=$model->getAttribute("username");
//            return DevRegist::allQueryByName($username,$where);
//        }
//            $sql="select user_info.Tel, dev_regist.DevNo,dev_regist.`DevBindMobile`,dev_regist.DevFactory,
//`dev_active`.`Date`,
//`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
//`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime`,
//`agent_info`.Name
// from dev_regist
// left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
// left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
// left join agent_info on agent_info.`Id`=dev_regist.`AgentId`
//  left join user_info on dev_regist.UserId=user_info.`Id`
// left join 	(select * from dev_cmd order by dev_cmd.`RowTime` desc) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo` ".(empty($where)?"":"where $where")." group by dev_regist.`DevNo`";
//        return static::findBySql($sql);
//    }


    public static function allQuery2($state,$search,$province,$city,$area,$sort)
    {
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $where =" dev_regist.DevNo not in ('2080111157','2079111335',
        '2080111168','2079111324','2079111234','2080111270',
        '2810000021','2081111136','2085111118','2081111338') ";

        if(!empty($search)){
            if(!empty($where)){
                $where.=" and ";
            }
            if($state==3){
                $where.=" (dev_regist.DevNo like '%$search%'
                or dev_regist.Iccid like '%$search%')";
            }else{
                $where.=" (dev_regist.DevNo like '%$search%'
            or dev_regist.DevFactory like '%$search%'
            or agent_info.Name like '%$search%'
            or agent2.Name like '%$search%'
            or user_info.Tel like '%$search%'
            or user_info.Name like '%$search%'
            or dev_regist.CodeNumber like '%$search%'
            or dev_regist.Iccid like '%$search%'
            )";
            }
        }

        if($state==1){//正常
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.IsActive=1 and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0";
        }
        if($state==2){//已初始化
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)  and dev_regist.AgentId > 0 ";
        }
        if($state==3){//未激活设备（没有绑定用户）
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.AgentId = 0 and
 not EXISTS (select 1 from dev_regist as temp where temp.CustomerType > 0 and temp.Iccid=dev_regist.Iccid
 and not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=temp.DevNo)) ";
        }

        if(!empty($province)){
            //省
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.Province='$province'";
        }
        if(!empty($city)){
            //市
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.City='$city'";
        }
        if(!empty($area)){
            //区
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" dev_regist.Area='$area'";
        }

        //如果是设备厂家，只显示对应的设备
        if($logic_type==2){

            if(!empty($where)){
                $where.=" and ";
            }

            //获取该设备厂家登陆账号
            $loginName=$model->username;
            //获取该登陆账号的厂家id
            $factoryid=DevFactory::findOne(['LoginName'=>$loginName])->Id;
//            if($data){
//                $factoryid=$data->Id;
                $where.=" dev_regist.DevFactoryId = $factoryid";
//            }




        }

//        return $where;


        //排序（设备激活时间）
        $order=' order by RowTime desc';
        if($sort && $sort%2==0){//偶数 升序
            $order=" order by RowTime desc";

        }
        if($sort && $sort%2==1){
            $order=" order by RowTime asc";

        }




        if($logic_type==3||$logic_type==4||$logic_type==6){
            //代理商
            $username=$model->getAttribute("username");
            return DevRegist::allQueryByName($username,$where,$logic_type,$order);
        }

        //投资商
        if($logic_type==5){
            //代理商
            $username=$model->getAttribute("username");
            $investor_id=ActiveRecord::findBySql("select Id from agent_info where LoginName='$username'")->asArray()->one()['Id'];
            return DevRegist::investor($investor_id,$where,$order);

        }


        $sql="select * from (select user_info.Tel,user_info.Name as UserName,
dev_regist.AgentId,dev_regist.DevNo,dev_regist.`DevBindMobile`,
dev_factory.Name as DevFactory,dev_regist.CodeNumber,
`dev_active`.`Date`,dev_regist.Province,dev_regist.City,dev_regist.Area,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime` as cmd_RowTime,`dev_regist`.`Iccid`,
`dev_active`.`RowTime`,`agent_info`.Name as agentname,
agent2.Name as agentpname,dev_regist.IsActive,
  brands.BrandName,agent.Name as investor,goods.name as goodsname,
  dev_status.LastConnectDate,dev_status.LastConnectTime
 from dev_regist
 left join `dev_status` on dev_regist.`DevNo`=dev_status.`DevNo`
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId`
 left join agent_info as agent2 on agent2.`Id`=agent_info.`ParentId`
 left join user_info on dev_regist.UserId=user_info.`Id`
 left join 	(select * from dev_cmd order by dev_cmd.`RowTime` desc)
 as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo`

 left join brands on brands.BrandNo=dev_regist.brand_id
 left join agent_info as agent on dev_regist.investor_id=agent.Id

 left join goods on goods.id=dev_regist.goods_id
 left join investor on investor.agent_id=dev_regist.investor_id
 and investor.goods_id=dev_regist.goods_id
 left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id

 ".(empty($where)?"":"where $where")." group by dev_regist.`DevNo`) as temp  $order";
//        return $sql;
        return static::findBySql($sql);
    }

    public static function allQueryByName($username,$where,$logic_type,$order)
    {
        $str='';
        $agent_id=-1;
        if($logic_type==3){//运营中心
            //获取改运营中心下的所有服务中心
            //获取运营中心id
            $data=AgentInfo::findOne(['LoginName'=>$username]);

            if($data){
                $agent_id=$data->Id;//运营中心id
                //获取下面的服务中心id
//                $str="(select agent_info.Id from agent_info where agent_info.ParentId = $agent_id)";
                $str="(select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5))";

            }
        }elseif($logic_type==6) {//片区中心
            //获取片区中心id
            $data = AgentInfo::findOne(['LoginName' => $username]);

            if ($data) {
                $agent_id = $data->Id;//片区中心id
                //获取下面的服务中心id
                $str = "(select agent_info.Id from agent_info where agent_info.ParentId = $agent_id)";

            }
        }else{//服务中心

            //根据登陆名称获取agentid
            $data=AgentInfo::findOne(['LoginName'=>$username]);
            if($data){

                $str="(select agent_info.Id from agent_info where agent_info.LoginName='{$username}')";

            }


        }




        return static::findBySql("select * from (select user_info.Name
as UserName,user_info.Tel, dev_regist.DevNo,dev_regist.AgentId,
dev_regist.`DevBindMobile`,dev_factory.Name as DevFactory,dev_regist.CodeNumber,
`dev_active`.`Date`,dev_regist.Province,dev_regist.City,dev_regist.Area,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime` as cmd_RowTime,`dev_regist`.`Iccid`,
`dev_active`.`RowTime`,`agent_info`.Name as agentname,
agent2.Name as agentpname,dev_regist.IsActive,
 brands.BrandName,agent.Name as investor,goods.name as goodsname,
 dev_status.LastConnectDate,dev_status.LastConnectTime
 from dev_regist
 left join `dev_status` on dev_regist.`DevNo`=dev_status.`DevNo`
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
   left join user_info on dev_regist.UserId=user_info.`Id`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId` or  agent_info.`ParentId`=dev_regist.`AgentId`
  left join agent_info as agent2 on agent2.`Id`=agent_info.`ParentId`
 left join 	(select * from dev_cmd order by dev_cmd.`RowTime` desc) as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo`

 left join brands on brands.BrandNo=dev_regist.brand_id
 left join agent_info as agent on dev_regist.investor_id=agent.Id

 left join goods on goods.id=dev_regist.goods_id
 left join investor on investor.agent_id=dev_regist.investor_id
 and investor.goods_id=dev_regist.goods_id
 left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id

  where (dev_regist.AgentId=$agent_id or dev_regist.AgentId in $str )
  ".(empty($where)?"":"and $where")." group by dev_regist.`DevNo`) as temp $order");

    }

    public static function investor($investor_id,$where,$order){

        return static::findBySql("select * from (select user_info.Tel,user_info.Name as UserName,
dev_regist.AgentId, dev_regist.DevNo,dev_regist.`DevBindMobile`,
dev_factory.Name as DevFactory,dev_regist.CodeNumber,
`dev_active`.`Date`,dev_regist.Province,dev_regist.City,dev_regist.Area,
`dev_location`.`Lat`,dev_location.`Lng`,dev_location.`Address` ,
`dev_cmd_tb`.`Cmd`,dev_cmd_tb.`RowTime` as cmd_RowTime,`dev_regist`.`Iccid`,
`dev_active`.`RowTime`,`agent_info`.Name as agentname,
agent2.Name as agentpname,dev_regist.IsActive,
  brands.BrandName,agent.Name as investor,goods.name as goodsname,
  dev_status.LastConnectDate,dev_status.LastConnectTime
 from dev_regist
 left join `dev_status` on dev_regist.`DevNo`=dev_status.`DevNo`
 left join `dev_active` on dev_regist.`DevNo`=dev_active.`DevNo`
 left join `dev_location` on dev_regist.`DevNo`=dev_location.`DevNo`
 left join agent_info on agent_info.`Id`=dev_regist.`AgentId`
 left join agent_info as agent2 on agent2.`Id`=agent_info.`ParentId`
 left join user_info on dev_regist.UserId=user_info.`Id`
 left join 	(select * from dev_cmd order by dev_cmd.`RowTime` desc)
 as dev_cmd_tb on dev_regist.`DevNo`=dev_cmd_tb.`DevNo`

 left join brands on brands.BrandNo=dev_regist.brand_id
 left join agent_info as agent on dev_regist.investor_id=agent.Id

 left join goods on goods.id=dev_regist.goods_id
 left join investor on investor.agent_id=dev_regist.investor_id
 and investor.goods_id=dev_regist.goods_id
 left join agent_stock on agent_stock.agent_id=dev_regist.AgentId
 and agent_stock.goods_id=dev_regist.goods_id
 left join dev_factory on dev_factory.id=agent_stock.factory_id

 where investor.agent_id=$investor_id
 ".(empty($where)?"":"and $where")." group by dev_regist.`DevNo`) as temp $order");

    }




    public static function dynamicAllQuery($state,$content,$province,$city,$area,$selecttime,$sort){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");

        $where=" dev_action_snapshot.DevNo not in ('2080111157','2079111335',
        '2080111168','2079111324','2079111234','2080111270',
        '2810000021','2081111136','2085111118','2081111338') ";
        $startTime='';
        $endTime='';
        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_action_snapshot.RowTime >= '$startTime' and dev_action_snapshot.RowTime <= '$endTime'";
        }



        if(!empty($content)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.=" (dev_regist.`DevNo` like '%$content%'
                    or user_info.`Name` like '%$content%'
                    or dev_regist.`Iccid` like '%$content%'
                    ) ";
        }

        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Area='$area'";
        }
        $where2='';
        if($state==1){//显示正常设备（没有初始化的）动态
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="  not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0 ";
        }
        if($state==2){//显示已初始化的动态
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="  exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo) and dev_regist.AgentId > 0 ";
        }
        if($state==3){//显示未绑定用户的动态
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="  dev_regist.AgentId = 0 and
 not EXISTS (select 1 from dev_regist as temp where temp.AgentId > 0 and temp.Iccid=dev_regist.Iccid
 and not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=temp.DevNo)) ";
        }
        //排序（操作时间）
        $order=" ORDER BY dev_action_snapshot.RowTime desc ";
        if($sort && $sort%2==1){//奇数 降序
            $order=" ORDER BY dev_action_snapshot.RowTime asc";

        }
        if ($logic_type == 3||$logic_type == 4) {
            //代理商
            $username=$model->getAttribute("username");
            $agent_id=AgentInfo::findOne(['LoginName'=>$username])->Id;
            if($logic_type == 4){//服务中心
                if(!empty($where)){
                    $where.=" and ";
                }
                $where.="dev_regist.AgentId=$agent_id";
            }
            if($logic_type == 3){//运营中心
                if(!empty($where)){
                    $where.=" and ";
                }
                $where.="(dev_regist.AgentId=$agent_id or dev_regist.AgentId in (select Id from agent_info
where (ParentId=$agent_id and Level=5)
or (ParentId in (select Id from agent_info where ParentId=$agent_id and Level=7 ) and Level=5)))";
            }
//            var_dump($username);exit;
//            return DevRegist::dynamicAllQueryWithName($where2,$where,$username,$order);
        }


        $sql="select user_info.Tel,user_info.Name as UserName,
 dev_regist.Province,dev_regist.City,dev_regist.Area, dev_action_snapshot.ActType,
 dev_action_snapshot.WaterUse,dev_action_snapshot.Degrees,dev_action_snapshot.ActTime,
 dev_action_snapshot.DevNo,dev_action_snapshot.RowTime,
 dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng`,status_dev_water.VlNum,
 status_dev_water.Dts as Dts2,dev_regist.Iccid,dev_regist.AgentId
from dev_action_snapshot
left join dev_location on dev_action_snapshot.`DevNo`=dev_location.`DevNo`
left join dev_regist on dev_regist.DevNo=dev_action_snapshot.`DevNo`
left join user_info on dev_regist.UserId=user_info.`Id`
left join status_dev_water on dev_action_snapshot.DevNo=status_dev_water.DevNo
".(empty($where)?"":"where $where")." $order " ;

        return static::findBySql($sql);
    }


//已初始化的设备的操作记录
    public static function dynamicAllQuery2($content,$DevNo,$selecttime){
//        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
//        $logic_type=$model->getAttribute("logic_type");
        $where="";

        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            $where.="RowTime >= '$startTime' and RowTime <= '$endTime'";
        }


        if(!empty($content)){
            if($content=='开关机'){
                $content=1;
            }
            if($content=='调温'){
                $content=2;
            }
            if($content=='加热'){
                $content=4;
            }
            if($content=='消毒'){
                $content=8;
            }
            if($content=='抽水'){
                $content=16;
            }
            if($where){
                $where.=" and ";
            }
            $where.="ActType = $content ";
        }


//        if(!empty($province)){
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.="dev_regist.Province='$province'";
//        }
//        if(!empty($city)){
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.="dev_regist.City='$city'";
//        }
//        if(!empty($area)){
//            if(!empty($where)){
//                $where.=" and ";
//            }
//            $where.="dev_regist.Area='$area'";
//        }
//        if ($logic_type == 3||$logic_type == 4) {
//            //代理商
//            $username=$model->getAttribute("username");
//            return DevRegist::dynamicAllQueryWithName($where,$username);
//        }

        $sql="select *
from dev_action_log
where DevNo in (select DevNo from dev_cmd where CmdType=4 and State=1 GROUP BY DevNo)
and DevNo <> 0 and DevNO <> 1 and DevNo='$DevNo'".(empty($where)?"":"and $where")."
 order by ActTime Desc" ;
        return static::findBySql($sql);
    }

    /**
     * 账户管理查询
     * @param $tel
     * @param $userid
     * @return yii\db\ActiveQuery
     */
    public static function dynamicAllQueryWithName($where2,$where,$username,$order){
        if(!empty($username)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="agent_info.LoginName='$username'";
        }

//        $sql="select * from (select user_info.Tel,user_info.Name as UserName,
// dev_regist.Province,dev_regist.City,dev_regist.Area, dev_action_log.*,
// dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng`,status_dev_water.VlNum,
// status_dev_water.Dts as Dts2,dev_regist.Iccid
//from dev_action_log
//left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
//left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
//left join user_info on dev_regist.UserId=user_info.`Id`
//left join status_dev_water on dev_action_log.DevNo=status_dev_water.DevNo
//
//left join agent_info on  agent_info.Id=dev_regist.AgentId
// or  agent_info.`ParentId`=dev_regist.`AgentId`
//
//".(empty($where)?"":"where $where")." order by dev_action_log.RowTime Desc) as temp
//   $where2 group by DevNo $order" ;

        $sql="select * from (select user_info.Tel,user_info.Name as UserName,
 dev_regist.Province,dev_regist.City,dev_regist.Area, dev_action_snapshot.*,
 dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng`,status_dev_water.VlNum,
 status_dev_water.Dts as Dts2,dev_regist.Iccid
from dev_action_snapshot
left join dev_location on dev_action_snapshot.`DevNo`=dev_location.`DevNo`
left join dev_regist on dev_regist.DevNo=dev_action_snapshot.`DevNo`
left join user_info on dev_regist.UserId=user_info.`Id`
left join status_dev_water on dev_action_snapshot.DevNo=status_dev_water.DevNo

left join agent_info on  agent_info.Id=dev_regist.AgentId
 or  agent_info.`ParentId`=dev_regist.`AgentId`

".(empty($where)?"":"where $where")." order by dev_action_snapshot.RowTime Desc) as temp
   $where2 " ;




        return static::findBySql($sql);
    }


    public static function dynamicPageQuery($state,$offset=0,$limit=0,$content,$province,$city,$area,$sort){
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $logic_type=$model->getAttribute("logic_type");
        $where="";
        if(!empty($content)){
            $where.="dev_regist.`DevNo` like '%$content%' or user_info.`Name` like '%$content%'";
        }
        if(!empty($province)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Area='$area'";
        }

        $where2='';
        if($state==1){//显示正常设备（没有初始化的）动态

            $where2=" where DevNo not in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)";
        }
        if($state==2){//显示已初始化的动态

            $where2=" where DevNo in (select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo)";
        }

        //排序（操作时间）
        $order=" ORDER BY ActTime desc ";
        if($sort && $sort%2==1){//奇数 降序
            $order=" ORDER BY ActTime asc";

        }

        if ($logic_type == 3||$logic_type == 4) {
            //代理商
            $username=$model->getAttribute("username");
            return DevRegist::dynamicPageQueryWithName($where2,$where,$username,$offset,$limit,$order);
        }
        $sql="select * from (select user_info.Tel,user_info.Name as UserName,
 dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.DevBindMobile,
 dev_action_log.ActType,dev_action_log.WaterUse,dev_action_log.Degrees,
 dev_action_log.ActTime,dev_action_log.DevNo,dev_location.`Address`,
 dev_location.`Lat`,dev_location.`Lng`,
 status_dev_water.VlNum,status_dev_water.Dts as Dts2
from dev_action_log
left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
left join user_info on dev_regist.UserId=user_info.`Id`
left join status_dev_water on dev_action_log.DevNo=status_dev_water.DevNo
".(empty($where)?"":"where $where")." order by dev_action_log.ActTime desc) as temp
$where2 group by DevNo $order  limit $offset , $limit";//and DevNo <> 0 and DevNO <> 1
        return static::findBySql($sql);
    }
    public static function dynamicPageQueryWithName($where2,$where,$username,$offset=0,$limit=0,$order){
        if(!empty($username)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="agent_info.LoginName='$username'";
        }


//        $sql="select * from ( select dev_regist.Province,
//dev_regist.City,dev_regist.Area, dev_regist.DevBindMobile, dev_action_log.*,
//dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng`
//from dev_action_log
//left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
//left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
//left join agent_info on agent_info.Id=dev_regist.AgentId
//or  agent_info.`ParentId`=dev_regist.`AgentId`
//" .(empty($where)?"":"where $where")." order by dev_action_log.ActTime desc) as temp
//group by DevNo $order limit $offset , $limit";

        $sql="select * from (select user_info.Tel,user_info.Name as UserName,
 dev_regist.Province,dev_regist.City,dev_regist.Area,dev_regist.DevBindMobile,
 dev_action_log.*,dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng`,
 status_dev_water.VlNum,status_dev_water.Dts as Dts2
from dev_action_log
left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
left join user_info on dev_regist.UserId=user_info.`Id`
left join status_dev_water on dev_action_log.DevNo=status_dev_water.DevNo

left join agent_info on agent_info.Id=dev_regist.AgentId
or  agent_info.`ParentId`=dev_regist.`AgentId`

".(empty($where)?"":"where $where")." order by dev_action_log.ActTime desc) as temp
$where2 group by DevNo $order  limit $offset , $limit";


        return static::findBySql($sql);
    }



}
