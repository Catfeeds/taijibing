<?php
namespace backend\controllers;
//供应商
use backend\models\Address;
use yii\db\ActiveRecord;
use yii\db\Exception;

class SupplierController extends BaseController{
    //供应商列表
    public function actionList(){
       $result=$this->GetListDatas(1);
        return $this->render('list',[
            'select_where'=>$result['select_where'],
            'checked_datas'=>$result['checked_datas'],
            'form_datas'=>json_encode($result['form_datas']),
            'total'=>$result['total'],
        ]);

    }

    //供应商列表 ajax分页
    public function actionListPage(){

        $result=$this->GetListDatas();
        return json_encode([
            'form_datas'=>$result['form_datas'],
            'total'=>$result['total'],
        ]);
    }

    //供应商列表 数据
    public function GetListDatas($tag=''){
        //条件参数
        $Name=addslashes(trim($this->getParam('Name')));//名称
        $LoginName=addslashes(trim($this->getParam('LoginName')));//账号
        $logic_type=$this->getParam('logic_type');//角色(1水厂，2设备厂家)
        $BrandName=$this->getParam('BrandName');//品牌
        $GoodsName=$this->getParam('GoodsName');//商品
        $Provence=$this->getParam('Provence');//省
        $City=$this->getParam('City');//市
        $Area=$this->getParam('Area');//区
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if(!$offset){
            $offset=0;
        }
        if(!$limit){
            $limit=10;
        }
        //排序（'LastUpTime'最近操作时间,'LeftAmount'条码余额）
        $order_column=$this->getParam('order_column');//排序字段
        $sort=$this->getParam('sort');

        //默认按最近操作时间降序、条码余额升序 排序
        $order=" order by LastUpTime desc,LeftAmount asc ";
        if(in_array($order_column,['LastUpTime','LeftAmount'])){
            if($sort%2==1){//奇数升序
                $order=" order by $order_column asc ";
            }
            if($sort%2==0){//偶数降序
                $order=" order by $order_column desc ";
            }

        }

        $where='';
        if($Name){
            $where.=" Name like '%$Name%' ";
        }
        if($LoginName){
            if($where)$where.=' and ';
            $where.=" (LoginName like '%$LoginName%' or ContractTel like '%$LoginName%')";
        }
        if($logic_type){
            if($where)$where.=' and ';
            $where.=" logic_type = $logic_type ";
        }
        if($BrandName){
            if($where)$where.=' and ';
            $where.=" BrandName = '$BrandName' ";
        }
        if($GoodsName){
            if($where)$where.=' and ';
            $where.=" GoodsName = '$GoodsName' ";
        }
        if($Provence){
            if($where)$where.=' and ';
            $where.=" Province = '$Provence' ";
        }
        if($City){
            if($where)$where.=' and ';
            $where.=" City = '$City' ";
        }
        if($Area){
            if($where)$where.=' and ';
            $where.=" Area = '$Area' ";
        }
        //将供应商和设备厂家合并
        //供应商
        $sql1="select factory_info.LoginName,factory_info.`Name`,admin_user.logic_type,
factory_info.Province,factory_info.City,factory_info.Area,factory_info.Address,
factory_info.ContractUser,factory_info.ContractTel,brands.BrandName,
goods.name as GoodsName,goods.volume as Volume,factory_wcode.LeftAmount,
factory_wcode.LastUpTime,factory_info.Id as Fid,brands.BrandNo as BrandId,
factory_wcode.GoodsId
from factory_info
left join factory_wcode on factory_wcode.Fid=factory_info.Id
left join goods on factory_wcode.GoodsId=goods.id
left join brands on goods.brand_id=brands.BrandNo
left join admin_user on admin_user.username=factory_info.LoginName";
        //设备厂家
        $sql2="select dev_factory.LoginName,dev_factory.`Name`,admin_user.logic_type,
dev_factory.Province,dev_factory.City,dev_factory.Area,dev_factory.Address,
dev_factory.ContractUser,dev_factory.ContractTel,
brands.BrandName,goods.name as GoodsName,goods.volume as Volume,
dev_factory_wcode.LeftAmount,dev_factory_wcode.LastUpTime,
dev_factory.Id as Fid,brands.BrandNo as BrandId,dev_factory_wcode.GoodsId
from dev_factory
left join dev_factory_wcode on dev_factory_wcode.Fid=dev_factory.Id
left join goods on dev_factory_wcode.GoodsId=goods.id
left join brands on goods.brand_id=brands.BrandNo
left join admin_user on admin_user.username=dev_factory.LoginName";

        //表格数据
        $sql="select * from ($sql1 union $sql2)as temp ".(!empty($where)?" where $where ":'');
        $total=ActiveRecord::findBySql($sql)->count();
        $form_datas=ActiveRecord::findBySql($sql." $order limit $offset,$limit ")->asArray()->all();

        if($tag==1){//判断是否是分页

            //下拉框数据
            //品牌
            $brands=ActiveRecord::findBySql("select BrandNo,BrandName from brands ")->asArray()->all();
            //商品
            $goods=ActiveRecord::findBySql("select id,name,brand_id from goods")->asArray()->all();

            //地址
            $address=(new Address())->allQuery()->asArray()->all();

            $select_where=json_encode([
                'brands'=>$brands,
                'goods'=>$goods,
                'address'=>$address,
            ]);
            //已选条件数据
            $checked_datas=[
                'Name'=>$Name,
                'LoginName'=>$LoginName,
                'logic_type'=>$logic_type,
                'BrandName'=>$BrandName,
                'GoodsName'=>$GoodsName,
                'Provence'=>$Provence,
                'City'=>$City,
                'Area'=>$Area,
                'offset'=>$offset,
                'limit'=>$limit,
                'order_column'=>$order_column,
                'sort'=>$sort,
            ];

            return [
                'select_where'=>$select_where,
                'checked_datas'=>$checked_datas,
                'form_datas'=>$form_datas,
                'total'=>$total,
            ];

        }

        return ['total'=>$total,'form_datas'=>$form_datas];
    }

