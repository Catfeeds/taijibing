<?php
namespace backend\controllers;

//酒店订单中心
use yii\db\ActiveRecord;
use backend\models\Address;

class HotelOrderController extends BaseController{
    public function actionIndex(){

        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''&&$limit==''){
            $offset=0;
            $limit=10;
        }

        //购水时间排序
        $sort=$this->getParam('sort');
        $search=$this->getParam('search');
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');
        $selecttime=$this->getParam('selecttime');//时间段
        $pay_state=$this->getParam('pay_state');//支付状态（0 支付失败，1支付成功）
        $dev_state=$this->getParam('dev_state');//设备状态（1正常，2已初始化）
        $order_state=$this->getParam('order_state');//订单状态(0 交易关闭，1交易成功，2退款中，3退款成功，4退款失败)
        $brand_id=$this->getParam('brand_id');//品牌id
        $goods_id=$this->getParam('goods_id');//商品id
		//var_dump($pay_state,$order_state);exit;

        //地址
        $address=(new Address())->allQuery()->asArray()->all();
        //品牌
        $brands=ActiveRecord::findBySql("select BrandNo,BrandName from brands where brands.CategoryId=1")->asArray()->all();
        //商品
        $goods=ActiveRecord::findBySql("select id,`name`,brand_id from goods where category_id=1 and state=0")->asArray()->all();


