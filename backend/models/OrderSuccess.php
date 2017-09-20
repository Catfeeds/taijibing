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
                         'Amount','Volume','WaterBrand'],
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
            'WaterBrand'=>'选择品牌'
        ];
    }

    /**
     * 验证充值表单
     */
    public function checkForm(){
        $WaterBrand=$this->getAttribute("WaterBrand");//对应的品牌
//        return $WaterBrand;exit;
        $Fid=$this->getAttribute("Fid");

        $TotalMoney=$this->getAttribute("TotalMoney");
//        return $TotalMoney;exit;
        $CouponMoney=$this->getAttribute("CouponMoney");
//        return $CouponMoney;exit;
        $OrderMoney=$this->getAttribute("OrderMoney");
//        return $CouponMoney;exit;
        $Volume=$this->getAttribute("Volume");
        $Amount=$this->getAttribute("Amount");
        if(!is_numeric($OrderMoney)||!is_numeric($Fid)||!is_numeric($TotalMoney)||!is_numeric($CouponMoney)||!is_numeric($Volume)||!is_numeric($Amount)||empty($WaterBrand)){//对应的品牌不为空
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
        $Fid=$this->getAttribute("Fid");
        $Volume=$this->getAttribute("Volume");
        $OriAmount=intval($this->getAttribute("Amount"));
        $sql='';
        $data=static::findBySql("select * from factory_wcode where Fid=$Fid and Volume=$Volume and WaterBrand='$WaterBrand'")->asArray()->one();
        if(empty($data)){
            //插入
            $now=date("Y-m-d H:i:s");
            $sql="insert into factory_wcode(Fid,Volume,Amount,RowTime,PrintAmount,LeftAmount,LastUpTime,WaterBrand) VALUES($Fid,$Volume,$OriAmount,'$now',0,$OriAmount,'$now','$WaterBrand')";//对应的品牌

        }else{
            $Amount=intval($data["Amount"])+$OriAmount;
            $LeftAmount=intval($data["LeftAmount"])+$OriAmount;
            //更新
            $sql="update factory_wcode set Amount=$Amount , LeftAmount=$LeftAmount where  Fid=$Fid and Volume=$Volume and WaterBrand='$WaterBrand'";//对应的品牌
        }
        return $sql;
    }
    /**
     *  获取创建订单号查询语句
     */
    public function getCreateOrderSql(){
        $WaterBrand=$this->getAttribute("WaterBrand");//对应的品牌
        $Fid=$this->getAttribute("Fid");
        $TotalMoney=$this->getAttribute("TotalMoney");
        $CouponMoney=$this->getAttribute("CouponMoney");
        $OrderMoney=$this->getAttribute("OrderMoney");
        $Volume=$this->getAttribute("Volume");
        $Amount=$this->getAttribute("Amount");
        $OrderNo=$this->getOrderNo();
        $now=date("Y-m-d H:i:s");
        $sql="insert into orders_success(OrderNo,Fid,TotalMoney,CouponMoney,OrderMoney,Volume,Amount,RowTime,State,WaterBrand)
              VALUES ('$OrderNo',$Fid,$TotalMoney,$CouponMoney,$OrderMoney,$Volume,$Amount,'$now',1,'$WaterBrand')";//对应的品牌
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
    public static function all($pid){
        return self::findBySql("select * from orders_success where Fid=$pid");
    }
    public static function pageQuery($offset=0,$limit=10,$pid){
        return self::findBySql("select * from orders_success where Fid=$pid order by RowTime DESC limit $offset , $limit");
    }
}