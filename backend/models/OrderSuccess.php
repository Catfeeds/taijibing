<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/6
 * Time: 下午5:00
 */

namespace backend\models;


use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\db\Transaction;

class OrderSuccess extends ActiveRecord
{

    public static function tableName()
    {
        return 'orders_success';
    }

    /**
     * 累计流水
     */
    public static function getTotalIncome(){

        return static::findBySql("select sum(OrderMoney) as amount from orders_success")->asArray()->one();
    }
    /**
     * 今日流水
     */
    public static function getIncomeOfToday(){
        $now= date("Y-m-d");
        $starttime=$now."00:00:00";
        $endtime=$now."23:59:59";
        return static::findBySql("select sum(OrderMoney)  as amount from orders_success where RowTime<'$endtime' and RowTime>'$starttime'")->asArray()->one();
    }
    public function scenarios()
    {
        return [
            'create' => ['OrderNo', 'Fid','TotalMoney',
                         'OrderMoney','CouponMoney',
                         'Amount','Volume','WaterBrand','GoodsId'],
        ];
    }
//    public function rules(){
//        return[
//            [['OrderNo', 'Fid','TotalMoney',
//                'OrderMoney','CouponMoney',
//                'Amount','Volume','WaterBrand'],'required']
//        ];
//    }

    public function attributeLabels()
    {
        return [
            'Fid' => '厂家',
            'TotalMoney' => '应付金额',
            'OrderMoney' => '支付金额',
            'CouponMoney' => '优惠金额',
            'Volume' => '购买容量(L)',
            'Amount'=>'购买数量',
            'WaterBrand'=>'选择品牌',
            'GoodsId'=>'选择商品',
        ];
    }

    /**
     * 验证充值表单
     */
    public function checkForm(){
        $WaterBrand=$this->getAttribute("WaterBrand");//对应的品牌
        $GoodsId=$this->getAttribute("GoodsId");//对应品牌的商品

        $Fid=$this->getAttribute("Fid");

        $TotalMoney=$this->getAttribute("TotalMoney");

        $CouponMoney=$this->getAttribute("CouponMoney");

        $OrderMoney=$this->getAttribute("OrderMoney");

        $Volume=$this->getAttribute("Volume");
        $Amount=$this->getAttribute("Amount");
                                                                                                                                 //对应的品牌不为空     //对应品牌的商品
        if(!is_numeric($OrderMoney)||!is_numeric($Fid)||!is_numeric($TotalMoney)||!is_numeric($CouponMoney)||$CouponMoney<0||!is_numeric($Volume)||!is_numeric($Amount)||empty($WaterBrand)||empty($GoodsId)){
            return false;
        }
        return true;
    }
    /**
     * 水厂充值
     */
    public  function createOrder(){
        $transaction =$this->beginTransaction();
        try{

//            $transaction =$this->beginTransaction();


            $sql1=$this->getCreateOrderSql();
            $res=$this->getDb()->createCommand($sql1)->execute();
            if(!$res){
                throw new \yii\db\Exception($this->errors);
            }

            $sql2=$this->getUpdateFactoryWcodeSql();
            $res2=$this->getDb()->createCommand($sql2)->execute();

            if(!$res2){
                throw new \yii\db\Exception($this->errors);
            }

            $transaction->commit();
            return true;
        }catch(Exception $e){
            $transaction->rollBack();

//            return $e->getMessage();
            return false;
        }
    }