        $datas=$this->GetDatas($sort,$search,$province,$city,$area,$selecttime,$pay_state,
            $dev_state,$brand_id,$goods_id,$order_state);

        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." limit $offset,$limit")->asArray()->all();
        //已选条件
        $search_where=json_encode([
            'offset'=>$offset,
            'limit'=>$limit,
            'search'=>$search,
            'province'=>$province,
            'city'=>$city,
            'area'=>$area,
            'selecttime'=>$selecttime,
            'pay_state'=>$pay_state,
            'dev_state'=>$dev_state,
            'brand_id'=>$brand_id,
            'goods_id'=>$goods_id,
            'order_state'=>$order_state,
        ]);

        return $this->renderPartial('index',[
            'total'=>$total,
            'data'=>json_encode($data),
            'search_where'=>$search_where,
            'address'=>$address,
            'brands'=>$brands,
            'goods'=>$goods,
            'sort'=>$sort,
        ]);

    }

    //酒店订单中心分页接口
    public function actionPage(){
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''&&$limit==''){
            $offset=0;
            $limit=10;
        }

        //购水时间排序
        $sort=$this->getParam('sort');
        $search=$this->getParam('search');
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');
        $selecttime=$this->getParam('selecttime');//时间段
        $pay_state=$this->getParam('pay_state');//支付状态（0 支付失败，1支付成功）
        $dev_state=$this->getParam('dev_state');//支付状态（1正常，2已初始化）
        $order_state=$this->getParam('order_state');//订单状态(0 交易关闭，1交易成功，2退款中，3退款成功，4退款失败)
        $brand_id=$this->getParam('brand_id');//品牌id
        $goods_id=$this->getParam('goods_id');//商品id

        $datas=$datas=$this->GetDatas($sort,$search,$province,$city,$area,$selecttime,$pay_state,
            $dev_state,$brand_id,$goods_id,$order_state);

        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." limit $offset,$limit")->asArray()->all();
        return json_encode(['total'=>$total,'data'=>$data,'sort'=>$sort,]);
    }


    public function GetDatas($sort,$search,$province,$city,$area,$selecttime,$pay_state,
                             $dev_state,$brand_id,$goods_id,$order_state){



        if($sort===''||$sort===null){
            $sort=0;
        }
        //默认降序
        $order=' order by hotel_user_order.RowTime desc ';
        if($sort && $sort%2==1){//奇数升序
            $order=' order by hotel_user_order.RowTime asc ';
        }

        if($pay_state===null||$pay_state===''){
            $pay_state=1;//默认 1支付成功
        }
        if($dev_state===null||$pay_state===''){
            $pay_state=1;//默认 1正常
        }
        if($order_state===null||$pay_state===''){
            $order_state=1;//默认 1交易成功
        }


        $where='';
        if($search){//手机号，设备编号，ICCID，二维码编号
            $where=" (dev_regist.RoomNo like '%$search%'
                      or agent_info.ContractTel like '%$search%'
                      or hotel_user_order.DevNo like '%$search%'
                      or dev_regist.Iccid like '%$search%'
                      or hotel_user_order.CodeNumber like '%$search%'
                        ) ";
        }


        if($province){
            if($where){
                $where.=' and ';
            }
            $where.=" dev_regist.Province = '$province' ";
        }
        if($city){
            if($where){
                $where.=' and ';
            }
            $where.=" dev_regist.City = '$city' ";
        }
        if($area){
            if($where){
                $where.=' and ';
            }
            $where.=" dev_regist.Area = '$area' ";
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
                $where.=' and ';
            }
            $where.=" hotel_user_order.RowTime >= '$startTime' and hotel_user_order.RowTime <= '$endTime' ";
        }

        //支付状态
        if($pay_state!==null&&$pay_state!==''){
            if($where){
                $where.=' and ';
            }
            $where.=" hotel_user_order.State= $pay_state ";

        }
        //设备状态
        if($dev_state!==null&&$dev_state!==''){
            if($where){
                $where.=' and ';
            }
            if($dev_state==1){//正常
                $where.=" not exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=hotel_user_order.DevNo) ";
            }
            if($dev_state==2){//已初始化
                $where.=" exists (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=hotel_user_order.DevNo) ";
            }


        }
        //品牌
        if($brand_id!==null&&$brand_id!==''){
            if($where){
                $where.=' and ';
            }
            $where.=" hotel_user_order.BrandId= '$brand_id' ";

        }
        //商品
        if($goods_id!==null&&$goods_id!==''){
            if($where){
                $where.=' and ';
            }
            $where.=" hotel_user_order.GoodsId= $goods_id ";

        }
        //订单状态
        if($order_state!==null&&$order_state!==''){
            if($where){
                $where.=' and ';
            }
            if($order_state==0){//交易关闭
                $where.=" hotel_user_order.OrderState=0 ";
            }
            if($order_state==1){//交易成功
                $where.=" hotel_user_order.OrderState=1 ";
            }
            if($order_state==2){//退款中
                $where.=" hotel_user_order.OrderState=2 ";
            }
            if($order_state==3){//退款成功
                $where.=" hotel_user_order.OrderState=3 ";
            }
            if($order_state==4){//退款失败
                $where.=" hotel_user_order.OrderState=4 ";
            }

        }

        $datas=ActiveRecord::findBySql("select DISTINCT hotel_user_order.OutTradeNo,
hotel_user_order.TransactionId,hotel_user_order.DevNo,hotel_user_order.CodeNumber,
dev_regist.RoomNo,agent_info.Name,agent_info.ContractTel,dev_regist.Province,
dev_regist.City,dev_regist.Area,dev_regist.Address,hotel_user_order.Volume,
hotel_user_order.PayMoney,brands.BrandName,goods.name as GoodsName,
hotel_user_order.RowTime,hotel_user_order.PayType,hotel_user_order.State,
hotel_user_order.OrderState,hotel_user_order.ActTime
from hotel_user_order
left join dev_regist on dev_regist.DevNo=hotel_user_order.DevNo
left join agent_info on agent_info.Id=dev_regist.AgentId
left join brands on hotel_user_order.BrandId=brands.BrandNo
left join goods on goods.id=hotel_user_order.GoodsId
".(empty($where)?'':' where '.$where).' '.$order);

        return $datas;
    }

    //ajax将订单状态改为退款中
//    public function actionChangeOrderState(){
//        //交易单号
//        $OutTradeNo=$this->getParam('OutTradeNo');
//        if(!$OutTradeNo){
//           return json_encode(['state'=>-1,'msg'=>'参数错误']);
//        }
//        $data=ActiveRecord::findBySql("select DevNo from hotel_user_order where OutTradeNo='$OutTradeNo'")->asArray()->one();
//        if(!$data){
//            return json_encode(['state'=>-1,'msg'=>'该订单不存在']);
//        }
//        $sql="update hotel_user_order set OrderState=2 where OutTradeNo='$OutTradeNo'";
//        $re=\Yii::$app->db->createCommand($sql)->execute();
//        if($re){
//            return json_encode(['state'=>0]);
//        }
//        return json_encode(['state'=>-1,'msg'=>'失败']);
//
//    }

}