    //Ajax角色改变时获取对应的品牌和商品
    public function actionGetBrandsGoods(){
        $logic_type=$this->getParam('logic_type');//角色(1水厂，2设备厂家)
        if(!$logic_type){
           return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $brands='';
        $goods='';
        if($logic_type==1){//角色 1供应商
            //水品牌
            $brands=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId <> 2")->asArray()->all();
            //水商品
            $goods=ActiveRecord::findBySql("select id,name,brand_id from goods where category_id<>2")->asArray()->all();
        }elseif($logic_type==2){//2设备厂家
            //设备品牌
            $brands=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId = 2")->asArray()->all();
            //设备商品
            $goods=ActiveRecord::findBySql("select id,name,brand_id from goods where category_id=2")->asArray()->all();
        }
        return json_encode(['state'=>0,'brands'=>$brands,'goods'=>$goods]);
    }

    //充值
    public function actionRecharge(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $BrandId=$this->getParam("BrandId");
        $GoodsId=$this->getParam("GoodsId");
        $Volume=$this->getParam("Volume");
        $Fid=$this->getParam("Fid");//厂家id
        $logic_type=$this->getParam("logic_type");//角色(1水厂，2设备厂家)
        if(!$Fid||!$logic_type){
            \Yii::$app->session->setFlash('error','参数错误');
            return $this->redirect(['list']);
        }

        $brands='';
        $goods='';
//        if($logic_type==1){//1供应商
            $brands=ActiveRecord::findBySql("select BrandNo,BrandName from brands ")->asArray()->all();
            $goods=ActiveRecord::findBySql("select id,name,brand_id,category_id from goods ")->asArray()->all();
//        }elseif($logic_type==2){//2设备厂家
//            $brands=ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId = 2")->asArray()->all();
//            $goods=ActiveRecord::findBySql("select id,name,brand_id,category_id from goods where category_id=2")->asArray()->all();
//        }

        return $this->render('recharge',[
            'brands'=>$brands,
            'goods'=>$goods,
            'Volume'=>$Volume,
            'logic_type'=>$logic_type,
            'Fid'=>$Fid,
            'BrandId'=>$BrandId,
            'GoodsId'=>$GoodsId,
            'url'=>$urlobj,
        ]);




    }

    //ajax根据商品名称获取商品规格
    public function actionGetVolume(){
        $GoodsName=$this->getParam('GoodsName');
        $BrandId=$this->getParam('BrandId');
        if(!$GoodsName||!$BrandId){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $volume=ActiveRecord::findBySql("select volume,unit from goods where name='$GoodsName' and brand_id='$BrandId'")->asArray()->all();
        return json_encode(['state'=>0,'volume'=>$volume]);
    }

    //Ajax 保存充值
    public function actionSaveRecharge(){
        $Fid=$this->getParam('Fid');//厂家id
        $logic_type=$this->getParam('logic_type');//角色(1水厂，2设备厂家)
        $BrandId=$this->getParam('BrandId');//品牌id
        $GoodsName=$this->getParam('GoodsName');//商品名称
        $Volume=$this->getParam('Volume');//商品规格
        $TotalMoney=$this->getParam('TotalMoney');//应付金额
        $OrderMoney=$this->getParam('OrderMoney');//支付金额
        $CouponMoney=$this->getParam('CouponMoney');//优惠金额
        $Amount=intval($this->getParam('Amount'));//购买数量

        //验证数据
        if(!$Fid||!$logic_type||!$BrandId||!$GoodsName
            ||!is_numeric($TotalMoney)||!is_numeric($OrderMoney)
            ||!is_numeric($CouponMoney)||!is_numeric($Amount)
            ||$Amount<=0||$TotalMoney<=0||$OrderMoney<=0||$CouponMoney<0
            ||$TotalMoney!=$OrderMoney+$CouponMoney||!$Volume||!is_numeric($Volume)){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }

        $GoodsId=$this->GetGoodsId($BrandId,$GoodsName,$Volume);
        $OrderNo=$this->getOrderNo();//生成订单号

        $now=date("Y-m-d H:i:s");
        $recharge_log_table='';//充值记录表
        $account_table='';//账户表
        //根据角色 充值记录表，账户表
        if($logic_type==1){//水厂
            $recharge_log_table=' orders_success ';//充值记录表
            $account_table=' factory_wcode ';//账户表
            $brand_column='WaterBrand';//品牌字段
        }
        if($logic_type==2){//设备厂家
            $recharge_log_table=' dev_factory_recharge_log ';//充值记录表
            $account_table=' dev_factory_wcode ';//账户表
            $brand_column='BrandId';//品牌字段
        }

        $transaction =\Yii::$app->db->beginTransaction();
        try{
                //充值记录
                //获取之前的充值总量、剩余总量
                $data = ActiveRecord::findBySql("select Amount,LeftAmount from $account_table
                where Fid=$Fid and GoodsId=$GoodsId")->asArray()->one();
                $recharge_total = $Amount;//充值总量
                $rest_total = $Amount;//剩余总量
                if ($data) {
                    $recharge_total = $data['Amount'] + $Amount;
                    $rest_total = $data['LeftAmount'] + $Amount;
                }

                $sql1 = "insert into $recharge_log_table(OrderNo,Fid,TotalMoney,CouponMoney,OrderMoney,".($Volume?"Volume,":'')."Amount,RowTime,State,$brand_column,GoodsId,RechargeAmount,RestAmount)
              VALUES ('$OrderNo',$Fid,$TotalMoney,$CouponMoney,$OrderMoney,".($Volume?"$Volume,":'')."$Amount,'$now',1,'$BrandId',$GoodsId,$recharge_total,$rest_total)";//对应的品牌、商品

                //账户
                if (empty($data)) {
                    //插入
                    $now = date("Y-m-d H:i:s");
                    $sql2 = "insert into $account_table(Fid,".($Volume?"Volume,":'')."Amount,RowTime,PrintAmount,LeftAmount,LastUpTime,$brand_column,GoodsId) VALUES($Fid,".($Volume?"$Volume,":'')."$Amount,'$now',0,$Amount,'$now','$BrandId',$GoodsId)";//对应的品牌、商品

                } else {
                    //更新
                    $sql2 = "update $account_table set Amount=Amount+$Amount , LeftAmount=LeftAmount+$Amount,LastUpTime='$now' where  Fid=$Fid and GoodsId=$GoodsId";//对应的品牌、商品
                }

            //保存充值记录
            $res = \Yii::$app->db->createCommand($sql1)->execute();
            if (!$res) {
                throw new \yii\db\Exception('保存充值记录失败');
            }

            //修改账户
            $res = \Yii::$app->db->createCommand($sql2)->execute();
            if (!$res) {
                throw new \yii\db\Exception('修改账户失败');
            }

            $transaction->commit();
            return json_encode(['state'=>0]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);

        }

    }

    //根据品牌id和商品名称获取商品id
    public function GetGoodsId($BrandId,$GoodsName,$Volume){
        $GoodsId=0;
        $data=ActiveRecord::findBySql("select id from goods
        where brand_id='$BrandId' and name='$GoodsName' ".($Volume?" and volume='$Volume'":''))->asArray()->one();
        if($data){
            $GoodsId=$data['id'];
        }
        return $GoodsId;
    }

    //生成订单号
    public function getOrderNo(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    //充值记录
    public function actionRechargeLog(){

        $result=$this->GetRechargeLogDatas();
        if(array_key_exists('state',$result)&&$result['state']==-1){
            \Yii::$app->session->setFlash('error','参数错误');
            return $this->redirect(['list']);
        }
        return $this->render('recharge-log',
            [
            'select_where'=>$result['select_where'],
            'total'=>$result['total'],
            'form_datas'=>json_encode($result['form_datas']),
            ]);

    }

    //ajax充值记录分页
    public function actionRechargeLogPage(){
        $result=$this->GetRechargeLogDatas();
        if(array_key_exists('state',$result)&&$result['state']==-1){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }

        return json_encode(['state'=>0,
            'total'=>$result['total'],
            'form_datas'=>$result['form_datas']]);

    }

    //充值记录 数据
    public function GetRechargeLogDatas(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $start_time=addslashes($this->getParam("start_time"));
        $end_time=$this->getParam("end_time");
        //分页
        $offset=$this->getParam("offset");
        $limit=$this->getParam("limit");
        if(!$offset){
            $offset=0;
        }
        if(!$limit){
            $limit=10;
        }

        $Fid=$this->getParam("Fid");
//        $BrandId=$this->getParam("BrandId");
        $GoodsId=$this->getParam("GoodsId");
        $logic_type=$this->getParam('logic_type');//角色(1水厂，2设备厂家)

        if(!$Fid||!$GoodsId||!$logic_type){

            return ['state'=>-1,'msg'=>'参数错误'];
        }

        //排序（RowTime时间，RestAmount剩余条码）
        $order_column=$this->getParam('order_column');//排序字段
        $sort=$this->getParam('sort');

        //默认按最近操作时间降序、条码余额升序 排序
        $order=" order by RowTime desc ";
        if(in_array($order_column,['RowTime','RestAmount'])){
            if($sort&&$sort%2==1){//奇数升序
                $order=" order by $order_column asc ";
            }
            if($sort&&$sort%2==0){//偶数降序
                $order=" order by $order_column desc ";
            }

        }

        $recharge_log_table='';//充值记录表
        //$account_table='';//账户表
                //根据角色 充值记录表，账户表
        if($logic_type==1){//水厂
            $recharge_log_table=' orders_success ';//充值记录表
            //$account_table=' factory_wcode ';//账户表

        }
        if($logic_type==2){//设备厂家
            $recharge_log_table=' dev_factory_recharge_log ';//充值记录表
            //$account_table=' dev_factory_wcode ';//账户表

        }

        $where=" where $recharge_log_table.Fid=$Fid and $recharge_log_table.GoodsId=$GoodsId";
        if($start_time&&$end_time){
            $where.=" and $recharge_log_table.RowTime > '$start_time' and $recharge_log_table.RowTime < '$end_time 23:59:59' ";
        }

        $sql="select brands.BrandName,goods.name as GoodsName,goods.volume as Volume,
        $recharge_log_table.TotalMoney,$recharge_log_table.OrderMoney,$recharge_log_table.CouponMoney,
        $recharge_log_table.Amount,$recharge_log_table.RechargeAmount,$recharge_log_table.RestAmount,
        $recharge_log_table.RowTime
         from $recharge_log_table
         left join goods on goods.id=$recharge_log_table.GoodsId
         left join brands on brands.BrandNo=goods.brand_id
         $where ";
        //总条数
        $total=ActiveRecord::findBySql($sql)->count();
        //表格数据
        $form_datas=ActiveRecord::findBySql($sql." $order limit $offset,$limit ")->asArray()->all();

        //已选条件
        $select_where=json_encode([
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'url'=>$urlobj,
            'offset'=>$offset,
            'limit'=>$limit,
            'Fid'=>$Fid,
            'GoodsId'=>$GoodsId,
            'logic_type'=>$logic_type,
        ]);
        return [
                'select_where'=>$select_where,
                'total'=>$total,
                'form_datas'=>$form_datas,
            ];
    }


    //使用记录
    public function actionUseLog(){
        $logic_type=$this->getParam('logic_type');//角色(1水厂，2设备厂家)
        if($logic_type==2){
            \Yii::$app->session->setFlash('error','设备厂家,还没有条码使用记录');
            return $this->redirect(['list']);
        }
        $result=$this->GetUseLogDatas();
        if(array_key_exists('state',$result)&&$result['state']==-1){
            \Yii::$app->session->setFlash('error','参数错误');
            return $this->redirect(['list']);
        }
        return $this->render('use-log',
            [
                'select_where'=>$result['select_where'],
                'total'=>$result['total'],
                'form_datas'=>json_encode($result['form_datas']),
            ]);
    }

    //ajax 使用记录 分页
    public function actionUseLogPage(){
        $logic_type=$this->getParam('logic_type');//角色(1水厂，2设备厂家)
        if($logic_type==2){
            return json_encode(['state'=>-1,'msg'=>'设备厂家,还没有条码使用记录']);
        }
        $result=$this->GetUseLogDatas();
        if(array_key_exists('state',$result)&&$result['state']==-1){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        return
            [
                'total'=>$result['total'],
                'form_datas'=>json_encode($result['form_datas']),
            ];
    }

    //获取使用记录 数据
    public function GetUseLogDatas(){
        //目前只有水条码的使用（打印）记录

        $urlobj = $this->getParam("Url");//返回参数记录
        $start_time=addslashes($this->getParam("start_time"));
        $end_time=$this->getParam("end_time");
        //分页
        $offset=$this->getParam("offset");
        $limit=$this->getParam("limit");
        if(!$offset){
            $offset=0;
        }
        if(!$limit){
            $limit=10;
        }

        $Fid=$this->getParam("Fid");
//        $BrandId=$this->getParam("BrandId");
        $GoodsId=$this->getParam("GoodsId");
        $logic_type=$this->getParam('logic_type');//角色(1水厂，2设备厂家)

        if(!$Fid||!$GoodsId||!$logic_type){

            return ['state'=>-1,'msg'=>'参数错误'];
        }

        //排序（StartTime时间，Amount数量，LeftAmount剩余条码）
        $order_column=$this->getParam('order_column');//排序字段
        $sort=$this->getParam('sort');

        //默认按 打印时间 降序
        $order=" order by StartTime desc ";
        if(in_array($order_column,['StartTime','Amount','LeftAmount'])){
            if($sort&&$sort%2==1){//奇数升序
                $order=" order by $order_column asc ";
            }
            if($sort&&$sort%2==0){//偶数降序
                $order=" order by $order_column desc ";
            }

        }


        $where='';
        if($start_time&&$end_time){
            $where=" and f.StartTime > '$start_time' and f.StartTime < '$end_time 23:59:59' ";
        }

        $sql="select distinct * from (select brands.BrandName,
 goods.name as GoodsName,goods.Volume,f.Amount,factory_wcode.LeftAmount,f.StartTime
 from factory_wcode_print_log as f
 LEFT JOIN factory_wcode on f.Fid=factory_wcode.Fid
 and f.GoodsId=factory_wcode.GoodsId
 LEFT JOIN goods on f.GoodsId=goods.id
 LEFT JOIN brands on goods.brand_id=brands.BrandNo
 where f.Fid=$Fid and f.GoodsId='$GoodsId'
 $where ) as temp ";
        //总条数
        $total=ActiveRecord::findBySql($sql)->count();
        //表格数据
        $form_datas=ActiveRecord::findBySql($sql." $order limit $offset,$limit ")->asArray()->all();

        //已选条件
        $select_where=json_encode([
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'url'=>$urlobj,
            'offset'=>$offset,
            'limit'=>$limit,
            'Fid'=>$Fid,
            'GoodsId'=>$GoodsId,
            'logic_type'=>$logic_type,
        ]);
        return [
            'select_where'=>$select_where,
            'total'=>$total,
            'form_datas'=>$form_datas,
        ];
    }

}