    /**
     * 同步厂商数据
     */
    public function getUpdateFactoryWcodeSql(){
        $WaterBrand=$this->getAttribute("WaterBrand");//对应的品牌
        $GoodsId=$this->getAttribute("GoodsId");//对应品牌的商品
        $Fid=$this->getAttribute("Fid");
        $Volume=$this->getAttribute("Volume");
        $OriAmount=intval($this->getAttribute("Amount"));
        $sql='';
        $data=static::findBySql("select * from factory_wcode where Fid=$Fid and Volume=$Volume and WaterBrand='$WaterBrand' and GoodsId=$GoodsId")->asArray()->one();
        if(empty($data)){
            //插入
            $now=date("Y-m-d H:i:s");
            $sql="insert into factory_wcode(Fid,Volume,Amount,RowTime,PrintAmount,LeftAmount,LastUpTime,WaterBrand,GoodsId) VALUES($Fid,$Volume,$OriAmount,'$now',0,$OriAmount,'$now','$WaterBrand',$GoodsId)";//对应的品牌、商品

        }else{
            $Amount=intval($data["Amount"])+$OriAmount;
            $LeftAmount=intval($data["LeftAmount"])+$OriAmount;
            //更新
            $sql="update factory_wcode set Amount=$Amount , LeftAmount=$LeftAmount where  Fid=$Fid and Volume=$Volume and WaterBrand='$WaterBrand' and GoodsId=$GoodsId";//对应的品牌、商品
        }
        return $sql;
    }
    /**
     *  获取创建订单号查询语句
     */
    public function getCreateOrderSql(){
        $WaterBrand=$this->getAttribute("WaterBrand");//对应的品牌
        $GoodsId=$this->getAttribute("GoodsId");//对应品牌的商品
        $Fid=$this->getAttribute("Fid");
        $TotalMoney=$this->getAttribute("TotalMoney");
        $CouponMoney=$this->getAttribute("CouponMoney");
        $OrderMoney=$this->getAttribute("OrderMoney");
        $Volume=$this->getAttribute("Volume");
        $Amount=$this->getAttribute("Amount");
        $OrderNo=$this->getOrderNo();
        $now=date("Y-m-d H:i:s");
        //获取之前的充值总量、剩余总量
        $data=ActiveRecord::findBySql("select Amount,LeftAmount from factory_wcode where Fid=$Fid
         and Volume=$Volume and WaterBrand='$WaterBrand' and GoodsId=$GoodsId")->asArray()->one();
        $recharge_total=$Amount;//充值总量
        $rest_total=$Amount;//剩余总量
        if($data){
            $recharge_total=$data['Amount']+$Amount;
            $rest_total=$data['LeftAmount']+$Amount;
        }

        $sql="insert into orders_success(OrderNo,Fid,TotalMoney,CouponMoney,OrderMoney,Volume,Amount,RowTime,State,WaterBrand,GoodsId,RechargeAmount,RestAmount)
              VALUES ('$OrderNo',$Fid,$TotalMoney,$CouponMoney,$OrderMoney,$Volume,$Amount,'$now',1,'$WaterBrand',$GoodsId,$recharge_total,$rest_total)";//对应的品牌、商品
        return $sql;
    }
    public function getOrderNo(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }
    public function beginTransaction()
    {
         return  $this->getDb()->beginTransaction();
    }
    public static function all($pid,$brand_id,$goods_id,$Volume,$content,$selecttime,$sort,$sort2){
        $startTime='';
        $endTime='';
        $where='';
        if($content){
            $where=" BrandName like '%$content%' ";
        }

        if(!empty($selecttime)){
            $dateArr=explode("至",$selecttime);
            if(count($dateArr)==2){
                $startTime=$dateArr[0];
//                $endTime=$dateArr[1];
                $endTime=date('Y-m-d H:i:s',strtotime($dateArr[1])+24*3600-1);
            }
        }
        if(!empty($startTime)&&!empty($endTime)){
            if($where){
                $where.=" and ";
            }

            $where.=" RowTime >= '$startTime' and RowTime <= '$endTime'";
        }

        //排序（剩余条码数）
        $order='';
        if($sort && $sort%2==0){//偶数 升序
           $order=" order by RestAmount desc";

        }
        if($sort && $sort%2==1){
            $order=" order by RestAmount asc";

        }

        //排序(总条码数)
        if($sort2 && $sort2%2==0){//偶数 升序
            $order=" order by RechargeAmount desc";

        }
        if($sort2 && $sort2%2==1){
            $order=" order by RechargeAmount asc";

        }


//        var_dump($order);exit;


        return self::findBySql("select * from (select o.*,w.BrandName,goods.name from orders_success as o

        JOIN brands as w ON o.WaterBrand=w.BrandNo
        JOIN goods ON o.GoodsId=goods.id
        where o.Fid=$pid and o.WaterBrand='$brand_id'
        and o.GoodsId='$goods_id' and o.Volume=$Volume
        order by RowTime DESC) as temp ".(empty($where)?'':'where'.$where)." $order");//,f.Amount as total,f.LeftAmount as least
    }//JOIN factory_wcode as f ON o.Fid=f.Fid and o.Volume=f.Volume and o.WaterBrand=f.WaterBrand and o.GoodsId=f.GoodsId
    public static function pageQuery($offset=0,$limit=10,$pid){
        return self::findBySql("select * from orders_success where Fid=$pid order by RowTime DESC limit $offset , $limit");
    }
}